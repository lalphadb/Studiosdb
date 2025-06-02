<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\Session;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Si c'est un superadmin
        if ($user->role === 'admin') {
            return $this->superAdminDashboard();
        }
        
        // Pour les admins d'école
        return $this->ecoleAdminDashboard($user);
    }
    
    private function superAdminDashboard()
    {
        // Statistiques globales pour superadmin
        $stats = [
            'total_ecoles' => Ecole::count(),
            'total_ecoles_actives' => Ecole::where('statut', 'actif')->count(),
            'total_membres' => Membre::count(),
            'total_membres_approuves' => Membre::where('approuve', true)->count(),
            'total_cours' => Cours::count(),
            'total_sessions' => Session::count(),
            'total_users' => User::count(),
            'nouveaux_membres_mois' => Membre::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
        
        // Top 5 écoles par nombre de membres
        $topEcoles = Ecole::withCount('membres')
            ->orderBy('membres_count', 'desc')
            ->take(5)
            ->get();
        
        // Statistiques par école
        $ecolesStats = Ecole::with(['membres' => function($query) {
            $query->where('approuve', true);
        }])
        ->withCount(['membres', 'cours'])
        ->get();
        
        // Graphique des inscriptions par mois (12 derniers mois)
        $inscriptionsParMois = Membre::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();
        
        return view('admin.dashboard.superadmin', compact(
            'stats', 
            'topEcoles', 
            'ecolesStats',
            'inscriptionsParMois'
        ));
    }
    
    private function ecoleAdminDashboard($user)
    {
        $ecoleId = $user->ecole_id;
        
        if (!$ecoleId) {
            return redirect()->route('admin.ecoles.index')
                ->with('error', 'Aucune école assignée à votre compte.');
        }
        
        $ecole = Ecole::find($ecoleId);
        
        // Statistiques de base pour l'école
        $stats = [
            'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
            'membres_approuves' => Membre::where('ecole_id', $ecoleId)->where('approuve', true)->count(),
            'membres_en_attente' => Membre::where('ecole_id', $ecoleId)->where('approuve', false)->count(),
            'total_cours' => Cours::where('ecole_id', $ecoleId)->count(),
            'sessions_actives' => Session::whereHas('cours', function($q) use ($ecoleId) {
                $q->where('ecole_id', $ecoleId);
            })->where('statut', 'actif')->count(),
            'nouveaux_cette_semaine' => Membre::where('ecole_id', $ecoleId)
                ->where('created_at', '>=', Carbon::now()->startOfWeek())
                ->count(),
        ];
        
        // Membres récents à approuver
        $membresEnAttente = Membre::where('ecole_id', $ecoleId)
            ->where('approuve', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Prochaines sessions
        $prochainesSessions = Session::whereHas('cours', function($q) use ($ecoleId) {
            $q->where('ecole_id', $ecoleId);
        })
        ->where('date_debut', '>=', Carbon::now())
        ->orderBy('date_debut')
        ->take(5)
        ->with('cours')
        ->get();
        
        // Pour le graphique des présences (temporaire sans ceintures)
        $presencesParJour = [];
        
        // Badges récents (si le système est activé)
        $badgesRecents = [];
        
        return view('admin.dashboard.ecole', compact(
            'ecole',
            'stats',
            'membresEnAttente',
            'prochainesSessions',
            'presencesParJour',
            'badgesRecents'
        ));
    }
}
