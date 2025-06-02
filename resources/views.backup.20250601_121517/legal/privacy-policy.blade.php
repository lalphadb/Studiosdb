@extends('layouts.app')

@section('title', 'Politique de confidentialité')

@section('content')
<div class="container legal-page">
    <h1>Politique de confidentialité</h1>
    <p class="last-updated">Dernière mise à jour : {{ now()->format('d F Y') }}</p>
    
    <section>
        <h2>1. Introduction</h2>
        <p>Studios Unis s'engage à protéger la vie privée de ses utilisateurs conformément à la Loi 25 du Québec.</p>
    </section>
    
    <section>
        <h2>2. Collecte des renseignements personnels</h2>
        <p>Nous collectons les renseignements suivants :</p>
        <ul>
            <li>Nom et prénom</li>
            <li>Adresse courriel</li>
            <li>Numéro de téléphone</li>
            <li>Date de naissance</li>
            <li>Informations relatives aux cours et à la progression</li>
        </ul>
    </section>
    
    <section>
        <h2>3. Utilisation des renseignements</h2>
        <p>Les renseignements personnels sont utilisés exclusivement pour :</p>
        <ul>
            <li>La gestion des inscriptions et des cours</li>
            <li>Le suivi de la progression des élèves</li>
            <li>La communication d'informations importantes</li>
            <li>L'amélioration de nos services</li>
        </ul>
    </section>
    
    <section>
        <h2>4. Vos droits</h2>
        <p>Conformément à la Loi 25, vous avez le droit de :</p>
        <ul>
            <li>Accéder à vos renseignements personnels</li>
            <li>Demander la rectification de renseignements inexacts</li>
            <li>Retirer votre consentement</li>
            <li>Demander la portabilité de vos données</li>
        </ul>
    </section>
    
    <section>
        <h2>5. Contact</h2>
        <div class="contact-info">
            <p><strong>{{ config('app.privacy_officer_name', 'Jean Tremblay') }}</strong></p>
            <p>Responsable de la protection des renseignements personnels</p>
            <p>Email : {{ config('app.privacy_officer_email', 'protection@studiosunis.com') }}</p>
            <p>Téléphone : {{ config('app.privacy_officer_phone', '1-888-555-0123') }}</p>
        </div>
    </section>
</div>

<style>
.legal-page {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border-radius: var(--radius-lg);
    border: 1px solid var(--glass-border);
}

.legal-page h1 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.legal-page h2 {
    color: var(--accent-primary);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.legal-page section {
    margin-bottom: 2rem;
}

.legal-page ul {
    margin-left: 2rem;
}

.last-updated {
    color: var(--text-muted);
    font-style: italic;
    margin-bottom: 2rem;
}

.contact-info {
    background: var(--glass-bg-hover);
    padding: 1.5rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--glass-border);
}
</style>
@endsection
