@extends('layouts.admin')

@section('title', 'Nouveau Membre')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-white">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Nouveau Membre
                    </h1>
                    <p class="text-light opacity-75 mb-0">Ajoutez un nouveau membre à l'école</p>
                </div>
                <a href="{{ route('admin.membres.index') }}" class="btn btn-outline-light btn-glass">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="content-section-ultimate">
        <div class="card-body p-4">
            <form method="POST" action="#" class="needs-validation" novalidate>
                @csrf
                
                <!-- Informations personnelles -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-user me-2"></i>Informations personnelles
                        </h5>
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="prenom" class="form-label text-light">Prénom *</label>
                        <input type="text" class="form-control-glass" id="prenom" name="prenom" required>
                        <div class="invalid-feedback">Le prénom est requis.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label text-light">Nom *</label>
                        <input type="text" class="form-control-glass" id="nom" name="nom" required>
                        <div class="invalid-feedback">Le nom est requis.</div>
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="date_naissance" class="form-label text-light">Date de naissance</label>
                        <input type="date" class="form-control-glass" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="col-md-4">
                        <label for="sexe" class="form-label text-light">Sexe</label>
                        <select class="form-control-glass" id="sexe" name="sexe">
                            <option value="">Sélectionner</option>
                            <option value="H">Homme</option>
                            <option value="F">Femme</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="ecole_id" class="form-label text-light">École *</label>
                        <select class="form-control-glass" id="ecole_id" name="ecole_id" required>
                            <option value="">Sélectionner une école</option>
                            @foreach($ecoles as $ecole)
                                <option value="{{ $ecole->id }}">{{ $ecole->nom }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">L'école est requise.</div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-phone me-2"></i>Contact
                        </h5>
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" class="form-control-glass" id="email" name="email">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label text-light">Téléphone</label>
                        <input type="tel" class="form-control-glass" id="telephone" name="telephone">
                    </div>
                </div>

                <!-- Adresse -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>Adresse
                        </h5>
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-2">
                        <label for="numero_rue" class="form-label text-light">N°</label>
                        <input type="text" class="form-control-glass" id="numero_rue" name="numero_rue">
                    </div>
                    <div class="col-md-10">
                        <label for="nom_rue" class="form-label text-light">Rue</label>
                        <input type="text" class="form-control-glass" id="nom_rue" name="nom_rue">
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="ville" class="form-label text-light">Ville</label>
                        <input type="text" class="form-control-glass" id="ville" name="ville">
                    </div>
                    <div class="col-md-4">
                        <label for="province" class="form-label text-light">Province</label>
                        <input type="text" class="form-control-glass" id="province" name="province" value="QC">
                    </div>
                    <div class="col-md-4">
                        <label for="code_postal" class="form-label text-light">Code postal</label>
                        <input type="text" class="form-control-glass" id="code_postal" name="code_postal">
                    </div>
                </div>

                <!-- Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.membres.index') }}" class="btn btn-outline-light btn-glass">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-glass-ultimate">
                                <i class="fas fa-save me-2"></i>Créer le membre
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validation du formulaire
(function() {
    'use strict';
    
    const form = document.querySelector('.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    }, false);
})();
</script>
@endsection
