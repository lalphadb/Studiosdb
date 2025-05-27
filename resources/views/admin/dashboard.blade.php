@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<!-- Welcome Hero Section -->
<div class="welcome-hero">
    <div class="welcome-content d-flex justify-content-between align-items-center">
        <div>
            <h1 class="welcome-title">Bonjour {{ auth()->user()->name }} ! 👋</h1>
            <p class="welcome-subtitle">Vue d'ensemble de votre système de gestion - Studios Unis</p>
        </div>
        <div class="welcome-date-section">
            <div class="date-display">{{ now()->format('d') }}</div>
            <div class="date-info">{{ now()->locale('fr')->format('M Y') }}</div>
            <div class="time-info">Dernière mise à jour: {{ now()->format('H:i') }}</div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Membres inscrits -->
    <div class="stat-card-ultimate">
        <div class="card-header-ultimate">
            <div class="card-icon-ultimate icon-primary-ultimate">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content-ultimate">
                <h4 class="card-number-ultimate">{{ $stats['total_membres'] ?? 1 }}</h4>
                <p class="card-label-ultimate">Membres inscrits</p>
            </div>
        </div>
        <div class="card-footer-ultimate">
            <a href="{{ route('admin.membres.index') }}" class="card-link-ultimate">
                Voir tous les membres
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Présences aujourd'hui -->
    <div class="stat-card-ultimate">
        <div class="card-header-ultimate">
            <div class="card-icon-ultimate icon-success-ultimate">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-content-ultimate">
                <h4 class="card-number-ultimate">{{ $stats['presences_aujourdhui'] ?? 0 }}</h4>
                <p class="card-label-ultimate">Présences aujourd'hui</p>
            </div>
        </div>
        <div class="card-footer-ultimate">
            <a href="{{ route('admin.presences.index') }}" class="card-link-ultimate">
                Gérer les présences
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Membres en attente -->
    <div class="stat-card-ultimate">
        <div class="card-header-ultimate">
            <div class="card-icon-ultimate icon-warning-ultimate">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-content-ultimate">
                <h4 class="card-number-ultimate">{{ $stats['membres_en_attente'] ?? 0 }}</h4>
                <p class="card-label-ultimate">Membres en attente</p>
            </div>
        </div>
        <div class="card-footer-ultimate">
            <a href="{{ route('admin.membres.index', ['statut' => 'en_attente']) }}" class="card-link-ultimate">
                Voir les demandes
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Écoles actives -->
    <div class="stat-card-ultimate">
        <div class="card-header-ultimate">
            <div class="card-icon-ultimate icon-danger-ultimate">
                <i class="fas fa-building"></i>
            </div>
            <div class="card-content-ultimate">
                <h4 class="card-number-ultimate">{{ $stats['ecoles_actives'] ?? 44 }}</h4>
                <p class="card-label-ultimate">École(s) active(s)</p>
            </div>
        </div>
        <div class="card-footer-ultimate">
            <a href="{{ route('admin.ecoles.index') }}" class="card-link-ultimate">
                Gérer les écoles
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Section Derniers Membres -->
<div class="content-section-ultimate">
    <h3 class="section-title-ultimate">
        <i class="fas fa-users"></i>
        Derniers membres inscrits
    </h3>
    
    <!-- Données de test -->
    <div class="table-responsive">
        <table class="table-glass-ultimate">
            <thead>
                <tr>
                    <th>MEMBRE</th>
                    <th>CONTACT</th>
                    <th>ÉCOLE</th>
                    <th>STATUT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="card-icon-ultimate icon-primary-ultimate me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <strong>Marc Doucet</strong><br>
                                <small style="color: rgba(255,255,255,0.7);">Inscrit récemment</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        test@test.com<br>
                        <small style="color: rgba(255,255,255,0.7);">418-555-0123</small>
                    </td>
                    <td>
                        <span class="badge-info-ultimate">St-Émile</span>
                    </td>
                    <td>
                        <span class="badge-success-ultimate">
                            <i class="fas fa-check"></i>
                            Approuvé
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Section Sessions Récentes -->
<div class="content-section-ultimate">
    <h3 class="section-title-ultimate">
        <i class="fas fa-calendar"></i>
        Sessions de cours récentes
    </h3>
    
    <div class="text-center py-5">
        <div class="card-icon-ultimate icon-success-ultimate mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h4 style="color: white;">Aucune session récente</h4>
        <p style="color: rgba(255, 255, 255, 0.7);">Aucune session de cours récente trouvée</p>
    </div>
</div>
@endsection
