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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',0,'API Token','c83e0a17c40cda8cdabda400eda45b6da5a4d19f4c4d5e4db892685194fa874c','[\"*\"]',NULL,NULL,'2024-07-12 00:59:44','2024-07-12 00:59:44'),(2,'App\\Models\\User',0,'API Token','63819f8b06a4474c6c75403a29cfa4e0e2e2a1e6fdeac0f45585e8fb7002be1b','[\"*\"]',NULL,NULL,'2024-07-12 01:03:23','2024-07-12 01:03:23'),(3,'App\\Models\\User',0,'API Token','9d790f98bd77926855d48b85e0e5bfb5e1c265169e86a31de1a3d01074b29faa','[\"*\"]',NULL,NULL,'2024-07-12 01:04:35','2024-07-12 01:04:35'),(4,'App\\Models\\User',0,'API Token','7590fbe4157c74390641ae093dbe4ae62b4e15340de1f3322543f02a1b998994','[\"*\"]',NULL,NULL,'2024-07-12 01:06:42','2024-07-12 01:06:42'),(5,'App\\Models\\User',0,'API Token','266a58ae093d5a764d12510b30228287032e509ad05df331f99a0979a51f55c6','[\"*\"]',NULL,NULL,'2024-07-12 01:07:11','2024-07-12 01:07:11'),(6,'App\\Models\\User',0,'API Token','bdb7d31a5dca531454e4a34d6341ef506195bb78d73f1f946956ada1cf1f5f9e','[\"*\"]',NULL,NULL,'2024-07-12 01:07:22','2024-07-12 01:07:22'),(7,'App\\Models\\User',0,'API Token','8aaec67a375b4c124780b3ea0f5d7f3de61059f2570b5b49146784dc77829350','[\"*\"]',NULL,NULL,'2024-07-12 01:28:33','2024-07-12 01:28:33'),(8,'App\\Models\\User',0,'API Token','d153607b2cd83e50c1c15103a6e5e7fa5e9ff6ec6f81bd9eac31453a807a1fc5','[\"*\"]',NULL,NULL,'2024-07-12 01:47:54','2024-07-12 01:47:54'),(9,'App\\Models\\User',0,'API Token','9dbaa8283790eb6b6c8cba9200f8e28a30364a5de2fca71b92aa09b0ac8e69e8','[\"*\"]',NULL,NULL,'2024-07-12 01:50:18','2024-07-12 01:50:18'),(10,'App\\Models\\User',20,'API Token','d9873a560bf3fc1b8038d60e542da4a1f127fb8e2c58bb7832f84ad306c4f4a4','[\"*\"]',NULL,NULL,'2024-07-12 02:03:18','2024-07-12 02:03:18'),(11,'App\\Models\\User',0,'API Token','c02997a8a4cf32c9beceb0231c9a294185fff229b3e1b7506585498c3d0bacc2','[\"*\"]',NULL,NULL,'2024-07-12 03:21:31','2024-07-12 03:21:31'),(12,'App\\Models\\User',1,'API Token','47fbcff8b2f3cc7b491d3eba413975e75d544eda09fdb2207fca2b450d0afbe1','[\"*\"]',NULL,NULL,'2024-08-02 05:39:53','2024-08-02 05:39:53'),(13,'App\\Models\\User',1,'API Token','45048fbac35e0f207884c6c0236a49b327498b26c8a4ab66cb89f6470f6afce3','[\"*\"]',NULL,NULL,'2024-08-02 05:44:17','2024-08-02 05:44:17'),(14,'App\\Models\\User',0,'API Token','bdbcb77fe5cf3cd13e47e3f7ff086dec1952068e84faf0eb77da13b5153952c9','[\"*\"]',NULL,NULL,'2024-08-02 05:46:38','2024-08-02 05:46:38'),(15,'App\\Models\\User',1,'API Token','46df1a8bdfb1756bb5758487666fa1e5a0437bf04d20c20af42c3d504373a636','[\"*\"]',NULL,NULL,'2024-08-02 06:12:31','2024-08-02 06:12:31'),(16,'App\\Models\\User',1,'API Token','4320dcb2d1ee8d629b7b62c370c51b8ca9f9ea685599c1c8a9d292252d16bd48','[\"*\"]',NULL,NULL,'2024-08-02 06:50:54','2024-08-02 06:50:54'),(17,'App\\Models\\User',1,'API Token','9ed43c03e0322114fea7ed9ed95640b91453242120f8b30b2b3a7df2c88076a4','[\"*\"]',NULL,NULL,'2024-08-02 06:53:10','2024-08-02 06:53:10'),(18,'App\\Models\\User',1,'API Token','4ef5b7078df128b5345f778eca21d11bfca6a81f460692d97b5d88ea21ca6b37','[\"*\"]',NULL,NULL,'2024-08-02 21:33:21','2024-08-02 21:33:21'),(19,'App\\Models\\User',1,'API Token','6667197f4bbc584008a20829057c0a341b82b585098359fa82e42f2e66b85156','[\"*\"]',NULL,NULL,'2024-08-02 21:36:57','2024-08-02 21:36:57'),(20,'App\\Models\\User',1,'API Token','692a305f23ddfe91f5563c5741beaca58ca2b414f14547e098bb4d3c92fa381d','[\"*\"]',NULL,NULL,'2024-08-02 21:46:31','2024-08-02 21:46:31'),(21,'App\\Models\\User',1,'API Token','5142d8138ff51c61b5649113d18ff90684260eac5d986d2d513a90e8942bc7d0','[\"*\"]',NULL,NULL,'2024-08-02 23:26:31','2024-08-02 23:26:31'),(22,'App\\Models\\User',1,'API Token','b8c5ad28bceaa3d05a81359f29449a7cda5b3dd54d79aa48865339ed61845cdf','[\"*\"]',NULL,NULL,'2024-08-07 00:36:59','2024-08-07 00:36:59'),(23,'App\\Models\\User',1,'API Token','ce8dfc81606a79b3b914369e0e59f3781a331758d605d91edadc03467c254d43','[\"*\"]',NULL,NULL,'2024-08-07 00:37:51','2024-08-07 00:37:51'),(24,'App\\Models\\User',1,'API Token','71c0ccefcc889daa30a3bca3f30f03ea74304f17ed957c2a81cb0ffd592c4243','[\"*\"]',NULL,NULL,'2024-08-07 00:43:53','2024-08-07 00:43:53');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
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
