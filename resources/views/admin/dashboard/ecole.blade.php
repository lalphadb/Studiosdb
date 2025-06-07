@extends('layouts.admin')

@section('title', 'Dashboard École')

@section('content')
<div class="page-transition">
    <!-- Header Admin École -->
    <div class="dashboard-header">
        <div class="welcome-section">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="metric-icon success">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h1 class="welcome-title">{{ auth()->user()->ecole->nom ?? 'Mon École' }}</h1>
                    <p class="welcome-subtitle">
                        {{ Auth::user()->name }}
                        <span class="badge badge-success">Admin École</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats École Spécifiques -->
    <div class="metrics-grid">
        <!-- Mes Membres -->
        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['mes_membres'] ?? 0 }}</div>
                    <div class="metric-label">Mes Membres</div>
                    <div class="metric-change neutral">
                        <i class="fas fa-plus"></i>
                        À développer
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.membres.index') }}" class="btn btn-success btn-sm">Gérer</a>
        </div>

        <!-- Mes Cours -->
        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['mes_cours'] ?? 0 }}</div>
                    <div class="metric-label">Mes Cours</div>
                    <div class="metric-change neutral">
                        <i class="fas fa-calendar"></i>
                        Planifier
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.cours.index') }}" class="btn btn-primary btn-sm">Gérer</a>
        </div>

        <!-- Présences Semaine -->
        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon warning">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['presences_semaine'] ?? 0 }}</div>
                    <div class="metric-label">Présences</div>
                    <div class="metric-change positive">
                        <i class="fas fa-calendar-week"></i>
                        Cette semaine
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.presences.index') }}" class="btn btn-warning btn-sm">Voir</a>
        </div>

        <!-- Inscriptions -->
        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon danger">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['inscriptions_mois'] ?? 0 }}</div>
                    <div class="metric-label">Inscriptions</div>
                    <div class="metric-change positive">
                        <i class="fas fa-calendar-alt"></i>
                        Ce mois
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-danger btn-sm">Gérer</a>
        </div>
    </div>

    <!-- Actions Rapides École -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-bolt"></i>
                Gestion Rapide
            </h2>
        </div>
        
        <div class="quick-actions-grid">
            <!-- Mes Membres -->
            <a href="{{ route('admin.membres.index') }}" class="quick-action-card">
                <div class="quick-action-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Mes Membres</h3>
                    <p>Gérer les membres de votre école</p>
                    <div class="quick-action-stats">
                        <span class="badge badge-success">{{ $stats['mes_membres'] ?? 0 }} membres</span>
                    </div>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>

            <!-- Mes Cours -->
            <a href="{{ route('admin.cours.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Mes Cours</h3>
                    <p>Planifier et gérer vos cours</p>
                    <div class="quick-action-stats">
                        <span class="badge badge-primary">{{ $stats['mes_cours'] ?? 0 }} cours</span>
                    </div>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>

            <!-- Présences -->
            <a href="{{ route('admin.presences.index') }}" class="quick-action-card">
                <div class="quick-action-icon warning">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Présences</h3>
                    <p>Prendre les présences des cours</p>
                    <div class="quick-action-stats">
                        <span class="badge badge-warning">Aujourd'hui</span>
                    </div>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>

            <!-- Ceintures -->
            <a href="{{ route('admin.ceintures.index') }}" class="quick-action-card">
                <div class="quick-action-icon danger">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Ceintures</h3>
                    <p>Gérer les grades et promotions</p>
                    <div class="quick-action-stats">
                        <span class="badge badge-danger">Examens</span>
                    </div>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Activité Récente -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-clock"></i>
                Activité Récente
            </h2>
        </div>
        
        <div class="activity-list">
            @forelse($activites ?? [] as $activite)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-{{ $activite->icon ?? 'circle' }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $activite->titre }}</div>
                    <div class="activity-description">{{ $activite->description }}</div>
                    <div class="activity-time">{{ $activite->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="empty-state-title">Aucune activité récente</div>
                <div class="empty-state-text">Les activités de votre école apparaîtront ici</div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
