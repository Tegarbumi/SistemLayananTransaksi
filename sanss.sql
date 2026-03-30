-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 30, 2026 at 09:18 AM
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
-- Database: `sanss`
--

-- --------------------------------------------------------

--
-- Table structure for table `alats`
--

CREATE TABLE `alats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga24` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL DEFAULT 'noimage.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alats`
--

INSERT INTO `alats` (`id`, `kategori_id`, `nama_alat`, `deskripsi`, `harga24`, `gambar`, `created_at`, `updated_at`) VALUES
(33, 1, 'Tenda Borneo', 'Tenda Borneo Kapasitas 1-4 Orang (Double Layer)', 45000, '1773065129-9175a4974f40b4bedb1380088740c9c2.png', '2026-03-09 13:39:54', '2026-03-09 14:05:29'),
(34, 1, 'Tenda Wildshell', 'Tenda Wildshell Kapasitas 1-4 Orang (Double Layer)', 50000, '1773065750-tenda_jaya_dipa-min_1763450042162.png', '2026-03-09 14:15:50', '2026-03-09 14:15:50'),
(35, 2, 'Carrier', 'Dengan kompartemen yang luas.', 35000, '1773066062-5cb974d4dc04751201e1c4648cf85611.jpeg', '2026-03-09 14:21:02', '2026-03-11 09:26:34'),
(36, 2, 'Hydropack', 'Dengan kantong air (hydration bladder).', 20000, '1773067212-id-11134207-7r98w-luokxy9jrzih52.jpg', '2026-03-09 14:40:12', '2026-03-11 09:27:21'),
(37, 2, 'Day Pack', 'Tas tahan air dengan kompartemen yang luas.', 25000, '1773067242-images.jpg', '2026-03-09 14:40:42', '2026-03-11 09:30:47'),
(38, 3, 'Kompor Portebel Mini Windproof', 'Kompor praktis yang mudah dibawa kemana - mana.', 15000, '1773067745-KOMPOR-WINDPROOF.png', '2026-03-09 14:48:08', '2026-03-11 09:32:22'),
(39, 3, 'Kompor Portebel 2in1', 'Kompor Portable 2In1 dengan gas LPG 3KG/12KG.', 25000, '1773068205-beca06e71e8c43ef0468e9981ce131d8.jpg', '2026-03-09 14:56:45', '2026-03-11 09:30:18'),
(40, 4, 'Tracking Pole', 'Tongkat hiking adjustable untuk treking.', 15000, '1773068694-S9b7d706719fa4127b042585bc2059872q.jpg_720x720q80.jpg', '2026-03-09 15:04:54', '2026-03-11 09:31:52'),
(41, 4, 'Headlamp', 'Headlamp LED Multifunction Outdoor', 10000, '1773069007-dcaf19a3bb3906b18fb05b4c31da1cb3.jpg', '2026-03-09 15:10:07', '2026-03-09 15:10:07'),
(42, 5, 'Matras', 'Matras camping portabel dengan tebal 3 mm.', 10000, '1773069087-097eba2a30b1b724a67dd3585d93984a.jpg_720x720q80.jpg', '2026-03-09 15:11:27', '2026-03-11 09:33:41'),
(43, 5, 'Sleeping Bag', 'Sleeping Bag Polar Bulu yang nyaman.', 20000, '1773069380-Sleeping_Bag_harga_sewa_10.0001.jpg', '2026-03-09 15:16:20', '2026-03-11 09:34:34'),
(44, 4, 'Sepatu Gunung', 'Dirancang dengan sol anti-selip.', 35000, '1773069542-3a5f4b98-b609-4ab6-92ad-b2d91670ddec.jpg', '2026-03-09 15:19:02', '2026-03-11 09:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `durasi` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Tenda', NULL, NULL),
(2, 'Tas', NULL, NULL),
(3, 'Peralatan Masak', NULL, NULL),
(4, 'Aksesoris Lainnya', NULL, NULL),
(5, 'Perlengkapan Tidur', '2026-01-15 01:32:23', '2026-01-15 01:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `dendas`
--

CREATE TABLE `dendas` (
  `id` bigint(20) NOT NULL,
  `payment_id` bigint(20) NOT NULL,
  `jenis_denda` enum('telat','rusak','hilang') DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_pembayaran` enum('belum_bayar','sudah_bayar') DEFAULT 'belum_bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dendas`
--

INSERT INTO `dendas` (`id`, `payment_id`, `jenis_denda`, `jumlah`, `keterangan`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 38, 'telat', 50000, 'sadasdas', 'sudah_bayar', '2026-03-29 08:04:06', '2026-03-29 08:05:25'),
(2, 40, 'rusak', 50000, 'sdfsdfsd', 'sudah_bayar', '2026-03-29 08:08:30', '2026-03-29 08:09:09'),
(3, 41, 'hilang', 300000, 'Hilang tas nya jir', 'sudah_bayar', '2026-03-29 08:30:27', '2026-03-29 08:31:15'),
(4, 42, 'telat', 10000, '23232323', 'sudah_bayar', '2026-03-29 09:58:04', '2026-03-29 09:58:23'),
(5, 43, 'telat', 50000, 'pp', 'sudah_bayar', '2026-03-30 06:22:20', '2026-03-30 06:38:55'),
(6, 46, 'rusak', 50000, '435345', 'sudah_bayar', '2026-03-30 06:39:56', '2026-03-30 07:01:37'),
(7, 45, 'telat', 50000, 'coba', 'sudah_bayar', '2026-03-30 06:50:29', '2026-03-30 07:01:45'),
(8, 48, 'telat', 56565, 're', 'sudah_bayar', '2026-03-30 06:54:09', '2026-03-30 07:01:28'),
(9, 49, 'telat', 50000, '-', 'sudah_bayar', '2026-03-30 07:00:14', '2026-03-30 07:01:18'),
(10, 50, 'telat', 787878, '-', 'sudah_bayar', '2026-03-30 07:05:21', '2026-03-30 07:06:26'),
(11, 51, 'telat', 56000, '-', 'sudah_bayar', '2026-03-30 07:05:54', '2026-03-30 07:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_02_15_140424_create_categories_table', 1),
(5, '2022_02_15_154902_create_alats_table', 1),
(6, '2022_04_09_065246_create_carts_table', 1),
(7, '2022_04_13_135055_create_payments_table', 1),
(8, '2022_04_13_142930_create_orders_table', 1),
(9, '2026_03_10_122741_create_services_table', 1),
(10, '2026_03_10_212216_add_service_id_to_carts_table', 2),
(11, '2026_03_10_230430_add_service_id_to_orders_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `durasi` int(11) DEFAULT NULL,
  `starts` datetime NOT NULL,
  `ends` datetime NOT NULL,
  `harga` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_bonus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `alat_id`, `service_id`, `user_id`, `payment_id`, `durasi`, `starts`, `ends`, `harga`, `status`, `created_at`, `updated_at`, `is_bonus`) VALUES
(17, 33, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 45000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05', 0),
(18, 33, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 45000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05', 0),
(19, 34, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 50000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05', 0),
(20, 35, NULL, 1, 12, 24, '2026-03-12 05:40:00', '2026-03-13 05:40:00', 35000, 2, '2026-03-09 16:34:24', '2026-03-09 16:34:39', 0),
(21, 36, NULL, 1, 12, 24, '2026-03-12 05:40:00', '2026-03-13 05:40:00', 20000, 2, '2026-03-09 16:34:24', '2026-03-09 16:34:39', 0),
(24, NULL, 3, 10, 18, NULL, '2026-04-02 23:26:00', '2026-04-02 23:26:00', 100000, 2, '2026-03-10 16:22:33', '2026-03-10 17:00:02', 0),
(25, NULL, 2, 10, 18, NULL, '2026-04-02 23:26:00', '2026-04-02 23:26:00', 250000, 2, '2026-03-10 16:22:33', '2026-03-10 17:00:02', 0),
(28, NULL, 3, 10, 23, NULL, '2026-03-12 23:34:00', '2026-03-12 23:34:00', 100000, 2, '2026-03-10 16:33:13', '2026-03-10 16:44:16', 0),
(29, 35, NULL, 10, 24, 24, '2026-03-20 13:46:00', '2026-03-21 13:46:00', 35000, 2, '2026-03-11 06:44:32', '2026-03-11 06:45:58', 0),
(30, NULL, 3, 10, 24, NULL, '2026-03-20 13:46:00', '2026-03-20 13:46:00', 100000, 2, '2026-03-11 06:44:32', '2026-03-11 06:45:58', 0),
(31, 34, NULL, 10, 25, 24, '2026-03-27 16:00:00', '2026-03-28 16:00:00', 50000, 2, '2026-03-11 09:00:10', '2026-03-11 09:01:00', 0),
(34, 33, NULL, 15, 28, 24, '2026-03-22 00:16:00', '2026-03-23 00:16:00', 45000, 2, '2026-03-11 17:16:38', '2026-03-11 17:23:01', 0),
(85, 34, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 50000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(86, 34, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 50000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(87, 34, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 50000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(88, 34, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 50000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(89, NULL, 1, 10, 34, NULL, '2026-03-30 12:19:00', '2026-03-30 12:19:00', 315500, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(90, 39, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 25000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(91, 39, NULL, 10, 34, 24, '2026-03-30 12:19:00', '2026-03-31 12:19:00', 25000, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(92, 44, NULL, 10, 34, 0, '2026-03-30 12:19:00', '2026-03-30 12:19:00', 0, 2, '2026-03-29 04:18:42', '2026-03-29 04:19:20', 0),
(93, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(94, 34, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 50000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(95, 35, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 35000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(96, 36, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 20000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(97, 37, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 25000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(98, 36, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 20000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(99, 34, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 50000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(100, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(101, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(102, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(103, 34, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 50000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(104, 35, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 35000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(105, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(106, 33, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 45000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(107, 34, NULL, 10, 35, 24, '2026-03-30 11:30:00', '2026-03-31 11:30:00', 50000, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(108, 40, NULL, 10, 35, 0, '2026-03-30 11:30:00', '2026-03-30 11:30:00', 0, 2, '2026-03-29 04:30:49', '2026-03-29 04:31:45', 0),
(109, 35, NULL, 10, 36, 24, '2026-03-04 15:12:00', '2026-03-05 15:12:00', 35000, 2, '2026-03-29 06:10:02', '2026-03-29 06:10:21', 0),
(110, 34, NULL, 10, 36, 24, '2026-03-04 15:12:00', '2026-03-05 15:12:00', 50000, 2, '2026-03-29 06:10:02', '2026-03-29 06:10:21', 0),
(111, 33, NULL, 10, 37, 24, '2026-03-31 15:28:00', '2026-04-01 15:28:00', 45000, 2, '2026-03-29 07:27:44', '2026-03-29 07:28:03', 0),
(112, 33, NULL, 10, 37, 24, '2026-03-31 15:28:00', '2026-04-01 15:28:00', 45000, 2, '2026-03-29 07:27:44', '2026-03-29 07:28:03', 0),
(113, 35, NULL, 10, 38, 24, '2026-04-04 14:59:00', '2026-04-05 14:59:00', 35000, 2, '2026-03-29 07:59:14', '2026-03-29 07:59:29', 0),
(114, 36, NULL, 10, 39, 24, '2026-03-31 15:06:00', '2026-04-01 15:06:00', 20000, 2, '2026-03-29 08:06:02', '2026-03-29 08:06:19', 0),
(115, 37, NULL, 10, 40, 24, '2026-04-03 15:07:00', '2026-04-04 15:07:00', 25000, 2, '2026-03-29 08:07:26', '2026-03-29 08:07:39', 0),
(116, 35, NULL, 10, 41, 24, '2026-04-01 16:26:00', '2026-04-02 16:26:00', 35000, 2, '2026-03-29 08:25:44', '2026-03-29 08:25:54', 0),
(117, 33, NULL, 10, 42, 24, '2026-03-31 18:59:00', '2026-04-01 18:59:00', 45000, 2, '2026-03-29 09:57:18', '2026-03-29 09:57:33', 0),
(118, 33, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 45000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(119, 34, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 50000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(120, 39, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 25000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(121, 35, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 35000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(122, 40, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 15000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(123, 40, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 15000, 2, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(124, 43, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 20000, 2, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(125, 43, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 20000, 2, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(126, 38, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 15000, 3, '2026-03-30 05:59:16', '2026-03-30 06:13:27', 0),
(127, 38, NULL, 10, 43, 24, '2026-03-31 13:00:00', '2026-04-01 13:00:00', 15000, 2, '2026-03-30 05:59:16', '2026-03-30 06:13:59', 0),
(128, NULL, 1, 10, 44, NULL, '2026-04-08 13:21:00', '2026-04-08 13:21:00', 315500, 2, '2026-03-30 06:15:06', '2026-03-30 06:15:21', 0),
(129, 35, NULL, 10, 44, 24, '2026-04-08 13:21:00', '2026-04-09 13:21:00', 35000, 2, '2026-03-30 06:15:06', '2026-03-30 06:15:21', 0),
(130, 35, NULL, 10, 45, 24, '2026-04-10 13:38:00', '2026-04-11 13:38:00', 35000, 2, '2026-03-30 06:33:24', '2026-03-30 06:33:32', 0),
(131, 36, NULL, 10, 45, 24, '2026-04-10 13:38:00', '2026-04-11 13:38:00', 20000, 2, '2026-03-30 06:33:24', '2026-03-30 06:33:32', 0),
(132, 36, NULL, 10, 46, 24, '2026-03-31 19:44:00', '2026-04-01 19:44:00', 20000, 2, '2026-03-30 06:38:07', '2026-03-30 06:39:17', 0),
(133, 37, NULL, 10, 46, 24, '2026-03-31 19:44:00', '2026-04-01 19:44:00', 25000, 2, '2026-03-30 06:38:07', '2026-03-30 06:39:17', 0),
(134, 36, NULL, 15, 47, 24, '2026-03-31 13:58:00', '2026-04-01 13:58:00', 20000, 2, '2026-03-30 06:52:38', '2026-03-30 06:52:38', 0),
(135, 35, NULL, 10, 48, 24, '2026-04-04 13:54:00', '2026-04-05 13:54:00', 35000, 2, '2026-03-30 06:53:32', '2026-03-30 06:53:42', 0),
(136, 36, NULL, 10, 49, 24, '2026-04-01 19:05:00', '2026-04-02 19:05:00', 20000, 2, '2026-03-30 07:00:08', '2026-03-30 07:00:08', 0),
(137, 36, NULL, 15, 50, 24, '2026-03-31 20:11:00', '2026-04-01 20:11:00', 20000, 2, '2026-03-30 07:05:13', '2026-03-30 07:05:13', 0),
(138, 36, NULL, 10, 51, 24, '2026-04-03 14:11:00', '2026-04-04 14:11:00', 20000, 2, '2026-03-30 07:05:46', '2026-03-30 07:05:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `bukti_denda` varchar(255) DEFAULT NULL,
  `jaminan_ktp` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `no_invoice`, `user_id`, `total`, `bukti`, `bukti_denda`, `jaminan_ktp`, `status`, `created_at`, `updated_at`) VALUES
(11, '10/1773073905', 10, 140000, '1773074655-Screenshot 2025-11-21 083959.png', NULL, NULL, 5, '2026-03-09 16:31:45', '2026-03-10 15:59:47'),
(12, '1/1773074064', 1, 55000, '1773074475-Screenshot 2025-11-19 103428.png', NULL, NULL, 5, '2026-03-09 16:34:24', '2026-03-10 16:00:06'),
(18, '10/1773159753', 10, 350000, '1773162033-WhatsApp Image 2026-03-10 at 20.57.53.jpeg', NULL, NULL, 5, '2026-03-10 16:22:33', '2026-03-10 17:01:19'),
(23, '10/1773160393', 10, 100000, '1773161258-Screenshot 2026-03-10 205348.png', NULL, NULL, 5, '2026-03-10 16:33:13', '2026-03-10 16:50:00'),
(24, '10/1773211472', 10, 135000, '1773211612-Screenshot 2025-11-19 103428.png', NULL, NULL, 5, '2026-03-11 06:44:32', '2026-03-11 06:54:38'),
(25, '10/1773219610', 10, 50000, '1773219759-Screenshot 2025-11-19 103428.png', NULL, NULL, 5, '2026-03-11 09:00:10', '2026-03-29 06:08:32'),
(28, '15/1773249398', 15, 45000, '1773253599_bukti_WhatsApp Image 2026-03-02 at 23.07.20.jpeg', NULL, '1773253599_ktp_Gemini_Generated_Image_8ow7mi8ow7mi8ow7.png', 5, '2026-03-11 17:16:38', '2026-03-12 23:13:54'),
(34, '10/1774757922', 10, 565500, '1774758010_bukti_Screenshot 2025-12-03 104013.png', NULL, '1774758010_ktp_Screenshot 2025-12-03 102557.png', 5, '2026-03-29 04:18:42', '2026-03-29 04:21:44'),
(35, '10/1774758649', 10, 605000, '1774758723_bukti_Screenshot 2025-11-20 073955.png', NULL, '1774758723_ktp_Screenshot 2025-11-20 073955.png', 5, '2026-03-29 04:30:49', '2026-03-29 06:09:33'),
(36, '10/1774764602', 10, 85000, '1774764639_bukti_Screenshot 2025-11-21 083959.png', '1774769170_denda_Screenshot 2025-11-30 094125.png', '1774764639_ktp_Screenshot 2025-11-21 083959.png', 5, '2026-03-29 06:10:02', '2026-03-29 07:26:27'),
(37, '10/1774769264', 10, 90000, '1774769524_bukti_Screenshot 2025-11-19 103428.png', NULL, '1774769524_ktp_Screenshot 2025-11-19 103428.png', 5, '2026-03-29 07:27:44', '2026-03-29 07:58:39'),
(38, '10/1774771154', 10, 35000, '1774771186_bukti_Screenshot 2025-11-30 094125.png', '1774771536_denda_Screenshot 2025-11-30 094125.png', '1774771186_ktp_Screenshot 2025-11-30 094125.png', 5, '2026-03-29 07:59:14', '2026-03-29 08:05:36'),
(39, '10/1774771562', 10, 20000, '1774771593_bukti_Screenshot 2025-11-19 103428.png', NULL, '1774771593_ktp_Screenshot 2025-11-19 103428.png', 5, '2026-03-29 08:06:02', '2026-03-29 08:06:49'),
(40, '10/1774771646', 10, 25000, '1774771670_bukti_Screenshot 2025-11-21 083959.png', '1774771741_denda_Screenshot 2025-11-19 120541.png', '1774771670_ktp_Screenshot 2025-11-21 083959.png', 5, '2026-03-29 08:07:26', '2026-03-29 08:09:09'),
(41, '10/1774772744', 10, 35000, '1774772975_bukti_Screenshot 2025-12-08 191812.png', '1774773062_denda_Screenshot 2025-11-20 073955.png', '1774772975_ktp_Screenshot 2025-12-08 191812.png', 5, '2026-03-29 08:25:44', '2026-03-29 08:31:15'),
(42, '10/1774778238', 10, 45000, '1774778267_bukti_Screenshot 2025-11-19 103428.png', '1774778298_denda_Screenshot 2025-11-20 073955.png', '1774778267_ktp_Screenshot 2025-11-19 120411.png', 5, '2026-03-29 09:57:18', '2026-03-29 09:58:23'),
(43, '10/1774850356', 10, 70000, '1774851407_bukti_1.jpg', '1774852696_denda_WhatsApp Image 2024-09-21 at 22.20.52_f78b40cf.jpg', '1774851407_ktp_1.jpg', 5, '2026-03-30 05:59:16', '2026-03-30 06:38:55'),
(44, '10/1774851306', 10, 350500, '1774851352_bukti_promosi.jpeg', NULL, '1774851352_ktp_promosi.jpeg', 5, '2026-03-30 06:15:06', '2026-03-30 06:21:28'),
(45, '10/1774852404', 10, 55000, '1774852646_bukti_promosi.jpeg', '1774853479_denda_BMC.jpeg', '1774852646_ktp_promosi.jpeg', 5, '2026-03-30 06:33:24', '2026-03-30 07:01:45'),
(46, '10/1774852687', 10, 45000, '1774852774_bukti_sketsa.jpeg', '1774853449_denda_BMC.jpeg', '1774852774_ktp_sketsa.jpeg', 5, '2026-03-30 06:38:07', '2026-03-30 07:01:37'),
(47, '15/1774853558', 15, 20000, NULL, NULL, NULL, 5, '2026-03-30 06:52:38', '2026-03-30 06:52:50'),
(48, '10/1774853612', 10, 35000, '1774853636_bukti_1.jpg', '1774853671_denda_1.jpg', '1774853636_ktp_sketsa.jpeg', 5, '2026-03-30 06:53:32', '2026-03-30 07:01:28'),
(49, '10/1774854008', 10, 20000, NULL, '1774854041_denda_BMC.jpeg', NULL, 5, '2026-03-30 07:00:08', '2026-03-30 07:01:18'),
(50, '15/1774854313', 15, 20000, NULL, NULL, NULL, 5, '2026-03-30 07:05:13', '2026-03-30 07:06:26'),
(51, '10/1774854346', 10, 20000, NULL, '1774854369_denda_BMC.jpeg', NULL, 5, '2026-03-30 07:05:46', '2026-03-30 07:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `durasi` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `nama_layanan`, `deskripsi`, `harga`, `durasi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Canyoneering', 'Petualangan menuruni air terjun dengan pemandu', 315500, '1 Hari', '1773150946.png', NULL, '2026-03-10 13:55:46'),
(2, 'Paket Terima Beres', 'Tenda sudah dipasang sebelum datang', 250000, 'Sekali', '1773151124.jpeg', NULL, '2026-03-10 13:58:44'),
(3, 'Laundry Tenda', 'Pencucian dan perawatan tenda', 100000, '1 Hari', '1773151363.jpg', NULL, '2026-03-10 14:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `telepon`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2b$12$S2XUkS7s0oZUsdj5B4/L3ew9ICzZQX.R./6EB2./1tJ4ihyBUtx52', NULL, 2, NULL, NULL, NULL),
(10, 'Tegar Bumi', 'tegarbumi10@gmail.com', NULL, '$2y$10$elUQ9cDhMZzlyVXY2zalsOXGDG.o7VSPLTiV0dngcLCjY6aPEroqi', '089646756511', 0, NULL, '2026-03-09 15:37:40', '2026-03-09 15:37:40'),
(13, 'Kasir Sanss', 'kasir@gmail.com', NULL, '$2y$10$7agxtDOwtx6DAruc8y3toesx.OzwOj2qAgNdeSqucs1Q7sdxQG0Dy', '099545445', 1, NULL, '2026-03-11 09:12:55', '2026-03-11 09:14:24'),
(14, 'amir', 'forriyus@gmail.com', NULL, '$2y$10$aJ6Z3aWosbRgMFZralFgM.XYbc4TxbgS/4Y9C51LHynMYf3HIkJWK', '0895806690705', 2, NULL, '2026-03-11 16:07:47', '2026-03-11 17:33:49'),
(15, 'forriyus', 'rifplodsjunior90@gmail.com', NULL, '$2y$10$g8TQAwQZxvEzrfteMSbBN..gHiS4YOuHpmZAQEdMmxm1n1SEH7kkK', '123456789', 0, NULL, '2026-03-11 17:15:37', '2026-03-11 17:15:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alats`
--
ALTER TABLE `alats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alats_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_alat_id_foreign` (`alat_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dendas`
--
ALTER TABLE `dendas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_alat_id_foreign` (`alat_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alats`
--
ALTER TABLE `alats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dendas`
--
ALTER TABLE `dendas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alats`
--
ALTER TABLE `alats`
  ADD CONSTRAINT `alats_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
