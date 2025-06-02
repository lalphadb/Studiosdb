#!/bin/bash

# Script de correction du layout guest
# Corrige l'erreur "Undefined variable $slot"

echo "🔧 CORRECTION DU LAYOUT GUEST"
echo "============================"

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# 1. Backup
echo -e "${YELLOW}📦 Backup du fichier guest.blade.php...${NC}"
cp resources/views/layouts/guest.blade.php resources/views/layouts/guest.blade.php.backup-$(date +%Y%m%d-%H%M%S)

# 2. Corriger le layout guest
echo -e "${YELLOW}✏️ Correction du layout guest...${NC}"
cat > resources/views/layouts/guest.blade.php << 'EOF'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Studios Unis') }} - @yield('title', 'Bienvenue')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background: #050505;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 0, 128, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        .main-content {
            flex: 1;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #00d4ff 0%, #00ff88 100%);
            border: none;
            color: #000;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00d4ff;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(0, 212, 255, 0.25);
        }
        
        a {
            color: #00d4ff;
            text-decoration: none;
        }
        
        a:hover {
            color: #00ff88;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="main-content">
        @yield('content')
    </div>
    
    <!-- Footer Loi 25 -->
    @include('components.footer-loi25')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
EOF

# 3. Vérifier que le footer existe
echo -e "${YELLOW}📄 Vérification du footer Loi 25...${NC}"
if [ ! -f "resources/views/components/footer-loi25.blade.php" ]; then
    echo -e "${YELLOW}Création du footer Loi 25...${NC}"
    mkdir -p resources/views/components
    cat > resources/views/components/footer-loi25.blade.php << 'EOF'
<footer style="background: rgba(10, 10, 10, 0.8); border-top: 1px solid rgba(255, 255, 255, 0.1); padding: 20px 0; margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p style="color: #7c7c94; margin: 0;">© {{ date('Y') }} Studios Unis - Tous droits réservés</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('privacy-policy') }}" style="color: #7c7c94; margin: 0 10px;">Politique de confidentialité</a>
                <a href="{{ route('terms') }}" style="color: #7c7c94; margin: 0 10px;">Conditions</a>
                <a href="{{ route('contact') }}" style="color: #7c7c94; margin: 0 10px;">Contact</a>
            </div>
        </div>
    </div>
</footer>
EOF
fi

# 4. Vérifier le bouton back
echo -e "${YELLOW}🔙 Vérification du bouton back...${NC}"
if [ ! -f "resources/views/components/back-button.blade.php" ]; then
    echo -e "${YELLOW}Création du bouton back...${NC}"
    cat > resources/views/components/back-button.blade.php << 'EOF'
<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Retour
</a>
EOF
fi

# 5. Vider le cache
echo -e "${YELLOW}🔄 Vidage du cache...${NC}"
php artisan view:clear
php artisan cache:clear

# 6. Tester l'accès au dashboard
echo -e "${GREEN}✅ Correction terminée !${NC}"
echo ""
echo "📋 ACTIONS EFFECTUÉES :"
echo "---------------------"
echo "✓ Layout guest corrigé (remplacé \$slot par @yield)"
echo "✓ Footer Loi 25 vérifié/créé"
echo "✓ Bouton back vérifié/créé"
echo "✓ Cache vidé"
echo ""
echo -e "${YELLOW}🚀 TESTEZ MAINTENANT :${NC}"
echo "http://207.253.150.57/admin"
echo ""
echo "Si l'erreur persiste, vérifiez les logs :"
echo "tail -f storage/logs/laravel.log"
