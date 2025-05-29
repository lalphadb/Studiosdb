@extends('layouts.admin')

@section('title', 'Gestion des écoles')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">Gestion des écoles</h1>
            <p class="text-muted">{{ $ecoles->total() }} école(s) au total</p>
        </div>
        <div>
            <a href="{{ route('admin.ecoles.create') }}" class="btn btn-glass-ultimate">
                <i class="fas fa-plus me-2"></i>Nouvelle école
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="content-section-ultimate mb-4">
        <form method="GET" action="{{ route('admin.ecoles.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="search" class="form-label text-white">Rechercher</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nom, ville, responsable...">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="ville" class="form-label text-white">Ville</label>
                    <input type="text" 
                           class="form-control" 
                           id="ville" 
                           name="ville" 
                           value="{{ request('ville') }}"
                           placeholder="Filtrer par ville...">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="active" class="form-label text-white">Statut</label>
                    <select class="form-control" id="active" name="active">
                        <option value="">Toutes les écoles</option>
                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Actives</option>
                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactives</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des écoles -->
    <div class="content-section-ultimate">
        @if($ecoles->count() > 0)
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>École</th>
                            <th>Localisation</th>
                            <th>Contact</th>
                            <th>Responsable</th>
                            <th>Statut</th>
                            <th>Membres</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ecoles as $ecole)
                        <tr>
                            <td>
                                <div>
                                    <strong class="text-white">{{ $ecole->nom }}</strong>
                                    @if($ecole->adresse)
                                        <br><small class="text-muted">{{ $ecole->adresse }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-white">
                                    @if($ecole->ville)
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $ecole->ville }}
                                    @endif
                                    @if($ecole->province)
                                        <br><small class="text-muted">{{ $ecole->province }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-white">
                                    @if($ecole->telephone)
                                        <div><i class="fas fa-phone me-1"></i>{{ $ecole->telephone }}</div>
                                    @endif
                                    @if($ecole->email)
                                        <div><i class="fas fa-envelope me-1"></i>{{ $ecole->email }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-white">{{ $ecole->responsable ?? 'Non assigné' }}</span>
                            </td>
                            <td>
                                @if($ecole->active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $ecole->membres_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.ecoles.show', $ecole) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ecoles.edit', $ecole) }}" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(auth()->user()->role === 'superadmin')
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-{{ $ecole->active ? 'secondary' : 'success' }}" 
                                            title="{{ $ecole->active ? 'Désactiver' : 'Activer' }}"
                                            onclick="toggleStatus({{ $ecole->id }}, '{{ $ecole->nom }}', {{ $ecole->active ? 'false' : 'true' }})">
                                        <i class="fas fa-{{ $ecole->active ? 'pause' : 'play' }}"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination corrigée -->
            @if($ecoles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Pagination des écoles">
                    {{ $ecoles->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-school fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Aucune école trouvée</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'ville', 'active']))
                        Aucune école ne correspond à vos critères de recherche.
                    @else
                        Commencez par ajouter votre première école.
                    @endif
                </p>
                <a href="{{ route('admin.ecoles.create') }}" class="btn btn-glass-ultimate">
                    <i class="fas fa-plus me-2"></i>Ajouter une école
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
