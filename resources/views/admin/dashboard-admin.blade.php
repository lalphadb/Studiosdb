@extends('layouts.admin')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/aurora-grey-theme.css') }}">
@endpush

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header avec info école -->
    <div class="aurora-card mb-6 fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ $ecole->nom }}</h1>
                <p class="text-secondary flex items-center gap-3">
                    <span><i class="fas fa-map-marker-alt mr-2"></i>{{ $ecole->ville }}, {{ $ecole->province }}</span>
                    <span class="text-white/30">•</span>
                    <span><i class="fas fa-calendar mr-2"></i>{{ now()->format('l, d F Y') }}</span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-muted mb-1">Responsable</p>
                <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
    <!-- Alerte membres en attente -->
    @if($stats['membres_en_attente'] > 0)
    <div class="aurora-card border-yellow-500/30 bg-yellow-500/5 mb-6 fade-in-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center animate-pulse">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-white">Action requise</h4>
                    <p class="text-sm text-secondary">{{ $stats['membres_en_attente'] }} membre(s) en attente d'approbation</p>
                </div>
            </div>
            <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="btn-aurora">
                Examiner maintenant
            </a>
        </div>
    </div>
    @endif

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-in">
        <!-- Total Membres -->
        <div class="stat-card">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-muted text-sm mb-1">Total Membres</p>
                    <h3 class="text-3xl font-bold text-white">{{ $stats['total_membres'] }}</h3>
                    <p class="text-green-400 text-sm mt-1">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $stats['membres_actifs'] }} actifs
                    </p>
                </div>
                <div class="icon-aurora">
                    <i class="fas fa-users text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.membres.index') }}" class="text-sm text-green-400 hover:text-green-300 transition-colors">
                    Voir tous les membres <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Total Cours -->
        <div class="stat-card">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-muted text-sm mb-1">Total Cours</p>
                    <h3 class="text-3xl font-bold text-white">{{ $stats['cours_actifs'] }}</h3>
                    <p class="text-blue-400 text-sm mt-1">
                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                        Actifs
                    </p>
                </div>
                <div class="icon-aurora">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.cours.index') }}" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                    Gérer les cours <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Présences/Semaine -->
        <div class="stat-card">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-muted text-sm mb-1">Présences/Semaine</p>
                    <h3 class="text-3xl font-bold text-white">{{ $stats['sessions_semaine'] ?? 0 }}</h3>
                    <p class="text-purple-400 text-sm mt-1">
                        <i class="fas fa-calendar-check mr-1"></i>
                        Sessions à venir
                    </p>
                </div>
                <div class="icon-aurora">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.presences.index') }}" class="text-sm text-purple-400 hover:text-purple-300 transition-colors">
                    Voir les présences <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Nouveaux ce mois -->
        <div class="stat-card">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-muted text-sm mb-1">Nouveaux ce mois</p>
                    <h3 class="text-3xl font-bold text-white">{{ $stats['nouveaux_membres_mois'] }}</h3>
                    <p class="text-pink-400 text-sm mt-1">
                        <i class="fas fa-user-plus mr-1"></i>
                        {{ now()->format('F Y') }}
                    </p>
                </div>
                <div class="icon-aurora">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.membres.index', ['date' => 'this_month']) }}" class="text-sm text-pink-400 hover:text-pink-300 transition-colors">
                    Voir les nouveaux <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 stagger-in">
        <a href="{{ route('admin.membres.create') }}" class="quick-action">
            <i class="fas fa-user-plus text-green-400"></i>
            <span class="font-semibold">Nouveau membre</span>
        </a>
        
        <a href="{{ route('admin.presences.create') }}" class="quick-action">
            <i class="fas fa-check-circle text-blue-400"></i>
            <span class="font-semibold">Prendre présences</span>
        </a>
        
        <a href="{{ route('admin.cours.create') }}" class="quick-action">
            <i class="fas fa-calendar-plus text-purple-400"></i>
            <span class="font-semibold">Créer un cours</span>
        </a>
        
        <a href="{{ route('admin.inscriptions.create') }}" class="quick-action">
            <i class="fas fa-clipboard-list text-orange-400"></i>
            <span class="font-semibold">Nouvelle inscription</span>
        </a>
    </div>

    <!-- Contenu principal en 2 colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Prochaines Sessions -->
        <div class="aurora-card">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-day text-blue-400 mr-3"></i>
                Prochaines Sessions
            </h3>
            
            @forelse($prochainesSessions ?? [] as $session)
            <div class="p-4 rounded-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-white/10 mb-3 hover:border-blue-500/30 transition-all group">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-white group-hover:text-blue-400 transition-colors">
                            {{ $session->cours->nom ?? 'Session' }}
                        </p>
                        <p class="text-sm text-muted mt-1">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $session->date_debut->format('d/m/Y') }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock mr-2"></i>
                            {{ $session->date_debut->format('H:i') }} - {{ $session->date_fin->format('H:i') }}
                        </p>
                    </div>
                    @if($session->date_debut->isToday())
                    <a href="{{ route('admin.presences.create', ['session_id' => $session->id]) }}" 
                       class="btn-aurora text-sm">
                        Présences
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fas fa-calendar-times text-3xl text-white/30"></i>
                </div>
                <p class="text-muted">Aucune session prévue</p>
            </div>
            @endforelse
        </div>

        <!-- Membres récents -->
        <div class="aurora-card">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-user-clock text-purple-400 mr-3"></i>
                Membres Récents
            </h3>
            
            @forelse($membresEnAttente ?? [] as $membre)
            <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-purple-500/10 to-pink-500/10 border border-white/10 mb-3 hover:border-purple-500/30 transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold">
                        {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-white">{{ $membre->prenom }} {{ $membre->nom }}</p>
                        <p class="text-sm text-muted">
                            @if(!$membre->approuve)
                                <span class="text-yellow-400"><i class="fas fa-exclamation-circle mr-1"></i>En attente</span>
                            @else
                                <i class="fas fa-calendar mr-1"></i>{{ $membre->created_at->format('d/m/Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.membres.show', $membre) }}" 
                   class="text-purple-400 hover:text-purple-300 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fas fa-user-check text-3xl text-white/30"></i>
                </div>
                <p class="text-muted">Aucun nouveau membre</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

