@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="theta-card">
                <h1 class="text-center mb-4">Politique de confidentialité</h1>
                
                <section class="mb-5">
                    <h2>1. Introduction</h2>
                    <p>Studios Unis s'engage à protéger la confidentialité des renseignements personnels de ses membres conformément à la Loi 25 du Québec.</p>
                </section>
                
                <section class="mb-5" id="collecte">
                    <h2>2. Collecte des renseignements</h2>
                    <p>Nous recueillons uniquement les renseignements nécessaires pour :</p>
                    <ul>
                        <li>Gérer les inscriptions aux cours</li>
                        <li>Assurer le suivi de la progression</li>
                        <li>Communiquer avec nos membres</li>
                        <li>Respecter nos obligations légales</li>
                    </ul>
                </section>
                
                <section class="mb-5" id="utilisation">
                    <h2>3. Utilisation des renseignements</h2>
                    <p>Les renseignements personnels sont utilisés exclusivement pour les fins auxquelles ils ont été recueillis.</p>
                </section>
                
                <section class="mb-5" id="protection">
                    <h2>4. Protection des renseignements</h2>
                    <p>Nous mettons en place des mesures de sécurité appropriées pour protéger vos renseignements personnels contre tout accès non autorisé.</p>
                </section>
                
                <section class="mb-5" id="droits">
                    <h2>5. Vos droits</h2>
                    <p>Vous avez le droit de :</p>
                    <ul>
                        <li>Accéder à vos renseignements personnels</li>
                        <li>Demander la rectification de vos renseignements</li>
                        <li>Retirer votre consentement</li>
                        <li>Demander la suppression de vos renseignements</li>
                    </ul>
                </section>
                
                <section class="mb-5">
                    <h2>6. Contact</h2>
                    <p>Pour toute question concernant cette politique ou vos renseignements personnels :</p>
                    <p>
                        <strong>Responsable de la protection des renseignements personnels</strong><br>
                        Studios Unis<br>
                        Email: confidentialite@studiosunisdb.com<br>
                        Téléphone: (418) 555-0123
                    </p>
                </section>
                
                <div class="text-center mt-5">
                    <small class="text-muted">Dernière mise à jour : {{ date('d F Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
