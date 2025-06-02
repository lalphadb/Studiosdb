#!/bin/bash
# improve-existing-dashboard.sh

echo "🎨 AMÉLIORATION DES DASHBOARDS EXISTANTS"
echo "========================================"

# 1. Modifier le DashboardController pour utiliser les bonnes vues
echo "📝 Mise à jour du DashboardController..."
cat > app/Http/Controllers/Admin/DashboardController.php << 'EOF'
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
EOF

# 2. Améliorer la vue superadmin avec glassmorphism
echo "🎨 Amélioration de la vue superadmin..."
cat > resources/views/admin/dashboard/superadmin.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord Super Admin')
@section('page-title', 'Centre de Contrôle Global')
@section('breadcrumb', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- En-tête amélioré -->
    <div class="dashboard-header" style="background: rgba(255,255,255,0.02); backdrop-filter: blur(10px); border-radius: 20px; padding: 2rem; margin-bottom: 2rem;">
        <h1 class="dashboard-title" style="font-size: 2.5rem; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,.3);">
            <i class="fas fa-chart-line"></i> Centre de Contrôle Global
        </h1>
        <p style="color: #8b92a3;">Vue d'ensemble complète du système Studios Unis</p>
    </div>

    <!-- Grille de statistiques principales -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Écoles -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #17a2b8, #20c997);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: rgba(23,162,184,0.2); color: #17a2b8; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 1rem;">
                    <i class="fas fa-school"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_ecoles'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Écoles</p>
                <p style="color: #20c997; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['ecoles_actives'] }} actives</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.ecoles.index') }}" style="color: #17a2b8; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    Gérer les écoles <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Membres -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f59e0b, #ef4444);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: rgba(245,158,11,0.2); color: #f59e0b; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 1rem;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_membres'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Membres</p>
                <p style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['membres_approuves'] }} approuvés</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.membres.index') }}" style="color: #f59e0b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    Voir tous les membres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Cours -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #8b5cf6, #ec4899);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: rgba(139,92,246,0.2); color: #8b5cf6; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 1rem;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_cours'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Cours</p>
                <p style="color: #ec4899; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['total_sessions'] }} sessions</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.cours.index') }}" style="color: #8b5cf6; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    Gérer les cours <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Nouveaux ce mois -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #10b981, #3b82f6);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: rgba(16,185,129,0.2); color: #10b981; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['nouveaux_membres_mois'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Nouveaux ce mois</p>
                <p style="color: #3b82f6; font-size: 0.875rem; margin-top: 0.5rem;">+{{ round(($stats['nouveaux_membres_mois'] / max($stats['total_membres'], 1)) * 100, 1) }}%</p>
            </div>
        </div>
    </div>

    <!-- Contenu principal en 2 colonnes -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Colonne gauche -->
        <div>
            <!-- Top 5 Écoles -->
            <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600;">
                        <i class="fas fa-trophy" style="color: #f59e0b;"></i> Top 5 Écoles par Membres
                    </h3>
                </div>
                <div class="content-card-body">
                    @foreach($topEcoles as $index => $ecole)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; margin-bottom: 0.5rem; background: rgba(255,255,255,0.02); border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">#{{ $index + 1 }}</span>
                            <div>
                                <p style="font-weight: 600; margin: 0;">{{ $ecole->nom }}</p>
                                <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">{{ $ecole->ville }}</p>
                            </div>
                        </div>
                        <span style="font-size: 1.25rem; font-weight: 700; color: #10b981;">{{ $ecole->membres_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Graphique des inscriptions -->
            <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600;">
                        <i class="fas fa-chart-line" style="color: #3b82f6;"></i> Évolution des Inscriptions
                    </h3>
                </div>
                <div class="content-card-body">
                    <canvas id="inscriptionsChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Colonne droite -->
        <div>
            <!-- Activité récente -->
            <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600;">
                        <i class="fas fa-history" style="color: #8b5cf6;"></i> Activité Récente
                    </h3>
                </div>
                <div class="content-card-body">
                    <ul class="modern-list" style="list-style: none; padding: 0;">
                        @forelse($activiteRecente->take(5) as $activite)
                        <li style="padding: 0.75rem; margin-bottom: 0.5rem; background: rgba(255,255,255,0.02); border-radius: 8px; display: flex; align-items: center; gap: 1rem;">
                            <i class="fas fa-user" style="color: #10b981;"></i>
                            <div style="flex: 1;">
                                <p style="margin: 0;">{{ $activite['message'] }}</p>
                                <p style="color: #8b92a3; font-size: 0.75rem; margin: 0;">{{ $activite['ecole'] }} - {{ $activite['date']->diffForHumans() }}</p>
                            </div>
                        </li>
                        @empty
                        <li style="text-align: center; color: #8b92a3; padding: 2rem;">Aucune activité récente</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600;">
                        <i class="fas fa-bolt" style="color: #f59e0b;"></i> Actions Rapides
                    </h3>
                </div>
                <div class="quick-actions" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <a href="{{ route('admin.ecoles.create') }}" class="action-btn" style="background: rgba(23,162,184,0.1); border: 1px solid rgba(23,162,184,0.3); color: #17a2b8; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s;">
                        <i class="fas fa-plus-circle" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                        Nouvelle École
                    </a>
                    <a href="{{ route('admin.membres.create') }}" class="action-btn" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s;">
                        <i class="fas fa-user-plus" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                        Nouveau Membre
                    </a>
                    <a href="{{ route('admin.cours.create') }}" class="action-btn" style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.3); color: #8b5cf6; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s;">
                        <i class="fas fa-calendar-plus" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                        Nouveau Cours
                    </a>
                    <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="action-btn" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s; position: relative;">
                        <i class="fas fa-user-check" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                        Approbations
                        @if($tachesEnAttente['membres_a_approuver'] > 0)
                        <span style="position: absolute; top: -0.5rem; right: -0.5rem; background: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 9999px;">
                            {{ $tachesEnAttente['membres_a_approuver'] }}
                        </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Graphique des inscriptions
const ctx = document.getElementById('inscriptionsChart').getContext('2d');
const inscriptionsData = @json($inscriptionsParMois);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: inscriptionsData.map(item => {
            const [year, month] = item.mois.split('-');
            return new Date(year, month - 1).toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
        }),
        datasets: [{
            label: 'Nouvelles inscriptions',
            data: inscriptionsData.map(item => item.total),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#8b92a3'
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#8b92a3'
                }
            }
        }
    }
});
</script>
@endpush
@endsection
EOF

# 3. Améliorer la vue admin école
echo "🏫 Amélioration de la vue admin école..."
cat > resources/views/admin/dashboard/ecole.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', $ecole->nom)
@section('breadcrumb', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- En-tête pratique -->
    <div class="dashboard-header" style="background: rgba(255,255,255,0.02); backdrop-filter: blur(10px); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem;">
        <h1 class="dashboard-title" style="font-size: 2rem; font-weight: 700;">
            <i class="fas fa-school"></i> {{ $ecole->nom }}
        </h1>
        <p style="color: #8b92a3;">{{ $ecole->ville }}, {{ $ecole->province }}</p>
    </div>

    <!-- Alertes importantes -->
    @if($stats['membres_en_attente'] > 0)
    <div style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); border-radius: 12px; padding: 1rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1.5rem;"></i>
            <div>
                <p style="font-weight: 600; margin: 0;">Action requise</p>
                <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">{{ $stats['membres_en_attente'] }} membre(s) en attente d'approbation</p>
            </div>
        </div>
        <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none;">
            Examiner
        </a>
    </div>
    @endif

    <!-- Stats pratiques en grille -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <!-- Membres actifs -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $stats['membres_actifs'] }}</h3>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">Membres actifs</p>
                </div>
                <div style="background: rgba(16,185,129,0.2); color: #10b981; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Présences aujourd'hui -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $stats['presences_jour'] }}</h3>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">Présences aujourd'hui</p>
                </div>
                <div style="background: rgba(59,130,246,0.2); color: #3b82f6; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Cours actifs -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $stats['cours_actifs'] }}</h3>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">Cours actifs</p>
                </div>
                <div style="background: rgba(139,92,246,0.2); color: #8b5cf6; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>

        <!-- Sessions cette semaine -->
        <div class="stat-card-modern" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $stats['sessions_semaine'] }}</h3>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">Sessions/semaine</p>
                </div>
                <div style="background: rgba(245,158,11,0.2); color: #f59e0b; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions" style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Actions rapides</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
            <a href="{{ route('admin.membres.create') }}" class="action-btn" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10b981; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                <i class="fas fa-user-plus" style="font-size: 1.5rem;"></i>
                <span>Nouveau membre</span>
            </a>
            <a href="{{ route('admin.presences.create') }}" class="action-btn" style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.3); color: #3b82f6; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span>Prendre présences</span>
            </a>
            <a href="{{ route('admin.cours.create') }}" class="action-btn" style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.3); color: #8b5cf6; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                <i class="fas fa-calendar-plus" style="font-size: 1.5rem;"></i>
                <span>Créer cours</span>
            </a>
            <a href="{{ route('admin.inscriptions.create') }}" class="action-btn" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                <i class="fas fa-clipboard-list" style="font-size: 1.5rem;"></i>
                <span>Inscription</span>
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Sessions aujourd'hui -->
        <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem;">
            <div class="content-card-header" style="margin-bottom: 1rem;">
                <h3 class="content-card-title" style="font-size: 1.125rem; font-weight: 600;">
                    <i class="fas fa-calendar-day" style="color: #3b82f6;"></i> Sessions aujourd'hui
                </h3>
            </div>
            <div class="content-card-body">
                @forelse($sessionsAujourdhui as $session)
                <div style="padding: 0.75rem; background: rgba(255,255,255,0.02); border-radius: 8px; margin-bottom: 0.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-weight: 600; margin: 0;">{{ $session->cours->nom }}</p>
                            <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">
                                {{ $session->date_debut->format('H:i') }} - {{ $session->date_fin->format('H:i') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.presences.create', ['session_id' => $session->id]) }}" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem;">
                            Présences
                        </a>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: #8b92a3; padding: 2rem;">Aucune session aujourd'hui</p>
                @endforelse
            </div>
        </div>

        <!-- Membres en attente -->
        <div class="content-card" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem;">
            <div class="content-card-header" style="margin-bottom: 1rem;">
                <h3 class="content-card-title" style="font-size: 1.125rem; font-weight: 600;">
                    <i class="fas fa-user-clock" style="color: #f59e0b;"></i> Membres en attente
                </h3>
            </div>
            <div class="content-card-body">
                @forelse($membresEnAttente as $membre)
                <div style="padding: 0.75rem; background: rgba(255,255,255,0.02); border-radius: 8px; margin-bottom: 0.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-weight: 600; margin: 0;">{{ $membre->prenom }} {{ $membre->nom }}</p>
                            <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">{{ $membre->created_at->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('admin.membres.show', $membre) }}" style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem;">
                            Examiner
                        </a>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: #8b92a3; padding: 2rem;">Aucun membre en attente</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
EOF

# 4. Nettoyer les fichiers non utilisés
echo "🧹 Nettoyage des fichiers non utilisés..."

# Déplacer les fichiers non utilisés dans un dossier backup
mkdir -p backup/unused-dashboard-files/views
mkdir -p backup/unused-dashboard-files/css

# Déplacer les vues non utilisées
mv resources/views/admin/dashboard/modern.blade.php backup/unused-dashboard-files/views/ 2>/dev/null || true
mv resources/views/admin/dashboard/safe-dashboard.blade.php backup/unused-dashboard-files/views/ 2>/dev/null || true
mv resources/views/admin/dashboard/index.blade.php backup/unused-dashboard-files/views/ 2>/dev/null || true

# Déplacer les CSS non utilisés
mv public/css/dashboard-fix.css backup/unused-dashboard-files/css/ 2>/dev/null || true
mv public/css/dashboard-final.css backup/unused-dashboard-files/css/ 2>/dev/null || true

# 5. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data resources/views/admin/dashboard/
chown -R lalpha:www-data app/Http/Controllers/Admin/
chmod -R 755 resources/views/admin/dashboard/
chmod -R 755 app/Http/Controllers/Admin/

# 6. Vider le cache
echo "🧹 Vidage du cache..."
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Amélioration terminée !"
echo ""
echo "📋 CE QUI A ÉTÉ FAIT :"
echo "1. ✅ DashboardController modifié pour rediriger vers les bonnes vues"
echo "2. ✅ Vue superadmin améliorée avec glassmorphism et analytics"
echo "3. ✅ Vue admin école améliorée pour être plus pratique"
echo "4. ✅ Utilisation du CSS existant (studiosdb-glassmorphic-complete.css)"
echo "5. ✅ Fichiers non utilisés déplacés dans backup/"
echo ""
echo "🗂️ FICHIERS ACTIFS :"
echo "- admin/dashboard/superadmin.blade.php (pour superadmin)"
echo "- admin/dashboard/ecole.blade.php (pour admin d'école)"
echo "- admin/dashboard/no-ecole.blade.php (si pas d'école assignée)"
echo "- admin/dashboard/error.blade.php (en cas d'erreur)"
echo ""
echo "🎨 AMÉLIORATIONS APPLIQUÉES :"
echo "- Glassmorphism sur toutes les cartes"
echo "- Grille de stats responsive"
echo "- Actions rapides"
echo "- Graphiques pour superadmin"
echo "- Interface pratique pour admin école"
