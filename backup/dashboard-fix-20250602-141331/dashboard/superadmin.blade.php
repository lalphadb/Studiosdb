@extends('layouts.admin')

@section('title', 'Tableau de bord Super Admin')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-purple-600 bg-clip-text text-transparent">
                Tableau de bord Global
            </h1>
            <p class="text-gray-400 mt-2">Vue d'ensemble de toutes les écoles</p>
        </div>

        <!-- Statistiques globales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Écoles -->
            <div class="glassmorphic-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Écoles</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_ecoles'] }}</p>
                        <p class="text-cyan-400 text-sm mt-1">{{ $stats['total_ecoles_actives'] }} actives</p>
                    </div>
                    <div class="glassmorphic-icon">
                        <i class="fas fa-school text-2xl text-cyan-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Membres -->
            <div class="glassmorphic-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Membres</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_membres'] }}</p>
                        <p class="text-green-400 text-sm mt-1">{{ $stats['total_membres_approuves'] }} approuvés</p>
                    </div>
                    <div class="glassmorphic-icon">
                        <i class="fas fa-users text-2xl text-green-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Cours -->
            <div class="glassmorphic-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Cours</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_cours'] }}</p>
                        <p class="text-orange-400 text-sm mt-1">{{ $stats['total_sessions'] }} sessions</p>
                    </div>
                    <div class="glassmorphic-icon">
                        <i class="fas fa-chalkboard-teacher text-2xl text-orange-400"></i>
                    </div>
                </div>
            </div>

            <!-- Nouveaux ce mois -->
            <div class="glassmorphic-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Nouveaux ce mois</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['nouveaux_membres_mois'] }}</p>
                        <p class="text-purple-400 text-sm mt-1">membres</p>
                    </div>
                    <div class="glassmorphic-icon">
                        <i class="fas fa-user-plus text-2xl text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et tableaux -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top 5 Écoles -->
            <div class="glassmorphic-card p-6">
                <h3 class="text-xl font-semibold text-white mb-4">Top 5 Écoles par Membres</h3>
                <div class="space-y-3">
                    @foreach($topEcoles as $index => $ecole)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 hover:bg-white/10 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-cyan-400">#{{ $index + 1 }}</span>
                            <div>
                                <p class="text-white font-medium">{{ $ecole->nom }}</p>
                                <p class="text-gray-400 text-sm">{{ $ecole->ville }}</p>
                            </div>
                        </div>
                        <span class="text-xl font-bold text-green-400">{{ $ecole->membres_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Graphique des inscriptions -->
            <div class="glassmorphic-card p-6">
                <h3 class="text-xl font-semibold text-white mb-4">Inscriptions (12 derniers mois)</h3>
                <canvas id="inscriptionsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('inscriptionsChart').getContext('2d');
const inscriptionsData = @json($inscriptionsParMois);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: inscriptionsData.map(item => item.mois),
        datasets: [{
            label: 'Nouvelles inscriptions',
            data: inscriptionsData.map(item => item.total),
            borderColor: 'rgb(34, 211, 238)',
            backgroundColor: 'rgba(34, 211, 238, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: '#fff' }
            }
        },
        scales: {
            y: {
                ticks: { color: '#fff' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            },
            x: {
                ticks: { color: '#fff' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            }
        }
    }
});
</script>
@endpush
@endsection
