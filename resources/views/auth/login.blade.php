<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Studios Unis</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* =============================================
           STUDIOS UNIS - NÉOMORPHISME DARK ELITE
           Design sculptural avec reliefs organiques
           ============================================= */
        :root {
            /* PALETTE NÉOMORPHISME */
            --primary-bg: #1a1a1a;
            --surface-bg: #252525;
            --elevated-bg: #2f2f2f;
            --sunken-bg: #1f1f1f;
            
            /* COULEURS ORGANIQUES */
            --accent-gold: #d4af37;
            --warm-copper: #b87333;
            --steel-blue: #4682b4;
            --sage-green: #87a96b;
            --warm-gray: #8b8680;
            
            /* OMBRES NÉOMORPHIQUES */
            --shadow-raised: 
                6px 6px 12px rgba(0, 0, 0, 0.4),
                -6px -6px 12px rgba(255, 255, 255, 0.05);
            --shadow-pressed: 
                inset 4px 4px 8px rgba(0, 0, 0, 0.5),
                inset -4px -4px 8px rgba(255, 255, 255, 0.03);
            --shadow-floating: 
                0 10px 30px rgba(0, 0, 0, 0.6),
                0 1px 8px rgba(255, 255, 255, 0.1);
            
            /* TEXTE RAFFINÉ */
            --text-primary: #e8e8e8;
            --text-secondary: #b8b8b8;
            --text-muted: #888888;
            --text-accent: var(--accent-gold);
            
            /* TRANSITIONS ORGANIQUES */
            --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--primary-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Fond animé organique */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(70, 130, 180, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(184, 115, 51, 0.05) 0%, transparent 50%);
            animation: backgroundFloat 20s ease-in-out infinite;
        }

        @keyframes backgroundFloat {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }

        /* Container principal */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        /* Carte de connexion néomorphique */
        .login-card {
            background: var(--surface-bg);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-floating);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-gold), var(--warm-copper), var(--steel-blue));
            border-radius: 24px 24px 0 0;
        }

        /* En-tête */
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-container {
            background: var(--elevated-bg);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow-raised);
            transition: var(--transition-bounce);
        }

        .logo-container:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: var(--shadow-floating);
        }

        .logo-container i {
            font-size: 2.5rem;
            color: var(--accent-gold);
            animation: logoGlow 3s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% { text-shadow: 0 0 10px rgba(212, 175, 55, 0.3); }
            50% { text-shadow: 0 0 20px rgba(212, 175, 55, 0.6), 0 0 30px rgba(212, 175, 55, 0.4); }
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 400;
        }

        /* Formulaire */
        .login-form {
            space: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            background: var(--sunken-bg);
            border: none;
            border-radius: 16px;
            padding: 1rem 1rem 1rem 3.5rem;
            color: var(--text-primary);
            font-size: 1rem;
            box-shadow: var(--shadow-pressed);
            transition: var(--transition-smooth);
            outline: none;
        }

        .form-input:focus {
            box-shadow: 
                var(--shadow-pressed),
                0 0 0 2px rgba(212, 175, 55, 0.3);
            background: var(--elevated-bg);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--warm-gray);
            font-size: 1.1rem;
            transition: var(--transition-smooth);
        }

        .form-input:focus + .form-icon {
            color: var(--accent-gold);
            transform: translateY(-50%) scale(1.1);
        }

        /* Bouton de connexion */
        .login-button {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-gold), var(--warm-copper));
            border: none;
            border-radius: 16px;
            padding: 1rem 2rem;
            color: var(--primary-bg);
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: var(--shadow-raised);
            transition: var(--transition-bounce);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-floating);
        }

        .login-button:active {
            transform: translateY(0);
            box-shadow: var(--shadow-pressed);
        }

        /* Options supplémentaires */
        .login-options {
            margin-top: 2rem;
            text-align: center;
        }

        .remember-me {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .custom-checkbox {
            position: relative;
            margin-right: 0.8rem;
        }

        .custom-checkbox input {
            opacity: 0;
            position: absolute;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            background: var(--sunken-bg);
            border-radius: 6px;
            box-shadow: var(--shadow-pressed);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
        }

        .custom-checkbox input:checked + .checkmark {
            background: var(--accent-gold);
            box-shadow: var(--shadow-raised);
        }

        .checkmark i {
            color: var(--primary-bg);
            font-size: 0.8rem;
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .custom-checkbox input:checked + .checkmark i {
            opacity: 1;
        }

        .forgot-password {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition-smooth);
            position: relative;
        }

        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--accent-gold);
            transition: var(--transition-smooth);
        }

        .forgot-password:hover {
            color: var(--accent-gold);
        }

        .forgot-password:hover::after {
            width: 100%;
        }

        /* Alerte d'erreur néomorphique */
        .alert {
            background: var(--surface-bg);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-raised);
            border-left: 4px solid #dc3545;
        }

        .alert-error {
            color: #ff6b6b;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .logo-container {
                width: 60px;
                height: 60px;
            }
            
            .logo-container i {
                font-size: 2rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }

        /* Animation d'entrée */
        .login-card {
            animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* États de loading */
        .login-button.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .login-button.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: var(--primary-bg);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="login-title">Studios Unis</h1>
                <p class="login-subtitle">Connectez-vous à votre espace</p>
            </div>

            <!-- Affichage des erreurs -->
            <div class="alert alert-error" style="display: none;" id="errorAlert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span id="errorMessage">Identifiants incorrects</span>
            </div>

            <form class="login-form" id="loginForm" method="POST" action="/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <div class="form-input-container">
                        <input type="email" 
                               class="form-input" 
                               name="email" 
                               placeholder="votre@email.com"
                               value="{{ old('email') }}"
                               required>
                        <i class="fas fa-envelope form-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <div class="form-input-container">
                        <input type="password" 
                               class="form-input" 
                               name="password" 
                               placeholder="••••••••••"
                               required>
                        <i class="fas fa-lock form-icon"></i>
                    </div>
                </div>

                <button type="submit" class="login-button" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Se connecter
                </button>

                <div class="login-options">
                    <label class="remember-me">
                        <div class="custom-checkbox">
                            <input type="checkbox" name="remember">
                            <div class="checkmark">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        Se souvenir de moi
                    </label>

                    <a href="/password/reset" class="forgot-password">
                        Mot de passe oublié ?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Gestion du formulaire
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            
            // Animation de loading
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connexion...';
            
            // Permettre la soumission normale du formulaire
            // (ne pas faire e.preventDefault() pour que Laravel traite la requête)
        });

        // Animation au focus des inputs
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Effet de particules sur le logo
        const logo = document.querySelector('.logo-container');
        logo.addEventListener('click', function() {
            this.style.animation = 'none';
            setTimeout(() => {
                this.style.animation = 'logoGlow 3s ease-in-out infinite';
            }, 10);
        });

        // Gestion des erreurs (si Laravel renvoie des erreurs)
        @if ($errors->any())
            document.getElementById('errorAlert').style.display = 'block';
            document.getElementById('errorMessage').textContent = '{{ $errors->first() }}';
            
            // Reset button state si erreur
            const btn = document.getElementById('loginBtn');
            btn.classList.remove('loading');
            btn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Se connecter';
        @endif
    </script>
</body>
</html>
