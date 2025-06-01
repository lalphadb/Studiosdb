#!/bin/bash
# audit.sh

echo "=== AUDIT STUDIOSUNISDB ==="
date

# Créer le dossier de rapport
mkdir -p audit_reports
REPORT="audit_reports/audit_$(date +%Y%m%d_%H%M%S).md"

{
    echo "# Rapport d'Audit STUDIOSUNISDB"
    echo "Date: $(date)"
    echo ""
    
    echo "## 1. Configuration"
    echo "### PHP"
    php -v | head -1
    
    echo "### Laravel"
    php artisan --version
    
    echo "### Composer"
    composer --version
    
    echo ""
    echo "## 2. Base de données"
    echo "### Tables avec données"
    mysql -u root -p$DB_PASSWORD studiosdb -e "
    SELECT TABLE_NAME, TABLE_ROWS 
    FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = 'studiosdb' 
    AND TABLE_ROWS > 0
    ORDER BY TABLE_ROWS DESC;" 2>/dev/null
    
    echo ""
    echo "## 3. Sécurité"
    echo "### Packages vulnérables"
    composer audit 2>&1
    
    echo ""
    echo "## 4. Qualité du code"
    echo "### PHPStan"
    ./vendor/bin/phpstan analyse --error-format=table 2>&1 || echo "PHPStan non installé"
    
    echo ""
    echo "## 5. Routes exposées"
    php artisan route:list --columns=method,uri,name,middleware | grep -v "auth" | head -20
    
} > "$REPORT"

echo "Rapport généré: $REPORT"
