@extends('layouts.admin')

@section('title', 'Modifier le membre')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Modifier le membre</h1>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.membres.index') }}">Membres</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.membres.show', $membre) }}">{{ $membre->nom_complet }}</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-section-ultimate">
                <form method="POST" action="{{ route('admin.membres.update', $membre) }}">
                    @csrf
                    @method('PUT')

                    <!-- Informations personnelles -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-user me-2"></i>Informations personnelles
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom *</label>
                            <input type="text" 
                                   class="form-control @error('prenom') is-invalid @enderror" 
                                   id="prenom" 
                                   name="prenom" 
                                   value="{{ old('prenom', $membre->prenom) }}" 
                                   required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom', $membre->nom) }}" 
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $membre->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" 
                                   class="form-control @error('telephone') is-invalid @enderror" 
                                   id="telephone" 
                                   name="telephone" 
                                   value="{{ old('telephone', $membre->telephone) }}"
                                   placeholder="(418) 123-4567">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" 
                                   class="form-control @error('date_naissance') is-invalid @enderror" 
                                   id="date_naissance" 
                                   name="date_naissance" 
                                   value="{{ old('date_naissance', $membre->date_naissance?->format('Y-m-d')) }}">
                            @error('date_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select class="form-control @error('sexe') is-invalid @enderror" 
                                    id="sexe" 
                                    name="sexe">
                                <option value="">Sélectionner...</option>
                                <option value="H" {{ old('sexe', $membre->sexe) === 'H' ? 'selected' : '' }}>Homme</option>
                                <option value="F" {{ old('sexe', $membre->sexe) === 'F' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('sexe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>Adresse
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="numero_rue" class="form-label">Numéro</label>
                            <input type="text" 
                                   class="form-control @error('numero_rue') is-invalid @enderror" 
                                   id="numero_rue" 
                                   name="numero_rue" 
                                   value="{{ old('numero_rue', $membre->numero_rue) }}">
                            @error('numero_rue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-9 mb-3">
                            <label for="nom_rue" class="form-label">Nom de la rue</label>
                            <input type="text" 
                                   class="form-control @error('nom_rue') is-invalid @enderror" 
                                   id="nom_rue" 
                                   name="nom_rue" 
                                   value="{{ old('nom_rue', $membre->nom_rue) }}">
                            @error('nom_rue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" 
                                   class="form-control @error('ville') is-invalid @enderror" 
                                   id="ville" 
                                   name="ville" 
                                   value="{{ old('ville', $membre->ville) }}">
                            @error('ville')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" 
                                   class="form-control @error('province') is-invalid @enderror" 
                                   id="province" 
                                   name="province" 
                                   value="{{ old('province', $membre->province ?? 'QC') }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="code_postal" class="form-label">Code postal</label>
                            <input type="text" 
                                   class="form-control @error('code_postal') is-invalid @enderror" 
                                   id="code_postal" 
                                   name="code_postal" 
                                   value="{{ old('code_postal', $membre->code_postal) }}"
                                   placeholder="G1A 1A1">
                            @error('code_postal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- École et statut -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-school me-2"></i>École et statut
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ecole_id" class="form-label">École *</label>
                            <select class="form-control @error('ecole_id') is-invalid @enderror" 
                                    id="ecole_id" 
                                    name="ecole_id" 
                                    required>
                                <option value="">Sélectionner une école...</option>
                                @foreach($ecoles as $ecole)
                                    <option value="{{ $ecole->id }}" 
                                            {{ old('ecole_id', $membre->ecole_id) == $ecole->id ? 'selected' : '' }}>
                                        {{ $ecole->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ecole_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="approuve" class="form-label">Statut d'approbation</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="approuve" 
                                       name="approuve" 
                                       value="1"
                                       {{ old('approuve', $membre->approuve) ? 'checked' : '' }}>
                                <label class="form-check-label" for="approuve">
                                    Membre approuvé
                                </label>
                            </div>
                            @error('approuve')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="row">
                        <div class="col-12">
                            <hr class="my-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-glass-ultimate">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
