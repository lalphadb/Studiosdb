@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card animate-fadeIn">
        <div class="stat-icon">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-value">{{ $totalMembres ?? 0 }}</div>
        <div class="stat-label">Membres actifs</div>
        <div class="stat-progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 75%"></div>
            </div>
            <span class="text-success">+12%</span>
        </div>
    </div>
    
    <div class="stat-card animate-fadeIn" style="animation-delay: 0.1s">
        <div class="stat-icon success">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-value">{{ $totalPresences ?? 0 }}</div>
        <div class="stat-label">Présences aujourd'hui</div>
        <div class="stat-progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 60%; background: var(--gradient-success)"></div>
            </div>
            <span class="text-success">+8%</span>
        </div>
    </div>
    
    <div class="stat-card animate-fadeIn" style="animation-delay: 0.2s">
        <div class="stat-icon warning">
            <i class="bi bi-building"></i>
        </div>
        <div class="stat-value">{{ $totalEcoles ?? 0 }}</div>
        <div class="stat-label">Écoles actives</div>
        <div class="stat-progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 90%; background: var(--gradient-warning)"></div>
            </div>
            <span class="text-warning">+5%</span>
        </div>
    </div>
    
    <div class="stat-card animate-fadeIn" style="animation-delay: 0.3s">
        <div class="stat-icon danger">
            <i class="bi bi-calendar3"></i>
        </div>
        <div class="stat-value">{{ $totalCours ?? 0 }}</div>
        <div class="stat-label">Cours programmés</div>
        <div class="stat-progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 45%; background: var(--gradient-danger)"></div>
            </div>
            <span class="text-danger">-3%</span>
        </div>
    </div>
</div>

<div class="row">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="theta-card">
            <div class="card-header">
                <h5 class="card-title">Évolution des inscriptions</h5>
                <div class="card-options">
                    <button class="btn btn-sm btn-secondary">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Pie Chart -->
    <div class="col-lg-4">
        <div class="theta-card">
            <div class="card-header">
                <h5 class="card-title">Répartition par école</h5>
                <div class="card-options">
                    <button class="btn btn-sm btn-secondary">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="theta-card mt-4">
    <div class="card-header">
        <h5 class="card-title">Activités récentes</h5>
        <a href="#" class="btn btn-sm btn-primary">Voir tout</a>
    </div>
    
    <div class="theta-table">
        <table>
            <thead>
                <tr>
                    <th>Membre</th>
                    <th>Action</th>
                    <th>École</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px; margin-right: 10px;">
                                JD
                            </div>
                            <div>
                                <div class="font-weight-medium">Jean Dupont</div>
                                <div class="text-muted" style="font-size: 12px;">jean.dupont@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Nouvelle inscription</td>
                    <td>École St-Émile</td>
                    <td>Il y a 2 heures</td>
                    <td><span class="badge badge-success">Complété</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px; margin-right: 10px;">
                                ML
                            </div>
                            <div>
                                <div class="font-weight-medium">Marie Leblanc</div>
                                <div class="text-muted" style="font-size: 12px;">marie.leblanc@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Présence marquée</td>
                    <td>École Beauport</td>
                    <td>Il y a 3 heures</td>
                    <td><span class="badge badge-info">En cours</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px; margin-right: 10px;">
                                PT
                            </div>
                            <div>
                                <div class="font-weight-medium">Pierre Tremblay</div>
                                <div class="text-muted" style="font-size: 12px;">pierre.tremblay@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Paiement reçu</td>
                    <td>École Charlesbourg</td>
                    <td>Il y a 5 heures</td>
                    <td><span class="badge badge-success">Complété</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Graphique en temps réel -->
<div class="theta-card mt-4">
    <div class="card-header">
        <h5 class="card-title">📊 Présences en temps réel</h5>
        <div class="card-options">
            <span class="badge badge-info animate-pulse">LIVE</span>
        </div>
    </div>
    <div class="chart-container" style="height: 300px;">
        <canvas id="realtimeChart"></canvas>
    </div>
</div>

<!-- Widget des badges et statistiques avancées -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="theta-card">
            <div class="card-header">
                <h5 class="card-title">🏆 Derniers badges obtenus</h5>
                <a href="#" class="btn btn-sm btn-primary">Voir tous</a>
            </div>
            <div class="badges-list">
                <div class="badge-item">
                    <div class="badge-icon" style="background: linear-gradient(135deg, #00d4ff 0%, #00ff88 100%); box-shadow: 0 8px 32px rgba(0, 212, 255, 0.3);">
                        <i class="bi bi-fire"></i>
                    </div>
                    <div class="badge-info">
                        <h6>En Feu!</h6>
                        <p>Jean Dupont - Il y a 2h</p>
                    </div>
                    <div class="badge-points">+500 pts</div>
                </div>
                <div class="badge-item">
                    <div class="badge-icon" style="background: linear-gradient(135deg, #ff6b00 0%, #ffaa00 100%); box-shadow: 0 8px 32px rgba(255, 170, 0, 0.3);">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="badge-info">
                        <h6>Étoile Montante</h6>
                        <p>Marie Leblanc - Il y a 5h</p>
                    </div>
                    <div class="badge-points">+750 pts</div>
                </div>
                <div class="badge-item">
                    <div class="badge-icon" style="background: linear-gradient(135deg, #7928ca 0%, #ff0080 100%); box-shadow: 0 8px 32px rgba(255, 0, 128, 0.3);">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="badge-info">
                        <h6>Perfectionniste</h6>
                        <p>Sophie Martin - Il y a 8h</p>
                    </div>
                    <div class="badge-points">+300 pts</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="theta-card">
            <div class="card-header">
                <h5 class="card-title">📈 Statistiques avancées</h5>
            </div>
            <div class="stats-advanced">
                <div class="stat-item">
                    <div class="stat-label">Taux de rétention</div>
                    <div class="stat-value">87%</div>
                    <div class="stat-trend text-success">
                        <i class="bi bi-arrow-up"></i> +3.2%
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Membres actifs (7j)</div>
                    <div class="stat-value">142</div>
                    <div class="stat-trend text-success">
                        <i class="bi bi-arrow-up"></i> +12
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Score moyen progression</div>
                    <div class="stat-value">8.4/10</div>
                    <div class="stat-trend text-warning">
                        <i class="bi bi-dash"></i> stable
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Temps moyen par session</div>
                    <div class="stat-value">1h 32m</div>
                    <div class="stat-trend text-danger">
                        <i class="bi bi-arrow-down"></i> -5m
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Configuration globale des graphiques avec le nouveau thème
Chart.defaults.color = '#b4b4c6';
Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
        datasets: [{
            label: 'Nouvelles inscriptions',
            data: [65, 59, 80, 81, 56, 55, 78, 88, 92, 85, 102, 115],
            borderColor: '#00d4ff',
            backgroundColor: 'rgba(0, 212, 255, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#00d4ff',
            pointBorderColor: '#0a0a0a',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }, {
            label: 'Renouvellements',
            data: [45, 52, 48, 58, 61, 55, 62, 68, 72, 78, 82, 88],
            borderColor: '#00ff88',
            backgroundColor: 'rgba(0, 255, 136, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#00ff88',
            pointBorderColor: '#0a0a0a',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: '#b4b4c6',
                    padding: 20,
                    font: {
                        size: 12
                    },
                    usePointStyle: true
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.05)',
                    borderColor: 'rgba(255, 255, 255, 0.08)'
                },
                ticks: {
                    color: '#7c7c94',
                    font: {
                        size: 11
                    }
                }
            },
            y: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.05)',
                    borderColor: 'rgba(255, 255, 255, 0.08)'
                },
                ticks: {
                    color: '#7c7c94',
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Distribution Chart
const distributionCtx = document.getElementById('distributionChart').getContext('2d');
new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
        labels: ['St-Émile', 'Beauport', 'Charlesbourg', 'Autres'],
        datasets: [{
            data: [35, 28, 22, 15],
            backgroundColor: [
                '#00d4ff',
                '#00ff88',
                '#ffaa00',
                '#ff0080'
            ],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: '#b4b4c6',
                    padding: 15,
                    font: {
                        size: 12
                    },
                    usePointStyle: true
                }
            }
        }
    }
});

// ========================================
// ANALYTICS AVANCÉS ET TEMPS RÉEL
// ========================================

// Charger les plugins nécessaires pour le temps réel
const script1 = document.createElement('script');
script1.src = 'https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0';
document.head.appendChild(script1);

const script2 = document.createElement('script');
script2.src = 'https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js';
document.head.appendChild(script2);

const script3 = document.createElement('script');
script3.src = 'https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.1';
document.head.appendChild(script3);

// Attendre que les scripts soient chargés
setTimeout(() => {
    // Graphique en temps réel
    const realtimeCtx = document.getElementById('realtimeChart');
    if (realtimeCtx) {
        const realtimeChart = new Chart(realtimeCtx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Présences',
                    data: [],
                    borderColor: '#00d4ff',
                    backgroundColor: 'rgba(0, 212, 255, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#00d4ff',
                    pointBorderColor: '#0a0a0a',
                    pointBorderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        type: 'realtime',
                        realtime: {
                            duration: 60000, // 1 minute de données
                            refresh: 1000, // Mise à jour chaque seconde
                            delay: 2000,
                            onRefresh: chart => {
                                // Générer des données de test (remplacer par API réelle)
                                const now = Date.now();
                                const value = Math.floor(Math.random() * 10) + 20;
                                
                                chart.data.datasets[0].data.push({
                                    x: now,
                                    y: value
                                });
                                
                                // Limiter le nombre de points
                                if (chart.data.datasets[0].data.length > 100) {
                                    chart.data.datasets[0].data.shift();
                                }
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#7c7c94',
                            source: 'auto',
                            autoSkip: true,
                            maxRotation: 0
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 40,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#7c7c94',
                            stepSize: 10
                        }
                    }
                }
            }
        });
    }
}, 1000);

// CSS pour les nouveaux éléments
const styles = `
<style>
/* Badges List */
.badges-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.badge-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 16px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.badge-item:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
    border-color: rgba(255, 255, 255, 0.1);
}

.badge-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.badge-icon::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transform: rotate(45deg);
    transition: all 0.6s ease;
    opacity: 0;
}

.badge-item:hover .badge-icon::after {
    animation: shine 0.6s ease;
    opacity: 1;
}

@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.badge-info {
    flex: 1;
}

.badge-info h6 {
    margin: 0;
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
}

.badge-info p {
    margin: 0;
    color: #7c7c94;
    font-size: 14px;
    margin-top: 4px;
}

.badge-points {
    color: #00ff88;
    font-weight: 700;
    font-size: 20px;
    text-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
}

/* Stats avancées */
.stats-advanced {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.stat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}

.stat-item .stat-label {
    color: #7c7c94;
    font-size: 14px;
}

.stat-item .stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
    flex: 1;
    text-align: center;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    font-weight: 600;
}

/* Animation pulse pour le badge LIVE */
@keyframes pulse {
    0% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-pulse {
    animation: pulse 2s infinite;
}

/* Amélioration des cartes existantes */
.theta-card {
    transition: all 0.3s ease;
}

.theta-card:hover {
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .badge-item {
        padding: 15px;
    }
    
    .badge-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .badge-info h6 {
        font-size: 16px;
    }
    
    .badge-points {
        font-size: 18px;
    }
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', styles);

// Animer les éléments au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fadeIn');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observer tous les éléments animables
document.querySelectorAll('.badge-item, .stat-item').forEach(item => {
    observer.observe(item);
});

// Fonction pour mettre à jour les données en temps réel (à connecter à votre API)
function updateRealtimeData() {
    // Exemple de mise à jour des statistiques
    // À remplacer par des appels API réels
    
    // fetch('/api/stats/realtime')
    //     .then(response => response.json())
    //     .then(data => {
    //         // Mettre à jour les valeurs affichées
    //         document.querySelector('.stat-value').textContent = data.activeMembers;
    //     });
}

// Mettre à jour toutes les 30 secondes
setInterval(updateRealtimeData, 30000);
</script>
@endpush
