<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use App\Models\Ceinture;
use App\Models\Seminaire;
use Illuminate\Http\Request;
use App\Http\Requests\MembreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MembresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,superadmin');
    }

    public function index()
    {
        $query = Membre::with(['ecole', 'ceinture']);
        
        // Filtrer par école pour les admins
        if (auth()->user()->role === 'admin' && auth()->user()->hasEcole()) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }
        
        $membres = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Charger les données pour les filtres
        $ecoles = Ecole::orderBy('nom')->get();
        $ceintures = Ceinture::orderBy('ordre')->get();
        
        $stats = [
            'total' => $query->count(),
            'approuves' => $query->clone()->where('approuve', true)->count(),
            'en_attente' => $query->clone()->where('approuve', false)->count(),
            'ce_mois' => $query->clone()->whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.membres.index', compact('membres', 'stats', 'ecoles', 'ceintures'));
    }

    public function create()
    {
        $ecoles = Ecole::orderBy('nom')->get();
        $ceintures = Ceinture::orderBy('ordre')->get();
        $seminaires = Seminaire::where('date_debut', '>=', now()->subYear())
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('admin.membres.create', compact('ecoles', 'ceintures', 'seminaires'));
    }

    public function store(MembreRequest $request)
    {
        Log::info('Début store membre', $request->all());

        try {
            $validated = $request->validated();

            DB::beginTransaction();
            
            // Pour les admins, forcer l'école de l'utilisateur
            if (auth()->user()->role === 'admin' && auth()->user()->hasEcole()) {
                $validated['ecole_id'] = auth()->user()->ecole_id;
            }
            
            // Gérer la photo si présente
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('membres/photos', 'public');
            }
            
            // Définir l'approbation
            $validated['approuve'] = $request->has('approuve');
            
            // Créer le membre
            $membre = Membre::create($validated);
            
            Log::info('Membre créé avec ID: ' . $membre->id);
            
            // Attacher la ceinture actuelle
            if ($request->filled('ceinture_id')) {
                $membre->ceintures()->attach($request->ceinture_id, [
                    'date_obtention' => $request->date_derniere_ceinture ?? now()
                ]);
                $membre->update(['ceinture_id' => $request->ceinture_id]);
            }
            
            // Attacher les séminaires
            if ($request->has('seminaires')) {
                $membre->seminaires()->sync($request->seminaires);
            }
            
            DB::commit();
            
            Log::info('Transaction réussie pour membre ID: ' . $membre->id);
            
            return redirect()->route('admin.membres.show', $membre)
                ->with('success', 'Membre créé avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur création membre: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Supprimer la photo si elle a été uploadée
            if (isset($validated['photo'])) {
                Storage::disk('public')->delete($validated['photo']);
            }
            
            return back()->withInput()
                ->with('error', 'Erreur lors de la création du membre: ' . $e->getMessage());
        }
    }

    public function show(Membre $membre)
    {
        // Vérifier l'accès pour les admins
        if (auth()->user()->role === 'admin' && 
            auth()->user()->hasEcole() && 
            $membre->ecole_id !== auth()->user()->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $membre->load(['ecole', 'ceintures', 'seminaires', 'cours']);
        
        // Statistiques
        $stats = [
            'cours_inscrits' => $membre->cours()->count(),
            'presences' => $membre->presences()->where('status', 'present')->count(),
            'taux_presence' => 0,
            'seminaires_participes' => $membre->seminaires()->count(),
            'progression_ceinture' => [
                'ceinture_actuelle' => $membre->ceinture,
                'prochaine_ceinture' => null,
                'pourcentage' => 0,
                'facteurs' => [
                    'presence' => 1.0,
                    'performance' => 1.0,
                    'seminaires' => 1.0
                ]
            ]
        ];
        
        // Calculer le taux de présence
        $totalPresences = $membre->presences()->count();
        if ($totalPresences > 0) {
            $stats['taux_presence'] = round(($stats['presences'] / $totalPresences) * 100);
        }
        
        $dernieresPresences = $membre->presences()
            ->with('cours')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $historiqueCeintures = $membre->ceintures()
            ->orderBy('ordre', 'desc')
            ->get();
        
        $ceintureActuelle = $membre->ceinture;
        
        return view('admin.membres.show', compact(
            'membre', 
            'stats', 
            'dernieresPresences', 
            'historiqueCeintures',
            'ceintureActuelle'
        ));
    }

    public function edit(Membre $membre)
    {
        // Vérifier l'accès
        if (auth()->user()->role === 'admin' && 
            auth()->user()->hasEcole() && 
            $membre->ecole_id !== auth()->user()->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $ecoles = Ecole::orderBy('nom')->get();
        $ceintures = Ceinture::orderBy('ordre')->get();
        $seminaires = Seminaire::orderBy('date_debut', 'desc')->get();
        
        $ceintureActuelle = $membre->ceinture;
        $membreSeminaires = $membre->seminaires->pluck('id')->toArray();
        
        return view('admin.membres.edit', compact(
            'membre', 
            'ecoles', 
            'ceintures', 
            'seminaires',
            'ceintureActuelle',
            'membreSeminaires'
        ));
    }

    public function update(MembreRequest $request, Membre $membre)
    {
        // Vérifier l'accès
        if (auth()->user()->role === 'admin' && 
            auth()->user()->hasEcole() && 
            $membre->ecole_id !== auth()->user()->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
            $validated = $request->validated();
        
        DB::beginTransaction();
        
        try {
            // Pour les admins, empêcher le changement d'école
            if (auth()->user()->role === 'admin') {
                unset($validated['ecole_id']);
            }
            
            // Gérer la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo
                if ($membre->photo) {
                    Storage::disk('public')->delete($membre->photo);
                }
                $validated['photo'] = $request->file('photo')->store('membres/photos', 'public');
            }
            
            $validated['approuve'] = $request->has('approuve');
            
            $membre->update($validated);
            
            // Mettre à jour la ceinture si changée
            if ($request->filled('ceinture_id') && $request->ceinture_id != $membre->ceinture_id) {
                $membre->ceintures()->attach($request->ceinture_id, [
                    'date_obtention' => $request->date_derniere_ceinture ?? now()
                ]);
                $membre->update(['ceinture_id' => $request->ceinture_id]);
            }
            
            // Mettre à jour les séminaires
            if ($request->has('seminaires')) {
                $membre->seminaires()->sync($request->seminaires);
            } else {
                $membre->seminaires()->detach();
            }
            
            DB::commit();
            
            return redirect()->route('admin.membres.show', $membre)
                ->with('success', 'Membre mis à jour avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function destroy(Membre $membre)
    {
        // Vérifier l'accès
        if (auth()->user()->role === 'admin' && 
            auth()->user()->hasEcole() && 
            $membre->ecole_id !== auth()->user()->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        try {
            // Supprimer la photo si elle existe
            if ($membre->photo) {
                Storage::disk('public')->delete($membre->photo);
            }
            
            $membre->delete();
            
            return redirect()->route('admin.membres.index')
                ->with('success', 'Membre supprimé avec succès!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function history(Membre $membre)
    {
        $activities = $membre->activities()->latest()->paginate(20);
        $historiqueCeintures = $membre->ceintures()->orderBy('ordre')->get();
        $historiquePresences = $membre->presences()->with('cours')->latest()->get();
        
        return view('admin.membres.history', compact('membre', 'activities', 'historiqueCeintures', 'historiquePresences'));
    }
}
