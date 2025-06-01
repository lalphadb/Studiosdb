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
        try {
            $totalMembres = Membre::where('statut', 'actif')->count();
            $totalEcoles = Ecole::where('statut', 'actif')->count();
            $totalCours = Cours::count();
            $totalPresences = Presence::whereDate('date', today())->count();
            
            return view('admin.dashboard', compact(
                'totalMembres',
                'totalEcoles',
                'totalCours',
                'totalPresences'
            ));
        } catch (\Exception $e) {
            // En cas d'erreur de DB, afficher le dashboard avec des valeurs par défaut
            return view('admin.dashboard', [
                'totalMembres' => 0,
                'totalEcoles' => 0,
                'totalCours' => 0,
                'totalPresences' => 0
            ]);
        }
    }

    public function apiStats()
    {
        try {
            return response()->json([
                'totalMembres' => Membre::where('statut', 'actif')->count(),
                'totalEcoles' => Ecole::where('statut', 'actif')->count(),
                'totalCours' => Cours::count(),
                'totalPresences' => Presence::whereDate('date', today())->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des statistiques'
            ], 500);
        }
    }
}
