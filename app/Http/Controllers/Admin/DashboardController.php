<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use App\Models\Cours;
use App\Models\Presence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistiques selon le rôle
        if ($user->role === 'superadmin') {
            $stats = [
                'totalMembres' => Membre::count(),
                'membresApprouves' => Membre::where('approuve', true)->count(),
                'membresEnAttente' => Membre::where('approuve', false)->count(),
                'totalEcoles' => Ecole::where('active', true)->count(),
                'totalCours' => Cours::where('statut', 'actif')->count(),
                'presencesAujourdhui' => Presence::whereDate('date_presence', today())->count(),
            ];
            
            // Données pour les graphiques
            $membresParEcole = Ecole::withCount('membres')->where('active', true)->get();
        } else {
            // Statistiques pour admin d'école
            $stats = [
                'totalMembres' => Membre::where('ecole_id', $user->ecole_id)->count(),
                'membresApprouves' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', true)->count(),
                'membresEnAttente' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', false)->count(),
                'totalEcoles' => 1,
                'totalCours' => Cours::where('ecole_id', $user->ecole_id)->where('statut', 'actif')->count(),
                'presencesAujourdhui' => Presence::whereHas('cours', function($q) use ($user) {
                    $q->where('ecole_id', $user->ecole_id);
                })->whereDate('date_presence', today())->count(),
            ];
            
            $membresParEcole = collect(); // Pas de graphique pour admin d'école
        }

        return view('admin.dashboard', compact('stats', 'membresParEcole'));
    }

    // API pour les statistiques (appelé via AJAX)
    public function apiStats()
    {
        $user = auth()->user();
        
        if ($user->role === 'superadmin') {
            return response()->json([
                'membres_approuves' => Membre::where('approuve', true)->count(),
                'membres_en_attente' => Membre::where('approuve', false)->count(),
                'ecoles_actives' => Ecole::where('active', true)->count(),
                'cours_actifs' => Cours::where('statut', 'actif')->count(),
            ]);
        } else {
            return response()->json([
                'membres_approuves' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', true)->count(),
                'membres_en_attente' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', false)->count(),
                'cours_actifs' => Cours::where('ecole_id', $user->ecole_id)->where('statut', 'actif')->count(),
            ]);
        }
    }
}
