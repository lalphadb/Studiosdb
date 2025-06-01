#!/bin/bash

# Configuration
BACKUP_RETENTION_DAYS=30
LOG_RETENTION_DAYS=30
SESSION_RETENTION_HOURS=24

# Couleurs pour output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Maintenance StudiosUnisDB ===${NC}"
date

# Fonction pour afficher le statut
show_status() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓ $2${NC}"
    else
        echo -e "${RED}✗ $2${NC}"
    fi
}

# Créer les dossiers
mkdir -p backups storage/logs

# 1. Nettoyer les logs
echo -e "\n${YELLOW}1. Nettoyage des logs...${NC}"
find storage/logs -name "*.log" -mtime +$LOG_RETENTION_DAYS -delete 2>/dev/null
show_status $? "Logs de plus de $LOG_RETENTION_DAYS jours supprimés"

# 2. Nettoyer les sessions
echo -e "\n${YELLOW}2. Nettoyage des sessions...${NC}"
if [ -z "$DB_PASSWORD" ]; then
    echo -n "Mot de passe MySQL: "
    read -s DB_PASSWORD
    echo
fi

mysql -u root -p$DB_PASSWORD studiosdb -e "
DELETE FROM sessions 
WHERE last_activity < UNIX_TIMESTAMP(NOW() - INTERVAL $SESSION_RETENTION_HOURS HOUR);" 2>/dev/null
show_status $? "Sessions expirées supprimées"

# 3. Nettoyer activity logs
echo -e "\n${YELLOW}3. Nettoyage des activity logs...${NC}"
php artisan activitylog:clean
show_status $? "Activity logs nettoyés"

# 4. Optimiser les tables
echo -e "\n${YELLOW}4. Optimisation des tables...${NC}"
mysql -u root -p$DB_PASSWORD studiosdb -e "
SELECT CONCAT('OPTIMIZE TABLE ', table_name, ';') 
FROM information_schema.tables 
WHERE table_schema = 'studiosdb';" -s | mysql -u root -p$DB_PASSWORD studiosdb 2>/dev/null
show_status $? "Tables optimisées"

# 5. Backup
echo -e "\n${YELLOW}5. Backup de la base de données...${NC}"
BACKUP_FILE="backups/studiosdb_$(date +%Y%m%d_%H%M%S).sql"
mysqldump -u root -p$DB_PASSWORD studiosdb > $BACKUP_FILE 2>/dev/null
if [ $? -eq 0 ]; then
    SIZE=$(du -h $BACKUP_FILE | cut -f1)
    show_status 0 "Backup créé ($SIZE)"
    
    # Compresser le backup
    gzip $BACKUP_FILE
    show_status $? "Backup compressé"
    
    # Nettoyer anciens backups
    find backups -name "*.sql.gz" -mtime +$BACKUP_RETENTION_DAYS -delete
    show_status $? "Anciens backups nettoyés"
else
    show_status 1 "Erreur lors du backup"
fi

# 6. Optimiser Laravel
echo -e "\n${YELLOW}6. Optimisation Laravel...${NC}"
php artisan optimize:clear > /dev/null 2>&1
php artisan optimize > /dev/null 2>&1
show_status $? "Caches Laravel optimisés"

# 7. Statistiques
echo -e "\n${GREEN}=== Statistiques ===${NC}"
echo "Espace logs: $(du -sh storage/logs 2>/dev/null | cut -f1)"
echo "Sessions actives: $(mysql -u root -p$DB_PASSWORD studiosdb -e "SELECT COUNT(*) FROM sessions;" -s 2>/dev/null)"
echo "Activity logs: $(mysql -u root -p$DB_PASSWORD studiosdb -e "SELECT COUNT(*) FROM activity_log;" -s 2>/dev/null)"
echo "Membres actifs: $(mysql -u root -p$DB_PASSWORD studiosdb -e "SELECT COUNT(*) FROM membres WHERE approuve = 1;" -s 2>/dev/null)"
echo "Backups: $(ls -1 backups/*.sql.gz 2>/dev/null | wc -l) fichiers ($(du -sh backups 2>/dev/null | cut -f1))"

echo -e "\n${GREEN}Maintenance terminée !${NC}"
