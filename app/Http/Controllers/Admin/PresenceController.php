<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Cours;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PresenceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'cours_id' => 'nullable|exists:cours,id',
                'membre_id' => 'nullable|exists:membres,id',
                'date_debut' => 'nullable|date',
                'date_fin' => 'nullable|date|after_or_equal:date_debut',
                'status' => 'nullable|in:present,absent,retard'
            ]);

            $query = Presence::with(['membre', 'cours.ecole']);

            // Restriction par rôle
            if (Auth::user()->role !== 'superadmin' && Auth::user()->ecole_id) {
                $query->whereHas('cours', function($q) {
                    $q->where('ecole_id', Auth::user()->ecole_id);
                });
            }

            // Application des filtres
            if (!empty($validated['cours_id'])) {
                $query->where('cours_id', $validated['cours_id']);
            }

            if (!empty($validated['membre_id'])) {
                $query->where('membre_id', $validated['membre_id']);
            }

            if (!empty($validated['date_debut'])) {
                $query->whereDate('date_presence', '>=', $validated['date_debut']);
            }

            if (!empty($validated['date_fin'])) {
                $query->whereDate('date_presence', '<=', $validated['date_fin']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            $presences = $query->latest('date_presence')->paginate(20);

            return view('admin.presences.index', compact('presences'));
            
        } catch (\Exception $e) {
            Log::error('Erreur dans PresenceController@index: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors du chargement des présences.']);
        }
    }

    public function create()
    {
        $this->authorize('create', Presence::class);
        
        $query = Cours::where('actif', true)->with('ecole');
        
        if (Auth::user()->role !== 'superadmin' && Auth::user()->ecole_id) {
            $query->where('ecole_id', Auth::user()->ecole_id);
        }
        
        $cours = $query->orderBy('nom')->get();
        
        $membresQuery = Membre::where('approuve', true)->with('ecole');
        
        if (Auth::user()->role !== 'superadmin' && Auth::user()->ecole_id) {
            $membresQuery->where('ecole_id', Auth::user()->ecole_id);
        }
        
        $membres = $membresQuery->orderBy('nom')->orderBy('prenom')->get();

        return view('admin.presences.create', compact('cours', 'membres'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Presence::class);
        
        $validated = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'cours_id' => 'required|exists:cours,id',
            'date_presence' => 'required|date|before_or_equal:today',
            'status' => 'required|in:present,absent,retard',
            'commentaire' => 'nullable|string|max:500',
        ]);

        try {
            // Vérification des permissions
            $cours = Cours::findOrFail($validated['cours_id']);
            $membre = Membre::findOrFail($validated['membre_id']);
            
            if (Auth::user()->role !== 'superadmin') {
                if ($cours->ecole_id !== Auth::user()->ecole_id || $membre->ecole_id !== Auth::user()->ecole_id) {
                    abort(403, 'Accès non autorisé.');
                }
            }

            // Vérification de la duplication
            $existingPresence = Presence::where([
                'membre_id' => $validated['membre_id'],
                'cours_id' => $validated['cours_id'],
                'date_presence' => $validated['date_presence']
            ])->first();

            if ($existingPresence) {
                return back()->withInput()->withErrors(['error' => 'Une présence existe déjà pour ce membre à cette date.']);
            }

            Presence::create($validated);
            
            Log::info('Présence créée', [
                'membre_id' => $validated['membre_id'],
                'cours_id' => $validated['cours_id'],
                'user_id' => Auth::id()
            ]);

            return redirect()->route('admin.presences.index')
                ->with('success', 'Présence enregistrée avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur création présence: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Erreur lors de l\'enregistrement de la présence.']);
        }
    }
}