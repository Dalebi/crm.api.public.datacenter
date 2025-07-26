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
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `id_data_center` int unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_id_data_center_transfer_foreign` (`id_data_center`),
  CONSTRAINT `transfers_id_data_center_transfer_foreign` FOREIGN KEY (`id_data_center`) REFERENCES `data_centers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfers`
--

LOCK TABLES `transfers` WRITE;
/*!40000 ALTER TABLE `transfers` DISABLE KEYS */;
INSERT INTO `transfers` VALUES (8,'30Mbps (~10TB)x',0,1,1,'2018-06-12 17:06:43','2024-03-15 03:58:21'),(9,'45Mbps (~15TB)',500,1,1,'2018-06-12 17:07:36','2018-06-12 17:16:04'),(10,'60Mbps (~20TB)',1000,1,1,'2018-06-12 17:08:30','2018-06-12 17:16:09'),(11,'100 Mbps',1800,1,1,'2018-06-12 17:11:21','2018-07-09 18:13:09'),(12,'350 Mbps (burstable 1Gbps)',4500,1,1,'2018-06-12 17:12:36','2019-10-02 17:20:50'),(13,'1,000 Mbps (burstable 1Gbps)',12500,1,1,'2018-06-12 17:14:32','2019-10-02 17:23:58'),(14,'30Mbps (~10TB)',0,2,1,'2018-06-12 17:24:00','2022-02-09 22:22:41'),(18,'40Mbps Ancho de Banda Mensual Premium',5000,2,1,'2018-06-12 20:45:32','2022-06-13 18:06:34'),(19,'50Mbps Ancho de Banda Mensual Premium',10000,2,1,'2018-06-12 20:46:25','2022-06-13 18:06:21'),(20,'200 Mbps (burstable 1Gbps)',2500,1,1,'2018-07-13 15:04:31','2018-07-13 15:04:31'),(21,'75Mbps Ancho de Banda Mensual Premium',22500,2,1,'2019-02-28 20:47:51','2022-06-13 18:06:41'),(22,'100Mbps (burstable 1Gbps)',28000,2,1,'2020-01-06 19:57:26','2022-02-10 14:25:41'),(23,'250 Mbps (burstable 1Gbps)',66000,2,1,'2020-01-06 19:59:05','2022-02-10 14:22:54'),(24,'500 Mbps (burstable 1Gbps)',141000,2,1,'2020-01-06 20:01:28','2022-02-10 14:25:24');
/*!40000 ALTER TABLE `transfers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-07 11:27:09
