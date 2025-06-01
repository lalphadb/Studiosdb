-- Sauvegarder les données importantes avant suppression
CREATE TABLE IF NOT EXISTS _backup_tables_metadata (
    table_name VARCHAR(255),
    row_count INT,
    backed_up_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Enregistrer les tables à supprimer
INSERT INTO _backup_tables_metadata (table_name, row_count)
SELECT TABLE_NAME, TABLE_ROWS 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'studiosdb' 
AND TABLE_NAME IN ('log', 'logs_admins', 'admins', 'liens_personnalises', 'historique');

-- Supprimer les tables inutilisées
DROP TABLE IF EXISTS log;
DROP TABLE IF EXISTS logs_admins;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS liens_personnalises;
DROP TABLE IF EXISTS historique;

-- Analyser les tables de ceintures pour consolidation
SELECT 'ceintures', COUNT(*) FROM ceintures
UNION SELECT 'ceintures_membres', COUNT(*) FROM ceintures_membres
UNION SELECT 'ceintures_obtenues', COUNT(*) FROM ceintures_obtenues
UNION SELECT 'membre_ceinture', COUNT(*) FROM membre_ceinture;
