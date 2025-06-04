<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcoleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('superadmin')) {
            $ecoles = Ecole::orderBy('nom')->paginate(20);
            $stats = [
                'total' => Ecole::count(),
                'actives' => Ecole::where('statut', 'active')->count(),
                'inactives' => Ecole::where('statut', 'inactive')->count(),
                'sans_adresse' => Ecole::whereNull('adresse')->count(),
            ];
        } else {
            $ecoles = Ecole::where('id', $user->ecole_id)->paginate(1);
            $stats = [
                'total' => 1,
                'actives' => $user->ecole && $user->ecole->statut === 'active' ? 1 : 0,
                'inactives' => $user->ecole && $user->ecole->statut === 'inactive' ? 1 : 0,
                'sans_adresse' => $user->ecole && is_null($user->ecole->adresse) ? 1 : 0,
            ];
        }
        
        return view('admin.ecoles.index', compact('ecoles', 'stats'));
    }

    public function show(Ecole $ecole)
    {
        $user = auth()->user();
        
        // Vérifier les permissions
        if (!$user->hasRole('superadmin') && $ecole->id !== $user->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $ecole->load(['membres', 'cours']);
        $stats = [
            'membres_total' => $ecole->membres()->count(),
            'membres_actifs' => $ecole->membres()->where('approuve', true)->count(),
            'cours_total' => $ecole->cours()->count(),
            'cours_actifs' => $ecole->cours()->where('actif', true)->count(),
        ];
        
        return view('admin.ecoles.show', compact('ecole', 'stats'));
    }

    public function create()
    {
        // Seul le superadmin peut créer des écoles
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Seul le super administrateur peut créer des écoles');
        }
        
        return view('admin.ecoles.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Seul le super administrateur peut créer des écoles');
        }

        $validated = $request->validate([
            'nom' => 'required|max:255',
            'ville' => 'required|max:100',
            'province' => 'required|max:20',
            'adresse' => 'nullable|max:255',
            'code_postal' => 'nullable|max:10',
            'telephone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|in:active,inactive',
        ]);

        $ecole = Ecole::create($validated);

        return redirect()->route('admin.ecoles.show', $ecole)
            ->with('success', 'École créée avec succès !');
    }

    public function edit(Ecole $ecole)
    {
        $user = auth()->user();
        
        // Vérifier les permissions
        if (!$user->hasRole('superadmin') && $ecole->id !== $user->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('admin.ecoles.edit', compact('ecole'));
    }

    public function update(Request $request, Ecole $ecole)
    {
        $user = auth()->user();
        
        // Vérifier les permissions
        if (!$user->hasRole('superadmin') && $ecole->id !== $user->ecole_id) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'nom' => 'required|max:255',
            'ville' => 'required|max:100',
            'province' => 'required|max:20',
            'adresse' => 'nullable|max:255',
            'code_postal' => 'nullable|max:10',
            'telephone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|in:active,inactive',
        ]);

        $ecole->update($validated);

        return redirect()->route('admin.ecoles.show', $ecole)
            ->with('success', 'École mise à jour avec succès !');
    }

    public function destroy(Ecole $ecole)
    {
        // Seul le superadmin peut supprimer des écoles
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Seul le super administrateur peut supprimer des écoles');
        }

        $ecole->delete();

        return redirect()->route('admin.ecoles.index')
            ->with('success', 'École supprimée avec succès !');
    }

    public function toggleStatus(Ecole $ecole)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Seul le super administrateur peut modifier le statut');
        }

        $ecole->statut = $ecole->statut === 'active' ? 'inactive' : 'active';
        $ecole->save();

        return response()->json([
            'success' => true,
            'statut' => $ecole->statut
        ]);
    }
}
