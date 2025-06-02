@extends('layouts.admin')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
<style>
/* Fix pour éviter le chevauchement */
.dashboard-container {
    padding: 25px;
    max-width: 100%;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
}

/* Assurer que les cartes ne débordent pas */
.stat-card, .content-card {
    width: 100%;
    box-sizing: border-box;
}

@media (max-width: 768px) {
    .stats-grid,
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header avec infos école -->
    <div class="content-header mb-4">
        <h1 class="page-title">Tableau de bord - {{ auth()->user()->ecole->nom ?? 'Mon École' }}</h1>
        <nav class="breadcrumb">
            <span>{{ auth()->user()->ecole->ville ?? '' }}</span>
            <span>•</span>
            <span>{{ now()->format('d F Y') }}</span>
        </nav>
    </div>

    <!-- Stats principales de l'école -->
    <div class="stats-grid">
        <!-- Membres actifs de l'école -->
        <div class="stat-card cyan">
            <div class="stat-icon cyan">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['membres_actifs'] ?? 0 }}</div>
            <div class="stat-label">Membres actifs</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['nouveaux_ce_mois'] ?? 0 }} ce mois
            </div>
        </div>

        <!-- Cours actifs -->
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-value">{{ $stats['cours_actifs'] ?? 0 }}</div>
            <div class="stat-label">Cours actifs</div>
            <div class="stat-change">
                {{ $stats['sessions_semaine'] ?? 0 }} sessions/semaine
            </div>
        </div>

        <!-- Présences aujourd'hui -->
        <div class="stat-card orange">
            <div class="stat-icon orange">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['presences_jour'] ?? 0 }}</div>
            <div class="stat-label">Présences aujourd'hui</div>
            <div class="stat-change">
                Taux: {{ $stats['taux_presence'] ?? 0 }}%
            </div>
        </div>

        <!-- Inscriptions en attente -->
        <div class="stat-card pink">
            <div class="stat-icon pink">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $stats['inscriptions_attente'] ?? 0 }}</div>
            <div class="stat-label">En attente</div>
            <div class="stat-change">
                <a href="{{ route('admin.membres.index') }}?statut=en_attente" style="color: inherit;">
                    Voir les demandes
                </a>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="content-grid">
        <!-- Cours du jour -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-day card-icon"></i>
                    Cours d'aujourd'hui
                </h3>
                <span class="badge bg-info">{{ count($cours_jour ?? []) }}</span>
            </div>
            <div class="card-body">
                @forelse($cours_jour ?? [] as $cours)
                    <div class="cours-item mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-white mb-1">{{ $cours->nom }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clock"></i> {{ $cours->heure_debut }} - {{ $cours->heure_fin }}
                                    <span class="ms-3">
                                        <i class="fas fa-users"></i> {{ $cours->inscriptions_count ?? 0 }}/{{ $cours->places_max ?? '∞' }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('admin.presences.create') }}?cours_id={{ $cours->id }}" 
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-check"></i> Présences
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Aucun cours programmé aujourd'hui</p>
                @endforelse
            </div>
        </div>

        <!-- Dernières inscriptions -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus card-icon"></i>
                    Dernières inscriptions
                </h3>
                <a href="{{ route('admin.membres.index') }}" class="btn btn-sm btn-outline-info">
                    Voir tout
                </a>
            </div>
            <div class="card-body">
                @forelse($dernieres_inscriptions ?? [] as $membre)
                    <div class="membre-item mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-3">
                                {{ strtoupper(substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-white mb-0">{{ $membre->prenom }} {{ $membre->nom }}</h6>
                                <small class="text-muted">{{ $membre->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$membre->approuve)
                                <span class="badge bg-warning">En attente</span>
                            @else
                                <span class="badge bg-success">Approuvé</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Aucune nouvelle inscription</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="content-grid mt-4">
        <!-- Évolution des inscriptions -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line card-icon"></i>
                    Évolution des inscriptions
                </h3>
            </div>
            <div class="card-body">
                <canvas id="inscriptionsChart" height="300"></canvas>
            </div>
        </div>

        <!-- Répartition par ceinture -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-award card-icon"></i>
                    Répartition par ceinture
                </h3>
            </div>
            <div class="card-body">
                <canvas id="ceinturesChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="content-card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-bolt card-icon"></i>
                Actions rapides
            </h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Nouveau membre
                </a>
                <a href="{{ route('admin.presences.create') }}" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Prendre les présences
                </a>
                <a href="{{ route('admin.cours.create') }}" class="btn btn-info">
                    <i class="fas fa-plus-circle"></i> Créer un cours
                </a>
                <a href="{{ route('admin.inscriptions.create') }}" class="btn btn-warning">
                    <i class="fas fa-clipboard-list"></i> Nouvelle inscription
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Graphique des inscriptions
const inscriptionsCtx = document.getElementById('inscriptionsChart').getContext('2d');
new Chart(inscriptionsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chart_labels ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin']) !!},
        datasets: [{
            label: 'Nouvelles inscriptions',
            data: {!! json_encode($inscriptions_data ?? [12, 19, 15, 25, 22, 30]) !!},
            borderColor: '#20b9be',
            backgroundColor: 'rgba(32, 185, 190, 0.1)',
            tension: 0.4
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
                    color: 'rgba(255, 255, 255, 0.7)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: 'rgba(255, 255, 255, 0.7)'
                }
            }
        }
    }
});

// Graphique des ceintures
const ceinturesCtx = document.getElementById('ceinturesChart').getContext('2d');
new Chart(ceinturesCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ceintures_labels ?? ['Blanche', 'Jaune', 'Orange', 'Verte', 'Bleue', 'Marron', 'Noire']) !!},
        datasets: [{
            data: {!! json_encode($ceintures_data ?? [30, 25, 20, 15, 8, 2, 1]) !!},
            backgroundColor: [
                '#ffffff',
                '#ffd700',
                '#ff9800',
                '#4caf50',
                '#2196f3',
                '#795548',
                '#000000'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    color: 'rgba(255, 255, 255, 0.8)'
                }
            }
        }
    }
});
</script>
@endpush

<style>
/* Styles additionnels */
.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #20b9be, #4caf50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.cours-item {
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.membre-item {
    padding: 10px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.membre-item:hover {
    background: rgba(255, 255, 255, 0.05);
}
</style>
@endsection
