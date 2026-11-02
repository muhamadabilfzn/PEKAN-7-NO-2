-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 03:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cleanhub_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_status` (IN `p_laporan_id` INT UNSIGNED, IN `p_status_baru` VARCHAR(30), IN `p_user_id` INT UNSIGNED, IN `p_catatan` TEXT)   BEGIN
    DECLARE v_status_lama VARCHAR(30);

    SELECT status INTO v_status_lama FROM laporan WHERE id = p_laporan_id FOR UPDATE;

    UPDATE laporan SET status = p_status_baru WHERE id = p_laporan_id;

    INSERT INTO riwayat_status (laporan_id, status_lama, status_baru, diubah_oleh, catatan)
    VALUES (p_laporan_id, v_status_lama, p_status_baru, p_user_id, p_catatan);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `aksi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `aksi`, `deskripsi`, `ip_address`, `created_at`) VALUES
(1, 6, 'login', 'Login berhasil', '::1', '2026-06-14 23:56:53'),
(2, 6, 'logout', 'Logout dari sistem', '::1', '2026-06-15 00:00:04'),
(3, 2, 'login', 'Login berhasil', '::1', '2026-06-15 00:07:07'),
(4, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-15 00:07:54'),
(5, 1, 'login', 'Login berhasil', '::1', '2026-06-15 00:08:14'),
(6, 1, 'logout', 'Logout dari sistem', '::1', '2026-06-15 00:11:32'),
(7, 2, 'login', 'Login berhasil', '::1', '2026-06-15 00:12:16'),
(8, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-15 00:13:01'),
(9, 4, 'login', 'Login berhasil', '::1', '2026-06-15 00:13:23'),
(10, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-15 00:15:52'),
(11, 1, 'login', 'Login berhasil', '::1', '2026-06-15 00:16:40'),
(12, 1, 'login', 'Login berhasil', '::1', '2026-06-15 06:26:45'),
(13, 1, 'logout', 'Logout dari sistem', '::1', '2026-06-15 06:35:30'),
(14, 4, 'login', 'Login berhasil', '::1', '2026-06-15 06:35:46'),
(15, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-15 06:37:24'),
(16, 2, 'login', 'Login berhasil', '::1', '2026-06-15 06:37:36'),
(17, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-15 06:39:34'),
(18, 2, 'login', 'Login berhasil', '::1', '2026-06-15 12:18:00'),
(19, 1, 'login', 'Login berhasil', '::1', '2026-06-16 11:02:22'),
(20, 2, 'login', 'Login berhasil', '::1', '2026-06-16 13:53:39'),
(21, 2, 'login', 'Login berhasil', '::1', '2026-06-17 06:25:33'),
(22, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-17 06:25:37'),
(23, 4, 'login', 'Login berhasil', '::1', '2026-06-17 06:25:47'),
(24, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-17 06:27:43'),
(25, 4, 'login', 'Login berhasil', '::1', '2026-06-17 06:27:46'),
(26, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-17 06:27:59'),
(27, 1, 'login', 'Login berhasil', '::1', '2026-06-17 06:28:16'),
(28, 1, 'login', 'Login berhasil', '::1', '2026-06-17 08:54:56'),
(29, 1, 'logout', 'Logout dari sistem', '::1', '2026-06-17 08:55:29'),
(30, 2, 'login', 'Login berhasil', '::1', '2026-06-17 08:56:34'),
(31, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-17 08:58:04'),
(32, 1, 'login', 'Login berhasil', '::1', '2026-06-17 09:29:07'),
(33, 2, 'login', 'Login berhasil', '::1', '2026-06-17 14:47:30'),
(34, 2, 'logout', 'Logout dari sistem', '::1', '2026-06-17 14:49:08'),
(35, 4, 'login', 'Login berhasil', '::1', '2026-06-17 14:49:20'),
(36, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-17 14:50:05'),
(37, 4, 'login', 'Login berhasil', '::1', '2026-06-18 13:44:47'),
(38, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-18 13:44:53'),
(39, 4, 'login', 'Login berhasil', '::1', '2026-06-18 13:49:27'),
(40, 4, 'logout', 'Logout dari sistem', '::1', '2026-06-18 13:49:31'),
(41, 1, 'login', 'Login berhasil', '::1', '2026-06-18 13:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `konten` longtext NOT NULL,
  `kategori` enum('pemilahan','daur_ulang','kebersihan','pengelolaan') NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `judul`, `slug`, `thumbnail`, `konten`, `kategori`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cara Memilah Sampah dengan Benar', 'cara-memilah-sampah', NULL, 'Memilah sampah adalah langkah awal menjaga kebersihan lingkungan. Pisahkan sampah organik, anorganik, dan B3 ke tempat berbeda sejak dari rumah.', 'pemilahan', 1, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(2, 1, '5 Kreasi Daur Ulang Botol Plastik', 'daur-ulang-botol-plastik', NULL, 'Botol plastik bekas dapat disulap menjadi pot tanaman, tempat pensil, hingga mainan anak yang kreatif. Yuk kurangi sampah plastik dengan kreasi sederhana!', 'daur_ulang', 1, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(3, 1, 'Jadwal Pengangkutan Sampah Terbaru', 'jadwal-pengangkutan-sampah', NULL, 'Pengangkutan sampah mingguan dijadwalkan setiap Senin dan Kamis pukul 06.00-08.00. Warga dimohon menyiapkan sampah sebelum pukul 06.00.', 'kebersihan', 1, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(4, 1, 'Pengelolaan Sampah Organik Menjadi Kompos', 'pengelolaan-sampah-kompos', NULL, 'Sampah organik rumah tangga seperti sisa sayuran dan buah dapat diolah menjadi kompos yang berguna untuk pupuk tanaman. Simak caranya di sini.', 'pengelolaan', 1, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(5, 1, 'pelaku penyebab banjir', 'pelaku-penyebab-banjir', NULL, 'konten ini berisikan nama nama pelaku yg membuang sampah sembarangan di kampung bandung ini yg berisial nk dan am  trus merekam membuang sampah di sungai yg mengakibatkan desa kita banjir se pingganng selama 4 hari', 'kebersihan', 1, '2026-06-17 06:33:50', '2026-06-17 06:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `report_id` int(10) UNSIGNED NOT NULL,
  `officer_id` int(10) UNSIGNED NOT NULL,
  `assigned_by` int(10) UNSIGNED DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('pending','diterima','selesai') NOT NULL DEFAULT 'pending',
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `selesai_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `report_id`, `officer_id`, `assigned_by`, `catatan`, `status`, `assigned_at`, `selesai_at`) VALUES
(2, 2, 1, 1, 'Bersihkan saluran air RT 05', 'diterima', '2026-06-14 02:45:23', NULL),
(3, 5, 2, 1, 'Angkut puing dari lahan kosong', 'diterima', '2026-06-14 02:45:23', NULL),
(4, 7, 2, 1, 'Bersihkan selokan RT 05', 'selesai', '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(5, 9, 1, 1, '', 'selesai', '2026-06-15 00:08:52', '2026-06-14 19:12:43'),
(6, 3, 2, 1, '', 'pending', '2026-06-15 00:11:05', NULL),
(7, 6, 1, 1, '', 'selesai', '2026-06-15 00:11:23', '2026-06-15 01:37:49'),
(8, 10, 2, 1, '', 'pending', '2026-06-17 06:36:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_lokasi` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `nama_lokasi`, `alamat`, `latitude`, `longitude`, `kecamatan`, `kelurahan`) VALUES
(1, 'TPS Arcamanik', 'Jl. Arcamanik Endah No.1', -6.91750000, 107.67710000, 'Arcamanik', 'Cisaranten Endah'),
(2, 'TPS Parakan Saat', 'Jl. Parakan Saat No.2', -6.92100000, 107.68200000, 'Arcamanik', 'Cisaranten Kidul'),
(3, 'TPS Antapani', 'Jl. Antapani Raya No.10', -6.91000000, 107.67000000, 'Antapani', 'Antapani Tengah'),
(4, 'Saluran Air RT 05', 'Depan Masjid Al-Ikhlas RT 05/02', -6.91850000, 107.67850000, 'Arcamanik', 'Cisaranten Endah'),
(5, 'Lahan Kosong Blok C', 'Lahan kosong belakang perumahan', -6.92300000, 107.68500000, 'Arcamanik', 'Cisaranten Kidul');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('info','success','warning','danger') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `judul`, `pesan`, `tipe`, `is_read`, `created_at`) VALUES
(1, 4, 'Laporan Diterima', 'Laporan #1 Anda telah diterima dan sedang diverifikasi.', 'info', 1, '2026-06-14 02:45:23'),
(2, 4, 'Laporan Selesai', 'Laporan #1 Anda telah berhasil ditangani oleh petugas.', 'success', 1, '2026-06-14 02:45:23'),
(3, 4, 'Laporan Diproses', 'Laporan #2 Anda sedang diproses oleh Budi Santoso.', 'info', 0, '2026-06-14 02:45:23'),
(4, 2, 'Tugas Baru', 'Anda mendapat tugas baru untuk laporan #2.', 'warning', 0, '2026-06-14 02:45:23'),
(5, 5, 'Laporan Diverifikasi', 'Laporan #4 Anda telah diverifikasi oleh admin.', 'info', 0, '2026-06-14 02:45:23'),
(6, 6, 'Laporan Berhasil Dikirim', 'Laporan #9 Anda telah diterima dan akan segera diverifikasi.', 'success', 0, '2026-06-14 23:58:46'),
(7, 6, 'Laporan Diverifikasi', 'Laporan #9 Anda telah diverifikasi oleh admin.', 'info', 0, '2026-06-15 00:08:37'),
(8, 2, 'Tugas Baru', 'Anda mendapat tugas baru untuk menangani laporan #9', 'warning', 0, '2026-06-15 00:08:52'),
(9, 6, 'Laporan Sedang Diproses', 'Laporan #9 Anda sedang diproses oleh petugas kebersihan.', 'info', 0, '2026-06-15 00:08:52'),
(10, 5, 'Laporan Diverifikasi', 'Laporan #3 Anda telah diverifikasi oleh admin.', 'info', 0, '2026-06-15 00:10:53'),
(11, 3, 'Tugas Baru', 'Anda mendapat tugas baru untuk menangani laporan #3', 'warning', 0, '2026-06-15 00:11:05'),
(12, 5, 'Laporan Sedang Diproses', 'Laporan #3 Anda sedang diproses oleh petugas kebersihan.', 'info', 0, '2026-06-15 00:11:05'),
(13, 5, 'Laporan Diverifikasi', 'Laporan #6 Anda telah diverifikasi oleh admin.', 'info', 0, '2026-06-15 00:11:15'),
(14, 2, 'Tugas Baru', 'Anda mendapat tugas baru untuk menangani laporan #6', 'warning', 0, '2026-06-15 00:11:23'),
(15, 5, 'Laporan Sedang Diproses', 'Laporan #6 Anda sedang diproses oleh petugas kebersihan.', 'info', 0, '2026-06-15 00:11:23'),
(16, 6, 'Laporan Selesai Ditangani!', 'Laporan #9 Anda telah berhasil ditangani oleh petugas. Terima kasih!', 'success', 0, '2026-06-15 00:12:43'),
(17, 5, 'Laporan Selesai Ditangani!', 'Laporan #6 Anda telah berhasil ditangani oleh petugas. Terima kasih!', 'success', 0, '2026-06-15 06:37:49'),
(18, 4, 'Laporan Berhasil Dikirim', 'Laporan #10 Anda telah diterima dan akan segera diverifikasi.', 'success', 0, '2026-06-17 06:26:40'),
(19, 4, 'Laporan Berhasil Dikirim', 'Laporan #11 Anda telah diterima dan akan segera diverifikasi.', 'success', 0, '2026-06-17 06:27:27'),
(20, 4, 'Laporan Diverifikasi', 'Laporan #10 Anda telah diverifikasi oleh admin.', 'info', 0, '2026-06-17 06:36:49'),
(21, 3, 'Tugas Baru', 'Anda mendapat tugas baru untuk menangani laporan #10', 'warning', 0, '2026-06-17 06:36:54'),
(22, 4, 'Laporan Sedang Diproses', 'Laporan #10 Anda sedang diproses oleh petugas kebersihan.', 'info', 0, '2026-06-17 06:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `area_kerja` varchar(150) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`id`, `user_id`, `area_kerja`, `saldo`, `status`) VALUES
(1, 2, 'Arcamanik – Cisaranten Endah', 75000.00, 'aktif'),
(2, 3, 'Antapani – Cisaranten Kidul', 30000.00, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `report_images`
--

CREATE TABLE `report_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `report_id` int(10) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('foto','video') NOT NULL DEFAULT 'foto',
  `is_bukti_selesai` tinyint(1) NOT NULL DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` enum('admin','petugas','masyarakat') NOT NULL,
  `display_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`) VALUES
(1, 'admin', 'Administrator'),
(2, 'petugas', 'Petugas Kebersihan'),
(3, 'masyarakat', 'Masyarakat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 3,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `nama_lengkap`, `username`, `email`, `password`, `jenis_kelamin`, `tanggal_lahir`, `no_hp`, `alamat`, `foto_profil`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin CleanHub', 'admin', 'admin@cleanhub.id', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'L', NULL, '081200000001', 'Kantor Desa Cisaranten Endah, Bandung', 'default.png', 'aktif', '2026-06-14 02:45:23', '2026-06-15 00:06:01'),
(2, 2, 'Budi Santoso', 'budi_petugas', 'petugas@cleanhub.id', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'L', NULL, '081200000002', 'Jl. Parakan Saat No. 10, Bandung', 'default.png', 'aktif', '2026-06-14 02:45:23', '2026-06-15 00:06:01'),
(3, 2, 'Rahmat Hidayat', 'rahmat_pet', 'rahmat@cleanhub.id', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'L', NULL, '081200000003', 'Jl. Cisaranten No. 5, Bandung', 'default.png', 'aktif', '2026-06-14 02:45:23', '2026-06-15 00:06:01'),
(4, 3, 'Sari Dewi', 'sari_user', 'user@cleanhub.id', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'P', NULL, '081200000004', 'Jl. Arcamanik No. 3, Bandung', 'default.png', 'aktif', '2026-06-14 02:45:23', '2026-06-15 00:06:01'),
(5, 3, 'Andi Wijaya', 'andi_user', 'andi@cleanhub.id', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'L', NULL, '081200000005', 'Jl. Antapani No. 7, Bandung', 'default.png', 'aktif', '2026-06-14 02:45:23', '2026-06-15 00:06:01'),
(6, 3, 'Muhammad Rasyid Winarno', 'occyd14@gmail.com', 'occyd14@gmail.com', '$2y$10$RznJCcKoDVf9cXotA/oYRugXpL24Vr32HB0x.LBMIIaOUNq361wCS', 'L', '2007-06-29', '081219849901', 'jalan rukun saluyu', 'default.png', 'aktif', '2026-06-14 23:56:38', '2026-06-15 00:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `waste_categories`
--

CREATE TABLE `waste_categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT 'fa-trash',
  `warna` varchar(10) DEFAULT '#6c757d'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waste_categories`
--

INSERT INTO `waste_categories` (`id`, `nama`, `deskripsi`, `icon`, `warna`) VALUES
(1, 'Plastik/Kering', 'Sampah plastik, botol, dan anorganik kering', 'fa-wine-bottle', '#00bcd4'),
(2, 'Organik/Basah', 'Sampah organik, sisa makanan, dan daun', 'fa-leaf', '#28a745'),
(3, 'Bangunan Liar', 'Puing bangunan, material konstruksi, besi tua', 'fa-hard-hat', '#ffc107'),
(4, 'B3 / Berbahaya', 'Baterai, elektronik bekas, obat kadaluarsa', 'fa-skull-crossbones', '#dc3545'),
(5, 'Campuran', 'Sampah campur yang belum dipilah', 'fa-dumpster', '#6c757d');

-- --------------------------------------------------------

--
-- Table structure for table `waste_reports`
--

CREATE TABLE `waste_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('diajukan','diverifikasi','diproses','ditangani','selesai') NOT NULL DEFAULT 'diajukan',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `alamat_detail` text DEFAULT NULL,
  `iuran` decimal(10,2) NOT NULL DEFAULT 15000.00,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waste_reports`
--

INSERT INTO `waste_reports` (`id`, `user_id`, `category_id`, `location_id`, `deskripsi`, `status`, `latitude`, `longitude`, `alamat_detail`, `iuran`, `is_paid`, `created_at`, `updated_at`) VALUES
(2, 4, 2, 4, 'Sampah organik menyumbat saluran air, menimbulkan bau tidak sedap.', 'diproses', -6.91850000, 107.67850000, 'Saluran Air RT 05', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(3, 5, 3, 2, 'Puing bangunan dibuang sembarangan di pinggir jalan.', 'diproses', -6.92100000, 107.68200000, 'Jl. Parakan Saat depan warung', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 19:11:05'),
(4, 5, 1, 3, 'Botol plastik berserakan di sekitar taman bermain anak.', 'diverifikasi', -6.91000000, 107.67000000, 'Taman Bermain Antapani', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(5, 4, 5, 5, 'Sampah campur menumpuk di lahan kosong sudah lebih dari seminggu.', 'ditangani', -6.92300000, 107.68500000, 'Lahan kosong blok C', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(6, 5, 4, 1, 'Ditemukan baterai bekas dan HP rusak dibuang di TPS tanpa penanganan khusus.', 'selesai', -6.91750000, 107.67710000, 'TPS Arcamanik area pojok', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-15 01:37:49'),
(7, 4, 2, 4, 'Selokan penuh sampah daun dan sisa makanan, potensi banjir.', 'selesai', -6.91850000, 107.67850000, 'Selokan RT 05 dekat pos ronda', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(8, 5, 1, 3, 'Kantong plastik menggantung di pohon dan berserakan.', 'diproses', -6.91000000, 107.67000000, 'Jl. Antapani depan minimarket', 15000.00, 0, '2026-06-14 02:45:23', '2026-06-14 02:45:23'),
(9, 6, 2, NULL, 'gvhbcfbcfvbn', 'selesai', NULL, NULL, 'Koordinat: -6.9710157, 107.6283768 (GPS Akurat)', 15000.00, 0, '2026-06-14 23:58:46', '2026-06-14 19:12:43'),
(10, 4, 4, NULL, 'fghhgfdrhjkijuhygt', 'ditangani', NULL, NULL, 'Koordinat: -6.9733047, 107.6324983 (GPS Akurat)', 15000.00, 0, '2026-06-17 06:26:40', '2026-06-17 01:37:07'),
(11, 4, 4, NULL, 'nhgfeswa;lkjtre', 'diajukan', NULL, NULL, 'Koordinat: -6.9733047, 107.6324983 (GPS Akurat)', 15000.00, 0, '2026-06-17 06:27:27', '2026-06-17 06:27:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD KEY `fk_article_user` (`user_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assign_report` (`report_id`),
  ADD KEY `fk_assign_officer` (`officer_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_officer_user` (`user_id`);

--
-- Indexes for table `report_images`
--
ALTER TABLE `report_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_img_report` (`report_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Indexes for table `waste_categories`
--
ALTER TABLE `waste_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `fk_report_location` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_images`
--
ALTER TABLE `report_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `waste_categories`
--
ALTER TABLE `waste_categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `waste_reports`
--
ALTER TABLE `waste_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `fk_assign_officer` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`id`),
  ADD CONSTRAINT `fk_assign_report` FOREIGN KEY (`report_id`) REFERENCES `waste_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `fk_officer_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_images`
--
ALTER TABLE `report_images`
  ADD CONSTRAINT `fk_img_report` FOREIGN KEY (`report_id`) REFERENCES `waste_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD CONSTRAINT `fk_report_category` FOREIGN KEY (`category_id`) REFERENCES `waste_categories` (`id`),
  ADD CONSTRAINT `fk_report_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
