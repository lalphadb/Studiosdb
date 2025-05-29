@extends('layouts.admin')

@section('title', 'Cours')
@section('page-title', 'Gestion des Cours')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cours de Karaté</h1>
            <p class="text-gray-600">Gérez tous les cours</p>
        </div>
        <a href="{{ route('admin.cours.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            Nouveau Cours
        </a>
    </div>

    @if(isset($error))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
        En cours de développement - {{ $error }}
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($cours->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">École</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Places</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($cours as $coursItem)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $coursItem->nom }}</div>
                                @if($coursItem->instructeur)
                                <div class="text-sm text-gray-500">{{ $coursItem->instructeur }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $coursItem->ecole->nom ?? 'Non assigné' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $coursItem->places_max }} places
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $coursItem->statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($coursItem->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium space-x-2">
                                <a href="{{ route('admin.cours.show', $coursItem) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                                <a href="{{ route('admin.cours.edit', $coursItem) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900">Aucun cours</h3>
                <p class="text-gray-500">Créez votre premier cours.</p>
                <a href="{{ route('admin.cours.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Créer un cours
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
