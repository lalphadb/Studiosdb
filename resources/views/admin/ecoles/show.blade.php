@extends('layouts.admin')

@section('title', $ecole->nom)

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-school me-2"></i>{{ $ecole->nom }}
            </h1>
            <p class="text-white-50 mb-0">{{ $ecole->adresse_complete }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.ecoles.edit', $ecole) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.ecoles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card gradient-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['membres_total'] }}</h3>
                    <p>Membres totaux</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-success">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['membres_actifs'] }}</h3>
                    <p>Membres actifs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-info">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['cours_total'] }}</h3>
                    <p>Cours totaux</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-warning">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['cours_actifs'] }}</h3>
                    <p>Cours actifs</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-md-6">
            <div class="glass-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Statut:</th>
                            <td>
                                <span class="badge bg-{{ $ecole->statut === 'active' ? 'success' : 'secondary' }}">
                                    {{ $ecole->statut === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Adresse:</th>
                            <td>{{ $ecole->adresse ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ville:</th>
                            <td>{{ $ecole->ville }}</td>
                        </tr>
                        <tr>
                            <th>Province:</th>
                            <td>{{ $ecole->province }}</td>
                        </tr>
                        <tr>
                            <th>Code postal:</th>
                            <td>{{ $ecole->code_postal ?? '-' }}</td>
                        </tr>
                        <tr>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coordonnées -->
        <div class="col-md-6">
            <div class="glass-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Coordonnées</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Téléphone:</th>
                            <td>
                                @if($ecole->telephone)
                                    <a href="tel:{{ $ecole->telephone }}">{{ $ecole->telephone }}</a>
                                @else
                                    <span class="text-muted">Non renseigné</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Courriel:</th>
                            <td>
                                @if($ecole->email)
                                    <a href="mailto:{{ $ecole->email }}">{{ $ecole->email }}</a>
                                @else
                                    <span class="text-muted">Non renseigné</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Créée le:</th>
                            <td>{{ $ecole->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Dernière mise à jour:</th>
                            <td>{{ $ecole->updated_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="glass-card">
        <div class="card-header">
            <h5 class="mb-0">Actions rapides</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-primary w-100">
                        <i class="fas fa-user-plus me-2"></i>
                        Ajouter un membre
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-info w-100">
                        <i class="fas fa-book-open me-2"></i>
                        Créer un cours
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-success w-100">
                        <i class="fas fa-users me-2"></i>
                        Voir les membres
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-warning w-100">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistiques détaillées
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
