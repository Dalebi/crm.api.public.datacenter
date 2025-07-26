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
-- Table structure for table `cpus`
--

DROP TABLE IF EXISTS `cpus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cpus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_disk_1` int unsigned NOT NULL,
  `id_disk_2` int unsigned DEFAULT NULL,
  `id_public_port` int unsigned NOT NULL,
  `id_transfer` int unsigned NOT NULL,
  `id_data_center` int unsigned NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cpus_id_disk_1_cpu_foreign` (`id_disk_1`),
  KEY `cpus_id_disk_2_cpu_foreign` (`id_disk_2`),
  KEY `cpus_id_public_port_cpu_foreign` (`id_public_port`),
  KEY `cpus_id_transfer_cpu_foreign` (`id_transfer`),
  KEY `cpus_id_data_center_cpu_foreign` (`id_data_center`),
  CONSTRAINT `cpus_id_data_center_cpu_foreign` FOREIGN KEY (`id_data_center`) REFERENCES `data_centers` (`id`),
  CONSTRAINT `cpus_id_disk_1_cpu_foreign` FOREIGN KEY (`id_disk_1`) REFERENCES `disks` (`id`),
  CONSTRAINT `cpus_id_disk_2_cpu_foreign` FOREIGN KEY (`id_disk_2`) REFERENCES `disks` (`id`),
  CONSTRAINT `cpus_id_public_port_cpu_foreign` FOREIGN KEY (`id_public_port`) REFERENCES `public_ports` (`id`),
  CONSTRAINT `cpus_id_transfer_cpu_foreign` FOREIGN KEY (`id_transfer`) REFERENCES `transfers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpus`
--

LOCK TABLES `cpus` WRITE;
/*!40000 ALTER TABLE `cpus` DISABLE KEYS */;
INSERT INTO `cpus` VALUES (2,'Intel Atom D510 Dual-Core 1.6GHz w/HT (4 threads)','2190',5,15,4,8,1,1,'2018-06-15 17:36:39','2023-04-27 17:52:22'),(3,'Intel Core i3-2120 Dual-Core 3.3 Ghz w/HT (4 threads)','2690',5,15,4,8,1,1,'2018-06-19 20:06:44','2022-12-22 18:23:56'),(4,'Intel Xeon E3-1230 v5 Quad-Core 3.4GHz w/HT (8 threads)','3790',5,15,4,9,1,1,'2018-06-19 20:08:25','2022-12-22 18:34:48'),(5,'Intel Xeon E3-1270 v5 Quad-Core 3.6GHz w/HT (8 threads)','4390',5,15,4,9,1,1,'2018-06-19 20:09:32','2022-12-22 18:34:20'),(6,'2x 6-Core E5-2620 v3 2.4GHz w/HT (24 threads)','8290',5,15,4,9,1,1,'2018-06-19 20:12:14','2022-12-22 18:37:52'),(7,'2x 8-Core E5-2620 v4 2.1GHz w/HT (32 threads)','9690',5,15,4,9,1,1,'2018-06-19 20:14:56','2022-12-22 18:37:33'),(8,'2x 10-Core E5-2630 v4 2.2GHz w/HT (40 threads)','13490',5,15,4,9,1,1,'2018-06-19 20:16:45','2022-12-22 18:45:17'),(9,'2x 12-core Xeon E5-2650 V4 2.2GHz w/HT (48 threads)','16990',5,15,4,9,1,1,'2018-06-19 20:19:10','2022-12-22 19:45:55'),(10,'2x 14-core Xeon E5-2660 V4 2.3GHz w/HT (56 threads)','19590',5,15,4,9,1,1,'2018-06-19 20:20:49','2022-12-22 20:05:22'),(11,'2x 16-core Xeon E5-2683 V4 2.1GHz w/HT (64 threads)','23690',5,15,4,9,1,1,'2018-06-19 20:36:24','2022-12-22 20:17:43'),(12,'2x 18-core Xeon E5-2695 V4 2.1GHz w/HT (72 threads)','28590',5,15,4,9,1,1,'2018-06-19 20:37:17','2022-12-22 20:21:29'),(13,'Intel Atom D510 Dual-Core 1.6GHz w/HT (4 threads) **NO DISPONIBLE**','2190',5,15,5,14,2,1,'2018-06-19 20:46:04','2023-01-13 18:40:45'),(14,'Intel Core i3-2120 Dual-Core 3.3 Ghz w/HT (4 threads)','2690',5,15,5,14,2,1,'2018-06-19 21:01:25','2022-12-15 15:57:36'),(15,'Intel Xeon X3440 Quad-Core 2.5GHz w/HT (8 threads)','2990',5,15,5,14,2,1,'2018-06-19 21:21:05','2022-12-22 20:36:14'),(16,'Single Xeon E3-1230 Quad-Core 3.2GHz w/HT (8 threads) **NO DISPONIBLE**','3290',5,15,5,14,2,1,'2018-06-19 21:27:06','2023-01-13 18:43:01'),(17,'Single Xeon E3-1231 v3 Quad-Core 3.4GHz w/HT (8 threads)','3790',5,15,5,14,2,1,'2018-06-19 21:32:12','2022-12-22 20:30:23'),(18,'Single Xeon E3-1271 v3 Quad-Core 3.6GHz w/HT (8 threads)','4390',5,15,5,14,2,1,'2018-06-19 21:40:24','2022-12-22 20:38:38'),(19,'2x Hexa-Core E5-2609 v3 1.9GHz (12 cores)','5490',5,15,5,14,2,1,'2018-06-19 21:50:25','2022-12-22 20:39:42'),(20,'2x Quad-Core E-5520 2.26GHz w/HT (16 threads)  **NO DISPONIBLE**','6490',5,15,5,14,2,1,'2018-06-21 17:55:12','2023-02-09 21:51:55'),(21,'2x 6-Core E5-2620 v2 2.1GHz w/HT (24 threads)','8290',5,15,5,14,2,1,'2018-06-21 17:59:21','2022-12-22 20:45:13'),(22,'2x 6-Core E5-2620 v3 2.4GHz w/HT (24 threads)','8790',5,15,5,14,2,1,'2018-06-21 18:01:44','2022-12-22 20:44:12'),(23,'2x 8-Core E5-2620 v4 2.1GHz w/HT (32 threads)','9690',5,15,5,14,2,1,'2018-06-21 18:19:42','2022-12-22 20:47:21'),(24,'2x 8-Core E5-2650 V2 2.6GHz w/HT (32 threads)','10690',5,15,5,14,2,1,'2018-06-21 18:23:35','2022-12-22 20:49:00'),(25,'2 x Octo-Core E5-2640 V2 2.0GHz w/HT (32 threads)','10190',5,15,5,14,2,1,'2018-07-20 16:05:25','2022-12-22 20:49:55'),(26,'2x 10-Core E5-2630 v4 2.2GHz w/HT (40 threads)','13490',5,15,5,14,2,1,'2018-07-20 16:07:49','2022-12-22 20:51:03'),(27,'2x 12-core Xeon E5-2650 v4 2.2GHz w/HT (48 threads)','16990',5,15,6,14,2,1,'2018-07-20 16:09:17','2023-01-18 20:44:37'),(28,'2x 14-core Xeon E5-2660 v4 2.3GHz w/HT (56 threads)','19590',5,15,5,14,2,1,'2019-01-09 20:42:20','2022-12-22 20:53:07'),(29,'2x 16-core Xeon E5-2683 v4 2.1GHz w/HT (64 threads)','23690',5,15,5,14,2,1,'2019-01-09 21:21:57','2022-12-22 20:55:15');
/*!40000 ALTER TABLE `cpus` ENABLE KEYS */;
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
