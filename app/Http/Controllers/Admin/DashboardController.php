<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Dashboard spécifique selon le rôle
        if ($user->hasRole('admin')) {
            // Admin d'école - dashboard limité à leur école
            return view('admin.dashboard-ecole', [
                'ecole' => $user->ecole,
                'stats' => $this->getEcoleStats($user->ecole_id)
            ]);
        }
        
        // SuperAdmin - dashboard global
        if ($user->hasRole('superadmin')) {
            return view('admin.dashboard', [
                'stats' => $this->getGlobalStats()
            ]);
        }
        
        // Autres rôles
        return view('admin.dashboard', [
            'error' => 'Rôle non reconnu: ' . $user->getRoleNames()->implode(', ')
        ]);
    }
    
    private function getEcoleStats($ecoleId)
    {
        // Stats pour une école spécifique
        return [
            'membres' => 0, // \App\Models\Membre::where('ecole_id', $ecoleId)->count(),
            'cours' => 0, // \App\Models\Cours::where('ecole_id', $ecoleId)->count(),
            'presences_semaine' => 0,
            'inscriptions_mois' => 0,
        ];
    }
    
    private function getGlobalStats()
    {
        // Stats globales pour superadmin
        return [
            'total_ecoles' => \App\Models\Ecole::count(),
            'ecoles_actives' => \App\Models\Ecole::where('statut', 'active')->count(),
            'ecoles_inactives' => \App\Models\Ecole::where('statut', 'inactive')->count(),
            'total_membres' => 0, // \App\Models\Membre::count(),
            'total_cours' => 0, // \App\Models\Cours::count(),
            'total_users' => \App\Models\User::count(),
        ];
    }
}
