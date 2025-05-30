@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Cours de Karaté</h1>
                <p class="text-gray-300">Gérez tous les cours</p>
            </div>
            <a href="{{ route('admin.cours.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nouveau Cours
            </a>
        </div>

        @if($cours->count() > 0)
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cours</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">École</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Session</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Niveau</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Places</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($cours as $cour)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-white">{{ $cour->nom }}</div>
                                        <div class="text-sm text-gray-400">{{ Str::limit($cour->description ?? '', 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-300">{{ $cour->ecole->nom ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-300">{{ $cour->session->nom ?? 'Aucune session' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400">
                                            {{ ucfirst($cour->niveau ?? 'tous_niveaux') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $cour->places_max ?? 20 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cour->statut === 'actif' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                            {{ ucfirst($cour->statut ?? 'inactif') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.cours.show', $cour) }}" 
                                               class="text-blue-400 hover:text-blue-300 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cours.edit', $cour) }}" 
                                               class="text-green-400 hover:text-green-300 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($cours->hasPages())
                <div class="mt-8">
                    {{ $cours->links() }}
                </div>
            @endif
        @else
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-12 text-center">
                <i class="fas fa-graduation-cap text-6xl text-gray-600 mb-6"></i>
                <h3 class="text-2xl font-bold text-white mb-4">Aucun cours</h3>
                <p class="text-gray-400 mb-8">Créez votre premier cours de karaté pour commencer.</p>
                <a href="{{ route('admin.cours.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-medium transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>Créer un cours
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
