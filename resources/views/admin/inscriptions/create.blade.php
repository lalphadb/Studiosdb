@extends('layouts.admin')

@section('title', 'Nouvelle Inscription')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
@endpush

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="main-content">
    <div class="container">
        <!-- Header -->
        <div class="content-header mb-4">
            <h1 class="page-title">Nouvelle Inscription</h1>
            <nav class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.inscriptions.index') }}">Inscriptions</a>
                <span>/</span>
                <span>Nouvelle</span>
            </nav>
        </div>

        <!-- Formulaire -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus card-icon"></i>
                    Formulaire d'inscription
                </h3>
            </div>
            
            <form action="{{ route('admin.inscriptions.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Sélection du membre -->
                        <div class="mb-4">
                            <label class="form-label text-white">Membre *</label>
                            <select name="membre_id" class="form-control @error('membre_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un membre...</option>
                                @foreach($membres as $membre)
                                    <option value="{{ $membre->id }}" {{ old('membre_id') == $membre->id ? 'selected' : '' }}>
                                        {{ $membre->prenom }} {{ $membre->nom }} - {{ $membre->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('membre_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Sélection du cours -->
                        <div class="mb-4">
                            <label class="form-label text-white">Cours *</label>
                            <select name="cours_id" class="form-control @error('cours_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un cours...</option>
                                @foreach($cours->groupBy('ecole.nom') as $ecoleNom => $coursEcole)
                                    <optgroup label="{{ $ecoleNom }}">
                                        @foreach($coursEcole as $c)
                                            <option value="{{ $c->id }}" {{ old('cours_id') == $c->id ? 'selected' : '' }}>
                                                {{ $c->nom }} 
                                                @if($c->session) ({{ $c->session->nom }}) @endif
                                                - Places: {{ $c->inscriptions()->where('statut', 'confirmee')->count() }}/{{ $c->places_max ?: '∞' }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('cours_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <label class="form-label text-white">Notes (optionnel)</label>
                    <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Informations complémentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Informations du cours sélectionné -->
                <div id="cours-info" class="alert alert-info d-none" style="background: rgba(32, 185, 190, 0.2); border: 1px solid #20b9be;">
                    <h5 class="alert-heading">Informations du cours</h5>
                    <div id="cours-details"></div>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Enregistrer l'inscription
                    </button>
                    <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Afficher les infos du cours sélectionné
document.querySelector('select[name="cours_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const coursInfo = document.getElementById('cours-info');
    const coursDetails = document.getElementById('cours-details');
    
    if (this.value) {
        coursInfo.classList.remove('d-none');
        
        // Extraire les informations du texte de l'option
        const text = selectedOption.text;
        const placesMatch = text.match(/Places: (\d+)\/(\d+|∞)/);
        
        if (placesMatch) {
            const inscrites = placesMatch[1];
            const max = placesMatch[2];
            const disponibles = max === '∞' ? 'Illimitées' : (parseInt(max) - parseInt(inscrites));
            
            coursDetails.innerHTML = `
                <p class="mb-1"><strong>Cours :</strong> ${text.split(' - ')[0]}</p>
                <p class="mb-1"><strong>Places inscrites :</strong> ${inscrites}</p>
                <p class="mb-1"><strong>Places disponibles :</strong> ${disponibles}</p>
                ${parseInt(inscrites) >= parseInt(max) && max !== '∞' ? '<p class="mb-0 text-warning"><i class="fas fa-exclamation-triangle mr-2"></i>Ce cours est complet. L\'inscription sera mise en liste d\'attente.</p>' : ''}
            `;
        }
    } else {
        coursInfo.classList.add('d-none');
    }
});
</script>
@endpush

@endsection
