/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cleanhub_ta
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `aksi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES
(1,8,'logout','Logout dari sistem','98.182.47.217','2026-09-24 10:18:22','2026-10-12 23:50:24'),
(2,1,'logout','Logout dari sistem','30.26.211.244','2026-09-17 22:33:35','2026-10-12 23:50:24'),
(3,10,'logout','Logout dari sistem','156.88.208.69','2026-10-11 03:58:14','2026-10-12 23:50:24'),
(4,7,'login','Login berhasil','101.110.112.117','2026-10-01 03:14:51','2026-10-12 23:50:24'),
(5,10,'login','Login berhasil','62.129.125.121','2026-10-07 09:19:48','2026-10-12 23:50:24'),
(6,16,'logout','Logout dari sistem','108.173.128.113','2026-09-21 02:36:23','2026-10-12 23:50:24'),
(7,4,'login','Login berhasil','172.121.61.92','2026-09-18 23:57:54','2026-10-12 23:50:24'),
(8,12,'login','Login berhasil','194.185.93.131','2026-10-11 23:52:23','2026-10-12 23:50:24'),
(9,16,'login','Login berhasil','76.167.88.10','2026-10-03 22:24:04','2026-10-12 23:50:24'),
(10,4,'logout','Logout dari sistem','73.59.163.161','2026-09-26 00:43:01','2026-10-12 23:50:24'),
(11,8,'login','Login berhasil','145.215.235.116','2026-10-06 11:39:34','2026-10-12 23:50:24'),
(12,16,'login','Login berhasil','127.75.77.52','2026-10-11 18:02:55','2026-10-12 23:50:24'),
(13,6,'logout','Logout dari sistem','88.125.207.158','2026-09-27 02:41:37','2026-10-12 23:50:24'),
(14,14,'logout','Logout dari sistem','215.251.52.135','2026-09-26 04:36:27','2026-10-12 23:50:24'),
(15,14,'login','Login berhasil','14.98.45.69','2026-10-11 11:50:45','2026-10-12 23:50:24'),
(16,15,'login','Login berhasil','46.13.60.249','2026-10-07 06:51:46','2026-10-12 23:50:24'),
(17,14,'logout','Logout dari sistem','89.26.160.209','2026-10-01 08:00:51','2026-10-12 23:50:24'),
(18,10,'logout','Logout dari sistem','176.25.229.174','2026-10-01 22:12:16','2026-10-12 23:50:24'),
(19,12,'login','Login berhasil','203.185.114.185','2026-09-27 10:58:50','2026-10-12 23:50:24'),
(20,16,'logout','Logout dari sistem','195.131.61.181','2026-09-29 20:35:00','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `konten` longtext NOT NULL,
  `kategori` enum('pemilahan','daur_ulang','kebersihan','pengelolaan') NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_user_id_foreign` (`user_id`),
  CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES
(1,1,'Cara Memilah Sampah dengan Benar','cara-memilah-sampah-dengan-benar',NULL,'Incidunt debitis autem expedita ut molestiae. Distinctio cumque iste fugit consequuntur vero enim dolorem. Numquam culpa sint in doloremque quidem minima.\n\nSaepe odit dolorem numquam id error quod impedit. Voluptatem est et voluptatem inventore est. Ea doloribus totam aut alias sequi.\n\nNon ut non ea id ut. Eos dolore esse et quis harum sapiente fugiat. Voluptatem non minus odit laborum vero. Qui praesentium aliquid ab est ab voluptatem qui. Voluptatem molestiae nam harum omnis excepturi eligendi qui non.','pemilahan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(2,1,'5 Kreasi Daur Ulang Botol Plastik','5-kreasi-daur-ulang-botol-plastik',NULL,'In voluptatem qui nostrum quisquam ut commodi eveniet. Sit dolorum rerum non earum dignissimos illo.\n\nConsequuntur odit qui consequatur dolorem itaque. Architecto iste nam a. Sed voluptas et accusamus corporis qui aut. Qui quo minus dolores eveniet.\n\nQui pariatur error laboriosam harum. Numquam praesentium velit laboriosam sed voluptas perferendis. Odit enim quia et ullam quae est eum.','daur_ulang',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(3,1,'Jadwal Pengangkutan Sampah Terbaru','jadwal-pengangkutan-sampah-terbaru',NULL,'Ea ab repudiandae inventore aspernatur commodi. Qui voluptatum rerum ea ullam tempora et. Illo deleniti consequuntur voluptatibus debitis alias qui voluptatem. Porro temporibus perferendis voluptas est.\n\nNihil est omnis aut nobis odio quo. Corrupti eaque omnis aut aliquam. Voluptas assumenda et quia expedita eaque nemo magni maiores. Eaque est animi ut porro voluptates blanditiis sed.\n\nPossimus accusantium reiciendis et voluptatem ipsa rem ea. Laboriosam eius rem amet non placeat provident quo. Delectus voluptatem odio ex sunt quibusdam repellendus dignissimos.','kebersihan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(4,1,'Mengolah Sampah Organik Menjadi Kompos','mengolah-sampah-organik-menjadi-kompos',NULL,'Incidunt qui et et sequi repellat. Repellat rem eligendi culpa neque. Dolorem nesciunt voluptatem quisquam provident aut dolores ea.\n\nQui dignissimos vitae animi iusto omnis et. Quam assumenda et animi et quaerat rem sit. Ullam nisi dolores sunt ut id architecto veritatis.\n\nLaboriosam inventore sint voluptatem itaque eos. Soluta dolorem aliquid ipsum officia voluptatum deleniti illum.','pengelolaan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(5,1,'Mengenal Sampah B3 di Lingkungan Rumah','mengenal-sampah-b3-di-lingkungan-rumah',NULL,'Et id et dicta sed. Culpa voluptatem rerum consequatur ut facilis quibusdam. In dolorem eveniet ullam magnam sed aut. Nesciunt voluptatem maxime dolores sint.\n\nVoluptas omnis labore quam voluptate et vel et qui. Deleniti cumque qui dolorem at repellendus illum sint nobis. Modi ut provident inventore quam nisi provident facilis. Accusantium cumque dicta minus facere quos dolore.\n\nSuscipit dolores aspernatur rerum eligendi tempore aspernatur ut. Quo et pariatur adipisci non quam ut et ut. Quam officia necessitatibus ut sint est enim. Aut itaque alias sed suscipit veritatis quae voluptas.','pemilahan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(6,1,'Manfaat Bank Sampah bagi Warga','manfaat-bank-sampah-bagi-warga',NULL,'Ut fugiat eius aut praesentium et et dolorum. Assumenda consequatur sint ut natus possimus. Voluptatem quae labore facilis quam explicabo quis nemo.\n\nAut aut cupiditate est ut molestias dignissimos doloremque. Molestiae assumenda aut architecto. Aspernatur in et qui quisquam.\n\nQuos rerum est cupiditate molestiae ea non ut et. Voluptatem sit eveniet deserunt officiis. Quae ab provident ipsum rerum mollitia dolorum. Dolorem reprehenderit expedita saepe natus quasi atque nemo sed.','pengelolaan',0,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(7,1,'Tips Menjaga Selokan Tetap Bersih','tips-menjaga-selokan-tetap-bersih',NULL,'Omnis praesentium aspernatur deserunt quibusdam doloribus. Sit maiores et earum et. Architecto magnam consectetur qui quia. In corporis incidunt nihil assumenda voluptas.\n\nArchitecto id iusto dolorum aut optio deleniti ut. Deleniti et ut reprehenderit est a. Aut sunt ipsa maxime ea. Molestiae ea aut possimus eaque labore. Quae et exercitationem amet voluptas velit ab.\n\nAb soluta incidunt aut ut et eos. Et pariatur nostrum ullam consequuntur et. Voluptatem sit facilis exercitationem quis aut ex. Inventore est eos dolore.','kebersihan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(8,1,'Kreasi Tas Belanja dari Kain Perca','kreasi-tas-belanja-dari-kain-perca',NULL,'A necessitatibus voluptatem perferendis consequatur. Explicabo aut sed similique ab. Ea a id distinctio laboriosam labore vel.\n\nEos consectetur mollitia voluptas reiciendis magni assumenda ut. Repudiandae consequatur dolores rerum unde. Voluptatem molestiae ipsam dolorem nam culpa numquam. Ipsum cum nihil repellendus debitis voluptatibus alias ea. Deleniti tempora necessitatibus eius assumenda consectetur consequatur.\n\nConsectetur tempore debitis facere eos sunt. Similique modi et nobis omnis. Sunt est voluptate et est.','daur_ulang',1,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(9,1,'Mengurangi Sampah Plastik Sekali Pakai','mengurangi-sampah-plastik-sekali-pakai',NULL,'Deleniti minima soluta atque veritatis. Dolor molestiae facilis quaerat veniam officia iure facere. Assumenda in nesciunt neque recusandae unde.\n\nDolorem quo quis dolore. Eos enim non blanditiis ratione recusandae eum aut. A aut a corporis molestiae corrupti nihil. Nemo ipsa voluptas officiis beatae expedita asperiores veritatis.\n\nAperiam ab soluta optio. Maiores nostrum amet eos eum animi. Omnis unde quia facilis et beatae voluptas enim consequatur. Est fugit sed ad autem.','pemilahan',0,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(10,1,'Gotong Royong Membersihkan Lingkungan RW','gotong-royong-membersihkan-lingkungan-rw',NULL,'Sit provident expedita aperiam impedit. At maxime excepturi provident sint aliquid. Voluptate nemo odio culpa aut. Atque sunt et corporis accusamus debitis.\n\nAnimi cum sit recusandae est minima eius. Quae qui vero est error velit. Et quidem ullam aspernatur est quasi excepturi. Eum iusto et doloribus dolores sit eligendi. Vel possimus autem animi aut quae corrupti.\n\nAnimi deleniti eveniet omnis voluptas alias et ut unde. Quis quis occaecati reiciendis est porro non. Esse dolore earum ea repudiandae. Porro rem porro corporis perferendis voluptatem.','kebersihan',1,'2026-10-12 23:50:24','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint(20) unsigned NOT NULL,
  `officer_id` bigint(20) unsigned NOT NULL,
  `assigned_by` bigint(20) unsigned DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('pending','diterima','selesai') NOT NULL DEFAULT 'pending',
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `selesai_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_report_id_foreign` (`report_id`),
  KEY `assignments_officer_id_foreign` (`officer_id`),
  KEY `assignments_assigned_by_foreign` (`assigned_by`),
  CONSTRAINT `assignments_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `assignments_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`id`),
  CONSTRAINT `assignments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `waste_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES
(1,1,3,1,'Pilah sampah sebelum diangkut ke TPS.','pending','2026-09-23 11:54:12',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(2,2,2,1,'Koordinasi dengan ketua RT setempat.','selesai','2026-10-07 09:33:24','2026-10-07 23:07:04','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(3,4,3,1,'Pilah sampah sebelum diangkut ke TPS.','diterima','2026-09-07 16:55:57',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(4,5,4,1,'Pilah sampah sebelum diangkut ke TPS.','diterima','2026-09-08 10:47:52',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(5,6,3,1,'Angkut tumpukan sampah sebelum pukul 10.00.','diterima','2026-09-23 12:07:25',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(6,10,3,1,'Pilah sampah sebelum diangkut ke TPS.','diterima','2026-10-09 05:55:18',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(7,13,2,1,'Bersihkan saluran air di lokasi.','diterima','2026-09-19 00:30:03',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(8,15,3,1,'Pilah sampah sebelum diangkut ke TPS.','pending','2026-09-18 04:34:33',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(9,17,2,1,'Koordinasi dengan ketua RT setempat.','diterima','2026-10-08 08:09:16',NULL,'2026-10-12 23:50:24','2026-10-12 23:50:24'),
(10,18,3,1,'Koordinasi dengan ketua RT setempat.','selesai','2026-10-03 18:04:15','2026-10-07 23:35:08','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(11,19,4,1,'Bersihkan saluran air di lokasi.','selesai','2026-10-09 09:40:42','2026-10-11 15:41:46','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(12,20,3,1,'Angkut tumpukan sampah sebelum pukul 10.00.','selesai','2026-09-29 02:25:35','2026-09-30 23:29:51','2026-10-12 23:50:24','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES
(1,'Saluran Air Tentara Pelajar','Jln. Sunaryo No. 118',-6.93151624,107.66568699,'Antapani','Antapani Wetan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(2,'Taman Banceng Pondok','Ds. Kalimalang No. 896',-6.93700466,107.67093834,'Ujungberung','Pasanggrahan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(3,'Taman Gotong Royong','Jr. Flora No. 192',-6.93367809,107.65568094,'Ujungberung','Pasirjati','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(4,'Saluran Air Batako','Ds. Pintu Besar Selatan No. 583',-6.92197263,107.68928374,'Ujungberung','Pasanggrahan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(5,'TPS Bazuka Raya','Jln. Dago No. 580',-6.92759770,107.68170566,'Antapani','Antapani Wetan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(6,'Saluran Air Baing','Jln. Bacang No. 850',-6.91691023,107.68451094,'Antapani','Antapani Kidul','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(7,'TPS Ahmad Dahlan','Gg. Cikutra Barat No. 482',-6.91880114,107.69708092,'Arcamanik','Cisaranten Endah','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(8,'Taman Adisucipto','Kpg. Baya Kali Bungur No. 990',-6.93303636,107.65775300,'Ujungberung','Cigending','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(9,'Taman Batako','Dk. Moch. Yamin No. 495',-6.92222726,107.68219399,'Arcamanik','Sindangjaya','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(10,'Saluran Air Abang','Jln. Dewi Sartika No. 302',-6.92033645,107.67540083,'Ujungberung','Cigending','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(11,'TPS Dahlia','Ds. Lada No. 894',-6.90224847,107.66315208,'Antapani','Antapani Wetan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(12,'Lahan Kosong Rajawali Barat','Psr. Suprapto No. 551',-6.92600790,107.67793528,'Antapani','Cisaranten Bina Harapan','2026-10-12 23:50:23','2026-10-12 23:50:23');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2026_06_20_000000_create_support_messages_table',1),
(2,'2026_10_12_234848_create_roles_table',1),
(3,'2026_10_12_234849_create_users_table',1),
(4,'2026_10_12_234850_create_waste_categories_table',1),
(5,'2026_10_12_234852_create_locations_table',1),
(6,'2026_10_12_234853_create_waste_reports_table',1),
(7,'2026_10_12_234854_create_officers_table',1),
(8,'2026_10_12_234855_create_assignments_table',1),
(9,'2026_10_12_234856_create_report_images_table',1),
(10,'2026_10_12_234857_create_articles_table',1),
(11,'2026_10_12_234858_create_notifications_table',1),
(12,'2026_10_12_234900_create_activity_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('info','success','warning','danger') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES
(1,8,'Laporan Diverifikasi','Laporan #5 Anda telah diverifikasi oleh admin.','info',1,'2026-09-29 19:37:32','2026-10-12 23:50:24'),
(2,2,'Laporan Diterima','Laporan #17 Anda telah diterima dan sedang diverifikasi.','info',0,'2026-09-18 09:42:13','2026-10-12 23:50:24'),
(3,15,'Laporan Diverifikasi','Laporan #13 Anda telah diverifikasi oleh admin.','info',0,'2026-10-04 19:19:25','2026-10-12 23:50:24'),
(4,10,'Laporan Diverifikasi','Laporan #11 Anda telah diverifikasi oleh admin.','info',1,'2026-09-15 19:29:35','2026-10-12 23:50:24'),
(5,11,'Laporan Diverifikasi','Laporan #5 Anda telah diverifikasi oleh admin.','info',1,'2026-09-14 16:00:43','2026-10-12 23:50:24'),
(6,15,'Laporan Diterima','Laporan #17 Anda telah diterima dan sedang diverifikasi.','info',0,'2026-09-23 03:42:15','2026-10-12 23:50:24'),
(7,8,'Laporan Diterima','Laporan #9 Anda telah diterima dan sedang diverifikasi.','info',0,'2026-10-02 06:11:30','2026-10-12 23:50:24'),
(8,15,'Laporan Diverifikasi','Laporan #17 Anda telah diverifikasi oleh admin.','info',0,'2026-09-16 09:38:46','2026-10-12 23:50:24'),
(9,11,'Laporan Diverifikasi','Laporan #14 Anda telah diverifikasi oleh admin.','info',1,'2026-09-22 09:44:18','2026-10-12 23:50:24'),
(10,11,'Laporan Selesai','Laporan #20 Anda telah berhasil ditangani oleh petugas.','success',0,'2026-10-02 08:36:53','2026-10-12 23:50:24'),
(11,6,'Laporan Diverifikasi','Laporan #5 Anda telah diverifikasi oleh admin.','info',0,'2026-09-25 11:10:57','2026-10-12 23:50:24'),
(12,7,'Laporan Diverifikasi','Laporan #15 Anda telah diverifikasi oleh admin.','info',1,'2026-10-02 02:21:17','2026-10-12 23:50:24'),
(13,14,'Tugas Baru','Anda mendapat tugas baru untuk menangani laporan #4.','warning',1,'2026-09-27 12:51:28','2026-10-12 23:50:24'),
(14,3,'Laporan Diverifikasi','Laporan #19 Anda telah diverifikasi oleh admin.','info',0,'2026-10-09 00:45:32','2026-10-12 23:50:24'),
(15,15,'Laporan Selesai','Laporan #16 Anda telah berhasil ditangani oleh petugas.','success',1,'2026-09-27 05:38:36','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officers`
--

DROP TABLE IF EXISTS `officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `officers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `area_kerja` varchar(150) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `officers_user_id_unique` (`user_id`),
  CONSTRAINT `officers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officers`
--

LOCK TABLES `officers` WRITE;
/*!40000 ALTER TABLE `officers` DISABLE KEYS */;
INSERT INTO `officers` VALUES
(1,2,'Ujungberung – Antapani Tengah',82500.00,'aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(2,3,'Arcamanik – Pasanggrahan',112500.00,'aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(3,5,'Ujungberung – Antapani Tengah',15000.00,'aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(4,6,'Ujungberung – Cisaranten Kidul',120000.00,'aktif','2026-10-12 23:50:24','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `officers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_images`
--

DROP TABLE IF EXISTS `report_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint(20) unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('foto','video') NOT NULL DEFAULT 'foto',
  `is_bukti_selesai` tinyint(1) NOT NULL DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_images_report_id_foreign` (`report_id`),
  CONSTRAINT `report_images_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `waste_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_images`
--

LOCK TABLES `report_images` WRITE;
/*!40000 ALTER TABLE `report_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` enum('admin','petugas','masyarakat') NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'admin','Administrator','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(2,'petugas','Petugas Kebersihan','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(3,'masyarakat','Masyarakat','2026-10-12 23:50:23','2026-10-12 23:50:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_messages`
--

DROP TABLE IF EXISTS `support_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(150) DEFAULT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_messages`
--

LOCK TABLES `support_messages` WRITE;
/*!40000 ALTER TABLE `support_messages` DISABLE KEYS */;
INSERT INTO `support_messages` VALUES
(1,'Wahyu Sirait','puspasari.daliono@example.com','Cara membuat laporan','LITTLE larger, sir, if you were never even introduced to a mouse, you know. Come on!\' So they couldn\'t get them out of the house!\' (Which was very like a sky-rocket!\' \'So you think you might do very.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(2,'Zelda Kuswandari S.T.','padmasari.kemba@example.net','Laporan belum diverifikasi','The Frog-Footman repeated, in the house, quite forgetting in the air. \'--as far out to sea!\" But the snail replied \"Too far, too far!\" and gave a sudden burst of tears, \'I do wish they WOULD put.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(3,'Dariati Tampubolon','yramadan@example.com','Lupa password akun','THEIR eyes bright and eager with many a strange tale, perhaps even with the clock. For instance, suppose it were white, but there were ten of them, and it\'ll sit up and walking away. \'You insult me.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(4,'Jessica Puput Pertiwi S.IP','aryani.ilsa@example.com','Laporan belum diverifikasi','Alice said; but was dreadfully puzzled by the time at the end of the house, \"Let us both go to on the end of trials, \"There was some attempts at applause, which was the cat.) \'I hope they\'ll.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(5,'Kusuma Daniswara Simbolon','cager82@example.net','Lupa password akun','On various pretexts they all stopped and looked at her, and said, \'So you did, old fellow!\' said the Cat, \'or you wouldn\'t mind,\' said Alice: \'besides, that\'s not a bit afraid of it. She stretched.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(6,'Jumari Pranowo','lintang.halim@example.org','Cara membuat laporan','So Alice began to repeat it, when a sharp hiss made her look up and down in a day is very confusing.\' \'It isn\'t,\' said the Hatter, with an important air, \'are you all ready? This is the same year.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(7,'Amalia Uyainah','koko.irawan@example.com','Laporan belum diverifikasi','She was walking by the officers of the hall: in fact she was playing against herself, for she felt that she did not much surprised at this, that she had this fit) An obstacle that came between Him.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(8,'Cici Nasyidah','nasyiah.eka@example.org','Saran untuk CleanHub','The three soldiers wandered about in the air. She did it at all,\' said the Cat, \'a dog\'s not mad. You grant that?\' \'I suppose they are the jurors.\' She said the King, who had spoken first. \'That\'s.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(9,'Uchita Novitasari M.Ak','edi55@example.com','Lupa password akun','WOULD not remember the simple rules their friends had taught them: such as, \'Sure, I don\'t believe you do lessons?\' said Alice, rather doubtfully, as she had nothing else to do, so Alice soon came.','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(10,'Jarwadi Maheswara S.H.','ani.saptono@example.org','Cara membuat laporan','White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' said the Caterpillar took the hookah out of sight, they were mine before. If I or she fell very slowly, for she was appealed.','2026-10-12 23:50:24','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `support_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL DEFAULT 3,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,1,'Admin CleanHub','admin','admin@cleanhub.id','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1995-05-26','0891 9830 5098','Kpg. Ters. Kiaracondong No. 528, Surabaya 10086, Aceh','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(2,2,'Budi Santoso','budi_petugas','petugas@cleanhub.id','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1993-04-27','(+62) 524 4037 6901','Ki. Sukabumi No. 216, Solok 56912, Sumsel','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(3,2,'Rahmat Hidayat','rahmat_pet','rahmat@cleanhub.id','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1982-09-01','023 1901 952','Ds. Baha No. 905, Palangka Raya 72636, Jateng','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(4,3,'Sari Dewi','sari_user','user@cleanhub.id','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','1970-12-01','(+62) 308 0039 9546','Dk. Rajawali Timur No. 599, Administrasi Jakarta Selatan 46147, Riau','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(5,2,'Tiara Astuti','lanjar66','dabukke.dinda@example.com','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','1982-10-08','0667 0176 0605','Psr. Veteran No. 373, Cirebon 45472, Kalbar','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(6,2,'Lasmanto Saragih','hpuspita','aastuti@example.com','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1977-11-29','(+62) 953 5618 834','Ds. Warga No. 196, Bekasi 53308, Sulbar','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(7,3,'Kasim Timbul Lazuardi','betania10','virman39@example.org','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1973-01-29','(+62) 779 6478 045','Ki. Baranang Siang No. 133, Yogyakarta 25949, Sumbar','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(8,3,'Mahdi Damanik','vnuraini','twastuti@example.net','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1998-11-25','0845 9502 5335','Jln. Bagis Utama No. 306, Samarinda 28440, Kalbar','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(9,3,'Yunita Lestari','mprasasta','lmelani@example.net','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','1985-07-29','022 9086 507','Ki. Supomo No. 455, Palembang 92926, Sulbar','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(10,3,'Argono Nababan S.E.','malika.waskita','kuswoyo.gantar@example.net','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','2000-02-27','(+62) 621 4083 804','Ki. Rajawali Timur No. 220, Dumai 95063, Sumut','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(11,3,'Vera Gasti Pratiwi S.T.','banawi56','intan02@example.com','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','2007-08-11','(+62) 223 9116 8679','Jln. Gatot Subroto No. 834, Bengkulu 59070, Bali','default.png','nonaktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(12,3,'Ayu Haryanti S.H.','novi55','kezia15@example.org','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','2000-05-21','0498 8391 2637','Psr. Tubagus Ismail No. 225, Cilegon 88758, Bengkulu','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(13,3,'Wira Thamrin','suartini.ade','mayasari.maman@example.net','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1997-01-05','024 5616 9286','Dk. Rajawali No. 846, Bogor 22812, Jatim','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(14,3,'Laksana Gunawan M.Pd','edison01','zmandasari@example.org','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1997-07-11','(+62) 440 9597 062','Psr. Tambun No. 117, Tangerang 35442, Kalteng','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(15,3,'Eli Salsabila Suartini','sriyanti','ioktaviani@example.org','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','P','1977-04-26','(+62) 590 8393 1433','Dk. Labu No. 829, Bau-Bau 95314, Jateng','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24'),
(16,3,'Mahmud Saragih','firmansyah.pia','permata.gada@example.org','$2y$12$NQE8wdGarghtO5t06JmwGuJWAs4PB9OieE.C1WFuc1MTQTMOyVY.S','L','1985-06-21','(+62) 454 3488 8118','Kpg. Sam Ratulangi No. 3, Administrasi Jakarta Pusat 91613, Jambi','default.png','aktif','2026-10-12 23:50:24','2026-10-12 23:50:24');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waste_categories`
--

DROP TABLE IF EXISTS `waste_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `waste_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT 'fa-trash',
  `warna` varchar(10) DEFAULT '#6c757d',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waste_categories`
--

LOCK TABLES `waste_categories` WRITE;
/*!40000 ALTER TABLE `waste_categories` DISABLE KEYS */;
INSERT INTO `waste_categories` VALUES
(1,'Plastik/Kering','Sampah plastik, botol, dan anorganik kering','fa-wine-bottle','#00bcd4','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(2,'Organik/Basah','Sampah organik, sisa makanan, dan daun','fa-leaf','#28a745','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(3,'Bangunan Liar','Puing bangunan, material konstruksi, besi tua','fa-hard-hat','#ffc107','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(4,'B3 / Berbahaya','Baterai, elektronik bekas, obat kadaluarsa','fa-skull-crossbones','#dc3545','2026-10-12 23:50:23','2026-10-12 23:50:23'),
(5,'Campuran','Sampah campur yang belum dipilah','fa-dumpster','#6c757d','2026-10-12 23:50:23','2026-10-12 23:50:23');
/*!40000 ALTER TABLE `waste_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waste_reports`
--

DROP TABLE IF EXISTS `waste_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `waste_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('diajukan','diverifikasi','diproses','ditangani','selesai') NOT NULL DEFAULT 'diajukan',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `alamat_detail` text DEFAULT NULL,
  `iuran` decimal(10,2) NOT NULL DEFAULT 15000.00,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `waste_reports_user_id_foreign` (`user_id`),
  KEY `waste_reports_category_id_foreign` (`category_id`),
  KEY `waste_reports_location_id_foreign` (`location_id`),
  KEY `waste_reports_status_index` (`status`),
  CONSTRAINT `waste_reports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `waste_categories` (`id`),
  CONSTRAINT `waste_reports_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `waste_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waste_reports`
--

LOCK TABLES `waste_reports` WRITE;
/*!40000 ALTER TABLE `waste_reports` DISABLE KEYS */;
INSERT INTO `waste_reports` VALUES
(1,10,2,4,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','diproses',-6.92197263,107.68928374,'Saluran Air Batako',15000.00,0,'2026-09-06 21:22:49','2026-09-06 21:22:49'),
(2,14,1,1,'Tempat pembuangan sementara sudah penuh dan sampah meluber ke jalan.','selesai',-6.93151624,107.66568699,'Saluran Air Tentara Pelajar',15000.00,0,'2026-09-28 01:00:39','2026-09-28 01:00:39'),
(3,12,5,4,'Sampah menumpuk di pinggir jalan dan mulai menimbulkan bau tidak sedap.','diverifikasi',-6.92197263,107.68928374,'Saluran Air Batako',15000.00,0,'2026-10-08 12:11:31','2026-10-08 12:11:31'),
(4,7,1,2,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','ditangani',-6.93700466,107.67093834,'Taman Banceng Pondok',15000.00,0,'2026-09-04 04:18:57','2026-09-04 04:18:57'),
(5,4,4,7,'Tempat pembuangan sementara sudah penuh dan sampah meluber ke jalan.','diproses',-6.91880114,107.69708092,'TPS Ahmad Dahlan',15000.00,1,'2026-09-07 19:11:29','2026-09-07 19:11:29'),
(6,4,4,8,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','ditangani',-6.93303636,107.65775300,'Taman Adisucipto',15000.00,0,'2026-09-05 12:08:24','2026-09-05 12:08:24'),
(7,16,5,5,'Botol dan kantong plastik berserakan di sekitar taman bermain anak.','diverifikasi',-6.92759770,107.68170566,'TPS Bazuka Raya',15000.00,0,'2026-09-17 04:12:51','2026-09-17 04:12:51'),
(8,14,3,11,'Sampah campur dibuang ke pinggir sungai dan mengganggu aliran air.','diverifikasi',-6.90224847,107.66315208,'TPS Dahlia',15000.00,0,'2026-09-20 23:47:49','2026-09-20 23:47:49'),
(9,13,1,4,'Botol dan kantong plastik berserakan di sekitar taman bermain anak.','diajukan',-6.92197263,107.68928374,'Saluran Air Batako',15000.00,1,'2026-10-04 04:13:52','2026-10-04 04:13:52'),
(10,7,2,2,'Sampah menumpuk di pinggir jalan dan mulai menimbulkan bau tidak sedap.','ditangani',-6.93700466,107.67093834,'Taman Banceng Pondok',15000.00,0,'2026-09-10 20:23:35','2026-09-10 20:23:35'),
(11,15,4,4,'Ditemukan baterai bekas dan barang elektronik rusak di tempat sampah umum.','diverifikasi',-6.92197263,107.68928374,'Saluran Air Batako',15000.00,1,'2026-10-09 11:22:24','2026-10-09 11:22:24'),
(12,8,5,8,'Botol dan kantong plastik berserakan di sekitar taman bermain anak.','diverifikasi',-6.93303636,107.65775300,'Taman Adisucipto',15000.00,1,'2026-08-25 05:47:13','2026-08-25 05:47:13'),
(13,12,4,2,'Botol dan kantong plastik berserakan di sekitar taman bermain anak.','diproses',-6.93700466,107.67093834,'Taman Banceng Pondok',15000.00,1,'2026-09-15 21:50:47','2026-09-15 21:50:47'),
(14,11,4,9,'Botol dan kantong plastik berserakan di sekitar taman bermain anak.','diajukan',-6.92222726,107.68219399,'Taman Batako',15000.00,0,'2026-09-09 11:26:06','2026-09-09 11:26:06'),
(15,11,5,8,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','diproses',-6.93303636,107.65775300,'Taman Adisucipto',15000.00,0,'2026-08-23 19:31:11','2026-08-23 19:31:11'),
(16,11,3,7,'Ditemukan baterai bekas dan barang elektronik rusak di tempat sampah umum.','diverifikasi',-6.91880114,107.69708092,'TPS Ahmad Dahlan',15000.00,1,'2026-08-23 23:18:52','2026-08-23 23:18:52'),
(17,4,1,1,'Sampah menumpuk di pinggir jalan dan mulai menimbulkan bau tidak sedap.','ditangani',-6.93151624,107.66568699,'Saluran Air Tentara Pelajar',15000.00,0,'2026-08-26 18:27:50','2026-08-26 18:27:50'),
(18,10,1,4,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','selesai',-6.92197263,107.68928374,'Saluran Air Batako',15000.00,0,'2026-10-02 13:38:54','2026-10-02 13:38:54'),
(19,10,5,9,'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.','selesai',-6.92222726,107.68219399,'Taman Batako',15000.00,0,'2026-10-05 00:30:27','2026-10-05 00:30:27'),
(20,7,5,NULL,'Tempat pembuangan sementara sudah penuh dan sampah meluber ke jalan.','selesai',NULL,NULL,'Jln. Basoka No. 641, Gorontalo 50446, Aceh',15000.00,0,'2026-09-24 03:24:23','2026-09-24 03:24:23');
/*!40000 ALTER TABLE `waste_reports` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-12 23:50:51
