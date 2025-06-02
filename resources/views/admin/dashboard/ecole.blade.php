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
