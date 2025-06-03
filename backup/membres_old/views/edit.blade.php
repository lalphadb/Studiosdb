@extends('layouts.admin')

@section('title', 'Modifier - ' . $membre->prenom . ' ' . $membre->nom)

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 glass-card">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-gradient-to-br from-orange-500 to-red-600 rounded-full">
                    <i class="fas fa-user-edit text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Modifier le Membre</h1>
                    <p class="text-gray-400 mt-1">{{ $membre->prenom }} {{ $membre->nom }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.membres.show', $membre) }}" class="btn-secondary">
                    <i class="fas fa-eye mr-2"></i>Voir
                </a>
                <a href="{{ route('admin.membres.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="glass-card bg-red-900 bg-opacity-20 border-red-500 mb-6">
            <h4 class="text-red-400 font-bold mb-2">Erreurs de validation</h4>
            <ul class="list-disc list-inside text-red-300">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.membres.update', $membre) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informations personnelles -->
            <div class="glass-card hover-lift">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-user mr-3 text-blue-400"></i>
                    Informations personnelles
                </h3>


<!-- Photo actuelle -->
@if($membre->photo)
    <div class="mb-6 text-center">
        <p class="text-sm text-gray-400 mb-2">Photo actuelle</p>
        <img src="{{ Storage::url($membre->photo) }}" 
             class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-700">
    </div>
@endif

<div class="grid grid-cols-2 gap-4">
    <div class="form-group">
        <label class="form-label">Prénom *</label>
        <input type="text" name="prenom" value="{{ old('prenom', $membre->prenom) }}" 
               class="form-input" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" value="{{ old('nom', $membre->nom) }}" 
               class="form-input" required>
    </div>

    <div class="form-group">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" 
               value="{{ old('date_naissance', $membre->date_naissance?->format('Y-m-d')) }}" 
               class="form-input">
    </div>

    <div class="form-group">
        <label class="form-label">Sexe</label>
        <select name="sexe" class="form-input">
            <option value="">Non spécifié</option>
            <option value="H" {{ old('sexe', $membre->sexe) == 'H' ? 'selected' : '' }}>Homme</option>
            <option value="F" {{ old('sexe', $membre->sexe) == 'F' ? 'selected' : '' }}>Femme</option>
        </select>
    </div>
</div>

<div class="form-group mt-4">
    <label class="form-label">Nouvelle photo (optionnel)</label>
    <input type="file" name="photo" accept="image/*" class="form-input">
    <p class="text-xs text-gray-400 mt-1">Laissez vide pour conserver la photo actuelle</p>
</div>
            <!-- Contact et École -->
            <div class="glass-card hover-lift">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-phone mr-3 text-green-400"></i>
                    Contact et École
                </h3>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $membre->email) }}" 
                           class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ old('telephone', $membre->telephone) }}" 
                           class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">École *</label>
                    <select name="ecole_id" class="form-input" required>
                        @foreach($ecoles as $ecole)
                            <option value="{{ $ecole->id }}" 
                                {{ old('ecole_id', $membre->ecole_id) == $ecole->id ? 'selected' : '' }}>
                                {{ $ecole->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="approuve" value="1" 
                               {{ old('approuve', $membre->approuve) ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                        <span class="form-label mb-0">Membre approuvé</span>
                    </label>
                </div>
            </div>

            <!-- Adresse -->
            <div class="glass-card hover-lift">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt mr-3 text-orange-400"></i>
                    Adresse
                </h3>

                <div class="grid grid-cols-3 gap-4">
                    <div class="form-group">
                        <label class="form-label">Numéro</label>
                        <input type="text" name="numero_rue" value="{{ old('numero_rue', $membre->numero_rue) }}" 
                               class="form-input">
                    </div>
                    
                    <div class="form-group col-span-2">
                        <label class="form-label">Nom de rue</label>
                        <input type="text" name="nom_rue" value="{{ old('nom_rue', $membre->nom_rue) }}" 
                               class="form-input">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="form-group">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" value="{{ old('ville', $membre->ville) }}" 
                               class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Province</label>
                        <select name="province" class="form-input">
                            <option value="QC" {{ old('province', $membre->province) == 'QC' ? 'selected' : '' }}>Québec</option>
                            <option value="ON" {{ old('province', $membre->province) == 'ON' ? 'selected' : '' }}>Ontario</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Code postal</label>
                        <input type="text" name="code_postal" value="{{ old('code_postal', $membre->code_postal) }}" 
                               class="form-input" placeholder="H0H 0H0">
                    </div>
                </div>
            </div>

            <!-- Karaté et Séminaires -->
            <div class="glass-card hover-lift">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-purple-400"></i>
                    Karaté et Séminaires
                </h3>

                <!-- Nouvelle ceinture -->
                <div class="mb-6">
                    <label class="form-label">Attribuer une nouvelle ceinture</label>
                    <select name="ceinture_id" class="form-input">
                        <option value="">-- Conserver la ceinture actuelle --</option>
                        @foreach($ceintures as $ceinture)
                            @if(!$ceintureActuelle || $ceinture->ordre > $ceintureActuelle->ordre)
                                <option value="{{ $ceinture->id }}">
                                    {{ $ceinture->nom }} (Niveau {{ $ceinture->niveau }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @if($ceintureActuelle)
                        <p class="text-sm text-gray-400 mt-1">
                            Ceinture actuelle : {{ $ceintureActuelle->nom }}
                        </p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Date d'obtention (si nouvelle ceinture)</label>
                    <input type="date" name="date_derniere_ceinture" 
                           value="{{ old('date_derniere_ceinture', now()->format('Y-m-d')) }}" 
                           class="form-input">
                </div>

                <!-- Séminaires -->
                <div class="mt-6">
                    <label class="form-label mb-3">Séminaires</label>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($seminaires as $seminaire)
                            <label class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-gray-700 cursor-pointer">
                                <input type="checkbox" name="seminaires[]" value="{{ $seminaire->id }}"
                                       {{ in_array($seminaire->id, old('seminaires', $membreSeminaires)) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded">
                                <div class="ml-3">
                                    <p class="text-white text-sm">{{ $seminaire->nom }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($seminaire->date_debut)->format('d/m/Y') }} - {{ $seminaire->lieu }}
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('admin.membres.show', $membre) }}" class="btn-secondary">
                <i class="fas fa-times mr-2"></i>Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i>Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
.glass-card {
    @apply bg-gray-900 bg-opacity-50 backdrop-blur-xl rounded-2xl border border-gray-800 p-6
           shadow-2xl transition-all duration-300;
}

.hover-lift:hover {
    transform: translateY(-5px);
}

.form-group {
    @apply mb-4;
}

.form-label {
    @apply block text-sm font-medium text-gray-300 mb-2;
}

.form-input {
    @apply w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white
           placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500
           focus:ring-opacity-50 transition-all duration-200;
}

.btn-primary {
    @apply px-6 py-3 bg-blue-600 text-white rounded-lg font-medium
           hover:bg-blue-700 transition-all duration-200 inline-flex items-center;
}

.btn-secondary {
    @apply px-6 py-3 bg-gray-700 text-white rounded-lg font-medium
           hover:bg-gray-600 transition-all duration-200 inline-flex items-center;
}
</style>
@endpush

@push('scripts')
<script>
// Format téléphone
document.querySelector('input[name="telephone"]')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 6) {
        value = `(${value.slice(0,3)}) ${value.slice(3,6)}-${value.slice(6,10)}`;
    } else if (value.length >= 3) {
        value = `(${value.slice(0,3)}) ${value.slice(3)}`;
    }
    e.target.value = value;
});

// Format code postal
document.querySelector('input[name="code_postal"]')?.addEventListener('input', function(e) {
    let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    if (value.length >= 3) {
        value = `${value.slice(0,3)} ${value.slice(3,6)}`;
    }
    e.target.value = value;
});
</script>
@endpush
@endsection
