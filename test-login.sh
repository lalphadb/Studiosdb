#!/bin/bash

echo "🔍 Vérification du système de login..."

# Vérifier les routes
echo -e "\n📍 Routes d'authentification:"
php artisan route:list | grep -E "(login|logout|register|password)" | head -20

# Vérifier les controllers
echo -e "\n📁 Controllers Auth:"
ls -la app/Http/Controllers/Auth/

# Vérifier la vue login
echo -e "\n📄 Vue login:"
if [ -f resources/views/auth/login.blade.php ]; then
    echo "✅ Vue login existe"
else
    echo "❌ Vue login manquante"
fi

# Vérifier le modèle User
echo -e "\n👤 Modèle User:"
grep -n "use HasFactory" app/Models/User.php

echo -e "\n✅ Vérification terminée!"
