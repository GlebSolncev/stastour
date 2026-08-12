-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets` (
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES ('about_background','64','2024-05-19 19:21:16','2024-05-23 21:58:42');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachmentable`
--

DROP TABLE IF EXISTS `attachmentable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachmentable` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `attachmentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachmentable_id` int unsigned NOT NULL,
  `attachment_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attachmentable_attachmentable_type_attachmentable_id_index` (`attachmentable_type`,`attachmentable_id`),
  KEY `attachmentable_attachment_id_foreign` (`attachment_id`),
  CONSTRAINT `attachmentable_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachmentable`
--

LOCK TABLES `attachmentable` WRITE;
/*!40000 ALTER TABLE `attachmentable` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachmentable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint NOT NULL DEFAULT '0',
  `sort` int NOT NULL DEFAULT '0',
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alt` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `user_id` bigint unsigned DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (1,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 11:59:17','2024-04-30 11:59:17'),(2,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 12:01:07','2024-04-30 12:01:07'),(6,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 12:06:38','2024-04-30 12:06:38'),(8,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 15:02:20','2024-04-30 15:02:20'),(9,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 15:02:21','2024-04-30 15:02:21'),(12,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 17:26:18','2024-04-30 17:26:18'),(13,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-04-30 17:34:51','2024-04-30 17:34:51'),(14,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 08:47:45','2024-05-07 08:47:45'),(15,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 08:57:20','2024-05-07 08:57:20'),(16,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:03:40','2024-05-07 09:03:40'),(17,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:08:37','2024-05-07 09:08:37'),(18,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:08:42','2024-05-07 09:08:42'),(19,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:09:19','2024-05-07 09:09:19'),(20,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:09:22','2024-05-07 09:09:22'),(21,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:10:03','2024-05-07 09:10:03'),(22,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:10:06','2024-05-07 09:10:06'),(23,'d8e3048746c63a6362ceef60dd2cfc1116c4bc42','Снимок экрана 2024-03-14 в 14.45.44.png','image/png','png',125783,0,'2024/05/07/',NULL,NULL,'00b0aa0a45491c2f77cc21f6dbfeb0f6ffa08e78','public',1,NULL,'2024-05-07 09:10:09','2024-05-07 09:10:09'),(24,'7c392b8ea47625ad50bc9b0a853e8731395aac76','IMG_20230325_192700.jpg_2023-10-31T10_24_19.744Z_output_0.jpeg','image/jpeg','jpeg',222795,0,'2024/05/08/',NULL,NULL,'4f538f4f207b9cc3a49634e1c8c0b86e64bfc975','public',1,NULL,'2024-05-08 15:52:55','2024-05-08 15:52:55'),(27,'1757271628cbccd1da56fddc6749dc339dfaa3ad','Screenshot 2023-12-20 185133.png','image/png','png',159772,0,'2024/05/08/',NULL,NULL,'46e05422e6b9b9c39de30d121b96a8da8ee55c2c','public',1,NULL,'2024-05-08 15:56:31','2024-05-08 15:56:31'),(28,'2b0518ad57c0a2356accc9f54a28db4c6b64256f','Screenshot 2023-06-27 151249.png','image/png','png',756265,0,'2024/05/08/',NULL,NULL,'37d9d6cbf0f8b0551e356b9f88a4fb879fa4a476','public',1,NULL,'2024-05-08 16:04:34','2024-05-08 16:04:34'),(29,'ea78d057591fa6b0829793570e73ee6a2219da8e','Screenshot 2023-07-19 164758.png','image/png','png',368656,0,'2024/05/08/',NULL,NULL,'35d141b59c5a8e92ed53520bb4c02a32bc65faa6','public',1,NULL,'2024-05-08 16:04:40','2024-05-08 16:04:40'),(30,'b0bcec460b859046c04e44e801953701faae7976','Screenshot 2023-10-13 124309.png','image/png','png',18914,0,'2024/05/08/',NULL,NULL,'0263f6c89e8c834e11dec7f520f7464459a949a6','public',1,NULL,'2024-05-08 16:04:47','2024-05-08 16:04:47'),(33,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:41:22','2024-05-10 16:41:22'),(34,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:41:23','2024-05-10 16:41:23'),(35,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:41:25','2024-05-10 16:41:25'),(36,'bf1f257855236bf4ff98f35be39f2c23f30fae35','test (3).kml','application/vnd.google-earth.kml+xml','kml',5691,0,'2024/05/10/',NULL,NULL,'2480b6d2a4dd6bc394eb7a0a85533e98c1e52a98','public',1,NULL,'2024-05-10 16:41:40','2024-05-10 16:41:40'),(37,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:44:05','2024-05-10 16:44:05'),(38,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:44:06','2024-05-10 16:44:06'),(39,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:44:07','2024-05-10 16:44:07'),(40,'bf1f257855236bf4ff98f35be39f2c23f30fae35','test (3).kml','application/vnd.google-earth.kml+xml','kml',5691,0,'2024/05/10/',NULL,NULL,'2480b6d2a4dd6bc394eb7a0a85533e98c1e52a98','public',1,NULL,'2024-05-10 16:44:24','2024-05-10 16:44:24'),(41,'bf1f257855236bf4ff98f35be39f2c23f30fae35','test (3).kml','application/vnd.google-earth.kml+xml','kml',5691,0,'2024/05/10/',NULL,NULL,'2480b6d2a4dd6bc394eb7a0a85533e98c1e52a98','public',1,NULL,'2024-05-10 16:46:18','2024-05-10 16:46:18'),(42,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:47:13','2024-05-10 16:47:13'),(43,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:47:14','2024-05-10 16:47:14'),(44,'bf1f257855236bf4ff98f35be39f2c23f30fae35','test (3).kml','application/vnd.google-earth.kml+xml','kml',5691,0,'2024/05/10/',NULL,NULL,'2480b6d2a4dd6bc394eb7a0a85533e98c1e52a98','public',1,NULL,'2024-05-10 16:47:29','2024-05-10 16:47:29'),(45,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:54:01','2024-05-10 16:54:01'),(46,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:54:02','2024-05-10 16:54:02'),(47,'68dd5c18621b5f41f2a01c6ec8525b68ac0ba13f','3dd59ad8574d5b603075fd11ff172e902d8529b4.png','image/png','png',926593,0,'2024/04/30/',NULL,NULL,'8ce309d77d639727228a0dbf4fbbb2f985e0412a','public',1,NULL,'2024-05-10 16:54:03','2024-05-10 16:54:03'),(48,'bf1f257855236bf4ff98f35be39f2c23f30fae35','test (3).kml','application/vnd.google-earth.kml+xml','kml',5691,0,'2024/05/10/',NULL,NULL,'2480b6d2a4dd6bc394eb7a0a85533e98c1e52a98','public',1,NULL,'2024-05-10 16:54:13','2024-05-10 16:54:13'),(52,'041d297bb1a22096c9d35dedd54697abe28e3f93','Screenshot_6.png','image/png','png',329907,0,'2024/05/14/',NULL,NULL,'9dbc1327913b7ca6708e78c0a07cfe5f084ac2a5','public',1,NULL,'2024-05-14 07:38:23','2024-05-14 07:38:23'),(53,'10ab247afb7230a21e78e2679cf39a8bd23a2cc9','about.png','image/png','png',1107020,0,'2024/05/19/',NULL,NULL,'72e1ead3b233906e9a214cd8a7456f5e37a65e60','public',1,NULL,'2024-05-19 19:15:09','2024-05-19 19:15:09'),(54,'10ab247afb7230a21e78e2679cf39a8bd23a2cc9','about.png','image/png','png',1107020,0,'2024/05/19/',NULL,NULL,'72e1ead3b233906e9a214cd8a7456f5e37a65e60','public',1,NULL,'2024-05-19 19:19:50','2024-05-19 19:19:50'),(56,'ffd208c99d0819b9e92084ebbc88db6b645dfbb3','castle.png','image/png','png',2067822,0,'2024/05/19/',NULL,NULL,'2403dd90ffc08f86823fe716865beb1727712f60','public',1,NULL,'2024-05-19 19:27:49','2024-05-19 19:27:49'),(57,'86145be4ecd281ab36153ef51dd3b47897cfd065','google.png','image/png','png',3418,0,'2024/05/19/',NULL,NULL,'682886626f9da32bf8a251529293eda183fb247e','public',1,NULL,'2024-05-19 19:29:45','2024-05-19 19:29:45'),(61,'629eb0a33e2106d305971a9f3c3eb9f38e2ec1b1','IMG_20190805_124149.jpg','image/jpeg','jpg',8168926,0,'2024/05/22/',NULL,NULL,'0cbc9a4645f0093a9840019db15af1637817d442','public',1,NULL,'2024-05-22 15:40:26','2024-05-22 15:40:26'),(62,'21e5fb029d3bf910c8bfcbabf44c510c31297e15','IMG_20190829_204139.jpg','image/jpeg','jpg',2761151,0,'2024/05/22/',NULL,NULL,'b1aa8f1530e3570b2e92fc1bd2b0094b6f4fddd3','public',1,NULL,'2024-05-22 15:42:29','2024-05-22 15:42:29'),(64,'10ab247afb7230a21e78e2679cf39a8bd23a2cc9','10ab247afb7230a21e78e2679cf39a8bd23a2cc9.png','image/png','png',1107020,0,'2024/05/19/',NULL,NULL,'72e1ead3b233906e9a214cd8a7456f5e37a65e60','public',1,NULL,'2024-05-23 21:58:41','2024-05-23 21:58:41'),(65,'b6a8261bc61b56826938fb56f98f92b88503e3bd','Untitled map.kml','application/vnd.google-earth.kml+xml','kml',4703,0,'2024/06/07/',NULL,NULL,'b81893490f6862998080b99f90e3949f4d2b5907','public',1,NULL,'2024-06-07 10:17:46','2024-06-07 10:17:46'),(69,'06b83337d8cf34c7598396cd2f7e0fdf91a87cdf','IMG_20190611_105038.jpg','image/jpeg','jpg',8084490,0,'2025/05/13/',NULL,NULL,'0bfc75d8fd20addee2fa946b59ab7901bdfe5ad1','public',1,NULL,'2025-05-13 19:38:25','2025-05-13 19:38:25'),(70,'4b26baa971423f847a0f920cc2c50d8bd79be634','IMG_20181115_151609.jpg','image/jpeg','jpg',4469676,0,'2025/05/13/',NULL,NULL,'b9d0418e114963544b7b97b564fa2d9f3622b8b5','public',1,NULL,'2025-05-13 19:38:32','2025-05-13 19:38:32'),(71,'ba6d18e84fcc380e2651398ee1279ffd0a5fe2d6','IMG_20181115_100143.jpg','image/jpeg','jpg',6475790,1,'2025/05/13/',NULL,NULL,'fbcf8f58af762c0ee2dbf4fcbcf2249aa7919c1b','public',1,NULL,'2025-05-13 19:38:39','2025-05-13 19:38:39'),(72,'ff9d9114de9e0c671c1504cd024fee68d0bbb889','IMG_20200104_103103.jpg','image/jpeg','jpg',5495899,2,'2025/05/13/',NULL,NULL,'e4a78fb042a4f9bcb39236128e16120823929670','public',1,NULL,'2025-05-13 19:38:48','2025-05-13 19:38:48'),(73,'a2dcf7507e0437627eff00b0f41f8c1ca7c8b4b1','IMG_20200225_095928.jpg','image/jpeg','jpg',4711418,3,'2025/05/13/',NULL,NULL,'1ed4873cd39fbd62da59b5fbab978986915790c8','public',1,NULL,'2025-05-13 19:38:59','2025-05-13 19:38:59'),(74,'ff9d9114de9e0c671c1504cd024fee68d0bbb889','IMG_20200104_103103.jpg','image/jpeg','jpg',5495899,0,'2025/05/13/',NULL,NULL,'e4a78fb042a4f9bcb39236128e16120823929670','public',1,NULL,'2025-05-13 19:40:30','2025-05-13 19:40:30'),(75,'ff9d9114de9e0c671c1504cd024fee68d0bbb889','IMG_20200104_103103.jpg','image/jpeg','jpg',5495899,0,'2025/05/13/',NULL,NULL,'e4a78fb042a4f9bcb39236128e16120823929670','public',1,NULL,'2025-05-13 19:40:46','2025-05-13 19:40:46'),(76,'525688c2841a3831747db3f0e81d305413626756','IMG20231222170253.jpg','image/jpeg','jpg',3662921,0,'2025/05/13/',NULL,NULL,'b5d83885c3e9dc0e906ade55f53154cb5e5f364a','public',1,NULL,'2025-05-13 19:41:41','2025-05-13 19:41:41'),(78,'caaa245ac1281a4d047bd4bf890c3687b84db519','20161105_145953_Richtone(HDR).jpg','image/jpeg','jpg',1803036,0,'2025/05/13/',NULL,NULL,'c2f9e68c70279c68a3f43ba754468346de0ac400','public',1,NULL,'2025-05-13 20:45:47','2025-05-13 20:45:47');
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basket`
--

DROP TABLE IF EXISTS `basket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `basket` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket`
--

LOCK TABLES `basket` WRITE;
/*!40000 ALTER TABLE `basket` DISABLE KEYS */;
INSERT INTO `basket` VALUES (1,1,'order_1','2024-04-30 15:40:03','2024-04-30 15:40:14'),(2,2,'order_2','2024-04-30 15:40:52','2024-04-30 15:41:15'),(3,3,'order_3','2024-04-30 15:46:03','2024-04-30 15:46:10'),(4,4,'order_4','2024-04-30 15:50:12','2024-04-30 15:50:19'),(5,5,'order_5','2024-04-30 16:18:08','2024-04-30 16:18:14'),(6,6,'order_6','2024-04-30 16:38:47','2024-04-30 16:38:53'),(7,NULL,'c1jD9pXQPlRLst2BVZUU4JSB0poCN8b3ZoTl8vbC','2024-05-02 09:27:34','2024-05-02 09:27:34'),(8,NULL,'vErxZKn3yBmWbun6EOL4p5QefwbNWwAiWWzBDieG','2024-05-08 16:00:24','2024-05-08 16:00:24'),(9,NULL,'qIuK3n8pxzTsgVkJ1bJSUT7I4iZ9uqYdOeotGAvu','2024-05-08 16:57:50','2024-05-08 16:57:50'),(10,NULL,'9gcFaHsm7aft92OWcE8qvYg55vcuM1F3ceQMqzXt','2024-05-11 20:24:13','2024-05-11 20:24:13'),(11,NULL,'G8zaxXr4WyahcXe3zsoX4FtkrieMurcwe88B0b8Z','2024-05-13 20:45:11','2024-05-13 20:45:11'),(12,7,'order_7','2024-05-14 14:13:41','2024-05-14 14:14:39'),(13,NULL,'uQFlhaUOnErRq7wY2EHs53bQ1ZFnlV0XVvDcR0Tx','2024-07-21 19:48:12','2024-07-21 19:48:12'),(14,NULL,'9OkBJ0n1ai3NlxuDD699Z4vcpR1JR2LayL48M9Ll','2025-11-12 14:27:40','2025-11-12 14:27:40'),(15,8,'order_8','2025-11-27 18:20:59','2025-11-27 18:31:13'),(16,NULL,'oMyzPx5Bd4RCGH6Kygv7V0ZaCR37D7WSSlfCHX2o','2025-11-27 18:31:56','2025-11-27 18:31:56'),(17,9,'order_9','2025-11-27 18:33:41','2025-11-27 18:34:45'),(18,NULL,'gDedsWtIC5UlrLaymuumkscnPDEI3OjLc7PN9Xww','2025-11-27 18:47:31','2025-11-27 18:47:31'),(19,NULL,'r4q7FwgH43ITAfykbhkW2VCs1xcX40V5M3kkKf0t','2025-11-30 20:24:06','2025-11-30 20:24:06'),(20,10,'order_10','2025-12-10 10:16:29','2025-12-10 10:17:54'),(21,NULL,'Auo5MI9bNYPQPMtBfLeAjYJ72S6IIkpESalE6Cei','2025-12-30 03:24:31','2025-12-30 03:24:31'),(22,NULL,'M3HDs0bguGVz9vdUtciFcOeNg1maU4Q5Mk6Wiosu','2026-01-03 17:05:45','2026-01-03 17:05:45'),(23,11,'order_11','2026-01-17 19:04:41','2026-01-17 19:06:14'),(24,NULL,'eoQN5U1vU9FwyYlKBDSIdAWynzP92DTH4q6zWH4F','2026-01-19 00:19:21','2026-01-19 00:19:21'),(25,NULL,'iGK726qCe7TnMn1cHST0lh84qiM9fxZ9qBCdDkzA','2026-01-20 08:05:17','2026-01-20 08:05:17'),(26,NULL,'EdGb9bAOqroKbvABW3IoXtMKdnzqqghXWjxVBGnY','2026-01-31 23:34:07','2026-01-31 23:34:07'),(27,NULL,'eJ1OLkcrEYQSqKwegVdwZyFcTngJQcDUyZQNgyCp','2026-02-21 11:20:08','2026-02-21 11:20:08'),(28,NULL,'hfYKzMABT7iO8DuLctgGNUdFQlnHlBMTisXO6lCq','2026-02-23 13:19:12','2026-02-23 13:19:12'),(29,NULL,'yYhykWZf1jYUcB4WWQnJcYI4B2YZ7ML2RnOdoqEi','2026-03-09 08:56:41','2026-03-09 08:56:41'),(30,NULL,'TSduh8CAFXbH4l6KcA2KPkE1Y5Jo2kQFiD8f2DVO','2026-03-23 03:51:02','2026-03-23 03:51:02'),(31,12,'order_12','2026-04-04 15:54:57','2026-04-04 15:55:22'),(32,13,'order_13','2026-04-23 12:50:52','2026-04-23 12:52:11'),(33,14,'order_14','2026-04-23 12:54:27','2026-04-23 12:55:56'),(34,15,'order_15','2026-06-30 10:41:58','2026-06-30 10:42:18'),(35,NULL,'ljLvw9AQ9FtV2VLyCCvivm6HAVMf7vMjoMcWqjtq','2026-06-30 10:53:39','2026-06-30 10:53:39');
/*!40000 ALTER TABLE `basket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basket_item`
--

DROP TABLE IF EXISTS `basket_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `basket_item` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `basket_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` int NOT NULL DEFAULT '0',
  `is_tour` tinyint(1) NOT NULL DEFAULT '0',
  `ext_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket_item`
--

LOCK TABLES `basket_item` WRITE;
/*!40000 ALTER TABLE `basket_item` DISABLE KEYS */;
INSERT INTO `basket_item` VALUES (1,1,1,100,1,1,'2024-04-30 15:40:03','2024-04-30 15:40:03'),(2,2,1,100,1,1,'2024-04-30 15:40:52','2024-04-30 15:40:52'),(3,3,1,100,1,1,'2024-04-30 15:46:03','2024-04-30 15:46:03'),(4,4,1,100,1,1,'2024-04-30 15:50:12','2024-04-30 15:50:12'),(5,5,1,100,1,1,'2024-04-30 16:18:08','2024-04-30 16:18:08'),(6,6,1,100,1,1,'2024-04-30 16:38:47','2024-04-30 16:38:47'),(7,7,1,100,1,1,'2024-05-02 09:27:34','2024-05-02 09:27:34'),(8,8,1,200,1,1,'2024-05-08 16:00:24','2024-05-08 16:00:24'),(9,9,1,200,1,1,'2024-05-08 16:57:50','2024-05-08 16:57:50'),(10,10,1,200,1,1,'2024-05-11 20:24:13','2024-05-11 20:24:13'),(12,11,3,150,1,7,'2024-05-13 20:45:54','2024-05-13 20:45:54'),(13,12,4,150,1,7,'2024-05-14 14:13:41','2024-05-14 14:13:41'),(14,13,1,150,1,7,'2024-07-21 19:48:12','2024-07-21 19:48:12'),(15,14,1,80,1,7,'2025-11-12 14:27:40','2025-11-12 14:27:40'),(17,15,1,80,1,7,'2025-11-27 18:30:04','2025-11-27 18:30:04'),(19,17,1,80,1,7,'2025-11-27 18:33:41','2025-11-27 18:33:41'),(20,16,1,80,1,7,'2025-11-27 18:43:16','2025-11-27 18:43:16'),(21,18,1,80,1,7,'2025-11-27 18:47:31','2025-11-27 18:47:31'),(22,19,1,80,1,7,'2025-11-30 20:24:06','2025-11-30 20:24:06'),(23,20,1,650,1,10,'2025-12-10 10:16:29','2025-12-10 10:16:29'),(24,21,2,80,1,7,'2025-12-30 03:24:31','2025-12-30 03:24:31'),(25,22,2,80,1,7,'2026-01-03 17:05:45','2026-01-03 17:05:45'),(26,23,2,80,1,7,'2026-01-17 19:04:41','2026-01-17 19:04:41'),(27,24,2,80,1,7,'2026-01-19 00:19:21','2026-01-19 00:19:21'),(28,25,1,80,1,7,'2026-01-20 08:05:17','2026-01-20 08:05:17'),(29,26,1,80,1,7,'2026-01-31 23:34:07','2026-01-31 23:34:07'),(30,27,1,80,1,7,'2026-02-21 11:20:08','2026-02-21 11:20:08'),(31,28,5,550,1,9,'2026-02-23 13:19:12','2026-02-23 13:19:12'),(32,29,1,650,1,10,'2026-03-09 08:56:41','2026-03-09 08:56:41'),(34,30,2,80,1,7,'2026-03-23 03:53:46','2026-03-23 03:53:46'),(35,31,2,80,1,7,'2026-04-04 15:54:57','2026-04-04 15:54:57'),(36,32,1,80,1,7,'2026-04-23 12:50:52','2026-04-23 12:50:52'),(37,33,1,80,1,7,'2026-04-23 12:54:27','2026-04-23 12:54:27'),(38,34,1,350,1,1,'2026-06-30 10:41:58','2026-06-30 10:41:58'),(40,35,1,350,1,1,'2026-06-30 12:46:46','2026-06-30 12:46:46');
/*!40000 ALTER TABLE `basket_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basket_property`
--

DROP TABLE IF EXISTS `basket_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `basket_property` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `basket_item_id` int DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket_property`
--

LOCK TABLES `basket_property` WRITE;
/*!40000 ALTER TABLE `basket_property` DISABLE KEYS */;
INSERT INTO `basket_property` VALUES (1,1,'timeslot_id','3','2024-04-30 15:40:03','2024-04-30 15:40:03'),(2,1,'timeslot_date','2024-05-06','2024-04-30 15:40:03','2024-04-30 15:40:03'),(3,1,'adult','1','2024-04-30 15:40:03','2024-04-30 15:40:03'),(4,2,'timeslot_id','3','2024-04-30 15:40:52','2024-04-30 15:40:52'),(5,2,'timeslot_date','2024-05-13','2024-04-30 15:40:52','2024-04-30 15:40:52'),(6,2,'adult','1','2024-04-30 15:40:52','2024-04-30 15:40:52'),(7,3,'timeslot_id','3','2024-04-30 15:46:03','2024-04-30 15:46:03'),(8,3,'timeslot_date','2024-06-24','2024-04-30 15:46:03','2024-04-30 15:46:03'),(9,3,'adult','1','2024-04-30 15:46:03','2024-04-30 15:46:03'),(10,4,'timeslot_id','3','2024-04-30 15:50:12','2024-04-30 15:50:12'),(11,4,'timeslot_date','2024-07-15','2024-04-30 15:50:12','2024-04-30 15:50:12'),(12,4,'adult','1','2024-04-30 15:50:12','2024-04-30 15:50:12'),(13,5,'timeslot_id','3','2024-04-30 16:18:08','2024-04-30 16:18:08'),(14,5,'timeslot_date','2024-08-12','2024-04-30 16:18:08','2024-04-30 16:18:08'),(15,5,'adult','1','2024-04-30 16:18:08','2024-04-30 16:18:08'),(16,6,'timeslot_id','3','2024-04-30 16:38:47','2024-04-30 16:38:47'),(17,6,'timeslot_date','2024-06-10','2024-04-30 16:38:47','2024-04-30 16:38:47'),(18,6,'adult','1','2024-04-30 16:38:47','2024-04-30 16:38:47'),(19,7,'timeslot_id','3','2024-05-02 09:27:34','2024-05-02 09:27:34'),(20,7,'timeslot_date','2024-05-27','2024-05-02 09:27:34','2024-05-02 09:27:34'),(21,7,'adult','1','2024-05-02 09:27:34','2024-05-02 09:27:34'),(22,8,'timeslot_id','3','2024-05-08 16:00:24','2024-05-08 16:00:24'),(23,8,'timeslot_date','2024-05-17','2024-05-08 16:00:24','2024-05-08 16:00:24'),(24,8,'adult','1','2024-05-08 16:00:24','2024-05-08 16:00:24'),(25,9,'timeslot_id','3','2024-05-08 16:57:50','2024-05-08 16:57:50'),(26,9,'timeslot_date','2024-05-10','2024-05-08 16:57:50','2024-05-08 16:57:50'),(27,9,'adult','1','2024-05-08 16:57:50','2024-05-08 16:57:50'),(28,10,'timeslot_id','3','2024-05-11 20:24:13','2024-05-11 20:24:13'),(29,10,'timeslot_date','2024-05-19','2024-05-11 20:24:13','2024-05-11 20:24:13'),(30,10,'adult','1','2024-05-11 20:24:13','2024-05-11 20:24:13'),(34,12,'timeslot_id','3','2024-05-13 20:45:54','2024-05-13 20:45:54'),(35,12,'timeslot_date','2024-05-14','2024-05-13 20:45:54','2024-05-13 20:45:54'),(36,12,'adult','2','2024-05-13 20:45:54','2024-05-13 20:45:54'),(37,12,'kid','1','2024-05-13 20:45:54','2024-05-13 20:45:54'),(38,12,'kid_info','8,5','2024-05-13 20:45:54','2024-05-13 20:45:54'),(39,13,'timeslot_id','3','2024-05-14 14:13:41','2024-05-14 14:13:41'),(40,13,'timeslot_date','2024-05-22','2024-05-14 14:13:41','2024-05-14 14:13:41'),(41,13,'adult','3','2024-05-14 14:13:41','2024-05-14 14:13:41'),(42,13,'kid','1','2024-05-14 14:13:41','2024-05-14 14:13:41'),(43,14,'timeslot_id','3','2024-07-21 19:48:12','2024-07-21 19:48:12'),(44,14,'timeslot_date','2024-07-23','2024-07-21 19:48:12','2024-07-21 19:48:12'),(45,14,'adult','1','2024-07-21 19:48:12','2024-07-21 19:48:12'),(46,15,'timeslot_id','3','2025-11-12 14:27:40','2025-11-12 14:27:40'),(47,15,'timeslot_date','2025-11-13','2025-11-12 14:27:40','2025-11-12 14:27:40'),(48,15,'adult','1','2025-11-12 14:27:40','2025-11-12 14:27:40'),(52,17,'timeslot_id','3','2025-11-27 18:30:04','2025-11-27 18:30:04'),(53,17,'timeslot_date','2025-11-28','2025-11-27 18:30:04','2025-11-27 18:30:04'),(54,17,'adult','1','2025-11-27 18:30:04','2025-11-27 18:30:04'),(58,19,'timeslot_id','3','2025-11-27 18:33:41','2025-11-27 18:33:41'),(59,19,'timeslot_date','2025-11-28','2025-11-27 18:33:41','2025-11-27 18:33:41'),(60,19,'adult','1','2025-11-27 18:33:41','2025-11-27 18:33:41'),(61,20,'timeslot_id','3','2025-11-27 18:43:16','2025-11-27 18:43:16'),(62,20,'timeslot_date','2025-11-28','2025-11-27 18:43:16','2025-11-27 18:43:16'),(63,20,'adult','1','2025-11-27 18:43:16','2025-11-27 18:43:16'),(64,21,'timeslot_id','3','2025-11-27 18:47:31','2025-11-27 18:47:31'),(65,21,'timeslot_date','2025-11-28','2025-11-27 18:47:31','2025-11-27 18:47:31'),(66,21,'adult','1','2025-11-27 18:47:31','2025-11-27 18:47:31'),(67,22,'timeslot_id','3','2025-11-30 20:24:06','2025-11-30 20:24:06'),(68,22,'timeslot_date','2026-06-01','2025-11-30 20:24:06','2025-11-30 20:24:06'),(69,22,'adult','1','2025-11-30 20:24:06','2025-11-30 20:24:06'),(70,23,'timeslot_id','3','2025-12-10 10:16:29','2025-12-10 10:16:29'),(71,23,'timeslot_date','2025-12-18','2025-12-10 10:16:29','2025-12-10 10:16:29'),(72,23,'adult','1','2025-12-10 10:16:29','2025-12-10 10:16:29'),(73,24,'timeslot_id','3','2025-12-30 03:24:31','2025-12-30 03:24:31'),(74,24,'timeslot_date','2026-06-28','2025-12-30 03:24:31','2025-12-30 03:24:31'),(75,24,'adult','2','2025-12-30 03:24:31','2025-12-30 03:24:31'),(76,25,'timeslot_id','3','2026-01-03 17:05:45','2026-01-03 17:05:45'),(77,25,'timeslot_date','2026-01-21','2026-01-03 17:05:45','2026-01-03 17:05:45'),(78,25,'adult','2','2026-01-03 17:05:45','2026-01-03 17:05:45'),(79,26,'timeslot_id','3','2026-01-17 19:04:41','2026-01-17 19:04:41'),(80,26,'timeslot_date','2026-06-07','2026-01-17 19:04:41','2026-01-17 19:04:41'),(81,26,'adult','2','2026-01-17 19:04:41','2026-01-17 19:04:41'),(82,27,'timeslot_id','3','2026-01-19 00:19:21','2026-01-19 00:19:21'),(83,27,'timeslot_date','2026-03-06','2026-01-19 00:19:21','2026-01-19 00:19:21'),(84,27,'adult','2','2026-01-19 00:19:21','2026-01-19 00:19:21'),(85,28,'timeslot_id','3','2026-01-20 08:05:17','2026-01-20 08:05:17'),(86,28,'timeslot_date','2026-01-29','2026-01-20 08:05:17','2026-01-20 08:05:17'),(87,28,'adult','1','2026-01-20 08:05:17','2026-01-20 08:05:17'),(88,29,'timeslot_id','3','2026-01-31 23:34:07','2026-01-31 23:34:07'),(89,29,'timeslot_date','2026-02-01','2026-01-31 23:34:07','2026-01-31 23:34:07'),(90,29,'adult','1','2026-01-31 23:34:07','2026-01-31 23:34:07'),(91,30,'timeslot_id','3','2026-02-21 11:20:08','2026-02-21 11:20:08'),(92,30,'timeslot_date','2026-02-28','2026-02-21 11:20:08','2026-02-21 11:20:08'),(93,30,'adult','1','2026-02-21 11:20:08','2026-02-21 11:20:08'),(94,31,'timeslot_id','3','2026-02-23 13:19:12','2026-02-23 13:19:12'),(95,31,'timeslot_date','2026-06-28','2026-02-23 13:19:12','2026-02-23 13:19:12'),(96,31,'adult','5','2026-02-23 13:19:12','2026-02-23 13:19:12'),(97,32,'timeslot_id','3','2026-03-09 08:56:41','2026-03-09 08:56:41'),(98,32,'timeslot_date','2026-03-12','2026-03-09 08:56:41','2026-03-09 08:56:41'),(99,32,'adult','1','2026-03-09 08:56:41','2026-03-09 08:56:41'),(103,34,'timeslot_id','3','2026-03-23 03:53:46','2026-03-23 03:53:46'),(104,34,'timeslot_date','2026-03-23','2026-03-23 03:53:46','2026-03-23 03:53:46'),(105,34,'adult','2','2026-03-23 03:53:46','2026-03-23 03:53:46'),(106,35,'timeslot_id','3','2026-04-04 15:54:57','2026-04-04 15:54:57'),(107,35,'timeslot_date','2026-10-04','2026-04-04 15:54:57','2026-04-04 15:54:57'),(108,35,'adult','2','2026-04-04 15:54:57','2026-04-04 15:54:57'),(109,36,'timeslot_id','3','2026-04-23 12:50:52','2026-04-23 12:50:52'),(110,36,'timeslot_date','2026-08-26','2026-04-23 12:50:52','2026-04-23 12:50:52'),(111,36,'adult','1','2026-04-23 12:50:52','2026-04-23 12:50:52'),(112,37,'timeslot_id','3','2026-04-23 12:54:27','2026-04-23 12:54:27'),(113,37,'timeslot_date','2026-08-26','2026-04-23 12:54:27','2026-04-23 12:54:27'),(114,37,'adult','1','2026-04-23 12:54:27','2026-04-23 12:54:27'),(115,38,'timeslot_id','5','2026-06-30 10:41:58','2026-06-30 10:41:58'),(116,38,'timeslot_date','2026-07-02','2026-06-30 10:41:58','2026-06-30 10:41:58'),(117,38,'adult','1','2026-06-30 10:41:58','2026-06-30 10:41:58'),(121,40,'timeslot_id','5','2026-06-30 12:46:46','2026-06-30 12:46:46'),(122,40,'timeslot_date','2026-07-01','2026-06-30 12:46:46','2026-06-30 12:46:46'),(123,40,'adult','1','2026-06-30 12:46:46','2026-06-30 12:46:46');
/*!40000 ALTER TABLE `basket_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_banners`
--

DROP TABLE IF EXISTS `main_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_banners` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_es` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_fr` text COLLATE utf8mb4_unicode_ci,
  `description_es` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_banners`
--

LOCK TABLES `main_banners` WRITE;
/*!40000 ALTER TABLE `main_banners` DISABLE KEYS */;
INSERT INTO `main_banners` VALUES (5,'Your best vacation in Portugal with StasTours',NULL,NULL,'Your personal guide to the most popular places in Portugal. Tours in Lisbon,  \r\nSintra, Algarve, and much more. Let\'s explore this wonderful country together!',NULL,NULL,'78','left','1',1,'2024-04-30 12:02:22','2025-05-13 20:45:48','http://wa.me/351964002296','Click here'),(10,'Explore with Us',NULL,NULL,NULL,NULL,NULL,'61','left','500',1,'2024-05-22 15:40:30','2025-05-13 20:37:07',NULL,NULL),(11,'Unforgettable Tours Led by Local Experts',NULL,NULL,NULL,NULL,NULL,'62','center','500',1,'2024-05-22 15:42:31','2025-05-13 20:36:21','http://wa.me/351964002296',NULL);
/*!40000 ALTER TABLE `main_banners` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (63,'2014_10_12_000000_create_users_table',1),(64,'2014_10_12_100000_create_password_reset_tokens_table',1),(65,'2015_04_12_000000_create_orchid_users_table',1),(66,'2015_10_19_214424_create_orchid_roles_table',1),(67,'2015_10_19_214425_create_orchid_role_users_table',1),(68,'2016_08_07_125128_create_orchid_attachmentstable_table',1),(69,'2017_09_17_125801_create_notifications_table',1),(70,'2019_08_19_000000_create_failed_jobs_table',1),(71,'2019_12_14_000001_create_personal_access_tokens_table',1),(72,'2024_02_05_140132_news_list_table',1),(73,'2024_02_22_152012_main_banners',1),(74,'2024_03_05_103535_tours_table',1),(75,'2024_03_08_183955_create_basket_item_table',1),(76,'2024_03_08_184002_create_basket_property_table',1),(77,'2024_03_09_123758_create_basket',1),(78,'2024_03_09_124041_create_order',1),(79,'2024_03_09_211421_create_timeslot',1),(80,'2024_03_10_073326_add_new_column_tours',1),(81,'2024_03_30_132117_update_news_table',1),(84,'2024_04_30_114535_add_button_and_url_to_main_banners',2),(85,'2024_04_30_125245_update_timeslots',3),(86,'2024_05_10_160230_update_tours',4),(87,'2024_05_10_185632_create_tour_timeslot_block_table',5),(88,'2024_05_19_184343_create_assets_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_pt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_es` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_text` text COLLATE utf8mb4_unicode_ci,
  `detail_text_pt` text COLLATE utf8mb4_unicode_ci,
  `detail_text_es` text COLLATE utf8mb4_unicode_ci,
  `preview_text` text COLLATE utf8mb4_unicode_ci,
  `preview_text_pt` text COLLATE utf8mb4_unicode_ci,
  `preview_text_es` text COLLATE utf8mb4_unicode_ci,
  `is_big` tinyint(1) NOT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Hello adventurers!',NULL,NULL,'12','hello-adventurers','<p><span style=\"color: rgb(0, 0, 0);\">I moved to Portugal with my parents when I was 10 and fell in love with this fairy tale country. Living in the Algarve region which is in the&nbsp; south I began to associate my life with tourism. I graduated from the professional tourism school in the city of Faro and then got a degree in Tourism in the university.&nbsp;</span></p><p><span style=\"color: rgb(0, 0, 0);\">Searching for new adventures after graduation, I moved to Lisbon, the capital of Portugal, nestled on the 7 hills. There I gained a bunch of exciting stories, working for one of the largest tourism companies and touring around the city and its surroundings. </span></p><p><br></p><p><span style=\"color: rgb(0, 0, 0);\">Having enough experience, I shifted to individual tours.&nbsp;</span></p><p><span style=\"color: rgb(0, 0, 0);\">We can communicate in English, Portuguese, Spanish and Russian. With my personal and professional life in Portugal I create tours where you learn both the historic facts and the real life of the Portuguese, their culture and traditions. With me you will discover Portugal’s hidden gems, try local cuisine and overall have a great time<span class=\"ql-cursor\">﻿</span>. See you in Portugal!</span></p><p><br></p>',NULL,NULL,'I moved to Portugal with my parents when I was 10 and fell in love with this fairy tale country. Living in the Algarve region which is in the  south I began to associate my life with tourism.',NULL,NULL,0,'500',1,'2024-04-30 17:26:02','2024-05-10 16:13:06',1),(2,'Ahoy, wine enthusiasts!',NULL,NULL,'13','ahoy-wine-enthusiasts','<p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">Today I’d like to tell you&nbsp; a fascinating story that spans the seas, from the rugged shores of Portugal to the posh parlours of English gentlemen.</span></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">This story began in the 17th century amidst a squabble between the French and the English, where a forbidden fruit became the toast of the town – enter, port wine!</span></p><p><br></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">Legend had it that when the French premier Colbert decided to play customs games with the English, raising taxes on their beloved Bordeaux, the English retaliated in a way only they could – by banning all French wines. But fear not, dear reader, for where there\'s a thirst, there\'s a solution!</span></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">Enter the intrepid English merchants, with their keen eye for a fine drop and a nose for adventure. Docking their ships in the bustling port of Porto, Portugal, they set their sights on the barrels of fortified goodness known as port wine. These seafaring scallywags wasted no time in loading their holds with the sweet nectar, destined for the lips of eager Englishmen across the channel.</span></p><p><span style=\"background-color: transparent; color: rgb(53, 28, 117);\"><span class=\"ql-cursor\">﻿﻿﻿﻿﻿﻿</span></span></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">But what made port wine so special, you might ask? Well, aside from its rich flavour and intoxicating aroma, it had a secret weapon – fortification! You see, these Portuguese vintners were no strangers to innovation. To withstand the rigours of the high seas, they added a hearty dose of grape spirits to their wines, creating a drink that could weather any storm.</span></p><p><br></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">And thus, port wine was born – a bold and bountiful beverage that quickly captured the hearts (and palates) of the English elite. But like any good tale, there were twists and turns along the way.</span></p><p><br></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">As demand for port wine soared, so too did the temptation for mischief. Counterfeiters lurked in the shadows, adding sugar to boost alcohol content and elderberry juice to deepen its hue. But fear not, for justice prevailed in the form of the Marquis of Pombal, who declared the Douro Valley the sole sanctuary for true port wine.</span></p><p><br></p><p><span style=\"background-color: transparent; color: rgb(0, 0, 0);\">Today, the legacy of port wine lives on, enchanting adventurers and connoisseurs alike with its storied past and exquisite flavour. So raise your glass, dear reader, and join us in a toast to the enduring spirit of port wine – from pirates to posh parties, it\'s a journey worth savouring! </span><span style=\"color: rgb(0, 0, 0);\">And where better to enjoy this than in Portugal itself? Come visit us, and I\'ll gladly raise a glass of this exquisite drink with you!</span></p><p><br></p>',NULL,NULL,'Today I’d like to tell you  a fascinating story that spans the seas, from the rugged shores of Portugal to the posh parlours of English gentlemen.',NULL,NULL,0,'500',1,'2024-04-30 17:35:19','2024-05-10 16:13:19',0);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `delivery_price` int NOT NULL DEFAULT '0',
  `timeslot_date` date DEFAULT NULL,
  `timeslot_id` int DEFAULT NULL,
  `timeslot_count` int NOT NULL DEFAULT '0',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restrictions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,0,'2024-05-06',3,1,1,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 15:40:14','2024-04-30 16:38:28'),(2,0,'2024-05-13',3,1,0,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 15:41:15','2024-04-30 15:41:15'),(3,0,'2024-06-24',3,1,0,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 15:46:10','2024-04-30 15:46:10'),(4,0,'2024-07-15',3,1,0,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 15:50:19','2024-04-30 15:50:19'),(5,0,'2024-08-12',3,1,0,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 16:18:14','2024-04-30 16:18:14'),(6,0,'2024-06-10',3,1,1,'test','+79043698834','aji1ov@yandex.ru',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-30 16:38:53','2024-04-30 16:39:10'),(7,0,'2024-05-22',3,4,0,'Ilia','+33876235286','ilmazitov88@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,'2024-05-14 14:14:39','2024-05-14 14:14:39'),(8,0,'2025-11-28',3,1,0,'Shreeyash Saboo','+919820942546','s_saboo@hotmail.com','No','Whatsapp same time zone',NULL,NULL,NULL,NULL,'2025-11-27 18:31:13','2025-11-27 18:31:13'),(9,0,'2025-11-28',3,1,0,'Shreeyash Saboo','+919820942546','s_saboo@hotmail.com','No','Same time zone, you can contact on whatsapp and e-mail',NULL,NULL,NULL,NULL,'2025-11-27 18:34:45','2025-11-27 18:34:45'),(10,0,'2025-12-18',3,1,0,'dwed','+31g7476783','hjahdj@hfgjsghs.com',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-10 10:17:54','2025-12-10 10:17:54'),(11,0,'2026-06-07',3,2,0,'michelle cardaronella','9856300602','mcard9@bellsouth.net','no','USA Central time zone\r\nemail or text',NULL,NULL,NULL,NULL,'2026-01-17 19:06:14','2026-01-17 19:06:14'),(12,0,'2026-10-04',3,2,0,'Michael Hewes','+19703715565','michaelhewes@gmail.com','No',NULL,NULL,NULL,NULL,NULL,'2026-04-04 15:55:22','2026-04-04 15:55:22'),(13,0,'2026-08-26',3,1,0,'Che Carpio','+12048050488','checarpio@icloud.com','no','via email',NULL,NULL,NULL,NULL,'2026-04-23 12:52:11','2026-04-23 12:52:11'),(14,0,'2026-08-26',3,1,0,'Che Carpio','+12048050488','checarpio@icloud.com','no','email: checarpio@icloud.com',NULL,NULL,NULL,NULL,'2026-04-23 12:55:56','2026-04-23 12:55:56'),(15,0,'2026-07-02',5,1,0,'test','+373333333333','qwe@qwe.qwe','no','test',NULL,NULL,NULL,NULL,'2026-06-30 10:42:18','2026-06-30 10:42:18');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_users`
--

DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_users` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_users_role_id_foreign` (`role_id`),
  CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_users`
--

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timeslot`
--

DROP TABLE IF EXISTS `timeslot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timeslot` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wd_mon` tinyint(1) NOT NULL DEFAULT '0',
  `wd_tue` tinyint(1) NOT NULL DEFAULT '0',
  `wd_wed` tinyint(1) NOT NULL DEFAULT '0',
  `wd_thu` tinyint(1) NOT NULL DEFAULT '0',
  `wd_fri` tinyint(1) NOT NULL DEFAULT '0',
  `wd_sat` tinyint(1) NOT NULL DEFAULT '0',
  `wd_sun` tinyint(1) NOT NULL DEFAULT '0',
  `begin` int NOT NULL,
  `end` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timeslot`
--

LOCK TABLES `timeslot` WRITE;
/*!40000 ALTER TABLE `timeslot` DISABLE KEYS */;
INSERT INTO `timeslot` VALUES (5,1,1,1,1,1,1,1,600,1140,'2026-06-30 10:40:31','2026-06-30 10:40:31',NULL);
/*!40000 ALTER TABLE `timeslot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_timeslot_block`
--

DROP TABLE IF EXISTS `tour_timeslot_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_timeslot_block` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tour_id` int NOT NULL,
  `block_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_timeslot_block`
--

LOCK TABLES `tour_timeslot_block` WRITE;
/*!40000 ALTER TABLE `tour_timeslot_block` DISABLE KEYS */;
INSERT INTO `tour_timeslot_block` VALUES (2,-1,'2024-05-12','2024-05-10 19:37:01','2024-05-10 20:39:24');
/*!40000 ALTER TABLE `tour_timeslot_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tours` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_es` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `preview_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_text_fr` text COLLATE utf8mb4_unicode_ci,
  `preview_text_es` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_tour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fr` text COLLATE utf8mb4_unicode_ci,
  `description_es` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_count` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration_of_the_tour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `map_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_road_tour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'Private Sintra Half-Day 2 Pax',NULL,NULL,399.00,'Discover the enchanting beauty of Sintra with a private half-day tour, skipping the lines at two stunning palaces. Immerse yourself in royal history and breathtaking architecture without the wait.',NULL,NULL,'private-sintra-half-day-2-pax','private','<p><span style=\"color: rgb(26, 43, 73);\">Enchanting Tour of Sintra: A Guided Adventure from Lisbon</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Discover the wonders of Sintra on this unforgettable guided tour from Lisbon, blending history, mystery, and local flavors. Explore in a small group as your guide shares the captivating stories and secrets behind each location.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Your adventure begins with a visit to the iconic Pena Palace, perched majestically atop the Sintra hills. Admire its vibrant colors, extravagant architecture, and stunning panoramic views during an exterior visit. This emblem of Portuguese Romanticism is a must-see and a perfect start to your day.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Next, head to the picturesque Sintra village, where you’ll have time to stroll through charming streets, browse local shops, and immerse yourself in the town’s unique ambiance. Indulge in a tasting of two famous local pastries: the flaky, creamy Travesseiro and the traditional Queijada, a sweet treat that showcases the region\'s rich culinary heritage.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Finally, step into the magical and mysterious world of the Quinta da Regaleira, known for its gardens, grottoes, and enigmatic symbols. Explore its Gothic-inspired architecture, secret tunnels, and hidden stories as you unravel the mysteries of this enchanting estate.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">️ Important Note – Alternative Itinerary in Case of Closures:</span></p><p><span style=\"color: rgb(26, 43, 73);\">In rare situations when Pena Palace, Quinta da Regaleira, or both are closed — which may happen due to natural disasters, extreme weather conditions, or heat waves — the tour will still go ahead with an alternative plan.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">In such cases, the visit will include:</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The National Palace of Sintra, located in the heart of the village</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The elegant Queluz Palace, often called the “Portuguese Versailles”</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">This alternative ensures a rich and memorable experience while maintaining the spirit of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Practical Information:</span></p><p><span style=\"color: rgb(26, 43, 73);\">Tickets: No need to worry about purchasing tickets in advance—your guide will take care of everything. Simply reimburse the ticket costs in cash on the day of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Pena Palace: Tickets are bought online in advance. If there are queues at the entrance, we skip the ticket line for faster access.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Quinta da Regaleira: Tickets are pre-purchased to save time and ensure availability.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Group Size: Tours require a minimum of 4 participants.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Timing: Tour start times may vary. Morning tours sometimes begin at 8:30 AM, and during winter, afternoon tours start earlier, at 1:00 PM instead of 2:00 PM.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Confirmation: We’ll contact you the day before the tour to confirm your attendance and share all the details, including the guide’s contact information and the exact meeting point and time.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Join us for an enchanting journey through Sintra’s history, culture, and breathtaking scenery. Whether it’s your first visit or a return to this magical place, it promises to be an experience to remember!</span></p>',NULL,NULL,'10,25,26','8','5','Address1 - Address2','5','2024-04-30 15:02:54','2026-06-30 12:49:50','[\"65\"]','[\"76\"]','[\"32\"]','car',NULL,'500'),(7,'Half-Day Sintra Tour with Pena Palace and Regaleira',NULL,NULL,80.00,'Half-Day Sintra Tour with Pena Palace and Regaleira',NULL,NULL,'half-day-sintra-tour-with-pena-palace-and-regaleira','group','<p><strong style=\"color: rgb(0, 0, 0);\">Enchanting Tour of Sintra: A Guided Adventure from Lisbon</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Discover the wonders of Sintra on this unforgettable guided tour from Lisbon, blending history, mystery, and local flavors. Explore in a small group as your guide shares the captivating stories and secrets behind each location.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Your adventure begins with a visit to the iconic Pena Palace, perched majestically atop the Sintra hills. Admire its vibrant colors, extravagant architecture, and stunning panoramic views during an exterior visit. This emblem of Portuguese Romanticism is a must-see and a perfect start to your day.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Next, head to the picturesque Sintra village, where you’ll have time to stroll through charming streets, browse local shops, and immerse yourself in the town’s unique ambiance. Indulge in a tasting of two famous local pastries: the flaky, creamy Travesseiro and the traditional Queijada, a sweet treat that showcases the region\'s rich culinary heritage.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Finally, step into the magical and mysterious world of the Quinta da Regaleira, known for its gardens, grottoes, and enigmatic symbols. Explore its Gothic-inspired architecture, secret tunnels, and hidden stories as you unravel the mysteries of this enchanting estate.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">️ Important Note – Alternative Itinerary in Case of Closures:</strong></p><p><strong style=\"color: rgb(0, 0, 0);\">In rare situations when Pena Palace, Quinta da Regaleira, or both are closed — which may happen due to natural disasters, extreme weather conditions, or heat waves — the tour will still go ahead with an alternative plan.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">In such cases, the visit will include:</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">The National Palace of Sintra, located in the heart of the village</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">The elegant Queluz Palace, often called the “Portuguese Versailles”</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">This alternative ensures a rich and memorable experience while maintaining the spirit of the tour.</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Practical Information:</strong></p><p><strong style=\"color: rgb(0, 0, 0);\">Tickets: No need to worry about purchasing tickets in advance—your guide will take care of everything. Simply reimburse the ticket costs in cash on the day of the tour.</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Pena Palace: Tickets are bought online in advance. If there are queues at the entrance, we skip the ticket line for faster access.</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Quinta da Regaleira: Tickets are pre-purchased to save time and ensure availability.</strong></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Group Size: Tours require a minimum of 4 participants.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Timing: Tour start times may vary. Morning tours sometimes begin at 8:30 AM, and during winter, afternoon tours start earlier, at 1:00 PM instead of 2:00 PM.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Confirmation: We’ll contact you the day before the tour to confirm your attendance and share all the details, including the guide’s contact information and the exact meeting point and time.</strong></p><p><br></p><p><br></p><p><strong style=\"color: rgb(0, 0, 0);\">Join us for an enchanting journey through Sintra’s history, culture, and breathtaking scenery. Whether it’s your first visit or a return to this magical place, it promises to be an experience to remember!</strong></p>',NULL,NULL,'69,70,71,72,73','8','6','Hard Rock Cafe Lisboa Av. da Liberdade 2, 1250-144 Lisboa, Portugal','3','2024-05-13 20:44:22','2025-05-13 19:40:47',NULL,'[\"75\"]','[\"74\"]','car',NULL,'500'),(8,'Private Sintra Half-Day 4 Pax',NULL,NULL,450.00,'Discover the enchanting beauty of Sintra with a private half-day tour, skipping the lines at two stunning palaces. Immerse yourself in royal history and breathtaking architecture without the wait.',NULL,NULL,'private-sintra-half-day-4-pax','private','<p><span style=\"color: rgb(26, 43, 73);\">Enchanting Tour of Sintra: A Guided Adventure from Lisbon</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Discover the wonders of Sintra on this unforgettable guided tour from Lisbon, blending history, mystery, and local flavors. Explore in a small group as your guide shares the captivating stories and secrets behind each location.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Your adventure begins with a visit to the iconic Pena Palace, perched majestically atop the Sintra hills. Admire its vibrant colors, extravagant architecture, and stunning panoramic views during an exterior visit. This emblem of Portuguese Romanticism is a must-see and a perfect start to your day.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Next, head to the picturesque Sintra village, where you’ll have time to stroll through charming streets, browse local shops, and immerse yourself in the town’s unique ambiance. Indulge in a tasting of two famous local pastries: the flaky, creamy Travesseiro and the traditional Queijada, a sweet treat that showcases the region\'s rich culinary heritage.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Finally, step into the magical and mysterious world of the Quinta da Regaleira, known for its gardens, grottoes, and enigmatic symbols. Explore its Gothic-inspired architecture, secret tunnels, and hidden stories as you unravel the mysteries of this enchanting estate.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">️ Important Note – Alternative Itinerary in Case of Closures:</span></p><p><span style=\"color: rgb(26, 43, 73);\">In rare situations when Pena Palace, Quinta da Regaleira, or both are closed — which may happen due to natural disasters, extreme weather conditions, or heat waves — the tour will still go ahead with an alternative plan.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">In such cases, the visit will include:</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The National Palace of Sintra, located in the heart of the village</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The elegant Queluz Palace, often called the “Portuguese Versailles”</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">This alternative ensures a rich and memorable experience while maintaining the spirit of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Practical Information:</span></p><p><span style=\"color: rgb(26, 43, 73);\">Tickets: No need to worry about purchasing tickets in advance—your guide will take care of everything. Simply reimburse the ticket costs in cash on the day of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Pena Palace: Tickets are bought online in advance. If there are queues at the entrance, we skip the ticket line for faster access.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Quinta da Regaleira: Tickets are pre-purchased to save time and ensure availability.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Group Size: Tours require a minimum of 4 participants.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Timing: Tour start times may vary. Morning tours sometimes begin at 8:30 AM, and during winter, afternoon tours start earlier, at 1:00 PM instead of 2:00 PM.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Confirmation: We’ll contact you the day before the tour to confirm your attendance and share all the details, including the guide’s contact information and the exact meeting point and time.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Join us for an enchanting journey through Sintra’s history, culture, and breathtaking scenery. Whether it’s your first visit or a return to this magical place, it promises to be an experience to remember!</span></p>',NULL,NULL,'10,25,26','8','5','Address1 - Address2','3','2025-05-13 20:24:52','2025-05-13 20:25:29','[\"65\"]','[\"76\"]','[\"32\"]','car',NULL,'500'),(9,'Private Sintra Half-Day 6 Pax',NULL,NULL,550.00,'Discover the enchanting beauty of Sintra with a private half-day tour, skipping the lines at two stunning palaces. Immerse yourself in royal history and breathtaking architecture without the wait.',NULL,NULL,'private-sintra-half-day-6-pax','private','<p><span style=\"color: rgb(26, 43, 73);\">Enchanting Tour of Sintra: A Guided Adventure from Lisbon</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Discover the wonders of Sintra on this unforgettable guided tour from Lisbon, blending history, mystery, and local flavors. Explore in a small group as your guide shares the captivating stories and secrets behind each location.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Your adventure begins with a visit to the iconic Pena Palace, perched majestically atop the Sintra hills. Admire its vibrant colors, extravagant architecture, and stunning panoramic views during an exterior visit. This emblem of Portuguese Romanticism is a must-see and a perfect start to your day.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Next, head to the picturesque Sintra village, where you’ll have time to stroll through charming streets, browse local shops, and immerse yourself in the town’s unique ambiance. Indulge in a tasting of two famous local pastries: the flaky, creamy Travesseiro and the traditional Queijada, a sweet treat that showcases the region\'s rich culinary heritage.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Finally, step into the magical and mysterious world of the Quinta da Regaleira, known for its gardens, grottoes, and enigmatic symbols. Explore its Gothic-inspired architecture, secret tunnels, and hidden stories as you unravel the mysteries of this enchanting estate.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">️ Important Note – Alternative Itinerary in Case of Closures:</span></p><p><span style=\"color: rgb(26, 43, 73);\">In rare situations when Pena Palace, Quinta da Regaleira, or both are closed — which may happen due to natural disasters, extreme weather conditions, or heat waves — the tour will still go ahead with an alternative plan.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">In such cases, the visit will include:</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The National Palace of Sintra, located in the heart of the village</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The elegant Queluz Palace, often called the “Portuguese Versailles”</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">This alternative ensures a rich and memorable experience while maintaining the spirit of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Practical Information:</span></p><p><span style=\"color: rgb(26, 43, 73);\">Tickets: No need to worry about purchasing tickets in advance—your guide will take care of everything. Simply reimburse the ticket costs in cash on the day of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Pena Palace: Tickets are bought online in advance. If there are queues at the entrance, we skip the ticket line for faster access.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Quinta da Regaleira: Tickets are pre-purchased to save time and ensure availability.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Group Size: Tours require a minimum of 4 participants.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Timing: Tour start times may vary. Morning tours sometimes begin at 8:30 AM, and during winter, afternoon tours start earlier, at 1:00 PM instead of 2:00 PM.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Confirmation: We’ll contact you the day before the tour to confirm your attendance and share all the details, including the guide’s contact information and the exact meeting point and time.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Join us for an enchanting journey through Sintra’s history, culture, and breathtaking scenery. Whether it’s your first visit or a return to this magical place, it promises to be an experience to remember!</span></p>',NULL,NULL,'10,25,26','8','5','Address1 - Address2','3','2025-05-13 20:25:37','2025-05-13 20:25:51','[\"65\"]','[\"76\"]','[\"32\"]','car',NULL,'500'),(10,'Private Sintra Half-Day 8 Pax',NULL,NULL,650.00,'Discover the enchanting beauty of Sintra with a private half-day tour, skipping the lines at two stunning palaces. Immerse yourself in royal history and breathtaking architecture without the wait.',NULL,NULL,'private-sintra-half-day-8-pax','private','<p><span style=\"color: rgb(26, 43, 73);\">Enchanting Tour of Sintra: A Guided Adventure from Lisbon</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Discover the wonders of Sintra on this unforgettable guided tour from Lisbon, blending history, mystery, and local flavors. Explore in a small group as your guide shares the captivating stories and secrets behind each location.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Your adventure begins with a visit to the iconic Pena Palace, perched majestically atop the Sintra hills. Admire its vibrant colors, extravagant architecture, and stunning panoramic views during an exterior visit. This emblem of Portuguese Romanticism is a must-see and a perfect start to your day.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Next, head to the picturesque Sintra village, where you’ll have time to stroll through charming streets, browse local shops, and immerse yourself in the town’s unique ambiance. Indulge in a tasting of two famous local pastries: the flaky, creamy Travesseiro and the traditional Queijada, a sweet treat that showcases the region\'s rich culinary heritage.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Finally, step into the magical and mysterious world of the Quinta da Regaleira, known for its gardens, grottoes, and enigmatic symbols. Explore its Gothic-inspired architecture, secret tunnels, and hidden stories as you unravel the mysteries of this enchanting estate.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">️ Important Note – Alternative Itinerary in Case of Closures:</span></p><p><span style=\"color: rgb(26, 43, 73);\">In rare situations when Pena Palace, Quinta da Regaleira, or both are closed — which may happen due to natural disasters, extreme weather conditions, or heat waves — the tour will still go ahead with an alternative plan.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">In such cases, the visit will include:</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The National Palace of Sintra, located in the heart of the village</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">The elegant Queluz Palace, often called the “Portuguese Versailles”</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">This alternative ensures a rich and memorable experience while maintaining the spirit of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Practical Information:</span></p><p><span style=\"color: rgb(26, 43, 73);\">Tickets: No need to worry about purchasing tickets in advance—your guide will take care of everything. Simply reimburse the ticket costs in cash on the day of the tour.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Pena Palace: Tickets are bought online in advance. If there are queues at the entrance, we skip the ticket line for faster access.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Quinta da Regaleira: Tickets are pre-purchased to save time and ensure availability.</span></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Group Size: Tours require a minimum of 4 participants.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Timing: Tour start times may vary. Morning tours sometimes begin at 8:30 AM, and during winter, afternoon tours start earlier, at 1:00 PM instead of 2:00 PM.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Confirmation: We’ll contact you the day before the tour to confirm your attendance and share all the details, including the guide’s contact information and the exact meeting point and time.</span></p><p><br></p><p><br></p><p><span style=\"color: rgb(26, 43, 73);\">Join us for an enchanting journey through Sintra’s history, culture, and breathtaking scenery. Whether it’s your first visit or a return to this magical place, it promises to be an experience to remember!</span></p>',NULL,NULL,'10,25,26','8','5','Address1 - Address2','3','2025-05-13 20:26:00','2025-05-13 20:26:15','[\"65\"]','[\"76\"]','[\"32\"]','car',NULL,'500');
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permissions` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@admin.com',NULL,'$2y$12$klpf1UTJtTsm6fr1opOwM.6rILB3Z8MgIkZ60Mmr4JErR2iqIghCS','SGzVcjwc5mTTAOjLXcz8IgQRo7TNh1IcC74PQ2QBgVLNsHeuAXbzWKwrQ6zW','2024-04-30 11:54:24','2024-04-30 11:54:24','{\"platform.index\": true, \"platform.systems.roles\": true, \"platform.systems.users\": true, \"platform.systems.attachment\": true}');
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

-- Dump completed on 2026-07-10 17:30:49
