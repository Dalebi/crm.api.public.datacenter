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
-- Table structure for table `corporate_address_data`
--

DROP TABLE IF EXISTS `corporate_address_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corporate_address_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `__contact` bigint unsigned DEFAULT NULL COMMENT 'Los campos comentados con __ estan por eliminarse ya que existe una tabla de contactos en la cual se hace la asociación de multiples contactos a la empresa.',
  `corporate_id` bigint unsigned NOT NULL,
  `__phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `__email` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exterior` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interior` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settlement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` smallint unsigned DEFAULT NULL,
  `state` tinyint unsigned DEFAULT NULL,
  `city` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `corporate_address_data`
--

LOCK TABLES `corporate_address_data` WRITE;
/*!40000 ALTER TABLE `corporate_address_data` DISABLE KEYS */;
INSERT INTO `corporate_address_data` VALUES (1,1,2318,'3315996582','alonsomoreno@racingmx.mx','Av de la Union\r\nCol Americana','3003','15','Americana','44324',1,15,153,NULL,'2024-09-25 00:38:28'),(2,NULL,2317,NULL,NULL,'null',NULL,NULL,NULL,NULL,1,6,NULL,'2024-09-25 01:41:35','2024-09-25 02:09:46'),(3,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,15,NULL,'2024-09-25 01:46:46','2024-09-25 01:51:05'),(4,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,15,NULL,'2024-09-25 01:52:37','2024-09-25 01:52:37'),(5,NULL,2317,NULL,NULL,'Acapulco',NULL,NULL,NULL,NULL,1,15,NULL,'2024-09-25 01:54:20','2024-09-25 01:54:51'),(6,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,15,NULL,'2024-09-25 01:57:03','2024-09-25 01:57:48'),(7,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,15,NULL,'2024-09-25 01:58:36','2024-09-25 01:58:36'),(8,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,NULL,'2024-09-25 02:03:13','2024-09-25 02:07:56'),(9,NULL,2317,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,NULL,'2024-09-25 02:08:40','2024-09-25 02:08:40');
/*!40000 ALTER TABLE `corporate_address_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-07 11:27:08
