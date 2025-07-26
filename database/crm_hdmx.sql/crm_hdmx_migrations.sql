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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(4,'2018_02_27_143059_create_rams_table',2),(5,'2018_02_27_143051_create_disks_table',3),(6,'2018_02_27_143110_create_raids_table',4),(7,'2018_02_27_143122_create_administrations_table',5),(8,'2018_02_27_143151_create_control_panels_table',5),(9,'2018_02_27_143210_create_public_ports_table',5),(10,'2018_02_27_143253_create_type_services_table',5),(11,'2018_02_27_143440_create_payment_cycles_table',5),(12,'2018_02_27_162058_create_data_centers_table',5),(13,'2018_02_27_162135_create_operative_systems_table',5),(14,'2018_02_27_143224_create_addons_table',6),(15,'2018_02_27_143304_create_services_table',6),(16,'2018_02_27_143417_create_transfers_table',6),(17,'2018_02_27_143319_create_c_p_us_table',7),(18,'2018_02_27_143357_create_service_features_table',7),(19,'2018_02_27_143501_create_ram_cpus_table',8),(20,'2018_05_02_130016_change_bandwidth_service_type_in_services_table',9),(21,'2018_05_17_130637_create_titles_table',10),(22,'2018_06_01_133951_change_id_disk_2_cpu_in_cpus_table',11),(23,'2018_06_07_111523_add_information_data_center_in_data_centers_table',12),(24,'2018_10_12_142130_add_price_and_id_data_center_to_public_ports',13),(25,'2020_07_28_114138_create_addon_types_table',14),(26,'2020_07_28_165456_add_id_addon_types_to_addons_table',15),(27,'2020_07_29_124949_add_key_addon_type_to_addon_types_table',15),(28,'2021_04_30_132826_create_cloud_table',16),(30,'2023_04_27_114723_create_product_payments_table',17),(31,'2014_10_12_100000_create_password_reset_tokens_table',18),(32,'2016_06_01_000001_create_oauth_auth_codes_table',19),(33,'2016_06_01_000002_create_oauth_access_tokens_table',20),(34,'2016_06_01_000003_create_oauth_refresh_tokens_table',21),(35,'2016_06_01_000004_create_oauth_clients_table',22),(36,'2016_06_01_000005_create_oauth_personal_access_clients_table',23),(37,'2019_12_14_000001_create_personal_access_tokens_table',24),(38,'2023_11_22_201919_rename_columns_table_users',24),(39,'2023_11_22_205510_create_permission_tables',25),(40,'2023_11_22_210642_create_activity_log_table',26),(41,'2023_11_22_210643_add_event_column_to_activity_log_table',26),(42,'2023_11_22_210644_add_batch_uuid_column_to_activity_log_table',26),(43,'2023_11_22_212432_add_columns_table_users',27),(44,'2023_11_23_203116_drop_columns_table_users',28),(47,'2023_11_23_210200_create_corporates_table',29),(48,'2023_11_23_231022_create_offices_table',29),(49,'2023_11_23_234104_create_corporates_table',30),(54,'2023_11_23_234232_create_corporates_table',31),(55,'2023_11_23_234356_create_offices_table',31),(56,'2024_03_07_191909_create_collaborators_table',32),(57,'2024_03_07_193500_create_collaborator_catalogs_table',32),(58,'2024_03_10_042220_create_collaborator_catalog_data_table',33),(59,'2024_03_11_161948_create_quote_catalogs_table',34),(60,'2024_03_11_161958_create_quotes_table',34),(61,'2024_03_11_164848_foreign_keys_collaborator',35),(62,'2024_03_11_165111_foreign_keys_collaborator_catalog_data',36),(63,'2024_03_11_165329_foreign_keys_corporate_catalog_data',37),(65,'2024_03_11_214041_add_field_color_table_quote_catalogs',38);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
