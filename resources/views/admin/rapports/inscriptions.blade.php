@extends('layouts.admin')

@section('title', 'Rapport d\'Inscriptions')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-user-plus me-2"></i>Rapport d'Inscriptions
            </h1>
            <p class="text-white-50">Analyse des nouvelles inscriptions et conversions</p>
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
            <form method="GET" action="{{ route('admin.rapports.inscriptions') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Année</label>
                    <select name="annee" class="form-select">
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
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

    <!-- KPIs -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="glass-card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-0">{{ $stats['total_inscriptions'] }}</h3>
                    <p class="text-muted mb-0">Total Inscriptions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <div class="card-body">
                    <h3 class="text-success mb-0">{{ $stats['inscriptions_confirmees'] }}</h3>
                    <p class="text-muted mb-0">Confirmées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <div class="card-body">
                    <h3 class="text-warning mb-0">{{ $stats['taux_conversion'] }}%</h3>
                    <p class="text-muted mb-0">Taux de Conversion</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <div class="card-body">
                    <h3 class="text-info mb-0">${{ number_format($stats['revenus_estimes'], 0) }}</h3>
                    <p class="text-muted mb-0">Revenus Estimés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-md-8">
            <div class="glass-card">
                <div class="card-header">
                    <h5 class="mb-0">Évolution Mensuelle des Inscriptions</h5>
                </div>
                <div class="card-body">
                    <canvas id="inscriptionsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card">
                <div class="card-header">
                    <h5 class="mb-0">Top Cours par Inscriptions</h5>
                </div>
                <div class="card-body">
                    @foreach($repartitionParCours->take(5) as $cours)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $cours->nom }}</span>
                            <span class="badge bg-primary">{{ $cours->inscriptions_count }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" style="width: {{ ($cours->inscriptions_count / max($repartitionParCours->max('inscriptions_count'), 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const inscriptionsData = @json($inscriptionsParMois);
new Chart(document.getElementById('inscriptionsChart'), {
    type: 'bar',
    data: {
        labels: inscriptionsData.map(d => d.mois),
        datasets: [{
            label: 'Total',
            data: inscriptionsData.map(d => d.total),
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: '#3b82f6',
            borderWidth: 1
        }, {
            label: 'Confirmées',
            data: inscriptionsData.map(d => d.confirmees),
            backgroundColor: 'rgba(16, 185, 129, 0.5)',
            borderColor: '#10b981',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#8b92a3'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#8b92a3'
                }
            }
        }
    }
});
</script>
@endpush
@endsection
