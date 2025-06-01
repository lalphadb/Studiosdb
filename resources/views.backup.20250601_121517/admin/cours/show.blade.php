@extends('layouts.admin')

@section('title', 'Détails du Cours')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            @include('components.back-button', ['route' => route('cours.index')])
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1 class="h3 text-white mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>{{ $cours->nom }}
                </h1>
                <div class="btn-group">
                    <a href="{{ route('cours.edit', $cours) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <form action="{{ route('cours.toggle-status', $cours) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $cours->actif ? 'secondary' : 'success' }}">
                            <i class="fas fa-power-off me-2"></i>{{ $cours->actif ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.alerts')

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-4 mb-4">
            <div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05);">
                    <h5 class="mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">École :</dt>
                        <dd class="col-sm-7">{{ $cours->ecole->nom }}</dd>
                        
                        <dt class="col-sm-5">Session :</dt>
                        <dd class="col-sm-7">
                            @if($cours->session)
                                <span class="badge" style="background-color: {{ $cours->session->couleur }};">
                                    {{ $cours->session->nom }}
                                </span>
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-5">Période :</dt>
                        <dd class="col-sm-7">
                            {{ $cours->date_debut_format }}
                            @if($cours->date_fin)
                                au {{ $cours->date_fin_format }}
                            @endif
                        </dd>
                        
                        <dt class="col-sm-5">Places :</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-info">
                                {{ $inscriptions->count() }} / {{ $cours->places_max ?: '∞' }}
                            </span>
                            @if($cours->places_disponibles === 0)
                                <span class="badge bg-danger ms-2">Complet</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-5">Statut :</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-{{ $cours->actif ? 'success' : 'secondary' }}">
                                {{ $cours->actif ? 'Actif' : 'Inactif' }}
                            </span>
                        </dd>
                    </dl>
                    
                    @if($cours->description)
                    <hr class="text-white-50">
                    <h6>Description :</h6>
                    <p class="small mb-0">{{ $cours->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Horaires -->
        <div class="col-lg-4 mb-4">
            <div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05);">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Horaires</h5>
                </div>
                <div class="card-body">
                    @if($cours->horaires->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($cours->horaires as $horaire)
                                <div class="list-group-item bg-transparent text-white border-secondary">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>{{ ucfirst($horaire->jour) }}</strong>
                                        <span class="badge bg-info">
                                            {{ $horaire->heure_debut_format }} - {{ $horaire->heure_fin_format }}
                                        </span>
                                    </div>
                                    @if($horaire->salle)
                                        <small class="text-muted">Salle: {{ $horaire->salle }}</small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Aucun horaire défini</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tarification -->
        <div class="col-lg-4 mb-4">
            <div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05);">
                    <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Tarification</h5>
                </div>
                <div class="card-body">
                    @if($cours->tarification_info)
                        <p class="mb-0">{{ $cours->tarification_info }}</p>
                    @else
                        <p class="text-muted text-center mb-0">Aucune information de tarification</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Membres inscrits -->
    <div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-header" style="background: rgba(255,255,255,0.05);">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Membres inscrits ({{ $inscriptions->count() }})</h5>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                    <i class="fas fa-user-plus me-2"></i>Inscrire un membre
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($inscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscriptions as $inscription)
                            <tr>
                                <td>
                                    <a href="{{ route('membres.show', $inscription->membre) }}" 
                                       class="text-info text-decoration-none">
                                        {{ $inscription->membre->prenom }} {{ $inscription->membre->nom }}
                                    </a>
                                </td>
                                <td>{{ $inscription->membre->email }}</td>
                                <td>{{ $inscription->membre->telephone }}</td>
                                <td>{{ $inscription->date_inscription ? $inscription->date_inscription->format('d/m/Y') : 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="if(confirm('Retirer ce membre du cours?')) { document.getElementById('desinscription-{{ $inscription->id }}').submit(); }">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                    <form id="desinscription-{{ $inscription->id }}" 
                                          action="{{ route('inscriptions.destroy', $inscription) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4 mb-0">Aucun membre inscrit à ce cours</p>
            @endif
        </div>
    </div>
</div>
@endsection
