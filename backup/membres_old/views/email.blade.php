@extends('layouts.admin')

@section('title', 'Envoyer un email - ' . $membre->prenom . ' ' . $membre->nom)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic.css') }}">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="glass-card mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-envelope text-neon-blue"></i>
                        Envoyer un email
                    </h1>
                    <p class="text-gray-400 mt-1">
                        À : {{ $membre->prenom }} {{ $membre->nom }} ({{ $membre->email }})
                    </p>
                </div>
                <a href="{{ route('admin.membres.show', $membre) }}" class="btn-glass">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au profil
                </a>
            </div>
        </div>

        <!-- Email Form -->
        <div class="glass-card">
            <form action="{{ route('admin.membres.send-email', $membre) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Template</label>
                    <select id="emailTemplate" class="glass-input" onchange="loadTemplate()">
                        <option value="">Message personnalisé</option>
                        <option value="bienvenue">Bienvenue</option>
                        <option value="rappel_cours">Rappel de cours</option>
                        <option value="nouvelle_ceinture">Nouvelle ceinture</option>
                        <option value="inscription_seminaire">Inscription séminaire</option>
                    </select>
                </div>
                
                <div class="form-floating mb-6">
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           class="glass-input" 
                           placeholder="Objet"
                           required>
                    <label for="subject">Objet du message</label>
                </div>
                
                <div class="form-floating mb-6">
                    <textarea id="message" 
                              name="message" 
                              class="glass-input" 
                              rows="12"
                              placeholder="Message"
                              required></textarea>
                    <label for="message">Message</label>
                </div>
                
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.membres.show', $membre) }}" class="btn-glass">
                        Annuler
                    </a>
                    <button type="submit" class="btn-glass btn-glass-primary">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer l'email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const templates = {
    bienvenue: {
        subject: 'Bienvenue chez Studios Unis!',
        message: `Bonjour {{ $membre->prenom }},

Nous sommes ravis de vous accueillir au sein de Studios Unis!

Votre inscription a été confirmée pour l'école {{ $membre->ecole->nom ?? '' }}.

N'hésitez pas à nous contacter si vous avez des questions.

Cordialement,
L'équipe Studios Unis`
    },
    rappel_cours: {
        subject: 'Rappel - Votre prochain cours',
        message: `Bonjour {{ $membre->prenom }},

Ceci est un rappel amical pour votre prochain cours de karaté.

N'oubliez pas d'apporter votre équipement!

À bientôt,
L'équipe Studios Unis`
    },
    nouvelle_ceinture: {
        subject: 'Félicitations pour votre nouvelle ceinture!',
        message: `Bonjour {{ $membre->prenom }},

Toutes nos félicitations pour l'obtention de votre nouvelle ceinture!

Votre progression est remarquable et nous sommes fiers de votre parcours.

Continuez ainsi!
L'équipe Studios Unis`
    },
    inscription_seminaire: {
        subject: 'Confirmation d\'inscription au séminaire',
        message: `Bonjour {{ $membre->prenom }},

Votre inscription au séminaire a été confirmée.

Nous avons hâte de vous y voir!

Cordialement,
L'équipe Studios Unis`
    }
};

function loadTemplate() {
    const template = document.getElementById('emailTemplate').value;
    if (templates[template]) {
        document.getElementById('subject').value = templates[template].subject;
        document.getElementById('message').value = templates[template].message;
    }
}
</script>
@endpush
@endsection
