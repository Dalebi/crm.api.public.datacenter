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
-- Table structure for table `data_centers`
--

DROP TABLE IF EXISTS `data_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_centers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `information` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_centers`
--

LOCK TABLES `data_centers` WRITE;
/*!40000 ALTER TABLE `data_centers` DISABLE KEYS */;
INSERT INTO `data_centers` VALUES (1,'Orlando, Florida','USA.Florida.Orlando DC2','<h4 align=\"center\" style=\"color: #ff6600; text-align: left\">Centro de Datos Orlando, Florida, EEUU.</h4>         <p>HostDime opera su centro de datos propio en la región de Orlando Florida, EEUU. Con el nombre código Orlando DC2. Nuestro centro de datos cuenta con múltiples conexiones GigE a proveedores Tier 1 de ancho de banda, tales como Level 3 and Time Warner. El acceso al Centro de Datos está protegido por llaves electrónicas HID, por lo que puede estar seguro de que su inversión esta segura.</p><br><p>El objetivo principal en el diseño de estas instalaciones fue asegurar los sistemas eléctricos y mecánicos para misión crítica y de igual importancia, eficacia manteniendo la escalabilidad. Nuestros centros de datos incluyen redundancia completa en el poder, la conectividad de red, extinción de incendios, además de altos estándares en seguridad.</p>          <table align=\"center\" style=\"width:100%\">             <tr>                 <th><h4 align=\"center\" style=\"color: #ff6600\">Data Center</h4></th>                 <th><h4 align=\"center\" style=\"color: #ff6600\">Seguridad</h4></th>             </tr>             <tr>                 <td>                     <p>» 25,000 pies cuadrados.</p>                     <p>» Edificio de un solo piso con paredes perimetrales de hormigón.</p>                     <p>» Resistente a tormentas de categoría 4.</p>                     <p>» Sala de conferencias para clientes.</p>                     <p>» Sala para clientes.</p>                 </td>                 <td>                     <p>» Personal activo en las instalaciones las 24 hrs del día los 365 días del año.</p>                     <p>» Control de acceso electrónico para la seguridad física.</p>                     <p>» Control de acceso de tipo Man-trampa con lectores biométricos de mano proporcionado por ADT Security.</p>                     <p>» Más de 50 cámaras IP ofrecen vigilancia en todo el data center.</p>                 </td>                        </tr>         </table>          <table align=\"center\" style=\"width:100%\">             <tr>                 <th><h4 align=\"center\" style=\"color: #ff6600\">Infraestructura Eléctrica</h4></th>                 <th><h4 align=\"center\" style=\"color: #ff6600\">Conectividad y Ancho de Banda</h4></th>             </tr>             <tr>                 <td>                     <p>» 1 X 500 KW Caterpillar Diesel Generator</p>                     <p>» 1 X 1250 KW Katolight Diesel Generator</p>                     <p>» 1 X 500KVA Powerware 9315 UPS</p>                     <p>» 1 X 480KVA Powerware 9390 UPS in a parallel N+1 configuration</p>                     <p>» 5 X Battery Strings (providing 15 minutes of runtime at full load)</p>                     <p>» 2,700 Gallons of fuel capacity for generators</p>                     <p>» Routine systems testing and maintenance</p>                 </td>                 <td>                     <p>» 20GB - Level3 Communications</p>                     <p>» 20GB - Backhaul to Miami Nap of Americas</p>                     <p>» 10GB - Global Crossing</p>                     <p>» 10GB - Tiscalli</p>                     <p>» 10GB - Public Peering (NOTA)</p>                     <p>» 20GB - Diverse Dark Fiber to Miami Nap of Americas</p>                     <p>» Private Network Availability</p>                 </td>             </tr>         </table>   <br>       <a href=\"https://www.hostdime.com.mx/data-center/\" target=\"_blank\" style=\"color: #ff6600\">Más información</a>','2018-04-19 17:33:21','2018-06-19 18:40:00'),(2,'Guadalajara, Jalisco','Mexico GDL DC2','<h4 align=\"center\" style=\"color: #ff6600\">Centro de Datos - Centro de Datos México</h4>           <p>HostDime opera su centro de datos propio en la región de Guadalajara Jalisco, México. Con el nombre código GDL DC2. Fue diseñado desde cero basado en décadas de experiencia de nuestros ingenieros con la estabilidad, fiabilidad y el más alto nivel de los estándares de UpTime. Contamos también con mas de 2 proveedores de red TIER 1. </p><br><p>El objetivo principal en el diseño de estas instalaciones fue asegurar los sistemas eléctricos y mecánicos para misión crítica y de igual importancia, eficacia manteniendo la escalabilidad. Nuestros centros de datos incluyen redundancia completa en el poder, la conectividad de red, extinción de incendios, además de altos estándares en seguridad.</p>             <table align=\"center\" style=\"width:100%\">              	<tr>                  		<th> 			<h4 align=\"center\" style=\"color: #ff6600\">Data Center</h4> 		</th>                  		<th> 			<h4 align=\"center\" style=\"color: #ff6600\">Seguridad</h4> 		</th>              	</tr>              	<tr>                  	<td>                      		<p>» 1,700 pies cuadrados. </p>                      		<p>» Edificio de 2 pisos con paredes perimetrales de concreto.</p>                      		<p>» Sala de conferencias para clientes.</p>                      		<p>» Personal en sitio 24x7x365.</p>                      		<p>» Control de precisión de humedad y temperatura constante 23°C</p>                      		<p>» 40 toneladas de capacidad total de refrigeración (8 Unidades Trane de 5 Toneladas.)</p>                  	</td>                  	<td>                      		<p>» Personal activo en las instalaciones las 24 hrs del día los 365 días del año.</p>                      		<p>» Control de acceso electrónico para la seguridad física.</p>                      		<p>» Control de acceso con lectores biométricos de mano proporcionado por ADT Security. </p>                      		<p>» Más de 20 cámaras IP ofrecen vigilancia dentro y fuera del centro de datos</p>                  	</td>                         	</tr>          </table><br><table align=\"center\" style=\"width:100%\">              	<tr>                  		<th> 			<h4 align=\"center\" style=\"color: #ff6600\">Infraestructura Eléctrica</h4> 		</th>                  		<th> 			<h4 align=\"center\" style=\"color: #ff6600\">Conectividad y Ancho de Banda</h4> 		</th>              	</tr>              	<tr>                  		<td>                      			<p>» 1 X 230 KW Detroit Diesel Generator. </p>                      			<p>» Generador con capacidad de 1,200 galones de combustible. </p>                      			<p>» 2 X 100 KVA APC UPS con configuración en paralelo N+1. </p>                      			<p>» Baterías (Proporcionan 60 min de carga en tiempo de ejecución). </p>                      			<p>» Pruebas de rutina y mantenimiento de sistemas</p>                  		</td>                  		<td>                      			<p>» 1 Gbps - ME Axtel </p>                      			<p>» 1 Gbps - ME Metro Carrier</p>                  		</td>              	</tr>          </table>  <br>         <a href=\"https://www.hostdime.com.mx/centro-de-datos/\" target=\"_blank\" style=\"color: #ff6600\">Más información</a>','2018-04-19 17:35:41','2018-06-19 18:40:06');
/*!40000 ALTER TABLE `data_centers` ENABLE KEYS */;
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
