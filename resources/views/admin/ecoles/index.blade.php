@extends('layouts.admin')

@section('title', 'Gestion des Écoles')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-school me-2"></i>Gestion des Écoles
            </h1>
        </div>
        <div class="col-md-4 text-end">
            @if(auth()->user()->hasRole('superadmin'))
            <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle École
            </a>
        @endif
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card gradient-primary">
                <div class="stat-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total des écoles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['actives'] }}</h3>
                    <p>Écoles actives</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-warning">
                <div class="stat-icon">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['inactives'] }}</h3>
                    <p>Écoles inactives</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gradient-danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['sans_adresse'] }}</h3>
                    <p>Sans adresse</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tableau des écoles -->
    <div class="glass-card">
        <div class="card-header">
            <h5 class="mb-0">Liste des écoles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            
                            <th>Statut</th>
                            <th class="text-center">Complet</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ecoles as $ecole)
                        <tr>
                            <td>
                                <a href="{{ route('admin.ecoles.show', $ecole) }}" class="text-decoration-none">
                                    {{ $ecole->nom }}
                                </a>
                            </td>
                            <td>{{ $ecole->ville }}</td>
                            <td>{{ $ecole->telephone ?? '-' }}</td>
                            <td>{{ $ecole->email ?? '-' }}</td>
                            
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" 
                                           type="checkbox" 
                                           data-id="{{ $ecole->id }}"
                                           {{ $ecole->statut === 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        <span class="badge bg-{{ $ecole->statut === 'active' ? 'success' : 'secondary' }}">
                                            {{ $ecole->statut === 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($ecole->is_complete)
                                    <i class="fas fa-check-circle text-success"></i>
                                @else
                                    <i class="fas fa-exclamation-circle text-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Informations incomplètes"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.ecoles.show', $ecole) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ecoles.edit', $ecole) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(auth()->user()->hasRole('superadmin'))
                                    <form action="{{ route('admin.ecoles.destroy', $ecole) }}" 
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <p class="mb-0 text-muted">Aucune école trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $ecoles->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialiser les tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Toggle statut
    $('.toggle-status').on('change', function() {
        const ecoleId = $(this).data('id');
        const $switch = $(this);
        const $label = $(this).siblings('label').find('.badge');
        
        $.ajax({
            url: `/admin/ecoles/${ecoleId}/toggle-status`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.statut === 'active') {
                        $label.removeClass('bg-secondary').addClass('bg-success').text('Active');
                    } else {
                        $label.removeClass('bg-success').addClass('bg-secondary').text('Inactive');
                    }
                }
            },
            error: function() {
                // Remettre le switch à sa position précédente
                $switch.prop('checked', !$switch.prop('checked'));
                alert('Erreur lors du changement de statut');
            }
        });
    });

    // Confirmation de suppression
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Cette action est irréversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
