<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\CoursHoraire;
use App\Models\CoursSession;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon as Carbon;

class CoursController extends Controller
{
    /**
     * Vérifier si l'utilisateur a accès au cours
     */
    private function userHasAccess($cours)
    {
        $user = Auth::user();
        
        Log::info('Checking access for user', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_ecole_id' => $user->ecole_id,
            'cours_ecole_id' => $cours->ecole_id
        ]);
        
        // Superadmin a accès à tout
        if ($user->role === 'superadmin') {
            return true;
        }
        
        // Si l'utilisateur n'a pas d'école assignée, refuser l'accès
        if (!$user->ecole_id) {
            Log::warning('User has no ecole_id assigned', ['user_id' => $user->id]);
            return false;
        }
        
        // Les autres doivent avoir la même ecole_id
        return $user->ecole_id == $cours->ecole_id;
    }

    /**
     * Convertir une date du format JJ/MM/AAAA au format YYYY-MM-DD
     */
    private function convertDateToDb($date)
    {
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        }
        return $date;
    }

    public function index()
    {
        try {
            $user = Auth::user();
            
            Log::info('CoursController@index accessed', [
                'user_id' => $user->id,
                'role' => $user->role,
                'ecole_id' => $user->ecole_id
            ]);
            
            // Si l'utilisateur n'a pas d'école et n'est pas superadmin, afficher une erreur
            if ($user->role !== 'superadmin' && !$user->ecole_id) {
                return view('admin.cours.index')
                    ->with('error', 'Votre compte n\'est associé à aucune école. Veuillez contacter l\'administrateur.')
                    ->with('cours', collect())
                    ->with('sessions', collect());
            }
            
            $query = Cours::with(['ecole', 'session', 'horaires']);
            
            // Filtrer par école sauf pour superadmin
            if ($user->role !== 'superadmin' && $user->ecole_id) {
                $query->where('ecole_id', $user->ecole_id);
            }
            
            $cours = $query->when(request('session_id'), function($q) {
                    $q->where('session_id', request('session_id'));
                })
                ->when(request('actif') !== null, function($q) {
                    $q->where('actif', request('actif'));
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12);
                
            $sessionsQuery = CoursSession::query();
            if ($user->role !== 'superadmin' && $user->ecole_id) {
                $sessionsQuery->where('ecole_id', $user->ecole_id);
            }
            $sessions = $sessionsQuery->orderBy('date_debut', 'desc')->get();
                
            return view('admin.cours.index', compact('cours', 'sessions'));
            
        } catch (\Exception $e) {
            Log::error('Error in CoursController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('admin.cours.index')
                ->with('error', 'Une erreur est survenue lors du chargement des cours.')
                ->with('cours', collect())
                ->with('sessions', collect());
        }
    }

    public function create()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une école assignée
        if ($user->role !== 'superadmin' && !$user->ecole_id) {
            return redirect()->route('admin.cours.index')
                ->with('error', 'Votre compte n\'est associé à aucune école.');
        }
        
        if ($user->role === 'superadmin') {
            $ecoles = Ecole::orderBy('nom')->get();
        } else {
            $ecoles = Ecole::where('id', $user->ecole_id)->get();
        }
            
        $sessionsQuery = CoursSession::where('active', true);
        if ($user->role !== 'superadmin' && $user->ecole_id) {
            $sessionsQuery->where('ecole_id', $user->ecole_id);
        }
        $sessions = $sessionsQuery->orderBy('date_debut', 'desc')->get();
        
        $jours = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi', 
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche'
        ];
        
        // Récupérer les horaires existants pour suggestions
        $horairesExistants = [];
        if ($user->ecole_id || $user->role === 'superadmin') {
            $horaireQuery = CoursHoraire::whereHas('cours', function($q) use ($user) {
                if ($user->role !== 'superadmin' && $user->ecole_id) {
                    $q->where('ecole_id', $user->ecole_id);
                }
            });
            
            $horairesExistants = $horaireQuery
                ->select('jour', 'heure_debut', 'heure_fin')
                ->distinct()
                ->orderByRaw("FIELD(jour, 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'), heure_debut")
                ->get()
                ->groupBy('jour');
        }
        
        return view('admin.cours.create', compact('ecoles', 'sessions', 'jours', 'horairesExistants'));
    }

    public function store(Request $request)
    {
        // Convertir la date si nécessaire
        if ($request->has('date_debut')) {
            $request->merge(['date_debut' => $this->convertDateToDb($request->date_debut)]);
        }
        if ($request->has('date_fin')) {
            $request->merge(['date_fin' => $this->convertDateToDb($request->date_fin)]);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ecole_id' => 'required|exists:ecoles,id',
            'session_id' => 'required|exists:cours_sessions,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'places_max' => 'nullable|integer|min:1',
            'tarification_info' => 'nullable|string',
            'horaires' => 'required|array|min:1',
            'horaires.*.jour' => 'required|string',
            'horaires.*.heure_debut' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'horaires.*.heure_fin' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', 'after:horaires.*.heure_debut']
        ]);

        $user = Auth::user();
        if ($user->role !== 'superadmin' && $user->ecole_id && $user->ecole_id != $validated['ecole_id']) {
            abort(403, 'Accès non autorisé à cette école');
        }

        DB::transaction(function() use ($validated) {
            $coursData = $validated;
            unset($coursData['horaires']);
            $coursData['actif'] = true;
            
            $cours = Cours::create($coursData);
            
            // Créer les horaires
            foreach ($validated['horaires'] as $horaire) {
                if (!empty($horaire['jour']) && !empty($horaire['heure_debut']) && !empty($horaire['heure_fin'])) {
                    $cours->horaires()->create([
                        'jour' => $horaire['jour'],
                        'heure_debut' => $horaire['heure_debut'],
                        'heure_fin' => $horaire['heure_fin'],
                        'active' => true
                    ]);
                }
            }
            
            Log::info('Cours créé', ['cours_id' => $cours->id, 'user_id' => Auth::id()]);
        });

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours créé avec succès!');
    }

    public function show($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                Log::warning('Access denied to cours', [
                    'cours_id' => $id,
                    'user_id' => Auth::id()
                ]);
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            $cours->load(['ecole', 'session', 'horaires']);
            
            $inscriptions = $cours->inscriptions()
                ->with('membre')
                ->where('statut', 'confirmee')
                ->get();
                
            return view('admin.cours.show', compact('cours', 'inscriptions'));
            
        } catch (\Exception $e) {
            Log::error('Error in CoursController@show', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return redirect()->route('admin.cours.index')
                ->with('error', 'Cours introuvable ou accès non autorisé.');
        }
    }

    public function edit($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            $user = Auth::user();
            
            if ($user->role === 'superadmin') {
                $ecoles = Ecole::orderBy('nom')->get();
            } else {
                $ecoles = Ecole::where('id', $user->ecole_id)->get();
            }
                
            $sessions = CoursSession::where('ecole_id', $cours->ecole_id)
                ->orderBy('date_debut', 'desc')
                ->get();
            
            $jours = [
                'lundi' => 'Lundi',
                'mardi' => 'Mardi', 
                'mercredi' => 'Mercredi',
                'jeudi' => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi' => 'Samedi',
                'dimanche' => 'Dimanche'
            ];
            
            $cours->load('horaires');
            
            return view('admin.cours.edit', compact('cours', 'ecoles', 'sessions', 'jours'));
            
        } catch (\Exception $e) {
            Log::error('Error in CoursController@edit', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return redirect()->route('admin.cours.index')
                ->with('error', 'Cours introuvable ou accès non autorisé.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            // Convertir la date si nécessaire
            if ($request->has('date_debut')) {
                $request->merge(['date_debut' => $this->convertDateToDb($request->date_debut)]);
            }
            if ($request->has('date_fin')) {
                $request->merge(['date_fin' => $this->convertDateToDb($request->date_fin)]);
            }
            
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'ecole_id' => 'required|exists:ecoles,id',
                'session_id' => 'required|exists:cours_sessions,id',
                'date_debut' => 'required|date',
                'date_fin' => 'nullable|date|after_or_equal:date_debut',
                'places_max' => 'nullable|integer|min:1',
                'tarification_info' => 'nullable|string',
                'horaires' => 'required|array|min:1',
                'horaires.*.jour' => 'required|string',
                'horaires.*.heure_debut' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
                'horaires.*.heure_fin' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', 'after:horaires.*.heure_debut']
            ]);

            DB::transaction(function() use ($validated, $cours) {
                $coursData = $validated;
                unset($coursData['horaires']);
                
                $cours->update($coursData);
                
                // Supprimer les anciens horaires et créer les nouveaux
                $cours->horaires()->delete();
                foreach ($validated['horaires'] as $horaire) {
                    if (!empty($horaire['jour']) && !empty($horaire['heure_debut']) && !empty($horaire['heure_fin'])) {
                        $cours->horaires()->create([
                            'jour' => $horaire['jour'],
                            'heure_debut' => $horaire['heure_debut'],
                            'heure_fin' => $horaire['heure_fin'],
                            'active' => true
                        ]);
                    }
                }
                
                Log::info('Cours modifié', ['cours_id' => $cours->id, 'user_id' => Auth::id()]);
            });

            return redirect()->route('admin.cours.show', $cours->id)
                ->with('success', 'Cours mis à jour avec succès!');
                
        } catch (\Exception $e) {
            Log::error('Error in CoursController@update', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour du cours.');
        }
    }

    public function destroy($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            if ($cours->inscriptions()->exists()) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer un cours avec des inscriptions');
            }
            
            Log::info('Cours supprimé', ['cours_id' => $cours->id, 'user_id' => Auth::id()]);
                
            $cours->delete();

            return redirect()->route('admin.cours.index')
                ->with('success', 'Cours supprimé avec succès');
                
        } catch (\Exception $e) {
            Log::error('Error in CoursController@destroy', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du cours.');
        }
    }

    public function duplicate($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            $newCours = $cours->replicate();
            $newCours->nom = $cours->nom . ' (Copie)';
            $newCours->save();
            
            // Dupliquer les horaires
            foreach ($cours->horaires as $horaire) {
                $newCours->horaires()->create($horaire->toArray());
            }
            
            Log::info('Cours dupliqué', ['cours_id' => $newCours->id, 'from_cours_id' => $cours->id, 'user_id' => Auth::id()]);
            
            return redirect()->route('admin.cours.edit', $newCours->id)
                ->with('success', 'Cours dupliqué avec succès! Veuillez mettre à jour les informations.');
                
        } catch (\Exception $e) {
            Log::error('Error in CoursController@duplicate', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la duplication du cours.');
        }
    }

    public function toggleStatus($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            
            if (!$this->userHasAccess($cours)) {
                abort(403, 'Accès non autorisé à ce cours');
            }
            
            $cours->actif = !$cours->actif;
            $cours->save();
            
            Log::info('Statut du cours changé', ['cours_id' => $cours->id, 'actif' => $cours->actif, 'user_id' => Auth::id()]);
            
            return redirect()->back()
                ->with('success', 'Statut du cours modifié');
                
        } catch (\Exception $e) {
            Log::error('Error in CoursController@toggleStatus', [
                'error' => $e->getMessage(),
                'cours_id' => $id
            ]);
            
            return redirect()->back()
                ->with('error', 'Erreur lors du changement de statut.');
        }
    }
}
