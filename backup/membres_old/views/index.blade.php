@extends('layouts.admin')

@section('title', 'Gestion des Membres')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic.css') }}">
<style>
.view-toggle {
    display: flex;
    background: var(--glass-primary);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    padding: 4px;
}

.view-toggle button {
    padding: 8px 16px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 8px;
}

.view-toggle button.active {
    background: var(--gradient-primary);
    color: white;
}

.search-advanced {
    position: relative;
}

.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--glass-primary);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    margin-top: 8px;
    max-height: 300px;
    overflow-y: auto;
    display: none;
}

.search-suggestions.show {
    display: block;
}

.search-suggestion {
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-suggestion:hover {
    background: rgba(255, 255, 255, 0.05);
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    background: var(--glass-primary);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    color: white;
    font-size: 14px;
}

.filter-chip button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0;
    width: 16px;
    height: 16px;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-6">
    <!-- Header avec stats -->
    <div class="glass-card mb-8">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between p-6">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-users text-neon-blue"></i>
                    Gestion des Membres
                </h1>
                <p class="text-gray-400 mt-2">{{ $stats['total'] }} membres au total</p>
            </div>
            
            <div class="flex items-center gap-4 mt-4 lg:mt-0">
                <!-- Vue Toggle -->
                <div class="view-toggle">
                    <button class="active" onclick="setView('table')">
                        <i class="fas fa-table"></i>
                    </button>
                    <button onclick="setView('kanban')">
                        <i class="fas fa-columns"></i>
                    </button>
                    <button onclick="setView('grid')">
                        <i class="fas fa-th"></i>
                    </button>
                </div>
                
                <!-- Add Member -->
                <a href="{{ route('admin.membres.create') }}" 
                   class="btn-glass btn-glass-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau membre
                </a>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-6 pb-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                <p class="text-gray-400 text-sm">Total</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-green-400">{{ $stats['approuves'] }}</p>
                <p class="text-gray-400 text-sm">Approuvés</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-yellow-400">{{ $stats['en_attente'] }}</p>
                <p class="text-gray-400 text-sm">En attente</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-blue-400">{{ $stats['ce_mois'] }}</p>
                <p class="text-gray-400 text-sm">Ce mois</p>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="glass-card mb-6 p-6">
        <form id="filterForm" method="GET" class="space-y-4">
            <!-- Search -->
            <div class="search-advanced">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                           id="searchInput"
                           name="search" 
                           class="glass-input pl-12"
                           placeholder="Rechercher par nom, email, téléphone..."
                           value="{{ request('search') }}"
                           autocomplete="off">
                    <button type="button" 
                            onclick="clearSearch()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Search Suggestions -->
                <div id="searchSuggestions" class="search-suggestions"></div>
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-4">
                @if(auth()->user()->role === 'superadmin')
                <select name="ecole_id" class="glass-input w-auto">
                    <option value="">Toutes les écoles</option>
                    @foreach($ecoles as $ecole)
                        <option value="{{ $ecole->id }}" {{ request('ecole_id') == $ecole->id ? 'selected' : '' }}>
                            {{ $ecole->nom }}
                        </option>
                    @endforeach
                </select>
                @endif
                
                <select name="statut" class="glass-input w-auto">
                    <option value="">Tous les statuts</option>
                    <option value="approuve" {{ request('statut') == 'approuve' ? 'selected' : '' }}>Approuvés</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                </select>
                
                <select name="ceinture" class="glass-input w-auto">
                    <option value="">Toutes les ceintures</option>
                    @foreach($ceintures as $ceinture)
                        <option value="{{ $ceinture->id }}" {{ request('ceinture') == $ceinture->id ? 'selected' : '' }}>
                            {{ $ceinture->nom }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn-glass btn-glass-primary">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
                
                @if(request()->hasAny(['search', 'ecole_id', 'statut', 'ceinture']))
                <a href="{{ route('admin.membres.index') }}" class="btn-glass">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
                @endif
            </div>
            
            <!-- Active Filters -->
            @if(request()->hasAny(['search', 'ecole_id', 'statut', 'ceinture']))
            <div class="flex flex-wrap gap-2 mt-4">
                @if(request('search'))
                <div class="filter-chip">
                    <span>Recherche: {{ request('search') }}</span>
                    <button type="button" onclick="removeFilter('search')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif
                
                @if(request('ecole_id'))
                <div class="filter-chip">
                    <span>École: {{ $ecoles->find(request('ecole_id'))->nom }}</span>
                    <button type="button" onclick="removeFilter('ecole_id')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif
            </div>
            @endif
        </form>
    </div>

    <!-- Table View (default) -->
    <div id="tableView" class="view-content">
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left p-4 text-gray-400 font-medium">
                                <input type="checkbox" onclick="toggleAll(this)" class="rounded">
                            </th>
                            <th class="text-left p-4 text-gray-400 font-medium">Membre</th>
                            <th class="text-left p-4 text-gray-400 font-medium">Contact</th>
                            <th class="text-left p-4 text-gray-400 font-medium">École</th>
                            <th class="text-left p-4 text-gray-400 font-medium">Ceinture</th>
                            <th class="text-left p-4 text-gray-400 font-medium">Statut</th>
                            <th class="text-left p-4 text-gray-400 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($membres as $membre)
                        <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                            <td class="p-4">
                                <input type="checkbox" class="member-checkbox rounded" value="{{ $membre->id }}">
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                        @if($membre->photo)
                                            <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                                {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                        <p class="text-gray-400 text-sm">
                                            @if($membre->age)
                                                {{ $membre->age }} ans
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="space-y-1">
                                    @if($membre->email)
                                        <p class="text-gray-300 text-sm">{{ $membre->email }}</p>
                                    @endif
                                    @if($membre->telephone)
                                        <p class="text-gray-300 text-sm">{{ $membre->telephone }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-gray-300">{{ $membre->ecole->nom ?? 'Non assigné' }}</span>
                            </td>
                            <td class="p-4">
                                @if($membre->derniere_ceinture)
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full" 
                                         style="background-color: {{ $membre->derniere_ceinture->couleur }}"></div>
                                    <span class="text-gray-300 text-sm">{{ $membre->derniere_ceinture->nom }}</span>
                                </div>
                                @else
                                <span class="text-gray-500 text-sm">Aucune</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                    {{ $membre->approuve ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                    {{ $membre->approuve ? 'Approuvé' : 'En attente' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.membres.show', $membre) }}" 
                                       class="text-gray-400 hover:text-white transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.membres.edit', $membre) }}" 
                                       class="text-gray-400 hover:text-blue-400 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteMember({{ $membre->id }})"
                                            class="text-gray-400 hover:text-red-400 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                <i class="fas fa-users text-4xl mb-4 block opacity-50"></i>
                                Aucun membre trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kanban View -->
    <div id="kanbanView" class="view-content" style="display: none;">
        <div class="kanban-container">
            <!-- Colonne En Attente -->
            <div class="kanban-column" data-status="en_attente">
                <div class="kanban-header">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-clock text-yellow-400"></i>
                        En attente
                    </h3>
                    <span class="text-gray-400 text-sm">{{ $stats['en_attente'] }}</span>
                </div>
                
                <div class="kanban-cards" data-status="en_attente">
                    @foreach($membres->where('approuve', false) as $membre)
                    <div class="kanban-card" draggable="true" data-id="{{ $membre->id }}">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                @if($membre->photo)
                                    <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                <p class="text-gray-400 text-xs">{{ $membre->ecole->nom ?? 'Non assigné' }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            @if($membre->email)
                            <p class="text-gray-300 flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-500 text-xs"></i>
                                {{ Str::limit($membre->email, 20) }}
                            </p>
                            @endif
                            @if($membre->telephone)
                            <p class="text-gray-300 flex items-center gap-2">
                                <i class="fas fa-phone text-gray-500 text-xs"></i>
                                {{ $membre->telephone }}
                            </p>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-xs text-gray-400">
                                {{ $membre->created_at->diffForHumans() }}
                            </span>
                            <button onclick="quickApprove({{ $membre->id }})" 
                                    class="text-green-400 hover:text-green-300 text-sm">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Colonne Approuvés -->
            <div class="kanban-column" data-status="approuve">
                <div class="kanban-header">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400"></i>
                        Approuvés
                    </h3>
                    <span class="text-gray-400 text-sm">{{ $stats['approuves'] }}</span>
                </div>
                
                <div class="kanban-cards" data-status="approuve">
                    @foreach($membres->where('approuve', true)->take(10) as $membre)
                    <div class="kanban-card" draggable="true" data-id="{{ $membre->id }}">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                @if($membre->photo)
                                    <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($membre->derniere_ceinture)
                                    <div class="w-3 h-3 rounded-full" 
                                         style="background-color: {{ $membre->derniere_ceinture->couleur }}"></div>
                                    <span class="text-gray-400 text-xs">{{ $membre->derniere_ceinture->nom }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">
                                {{ $membre->ecole->nom ?? 'Non assigné' }}
                            </span>
                            <a href="{{ route('admin.membres.show', $membre) }}" 
                               class="text-blue-400 hover:text-blue-300 text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Colonne Nouveaux -->
            <div class="kanban-column" data-status="nouveau">
                <div class="kanban-header">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-sparkles text-blue-400"></i>
                        Nouveaux ce mois
                    </h3>
                    <span class="text-gray-400 text-sm">{{ $stats['ce_mois'] }}</span>
                </div>
                
                <div class="kanban-cards" data-status="nouveau">
                    @foreach($membres->filter(function($m) { 
                        return $m->created_at->isCurrentMonth(); 
                    })->take(10) as $membre)
                    <div class="kanban-card" draggable="true" data-id="{{ $membre->id }}">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                @if($membre->photo)
                                    <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                <p class="text-gray-400 text-xs">
                                    Inscrit {{ $membre->created_at->format('d/m') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                                {{ $membre->approuve ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $membre->approuve ? 'Actif' : 'En attente' }}
                            </span>
                            <a href="{{ route('admin.membres.show', $membre) }}" 
                               class="text-blue-400 hover:text-blue-300 text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Grid View -->
    <div id="gridView" class="view-content" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($membres as $membre)
            <div class="glass-card p-6 hover:transform hover:scale-105 transition-all">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-4">
                        @if($membre->photo)
                            <img src="{{ Storage::url($membre->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                                {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-white font-semibold">{{ $membre->prenom }} {{ $membre->nom }}</h3>
                    <p class="text-gray-400 text-sm">{{ $membre->ecole->nom ?? 'Non assigné' }}</p>
                </div>
                
                <div class="space-y-2 mb-4">
                    @if($membre->email)
                    <p class="text-gray-300 text-sm flex items-center gap-2">
                        <i class="fas fa-envelope text-gray-500"></i>
                        {{ Str::limit($membre->email, 20) }}
                    </p>
                    @endif
                    @if($membre->telephone)
                    <p class="text-gray-300 text-sm flex items-center gap-2">
                        <i class="fas fa-phone text-gray-500"></i>
                        {{ $membre->telephone }}
                    </p>
                    @endif
                    @if($membre->derniere_ceinture)
                    <p class="text-gray-300 text-sm flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full" 
                             style="background-color: {{ $membre->derniere_ceinture->couleur }}"></div>
                        {{ $membre->derniere_ceinture->nom }}
                    </p>
                    @endif
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-gray-700">
                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                        {{ $membre->approuve ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                        {{ $membre->approuve ? 'Actif' : 'En attente' }}
                    </span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.membres.show', $membre) }}" 
                           class="text-gray-400 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.membres.edit', $membre) }}" 
                           class="text-gray-400 hover:text-blue-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $membres->appends(request()->query())->links() }}
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 glass-card p-4 hidden">
        <div class="flex items-center gap-4">
            <span class="text-white">
                <span id="selectedCount">0</span> sélectionné(s)
            </span>
            <button onclick="bulkApprove()" class="btn-glass btn-glass-primary">
                <i class="fas fa-check mr-2"></i>Approuver
            </button>
            <button onclick="bulkExport()" class="btn-glass">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
            <button onclick="bulkDelete()" class="btn-glass">
                <i class="fas fa-trash mr-2"></i>Supprimer
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// View Management
let currentView = localStorage.getItem('membersView') || 'table';
document.addEventListener('DOMContentLoaded', () => setView(currentView));

function setView(view) {
    // Hide all views
    document.querySelectorAll('.view-content').forEach(v => v.style.display = 'none');
    
    // Show selected view
    document.getElementById(view + 'View').style.display = 'block';
    
    // Update toggle buttons
    document.querySelectorAll('.view-toggle button').forEach(btn => btn.classList.remove('active'));
    event?.target?.classList.add('active');
    
    // Save preference
    localStorage.setItem('membersView', view);
    currentView = view;
}

// Search with suggestions
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const searchSuggestions = document.getElementById('searchSuggestions');

searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    const query = e.target.value;
    
    if (query.length < 2) {
        searchSuggestions.classList.remove('show');
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetchSuggestions(query);
    }, 300);
});

async function fetchSuggestions(query) {
    try {
        const response = await fetch(`/admin/membres/search?q=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        displaySuggestions(data);
    } catch (error) {
        console.error('Search error:', error);
    }
}

function displaySuggestions(membres) {
    if (membres.length === 0) {
        searchSuggestions.classList.remove('show');
        return;
    }
    
    searchSuggestions.innerHTML = membres.map(membre => `
        <div class="search-suggestion" onclick="selectMember(${membre.id})">
            <div class="w-10 h-10 rounded-full overflow-hidden">
                ${membre.photo ? 
                    `<img src="/storage/${membre.photo}" class="w-full h-full object-cover">` :
                    `<div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                        ${membre.prenom.charAt(0)}${membre.nom.charAt(0)}
                    </div>`
                }
            </div>
            <div class="flex-1">
                <p class="text-white">${membre.prenom} ${membre.nom}</p>
                <p class="text-gray-400 text-sm">${membre.email || ''}</p>
            </div>
            <span class="text-xs ${membre.approuve ? 'text-green-400' : 'text-yellow-400'}">
                ${membre.approuve ? 'Actif' : 'En attente'}
            </span>
        </div>
    `).join('');
    
    searchSuggestions.classList.add('show');
}

function selectMember(id) {
    window.location.href = `/admin/membres/${id}`;
}

function clearSearch() {
    searchInput.value = '';
    searchSuggestions.classList.remove('show');
}

// Click outside to close suggestions
document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
        searchSuggestions.classList.remove('show');
    }
});

// Drag & Drop for Kanban
let draggedElement = null;

document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners to cards
    document.querySelectorAll('.kanban-card').forEach(card => {
        card.addEventListener('dragstart', handleDragStart);
        card.addEventListener('dragend', handleDragEnd);
    });
    
    // Add event listeners to columns
    document.querySelectorAll('.kanban-cards').forEach(column => {
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
    });
});

function handleDragStart(e) {
    draggedElement = e.target;
    e.target.classList.add('dragging');
}

function handleDragEnd(e) {
    e.target.classList.remove('dragging');
}

function handleDragOver(e) {
    e.preventDefault();
    const afterElement = getDragAfterElement(e.currentTarget, e.clientY);
    if (afterElement == null) {
        e.currentTarget.appendChild(draggedElement);
    } else {
        e.currentTarget.insertBefore(draggedElement, afterElement);
    }
}

function handleDrop(e) {
    e.preventDefault();
    const memberId = draggedElement.dataset.id;
    const newStatus = e.currentTarget.dataset.status;
    
    // Update member status
    updateMemberStatus(memberId, newStatus);
}

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.kanban-card:not(.dragging)')];
    
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

async function updateMemberStatus(memberId, status) {
    try {
        const response = await fetch(`/admin/membres/${memberId}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: status })
        });
        
        if (response.ok) {
            showToast('Statut mis à jour', 'success');
        }
    } catch (error) {
        showToast('Erreur lors de la mise à jour', 'error');
    }
}

// Filter management
function removeFilter(filterName) {
    const form = document.getElementById('filterForm');
    const input = form.querySelector(`[name="${filterName}"]`);
    if (input) {
        input.value = '';
        form.submit();
    }
}

// Checkbox management
function toggleAll(source) {
    const checkboxes = document.querySelectorAll('.member-checkbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.member-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkActions.classList.add('hidden');
    }
}

// Add event listeners to all checkboxes
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('member-checkbox')) {
        updateBulkActions();
    }
});

// Quick actions
async function quickApprove(id) {
    try {
        const response = await fetch(`/admin/membres/${id}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showToast('Membre approuvé', 'success');
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        showToast('Erreur lors de l\'approbation', 'error');
    }
}

// Bulk actions
function getSelectedIds() {
    return Array.from(document.querySelectorAll('.member-checkbox:checked'))
        .map(cb => cb.value);
}

async function bulkApprove() {
    const ids = getSelectedIds();
    if (ids.length === 0) return;
    
    if (!confirm(`Approuver ${ids.length} membre(s)?`)) return;
    
    try {
        const response = await fetch('/admin/membres/bulk-approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        });
        
        if (response.ok) {
            showToast(`${ids.length} membre(s) approuvé(s)`, 'success');
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        showToast('Erreur lors de l\'approbation', 'error');
    }
}

function bulkExport() {
    const ids = getSelectedIds();
    if (ids.length === 0) return;
    
    window.location.href = `/admin/membres/export?ids=${ids.join(',')}&format=excel`;
}

function bulkDelete() {
    const ids = getSelectedIds();
    if (ids.length === 0) return;
    
    if (!confirm(`Supprimer ${ids.length} membre(s)? Cette action est irréversible.`)) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/membres/bulk-delete';
    form.innerHTML = `
        @csrf
        <input type="hidden" name="ids" value="${ids.join(',')}">
    `;
    document.body.appendChild(form);
    form.submit();
}

function deleteMember(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce membre?')) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/membres/${id}`;
    form.innerHTML = `
        @csrf
        @method('DELETE')
    `;
    document.body.appendChild(form);
    form.submit();
}

// Toast notifications
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-glass ${type} show`;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
        ${message}
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection
