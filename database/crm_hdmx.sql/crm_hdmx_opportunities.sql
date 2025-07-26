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
-- Table structure for table `opportunities`
--

DROP TABLE IF EXISTS `opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opportunities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `corporate_id` bigint NOT NULL,
  `contact_id` bigint DEFAULT NULL,
  `consultant_id` bigint DEFAULT NULL,
  `name` varchar(55) DEFAULT NULL,
  `status` enum('Nuevo','Interesado','Descartado','Cotizacion Enviada','Contratado','No Contratado') DEFAULT NULL,
  `quote_file` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opportunities`
--

LOCK TABLES `opportunities` WRITE;
/*!40000 ALTER TABLE `opportunities` DISABLE KEYS */;
INSERT INTO `opportunities` VALUES (1,1588,11,1,'Primera OP',NULL,NULL,1,'2024-09-26 17:16:25','2024-09-26 17:16:25'),(2,1843,13,1,'Primera OP',NULL,'',1,'2024-09-26 18:17:22','2024-09-27 19:59:12'),(3,776,13,1,'op 1',NULL,'public/quotes/2024/09/77620240927_201615.woff',1,'2024-09-26 19:04:20','2024-09-27 20:16:15'),(4,776,13,1,'op 1',NULL,NULL,1,'2024-09-26 19:24:32','2024-09-26 19:24:32'),(5,776,13,1,'op 1',NULL,NULL,1,'2024-09-26 19:25:17','2024-09-26 19:25:17'),(6,776,13,1,'op 1',NULL,NULL,1,'2024-09-26 19:27:10','2024-09-26 19:27:10'),(7,1191,8,1,'Oportunidad Quetal',NULL,NULL,1,'2024-09-26 20:20:00','2024-09-26 20:20:00'),(8,1191,8,1,'Oportunidad Quetal',NULL,NULL,1,'2024-09-26 20:20:44','2024-09-26 20:20:44'),(9,1191,8,1,'Oportunidad Quetal',NULL,'',1,'2024-09-27 15:14:04','2024-09-30 15:17:06'),(10,1191,8,1,'Miere 2',NULL,'',1,'2024-09-27 15:49:18','2024-09-27 19:58:15'),(11,764,14,1,'Oportunidad Zero',NULL,NULL,1,'2024-09-30 23:07:14','2024-09-30 23:07:14'),(12,764,14,1,'Oportunidad Zero','Interesado',NULL,1,'2024-09-30 23:07:27','2024-09-30 23:07:27'),(13,764,14,1,'Oportunidad Zero 1',NULL,NULL,1,'2024-09-30 23:09:13','2024-09-30 23:09:13'),(14,764,14,1,'Oportunidad Zero 2','Nuevo',NULL,1,'2024-09-30 23:13:10','2024-09-30 23:13:10'),(15,764,14,1,'Oportunidad Zero 3','Nuevo',NULL,1,'2024-09-30 23:14:04','2024-09-30 23:14:04'),(16,764,14,1,'Oportunidad Zero 4',NULL,NULL,1,'2024-09-30 23:16:44','2024-09-30 23:16:44'),(17,809,13,1,'E3','Contratado',NULL,1,'2024-10-02 16:41:16','2024-10-02 16:41:16'),(18,122,NULL,1,'E4','Contratado',NULL,1,'2024-10-02 16:47:38','2024-10-02 16:47:38'),(19,1933,14,1,'E8','Interesado',NULL,1,'2024-10-02 17:17:14','2024-10-02 17:17:14'),(20,97,13,1,'E9','Interesado',NULL,1,'2024-10-02 17:24:51','2024-10-02 17:24:51'),(21,17,11,1,'A1','Interesado','',1,'2024-10-02 17:50:12','2024-10-02 18:53:27'),(22,2078,13,1,'A2','Descartado','',1,'2024-10-02 17:51:06','2024-10-02 18:11:19'),(23,717,11,1,'Oportunidad `','Descartado','quotes/2024/10/71720241002_234632.txt',1,'2024-10-02 18:34:17','2024-10-02 23:46:32'),(24,1191,8,1,'Miere 2','Descartado','quotes/2024/10/119120241002_235012.txt',1,'2024-10-02 20:32:45','2024-10-02 23:50:12'),(25,0,18,1,'YTR675675',NULL,NULL,1,'2024-10-03 19:09:21','2024-10-03 19:09:21');
/*!40000 ALTER TABLE `opportunities` ENABLE KEYS */;
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
