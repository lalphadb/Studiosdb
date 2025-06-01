@extends('layouts.guest')

@section('title', 'Contact')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    @include('components.back-button')
    
    <div class="card bg-dark text-white shadow rounded-3 p-4">
        <h2 class="mb-4">NOUS CONTACTER</h2>
        <p><strong>Studios Unis</strong><br>Votre partenaire en arts martiaux</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="mt-4 text-info">INFORMATIONS DE CONTACT</h4>
                
                <div class="mb-4">
                    <h5 class="mt-3">Siège social</h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt text-info me-2"></i> 123 Rue Principale</p>
                    <p class="mb-1">Québec, QC G1A 1A1</p>
                    <p class="mb-1">Canada</p>
                </div>

                <div class="mb-4">
                    <h5 class="mt-3">Téléphone</h5>
                    <p class="mb-1"><i class="fas fa-phone text-info me-2"></i> Bureau : (418) 555-0123</p>
                    <p class="mb-1"><i class="fas fa-mobile-alt text-info me-2"></i> Urgence : (418) 555-0124</p>
                </div>

                <div class="mb-4">
                    <h5 class="mt-3">Courriel</h5>
                    <p class="mb-1"><i class="fas fa-envelope text-info me-2"></i> Général : info@studiosunis.com</p>
                    <p class="mb-1"><i class="fas fa-shield-alt text-info me-2"></i> Données personnelles : donnees@studiosunis.com</p>
                    <p class="mb-1"><i class="fas fa-headset text-info me-2"></i> Support : support@studiosunis.com</p>
                </div>

                <div class="mb-4">
                    <h5 class="mt-3">Heures d'ouverture</h5>
                    <table class="table table-dark table-sm">
                        <tbody>
                            <tr>
                                <td>Lundi - Vendredi</td>
                                <td class="text-end">9h00 - 21h00</td>
                            </tr>
                            <tr>
                                <td>Samedi</td>
                                <td class="text-end">9h00 - 17h00</td>
                            </tr>
                            <tr>
                                <td>Dimanche</td>
                                <td class="text-end">10h00 - 16h00</td>
                            </tr>
                            <tr>
                                <td>Jours fériés</td>
                                <td class="text-end text-warning">Fermé</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <h4 class="mt-4 text-info">FORMULAIRE DE CONTACT</h4>
                
                <form method="POST" action="#" class="mt-3">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Courriel <span class="text-danger">*</span></label>
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control bg-dark text-white border-secondary" id="phone" name="phone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label">Sujet <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" id="subject" name="subject" required>
                            <option value="">-- Choisir un sujet --</option>
                            <option value="general">Question générale</option>
                            <option value="inscription">Inscription aux cours</option>
                            <option value="horaire">Horaires et disponibilités</option>
                            <option value="tarifs">Tarifs et paiements</option>
                            <option value="donnees">Protection des données personnelles</option>
                            <option value="technique">Support technique</option>
                            <option value="plainte">Plainte ou réclamation</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="message" name="message" rows="5" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                            <label class="form-check-label" for="consent">
                                J'accepte que mes données soient traitées conformément à la <a href="{{ route('privacy-policy') }}" class="text-info">politique de confidentialité</a> <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-info text-dark fw-bold">
                        <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                    </button>
                </form>
                
                <div class="alert alert-info mt-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Les champs marqués d'un astérisque (<span class="text-danger">*</span>) sont obligatoires.</small>
                </div>
            </div>
        </div>

        <hr class="border-light my-4">

        <div class="row">
            <div class="col-md-6">
                <h4 class="text-info">AUTRES MOYENS DE NOUS JOINDRE</h4>
                <div class="mt-3">
                    <p><i class="fab fa-facebook text-info me-2"></i> <a href="#" class="text-white">Studios Unis Facebook</a></p>
                    <p><i class="fab fa-instagram text-info me-2"></i> <a href="#" class="text-white">@studiosunis</a></p>
                    <p><i class="fab fa-youtube text-info me-2"></i> <a href="#" class="text-white">Studios Unis YouTube</a></p>
                </div>
            </div>
            
            <div class="col-md-6">
                <h4 class="text-info">URGENCES</h4>
                <div class="mt-3">
                    <p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i> En cas d'urgence médicale, composez le 911</p>
                    <p>Pour les urgences administratives en dehors des heures d'ouverture :</p>
                    <p><strong>Téléphone d'urgence :</strong> (418) 555-0199</p>
                </div>
            </div>
        </div>

        <hr class="border-light">
        <p class="small text-muted mb-0">Studios Unis - Système de gestion • Réponse sous 24-48 heures ouvrables</p>
    </div>
</div>

<style>
/* Styles supplémentaires pour harmoniser avec le thème dark */
.form-control:focus,
.form-select:focus {
    background-color: #212529;
    border-color: #0dcaf0;
    color: white;
    box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
}

.form-control::placeholder {
    color: #6c757d;
}

.form-check-input {
    background-color: #212529;
    border-color: #495057;
}

.form-check-input:checked {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
}

.btn-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(13, 202, 240, 0.3);
}
</style>
@endsection
