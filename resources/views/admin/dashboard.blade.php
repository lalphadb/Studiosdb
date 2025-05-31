@extends('layouts.admin', ['pageTitle' => 'Dashboard'])

@section('content')
<div class="fade-in">
    <!-- Statistiques principales -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalMembres ?? 1 }}</div>
            <div class="stat-label">Membres actifs</div>
            <small class="text-accent-primary">Gérer les membres</small>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $totalPresences ?? 0 }}</div>
            <div class="stat-label">Présences aujourd'hui</div>
            <small class="text-accent-primary">Voir le détail</small>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $totalEcoles ?? 44 }}</div>
            <div class="stat-label">Écoles actives</div>
            <small class="text-accent-primary">Gérer les écoles</small>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $totalCours ?? 0 }}</div>
            <div class="stat-label">Cours programmés</div>
            <small class="text-accent-primary">Planifier des cours</small>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="actions-section">
        <h2 class="text-xl font-semibold mb-4 text-text-primary">Actions rapides</h2>
        <div class="actions-grid">
            <a href="{{ route('admin.membres.create') }}" class="action-btn">
                <i data-feather="user-plus"></i>
                <span>Nouveau membre</span>
            </a>
            <a href="{{ route('admin.cours.create') }}" class="action-btn">
                <i data-feather="plus-circle"></i>
                <span>Créer un cours</span>
            </a>
            <a href="{{ route('admin.presences.index') }}" class="action-btn">
                <i data-feather="check-square"></i>
                <span>Prendre les présences</span>
            </a>
            <a href="{{ route('admin.ecoles.index') }}" class="action-btn">
                <i data-feather="building"></i>
                <span>Gérer les écoles</span>
            </a>
        </div>
    </div>

    <!-- Graphique de répartition -->
    <div class="glass-card mt-6">
        <h3 class="text-lg font-semibold mb-4">Répartition des membres par école</h3>
        <canvas id="membresChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    feather.replace();
    
    // Configuration du graphique
    const ctx = document.getElementById('membresChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['École A', 'École B', 'École C', 'Autres'],
            datasets: [{
                data: [30, 25, 20, 25],
                backgroundColor: [
                    'rgba(0, 212, 255, 0.7)',
                    'rgba(124, 58, 237, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ],
                borderColor: [
                    'rgba(0, 212, 255, 1)',
                    'rgba(124, 58, 237, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff',
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
});
</script>
@endsection
