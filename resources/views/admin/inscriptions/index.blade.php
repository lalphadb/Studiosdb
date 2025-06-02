@extends('layouts.admin')

@section('title', 'Gestion des Inscriptions')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="container">
        <!-- Header -->
        <div class="content-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Gestion des Inscriptions</h1>
                    <nav class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>/</span>
                        <span>Inscriptions</span>
                    </nav>
                </div>
                <a href="{{ route('admin.inscriptions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Inscription
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid mb-4">
            <div class="stat-card cyan">
                <div class="stat-icon cyan">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Inscriptions</div>
            </div>

            <div class="stat-card green">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['confirmees'] }}</div>
                <div class="stat-label">Confirmées</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> Actives
                </div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $stats['attente'] }}</div>
                <div class="stat-label">Liste d'attente</div>
            </div>

            <div class="stat-card pink">
                <div class="stat-icon pink">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-value">{{ $stats['cette_semaine'] }}</div>
                <div class="stat-label">Cette semaine</div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="content-card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter card-icon"></i>
                    Filtres de recherche
                </h3>
            </div>
            <form method="GET" action="{{ route('admin.inscriptions.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Nom, email, cours..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="cours_id" class="form-control">
                            <option value="">Tous les cours</option>
                            @foreach($cours as $c)
                                <option value="{{ $c->id }}" {{ request('cours_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }} ({{ $c->ecole->nom }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="statut" class="form-control">
                            <option value="">Tous les statuts</option>
                            <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmées</option>
                            <option value="liste_attente" {{ request('statut') == 'liste_attente' ? 'selected' : '' }}>Liste d'attente</option>
                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulées</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="ecole_id" class="form-control">
                            <option value="">Toutes les écoles</option>
                            @foreach($ecoles as $ecole)
                                <option value="{{ $ecole->id }}" {{ request('ecole_id') == $ecole->id ? 'selected' : '' }}>
                                    {{ $ecole->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search mr-2"></i>Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tableau des inscriptions -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list card-icon"></i>
                    Liste des inscriptions
                </h3>
            </div>
            
            <form id="bulk-form" method="POST" action="{{ route('admin.inscriptions.bulk-action') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>Membre</th>
                                <th>Cours</th>
                                <th>École</th>
                                <th>Date inscription</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inscriptions as $inscription)
                            <tr>
                                <td>
                                    <input type="checkbox" name="inscriptions[]" value="{{ $inscription->id }}" class="form-check-input inscription-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($inscription->membre->prenom, 0, 1) . substr($inscription->membre->nom, 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <div class="text-white">{{ $inscription->membre->prenom }} {{ $inscription->membre->nom }}</div>
                                            <small class="text-muted">{{ $inscription->membre->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-white">{{ $inscription->cours->nom }}</div>
                                    @if($inscription->cours->session)
                                        <span class="badge" style="background: {{ $inscription->cours->session->couleur }};">
                                            {{ $inscription->cours->session->nom }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $inscription->cours->ecole->nom }}</td>
                                <td>{{ $inscription->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($inscription->statut === 'confirmee')
                                        <span class="badge bg-green-500/20 text-green-400">Confirmée</span>
                                    @elseif($inscription->statut === 'liste_attente')
                                        <span class="badge bg-yellow-500/20 text-yellow-400">Liste d'attente</span>
                                    @else
                                        <span class="badge bg-red-500/20 text-red-400">Annulée</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($inscription->statut === 'liste_attente')
                                        <form action="{{ route('admin.inscriptions.update-statut', $inscription) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="statut" value="confirmee">
                                            <button type="submit" class="btn btn-success btn-sm" title="Confirmer">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        @if($inscription->statut !== 'annulee')
                                        <form action="{{ route('admin.inscriptions.update-statut', $inscription) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="statut" value="annulee">
                                            <button type="submit" class="btn btn-warning btn-sm" title="Annuler">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.inscriptions.destroy', $inscription) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette inscription ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune inscription trouvée</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($inscriptions->count() > 0)
                <div class="p-3 border-top">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <select name="action" class="form-select form-select-sm w-auto">
                                    <option value="">Actions groupées...</option>
                                    <option value="confirm">Confirmer les inscriptions</option>
                                    <option value="cancel">Annuler les inscriptions</option>
                                    <option value="delete">Supprimer les inscriptions</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirmBulkAction()">
                                    Appliquer
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{ $inscriptions->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Select all checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.inscription-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Confirm bulk action
function confirmBulkAction() {
    const action = document.querySelector('select[name="action"]').value;
    const checkboxes = document.querySelectorAll('.inscription-checkbox:checked');
    
    if (!action) {
        alert('Veuillez sélectionner une action');
        return false;
    }
    
    if (checkboxes.length === 0) {
        alert('Veuillez sélectionner au moins une inscription');
        return false;
    }
    
    return confirm(`Êtes-vous sûr de vouloir ${action === 'confirm' ? 'confirmer' : action === 'cancel' ? 'annuler' : 'supprimer'} ${checkboxes.length} inscription(s) ?`);
}
</script>
@endpush

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #20b9be, #4caf50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 14px;
}

.form-control, .form-select {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
}

.form-control:focus, .form-select:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #20b9be;
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(32, 185, 190, 0.25);
}

.btn-primary {
    background: #20b9be;
    border: none;
}

.btn-primary:hover {
    background: #1a9da0;
}

.btn-success {
    background: #4caf50;
    border: none;
}

.btn-warning {
    background: #ff9800;
    border: none;
}

.btn-danger {
    background: #f44336;
    border: none;
}
</style>
@endsection
