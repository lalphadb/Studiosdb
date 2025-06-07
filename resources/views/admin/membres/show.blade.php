@extends('layouts.admin')

@section('title', 'Détails du Membre')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ $membre->nom_complet }}</h1>
                <p class="text-gray-300">Détails du membre</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.membres.edit', $membre) }}" 
                   class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('admin.membres.index') }}" 
                   class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations personnelles -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-white mb-6">Informations personnelles</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-400">Nom complet</label>
                            <p class="text-white text-lg">{{ $membre->nom_complet }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-400">Email</label>
                            <p class="text-white">{{ $membre->email ?? 'Non renseigné' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-400">Téléphone</label>
                            <p class="text-white">{{ $membre->telephone ?? 'Non renseigné' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-400">Date de naissance</label>
                            <p class="text-white">
                                @if($membre->date_naissance)
                                    {{ $membre->date_naissance->format('d/m/Y') }} ({{ $membre->age }} ans)
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-400">Sexe</label>
                            <p class="text-white">
                                @if($membre->sexe === 'H')
                                    Homme
                                @elseif($membre->sexe === 'F')
                                    Femme
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-400">École</label>
                            <p class="text-white">{{ $membre->ecole->nom ?? 'Aucune école' }}</p>
                        </div>
                    </div>
                    
                    @if($membre->adresse_complete)
                        <div class="mt-6">
                            <label class="text-sm font-medium text-gray-400">Adresse</label>
                            <p class="text-white">{{ $membre->adresse_complete }}</p>
                        </div>
                    @endif
                </div>

                <!-- Présences récentes -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <h2 class="text-xl font-semibold text-white mb-6">Présences récentes</h2>
                    
                    @if($membre->presences->count() > 0)
                        <div class="space-y-3">
                            @foreach($membre->presences->take(10) as $presence)
                                <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                                    <div>
                                        <p class="text-white font-medium">{{ $presence->cours->nom ?? 'Cours supprimé' }}</p>
                                        <p class="text-sm text-gray-400">{{ $presence->date_presence->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        {{ $presence->status === 'present' ? 'bg-green-500/20 text-green-400' : 
                                           ($presence->status === 'retard' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                        {{ ucfirst($presence->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-8">Aucune présence enregistrée</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statut -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Statut</h3>
                    <div class="text-center">
                        <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium 
                            {{ $membre->approuve ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ $membre->statut }}
                        </span>
                        
                        @if(!$membre->approuve)
                            <form action="{{ route('admin.membres.approve', $membre) }}" method="POST" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    Approuver le membre
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Statistiques</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Présences totales</span>
                            <span class="text-white font-medium">{{ $membre->presences->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Ceintures obtenues</span>
                            <span class="text-white font-medium">{{ $membre->ceintures->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Membre depuis</span>
                            <span class="text-white font-medium">{{ $membre->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ceintures -->
                @if($membre->ceintures->count() > 0)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Ceintures</h3>
                        <div class="space-y-3">
                            @foreach($membre->ceintures->sortBy('niveau') as $ceinture)
                                <div class="flex items-center justify-between p-2 bg-white/5 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $ceinture->couleur ?? '#666' }}"></div>
                                        <span class="text-white text-sm">{{ $ceinture->nom }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">
                                        {{ $ceinture->pivot->date_obtention ? \Carbon\Carbon::parse($ceinture->pivot->date_obtention)->format('d/m/Y') : 'N/A' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
