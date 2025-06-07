@extends('layouts.admin')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="page-transition">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header">
        <div class="welcome-section">
            <h1 class="welcome-title">Bonjour, {{ auth()->user()->name }} 👑</h1>
            <p class="welcome-subtitle">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="quick-stats">
            <div class="quick-stat-item">
                <span class="quick-stat-number">{{ $stats['total_ecoles'] ?? 0 }}</span>
                <span class="quick-stat-label">Écoles</span>
            </div>
            <div class="quick-stat-item">
                <span class="quick-stat-number">{{ $stats['total_users'] ?? 0 }}</span>
                <span class="quick-stat-label">Utilisateurs</span>
            </div>
        </div>
    </div>

    <!-- Métriques principales -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['total_ecoles'] ?? 0 }}</div>
                    <div class="metric-label">Écoles Studios Unis</div>
                    <div class="metric-change positive">
                        <i class="fas fa-arrow-up"></i>
                        {{ $stats['ecoles_actives'] ?? 0 }} actives
                    </div>
                </div>
            </div>
            <div class="metric-action">
                <a href="{{ route('admin.ecoles.index') }}" class="btn btn-secondary btn-sm">Gérer</a>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon success">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['admins_ecole'] ?? 0 }}</div>
                    <div class="metric-label">Admins d'École</div>
                    <div class="metric-change neutral">
                        <i class="fas fa-users"></i>
                        Gestion décentralisée
                    </div>
                </div>
            </div>
            <div class="metric-action">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['total_membres'] ?? 0 }}</div>
                    <div class="metric-label">Membres Total</div>
                    <div class="metric-change positive">
                        <i class="fas fa-globe"></i>
                        Réseau entier
                    </div>
                </div>
            </div>
            <div class="metric-action">
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary btn-sm">Détails</a>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-card-content">
                <div class="metric-icon danger">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="metric-details">
                    <div class="metric-number">{{ $stats['croissance_mois'] ?? '+0' }}%</div>
                    <div class="metric-label">Croissance</div>
                    <div class="metric-change positive">
                        <i class="fas fa-calendar"></i>
                        Ce mois
                    </div>
                </div>
            </div>
            <div class="metric-action">
                <a href="{{ route('admin.rapports.index') }}" class="btn btn-secondary btn-sm">Rapports</a>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="dashboard-main">
        <!-- Écoles par région -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Écoles par Région
                </h2>
                <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouvelle École
                </a>
            </div>
            
            <div class="schools-grid">
                @foreach($ecoles->groupBy('province') as $province => $ecolesProvince)
                <div class="province-card">
                    <div class="province-header">
                        <h3>{{ $province ?: 'Non spécifié' }}</h3>
                        <span class="badge badge-primary">{{ $ecolesProvince->count() }} école(s)</span>
                    </div>
                    
                    <div class="schools-list">
                        @foreach($ecolesProvince->take(5) as $ecole)
                        <div class="school-item">
                            <div class="school-info">
                                <div class="school-name">{{ $ecole->nom }}</div>
                                <div class="school-location">{{ $ecole->ville }}</div>
                            </div>
                            <div class="school-stats">
                                <span class="stat-item">
                                    <i class="fas fa-users"></i>
                                    {{ $ecole->membres_count ?? 0 }}
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-graduation-cap"></i>
                                    {{ $ecole->cours_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($ecolesProvince->count() > 5)
                        <div class="school-item">
                            <div class="school-more">
                                <a href="{{ route('admin.ecoles.index', ['province' => $province]) }}" class="btn btn-secondary btn-sm">
                                    Voir {{ $ecolesProvince->count() - 5 }} de plus
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                
                @if($ecoles->groupBy('province')->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="empty-state-title">Aucune école configurée</div>
                    <div class="empty-state-text">Commencez par ajouter votre première école Studios Unis</div>
                    <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Créer une École
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Admins d'école récents -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-user-plus"></i>
                    Nouveaux Administrateurs
                </h2>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i>
                    Ajouter Admin
                </a>
            </div>
            
            <div class="admins-list">
                @forelse($nouveauxAdmins ?? [] as $admin)
                <div class="admin-card">
                    <div class="admin-avatar">
                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                    </div>
                    <div class="admin-info">
                        <h4 class="admin-name">{{ $admin->name }}</h4>
                        <p class="admin-ecole">{{ $admin->ecole->nom ?? 'Aucune école assignée' }}</p>
                        <span class="admin-date">Ajouté {{ $admin->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="admin-actions">
                        <a href="{{ route('admin.users.edit', $admin) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="empty-state-title">Aucun nouvel administrateur</div>
                    <div class="empty-state-text">Les nouveaux administrateurs apparaîtront ici</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
