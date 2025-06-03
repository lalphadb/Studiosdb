@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-card p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Gestion des Cours</h1>
                    <p class="text-gray-400 mt-2">Gérez les cours de karaté</p>
                </div>
                <a href="{{ route('admin.cours.create') }}" 
                   class="glass-button bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau Cours
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.cours.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Rechercher un cours..."
                               class="glass-input w-full">
                    </div>

                    <!-- Type -->
                    <div>
                        <select name="type" class="glass-input w-full">
                            <option value="">Tous les types</option>
                            <option value="enfant" {{ request('type') == 'enfant' ? 'selected' : '' }}>Enfant</option>
                            <option value="adulte" {{ request('type') == 'adulte' ? 'selected' : '' }}>Adulte</option>
                            <option value="mixte" {{ request('type') == 'mixte' ? 'selected' : '' }}>Mixte</option>
                        </select>
                    </div>

                    <!-- Session -->
                    <div>
                        <select name="session_id" class="glass-input w-full">
                            <option value="">Toutes les sessions</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                    {{ $session->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Statut -->
                    <div>
                        <select name="actif" class="glass-input w-full">
                            <option value="">Tous les statuts</option>
                            <option value="1" {{ request('actif') == '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ request('actif') == '0' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="glass-button bg-blue-600/20 hover:bg-blue-600/30 text-blue-400">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.cours.index') }}" class="glass-button">
                        <i class="fas fa-times mr-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Liste des cours -->
        <div class="glass-card">
            @if($cours->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left p-4 text-gray-400">Nom</th>
                                <th class="text-left p-4 text-gray-400">Type</th>
                                <th class="text-left p-4 text-gray-400">École</th>
                                <th class="text-left p-4 text-gray-400">Horaires</th>
                                <th class="text-left p-4 text-gray-400">Capacité</th>
                                <th class="text-left p-4 text-gray-400">Statut</th>
                                <th class="text-right p-4 text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cours as $cour)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                    <td class="p-4">
                                        <div>
                                            <div class="font-medium text-white">{{ $cour->nom }}</div>
                                            <div class="text-sm text-gray-400">{{ $cour->type_cours }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $cour->type == 'enfant' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                            {{ $cour->type == 'adulte' ? 'bg-purple-500/20 text-purple-400' : '' }}
                                            {{ $cour->type == 'mixte' ? 'bg-green-500/20 text-green-400' : '' }}">
                                            {{ ucfirst($cour->type) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-300">{{ $cour->ecole->nom }}</td>
                                    <td class="p-4">
                                        <div class="text-sm text-gray-400">
                                            @foreach($cour->horaires as $horaire)
                                                <div>{{ ucfirst($horaire->jour) }} {{ $horaire->heure_debut }} - {{ $horaire->heure_fin }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-300">
                                        <span class="text-white">{{ $cour->inscriptions_count ?? 0 }}</span> / {{ $cour->capacite_max }}
                                    </td>
                                    <td class="p-4">
                                        @if($cour->actif)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                                Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.cours.show', $cour) }}" 
                                               class="text-blue-400 hover:text-blue-300 transition-colors"
                                               title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cours.edit', $cour) }}" 
                                               class="text-yellow-400 hover:text-yellow-300 transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cours.duplicate', $cour) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-purple-400 hover:text-purple-300 transition-colors"
                                                        title="Dupliquer">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.cours.destroy', $cour) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-400 hover:text-red-300 transition-colors"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $cours->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-chalkboard-teacher text-6xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Aucun cours trouvé</p>
                    <a href="{{ route('admin.cours.create') }}" 
                       class="glass-button bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 mt-4 inline-block">
                        <i class="fas fa-plus mr-2"></i>
                        Créer le premier cours
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
