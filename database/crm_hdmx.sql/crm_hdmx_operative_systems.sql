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
-- Table structure for table `operative_systems`
--

DROP TABLE IF EXISTS `operative_systems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operative_systems` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `active` tinyint unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operative_systems`
--

LOCK TABLES `operative_systems` WRITE;
/*!40000 ALTER TABLE `operative_systems` DISABLE KEYS */;
INSERT INTO `operative_systems` VALUES (1,'CentOS 7.x (64 Bit)',0,1,'2018-05-10 15:58:00','2019-01-29 16:11:02'),(2,'AlmaLinux 8',0,1,'2018-06-08 20:58:38','2022-11-02 16:14:16'),(3,'FreeBSD (Ultima versión)',0,1,'2018-06-08 20:58:50','2018-06-08 20:58:50'),(4,'Debian (Ultima versión)',0,1,'2018-06-08 20:59:19','2018-06-08 20:59:19'),(5,'Fedora Core (Ultima versión)',0,1,'2018-06-08 20:59:26','2022-11-02 16:14:34'),(6,'Ubuntu (Ultima versión)',0,1,'2018-06-08 20:59:40','2018-06-08 20:59:40'),(7,'Windows Server 2016 Standard (64bit)',650,1,'2018-06-08 21:00:15','2021-03-10 19:45:12'),(8,'Windows Server 2016 Datacenter (64bit)',3000,1,'2018-06-08 21:00:30','2021-03-10 19:45:23'),(9,'Windows Server 2019 Standard (64bit)',650,1,'2018-07-09 18:04:40','2021-03-10 19:44:51'),(10,'Windows Server 2019 Datacenter (64bit)',3000,1,'2018-07-09 18:04:59','2021-03-10 19:45:00'),(11,'Instalado por el cliente (IPMI)',0,1,'2018-12-04 17:45:05','2018-12-04 17:45:05'),(12,'TrueNAS CORE',0,1,'2019-01-21 16:07:43','2021-11-17 23:19:28'),(13,'VMware ESXi (No incluye licenciamiento)',0,1,'2022-02-15 18:34:52','2022-02-15 18:34:52');
/*!40000 ALTER TABLE `operative_systems` ENABLE KEYS */;
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
