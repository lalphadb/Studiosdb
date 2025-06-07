-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: studiosdb
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `activity_log_event_index` (`event`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,'default','created','App\\Models\\User','created',1,NULL,NULL,'{\"attributes\": {\"name\": \"Super Admin\", \"role\": \"superadmin\", \"email\": \"lalpha@4lb.ca\", \"active\": true, \"username\": \"superadmin\"}}',NULL,'2025-06-06 12:38:49','2025-06-06 12:38:49'),(2,'default','created','App\\Models\\User','created',2,NULL,NULL,'{\"attributes\": {\"name\": \"Louis Gestion\", \"role\": \"admin\", \"email\": \"louis@4lb.ca\", \"active\": true}}',NULL,'2025-06-07 12:47:11','2025-06-07 12:47:11');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_logs`
--

DROP TABLE IF EXISTS `auth_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '1',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_data` json DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_logs_email_created_at_index` (`email`,`created_at`),
  KEY `auth_logs_action_index` (`action`),
  KEY `auth_logs_user_id_action_index` (`user_id`,`action`),
  KEY `auth_logs_created_at_index` (`created_at`),
  KEY `auth_logs_ip_address_index` (`ip_address`),
  CONSTRAINT `auth_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_logs`
--

LOCK TABLES `auth_logs` WRITE;
/*!40000 ALTER TABLE `auth_logs` DISABLE KEYS */;
INSERT INTO `auth_logs` VALUES (1,NULL,NULL,'login_failed',1,NULL,'10.10.10.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0',NULL,NULL,'\"{\\\"email\\\":\\\"admin@test.com\\\"}\"',NULL,'2025-06-07 18:35:48','2025-06-07 18:35:48'),(2,NULL,NULL,'login_failed',1,NULL,'10.10.10.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0',NULL,NULL,'\"{\\\"email\\\":\\\"admin@studiosdb.com\\\"}\"',NULL,'2025-06-07 18:42:59','2025-06-07 18:42:59'),(3,NULL,NULL,'login_failed',1,NULL,'127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0',NULL,NULL,'\"{\\\"email\\\":\\\"lalpha@4lb.ca\\\"}\"',NULL,'2025-06-07 18:46:10','2025-06-07 18:46:10'),(4,NULL,NULL,'login_failed',1,NULL,'127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0',NULL,NULL,'\"{\\\"email\\\":\\\"louis@4lb.ca\\\"}\"',NULL,'2025-06-07 18:46:38','2025-06-07 18:46:38');
/*!40000 ALTER TABLE `auth_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  `conditions` json NOT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#00d4ff',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badges`
--

LOCK TABLES `badges` WRITE;
/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceintures`
--

DROP TABLE IF EXISTS `ceintures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ceintures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` int DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceintures`
--

LOCK TABLES `ceintures` WRITE;
/*!40000 ALTER TABLE `ceintures` DISABLE KEYS */;
INSERT INTO `ceintures` VALUES (1,'Blanche',1,'#FFFFFF',1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(2,'Jaune',2,'#FFD700',2,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(3,'Orange',3,'#FFA500',3,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(4,'Violet',4,'#9400D3',4,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(5,'Bleue',5,'#0000FF',5,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(6,'Bleue I',6,'#0066FF',6,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(7,'Verte',7,'#00FF00',7,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(8,'Verte I',8,'#00CC00',8,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(9,'Brune I',9,'#8B4513',9,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(10,'Brune II',10,'#A0522D',10,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(11,'Brune III',11,'#654321',11,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(12,'Noire (1er Dan) — Shodan',12,'#000000',12,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(13,'Noire (2e Dan) — Nidan',13,'#000000',13,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(14,'Noire (3e Dan) — Sandan',14,'#000000',14,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(15,'Noire (4e Dan) — Yondan',15,'#000000',15,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(16,'Noire (5e Dan) — Godan',16,'#000000',16,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(17,'Noire (6e Dan) — Rokudan',17,'#000000',17,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(18,'Noire (7e Dan) — Nanadan',18,'#000000',18,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(19,'Noire (8e Dan) — Hachidan',19,'#000000',19,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(20,'Noire (9e Dan) — Kudan',20,'#000000',20,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(21,'Noire (10e Dan) — Jūdan',21,'#000000',21,'2025-06-06 12:38:05','2025-06-06 12:38:05');
/*!40000 ALTER TABLE `ceintures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceintures_membres`
--

DROP TABLE IF EXISTS `ceintures_membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ceintures_membres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `ceinture_id` bigint unsigned NOT NULL,
  `date_obtention` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ceintures_membres_membre_id_foreign` (`membre_id`),
  KEY `ceintures_membres_ceinture_id_foreign` (`ceinture_id`),
  CONSTRAINT `ceintures_membres_ceinture_id_foreign` FOREIGN KEY (`ceinture_id`) REFERENCES `ceintures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ceintures_membres_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceintures_membres`
--

LOCK TABLES `ceintures_membres` WRITE;
/*!40000 ALTER TABLE `ceintures_membres` DISABLE KEYS */;
/*!40000 ALTER TABLE `ceintures_membres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceintures_obtenues`
--

DROP TABLE IF EXISTS `ceintures_obtenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ceintures_obtenues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `ceinture_id` bigint unsigned NOT NULL,
  `date_obtention` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ceintures_obtenues_membre_id_foreign` (`membre_id`),
  KEY `ceintures_obtenues_ceinture_id_foreign` (`ceinture_id`),
  CONSTRAINT `ceintures_obtenues_ceinture_id_foreign` FOREIGN KEY (`ceinture_id`) REFERENCES `ceintures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ceintures_obtenues_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceintures_obtenues`
--

LOCK TABLES `ceintures_obtenues` WRITE;
/*!40000 ALTER TABLE `ceintures_obtenues` DISABLE KEYS */;
/*!40000 ALTER TABLE `ceintures_obtenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consent_types`
--

DROP TABLE IF EXISTS `consent_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consent_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `consent_types_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consent_types`
--

LOCK TABLES `consent_types` WRITE;
/*!40000 ALTER TABLE `consent_types` DISABLE KEYS */;
INSERT INTO `consent_types` VALUES (1,'terms_conditions','Conditions d\'utilisation','J\'accepte les conditions d\'utilisation du service',1,1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(2,'privacy_policy','Politique de confidentialité','J\'ai lu et j\'accepte la politique de confidentialité',1,1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(3,'marketing_emails','Communications marketing','J\'accepte de recevoir des communications marketing par courriel',0,1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(4,'photo_usage','Utilisation de photos','J\'autorise l\'utilisation de mes photos à des fins promotionnelles',0,1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(5,'emergency_contact','Contact d\'urgence','J\'autorise le partage de mes informations avec les contacts d\'urgence',0,1,'2025-06-06 12:38:05','2025-06-06 12:38:05'),(6,'cookies_analytics','Cookies analytiques','J\'accepte l\'utilisation de cookies à des fins analytiques',0,1,'2025-06-06 12:38:05','2025-06-06 12:38:05');
/*!40000 ALTER TABLE `consent_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type_cours` enum('regulier','parent_enfant','ceinture_avancee','competition','prive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regulier',
  `jours` json DEFAULT NULL,
  `ecole_id` bigint unsigned NOT NULL,
  `professeur_id` bigint unsigned DEFAULT NULL,
  `capacite_max` int NOT NULL DEFAULT '20',
  `duree_minutes` int NOT NULL DEFAULT '60',
  `niveau` enum('debutant','intermediaire','avance','tous') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tous',
  `type` enum('enfant','adulte','mixte') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mixte',
  `age_min` int DEFAULT NULL,
  `age_max` int DEFAULT NULL,
  `prerequis` text COLLATE utf8mb4_unicode_ci,
  `tarification_info` text COLLATE utf8mb4_unicode_ci,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `session_id` bigint unsigned DEFAULT NULL,
  `instructeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif` decimal(8,2) DEFAULT NULL,
  `duree` int NOT NULL DEFAULT '60',
  `statut` enum('actif','inactif','complet','annule') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `ceinture_requise_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cours_ecole_id_actif_index` (`ecole_id`,`actif`),
  KEY `cours_professeur_id_index` (`professeur_id`),
  KEY `cours_ceinture_requise_id_foreign` (`ceinture_requise_id`),
  KEY `cours_ecole_id_index` (`ecole_id`),
  KEY `cours_session_id_index` (`session_id`),
  KEY `cours_actif_index` (`actif`),
  CONSTRAINT `cours_ceinture_requise_id_foreign` FOREIGN KEY (`ceinture_requise_id`) REFERENCES `ceintures` (`id`),
  CONSTRAINT `cours_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cours_professeur_id_foreign` FOREIGN KEY (`professeur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cours_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `cours_sessions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours`
--

LOCK TABLES `cours` WRITE;
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours_horaires`
--

DROP TABLE IF EXISTS `cours_horaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours_horaires` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cours_id` bigint unsigned NOT NULL,
  `jour` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `salle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cours_horaire` (`cours_id`,`jour`,`heure_debut`,`heure_fin`),
  KEY `cours_horaires_cours_id_jour_index` (`cours_id`,`jour`),
  KEY `cours_horaires_jour_heure_debut_index` (`jour`,`heure_debut`),
  CONSTRAINT `cours_horaires_cours_id_foreign` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_horaires`
--

LOCK TABLES `cours_horaires` WRITE;
/*!40000 ALTER TABLE `cours_horaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours_horaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours_schedules`
--

DROP TABLE IF EXISTS `cours_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cours_id` bigint unsigned NOT NULL,
  `jour_semaine` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `capacite_max` int NOT NULL DEFAULT '20',
  `salle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cours_schedules_cours_id_jour_semaine_index` (`cours_id`,`jour_semaine`),
  CONSTRAINT `cours_schedules_cours_id_foreign` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_schedules`
--

LOCK TABLES `cours_schedules` WRITE;
/*!40000 ALTER TABLE `cours_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours_sessions`
--

DROP TABLE IF EXISTS `cours_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ecole_id` bigint unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `mois` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inscriptions_actives` tinyint(1) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `date_limite_inscription` date DEFAULT NULL,
  `couleur` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cours_sessions_ecole_id_foreign` (`ecole_id`),
  CONSTRAINT `cours_sessions_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_sessions`
--

LOCK TABLES `cours_sessions` WRITE;
/*!40000 ALTER TABLE `cours_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demandes_inscriptions`
--

DROP TABLE IF EXISTS `demandes_inscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demandes_inscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandes_inscriptions`
--

LOCK TABLES `demandes_inscriptions` WRITE;
/*!40000 ALTER TABLE `demandes_inscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `demandes_inscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ecoles`
--

DROP TABLE IF EXISTS `ecoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ecoles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Québec',
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ecoles`
--

LOCK TABLES `ecoles` WRITE;
/*!40000 ALTER TABLE `ecoles` DISABLE KEYS */;
INSERT INTO `ecoles` VALUES (1,'Studios Unis Ancienne-Lorette','7050 boul. Hamel Ouest, suite 80','Ancienne-Lorette','Québec','G2G 1B5',NULL,'ancienne-lorette@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(2,'Studios Unis Beauce','17118 boul. Lacroix, Suite 2','St-Georges-de-Beauce','Québec','G5Y 8G9',NULL,'beauce@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(3,'Studios Unis Beauport','2204 boul. Louis-XIV','Beauport','Québec','G1C 1A2','(418) 667-7541','beauport@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(4,'Studios Unis Charlesbourg','13061 boul. Henri-Bourassa','Charlesbourg','Québec','G1G 3Y6','(418) 622-0822','charlesbourg@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(5,'Studios Unis Chicoutimi','605 rue St-Paul','Chicoutimi','Québec','G7J 3Z4','(418) 376-6357','chicoutimi@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(6,'Studios Unis Côte-de-Beaupré','6218 boul. Sainte-Anne, suite 102','L\'Ange-Gardien','Québec','G0A 2K0',NULL,'cote-de-beaupre@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(7,'Studios Unis Dolbeau-Mistassini','1350 boul. Wallberg','Dolbeau-Mistassini','Québec','G8L 1H1','(418) 618-0829','dolbeau@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(8,'Studios Unis Donnacona','120 Armand Bombardier, local 260','Donnacona','Québec','G3M 1V3',NULL,'donnacona@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(9,'Studios Unis Duberger','2300 Père-Lelièvre','Québec','Québec','G1P 2X5','(418) 683-8499','duberger@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(10,'Studios Unis Lac St-Charles','876 rue Jacques Bédard','Lac St-Charles','Québec','G2N 1E3',NULL,'lac-st-charles@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(11,'Studios Unis Laval-Ouest','4610 boul. Arthur-Sauvé','Laval','Québec','H7R 3X1',NULL,'laval-ouest@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(12,'Studios Unis Lévis','40 route du Président-Kennedy #102','Lévis','Québec','G6V 6C4',NULL,'levis@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(13,'Studios Unis Montmagny','111 7e Rue','Montmagny','Québec','G5V 3H2',NULL,'montmagny@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(14,'Studios Unis St-Étienne-de-Lauzon','2760 route Lagueux','Saint-Étienne-de-Lauzon','Québec','G6J 1A2',NULL,'st-etienne@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(15,'Studios Unis St-Jean-Chrysostome','732 avenue Taniata','Saint-Jean-Chrysostome','Québec','G6Z 2C5',NULL,'st-jean-chrysostome@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(16,'Studios Unis Québec',NULL,'Québec','Québec',NULL,NULL,'quebec@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(17,'Studios Unis St-Émile',NULL,'St-Émile','Québec',NULL,NULL,'st-emile@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(18,'Studios Unis St-Jérôme',NULL,'St-Jérôme','Québec',NULL,NULL,'st-jerome@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(19,'Studios Unis St-Nicolas',NULL,'St-Nicolas','Québec',NULL,NULL,'st-nicolas@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(20,'Studios Unis St-Urbain',NULL,'St-Urbain','Québec',NULL,NULL,'st-urbain@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(21,'Studios Unis Ste-Foy',NULL,'Ste-Foy','Québec',NULL,NULL,'ste-foy@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21'),(22,'Studios Unis Val-Bélair',NULL,'Val-Bélair','Québec',NULL,NULL,'val-belair@studiosunis.com','active','2025-06-06 12:49:21','2025-06-06 12:49:21');
/*!40000 ALTER TABLE `ecoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historique`
--

DROP TABLE IF EXISTS `historique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historique` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `historique_admin_id_foreign` (`admin_id`),
  CONSTRAINT `historique_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historique`
--

LOCK TABLES `historique` WRITE;
/*!40000 ALTER TABLE `historique` DISABLE KEYS */;
/*!40000 ALTER TABLE `historique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscriptions_cours`
--

DROP TABLE IF EXISTS `inscriptions_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscriptions_cours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `cours_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inscriptions_cours_membre_id_foreign` (`membre_id`),
  KEY `inscriptions_cours_cours_id_foreign` (`cours_id`),
  CONSTRAINT `inscriptions_cours_cours_id_foreign` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inscriptions_cours_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscriptions_cours`
--

LOCK TABLES `inscriptions_cours` WRITE;
/*!40000 ALTER TABLE `inscriptions_cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscriptions_cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journees_portes_ouvertes`
--

DROP TABLE IF EXISTS `journees_portes_ouvertes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journees_portes_ouvertes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journees_portes_ouvertes`
--

LOCK TABLES `journees_portes_ouvertes` WRITE;
/*!40000 ALTER TABLE `journees_portes_ouvertes` DISABLE KEYS */;
/*!40000 ALTER TABLE `journees_portes_ouvertes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liens_personnalises`
--

DROP TABLE IF EXISTS `liens_personnalises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `liens_personnalises` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `liens_personnalises_lien_unique` (`lien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liens_personnalises`
--

LOCK TABLES `liens_personnalises` WRITE;
/*!40000 ALTER TABLE `liens_personnalises` DISABLE KEYS */;
/*!40000 ALTER TABLE `liens_personnalises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `niveau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs_admins`
--

DROP TABLE IF EXISTS `logs_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs_admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_admins_admin_id_foreign` (`admin_id`),
  CONSTRAINT `logs_admins_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_admins`
--

LOCK TABLES `logs_admins` WRITE;
/*!40000 ALTER TABLE `logs_admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membre_badges`
--

DROP TABLE IF EXISTS `membre_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membre_badges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `badge_id` bigint unsigned NOT NULL,
  `obtenu_le` timestamp NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membre_badges_membre_id_badge_id_unique` (`membre_id`,`badge_id`),
  KEY `membre_badges_badge_id_foreign` (`badge_id`),
  CONSTRAINT `membre_badges_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `membre_badges_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre_badges`
--

LOCK TABLES `membre_badges` WRITE;
/*!40000 ALTER TABLE `membre_badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `membre_badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membre_ceinture`
--

DROP TABLE IF EXISTS `membre_ceinture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membre_ceinture` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `ceinture_id` bigint unsigned NOT NULL,
  `date_obtention` date NOT NULL,
  `grade_par` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membre_ceinture_membre_id_ceinture_id_unique` (`membre_id`,`ceinture_id`),
  KEY `membre_ceinture_ceinture_id_foreign` (`ceinture_id`),
  KEY `membre_ceinture_membre_id_date_obtention_index` (`membre_id`,`date_obtention`),
  CONSTRAINT `membre_ceinture_ceinture_id_foreign` FOREIGN KEY (`ceinture_id`) REFERENCES `ceintures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `membre_ceinture_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre_ceinture`
--

LOCK TABLES `membre_ceinture` WRITE;
/*!40000 ALTER TABLE `membre_ceinture` DISABLE KEYS */;
/*!40000 ALTER TABLE `membre_ceinture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membre_seminaire`
--

DROP TABLE IF EXISTS `membre_seminaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membre_seminaire` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membre_id` bigint unsigned NOT NULL,
  `seminaire_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membre_seminaire_membre_id_foreign` (`membre_id`),
  KEY `membre_seminaire_seminaire_id_foreign` (`seminaire_id`),
  CONSTRAINT `membre_seminaire_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `membre_seminaire_seminaire_id_foreign` FOREIGN KEY (`seminaire_id`) REFERENCES `seminaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre_seminaire`
--

LOCK TABLES `membre_seminaire` WRITE;
/*!40000 ALTER TABLE `membre_seminaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `membre_seminaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ecole_id` bigint unsigned DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` enum('H','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approuve` tinyint(1) NOT NULL DEFAULT '0',
  `niveau_ceinture` enum('blanche','jaune','orange','verte','bleue','marron','noire') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blanche',
  `date_derniere_ceinture` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membres_ecole_id_index` (`ecole_id`),
  KEY `membres_approuve_index` (`approuve`),
  CONSTRAINT `membres_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membres`
--

LOCK TABLES `membres` WRITE;
/*!40000 ALTER TABLE `membres` DISABLE KEYS */;
/*!40000 ALTER TABLE `membres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_01_000001_create_consent_tables',1),(5,'2025_05_10_000001_create_permission_tables',1),(6,'2025_05_10_000002_create_ecoles_table',1),(7,'2025_05_10_000003_create_sessions_table',1),(8,'2025_05_10_000004_create_ceintures_table',1),(9,'2025_05_10_000005_create_seminaires_table',1),(10,'2025_05_11_000001_create_cours_table',1),(11,'2025_05_11_000002_create_membres_table',1),(12,'2025_05_11_000003_create_cours_sessions_table',1),(13,'2025_05_11_000004_create_cours_horaires_table',1),(14,'2025_05_11_153400_create_portes_ouvertes_table',1),(15,'2025_05_11_191925_create_admins_table',1),(16,'2025_05_11_192058_create_ceintures_membres_table',1),(17,'2025_05_11_192124_create_ceintures_obtenues_table',1),(18,'2025_05_11_192220_create_demandes_inscriptions_table',1),(19,'2025_05_11_192315_create_historique_table',1),(20,'2025_05_11_192416_create_journees_portes_ouvertes_table',1),(21,'2025_05_11_192453_create_liens_personnalises_table',1),(22,'2025_05_11_192517_create_log_table',1),(23,'2025_05_11_192536_create_logs_admins_table',1),(24,'2025_05_12_000001_create_presences_table',1),(25,'2025_05_12_000002_create_inscriptions_cours_table',1),(26,'2025_05_12_000003_create_membre_seminaire_table',1),(27,'2025_05_12_000004_create_membre_ceinture_pivot_table',1),(28,'2025_05_12_185420_alter_membres_id_to_bigint',1),(29,'2025_05_12_185646_modify_membres_id_to_bigint',1),(30,'2025_05_14_195631_add_present_to_presences_table',1),(31,'2025_05_14_201504_update_presences_table',1),(32,'2025_05_14_202725_drop_journees_portes_ouvertes_table',1),(33,'2025_05_14_202837_create_journees_portes_ouvertes_table',1),(34,'2025_05_15_000001_add_profil_fields_to_users_table',1),(35,'2025_05_15_145918_update_presences_table_add_columns',1),(36,'2025_05_17_201848_add_session_id_to_cours_table',1),(37,'2025_05_18_222059_add_ordre_to_ceintures_table',1),(38,'2025_05_18_224136_add_couleur_to_ceintures_table',1),(39,'2025_05_18_224946_modify_couleur_nullable_on_ceintures',1),(40,'2025_05_20_000002_update_cours_table',1),(41,'2025_05_21_151026_add_missing_fields_to_ecoles_table',1),(42,'2025_05_22_000024_optimize_presences_table',1),(43,'2025_05_22_000927_add_indexes_and_comment_to_presences_table',1),(44,'2025_05_22_180029_add_username_to_users_table',1),(45,'2025_05_22_182644_add_active_column_to_users_table',1),(46,'2025_05_22_195345_add_missing_columns_to_cours_sessions_table',1),(47,'2025_05_28_212214_add_security_fields_to_users_table',1),(48,'2025_05_29_150157_add_theme_preference_to_users_table',1),(49,'2025_05_30_162759_create_activity_log_table',1),(50,'2025_05_30_162800_add_event_column_to_activity_log_table',1),(51,'2025_05_30_162801_add_batch_uuid_column_to_activity_log_table',1),(52,'2025_05_30_create_cours_schedules_table',1),(53,'2025_05_31_173455_add_statut_to_inscriptions_cours_table',1),(54,'2025_05_31_190831_add_type_and_requirements_to_cours_table',1),(55,'2025_05_31_195633_add_role_to_users_table',1),(56,'2025_05_31_simplify_cours_table',1),(57,'2025_06_01_100744_add_indexes_for_optimization',1),(58,'2025_06_01_132740_create_badges_tables',1),(59,'2025_06_01_create_auth_logs_table',1),(60,'2025_06_02_110116_update_auth_logs_table_structure',1),(61,'2025_06_02_140236_add_ceinture_system_to_membres_table',1),(62,'2025_06_05_161601_fix_users_sexe_column',1),(63,'2025_06_06_111317_create_notifications_table',2),(64,'2025_06_06_112847_add_soft_deletes_to_users_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage-all','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(2,'manage-ecole','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(3,'manage-cours','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(4,'manage-membres','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(5,'view-reports','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(6,'view-dashboard','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(7,'view-superadmin-dashboard','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(8,'view-ecoles','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(9,'create-ecoles','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(10,'edit-ecoles','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(11,'delete-ecoles','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(12,'view-membres','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(13,'create-membres','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(14,'edit-membres','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(15,'delete-membres','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(16,'approve-membres','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(17,'view-cours','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(18,'create-cours','web','2025-06-06 12:38:48','2025-06-06 12:38:48'),(19,'edit-cours','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(20,'delete-cours','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(21,'duplicate-cours','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(22,'view-presences','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(23,'take-presences','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(24,'edit-presences','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(25,'view-inscriptions','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(26,'manage-inscriptions','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(27,'view-seminaires','web','2025-06-06 12:38:49','2025-06-06 12:38:49'),(28,'manage-seminaires','web','2025-06-06 12:38:49','2025-06-06 12:38:49');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portes_ouvertes`
--

DROP TABLE IF EXISTS `portes_ouvertes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portes_ouvertes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_evenement` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portes_ouvertes`
--

LOCK TABLES `portes_ouvertes` WRITE;
/*!40000 ALTER TABLE `portes_ouvertes` DISABLE KEYS */;
/*!40000 ALTER TABLE `portes_ouvertes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presences`
--

DROP TABLE IF EXISTS `presences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `membre_id` bigint unsigned NOT NULL,
  `cours_id` bigint unsigned NOT NULL,
  `date_presence` date NOT NULL,
  `status` enum('present','absent','retard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  PRIMARY KEY (`id`),
  UNIQUE KEY `presences_membre_id_cours_id_date_presence_unique` (`membre_id`,`cours_id`,`date_presence`),
  KEY `presences_cours_id_date_presence_index` (`cours_id`,`date_presence`),
  KEY `presences_membre_id_date_presence_index` (`membre_id`,`date_presence`),
  CONSTRAINT `presences_cours_id_foreign` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  CONSTRAINT `presences_membre_id_foreign` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presences`
--

LOCK TABLES `presences` WRITE;
/*!40000 ALTER TABLE `presences` DISABLE KEYS */;
/*!40000 ALTER TABLE `presences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(2,2),(3,2),(4,2),(5,2),(3,3),(5,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(2,'admin','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(3,'instructeur','web','2025-06-06 12:38:05','2025-06-06 12:38:05'),(4,'user','web','2025-06-06 12:38:05','2025-06-06 12:38:05');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seminaires`
--

DROP TABLE IF EXISTS `seminaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seminaires` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seminaires`
--

LOCK TABLES `seminaires` WRITE;
/*!40000 ALTER TABLE `seminaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `seminaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('9zuZLZPTKQsaoyIHcKswzmv9XfaCy8rzhoh5T0vE',NULL,'127.0.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVZsbnNsZHRrb1BUQzIzam9WSWVZelROTlhuNFVPd3Z1Y3lkSnVnVSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749321627),('FBrxIgEH0TKIVIHGULqzOTPvMOqukqqThyqQF6pP',NULL,'127.0.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWThTeEs4QjNjMVNhMmhVQTJJdXZVMkdjM1FnSG56NGkxeVhKWnJBSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749320530),('fjJOSCeLVlDxmfSan254whZTcU7g4RhyqwCzcMYS',NULL,'43.153.58.28','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoieE9TdGtMbHhNYXRyQmJzZDhxa3M0S1l1SnZJUDhqVm1QOHZDN2NsYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvZm9yZ290LXBhc3N3b3JkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749316038),('fKzTCC6nFMBXrHMc2a5vptKGIuR3bHbzmhkIaHh3',1,'10.10.10.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicE5NN0NoNTBLNzVhQW5nY1Z3dUhQOGdielNDZU16aXV1b0RtVzZ0NiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2FkbWluIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1749324442),('Gq24oB06h9kP33fYGcJvnAQIwtSXseoCOoJODvo4',NULL,'185.242.226.14','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic1diOHplbDlhSFBhbnQ2aU90alNvWHA4WU42NXZuUTg0REowYlA5NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749323656),('IfR0YiCzMOL4cFaAJK0Q7tEl5ba6EYw3ngw9Uu0O',NULL,'51.159.23.43','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiblRucWNsT0RBZE85Q2NuV0hFbUVPWUh5TVQwMUF4djhFQ3RjNlhHcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749323553),('jyq9tCANCjI8e4bDhd1YgggRgcngGAUgd2St9uPv',NULL,'43.166.246.180','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0t4aFhsa0NpdlFpRWRBZll0NVhlN1VkMEdhNVlKVkxzSWNoa2Y2OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvcHJpdmFjeS1wb2xpY3kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749317479),('ke50jTCUa3ndPPkwIX4CjPemnXCvGUHus7mgyTCR',NULL,'127.0.0.1','curl/8.5.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZjJHZ2JBVEExYXN0RXF1azJhc2hWb2Z4VWR1aHRYOGxOYWxibW9hQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749323432),('MeOeuenmMPRhMvUWb9UA2Fj8zw7wv52JUpFS9IKy',NULL,'127.0.0.1','curl/8.5.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlFkakRNMk04WFBwM2ltc1hQdTduclRiRllNOVlPelZNWDZTeWZGRiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749321568),('o5hU7bqer0MzQy5s9V52Bg3csr286qKRzYGQF3hf',NULL,'127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYUd3MUlBVGZ1bW5FaTNTTnNWcnAwc0hmUGY2cmNicFEyMUdoSktndSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vbG9jYWxob3N0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749323440),('OrisHOqGkXga823UZhURSzSFyujbaDxit6yeRN0y',NULL,'49.51.196.42','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVdWWnp3Ym4xVW5BcnhGckdRaGNKdXI5bHJDcUUyS2REOUFoNVhsSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749316718),('PWiRV0WGLndxtoLe4Blv0VjbKTim6UiPFBQWq3Sk',NULL,'10.10.10.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidk12TjdBQXgwaUJoQkhZS0hxTDRYSjY1M0R5MHJNNzZuQjdZdlQwUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9fQ==',1749324371),('rPHnkJZAGHMWe4HjTXAPgqdtM4s01vtncjSnN3yc',NULL,'127.0.0.1','curl/8.5.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiQllLRGlWa1U2ZjBMM3VOaTJiVjExc1kyRzhhV0FoZGV6Q0Q1ZHE2QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749323313),('YrabvZooriFuB9kON6XKedb2TMMdRO2QBBUjgL1Y',NULL,'127.0.0.1','curl/8.5.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibU9peEhnSHBtM1FjUjlUMVR1ZFRKNW9mREhncjlxTllqcXFIUmhpYSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749320570),('yRhF23pvksC4EK9VjyCAisXtR4YiN8qi0DYoPRUt',NULL,'127.0.0.1','curl/8.5.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoibkFCT3dzQ2J2NWlzSHN3ck1QY0kxT1F6VEJrNURlR2c1Yng1U2JwVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1749321568),('zPqaDBir6yXDG9qT7CZ2te3uPl0ufMk1NJcFnM9D',NULL,'127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiME0zWUVQd1BIdG5XT1lkSm1Wb1FWSUs2NndmaU9qdjd3MkVuUU9OUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=',1749321974);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_consents`
--

DROP TABLE IF EXISTS `user_consents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_consents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `consent_type_id` bigint unsigned NOT NULL,
  `is_granted` tinyint(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `granted_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_consents_user_id_consent_type_id_unique` (`user_id`,`consent_type_id`),
  KEY `user_consents_consent_type_id_foreign` (`consent_type_id`),
  CONSTRAINT `user_consents_consent_type_id_foreign` FOREIGN KEY (`consent_type_id`) REFERENCES `consent_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_consents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_consents`
--

LOCK TABLES `user_consents` WRITE;
/*!40000 ALTER TABLE `user_consents` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_consents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` enum('M','F','Masculin','Féminin','Homme','Femme') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_civique` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'QC',
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ecole_id` bigint unsigned DEFAULT NULL,
  `membre_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_attempts` int NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `theme_preference` enum('light','dark','auto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `language_preference` enum('fr','en') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fr',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_ecole_id_foreign` (`ecole_id`),
  KEY `users_role_index` (`role`),
  KEY `users_active_index` (`active`),
  CONSTRAINT `users_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'QC',NULL,NULL,NULL,'Super Admin','lalpha@4lb.ca','superadmin','superadmin','2025-06-06 12:38:49','$2y$12$SAqfbEZt0Ic/73SyBLC20eKELWEhrCtRlIWOy/DU.2ZCg2F85hoZG',1,'KKyhv5NBN7lUToE49vKwe9NkiQbsE8Xdop9iKKcK1512sKHdHnjw1VvmVsFS','2025-06-06 12:38:49','2025-06-06 12:38:49',NULL,NULL,0,NULL,'auto','fr',NULL),(2,'Louis','Gestion',NULL,NULL,'(418) 555-0151','1234','Rue Principale','St-Émile','QC','G0A 4E0',17,NULL,'Louis Gestion','louis@4lb.ca','louis.gestion','admin','2025-06-07 12:47:11','$2y$12$jonh5DQNTyuZWo20UNuruOGQ.bS9svwI3N0BYey.yN1s12Vy5DcSC',1,'3bo4ZYETdUpRJj9FuNpIS3YWD9MIVM50uBoqLP4Xlp1X5z9E37IfW0EU79Yx','2025-06-07 12:47:11','2025-06-07 12:47:11',NULL,NULL,0,NULL,'auto','fr',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-07 15:45:47
