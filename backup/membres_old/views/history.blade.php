@extends('layouts.admin')

@section('title', 'Historique - ' . $membre->prenom . ' ' . $membre->nom)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic.css') }}">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="glass-card mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-history text-neon-purple"></i>
                        Historique complet
                    </h1>
                    <p class="text-gray-400 mt-1">
                        {{ $membre->prenom }} {{ $membre->nom }}
                    </p>
                </div>
                <a href="{{ route('admin.membres.show', $membre) }}" class="btn-glass">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au profil
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Timeline d'activité -->
            <div class="lg:col-span-2">
                <div class="glass-card">
                    <h3 class="text-xl font-bold text-white mb-6">
                        <i class="fas fa-stream mr-2"></i>
                        Activité récente
                    </h3>
                    
                    <div class="timeline-container">
                        <div class="timeline-line"></div>
                        
                        @forelse($activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="glass-card p-4 ml-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-white font-medium">{{ $activity->description }}</p>
                                        <p class="text-gray-400 text-sm mt-1">
                                            Par {{ $activity->causer ? $activity->causer->name : 'Système' }}
                                        </p>
                                        @if($activity->properties && count($activity->properties) > 0)
                                        <div class="mt-2 text-xs text-gray-500">
                                            @foreach($activity->properties as $key => $value)
                                                <span class="inline-block bg-gray-800 px-2 py-1 rounded mr-1 mb-1">
                                                    {{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}
                                                </span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-center py-8">Aucune activité enregistrée</p>
                        @endforelse
                    </div>
                    
                    @if($activities->hasPages())
                    <div class="mt-6">
                        {{ $activities->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats et résumés -->
            <div class="space-y-6">
                <!-- Historique Ceintures -->
                <div class="glass-card">
                    <h3 class="text-lg font-bold text-white mb-4">
                        <i class="fas fa-award mr-2 text-yellow-400"></i>
                        Progression des ceintures
                    </h3>
                    
                    @if($historiqueCeintures->count() > 0)
                    <div class="space-y-3">
                        @foreach($historiqueCeintures as $ceinture)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                 style="background-color: {{ $ceinture->couleur }}">
                                <i class="fas fa-trophy text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white text-sm">{{ $ceinture->nom }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $ceinture->pivot->date_obtention ? 
                                       \Carbon\Carbon::parse($ceinture->pivot->date_obtention)->format('d/m/Y') : '' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-400 text-sm">Aucune ceinture enregistrée</p>
                    @endif
                </div>

                <!-- Statistiques de présences -->
                <div class="glass-card">
                    <h3 class="text-lg font-bold text-white mb-4">
                        <i class="fas fa-chart-line mr-2 text-green-400"></i>
                        Statistiques de présence
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Total présences</span>
                                <span class="text-white font-medium">
                                    {{ $historiquePresences->where('status', 'present')->count() }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2 mt-1">
                                <div class="bg-green-500 h-2 rounded-full" 
                                     style="width: {{ $historiquePresences->count() > 0 ? 
                                        ($historiquePresences->where('status', 'present')->count() / $historiquePresences->count() * 100) : 0 
                                     }}%"></div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div>
                                <p class="text-2xl font-bold text-green-400">
                                    {{ $historiquePresences->where('status', 'present')->count() }}
                                </p>
                                <p class="text-xs text-gray-400">Présent</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-red-400">
                                    {{ $historiquePresences->where('status', 'absent')->count() }}
                                </p>
                                <p class="text-xs text-gray-400">Absent</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-yellow-400">
                                    {{ $historiquePresences->where('status', 'retard')->count() }}
                                </p>
                                <p class="text-xs text-gray-400">Retard</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="glass-card">
                    <h3 class="text-lg font-bold text-white mb-4">Actions</h3>
                    <div class="space-y-2">
                        <button onclick="exportHistory()" class="w-full btn-glass">
                            <i class="fas fa-download mr-2"></i>
                            Exporter l'historique
                        </button>
                        <button onclick="printHistory()" class="w-full btn-glass">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportHistory() {
    window.location.href = `{{ route('admin.membres.export-personal', $membre) }}`;
}

function printHistory() {
    window.print();
}
</script>
@endpush
@endsection
