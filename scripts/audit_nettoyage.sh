#!/bin/bash
# =================================================================
# SCRIPT D'AUDIT NETTOYAGE - STUDIOSUNISDB
# Détecte et supprime les fichiers inutilisés
# =================================================================

AUDIT_DIR="audit"
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
CLEANUP_LOG="$AUDIT_DIR/nettoyage_$TIMESTAMP.log"
BACKUP_DIR="$AUDIT_DIR/backup_avant_nettoyage_$TIMESTAMP"

# Créer les dossiers
mkdir -p "$AUDIT_DIR" "$BACKUP_DIR"

echo "🧹 AUDIT NETTOYAGE STUDIOSUNISDB - $(date)" | tee "$CLEANUP_LOG"
echo "=================================================" | tee -a "$CLEANUP_LOG"

# =================================================================
# FONCTION DE SAUVEGARDE
# =================================================================
backup_file() {
    local file="$1"
    if [[ -f "$file" ]]; then
        local backup_path="$BACKUP_DIR/$file"
        mkdir -p "$(dirname "$backup_path")"
        cp "$file" "$backup_path"
        echo "  📦 Sauvegardé: $file" | tee -a "$CLEANUP_LOG"
    fi
}

# =================================================================
# 1. FICHIERS TEMPORAIRES ET CACHE
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🗑️  NETTOYAGE FICHIERS TEMPORAIRES" | tee -a "$CLEANUP_LOG"
echo "=================================" | tee -a "$CLEANUP_LOG"

# Fichiers temporaires Laravel
TEMP_FILES=(
    "bootstrap/cache/*.php"
    "storage/framework/cache/data/*"
    "storage/framework/sessions/*"
    "storage/framework/views/*"
    "storage/logs/*.log"
    "public/hot"
    "public/build/manifest.json"
    ".phpunit.result.cache"
    "node_modules/.cache"
    ".vite"
    "npm-debug.log*"
    "yarn-debug.log*"
    "yarn-error.log*"
)

for pattern in "${TEMP_FILES[@]}"; do
    files=$(find . -path "./$pattern" 2>/dev/null)
    if [[ -n "$files" ]]; then
        echo "$files" | while read -r file; do
            if [[ -f "$file" ]]; then
                echo "  ❌ Supprimé: $file" | tee -a "$CLEANUP_LOG"
                rm -f "$file"
            fi
        done
    fi
done

# =================================================================
# 2. AUDIT DES VUES INUTILISÉES
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "👁️  AUDIT VUES BLADE" | tee -a "$CLEANUP_LOG"
echo "===================" | tee -a "$CLEANUP_LOG"

UNUSED_VIEWS=()

# Vues potentiellement inutilisées
SUSPECT_VIEWS=(
    "resources/views/test.blade.php"
    "resources/views/admin/dashboard-simple.blade.php"
    "resources/views/admin/themes/index.blade.php"
    "resources/views/emails/membres/custom.blade.php"
)

for view in "${SUSPECT_VIEWS[@]}"; do
    if [[ -f "$view" ]]; then
        # Chercher les références dans les contrôleurs et routes
        base_name=$(basename "$view" .blade.php)
        dir_name=$(dirname "$view" | sed 's|resources/views/||')
        view_name="$dir_name/$base_name"
        view_name=${view_name#./}
        
        # Rechercher les références
        refs=$(grep -r "$base_name\|$view_name" app/Http/Controllers/ routes/ --include="*.php" 2>/dev/null | wc -l)
        
        if [[ $refs -eq 0 ]]; then
            echo "  ⚠️  Vue potentiellement inutilisée: $view" | tee -a "$CLEANUP_LOG"
            UNUSED_VIEWS+=("$view")
        else
            echo "  ✅ Vue utilisée: $view ($refs références)" | tee -a "$CLEANUP_LOG"
        fi
    fi
done

# =================================================================
# 3. AUDIT DES CONTRÔLEURS INUTILISÉS
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🎛️  AUDIT CONTRÔLEURS" | tee -a "$CLEANUP_LOG"
echo "=====================" | tee -a "$CLEANUP_LOG"

# Contrôleurs potentiellement inutilisés
find app/Http/Controllers -name "*.php" -type f | while read -r controller; do
    controller_name=$(basename "$controller" .php)
    
    # Vérifier dans les routes
    route_refs=$(grep -r "$controller_name" routes/ --include="*.php" 2>/dev/null | wc -l)
    
    if [[ $route_refs -eq 0 ]]; then
        echo "  ⚠️  Contrôleur potentiellement inutilisé: $controller" | tee -a "$CLEANUP_LOG"
    else
        echo "  ✅ Contrôleur utilisé: $controller_name" | tee -a "$CLEANUP_LOG"
    fi
done

# =================================================================
# 4. AUDIT DES MIDDLEWARES INUTILISÉS
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🛡️  AUDIT MIDDLEWARES" | tee -a "$CLEANUP_LOG"
echo "=====================" | tee -a "$CLEANUP_LOG"

find app/Http/Middleware -name "*.php" -type f | while read -r middleware; do
    middleware_name=$(basename "$middleware" .php)
    
    # Vérifier dans Kernel.php et routes
    kernel_refs=$(grep -r "$middleware_name" app/Http/Kernel.php routes/ 2>/dev/null | wc -l)
    
    if [[ $kernel_refs -eq 0 ]]; then
        echo "  ⚠️  Middleware potentiellement inutilisé: $middleware" | tee -a "$CLEANUP_LOG"
    else
        echo "  ✅ Middleware utilisé: $middleware_name" | tee -a "$CLEANUP_LOG"
    fi
done

# =================================================================
# 5. AUDIT DES MIGRATIONS OBSOLÈTES
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🗄️  AUDIT MIGRATIONS" | tee -a "$CLEANUP_LOG"
echo "====================" | tee -a "$CLEANUP_LOG"

# Migrations potentiellement obsolètes
OBSOLETE_MIGRATIONS=(
    "*create_journees_portes_ouvertes_table.php"
    "*drop_journees_portes_ouvertes_table.php"
    "*create_admins_table.php"
    "*create_liens_personnalises_table.php"
    "*create_logs_admins_table.php"
    "*create_log_table.php"
)

for pattern in "${OBSOLETE_MIGRATIONS[@]}"; do
    files=$(find database/migrations -name "$pattern" 2>/dev/null)
    if [[ -n "$files" ]]; then
        echo "$files" | while read -r migration; do
            echo "  ⚠️  Migration potentiellement obsolète: $migration" | tee -a "$CLEANUP_LOG"
        done
    fi
done

# =================================================================
# 6. AUDIT DES ASSETS CSS/JS NON UTILISÉS
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🎨 AUDIT ASSETS CSS/JS" | tee -a "$CLEANUP_LOG"
echo "======================" | tee -a "$CLEANUP_LOG"

# CSS potentiellement inutilisés
CSS_FILES=(
    "resources/css/aurora-grey-unified.css"
    "public/css/old-styles.css"
    "resources/sass/app.scss"
)

for css in "${CSS_FILES[@]}"; do
    if [[ -f "$css" ]]; then
        echo "  ⚠️  CSS potentiellement inutilisé: $css" | tee -a "$CLEANUP_LOG"
    fi
done

# =================================================================
# 7. AUDIT DÉPENDANCES NPM INUTILISÉES
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "📦 AUDIT DÉPENDANCES NPM" | tee -a "$CLEANUP_LOG"
echo "========================" | tee -a "$CLEANUP_LOG"

if command -v npm >/dev/null 2>&1; then
    if [[ -f "package.json" ]]; then
        echo "  🔍 Vérification des dépendances NPM..." | tee -a "$CLEANUP_LOG"
        
        # Packages potentiellement inutilisés
        UNUSED_PACKAGES=(
            "@popperjs/core"
            "bootstrap"
            "sass"
            "resolve-url-loader"
            "sass-loader"
        )
        
        for package in "${UNUSED_PACKAGES[@]}"; do
            if npm list "$package" >/dev/null 2>&1; then
                # Vérifier s'il est utilisé dans le code
                usage=$(find resources/js resources/css -type f \( -name "*.js" -o -name "*.css" -o -name "*.vue" \) -exec grep -l "$package" {} \; 2>/dev/null | wc -l)
                if [[ $usage -eq 0 ]]; then
                    echo "  ⚠️  Package NPM potentiellement inutilisé: $package" | tee -a "$CLEANUP_LOG"
                fi
            fi
        done
    fi
fi

# =================================================================
# 8. SUPPRESSION SÉCURISÉE DES FICHIERS IDENTIFIÉS
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🗑️  SUPPRESSION SÉCURISÉE" | tee -a "$CLEANUP_LOG"
echo "=========================" | tee -a "$CLEANUP_LOG"

# Fichiers sûrs à supprimer
SAFE_TO_DELETE=(
    "resources/views/test.blade.php"
    "resources/css/aurora-grey-unified.css"
    "public/css/old-styles.css"
    "npm-debug.log"
    "yarn-debug.log"
    "yarn-error.log"
    ".DS_Store"
    "Thumbs.db"
)

for file in "${SAFE_TO_DELETE[@]}"; do
    if [[ -f "$file" ]]; then
        backup_file "$file"
        rm -f "$file"
        echo "  ❌ Supprimé: $file" | tee -a "$CLEANUP_LOG"
    fi
done

# Nettoyer les dossiers vides
find . -type d -empty -not -path "./.git/*" -not -path "./node_modules/*" -delete 2>/dev/null

# =================================================================
# 9. OPTIMISATION AUTOLOAD COMPOSER
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "🔧 OPTIMISATION COMPOSER" | tee -a "$CLEANUP_LOG"
echo "========================" | tee -a "$CLEANUP_LOG"

if command -v composer >/dev/null 2>&1; then
    echo "  🔄 Dump autoload optimisé..." | tee -a "$CLEANUP_LOG"
    composer dump-autoload -o --no-dev 2>/dev/null || composer dump-autoload -o
    echo "  ✅ Autoload optimisé" | tee -a "$CLEANUP_LOG"
fi

# =================================================================
# 10. RAPPORT FINAL
# =================================================================
echo "" | tee -a "$CLEANUP_LOG"
echo "📊 RAPPORT FINAL" | tee -a "$CLEANUP_LOG"
echo "================" | tee -a "$CLEANUP_LOG"

# Calculer l'espace libéré
if [[ -d "$BACKUP_DIR" ]]; then
    BACKUP_SIZE=$(du -sh "$BACKUP_DIR" 2>/dev/null | cut -f1)
    echo "  💾 Fichiers sauvegardés: $BACKUP_SIZE dans $BACKUP_DIR" | tee -a "$CLEANUP_LOG"
fi

# Taille actuelle du projet
PROJECT_SIZE=$(du -sh . 2>/dev/null | cut -f1)
echo "  📏 Taille projet après nettoyage: $PROJECT_SIZE" | tee -a "$CLEANUP_LOG"

# Compter les fichiers par type
echo "" | tee -a "$CLEANUP_LOG"
echo "📈 STATISTIQUES PROJET:" | tee -a "$CLEANUP_LOG"
echo "  Controllers: $(find app/Http/Controllers -name "*.php" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  Models: $(find app/Models -name "*.php" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  Middlewares: $(find app/Http/Middleware -name "*.php" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  Views: $(find resources/views -name "*.blade.php" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  Migrations: $(find database/migrations -name "*.php" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  CSS Files: $(find resources/css -name "*.css" | wc -l)" | tee -a "$CLEANUP_LOG"
echo "  JS Files: $(find resources/js -name "*.js" | wc -l)" | tee -a "$CLEANUP_LOG"

echo "" | tee -a "$CLEANUP_LOG"
echo "✅ NETTOYAGE TERMINÉ !" | tee -a "$CLEANUP_LOG"
echo "📄 Log complet: $CLEANUP_LOG" | tee -a "$CLEANUP_LOG"
echo "📦 Backup: $BACKUP_DIR" | tee -a "$CLEANUP_LOG"
echo "$(date)" | tee -a "$CLEANUP_LOG"

# =================================================================
# 11. RECOMMANDATIONS
# =================================================================
cat >> "$CLEANUP_LOG" << REC_EOF

📝 RECOMMANDATIONS POST-NETTOYAGE:

🔧 COMMANDES À EXÉCUTER:
php artisan config:clear
php artisan route:clear  
php artisan view:clear
npm run build

🧪 TESTS À EFFECTUER:
- Vérifier que l'application fonctionne
- Tester toutes les pages principales
- Vérifier les assets CSS/JS
- Tester l'authentification

🚀 SI TOUT FONCTIONNE:
git add .
git commit -m "🧹 Nettoyage projet - Suppression fichiers inutilisés"
git push origin main

⚠️  EN CAS DE PROBLÈME:
Les fichiers sont sauvegardés dans: $BACKUP_DIR
Pour restaurer: cp -r $BACKUP_DIR/* ./

REC_EOF

echo ""
echo "🎉 AUDIT NETTOYAGE TERMINÉ !"
echo "📄 Rapport complet: $CLEANUP_LOG"
echo "📦 Sauvegarde: $BACKUP_DIR"
echo ""
echo "🧪 TESTEZ L'APPLICATION AVANT DE COMMITER !"

