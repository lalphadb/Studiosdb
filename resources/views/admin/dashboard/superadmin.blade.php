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
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #17a2b8, #20c997);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #17a2b8, #20c997); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(23,162,184,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-school"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['total_ecoles'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Écoles</p>
                <p style="color: #20c997; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['ecoles_actives'] }} actives</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.ecoles.index') }}" style="color: #17a2b8; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Gérer les écoles <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Membres -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f59e0b, #ef4444);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(245,158,11,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['total_membres'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Membres</p>
                <p style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['membres_approuves'] }} approuvés</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.membres.index') }}" style="color: #f59e0b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Voir tous les membres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Cours -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #8b5cf6, #ec4899);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(139,92,246,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['total_cours'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Total des Cours</p>
                <p style="color: #ec4899; font-size: 0.875rem; margin-top: 0.5rem;">{{ $stats['total_sessions'] }} sessions</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.cours.index') }}" style="color: #8b5cf6; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Gérer les cours <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Nouveaux ce mois -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #10b981, #3b82f6);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #3b82f6); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(16,185,129,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['nouveaux_membres_mois'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Nouveaux ce mois</p>
                <p style="color: #3b82f6; font-size: 0.875rem; margin-top: 0.5rem;">+{{ round(($stats['nouveaux_membres_mois'] / max($stats['total_membres'], 1)) * 100, 1) }}%</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.membres.index') }}?date=this_month" style="color: #10b981; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Voir les nouveaux <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Contenu principal en 2 colonnes -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Colonne gauche -->
        <div>
            <!-- Top 5 Écoles -->
            <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; transition: all 0.3s ease;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <i class="fas fa-trophy" style="color: #f59e0b;"></i> Top 5 Écoles par Membres
                    </h3>
                </div>
                <div class="content-card-body">
                    @foreach($topEcoles as $index => $ecole)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; margin-bottom: 0.5rem; background: rgba(255,255,255,0.02); border-radius: 12px; transition: all 0.3s ease;"
                         onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateX(5px)'"
                         onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.transform='translateX(0)'">
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
            <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; transition: all 0.3s ease;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
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
            <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; transition: all 0.3s ease;">
                <div class="content-card-header" style="margin-bottom: 1.5rem;">
                    <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <i class="fas fa-history" style="color: #8b5cf6;"></i> Activité Récente
                    </h3>
                </div>
                <div class="content-card-body">
                    <ul class="modern-list" style="list-style: none; padding: 0;">
                        @forelse($activiteRecente->take(5) as $activite)
                        <li style="padding: 0.75rem; margin-bottom: 0.5rem; background: rgba(255,255,255,0.02); border-radius: 8px; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255,255,255,0.05)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.02)'">
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
<div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; transition: all 0.3s ease;">
    <div class="content-card-header" style="margin-bottom: 1.5rem;">
        <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
            <i class="fas fa-bolt" style="color: #f59e0b;"></i> Actions Rapides
        </h3>
    </div>
    <div class="quick-actions" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
        <a href="{{ route('admin.ecoles.create') }}" class="action-btn" 
           style="background: rgba(23,162,184,0.1); border: 1px solid rgba(23,162,184,0.3); color: #17a2b8; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(23,162,184,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-plus-circle" style="font-size: 1.5rem;"></i>
            Nouvelle École
        </a>
        
        <a href="{{ route('admin.membres.create') }}" class="action-btn" 
           style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(245,158,11,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-user-plus" style="font-size: 1.5rem;"></i>
            Nouveau Membre
        </a>
        
        <a href="{{ route('admin.cours.create') }}" class="action-btn" 
           style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.3); color: #8b5cf6; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(139,92,246,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-calendar-plus" style="font-size: 1.5rem;"></i>
            Nouveau Cours
        </a>
        
        <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="action-btn" 
           style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; position: relative; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(239,68,68,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-user-check" style="font-size: 1.5rem;"></i>
            Approbations
            @if($tachesEnAttente['membres_a_approuver'] > 0)
            <span style="position: absolute; top: -0.5rem; right: -0.5rem; background: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 9999px; animation: pulse 2s infinite;">
                {{ $tachesEnAttente['membres_a_approuver'] }}
            </span>
            @endif
        </a>
        
        <!-- NOUVEAU BOUTON: Gérer les Écoles -->
        <a href="{{ route('admin.ecoles.index') }}" class="action-btn" 
           style="background: rgba(32,201,151,0.1); border: 1px solid rgba(32,201,151,0.3); color: #20c997; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(32,201,151,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-school" style="font-size: 1.5rem;"></i>
            Gérer les Écoles
        </a>
        
        <!-- Optionnel: Bouton pour voir les rapports -->
        <a href="{{ route('admin.rapports.presences') }}" class="action-btn" 
           style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.3); color: #3b82f6; padding: 1rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(59,130,246,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-chart-bar" style="font-size: 1.5rem;"></i>
            Rapports
        </a>
    </div>
</div>
@push('scripts')
<script>
// Effet hover sur les icônes des stats
document.querySelectorAll('.stat-card-modern').forEach(card => {
    const icon = card.querySelector('.stat-icon');
    card.addEventListener('mouseenter', () => {
        icon.style.transform = 'scale(1.1) rotate(5deg)';
    });
    card.addEventListener('mouseleave', () => {
        icon.style.transform = 'scale(1) rotate(0deg)';
    });
});

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
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
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

<style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

/* Effet glow au hover sur les valeurs */
.stat-card-modern:hover .stat-value {
    text-shadow: 
        0 0 20px rgba(255,255,255,0.5),
        0 2px 4px rgba(0,0,0,0.3);
}

/* Amélioration de la visibilité */
.content-card {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.content-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}
</style>
@endpush
@endsection
