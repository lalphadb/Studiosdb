#!/bin/bash

echo "🔧 Correction des permissions Laravel..."

# Variables
PROJECT_PATH="/var/www/html/studiosdb"
WEB_USER="www-data"
CURRENT_USER=$(whoami)

cd $PROJECT_PATH

echo "📁 Correction des permissions storage et cache..."

# Créer les dossiers s'ils n'existent pas
mkdir -p storage/{app,framework,logs}
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Permissions pour storage
sudo chown -R $CURRENT_USER:$WEB_USER storage
sudo chown -R $CURRENT_USER:$WEB_USER bootstrap/cache

# Permissions d'écriture pour le groupe
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# S'assurer que les fichiers futurs héritent des permissions
sudo chmod g+s storage
sudo chmod g+s bootstrap/cache

# Permissions spéciales pour les logs
sudo chmod -R 775 storage/logs

# Créer le fichier laravel.log s'il n'existe pas
touch storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log
sudo chown $CURRENT_USER:$WEB_USER storage/logs/laravel.log

echo "✅ Permissions corrigées!"

# Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "✅ Terminé!"
