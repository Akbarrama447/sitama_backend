-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 10:55 AM
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
-- Database: `sitamafinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_prodi`
--

DROP TABLE IF EXISTS `admin_prodi`;
CREATE TABLE `admin_prodi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `prodi_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

DROP TABLE IF EXISTS `bimbingan`;
CREATE TABLE `bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_akhir_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(20) NOT NULL,
  `urutan` tinyint(4) NOT NULL COMMENT 'urutan pembimbing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`id`, `tugas_akhir_id`, `dosen_nip`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 1, '198119046338', 1, '2025-10-26 15:34:05', '2025-10-26 15:34:05'),
(2, 1, '198946122444', 2, '2025-10-26 15:34:05', '2025-10-26 15:34:05'),
(3, 2, '198617040828', 1, '2025-11-09 05:02:11', NULL),
(4, 2, '198936489906', 2, '2025-11-09 05:02:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan_log`
--

DROP TABLE IF EXISTS `bimbingan_log`;
CREATE TABLE `bimbingan_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bimbingan_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mhs_nim` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan_log`
--

INSERT INTO `bimbingan_log` (`id`, `bimbingan_id`, `judul`, `deskripsi`, `tanggal`, `catatan`, `status`, `file_path`, `created_at`, `updated_at`, `mhs_nim`) VALUES
(14, 1, 'knjkjngdfhg', 'knkjnvkjfngkj', '2025-11-28', NULL, 1, NULL, '2025-11-28 02:08:58', '2025-12-18 17:40:32', 110127515),
(15, 1, 'ngkdnfgndfk', 'dkngkjdngkldfngkfd', '2025-11-28', NULL, 1, NULL, '2025-11-28 02:09:20', '2025-12-18 18:15:18', 110127515),
(16, 1, 'fghfghfgjmbnm', '[rlyhopfjhoifojfgophjdp', '2025-11-28', NULL, 1, NULL, '2025-11-28 02:09:38', '2025-12-18 18:24:26', 110127515),
(20, 1, 'dnksdjnfkd', 'bkabsdkabsdkasd', '2025-12-02', NULL, 1, NULL, '2025-12-01 23:42:22', '2025-12-18 17:12:55', 110127515),
(21, 1, 'ksfksdfk', 'knvn vmc', '2025-12-02', NULL, 1, NULL, '2025-12-02 02:20:32', '2025-12-18 17:13:04', 110127515),
(22, 1, 'svsdf', 'sdfd', '2025-12-14', NULL, 1, NULL, '2025-12-14 01:42:52', '2025-12-18 16:57:52', 110127515),
(24, 1, 'Bimbingan final? or not', 'aduhai capek', '0000-00-00', NULL, 1, NULL, NULL, NULL, NULL),
(25, 1, 'Aduhai', 'tomyam', '0000-00-00', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_label` varchar(255) NOT NULL,
  `setting_type` enum('binary','value','ref') DEFAULT 'value',
  `setting_value` varchar(255) NOT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `setting_key`, `setting_label`, `setting_type`, `setting_value`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'min_bimbingan', 'Minimal Bimbingan Disetujui', 'value', '8', 1, '2025-12-18 05:22:53', '2025-12-18 05:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_sidang`
--

DROP TABLE IF EXISTS `dokumen_sidang`;
CREATE TABLE `dokumen_sidang` (
  `dokumen_id` bigint(20) UNSIGNED NOT NULL,
  `dokumen_syarat` varchar(50) DEFAULT NULL,
  `dokumen_file` varchar(100) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `tipe_dokumen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_sidang`
--

INSERT INTO `dokumen_sidang` (`dokumen_id`, `dokumen_syarat`, `dokumen_file`, `verified`, `keterangan`, `tipe_dokumen`) VALUES
(1, 'Proposal', '/template/proposal.docx', 1, 'Dokumen proposal penelitian', 'docx'),
(2, 'Laporan Akhir', '/template/laporan.pdf', 1, 'Laporan akhir tugas akhir', 'pdf'),
(3, 'Transkrip Nilai', '/template/transkrip.pdf', 1, 'Transkrip nilai terbaru', 'pdf'),
(4, 'KRS', '/template/krs.pdf', 1, 'Kartu Rencana Studi', 'pdf'),
(5, 'Surat Keterangan Aktif', '/template/surat_aktif.pdf', 1, 'Surat keterangan aktif kuliah', 'pdf'),
(6, 'Persetujuan Pembimbing', '/template/persetujuan_pembimbing.pdf', 1, 'Surat persetujuan dari dosen pembimbing', 'pdf'),
(7, 'Beasiswa', '/template/beasiswa.pdf', 1, 'Surat keterangan beasiswa (jika ada)', 'pdf'),
(8, 'Logbook Bimbingan', '/template/logbook.pdf', 1, 'Rekap logbook bimbingan', 'pdf');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `prodi_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nama` varchar(255) NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `user_id`, `prodi_id`, `dosen_nama`, `dosen_nip`, `created_at`, `updated_at`) VALUES
(1, 51, 3, 'Muttabik Fathul Latief', '198119046338', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(2, 52, 3, 'Amran Yobioktabera', '198946122444', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(3, 53, 4, 'Suko Tyas P', '198311338302', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(4, 54, 3, 'Sukamto', '198936489906', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(5, 55, 3, 'Eri Lavandi', '198924088196', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(6, 56, 3, 'Liliek Triyono', '198617040828', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(7, 57, 1, 'Teresa Orn', '198576047301', '2025-10-22 06:09:33', '2025-10-22 06:09:33'),
(8, 58, 2, 'Bryana Langworth DDS', '198159090874', '2025-10-22 06:09:33', '2025-10-22 06:09:33'),
(9, 59, 2, 'Victoria Smith', '198561883760', '2025-10-22 06:09:33', '2025-10-22 06:09:33'),
(10, 60, 1, 'Randi Bruen', '198303080943', '2025-10-22 06:09:33', '2025-10-22 06:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_penguji`
--

DROP TABLE IF EXISTS `dosen_penguji`;
CREATE TABLE `dosen_penguji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sidang_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `peran` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen_penguji`
--

INSERT INTO `dosen_penguji` (`id`, `sidang_id`, `dosen_nip`, `peran`, `created_at`, `updated_at`) VALUES
(2, 5, '198936489906', '1', '2025-11-09 05:00:01', NULL),
(3, 5, '198924088196', '2', '2025-11-09 05:00:01', NULL),
(5, 5, '198159090874', '3', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_sidang`
--

DROP TABLE IF EXISTS `jadwal_sidang`;
CREATE TABLE `jadwal_sidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `sesi_id` bigint(20) UNSIGNED NOT NULL,
  `ruangan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_sidang`
--

INSERT INTO `jadwal_sidang` (`id`, `tanggal`, `sesi_id`, `ruangan_id`, `created_at`, `updated_at`) VALUES
(1, '2025-12-03', 1, 1, '2025-11-03 03:57:46', '2025-11-03 03:57:46'),
(2, '2025-11-11', 2, 1, '2025-11-09 04:48:41', '2025-11-09 04:48:41'),
(3, '2025-11-11', 1, 2, '2025-11-09 04:58:38', NULL),
(4, '2025-12-13', 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

DROP TABLE IF EXISTS `jurusan`;
CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'Teknik Elektro', '2025-10-22 06:09:21', '2025-10-22 06:09:21'),
(2, 'Teknik Mesin', '2025-10-22 06:09:21', '2025-10-22 06:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `mhs_nim` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `prodi_id` bigint(20) UNSIGNED NOT NULL,
  `mhs_nama` varchar(255) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`mhs_nim`, `user_id`, `prodi_id`, `mhs_nama`, `tahun_masuk`, `created_at`, `updated_at`) VALUES
(110120206, 45, 2, 'Mittie O\'Hara', '1980', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(110120689, 44, 2, 'Dasia Schinner', '1983', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110120969, 42, 2, 'Dr. Shawn O\'Connell DVM', '1970', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110121078, 28, 2, 'Heloise Hane', '1999', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110121158, 9, 1, 'Miss Theresa Von', '2020', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110121212, 6, 2, 'Zoe Kertzmann', '2004', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110122154, 20, 2, 'Kristina D\'Amore', '2000', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110122354, 36, 2, 'Eloise Kiehn', '1983', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110122399, 49, 2, 'Irwin Bayer', '1997', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(110122449, 48, 2, 'Adah Cassin DDS', '1983', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(110122601, 1, 1, 'Wika Dwi Aprilia', '1972', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110122731, 34, 2, 'Joany Boyer', '1982', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110123067, 18, 1, 'Levi Dickens DDS', '1981', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110123113, 17, 2, 'Thora Kuhn', '2021', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110123348, 37, 2, 'Willow Morar', '2015', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110123402, 5, 1, 'Dwight Ryan', '1988', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110123778, 24, 2, 'Emil Macejkovic', '1994', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110123801, 16, 2, 'Adele Klocko', '1975', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110124003, 15, 2, 'Oran Hilpert', '1979', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110124421, 2, 2, 'Kendra Koelpin', '2000', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110124728, 21, 2, 'Kip Gleichner', '1971', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110125213, 33, 2, 'Jackeline Hermann', '1983', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110125663, 22, 2, 'Nedra Dickens', '1975', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110126092, 46, 2, 'Lucio Brekke III', '2013', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(110126447, 31, 2, 'Joel O\'Kon', '2002', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110126453, 41, 2, 'Stuart Howe', '2013', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110126462, 32, 1, 'Dr. Katelin Crist V', '1976', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110126640, 4, 2, 'Eldora Stark I', '2021', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110126643, 29, 2, 'Guy Schoen', '1974', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110126684, 19, 1, 'Haskell Cronin', '1997', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110126737, 13, 2, 'Arthur Will', '2008', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110126745, 39, 1, 'Jarod Greenholt II', '1987', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110126792, 11, 2, 'Theron Hickle', '1994', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110127038, 27, 2, 'Alanis Ratke', '1971', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110127063, 38, 2, 'Kelly Casper', '1992', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110127515, 23, 1, 'Gennaro Kutch DVM', '1998', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110127552, 40, 1, 'Bridgette Torp', '2011', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110127701, 14, 2, 'Sophia Jacobson', '1994', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110127716, 3, 1, 'Mr. Beau Renner', '2017', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110127721, 7, 1, 'Malcolm Kovacek', '1992', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110127746, 26, 2, 'Bernhard Oberbrunner', '1989', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110127911, 10, 1, 'Willis Denesik', '1973', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110128060, 35, 2, 'Prof. Jayme Ward PhD', '1974', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110128273, 30, 2, 'Mrs. Shany Herman', '2023', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110128963, 25, 1, 'Ms. Jailyn Kshlerin I', '1993', '2025-10-22 06:09:29', '2025-10-22 06:09:29'),
(110129006, 12, 2, 'Norma Jacobs I', '1991', '2025-10-22 06:09:28', '2025-10-22 06:09:28'),
(110129047, 50, 1, 'Prof. Gregory Reynolds DDS', '1996', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(110129388, 43, 1, 'Dr. Natasha Mills', '1971', '2025-10-22 06:09:30', '2025-10-22 06:09:30'),
(110129690, 8, 1, 'Eriberto Kuhic', '2012', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(110129917, 47, 1, 'Mr. Modesto Haley IV', '2017', '2025-10-22 06:09:31', '2025-10-22 06:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `parent_id`, `order`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Menu Manajemen', '#', 0, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(2, 'Dashboard', 'home', 1, 1, 'fas fa-home', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(3, 'Manajemen Pengguna', '#', 1, 2, 'fas fa-users-cog', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(4, 'Kelola Pengguna', 'manage-user', 3, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(5, 'Kelola Role', 'manage-role', 3, 2, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(6, 'Kelola Menu', 'manage-menu', 3, 3, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(7, 'Backup Server', '#', 0, 2, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(8, 'Backup Database', 'dbbackup', 7, 1, 'fas fa-database', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(9, 'Dosen', '#', 0, 1, 'fas fa-graduation-cap', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(10, 'Mahasiswa Bimbingan', 'bimbingan', 9, 1, 'fas fa-user-graduate', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(11, 'Sidang Tugas Akhir', 'sidang-ta', 9, 1, 'fas fa-scroll', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(12, 'Menu Manajemen', '#', 0, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(13, 'Dashboard', 'home', 12, 1, 'fas fa-home', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(14, 'Manajemen Pengguna', '#', 12, 2, 'fas fa-users-cog', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(15, 'Kelola Pengguna', 'manage-user', 14, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(16, 'Menu Manajemen', '#', 0, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(17, 'Dashboard', 'home', 16, 1, 'fas fa-home', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(18, 'Manajemen Pengguna', '#', 16, 2, 'fas fa-users-cog', '2025-12-15 09:50:16', '2025-12-15 09:50:16'),
(19, 'Kelola Pengguna', 'manage-user', 18, 1, NULL, '2025-12-15 09:50:16', '2025-12-15 09:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_20_062914_buat_tabel_jurusan', 1),
(5, '2025_10_20_062914_buat_tabel_prodi', 1),
(6, '2025_10_20_062915_buat_tabel_dosen', 1),
(7, '2025_10_20_062915_buat_tabel_mahasiswa', 1),
(8, '2025_10_20_062916_buat_tabel_admin', 1),
(9, '2025_10_20_062916_buat_tabel_admin_prodi', 1),
(10, '2025_10_20_062916_buat_tabel_prodi_dosen', 1),
(11, '2025_10_20_064624_buat_tabel_ruangan', 1),
(12, '2025_10_20_064624_buat_tabel_sesi', 1),
(13, '2025_10_20_065423_buat_tabel_tugas_akhir', 1),
(14, '2025_10_20_065424_buat_tabel_bimbingan', 1),
(15, '2025_10_20_065424_buat_tabel_tugas_akhir_anggota', 1),
(16, '2025_10_20_065425_buat_tabel_bimbingan_log', 1),
(17, '2025_10_20_065826_buat_tabel_jadwal_sidang', 1),
(18, '2025_10_20_065826_buat_tabel_sidang__tugas__akhir', 1),
(19, '2025_10_20_065826_buat_tabel_syarat_sidang', 1),
(20, '2025_10_20_065827_buat_tabel_dosen_penguji', 1),
(21, '2025_10_20_070121_buat_tabel_unsur_nilai_pembimbing', 1),
(22, '2025_10_20_070121_buat_tabel_unsur_nilai_penguji', 1),
(23, '2025_10_20_070122_buat_tabel_nilai_dosen_pembimbing', 1),
(24, '2025_10_20_070122_buat_tabel_nilai_dosen_penguji', 1),
(25, '2025_10_20_070123_buat_tabel_revisi_tugas_akhir', 1),
(26, '2025_10_22_122515_create_personal_access_tokens_table', 1),
(27, '2025_10_22_130000_add_file_path_to_bimbingan_log_table', 2),
(29, '2025_11_24_032409_add_mhs_nim_to_bimbingan_log_table', 3),
(32, '2025_11_29_000001_perbaikan_hapus_semua_tabel_tidak_digunakan', 5),
(33, '2025_11_29_000002_buat_tabel_dokumen_sidang', 5),
(34, '2025_12_07_000000_revisi_struktur_dokumen_sidang', 6),
(35, '2025_12_07_000001_cleanup_failed_migration', 6),
(36, '2025_12_07_000002_pembersihan_awal', 7),
(37, '2025_12_07_000003_kembali_ke_kondisi_awal', 8),
(42, '2025_12_07_000005_tambah_fitur_syarat_sidang', 9),
(46, '2025_12_07_000004_reset_ke_kondisi_awal', 10),
(47, '2025_12_07_000007_tambah_kolom_syarat_sidang', 10),
(48, '2025_12_07_000008_struktur_pm_kamu', 10),
(49, '2025_12_07_000009_hapus_kolom_wajib', 11),
(51, '2025_12_07_000010_hapus_kolom_user_id', 12),
(52, '2014_10_12_000000_create_users_table', 13),
(53, '2014_10_12_100000_create_password_resets_table', 13),
(54, '2019_08_19_000000_create_failed_jobs_table', 14),
(55, '2019_12_14_000001_create_personal_access_tokens_table', 14),
(56, '2024_01_01_000001_create_nilai_system_tables', 14),
(57, '2024_01_01_000002_create_dosen_penguji_table', 14),
(58, '2024_01_01_000003_create_unsur_nilai_dosen_pembimbing_table', 14),
(59, '2024_01_01_000004_create_nilai_dosen_penguji_table', 14),
(60, '2024_01_01_234158_create_menus_table', 14),
(61, '2024_02_02_053619_create_permission_tables', 14),
(62, '2024_02_03_232722_create_role_has_menus_tables', 14),
(63, '2024_02_03_235312_add_menu_id_on_permission', 14),
(64, '2025_11_18_080822_create_bimbingans_table', 14),
(65, '2025_11_18_080833_create_dosens_table', 14),
(66, '2025_11_28_000001_add_columns_to_bimbingan_table', 14),
(67, '2025_11_28_000002_update_dosen_relationships_for_transition', 14),
(68, '2025_11_28_000003_create_unsur_nilai_dosen_penguji_table', 14),
(69, '2025_11_28_000004_rename_unsur_nilai_tables', 14),
(70, '2025_11_28_000005_update_unsur_nilai_pembimbing_structure', 14),
(71, '2025_11_28_000006_create_or_update_unsur_nilai_penguji_structure', 14),
(72, '2025_12_18_115101_create_configs_table', 14),
(73, '2025_12_18_202855_add_menu_id_to_permissions_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 61),
(2, 'App\\Models\\User', 61);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 61),
(2, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(2, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_dosen_pembimbing`
--

DROP TABLE IF EXISTS `nilai_dosen_pembimbing`;
CREATE TABLE `nilai_dosen_pembimbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sidang_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `unsur_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_dosen_pembimbing`
--

INSERT INTO `nilai_dosen_pembimbing` (`id`, `sidang_id`, `dosen_nip`, `unsur_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 5, '198946122444', 1, 94, '2025-12-18 18:39:36', '2025-12-18 18:39:36'),
(2, 5, '198946122444', 2, 95, '2025-12-18 18:39:36', '2025-12-18 18:39:36'),
(3, 5, '198946122444', 3, 78, '2025-12-18 18:39:36', '2025-12-18 18:39:36'),
(4, 5, '198946122444', 4, 98, '2025-12-18 18:39:36', '2025-12-18 18:39:36'),
(5, 5, '198119046338', 1, 99, '2025-12-18 18:41:28', '2025-12-18 18:41:28'),
(6, 5, '198119046338', 2, 99, '2025-12-18 18:41:28', '2025-12-18 18:41:28'),
(7, 5, '198119046338', 3, 99, '2025-12-18 18:41:28', '2025-12-18 18:41:28'),
(8, 5, '198119046338', 4, 99, '2025-12-18 18:41:28', '2025-12-18 18:41:28');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_dosen_penguji`
--

DROP TABLE IF EXISTS `nilai_dosen_penguji`;
CREATE TABLE `nilai_dosen_penguji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sidang_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `unsur_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_dosen_penguji`
--

INSERT INTO `nilai_dosen_penguji` (`id`, `sidang_id`, `dosen_nip`, `unsur_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 5, '198924088196', 1, 98, '2025-12-19 07:04:27', '2025-12-19 07:04:27'),
(2, 5, '198924088196', 2, 98, '2025-12-19 07:04:27', '2025-12-19 07:04:27'),
(3, 5, '198924088196', 3, 87, '2025-12-19 07:04:27', '2025-12-19 07:04:27'),
(4, 5, '198924088196', 4, 90, '2025-12-19 07:04:27', '2025-12-19 07:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `menu_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'create_user', 'web', NULL, NULL),
(2, NULL, 'manage-user', 'web', NULL, NULL),
(3, NULL, 'manage-configs', 'web', NULL, NULL),
(4, NULL, 'view-bimbingan', 'web', NULL, NULL),
(5, NULL, 'verify-bimbingan', 'web', NULL, NULL),
(6, NULL, 'input-nilai-sidang', 'web', NULL, NULL),
(7, NULL, 'daftar-sidang', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '8153029ba14cbdf0e16c23f81434e674788db0e2fb1890c40aa4d710aa778601', '[\"*\"]', NULL, NULL, '2025-10-22 06:10:16', '2025-10-22 06:10:16'),
(2, 'App\\Models\\ModelApi\\User', 2, 'auth_token_flutter_app', '5880c56d596948116bad8d98c1cff6f91c6c427761c07235d830ce54dce280cb', '[\"*\"]', '2025-10-22 06:32:37', NULL, '2025-10-22 06:17:15', '2025-10-22 06:32:37'),
(3, 'App\\Models\\ModelApi\\User', 2, 'auth_token_flutter_app', 'e812906ffa27559b3f89641d52bfa86f1641bd11a4b3c51eb21c96bf8b1ed7b4', '[\"*\"]', NULL, NULL, '2025-10-22 06:33:46', '2025-10-22 06:33:46'),
(4, 'App\\Models\\ModelApi\\User', 9, 'auth_token_flutter_app', '78e108e1c1f07de20f1c6690c2e5b98f10d008c125dabe49b39dab3c8eb91b94', '[\"*\"]', NULL, NULL, '2025-10-22 08:01:22', '2025-10-22 08:01:22'),
(5, 'App\\Models\\ModelApi\\User', 9, 'auth_token_flutter_app', '247498ff62825076201269c1194acaa3650c30c096fc43dcaeb658dfcf2820c4', '[\"*\"]', NULL, NULL, '2025-10-23 03:15:02', '2025-10-23 03:15:02'),
(6, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '0e66e929a9a0640ea9a009bb8feb0b526c9740ed959d566b3747e31490025ef3', '[\"*\"]', NULL, NULL, '2025-10-23 03:27:23', '2025-10-23 03:27:23'),
(7, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'a60c41893f1f3b9910049a986ff1e017fddb171bd34d3b3b9a987a98299d67ff', '[\"*\"]', NULL, NULL, '2025-10-23 03:31:32', '2025-10-23 03:31:32'),
(8, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5d67c50fd7358b305b624cab4f224c2c69b1aa2b6824acc89648c45cdfef5c55', '[\"*\"]', NULL, NULL, '2025-10-24 07:19:12', '2025-10-24 07:19:12'),
(9, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '418a057b3d3c0670a1544c46cce96c2b6e68dcce00fa28b2e6d9be998d72a5dd', '[\"*\"]', NULL, NULL, '2025-10-24 07:22:13', '2025-10-24 07:22:13'),
(10, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '76d624dd5364663f08d73864a0fc8e65a174d4c2b15a353fa7e5905d8946f97d', '[\"*\"]', '2025-10-25 21:29:35', NULL, '2025-10-25 21:24:15', '2025-10-25 21:29:35'),
(11, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5ae3deeae10a35001fbce27324f63f4bdaa2ebdc171c29b02345db2ead17697a', '[\"*\"]', '2025-10-28 21:02:37', NULL, '2025-10-26 08:47:01', '2025-10-28 21:02:37'),
(12, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '0f713e7849f7b8722e753ce248919b0decfeadd9330833fbf10bec65664033a6', '[\"*\"]', NULL, NULL, '2025-10-28 20:42:54', '2025-10-28 20:42:54'),
(13, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '84884595b86d7c3142a1420a27dbc61ea774e4e26c567d22e33322e1065b93aa', '[\"*\"]', NULL, NULL, '2025-10-28 20:52:13', '2025-10-28 20:52:13'),
(14, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '7db5187caeebf24c0ad78d7f9d5eb25c0aadeef0fbc94ecfba1641c69caa0587', '[\"*\"]', '2025-10-28 23:27:56', NULL, '2025-10-28 21:50:14', '2025-10-28 23:27:56'),
(15, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '911df64dfe75685ac114dcc6b180693f44c009d26e80019a90ac9b87ea389a04', '[\"*\"]', '2025-10-29 02:10:02', NULL, '2025-10-28 23:33:54', '2025-10-29 02:10:02'),
(16, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '77d4e5b21fd84b93759062c739d5419946ad363b3f56ca6efb47131f792d6e10', '[\"*\"]', '2025-10-29 07:16:42', NULL, '2025-10-29 07:09:47', '2025-10-29 07:16:42'),
(17, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'd492bf5584d8381455e2b46bfdd77073c2b66dbfe27c358748bd65c2127851cf', '[\"*\"]', '2025-10-29 07:40:47', NULL, '2025-10-29 07:40:45', '2025-10-29 07:40:47'),
(18, 'App\\Models\\ModelApi\\User', 18, 'auth_token_flutter_app', '796510acb1503f3b82aa898d98ce10f3ed16ebaa21138b1fc462809635cbd67f', '[\"*\"]', '2025-10-29 10:03:28', NULL, '2025-10-29 07:49:54', '2025-10-29 10:03:28'),
(19, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '92c11227c81182ce55a3152ffb6e0c5d89f41def6399739b2a983f4c6ba3ad9f', '[\"*\"]', NULL, NULL, '2025-10-29 08:15:07', '2025-10-29 08:15:07'),
(20, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', 'e4341cdd0ed5921b6b68eefa444f89564eff48419db03c8fc0ce8e9c86864b92', '[\"*\"]', '2025-10-29 08:15:30', NULL, '2025-10-29 08:15:24', '2025-10-29 08:15:30'),
(21, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '317a0c455bb71abb8db5fbfd1880d7b48df3b1bafb16e51a5ded88a36d968685', '[\"*\"]', '2025-10-29 10:10:40', NULL, '2025-10-29 10:08:22', '2025-10-29 10:10:40'),
(22, 'App\\Models\\ModelApi\\User', 16, 'auth_token_flutter_app', '1a0fac6c6f908b71fd2ab09c4ee2a39dcdf7661a4c4febbd6a479dda69a1248e', '[\"*\"]', '2025-10-29 18:39:46', NULL, '2025-10-29 10:16:08', '2025-10-29 18:39:46'),
(23, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', 'b0ae1908453e4633a483190b33f9ed62962f983ca90e317b4dee34510959c144', '[\"*\"]', '2025-10-29 20:02:31', NULL, '2025-10-29 18:41:02', '2025-10-29 20:02:31'),
(24, 'App\\Models\\ModelApi\\User', 5, 'auth_token_flutter_app', 'fe54bcab66b7c7bec788bc783d5a9bef107524c5a4ae5e73d1a0b6eb7515204b', '[\"*\"]', '2025-11-02 21:21:32', NULL, '2025-10-29 19:17:06', '2025-11-02 21:21:32'),
(25, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '6f41b326db0c8b23348e86c1803e292dc427c780ef2f6268b189bfa61f009c51', '[\"*\"]', '2025-10-29 21:30:58', NULL, '2025-10-29 21:30:43', '2025-10-29 21:30:58'),
(26, 'App\\Models\\ModelApi\\User', 43, 'auth_token_flutter_app', 'cd2cad47579741e9e73ed6987d6b8c35a8f3df1fd9f7ee1ba25aa43c50f2f236', '[\"*\"]', '2025-11-01 00:03:54', NULL, '2025-11-01 00:03:44', '2025-11-01 00:03:54'),
(27, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '4911afbb21ed0ac3e89cc3e1c31bfb8278627818eee2ca2f8363e36e9b025078', '[\"*\"]', NULL, NULL, '2025-11-02 04:49:18', '2025-11-02 04:49:18'),
(28, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', 'd8e1bbb38968c5006c54a86edc10eb4c181e775a42322f2d75d46fbae49da38b', '[\"*\"]', NULL, NULL, '2025-11-02 04:49:23', '2025-11-02 04:49:23'),
(29, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '4e1245ff98cc8353f9d7a37b32096a0e3d61bd0b6614b125183a1a1331f6a08f', '[\"*\"]', '2025-11-02 04:50:36', NULL, '2025-11-02 04:50:31', '2025-11-02 04:50:36'),
(30, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', 'b9b08b38ef91b7e4723a66e584f35fd57af0e52832b0087d586818839321d634', '[\"*\"]', NULL, NULL, '2025-11-02 04:55:31', '2025-11-02 04:55:31'),
(31, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '8441c7ebcfe099bb1fbef1cf9b794df7592ae867207c3eae7d99b4c1c211735f', '[\"*\"]', '2025-11-02 04:58:43', NULL, '2025-11-02 04:55:45', '2025-11-02 04:58:43'),
(32, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '0a89fd22e2fd84352a3f8ea5d1f164705403d2cc11dcc240df48cb6210f54499', '[\"*\"]', '2025-11-02 22:32:06', NULL, '2025-11-02 09:13:30', '2025-11-02 22:32:06'),
(33, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '63994428272440af67b1eb16180fa07d49d5b3cdcb1d79873caf23777463cbf0', '[\"*\"]', NULL, NULL, '2025-11-02 09:58:50', '2025-11-02 09:58:50'),
(34, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', 'a66c9ccae920e2bcca42d7342895736174b4c4240e95a27f7ed9c438b262891f', '[\"*\"]', NULL, NULL, '2025-11-02 10:05:19', '2025-11-02 10:05:19'),
(35, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '03304530ebf5055f8c7f70aebc727d3c1fb34c000d8bf18e416232bea8eef958', '[\"*\"]', '2025-11-02 10:34:10', NULL, '2025-11-02 10:34:09', '2025-11-02 10:34:10'),
(36, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', 'c9f096bc15c71d05e8a6be3d0780ef911ceaa3ea13063d30a1d6ccd138c66924', '[\"*\"]', '2025-11-02 11:01:00', NULL, '2025-11-02 11:00:54', '2025-11-02 11:01:00'),
(37, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '6c8673aec4165e81fe6b1a43c2e3d295f6670464940aff75be4ab24b8648686d', '[\"*\"]', '2025-11-02 11:05:32', NULL, '2025-11-02 11:05:10', '2025-11-02 11:05:32'),
(38, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', 'dd5812158a07a788b78de08ab46ebf262bb60c214aadc3d027416a7ef4dcdcf1', '[\"*\"]', '2025-11-02 11:35:32', NULL, '2025-11-02 11:35:29', '2025-11-02 11:35:32'),
(39, 'App\\Models\\ModelApi\\User', 16, 'auth_token_flutter_app', '27b6cd8bf5f8a840fab3092358804cbc10420390491a4d32e9e8e1ce08945498', '[\"*\"]', '2025-11-02 20:23:54', NULL, '2025-11-02 20:23:49', '2025-11-02 20:23:54'),
(40, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '795a020a94928db4ab86b9e39b4f51166b81e0d9a372d80942359ec30f1e7f70', '[\"*\"]', '2025-11-08 20:07:39', NULL, '2025-11-02 21:22:39', '2025-11-08 20:07:39'),
(41, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9192e276f950cd249997af0d13a543f01c66062b459ef64a0681277601e9c172', '[\"*\"]', '2025-11-02 21:46:54', NULL, '2025-11-02 21:46:50', '2025-11-02 21:46:54'),
(42, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '669c6d2fc97476ea81e870598b5a3ce5f88123abf5fc9bfb37b4107074b8d69e', '[\"*\"]', '2025-11-02 21:51:23', NULL, '2025-11-02 21:50:57', '2025-11-02 21:51:23'),
(43, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6436a5396175482ac5fe5aea4831ecf659c7884761edddf669327ca8815cfb06', '[\"*\"]', '2025-11-02 21:55:31', NULL, '2025-11-02 21:55:13', '2025-11-02 21:55:31'),
(44, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd4a428b16de5fcc0a47bb864ff931bc6cff5a5f9e4cd3bfa6fd2a02a7786ae84', '[\"*\"]', '2025-11-02 21:58:51', NULL, '2025-11-02 21:58:49', '2025-11-02 21:58:51'),
(45, 'App\\Models\\ModelApi\\User', 22, 'auth_token_flutter_app', '95163bed61e326fd6a2ec61ad7b18ce30d96e68929f37d527aa837c26ac84a78', '[\"*\"]', '2025-11-03 03:31:58', NULL, '2025-11-03 03:31:20', '2025-11-03 03:31:58'),
(46, 'App\\Models\\ModelApi\\User', 15, 'auth_token_flutter_app', '0a5d96db8bd19e9bca04b63cb12bacea1725f4ae52609050f52c171c47267ece', '[\"*\"]', '2025-11-03 03:46:11', NULL, '2025-11-03 03:45:53', '2025-11-03 03:46:11'),
(47, 'App\\Models\\ModelApi\\User', 16, 'auth_token_flutter_app', '987946dcc286e63fcf034e631aba4ef5f62064e7ed1fc9c485969738dcfea72c', '[\"*\"]', '2025-11-03 04:02:59', NULL, '2025-11-03 04:02:57', '2025-11-03 04:02:59'),
(48, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '5fc9ec39b8263f811aa3ce0cd18a05076f4d3b0f31f120564f1a8a55c30a8b34', '[\"*\"]', '2025-11-03 04:03:25', NULL, '2025-11-03 04:03:20', '2025-11-03 04:03:25'),
(49, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '04e9188b8e9cea264bffd86283f155c0f530dfd2ab446a3d8e4f6d60dbc913b2', '[\"*\"]', '2025-11-03 05:08:03', NULL, '2025-11-03 04:04:19', '2025-11-03 05:08:03'),
(50, 'App\\Models\\ModelApi\\User', 16, 'auth_token_flutter_app', 'dbb7e7d2b0be40c2bf02e03b7c7cf66b7374448aa7aeef3b4102fe9d561bbb5d', '[\"*\"]', '2025-11-09 02:08:39', NULL, '2025-11-03 04:31:00', '2025-11-09 02:08:39'),
(51, 'App\\Models\\ModelApi\\User', 14, 'auth_token_flutter_app', '238e7fde4fd943efefd0c4d747e2649cc30842a9eda5b3d721e08c79a0d2da7f', '[\"*\"]', '2025-11-03 04:53:10', NULL, '2025-11-03 04:45:33', '2025-11-03 04:53:10'),
(52, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'cd0291a068be5d41eecfd0e286cc64446246c1d282d9bbb160239144e980ef2c', '[\"*\"]', '2025-11-03 04:54:09', NULL, '2025-11-03 04:53:59', '2025-11-03 04:54:09'),
(53, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'b5401918a0d8188cb68032879c5873cabed241ed3d6d6f7af222baeb5174188a', '[\"*\"]', '2025-11-03 05:11:21', NULL, '2025-11-03 05:11:18', '2025-11-03 05:11:21'),
(54, 'App\\Models\\ModelApi\\User', 16, 'auth_token_flutter_app', '19113c293bc4536fb39fae35e8909d998321a8f3a94f5754060240c9463ef65b', '[\"*\"]', '2025-11-03 05:20:55', NULL, '2025-11-03 05:20:50', '2025-11-03 05:20:55'),
(55, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'ab390702cb1a23eedf55ebead8185c0879f272fee1c2423f096abbfbc1852348', '[\"*\"]', '2025-11-03 05:40:17', NULL, '2025-11-03 05:39:52', '2025-11-03 05:40:17'),
(56, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '8937538894479c3955d5132229710d0aaa37e313eef6d37d63d6f2c4a3aa57ad', '[\"*\"]', '2025-11-03 20:19:03', NULL, '2025-11-03 20:17:15', '2025-11-03 20:19:03'),
(57, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '26d2a3bfb374224faefe9864108aaf56b8698ad3db2847d85000e3cc79362fe5', '[\"*\"]', '2025-11-03 20:24:41', NULL, '2025-11-03 20:24:39', '2025-11-03 20:24:41'),
(58, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '901026762e2bc3972533385f3c39d4c48400d23d19da8aa084c43fe4dcdbf4dc', '[\"*\"]', '2025-11-03 21:04:10', NULL, '2025-11-03 21:03:57', '2025-11-03 21:04:10'),
(59, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '35ab7c27552abc60e289ac1d13e018165905c214cb16311b56b7bc79b56e2b21', '[\"*\"]', '2025-11-03 21:06:15', NULL, '2025-11-03 21:06:09', '2025-11-03 21:06:15'),
(60, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '81a38669cb5aad492b4de909ced7b9584faa6c39b16bc5b6163160a43ccb61b4', '[\"*\"]', '2025-11-03 21:09:09', NULL, '2025-11-03 21:09:04', '2025-11-03 21:09:09'),
(61, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', 'bf88f1d6b9cf6ea19a843d3adaa60e97feb3d8dca5e3829843f3fbb8fcc36e04', '[\"*\"]', '2025-11-03 21:10:44', NULL, '2025-11-03 21:10:39', '2025-11-03 21:10:44'),
(62, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '05bde577d711f0d56c24d1f763080d5e3f3491dc3cf65e4fd77b10a86905437f', '[\"*\"]', '2025-11-03 21:12:13', NULL, '2025-11-03 21:12:08', '2025-11-03 21:12:13'),
(63, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', 'c50b3541b5f866566c68472554d2324d54cec6a715d5e0451a0c696d7031e22e', '[\"*\"]', '2025-11-03 21:13:37', NULL, '2025-11-03 21:13:32', '2025-11-03 21:13:37'),
(64, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '2e61ca1db7dc40aa888c991beadd003afad6347d661470f230785c12082f1097', '[\"*\"]', '2025-11-03 21:15:06', NULL, '2025-11-03 21:15:01', '2025-11-03 21:15:06'),
(65, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '888b80b2b8a9723225e87ca49a25994e9685b8a3d2d88c4f95d0a5e5756879e2', '[\"*\"]', '2025-11-03 21:17:42', NULL, '2025-11-03 21:16:53', '2025-11-03 21:17:42'),
(66, 'App\\Models\\ModelApi\\User', 21, 'auth_token_flutter_app', '94054db8fd019d0c59a8bacea795d0ac2f4aa99f706c471c39ec7482ae4e8f96', '[\"*\"]', '2025-11-03 22:18:33', NULL, '2025-11-03 21:23:59', '2025-11-03 22:18:33'),
(67, 'App\\Models\\ModelApi\\User', 22, 'auth_token_flutter_app', '509d537c463ca03cae8659c3cf9168efc7535dc4f93fb088ffa8b5df4d7d6818', '[\"*\"]', '2025-11-03 22:10:43', NULL, '2025-11-03 22:10:38', '2025-11-03 22:10:43'),
(68, 'App\\Models\\ModelApi\\User', 22, 'auth_token_flutter_app', 'aa428427cbc23c53ba0f9ec1b3be6cbbb657a2bd9f088ad1db1fe1fb2c6e67f9', '[\"*\"]', '2025-11-03 22:48:07', NULL, '2025-11-03 22:19:31', '2025-11-03 22:48:07'),
(69, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '046fcb30721011eeb86220691dcc68b7c5b30e9353207be6f40b882fa8a73f79', '[\"*\"]', '2025-11-03 22:27:15', NULL, '2025-11-03 22:26:32', '2025-11-03 22:27:15'),
(70, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'bc6b05f631ebbfdc1da14e3eab37be2f814277329fa8a6d4fc0c49bf6a8b8611', '[\"*\"]', '2025-11-03 22:48:01', NULL, '2025-11-03 22:47:58', '2025-11-03 22:48:01'),
(71, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '095351f1c4fa87fa31156009732e4dc48cc413a6724340f1e162a5d7008807a2', '[\"*\"]', '2025-11-03 23:15:58', NULL, '2025-11-03 22:49:06', '2025-11-03 23:15:58'),
(72, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '7c04b8e4227aaaaa3271a40fb61018781246158b60f4f8abd3d30b2545118bd9', '[\"*\"]', '2025-11-03 23:40:39', NULL, '2025-11-03 23:28:27', '2025-11-03 23:40:39'),
(73, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '3854875b69bee142aadf513ef0dede2fb4178243fc6f420ec47aa1fc7cf47d92', '[\"*\"]', '2025-11-04 00:11:24', NULL, '2025-11-04 00:11:21', '2025-11-04 00:11:24'),
(74, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'bcfea90991002e860c1b64ac38a5301c16d8223a78f835b1623c092dbf3bfd0d', '[\"*\"]', '2025-11-04 00:12:56', NULL, '2025-11-04 00:12:30', '2025-11-04 00:12:56'),
(75, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'e7fd431ab2e8ecb1899f5633216c4d1404deb0ab77f17053e459b38fec1c6f41', '[\"*\"]', NULL, NULL, '2025-11-04 00:38:14', '2025-11-04 00:38:14'),
(76, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', '56aebf316b615c1c52aebb0a0ccfa39f5560a0e23064e169d3dbeeb699a44229', '[\"*\"]', '2025-11-04 09:22:47', NULL, '2025-11-04 00:38:37', '2025-11-04 09:22:47'),
(77, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', 'f843d7d9bef0e371f18cf951412f5ed21cbd68a536f672db55379164966de024', '[\"*\"]', '2025-11-04 09:18:35', NULL, '2025-11-04 09:18:31', '2025-11-04 09:18:35'),
(78, 'App\\Models\\ModelApi\\User', 10, 'auth_token_flutter_app', 'c5ef76c7684d1f41ac9aca86d8b8c8094ce4ae713936504d77fa57a929ae012e', '[\"*\"]', '2025-11-08 21:49:49', NULL, '2025-11-04 09:24:48', '2025-11-08 21:49:49'),
(79, 'App\\Models\\ModelApi\\User', 22, 'auth_token_flutter_app', '5b3f2f498a8daa81b448ae4a84bcf3eafb540cf04cec753eb345b36a82295907', '[\"*\"]', '2025-11-04 09:39:27', NULL, '2025-11-04 09:39:25', '2025-11-04 09:39:27'),
(80, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', 'edc32dc1061c9dcf2e07459bed766d2e05de1e7170b9b7c550fb67be20a71ba1', '[\"*\"]', '2025-11-04 09:42:37', NULL, '2025-11-04 09:42:31', '2025-11-04 09:42:37'),
(81, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd49f38e30a2839aed91158ec2d9d7361eeb4298c27ca03b08b0b519b647cb994', '[\"*\"]', '2025-11-09 01:48:41', NULL, '2025-11-08 20:08:00', '2025-11-09 01:48:41'),
(82, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '4b2cd1ee325215f25b77055eb1069af53f27f2e4d7e5d6bc9a20bd2b2e632547', '[\"*\"]', '2025-11-08 20:10:03', NULL, '2025-11-08 20:10:00', '2025-11-08 20:10:03'),
(83, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', 'd0c5abd18411616e94f405aaeb279d841a8c46a51e5aa80934362d03c533e8f3', '[\"*\"]', '2025-11-08 20:25:42', NULL, '2025-11-08 20:25:38', '2025-11-08 20:25:42'),
(84, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', 'b4e56ccb55cacdadc2b606ca02540e0ebde507c3cad0ac7b17715e029bdcd1cf', '[\"*\"]', '2025-11-08 20:30:51', NULL, '2025-11-08 20:30:47', '2025-11-08 20:30:51'),
(85, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '6e589b905a473bcfb088e0d3018b0f111cdc2fc9e915f6f295af742843b018ff', '[\"*\"]', '2025-11-08 20:34:18', NULL, '2025-11-08 20:34:15', '2025-11-08 20:34:18'),
(86, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '23326c94e0aa1e985c27f5b8dccb050f15af33edd174cd93509072cd2f5693fc', '[\"*\"]', '2025-11-08 20:41:29', NULL, '2025-11-08 20:41:25', '2025-11-08 20:41:29'),
(87, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '960a400833d5aee0359d61e5fa3025fbb8c3b7f07b596f9eba1665e25c8ac30e', '[\"*\"]', NULL, NULL, '2025-11-08 20:44:24', '2025-11-08 20:44:24'),
(88, 'App\\Models\\ModelApi\\User', 17, 'auth_token_flutter_app', '37d6b1ef0bb30285fe70cd9306101bb96ac229890d66fd67dfeec8aa6b7f4f81', '[\"*\"]', NULL, NULL, '2025-11-08 20:44:35', '2025-11-08 20:44:35'),
(89, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '6527590d2b84ceaa52731b6f4a0393ecc6fbcbd3673b31cbbd4f04727275ee4a', '[\"*\"]', '2025-11-08 20:44:41', NULL, '2025-11-08 20:44:36', '2025-11-08 20:44:41'),
(90, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '607b7f88e97945f1ee68eeb6e00a8673b992824a162c0f6fa4b525e020fafe74', '[\"*\"]', '2025-11-08 20:47:20', NULL, '2025-11-08 20:47:16', '2025-11-08 20:47:20'),
(91, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', 'c808ab0bcd01eba9c4967c454ba126c33751030ae6e7c96ca24d32259f2afe17', '[\"*\"]', '2025-11-08 20:55:57', NULL, '2025-11-08 20:55:37', '2025-11-08 20:55:57'),
(92, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '54d74d4176ccd615de1a443158503f796a4b9e41005a2cfe0d04112beb723f51', '[\"*\"]', '2025-11-08 20:59:20', NULL, '2025-11-08 20:59:17', '2025-11-08 20:59:20'),
(93, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '58210cfa57b7e4897917d84e6cade223da5b68460694d0aa15657db494a4d515', '[\"*\"]', '2025-11-08 21:02:27', NULL, '2025-11-08 21:02:22', '2025-11-08 21:02:27'),
(94, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '028241847a890726d6b9a1817677d73c96491d8469d4e46147acb266816339b4', '[\"*\"]', '2025-11-08 21:04:26', NULL, '2025-11-08 21:04:24', '2025-11-08 21:04:26'),
(95, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', 'f11636938a57ea06b018506c72f6346302da80addf462cf19c099bf67d0bc473', '[\"*\"]', '2025-11-08 21:09:11', NULL, '2025-11-08 21:09:08', '2025-11-08 21:09:11'),
(96, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '7de5afcbed3f1593a629b0d85f29b5586e60fee03fb913c722d507ecb07a2562', '[\"*\"]', '2025-11-08 21:12:11', NULL, '2025-11-08 21:12:08', '2025-11-08 21:12:11'),
(97, 'App\\Models\\ModelApi\\User', 11, 'auth_token_flutter_app', '26e64b1f92f40398062f87a2a6afd25aac0499dbe8b57a288bc4f2f9639e9757', '[\"*\"]', '2025-11-08 21:17:59', NULL, '2025-11-08 21:17:56', '2025-11-08 21:17:59'),
(98, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '571f299ed9ab22a85e01993bec1d942bf33b2bcb987306226f764f9981d46a1d', '[\"*\"]', '2025-11-08 22:32:56', NULL, '2025-11-08 21:50:15', '2025-11-08 22:32:56'),
(99, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'b65d3d711987e96c0eb0116787474be14e73a0a6da0731ef0b322e6115bc99e2', '[\"*\"]', '2025-11-08 21:54:58', NULL, '2025-11-08 21:52:26', '2025-11-08 21:54:58'),
(100, 'App\\Models\\ModelApi\\User', 4, 'auth_token_flutter_app', '82c2af901cef6177ae7e9e2a3496d8bfc53c87079079141ff67373f35c0e6a31', '[\"*\"]', NULL, NULL, '2025-11-08 22:30:58', '2025-11-08 22:30:58'),
(101, 'App\\Models\\ModelApi\\User', 4, 'auth_token_flutter_app', '789cbb3fea49f8118e0f008396bdf5a4eefec60c1d2d5452b47d09c0a0021332', '[\"*\"]', '2025-11-08 22:31:11', NULL, '2025-11-08 22:31:01', '2025-11-08 22:31:11'),
(102, 'App\\Models\\ModelApi\\User', 4, 'auth_token_flutter_app', '5bc1f4a60f3161c1deb2f6f041dfefb9558aa424cffc9e4de78a5c14669f7a37', '[\"*\"]', '2025-11-08 22:34:35', NULL, '2025-11-08 22:34:33', '2025-11-08 22:34:35'),
(103, 'App\\Models\\ModelApi\\User', 4, 'auth_token_flutter_app', '892ce27ce6d9ee57636d48a522b88ec4c9530565b94512fad1067d1944760ee5', '[\"*\"]', '2025-11-08 22:41:09', NULL, '2025-11-08 22:41:01', '2025-11-08 22:41:09'),
(104, 'App\\Models\\ModelApi\\User', 3, 'auth_token_flutter_app', '53ef32e36642449b80a8cd65727101d7bff3f5bcfacaa19be99a1b7741a39bb8', '[\"*\"]', '2025-11-09 01:53:09', NULL, '2025-11-09 01:50:27', '2025-11-09 01:53:09'),
(105, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ff81a9c7b72c1e06da2aa07c6e1b82298547760743b940d44e094749a571bb9b', '[\"*\"]', '2025-11-15 01:55:14', NULL, '2025-11-09 02:09:52', '2025-11-15 01:55:14'),
(106, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c5664a509177355e67a6bd863619ac61747651af894446760b42b868df577f37', '[\"*\"]', '2025-11-09 02:21:21', NULL, '2025-11-09 02:16:17', '2025-11-09 02:21:21'),
(107, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '96fdbb92aca9799f8652f7e1efcf7b51adea3e1d4442ce19ece23695e705ff89', '[\"*\"]', '2025-11-09 03:17:16', NULL, '2025-11-09 02:21:49', '2025-11-09 03:17:16'),
(108, 'App\\Models\\ModelApi\\User', 18, 'auth_token_flutter_app', '739f0ac16ec87cc3e1625a1d083659fc2fb89cbda3551cd454a76629e1cbc87d', '[\"*\"]', '2025-11-10 04:03:47', NULL, '2025-11-09 03:18:46', '2025-11-10 04:03:47'),
(109, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6c2708e7c838ab54fa4b3dc64ce6da7d42e88111cfa0739b73bb45490d2e3a5f', '[\"*\"]', '2025-11-10 04:06:18', NULL, '2025-11-10 04:06:13', '2025-11-10 04:06:18'),
(110, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd0ed3f75a903f80471901989586b2cd6178db1413b523764bffc7b5f043cc8d6', '[\"*\"]', '2025-11-10 06:56:45', NULL, '2025-11-10 04:09:08', '2025-11-10 06:56:45'),
(111, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '233d3ef6dc4e9716d8f36eb6684b86a7ae8d13fd9d6808dfc3cad78ab4226dcc', '[\"*\"]', '2025-11-11 01:31:02', NULL, '2025-11-10 06:57:08', '2025-11-11 01:31:02'),
(112, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3a8ff48be53c7d16c3331dd271481280e0a11192a0345d6547809856a3d81e1f', '[\"*\"]', NULL, NULL, '2025-11-10 23:55:20', '2025-11-10 23:55:20'),
(113, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '414fcade4f1573a087a33b29774c7968e1f394b25a70a0c2d9df0764db66a650', '[\"*\"]', '2025-11-10 23:55:44', NULL, '2025-11-10 23:55:34', '2025-11-10 23:55:44'),
(114, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '83e592ea42a849af185e8a31e8c5ae7b6455efabb706bb39636db8e14bdbab8f', '[\"*\"]', '2025-11-11 01:32:59', NULL, '2025-11-11 01:32:54', '2025-11-11 01:32:59'),
(115, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4f92e09ec6161fa0cb5eb88b5d8219cc14862851a6afa6bcb7f9a254771896d7', '[\"*\"]', '2025-11-11 01:37:01', NULL, '2025-11-11 01:33:48', '2025-11-11 01:37:01'),
(116, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd1c6b750f7776f468b83972febe6d7090c943cb33f4e605f3c2e1a36396baa55', '[\"*\"]', '2025-11-12 19:23:26', NULL, '2025-11-11 01:44:04', '2025-11-12 19:23:26'),
(117, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4a7f5181fa48d5acdcccb47f5045ac7f651fffe7077fd82dfb8400d01a1880b1', '[\"*\"]', '2025-11-15 22:45:04', NULL, '2025-11-12 19:24:10', '2025-11-15 22:45:04'),
(118, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '447a288c2bf65371620625536ecf73402bb4637fca8b1088f2f49933a07e0cc4', '[\"*\"]', NULL, NULL, '2025-11-15 01:03:32', '2025-11-15 01:03:32'),
(119, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd9dcdb9735bf8d1d2c67c4e6308bb1728bb613894e847aa7b99f788e0abd7094', '[\"*\"]', '2025-11-15 01:03:46', NULL, '2025-11-15 01:03:38', '2025-11-15 01:03:46'),
(120, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f7e4d6d99e658a6895825f61aea566d4ba64e4257d597c5e894232ab7e775c79', '[\"*\"]', '2025-11-15 01:05:16', NULL, '2025-11-15 01:05:12', '2025-11-15 01:05:16'),
(121, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd4c3c66089e7c952dbc4823ddb2a1df4f22dd72c99eabe2708f82a999ec2a991', '[\"*\"]', '2025-11-15 01:05:55', NULL, '2025-11-15 01:05:51', '2025-11-15 01:05:55'),
(122, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e2c7f90bd24f2b3c32f2b9ebc60009624470dcaa123a53397bfbca0a5f1cc687', '[\"*\"]', '2025-11-16 04:03:46', NULL, '2025-11-15 01:12:19', '2025-11-16 04:03:46'),
(123, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'af586e9b73726b3707cf89befd59c7a4ea21abe80c88e947383b4550bbb70176', '[\"*\"]', '2025-11-15 01:37:18', NULL, '2025-11-15 01:35:37', '2025-11-15 01:37:18'),
(124, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c0a99e04d6f8cd67b257c346041574670474087d44ffe82c0704782827927d0a', '[\"*\"]', '2025-11-15 01:39:26', NULL, '2025-11-15 01:39:16', '2025-11-15 01:39:26'),
(125, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4198cd95f960f4036e1bc9f199cfdd421ab8a75534c03b1a0535c00b2c1c54e1', '[\"*\"]', '2025-11-15 01:43:19', NULL, '2025-11-15 01:43:14', '2025-11-15 01:43:19'),
(126, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '318be55d7b2d881bfefe332287c434eb4afddf594c3bdc32e9d8838b685f4df7', '[\"*\"]', '2025-11-15 02:14:20', NULL, '2025-11-15 01:57:47', '2025-11-15 02:14:20'),
(127, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0c18dfefca6752ed5d7f0075e00654c446b6ba25730cefc56077a534fbf83209', '[\"*\"]', NULL, NULL, '2025-11-15 09:10:22', '2025-11-15 09:10:22'),
(128, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5c532aa443f658a85f8c856699a700d7aac0414705490a7805d3f3d825f6d709', '[\"*\"]', '2025-11-15 09:10:32', NULL, '2025-11-15 09:10:24', '2025-11-15 09:10:32'),
(129, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6c3038f0f361a5f4bd0f4d62e5a0e2da1c9114dce7c85ae11b5ec4c21a3f6522', '[\"*\"]', '2025-11-15 10:55:23', NULL, '2025-11-15 10:54:52', '2025-11-15 10:55:23'),
(130, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '402d978eb024b62d763ecdda3c4a52561293d757b1c1b241a0c9609ea7ee2ddc', '[\"*\"]', '2025-11-15 10:58:37', NULL, '2025-11-15 10:58:31', '2025-11-15 10:58:37'),
(131, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c88d148325e1d511233266dc01cb96877cd20e54628b69f400ad5587d65a3593', '[\"*\"]', '2025-11-15 11:41:28', NULL, '2025-11-15 11:41:23', '2025-11-15 11:41:28'),
(132, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4b1255c00870ff625c557992a09ce829555ab361110c5db71819a70016f12aa2', '[\"*\"]', '2025-11-15 11:45:04', NULL, '2025-11-15 11:45:00', '2025-11-15 11:45:04'),
(133, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a870e65b5c8616179b774239548892f61bc059525260db1127b3d9c2c7b22c88', '[\"*\"]', '2025-11-15 11:47:37', NULL, '2025-11-15 11:47:32', '2025-11-15 11:47:37'),
(134, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '87bf5bdc4e4e0619aa4977f61a0b9a3d220939e568f7b3d07aaa4221c896b852', '[\"*\"]', NULL, NULL, '2025-11-15 12:03:23', '2025-11-15 12:03:23'),
(135, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'da5ca2e64c32a5ac765e9b800c2600af454e840f70d25440c2e17abdd3e340f0', '[\"*\"]', '2025-11-15 12:04:38', NULL, '2025-11-15 12:04:32', '2025-11-15 12:04:38'),
(136, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '2e189971291f374154fb88239a9fccb3be2a96f99a954b650e7de7321f2af3d1', '[\"*\"]', '2025-11-15 12:11:02', NULL, '2025-11-15 12:09:00', '2025-11-15 12:11:02'),
(137, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'da1b01a3314ea92cabb8e0a76e58294ec181fc0025b9d0ce8eb67f4f2027a63a', '[\"*\"]', NULL, NULL, '2025-11-15 22:19:06', '2025-11-15 22:19:06'),
(138, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4b255f8838f6bb2ce85b68548c742b6d0d93682239676038b3cec434e450ba11', '[\"*\"]', NULL, NULL, '2025-11-15 22:19:32', '2025-11-15 22:19:32'),
(139, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '519a62f987d78cc1ed015fe1c5e5af8a41378b2efb3c59745a3fb77b3739675e', '[\"*\"]', NULL, NULL, '2025-11-15 22:19:36', '2025-11-15 22:19:36'),
(140, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '471577f4e99b399a407bbc393e624d46a372566648d5cfeef2ae48373cd96684', '[\"*\"]', '2025-11-15 22:22:18', NULL, '2025-11-15 22:22:01', '2025-11-15 22:22:18'),
(141, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f1e794fdde5d0f7093dfe6e3ba331f30f24ca31420733d582b84e5ad5479df1f', '[\"*\"]', '2025-11-15 23:33:20', NULL, '2025-11-15 22:45:23', '2025-11-15 23:33:20'),
(142, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f244825a264dec4e4531707ee60ce250b3a531b9715bf105c953a294f1ed6ee5', '[\"*\"]', '2025-11-30 08:43:25', NULL, '2025-11-15 23:33:34', '2025-11-30 08:43:25'),
(143, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a1621a7689377d0e248a6f3cb2ecadcf9001956a7d8ead1c24ae4e17f27f3f19', '[\"*\"]', '2025-11-19 01:44:32', NULL, '2025-11-16 04:05:02', '2025-11-19 01:44:32'),
(144, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'eb4d6bc6d1f2cfbce6bf1237091cb7c9cb72b6002fb22e2ee40e117c389a1558', '[\"*\"]', '2025-11-16 04:27:40', NULL, '2025-11-16 04:27:31', '2025-11-16 04:27:40'),
(145, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '871d05d6fee9c2407381a3f71e8e06caa11ef0c4166fbc2f922f790dbe783ceb', '[\"*\"]', '2025-11-18 00:33:55', NULL, '2025-11-18 00:33:50', '2025-11-18 00:33:55'),
(146, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ccf29112ea8e652b906f714db7fbbb5cdabab6974888207eaba032ffb30b8532', '[\"*\"]', '2025-11-18 00:39:29', NULL, '2025-11-18 00:39:26', '2025-11-18 00:39:29'),
(147, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8e20aa2eba35ee38b7ab206a7a47473891696db798b548e8c6d9d7d9712e3ae6', '[\"*\"]', NULL, NULL, '2025-11-18 02:08:41', '2025-11-18 02:08:41'),
(148, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a550b70929174d5629a0781c6936a5d92387513ecc7a93d8dcb7e73d21fd26d7', '[\"*\"]', '2025-11-18 02:09:03', NULL, '2025-11-18 02:08:45', '2025-11-18 02:09:03'),
(149, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '168b1a9d67dc801098c0a9accab109038423fe269f62debb35c9f4a81027347f', '[\"*\"]', '2025-11-18 02:12:12', NULL, '2025-11-18 02:12:04', '2025-11-18 02:12:12'),
(150, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4e9ca942536ca4d8a93ecd58874ab35980746ab591398e16f504d21b2b7a9262', '[\"*\"]', NULL, NULL, '2025-11-19 01:13:32', '2025-11-19 01:13:32'),
(151, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'b67cc15362be1546d1b7d4b008291343631f8845cd31de49fbbac47fcb90504e', '[\"*\"]', '2025-11-19 01:13:46', NULL, '2025-11-19 01:13:35', '2025-11-19 01:13:46'),
(152, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '736c22eb6c7c2e808acf111c83e4d18c5f1b47c466c0d71c782411503c37ef1a', '[\"*\"]', '2025-11-19 01:15:47', NULL, '2025-11-19 01:15:44', '2025-11-19 01:15:47'),
(153, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'faa50387bb8363fef616e88abd187f06d8056c5003f400197de7d61396f8e24a', '[\"*\"]', NULL, NULL, '2025-11-19 01:46:11', '2025-11-19 01:46:11'),
(154, 'App\\Models\\ModelApi\\User', 24, 'auth_token_flutter_app', '2384285a597c9a4f24a1b54aa2295fbe8c79080e085ff54b367599b83aac49cc', '[\"*\"]', '2025-11-22 22:04:34', NULL, '2025-11-19 01:46:21', '2025-11-22 22:04:34'),
(155, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9327678ee615676613d283b4898a6b061ff06df52769e7122a6fc3991c384680', '[\"*\"]', '2025-11-19 01:55:38', NULL, '2025-11-19 01:55:33', '2025-11-19 01:55:38'),
(156, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5909f8bb96d485f607e68023713cef6a9dfbeaafafd0322428dffa4af3ecf1e0', '[\"*\"]', '2025-11-19 02:00:38', NULL, '2025-11-19 02:00:32', '2025-11-19 02:00:38'),
(157, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3aaa2fa817b68407c7b573ea71ba0beeb1635a322b23e98f11423fb866811655', '[\"*\"]', '2025-11-19 02:03:22', NULL, '2025-11-19 02:03:17', '2025-11-19 02:03:22'),
(158, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1eceb208064a1b51c189c57e921d629b47c959cb3e98b1ffe5ca7199922affdb', '[\"*\"]', '2025-11-19 02:06:30', NULL, '2025-11-19 02:06:28', '2025-11-19 02:06:30'),
(159, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'cbf53d5e91f0e04a89f50a92ac64752eaf577a12e88fb4e13555f0bceb27ca14', '[\"*\"]', '2025-11-19 02:08:56', NULL, '2025-11-19 02:08:52', '2025-11-19 02:08:56'),
(160, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ac4dc127d708318f4abdd01ef550f13cab79011a7f8142b24f9595114eaf713f', '[\"*\"]', '2025-11-19 03:06:30', NULL, '2025-11-19 03:06:25', '2025-11-19 03:06:30'),
(161, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ddb1008e8aa5e49124885211b972fe6e1d7096baec0a51f9b8efb591de96e49a', '[\"*\"]', '2025-11-19 03:28:18', NULL, '2025-11-19 03:28:12', '2025-11-19 03:28:18'),
(162, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1250a72f677730a5e9828ca59ae9e4ca684b8cec974adc46cd08346bcace1c1b', '[\"*\"]', '2025-11-19 03:47:54', NULL, '2025-11-19 03:47:50', '2025-11-19 03:47:54'),
(163, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6c1e058fd5a1a080d18da9b77dc3fdbf4d9c32c929ae328addaa27b329046de3', '[\"*\"]', '2025-11-19 03:52:15', NULL, '2025-11-19 03:52:11', '2025-11-19 03:52:15'),
(164, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '51be1231222a2d3d31e98bed5e37585990652d5add558b776a35fd41719a8e97', '[\"*\"]', '2025-11-19 04:05:58', NULL, '2025-11-19 04:05:54', '2025-11-19 04:05:58'),
(165, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3f036d461e5c24bcac4d1d07f820105dd733b161a9532628e226fc32b2e82043', '[\"*\"]', '2025-11-19 04:08:42', NULL, '2025-11-19 04:08:39', '2025-11-19 04:08:42'),
(166, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6ac2a34e8ad093f79b3460745c60c96f631412ccb9d4669d575c7fede4888a34', '[\"*\"]', '2025-11-19 04:10:00', NULL, '2025-11-19 04:09:56', '2025-11-19 04:10:00'),
(167, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c89f789cc6770abec663456de212f2ceab90d6db88162b7d970e7bc913c97ec5', '[\"*\"]', '2025-11-19 04:24:51', NULL, '2025-11-19 04:24:46', '2025-11-19 04:24:51'),
(168, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'dd541f688775ae17e22e1d28453deaefd8ee09309ba258438dd674b94c7cad12', '[\"*\"]', '2025-11-19 05:00:31', NULL, '2025-11-19 05:00:24', '2025-11-19 05:00:31'),
(169, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8b2ae69b725beb8d63e0dda976a52ff8babb77f3076a35bd6340e5a0acf9649a', '[\"*\"]', '2025-11-19 05:17:36', NULL, '2025-11-19 05:17:28', '2025-11-19 05:17:36'),
(170, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0b0df909550916da4e533cf76e50ab5eeca353a37bd707a738bc9c4866b9bc1f', '[\"*\"]', '2025-11-19 06:34:29', NULL, '2025-11-19 06:34:05', '2025-11-19 06:34:29'),
(171, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a596cb6e9445260ba3b02fcaf0b846f57131c41cf74650f52f4c586737269bfc', '[\"*\"]', '2025-11-19 07:09:13', NULL, '2025-11-19 07:04:38', '2025-11-19 07:09:13'),
(172, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'f6c3467b66bd438bf1fd662a5fc6a873f13f27d1c05994fe5db2e46a296ed3bc', '[\"*\"]', '2025-11-19 07:10:37', NULL, '2025-11-19 07:09:55', '2025-11-19 07:10:37'),
(173, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '316308693e80881dc78b0fe7ea52c3ffe3d2190021059f3e9a2e2d953c3a408b', '[\"*\"]', '2025-11-19 07:12:52', NULL, '2025-11-19 07:12:49', '2025-11-19 07:12:52'),
(174, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '09b66effae91e568de3f560d5284c15a3c51c1ebc8e0bc9792220755b5e4e199', '[\"*\"]', NULL, NULL, '2025-11-19 07:18:05', '2025-11-19 07:18:05'),
(175, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '967c4c1b9493924eae20da0c52aee53c69cd8847db5627cc87a9462e5b260aea', '[\"*\"]', NULL, NULL, '2025-11-19 07:18:07', '2025-11-19 07:18:07'),
(176, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '986273b1782d2ba20b17ec9e2c6ef05d04d900b132f5c6ea33484244e706558a', '[\"*\"]', '2025-11-19 07:18:24', NULL, '2025-11-19 07:18:19', '2025-11-19 07:18:24'),
(177, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '29bbf883bce88fcc06b827ad03347e42c1d6ff2de76d426624abde4ee7ef83c1', '[\"*\"]', '2025-11-19 07:22:46', NULL, '2025-11-19 07:22:43', '2025-11-19 07:22:46'),
(178, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5138cc6f62da1983e87964aae7e1a900e23922fbe35a0a5e183094a43b99257e', '[\"*\"]', '2025-11-19 07:30:45', NULL, '2025-11-19 07:28:11', '2025-11-19 07:30:45'),
(179, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'bf0a3bc31720a49b921b50e50ad1672a67b4658f1b28fac9ba4c40d2991a5557', '[\"*\"]', '2025-11-19 07:31:24', NULL, '2025-11-19 07:31:11', '2025-11-19 07:31:24'),
(180, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', 'bfbf2a0cdf7d9ee5856099efbd409b288c168287152727575e81453893d535ce', '[\"*\"]', '2025-11-19 07:47:25', NULL, '2025-11-19 07:37:57', '2025-11-19 07:47:25'),
(181, 'App\\Models\\ModelApi\\User', 13, 'auth_token_flutter_app', '1b4e1535927651317f1cd1e3d8a3b5ddb2f3ccb9230cf238a3e9ccfb9b14ec44', '[\"*\"]', '2025-11-19 07:48:22', NULL, '2025-11-19 07:48:19', '2025-11-19 07:48:22'),
(182, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8bb78912697270a5cf46134bae6a027bbc4152088d569e81f70b61183b9d341a', '[\"*\"]', '2025-11-19 07:48:43', NULL, '2025-11-19 07:48:40', '2025-11-19 07:48:43'),
(183, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0415c5157d12d033808b0537757db4e024db06fc99fcd4017123c475d3a4b402', '[\"*\"]', '2025-11-19 08:02:19', NULL, '2025-11-19 08:02:15', '2025-11-19 08:02:19'),
(184, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4a0098e0c71c431e7faaffaf84167c16616554cf63101c8de20d453757be4f43', '[\"*\"]', '2025-11-19 08:10:51', NULL, '2025-11-19 08:10:28', '2025-11-19 08:10:51'),
(185, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1fa9a6a90d292483d536b18386d7131a27da0f9c68c7a3cb3b1eb685a6c01ccf', '[\"*\"]', '2025-11-19 08:12:32', NULL, '2025-11-19 08:12:28', '2025-11-19 08:12:32'),
(186, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '553ba4aa3d5b050cb3a3467bae901308f123f3abff4796d4e1e6352167aa6373', '[\"*\"]', '2025-11-19 08:14:53', NULL, '2025-11-19 08:14:50', '2025-11-19 08:14:53'),
(187, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd100d3d0431978fcc81956f9aa00006a2940940a50056f115dd6d78d3eb79809', '[\"*\"]', '2025-11-19 08:16:35', NULL, '2025-11-19 08:16:31', '2025-11-19 08:16:35'),
(188, 'App\\Models\\ModelApi\\User', 32, 'auth_token_flutter_app', 'a565fc1dd2c190393afa2a0d1b87b134d28de1c807ee92dd0859f866c8728b6a', '[\"*\"]', '2025-11-19 08:21:11', NULL, '2025-11-19 08:20:42', '2025-11-19 08:21:11'),
(189, 'App\\Models\\ModelApi\\User', 32, 'auth_token_flutter_app', 'f184ad3b96842adb91aa72c3a33ef97a9a22fca1e16597757d1760903e715398', '[\"*\"]', '2025-11-19 08:26:05', NULL, '2025-11-19 08:25:55', '2025-11-19 08:26:05'),
(190, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9d841bf95e06881a4c2c1120fc4b1f6d507a1903b7e9d61d8e4f13e67a85a7dc', '[\"*\"]', NULL, NULL, '2025-11-19 18:24:21', '2025-11-19 18:24:21'),
(191, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '7c54d91f6b4a330ae961a011a0ec68700d27090cefbfa089f2020b2ab4f338ed', '[\"*\"]', '2025-11-19 18:27:48', NULL, '2025-11-19 18:27:41', '2025-11-19 18:27:48'),
(192, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '705bd1589c8162b416693d51487792725c55129196076900d7d656182c8c4f45', '[\"*\"]', '2025-11-19 18:32:53', NULL, '2025-11-19 18:32:36', '2025-11-19 18:32:53'),
(193, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '071a5a419e9f352f6a230314b0f6c9f6307b70a5431acb4c606c5c1c15f5a65e', '[\"*\"]', '2025-11-22 20:56:37', NULL, '2025-11-22 20:31:45', '2025-11-22 20:56:37'),
(194, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f4a46e05ab6f2b67513570e501b6527ce0a81f966d8fc0a88385bdc0f1bff8d8', '[\"*\"]', '2025-11-22 21:02:38', NULL, '2025-11-22 21:00:32', '2025-11-22 21:02:38'),
(195, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '689f42c17b695bdf13062b1de4ec377954a7a5671b0ae2a4c246b5783294a0eb', '[\"*\"]', NULL, NULL, '2025-11-22 21:54:48', '2025-11-22 21:54:48'),
(196, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1263a651dd42248c7564bdfde4b543a6de149de61bfba67d0c97e6e9b302eaf2', '[\"*\"]', '2025-11-22 21:54:56', NULL, '2025-11-22 21:54:52', '2025-11-22 21:54:56'),
(197, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5864fef5a5223afb47fd35a6490f6875202c6b0f326f0cc21d0d2f9ccded9c25', '[\"*\"]', '2025-11-22 22:01:09', NULL, '2025-11-22 21:57:45', '2025-11-22 22:01:09'),
(198, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '53c28f54688898da2c6776d8711d575569828d030d158eaa0f1de43cd4f2e78f', '[\"*\"]', '2025-11-23 10:58:21', NULL, '2025-11-22 22:04:45', '2025-11-23 10:58:21'),
(199, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'bc455bf83aa644729d83d07c62d5a5208240f77152dca8920ea9be1decffe22f', '[\"*\"]', '2025-11-22 22:07:18', NULL, '2025-11-22 22:07:14', '2025-11-22 22:07:18'),
(200, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '042ec6de73a8e9041695b2c86d93739215761c158b66d1404d1f6f593405a2a1', '[\"*\"]', NULL, NULL, '2025-11-23 10:50:31', '2025-11-23 10:50:31'),
(201, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '807ec9d922bad3415d0ac99bdd9e10faad9f9afb7e9056a1a8c3a1bf20bda17b', '[\"*\"]', '2025-11-23 10:56:43', NULL, '2025-11-23 10:50:33', '2025-11-23 10:56:43'),
(202, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '03eafc60f91057b9d1064bd270bde7c3bd7e9d5797e48a09499b07625ec6fc4d', '[\"*\"]', '2025-11-23 11:03:00', NULL, '2025-11-23 11:01:39', '2025-11-23 11:03:00'),
(203, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4b33ba84a0814e5d4ddd3fb38d4540893728a5f76794a1ca530a9ce631fd4095', '[\"*\"]', '2025-11-23 11:10:01', NULL, '2025-11-23 11:09:29', '2025-11-23 11:10:01'),
(204, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c237ba3a3ba140cd37ad94f18197e129356417c9d32aa90562c48416bd58223d', '[\"*\"]', '2025-11-23 11:15:46', NULL, '2025-11-23 11:15:42', '2025-11-23 11:15:46'),
(205, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6c6e446954e174234e1d9128753ac0f5fdfb3f54f9debcecb9095a95de7558fb', '[\"*\"]', '2025-11-23 11:24:09', NULL, '2025-11-23 11:22:32', '2025-11-23 11:24:09'),
(206, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '3e9e2bc63b915f218d120e2beb3889b3ddeafd04cf7a8d16ab9599ca3688028e', '[\"*\"]', '2025-11-23 11:27:14', NULL, '2025-11-23 11:27:10', '2025-11-23 11:27:14'),
(207, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '3cdf7cdd4045482e259a1a4e6f5e0d1e0b53c58470a942206c758d6e490ea2b0', '[\"*\"]', '2025-11-23 11:29:13', NULL, '2025-11-23 11:27:51', '2025-11-23 11:29:13'),
(208, 'App\\Models\\ModelApi\\User', 20, 'auth_token_flutter_app', '3aba561d1a0550016434f3133f574e6ec5181427a15bd1410a0efb1531b1a65a', '[\"*\"]', '2025-11-23 20:01:25', NULL, '2025-11-23 11:30:49', '2025-11-23 20:01:25'),
(209, 'App\\Models\\ModelApi\\User', 20, 'auth_token_flutter_app', '6cfd0f60fc138acb6eab8fcafc3609dace1dd76e87490e83334db78a9344c956', '[\"*\"]', '2025-11-23 11:33:11', NULL, '2025-11-23 11:33:07', '2025-11-23 11:33:11'),
(210, 'App\\Models\\ModelApi\\User', 1, 'auth_token_flutter_app', '9b169127cdff5760ddf6e9436c42ed53901fb9864aec581e70040a0cb497d8d2', '[\"*\"]', '2025-11-23 20:39:09', NULL, '2025-11-23 20:03:23', '2025-11-23 20:39:09'),
(211, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'cff1ab0802a2bdb1f4da5cde66869cbcc6aa91af77567e519d5b3d3d62026337', '[\"*\"]', '2025-11-23 20:50:03', NULL, '2025-11-23 20:39:44', '2025-11-23 20:50:03'),
(212, 'App\\Models\\ModelApi\\User', 6, 'auth_token_flutter_app', 'af12767c83c40560012dc376bfcabd85ab6a31683fe09c3415713b8b561f7402', '[\"*\"]', '2025-11-23 20:54:55', NULL, '2025-11-23 20:52:33', '2025-11-23 20:54:55'),
(213, 'App\\Models\\ModelApi\\User', 12, 'auth_token_flutter_app', '4c68a70940e762ccf15eaf592b2cfe4f5f2dce5f94149548b4dd44939698b8ad', '[\"*\"]', NULL, NULL, '2025-11-23 20:52:57', '2025-11-23 20:52:57'),
(214, 'App\\Models\\ModelApi\\User', 12, 'auth_token_flutter_app', 'ac1d5b297476c115a79281a038ca8dcba75b8b32a5cad42e301a75e63e603f5f', '[\"*\"]', '2025-11-23 20:54:24', NULL, '2025-11-23 20:54:11', '2025-11-23 20:54:24'),
(215, 'App\\Models\\ModelApi\\User', 19, 'auth_token_flutter_app', '7438dd0f78aa8776fb6126435aea576e415507d392b21c76ad238d6909f1d1c2', '[\"*\"]', '2025-11-29 00:49:15', NULL, '2025-11-23 20:56:04', '2025-11-29 00:49:15'),
(216, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '601660c93c36d6ce657c3216f17790c9b498c5c7297ffc7f8d8a71d1ea3a1a1a', '[\"*\"]', '2025-11-28 02:29:42', NULL, '2025-11-24 21:04:50', '2025-11-28 02:29:42'),
(217, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'fca5bdc7895b35e9ea0c95767c76678718b64d2d46a178e9e8d2b6b6d2ac3f7f', '[\"*\"]', '2025-11-24 23:50:47', NULL, '2025-11-24 23:50:38', '2025-11-24 23:50:47'),
(218, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9575a33cb62aa2c550f172cdb768477da40ffd0a857cdc6fcc21ef88173a32ac', '[\"*\"]', '2025-11-25 00:07:09', NULL, '2025-11-25 00:04:33', '2025-11-25 00:07:09'),
(219, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'cba00b4abdf6a19c12271191953b0bd5a1cd6bdc39651b2d55413525e6f3892e', '[\"*\"]', '2025-11-25 02:18:50', NULL, '2025-11-25 00:39:24', '2025-11-25 02:18:50'),
(220, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '77ed14f4f2b24696c8d26f74fbf89d8cc944cc1d64a8a49f6c18dede9d95bee2', '[\"*\"]', NULL, NULL, '2025-11-26 06:54:21', '2025-11-26 06:54:21'),
(221, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd7b95b8ef3775a46381fc84ee601cae6e40c059bd86f5e24ca0086c1ab417453', '[\"*\"]', NULL, NULL, '2025-11-26 06:54:26', '2025-11-26 06:54:26'),
(222, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8e1362eba084bdaf013440d14d9a14ceeba24f29d072a3367f39b20009a26025', '[\"*\"]', '2025-11-26 06:56:06', NULL, '2025-11-26 06:54:50', '2025-11-26 06:56:06'),
(223, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c6a9ecedd5b022e9e9d82c86d1bde38a0d2e13dd89b4e68b7c79f5d3e0833742', '[\"*\"]', '2025-11-26 07:17:41', NULL, '2025-11-26 07:17:36', '2025-11-26 07:17:41'),
(224, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'bc85c5d9e9cddf79a74167da1aa886762267ed75fab8669c02d6955138e9ca69', '[\"*\"]', '2025-11-26 18:22:50', NULL, '2025-11-26 18:22:39', '2025-11-26 18:22:50'),
(225, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c2ba581bccfac87369edc2d835a7c4789e687f2b0b62a3d9d6a1c3949de5efe3', '[\"*\"]', '2025-11-26 18:33:32', NULL, '2025-11-26 18:31:36', '2025-11-26 18:33:32'),
(226, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5b6f3e98f47430a6bac68ad903131c0eec64b2ad41836adfb73986a114ae9c45', '[\"*\"]', '2025-11-26 19:13:47', NULL, '2025-11-26 19:13:21', '2025-11-26 19:13:47'),
(227, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '32ca18aef91628295a301ede59d0141460368d5069f1fd01519982b71f5b86e8', '[\"*\"]', NULL, NULL, '2025-11-28 00:54:34', '2025-11-28 00:54:34'),
(228, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3f1d3493031976e0f311f0fded6c228ef9fd711da0cd7ce1c93af3dd19c9090d', '[\"*\"]', '2025-11-28 01:37:02', NULL, '2025-11-28 00:54:37', '2025-11-28 01:37:02'),
(229, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '77520035ac35485e53286c2671153237b28b3f7bcc8f92799735b3e9b4980f3c', '[\"*\"]', '2025-11-28 02:05:26', NULL, '2025-11-28 01:54:54', '2025-11-28 02:05:26'),
(230, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '13b79c19a08e7c15ea79b6636374930b8189bdb736a4056fa0730ad77f9dd409', '[\"*\"]', '2025-11-28 02:06:36', NULL, '2025-11-28 02:05:41', '2025-11-28 02:06:36');
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(231, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '53c96b97a5614a878a345294bd19908df7b314a91b13eece759a8a1b9c51f285', '[\"*\"]', '2025-11-28 02:15:03', NULL, '2025-11-28 02:07:21', '2025-11-28 02:15:03'),
(232, 'App\\Models\\ModelApi\\User', 7, 'auth_token_flutter_app', 'bfa458b6dec03f2e5cc4baa999176558f1578b33e90fecd86f4c034fdde3ac3c', '[\"*\"]', '2025-11-28 02:22:35', NULL, '2025-11-28 02:15:41', '2025-11-28 02:22:35'),
(233, 'App\\Models\\ModelApi\\User', 7, 'auth_token_flutter_app', 'bb3a0799e1eaa901e9bdb5c5f89e65609cfa5e763b4bf3a7ef1f28d45b2070a9', '[\"*\"]', '2025-11-28 02:27:00', NULL, '2025-11-28 02:22:55', '2025-11-28 02:27:00'),
(234, 'App\\Models\\ModelApi\\User', 7, 'auth_token_flutter_app', '61747f1b43e7ffb06735b2ab7f4bcc062d32ace1e165434b4c86bcb7bd63f241', '[\"*\"]', '2025-11-28 02:28:43', NULL, '2025-11-28 02:28:40', '2025-11-28 02:28:43'),
(235, 'App\\Models\\ModelApi\\User', 7, 'auth_token_flutter_app', '3f3a5072b623a0c2f60c7f3a06b430478d11a4663837f6e5b47d5aa27239f0c6', '[\"*\"]', '2025-11-28 02:31:13', NULL, '2025-11-28 02:30:24', '2025-11-28 02:31:13'),
(236, 'App\\Models\\ModelApi\\User', 12, 'auth_token_flutter_app', '4b8ad7b56767cb043283241b8bbdb39207ef969f32d2ab4268da98d25c14f34c', '[\"*\"]', '2025-11-28 02:42:28', NULL, '2025-11-28 02:33:48', '2025-11-28 02:42:28'),
(237, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '7c292de20134574fcefd0e97e01174acae2e1db5385c7ed155f555ce57a6c5c9', '[\"*\"]', '2025-11-28 23:15:31', NULL, '2025-11-28 02:46:25', '2025-11-28 23:15:31'),
(238, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'da270b5e1af89ec7cb214de5c0f82b4db83b60d620f9236a288d4b41cfb83579', '[\"*\"]', NULL, NULL, '2025-11-28 21:07:34', '2025-11-28 21:07:34'),
(239, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9267561af22a7579a0e2249e2e603b1c616ada11a9a04171bc694b7e0f81cb18', '[\"*\"]', '2025-11-28 21:07:52', NULL, '2025-11-28 21:07:37', '2025-11-28 21:07:52'),
(240, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9fb10a5e919e80e2c0662a4cc1b14ffa17310874d2091aae9af7dee96d517964', '[\"*\"]', '2025-11-28 21:29:22', NULL, '2025-11-28 21:29:09', '2025-11-28 21:29:22'),
(241, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '92e6b2b33a1ef8d97940d049ba23d339fdd00bc9795e968a42f2747adf994967', '[\"*\"]', '2025-11-28 21:56:02', NULL, '2025-11-28 21:55:58', '2025-11-28 21:56:02'),
(242, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a460ead3e2589c8023ca4ff3db5ece582aabc5bdf2dbceb36f6ecb324419b2af', '[\"*\"]', NULL, NULL, '2025-11-28 23:14:40', '2025-11-28 23:14:40'),
(243, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '53265c0b69a57825704be3b5cb488cffcfe074acae0ebc95b4f4e43694327444', '[\"*\"]', '2025-11-28 23:22:17', NULL, '2025-11-28 23:16:01', '2025-11-28 23:22:17'),
(244, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '7bae495a2d950f4c2bba6365da7cae7a407b717cbc613c7a1ae1330cff66d278', '[\"*\"]', '2025-11-28 23:46:33', NULL, '2025-11-28 23:24:18', '2025-11-28 23:46:33'),
(245, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd391fb64f09bb254d3d6fd371b863e50fc56f7502d5f5f51862dff4d303fd2e2', '[\"*\"]', NULL, NULL, '2025-11-28 23:35:06', '2025-11-28 23:35:06'),
(246, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '76a80d33590726ace587822861636070c68e0fb8be44464f631e3c1f86355c1d', '[\"*\"]', '2025-11-29 00:22:59', NULL, '2025-11-28 23:46:50', '2025-11-29 00:22:59'),
(247, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '082c355143ff55403511a194a464408d07a7d087d10d53d40a2051c4d6dfeb6c', '[\"*\"]', '2025-11-29 00:23:44', NULL, '2025-11-29 00:23:25', '2025-11-29 00:23:44'),
(248, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f03afa14f7c75654fba3bae722ff750c0283d1b5e79dc4a35df6dd63d03eceb1', '[\"*\"]', '2025-11-29 00:26:06', NULL, '2025-11-29 00:25:32', '2025-11-29 00:26:06'),
(249, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '7eeea32d69a1f0964018ff8b9d3cb0504463ba42c87a180664c85938675cf2a4', '[\"*\"]', '2025-11-30 00:44:40', NULL, '2025-11-29 00:26:30', '2025-11-30 00:44:40'),
(250, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1abac8d664d74d7f89c4f4fc6ff64ce5292b83e57aee61cb2370996accf61733', '[\"*\"]', '2025-11-29 00:44:11', NULL, '2025-11-29 00:34:15', '2025-11-29 00:44:11'),
(251, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'e842ee87fe446774b12bcdfd8fac374435479c32a76ef9bc5a7927eb2502b965', '[\"*\"]', '2025-11-29 04:46:04', NULL, '2025-11-29 00:49:23', '2025-11-29 04:46:04'),
(252, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '10ba16dc060d1b35bb7eb0bcdbd7623e95155d4d992cce879deae01741049bb8', '[\"*\"]', '2025-11-29 01:36:38', NULL, '2025-11-29 01:36:33', '2025-11-29 01:36:38'),
(253, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6a8f546ca0f940a1392cacc840bbad6680f049bf1818361d596cb8999dbff7a6', '[\"*\"]', '2025-11-29 01:40:46', NULL, '2025-11-29 01:40:42', '2025-11-29 01:40:46'),
(254, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0f6c2d51f07d2508093d32b270dce52553f8c3151d9cb902e29fce5840203784', '[\"*\"]', '2025-11-29 01:47:52', NULL, '2025-11-29 01:47:24', '2025-11-29 01:47:52'),
(255, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'b9acbbfbbb79a606005e492fb5f01ef46c22b7e89da271c4bf9d1c0d46bca0ea', '[\"*\"]', '2025-11-29 01:51:45', NULL, '2025-11-29 01:50:29', '2025-11-29 01:51:45'),
(256, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '19c60f983e632f7b5e4f76bed13e23d376b572172490746af08ed47e84206593', '[\"*\"]', '2025-11-29 01:59:01', NULL, '2025-11-29 01:56:55', '2025-11-29 01:59:01'),
(257, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '25f688c8e42ff7218f119a6049b30f6486c36bec2711e0bc866d97f30c20d9bf', '[\"*\"]', '2025-11-29 02:05:02', NULL, '2025-11-29 02:04:31', '2025-11-29 02:05:02'),
(258, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'e564ebcbac0cdde4393065ec67803f23aa3dd33e0deb1e1da9a7952f4160ee11', '[\"*\"]', '2025-11-29 02:09:20', NULL, '2025-11-29 02:09:16', '2025-11-29 02:09:20'),
(259, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '301098b8349df6d5380276cb94e28910dc35096c9d492faf067e69b54087e18c', '[\"*\"]', '2025-11-29 02:22:55', NULL, '2025-11-29 02:21:04', '2025-11-29 02:22:55'),
(260, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '1e8c1f50c4bd105c487e52d878f937acf0164e8a0d25ee39873da76febdc45a8', '[\"*\"]', '2025-11-29 02:30:18', NULL, '2025-11-29 02:29:51', '2025-11-29 02:30:18'),
(261, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '8c9b0dc8ddf6728df359314135ca0c42ac6ad27d0aad6e48ad022fbff6cb2e10', '[\"*\"]', '2025-11-29 02:43:25', NULL, '2025-11-29 02:39:46', '2025-11-29 02:43:25'),
(262, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'f85df637dc0337eca9459aa22f3674affc6dad99c97cbad5a9ab8262edbd5acb', '[\"*\"]', '2025-11-29 02:56:06', NULL, '2025-11-29 02:55:29', '2025-11-29 02:56:06'),
(263, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '5906ef6b4d78c63e50d81424bb187be5fad0e8ece232a9b3a7b0731735f1485d', '[\"*\"]', '2025-11-29 03:04:27', NULL, '2025-11-29 03:03:40', '2025-11-29 03:04:27'),
(264, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'fcd3c91760ff9b44559328703cd2552fcddb1f474736008bf00d258d9c2b8119', '[\"*\"]', '2025-11-29 03:17:39', NULL, '2025-11-29 03:16:34', '2025-11-29 03:17:39'),
(265, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'bf5a49f300531dab2a605dcfc6903621d27966be465426abb555887d64dac30e', '[\"*\"]', '2025-11-29 03:29:57', NULL, '2025-11-29 03:29:39', '2025-11-29 03:29:57'),
(266, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '0cb96aeb992e145bd97f61d042366ee72c19c3cfa6a644f7125ca349e51b17d5', '[\"*\"]', '2025-11-29 03:56:12', NULL, '2025-11-29 03:56:07', '2025-11-29 03:56:12'),
(267, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'b36028a2d4d9c989c978b4527dad878f8df47cd68f7e30b9269ce97451e19a88', '[\"*\"]', '2025-11-29 03:57:27', NULL, '2025-11-29 03:56:48', '2025-11-29 03:57:27'),
(268, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '6c01aa49267accf8839f865ea94c7002bb48d25eeb0cc1de13d7990a92be5d94', '[\"*\"]', '2025-11-29 04:03:52', NULL, '2025-11-29 03:57:59', '2025-11-29 04:03:52'),
(269, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '19631dca9752c31cead0cd7bd866889eb1cbf9266c12b1cfc10083ae03034a38', '[\"*\"]', '2025-11-29 04:54:59', NULL, '2025-11-29 04:52:16', '2025-11-29 04:54:59'),
(270, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9464dcc5090b94a69f1eeb28b6d908a634a0ce380da7258c7198bc1eb008e526', '[\"*\"]', '2025-12-07 04:14:38', NULL, '2025-11-30 00:48:15', '2025-12-07 04:14:38'),
(271, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '26321c7ab223603894777399ee761e18ac28eeb333bb8aad0905b256ce4ceee5', '[\"*\"]', NULL, NULL, '2025-11-30 01:16:30', '2025-11-30 01:16:30'),
(272, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '3ab3722c1c8e1f01860b0272d8d271d22ea5b0ddc2993f864ccf9d10d677d3cc', '[\"*\"]', '2025-11-30 01:20:31', NULL, '2025-11-30 01:16:41', '2025-11-30 01:20:31'),
(273, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'f16778a36681aa98b3c5a527ee14158b0ef26528ec090c31aa413fad3abf644a', '[\"*\"]', '2025-11-30 01:47:22', NULL, '2025-11-30 01:47:18', '2025-11-30 01:47:22'),
(274, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e4acf0fbad3d7e65f2e1a0e98d67a31a3b0c61a24b439edea49000ef221afdb2', '[\"*\"]', '2025-11-30 06:11:27', NULL, '2025-11-30 06:11:23', '2025-11-30 06:11:27'),
(275, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '43328c3c8f70e2bc899598f6925d48d25a451a76f9a6a4eea83c1f4646a1a4e5', '[\"*\"]', '2025-11-30 06:14:20', NULL, '2025-11-30 06:13:54', '2025-11-30 06:14:20'),
(276, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ebd54f840c89e921eeca99dd3cac48e0cb841074d84a15f1e04426c3570d6f8c', '[\"*\"]', '2025-11-30 06:24:30', NULL, '2025-11-30 06:23:30', '2025-11-30 06:24:30'),
(277, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '93874f6472c10e7ff2a134a0b47fd0a910338346e6a7a4580a9ea117ca0cb27a', '[\"*\"]', '2025-11-30 06:40:15', NULL, '2025-11-30 06:40:09', '2025-11-30 06:40:15'),
(278, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f9eb59c0e029dda81af01e95e4e8ddb1aeb706939e532f4503eb0362653ce5f6', '[\"*\"]', '2025-11-30 06:50:51', NULL, '2025-11-30 06:50:46', '2025-11-30 06:50:51'),
(279, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '2827c61405397d2da06a026ebdf72d3bf1757713f5617d542687680dfcbf3d0a', '[\"*\"]', '2025-11-30 08:43:59', NULL, '2025-11-30 08:43:44', '2025-11-30 08:43:59'),
(280, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '45d653bedc155ff354784e2e474569c35ab7ca14753ff6c005be6ca25bbdbfa3', '[\"*\"]', '2025-11-30 08:53:08', NULL, '2025-11-30 08:53:04', '2025-11-30 08:53:08'),
(281, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '7884d1c4b8ad8cedd603a5bb1192ecc8a1249d36382245535230da4b2034543f', '[\"*\"]', '2025-12-01 07:29:04', NULL, '2025-12-01 07:28:20', '2025-12-01 07:29:04'),
(282, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd09ad17cc6ee7ce92942d80c43d7f26534251c64887d90f20b006f42b02512ca', '[\"*\"]', NULL, NULL, '2025-12-01 21:26:52', '2025-12-01 21:26:52'),
(283, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '79ec8f27d3b58d4894db6ceedfe0363b78b403c0803f34ffc8a3c102b191bc3c', '[\"*\"]', '2025-12-01 21:27:59', NULL, '2025-12-01 21:26:54', '2025-12-01 21:27:59'),
(284, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd84161ef214cea056f82fa795b8262470a1ad82b7e35de6246a73fc675f50bb9', '[\"*\"]', NULL, NULL, '2025-12-01 21:31:57', '2025-12-01 21:31:57'),
(285, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '7e66521b0671e665ea0222b1274ccddb47fac5f2793a76b0f568c796b1ff449a', '[\"*\"]', '2025-12-01 21:33:02', NULL, '2025-12-01 21:32:33', '2025-12-01 21:33:02'),
(286, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '2ca3e34c9cf697dfa86f1ec488c43003f6ae7ccdd433b1531bfce6b95ec9d67a', '[\"*\"]', '2025-12-01 21:38:41', NULL, '2025-12-01 21:38:33', '2025-12-01 21:38:41'),
(287, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '614e7b07e40f1f68302a3cf36a08d6bf59352c3fb124dc3590ff88ae8a310243', '[\"*\"]', '2025-12-01 21:47:13', NULL, '2025-12-01 21:47:04', '2025-12-01 21:47:13'),
(288, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '2991e31b2fd6e912f613bc5725688f33cd736a42be8a81cfe5e6c879dc98c56d', '[\"*\"]', '2025-12-01 23:13:42', NULL, '2025-12-01 23:13:34', '2025-12-01 23:13:42'),
(289, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '6e83400b7173853273e29f8c0e1844aa3d16696992ecf3e4466157d0e24f1811', '[\"*\"]', '2025-12-01 23:17:26', NULL, '2025-12-01 23:17:13', '2025-12-01 23:17:26'),
(290, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd141c0f7266bc8eadb05f106630330a338f66ea9a86104d55b66d5385ee197c7', '[\"*\"]', '2025-12-01 23:26:26', NULL, '2025-12-01 23:26:21', '2025-12-01 23:26:26'),
(291, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0084eee9f1aef515bc9d0b67c6f481cc05aef0fc252c44d18770ee71c045abef', '[\"*\"]', '2025-12-01 23:39:14', NULL, '2025-12-01 23:39:08', '2025-12-01 23:39:14'),
(292, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0818b06bb940e9452b02d01f6dacd30df3ab8e3ca26dc0dc1288240afabe4435', '[\"*\"]', '2025-12-01 23:42:24', NULL, '2025-12-01 23:40:59', '2025-12-01 23:42:24'),
(293, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1533820e0c50be33e4acae2c3a7e3d76ae57d076f476ba89df9257bcae0bd643', '[\"*\"]', '2025-12-01 23:54:28', NULL, '2025-12-01 23:52:36', '2025-12-01 23:54:28'),
(294, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'cb2e6c2a1f7fb393f14823bcfb8c3cb272a8ed7a133e71ea01587f1dcf7f6730', '[\"*\"]', '2025-12-02 00:08:05', NULL, '2025-12-02 00:07:27', '2025-12-02 00:08:05'),
(295, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4f640fbb2aa5d9ad6f709175e146b9c3867cd7b61f1e1f532f80dc0577617d47', '[\"*\"]', '2025-12-02 00:57:05', NULL, '2025-12-02 00:56:56', '2025-12-02 00:57:05'),
(296, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ddf3a88fe040426ff549b9ad6022a935493aa1e3bf6e41e0fcd3f009e126ef71', '[\"*\"]', '2025-12-02 01:03:13', NULL, '2025-12-02 01:03:08', '2025-12-02 01:03:13'),
(297, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'f7eddc1d9e6cb5c0f18e8ad4b34bb2e8b8c0011d367577aa504bfb9997c50efe', '[\"*\"]', '2025-12-02 02:14:29', NULL, '2025-12-02 01:49:22', '2025-12-02 02:14:29'),
(298, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd76952f7b580564717256a5a61c7ebfe2a57e464c40d40805662be70c2e8d2f6', '[\"*\"]', '2025-12-02 02:22:07', NULL, '2025-12-02 02:19:01', '2025-12-02 02:22:07'),
(299, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '01056de46f6244ac279e93008a85d04d6371b3d4d3e6417d87dbe3faa5b136de', '[\"*\"]', '2025-12-02 02:22:39', NULL, '2025-12-02 02:22:29', '2025-12-02 02:22:39'),
(300, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'd7256f9dc36b2b844c614fa5a285dd5617668a48779ba2ddf38a4193b916fbf1', '[\"*\"]', '2025-12-02 22:55:17', NULL, '2025-12-02 21:51:27', '2025-12-02 22:55:17'),
(301, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6cb20ad53c581044abacca3620bc4a942b36d2923e07706403a262bf1692e8ee', '[\"*\"]', NULL, NULL, '2025-12-04 01:23:46', '2025-12-04 01:23:46'),
(302, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e8d0796966eb4c3f325804357c45715a7303b83585dbecf3f2ab0ab47a391797', '[\"*\"]', '2025-12-04 01:23:59', NULL, '2025-12-04 01:23:48', '2025-12-04 01:23:59'),
(303, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '797946194b5e28c5845b240d0937d335c398f472e6f6d764c610af2d340d749a', '[\"*\"]', NULL, NULL, '2025-12-05 21:09:13', '2025-12-05 21:09:13'),
(304, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6514393d328fbc7e7c1f26b475e97897a589f08cfda60a04df7b1e39084687bc', '[\"*\"]', '2025-12-05 21:11:19', NULL, '2025-12-05 21:11:09', '2025-12-05 21:11:19'),
(305, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c144f5317c51f0862b384efe017922e6c6995fb3a6b2e04c0b8e1c2df4070403', '[\"*\"]', '2025-12-05 21:14:37', NULL, '2025-12-05 21:14:01', '2025-12-05 21:14:37'),
(306, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3f99eeba9df8401aa1af55cd7e48aa61604d0b28c7268086ae0bc1d56d6015a6', '[\"*\"]', '2025-12-05 21:35:57', NULL, '2025-12-05 21:35:44', '2025-12-05 21:35:57'),
(307, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8ca74f1f12129a2e913f4c214978b3e6bd159ebc428a6998bddb3ab820e72593', '[\"*\"]', '2025-12-05 21:44:41', NULL, '2025-12-05 21:44:32', '2025-12-05 21:44:41'),
(308, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '492a799d9a54627eea8e02261c7e2a58f9dc5901c4bd7a8a839d90e93bf3bb23', '[\"*\"]', '2025-12-05 22:44:48', NULL, '2025-12-05 22:44:32', '2025-12-05 22:44:48'),
(309, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '61447196f6fcc95d2bc779e9c937051d9e11280f9949f7618cce18dad010a1b4', '[\"*\"]', '2025-12-05 22:47:32', NULL, '2025-12-05 22:47:25', '2025-12-05 22:47:32'),
(310, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '965f2fd0fe21cd9ac82487e5c6eac88e95da56e6c8d1550e624e50204b283aa7', '[\"*\"]', NULL, NULL, '2025-12-05 22:58:34', '2025-12-05 22:58:34'),
(311, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '2341ad0823b115036aaa246e0d0ae9a3d0e40b25b4a489d70680ecdda2e6dfd7', '[\"*\"]', NULL, NULL, '2025-12-05 22:58:38', '2025-12-05 22:58:38'),
(312, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e9ae148488182226d878358a773da173a778720d36c7ca30ec1f9122357fd62b', '[\"*\"]', NULL, NULL, '2025-12-05 22:58:38', '2025-12-05 22:58:38'),
(313, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0952e3a183b293a5542708f7b2ab41a93e575935e403c47217e4c5e12ce6c537', '[\"*\"]', '2025-12-05 23:01:26', NULL, '2025-12-05 22:58:39', '2025-12-05 23:01:26'),
(314, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9db4ceec10947b5d6871da901fbc7b72f022cc51cba8c60405a4073a0e08cb3b', '[\"*\"]', '2025-12-05 23:07:52', NULL, '2025-12-05 23:07:15', '2025-12-05 23:07:52'),
(315, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '37f7192a0ce28bc35f80afebbfb40bd64ee4484e43db714a0c07d778d2457b37', '[\"*\"]', '2025-12-05 23:11:54', NULL, '2025-12-05 23:11:45', '2025-12-05 23:11:54'),
(316, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5a3e83685b5840e5b3c38b4067fa602972ce76607b42a8eca9437d4240c2c4a1', '[\"*\"]', '2025-12-05 23:17:45', NULL, '2025-12-05 23:17:38', '2025-12-05 23:17:45'),
(317, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '720a6d57b2ef9051529d0edf92b13f2b0ddc59a32fb54c0015c8232c3b50804a', '[\"*\"]', '2025-12-05 23:24:45', NULL, '2025-12-05 23:23:33', '2025-12-05 23:24:45'),
(318, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '251fc34f71d0cd940dd441a3dad5c552f7d802ebaac85de7bd94798e5152b776', '[\"*\"]', '2025-12-05 23:41:19', NULL, '2025-12-05 23:41:09', '2025-12-05 23:41:19'),
(319, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c4294950d068b75d895c62b300a960aa55aa1c0caaabf4aff43c230a32263d25', '[\"*\"]', '2025-12-05 23:49:35', NULL, '2025-12-05 23:48:33', '2025-12-05 23:49:35'),
(320, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8e7f29c91858c67155f296a9660cea90823e3d601e260db74369ca0dbf48e669', '[\"*\"]', '2025-12-06 00:18:06', NULL, '2025-12-05 23:53:47', '2025-12-06 00:18:06'),
(321, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e2e19fb41010ce580fe42a364073dd3a0a847c13f9868872669488424c8ae4e2', '[\"*\"]', '2025-12-06 00:34:05', NULL, '2025-12-06 00:33:56', '2025-12-06 00:34:05'),
(322, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3bab5110d25c5d1de8302a2310a8865c454634cee9741ca170356d9ab84f6d0c', '[\"*\"]', '2025-12-06 00:42:50', NULL, '2025-12-06 00:38:18', '2025-12-06 00:42:50'),
(323, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'd1ffa5199caf4cfb785bd04dd6ee6894679a27f9c253dee01f3b7f1b48963824', '[\"*\"]', '2025-12-06 00:43:46', NULL, '2025-12-06 00:43:38', '2025-12-06 00:43:46'),
(324, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5459ae7df4821fa70c24baf00c1c9d92fba62f9d37b7ea58df9923768faeb50e', '[\"*\"]', '2025-12-06 00:52:50', NULL, '2025-12-06 00:52:45', '2025-12-06 00:52:50'),
(325, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'ef6ab7c3f35221442597ff2d3b86c827c78989c3522f7859f03f0d42350e9e88', '[\"*\"]', '2025-12-06 00:53:13', NULL, '2025-12-06 00:53:06', '2025-12-06 00:53:13'),
(326, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '20d930787f5283a1a844e0614b4fedca4869633933a9f4f24448fcb1b45889f9', '[\"*\"]', '2025-12-06 00:58:36', NULL, '2025-12-06 00:58:24', '2025-12-06 00:58:36'),
(327, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'bb6a515e0cafd3ba8bdade8672d234d04ca3b30269d90c56b032aedefc1128b7', '[\"*\"]', '2025-12-06 01:08:10', NULL, '2025-12-06 01:08:01', '2025-12-06 01:08:10'),
(328, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '06e732cd18190ebc299128bf67febc3f4644d69800a601b2ed1f4d91fd6e28f6', '[\"*\"]', '2025-12-06 01:08:35', NULL, '2025-12-06 01:08:28', '2025-12-06 01:08:35'),
(329, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '89b8db80ef04ce3be987f362ec1964a313737c904a2743527b437672e4e903c5', '[\"*\"]', '2025-12-06 01:20:23', NULL, '2025-12-06 01:20:17', '2025-12-06 01:20:23'),
(330, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6724c802c27f420728e37da9d635e393672d6014047c3c13891c7021e1f086ff', '[\"*\"]', '2025-12-06 01:20:45', NULL, '2025-12-06 01:20:39', '2025-12-06 01:20:45'),
(331, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '6ca6eaf79173010c62d1fe42500a9e6c6588dab30646b9cb3d76d71657a31d6f', '[\"*\"]', '2025-12-06 01:23:14', NULL, '2025-12-06 01:21:02', '2025-12-06 01:23:14'),
(332, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1b7bc72cbc008b413abb80e762e424daa8d189354a94d075e2ab35a4c276aa1e', '[\"*\"]', '2025-12-06 01:34:32', NULL, '2025-12-06 01:34:28', '2025-12-06 01:34:32'),
(333, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '62458b5e7145cb4c8e1618ed6a1d8ed7170a456dfa4d4d2a0347ac9a85811264', '[\"*\"]', NULL, NULL, '2025-12-06 19:41:40', '2025-12-06 19:41:40'),
(334, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'bb3a294d67a66813abae407522fe3b9cd384a9a66daef0028a9069adfdf12c08', '[\"*\"]', NULL, NULL, '2025-12-06 19:41:47', '2025-12-06 19:41:47'),
(335, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '63547a93fae3fa3cc4ca1443548dad7ba82b23663a88f56b2e4ef49c73e69032', '[\"*\"]', '2025-12-06 19:46:45', NULL, '2025-12-06 19:43:47', '2025-12-06 19:46:45'),
(336, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'f5498df19fbc966308a6ecf3b25e75194dc6807fdc2a60c52a919bf7acbee60d', '[\"*\"]', '2025-12-06 19:47:59', NULL, '2025-12-06 19:46:59', '2025-12-06 19:47:59'),
(337, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '64897267c2ed1b7fdc827c5bac027fe117f796b196902294775f4b73a8641d5d', '[\"*\"]', '2025-12-07 04:15:29', NULL, '2025-12-07 04:15:04', '2025-12-07 04:15:29'),
(338, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '0018c3a7be44eaf214b93aa8f043054e6c1ff92f4296aee9801100977bcde7bc', '[\"*\"]', '2025-12-07 09:05:48', NULL, '2025-12-07 04:26:33', '2025-12-07 09:05:48'),
(339, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ee0f7df80abe2c80d78a25e4a87701639c7090ee098b64a8e328e77ca1d95040', '[\"*\"]', '2025-12-07 07:36:25', NULL, '2025-12-07 07:35:20', '2025-12-07 07:36:25'),
(340, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'fc30c7d64ef16e7ef5a4cb93c6ba5f7d39cb7661dc517ebc9b9c79c5580bb4a7', '[\"*\"]', NULL, NULL, '2025-12-07 09:09:34', '2025-12-07 09:09:34'),
(341, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'e4bd6c3dd1904acaafc79e7203dce654a930acc08b5d1faf8223698c428a2eab', '[\"*\"]', '2025-12-07 09:20:19', NULL, '2025-12-07 09:10:55', '2025-12-07 09:20:19'),
(342, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3e0ae60f8f98269ccb1f6e0d8e7dd1151f2b50cc4858d2b3ab8f7520da85a4a7', '[\"*\"]', '2025-12-07 09:13:09', NULL, '2025-12-07 09:13:02', '2025-12-07 09:13:09'),
(343, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '89fecd54a5699de490f750d74cb63514743bf847b0dde0a9d1fc4ed2658c458a', '[\"*\"]', '2025-12-08 23:40:35', NULL, '2025-12-07 09:20:33', '2025-12-08 23:40:35'),
(344, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4276878bb299aa3708539cfee4f2df27eb73c52a87bef47840858a7add7aca86', '[\"*\"]', NULL, NULL, '2025-12-07 09:20:42', '2025-12-07 09:20:42'),
(345, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '43bfbc4b708ff713a814f5632406ec02392b44ed49ce42fd5ef3a92743cab72e', '[\"*\"]', '2025-12-07 09:39:59', NULL, '2025-12-07 09:39:53', '2025-12-07 09:39:59'),
(346, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8ffecb0bb9ecc63acdf02c95c0b524e220560baaa9ea2548acb84fb9dc66c933', '[\"*\"]', '2025-12-07 10:32:17', NULL, '2025-12-07 10:32:10', '2025-12-07 10:32:17'),
(347, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '67f3642a68e4fe3a2df0f67908516e883073327605a753a2fa040fa38ce99c7d', '[\"*\"]', '2025-12-07 10:37:20', NULL, '2025-12-07 10:37:15', '2025-12-07 10:37:20'),
(348, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1b13e1f0aa37ecb65fc32c02acf6fad469eea1fc1d0a59062796bf53a326a0b6', '[\"*\"]', '2025-12-07 10:44:40', NULL, '2025-12-07 10:44:34', '2025-12-07 10:44:40'),
(349, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '6ca5ba412f4cb7a4ee60c6cdc59afeabdca0e4d9fad221f1196bbb2000d30bfb', '[\"*\"]', '2025-12-07 10:55:04', NULL, '2025-12-07 10:55:00', '2025-12-07 10:55:04'),
(350, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '19afbe270c9fb0409ec0a01108accfcfe90b43069b41282b0fbacf21cc1c5ff2', '[\"*\"]', NULL, NULL, '2025-12-08 21:26:20', '2025-12-08 21:26:20'),
(351, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '9af4a69e2404a95227f5be61712241e7ee935e8d113ba3b4374773165e53297a', '[\"*\"]', '2025-12-08 21:26:35', NULL, '2025-12-08 21:26:25', '2025-12-08 21:26:35'),
(352, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8dc6702d0592b4dc9cae86b0ad46178cb1e3975168d068dda2fce6f68e86c60f', '[\"*\"]', '2025-12-08 21:51:05', NULL, '2025-12-08 21:49:54', '2025-12-08 21:51:05'),
(353, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1cc64732833212e6739f3e8579c6a87432a4d2db8f55661235ecf9ed8d405979', '[\"*\"]', '2025-12-08 21:56:00', NULL, '2025-12-08 21:54:44', '2025-12-08 21:56:00'),
(354, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'af8a6238beb1d95f49a8d0556adb7b3fd4deef986fa38ac90625c1e7f01dfaa8', '[\"*\"]', '2025-12-08 23:57:05', NULL, '2025-12-08 23:33:51', '2025-12-08 23:57:05'),
(355, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4866f550fdf2f0d9364e1313607c2d60142fd9f3f7357c359a57ae36d3989402', '[\"*\"]', '2025-12-09 00:13:17', NULL, '2025-12-09 00:00:12', '2025-12-09 00:13:17'),
(356, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '47bdecdfcf542bcaff745e2aff2b973c9bb4f8ce13463399b25074e9a6393439', '[\"*\"]', '2025-12-09 00:15:10', NULL, '2025-12-09 00:13:56', '2025-12-09 00:15:10'),
(357, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '98d065172b8bd2f14f4a25469802fe19f70e168bfc067ef07f9ad42f91030b22', '[\"*\"]', '2025-12-09 00:16:11', NULL, '2025-12-09 00:15:59', '2025-12-09 00:16:11'),
(358, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '816a18abe18ba8ac676ef7edcee7977ac6303e19f8fe2893fc947bdfa28dee36', '[\"*\"]', '2025-12-09 00:53:08', NULL, '2025-12-09 00:51:28', '2025-12-09 00:53:08'),
(359, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '4fe85c0ee04e2368c9eb957ba15d6fee2858ad1c9ee514c4f29c003a2446d990', '[\"*\"]', '2025-12-09 01:52:02', NULL, '2025-12-09 01:50:57', '2025-12-09 01:52:02'),
(360, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '881a3be8b4d5ec0ccdea7c5e509ee710975cb5a94361eb4a3a5c9dc45fde0d46', '[\"*\"]', NULL, NULL, '2025-12-10 18:32:27', '2025-12-10 18:32:27'),
(361, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '754e40453e220ae8ba67ccd589f9b316fbdfb287554704b05866606782cc6d03', '[\"*\"]', '2025-12-10 18:51:26', NULL, '2025-12-10 18:32:34', '2025-12-10 18:51:26'),
(362, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'b29a262323f7ba808fac646733232f6d645f41e6bf127784a24c6898f94c4e19', '[\"*\"]', '2025-12-10 19:19:19', NULL, '2025-12-10 19:18:49', '2025-12-10 19:19:19'),
(363, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '1e563ac12d825731c1945b99902ee5936c3e6a1f8f34531509c289e61cd07f0c', '[\"*\"]', '2025-12-12 05:32:30', NULL, '2025-12-10 19:21:01', '2025-12-12 05:32:30'),
(364, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a83a62cad2fd1de94bfb2abb6412e16dafc94175ab2d8ebb1bbcf6134681b355', '[\"*\"]', NULL, NULL, '2025-12-12 04:01:32', '2025-12-12 04:01:32'),
(365, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '3a560859e287f91eaaf2ddd7f62e16be83dc821a381a8faeffae9ee7d897ec37', '[\"*\"]', '2025-12-12 04:42:21', NULL, '2025-12-12 04:17:56', '2025-12-12 04:42:21'),
(366, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e3c63332fd5bd44a753450cf618488a8026efcb696ae994330854150ab9e4888', '[\"*\"]', '2025-12-12 05:04:19', NULL, '2025-12-12 05:03:31', '2025-12-12 05:04:19'),
(367, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ab6a7c51cad5eddf454a060180e3ca41ff4baf0615b2ca903de5543e0a863a0c', '[\"*\"]', '2025-12-12 05:07:19', NULL, '2025-12-12 05:04:41', '2025-12-12 05:07:19'),
(368, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ee436ab819dc67e5d169477fba591675f58f431702e77b192a525da8692c0af2', '[\"*\"]', '2025-12-12 05:13:10', NULL, '2025-12-12 05:12:35', '2025-12-12 05:13:10'),
(369, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '39e3707ce03559455ce0d52c0c1a1c0ba23431f29dd26f8dd4872286b07a3781', '[\"*\"]', '2025-12-12 05:20:58', NULL, '2025-12-12 05:18:31', '2025-12-12 05:20:58'),
(370, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '905756be06dcc175a3d38ea4bbc7b6f7a580fdd0cf1fb96475ed576947c2ac2c', '[\"*\"]', '2025-12-12 05:26:33', NULL, '2025-12-12 05:25:53', '2025-12-12 05:26:33'),
(371, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'c4e7697bde31b92c87dbcf69b304b5690e422fa4a5fda625a88b53aa54a965d3', '[\"*\"]', '2025-12-12 05:28:11', NULL, '2025-12-12 05:28:07', '2025-12-12 05:28:11'),
(372, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'fb1da7a3f9c0cabd2ffb587714755fc24e50dffb5bb1e799e1b09eae537c06bd', '[\"*\"]', '2025-12-12 05:31:13', NULL, '2025-12-12 05:31:06', '2025-12-12 05:31:13'),
(373, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a787b248a1ab32c1c84aa1ee21c9110cba9f06b9389ea52e6db12acf9118fead', '[\"*\"]', '2025-12-12 05:57:23', NULL, '2025-12-12 05:32:55', '2025-12-12 05:57:23'),
(374, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '31d9ce7944a761dda50e5e65a1a1a2f4a53c20d9ec9ae51135a07fa9b55104e2', '[\"*\"]', '2025-12-12 05:40:15', NULL, '2025-12-12 05:39:26', '2025-12-12 05:40:15'),
(375, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '1ace6541bb26ffd1a3a5746c505223d9793f608ed1a4250b7c6572ad71908acb', '[\"*\"]', '2025-12-12 05:50:59', NULL, '2025-12-12 05:50:53', '2025-12-12 05:50:59'),
(376, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '916bafe15b58d09c1e2c70cef736b12d53853c0e03a1c2eef50aa7e5629a9b55', '[\"*\"]', '2025-12-12 06:24:51', NULL, '2025-12-12 06:13:46', '2025-12-12 06:24:51'),
(377, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '069064450f86dc49858e63a70f2ad1e5f2094e74317edaa39913e03982b57f54', '[\"*\"]', '2025-12-13 22:40:24', NULL, '2025-12-12 08:11:57', '2025-12-13 22:40:24'),
(378, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '7a17da029ca80a183a15b8c11598e03f61a524a81f617c20a667ca02bce78724', '[\"*\"]', '2025-12-12 08:57:11', NULL, '2025-12-12 08:56:40', '2025-12-12 08:57:11'),
(379, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'b079e27896095799cf98f127d4c6bc7ce8b3429cb154a78217e5abda31b6ab8e', '[\"*\"]', '2025-12-12 09:16:51', NULL, '2025-12-12 09:16:40', '2025-12-12 09:16:51'),
(380, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'e1823b91888c671c4fc1e06baf0e5cd79cb76e62cc183d0c2bd1f3b5dac68a1f', '[\"*\"]', '2025-12-12 09:49:25', NULL, '2025-12-12 09:47:47', '2025-12-12 09:49:25'),
(381, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'ce6bc40ae24f10a6dd763aa6127aaf4ed182d91266108dd74fd659b8676e8ec7', '[\"*\"]', '2025-12-12 10:00:10', NULL, '2025-12-12 09:58:57', '2025-12-12 10:00:10'),
(382, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', 'a25b01bebf7fce8c15a3dddda23804d990f45f9dc11d055077c1e685e0c80f18', '[\"*\"]', '2025-12-12 11:18:53', NULL, '2025-12-12 11:08:12', '2025-12-12 11:18:53'),
(383, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', '6962cf37b8497a82fa9029147b1425211473bcc5ada5648bc3a782a69dac7b47', '[\"*\"]', '2025-12-12 11:40:14', NULL, '2025-12-12 11:19:45', '2025-12-12 11:40:14'),
(384, 'App\\Models\\ModelApi\\User', 33, 'auth_token_flutter_app', 'a22c84bbeca5bef53938219ee7fa1df5c84365c62afb891d3660784dc0c09611', '[\"*\"]', NULL, NULL, '2025-12-13 22:36:38', '2025-12-13 22:36:38'),
(385, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '8c06709d669af2ce5dfead8228923f61dda4256f4420c38e6d7e34eed223ac35', '[\"*\"]', NULL, NULL, '2025-12-14 01:39:26', '2025-12-14 01:39:26'),
(386, 'App\\Models\\ModelApi\\User', 23, 'auth_token_flutter_app', '5374910c6b876e9edb3baa053f50186042acfa47b3c6d13f332fe576feb6880a', '[\"*\"]', '2025-12-14 01:43:32', NULL, '2025-12-14 01:39:41', '2025-12-14 01:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

DROP TABLE IF EXISTS `prodi`;
CREATE TABLE `prodi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_prodi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `jurusan_id`, `nama_prodi`, `created_at`, `updated_at`) VALUES
(1, 1, 'D4-Teknik Telekomunikasi', '2025-10-22 06:09:21', '2025-10-22 06:09:21'),
(2, 2, 'D3-Teknik Mesin', '2025-10-22 06:09:21', '2025-10-22 06:09:21'),
(3, 1, 'D3 Teknik Informatika', NULL, NULL),
(4, 1, 'D4 Teknologi Rekayasa Komputer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prodi_dosen`
--

DROP TABLE IF EXISTS `prodi_dosen`;
CREATE TABLE `prodi_dosen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prodi_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revisi_tugas_akhir`
--

DROP TABLE IF EXISTS `revisi_tugas_akhir`;
CREATE TABLE `revisi_tugas_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_akhir_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `catatan_revisi` text NOT NULL,
  `status_revisi` varchar(255) NOT NULL DEFAULT 'Belum Selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2025-12-15 03:44:58', '2025-12-15 03:44:58'),
(2, 'dosen', 'web', NULL, NULL),
(3, 'superadminn', 'web', '2025-12-18 06:18:55', '2025-12-18 06:18:55'),
(4, 'mahasiswa', 'web', '2025-12-18 13:50:46', '2025-12-18 13:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_menus`
--

DROP TABLE IF EXISTS `role_has_menus`;
CREATE TABLE `role_has_menus` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_menus`
--

INSERT INTO `role_has_menus` (`role_id`, `menu_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(2, 9),
(2, 10),
(2, 11);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

DROP TABLE IF EXISTS `ruangan`;
CREATE TABLE `ruangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`, `created_at`, `updated_at`) VALUES
(1, 'Lab Multimedia SB II/04', '2025-11-03 03:53:41', '2025-11-03 03:53:41'),
(2, 'GKT 803', '2025-11-09 04:56:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sesi`
--

DROP TABLE IF EXISTS `sesi`;
CREATE TABLE `sesi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_sesi` varchar(255) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sesi`
--

INSERT INTO `sesi` (`id`, `nama_sesi`, `waktu_mulai`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(1, 'Sesi 1', '08:00:00', '00:00:00', '2025-11-03 03:55:57', '2025-11-03 03:55:57'),
(2, 'Sesi 2', '10:00:00', '11:00:00', NULL, NULL),
(3, 'sesi 3', '09:32:09', '11:32:09', '2025-12-11 02:32:09', '2025-12-11 02:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0RmZn23hL2pwBwcNQVECblgLmNbD8CWA0QYcCFVM', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjlPc0phcExsemhLaTVwSHNhNDlsaFhSb1o0UUxrODhQQnZXSXN2ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765688206),
('7FaAgxaVHheMaus401iLO59Ul51L8beE6C0O6r5b', NULL, '192.168.55.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoianEwSjRCRmwyYnVqWDBLQ05icU1CYXl5bnFyVXlwMjJ2c241cklFMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjU1LjIxOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763270416),
('9MFOAXBqg9LMDcdHf1WQG3DNXlB5JvB9eX6UHbHw', NULL, '172.16.160.154', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidndZdlhMQjNVVTBIU2p1a3hvWldETlkzcmhrcjk0cGg2OFJFYnZaViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYwLjE1NDo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764205501),
('aiKvMcbOPQzo2HjTOTNkNNu3nLIVCBEI66M0TOqd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkVvdkpvTHhLcEJoaFNDTFY0bjZqQ29BbUxJc1BIZGtRUG9sYWgzSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765538020),
('aPaOHXMEzIWCel9T5O13P4WWum59odzN7UAVzUjF', NULL, '10.19.92.232', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUZRckpMNTVieUxnVnRzMUlPejFDNGRxUTJKUEpyb01iOTZ4MkNxNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMC4xOS45Mi4yMzI6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764389091),
('Ccjn4LzhFKza388HAa7HKXwgH8ACewxgcaU8mj0L', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0dlNTZKQWZSUVI2NXQ4NUJ1bGQ2WUpUb08yQkJsRDRmT1JHUndKaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765074910),
('da3cTEX5WpLCuNdjmzaHwt04kP1PLRVIyHJLmQLJ', NULL, '172.16.163.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaEtrbFpPZWVjeTZUV1pOa25RTXhNb1VhT2RPM25nOUlYZjhlcFQzQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYzLjI0NDo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764054178),
('dvDjyIgjr1DMqBnRh4scvklU57WTMFvZcD3ShYhC', NULL, '172.16.162.231', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnVpbzQxV2tVamF4ZGxsNVZEakdSV1hiWUZXV1RLVkIyOVN4TmR5cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYyLjIzMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763000061),
('EFfe5h5hRHbZXo2ZOlyw7GuDrT59shWnhYoR0nWU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTJNNVRPazV5MkYyeHZYUnUybDZFTHBrOUp4RDFBbkd5V2Vic3FhMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763868513),
('fsBG6aUCbBcLIMdaW8SfM3QwXHeogpqMblUpYqjx', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUI0YkpQM1REcWdCcXFpN0FQa0plZG1kRGlnZ2plcFBFbXZtaXZ5ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765689114),
('FY1iEAtCXVZ9mQ4oxaFxUdL52HW6q7o8Hf9KFAPp', NULL, '172.16.163.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTdLVHJXTUJYTWQwSnZIN3UyR1NEeGR1MGVRUWk0VFBrNm93akpyYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYzLjEyMDo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764316342),
('FyeNveeSfqO2WUFbdhHUzBIwkakUB0N1FtAwTtWA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXJFTUtkUkJnWVVYQnFFclpXNVJGa2VqemMwTEFiRE1CdFdJVG9kbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764737009),
('GJIX1PGEOB2yGRH2498jtpjv91IhtcNGUy5bK56l', NULL, '192.168.1.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0hxMVowd3dob0E4REloOWQwQnZkd3hCQVhwUGVtZTdHUHQ4bExocCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xOTIuMTY4LjEuNzY6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763220401),
('gMopE1mHVIU7Kko7ZoGF58guWR03reBq7xpc15Bt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWZYcEpJQ0ZvSDlhaGJoekZEaXBsUXZ2QmZYMXdzOGlKcnpMT25tUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765705219),
('Hb56sEnk7WQlCdLQiyuAqHYonaNyrVhz1N1BUpRg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDFNSHA2eFFBU21GMkJtU00zSzl6UGZxTHdxaUtTWHptQXBPMFVQRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765690422),
('kBmaDksIKb3h1vxCxVEQ4xI3A0Gz5KaG4OKFZ2Dn', NULL, '192.168.0.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUlUNGRSblcxZkVpV05CaEc3TXR1VExKUkRucWZmb0xIVW1zOVAxTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjAuMTE2OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763464133),
('MkYzoBm9REjkTxMBLBsKrFPcrFbE1hKSTPjN0hzn', NULL, '192.168.18.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGN0VnlHZFVDT3MxN2N1WTJ4d3V6TGR0b2hIVGlaNURSU3NtdE9ORiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjE4LjIzOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763193493),
('MV6BPHi3tRLqJZ7b31SyCbArQeZFzQ7BLMbJaYqk', NULL, '172.16.160.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2xiNGlpQzRxWmxkZGtBWTZCdVlXUzlkZGxJZzVzZlE4M2VHUTNLWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYwLjEyMzo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763451157),
('myve9TqBKwvycBNdjerPApqd7RabuXE99BiBH1jB', NULL, '172.16.161.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVVocUFUeEhlcFBZMHlPUEx2bnd4dFhxemNrSEVSR0g1NlBOZU9neCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xNzIuMTYuMTYxLjA6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763600937),
('ooQejrGhuVS74iRhwxnXAXR1ddWNT3MyHdDPooMq', NULL, '192.168.0.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFZJOUtTZXRXWDhaVkh0TGZWdjlHSnlmV21FNDMyOVZHcThDTkFMeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjAuMTE2OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763539838),
('QsX3DBGC95s9wnzw4Z0S7hvBWwc1LJeQcQB203U7', NULL, '172.16.41.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTHZmNkZVak5ORGtMN2ZIc0JTR2F5azBuQzB2a1lmMk9IQ1ZZdVBaUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTYuNDEuMTg4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764390434),
('QW3xFWGaUXVUq70dn58D9tf0JDmWgFwvQsrU036L', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlV5SjM5MmphRkpmWnJkdUtOQlZiREttbEZwRnBZY2hqaEtrcEJEdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765010008),
('rhgCnSg9FmPafF5b56baFgyxmBkqgGZCBAMhDkXT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3JlQVBKanJBZjl6ZkVZM1BCRXdnNnlyaGoweWJBS3NSZ0JBcXJqayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764834970),
('RrMfNznZOwqCpH2oOv6oxCQwclFxEsztBm2gDE4O', NULL, '192.168.18.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUR6cklYRzZQVkFiYUxGckd5VUpmV2NjYW40YUJSQ203aDExeTlTZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjE4Ljc0OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762772214),
('swnm9bNYtKORKhNpRK7M0loZ1g0EQGBoRQ5Jj9SD', NULL, '192.168.18.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWZjWENKR3V4VXduYzR3WGs1ajY2RXZXN1F2OUg4SFpWcUI4bFRpZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjE4LjIzOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763167035),
('tdIEEbYH4n412V2BIAfdq35qCjLTdpzBF3eFpG7q', NULL, '10.19.92.232', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnBESHRZU3ppZHVKZFdYbVp6dENzMkZVN0ZzMmNFWW16VEpObmxoTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMC4xOS45Mi4yMzI6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764165284),
('VumNAkiSDPWORFoS0GlrCafeWleuIqpZHRVzdErf', NULL, '172.16.162.38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDFPN01tSUU5ZWZsRHQzcndzZGQ3cDlZUFZ3aXFWM2hSOHpqOVBnSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYxLjEzNjo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762849552),
('VZPt3nDTCuAI2WNDPY8AO9k2SRdd3PQ0Vjm74uu7', NULL, '172.16.92.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFRzT2JobkdhcWRVZTdkREx2VENYWU9TQ2d2YUU5bmptMlRVZndmdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTYuOTIuMTEzOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763457244),
('wod5oOewchVn2uGcLZtWCHVQjsvoQjrJTeQnI0HH', NULL, '192.168.1.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2ZkOHRPNmRXMEVxQktoWjFnVkVBanlRTFJRY0Fkek9RVXBRdTFWNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xOTIuMTY4LjEuNzY6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763229039),
('xgil1yStL3jth7KdRzAH7muniD1cKmEzP1vaQX8c', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWhCSUd0Q3RXdHBLR1QzU1VmdHJWWkk1WlQ4aEFKeDRxWXFWYXNhTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764486715),
('XhKFGWboBQcfZAFfjV46jLfuEpqa9gMeWdakSfAF', NULL, '192.168.55.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3FZdFdBc0VVckV0QVNFM0c2dURmTlVHZWsybXVsd2Q0cE53Yzg3ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjU1LjIwOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764512150),
('YSJM3WkJKn3PIQdShDMpPLMBKp31V8WAI8Ffkpcg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkVIaW56Um1SdkxiN3hkYWw1NkM1M09DaFZkempGZUM0UkNONlEwMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765261914),
('ZjhCI0svQ1kNwnwSMtYjlEy5JCDm4lB5fRD7axQL', NULL, '172.16.161.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVRJYWptMVlObkxYSE1TVnNoOWMyMkRrenQ5UDdseXhRMnhhS080UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xNzIuMTYuMTYxLjEzNjo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762843821);

-- --------------------------------------------------------

--
-- Table structure for table `sidang_tugas_akhir`
--

DROP TABLE IF EXISTS `sidang_tugas_akhir`;
CREATE TABLE `sidang_tugas_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_akhir_id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_sidang_id` bigint(20) UNSIGNED NOT NULL,
  `sekretaris_nip` varchar(30) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `nilai_akhir` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sidang_tugas_akhir`
--

INSERT INTO `sidang_tugas_akhir` (`id`, `tugas_akhir_id`, `jadwal_sidang_id`, `sekretaris_nip`, `status`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(2, 2, 2, NULL, '0', 0, '2025-11-09 04:54:21', '2025-11-09 04:54:21'),
(3, 3, 3, NULL, '0', 0, '2025-11-09 04:59:10', NULL),
(5, 1, 2, '198617040828', '0', 94.19, '2025-12-12 10:00:10', '2025-12-19 07:04:27'),
(6, 29, 4, NULL, '0', 0, '2025-12-12 11:37:20', '2025-12-12 11:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `syarat_sidang`
--

DROP TABLE IF EXISTS `syarat_sidang`;
CREATE TABLE `syarat_sidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_akhir_id` bigint(20) UNSIGNED NOT NULL,
  `dokumen_id` bigint(20) UNSIGNED NOT NULL,
  `dokumen_file_original` varchar(255) NOT NULL,
  `dokumen_file` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `tanggal_upload` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `syarat_sidang`
--

INSERT INTO `syarat_sidang` (`id`, `tugas_akhir_id`, `dokumen_id`, `dokumen_file_original`, `dokumen_file`, `verified`, `tanggal_upload`) VALUES
(33, 1, 1, '1-s2.0-S2665917424002812-main (1).pdf', 'dokumen_sidang/1765542386_693c09f2c71d2.pdf', 1, '2025-12-12 05:26:27'),
(34, 1, 2, 'Laporan Mqtt Raspberry Pi Update.docx', 'dokumen_sidang/1765542393_693c09f9e3ade.docx', 1, '2025-12-12 05:26:33'),
(35, 1, 3, 'Laporan Mqtt Raspberry Pi Update.docx', 'dokumen_sidang/1765543188_693c0d14ac9f8.docx', 1, '2025-12-12 05:39:48'),
(36, 1, 4, 'Laporan Mqtt Raspberry Pi Update.docx', 'dokumen_sidang/1765543215_693c0d2fe7f58.docx', 1, '2025-12-12 05:40:15'),
(37, 1, 5, 'asd', 'pdf', 1, NULL),
(39, 1, 7, 'cv', 'cv', 1, NULL),
(40, 1, 8, 'dvdf', 'vcv', 1, NULL),
(41, 1, 6, 'ddf', 'dff', 1, NULL),
(42, 29, 1, '1-s2.0-S2665917424002812-main (1).pdf', 'dokumen_sidang/1765563775_693c5d7f1cb86.pdf', 1, '2025-12-12 11:22:58'),
(43, 29, 2, 'Laporan Mqtt Raspberry Pi Update.docx', 'dokumen_sidang/1765563791_693c5d8fb8382.docx', 1, '2025-12-12 11:23:11'),
(44, 29, 3, '33424202_Akbar Ramadhan_JobsheetKMC.pdf', 'dokumen_sidang/1765563806_693c5d9eb7cda.pdf', 1, '2025-12-12 11:23:26'),
(45, 29, 4, 'Laporan Mqtt Raspberry Pi Update.docx', 'dokumen_sidang/1765563817_693c5da969986.docx', 1, '2025-12-12 11:23:37'),
(46, 29, 5, 'Laporan_Konfigurasi_MQTT_Access_Control.docx', 'dokumen_sidang/1765563827_693c5db3b6eae.docx', 1, '2025-12-12 11:23:47'),
(47, 29, 6, 'Laporan_Pembatasan_Hak_Akses_MQTT.docx', 'dokumen_sidang/1765563861_693c5dd5e2ae4.docx', 1, '2025-12-12 11:24:22'),
(48, 29, 7, '33424202_Akbar Ramadhan_JobsheetKMC.pdf', 'dokumen_sidang/1765563878_693c5de619f4b.pdf', 1, '2025-12-12 11:24:38'),
(49, 29, 8, '33424215_M.NaufalArifki_JobsheetKMC.docx', 'dokumen_sidang/1765563886_693c5dee4f8f1.docx', 1, '2025-12-12 11:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_akhir`
--

DROP TABLE IF EXISTS `tugas_akhir`;
CREATE TABLE `tugas_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(500) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `tahun_akademik` varchar(9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id`, `judul`, `deskripsi`, `status`, `tahun_akademik`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'Bimbingan', '2024/2025', '2025-10-26 15:32:55', '2025-12-12 10:00:10'),
(2, 'Ini Judul TA Punya Rosario', 'deskripsi ta rosario', 'Bimbingan', '2024/2025', '2025-10-29 19:31:48', '2025-10-29 19:31:48'),
(3, 'Testing Ta ke 3', 'hallo mates', 'Bimbingan', '2024/2025', '2025-11-09 04:55:16', NULL),
(4, 'Judul TA', 'Deskripsi TA', 'Diajukan', '2024/2025', '2025-11-19 01:47:51', '2025-11-19 01:47:51'),
(5, 'sdfsdf', 'asddfd', 'Diajukan', '2024/2025', '2025-11-19 07:38:15', '2025-11-19 07:38:15'),
(6, 'asdsd', 'dfgfg', 'Diajukan', '2024/2025', '2025-11-19 08:26:05', '2025-11-19 08:26:05'),
(7, 'Sistem Informasi Akademik Berbasis Web', 'Pengembangan aplikasi web untuk mengelola data akademik mahasiswa dan dosen.', 'Diajukan', '2024/2025', '2025-11-23 20:57:17', '2025-11-23 20:57:17'),
(29, 'asd', 'olndsds', 'Diajukan', '2024/2025', '2025-12-10 19:19:20', '2025-12-12 11:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_akhir_anggota`
--

DROP TABLE IF EXISTS `tugas_akhir_anggota`;
CREATE TABLE `tugas_akhir_anggota` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_akhir_id` bigint(20) UNSIGNED NOT NULL,
  `mhs_nim` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tugas_akhir_anggota`
--

INSERT INTO `tugas_akhir_anggota` (`id`, `tugas_akhir_id`, `mhs_nim`, `created_at`, `updated_at`) VALUES
(2, 1, 110127515, '2025-10-26 15:40:35', '2025-10-26 15:40:35'),
(3, 1, 110122601, '2025-10-26 15:40:35', '2025-10-26 15:40:35'),
(4, 2, 110123402, NULL, NULL),
(5, 3, 110121212, '2025-11-09 04:57:06', NULL),
(6, 1, 110124728, '2025-11-09 04:57:32', NULL),
(7, 4, 110126447, NULL, NULL),
(8, 5, 110122154, NULL, NULL),
(9, 6, 110125663, NULL, NULL),
(41, 29, 110125213, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unsur_nilai_dosen_pembimbing`
--

DROP TABLE IF EXISTS `unsur_nilai_dosen_pembimbing`;
CREATE TABLE `unsur_nilai_dosen_pembimbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dosen_nip` varchar(255) NOT NULL,
  `sidang_id` bigint(20) UNSIGNED NOT NULL,
  `unsur_id` int(11) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `kerajinan_nilai` int(11) DEFAULT NULL,
  `keteguhan_nilai` int(11) DEFAULT NULL,
  `kemajuan_nilai` int(11) DEFAULT NULL,
  `total_nilai` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unsur_nilai_pembimbing`
--

DROP TABLE IF EXISTS `unsur_nilai_pembimbing`;
CREATE TABLE `unsur_nilai_pembimbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unsur` varchar(255) NOT NULL,
  `bobot` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unsur_nilai_pembimbing`
--

INSERT INTO `unsur_nilai_pembimbing` (`id`, `nama_unsur`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan', 10, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(2, 'Kreativitas', 15, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(3, 'Penguasaan Materi', 20, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(4, 'Kelengkapan', 5, '2025-12-18 18:01:10', '2025-12-18 18:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `unsur_nilai_penguji`
--

DROP TABLE IF EXISTS `unsur_nilai_penguji`;
CREATE TABLE `unsur_nilai_penguji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unsur` varchar(255) NOT NULL,
  `bobot` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unsur_nilai_penguji`
--

INSERT INTO `unsur_nilai_penguji` (`id`, `nama_unsur`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 'Isi dan Bobot Naskah', 15, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(2, 'Penguasaan Materi', 15, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(3, 'Presentasi dan penampilan', 5, '2025-12-18 18:01:10', '2025-12-18 18:01:10'),
(4, 'Hasil Rancang Bangun', 15, '2025-12-18 18:01:10', '2025-12-18 18:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Wika Dwi Aprilia', 'wika@example.net', '$2y$10$J61aMw5YiiPaWwI/1lfmO.5ceymuryBkWLiG.Q5lJtl2.1cktiMCW', 'mahasiswa', 'PQLzMcRS1Ybebt1rAsxfufBaZK1LerWAHcmVhx1dBWQFVWe0YEFMujdcgd3e', '2025-10-22 06:09:22', '2025-12-18 15:06:10'),
(2, 'Andromeda Elang Buana', 'elang@example.org', '$2y$10$TKVO7wVOkieItTWCVeonLezFh8/t09S6LBf2Kjbf6E7V.LtVW/tvi', 'mahasiswa', 'yrEOoXhQMd', '2025-10-22 06:09:22', '2025-12-18 16:02:21'),
(3, 'Akbar Romadon', 'akbar@example.com', '$2y$10$fR99xuJa/cLJw2gQ44RSP.8je2iOgxPTgkN1tUhaD9OtmzNN1q71q', 'mahasiswa', 'ge2cftNDN0', '2025-10-22 06:09:22', '2025-12-18 16:03:02'),
(4, 'Haikal Al Waly', 'haikal@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'gDIGTUBLMH', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(5, 'Farhan Rabbani', 'farhan@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'U8QeTxfbHn', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(6, 'Selvi Rahmasari', 'selvi@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Mrm2LWWxbL', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(7, 'Malcolm Kovacek', 'bernier.velva@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'PoaCy9APO2', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(8, 'Eriberto Kuhic', 'baumbach.brooke@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'UG9ywyFTTG', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(9, 'Miss Theresa Von', 'erika67@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '6B2e2CdswC', '2025-10-22 06:09:22', '2025-10-22 06:09:22'),
(10, 'Willis Denesik', 'ukris@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'qLFayO1tS7', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(11, 'Theron Hickle', 'garry.parker@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'l2FZrQzJN1', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(12, 'Norma Jacobs I', 'ondricka.camille@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'dZKV9ydpVs', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(13, 'Arthur Will', 'dhowe@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'ddgS8Ky0er', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(14, 'Sophia Jacobson', 'blaze91@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'zbDTApZCKe', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(15, 'Oran Hilpert', 'econnelly@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'HAtmD6Qcux', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(16, 'Adele Klocko', 'vdoyle@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'QFg2EFBY5U', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(17, 'Thora Kuhn', 'uparisian@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Pt7U2Bm5nD', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(18, 'Levi Dickens DDS', 'julie94@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'UyZVNlnYJH', '2025-10-22 06:09:23', '2025-10-22 06:09:23'),
(19, 'Haskell Cronin', 'katrine.bartoletti@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'stKW05CzXm', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(20, 'Kristina D\'Amore', 'hermiston.rosanna@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'fD1AzEv2Ga', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(21, 'Kip Gleichner', 'elvis87@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'MnMBC7c4NI', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(22, 'Nedra Dickens', 'kmurray@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'LDoAv65aUA', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(23, 'Gennaro Kutch DVM', 'eloy43@example.org', '$2y$12$BNeQE4EpctoySEvDeu/qpekywneQ3hjR08CjrssFGouSQD/l7Hz.i', 'mahasiswa', 'c3NHqlzZt5', '2025-10-22 06:09:24', '2025-12-02 02:22:10'),
(24, 'Emil Macejkovic', 'providenci26@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'UhYDQbrNUz', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(25, 'Ms. Jailyn Kshlerin I', 'reece.feeney@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '18je3LxuBq', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(26, 'Bernhard Oberbrunner', 'earnest41@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '6frRQqwFZv', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(27, 'Alanis Ratke', 'lfriesen@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'gPFVFdgkND', '2025-10-22 06:09:24', '2025-10-22 06:09:24'),
(28, 'Heloise Hane', 'candido.larkin@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'o9grdgpaiE', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(29, 'Guy Schoen', 'jaylon63@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '97k9m56H6y', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(30, 'Mrs. Shany Herman', 'ykub@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'XzFb67KQ3W', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(31, 'Joel O\'Kon', 'macie.moore@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '8zcqrxAvkV', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(32, 'Dr. Katelin Crist V', 'judy79@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Ep47q4hNlJ', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(33, 'Jackeline Hermann', 'margarete.hudson@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'ZHHfQPaJCs', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(34, 'Joany Boyer', 'nankunding@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '4cEun4ZWkj', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(35, 'Prof. Jayme Ward PhD', 'kschmeler@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '8Js6NSIb6m', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(36, 'Eloise Kiehn', 'emely.fritsch@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', '8qUbYbX0DN', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(37, 'Willow Morar', 'jude91@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Ekl3I8bdn2', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(38, 'Kelly Casper', 'tnolan@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Y3L6uZNEc1', '2025-10-22 06:09:25', '2025-10-22 06:09:25'),
(39, 'Jarod Greenholt II', 'neil56@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'GGWDrphGnW', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(40, 'Bridgette Torp', 'oborer@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'SoDB4ryHN7', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(41, 'Stuart Howe', 'virgil.johnson@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'hLDLMzuFui', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(42, 'Dr. Shawn O\'Connell DVM', 'reanna.grant@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'XM5Rqchqg9', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(43, 'Dr. Natasha Mills', 'nicholas40@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'isIvXZLXnt', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(44, 'Dasia Schinner', 'rice.randall@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'dcuhopgjYe', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(45, 'Mittie O\'Hara', 'vinnie45@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'MN6XWvz931', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(46, 'Lucio Brekke III', 'sherwood.stracke@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'ZHogxfvdaA', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(47, 'Mr. Modesto Haley IV', 'jveum@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'YLxWgRjBze', '2025-10-22 06:09:26', '2025-10-22 06:09:26'),
(48, 'Adah Cassin DDS', 'sbeahan@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'z5jGhBgc1J', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(49, 'Irwin Bayer', 'pfannerstill.sam@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Kl2Z1w2RpJ', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(50, 'Prof. Gregory Reynolds DDS', 'zboncak.tamia@example.net', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'mahasiswa', 'Vi1n4g3o0i', '2025-10-22 06:09:27', '2025-10-22 06:09:27'),
(51, 'Muttabik Fathul Latief', 'pakabik@example.org', '$2y$10$ApNCgZlbQxlfqgDjGLu4POWvAAGzrHFNtopo6nEB8Ryk1vIoV7fom', 'dosen', 'cMGYd1bUzdFksPhBhoLaHAaSgehRdi8YuQ3wY3dhOgqrcyE5YG61af7F1drs', '2025-10-22 06:09:31', '2025-12-18 16:19:04'),
(52, 'Amran Yobioktabera', 'pakamran@example.net', '$2y$10$Z43YpoovpHSa82kpJg2OLOZsptP7lbhrW.3YwfW0DYAYVcEEHBWmC', 'dosen', '1yIrmahosp2brEwXe82rzdRWXrGGaZK2pPwrfgcAghjKvMbz3Sa3aQdfacve', '2025-10-22 06:09:31', '2025-12-18 05:59:09'),
(53, 'Suko Tyas P', 'paksuko@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'dosen', 'GG192jDvG2', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(54, 'Sukamto', 'pakkamto@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'dosen', 'E8dn517lKA', '2025-10-22 06:09:31', '2025-10-22 06:09:31'),
(55, 'Eri Lavandi', 'bueri@example.com', '$2y$10$5iF6wAUZoC1s63HBqnP1fuVrCwM.dqFjVkRW3bQ6sBhOfUyJEdxEO', 'dosen', 'W0sAbMYBJ0Tdl3zBhVjHPu5RIvagYE6Dhf3QcHbrdSzvcQAo7aP6Xav6GbdB', '2025-10-22 06:09:31', '2025-12-19 07:02:09'),
(56, 'Liliek Triyono', 'paklilik@example.org', '$2y$10$NCSRyJiykWa6vwMUjzsMF.Ob3Q1H6mYeDYRY1WOrqrmDp05TnSfk.', 'dosen', 'TZ0k1uAkpd7RrI6ZcX6GjeX7Kv0wfcfYNekHc0GhVW0FhDuwS8vdkRJPwSmF', '2025-10-22 06:09:31', '2025-12-15 03:04:51'),
(57, 'Teresa Orn', 'myrtis.nikolaus@example.org', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'dosen', '9ckPTS450y', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(58, 'Bryana Langworth DDS', 'kwhite@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'dosen', 'ZTUqiZdPOO', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(59, 'Victoria Smith', 'miller.myra@example.net', '$2y$10$Vv5RhVLq7LzYNXsh1QWRNeZH7Y74OzKFjr.i9viJpK8FBhF49TXOy', 'dosen', 'CjVxTiUgeHF50FttktzMdOmqwOJNomloIXTSBcMRH9iR8r1DfEM1wzlwTtBc', '2025-10-22 06:09:32', '2025-12-14 10:01:06'),
(60, 'Randi Bruen', 'johnston.minnie@example.com', '$2y$12$8xD3pkAHvm45wN2221LrrOkt3LofJibyTau/1k30HN5i5co5nYwhW', 'dosen', 'cKOjmWsxT0', '2025-10-22 06:09:32', '2025-10-22 06:09:32'),
(61, 'Super Admin', 'superadmin@gmail.com', '$2y$10$WeVbpizMDFjc9KDU4fTRpeaSO5DDU4HQ2Eh9XR9RAUHgH0ey2..le', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_prodi`
--
ALTER TABLE `admin_prodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_prodi_user_id_foreign` (`user_id`),
  ADD KEY `admin_prodi_prodi_id_foreign` (`prodi_id`);

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bimbingan_tugas_akhir_id_foreign` (`tugas_akhir_id`),
  ADD KEY `bimbingan_dosen_nip_foreign` (`dosen_nip`);

--
-- Indexes for table `bimbingan_log`
--
ALTER TABLE `bimbingan_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bimbingan_log_bimbingan_id_foreign` (`bimbingan_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `dokumen_sidang`
--
ALTER TABLE `dokumen_sidang`
  ADD PRIMARY KEY (`dokumen_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosen_dosen_nip_unique` (`dosen_nip`),
  ADD KEY `dosen_user_id_foreign` (`user_id`),
  ADD KEY `dosen_prodi_id_foreign` (`prodi_id`);

--
-- Indexes for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dosen_penguji_sidang_id_foreign` (`sidang_id`),
  ADD KEY `dosen_penguji_dosen_nip_foreign` (`dosen_nip`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_sidang`
--
ALTER TABLE `jadwal_sidang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_sidang_sesi_id_foreign` (`sesi_id`),
  ADD KEY `jadwal_sidang_ruangan_id_foreign` (`ruangan_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`mhs_nim`),
  ADD KEY `mahasiswa_user_id_foreign` (`user_id`),
  ADD KEY `mahasiswa_prodi_id_foreign` (`prodi_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`);

--
-- Indexes for table `nilai_dosen_pembimbing`
--
ALTER TABLE `nilai_dosen_pembimbing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_dosen_pembimbing_sidang_id_foreign` (`sidang_id`),
  ADD KEY `nilai_dosen_pembimbing_dosen_nip_foreign` (`dosen_nip`),
  ADD KEY `nilai_dosen_pembimbing_unsur_id_foreign` (`unsur_id`);

--
-- Indexes for table `nilai_dosen_penguji`
--
ALTER TABLE `nilai_dosen_penguji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_dosen_penguji_sidang_id_foreign` (`sidang_id`),
  ADD KEY `nilai_dosen_penguji_dosen_nip_foreign` (`dosen_nip`),
  ADD KEY `nilai_dosen_penguji_unsur_id_foreign` (`unsur_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodi_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `prodi_dosen`
--
ALTER TABLE `prodi_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodi_dosen_prodi_id_foreign` (`prodi_id`),
  ADD KEY `prodi_dosen_dosen_nip_foreign` (`dosen_nip`);

--
-- Indexes for table `revisi_tugas_akhir`
--
ALTER TABLE `revisi_tugas_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revisi_tugas_akhir_tugas_akhir_id_foreign` (`tugas_akhir_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_menus`
--
ALTER TABLE `role_has_menus`
  ADD PRIMARY KEY (`role_id`,`menu_id`),
  ADD KEY `role_has_menus_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sidang_tugas_akhir`
--
ALTER TABLE `sidang_tugas_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sidang_tugas_akhir_tugas_akhir_id_foreign` (`tugas_akhir_id`),
  ADD KEY `sidang_tugas_akhir_jadwal_sidang_id_foreign` (`jadwal_sidang_id`);

--
-- Indexes for table `syarat_sidang`
--
ALTER TABLE `syarat_sidang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `syarat_sidang_tugas_akhir_id_foreign` (`tugas_akhir_id`),
  ADD KEY `syarat_sidang_dokumen_id_foreign` (`dokumen_id`);

--
-- Indexes for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_akhir_anggota`
--
ALTER TABLE `tugas_akhir_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_akhir_anggota_tugas_akhir_id_foreign` (`tugas_akhir_id`),
  ADD KEY `tugas_akhir_anggota_mhs_nim_foreign` (`mhs_nim`);

--
-- Indexes for table `unsur_nilai_dosen_pembimbing`
--
ALTER TABLE `unsur_nilai_dosen_pembimbing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembimbing_unsur_unique` (`sidang_id`,`dosen_nip`,`unsur_id`),
  ADD KEY `unsur_nilai_dosen_pembimbing_dosen_nip_index` (`dosen_nip`);

--
-- Indexes for table `unsur_nilai_pembimbing`
--
ALTER TABLE `unsur_nilai_pembimbing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unsur_nilai_penguji`
--
ALTER TABLE `unsur_nilai_penguji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_prodi`
--
ALTER TABLE `admin_prodi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bimbingan_log`
--
ALTER TABLE `bimbingan_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokumen_sidang`
--
ALTER TABLE `dokumen_sidang`
  MODIFY `dokumen_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_sidang`
--
ALTER TABLE `jadwal_sidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `nilai_dosen_pembimbing`
--
ALTER TABLE `nilai_dosen_pembimbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nilai_dosen_penguji`
--
ALTER TABLE `nilai_dosen_penguji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prodi_dosen`
--
ALTER TABLE `prodi_dosen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revisi_tugas_akhir`
--
ALTER TABLE `revisi_tugas_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sidang_tugas_akhir`
--
ALTER TABLE `sidang_tugas_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `syarat_sidang`
--
ALTER TABLE `syarat_sidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tugas_akhir_anggota`
--
ALTER TABLE `tugas_akhir_anggota`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `unsur_nilai_dosen_pembimbing`
--
ALTER TABLE `unsur_nilai_dosen_pembimbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unsur_nilai_pembimbing`
--
ALTER TABLE `unsur_nilai_pembimbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unsur_nilai_penguji`
--
ALTER TABLE `unsur_nilai_penguji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_prodi`
--
ALTER TABLE `admin_prodi`
  ADD CONSTRAINT `admin_prodi_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`),
  ADD CONSTRAINT `admin_prodi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_tugas_akhir_id_foreign` FOREIGN KEY (`tugas_akhir_id`) REFERENCES `tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bimbingan_log`
--
ALTER TABLE `bimbingan_log`
  ADD CONSTRAINT `bimbingan_log_bimbingan_id_foreign` FOREIGN KEY (`bimbingan_id`) REFERENCES `bimbingan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`),
  ADD CONSTRAINT `dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  ADD CONSTRAINT `dosen_penguji_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `dosen_penguji_sidang_id_foreign` FOREIGN KEY (`sidang_id`) REFERENCES `sidang_tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_sidang`
--
ALTER TABLE `jadwal_sidang`
  ADD CONSTRAINT `jadwal_sidang_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`),
  ADD CONSTRAINT `jadwal_sidang_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id`);

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`),
  ADD CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_dosen_pembimbing`
--
ALTER TABLE `nilai_dosen_pembimbing`
  ADD CONSTRAINT `nilai_dosen_pembimbing_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_dosen_pembimbing_sidang_id_foreign` FOREIGN KEY (`sidang_id`) REFERENCES `sidang_tugas_akhir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_dosen_pembimbing_unsur_id_foreign` FOREIGN KEY (`unsur_id`) REFERENCES `unsur_nilai_pembimbing` (`id`);

--
-- Constraints for table `nilai_dosen_penguji`
--
ALTER TABLE `nilai_dosen_penguji`
  ADD CONSTRAINT `nilai_dosen_penguji_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_dosen_penguji_sidang_id_foreign` FOREIGN KEY (`sidang_id`) REFERENCES `sidang_tugas_akhir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_dosen_penguji_unsur_id_foreign` FOREIGN KEY (`unsur_id`) REFERENCES `unsur_nilai_penguji` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `prodi_dosen`
--
ALTER TABLE `prodi_dosen`
  ADD CONSTRAINT `prodi_dosen_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`),
  ADD CONSTRAINT `prodi_dosen_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);

--
-- Constraints for table `revisi_tugas_akhir`
--
ALTER TABLE `revisi_tugas_akhir`
  ADD CONSTRAINT `revisi_tugas_akhir_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `revisi_tugas_akhir_tugas_akhir_id_foreign` FOREIGN KEY (`tugas_akhir_id`) REFERENCES `tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_menus`
--
ALTER TABLE `role_has_menus`
  ADD CONSTRAINT `role_has_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sidang_tugas_akhir`
--
ALTER TABLE `sidang_tugas_akhir`
  ADD CONSTRAINT `sidang_tugas_akhir_jadwal_sidang_id_foreign` FOREIGN KEY (`jadwal_sidang_id`) REFERENCES `jadwal_sidang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sidang_tugas_akhir_tugas_akhir_id_foreign` FOREIGN KEY (`tugas_akhir_id`) REFERENCES `tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `syarat_sidang`
--
ALTER TABLE `syarat_sidang`
  ADD CONSTRAINT `syarat_sidang_dokumen_id_foreign` FOREIGN KEY (`dokumen_id`) REFERENCES `dokumen_sidang` (`dokumen_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `syarat_sidang_tugas_akhir_id_foreign` FOREIGN KEY (`tugas_akhir_id`) REFERENCES `tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tugas_akhir_anggota`
--
ALTER TABLE `tugas_akhir_anggota`
  ADD CONSTRAINT `tugas_akhir_anggota_mhs_nim_foreign` FOREIGN KEY (`mhs_nim`) REFERENCES `mahasiswa` (`mhs_nim`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_akhir_anggota_tugas_akhir_id_foreign` FOREIGN KEY (`tugas_akhir_id`) REFERENCES `tugas_akhir` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unsur_nilai_dosen_pembimbing`
--
ALTER TABLE `unsur_nilai_dosen_pembimbing`
  ADD CONSTRAINT `unsur_nilai_dosen_pembimbing_dosen_nip_foreign` FOREIGN KEY (`dosen_nip`) REFERENCES `dosen` (`dosen_nip`) ON DELETE CASCADE,
  ADD CONSTRAINT `unsur_nilai_dosen_pembimbing_sidang_id_foreign` FOREIGN KEY (`sidang_id`) REFERENCES `sidang_tugas_akhir` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
