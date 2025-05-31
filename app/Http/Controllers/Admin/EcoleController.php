<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcoleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ecole::query();

        // Restriction par rôle
        if ($user->role !== 'superadmin') {
            $query->where('id', $user->ecole_id);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('ville', 'like', "%{$search}%");
            });
        }

        $ecoles = $query->orderBy('nom')->paginate(12);

        return view('admin.ecoles.index', compact('ecoles'));
    }

    public function show(Ecole $ecole)
    {
        $user = Auth::user();
        
        if ($user->role !== 'superadmin' && $user->ecole_id !== $ecole->id) {
            abort(403);
        }

        return view('admin.ecoles.show', compact('ecole'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
        
        return view('admin.ecoles.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|max:255',
            'ville' => 'required|max:100',
            'province' => 'required|max:20',
            'adresse' => 'nullable|max:255',
            'telephone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'responsable' => 'nullable|max:255',
        ]);

        $ecole = Ecole::create($validated);

        return redirect()->route('admin.ecoles.show', $ecole)
            ->with('success', 'École créée avec succès !');
    }

    public function edit(Ecole $ecole)
    {
        $user = Auth::user();
        
        if ($user->role !== 'superadmin' && $user->ecole_id !== $ecole->id) {
            abort(403);
        }

        return view('admin.ecoles.edit', compact('ecole'));
    }

    public function update(Request $request, Ecole $ecole)
    {
        $user = Auth::user();
        
        if ($user->role !== 'superadmin' && $user->ecole_id !== $ecole->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|max:255',
            'ville' => 'required|max:100',
            'province' => 'required|max:20',
            'adresse' => 'nullable|max:255',
            'telephone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'responsable' => 'nullable|max:255',
        ]);

        $ecole->update($validated);

        return redirect()->route('admin.ecoles.show', $ecole)
            ->with('success', 'École mise à jour !');
    }

    public function destroy(Ecole $ecole)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $ecole->delete();

        return redirect()->route('admin.ecoles.index')
            ->with('success', 'École supprimée !');
    }

    public function toggleStatus(Ecole $ecole)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $ecole->update(['active' => !$ecole->active]);

        return back()->with('success', 'Statut mis à jour !');
    }
}
