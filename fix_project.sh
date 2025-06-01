#!/bin/bash

echo "🔧 Correction du projet StudiosUnisDB..."

# 1. Backup
echo "📦 Création d'un backup..."
cp app/Http/Requests/Auth/LoginRequest.php app/Http/Requests/Auth/LoginRequest.php.backup
cp app/Models/CoursSchedule.php app/Models/CoursSchedule.php.backup

# 2. Nettoyer les caches
echo "🧹 Nettoyage des caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Optimiser
echo "⚡ Optimisation..."
php artisan optimize

# 4. Vérifier les erreurs PHP
echo "🔍 Vérification des erreurs PHP..."
find app -name "*.php" -exec php -l {} \; | grep -v "No syntax errors"

# 5. Créer les rôles Spatie si nécessaire
echo "👥 Vérification des rôles..."
php artisan tinker --execute="
use Spatie\Permission\Models\Role;
if (Role::count() == 0) {
    Role::create(['name' => 'super-admin']);
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'instructeur']);
    Role::create(['name' => 'membre']);
    echo 'Rôles créés!';
} else {
    echo 'Rôles déjà existants';
}
"

echo "✅ Corrections terminées!"
