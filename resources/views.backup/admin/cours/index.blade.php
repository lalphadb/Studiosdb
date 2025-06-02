@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1 class="h3 text-white mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Gestion des Cours
                </h1>
                <a href="{{ route('admin.cours.create') }}" class="btn btn-info">
                    <i class="fas fa-plus me-2"></i>Nouveau Cours
                </a>
            </div>
        </div>
    </div>

    @include('components.alerts')

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark text-white border-info" style="backdrop-filter: blur(10px); background: rgba(0,150,255,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Cours</h6>
                            <h3 class="mb-0">{{ $cours->total() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-book fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-success" style="backdrop-filter: blur(10px); background: rgba(0,255,0,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Cours Actifs</h6>
                            <h3 class="mb-0">{{ $cours->where('actif', true)->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-warning" style="backdrop-filter: blur(10px); background: rgba(255,200,0,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Sessions</h6>
                            <h3 class="mb-0">{{ $sessions->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-secondary" style="backdrop-filter: blur(10px); background: rgba(150,150,150,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Cours/Semaine</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalHoraires = 0;
                                    foreach($cours as $c) {
                                        if($c->actif) {
                                            $totalHoraires += $c->horaires->count();
                                        }
                                    }
                                @endphp
                                {{ $totalHoraires }}
                            </h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card bg-dark text-white mb-4" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cours.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Session</label>
                    <select name="session_id" class="form-select bg-dark text-white" style="background: rgba(255,255,255,0.1) !important;">
                        <option value="">Toutes les sessions</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Statut</label>
                    <select name="actif" class="form-select bg-dark text-white" style="background: rgba(255,255,255,0.1) !important;">
                        <option value="">Tous les statuts</option>
                        <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Actifs uniquement</option>
                        <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Inactifs uniquement</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Vue</label>
                    <select name="view" class="form-select bg-dark text-white" style="background: rgba(255,255,255,0.1) !important;">
                        <option value="cards" {{ request('view', 'cards') == 'cards' ? 'selected' : '' }}>Vue cartes</option>
                        <option value="calendar" {{ request('view') == 'calendar' ? 'selected' : '' }}>Vue calendrier</option>
                        <option value="list" {{ request('view') == 'list' ? 'selected' : '' }}>Vue liste</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-info me-2">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    @php
        $viewType = request('view', 'cards');
    @endphp

    @if($viewType == 'calendar')
        <!-- Vue Calendrier par jour -->
        @include('admin.cours.partials.calendar-view', ['cours' => $cours])
    @elseif($viewType == 'list')
        <!-- Vue Liste -->
        @include('admin.cours.partials.list-view', ['cours' => $cours])
    @else
        <!-- Vue Cartes (par défaut) -->
        @include('admin.cours.partials.cards-view', ['cours' => $cours])
    @endif
    
    <div class="mt-4">
        {{ $cours->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
