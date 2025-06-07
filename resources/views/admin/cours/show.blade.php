@extends('layouts.admin')

@section('title', $cours->nom)

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-card p-6 mb-6">
            <div class="flex justify-between items-start">
                <div class="flex items-start">
                    <a href="{{ route('admin.cours.index') }}" 
                       class="glass-button mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $cours->nom }}</h1>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-gray-400">{{ $cours->ecole->nom }}</span>
                            @if($cours->session)
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-400">{{ $cours->session->nom }}</span>
                            @endif
                            @if($cours->actif)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                    Inactif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.cours.edit', $cours) }}" 
                       class="glass-button bg-yellow-600/20 hover:bg-yellow-600/30 text-yellow-400">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    <form action="{{ route('admin.cours.duplicate', $cours) }}" 
                          method="POST" 
                          class="inline">
                        @csrf
                        <button type="submit" 
                                class="glass-button bg-purple-600/20 hover:bg-purple-600/30 text-purple-400">
                            <i class="fas fa-copy mr-2"></i>
                            Dupliquer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Informations générales</h2>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Type de cours</dt>
                            <dd class="mt-1 text-white">{{ ucfirst(str_replace('_', ' ', $cours->type_cours)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Catégorie</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $cours->type == 'enfant' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                    {{ $cours->type == 'adulte' ? 'bg-purple-500/20 text-purple-400' : '' }}
                                    {{ $cours->type == 'mixte' ? 'bg-green-500/20 text-green-400' : '' }}">
                                    {{ ucfirst($cours->type) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Durée</dt>
                            <dd class="mt-1 text-white">{{ $cours->duree_minutes }} minutes</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Capacité</dt>
                            <dd class="mt-1 text-white">{{ $cours->capacite_max }} places</dd>
                        </div>
                        @if($cours->description)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-400">Description</dt>
                                <dd class="mt-1 text-gray-300">{{ $cours->description }}</dd>
                            </div>
                        @endif
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-400">Jours de la semaine</dt>
                            <dd class="mt-1 flex flex-wrap gap-2">
                                @foreach($cours->jours ?? [] as $jour)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-500/20 text-indigo-400">
                                        {{ ucfirst($jour) }}
                                    </span>
                                @endforeach
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Horaires -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Horaires</h2>
                    @if($cours->horaires->count() > 0)
                        <div class="space-y-3">
                            @foreach($cours->horaires as $horaire)
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                                    <div class="flex items-center gap-4">
                                        <i class="fas fa-clock text-indigo-400"></i>
                                        <div>
                                            <div class="font-medium text-white">{{ ucfirst($horaire->jour) }}</div>
                                            <div class="text-sm text-gray-400">
                                                {{ substr($horaire->heure_debut, 0, 5) }} - {{ substr($horaire->heure_fin, 0, 5) }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($horaire->salle)
                                        <div class="text-sm text-gray-400">
                                            <i class="fas fa-door-open mr-1"></i>
                                            {{ $horaire->salle }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">Aucun horaire défini</p>
                    @endif
                </div>

                <!-- Membres inscrits -->
                <div class="glass-card p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-white">Membres inscrits</h2>
                        <span class="text-sm text-gray-400">
                            {{ $cours->inscriptions->count() }} / {{ $cours->capacite_max }}
                        </span>
                    </div>
                    
                    @if($cours->inscriptions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-white/10">
                                        <th class="text-left p-3 text-gray-400">Membre</th>
                                        <th class="text-left p-3 text-gray-400">Date d'inscription</th>
                                        <th class="text-left p-3 text-gray-400">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cours->inscriptions()->with('membre')->get() as $inscription)
                                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                            <td class="p-3">
                                                <a href="{{ route('admin.membres.show', $inscription->membre) }}" 
                                                   class="text-indigo-400 hover:text-indigo-300">
                                                    {{ $inscription->membre->prenom }} {{ $inscription->membre->nom }}
                                                </a>
                                            </td>
                                            <td class="p-3 text-gray-300">
                                                {{ $inscription->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="p-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                                    Actif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-400">Aucune inscription pour le moment</p>
                    @endif
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-6">
                <!-- Statistiques -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Statistiques</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-400">Taux de remplissage</span>
                                <span class="text-sm font-medium text-white">
                                    {{ $cours->inscriptions->count() > 0 ? round(($cours->inscriptions->count() / $cours->capacite_max) * 100) : 0 }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" 
                                     style="width: {{ $cours->inscriptions->count() > 0 ? round(($cours->inscriptions->count() / $cours->capacite_max) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/10">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-400">Membres inscrits</span>
                                <span class="text-xl font-bold text-white">{{ $stats['inscrits'] }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-400">Présents aujourd'hui</span>
                                <span class="text-xl font-bold text-white">{{ $stats['presents_aujourdhui'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Taux de présence</span>
                                <span class="text-xl font-bold text-white">{{ $stats['taux_presence'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Actions rapides</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.presences.index', ['cours_id' => $cours->id]) }}" 
                           class="glass-button w-full justify-center bg-blue-600/20 hover:bg-blue-600/30 text-blue-400">
                            <i class="fas fa-check-circle mr-2"></i>
                            Prendre les présences
                        </a>
                        <a href="{{ route('admin.inscriptions.create', ['cours_id' => $cours->id]) }}" 
                           class="glass-button w-full justify-center bg-green-600/20 hover:bg-green-600/30 text-green-400">
                            <i class="fas fa-user-plus mr-2"></i>
                            Inscrire un membre
                        </a>
                        <button class="glass-button w-full justify-center bg-purple-600/20 hover:bg-purple-600/30 text-purple-400">
                            <i class="fas fa-envelope mr-2"></i>
                            Envoyer un message
                        </button>
                    </div>
                </div>

                <!-- Dernières présences -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Dernières présences</h3>
                    @if($cours->presences->count() > 0)
                        <div class="space-y-2">
                            @foreach($cours->presences as $presence)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-300">
                                        {{ $presence->membre->prenom }} {{ $presence->membre->nom }}
                                    </span>
                                    <span class="text-gray-400">
                                        {{ $presence->created_at->format('d/m H:i') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Aucune présence enregistrée</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
