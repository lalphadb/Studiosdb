<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Studios Unis') }} - @yield('title', 'Authentification')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-content">
            @yield('content')
        </div>
        
        <!-- Footer en bas avec couleurs forcées -->
        <div class="auth-footer">
            <div class="auth-footer-links">
                <a href="{{ route('privacy-policy') }}" style="color: #8492a5 !important; text-decoration: none; font-size: 0.875rem; transition: color 0.25s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#8492a5'">Politique de confidentialité</a>
                <span style="color: rgba(255,255,255,0.5); margin: 0 0.5rem;">•</span>
                <a href="{{ route('terms') }}" style="color: #8492a5 !important; text-decoration: none; font-size: 0.875rem; transition: color 0.25s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#8492a5'">Conditions d'utilisation</a>
                <span style="color: rgba(255,255,255,0.5); margin: 0 0.5rem;">•</span>
                <a href="{{ route('contact') }}" style="color: #8492a5 !important; text-decoration: none; font-size: 0.875rem; transition: color 0.25s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#8492a5'">Loi 25</a>
            </div>
            <p style="color: rgba(255,255,255,0.5) !important; font-size: 0.75rem; margin: 0; line-height: 1.4; text-align: center;">
                © {{ date('Y') }} Studios Unis Karaté Québec. Tous droits réservés.<br>
                <small style="opacity: 0.8; color: rgba(255,255,255,0.4) !important;">Conforme à la Loi 25 sur la protection des renseignements personnels</small>
            </p>
        </div>
    </div>
</body>
</html>
