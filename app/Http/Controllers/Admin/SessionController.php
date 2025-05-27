<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursSession;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = CoursSession::with(['ecole']);

            // Filtrage par rôle
            if ($user->role !== 'superadmin' && $user->ecole_id) {
                $query->where('ecole_id', $user->ecole_id);
            }

            $sessions = $query->orderBy('date_debut', 'desc')->paginate(15);
            
            // Données pour les filtres
            $ecoles = $user->role === 'superadmin' ? 
                     Ecole::where('active', true)->orderBy('nom')->get() : 
                     collect();

            return view('admin.sessions.index', compact('sessions', 'ecoles'));
            
        } catch (\Exception $e) {
            return view('admin.sessions.index', [
                'sessions' => collect(),
                'ecoles' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }

    // Autres méthodes basiques
    public function create()
    {
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.sessions.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function show(CoursSession $session)
    {
        return view('admin.sessions.show', compact('session'));
    }

    public function edit(CoursSession $session)
    {
        return view('admin.sessions.edit', compact('session'));
    }

    public function update(Request $request, CoursSession $session)
    {
        return redirect()->route('admin.sessions.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function destroy(CoursSession $session)
    {
        return redirect()->route('admin.sessions.index')->with('success', 'Fonctionnalité en cours de développement');
    }
}
