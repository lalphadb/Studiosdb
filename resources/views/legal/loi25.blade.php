@extends('layouts.guest')

@section('title', 'Loi 25 - Protection des renseignements personnels')

@section('content')
<div class="aurora-card max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-6">Loi 25 - Protection des renseignements personnels</h1>
    
    <div class="text-gray-300 space-y-6">
        <section class="bg-blue-900/20 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-blue-400 mb-3">📋 Qu'est-ce que la Loi 25 ?</h2>
            <p>La Loi 25 modernise le cadre juridique de protection des renseignements personnels au Québec. Elle renforce les droits des citoyens et les obligations des entreprises.</p>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">🔐 Vos droits selon la Loi 25</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-green-400 mb-2">✅ Droit d'accès</h3>
                    <p class="text-sm">Consulter vos renseignements personnels que nous détenons</p>
                </div>
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-blue-400 mb-2">📝 Droit de rectification</h3>
                    <p class="text-sm">Corriger des informations inexactes ou incomplètes</p>
                </div>
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-purple-400 mb-2">📦 Droit à la portabilité</h3>
                    <p class="text-sm">Récupérer vos données dans un format lisible</p>
                </div>
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-red-400 mb-2">🗑️ Droit à l'oubli</h3>
                    <p class="text-sm">Demander la suppression de vos données (sous conditions)</p>
                </div>
            </div>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">🛡️ Nos engagements</h2>
            <ul class="space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                    <span>Protection renforcée de vos données personnelles</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                    <span>Notification rapide en cas d'incident de confidentialité</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                    <span>Consentement libre et éclairé pour la collecte de données</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                    <span>Minimisation des données collectées (uniquement le nécessaire)</span>
                </li>
            </ul>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">📞 Exercer vos droits</h2>
            <div class="bg-gradient-to-r from-blue-900/20 to-purple-900/20 p-6 rounded-lg">
                <h3 class="font-semibold text-white mb-3">Responsable de la protection des renseignements personnels</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-blue-400 font-medium">📧 Email</p>
                        <p>donnees@studiosunis.com</p>
                    </div>
                    <div>
                        <p class="text-blue-400 font-medium">📞 Téléphone</p>
                        <p>(418) 555-0124</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 mt-3">⏱️ Délai de réponse : 30 jours maximum</p>
            </div>
        </section>
        
        <section>
            <h2 class="text-xl font-semibold text-white mb-3">⚖️ Commission d'accès à l'information</h2>
            <div class="bg-gray-900/30 p-4 rounded-lg">
                <p class="mb-2">Si vous n'êtes pas satisfait de notre réponse :</p>
                <p>🌐 Site web : <a href="https://www.cai.gouv.qc.ca" class="text-blue-400 hover:text-blue-300" target="_blank">www.cai.gouv.qc.ca</a></p>
                <p>📞 Téléphone : 1 888 528-7741</p>
            </div>
        </section>
        
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('privacy-policy') }}" class="btn-aurora">
                📋 Politique complète
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
