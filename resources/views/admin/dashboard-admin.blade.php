@extends('layouts.admin')

@section('title', 'Tableau de bord Admin École')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-white">
        <i class="fas fa-school"></i> Tableau de bord - {{ Auth::user()->ecole->nom ?? 'École' }}
    </h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $stats['total_membres'] }}</h3>
                    <p>Total Membres</p>
                    <small>{{ $stats['membres_actifs'] }} actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $stats['total_cours'] }}</h3>
                    <p>Total Cours</p>
                    <small>{{ $stats['cours_actifs'] }} actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $stats['presences_semaine'] }}</h3>
                    <p>Présences/Semaine</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $stats['nouveaux_membres_mois'] }}</h3>
                    <p>Nouveaux ce mois</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card">
                <div class="card-header">
                    <h5>Prochaines Sessions</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cours</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prochainesSessions as $session)
                            <tr>
                                <td>{{ $session->nom }}</td>
                                <td>{{ $session->date_debut->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.presences.create', ['session' => $session->id]) }}" class="btn btn-sm btn-primary">
                                        Présences
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucune session prévue</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card">
                <div class="card-header">
                    <h5>Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.membres.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-user-plus"></i> Nouveau Membre
                    </a>
                    <a href="{{ route('admin.cours.create') }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-calendar-plus"></i> Nouveau Cours
                    </a>
                    @if($taches['membres_a_approuver'] > 0)
                    <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="btn btn-danger w-100">
                        <i class="fas fa-user-check"></i> Approbations ({{ $taches['membres_a_approuver'] }})
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
