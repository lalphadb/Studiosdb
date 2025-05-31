<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use App\Models\Cours;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $cacheKey = "dashboard_stats_{$user->id}_{$user->role}";
            
            $stats = Cache::remember($cacheKey, 300, function () use ($user) {
                if ($user->role === 'superadmin') {
                    return [
                        'totalMembres' => Membre::count(),
                        'membresApprouves' => Membre::where('approuve', true)->count(),
                        'membresEnAttente' => Membre::where('approuve', false)->count(),
                        'totalEcoles' => Ecole::where('active', true)->count(),
                        'totalCours' => Cours::where('actif', true)->count(),
                        'presencesAujourdhui' => Presence::whereDate('date_presence', today())->count(),
                    ];
                } else {
                    return [
                        'totalMembres' => Membre::where('ecole_id', $user->ecole_id)->count(),
                        'membresApprouves' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', true)->count(),
                        'membresEnAttente' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', false)->count(),
                        'totalEcoles' => 1,
                        'totalCours' => Cours::where('ecole_id', $user->ecole_id)->where('actif', true)->count(),
                        'presencesAujourdhui' => Presence::whereHas('cours', function($q) use ($user) {
                            $q->where('ecole_id', $user->ecole_id);
                        })->whereDate('date_presence', today())->count(),
                    ];
                }
            });
            
            // Données pour les graphiques
            $membresParEcole = $user->role === 'superadmin' 
                ? Cache::remember("membres_par_ecole_{$user->id}", 600, function() {
                    return Ecole::withCount('membres')->where('active', true)->get();
                })
                : collect();

            return view('admin.dashboard', compact('stats', 'membresParEcole'));
            
        } catch (\Exception $e) {
            Log::error('Erreur dashboard: ' . $e->getMessage());
            
            // Valeurs par défaut en cas d'erreur
            $stats = [
                'totalMembres' => 0,
                'membresApprouves' => 0,
                'membresEnAttente' => 0,
                'totalEcoles' => 0,
                'totalCours' => 0,
                'presencesAujourdhui' => 0,
            ];
            
            return view('admin.dashboard', compact('stats'))->with('error', 'Erreur lors du chargement du tableau de bord.');
        }
    }

    public function apiStats(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }
        
        try {
            $user = Auth::user();
            
            if ($user->role === 'superadmin') {
                $data = [
                    'membres_approuves' => Membre::where('approuve', true)->count(),
                    'membres_en_attente' => Membre::where('approuve', false)->count(),
                    'ecoles_actives' => Ecole::where('active', true)->count(),
                    'cours_actifs' => Cours::where('actif', true)->count(),
                ];
            } else {
                $data = [
                    'membres_approuves' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', true)->count(),
                    'membres_en_attente' => Membre::where('ecole_id', $user->ecole_id)->where('approuve', false)->count(),
                    'cours_actifs' => Cours::where('ecole_id', $user->ecole_id)->where('actif', true)->count(),
                ];
            }
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            Log::error('Erreur API stats: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors du chargement des statistiques'], 500);
        }
    }
}