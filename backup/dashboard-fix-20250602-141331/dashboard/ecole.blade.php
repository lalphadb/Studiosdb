@extends('layouts.admin')

@section('title', 'Tableau de bord - ' . $ecole->nom)

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-purple-600 bg-clip-text text-transparent">
                {{ $ecole->nom }}
            </h1>
            <p class="text-gray-400 mt-2">{{ $ecole->ville }}, {{ $ecole->province }}</p>
        </div>

        <!-- Cartes d'action rapide -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Membres en attente -->
            @if($stats['membres_en_attente'] > 0)
            <div class="glassmorphic-card p-6 border-l-4 border-yellow-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-400 font-semibold">Action requise</p>
                        <p class="text-2xl font-bold text-white mt-2">{{ $stats['membres_en_attente'] }}</p>
                        <p class="text-gray-400">Membres en attente</p>
                    </div>
                    <i class="fas fa-user-clock text-3xl text-yellow-400"></i>
                </div>
                <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" 
                   class="mt-4 inline-flex items-center text-yellow-400 hover:text-yellow-300">
                    Voir les demandes <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endif

            <!-- Prochaine session -->
            @if($prochainesSessions->count() > 0)
            <div class="glassmorphic-card p-6">
                <p class="text-cyan-400 font-semibold mb-2">Prochaine session</p>
                <p class="text-white font-bold">{{ $prochainesSessions->first()->cours->nom }}</p>
                <p class="text-gray-400 text-sm mt-1">
                    {{ $prochainesSessions->first()->date_debut->format('d/m/Y H:i') }}
                </p>
                <a href="{{ route('admin.sessions.index') }}" 
                   class="mt-4 inline-flex items-center text-cyan-400 hover:text-cyan-300">
                    Gérer les sessions <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endif

            <!-- Actions rapides -->
            <div class="glassmorphic-card p-6">
                <p class="text-purple-400 font-semibold mb-4">Actions rapides</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.membres.create') }}" 
                       class="block p-2 rounded hover:bg-white/10 text-white transition">
                        <i class="fas fa-user-plus mr-2"></i> Nouveau membre
                    </a>
                    <a href="{{ route('admin.cours.create') }}" 
                       class="block p-2 rounded hover:bg-white/10 text-white transition">
                        <i class="fas fa-plus-circle mr-2"></i> Nouveau cours
                    </a>
                    <a href="{{ route('admin.sessions.create') }}" 
                       class="block p-2 rounded hover:bg-white/10 text-white transition">
                        <i class="fas fa-calendar-plus mr-2"></i> Nouvelle session
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glassmorphic-card p-4 text-center">
                <p class="text-3xl font-bold text-white">{{ $stats['total_membres'] }}</p>
                <p class="text-gray-400 text-sm">Total membres</p>
            </div>
            <div class="glassmorphic-card p-4 text-center">
                <p class="text-3xl font-bold text-green-400">{{ $stats['membres_approuves'] }}</p>
                <p class="text-gray-400 text-sm">Approuvés</p>
            </div>
            <div class="glassmorphic-card p-4 text-center">
                <p class="text-3xl font-bold text-cyan-400">{{ $stats['total_cours'] }}</p>
                <p class="text-gray-400 text-sm">Cours</p>
            </div>
            <div class="glassmorphic-card p-4 text-center">
                <p class="text-3xl font-bold text-orange-400">{{ $stats['sessions_actives'] }}</p>
                <p class="text-gray-400 text-sm">Sessions actives</p>
            </div>
        </div>

        <!-- Liste des membres en attente -->
        @if($membresEnAttente->count() > 0)
        <div class="glassmorphic-card p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Membres en attente d'approbation</h3>
            <div class="space-y-2">
                @foreach($membresEnAttente as $membre)
                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 hover:bg-white/10 transition">
                    <div>
                        <p class="text-white font-medium">{{ $membre->prenom }} {{ $membre->nom }}</p>
                        <p class="text-gray-400 text-sm">Inscrit le {{ $membre->created_at->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ route('admin.membres.show', $membre) }}" 
                       class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition">
                        Examiner
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
