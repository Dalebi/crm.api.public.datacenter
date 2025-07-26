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
-- Table structure for table `id_user`
--

DROP TABLE IF EXISTS `id_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `id_user` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `name_user` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_user` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_user` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_user_unique` (`email_user`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `id_user`
--

LOCK TABLES `id_user` WRITE;
/*!40000 ALTER TABLE `id_user` DISABLE KEYS */;
INSERT INTO `id_user` VALUES (0,'Admin','francisco.s@hostdime.com.mx','$2a$12$X9ltYHtKb5vdBxNXOsNT5.oZlY7iQnkYGa/h54ByeLW0OInUTINKW','admin','Administrador Sistema','eeSuKSD3kLkun1DFdsUJZvYDLCDgjdIcUuDNRReoyvZWNVmLaSvBsuh729Od','2018-04-05 17:41:42','2018-07-17 21:58:52'),(1,'AdminT','steel.v@hostdime.com.mx','$2a$12$X9ltYHtKb5vdBxNXOsNT5.oZlY7iQnkYGa/h54ByeLW0OInUTINKW','admin','Administrador Sistema','JcW45djLTXszXY9Hd1ry5yEt8CYlb82CDoJuktxcG2r3hsEKlKdYzinKboHP','2018-04-05 17:41:42','2018-07-17 21:58:52'),(6,'Eduardo Gonzalez','eduardo.p@hostdime.com.mx','$2y$10$O8EJWgY/imrVdwbUtzpzheh7UbhZZpo6cqRk95NxcDqM6kPgGNrTm','user','Gerente Comercial & Project Manager',NULL,'2018-06-12 16:58:01','2021-10-11 15:53:31'),(7,'Silvia Martinez','silvia.v@hostdime.com.mx','$2y$10$cLHbj7eUI08ufIujrqDCBObl1YI4y4v0FzSRJIfKL4q4BE7lb6jNS','user','Ingeniera Comercial Jr & Asesora de Proyectos',NULL,'2018-06-12 16:59:37','2022-01-17 23:57:10'),(8,'Eduardo Basulto','eduardo.j@hostdime.com.mx','$2y$10$6dXogSIrFss7Vu.uvegVq.wVvWQsx22Rm.eSlZqHgBwVQ/G0fa6tq','user','Director General & LATAM Coordinator',NULL,'2018-06-12 17:00:41','2022-07-01 18:18:05'),(12,'Omar Campos','omar.c@hostdime.com.mx','$2y$10$/8VhQhRm6hdA23gvg365m.hi3z9/n8liavtqntGJeS4DP22ryXR/W','user','Ventas',NULL,'2018-10-12 18:19:11','2018-10-12 18:19:11'),(13,'Iván Pedroza','ivan.p@hostdime.com.mx','$2y$10$si76IpDdl9LP6VIp5igzHuDENXl04JLS9XHA6.faKzUqMV3YmvQMK','user','Ingeniero Comercial & Asesor de Proyectos',NULL,'2022-01-17 23:55:58','2022-01-17 23:56:33'),(14,'Jessica Avila','jessicaaavilasanchez@gmail.com','$2y$10$ynGFFHFDKutMMg3ivjEOH.Hvr6lYh290VFluI8UfIqWPB/6y7ndp2','user','Aliado Comercial',NULL,'2023-03-22 23:46:40','2023-03-22 23:46:40'),(17,'AdminOriginal','francisco.ss@hostdime.com.mx','$2y$10$si76IpDdl9LP6VIp5igzHuDENXl04JLS9XHA6.faKzUqMV3YmvQMK','admin','Administrador Sistema','9cyoGRpJ7Ts5QOar5iqYFSfR0AizTFTQ1ebGWOmL7A9HEv3jdHxTBEHwEb7G','2018-04-05 17:41:42','2018-07-17 21:58:52');
/*!40000 ALTER TABLE `id_user` ENABLE KEYS */;
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
