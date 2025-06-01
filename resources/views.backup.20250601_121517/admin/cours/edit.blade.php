@extends('layouts.admin')

@section('title', 'Modifier le Cours')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            @include('components.back-button', ['route' => route('cours.index')])
            <h1 class="h3 text-white mb-0">
                <i class="fas fa-edit me-2"></i>Modifier le Cours
            </h1>
        </div>
    </div>

    <form action="{{ route('cours.update', $cours) }}" method="POST" id="cours-form">
        @csrf
        @method('PUT')
        
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
                                       value="{{ old('nom', $cours->nom) }}" 
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
                                       value="{{ old('places_max', $cours->places_max) }}" 
                                       min="1">
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
                                      rows="3">{{ old('description', $cours->description) }}</textarea>
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
                                        <option value="{{ $ecole->id }}" {{ old('ecole_id', $cours->ecole_id) == $ecole->id ? 'selected' : '' }}>
                                            {{ $ecole->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ecole_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <input type="hidden" name="ecole_id" value="{{ $cours->ecole_id }}">
                            @endif
                            
                            <div class="col-md-{{ count($ecoles) > 1 ? '4' : '6' }} mb-3">
                                <label for="session_id" class="form-label">Session *</label>
                                <select class="form-select bg-dark text-white @error('session_id') is-invalid @enderror" 
                                        style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2);"
                                        id="session_id" 
                                        name="session_id"
                                        required>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->id }}" 
                                                {{ old('session_id', $cours->session_id) == $session->id ? 'selected' : '' }}
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
                                       value="{{ old('date_debut', $cours->date_debut_format) }}" 
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
                                      rows="2">{{ old('tarification_info', $cours->tarification_info) }}</textarea>
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
                            @forelse($cours->horaires as $index => $horaire)
                            <div class="horaire-item mb-3 p-3" style="background: rgba(255,255,255,0.05); border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <select name="horaires[{{ $index }}][jour]" class="form-select bg-dark text-white" style="background: rgba(255,255,255,0.1) !important;" required>
                                            <option value="">Jour</option>
                                            @foreach($jours as $jour => $label)
                                                <option value="{{ $jour }}" {{ $horaire->jour == $jour ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Heure début (24h)</label>
                                        <input type="text" 
                                               name="horaires[{{ $index }}][heure_debut]" 
                                               class="form-control bg-dark text-white timepicker" 
                                               style="background: rgba(255,255,255,0.1) !important;"
                                               value="{{ $horaire->heure_debut_format }}"
                                               pattern="[0-2][0-9]:[0-5][0-9]"
                                               required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Heure fin (24h)</label>
                                        <input type="text" 
                                               name="horaires[{{ $index }}][heure_fin]" 
                                               class="form-control bg-dark text-white timepicker" 
                                               style="background: rgba(255,255,255,0.1) !important;"
                                               value="{{ $horaire->heure_fin_format }}"
                                               pattern="[0-2][0-9]:[0-5][0-9]"
                                               required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small text-muted">&nbsp;</label>
                                        <div>
                                            <button type="button" class="btn btn-success btn-sm copy-horaire" title="Copier cet horaire">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm remove-horaire" {{ $loop->first && $loop->count == 1 ? 'style=display:none;' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
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
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card bg-dark text-white sticky-top" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); top: 1rem;">
                    <div class="card-header" style="background: rgba(255,255,255,0.05);">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row small mb-0">
                            <dt class="col-sm-6">Créé le :</dt>
                            <dd class="col-sm-6">{{ $cours->created_at->format('d/m/Y H:i') }}</dd>
                            
                            <dt class="col-sm-6">Modifié le :</dt>
                            <dd class="col-sm-6">{{ $cours->updated_at->format('d/m/Y H:i') }}</dd>
                            
                            <dt class="col-sm-6">Inscrits :</dt>
                            <dd class="col-sm-6">{{ $cours->inscriptions->count() }} membres</dd>
                            
                            <dt class="col-sm-6">Statut :</dt>
                            <dd class="col-sm-6">
                                <span class="badge bg-{{ $cours->actif ? 'success' : 'secondary' }}">
                                    {{ $cours->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </dd>
                        </dl>
                        
                        <hr class="text-white-50">
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('cours.show', $cours) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye me-2"></i>Voir le cours
                            </a>
                            <form action="{{ route('cours.toggle-status', $cours) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $cours->actif ? 'warning' : 'success' }} w-100">
                                    <i class="fas fa-power-off me-2"></i>{{ $cours->actif ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                            @if($cours->inscriptions->count() == 0)
                            <form action="{{ route('cours.destroy', $cours) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="fas fa-trash me-2"></i>Supprimer
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-outline-danger w-100" disabled>
                                <i class="fas fa-trash me-2"></i>Supprimer ({{ $cours->inscriptions->count() }} inscrits)
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-info btn-lg">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('cours.show', $cours) }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let horaireIndex = {{ $cours->horaires->count() }};
    
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
                field.name = name.replace(/\[\d+\]/, '[' + horaireIndex + ']');
                field.value = '';
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
input.timepicker {
    font-family: monospace;
    letter-spacing: 0.1em;
}
</style>
@endsection
