@extends('layouts.guest')

@section('title', 'Politique de confidentialité')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    @include('components.back-button')
    
    <div class="card bg-dark text-white shadow rounded-3 p-4">
        <h2 class="mb-4">POLITIQUE DE CONFIDENTIALITÉ</h2>
        <p><strong>Studios Unis</strong><br>Date d'entrée en vigueur : {{ now()->format('d F Y') }}</p>

        <h4 class="mt-4">1. INTRODUCTION</h4>
        <p>Studios Unis (« nous », « notre », « nos ») s'engage à protéger la confidentialité des renseignements personnels que nous recueillons auprès de nos utilisateurs (« vous », « votre »). Cette politique est conforme à la <strong>Loi 25 du Québec</strong>.</p>

        <h4 class="mt-4">2. PERSONNE RESPONSABLE DE LA PROTECTION DES RENSEIGNEMENTS PERSONNELS</h4>
        <p>Pour toute question :</p>
        <ul>
            <li><strong>Courriel :</strong> donnees@studiosunis.com</li>
            <li><strong>Téléphone :</strong> (418) 555-0124</li>
            <li><strong>Adresse :</strong> 123 Rue Principale, Québec, QC G1A 1A1</li>
        </ul>

        <h4 class="mt-4">3. RENSEIGNEMENTS PERSONNELS RECUEILLIS</h4>
        <ul>
            <li>Nom, prénom, courriel, téléphone</li>
            <li>Nom d'utilisateur, mot de passe</li>
            <li>Données de navigation, adresse IP</li>
            <li>Informations relatives aux cours et à la progression</li>
        </ul>

        <h4 class="mt-4">4. FINALITÉS</h4>
        <ul>
            <li>Fournir et améliorer les services</li>
            <li>Gérer les comptes utilisateurs et les inscriptions aux cours</li>
            <li>Communiquer avec vous</li>
            <li>Assistance, statistiques, obligations légales</li>
        </ul>

        <h4 class="mt-4">5. CONSENTEMENT</h4>
        <p>Votre consentement est libre, éclairé, spécifique et limité dans le temps. Il peut être retiré à tout moment.</p>

        <h4 class="mt-4">6. PARTAGE DES RENSEIGNEMENTS</h4>
        <p>Nous partageons vos données uniquement avec :</p>
        <ul>
            <li>Prestataires d'hébergement, paiement et statistiques</li>
            <li>Conformément à la loi</li>
        </ul>

        <h4 class="mt-4">7. CONSERVATION</h4>
        <p>Les données sont conservées pour la durée nécessaire aux finalités, puis supprimées ou anonymisées.</p>

        <h4 class="mt-4">8. SÉCURITÉ</h4>
        <ul>
            <li>Chiffrement, journalisation, contrôle d'accès</li>
            <li>Formation et audits</li>
        </ul>

        <h4 class="mt-4">9. INCIDENTS DE CONFIDENTIALITÉ</h4>
        <p>Nous informons les utilisateurs et la Commission d'accès à l'information si un incident présente un risque sérieux.</p>

        <h4 class="mt-4">10. VOS DROITS</h4>
        <ul>
            <li>Droit d'accès, rectification, suppression</li>
            <li>Droit à l'oubli, opposition, portabilité</li>
        </ul>

        <h4 class="mt-4">11. CONDITIONS D'UTILISATION</h4>
        <p>En utilisant nos services, vous acceptez nos conditions d'utilisation qui incluent :</p>
        <ul>
            <li>L'utilisation appropriée de la plateforme</li>
            <li>Le respect des autres utilisateurs</li>
            <li>La protection de vos identifiants de connexion</li>
            <li>Le respect de la propriété intellectuelle</li>
        </ul>

        <h4 class="mt-4">12. COOKIES</h4>
        <p>Cookies essentiels, performance, préférence et ciblage peuvent être désactivés via votre navigateur.</p>

        <h4 class="mt-4">13. MINEURS</h4>
        <p>Nos services nécessitent le consentement parental pour les moins de 14 ans.</p>

        <h4 class="mt-4">14. MODIFICATIONS</h4>
        <p>Cette politique peut être mise à jour. La date de révision sera indiquée en haut de la page.</p>

        <h4 class="mt-4">15. QUESTIONS / PLAINTES</h4>
        <p>Contactez notre responsable ou :</p>
        <p><strong>Commission d'accès à l'information du Québec</strong><br>525, boulevard René-Lévesque Est, bureau 2.36<br>Québec (Québec) G1R 5S9<br>📞 418 528-7741 | 1 888 528-7741<br>🌐 <a href="https://www.cai.gouv.qc.ca" target="_blank" class="text-info">www.cai.gouv.qc.ca</a></p>

        <h4 class="mt-4">16. CONTACT</h4>
        <p>Pour toute question concernant cette politique : donnees@studiosunis.com</p>

        <hr class="border-light">
        <p class="small text-muted mb-0">Cette politique couvre également nos conditions d'utilisation, avis de collecte et procédures de droits d'accès.</p>
    </div>
</div>
@endsection
