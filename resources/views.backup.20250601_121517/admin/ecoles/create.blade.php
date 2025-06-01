@extends('layouts.admin')

@section('title', 'Créer une École')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #ffffff;">
                <i class="fas fa-plus-circle text-primary me-2"></i>
                Créer une École
            </h1>
            <p class="text-light mb-0">Ajoutez une nouvelle école au système Studios Unis</p>
        </div>
        <div>
            <a href="{{ route('ecoles.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-school text-primary me-2"></i>
                        Informations de l'École
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ecoles.store') }}">
                        @csrf

                        <!-- Erreurs de validation -->
                        @if ($errors->any())
                        <div class="alert alert-danger mb-4" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.3); color: #ffffff;">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</h6>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <!-- Nom de l'école -->
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label text-light fw-bold">
                                    <i class="fas fa-school me-1 text-primary"></i>
                                    Nom de l'école *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}" 
                                       required
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: Studios Unis - Québec">
                                @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ville -->
                            <div class="col-md-6 mb-3">
                                <label for="ville" class="form-label text-light fw-bold">
                                    <i class="fas fa-city me-1 text-primary"></i>
                                    Ville *
                                </label>
                                <input type="text" 
                                       class="form-control @error('ville') is-invalid @enderror" 
                                       id="ville" 
                                       name="ville" 
                                       value="{{ old('ville') }}" 
                                       required
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: Québec">
                                @error('ville')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-8 mb-3">
                                <label for="adresse" class="form-label text-light fw-bold">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                    Adresse complète
                                </label>
                                <input type="text" 
                                       class="form-control @error('adresse') is-invalid @enderror" 
                                       id="adresse" 
                                       name="adresse" 
                                       value="{{ old('adresse') }}"
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: 1234 rue des Écoles, Suite 100">
                                @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div class="col-md-4 mb-3">
                                <label for="province" class="form-label text-light fw-bold">
                                    <i class="fas fa-flag me-1 text-primary"></i>
                                    Province *
                                </label>
                                <select class="form-select @error('province') is-invalid @enderror" 
                                        id="province" 
                                        name="province" 
                                        required
                                        style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;">
                                    <option value="">Choisir...</option>
                                    <option value="QC" {{ old('province') == 'QC' ? 'selected' : '' }}>Québec (QC)</option>
                                    <option value="ON" {{ old('province') == 'ON' ? 'selected' : '' }}>Ontario (ON)</option>
                                    <option value="BC" {{ old('province') == 'BC' ? 'selected' : '' }}>Colombie-Britannique (BC)</option>
                                    <option value="AB" {{ old('province') == 'AB' ? 'selected' : '' }}>Alberta (AB)</option>
                                    <option value="MB" {{ old('province') == 'MB' ? 'selected' : '' }}>Manitoba (MB)</option>
                                    <option value="SK" {{ old('province') == 'SK' ? 'selected' : '' }}>Saskatchewan (SK)</option>
                                    <option value="NS" {{ old('province') == 'NS' ? 'selected' : '' }}>Nouvelle-Écosse (NS)</option>
                                    <option value="NB" {{ old('province') == 'NB' ? 'selected' : '' }}>Nouveau-Brunswick (NB)</option>
                                    <option value="PE" {{ old('province') == 'PE' ? 'selected' : '' }}>Île-du-Prince-Édouard (PE)</option>
                                    <option value="NL" {{ old('province') == 'NL' ? 'selected' : '' }}>Terre-Neuve-et-Labrador (NL)</option>
                                </select>
                                @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label text-light fw-bold">
                                    <i class="fas fa-phone me-1 text-primary"></i>
                                    Téléphone
                                </label>
                                <input type="tel" 
                                       class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" 
                                       name="telephone" 
                                       value="{{ old('telephone') }}"
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: (418) 123-4567">
                                @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-light fw-bold">
                                    <i class="fas fa-envelope me-1 text-primary"></i>
                                    Adresse email
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: quebec@studiosunis.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Responsable -->
                            <div class="col-12 mb-4">
                                <label for="responsable" class="form-label text-light fw-bold">
                                    <i class="fas fa-user-tie me-1 text-primary"></i>
                                    Responsable de l'école
                                </label>
                                <input type="text" 
                                       class="form-control @error('responsable') is-invalid @enderror" 
                                       id="responsable" 
                                       name="responsable" 
                                       value="{{ old('responsable') }}"
                                       style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;"
                                       placeholder="Ex: Jean Dupont et Marie Tremblay">
                                @error('responsable')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Note informative -->
                        <div class="alert alert-info mb-4" style="background: rgba(56, 178, 172, 0.2); border: 1px solid rgba(56, 178, 172, 0.3); color: #ffffff;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Information :</strong> L'école sera automatiquement activée après sa création. Vous pourrez la désactiver plus tard si nécessaire.
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('ecoles.index') }}" class="btn btn-outline-light">
                                <i class="fas fa-times me-2"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Créer l'École
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles pour les éléments de formulaire */
.form-control:focus, .form-select:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    color: #fff !important;
}

.form-select option {
    background: #2d3748;
    color: #fff;
}

.invalid-feedback {
    color: #fed7d7 !important;
}
</style>
@endsection
