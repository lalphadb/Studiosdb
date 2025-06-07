@extends('layouts.admin')

@section('title', 'Rapport de Rétention')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-user-check me-2"></i>Rapport de Rétention
            </h1>
            <p class="text-white-50">Analyse de la fidélisation et prédiction des risques</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.rapports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="glass-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.rapports.retention') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Période d'analyse</label>
                    <select name="periode" class="form-select">
                        <option value="3" {{ $periode == 3 ? 'selected' : '' }}>3 mois</option>
                        <option value="6" {{ $periode == 6 ? 'selected' : '' }}>6 mois</option>
                        <option value="12" {{ $periode == 12 ? 'selected' : '' }}>12 mois</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Taux de rétention global -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="glass-card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <canvas id="retentionGauge" height="200"></canvas>
                    </div>
                    <h3 class="mb-0">{{ $tauxRetention }}%</h3>
                    <p class="text-muted">Taux de Rétention Global</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="glass-card">
                <div class="card-header">
                    <h5 class="mb-0">Analyse par Cohorte</h5>
                </div>
                <div class="card-body">
                    <canvas id="cohorteChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Raisons d'abandon -->
        <div class="col-md-6">
            <div class="glass-card">
                <div class="card-header">
                    <h5 class="mb-0">Principales Raisons d'Abandon</h5>
                </div>
                <div class="card-body">
                    @foreach($raisonsAbandon as $raison)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $raison['raison'] }}</span>
                            <span>{{ $raison['pourcentage'] }}%</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: {{ $raison['pourcentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Membres à risque -->
        <div class="col-md-6">
            <div class="glass-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Membres à Risque d'Abandon
                        <span class="badge bg-danger ms-2">{{ $membresRisque->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>École</th>
                                    <th>Dernière présence</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($membresRisque->take(10) as $membre)
                                <tr>
                                    <td>{{ $membre->prenom }} {{ $membre->nom }}</td>
                                    <td>{{ $membre->ecole->nom ?? '-' }}</td>
                                    <td>
                                        @if($membre->presences()->latest('date')->first())
                                            {{ $membre->presences()->latest('date')->first()->date->diffForHumans() }}
                                        @else
                                            <span class="text-danger">Jamais</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="contacterMembre({{ $membre->id }})">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($membresRisque->count() > 10)
                        <p class="text-center mt-3">
                            <small class="text-muted">Et {{ $membresRisque->count() - 10 }} autres membres...</small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gauge de rétention
new Chart(document.getElementById('retentionGauge'), {
    type: 'doughnut',
    data: {
        labels: ['Rétention', 'Perte'],
        datasets: [{
            data: [{{ $tauxRetention }}, {{ 100 - $tauxRetention }}],
            backgroundColor: ['#10b981', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        cutout: '70%'
    }
});

// Graphique cohortes
const cohorteData = @json($cohortes);
new Chart(document.getElementById('cohorteChart'), {
    type: 'line',
    data: {
        labels: cohorteData.map(c => c.mois),
        datasets: [{
            label: 'Taux de rétention (%)',
            data: cohorteData.map(c => c.taux),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#8b92a3',
                    callback: function(value) {
                        return value + '%';
                    }
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#8b92a3'
                }
            }
        }
    }
});

function contacterMembre(membreId) {
    Swal.fire({
        title: 'Contacter le membre',
        text: 'Voulez-vous envoyer un email de relance à ce membre?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Envoyer',
        cancelButtonText: 'Annuler'
    });
}
</script>
@endpush
@endsection
