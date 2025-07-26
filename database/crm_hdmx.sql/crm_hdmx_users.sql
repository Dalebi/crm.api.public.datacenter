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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` mediumtext COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `position` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_user_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'Admin','francisco.s@hostdime.com.mx','$2y$12$HxveZFW8Fq6zTvuMnVbHyO25coAKcBdnyBEM2A7ZS8HgBeSOifKF2',NULL,1,'Administrador Sistema','eeSuKSD3kLkun1DFdsUJZvYDLCDgjdIcUuDNRReoyvZWNVmLaSvBsuh729Od','2018-04-05 17:41:42','2018-07-17 21:58:52'),(1,'Steel Edward Vázquez George','steel.g@hostdime.com.mx','$2y$12$HxveZFW8Fq6zTvuMnVbHyO25coAKcBdnyBEM2A7ZS8HgBeSOifKF2','1700769333_7e719be79d55353a3ce6551d704e43ca.jpg',1,'Developer Administrator','JcW45djLTXszXY9Hd1ry5yEt8CYlb82CDoJuktxcG2r3hsEKlKdYzinKboHP','2018-04-05 17:41:42','2024-02-28 22:38:19'),(6,'Eduardo Gonzalez','eduardo.p@hostdime.com.mx','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Gerente Comercial & Project Manager',NULL,'2018-06-12 16:58:01','2021-10-11 15:53:31'),(7,'Silvia Martinez','silvia.v@hostdime.com.mx','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Ingeniera Comercial Jr & Asesora de Proyectos',NULL,'2018-06-12 16:59:37','2022-01-17 23:57:10'),(8,'Eduardo Basulto','eduardo.j@hostdime.com.mx','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Director General & LATAM Coordinator',NULL,'2018-06-12 17:00:41','2022-07-01 18:18:05'),(12,'Omar Campos','omar.c@hostdime.com.mx','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Ventas',NULL,'2018-10-12 18:19:11','2018-10-12 18:19:11'),(13,'Iván Pedroza','ivan.p@hostdime.com.mx','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Ingeniero Comercial & Asesor de Proyectos',NULL,'2022-01-17 23:55:58','2022-01-17 23:56:33'),(14,'Jessica Avila','jessicaaavilasanchez@gmail.com','$2y$10$jVbBh7f3.iY9taxAi0dpbONyPhnaoz4sqQiPKHconn0DN2jxSYlBW',NULL,1,'Aliado Comercial',NULL,'2023-03-22 23:46:40','2023-03-22 23:46:40'),(20,'Cbeas','desarrollo@hostdime.com.mx','$2y$12$HxveZFW8Fq6zTvuMnVbHyO25coAKcBdnyBEM2A7ZS8HgBeSOifKF2',NULL,1,'Desarrollador',NULL,'2024-07-11 23:32:49','2024-07-11 23:32:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-07 11:27:07
