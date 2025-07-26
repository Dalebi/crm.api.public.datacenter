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
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_type_service` int unsigned NOT NULL,
  `id_data_center` int unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_id_type_service_service_foreign` (`id_type_service`),
  KEY `services_id_data_center_service_foreign` (`id_data_center`),
  CONSTRAINT `services_id_data_center_service_foreign` FOREIGN KEY (`id_data_center`) REFERENCES `data_centers` (`id`),
  CONSTRAINT `services_id_type_service_service_foreign` FOREIGN KEY (`id_type_service`) REFERENCES `type_services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (8,'Switch HP ProCurve 48 x Port Gigabit 10/100/1000',4,1,1,'2018-04-27 17:50:30','2022-05-23 22:54:45'),(9,'uVPS Mini',1,1,1,'2018-04-27 18:14:07','2024-04-25 01:51:11'),(14,'Colocación 1U',3,1,1,'2018-05-10 16:36:24','2021-04-27 20:10:33'),(15,'uVPS 1',1,1,1,'2018-05-10 16:54:01','2018-06-22 18:13:11'),(17,'uVPS 2',1,1,1,'2018-06-12 21:27:46','2018-06-22 18:13:18'),(18,'uVPS 3',1,1,1,'2018-06-12 21:31:12','2018-06-22 18:13:25'),(19,'Linux VPS1 (Administrado)',1,1,1,'2018-06-12 21:40:35','2019-11-07 19:48:58'),(20,'Linux VPS2 (Administrado)',1,1,1,'2018-06-12 21:52:44','2019-11-07 19:49:47'),(21,'Colocación 2U',3,1,1,'2018-06-13 20:21:14','2021-04-27 20:11:22'),(22,'Colocación 3U',3,1,1,'2018-06-13 20:22:38','2021-04-27 20:12:14'),(23,'Medio Rack 21U',3,1,1,'2018-06-13 20:25:39','2018-07-05 18:43:19'),(24,'Rack Completo 42U',3,1,1,'2018-06-13 20:28:03','2018-07-05 18:39:17'),(25,'Colocación 1U - México',3,2,1,'2018-06-13 20:29:55','2023-07-19 22:37:58'),(26,'Colocación 2U - México',3,2,1,'2018-06-13 20:31:21','2023-07-31 20:28:58'),(27,'Colocación 3U - México',3,2,1,'2018-06-13 20:32:38','2023-07-31 20:29:36'),(28,'Switch Juniper EX3300-48T',4,1,1,'2018-06-20 15:48:26','2021-09-13 18:46:43'),(29,'Switch HP ProCurve 48 x Port Gigabit 10/100/1000',4,2,1,'2018-06-20 15:49:33','2022-06-13 18:04:21'),(30,'Firewall Físico Juniper SRX210HE2 (gigE port / 850mbps throughput)',2,1,1,'2018-06-20 21:35:01','2018-06-20 21:35:01'),(31,'Firewall Físico Juniper SRX220H2 (gigE port / 950mbps throughput)',2,1,1,'2018-06-20 21:35:59','2018-06-20 21:35:59'),(32,'Firewall Físico Juniper SRX240H2 (gigE port / 1.8Gbps throughput)',2,1,1,'2018-06-20 21:36:41','2018-06-20 21:36:41'),(33,'Managed NGFW FortiGate 40F - México',2,2,1,'2018-06-20 21:38:14','2024-03-08 16:24:28'),(34,'Managed NGFW FortiGate 60F - México',2,2,1,'2018-06-20 21:38:45','2024-03-08 16:26:47'),(35,'Managed NGFW FortiGate 80F - México',2,2,1,'2018-06-20 21:40:08','2024-03-08 16:44:49'),(36,'Linux VPS3 (Administrado)',1,1,1,'2018-06-21 15:53:51','2019-11-07 19:59:38'),(37,'Windows VPS1 (Administrado)',1,1,1,'2018-06-21 16:02:18','2021-11-11 19:09:01'),(38,'Windows VPS2 (Administrado)',1,1,1,'2018-06-21 16:08:40','2021-11-11 19:11:12'),(39,'Windows VPS3 (Administrado)',1,1,1,'2018-06-21 16:52:23','2021-11-11 19:09:50'),(40,'Cloud VPS1 - México',1,2,1,'2018-06-21 17:01:29','2024-03-04 15:57:48'),(41,'Cloud VPS2 - México',1,2,1,'2018-06-21 17:16:03','2024-03-04 15:57:54'),(42,'Cloud VPS3 - México',1,2,1,'2018-06-21 17:19:29','2024-06-12 02:26:37'),(43,'Cloud VPS4 - México',1,2,1,'2018-06-21 17:21:12','2024-03-04 15:58:05'),(44,'Cloud VPS1 - México (Administrado)',1,2,1,'2018-06-21 17:30:19','2024-03-04 16:32:19'),(45,'Cloud VPS2 - México (Administrado)',1,2,1,'2018-06-21 17:34:55','2024-03-04 16:32:26'),(46,'Cloud VPS3 - México (Administrado)',1,2,1,'2018-06-21 17:37:08','2024-03-04 16:32:33'),(47,'Colocación 4U - México',3,2,1,'2018-06-25 17:14:21','2023-07-31 20:50:50'),(48,'Colocación 5U - México',3,2,1,'2018-06-25 17:26:33','2023-07-31 20:54:13'),(49,'Medio Rack 21U',3,2,1,'2018-07-05 19:00:30','2022-03-01 16:20:01'),(50,'Rack Completo 42U - México',3,2,1,'2018-07-05 19:06:45','2023-05-09 18:52:37'),(51,'Colocación 1U (Appliance)',3,2,1,'2018-07-10 14:37:29','2021-06-14 17:52:22'),(52,'Cloud VPS4 - México (Administrado)',1,2,1,'2018-10-11 20:26:08','2024-04-03 19:21:50'),(55,'Colocación 2U (Appliance)',3,2,1,'2018-11-30 16:11:07','2021-10-20 19:35:12'),(58,'1/4 de Rack 10U',3,2,1,'2019-08-05 21:16:23','2022-03-01 16:29:20'),(59,'Switch Juniper QFX3500-48S4Q',4,2,1,'2022-05-30 17:14:22','2022-05-30 17:14:22'),(60,'Cloud VPS1 - México',1,2,1,'2024-04-18 05:47:14','2024-04-18 05:47:14'),(61,'Colocación 1U',3,1,1,'2024-04-24 00:18:03','2024-04-24 00:18:03'),(62,'Colocación 1U',3,1,1,'2024-04-24 02:54:03','2024-04-24 02:54:03'),(63,'Colocación 1U',3,1,1,'2024-04-24 02:54:16','2024-04-24 02:54:16'),(64,'Colocación 1U',3,1,1,'2024-04-24 02:55:34','2024-04-24 02:55:34'),(65,'Colocación 1U',3,1,1,'2024-04-25 00:43:27','2024-04-25 00:43:27'),(66,'Colocación 1U',3,1,1,'2024-04-25 00:45:40','2024-04-25 00:45:40'),(67,'uVPS Mini',1,2,1,'2024-04-25 01:11:07','2024-04-25 01:11:07'),(68,'uVPS Mini',1,2,0,'2024-04-25 01:15:55','2024-04-25 01:15:55');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
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
