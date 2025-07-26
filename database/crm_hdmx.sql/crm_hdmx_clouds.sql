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
-- Table structure for table `clouds`
--

DROP TABLE IF EXISTS `clouds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clouds` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `key` enum('cpu','ram','disco_principal','disco_respaldo','ipv4','bw_entrada','bw_salida','auto_escalable') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(16,8) NOT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `included` int NOT NULL,
  `id_data_center` int unsigned NOT NULL,
  `active` tinyint unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cloud_id_data_center_cloud_foreign` (`id_data_center`),
  CONSTRAINT `cloud_id_data_center_cloud_foreign` FOREIGN KEY (`id_data_center`) REFERENCES `data_centers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clouds`
--

LOCK TABLES `clouds` WRITE;
/*!40000 ALTER TABLE `clouds` DISABLE KEYS */;
INSERT INTO `clouds` VALUES (1,'cpu','CPUs virtuales',0.36164384,'vCPU',0,1,1,'2021-06-25 19:06:12','2024-06-14 00:46:03'),(2,'ram','Memoria RAM',0.06027398,'GB',0,1,1,'2021-06-25 19:06:12','2021-06-25 19:06:12'),(3,'disco_principal','Almacenamiento principal SSD',0.00452055,'GB',0,1,1,'2021-06-25 19:06:12','2021-08-10 16:33:11'),(4,'disco_respaldo','Almacenamiento p/respaldos SATA',0.00150685,'GB',0,1,1,'2021-06-25 19:06:12','2021-08-10 16:33:39'),(5,'auto_escalable','Auto-escalable',1.50684932,'',0,1,1,'2021-06-25 19:06:12','2021-06-25 19:06:12'),(6,'ipv4','IPv4 Dedicada',0.30136987,'IP',1,1,1,'2021-06-25 19:06:12','2021-08-10 16:35:43'),(7,'bw_entrada','Ancho de banda mensual de entrada',0.00000000,'TB',0,1,1,'2021-06-25 19:06:12','2021-08-10 16:34:23'),(8,'bw_salida','Ancho de banda mensual de salida',0.22000000,'TB',10,1,1,'2021-06-25 19:06:12','2021-08-10 16:34:35'),(9,'cpu','CPUs virtuales',0.48219179,'vCPU',0,2,1,'2021-06-25 19:06:12','2021-06-25 19:06:12'),(10,'ram','Memoria RAM',0.09041096,'GB',0,2,1,'2021-06-25 19:06:12','2021-06-25 19:06:12'),(11,'disco_principal','Almacenamiento principal SSD',0.00602740,'GB',0,2,1,'2021-06-25 19:06:12','2021-08-10 16:34:48'),(12,'disco_respaldo','Almacenamiento p/respaldos SATA',0.00210959,'GB',0,2,1,'2021-06-25 19:06:12','2021-08-10 16:35:05'),(13,'auto_escalable','Auto-escalable',1.50684932,'',0,2,1,'2021-06-25 19:06:12','2021-06-25 19:06:12'),(14,'ipv4','IPv4 Dedicada',0.45205480,'IP',1,2,1,'2021-06-25 19:06:12','2021-08-10 16:35:36'),(15,'bw_entrada','Ancho de banda mensual de entrada',0.00000000,'TB',0,2,1,'2021-06-25 19:06:12','2021-08-10 16:35:14'),(16,'bw_salida','Ancho de banda mensual de salida',0.44000000,'TB',10,2,1,'2021-06-25 19:06:12','2021-08-10 16:35:19');
/*!40000 ALTER TABLE `clouds` ENABLE KEYS */;
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
