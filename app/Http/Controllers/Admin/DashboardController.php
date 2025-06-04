<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\Session;
use App\Models\Presence;
use App\Models\InscriptionCours;
use App\Models\CoursSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirection selon le rôle
        if ($user->hasRole('superadmin')) {
            return $this->superadminDashboard();
        } elseif ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } else {
            return redirect()->route('home');
        }
    }

    private function superadminDashboard()
    {
        // Statistiques globales
        $stats = [
            'total_ecoles' => Ecole::count(),
            'ecoles_actives' => Ecole::where('statut', 'active')->count(),
            'total_membres' => Membre::count(),
            'membres_approuves' => Membre::where('approuve', true)->count(),
            'total_cours' => Cours::count(),
            'total_sessions' => CoursSession::count(),
            'nouveaux_membres_mois' => Membre::whereMonth('created_at', date('m'))
                                            ->whereYear('created_at', date('Y'))
                                            ->count(),
        ];

        // Top 5 écoles par nombre de membres
        $topEcoles = Ecole::withCount('membres')
                         ->orderBy('membres_count', 'desc')
                         ->take(5)
                         ->get();

        // Inscriptions par mois (12 derniers mois)
        $inscriptionsParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Membre::whereMonth('created_at', $date->month)
                          ->whereYear('created_at', $date->year)
                          ->count();
            
            $inscriptionsParMois[] = [
                'mois' => $date->format('Y-m'),
                'total' => $count
            ];
        }

        // Activité récente
        $activiteRecente = collect();
        
        // Derniers membres inscrits
        $derniersMembres = Membre::with('ecole')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        
        foreach ($derniersMembres as $membre) {
            $activiteRecente->push([
                'message' => "Nouveau membre: {$membre->prenom} {$membre->nom}",
                'ecole' => $membre->ecole->nom ?? 'N/A',
                'date' => $membre->created_at
            ]);
        }

        // Tâches en attente
        $tachesEnAttente = [
            'membres_a_approuver' => Membre::where('approuve', false)->count(),
            'sessions_a_venir' => CoursSession::where('date_debut', '>=', now())
                                             ->where('date_debut', '<=', now()->addDays(7))
                                             ->count(),
        ];

        return view('admin.dashboard-superadmin', compact(
            'stats',
            'topEcoles',
            'inscriptionsParMois',
            'activiteRecente',
            'tachesEnAttente'
        ));
    }

    private function adminDashboard()
    {
        $user = Auth::user();
        $ecoleId = $user->ecole_id;

        // Statistiques de l'école
        $stats = [
            'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
            'membres_actifs' => Membre::where('ecole_id', $ecoleId)
                                     ->where('approuve', true)
                                     ->count(),
            'total_cours' => Cours::where('ecole_id', $ecoleId)->count(),
            'cours_actifs' => Cours::where('ecole_id', $ecoleId)
                                  ->where('actif', true)
                                  ->count(),
            'presences_semaine' => $this->getPresencesSemaine($ecoleId),
            'nouveaux_membres_mois' => Membre::where('ecole_id', $ecoleId)
                                           ->whereMonth('created_at', date('m'))
                                           ->whereYear('created_at', date('Y'))
                                           ->count(),
        ];

        // Cours du jour
        $coursAujourdhui = Cours::where('ecole_id', $ecoleId)
                               ->where('actif', true)
                               ->get();

        // Prochaines sessions (périodes)
        $prochainesSessions = CoursSession::where('ecole_id', $ecoleId)
                                         ->where('date_debut', '>=', now())
                                         ->where('active', true)
                                         ->orderBy('date_debut')
                                         ->take(5)
                                         ->get();

        // Membres récents
        $membresRecents = Membre::where('ecole_id', $ecoleId)
                               ->orderBy('created_at', 'desc')
                               ->take(5)
                               ->get();

        // Tâches
        $taches = [
            'membres_a_approuver' => Membre::where('ecole_id', $ecoleId)
                                          ->where('approuve', false)
                                          ->count(),
            'presences_a_prendre' => Cours::where('ecole_id', $ecoleId)
                                   ->where('actif', true)
                                   ->whereDoesntHave('presences', function($q) {
                                       $q->whereDate('date_presence', today());
                                   })
                                   ->count(),
        ];

        return view('admin.dashboard-admin', compact(
            'stats',
            'coursAujourdhui',
            'prochainesSessions',
            'membresRecents',
            'taches'
        ));
    }

    private function getPresencesSemaine($ecoleId)
    {
        return Presence::whereHas('cours', function($q) use ($ecoleId) {
                         $q->where('ecole_id', $ecoleId);
                     })
                     ->whereBetween('date_presence', [
                         now()->startOfWeek(),
                         now()->endOfWeek()
                     ])
                     ->where('status', 'present')
                     ->count();
    }

    // Méthodes pour les API stats (AJAX)
    public function apiStats()
    {
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            $data = [
                'membres_total' => Membre::count(),
                'cours_total' => Cours::count(),
                'presences_jour' => Presence::whereDate('date_debut', today())->count(),
                'revenus_mois' => InscriptionCours::whereMonth('created_at', date('m'))
                                                 ->where('statut', 'confirmee')
                                                 ->count() * 150, // Prix estimé
            ];
        } else {
            $ecoleId = $user->ecole_id;
            $data = [
                'membres_total' => Membre::where('ecole_id', $ecoleId)->count(),
                'cours_total' => Cours::where('ecole_id', $ecoleId)->count(),
                'presences_jour' => Presence::whereHas('cours', function($q) use ($ecoleId) {
                                              $q->where('ecole_id', $ecoleId);
                                          })
                                          ->whereDate('date_debut', today())
                                          ->count(),
            ];
        }
        
        return response()->json($data);
    }

    // ===== MÉTHODES POUR LES RAPPORTS =====

    public function rapportsIndex()
    {
        $user = auth()->user();
        
        $stats = [
            'total_ecoles' => $user->hasRole('superadmin') ? Ecole::count() : 1,
            'total_membres' => $user->hasRole('superadmin') 
                ? Membre::count() 
                : Membre::where('ecole_id', $user->ecole_id)->count(),
            'total_cours' => $user->hasRole('superadmin')
                ? Cours::count()
                : Cours::where('ecole_id', $user->ecole_id)->count(),
            'total_presences_mois' => $this->getPresencesMoisCount($user),
        ];
        
        return view('admin.rapports.index', compact('stats'));
    }

    public function retentionReport(Request $request)
    {
        $user = auth()->user();
        $periode = $request->get('periode', '6');
        
        $dateDebut = Carbon::now()->subMonths($periode);
        
        $query = Membre::where('created_at', '<=', $dateDebut);
        
        if (!$user->hasRole('superadmin')) {
            $query->where('ecole_id', $user->ecole_id);
        }
        
        $membresDebut = $query->count();
        $membresActifs = $query->where('approuve', true)->count();
        
        $tauxRetention = $membresDebut > 0 ? round(($membresActifs / $membresDebut) * 100, 2) : 0;
        
        $cohortes = $this->getAnalyseCohortes($user, $periode);
        
        $raisonsAbandon = [
            ['raison' => 'Manque de temps', 'pourcentage' => 35],
            ['raison' => 'Coût trop élevé', 'pourcentage' => 25],
            ['raison' => 'Déménagement', 'pourcentage' => 20],
            ['raison' => 'Insatisfaction', 'pourcentage' => 10],
            ['raison' => 'Autres', 'pourcentage' => 10],
        ];
        
        $membresRisque = Membre::where('approuve', true)
                              ->whereDoesntHave('presences', function($q) {
                                  $q->where('date_presence', '>=', Carbon::now()->subDays(30))
                                    ->where('status', 'present');
                              });
        
        if (!$user->hasRole('superadmin')) {
            $membresRisque->where('ecole_id', $user->ecole_id);
        }
        
        $membresRisque = $membresRisque->get();
        
        return view('admin.rapports.retention', compact(
            'tauxRetention',
            'cohortes',
            'raisonsAbandon',
            'membresRisque',
            'periode'
        ));
    }

    public function presencesReport(Request $request)
    {
        $user = auth()->user();
        $dateDebut = $request->get('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->get('date_fin', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $query = Presence::whereBetween('date_presence', [$dateDebut, $dateFin]);
        
        if (!$user->hasRole('superadmin')) {
            $query->whereHas('cours', function($q) use ($user) {
                $q->where('ecole_id', $user->ecole_id);
            });
        }
        
        $presencesParJour = $query->select(
                DB::raw('DATE(date_presence) as jour'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as presents'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absents')
            )
            ->groupBy('jour')
            ->orderBy('jour')
            ->get();
        
        $coursQuery = Cours::query();
        if (!$user->hasRole('superadmin')) {
            $coursQuery->where('ecole_id', $user->ecole_id);
        }
        
        $tauxParCours = $coursQuery->get()->map(function($cours) use ($dateDebut, $dateFin) {
            $presences = $cours->presences()->whereBetween('date_presence', [$dateDebut, $dateFin])->get();
            $total = $presences->count();
            $presents = $presences->where('status', 'present')->count();
            
            return [
                'cours' => $cours->nom,
                'taux' => $total > 0 ? round(($presents / $total) * 100, 2) : 0,
                'total' => $total,
                'presents' => $presents
            ];
        })->sortByDesc('taux');
        
        $membresQuery = Membre::withCount(['presences as presences_count' => function($q) use ($dateDebut, $dateFin) {
            $q->whereBetween('date_presence', [$dateDebut, $dateFin])
              ->where('status', 'present');
        }]);
        
        if (!$user->hasRole('superadmin')) {
            $membresQuery->where('ecole_id', $user->ecole_id);
        }
        
        $membresAssidus = $membresQuery->orderBy('presences_count', 'desc')
                                      ->take(10)
                                      ->get();
        
        $evolutionMensuelle = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $presQuery = Presence::whereMonth('date_presence', $date->month)
                                ->whereYear('date_presence', $date->year);
            
            if (!$user->hasRole('superadmin')) {
                $presQuery->whereHas('cours', function($q) use ($user) {
                    $q->where('ecole_id', $user->ecole_id);
                });
            }
            
            $total = $presQuery->count();
            $presents = clone $presQuery;
            $presents = $presents->where('status', 'present')->count();
            
            $evolutionMensuelle[] = [
                'mois' => $date->format('M Y'),
                'taux' => $total > 0 ? round(($presents / $total) * 100, 2) : 0
            ];
        }
        
        return view('admin.rapports.presences', compact(
            'presencesParJour',
            'tauxParCours',
            'membresAssidus',
            'evolutionMensuelle',
            'dateDebut',
            'dateFin'
        ));
    }

    public function inscriptionsReport(Request $request)
    {
        $user = auth()->user();
        $annee = $request->get('annee', date('Y'));
        
        $query = InscriptionCours::whereYear('created_at', $annee);
        
        if (!$user->hasRole('superadmin')) {
            $query->whereHas('cours', function($q) use ($user) {
                $q->where('ecole_id', $user->ecole_id);
            });
        }
        
        $inscriptionsParMois = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $count = clone $query;
            $total = $count->whereMonth('created_at', $mois)->count();
            
            $confirmees = clone $query;
            $confirmees = $confirmees->whereMonth('created_at', $mois)
                                     ->where('statut', 'confirmee')
                                     ->count();
            
            $inscriptionsParMois[] = [
                'mois' => Carbon::create($annee, $mois, 1)->format('M'),
                'total' => $total,
                'confirmees' => $confirmees
            ];
        }
        
        $coursQuery = Cours::withCount(['inscriptions' => function($q) use ($annee) {
            $q->whereYear('created_at', $annee);
        }]);
        
        if (!$user->hasRole('superadmin')) {
            $coursQuery->where('ecole_id', $user->ecole_id);
        }
        
        $repartitionParCours = $coursQuery->orderBy('inscriptions_count', 'desc')->get();
        
        $totalInscriptions = clone $query;
        $totalInscriptions = $totalInscriptions->count();
        
        $inscriptionsConfirmees = clone $query;
        $inscriptionsConfirmees = $inscriptionsConfirmees->where('statut', 'confirmee')->count();
        
        $tauxConversion = $totalInscriptions > 0 
            ? round(($inscriptionsConfirmees / $totalInscriptions) * 100, 2) 
            : 0;
        
        $revenusEstimes = $inscriptionsConfirmees * 150;
        
        $stats = [
            'total_inscriptions' => $totalInscriptions,
            'inscriptions_confirmees' => $inscriptionsConfirmees,
            'taux_conversion' => $tauxConversion,
            'revenus_estimes' => $revenusEstimes
        ];
        
        return view('admin.rapports.inscriptions', compact(
            'inscriptionsParMois',
            'repartitionParCours',
            'stats',
            'annee'
        ));
    }

    // Méthodes helpers privées
    private function getPresencesMoisCount($user)
    {
        $query = Presence::whereMonth('date_presence', date('m'))
                        ->whereYear('date_presence', date('Y'))
                        ->where('status', 'present');
        
        if (!$user->hasRole('superadmin')) {
            $query->whereHas('cours', function($q) use ($user) {
                $q->where('ecole_id', $user->ecole_id);
            });
        }
        
        return $query->count();
    }

    private function getAnalyseCohortes($user, $periode)
    {
        $cohortes = [];
        
        for ($i = $periode - 1; $i >= 0; $i--) {
            $dateCohorte = Carbon::now()->subMonths($i)->startOfMonth();
            
            $query = Membre::whereMonth('created_at', $dateCohorte->month)
                          ->whereYear('created_at', $dateCohorte->year);
            
            if (!$user->hasRole('superadmin')) {
                $query->where('ecole_id', $user->ecole_id);
            }
            
            $total = $query->count();
            $actifs = clone $query;
            $actifs = $actifs->where('approuve', true)->count();
            
            $cohortes[] = [
                'mois' => $dateCohorte->format('M Y'),
                'total' => $total,
                'actifs' => $actifs,
                'taux' => $total > 0 ? round(($actifs / $total) * 100, 2) : 0
            ];
        }
        
        return $cohortes;
    }
}
