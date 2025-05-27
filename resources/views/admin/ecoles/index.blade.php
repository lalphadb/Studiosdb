@extends('layouts.admin')

@section('title', 'Gestion des Écoles')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #ffffff;">
                <i class="fas fa-school text-primary me-2"></i>
                Gestion des Écoles
            </h1>
            <p class="text-light mb-0">{{ $ecoles->total() }} école(s) au total</p>
        </div>
        
        @if(auth()->user()->role === 'superadmin')
        <div>
            <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Nouvelle École
            </a>
        </div>
        @endif
    </div>

    <!-- Filtres et recherche -->
    <div class="card mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ecoles.index') }}" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control"
                               style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                               placeholder="Rechercher par nom, ville..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <select name="statut" class="form-select" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;">
                        <option value="">Tous les statuts</option>
                        <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i>
                        Filtrer
                    </button>
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-outline-light">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
    <div class="alert alert-success" style="background: rgba(72, 187, 120, 0.2); border: 1px solid rgba(72, 187, 120, 0.3); color: #ffffff;">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.3); color: #ffffff;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Grille des écoles -->
    <div class="row">
        @forelse($ecoles as $ecole)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body">
                    <!-- En-tête avec statut -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #667eea 0%, #764ba2 100%); border-radius: 50%;">
                            <i class="fas fa-school text-white"></i>
                        </div>
                        <div class="text-end">
                            @if($ecole->active)
                            <span class="badge bg-success">Actif</span>
                            @else
                            <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Informations école -->
                    <h5 class="card-title text-truncate mb-2" style="color: #ffffff;">
                        {{ $ecole->nom }}
                    </h5>
                    
                    <div class="text-light small mb-3">
                        @if($ecole->ville)
                        <div class="mb-1">
                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                            {{ $ecole->ville }}{{ $ecole->province ? ', ' . $ecole->province : '' }}
                        </div>
                        @endif
                        
                        @if($ecole->responsable)
                        <div class="mb-1">
                            <i class="fas fa-user me-1 text-primary"></i>
                            {{ $ecole->responsable }}
                        </div>
                        @endif
                        
                        @if($ecole->telephone)
                        <div class="mb-1">
                            <i class="fas fa-phone me-1 text-primary"></i>
                            {{ $ecole->telephone }}
                        </div>
                        @endif
                    </div>

                    <!-- Statistiques -->
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="small text-light">Membres</div>
                            <div class="h6 mb-0 text-white">{{ $ecole->membres_count ?? 0 }}</div>
                        </div>
                        <div class="col-4">
                            <div class="small text-light">Sessions</div>
                            <div class="h6 mb-0 text-primary">{{ $ecole->cours_sessions_count ?? 0 }}</div>
                        </div>
                        <div class="col-4">
                            <div class="small text-light">Cours</div>
                            <div class="h6 mb-0 text-info">{{ $ecole->cours_count ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.ecoles.show', $ecole) }}" 
                           class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>
                            Voir
                        </a>
                        
                        @if(auth()->user()->role === 'superadmin' || auth()->user()->ecole_id === $ecole->id)
                        <a href="{{ route('admin.ecoles.edit', $ecole) }}" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        
                        @if(auth()->user()->role === 'superadmin')
                        <form method="POST" 
                              action="{{ route('admin.ecoles.toggle-status', $ecole) }}" 
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="btn btn-outline-{{ $ecole->active ? 'warning' : 'success' }} btn-sm"
                                    title="{{ $ecole->active ? 'Désactiver' : 'Activer' }}">
                                <i class="fas fa-{{ $ecole->active ? 'pause' : 'play' }}"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-school fa-3x text-primary mb-3"></i>
                <h5 class="text-light">Aucune école trouvée</h5>
                <p class="text-light">
                    @if(request('search') || request('statut'))
                        Essayez de modifier vos critères de recherche.
                    @else
                        Commencez par créer votre première école.
                    @endif
                </p>
                @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Créer une école
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($ecoles->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav>
            {{ $ecoles->appends(request()->query())->links() }}
        </nav>
    </div>
    @endif
</div>

<style>
/* Correction styles pagination */
.pagination .page-link {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.2);
    color: #ffffff;
}
.pagination .page-link:hover {
    background: rgba(255,255,255,0.2);
    color: #ffffff;
}
.pagination .page-item.active .page-link {
    background: #667eea;
    border-color: #667eea;
}
</style>
@endsection
