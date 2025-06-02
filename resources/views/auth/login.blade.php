<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Studios Unis</title>
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Login avec les VRAIES couleurs du thème */
        body {
            background: #1a1d21; /* Votre fond principal */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Effet de grille animée en arrière-plan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(32, 185, 190, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(32, 185, 190, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: grid-move 20s linear infinite;
            z-index: 0;
        }

        @keyframes grid-move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Orbes lumineux flottants */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.5;
            animation: float 20s infinite ease-in-out;
        }

        .orb1 {
            width: 400px;
            height: 400px;
            background: #20b9be;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .orb2 {
            width: 300px;
            height: 300px;
            background: #e91e63;
            bottom: -150px;
            right: -150px;
            animation-delay: 5s;
        }

        .orb3 {
            width: 250px;
            height: 250px;
            background: #ff9800;
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(100px, -100px) scale(1.1); }
            50% { transform: translate(-100px, 100px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }

        /* Container principal */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        /* Card avec effet glass comme vos cartes */
        .login-card {
            background: #293237; /* Couleur de vos cartes */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        /* Bordure cyan en haut comme vos cartes */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #20b9be;
        }

        /* Logo */
        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #20b9be, #4caf50);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(32, 185, 190, 0.5);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(32, 185, 190, 0.5); }
            50% { box-shadow: 0 0 40px rgba(32, 185, 190, 0.8); }
        }

        .logo-container i {
            font-size: 40px;
            color: white;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }

        .logo-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-top: 5px;
        }

        /* Tabs comme votre design */
        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: #20b9be;
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 20px rgba(32, 185, 190, 0.5);
        }

        /* Inputs comme votre thème */
        .form-group {
            margin-bottom: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 18px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: #20b9be;
            box-shadow: 0 0 0 3px rgba(32, 185, 190, 0.1);
        }

        /* Toggle switch moderne */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .toggle-switch {
            display: flex;
            align-items: center;
            cursor: pointer;
            gap: 10px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            width: 50px;
            height: 26px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 13px;
            position: relative;
            transition: all 0.3s ease;
        }

        .toggle-slider::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
        }

        .toggle-switch input:checked + .toggle-slider {
            background: #20b9be;
            border-color: transparent;
        }

        .toggle-switch input:checked + .toggle-slider::after {
            transform: translateX(24px);
        }

        .toggle-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        /* Bouton submit */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #20b9be;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            background: #1a9da0;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(32, 185, 190, 0.5);
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #20b9be;
        }

        /* Liens */
        .forgot-link {
            color: #20b9be;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #ff9800;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #20b9be;
        }

        /* Messages d'erreur */
        .error-message {
            color: #f44336;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .divider span {
            background: #293237;
            padding: 0 20px;
            color: rgba(255, 255, 255, 0.5);
            position: relative;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
            
            .tabs-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Orbes lumineux animés -->
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <div class="login-container">
        <div class="login-card" x-data="{ activeTab: 'login', showPassword: false }">
            <!-- Logo -->
            <div class="logo-section">
                <div class="logo-container">
                    <i class="fas fa-infinity"></i>
                </div>
                <h1 class="logo-title">Studios Unis</h1>
                <p class="logo-subtitle">Système de gestion avant-gardiste</p>
            </div>

            <!-- Tabs -->
            <div class="tabs-container">
                <button class="tab-btn" :class="{ active: activeTab === 'login' }" @click="activeTab = 'login'">
                    <i class="fas fa-sign-in-alt"></i>
                    Connexion
                </button>
                <button class="tab-btn" :class="{ active: activeTab === 'register' }" @click="activeTab = 'register'">
                    <i class="fas fa-user-plus"></i>
                    Inscription
                </button>
                <button class="tab-btn" :class="{ active: activeTab === 'po' }" @click="activeTab = 'po'" style="background: linear-gradient(135deg, #ff9800, #ffab00); color: #1a1d21;">
                    <i class="fas fa-door-open"></i>
                    Portes Ouvertes
                </button>
            </div>

            <!-- Formulaire de connexion -->
            <form method="POST" action="{{ route('login') }}" x-show="activeTab === 'login'" x-transition>
                @csrf
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               name="email" 
                               class="form-input" 
                               placeholder="Adresse email"
                               value="{{ old('email') }}"
                               required 
                               autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               class="form-input" 
                               placeholder="Mot de passe"
                               required>
                        <button type="button" class="password-toggle" @click="showPassword = !showPassword">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="toggle-switch">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                        <span class="toggle-label">Se souvenir de moi</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Mot de passe oublié?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    SE CONNECTER
                </button>

                <div class="divider">
                    <span>ou</span>
                </div>

                <div style="text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.6); margin-bottom: 10px;">
                        Pas encore de compte?
                    </p>
                    <a href="#" @click.prevent="activeTab = 'register'" style="color: #20b9be; text-decoration: none;">
                        <i class="fas fa-user-plus"></i> Créer un compte
                    </a>
                </div>
            </form>

            <!-- Formulaire d'inscription -->
            <form method="POST" action="{{ route('register') }}" x-show="activeTab === 'register'" x-transition x-cloak>
                @csrf
                
                <div style="text-align: center; margin-bottom: 20px;">
                    <h3 style="color: white; margin-bottom: 10px;">Type de membre</h3>
                    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <label style="flex: 1; cursor: pointer;">
                            <input type="radio" name="member_type" value="new" checked style="display: none;">
                            <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border: 2px solid rgba(255, 255, 255, 0.1); border-radius: 10px; text-align: center; transition: all 0.3s ease;">
                                <i class="fas fa-user" style="font-size: 24px; color: #20b9be; display: block; margin-bottom: 5px;"></i>
                                <span style="color: rgba(255, 255, 255, 0.8); font-size: 14px;">Nouveau membre</span>
                            </div>
                        </label>
                        <label style="flex: 1; cursor: pointer;">
                            <input type="radio" name="member_type" value="existing" style="display: none;">
                            <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border: 2px solid rgba(255, 255, 255, 0.1); border-radius: 10px; text-align: center; transition: all 0.3s ease;">
                                <i class="fas fa-user-check" style="font-size: 24px; color: #4caf50; display: block; margin-bottom: 5px;"></i>
                                <span style="color: rgba(255, 255, 255, 0.8); font-size: 14px;">Ancien membre</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group" style="margin: 0;">
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="prenom" class="form-input" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nom" class="form-input" placeholder="Nom" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-input" placeholder="Mot de passe" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Confirmer le mot de passe" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-school input-icon"></i>
                        <select name="ecole_id" class="form-input" required style="cursor: pointer;">
                            <option value="">Sélectionnez votre école</option>
                            @if(isset($ecoles))
                                @foreach($ecoles as $ecole)
                                    <option value="{{ $ecole->id }}">{{ $ecole->nom }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    CRÉER MON COMPTE
                </button>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" @click.prevent="activeTab = 'login'" style="color: #20b9be; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Retour à la connexion
                    </a>
                </div>
            </form>

            <!-- Formulaire Portes Ouvertes -->
            <div x-show="activeTab === 'po'" x-transition x-cloak>
                <div style="text-align: center; margin-bottom: 30px;">
                    <i class="fas fa-door-open" style="font-size: 50px; color: #ff9800; margin-bottom: 15px; display: block;"></i>
                    <h3 style="color: white; margin-bottom: 10px;">Journées Portes Ouvertes</h3>
                    <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px;">
                        Découvrez nos installations et rencontrez nos instructeurs
                    </p>
                </div>

                <form method="POST" action="{{ route('portes-ouvertes.register') }}">
                    @csrf
                    
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-school input-icon"></i>
                            <select name="ecole_po_id" class="form-input" required>
                                <option value="">Choisissez une école</option>
                                <!-- Les écoles avec PO actives seront chargées ici -->
                            </select>
                        </div>
                    </div>

                    <div id="po-dates" style="margin-bottom: 20px;">
                        <!-- Les dates seront chargées dynamiquement -->
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div class="form-group" style="margin: 0;">
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="po_prenom" class="form-input" placeholder="Prénom" required>
                            </div>
                        </div>
                        <div class="form-group" style="margin: 0;">
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="po_nom" class="form-input" placeholder="Nom" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="po_email" class="form-input" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" name="po_telephone" class="form-input" placeholder="Téléphone (optionnel)">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #ff9800, #ffab00);">
                        S'INSCRIRE À LA JOURNÉE
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" @click.prevent="activeTab = 'login'" style="color: #20b9be; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p>&copy; {{ date('Y') }} Studios Unis. Tous droits réservés.</p>
            <div class="footer-links">
                <a href="{{ route('privacy-policy') }}">Confidentialité</a>
                <span>•</span>
                <a href="{{ route('terms') }}">Conditions</a>
                <span>•</span>
                <a href="{{ route('contact') }}">Support</a>
            </div>
        </div>
    </div>
</body>
</html>
