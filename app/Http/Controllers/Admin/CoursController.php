<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\CoursSession;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|superadmin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cours::with(['ecole', 'session', 'horaires']);

        // Filtrage par école pour les admins
        if (Auth::user()->role === 'admin' && Auth::user()->ecole_id) {
            $query->where('ecole_id', Auth::user()->ecole_id);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par statut
        if ($request->filled('actif')) {
            $query->where('actif', $request->actif);
        }

        // Filtre par session
        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        $cours = $query->latest()->paginate(10)->withQueryString();
        $ecoles = Ecole::where('statut', 'active')->get();
        $sessions = CoursSession::where('active', true)->get();

        return view('admin.cours.index', compact('cours', 'ecoles', 'sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ecoles = Auth::user()->role === 'superadmin'
            ? Ecole::where('statut', 'active')->get()
            : Ecole::where('id', Auth::user()->ecole_id)->get();

        $sessions = CoursSession::where('active', true)
            ->where('inscriptions_actives', true)
            ->get();

        return view('admin.cours.create', compact('ecoles', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_cours' => 'required|in:regulier,parent_enfant,ceinture_avancee,competition,prive',
            'type' => 'required|in:enfant,adulte,mixte',
            'ecole_id' => 'required|exists:ecoles,id',
            'session_id' => 'nullable|exists:cours_sessions,id',
            'capacite_max' => 'required|integer|min:1|max:100',
            'duree_minutes' => 'required|integer|min:30|max:180',
            'jours' => 'required|array|min:1',
            'jours.*' => 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'actif' => 'boolean',
            // Horaires
            'horaires' => 'required|array|min:1',
            'horaires.*.jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'horaires.*.heure_debut' => 'required|date_format:H:i',
            'horaires.*.heure_fin' => 'required|date_format:H:i|after:horaires.*.heure_debut',
            'horaires.*.salle' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            // Créer le cours
            $cours = Cours::create([
                'nom' => $validated['nom'],
                'description' => $validated['description'],
                'type_cours' => $validated['type_cours'],
                'type' => $validated['type'],
                'ecole_id' => $validated['ecole_id'],
                'session_id' => $validated['session_id'],
                'capacite_max' => $validated['capacite_max'],
                'duree_minutes' => $validated['duree_minutes'],
                'jours' => $validated['jours'],
                'actif' => $validated['actif'] ?? true,
            ]);

            // Créer les horaires
            foreach ($validated['horaires'] as $horaire) {
                $cours->horaires()->create([
                    'jour' => $horaire['jour'],
                    'heure_debut' => $horaire['heure_debut'],
                    'heure_fin' => $horaire['heure_fin'],
                    'salle' => $horaire['salle'] ?? null,
                    'active' => true,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.cours.index')
                ->with('success', 'Cours créé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Erreur lors de la création du cours: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cours $cours)
    {
        $this->authorize('view', $cours);

        $cours->load([
            'ecole',
            'session',
            'horaires',
            'inscriptions.membre',
            'presences' => function ($query) {
                $query->latest()->limit(10);
            },
        ]);

        $stats = [
            'inscrits' => $cours->inscriptions()->count(),
            'presents_aujourdhui' => $cours->presences()
                ->whereDate('date', today())
                ->where('present', true)
                ->count(),
            'taux_presence' => $this->calculerTauxPresence($cours),
        ];

        return view('admin.cours.show', compact('cours', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cours)
    {
        $this->authorize('update', $cours);

        $ecoles = Auth::user()->role === 'superadmin'
            ? Ecole::where('statut', 'active')->get()
            : Ecole::where('id', Auth::user()->ecole_id)->get();

        $sessions = CoursSession::where('active', true)->get();

        $cours->load('horaires');

        return view('admin.cours.edit', compact('cours', 'ecoles', 'sessions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cours $cours)
    {
        $this->authorize('update', $cours);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_cours' => 'required|in:regulier,parent_enfant,ceinture_avancee,competition,prive',
            'type' => 'required|in:enfant,adulte,mixte',
            'session_id' => 'nullable|exists:cours_sessions,id',
            'capacite_max' => 'required|integer|min:1|max:100',
            'duree_minutes' => 'required|integer|min:30|max:180',
            'jours' => 'required|array|min:1',
            'jours.*' => 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'actif' => 'boolean',
            // Horaires
            'horaires' => 'required|array|min:1',
            'horaires.*.id' => 'nullable|exists:cours_horaires,id',
            'horaires.*.jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'horaires.*.heure_debut' => 'required|date_format:H:i',
            'horaires.*.heure_fin' => 'required|date_format:H:i|after:horaires.*.heure_debut',
            'horaires.*.salle' => 'nullable|string|max:50',
            'horaires.*.active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Mettre à jour le cours
            $cours->update([
                'nom' => $validated['nom'],
                'description' => $validated['description'],
                'type_cours' => $validated['type_cours'],
                'type' => $validated['type'],
                'session_id' => $validated['session_id'],
                'capacite_max' => $validated['capacite_max'],
                'duree_minutes' => $validated['duree_minutes'],
                'jours' => $validated['jours'],
                'actif' => $validated['actif'] ?? true,
            ]);

            // Gérer les horaires
            $horaireIds = [];
            foreach ($validated['horaires'] as $horaireData) {
                if (isset($horaireData['id'])) {
                    // Mettre à jour l'horaire existant
                    $horaire = $cours->horaires()->find($horaireData['id']);
                    if ($horaire) {
                        $horaire->update($horaireData);
                        $horaireIds[] = $horaire->id;
                    }
                } else {
                    // Créer un nouvel horaire
                    $horaire = $cours->horaires()->create($horaireData);
                    $horaireIds[] = $horaire->id;
                }
            }

            // Supprimer les horaires non présents
            $cours->horaires()->whereNotIn('id', $horaireIds)->delete();

            DB::commit();

            return redirect()->route('admin.cours.show', $cours)
                ->with('success', 'Cours mis à jour avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cours $cours)
    {
        $this->authorize('delete', $cours);

        try {
            // Vérifier s'il y a des inscriptions
            if ($cours->inscriptions()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer un cours avec des inscriptions.');
            }

            $cours->delete();

            return redirect()->route('admin.cours.index')
                ->with('success', 'Cours supprimé avec succès!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    /**
     * Dupliquer un cours
     */
    public function duplicate(Cours $cours)
    {
        $this->authorize('create', Cours::class);

        DB::beginTransaction();
        try {
            $newCours = $cours->replicate();
            $newCours->nom = $cours->nom.' (Copie)';
            $newCours->actif = false;
            $newCours->save();

            // Dupliquer les horaires
            foreach ($cours->horaires as $horaire) {
                $newHoraire = $horaire->replicate();
                $newHoraire->cours_id = $newCours->id;
                $newHoraire->save();
            }

            DB::commit();

            return redirect()->route('admin.cours.edit', $newCours)
                ->with('success', 'Cours dupliqué avec succès! Veuillez modifier les informations.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la duplication: '.$e->getMessage());
        }
    }

    /**
     * Calculer le taux de présence
     */
    private function calculerTauxPresence(Cours $cours)
    {
        $totalPresences = $cours->presences()->count();
        $presencesEffectives = $cours->presences()->where('present', true)->count();

        return $totalPresences > 0
            ? round(($presencesEffectives / $totalPresences) * 100, 1)
            : 0;
    }
}
