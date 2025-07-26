-- MySQL dump 10.13  Distrib 8.0.34, for macos13 (x86_64)
--
-- Host: 127.0.0.1    Database: crm_hdmx
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `collaborator_catalog_data`
--

DROP TABLE IF EXISTS `collaborator_catalog_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collaborator_catalog_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `collaborator_id` bigint unsigned NOT NULL,
  `collaborator_catalog_id` bigint unsigned NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collaborator_catalog_data_collaborator_id_foreign` (`collaborator_id`),
  KEY `collaborator_catalog_data_collaborator_catalog_id_foreign` (`collaborator_catalog_id`),
  CONSTRAINT `collaborator_catalog_data_collaborator_catalog_id_foreign` FOREIGN KEY (`collaborator_catalog_id`) REFERENCES `collaborator_catalogs` (`id`),
  CONSTRAINT `collaborator_catalog_data_collaborator_id_foreign` FOREIGN KEY (`collaborator_id`) REFERENCES `collaborators` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborator_catalog_data`
--

LOCK TABLES `collaborator_catalog_data` WRITE;
/*!40000 ALTER TABLE `collaborator_catalog_data` DISABLE KEYS */;
INSERT INTO `collaborator_catalog_data` VALUES (19,3,1,'Steel Edward','2024-05-31 00:46:01','2024-05-31 00:46:01'),(20,3,2,'George','2024-05-31 00:46:01','2024-05-31 00:46:01'),(21,3,3,'Vázquez','2024-05-31 00:46:01','2024-05-31 00:46:01'),(22,3,4,'3334691505','2024-05-31 00:46:01','2024-05-31 00:46:01'),(23,3,5,'3334691505','2024-05-31 00:46:01','2024-05-31 00:46:01');
/*!40000 ALTER TABLE `collaborator_catalog_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-07 11:27:10
