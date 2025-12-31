-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: kel12
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
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
-- Table structure for table `jadwals`
--

DROP TABLE IF EXISTS `jadwals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jadwals` (
  `id_jadwal` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_jadwal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `status_masuk` tinyint(1) NOT NULL DEFAULT 0,
  `jumlah_maxpasien` int(11) NOT NULL DEFAULT 30,
  `jumlah_pasien_hari_ini` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwals`
--

LOCK TABLES `jadwals` WRITE;
/*!40000 ALTER TABLE `jadwals` DISABLE KEYS */;
INSERT INTO `jadwals` VALUES (1,'2022-12-12','08:00:00','17:00:00',1,27,3,'2022-12-12 14:30:50','2022-12-12 14:39:30'),(2,'2022-12-13','08:00:00','17:00:00',0,30,0,'2022-12-12 14:31:08','2022-12-12 14:38:07'),(3,'2022-12-14','07:00:00','17:00:00',0,30,0,'2022-12-12 14:31:26','2022-12-12 14:38:03'),(4,'2022-12-15','07:00:00','17:00:00',0,30,0,'2022-12-12 14:31:26','2022-12-12 14:32:57'),(5,'2022-12-16','07:00:00','17:00:00',0,30,0,'2022-12-12 14:31:26','2022-12-12 14:31:26'),(6,'2022-12-17','07:00:00','17:00:00',0,30,0,'2022-12-12 14:31:26','2022-12-12 14:31:26'),(7,'2022-12-18','07:00:00','17:00:00',0,29,1,'2022-12-12 14:31:26','2022-12-18 13:41:31'),(8,'2022-12-19','10:00:00','20:00:00',0,30,0,'2022-12-18 03:37:08','2022-12-18 03:37:08');
/*!40000 ALTER TABLE `jadwals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2022_09_07_003020_create_jadwals_table',1),(5,'2022_09_09_011230_create_rekam_medis_table',1),(6,'2022_09_17_072321_create_reservasis_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekam_medis`
--

DROP TABLE IF EXISTS `rekam_medis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rekam_medis` (
  `id_rekam_medis` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nama_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kadar_gula_darah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `kadar_kolesterol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `kadar_asam_urat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `tekanan_darah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `alergi_makanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `tgl_periksa` date NOT NULL,
  `usia` int(11) NOT NULL,
  `keterangan` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rekam_medis`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekam_medis`
--

LOCK TABLES `rekam_medis` WRITE;
/*!40000 ALTER TABLE `rekam_medis` DISABLE KEYS */;
INSERT INTO `rekam_medis` VALUES (1,3,'Flu','Rio','90','100','69','120/90','Udang','2022-12-12',20,'Minum obat batuk','2022-12-12 14:44:50','2022-12-12 14:44:50');
/*!40000 ALTER TABLE `rekam_medis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservasis`
--

DROP TABLE IF EXISTS `reservasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservasis` (
  `id_reservasi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `tgl_reservasi` date NOT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status_hadir` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reservasi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservasis`
--

LOCK TABLES `reservasis` WRITE;
/*!40000 ALTER TABLE `reservasis` DISABLE KEYS */;
INSERT INTO `reservasis` VALUES (1,3,'2022-12-12','Riyanti','Sakit Perut',1,0,'2022-12-12 14:38:55','2022-12-12 14:38:55'),(2,3,'2022-12-12','Rio','Flu',2,1,'2022-12-12 14:39:12','2022-12-12 14:40:06'),(3,3,'2022-12-12','Bambang','Sakit Tenggorokan',3,2,'2022-12-12 14:39:30','2022-12-12 14:40:11'),(4,3,'2022-12-18','reynaldi','pilek',1,0,'2022-12-18 13:41:31','2022-12-18 13:41:31');
/*!40000 ALTER TABLE `reservasis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `birthday` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Fitria Uyainah','1','1999-01-04','Jl Raya Dukuh Kupang 31, Surabaya','082130005337','staff@gmail.com','$2y$10$7oNH0Hp8WAzRGKy2Wf/yXe5YUu4yZ6B1ZmQGp2BlfGx638dSbM1QO',NULL,'2022-12-12 14:23:12','2022-12-29 03:49:16'),(2,'Dr Reynaldi','2','1988-11-23','Jl Klampis Indah II D-26, Surabaya','082110004312','dokter@gmail.com','$2y$10$BGDxf0z0NnevMq30DhjBCOtNCgMPNMp/F8Cgwg2f4BWxrL44R4vru',NULL,'2022-12-12 14:23:12','2022-12-12 14:28:16'),(3,'Alika Nurdiyanti','0','2003-02-11','Jln. Veteran No. 357, Banjarbaru 95001, SumSel','082005559510','user@gmail.com','$2y$10$HkM7EnGyjPo1c20MDkhOZOif9DV7KBh8MMH2lPSWHQ9beIWyNkNeK',NULL,'2022-12-12 14:23:12','2022-12-12 14:29:10'),(4,'Farhunnisa Pratiwi','0','1978-07-12','Ds. Padma No. 910, Denpasar 94384, Maluku','0847 3337 9189','fhassanah@example.net','$2y$10$nzZ9hNp69G0vvKuewW3yv.TejpEswnqJPjmfb33TBodXJry1yEqG.',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(5,'Okto Latupono','0','1995-10-14','Psr. Panjaitan No. 748, Sibolga 58390, BaBel','0374 6739 4525','dsihombing@example.net','$2y$10$CFsxBmugU9WfTbDEnFv/h.ugGlQSxhLgTTwaSAr41RNn3p8Q3miAK',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(6,'Rahayu Andriani','0','2010-12-06','Jln. BKR No. 968, Administrasi Jakarta Barat 41762, Banten','(+62) 842 287 058','martani79@example.com','$2y$10$iNUrNfF7Pcnt/ElPQwbhVeIf5AhAN7eHnLUBaUAv0x3crGkpICpf2',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(7,'Luis Pradana','0','2010-07-08','Dk. Salatiga No. 603, Ambon 14567, Jambi','(+62) 898 475 903','puspasari.irma@example.org','$2y$10$iWR7tCH6JShqAb7KG8R6VeS34g6LlDilN4S3/.d/EEqfmu3A/bWB2',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(8,'Diana Yolanda','0','1997-03-20','Jr. Yoga No. 83, Binjai 34503, DKI','(+62) 392 9258 369','prasetyo.arta@example.com','$2y$10$wOJe91eKQKNN8hvDKaH6suHoj.uiKDWBLfDYgncoQpaZFE52m.w3i',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(9,'Harsana Januar','0','2006-07-01','Gg. Panjaitan No. 284, Banda Aceh 35855, KalTeng','(+62) 726 7005 6638','prayoga.eli@example.net','$2y$10$5OHB4fU8v9YHsGMxI0n/buK.GdV.K8rBZsF5Wa31FVdb6YAfzGoVS',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12'),(10,'Banawi Nugroho','0','1981-10-25','Kpg. Pelajar Pejuang 45 No. 785, Medan 47986, Maluku','0818 9517 9521','yoga16@example.org','$2y$10$H3DW9ugAuZ1PcGrxwKotc.31nUKHK58hUxcANAiJo.p4wT5o6ImLe',NULL,'2022-12-12 14:23:12','2022-12-12 14:23:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'kel12'
--

--
-- Dumping routines for database 'kel12'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-08 19:25:27
