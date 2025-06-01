#!/bin/bash

echo "=== Maintenance StudiosUnisDB ==="
date

# Créer les dossiers nécessaires
mkdir -p backups
mkdir -p storage/logs

# Nettoyer les logs anciens
find storage/logs -name "*.log" -mtime +30 -delete 2>/dev/null
echo "✓ Logs nettoyés"

# Nettoyer les sessions expirées (Laravel utilise model:prune)
php artisan model:prune --model="Illuminate\Session\SessionManager" 2>/dev/null || echo "  Sessions: pas de modèle prunable configuré"

# Alternative pour nettoyer les sessions dans la DB
mysql -u root -p${DB_PASSWORD:-} studiosdb -e "DELETE FROM sessions WHERE last_activity < UNIX_TIMESTAMP(NOW() - INTERVAL 24 HOUR);" 2>/dev/null && echo "✓ Sessions nettoyées"

# Nettoyer les activity logs anciens
php artisan activitylog:clean
echo "✓ Activity logs nettoyés"

# Nettoyer les jobs échoués anciens
php artisan queue:prune-failed --hours=168 2>/dev/null || echo "  Jobs: pas de jobs échoués"

# Optimiser les caches
php artisan optimize:clear
php artisan optimize
echo "✓ Caches optimisés"

# Backup de la base de données
if command -v mysqldump &> /dev/null; then
    echo -n "Mot de passe MySQL: "
    read -s DB_PASS
    echo
    mysqldump -u root -p$DB_PASS studiosdb > backups/studiosdb_$(date +%Y%m%d_%H%M%S).sql 2>/dev/null
    if [ $? -eq 0 ]; then
        echo "✓ Backup créé"
        # Nettoyer les backups de plus de 30 jours
        find backups -name "*.sql" -mtime +30 -delete 2>/dev/null
        echo "✓ Anciens backups nettoyés"
    else
        echo "✗ Erreur lors du backup"
    fi
fi

# Statistiques
echo ""
echo "=== Statistiques ==="
echo "Espace utilisé par les logs: $(du -sh storage/logs 2>/dev/null | cut -f1)"
echo "Nombre de sessions actives: $(mysql -u root -p$DB_PASS studiosdb -e "SELECT COUNT(*) FROM sessions;" -s 2>/dev/null || echo "N/A")"
echo "Nombre d'activity logs: $(mysql -u root -p$DB_PASS studiosdb -e "SELECT COUNT(*) FROM activity_log;" -s 2>/dev/null || echo "N/A")"
echo "Taille des backups: $(du -sh backups 2>/dev/null | cut -f1 || echo "N/A")"

echo ""
echo "Maintenance terminée !"
