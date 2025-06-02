<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\CoursSession;
use App\Models\User;
use App\Models\Presence;
use App\Models\InscriptionCours;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Rediriger vers le bon dashboard selon le rôle
        if ($user->role === 'superadmin' || $user->role === 'admin' || $user->id === 1) {
            return $this->superAdminDashboard();
        }
        
        return $this->ecoleAdminDashboard($user);
    }
    
    private function superAdminDashboard()
    {
        // Statistiques globales
        $stats = [
            'total_ecoles' => Ecole::count(),
            'ecoles_actives' => Ecole::where('statut', 'actif')->count() ?? Ecole::count(),
            'total_membres' => Membre::count(),
            'membres_approuves' => Membre::where('approuve', true)->count(),
            'total_cours' => Cours::count(),
            'total_sessions' => CoursSession::count(),
            'total_users' => User::count(),
            'nouveaux_membres_mois' => Membre::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
        
        // Top 5 écoles par membres
        $topEcoles = Ecole::withCount('membres')
            ->orderBy('membres_count', 'desc')
            ->take(5)
            ->get();
        
        // Données pour graphiques
        $inscriptionsParMois = Membre::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();
        
        // Activité récente
        $activiteRecente = collect();
        
        // Derniers membres
        $derniersMembres = Membre::with('ecole')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($membre) {
                return [
                    'type' => 'membre',
                    'message' => "Nouveau membre : {$membre->prenom} {$membre->nom}",
                    'ecole' => $membre->ecole->nom ?? 'N/A',
                    'date' => $membre->created_at
                ];
            });
        
        $activiteRecente = $activiteRecente->merge($derniersMembres);
        
        // Tâches en attente
        $tachesEnAttente = [
            'membres_a_approuver' => Membre::where('approuve', false)->count(),
            'sessions_a_venir' => CoursSession::where('date_debut', '>', Carbon::now())->count(),
        ];
        
        return view('admin.dashboard.superadmin', compact(
            'stats',
            'topEcoles',
            'inscriptionsParMois',
            'activiteRecente',
            'tachesEnAttente'
        ));
    }
    
    private function ecoleAdminDashboard($user)
    {
        $ecoleId = $user->ecole_id;
        
        if (!$ecoleId) {
            return view('admin.dashboard.no-ecole');
        }
        
        $ecole = Ecole::find($ecoleId);
        
        if (!$ecole) {
            return view('admin.dashboard.no-ecole');
        }
        
        // Stats pratiques pour admin école
        $stats = [
            'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
            'membres_actifs' => Membre::where('ecole_id', $ecoleId)->where('approuve', true)->count(),
            'membres_en_attente' => Membre::where('ecole_id', $ecoleId)->where('approuve', false)->count(),
            'cours_actifs' => Cours::where('ecole_id', $ecoleId)->count(),
            'presences_jour' => Presence::whereDate('created_at', Carbon::today())
                ->whereHas('membre', function($q) use ($ecoleId) {
                    $q->where('ecole_id', $ecoleId);
                })->count(),
            'sessions_semaine' => CoursSession::whereHas('cours', function($q) use ($ecoleId) {
                    $q->where('ecole_id', $ecoleId);
                })
                ->whereBetween('date_debut', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
        ];
        
        // Membres à approuver
        $membresEnAttente = Membre::where('ecole_id', $ecoleId)
            ->where('approuve', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Sessions aujourd'hui
        $sessionsAujourdhui = CoursSession::with('cours')
            ->whereHas('cours', function($q) use ($ecoleId) {
                $q->where('ecole_id', $ecoleId);
            })
            ->whereDate('date_debut', Carbon::today())
            ->get();
        
        // Prochains cours cette semaine
        $prochainsCours = CoursSession::with('cours')
            ->whereHas('cours', function($q) use ($ecoleId) {
                $q->where('ecole_id', $ecoleId);
            })
            ->whereBetween('date_debut', [Carbon::now(), Carbon::now()->endOfWeek()])
            ->orderBy('date_debut')
            ->take(5)
            ->get();
        
        return view('admin.dashboard.ecole', compact(
            'ecole',
            'stats',
            'membresEnAttente',
            'sessionsAujourdhui',
            'prochainsCours'
        ));
    }
}
