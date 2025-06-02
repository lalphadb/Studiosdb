@extends('layouts.modern-admin')

@section('title', 'Tableau de bord')

@section('content')
<!-- Header -->
<div class="dashboard-header">
    <h1 class="dashboard-title">
        <i class="fa fa-chart-line" style="margin-right: 0.5rem;"></i>
        Tableau de bord
    </h1>
    <p class="dashboard-subtitle">Vue d'ensemble de votre système de gestion - Studios Unis</p>
    <div class="date-info">
        <i class="fa fa-calendar"></i>
        <span>{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
        <span style="margin-left: 1rem;">
            <i class="fa fa-clock"></i>
            Dernière mise à jour: {{ now()->format('H:i') }}
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <!-- Membres inscrits -->
    <div class="stat-card blue">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_membres'] ?? 11 }}</div>
                <div class="stat-label">Membres inscrits</div>
            </div>
            <div class="stat-icon blue">
                <i class="fa fa-users"></i>
            </div>
        </div>
        <a href="{{ route('admin.membres.index') }}" class="stat-link">
            Voir tous les membres <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Présences -->
    <div class="stat-card green">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['presences_jour'] ?? 0 }}</div>
                <div class="stat-label">Présences aujourd'hui</div>
            </div>
            <div class="stat-icon green">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
        <a href="{{ route('admin.presences.index') }}" class="stat-link">
            Gérer les présences <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Membres en attente -->
    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['membres_en_attente'] ?? 0 }}</div>
                <div class="stat-label">Membres en attente</div>
            </div>
            <div class="stat-icon orange">
                <i class="fa fa-user-clock"></i>
            </div>
        </div>
        <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="stat-link">
            Voir les demandes <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Écoles actives -->
    <div class="stat-card red">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_ecoles'] ?? 22 }}</div>
                <div class="stat-label">École(s) active(s)</div>
            </div>
            <div class="stat-icon red">
                <i class="fa fa-school"></i>
            </div>
        </div>
        <a href="{{ route('admin.ecoles.index') }}" class="stat-link">
            Gérer les écoles <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Derniers membres -->
    <div class="content-card">
        <div class="content-header">
            <i class="fa fa-user-plus" style="color: var(--accent-blue);"></i>
            <h2 class="content-title">Derniers membres inscrits</h2>
        </div>
        
        @if(isset($derniers_membres) && $derniers_membres->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>MEMBRE</th>
                    <th>CONTACT</th>
                    <th>ÉCOLE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($derniers_membres as $membre)
                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">
                                {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                            </div>
                            <div>
                                <div class="member-name">{{ $membre->prenom }} {{ $membre->nom }}</div>
                                <div class="member-date">Inscrit le {{ $membre->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $membre->email ?? 'test@test.com' }}</div>
                        <div class="member-date">{{ $membre->telephone ?? '418-555-0123' }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $membre->approuve ? 'active' : 'pending' }}">
                            {{ $membre->ecole->nom ?? 'École' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.membres.show', $membre) }}" class="btn-icon" title="Voir">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.membres.edit', $membre) }}" class="btn-icon" title="Modifier">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-users"></i></div>
            <p>Aucun membre inscrit récemment</p>
        </div>
        @endif
    </div>
    
    <!-- Sessions récentes -->
    <div class="content-card">
        <div class="content-header">
            <i class="fa fa-calendar-check" style="color: var(--accent-green);"></i>
            <h2 class="content-title">Sessions de cours récentes</h2>
        </div>
        
        @if(isset($sessions_recentes) && $sessions_recentes->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>SESSION</th>
                    <th>PARTICIPANTS</th>
                    <th>STATUT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions_recentes as $session)
                <tr>
                    <td>
                        <div>
                            <div class="member-name">{{ $session->cours->nom ?? 'Session' }}</div>
                            <div class="member-date">{{ $session->date_debut->format('d/m/Y H:i') }}</div>
                        </div>
                    </td>
                    <td>{{ $session->inscriptions_count ?? 0 }}/{{ $session->places_max ?? 30 }}</td>
                    <td>
                        <span class="badge active">Actif</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-calendar"></i></div>
            <p>Aucune session de cours récente trouvée</p>
        </div>
        @endif
    </div>
</div>
@endsection
