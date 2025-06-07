@extends('layouts.guest')

@section('title', 'Politique de confidentialité - Loi 25')

@section('content')
<div class="aurora-card max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-6">Politique de confidentialité</h1>
    <p class="text-sm text-gray-400 mb-8">Conforme à la Loi 25 du Québec sur la protection des renseignements personnels</p>
    
    <div class="text-gray-300 space-y-6">
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">1. Responsable du traitement</h2>
            <p><strong>Studios Unis Karaté</strong></p>
            <p>Adresse : Québec, Canada</p>
            <p>Téléphone : (418) 555-0123</p>
            <p>Courriel : donnees@studiosunis.com</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">2. Finalités de la collecte</h2>
            <p>Nous collectons vos renseignements personnels aux fins suivantes :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Gestion des inscriptions aux cours de karaté</li>
                <li>Suivi de la progression et des présences</li>
                <li>Communication avec les membres</li>
                <li>Facturation et paiements</li>
                <li>Conformité aux exigences légales</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">3. Renseignements collectés</h2>
            <p>Nous collectons les renseignements suivants :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Nom, prénom, date de naissance</li>
                <li>Adresse de domicile</li>
                <li>Numéro de téléphone et courriel</li>
                <li>Informations de santé pertinentes (si applicable)</li>
                <li>Historique des cours et présences</li>
                <li>Données de connexion (logs, adresse IP)</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">4. Fondement juridique</h2>
            <p>Le traitement de vos données repose sur :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Votre consentement libre et éclairé</li>
                <li>L'exécution du contrat d'inscription</li>
                <li>Nos obligations légales</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">5. Vos droits selon la Loi 25</h2>
            <p>Vous disposez des droits suivants :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li><strong>Droit d'accès :</strong> Consulter vos renseignements personnels</li>
                <li><strong>Droit de rectification :</strong> Corriger des informations inexactes</li>
                <li><strong>Droit à la portabilité :</strong> Récupérer vos données</li>
                <li><strong>Droit de retrait du consentement :</strong> Retirer votre consentement</li>
                <li><strong>Droit à l'oubli :</strong> Demander la suppression (sous conditions)</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">6. Conservation des données</h2>
            <p>Vos renseignements sont conservés :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Données d'inscription : 7 ans après la fin de l'adhésion</li>
                <li>Données financières : 7 ans (exigence fiscale)</li>
                <li>Logs de connexion : 1 an maximum</li>
                <li>Données médicales : 10 ans (si applicable)</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">7. Sécurité des données</h2>
            <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Chiffrement des données sensibles</li>
                <li>Accès restreint aux données (principe du moindre privilège)</li>
                <li>Sauvegarde régulière et sécurisée</li>
                <li>Formation du personnel</li>
                <li>Surveillance et journalisation des accès</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">8. Communication de renseignements</h2>
            <p>Vos données peuvent être communiquées :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Aux instructeurs de votre école (pour les cours)</li>
                <li>Aux autorités compétentes (si requis par la loi)</li>
                <li>À nos prestataires de services (sous contrat de confidentialité)</li>
            </ul>
            <p class="mt-2"><strong>Aucune vente de données à des tiers.</strong></p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">9. Incident de confidentialité</h2>
            <p>En cas d'incident impliquant vos renseignements personnels, nous nous engageons à :</p>
            <ul class="list-disc ml-6 mt-2 space-y-1">
                <li>Vous notifier dans les meilleurs délais</li>
                <li>Informer la Commission d'accès à l'information (CAI) si requis</li>
                <li>Prendre toutes mesures correctives nécessaires</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">10. Exercer vos droits</h2>
            <p>Pour exercer vos droits ou pour toute question :</p>
            <div class="bg-blue-900/20 p-4 rounded-lg mt-3">
                <p><strong>Responsable de la protection des renseignements personnels</strong></p>
                <p>Courriel : <a href="mailto:donnees@studiosunis.com" class="text-blue-400">donnees@studiosunis.com</a></p>
                <p>Téléphone : (418) 555-0124</p>
                <p>Délai de réponse : 30 jours maximum</p>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">11. Plainte</h2>
            <p>Si vous n'êtes pas satisfait de notre réponse, vous pouvez déposer une plainte auprès de :</p>
            <div class="bg-gray-900/20 p-4 rounded-lg mt-3">
                <p><strong>Commission d'accès à l'information du Québec</strong></p>
                <p>Site web : <a href="https://www.cai.gouv.qc.ca" class="text-blue-400" target="_blank">www.cai.gouv.qc.ca</a></p>
                <p>Téléphone : 1 888 528-7741</p>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-white mb-3">12. Modifications</h2>
            <p>Cette politique peut être mise à jour. La version la plus récente est toujours disponible sur notre site.</p>
            <p class="text-sm text-gray-400 mt-2">Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
        </section>
        
        <div class="mt-8 p-4 bg-green-900/20 rounded-lg">
            <h3 class="text-lg font-semibold text-green-400 mb-2">Consentement</h3>
            <p>En utilisant nos services, vous confirmez avoir lu et compris cette politique de confidentialité.</p>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="btn-aurora">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
