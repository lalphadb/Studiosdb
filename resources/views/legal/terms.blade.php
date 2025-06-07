@extends('layouts.guest')

@section('title', 'Conditions d\'utilisation')

@section('content')
<div class="aurora-card max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-6">Conditions d'utilisation</h1>
    
    <div class="text-gray-300 space-y-6">
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">1. Conditions générales</h2>
            <p>En utilisant la plateforme Studios Unis, vous acceptez les présentes conditions d'utilisation.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">2. Inscription et compte utilisateur</h2>
            <p>L'inscription nécessite de fournir des informations exactes et complètes. Vous êtes responsable de la sécurité de votre compte.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">3. Utilisation des services</h2>
            <p>Nos services sont destinés exclusivement aux activités de karaté et d'arts martiaux. Toute utilisation abusive est interdite.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">4. Responsabilités des utilisateurs</h2>
            <ul class="list-disc ml-6 space-y-1">
                <li>Respecter le règlement de l'école</li>
                <li>Fournir des informations exactes</li>
                <li>Respecter les autres membres</li>
                <li>Signaler tout problème technique</li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">5. Limitation de responsabilité</h2>
            <p>Studios Unis ne peut être tenu responsable des dommages indirects liés à l'utilisation de la plateforme.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">6. Protection des données</h2>
            <p>Vos données personnelles sont traitées conformément à notre <a href="{{ route('privacy-policy') }}" class="text-blue-400 hover:text-blue-300">politique de confidentialité</a>.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">7. Modification des conditions</h2>
            <p>Studios Unis se réserve le droit de modifier ces conditions à tout moment. Les utilisateurs seront informés des changements importants.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">8. Droit applicable</h2>
            <p>Ces conditions sont régies par les lois du Québec, Canada.</p>
        </section>
        
        <div class="mt-8 p-4 bg-blue-900/20 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-400 mb-2">Contact</h3>
            <p>Pour toute question concernant ces conditions :</p>
            <p>Courriel : <a href="mailto:legal@studiosunis.com" class="text-blue-400">legal@studiosunis.com</a></p>
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
