@extends('layouts.admin')

@section('title', 'Gestion des Membres')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4 fade-in">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-white">
                        <i class="fas fa-users me-2 text-primary"></i>Gestion des Membres
                    </h1>
                    <p class="text-light opacity-75 mb-0">Gérez les membres de votre école de karaté</p>
                </div>
                <a href="{{ route('admin.membres.create') }}" class="btn btn-glass-ultimate">
                    <i class="fas fa-plus me-2"></i>Nouveau Membre
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3 slide-up" style="animation-delay: 0.1s">
            <div class="stat-card-ultimate">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle-ultimate bg-primary me-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white">{{ $membres->total() ?? 0 }}</h3>
                            <p class="text-light opacity-75 mb-0">Total Membres</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 slide-up" style="animation-delay: 0.2s">
            <div class="stat-card-ultimate">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle-ultimate bg-success me-3">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white">{{ $membres->where('approuve', true)->count() }}</h3>
                            <p class="text-light opacity-75 mb-0">Approuvés</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 slide-up" style="animation-delay: 0.3s">
            <div class="stat-card-ultimate">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle-ultimate bg-warning me-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white">{{ $membres->where('approuve', false)->count() }}</h3>
                            <p class="text-light opacity-75 mb-0">En attente</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 slide-up" style="animation-delay: 0.4s">
            <div class="stat-card-ultimate">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle-ultimate bg-info me-3">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 text-white">{{ $membres->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            <p class="text-light opacity-75 mb-0">Ce mois</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et Recherche -->
    <div class="content-section-ultimate mb-4 slide-up" style="animation-delay: 0.5s">
        <div class="card-body p-4">
            <h5 class="text-white mb-3">
                <i class="fas fa-filter me-2"></i>Filtres et Recherche
            </h5>
            <form method="GET" action="{{ route('admin.membres.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label text-light">Rechercher</label>
                        <div class="input-group">
                            <input type="text" id="search" name="search" 
                                   class="form-control-glass" 
                                   placeholder="Nom, prénom, email..."
                                   value="{{ request('search') }}">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="fas fa-search text-light"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="ecole" class="form-label text-light">École</label>
                        <select id="ecole" name="ecole" class="form-control-glass">
                            <option value="">Toutes les écoles</option>
                            @foreach($ecoles as $ecole)
                                <option value="{{ $ecole->id }}" {{ request('ecole') == $ecole->id ? 'selected' : '' }}>
                                    {{ $ecole->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="statut" class="form-label text-light">Statut</label>
                        <select id="statut" name="statut" class="form-control-glass">
                            <option value="">Tous les statuts</option>
                            <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Approuvés</option>
                            <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>En attente</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label text-light">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-glass-ultimate flex-fill">
                                <i class="fas fa-search me-1"></i>Filtrer
                            </button>
                            <a href="{{ route('admin.membres.index') }}" class="btn btn-glass">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des Membres -->
    <div class="content-section-ultimate slide-up" style="animation-delay: 0.6s">
        <div class="card-body p-0">
            @if($membres->count() > 0)
            <div class="table-responsive">
                <table class="table table-glass-ultimate mb-0">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Contact</th>
                            <th>École</th>
                            <th>Statut</th>
                            <th>Inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($membres as $membre)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-glass-ultimate me-3">
                                        {{ strtoupper(substr($membre->prenom ?? 'N', 0, 1) . substr($membre->nom ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white">{{ $membre->prenom }} {{ $membre->nom }}</h6>
                                        @if($membre->date_naissance)
                                            <small class="text-light opacity-75">{{ $membre->age }} ans</small>
                                        @else
                                            <small class="text-light opacity-75">Âge non renseigné</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    @if($membre->email)
                                        <div class="contact-info-item">
                                            <i class="fas fa-envelope"></i>
                                            {{ $membre->email }}
                                        </div>
                                    @endif
                                    @if($membre->telephone)
                                        <div class="contact-info-item">
                                            <i class="fas fa-phone"></i>
                                            {{ $membre->telephone }}
                                        </div>
                                    @endif
                                    @if(!$membre->email && !$membre->telephone)
                                        <span class="text-light opacity-50">Non renseigné</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($membre->ecole)
                                    <span class="badge-glass-ultimate">
                                        {{ $membre->ecole->nom }}
                                    </span>
                                @else
                                    <span class="text-light opacity-50">Aucune école</span>
                                @endif
                            </td>
                            <td>
                                @if($membre->approuve)
                                    <span class="badge-glass-ultimate badge-status-approved">
                                        <i class="fas fa-check-circle me-1"></i>Approuvé
                                    </span>
                                @else
                                    <span class="badge-glass-ultimate badge-status-pending">
                                        <i class="fas fa-clock me-1"></i>En attente
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-light opacity-75">
                                    {{ $membre->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-glass" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-glass" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if(!$membre->approuve)
                                    <button class="btn btn-sm btn-glass-success" title="Approuver">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-glass-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($membres->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top border-light border-opacity-10">
                <div class="text-light opacity-75">
                    Affichage de {{ $membres->firstItem() }} à {{ $membres->lastItem() }} 
                    sur {{ $membres->total() }} membres
                </div>
                <div class="pagination-glass">
                    {{ $membres->links() }}
                </div>
            </div>
            @endif
            @else
            <div class="empty-state-glass">
                <i class="fas fa-users"></i>
                <h4>Aucun membre trouvé</h4>
                <p>Commencez par ajouter votre premier membre à l'école.</p>
                <a href="{{ route('admin.membres.create') }}" class="btn btn-glass-ultimate btn-lg">
                    <i class="fas fa-plus me-2"></i>Ajouter le premier membre
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
