<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques de base
        $stats = [
            'membres_total' => \App\Models\Membre::count(),
            'cours_total' => \App\Models\Cours::count(),
            'ecoles_total' => \App\Models\Ecole::count(),
            'seminaires_total' => \App\Models\Seminaire::count(),
        ];
        
        // Données spécifiques selon le rôle
        if ($user->role === 'admin') {
            // Admin voit seulement son école
            $stats['membres_total'] = \App\Models\Membre::where('ecole_id', $user->ecole_id)->count();
            $stats['cours_total'] = \App\Models\Cours::where('ecole_id', $user->ecole_id)->count();
        }
        
        return view('admin.dashboard', compact('stats', 'user'));
    }
}
