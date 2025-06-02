@extends('layouts.admin')

@section('title', 'Nouveau Membre')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Nouveau Membre</h1>
                <p class="text-gray-300">Ajoutez un nouveau membre à l'école</p>
            </div>
            <a href="{{ route('membres.index') }}" 
               class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
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
            <form method="POST" action="{{ route('membres.store') }}" class="space-y-8">
                @csrf

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
                            <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Entrez le prénom">
                        </div>

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-300 mb-2">
                                Nom <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Entrez le nom de famille">
                        </div>

                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-300 mb-2">
                                Date de naissance
                            </label>
                            <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="sexe" class="block text-sm font-medium text-gray-300 mb-2">
                                Sexe
                            </label>
                            <select id="sexe" name="sexe"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionnez...</option>
                                <option value="H" {{ old('sexe') === 'H' ? 'selected' : '' }}>Homme</option>
                                <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Informations de contact -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-envelope mr-3 text-green-400"></i>Contact
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                Adresse email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="exemple@email.com">
                        </div>

                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-300 mb-2">
                                Téléphone
                            </label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="(418) 555-0123">
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-purple-400"></i>Adresse
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="numero_rue" class="block text-sm font-medium text-gray-300 mb-2">
                                Numéro
                            </label>
                            <input type="text" id="numero_rue" name="numero_rue" value="{{ old('numero_rue') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="123">
                        </div>

                        <div class="md:col-span-2">
                            <label for="nom_rue" class="block text-sm font-medium text-gray-300 mb-2">
                                Nom de la rue
                            </label>
                            <input type="text" id="nom_rue" name="nom_rue" value="{{ old('nom_rue') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Rue Principale">
                        </div>

                        <div>
                            <label for="code_postal" class="block text-sm font-medium text-gray-300 mb-2">
                                Code postal
                            </label>
                            <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="G1A 1A1">
                        </div>

                        <div>
                            <label for="ville" class="block text-sm font-medium text-gray-300 mb-2">
                                Ville
                            </label>
                            <input type="text" id="ville" name="ville" value="{{ old('ville') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Québec">
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-300 mb-2">
                                Province
                            </label>
                            <select id="province" name="province"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="QC" {{ old('province', 'QC') === 'QC' ? 'selected' : '' }}>Québec</option>
                                <option value="ON" {{ old('province') === 'ON' ? 'selected' : '' }}>Ontario</option>
                                <option value="BC" {{ old('province') === 'BC' ? 'selected' : '' }}>Colombie-Britannique</option>
                                <option value="AB" {{ old('province') === 'AB' ? 'selected' : '' }}>Alberta</option>
                                <option value="MB" {{ old('province') === 'MB' ? 'selected' : '' }}>Manitoba</option>
                                <option value="SK" {{ old('province') === 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                                <option value="NS" {{ old('province') === 'NS' ? 'selected' : '' }}>Nouvelle-Écosse</option>
                                <option value="NB" {{ old('province') === 'NB' ? 'selected' : '' }}>Nouveau-Brunswick</option>
                                <option value="NL" {{ old('province') === 'NL' ? 'selected' : '' }}>Terre-Neuve-et-Labrador</option>
                                <option value="PE" {{ old('province') === 'PE' ? 'selected' : '' }}>Île-du-Prince-Édouard</option>
                                <option value="YT" {{ old('province') === 'YT' ? 'selected' : '' }}>Yukon</option>
                                <option value="NT" {{ old('province') === 'NT' ? 'selected' : '' }}>Territoires du Nord-Ouest</option>
                                <option value="NU" {{ old('province') === 'NU' ? 'selected' : '' }}>Nunavut</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- École et statut -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-school mr-3 text-orange-400"></i>École et statut
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ecole_id" class="block text-sm font-medium text-gray-300 mb-2">
                                École <span class="text-red-400">*</span>
                            </label>
                            <select id="ecole_id" name="ecole_id" required
                                    class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionnez une école...</option>
                                @foreach($ecoles as $ecole)
                                    <option value="{{ $ecole->id }}" {{ old('ecole_id') == $ecole->id ? 'selected' : '' }}>
                                        {{ $ecole->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center mt-8">
                            <input type="checkbox" id="approuve" name="approuve" value="1" {{ old('approuve') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="approuve" class="ml-3 text-sm text-gray-300">
                                Approuver le membre immédiatement
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-white/20">
                    <a href="{{ route('membres.index') }}" 
                       class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-medium transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Créer le membre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation du code postal canadien
    const codePostalInput = document.getElementById('code_postal');
    if (codePostalInput) {
        codePostalInput.addEventListener('blur', function() {
            const value = this.value.trim().toUpperCase();
            const canadianPostalRegex = /^[A-Z]\d[A-Z]\s?\d[A-Z]\d$/;
            
            if (value && !canadianPostalRegex.test(value)) {
                this.setCustomValidity('Format de code postal invalide (ex: G1A 1A1)');
            } else {
                this.setCustomValidity('');
                if (value && !value.includes(' ') && value.length === 6) {
                    this.value = value.slice(0, 3) + ' ' + value.slice(3);
                }
            }
        });
    }

    // Formatage automatique du téléphone
    const telephoneInput = document.getElementById('telephone');
    if (telephoneInput) {
        telephoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
            }
            e.target.value = value;
        });
    }
});
</script>
@endsection
