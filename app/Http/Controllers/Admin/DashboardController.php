<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use App\Models\Cours;
use App\Models\CoursSession;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques de base
        $stats = $this->getStatistiques($user);
        
        // Derniers membres inscrits
        $derniers_membres = $this->getDerniersMembres($user);
        
        // Sessions récentes
        $sessions_recentes = $this->getSessionsRecentes($user);
        
        return view('admin.dashboard', compact(
            'stats',
            'derniers_membres', 
            'sessions_recentes'
        ));
    }
    
    /**
     * Calcule les statistiques du dashboard
     */
    private function getStatistiques($user)
    {
        $stats = [];
        
        if ($user->role === 'superadmin') {
            // Superadmin voit tout
            $stats['total_membres'] = Membre::where('approuve', true)->count();
            $stats['membres_en_attente'] = Membre::where('approuve', false)->count();
            $stats['ecoles_actives'] = Ecole::where('active', true)->count();
            $stats['presences_aujourdhui'] = Presence::whereDate('date_presence', today())->count();
            $stats['cours_actifs'] = Cours::where('statut', 'actif')->count();
            $stats['sessions_actives'] = CoursSession::where('active', true)->count();
            $stats['total_utilisateurs'] = User::where('active', true)->count();
            
        } elseif ($user->role === 'admin' && $user->ecole_id) {
            // Admin d'école voit seulement son école
            $stats['total_membres'] = Membre::where('ecole_id', $user->ecole_id)
                                           ->where('approuve', true)
                                           ->count();
            $stats['membres_en_attente'] = Membre::where('ecole_id', $user->ecole_id)
                                                ->where('approuve', false)
                                                ->count();
            $stats['ecoles_actives'] = 1; // Son école seulement
            $stats['cours_actifs'] = Cours::where('ecole_id', $user->ecole_id)
                                        ->where('statut', 'actif')
                                        ->count();
            $stats['sessions_actives'] = CoursSession::where('ecole_id', $user->ecole_id)
                                                   ->where('active', true)
                                                   ->count();
            
            // Présences aujourd'hui pour cette école
            $stats['presences_aujourdhui'] = Presence::whereDate('date_presence', today())
                ->whereHas('membre', function($query) use ($user) {
                    $query->where('ecole_id', $user->ecole_id);
                })->count();
                
        } else {
            // Valeurs par défaut si pas d'école
            $stats['total_membres'] = 0;
            $stats['membres_en_attente'] = 0;
            $stats['ecoles_actives'] = 0;
            $stats['presences_aujourdhui'] = 0;
            $stats['cours_actifs'] = 0;
        }
        
        return $stats;
    }
    
    /**
     * Récupère les derniers membres inscrits
     */
    private function getDerniersMembres($user)
    {
        $query = Membre::with('ecole')
                      ->orderBy('created_at', 'desc')
                      ->limit(6);
        
        if ($user->role === 'admin' && $user->ecole_id) {
            $query->where('ecole_id', $user->ecole_id);
        }
        
        return $query->get();
    }
    
    /**
     * Récupère les sessions récentes
     */
    private function getSessionsRecentes($user)
    {
        $query = CoursSession::with('ecole')
                           ->orderBy('created_at', 'desc')
                           ->limit(5);
        
        if ($user->role === 'admin' && $user->ecole_id) {
            $query->where('ecole_id', $user->ecole_id);
        }
        
        return $query->get();
    }
    
    /**
     * API pour récupérer les stats en temps réel (AJAX)
     */
    public function getStatsApi()
    {
        $user = Auth::user();
        $stats = $this->getStatistiques($user);
        
        return response()->json([
            'success' => true,
            'stats' => $stats,
            'updated_at' => now()->format('H:i:s')
        ]);
    }
    
    /**
     * Graphique des membres par mois
     */
    public function getMembresParMois()
    {
        $user = Auth::user();
        
        $query = Membre::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
                      ->whereYear('created_at', date('Y'))
                      ->groupBy('mois')
                      ->orderBy('mois');
        
        if ($user->role === 'admin' && $user->ecole_id) {
            $query->where('ecole_id', $user->ecole_id);
        }
        
        $data = $query->get();
        
        // Formater pour Chart.js
        $labels = [];
        $values = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->locale('fr')->format('M');
            $found = $data->firstWhere('mois', $i);
            $values[] = $found ? $found->total : 0;
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $values
        ]);
    }
    
    /**
     * Activité récente
     */
    public function getActiviteRecente()
    {
        $user = Auth::user();
        $activites = [];
        
        // Nouveaux membres
        $nouveaux_membres = Membre::with('ecole')
                                 ->where('created_at', '>=', now()->subDays(7));
        
        if ($user->role === 'admin' && $user->ecole_id) {
            $nouveaux_membres->where('ecole_id', $user->ecole_id);
        }
        
        foreach ($nouveaux_membres->get() as $membre) {
            $activites[] = [
                'type' => 'nouveau_membre',
                'message' => "Nouveau membre: {$membre->prenom} {$membre->nom}",
                'ecole' => $membre->ecole->nom ?? 'N/A',
                'date' => $membre->created_at->diffForHumans(),
                'icon' => 'fas fa-user-plus',
                'color' => 'primary'
            ];
        }
        
        // Sessions créées
        $nouvelles_sessions = CoursSession::with('ecole')
                                        ->where('created_at', '>=', now()->subDays(7));
        
        if ($user->role === 'admin' && $user->ecole_id) {
            $nouvelles_sessions->where('ecole_id', $user->ecole_id);
        }
        
        foreach ($nouvelles_sessions->get() as $session) {
            $activites[] = [
                'type' => 'nouvelle_session',
                'message' => "Nouvelle session: {$session->nom}",
                'ecole' => $session->ecole->nom,
                'date' => $session->created_at->diffForHumans(),
                'icon' => 'fas fa-calendar-plus',
                'color' => 'success'
            ];
        }
        
        // Trier par date
        usort($activites, function($a, $b) {
            return strcmp($b['date'], $a['date']);
        });
        
        return response()->json(array_slice($activites, 0, 10));
    }
}
