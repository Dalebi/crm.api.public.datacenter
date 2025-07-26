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
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `paternal` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `maternal` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(105) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `comments` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'Emil','',NULL,'55889662211','ters@dewewo.com',NULL,1,'2024-09-23 23:24:05','2024-09-23 23:24:05'),(2,'Emil','',NULL,'55889662211','ters@dewewo.com',NULL,1,'2024-09-23 23:25:02','2024-09-23 23:25:02'),(3,'Emil','',NULL,'55889662211','ters@dewewo.com',NULL,1,'2024-09-23 23:35:49','2024-09-23 23:35:49'),(4,'Emil','',NULL,'55889662211','ters@dewewo.com',NULL,1,'2024-09-23 23:36:10','2024-09-23 23:36:10'),(5,'Emil','',NULL,'55889662211','ters@dewewo.com',NULL,1,'2024-09-23 23:36:49','2024-09-23 23:36:49'),(6,'Miere','',NULL,'59262311811','dewew@ewfewf.vom',NULL,1,'2024-09-23 23:54:08','2024-09-23 23:54:08'),(7,'Miere','',NULL,'59262311811','dewew@ewfewf.vom',NULL,1,'2024-09-23 23:54:50','2024-09-23 23:54:50'),(8,'Miere','',NULL,'59262311811','dewew@ewfewf.vom',NULL,1,'2024-09-23 23:58:58','2024-09-23 23:58:58'),(9,'EREWRW','',NULL,'594916','defwfw',NULL,1,'2024-09-24 00:09:45','2024-09-24 00:09:45'),(10,'Ttttttt','dqwdq','21313','25566663','dewoiii',NULL,1,'2024-09-24 00:10:13','2024-09-24 00:10:13'),(11,'Ttttttt','',NULL,'25566663434','dewoiii',NULL,1,'2024-09-24 00:44:46','2024-09-24 00:44:46'),(12,'Ttttttt','',NULL,'25566663434','dewoiii',NULL,1,'2024-09-24 00:45:02','2024-09-24 00:45:02'),(13,'Primera OP','','undefined','undefined','undefined',NULL,1,'2024-09-26 23:10:01','2024-09-26 23:10:01'),(14,'Primera OP','','undefined','undefined','undefined',NULL,1,'2024-09-26 23:10:25','2024-09-26 23:10:25'),(15,'RTF3221 C','','RTF3221','324242424242','undefined',NULL,1,'2024-10-04 00:33:42','2024-10-04 00:33:42'),(16,'CVF435667 C','','CVF435667','5666698888888','CVF435667@gmail.com',NULL,1,'2024-10-04 00:50:02','2024-10-04 00:50:02'),(17,'CVF435668 1','','CVF435668','454557777','CVF435668',NULL,1,'2024-10-04 00:55:03','2024-10-04 00:55:03'),(18,'YTR675675','','YTR675675','123343243242','YTR675675@gmail.com',NULL,1,'2024-10-04 01:09:21','2024-10-04 01:09:21');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
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
