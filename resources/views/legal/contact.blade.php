@extends('layouts.app')

@section('title', 'Contact')

@section('content')
@include('components.back-button')
<div class="container contact-page">
    <h1>Nous contacter</h1>
    
    <div class="contact-grid">
        <div class="contact-info">
            <h2>Informations de contact</h2>
            
            <div class="info-card">
                <h3>Studios Unis - Siège social</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Rue Principale</p>
                <p>Québec, QC G1A 1A1</p>
                <p><i class="fas fa-phone"></i> (418) 555-0123</p>
                <p><i class="fas fa-envelope"></i> info@studiosunis.com</p>
            </div>
            
            <div class="info-card">
                <h3>Heures d'ouverture</h3>
                <p>Lundi - Vendredi : 9h00 - 21h00</p>
                <p>Samedi : 9h00 - 17h00</p>
                <p>Dimanche : 10h00 - 16h00</p>
            </div>
            
            <div class="info-card">
                <h3>Pour les questions sur vos données personnelles</h3>
                <p>Envoyez un courriel à : donnees@studiosunis.com</p>
                <p>Ou appelez : (418) 555-0124</p>
            </div>
        </div>
        
        <div class="contact-form">
            <h2>Formulaire de contact</h2>
            <form method="POST" action="#" class="glass-form">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label required">Nom complet</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label required">Courriel</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="subject" class="form-label required">Sujet</label>
                    <select id="subject" name="subject" class="form-select" required>
                        <option value="">Choisir un sujet</option>
                        <option value="general">Question générale</option>
                        <option value="inscription">Inscription aux cours</option>
                        <option value="donnees">Protection des données</option>
                        <option value="technique">Support technique</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message" class="form-label required">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.contact-page {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-top: 2rem;
}

.info-card {
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-card h3 {
    color: var(--accent-primary);
    margin-bottom: 1rem;
}

.info-card p {
    margin-bottom: 0.5rem;
    color: var(--text-secondary);
}

.info-card i {
    color: var(--accent-primary);
    margin-right: 0.5rem;
    width: 20px;
}

.glass-form {
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    padding: 2rem;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}
</style>
@endsection
