#!/bin/bash

echo "🔧 Réinitialisation de la base de données StudiosUnisDB"
echo "=================================================="

# Demander confirmation
read -p "⚠️  ATTENTION: Ceci va supprimer toutes les données! Continuer? (oui/non): " confirm
if [ "$confirm" != "oui" ]; then
    echo "❌ Opération annulée"
    exit 1
fi

# Variables
DB_NAME="studiosdb"
DB_USER="root"

# Demander le mot de passe MySQL
read -sp "Mot de passe MySQL pour $DB_USER: " DB_PASS
echo

# Supprimer et recréer la base de données
echo "📦 Suppression et recréation de la base de données..."
mysql -u $DB_USER -p$DB_PASS << MYSQL_SCRIPT
DROP DATABASE IF EXISTS $DB_NAME;
CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SHOW DATABASES LIKE '$DB_NAME';
MYSQL_SCRIPT

# Vider tous les caches Laravel
echo "🧹 Nettoyage des caches Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Supprimer les fichiers de cache de schéma
rm -f bootstrap/cache/*.php

# Relancer les migrations
echo "🚀 Exécution des migrations..."
php artisan migrate:fresh

# Seeders de base
echo "🌱 Exécution des seeders..."
php artisan db:seed --class=ConsentTypeSeeder 2>/dev/null || echo "⚠️  ConsentTypeSeeder non trouvé"
php artisan db:seed --class=RoleSeeder 2>/dev/null || echo "⚠️  RoleSeeder non trouvé"

# Créer un super admin
echo "👤 Création du super admin..."
php artisan tinker << 'TINKER_SCRIPT'
$user = \App\Models\User::create([
    'name' => 'Super Admin',
    'email' => 'admin@studiosunisdb.com',
    'username' => 'superadmin',
    'password' => bcrypt('password123'),
    'role' => 'superadmin',
    'active' => true,
    'email_verified_at' => now(),
]);

// Assigner le rôle si Spatie est configuré
if (class_exists('Spatie\Permission\Models\Role')) {
    $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'superadmin']);
    $user->assignRole('superadmin');
}

echo "✅ Super admin créé: admin@studiosunisdb.com / password123\n";
exit
TINKER_SCRIPT

# Créer des données de test
echo "📊 Création des données de test..."
php artisan tinker << 'TINKER_SCRIPT'
// Écoles
$ecole1 = \App\Models\Ecole::create([
    'nom' => 'Studio St-Émile',
    'adresse' => '123 Rue Principale',
    'ville' => 'Québec',
    'province' => 'Québec',
    'telephone' => '418-555-0001',
    'email' => 'stemile@studiosunisdb.com',
    'statut' => 'actif',
    'responsable' => 'Jean Tremblay'
]);

$ecole2 = \App\Models\Ecole::create([
    'nom' => 'Studio Beauport',
    'adresse' => '456 Avenue des Arts',
    'ville' => 'Beauport',
    'province' => 'Québec',
    'telephone' => '418-555-0002',
    'email' => 'beauport@studiosunisdb.com',
    'statut' => 'actif',
    'responsable' => 'Marie Gagnon'
]);

// Quelques membres
for ($i = 1; $i <= 5; $i++) {
    \App\Models\Membre::create([
        'prenom' => 'Membre',
        'nom' => 'Test' . $i,
        'email' => 'membre' . $i . '@test.com',
        'telephone' => '418-555-01' . str_pad($i, 2, '0', STR_PAD_LEFT),
        'date_naissance' => now()->subYears(rand(8, 40)),
        'sexe' => $i % 2 ? 'H' : 'F',
        'ecole_id' => $i <= 3 ? $ecole1->id : $ecole2->id,
        'approuve' => $i <= 3
    ]);
}

echo "✅ Données de test créées\n";
exit
TINKER_SCRIPT

echo ""
echo "✅ Base de données réinitialisée avec succès!"
echo ""
echo "📋 Récapitulatif:"
echo "   - Base de données: $DB_NAME"
echo "   - Admin: admin@studiosunisdb.com / password123"
echo "   - 2 écoles créées"
echo "   - 5 membres de test créés"
echo ""
echo "🎉 Vous pouvez maintenant vous connecter!"

