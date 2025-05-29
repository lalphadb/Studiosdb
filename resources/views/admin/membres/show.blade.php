@extends('layouts.admin')

@section('title', 'Détails du membre')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Détails du membre</h1>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.membres.index') }}">Membres</a></li>
                    <li class="breadcrumb-item active">{{ $membre->nom_complet }}</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-glass-ultimate">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            @if(auth()->user()->role === 'superadmin')
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash me-2"></i>Supprimer
            </button>
            @endif
        </div>
    </div>

    <!-- Statut d'approbation -->
    <div class="row mb-4">
        <div class="col-12">
            @if($membre->approuve)
                <div class="alert alert-glass-ultimate alert-success d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fs-4"></i>
                    <div>
                        <h6 class="mb-1">Membre approuvé</h6>
                        <small>Ce membre est approuvé et peut participer aux cours.</small>
                    </div>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->ecole_id === $membre->ecole_id)
                    <form method="POST" action="{{ route('admin.membres.toggle-approbation', $membre) }}" class="ms-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-times me-1"></i>Désapprouver
                        </button>
                    </form>
                    @endif
                </div>
            @else
                <div class="alert alert-glass-ultimate alert-warning d-flex align-items-center">
                    <i class="fas fa-clock me-3 fs-4"></i>
                    <div>
                        <h6 class="mb-1">En attente d'approbation</h6>
                        <small>Ce membre doit être approuvé avant de pouvoir participer aux cours.</small>
                    </div>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->ecole_id === $membre->ecole_id)
                    <form method="POST" action="{{ route('admin.membres.toggle-approbation', $membre) }}" class="ms-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check me-1"></i>Approuver
                        </button>
                    </form>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Informations principales -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="stat-card-ultimate h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle-ultimate bg-primary me-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <h5 class="mb-0">Informations personnelles</h5>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">NOM COMPLET</label>
                        <div class="text-white">
                            {{ $membre->nom_complet }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">EMAIL</label>
                        <div class="text-white">
                            @if($membre->email)
                                <a href="mailto:{{ $membre->email }}" class="text-primary text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $membre->email }}
                                </a>
                            @else
                                <span class="text-muted">Non renseigné</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">TÉLÉPHONE</label>
                        <div class="text-white">
                            @if($membre->telephone)
                                <a href="tel:{{ $membre->telephone }}" class="text-primary text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $membre->telephone }}
                                </a>
                            @else
                                <span class="text-muted">Non renseigné</span>
                            @endif
                        </div>
                    </div>

                    @if($membre->date_naissance)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">ÂGE</label>
                        <div class="text-white">
                            {{ $membre->age }} ans
                            <small class="text-muted">({{ $membre->date_naissance->format('d/m/Y') }})</small>
                        </div>
                    </div>
                    @endif

                    @if($membre->sexe)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">SEXE</label>
                        <div class="text-white">
                            {{ $membre->sexe === 'H' ? 'Homme' : 'Femme' }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="stat-card-ultimate h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle-ultimate bg-info me-3">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <h5 class="mb-0">Adresse</h5>
                    </div>

                    @if($membre->numero_rue || $membre->nom_rue)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">ADRESSE</label>
                        <div class="text-white">
                            {{ $membre->numero_rue }} {{ $membre->nom_rue }}
                        </div>
                    </div>
                    @endif

                    @if($membre->ville)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">VILLE</label>
                        <div class="text-white">{{ $membre->ville }}</div>
                    </div>
                    @endif

                    @if($membre->province)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">PROVINCE</label>
                        <div class="text-white">{{ $membre->province }}</div>
                    </div>
                    @endif

                    @if($membre->code_postal)
                    <div class="mb-3">
                        <label class="text-light small fw-bold">CODE POSTAL</label>
                        <div class="text-white">{{ $membre->code_postal }}</div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-light small fw-bold">ÉCOLE</label>
                        <div class="text-white">
                            <a href="{{ route('admin.ecoles.show', $membre->ecole) }}" class="text-primary text-decoration-none">
                                <i class="fas fa-school me-1"></i>{{ $membre->ecole->nom }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="stat-card-ultimate h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle-ultimate bg-success me-3">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <h5 class="mb-0">Statistiques</h5>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">COURS ACTIFS</label>
                        <div class="text-white fs-4 fw-bold">{{ $stats['coursInscrits'] }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">PRÉSENCES TOTALES</label>
                        <div class="text-white fs-4 fw-bold">{{ $stats['totalPresences'] }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-light small fw-bold">PRÉSENCES CE MOIS</label>
                        <div class="text-white fs-4 fw-bold">{{ $stats['presencesRecentes'] }}</div>
                    </div>

                    @if($stats['ceintureActuelle'])
                    <div class="mb-3">
                        <label class="text-light small fw-bold">CEINTURE ACTUELLE</label>
                        <div class="text-white">
                            <span class="badge badge-ceinture" style="background-color: {{ $stats['ceintureActuelle']->couleur ?? '#6c757d' }}">
                                {{ $stats['ceintureActuelle']->nom }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cours actifs -->
    @if($coursActifs->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-section-ultimate">
                <h5 class="mb-4">
                    <i class="fas fa-graduation-cap me-2"></i>Cours actifs ({{ $coursActifs->count() }})
                </h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Cours</th>
                                <th>École</th>
                                <th>Niveau</th>
                                <th>Instructeur</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coursActifs as $cours)
                            <tr>
                                <td>
                                    <strong>{{ $cours->nom }}</strong>
                                    @if($cours->description)
                                        <br><small class="text-muted">{{ Str::limit($cours->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $cours->ecole->nom }}</td>
                                <td>
                                    @if($cours->niveau)
                                        <span class="badge bg-info">{{ ucfirst($cours->niveau) }}</span>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                                <td>{{ $cours->instructeur ?? 'Non assigné' }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($cours->statut) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Présences récentes -->
    @if($presencesRecentes->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-section-ultimate">
                <h5 class="mb-4">
                    <i class="fas fa-calendar-check me-2"></i>Présences récentes
                </h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cours</th>
                                <th>Statut</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presencesRecentes as $presence)
                            <tr>
                                <td>{{ $presence->date_presence->format('d/m/Y') }}</td>
                                <td>{{ $presence->cours->nom }}</td>
                                <td>
                                    @if($presence->status === 'present')
                                        <span class="badge bg-success">Présent</span>
                                    @elseif($presence->status === 'absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @else
                                        <span class="badge bg-warning">Retard</span>
                                    @endif
                                </td>
                                <td>{{ $presence->commentaire ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal de suppression -->
@if(auth()->user()->role === 'superadmin')
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-white">
                <p>Êtes-vous sûr de vouloir supprimer le membre <strong>{{ $membre->nom_complet }}</strong> ?</p>
                <p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Cette action est irréversible !</p>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('admin.membres.destroy', $membre) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
