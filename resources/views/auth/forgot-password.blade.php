<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - Studios Unis</title>
    
    <link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-futuristic.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-body">
    <div class="particles-container">
        @for ($i = 1; $i <= 5; $i++)
            <div class="particle"></div>
        @endfor
    </div>

    <div class="grid-bg"></div>

    <div class="auth-container">
        <div class="auth-card animate-fadeInUp">
            <div class="auth-logo">
                <div class="logo-glow">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="logo-text">Réinitialisation</h1>
                <p class="logo-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="auth-form active">
                @csrf
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               name="email" 
                               class="form-input @error('email') error @enderror" 
                               placeholder="Adresse email"
                               value="{{ old('email') }}"
                               required 
                               autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <span class="btn-text">Envoyer le lien</span>
                    <span class="btn-loading">
                        <i class="fas fa-circle-notch fa-spin"></i>
                    </span>
                </button>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('login') }}" class="link-btn" style="color: #00caff; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Retour à la connexion
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
