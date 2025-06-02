@extends('layouts.admin')

@section('title', 'Créer un Cours')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            @include('components.back-button', ['route' => route('cours.index')])
            <h1 class="h3 text-white mb-0">
                <i class="fas fa-plus-circle me-2"></i>Créer un Cours
            </h1>
        </div>
    </div>

    <form action="{{ route('cours.store') }}" method="POST" id="cours-form">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Informations de base -->
                <div class="card bg-dark text-white mb-4" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(255,215,0,0.1) 0%, rgba(70,130,180,0.1) 100%);">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations du cours</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nom" class="form-label">Nom du cours *</label>
                                <input type="text" 
                                       class="form-control bg-dark text-white @error('nom') is-invalid @enderror" 
                                       style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}" 
                                       placeholder="Ex: Karaté parents-enfants, Ceintures avancées, Cours adultes..."
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="places_max" class="form-label">Places maximum</label>
                                <input type="number" 
                                       class="form-control bg-dark text-white @error('places_max') is-invalid @enderror" 
                                       style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                       id="places_max" 
                                       name="places_max" 
                                       value="{{ old('places_max') }}" 
                                       min="1"
                                       placeholder="Illimité">
                                @error('places_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description du cours</label>
                            <textarea class="form-control bg-dark text-white @error('description') is-invalid @enderror" 
                                      style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Décrivez le cours : niveau, âge ciblé, objectifs...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            @if(count($ecoles) > 1)
                            <div class="col-md-4 mb-3">
                                <label for="ecole_id" class="form-label">École *</label>
                                <select class="form-select bg-dark text-white @error('ecole_id') is-invalid @enderror" 
                                        style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                        id="ecole_id" 
                                        name="ecole_id" 
                                        required>
                                    @foreach($ecoles as $ecole)
                                        <option value="{{ $ecole->id }}" {{ old('ecole_id', $ecoles->first()->id) == $ecole->id ? 'selected' : '' }}>
                                            {{ $ecole->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ecole_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <input type="hidden" name="ecole_id" value="{{ $ecoles->first()->id }}">
                            @endif
                            
                            <div class="col-md-{{ count($ecoles) > 1 ? '4' : '6' }} mb-3">
                                <label for="session_id" class="form-label">Session *</label>
                                <select class="form-select bg-dark text-white @error('session_id') is-invalid @enderror" 
                                        style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                        id="session_id" 
                                        name="session_id"
                                        required>
                                    <option value="">Choisir une session</option>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->id }}" 
                                                {{ old('session_id') == $session->id ? 'selected' : '' }}
                                                style="color: {{ $session->couleur }};">
                                            {{ $session->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('session_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-{{ count($ecoles) > 1 ? '4' : '6' }} mb-3">
                                <label for="date_debut" class="form-label">Date début * (JJ/MM/AAAA)</label>
                                <input type="text" 
                                       class="form-control bg-dark text-white @error('date_debut') is-invalid @enderror" 
                                       style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                       id="date_debut" 
                                       name="date_debut" 
                                       value="{{ old('date_debut') }}" 
                                       placeholder="31/05/2025"
                                       pattern="\d{2}/\d{2}/\d{4}"
                                       required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JJ/MM/AAAA</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tarification_info" class="form-label">Information de tarification (optionnel)</label>
                            <textarea class="form-control bg-dark text-white @error('tarification_info') is-invalid @enderror" 
                                      style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                      id="tarification_info" 
                                      name="tarification_info" 
                                      rows="2"
                                      placeholder="Ex: 80$/session, 15$/cours, Rabais famille disponible...">{{ old('tarification_info') }}</textarea>
                            @error('tarification_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Horaires -->
                <div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(70,130,180,0.1) 0%, rgba(184,115,51,0.1) 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Horaires du cours</h5>
                            <button type="button" class="btn btn-sm btn-info" id="add-horaire">
                                <i class="fas fa-plus me-1"></i>Ajouter un horaire
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="horaires-container">
                            <div class="horaire-item mb-3 p-3" style="background: rgba(255,255,255,0.05); border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <select name="horaires[0][jour]" class="form-select bg-dark text-white" style="background: rgba(255,255,255,0.1) !important;" required>
                                            <option value="">Jour</option>
                                            @foreach($jours as $jour => $label)
                                                <option value="{{ $jour }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Heure début (24h)</label>
                                        <input type="text" 
                                               name="horaires[0][heure_debut]" 
                                               class="form-control bg-dark text-white timepicker" 
                                               style="background: rgba(255,255,255,0.1) !important;"
                                               placeholder="18:00"
                                               pattern="[0-2][0-9]:[0-5][0-9]"
                                               required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Heure fin (24h)</label>
                                        <input type="text" 
                                               name="horaires[0][heure_fin]" 
                                               class="form-control bg-dark text-white timepicker" 
                                               style="background: rgba(255,255,255,0.1) !important;"
                                               placeholder="19:00"
                                               pattern="[0-2][0-9]:[0-5][0-9]"
                                               required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small text-muted">&nbsp;</label>
                                        <div>
                                            <button type="button" class="btn btn-success btn-sm copy-horaire" title="Copier cet horaire">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm remove-horaire" style="display:none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(count($horairesExistants) > 0)
                        <div class="mt-3 p-3" style="background: rgba(255,255,255,0.03); border-radius: 10px;">
                            <h6 class="text-info mb-2"><i class="fas fa-lightbulb me-2"></i>Horaires existants (cliquez pour copier)</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($horairesExistants as $jour => $horaires)
                                    @foreach($horaires as $h)
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info horaire-suggestion"
                                            data-jour="{{ $h->jour }}"
                                            data-debut="{{ \Carbon\Carbon::parse($h->heure_debut)->format('H:i') }}"
                                            data-fin="{{ \Carbon\Carbon::parse($h->heure_fin)->format('H:i') }}">
                                        {{ ucfirst($h->jour) }} {{ \Carbon\Carbon::parse($h->heure_debut)->format('H:i') }}-{{ \Carbon\Carbon::parse($h->heure_fin)->format('H:i') }}
                                    </button>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card bg-dark text-white sticky-top" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); top: 1rem;">
                    <div class="card-header" style="background: rgba(255,255,255,0.05);">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Guide rapide</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-warning">Exemples de noms de cours</h6>
                            <ul class="small list-unstyled">
                                <li class="mb-1">✓ Karaté Parents-Enfants (4-7 ans)</li>
                                <li class="mb-1">✓ Ceintures Avancées</li>
                                <li class="mb-1">✓ Cours Adultes Débutants</li>
                                <li class="mb-1">✓ Cours Privés</li>
                                <li class="mb-1">✓ Préparation Compétition</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-info">Format des heures</h6>
                            <p class="small mb-2">Utilisez le format 24h :</p>
                            <ul class="small mb-0">
                                <li>18:00 (6h PM)</li>
                                <li>19:30 (7h30 PM)</li>
                                <li>09:00 (9h AM)</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h6 class="text-success">Conseils</h6>
                            <ul class="small mb-0">
                                <li class="mb-2">Utilisez le bouton <i class="fas fa-copy text-success"></i> pour dupliquer un horaire</li>
                                <li class="mb-2">Cliquez sur les horaires existants pour les réutiliser</li>
                                <li class="mb-2">La tarification est libre - inscrivez ce qui convient à votre école</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-info btn-lg">
                    <i class="fas fa-save me-2"></i>Créer le cours
                </button>
                <a href="{{ route('cours.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let horaireIndex = 1;
    
    // Fonction pour formater la date
    function formatDateInput(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length >= 2) {
                formattedValue = value.slice(0, 2) + '/';
                if (value.length >= 4) {
                    formattedValue += value.slice(2, 4) + '/';
                    if (value.length >= 8) {
                        formattedValue += value.slice(4, 8);
                    } else {
                        formattedValue += value.slice(4);
                    }
                } else {
                    formattedValue += value.slice(2);
                }
            } else {
                formattedValue = value;
            }
            
            e.target.value = formattedValue;
        });
    }
    
    // Appliquer le formatage au champ date
    const dateInput = document.getElementById('date_debut');
    if (dateInput) {
        formatDateInput(dateInput);
    }
    
    // Fonction pour valider le format d'heure
    function validateTimeInput(input) {
        input.addEventListener('blur', function(e) {
            let value = e.target.value;
            if (value && !value.match(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/)) {
                e.target.setCustomValidity('Format invalide. Utilisez HH:MM (ex: 18:00)');
            } else {
                e.target.setCustomValidity('');
            }
        });
        
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d:]/g, '');
            if (value.length === 2 && !value.includes(':')) {
                value = value + ':';
            }
            e.target.value = value;
        });
    }
    
    // Appliquer la validation aux champs d'heure existants
    document.querySelectorAll('.timepicker').forEach(validateTimeInput);
    
    // Ajouter un horaire
    document.getElementById('add-horaire').addEventListener('click', function() {
        addHoraire();
    });
    
    function addHoraire(jour = '', debut = '', fin = '') {
        const container = document.getElementById('horaires-container');
        const template = container.querySelector('.horaire-item').cloneNode(true);
        
        // Update field names and values
        template.querySelectorAll('select, input').forEach(function(field) {
            const name = field.name;
            if (name) {
                field.name = name.replace('[0]', '[' + horaireIndex + ']');
            }
        });
        
        // Set values if provided
        if (jour) template.querySelector('select').value = jour;
        if (debut) template.querySelector('input[name*="heure_debut"]').value = debut;
        if (fin) template.querySelector('input[name*="heure_fin"]').value = fin;
        
        // Appliquer la validation aux nouveaux champs
        template.querySelectorAll('.timepicker').forEach(validateTimeInput);
        
        // Show remove button
        template.querySelector('.remove-horaire').style.display = 'inline-block';
        
        container.appendChild(template);
        horaireIndex++;
        
        updateButtons();
    }
    
    // Copier un horaire
    document.addEventListener('click', function(e) {
        if (e.target.closest('.copy-horaire')) {
            const item = e.target.closest('.horaire-item');
            const jour = item.querySelector('select').value;
            const debut = item.querySelector('input[name*="heure_debut"]').value;
            const fin = item.querySelector('input[name*="heure_fin"]').value;
            
            if (jour && debut && fin) {
                addHoraire(jour, debut, fin);
            }
        }
        
        if (e.target.closest('.remove-horaire')) {
            e.target.closest('.horaire-item').remove();
            updateButtons();
        }
        
        // Suggestions d'horaires
        if (e.target.closest('.horaire-suggestion')) {
            const btn = e.target.closest('.horaire-suggestion');
            addHoraire(btn.dataset.jour, btn.dataset.debut, btn.dataset.fin);
        }
    });
    
    function updateButtons() {
        const items = document.querySelectorAll('.horaire-item');
        items.forEach(function(item, index) {
            const removeBtn = item.querySelector('.remove-horaire');
            if (index === 0 && items.length === 1) {
                removeBtn.style.display = 'none';
            } else if (index > 0) {
                removeBtn.style.display = 'inline-block';
            }
        });
    }
});
</script>

<style>
.horaire-item {
    transition: all 0.3s ease;
}
.horaire-item:hover {
    background: rgba(255,255,255,0.08) !important;
    transform: translateY(-1px);
}
.horaire-suggestion {
    transition: all 0.2s ease;
}
.horaire-suggestion:hover {
    transform: scale(1.05);
}
input.timepicker {
    font-family: monospace;
    letter-spacing: 0.1em;
}
</style>
@endsection
