@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Tableau de bord</h1>
    
    <!-- Message de bienvenue -->
    <div class="alert alert-info">
        <h4 class="alert-heading">Bienvenue dans Studios Unis ! 👋</h4>
        <p class="mb-0">
            Connecté en tant que : <strong>{{ auth()->user()->name }}</strong> 
            @if(auth()->user()->role)
                ({{ auth()->user()->role }})
            @endif
        </p>
        @if(auth()->user()->ecole)
            <p class="mb-0">École : {{ auth()->user()->ecole->nom }}</p>
        @endif
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Membres actifs</h5>
                    <p class="card-text display-4">{{ $totalMembres ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Présences aujourd'hui</h5>
                    <p class="card-text display-4">{{ $totalPresences ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Écoles actives</h5>
                    <p class="card-text display-4">{{ $totalEcoles ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Cours programmés</h5>
                    <p class="card-text display-4">{{ $totalCours ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Actions rapides</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="{{ route('membres.index') }}" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus"></i> Gérer les membres
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('cours.index') }}" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Gérer les cours
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('presences.index') }}" class="btn btn-warning w-100">
                        <i class="bi bi-check-square"></i> Prendre les présences
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('ecoles.index') }}" class="btn btn-info w-100">
                        <i class="bi bi-building"></i> Gérer les écoles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique (optionnel) -->
    @if(isset($chartData))
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Répartition des membres par école</h5>
        </div>
        <div class="card-body">
            <canvas id="membresChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
    @endif
</div>

@if(isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('membresChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {!! json_encode($chartData) !!},
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endif
@endsection
