#!/bin/bash

echo "🔧 Configuration de la page d'accueil..."

# 1. Corriger la route principale
echo "📝 Mise à jour de routes/web.php..."
sed -i '1,20s/return view("welcome");/return redirect()->route("login");/g' routes/web.php

# 2. S'assurer que la redirection est correcte
if ! grep -q "redirect()->route('login')" routes/web.php; then
    echo "❌ Mise à jour manuelle nécessaire de routes/web.php"
    echo "Changez la route '/' pour : return redirect()->route('login');"
fi

# 3. Vider tous les caches
echo "🧹 Nettoyage des caches..."
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# 4. Optimiser
php artisan optimize:clear

echo "✅ Configuration terminée!"
echo "🎯 La page d'accueil redirige maintenant vers /login"
