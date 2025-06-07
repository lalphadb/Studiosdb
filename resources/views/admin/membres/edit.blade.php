@extends('layouts.admin')

@section('title', 'Modifier le Membre')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Modifier le Membre</h1>
                <p class="text-gray-300">{{ $membre->prenom }} {{ $membre->nom }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.membres.show', $membre) }}" 
                   class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fas fa-eye mr-2"></i>Voir
                </a>
                <a href="{{ route('admin.membres.index') }}" 
                   class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                <h4 class="text-red-300 font-medium mb-2">Erreurs de validation</h4>
                <ul class="text-red-300 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-8">
            <form method="POST" action="{{ route('admin.membres.update', $membre) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Le reste du formulaire est identique à la vue create, mais avec les valeurs du membre -->
                <!-- Informations personnelles -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-400"></i>Informations personnelles
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-300 mb-2">
                                Prénom <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $membre->prenom) }}" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Entrez le prénom">
                        </div>

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-300 mb-2">
                                Nom <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $membre->nom) }}" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Entrez le nom de famille">
                        </div>

                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-300 mb-2">
                                Date de naissance
                            </label>
                            <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $membre->date_naissance?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="sexe" class="block text-sm font-medium text-gray-300 mb-2">
                                Sexe
                            </label>
                            <select id="sexe" name="sexe"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionnez...</option>
                                <option value="H" {{ old('sexe', $membre->sexe) === 'H' ? 'selected' : '' }}>Homme</option>
                                <option value="F" {{ old('sexe', $membre->sexe) === 'F' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact et école sections similaires avec les valeurs du membre -->
                <!-- ... -->

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-white/20">
                    <a href="{{ route('admin.membres.show', $membre) }}" 
                       class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-medium transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
