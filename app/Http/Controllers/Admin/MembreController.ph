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
        $query = Membre::with(['ecole']);
        
        // Filtrage par rôle
        if (Auth::user()->role !== 'superadmin') {
            $query->where('ecole_id', Auth::user()->ecole_id);
        }
        
        // Recherche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtres
        if ($request->has('ecole') && $request->ecole) {
            $query->where('ecole_id', $request->ecole);
        }
        
        if ($request->has('statut') && $request->statut !== '') {
            $query->where('approuve', $request->statut);
        }
        
        $membres = $query->latest()->paginate(15);
        $ecoles = Ecole::where('active', true)->orderBy('nom')->get();
        
        return view('admin.membres.index', compact('membres', 'ecoles'));
    }
    
    public function show(Membre $membre)
    {
        $membre->load(['ecole', 'ceintures', 'cours', 'presences']);
        
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $membre->ecole_id !== Auth::user()->ecole_id) {
            abort(403);
        }
        
        return view('admin.membres.show', compact('membre'));
    }
    
    public function create()
    {
        $ecoles = Ecole::where('active', true)->orderBy('nom')->get();
        $ceintures = Ceinture::orderBy('niveau')->get();
        
        return view('admin.membres.create', compact('ecoles', 'ceintures'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:membres,email',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:H,F',
            'numero_rue' => 'nullable|string|max:10',
            'nom_rue' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:20',
            'code_postal' => 'nullable|string|max:10',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);
        
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $validated['ecole_id'] != Auth::user()->ecole_id) {
            abort(403);
        }
        
        $membre = Membre::create($validated);
        
        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre créé avec succès.');
    }
    
    public function edit(Membre $membre)
    {
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $membre->ecole_id !== Auth::user()->ecole_id) {
            abort(403);
        }
        
        $ecoles = Ecole::where('active', true)->orderBy('nom')->get();
        $ceintures = Ceinture::orderBy('niveau')->get();
        
        return view('admin.membres.edit', compact('membre', 'ecoles', 'ceintures'));
    }
    
    public function update(Request $request, Membre $membre)
    {
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $membre->ecole_id !== Auth::user()->ecole_id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:membres,email,' . $membre->id,
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:H,F',
            'numero_rue' => 'nullable|string|max:10',
            'nom_rue' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:20',
            'code_postal' => 'nullable|string|max:10',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);
        
        $membre->update($validated);
        
        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre mis à jour avec succès.');
    }
    
    public function destroy(Membre $membre)
    {
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $membre->ecole_id !== Auth::user()->ecole_id) {
            abort(403);
        }
        
        $membre->delete();
        
        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre supprimé avec succès.');
    }
    
    public function approve(Membre $membre)
    {
        // Vérification des permissions
        if (Auth::user()->role !== 'superadmin' && $membre->ecole_id !== Auth::user()->ecole_id) {
            abort(403);
        }
        
        $membre->update(['approuve' => !$membre->approuve]);
        
        $status = $membre->approuve ? 'approuvé' : 'mis en attente';
        
        return redirect()->back()
            ->with('success', "Membre {$status} avec succès.");
    }
}
