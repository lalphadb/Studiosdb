<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Connexion - Studios Unis</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center mb-4">
                    <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white">Studios Unis</h2>
                <p class="mt-2 text-blue-100">Système de gestion des écoles de karaté</p>
            </div>

            <!-- Formulaire de connexion -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-white/20">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            Adresse email
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm"
                               placeholder="votre@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">
                            Mot de passe
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required
                               class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Se souvenir -->
                    <div class="flex items-center">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-white/30 rounded bg-white/20">
                        <label for="remember" class="ml-2 block text-sm text-white">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Erreurs générales -->
                    @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                        <div class="bg-red-500/20 border border-red-400/50 text-red-100 px-4 py-3 rounded-lg">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Bouton de connexion -->
                    <button type="submit" 
                            class="w-full bg-white text-blue-900 font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 transition duration-200 transform hover:scale-105">
                        Se connecter
                    </button>
                </form>

                <!-- Liens de test (si mode debug) -->
                @if(config('app.debug'))
                <div class="mt-6 pt-6 border-t border-white/20">
                    <p class="text-xs text-white/60 text-center mb-3">Mode développement</p>
                    <a href="/quick-login" 
                       class="block w-full text-center bg-yellow-500/20 text-yellow-100 py-2 px-4 rounded-lg text-sm hover:bg-yellow-500/30 transition duration-200">
                        Connexion rapide (dev)
                    </a>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-blue-100 text-sm">
                    © {{ date('Y') }} Studios Unis - Tous droits réservés
                </p>
            </div>
        </div>
    </div>
</body>
</html>
