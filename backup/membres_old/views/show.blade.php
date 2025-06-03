@extends('layouts.admin')

@section('title', $membre->prenom . ' ' . $membre->nom)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic.css') }}">
<style>
.hero-section {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(236, 72, 153, 0.1));
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, var(--neon-purple) 0%, transparent 70%);
    opacity: 0.05;
    animation: rotate 30s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.progress-ring {
    transform: rotate(-90deg);
}

.progress-ring-circle {
    transition: stroke-dashoffset 0.5s ease;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-6">
    <!-- Hero Section -->
    <div class="hero-section glass-card mb-8">
        <div class="relative z-10 p-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">
                <!-- Profile Info -->
                <div class="flex items-center mb-6 lg:mb-0">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white/20">
                            @if($membre->photo)
                                <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-4xl font-bold text-white">
                                        {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <!-- Status Badge -->
                        <div class="absolute -bottom-2 -right-2 px-3 py-1 rounded-full text-xs font-bold
                            {{ $membre->approuve ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                            {{ $membre->approuve ? 'Actif' : 'En attente' }}
                        </div>
                    </div>

                    <div class="ml-8">
                        <h1 class="text-4xl font-bold text-white mb-2">
                            {{ $membre->prenom }} {{ $membre->nom }}
                        </h1>
                        <div class="flex items-center gap-4 text-gray-300">
                            @if($membre->age)
                                <span><i class="fas fa-birthday-cake mr-2"></i>{{ $membre->age }}</span>
                            @endif
                            <span><i class="fas fa-school mr-2"></i>{{ $membre->ecole->nom ?? 'Non assigné' }}</span>
                            <span><i class="fas fa-calendar-alt mr-2"></i>Membre depuis {{ $membre->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <!-- Ceinture actuelle -->
                        @if($ceintureActuelle)
                        <div class="mt-4 inline-flex items-center gap-3 glass-card px-4 py-2">
                            <div class="w-8 h-8 rounded-full" style="background-color: {{ $ceintureActuelle->couleur }}"></div>
                            <span class="text-white font-medium">{{ $ceintureActuelle->nom }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.membres.edit', $membre) }}" 
                       class="btn-glass btn-glass-primary">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    <button onclick="openEmailModal()" class="btn-glass">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </button>
                    
                    <button onclick="printMemberCard()" class="btn-glass">
                        <i class="fas fa-id-card mr-2"></i>Carte
                    </button>
                    
                    <button onclick="exportMemberData()" class="btn-glass">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card-glass">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Cours inscrits</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['cours_inscrits'] }}</p>
                </div>
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500/20">
                    <i class="fas fa-book text-blue-400 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card-glass">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Présences</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['presences'] }}</p>
                </div>
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-green-500/20">
                    <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card-glass">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Taux présence</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['taux_presence'] }}%</p>
                </div>
                <div class="w-16 h-16">
                    <svg class="progress-ring" width="64" height="64">
                        <circle class="text-gray-700" stroke-width="4" stroke="currentColor" fill="transparent" r="28" cx="32" cy="32" />
                        <circle class="progress-ring-circle text-yellow-400" 
                                stroke-width="4" 
                                stroke-dasharray="{{ 28 * 2 * 3.14159 }}" 
                                stroke-dashoffset="{{ 28 * 2 * 3.14159 * (1 - $stats['taux_presence'] / 100) }}"
                                stroke-linecap="round" 
                                stroke="currentColor" 
                                fill="transparent" 
                                r="28" 
                                cx="32" 
                                cy="32" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card-glass">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Séminaires</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['seminaires_participes'] }}</p>
                </div>
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-purple-500/20">
                    <i class="fas fa-graduation-cap text-purple-400 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Progression Chart -->
            @if($stats['progression_ceinture']['ceinture_actuelle'])
            <div class="chart-glass">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-chart-line mr-3 text-green-400"></i>
                    Progression vers {{ $stats['progression_ceinture']['prochaine_ceinture']->nom ?? 'Maximum atteint' }}
                </h3>
                
                <div class="relative">
                    <canvas id="progressionChart" height="100"></canvas>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                    <div class="glass-card p-4">
                        <p class="text-sm text-gray-400">Facteur Présence</p>
                        <p class="text-2xl font-bold text-white">x{{ $stats['progression_ceinture']['facteurs']['presence'] }}</p>
                    </div>
                    <div class="glass-card p-4">
                        <p class="text-sm text-gray-400">Performance</p>
                        <p class="text-2xl font-bold text-white">x{{ $stats['progression_ceinture']['facteurs']['performance'] }}</p>
                    </div>
                    <div class="glass-card p-4">
                        <p class="text-sm text-gray-400">Séminaires</p>
                        <p class="text-2xl font-bold text-white">x{{ $stats['progression_ceinture']['facteurs']['seminaires'] }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timeline Présences -->
            <div class="glass-card">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-history mr-3 text-blue-400"></i>
                    Activité récente
                </h3>
                
                <div class="timeline-container">
                    <div class="timeline-line"></div>
                    
                    @forelse($dernieresPresences->take(5) as $presence)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="glass-card p-4 ml-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-white font-medium">{{ $presence->cours->nom }}</p>
                                    <p class="text-gray-400 text-sm">
                                        {{ $presence->date_presence->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $presence->status == 'present' ? 'bg-green-500/20 text-green-400' : 
                                       ($presence->status == 'absent' ? 'bg-red-500/20 text-red-400' : 
                                       'bg-yellow-500/20 text-yellow-400') }}">
                                    {{ ucfirst($presence->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 text-center py-8">Aucune activité récente</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Contact Info -->
            <div class="glass-card">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-address-card mr-3 text-purple-400"></i>
                    Informations de contact
                </h3>
                
                <div class="space-y-4">
                    @if($membre->email)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <i class="fas fa-envelope text-blue-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm">Email</p>
                            <a href="mailto:{{ $membre->email }}" class="text-white hover:text-blue-400 transition">
                                {{ $membre->email }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($membre->telephone)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                            <i class="fas fa-phone text-green-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm">Téléphone</p>
                            <a href="tel:{{ $membre->telephone }}" class="text-white hover:text-green-400 transition">
                                {{ $membre->telephone }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($membre->numero_rue || $membre->nom_rue)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-orange-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-sm">Adresse</p>
                            <p class="text-white">
                                {{ $membre->numero_rue }} {{ $membre->nom_rue }}<br>
                                {{ $membre->ville }}, {{ $membre->province }} {{ $membre->code_postal }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ceintures -->
            <div class="glass-card">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-trophy mr-3 text-yellow-400"></i>
                    Historique des ceintures
                </h3>
                
                @if($historiqueCeintures->count() > 0)
                <div class="space-y-3">
                    @foreach($historiqueCeintures as $index => $ceinture)
                    <div class="flex items-center gap-4 p-3 glass-card {{ $index === 0 ? 'border-yellow-400' : '' }}">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center"
                             style="background-color: {{ $ceinture->couleur }}">
                            <i class="fas fa-award text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ $ceinture->nom }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $ceinture->pivot->date_obtention ? 
                                   \Carbon\Carbon::parse($ceinture->pivot->date_obtention)->format('d/m/Y') : '' }}
                            </p>
                        </div>
                        @if($index === 0)
                        <span class="text-xs text-yellow-400 font-medium">Actuelle</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-4">Aucune ceinture enregistrée</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="glass-card">
                <h3 class="text-lg font-bold text-white mb-4">Actions rapides</h3>
                <div class="space-y-2">
                    @if(!$membre->approuve)
                    <button onclick="quickApprove({{ $membre->id }})"
                            class="w-full btn-glass btn-glass-primary">
                        <i class="fas fa-check mr-2"></i>Approuver
                    </button>
                    @endif
                    
                    <button onclick="attributeCeinture()" class="w-full btn-glass">
                        <i class="fas fa-award mr-2"></i>Attribuer ceinture
                    </button>
                    
                    <button onclick="inscribeSeminaire()" class="w-full btn-glass">
                        <i class="fas fa-graduation-cap mr-2"></i>Inscrire séminaire
                    </button>
                    
                    <a href="{{ route('admin.membres.history', $membre) }}" class="block w-full btn-glass text-center">
                        <i class="fas fa-clock-rotate-left mr-2"></i>Historique complet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-card max-w-2xl w-full p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Envoyer un email</h3>
            
            <form id="emailForm" action="{{ route('admin.membres.send-email', $membre) }}" method="POST">
                @csrf
                <div class="form-floating mb-4">
                    <input type="text" 
                           id="emailSubject" 
                           name="subject" 
                           class="glass-input" 
                           placeholder="Objet"
                           required>
                    <label for="emailSubject">Objet</label>
                </div>
                
                <div class="form-floating mb-4">
                    <select id="emailTemplate" class="glass-input" onchange="loadTemplate()">
                        <option value="">Sélectionner un template</option>
                        <option value="bienvenue">Bienvenue</option>
                        <option value="rappel_cours">Rappel de cours</option>
                        <option value="nouvelle_ceinture">Nouvelle ceinture</option>
                        <option value="personnalise">Personnalisé</option>
                    </select>
                    <label for="emailTemplate">Template</label>
                </div>
                
                <div class="form-floating mb-6">
                    <textarea id="emailMessage" 
                              name="message" 
                              class="glass-input" 
                              rows="10"
                              placeholder="Message"
                              required></textarea>
                    <label for="emailMessage">Message</label>
                </div>
                
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeEmailModal()" class="btn-glass">
                        Annuler
                    </button>
                    <button type="submit" class="btn-glass btn-glass-primary">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart de progression
const ctx = document.getElementById('progressionChart')?.getContext('2d');
if (ctx) {
    const progressionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Progression',
                data: [20, 35, 45, 60, 75, {{ $stats['progression_ceinture']['pourcentage'] }}],
                borderColor: '#00d4ff',
                backgroundColor: 'rgba(0, 212, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });
}

// Email Modal
function openEmailModal() {
    document.getElementById('emailModal').classList.remove('hidden');
}

function closeEmailModal() {
    document.getElementById('emailModal').classList.add('hidden');
}

function loadTemplate() {
    const template = document.getElementById('emailTemplate').value;
    const messageField = document.getElementById('emailMessage');
    const subjectField = document.getElementById('emailSubject');
    
    const templates = {
        bienvenue: {
            subject: 'Bienvenue chez Studios Unis!',
            message: `Bonjour {{ $membre->prenom }},\n\nNous sommes ravis de vous accueillir parmi nous!\n\nCordialement,\nL'équipe Studios Unis`
        },
        rappel_cours: {
            subject: 'Rappel - Votre prochain cours',
            message: `Bonjour {{ $membre->prenom }},\n\nCeci est un rappel pour votre prochain cours.\n\nÀ bientôt!\nL'équipe Studios Unis`
        },
        nouvelle_ceinture: {
            subject: 'Félicitations pour votre nouvelle ceinture!',
            message: `Bonjour {{ $membre->prenom }},\n\nFélicitations pour l'obtention de votre nouvelle ceinture!\n\nContinuez vos efforts!\nL'équipe Studios Unis`
        }
    };
    
    if (templates[template]) {
        subjectField.value = templates[template].subject;
        messageField.value = templates[template].message;
    }
}

// Export données membre
function exportMemberData() {
    if (confirm('Exporter toutes les données personnelles de ce membre?')) {
        window.location.href = `{{ route('admin.membres.export-personal', $membre) }}`;
    }
}

// Print carte membre
function printMemberCard() {
    window.open(`{{ route('admin.membres.card', $membre) }}`, '_blank');
}

// Approbation rapide
function quickApprove(id) {
    if (confirm('Approuver ce membre?')) {
        fetch(`/admin/membres/${id}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

// Attribution ceinture
function attributeCeinture() {
    // Ouvrir un modal ou rediriger vers la page d'attribution
    window.location.href = `{{ route('admin.membres.ceintures.create', $membre) }}`;
}

// Inscription séminaire
function inscribeSeminaire() {
    // Ouvrir un modal ou rediriger vers la page d'inscription
    window.location.href = `{{ route('admin.membres.seminaires.create', $membre) }}`;
}
</script>
@endpush
@endsection
