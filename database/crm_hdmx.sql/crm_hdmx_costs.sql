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
-- Table structure for table `costs`
--

DROP TABLE IF EXISTS `costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `costs` (
  `id` int DEFAULT NULL COMMENT 'Esta tabla esta duplicada con prices, esta ultima es la que se utiliza, por lo tanto la tabla cost se podría eliminar',
  `table` text,
  `id_service` int DEFAULT NULL,
  `label` text,
  `cost` double DEFAULT NULL,
  `created_at` text,
  `updated_at` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costs`
--

LOCK TABLES `costs` WRITE;
/*!40000 ALTER TABLE `costs` DISABLE KEYS */;
INSERT INTO `costs` VALUES (46,'service',25,'Mensual',2990,'2024-02-22 14:40:32','2024-02-22 14:40:32'),(47,'service',25,'Semestral',17000,'2024-02-22 14:40:32','2024-02-22 14:40:32'),(48,'service',25,'Anual',30000,'2024-02-22 14:40:32','2024-02-22 14:40:32'),(49,'service',17,'Mensual',50,'2024-02-22 14:48:23','2024-02-22 14:48:23'),(58,'service',29,'Mensual',2500,'2024-02-23 14:39:33','2024-02-23 14:39:33'),(59,'service',29,'Semestral',17000,'2024-02-23 14:39:33','2024-02-23 14:39:33'),(60,'service',29,'Anual',25000,'2024-02-23 14:39:33','2024-02-23 14:39:33'),(67,'panel',2,'Mensual',1250,'2024-02-23 16:05:29','2024-02-23 16:05:29'),(68,'panel',2,'Semestral',7000,'2024-02-23 16:05:29','2024-02-23 16:05:29'),(69,'panel',2,'Anual',12500,'2024-02-23 16:05:29','2024-02-23 16:05:29'),(71,'addon',1,'Mensual',100,'2024-02-23 17:29:09','2024-02-23 17:29:09'),(72,'addon',1,'Semestral',500,'2024-02-23 17:29:09','2024-02-23 17:29:09'),(73,'addon',1,'Anual',1000,'2024-02-23 17:29:09','2024-02-23 17:29:09'),(74,'addon',38,'Mensual',100,'2024-02-26 13:14:04','2024-02-26 13:14:04'),(75,'addon',38,'Semestral',500,'2024-02-26 13:14:04','2024-02-26 13:14:04'),(76,'addon',38,'Anual',1000,'2024-02-26 13:14:04','2024-02-26 13:14:04'),(77,'addon',144,'Mensual',100,'2024-02-27 10:05:48','2024-02-27 10:05:48'),(78,'addon',144,'Semestral',500,'2024-02-27 10:05:48','2024-02-27 10:05:48'),(79,'addon',144,'Anual',1000,'2024-02-27 10:05:48','2024-02-27 10:05:48'),(80,'addon',59,'Mensual',100,'2024-02-27 11:33:13','2024-02-27 11:33:13'),(81,'addon',59,'Semestral',500,'2024-02-27 11:33:13','2024-02-27 11:33:13'),(82,'addon',59,'Anual',1000,'2024-02-27 11:33:13','2024-02-27 11:33:13'),(86,'addon',90,'Mensual',500,'2024-02-27 13:07:17','2024-02-27 13:07:17'),(87,'addon',90,'Semestral',3000,'2024-02-27 13:07:17','2024-02-27 13:07:17'),(88,'addon',90,'Anual',5500,'2024-02-27 13:07:17','2024-02-27 13:07:17'),(89,'addon',18,'Mensual',5000,'2024-02-27 13:41:19','2024-02-27 13:41:19'),(90,'addon',18,'Semestral',25000,'2024-02-27 13:41:19','2024-02-27 13:41:19'),(91,'addon',18,'Anual',50000,'2024-02-27 13:41:19','2024-02-27 13:41:19'),(93,'transfer',18,'Mensual',5000,'2024-02-27 13:42:51','2024-02-27 13:42:51'),(94,'transfer',18,'Semestral',25000,'2024-02-27 13:42:51','2024-02-27 13:42:51'),(95,'transfer',18,'Anual',50000,'2024-02-27 13:42:51','2024-02-27 13:42:51'),(96,'addon',127,'Mensual',500,'2024-02-27 14:31:51','2024-02-27 14:31:51'),(97,'addon',127,'Semestral',2500,'2024-02-27 14:31:52','2024-02-27 14:31:52'),(98,'addon',127,'Anual',5500,'2024-02-27 14:31:52','2024-02-27 14:31:52'),(102,'addon',170,'Mensual',350,'2024-03-01 13:28:39','2024-03-01 13:28:39'),(103,'addon',170,'Semestral',2000,'2024-03-01 13:28:39','2024-03-01 13:28:39'),(104,'addon',170,'Anual',4200,'2024-03-01 13:28:39','2024-03-01 13:28:39'),(105,'addon',62,'Mensual',250,'2024-03-01 13:29:17','2024-03-01 13:29:17'),(106,'addon',62,'Semestral',1200,'2024-03-01 13:29:17','2024-03-01 13:29:17'),(107,'addon',62,'Anual',3000,'2024-03-01 13:29:17','2024-03-01 13:29:17'),(150,'service',40,'Mensual',940,'2024-03-04 10:18:45','2024-03-04 10:18:45'),(151,'service',40,'Semestral',5640,'2024-03-04 10:18:45','2024-03-04 10:18:45'),(152,'service',40,'Anual',9400,'2024-03-04 10:18:45','2024-03-04 10:18:45'),(165,'service',44,'Mensual',1440,'2024-03-04 10:32:19','2024-03-04 10:32:19'),(166,'service',44,'Semestral',8640,'2024-03-04 10:32:19','2024-03-04 10:32:19'),(167,'service',44,'Anual',14400,'2024-03-04 10:32:19','2024-03-04 10:32:19'),(168,'service',45,'Mensual',2040,'2024-03-04 10:32:26','2024-03-04 10:32:26'),(169,'service',45,'Semestral',12240,'2024-03-04 10:32:26','2024-03-04 10:32:26'),(170,'service',45,'Anual',20400,'2024-03-04 10:32:26','2024-03-04 10:32:26'),(171,'service',46,'Mensual',3040,'2024-03-04 10:32:33','2024-03-04 10:32:33'),(172,'service',46,'Semestral',18240,'2024-03-04 10:32:33','2024-03-04 10:32:33'),(173,'service',46,'Anual',30400,'2024-03-04 10:32:33','2024-03-04 10:32:33'),(174,'service',41,'Mensual',1540,'2024-03-04 10:34:38','2024-03-04 10:34:38'),(175,'service',41,'Semestral',9240,'2024-03-04 10:34:38','2024-03-04 10:34:38'),(176,'service',41,'Anual',15400,'2024-03-04 10:34:38','2024-03-04 10:34:38'),(177,'service',42,'Mensual',2540,'2024-03-04 10:34:43','2024-03-04 10:34:43'),(178,'service',42,'Semestral',15240,'2024-03-04 10:34:43','2024-03-04 10:34:43'),(179,'service',42,'Anual',25400,'2024-03-04 10:34:43','2024-03-04 10:34:43'),(180,'service',43,'Mensual',3540,'2024-03-04 10:34:47','2024-03-04 10:34:47'),(181,'service',43,'Semestral',21240,'2024-03-04 10:34:47','2024-03-04 10:34:47'),(182,'service',43,'Anual',35400,'2024-03-04 10:34:47','2024-03-04 10:34:47'),(256,'service',33,'Mensual',5000,'2024-03-08 10:53:43','2024-03-08 10:53:43'),(257,'service',33,'Semestral',30000,'2024-03-08 10:53:43','2024-03-08 10:53:43'),(258,'service',33,'Anual',60000,'2024-03-08 10:53:43','2024-03-08 10:53:43'),(259,'service',34,'Mensual',7000,'2024-03-08 10:53:55','2024-03-08 10:53:55'),(260,'service',34,'Semestral',42000,'2024-03-08 10:53:55','2024-03-08 10:53:55'),(261,'service',34,'Anual',84000,'2024-03-08 10:53:55','2024-03-08 10:53:55'),(262,'service',35,'Mensual',13000,'2024-03-08 10:54:07','2024-03-08 10:54:07'),(263,'service',35,'Semestral',78000,'2024-03-08 10:54:07','2024-03-08 10:54:07'),(264,'service',35,'Anual',156000,'2024-03-08 10:54:07','2024-03-08 10:54:07');
/*!40000 ALTER TABLE `costs` ENABLE KEYS */;
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
