@extends('layouts.guest')

@section('title', 'Contact')

@section('content')
<div class="aurora-card max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-6">Nous contacter</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-xl font-semibold text-white mb-4">Informations de contact</h2>
            
            <div class="space-y-4">
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-white mb-2">Studios Unis - Siège social</h3>
                    <p class="text-gray-300"><i class="fas fa-map-marker-alt mr-2"></i>Québec, QC</p>
                    <p class="text-gray-300"><i class="fas fa-phone mr-2"></i>(418) 555-0123</p>
                    <p class="text-gray-300"><i class="fas fa-envelope mr-2"></i>info@studiosunis.com</p>
                </div>
                
                <div class="p-4 bg-white/5 rounded-lg">
                    <h3 class="font-semibold text-white mb-2">Protection des données</h3>
                    <p class="text-gray-300"><i class="fas fa-shield-alt mr-2"></i>donnees@studiosunis.com</p>
                    <p class="text-gray-300"><i class="fas fa-phone mr-2"></i>(418) 555-0124</p>
                </div>
            </div>
        </div>
        
        <div>
            <h2 class="text-xl font-semibold text-white mb-4">Formulaire de contact</h2>
            <form class="space-y-4" action="{{ route('contact') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nom complet</label>
                    <input type="text" name="name" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Sujet</label>
                    <select name="subject" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white" required>
                        <option value="">Choisir un sujet</option>
                        <option value="general">Question générale</option>
                        <option value="inscription">Inscription</option>
                        <option value="donnees">Protection des données</option>
                        <option value="technique">Support technique</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                    <textarea name="message" rows="4" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white" required></textarea>
                </div>
                
                <button type="submit" class="btn-aurora w-full">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Envoyer
                </button>
            </form>
        </div>
    </div>
    
    <div class="mt-8 text-center">
        <a href="{{ route('login') }}" class="btn-aurora">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la connexion
        </a>
    </div>
</div>
@endsection
