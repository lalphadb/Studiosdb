#!/bin/bash
# create_api_controllers.sh

echo "Création des contrôleurs API..."

# Créer le répertoire Api s'il n'existe pas
mkdir -p app/Http/Controllers/Api

# Générer les contrôleurs
php artisan make:controller Api/EcoleController --api
php artisan make:controller Api/MembreController --api
php artisan make:controller Api/CoursController --api
php artisan make:controller Api/PresenceController --api
php artisan make:controller Api/SessionController --api
php artisan make:controller Api/CeintureController --api

echo "✅ Contrôleurs API créés!"
