<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Ecole;
use App\Models\CoursSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = Cours::with(['ecole', 'session']);

            // Filtrage par rôle
            if ($user->role !== 'superadmin' && $user->ecole_id) {
                $query->where('ecole_id', $user->ecole_id);
            }

            $cours = $query->orderBy('nom')->paginate(15);
            
            // Données pour les filtres
            $ecoles = $user->role === 'superadmin' ? 
                     Ecole::where('active', true)->orderBy('nom')->get() : 
                     collect();
                     
            $sessions = collect(); // Vide pour l'instant

            return view('admin.cours.index', compact('cours', 'ecoles', 'sessions'));
            
        } catch (\Exception $e) {
            return view('admin.cours.index', [
                'cours' => collect(),
                'ecoles' => collect(),
                'sessions' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }

    // Autres méthodes basiques
    public function create()
    {
        return view('admin.cours.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.cours.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function show(Cours $cours)
    {
        return view('admin.cours.show', compact('cours'));
    }

    public function edit(Cours $cours)
    {
        return view('admin.cours.edit', compact('cours'));
    }

    public function update(Request $request, Cours $cours)
    {
        return redirect()->route('admin.cours.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function destroy(Cours $cours)
    {
        return redirect()->route('admin.cours.index')->with('success', 'Fonctionnalité en cours de développement');
    }
}
