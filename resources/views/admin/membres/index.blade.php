@extends('layouts.admin')

@section('title', 'Membres')
@section('page-title', 'Gestion des Membres')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Liste des Membres</h1>
            <p class="text-gray-600">Gérez tous les membres des écoles</p>
        </div>
        <a href="{{ route('admin.membres.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nouveau Membre
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Rechercher un membre..." 
                       value="{{ request('search') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <select name="statut" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="tous">Tous les statuts</option>
                <option value="approuves" {{ request('statut') === 'approuves' ? 'selected' : '' }}>Approuvés</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
            </select>
            
            @if(auth()->user()->role === 'superadmin' && isset($ecoles))
            <select name="ecole_id" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="all">Toutes les écoles</option>
                @foreach($ecoles as $ecole)
                <option value="{{ $ecole->id }}" {{ request('ecole_id') == $ecole->id ? 'selected' : '' }}>
                    {{ $ecole->nom }}
                </option>
                @endforeach
            </select>
            @endif
            
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Liste des membres -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if(isset($membres) && $membres->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">École</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($membres as $membre)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ substr($membre->prenom, 0, 1) }}{{ substr($membre->nom, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $membre->full_name }}</div>
                                        @if($membre->date_naissance)
                                        <div class="text-sm text-gray-500">{{ $membre->age }} ans</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $membre->ecole->nom ?? 'Non assigné' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($membre->email)
                                <div>{{ $membre->email }}</div>
                                @endif
                                @if($membre->telephone)
                                <div>{{ $membre->telephone }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($membre->approuve)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approuvé
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.membres.show', $membre) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                <a href="{{ route('admin.membres.edit', $membre) }}" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                @if(!$membre->approuve)
                                <form method="POST" action="{{ route('admin.membres.approve', $membre) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-900">Approuver</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($membres, 'links'))
            <div class="px-6 py-3 bg-gray-50">
                {{ $membres->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun membre</h3>
                <p class="mt-2 text-gray-500">Commencez par ajouter votre premier membre.</p>
                <a href="{{ route('admin.membres.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Ajouter un membre
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
