@extends('layouts.admin')

@section('title', 'École - ' . $ecole->nom)

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #ffffff;">
                <i class="fas fa-school text-primary me-2"></i>
                {{ $ecole->nom }}
            </h1>
            <p class="text-light mb-0">
                <i class="fas fa-map-marker-alt me-1"></i>
                {{ $ecole->ville }}{{ $ecole->province ? ', ' . $ecole->province : '' }}
            </p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('ecoles.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>
                Retour à la liste
            </a>
            
            @if(auth()->user()->role === 'superadmin' || auth()->user()->ecole_id === $ecole->id)
            <a href="{{ route('ecoles.edit', $ecole) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Modifier
            </a>
            @endif
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
    <div class="alert alert-success" style="background: rgba(72, 187, 120, 0.2); border: 1px solid rgba(72, 187, 120, 0.3); color: #ffffff;">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header d-flex align-items-center" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    <h5 class="mb-0 text-white">Informations générales</h5>
                    <div class="ms-auto">
                        @if($ecole->active)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-pause-circle me-1"></i>
                            Inactif
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-light small fw-bold">NOM DE L'ÉCOLE</label>
                                <div class="text-white">{{ $ecole->nom }}</div>
                            </div>
                            
                            @if($ecole->adresse)
                            <div class="mb-3">
                                <label class="text-light small fw-bold">ADRESSE</label>
                                <div class="text-white">{{ $ecole->adresse }}</div>
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="text-light small fw-bold">VILLE / PROVINCE</label>
                                <div class="text-white">{{ $ecole->ville }}{{ $ecole->province ? ', ' . $ecole->province : '' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            @if($ecole->telephone)
                            <div class="mb-3">
                                <label class="text-light small fw-bold">TÉLÉPHONE</label>
                                <div class="text-white">
                                    <a href="tel:{{ $ecole->telephone }}" class="text-primary text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $ecole->telephone }}
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($ecole->email)
                            <div class="mb-3">
                                <label class="text-light small fw-bold">EMAIL</label>
                                <div class="text-white">
                                    <a href="mailto:{{ $ecole->email }}" class="text-primary text-decoration-none">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ $ecole->email }}
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($ecole->responsable)
                            <div class="mb-3">
                                <label class="text-light small fw-bold">RESPONSABLE</label>
                                <div class="text-white">
                                    <i class="fas fa-user-tie me-1 text-primary"></i>
                                    {{ $ecole->responsable }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="text-light small fw-bold">DATES</label>
                            <div class="text-light small">
                                <i class="fas fa-calendar-plus me-1 text-success"></i>
                                Créée le {{ $ecole->created_at->format('d/m/Y à H:i') }}
                                @if($ecole->updated_at && $ecole->updated_at != $ecole->created_at)
                                <span class="ms-3">
                                    <i class="fas fa-calendar-edit me-1 text-warning"></i>
                                    Modifiée le {{ $ecole->updated_at->format('d/m/Y à H:i') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="col-lg-4">
            <div class="card mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-chart-bar text-primary me-2"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Membres -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: rgba(72, 187, 120, 0.1); border-radius: 8px;">
                        <div>
                            <div class="text-light small">Membres Total</div>
                            <div class="h4 mb-0 text-white">{{ $stats['membres_total'] ?? 0 }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #48bb78, #38a169); border-radius: 50%;">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>

                    <!-- Membres Actifs -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: rgba(56, 178, 172, 0.1); border-radius: 8px;">
                        <div>
                            <div class="text-light small">Membres Actifs</div>
                            <div class="h4 mb-0 text-white">{{ $stats['membres_actifs'] ?? 0 }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #38b2ac, #319795); border-radius: 50%;">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>

                    <!-- Membres en Attente -->
                    @if(($stats['membres_en_attente'] ?? 0) > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: rgba(237, 137, 54, 0.1); border-radius: 8px;">
                        <div>
                            <div class="text-light small">En Attente</div>
                            <div class="h4 mb-0 text-white">{{ $stats['membres_en_attente'] ?? 0 }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #ed8936, #dd6b20); border-radius: 50%;">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                    @endif

                    <!-- Cours Actifs -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: rgba(102, 126, 234, 0.1); border-radius: 8px;">
                        <div>
                            <div class="text-light small">Cours Actifs</div>
                            <div class="h4 mb-0 text-white">{{ $stats['cours_actifs'] ?? 0 }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 50%;">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                    </div>

                    <!-- Sessions -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background: rgba(159, 122, 234, 0.1); border-radius: 8px;">
                        <div>
                            <div class="text-light small">Sessions</div>
                            <div class="h4 mb-0 text-white">{{ $stats['sessions_actives'] ?? 0 }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #9f7aea, #805ad5); border-radius: 50%;">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions administratives -->
            @if(auth()->user()->role === 'superadmin')
            <div class="card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-cogs text-primary me-2"></i>
                        Actions Administratives
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Toggle Status -->
                    <form method="POST" action="{{ route('ecoles.toggle-status', $ecole) }}" class="mb-3">
                        @csrf
                        @method('PATCH')
                        @if($ecole->active)
                        <button type="submit" class="btn btn-outline-warning w-100" 
                                onclick="return confirm('Êtes-vous sûr de vouloir désactiver cette école ?')">
                            <i class="fas fa-pause me-2"></i>
                            Désactiver l'École
                        </button>
                        @else
                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="fas fa-play me-2"></i>
                            Activer l'École
                        </button>
                        @endif
                    </form>

                    <!-- Supprimer -->
                    @if(($stats['membres_total'] ?? 0) == 0 && ($stats['cours_actifs'] ?? 0) == 0)
                    <form method="POST" action="{{ route('ecoles.destroy', $ecole) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('⚠️ ATTENTION !\n\nÊtes-vous absolument sûr de vouloir supprimer définitivement cette école ?\n\nCette action est IRRÉVERSIBLE.')">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer l'École
                        </button>
                    </form>
                    @else
                    <div class="alert alert-warning" style="background: rgba(237, 137, 54, 0.2); border: 1px solid rgba(237, 137, 54, 0.3); color: #ffffff;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small>Impossible de supprimer une école avec des membres ou des cours actifs.</small>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
