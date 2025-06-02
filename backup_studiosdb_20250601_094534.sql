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
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,'default','created','App\\Models\\Cours','created',1,'App\\Models\\User',9,'{\"attributes\": {\"nom\": \"parents enfants\", \"actif\": true, \"places_max\": 40}}',NULL,'2025-06-01 00:29:14','2025-06-01 00:29:14'),(2,'default','Cours créé','App\\Models\\Cours',NULL,1,'App\\Models\\User',9,'[]',NULL,'2025-06-01 00:29:14','2025-06-01 00:29:14'),(3,'default','created','App\\Models\\Cours','created',2,'App\\Models\\User',9,'{\"attributes\": {\"nom\": \"cours pour tous\", \"actif\": true, \"places_max\": 40}}',NULL,'2025-05-31 20:41:57','2025-05-31 20:41:57'),(4,'default','Cours créé','App\\Models\\Cours',NULL,2,'App\\Models\\User',9,'[]',NULL,'2025-05-31 20:41:57','2025-05-31 20:41:57'),(5,'default','Test',NULL,NULL,NULL,NULL,NULL,'[]',NULL,'2025-06-01 13:32:27','2025-06-01 13:32:27');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceintures`
--

LOCK TABLES `ceintures` WRITE;
/*!40000 ALTER TABLE `ceintures` DISABLE KEYS */;
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
-- Table structure for table `consent_history`
--

DROP TABLE IF EXISTS `consent_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consent_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_consent_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_value` tinyint(1) DEFAULT NULL,
  `new_value` tinyint(1) NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_consent_id` (`user_consent_id`),
  CONSTRAINT `consent_history_ibfk_1` FOREIGN KEY (`user_consent_id`) REFERENCES `user_consents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consent_history`
--

LOCK TABLES `consent_history` WRITE;
/*!40000 ALTER TABLE `consent_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `consent_history` ENABLE KEYS */;
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
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `version` int NOT NULL DEFAULT '1',
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
INSERT INTO `consent_types` VALUES (1,'terms_conditions','Conditions d\'utilisation','J\'accepte les conditions d\'utilisation du service',1,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47'),(2,'privacy_policy','Politique de confidentialité','J\'ai lu et j\'accepte la politique de confidentialité',1,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47'),(3,'marketing_emails','Communications marketing','J\'accepte de recevoir des communications marketing par courriel',0,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47'),(4,'photo_usage','Utilisation de photos','J\'autorise l\'utilisation de mes photos à des fins promotionnelles',0,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47'),(5,'emergency_contact','Contact d\'urgence','J\'autorise le partage de mes informations avec les contacts d\'urgence',0,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47'),(6,'cookies_analytics','Cookies analytiques','J\'accepte l\'utilisation de cookies à des fins analytiques',0,1,1,'2025-05-30 21:18:47','2025-05-30 21:18:47');
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
  `age_min` int DEFAULT NULL,
  `age_max` int DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `places_max` int NOT NULL DEFAULT '20',
  `tarification_info` text COLLATE utf8mb4_unicode_ci,
  `ecole_id` bigint unsigned DEFAULT NULL,
  `session_id` bigint unsigned DEFAULT NULL,
  `tarif` decimal(8,2) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `duree` int NOT NULL DEFAULT '60',
  `jours` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ceinture_requise_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cours_ecole_id` (`ecole_id`),
  KEY `fk_cours_session_id` (`session_id`),
  KEY `cours_ceinture_requise_id_foreign` (`ceinture_requise_id`),
  CONSTRAINT `cours_ceinture_requise_id_foreign` FOREIGN KEY (`ceinture_requise_id`) REFERENCES `ceintures` (`id`),
  CONSTRAINT `fk_cours_ecole_id` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cours_session_id` FOREIGN KEY (`session_id`) REFERENCES `cours_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours`
--

LOCK TABLES `cours` WRITE;
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
INSERT INTO `cours` VALUES (2,'cours pour tous','session ete pour tous les niveaux','regulier',NULL,NULL,'2025-06-04',NULL,40,'175',1,3,NULL,1,60,NULL,'2025-05-31 20:41:57','2025-05-31 20:41:57',NULL),(3,'Cours Test pour Bobby','Cours de test pour vérifier les accès','regulier',NULL,NULL,'2025-05-31',NULL,20,NULL,1,1,NULL,1,60,NULL,'2025-05-31 21:29:12','2025-05-31 21:29:12',NULL);
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
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cours_horaire` (`cours_id`,`jour`,`heure_debut`,`heure_fin`),
  KEY `cours_horaires_cours_id_jour_index` (`cours_id`,`jour`),
  KEY `cours_horaires_jour_heure_debut_index` (`jour`,`heure_debut`),
  CONSTRAINT `cours_horaires_ibfk_1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_horaires`
--

LOCK TABLES `cours_horaires` WRITE;
/*!40000 ALTER TABLE `cours_horaires` DISABLE KEYS */;
INSERT INTO `cours_horaires` VALUES (2,2,'mercredi','18:00:00','19:30:00',NULL,NULL,1,'2025-05-31 20:41:57','2025-05-31 20:41:57'),(3,3,'lundi','18:00:00','19:00:00',NULL,NULL,1,'2025-05-31 21:29:12','2025-05-31 21:29:12');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_sessions`
--

LOCK TABLES `cours_sessions` WRITE;
/*!40000 ALTER TABLE `cours_sessions` DISABLE KEYS */;
INSERT INTO `cours_sessions` VALUES (1,1,'Hiver 2025',NULL,'2025-01-15','2025-03-31',NULL,1,1,NULL,'#4FC3F7',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(2,1,'Printemps 2025',NULL,'2025-04-01','2025-06-15',NULL,1,1,NULL,'#81C784',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(3,1,'Été 2025',NULL,'2025-06-16','2025-08-31',NULL,1,1,NULL,'#FFD54F',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(4,1,'Automne 2025',NULL,'2025-09-01','2025-12-20',NULL,1,1,NULL,'#FF8A65',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(5,2,'Hiver 2025',NULL,'2025-01-15','2025-03-31',NULL,1,1,NULL,'#4FC3F7',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(6,2,'Printemps 2025',NULL,'2025-04-01','2025-06-15',NULL,1,1,NULL,'#81C784',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(7,2,'Été 2025',NULL,'2025-06-16','2025-08-31',NULL,1,1,NULL,'#FFD54F',1,'2025-06-01 00:23:59','2025-06-01 00:23:59'),(8,2,'Automne 2025',NULL,'2025-09-01','2025-12-20',NULL,1,1,NULL,'#FF8A65',1,'2025-06-01 00:23:59','2025-06-01 00:23:59');
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
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Québec',
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ecoles`
--

LOCK TABLES `ecoles` WRITE;
/*!40000 ALTER TABLE `ecoles` DISABLE KEYS */;
INSERT INTO `ecoles` VALUES (1,'Studio St-Émile','123 rue Principale','St-Émile','QC','418-555-1000','info@st-emile.ca','Marie Dubois','2025-05-29 18:31:43','2025-05-29 18:31:43',1),(2,'Studio Val-Bélair','456 avenue du Centre','Val-Bélair','QC','418-555-2000','info@val-belair.ca','Pierre Gagnon','2025-05-29 18:31:43','2025-05-29 18:31:43',1);
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
  `statut` enum('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmee',
  `date_inscription` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membres_ecole_id_foreign` (`ecole_id`),
  CONSTRAINT `membres_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membres`
--

LOCK TABLES `membres` WRITE;
/*!40000 ALTER TABLE `membres` DISABLE KEYS */;
INSERT INTO `membres` VALUES (9,1,'Tremblay','Alexandre','alex.tremblay@gmail.com','1995-03-15','H','418-555-0101','123','rue des Érables','St-Émile','QC','G3E 1A1',1,'2024-01-15 15:00:00','2025-05-29 18:32:42'),(10,1,'Bouchard','Sophie','sophie.bouchard@hotmail.com','1988-07-22','F','418-555-0102','456','avenue Cartier','St-Émile','QC','G3E 2B2',1,'2024-02-10 19:30:00','2025-05-29 18:32:42'),(11,1,'Lavoie','Maxime','maxime.lavoie@gmail.com','2000-11-08','H','418-555-0103','789','boulevard Laurier','St-Émile','QC','G3E 3C3',1,'2024-03-05 14:15:00','2025-05-29 18:32:42'),(12,1,'Martin','Élise','elise.martin@yahoo.ca','1992-05-18','F','418-555-0104','321','rue de la Paix','St-Émile','QC','G3E 4D4',1,'2024-03-20 20:45:00','2025-05-29 18:32:42'),(13,1,'Tremblay','Alexandre','alex.tremblay@gmail.com','1995-03-15','H','418-555-0101','123','rue des Érables','St-Émile','QC','G3E 1A1',1,'2024-01-15 15:00:00','2025-05-29 18:32:54'),(14,1,'Bouchard','Sophie','sophie.bouchard@hotmail.com','1988-07-22','F','418-555-0102','456','avenue Cartier','St-Émile','QC','G3E 2B2',1,'2024-02-10 19:30:00','2025-05-29 18:32:54'),(15,1,'Lavoie','Maxime','maxime.lavoie@gmail.com','2000-11-08','H','418-555-0103','789','boulevard Laurier','St-Émile','QC','G3E 3C3',1,'2024-03-05 14:15:00','2025-05-29 18:32:54'),(16,1,'Martin','Élise','elise.martin@yahoo.ca','1992-05-18','F','418-555-0104','321','rue de la Paix','St-Émile','QC','G3E 4D4',1,'2024-03-20 20:45:00','2025-05-29 18:32:54'),(17,2,'Côté','David','david.cote@gmail.com','1990-09-12','H','418-555-0201','654','rue des Pins','Val-Bélair','QC','G3K 1E5',1,'2024-01-20 16:20:00','2025-05-29 18:33:06'),(18,2,'Bélanger','Nathalie','nathalie.belanger@outlook.com','1985-12-03','F','418-555-0202','987','avenue des Saules','Val-Bélair','QC','G3K 2F6',1,'2024-02-25 18:40:00','2025-05-29 18:33:06'),(19,2,'Roy','Vincent','vincent.roy@gmail.com','1998-04-25','H','418-555-0203','147','chemin des Bouleaux','Val-Bélair','QC','G3K 3G7',1,'2024-03-12 12:30:00','2025-05-29 18:33:06'),(20,2,'Paradis','Amélie','amelie.paradis@gmail.com','1993-08-14','F','418-555-0204','258','rue du Soleil','Val-Bélair','QC','G3K 4H8',1,'2024-04-02 19:25:00','2025-05-29 18:33:06');
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_11_153211_create_permission_tables',1),(5,'2025_05_11_153301_create_cours_table',1),(6,'2025_05_11_153323_create_ecoles_table',1),(7,'2025_05_11_153335_create_membres_table',1),(8,'2025_05_11_153348_create_presences_table',1),(9,'2025_05_11_153400_create_portes_ouvertes_table',1),(10,'2025_05_11_191925_create_admins_table',1),(11,'2025_05_11_192032_create_ceintures_table',1),(12,'2025_05_11_192058_create_ceintures_membres_table',1),(13,'2025_05_11_192124_create_ceintures_obtenues_table',1),(14,'2025_05_11_192220_create_demandes_inscriptions_table',1),(15,'2025_05_11_192315_create_historique_table',1),(16,'2025_05_11_192341_create_inscriptions_cours_table',1),(17,'2025_05_11_192416_create_journees_portes_ouvertes_table',1),(18,'2025_05_11_192453_create_liens_personnalises_table',1),(19,'2025_05_11_192517_create_log_table',1),(20,'2025_05_11_192536_create_logs_admins_table',1),(21,'2025_05_12_185420_alter_membres_id_to_bigint',1),(22,'2025_05_12_185646_modify_membres_id_to_bigint',1),(23,'2025_05_13_000000_create_sessions_table',1),(24,'2025_05_14_195631_add_present_to_presences_table',1),(25,'2025_05_14_201504_update_presences_table',1),(26,'2025_05_14_202725_drop_journees_portes_ouvertes_table',1),(27,'2025_05_14_202837_create_journees_portes_ouvertes_table',1),(28,'2025_05_15_000001_add_profil_fields_to_users_table',1),(29,'2025_05_15_145918_update_presences_table_add_columns',1),(30,'2025_05_17_193654_create_cours_sessions_table',1),(31,'2025_05_17_201848_add_session_id_to_cours_table',1),(32,'2025_05_18_163118_create_seminaires_table',2),(33,'2025_05_18_163905_create_membre_seminaire_table',2),(34,'2025_05_18_222059_add_ordre_to_ceintures_table',2),(35,'2025_05_18_222237_add_ordre_to_ceintures_table',2),(36,'2025_05_18_224136_add_couleur_to_ceintures_table',2),(37,'2025_05_18_224946_modify_couleur_nullable_on_ceintures',2),(38,'2025_05_20_000002_update_cours_table',2),(39,'2025_05_21_151026_add_missing_fields_to_ecoles_table',3),(40,'2025_05_22_000024_optimize_presences_table',3),(41,'2025_05_22_000208_add_indexes_and_comment_to_presences_table',3),(42,'2025_05_22_000927_add_indexes_and_comment_to_presences_table',3),(43,'2025_05_22_180029_add_username_to_users_table',3),(44,'2025_05_22_182644_add_active_column_to_users_table',3),(45,'2025_05_22_195345_add_missing_columns_to_cours_sessions_table',3),(46,'2025_05_22_201008_create_cours_horaires_table',1),(47,'2025_05_28_212214_add_security_fields_to_users_table',4),(48,'2025_05_29_151734_add_lieu_to_seminaires_table',4),(49,'2025_05_29_154500_create_membre_ceinture_pivot_table',4),(50,'2024_01_01_000001_create_consent_tables',5),(51,'2025_05_29_150157_add_theme_preference_to_users_table',6),(52,'2025_05_30_162759_create_activity_log_table',6),(53,'2025_05_30_162800_add_event_column_to_activity_log_table',6),(54,'2025_05_30_162801_add_batch_uuid_column_to_activity_log_table',6),(55,'2025_05_30_create_cours_schedules_table',7),(56,'2025_05_31_190831_add_type_and_requirements_to_cours_table',8),(57,'2025_05_31_update_cours_table_for_karate',8),(58,'2025_05_31_195633_add_role_to_users_table',9),(59,'2025_05_31_simplify_cours_table',10),(60,'2025_05_31_173306_add_missing_columns_to_inscriptions_cours',11),(61,'2025_05_31_173455_add_statut_to_inscriptions_cours_table',12);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',7),(2,'App\\Models\\User',8),(2,'App\\Models\\User',9);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage-all','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(2,'manage-ecole','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(3,'manage-cours','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(4,'manage-membres','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(5,'view-reports','web','2025-06-01 00:02:57','2025-06-01 00:02:57');
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
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `presences_membre_id_cours_id_date_presence_unique` (`membre_id`,`cours_id`,`date_presence`),
  UNIQUE KEY `uk_presence_unique` (`membre_id`,`cours_id`,`date_presence`),
  KEY `presences_cours_id_date_presence_index` (`cours_id`,`date_presence`),
  KEY `presences_membre_id_date_presence_index` (`membre_id`,`date_presence`),
  KEY `idx_cours_date` (`cours_id`,`date_presence`),
  KEY `idx_membre_date` (`membre_id`,`date_presence`),
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
INSERT INTO `roles` VALUES (1,'superadmin','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(2,'admin','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(3,'instructeur','web','2025-06-01 00:02:57','2025-06-01 00:02:57'),(4,'user','web','2025-06-01 00:02:57','2025-06-01 00:02:57');
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
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seminaires`
--

LOCK TABLES `seminaires` WRITE;
/*!40000 ALTER TABLE `seminaires` DISABLE KEYS */;
INSERT INTO `seminaires` VALUES (1,'Séminaire Kata Avancé','2024-06-15','2024-06-15','Dojo Principal Québec','Formation aux katas de niveau supérieur pour perfectionnement technique','2025-05-29 18:35:42','2025-05-29 18:35:42'),(2,'Stage de Perfectionnement','2024-07-10','2024-07-12','Centre Sportif Laval','Stage intensif de trois jours pour amélioration technique globale','2025-05-29 18:35:42','2025-05-29 18:35:42'),(3,'Formation Arbitrage','2024-08-20','2024-08-22','Salle de Conférence PEPS','Formation certifiante pour devenir arbitre officiel de compétitions','2025-05-29 18:35:42','2025-05-29 18:35:42'),(4,'Séminaire Autodéfense','2024-09-14','2024-09-14','Gymnase Université Laval','Techniques pratiques d\'autodéfense adaptées au quotidien','2025-05-29 18:35:42','2025-05-29 18:35:42');
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
INSERT INTO `sessions` VALUES ('01dSPxhZvjcseHXDmspHzwz1tHglu4b72p2kMGRn',NULL,'45.156.128.43','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXNNakdVUkxwQWVGTXNoQkdzTkJHd1V5bFdLVlNLM3N2OFVMV2hNTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748719123),('0nHa0EpPXgXCmZW1JuQ4EgDnEN6xJc0CYLq7Zlxq',NULL,'45.156.128.129','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWVUZHlwVDU0ZnRDTjBWZkdEUFBuS3FEbkdoRk50TEpmWHp5cEFWMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748741801),('0vtdFqCilYLqnZ5hd0rz0WJMSVREHW9KQqYclLXl',NULL,'139.99.35.46','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWszTU1weWVvclk3bmhIalZucUtXbHBWTjlTQTFBZWxGNWUwYXB0TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748780370),('1UQbrOyyGlQ4SZOYsYfHmCSYKLORftMndUvvvrOM',NULL,'45.156.128.129','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0l4RzhwNjZUY08wcG5BQzFFSFJvS3hkNGZvVVE2N1FOQkxQRUJaMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748741801),('1XUbAISSYUeVhAigAPGbx7sJNKJsv6hZJ0aZflp3',NULL,'34.38.147.151','python-requests/2.32.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoicEduTHpvRVpVVWhudGZxM0RCMFRZSnNlQmpxbk5ZTGpHV0dnY1ZRNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748775259),('35UaaodDaL3YuSqM0m3jh7sFPto4LZq2ERuCbiPx',NULL,'185.242.226.80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/95.0.4638.69 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiODU5N2VVYmZpajlyQmNjN0NlMm5Ja0g4aFRHVkNaMU45TFBXbzQ2SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748773433),('3QTdHM7Ipx7PKG8NI30wpAre9uJazmhCzQ9n5FV9',NULL,'195.3.221.137','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUJBczFxUXNwSVFEUk9KUVNqUk1jSWxQaFd0UzlMdjlMUWYya1ludCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748728824),('3XCe1kSGuo04imNkLFJSPiaueU6BKNHBAPvdkJsh',NULL,'64.62.156.207','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Safari/605.1.15','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUp0b3FBZmhYaUFxR0hWS1B6dTI5MEJ4ZmFIYzUxcW1xd2lSWVNZbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748761915),('4YvoqJ3IWeB8hYNk1KMZyHsSBSIqWotP4o1RpojE',NULL,'167.99.90.250','Mozilla/5.0 (X11; Linux x86_64; rv:136.0) Gecko/20100101 Firefox/136.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjlCUUtyNXJBU2FWVnhMaktnZjczcTg3a25JV0o3dXhrS09KQUNjTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748758015),('5SBrsLJ2uv35kQ6KxRHJkk6jU5lpFVHRe8fm4VmO',NULL,'104.152.52.142','curl/7.61.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzdCSFdUYmxSNHJmNjV0aTZYc284YXlIaHZMTU1SZ1pmZG9XdEZDdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748765912),('84CW8cXQOEFpgaTlxlGfTqjcE0ROqKoZ52Jw1f2t',NULL,'15.235.189.150','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2g5TGIyVHhRNEl4ZkZXeTAxY09EWVRoeHpuaTBmWmFSeG1hTXFkdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748779892),('8fKXceUWxbsYdqsBBADYNBy8MWBQZrlBN0Qjozwd',NULL,'167.99.90.250','Mozilla/5.0 (X11; Linux x86_64; rv:136.0) Gecko/20100101 Firefox/136.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWVZOVJWM0c1Y0s5VThZdmVLYXllV1J1a05vYUhxbEgyM3Raall4NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748758017),('a9pKkOi024LhF3fqDEuxE2B3QozU6klTDeC7ERrC',NULL,'34.247.178.83','Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHlQbWczdldQUmFjUmc3M0FTZzR4OHZEYXR3dUtUcGIyNHlSYjRiMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vd3d3LjRsYi5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748779595),('BaqC35Zbcx1zDGWKBf7e5jExxEo8SIJkQ5KIjsf2',NULL,'34.247.178.83','Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMW03S0ZzV0FiRWdBVGxwV3JFRTJvNFhCZWJnZ21NN05kb1Nic3R3SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vd3d3LjRsYi5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748779592),('bFsRHgZgs8xemaFXXIvKpBPRyLvbywA3D7Uh8LJw',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0ZnTlJUdDdaaVIwR0E2MjNlNktwczR6SW9SQzM5T0g0dEFkWXlMRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726828),('bk6gcEFSZOGqyX4NipnJ6eTmRWhhjgwG7TlQm3om',NULL,'185.242.226.14','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3hjdFVCZ3pIRk0zZ1ZSQ285VnpyTUpNWWhicDZsYlNZR1lsZjNoTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748751852),('C86Cnvvis6kcpYWIYwfJKmSk9tWcMH88vDXPxQpv',NULL,'64.227.70.84','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzZhZUdLMHBHd0h1SGJ1QzFuWXNMbmpmWjBiYXY0Y3FFMnRkYUk3aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748722489),('cDrLmYZsI5zzclXcDlHz2nU5YNtBBF4fQLYreaue',NULL,'57.141.0.13','meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmxaV2lCUEdJSXJ5c3A3V3FZbWpadW96YVc4Tmp4VFcySjZFR2NydCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vNGxiLmNhLz9DPVMlM0JPJTNERCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748752002),('cZPdKj2fQz1KWnNgzUh00YyeVFsl9l0tKSoKCVP7',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2Q5QkhORTQ4MUlPZlh3UEhIa2FVbHdNN2RHdzZNcERrSDg0aDV6QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726714),('DP0lReji225JOASoXanJfKGTq2FQKOD8NkbAi3be',NULL,'45.156.130.15','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieTdocXMxNU5yRzY3RW8wWVBGMm9mVVhFOXUyRDRmVDlFSFBvcDdyMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748717570),('e5k7iaJ8mvc5kFT4C2ZMqD0FJqFN2XHv3Wl6BVro',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEdFT05mMTJad3hBVUhnQTBkNDZkZUljZTlqRkJ1alI5QVdUZ2RZeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726952),('F8yW95g8qKqbHQwo9couaT9PgBS8eTsJzlmIKyGd',NULL,'198.235.24.27','','YTozOntzOjY6Il90b2tlbiI7czo0MDoieWJsZXRDZjNZVDVsVXJQOTBqSUZJSXB3WkUzQ2l6U0ttM2hORVZuSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTQ6Imh0dHBzOi8vNGxiLmNhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748766283),('fBqoJQiRpxvnUmgdnxMe6QXhPkwgjnEAm9MJWh1b',NULL,'64.62.156.202','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4.1 Safari/605.7.20','YTozOntzOjY6Il90b2tlbiI7czo0MDoib05oejk4NVZuMjl3V0p0Q0Y2b01BY1dxU25aYkN5bkFOVVZTYzJHaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748762026),('fsS5tPhqtdhFxPK70wf6Wpu0lRlVrUBEL1VKnbzV',NULL,'195.3.221.137','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiakJjcWxaRUdyWUJibTg1aWpaVWs3cm51anloNXZYSUQwTzZ1a1A0UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748773556),('gAs5RL5zD66M8hKOTwQdUsfXftXY8cvUKSghApet',NULL,'185.242.226.14','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjBTZkU2Nm9PYmxqSU5ITExLMVlyR0dXdlFJTldSN05mNEY2RU5DcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748751852),('GtPYNhK5WfMN0yXt10U4xv3fzkYghL7f5rbBa7iz',NULL,'45.156.128.45','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicERwZk91N0RkZ2VVTXB2TzF0dTJnZ2RsekFUSEdha0kxZlNuUXdZNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748738904),('gX82BzntsLPTg3MXCVSP9l8mgLr7nxi5uYyxjcUr',NULL,'192.168.1.62','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTB5SkFreHFHY0RNSjZISlBqcDJNemx6MXphUEE4UGFPdVRGaTZQeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748730561),('hxKzsBIw8kQHfldDN32MxOJO5B3XruBjGdAfjT3q',NULL,'78.135.70.251','Mozilla/5.0 (X11; CrOS x86_64 14541.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHBWWVVZckF3dDVQd2lReG1rM1NYaTdMeHVyYmp2VzB4WER0dFpzYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748771764),('IBIKUavQ8h7rzTIqDcCh14cTd0Dk40dhYU6QpSkU',NULL,'195.3.221.137','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNW5YVlR1MG9lNjVJOVowZERzSFhGYXEwdnlFZEE1OUQ4d3JZdW5raiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748719413),('ioVqjUTcBjOtDPnEPviu7pYhKjIMgJZIIplwt7D8',NULL,'57.141.0.9','meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjJsTTJFTFFIcFNpSkdyVUtZdjdiVUU1UEN1M1lGaWlDQW5HZUV5bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vNGxiLmNhLz9DPVMlM0JPJTNERCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748752023),('iOVWu50pdMS0XFwfcOKkpa8zc65jrWhG06p3lgoA',NULL,'190.140.39.113','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHl0eXF2WldEVU9DRTBvWFVTSzYwZ0RQTWZPVW5ldjdqdlZkT3FGRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748771793),('JIhAwXy6607hjx4xjBcj7ZdxqPcCkPo2fHN7VWrq',NULL,'64.62.156.205','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkJJRERDY0l6cktrZ0hkQm9yVjZESjhMZ25SMWFTVFJiMloweFdyaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748761798),('jwGm698qK2ZqFzARd7IGsTL5oplN8MIbKmYn8O63',NULL,'23.239.29.119','Mozilla/5.0 (X11; Linux x86_64) Chrome/98.0.4758.132 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2RxZzZlUkVtb2VNa052T3FTZXZZTFl2YjlXZkljTlE3OXhyMnRXUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748767557),('jymjCTjtyKqsU3Azucz99psHvlN5lBtqKybX2cfr',NULL,'3.143.33.63','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXFpWVhBMzVYYVBCb0ZIVUlKNG82ZVJKTnZWS1NHQTdRV215N05jMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748763846),('k4S4bK7MEQlLcvrzrD4S3YEu11VmBPXtPgrgL3LM',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXpTd29uVTA5MlBRUmJnZnhLZklQZTc1akp2VjJsamNoTG5iNHp5VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726793),('KZD3oaB61slx9lRq3GafXzNG3MI8dGAtboVSrbet',NULL,'185.242.226.116','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiemludGNCVXUySXhQZ3RXb1hPOHZXSlBmbmkxdXRiZVNwVGtVSmJoWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748729750),('MQUDtQ9SOSGJqwQjABQlUnzv4WYNvljtAV3Mx3uo',NULL,'64.227.70.84','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW01Z3d1TDlTdENhRG5TRzBQVGZtTjNtaVRoRkdaN0FsT2hGbkhRZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748722489),('n6RC4XJWbnIyIAotH9PAHKCVgoxUOEn0bYi4ZUCV',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWh5ejN3WWJOU1BIanBPaHFweUtTUWNTaUloM05lTnhrTnplNUlzTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726311),('NekZAYh2iySfnGPeqNjFG7FT7YDiUg3XZQDBBwev',NULL,'15.235.189.157','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmpRTlhmOTZoc2JsVXYxRFZhT2hVRFBYaU9OVWZLdndUbkkzTmROQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748779494),('nrGMdqz9LsbRT7eF63ihpsq7XdGg5ZzUPLZyMetP',NULL,NULL,'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR25iaER2YXVIYnFTWlBIUFpZeU5jNmxnUFFOOEpCWERkdGxVYTE5WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748726400),('nupm8ix6WY9hjA2UuYzK8bP1QSMA86UXFOGRplZZ',NULL,'65.49.1.136','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/110.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieXdjQW5keG9tb2g2a2FveThTTnU4WEk2U0ZBa1lqMUoyZjdwYkI5NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748767799),('oAeOCllriEwnQqeqlBxEuHQdJHchULn3NJ45O4RF',NULL,'64.62.156.207','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Safari/605.1.15','YTozOntzOjY6Il90b2tlbiI7czo0MDoicXBsMDVZYWQxRFVnVFNQdXY5V2FuSnpONFA5bEhrSkxyUzJDQ3d0WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748761915),('oE0gVtjKEGXadP6HFzwpUJUI1S4bYLOzYWo65ABa',NULL,'162.62.231.139','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoic0tUbVBmZjVJVXlhaEdNWERXMXZLSkZMMjQzUUl5RlljYkNPMmNGUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748760229),('oopKRgl2SQtN3U60B24DgvAQccKpexnuuQdvGwSd',NULL,'64.181.253.64','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoiczh5TTE1OW4wd0pBYmJMZTVFVERoRkQyZW93dFlwSElwWUJ5N0EwRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748739478),('PaU0WIcC2lIdN4rH3ardjd5tXtythGpTaQzqEpPB',NULL,'57.141.0.7','meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3l0am14b0JnQmtIb2ZseHFiVG5WSTVoWWcwcndNUFVrdjFKU2hLdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vd3d3LjRsYi5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748751273),('pEULVILGnd0DECGESX9uAHEJEnFwEpFm4e2BOS7B',NULL,'162.62.231.139','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVlluMHhmQzg4MHVGYUJJNzkzdzdTTjhNbHEzSDJ4WmdEanJZYWFCVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748760230),('pJuP9CGTC9eMy9sfjimh5Yyt5wP2jn7syRHBQZxM',NULL,'185.242.226.80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzlEY2hPd0VDWnREUzBGNVVIeHhyVXNZSTVMMThCRkVuS2JQczBXNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748770570),('pn5UfbCDiHXVbs0HjMA4mbYl3YrV1Obz9mLIeLYc',NULL,'86.106.74.118','WanScannerBot/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjFxclYzelZLZkRXcTJPNzZoNjNFREFYOTNUaGt0aGlmWEFkdVg4bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748720030),('pOuzLV7YseEKCedQgpXCiOwGxBklRjjiwGJ15TpD',NULL,'195.3.221.137','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWllGcUpwaU1CZnQ4Mkpxa0dCbVFlWnR2a1I4eXN6WUM5c1VGZzBFRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748746774),('qHnCrkXTNZZBT5RxLo09cxTfMYQB3y6ANOHTTjkg',NULL,'185.242.226.116','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1hOTzlIYnRDVFpCZUJ2RVNuQ2ZmOXhvQXBVSmJWeDl2ejJuMGhnRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748729750),('qWP1fRmWkgq34LAFZDnei2OPIGiMR0XZjinahQUm',9,'10.10.10.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSXA1Q1RzVmNOTTdWNXlVSnlyek5KWnBmb0dRbEttbmlkZm5pRjgzcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vNGxiLmNhL2FkbWluL2NvdXJzLzIiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=',1748728717),('rIE3GbET9WkB4JVDZW0jH6djOtXGno9R5twHNtW9',NULL,'64.181.253.64','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnV3UmlUdUg2UDBPcXo2UHhQbXY1bkdtY3JPZFZqUFlYWDNMS2pxcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vMTUwLTU3Lm1jLmNjYXBjYWJsZS5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748719163),('s8oulcDnJqoclWko5oB1S6cnwmSIvKVFPR6ZRoaI',NULL,'185.242.226.80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiekxJZDY5SkRjeEd3OE1jT3diTVE5dkN3T1FUSFBPbzRnbHViUkNmMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748770570),('sHjbfFUdRkUi2rWnpoYvwS0iWstRctRSfELu2oyk',NULL,'43.130.34.74','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2lwbDNKTlpwTU5teHh3Q0ZQaDkzbWlhdmhVZDJ2a1Z6RTBnOURNcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748779748),('SXzjsWCMhP951IdEdejIZPhqyrxorusFEyZ2M3Pn',NULL,'64.181.253.64','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSk5Ia2dSbEkxYVBWMkdFVGE3U0FIZG9pdUxQT3NZT3JCaFhnMVAyMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748762530),('tFEgJpc9OWIw0utcWJh4CA149aYsHIINOPbma0l2',NULL,'43.130.34.74','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1luMWhzZ1pBNHFEWFZrUVFPUXVhRWxXWFNpTXJiWVRkcUx6ZEx4aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748779746),('tLIGgf8vRF1uZsDEL4p5sQqiBTwLiA3UbqnNEU0p',NULL,'190.107.95.183','Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/133.0.6943.120 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoicDlHeTdEZGpybEczZFlXcGdZRUxPQk0wUThmc05XeVNra1JOS3FUdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vd3d3LjRsYi5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748771810),('uMlAL19y8vEtyIL2odjsFZIU8OtKQHTlfd3jWi4K',NULL,'78.135.70.251','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUNEQWRYbDZubGdTa3NoWGJpWllhb01QNXRzS2thb3NEbm50TkFiUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vd3d3LjRsYi5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748771856),('UW735X2r15G13MzxwfhCntCcwb9GWJDObvDOiMGL',NULL,'45.156.128.45','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmlGV01wa0U4dmNOSXUxNko4MVFkTE1MNXJFeTlxbmFuazNaRFZpMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748738904),('v0IvllsSVbOVtJzu5HjBDVXZ9HGddh60iFt3EILg',NULL,'49.51.204.74','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoibE9yV0oyUXlsbHpnVGdRWGZQVnprb0RObVNKSEFxczNkejZDSlphMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748738517),('v0p0YQPSkA9Ubgy334sx4oJOlhGp1DPdl9XexVPY',NULL,'198.235.24.27','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFNsMDVHYTdYTDJocWlRQ3J0eU5aS0I5ZVB1cUw2NDdYb1NDZ3RZSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748766284),('whsxgvPdPZViUyiOLOEZa49EbllajSI0wJOAPAPX',9,'10.10.10.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoic3o2TWNBcFc2QVdTbkZheHBtakg1SkIwZ2RzQVhFVFFXdnVTY3FRcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vNGxiLmNhL2FkbWluL2NvdXJzLzEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=',1748724900),('WJHopnEYvLBgfGfGL3iuBt8d0hGS5fpOormBRG2A',NULL,'45.156.130.15','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXpTZVJDbktjOWFMNlF1WndLVFBXU1RBUHBwWWoxdWFKdnAwbk9PNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748717570),('WTcprHvUFvQJdMGUIuIyz4nIKFYBnqtJzxE9rxJK',NULL,'57.141.0.29','meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQVhkdng4aFBXb3hobkNTa25oQW14V3c4SnpINnlkSTQzb0NXWDZ2USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNGxiLmNhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748752025),('Xe26G8mJzOxfasnAb3gNxLaBFL1i8udTS54nQX7g',NULL,'86.106.74.118','WanScannerBot/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTHp0Z25VR1d2MlRscGxqM2IzaVlnY2UzbFFCWmVVdHBZM0g4b1ZFMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTQ6Imh0dHBzOi8vNGxiLmNhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748720035),('xHBqHqTAajKfD07qb3YB81UMtnysdnVqYWbtEgWM',NULL,'79.124.58.198','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoib0lCM1ZLZWFRc3RuY1JFdE1ldGRLSlZLa2VVTENtbmpXNFY2c2xNaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvP1hERUJVR19TRVNTSU9OX1NUQVJUPXBocHN0b3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748719992),('XkeQorxfMA1DnkTTHctQObcslDlmsNdXP5GF17Hk',NULL,'162.216.149.215','Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnhIaEZsNXg4cU5wNFZvZzJVMmVrc3FIaG9OUEYwdEdqV21iSU1DRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748757895),('xnq85wmBlE5avTs7KXzmKr52gsMEhwxwpZlulAHx',NULL,'79.124.58.198','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZFJpVm5vNm9uTmNHT1hCMlhKRWxOWEROajBpdnFWNVNRaUptNTNiQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748719992),('Y02iCxTw1Amo7NB5lLWtQ0dOFG94cT7NzukYMHmZ',NULL,'45.156.128.43','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoid3VGcXNuVWpnMncxb2FOUEpYYmJwMEUzV3poNWtWQjJTNUFwSEJmbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748719124),('y9AdgRlDJ21LBM2baNQhS4evSwUTUB7I4edCGyEN',9,'10.10.10.43','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUm1QZGVjQ3o2MjFLTlhqbER4Wk5sTEhMRDQ0b3VqYlZQN0lSMzBGcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vMTAuMTAuMTAuNDMvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=',1748726486),('yMD893ZCXh3O8cADBjCSkwqyayGnizVKsVgPZpYA',NULL,'51.159.23.43','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHhYTXpjZnNCZ25xeDdkZkFpWm5kZ2JjMGRtcFFFYXZPRDBvYmtPZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748718753),('YsZbmIZKB0M5IiEEtqaIa6pa4W2SbkIXy14tT38T',NULL,'3.143.33.63','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2FJNFRuMVhRUmdQSmxzcDJ6cDE5NUR2MXphVG9qdzFpOXpKTnBUYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748763846),('Z6K8drT7rmLCJIK0q719tu1avZKPGeZFmQMYcwK2',NULL,'209.38.46.178','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/118.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFIzOVNoUVl3ZjVYcmQ4THc3VnB5clFBckw5WlcwT2d0azlab0FNMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748775193),('zeS2NtTK4146TvuSX5PCtRruU96jvT4P7HYyO1Kl',NULL,'64.62.156.206','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieDF0QTBGTVNIVUVRVTNMWXBnY2pJYXRsT2VTNHM0ZWl6cHlGY0ZlbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748760690),('zGzweDuEu3i7AYNaoHBCIgyPAoK2I5hvYzOrhgvP',NULL,'65.49.1.136','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/110.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUpvZkxIMFExa0JSUllpRDZnUEExT21GUnpWT1VIekZKWnFMa29rdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748767799),('ZiZJyBMeUAGZFXpB490yr5RORAMoOe1pqCJoBtDq',NULL,'49.51.204.74','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoia3FxV0I1TGNlN2ZQZmtDN0o1UGZXN0kxeGJPZ1JhTXhBcjhWdGNsViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTcvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748738518),('ZpH2PEyAMQyKhpvSJMiUpwOGtDfRbLsxAboecj1z',NULL,'162.216.149.215','Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjdRdnpiM2xteWNjSHV5RFpFMDd1V0FoOExtV3lPY2RXWUNiZVJaSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vMjA3LjI1My4xNTAuNTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1748757894);
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
  `consentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consentable_id` bigint unsigned NOT NULL,
  `consent_type_id` bigint unsigned NOT NULL,
  `is_granted` tinyint(1) NOT NULL,
  `granted_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_consents_consentable_type_consentable_id_index` (`consentable_type`,`consentable_id`),
  KEY `user_consents_consent_type_id_foreign` (`consent_type_id`),
  CONSTRAINT `user_consents_consent_type_id_foreign` FOREIGN KEY (`consent_type_id`) REFERENCES `consent_types` (`id`)
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
  `sexe` enum('H','F','A') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_ecole_id_foreign` (`ecole_id`),
  CONSTRAINT `users_ecole_id_foreign` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'QC',NULL,NULL,NULL,'Admin','louis@4lb.ca','admin','superadmin',NULL,'$2y$12$OlVgL37N34zsIG/nZZIEt.mzB9zoVB1.CCspw3Vc2ueW/SU1kERRW',1,'BWToHVOcukHz6GGATGJz7qXyP1T6I8nxEC7bMPa9uK1htwlnIkzHxbGPm0GC','2025-05-29 18:17:20','2025-05-30 21:29:52','2025-05-30 21:29:52','10.10.10.43',0,NULL,'auto','fr'),(7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'QC',NULL,1,NULL,'Marie Dubois','marie.dubois@st-emile.ca','marie.dubois','admin',NULL,'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1,NULL,'2025-05-29 18:32:30','2025-05-29 18:32:30',NULL,NULL,0,NULL,'auto','fr'),(8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'QC',NULL,2,NULL,'Pierre Gagnon','pierre.gagnon@val-belair.ca','pierre.gagnon','admin',NULL,'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1,NULL,'2025-05-29 18:32:30','2025-05-29 18:32:30',NULL,NULL,0,NULL,'auto','fr'),(9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'QC',NULL,1,NULL,'Bobby Dios','test@test.ca','bobby.dios','admin',NULL,'$2y$12$GGW6HRgq/D3i3BRzzDTJuO4T8O8MviHWsWqIArwXr5OysgKMsH/nu',1,'xsouDZzMVJFJEc6smF1i0Cmhptoi7uwPJBmVCt1EIn6CCKnBEwEuxWofdHwe','2025-05-31 23:52:05','2025-05-31 23:53:52','2025-05-31 23:53:52','10.10.10.1',0,NULL,'auto','fr');
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

-- Dump completed on 2025-06-01  9:45:39
