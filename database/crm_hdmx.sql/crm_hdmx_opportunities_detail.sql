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
-- Table structure for table `opportunities_detail`
--

DROP TABLE IF EXISTS `opportunities_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opportunities_detail` (
  `opportunity_id` bigint unsigned NOT NULL,
  `folio` tinyint unsigned NOT NULL COMMENT 'Cada detalle del seguimiento puede tener hasta 256 interacciones.',
  `description` varchar(45) DEFAULT NULL,
  `active` tinyint unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opportunities_detail`
--

LOCK TABLES `opportunities_detail` WRITE;
/*!40000 ALTER TABLE `opportunities_detail` DISABLE KEYS */;
INSERT INTO `opportunities_detail` VALUES (8,1,'Oportunidad Quetal',1,'2024-09-27 02:20:44','2024-09-27 02:20:44'),(9,1,'Paso 1',1,'2024-09-27 21:14:04','2024-09-27 21:14:04'),(10,1,'undefined',1,'2024-09-27 21:49:18','2024-09-27 21:49:18'),(9,2,'Paso 2',1,'2024-09-30 06:00:00','2024-09-30 06:00:00'),(9,3,'Paso 3',1,'2024-09-30 22:46:56','2024-09-30 22:46:56'),(9,4,'Paso 4',1,'2024-09-30 23:00:58','2024-09-30 23:00:58'),(11,1,'Alta',1,'2024-10-01 05:07:14','2024-10-01 05:07:14'),(12,1,'Nueva oportunidad zero',1,'2024-10-01 05:07:27','2024-10-01 05:07:27'),(13,1,'Zero 1',1,'2024-10-01 05:09:13','2024-10-01 05:09:13'),(14,1,'Zero 2',1,'2024-10-01 05:13:10','2024-10-01 05:13:10'),(15,1,'Z3',1,'2024-10-01 05:14:04','2024-10-01 05:14:04'),(16,1,'Zero 4',1,'2024-10-01 05:16:44','2024-10-01 05:16:44'),(17,1,'E3',1,'2024-10-02 22:41:16','2024-10-02 22:41:16'),(18,1,'E4',1,'2024-10-02 22:47:38','2024-10-02 22:47:38'),(19,1,'E8',1,'2024-10-02 23:17:14','2024-10-02 23:17:14'),(20,1,'E9',1,'2024-10-02 23:24:51','2024-10-02 23:24:51'),(21,1,'A1',1,'2024-10-02 23:50:12','2024-10-02 23:50:12'),(22,1,'A2',1,'2024-10-02 23:51:06','2024-10-02 23:51:06'),(22,2,'A2 .1',1,'2024-10-03 00:11:19','2024-10-03 00:11:19'),(22,3,'A2.2',1,'2024-10-03 00:11:27','2024-10-03 00:11:27'),(23,1,'Primer contacto',1,'2024-10-03 00:34:17','2024-10-03 00:34:17'),(23,2,'Segundo Contacto',1,'2024-10-03 00:34:58','2024-10-03 00:34:58'),(23,3,'+Se agrega cotizacion',1,'2024-10-03 00:35:21','2024-10-03 00:35:21'),(21,2,'Paso 2',1,'2024-10-03 00:53:27','2024-10-03 00:53:27'),(24,1,'Nuevo registro',1,'2024-10-03 02:32:46','2024-10-03 02:32:46'),(9,5,'Paso 5',1,'2024-10-03 02:37:34','2024-10-03 02:37:34'),(23,4,'Tercer Contacto',1,'2024-10-03 05:02:16','2024-10-03 05:02:16'),(23,5,'undefined',1,'2024-10-03 05:38:47','2024-10-03 05:38:47'),(23,6,'undefined',1,'2024-10-03 05:41:37','2024-10-03 05:41:37'),(23,7,'undefined',1,'2024-10-03 05:42:45','2024-10-03 05:42:45'),(23,8,'undefined',1,'2024-10-03 05:44:33','2024-10-03 05:44:33'),(23,9,'undefined',1,'2024-10-03 05:46:32','2024-10-03 05:46:32'),(24,2,'undefined',1,'2024-10-03 05:50:12','2024-10-03 05:50:12'),(9,6,'Paso 6',1,'2024-10-05 04:51:59','2024-10-05 04:51:59');
/*!40000 ALTER TABLE `opportunities_detail` ENABLE KEYS */;
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
