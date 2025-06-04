@extends('layouts.admin')

@section('title', 'Tableau de bord Super Admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-white">
        <i class="fas fa-chart-line"></i> Centre de Contrôle Global
    </h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $stats['total_ecoles'] }}</h3>
                    <p>Total Écoles</p>
                    <small class="text-success">{{ $stats['ecoles_actives'] }} actives</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $stats['total_membres'] }}</h3>
                    <p>Total Membres</p>
                    <small>{{ $stats['membres_approuves'] }} approuvés</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $stats['total_cours'] }}</h3>
                    <p>Total Cours</p>
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
                    <h5>Top 5 Écoles</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>École</th>
                                <th>Ville</th>
                                <th>Membres</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topEcoles as $ecole)
                            <tr>
                                <td>{{ $ecole->nom }}</td>
                                <td>{{ $ecole->ville }}</td>
                                <td><span class="badge bg-primary">{{ $ecole->membres_count }}</span></td>
                            </tr>
                            @endforeach
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
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-school"></i> Gérer les Écoles
                    </a>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-users"></i> Tous les Membres
                    </a>
                    <a href="{{ route('admin.rapports.index') }}" class="btn btn-info w-100">
                        <i class="fas fa-chart-bar"></i> Rapports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
