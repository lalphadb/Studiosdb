<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use App\Models\Ceinture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Membre::with(['ecole', 'ceintures']);

        // Restriction par rôle - Admin voit seulement ses membres
        if ($user->role !== 'superadmin') {
            $query->where('ecole_id', $user->ecole_id);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par école (pour superadmin)
        if ($request->filled('ecole_id') && $user->role === 'superadmin') {
            $query->where('ecole_id', $request->ecole_id);
        }

        // Filtre par statut d'approbation
        if ($request->filled('approuve')) {
            $query->where('approuve', $request->approuve === 'oui');
        }

        $membres = $query->orderBy('nom')->orderBy('prenom')->paginate(15);

        // Liste des écoles pour le filtre (superadmin seulement)
        $ecoles = $user->role === 'superadmin' 
            ? Ecole::where('active', true)->orderBy('nom')->get()
            : collect();

        return view('admin.membres.index', compact('membres', 'ecoles'));
    }

    public function show(Membre $membre)
    {
        $user = Auth::user();
        
        // Vérification permissions
        if ($user->role !== 'superadmin' && $user->ecole_id !== $membre->ecole_id) {
            abort(403, 'Vous ne pouvez consulter que les membres de votre école');
        }

        $membre->load(['ecole', 'ceintures', 'inscriptions.cours', 'presences']);

        // Statistiques du membre
        $stats = [
            'cours_inscrits' => $membre->inscriptions()->count(),
            'presences_total' => $membre->presences()->count(),
            'presences_mois' => $membre->presences()->whereMonth('date_presence', now()->month)->count(),
            'ceinture_actuelle' => $membre->ceintures()->latest('pivot.date_obtention')->first(),
        ];

        return view('admin.membres.show', compact('membre', 'stats'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Liste des écoles selon le rôle
        $ecoles = $user->role === 'superadmin' 
            ? Ecole::where('active', true)->orderBy('nom')->get()
            : Ecole::where('id', $user->ecole_id)->get();

        // Liste des ceintures
        $ceintures = Ceinture::orderBy('niveau')->get();

        return view('admin.membres.create', compact('ecoles', 'ceintures'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:membres,email',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:H,F',
            'telephone' => 'nullable|string|max:255',
            'numero_rue' => 'nullable|string|max:255',
            'nom_rue' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        // Vérification permissions école
        if ($user->role !== 'superadmin' && $validated['ecole_id'] != $user->ecole_id) {
            abort(403, 'Vous ne pouvez créer des membres que pour votre école');
        }

        // Auto-approbation pour les admins
        $validated['approuve'] = true;

        $membre = Membre::create($validated);

        return redirect()->route('admin.membres.show', $membre)
            ->with('success', '👤 Membre créé avec succès !');
    }

    public function edit(Membre $membre)
    {
        $user = Auth::user();
        
        // Vérification permissions
        if ($user->role !== 'superadmin' && $user->ecole_id !== $membre->ecole_id) {
            abort(403);
        }

        // Liste des écoles selon le rôle  
        $ecoles = $user->role === 'superadmin' 
            ? Ecole::where('active', true)->orderBy('nom')->get()
            : Ecole::where('id', $user->ecole_id)->get();

        return view('admin.membres.edit', compact('membre', 'ecoles'));
    }

    public function update(Request $request, Membre $membre)
    {
        $user = Auth::user();
        
        // Vérification permissions
        if ($user->role !== 'superadmin' && $user->ecole_id !== $membre->ecole_id) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255', 
            'email' => 'nullable|email|unique:membres,email,' . $membre->id,
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:H,F',
            'telephone' => 'nullable|string|max:255',
            'numero_rue' => 'nullable|string|max:255',
            'nom_rue' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        // Vérification permissions école
        if ($user->role !== 'superadmin' && $validated['ecole_id'] != $user->ecole_id) {
            abort(403);
        }

        $membre->update($validated);

        return redirect()->route('admin.membres.show', $membre)
            ->with('success', '✅ Membre mis à jour avec succès !');
    }

    public function destroy(Membre $membre)
    {
        $user = Auth::user();
        
        // Seul le superadmin peut supprimer des membres
        if ($user->role !== 'superadmin') {
            abort(403, 'Seul le superadmin peut supprimer des membres');
        }

        $nom_complet = $membre->prenom . ' ' . $membre->nom;
        $membre->delete();

        return redirect()->route('admin.membres.index')
            ->with('success', "🗑️ Membre « {$nom_complet} » supprimé avec succès !");
    }

    /**
     * Page des membres en attente d'approbation
     */
    public function attente(Request $request)
    {
        $user = Auth::user();
        $query = Membre::with('ecole')->where('approuve', false);

        // Restriction par rôle
        if ($user->role !== 'superadmin') {
            $query->where('ecole_id', $user->ecole_id);
        }

        $membres = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.membres.attente', compact('membres'));
    }

    /**
     * Approuver un membre
     */
    public function approve(Membre $membre)
    {
        $user = Auth::user();
        
        // Vérification permissions
        if ($user->role !== 'superadmin' && $user->ecole_id !== $membre->ecole_id) {
            abort(403);
        }

        $membre->update(['approuve' => true]);

        return back()->with('success', "✅ Membre « {$membre->prenom} {$membre->nom} » approuvé !");
    }

    /**
     * Rejeter un membre
     */
    public function reject(Membre $membre)
    {
        $user = Auth::user();
        
        // Vérification permissions
        if ($user->role !== 'superadmin' && $user->ecole_id !== $membre->ecole_id) {
            abort(403);
        }

        $nom_complet = $membre->prenom . ' ' . $membre->nom;
        $membre->delete();

        return back()->with('success', "❌ Membre « {$nom_complet} » rejeté et supprimé !");
    }

    /**
     * Ajouter une ceinture à un membre
     */
    public function ajouterCeinture(Request $request, Membre $membre)
    {
        $validated = $request->validate([
            'ceinture_id' => 'required|exists:ceintures,id',
            'date_obtention' => 'required|date',
        ]);

        // Vérifier si le membre n'a pas déjà cette ceinture
        if ($membre->ceintures()->where('ceinture_id', $validated['ceinture_id'])->exists()) {
            return back()->with('error', 'Ce membre possède déjà cette ceinture');
        }

        $membre->ceintures()->attach($validated['ceinture_id'], [
            'date_obtention' => $validated['date_obtention']
        ]);

        $ceinture = Ceinture::find($validated['ceinture_id']);

        return back()->with('success', "🥋 Ceinture « {$ceinture->nom} » ajoutée avec succès !");
    }

    /**
     * Retirer une ceinture d'un membre
     */
    public function retirerCeinture(Membre $membre, Ceinture $ceinture)
    {
        $membre->ceintures()->detach($ceinture->id);

        return back()->with('success', "🗑️ Ceinture « {$ceinture->nom} » retirée !");
    }
}
