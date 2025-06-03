#!/bin/bash
# fix_controllers.sh

echo "🔧 Correction des contrôleurs..."

cd /var/www/html/studiosdb/app/Http/Controllers/Admin

# 1. Corriger MembreController
echo "📝 Correction de MembreController..."
if [ -f "MembreController.php" ]; then
    # Option 1: Renommer le fichier pour correspondre aux routes
    mv MembreController.php MembresController.php
    sed -i 's/class MembreController/class MembresController/g' MembresController.php
    echo "✅ MembreController renommé en MembresController"
fi

# 2. Corriger InscriptionController
echo "📝 Correction de InscriptionController..."
if [ -f "InscriptionController.php" ]; then
    # Le fichier devrait correspondre à sa classe
    mv InscriptionController.php InscriptionCoursController_temp.php
    # Vérifier si InscriptionCoursController.php existe déjà
    if [ ! -f "InscriptionCoursController.php" ]; then
        mv InscriptionCoursController_temp.php InscriptionCoursController.php
        echo "✅ InscriptionController renommé en InscriptionCoursController"
    else
        echo "⚠️  InscriptionCoursController.php existe déjà, suppression du doublon"
        rm InscriptionCoursController_temp.php
    fi
fi

# 3. Vérifier les doublons
echo "🔍 Recherche de doublons..."
find . -name "*Controller.php" -type f | sort | uniq -d

# 4. Nettoyer le cache
cd /var/www/html/studiosdb
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

echo "✅ Correction terminée!"
