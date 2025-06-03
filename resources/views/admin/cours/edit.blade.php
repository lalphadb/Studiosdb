@extends('layouts.admin')

@section('title', 'Modifier le Cours')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-card p-6 mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.cours.show', $cours) }}" 
                   class="glass-button mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">Modifier le Cours</h1>
                    <p class="text-gray-400 mt-2">{{ $cours->nom }}</p>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('admin.cours.update', $cours) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Informations générales -->
            <div class="glass-card p-6 mb-6">
                <h2 class="text-xl font-semibold text-white mb-4">Informations générales</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Nom du cours <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="nom" 
                               value="{{ old('nom', $cours->nom) }}"
                               class="glass-input w-full @error('nom') border-red-500 @enderror"
                               required>
                        @error('nom')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type de cours -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Type de cours <span class="text-red-400">*</span>
                        </label>
                        <select name="type_cours" 
                                class="glass-input w-full @error('type_cours') border-red-500 @enderror"
                                required>
                            <option value="regulier" {{ old('type_cours', $cours->type_cours) == 'regulier' ? 'selected' : '' }}>Régulier</option>
                            <option value="parent_enfant" {{ old('type_cours', $cours->type_cours) == 'parent_enfant' ? 'selected' : '' }}>Parent-Enfant</option>
                            <option value="ceinture_avancee" {{ old('type_cours', $cours->type_cours) == 'ceinture_avancee' ? 'selected' : '' }}>Ceinture Avancée</option>
                            <option value="competition" {{ old('type_cours', $cours->type_cours) == 'competition' ? 'selected' : '' }}>Compétition</option>
                            <option value="prive" {{ old('type_cours', $cours->type_cours) == 'prive' ? 'selected' : '' }}>Privé</option>
                        </select>
                        @error('type_cours')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Catégorie <span class="text-red-400">*</span>
                        </label>
                        <select name="type" 
                                class="glass-input w-full @error('type') border-red-500 @enderror"
                                required>
                            <option value="enfant" {{ old('type', $cours->type) == 'enfant' ? 'selected' : '' }}>Enfant</option>
                            <option value="adulte" {{ old('type', $cours->type) == 'adulte' ? 'selected' : '' }}>Adulte</option>
                            <option value="mixte" {{ old('type', $cours->type) == 'mixte' ? 'selected' : '' }}>Mixte</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- École (lecture seule) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            École
                        </label>
                        <input type="text" 
                               value="{{ $cours->ecole->nom }}"
                               class="glass-input w-full opacity-50"
                               disabled>
                    </div>

                    <!-- Session -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Session
                        </label>
                        <select name="session_id" 
                                class="glass-input w-full @error('session_id') border-red-500 @enderror">
                            <option value="">Aucune session</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" {{ old('session_id', $cours->session_id) == $session->id ? 'selected' : '' }}>
                                    {{ $session->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('session_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacité -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Capacité maximale <span class="text-red-400">*</span>
                        </label>
                        <input type="number" 
                               name="capacite_max" 
                               value="{{ old('capacite_max', $cours->capacite_max) }}"
                               min="1"
                               max="100"
                               class="glass-input w-full @error('capacite_max') border-red-500 @enderror"
                               required>
                        @error('capacite_max')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Durée (minutes) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" 
                               name="duree_minutes" 
                               value="{{ old('duree_minutes', $cours->duree_minutes) }}"
                               min="30"
                               max="180"
                               step="15"
                               class="glass-input w-full @error('duree_minutes') border-red-500 @enderror"
                               required>
                        @error('duree_minutes')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Statut
                        </label>
                        <select name="actif" class="glass-input w-full">
                            <option value="1" {{ old('actif', $cours->actif) == '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('actif', $cours->actif) == '0' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="3"
                              class="glass-input w-full @error('description') border-red-500 @enderror">{{ old('description', $cours->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jours -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">
                        Jours de la semaine <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @php
                            $selectedJours = old('jours', $cours->jours ?? []);
                        @endphp
                        @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                            <label class="glass-card p-3 cursor-pointer hover:bg-white/10 transition-colors">
                                <input type="checkbox" 
                                       name="jours[]" 
                                       value="{{ $jour }}"
                                       {{ in_array($jour, $selectedJours) ? 'checked' : '' }}
                                       class="mr-2">
                                <span class="text-white">{{ ucfirst($jour) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('jours')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Horaires -->
            <div class="glass-card p-6 mb-6">
                <h2 class="text-xl font-semibold text-white mb-4">Horaires</h2>
                
                <div id="horaires-container">
                    @forelse($cours->horaires as $index => $horaire)
                        <div class="horaire-item glass-card p-4 mb-4" data-id="{{ $horaire->id }}">
                            <input type="hidden" name="horaires[{{ $index }}][id]" value="{{ $horaire->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Jour</label>
                                    <select name="horaires[{{ $index }}][jour]" class="glass-input w-full" required>
                                        @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                                            <option value="{{ $jour }}" {{ $horaire->jour == $jour ? 'selected' : '' }}>
                                                {{ ucfirst($jour) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure début</label>
                                    <input type="time" 
                                           name="horaires[{{ $index }}][heure_debut]" 
                                           value="{{ substr($horaire->heure_debut, 0, 5) }}"
                                           class="glass-input w-full" 
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure fin</label>
                                    <input type="time" 
                                           name="horaires[{{ $index }}][heure_fin]" 
                                           value="{{ substr($horaire->heure_fin, 0, 5) }}"
                                           class="glass-input w-full" 
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Salle</label>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               name="horaires[{{ $index }}][salle]" 
                                               value="{{ $horaire->salle }}"
                                               class="glass-input w-full" 
                                               placeholder="Dojo 1">
                                        <button type="button" 
                                                onclick="removeHoraire(this)" 
                                                class="glass-button bg-red-600/20 hover:bg-red-600/30 text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="horaire-item glass-card p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Jour</label>
                                    <select name="horaires[0][jour]" class="glass-input w-full" required>
                                        <option value="">Sélectionner...</option>
                                        @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                                            <option value="{{ $jour }}">{{ ucfirst($jour) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure début</label>
                                    <input type="time" name="horaires[0][heure_debut]" class="glass-input w-full" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure fin</label>
                                    <input type="time" name="horaires[0][heure_fin]" class="glass-input w-full" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Salle</label>
                                    <input type="text" name="horaires[0][salle]" class="glass-input w-full" placeholder="Dojo 1">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" 
                        onclick="addHoraire()" 
                        class="glass-button bg-green-600/20 hover:bg-green-600/30 text-green-400">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un horaire
                </button>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.cours.show', $cours) }}" 
                   class="glass-button">
                    Annuler
                </a>
                <button type="submit" 
                        class="glass-button bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let horaireIndex = {{ $cours->horaires->count() }};

function addHoraire() {
    const container = document.getElementById('horaires-container');
    const template = `
        <div class="horaire-item glass-card p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Jour</label>
                    <select name="horaires[${horaireIndex}][jour]" class="glass-input w-full" required>
                        <option value="">Sélectionner...</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure début</label>
                    <input type="time" name="horaires[${horaireIndex}][heure_debut]" class="glass-input w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Heure fin</label>
                    <input type="time" name="horaires[${horaireIndex}][heure_fin]" class="glass-input w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Salle</label>
                    <div class="flex gap-2">
                        <input type="text" name="horaires[${horaireIndex}][salle]" class="glass-input w-full" placeholder="Dojo 1">
                        <button type="button" onclick="removeHoraire(this)" class="glass-button bg-red-600/20 hover:bg-red-600/30 text-red-400">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    horaireIndex++;
}

function removeHoraire(button) {
    button.closest('.horaire-item').remove();
}
</script>
@endsection
