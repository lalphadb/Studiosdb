#!/bin/bash

# Créer le fichier d'audit avec timestamp
AUDIT_FILE="audit_studiosdb_$(date +%Y%m%d_%H%M%S).txt"

echo "=== AUDIT COMPLET PROJET STUDIOSUNISDB ===" > $AUDIT_FILE
echo "Date: $(date)" >> $AUDIT_FILE
echo "=========================================" >> $AUDIT_FILE
echo "" >> $AUDIT_FILE

# 1. STRUCTURE DU PROJET
echo "### 1. STRUCTURE DU PROJET ###" >> $AUDIT_FILE
echo "Arborescence principale:" >> $AUDIT_FILE
tree -L 3 -I 'vendor|node_modules|storage|.git' >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 2. CONFIGURATION LARAVEL
echo "### 2. CONFIGURATION LARAVEL ###" >> $AUDIT_FILE
echo "Version Laravel:" >> $AUDIT_FILE
php artisan --version >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "Configuration .env (sans données sensibles):" >> $AUDIT_FILE
grep -E '^(APP_|DB_CONNECTION|DB_DATABASE|MAIL_|BROADCAST_|CACHE_|SESSION_)' .env | sed 's/=.*/=***/' >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 3. ROUTES
echo "### 3. ROUTES ###" >> $AUDIT_FILE
echo "Liste des routes:" >> $AUDIT_FILE
php artisan route:list --columns=method,uri,name,action >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 4. MIGRATIONS ET STRUCTURE DB
echo "### 4. MIGRATIONS ET BASE DE DONNÉES ###" >> $AUDIT_FILE
echo "Status des migrations:" >> $AUDIT_FILE
php artisan migrate:status >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "Structure de la table users:" >> $AUDIT_FILE
php artisan tinker --execute="Schema::getColumnListing('users')" >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 5. MODÈLES
echo "### 5. MODÈLES ###" >> $AUDIT_FILE
echo "Liste des modèles:" >> $AUDIT_FILE
find app/Models -name "*.php" -type f >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 6. CONTRÔLEURS
echo "### 6. CONTRÔLEURS ###" >> $AUDIT_FILE
echo "Structure des contrôleurs:" >> $AUDIT_FILE
find app/Http/Controllers -name "*.php" -type f | sort >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 7. VUES
echo "### 7. VUES ###" >> $AUDIT_FILE
echo "Structure des vues:" >> $AUDIT_FILE
find resources/views -name "*.blade.php" | sort >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "Layouts utilisés:" >> $AUDIT_FILE
grep -h "@extends" resources/views/**/*.blade.php 2>/dev/null | sort | uniq >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 8. ASSETS ET CSS
echo "### 8. ASSETS ET CSS ###" >> $AUDIT_FILE
echo "Fichiers CSS dans public:" >> $AUDIT_FILE
find public -name "*.css" | head -20 >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "package.json dépendances:" >> $AUDIT_FILE
if [ -f package.json ]; then
    grep -A 20 '"dependencies"' package.json >> $AUDIT_FILE 2>&1
fi
echo "" >> $AUDIT_FILE

# 9. MIDDLEWARE
echo "### 9. MIDDLEWARE ###" >> $AUDIT_FILE
echo "Liste des middleware:" >> $AUDIT_FILE
grep -A 50 "protected \$routeMiddleware" app/Http/Kernel.php 2>/dev/null >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 10. PROVIDERS
echo "### 10. PROVIDERS ###" >> $AUDIT_FILE
echo "Service Providers:" >> $AUDIT_FILE
ls -la app/Providers/ >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 11. PERMISSIONS (Spatie)
echo "### 11. PERMISSIONS ET RÔLES ###" >> $AUDIT_FILE
echo "Rôles disponibles:" >> $AUDIT_FILE
php artisan tinker --execute="\Spatie\Permission\Models\Role::pluck('name')" >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 12. FICHIERS DE CONFIGURATION
echo "### 12. FICHIERS DE CONFIGURATION ###" >> $AUDIT_FILE
echo "Fichiers dans config/:" >> $AUDIT_FILE
ls -la config/ >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 13. COMPOSER PACKAGES
echo "### 13. PACKAGES COMPOSER ###" >> $AUDIT_FILE
echo "Packages installés:" >> $AUDIT_FILE
composer show >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 14. ERREURS DANS LES LOGS
echo "### 14. DERNIÈRES ERREURS (logs) ###" >> $AUDIT_FILE
echo "Dernières 50 lignes du log:" >> $AUDIT_FILE
tail -50 storage/logs/laravel.log >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 15. ANALYSE DES PROBLÈMES POTENTIELS
echo "### 15. ANALYSE DES PROBLÈMES POTENTIELS ###" >> $AUDIT_FILE
echo "Fichiers PHP avec erreurs de syntaxe:" >> $AUDIT_FILE
find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \; 2>&1 | grep -v "No syntax errors" >> $AUDIT_FILE
echo "" >> $AUDIT_FILE

# 16. ANALYSE SPÉCIFIQUE AUTH
echo "### 16. ANALYSE SPÉCIFIQUE AUTHENTIFICATION ###" >> $AUDIT_FILE
echo "Contenu de auth.php:" >> $AUDIT_FILE
head -30 config/auth.php >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "LoginController methods:" >> $AUDIT_FILE
grep -E "public function|protected function|private function" app/Http/Controllers/Auth/LoginController.php 2>/dev/null >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 17. ANALYSE CSS/FRAMEWORKS
echo "### 17. ANALYSE CSS/FRAMEWORKS ###" >> $AUDIT_FILE
echo "Recherche Tailwind:" >> $AUDIT_FILE
grep -r "tailwind" resources/views/ 2>/dev/null | head -10 >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "Recherche Bootstrap:" >> $AUDIT_FILE
grep -r "bootstrap" resources/views/ 2>/dev/null | head -10 >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 18. USERS TABLE STRUCTURE
echo "### 18. STRUCTURE DÉTAILLÉE TABLE USERS ###" >> $AUDIT_FILE
php artisan tinker --execute="
    \$columns = DB::select('SHOW COLUMNS FROM users');
    foreach(\$columns as \$column) {
        echo \$column->Field . ' - ' . \$column->Type . ' - ' . \$column->Null . PHP_EOL;
    }
" >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# 19. FICHIERS IMPORTANTS
echo "### 19. CONTENU FICHIERS IMPORTANTS ###" >> $AUDIT_FILE
echo "=== User.php Model ===" >> $AUDIT_FILE
head -50 app/Models/User.php >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE
echo "=== LoginRequest.php ===" >> $AUDIT_FILE
cat app/Http/Requests/Auth/LoginRequest.php >> $AUDIT_FILE 2>&1
echo "" >> $AUDIT_FILE

# Finaliser
echo "### FIN DE L'AUDIT ###" >> $AUDIT_FILE
echo "Fichier généré: $AUDIT_FILE" >> $AUDIT_FILE

# Afficher le résultat
echo "✅ Audit terminé!"
echo "📄 Fichier créé: $AUDIT_FILE"
echo "📊 Taille: $(du -h $AUDIT_FILE | cut -f1)"
echo ""
echo "Pour envoyer le fichier à Claude, utilisez:"
echo "cat $AUDIT_FILE"
