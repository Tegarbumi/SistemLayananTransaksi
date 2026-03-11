-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 11, 2026 at 07:57 AM
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
(35, 2, 'Carrier', 'Dilengkapi dengan kompartemen luas dan sistem penyangga yang nyaman untuk membantu mendistribusikan beban saat perjalanan.', 35000, '1773066062-5cb974d4dc04751201e1c4648cf85611.jpeg', '2026-03-09 14:21:02', '2026-03-09 14:21:02'),
(36, 2, 'Hydropack', 'Tas dengan kantong air (hydration bladder) yang memungkinkan pengguna minum dengan mudah saat beraktivitas outdoor seperti hiking atau bersepeda.', 20000, '1773067212-id-11134207-7r98w-luokxy9jrzih52.jpg', '2026-03-09 14:40:12', '2026-03-09 14:40:12'),
(37, 2, 'Day Pack', 'Tas tahan air yang digunakan untuk melindungi barang dari air, hujan, atau kelembapan saat kegiatan outdoor seperti camping, hiking, atau rafting.', 25000, '1773067242-images.jpg', '2026-03-09 14:40:42', '2026-03-09 14:40:42'),
(38, 3, 'Kompor Portebel Mini Windproof', 'Kompor yang mudah dibawa, tidak memakan tempat menggunakan bahan bakar gas kaleng sehingga praktis digunakan di berbagai kondisi.', 15000, '1773067745-KOMPOR-WINDPROOF.png', '2026-03-09 14:48:08', '2026-03-09 14:50:36'),
(39, 3, 'Kompor Portebel 2in1', 'Kompor Portable 2In1 Untuk Gas Kaleng Dan gas LPG 3KG/12KGUntuk memenuhi kebutuhan rumah tangga, terutama untuk kegiatan memasak Anda.', 25000, '1773068205-beca06e71e8c43ef0468e9981ce131d8.jpg', '2026-03-09 14:56:45', '2026-03-09 14:56:45'),
(40, 4, 'Tracking Pole', 'Tongkat hiking adjustable height dari Naturehike, pilihan ideal untuk trekking dan camping', 15000, '1773068694-S9b7d706719fa4127b042585bc2059872q.jpg_720x720q80.jpg', '2026-03-09 15:04:54', '2026-03-09 15:04:54'),
(41, 4, 'Headlamp', 'Headlamp LED Multifunction Outdoor', 10000, '1773069007-dcaf19a3bb3906b18fb05b4c31da1cb3.jpg', '2026-03-09 15:10:07', '2026-03-09 15:10:07'),
(42, 5, 'Matras', 'Matras camping portabel dengan tebal 3 mm dan ukuran 200x60 cm, cocok untuk camping, hiking, yoga, dan aktivitas outdoor lainnya.', 10000, '1773069087-097eba2a30b1b724a67dd3585d93984a.jpg_720x720q80.jpg', '2026-03-09 15:11:27', '2026-03-09 15:11:27'),
(43, 5, 'Sleeping Bag', 'Sleeping Bag Polar Bulu adalah pilihan luar biasa untuk menjaga kenyamanan dan kehangatan Anda saat berkemah atau berpetualang di cuaca dingin.', 20000, '1773069380-Sleeping_Bag_harga_sewa_10.0001.jpg', '2026-03-09 15:16:20', '2026-03-09 15:16:20'),
(44, 4, 'Sepatu Gunung', 'Dirancang dengan sol anti-selip, fitur pelindung mata kaki (ankle support), dan material breathable atau kedap air untuk keamanan mendaki.', 35000, '1773069542-3a5f4b98-b609-4ab6-92ad-b2d91670ddec.jpg', '2026-03-09 15:19:02', '2026-03-09 15:19:02');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `alat_id`, `service_id`, `user_id`, `payment_id`, `durasi`, `starts`, `ends`, `harga`, `status`, `created_at`, `updated_at`) VALUES
(17, 33, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 45000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05'),
(18, 33, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 45000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05'),
(19, 34, NULL, 10, 11, 24, '2026-03-10 09:00:00', '2026-03-11 09:00:00', 50000, 2, '2026-03-09 16:31:45', '2026-03-09 16:33:05'),
(20, 35, NULL, 1, 12, 24, '2026-03-12 05:40:00', '2026-03-13 05:40:00', 35000, 2, '2026-03-09 16:34:24', '2026-03-09 16:34:39'),
(21, 36, NULL, 1, 12, 24, '2026-03-12 05:40:00', '2026-03-13 05:40:00', 20000, 2, '2026-03-09 16:34:24', '2026-03-09 16:34:39'),
(22, 44, NULL, 10, 13, 24, '2026-03-12 05:07:00', '2026-03-13 05:07:00', 35000, 1, '2026-03-10 16:01:51', '2026-03-10 16:01:51'),
(23, 36, NULL, 10, 14, 24, '2026-03-13 00:03:00', '2026-03-14 00:03:00', 20000, 1, '2026-03-10 16:02:24', '2026-03-10 16:02:24'),
(24, NULL, 3, 10, 18, NULL, '2026-04-02 23:26:00', '2026-04-02 23:26:00', 100000, 2, '2026-03-10 16:22:33', '2026-03-10 17:00:02'),
(25, NULL, 2, 10, 18, NULL, '2026-04-02 23:26:00', '2026-04-02 23:26:00', 250000, 2, '2026-03-10 16:22:33', '2026-03-10 17:00:02'),
(26, 37, NULL, 10, 21, 24, '2026-03-07 23:24:00', '2026-03-08 23:24:00', 25000, 1, '2026-03-10 16:24:21', '2026-03-10 16:24:21'),
(27, 40, NULL, 10, 22, 24, '2026-03-04 23:33:00', '2026-03-05 23:33:00', 15000, 1, '2026-03-10 16:32:54', '2026-03-10 16:32:54'),
(28, NULL, 3, 10, 23, NULL, '2026-03-12 23:34:00', '2026-03-12 23:34:00', 100000, 2, '2026-03-10 16:33:13', '2026-03-10 16:44:16'),
(29, 35, NULL, 10, 24, 24, '2026-03-20 13:46:00', '2026-03-21 13:46:00', 35000, 2, '2026-03-11 06:44:32', '2026-03-11 06:45:58'),
(30, NULL, 3, 10, 24, NULL, '2026-03-20 13:46:00', '2026-03-20 13:46:00', 100000, 2, '2026-03-11 06:44:32', '2026-03-11 06:45:58');

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
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `no_invoice`, `user_id`, `total`, `bukti`, `status`, `created_at`, `updated_at`) VALUES
(11, '10/1773073905', 10, 140000, '1773074655-Screenshot 2025-11-21 083959.png', 4, '2026-03-09 16:31:45', '2026-03-10 15:59:47'),
(12, '1/1773074064', 1, 55000, '1773074475-Screenshot 2025-11-19 103428.png', 4, '2026-03-09 16:34:24', '2026-03-10 16:00:06'),
(13, '10/1773158511', 10, 350500, NULL, 1, '2026-03-10 16:01:51', '2026-03-10 16:01:51'),
(14, '10/1773158544', 10, 20000, NULL, 1, '2026-03-10 16:02:24', '2026-03-10 16:02:24'),
(15, '10/1773158569', 10, 100000, NULL, 1, '2026-03-10 16:02:49', '2026-03-10 16:02:49'),
(16, '10/1773159635', 10, 350000, NULL, 1, '2026-03-10 16:20:35', '2026-03-10 16:20:35'),
(17, '10/1773159667', 10, 350000, NULL, 1, '2026-03-10 16:21:07', '2026-03-10 16:21:07'),
(18, '10/1773159753', 10, 350000, '1773162033-WhatsApp Image 2026-03-10 at 20.57.53.jpeg', 4, '2026-03-10 16:22:33', '2026-03-10 17:01:19'),
(19, '10/1773159762', 10, 0, NULL, 1, '2026-03-10 16:22:42', '2026-03-10 16:22:42'),
(20, '10/1773159772', 10, 0, NULL, 1, '2026-03-10 16:22:52', '2026-03-10 16:22:52'),
(21, '10/1773159861', 10, 25000, NULL, 1, '2026-03-10 16:24:21', '2026-03-10 16:24:21'),
(22, '10/1773160374', 10, 15000, NULL, 1, '2026-03-10 16:32:54', '2026-03-10 16:32:54'),
(23, '10/1773160393', 10, 100000, '1773161258-Screenshot 2026-03-10 205348.png', 4, '2026-03-10 16:33:13', '2026-03-10 16:50:00'),
(24, '10/1773211472', 10, 135000, '1773211612-Screenshot 2025-11-19 103428.png', 4, '2026-03-11 06:44:32', '2026-03-11 06:54:38');

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
(1, 'admin', 'adminbumi@gmail.com', NULL, '$2b$12$S2XUkS7s0oZUsdj5B4/L3ew9ICzZQX.R./6EB2./1tJ4ihyBUtx52', NULL, 2, NULL, NULL, NULL),
(10, 'Tegar Bumi', 'tegarbumi10@gmail.com', NULL, '$2y$10$elUQ9cDhMZzlyVXY2zalsOXGDG.o7VSPLTiV0dngcLCjY6aPEroqi', '089646756511', 0, NULL, '2026-03-09 15:37:40', '2026-03-09 15:37:40'),
(11, 'Bumi Admin', 'tegarbumi.9e@gmail.com', NULL, '$2y$10$N1qPkVg8VafUOBJZr06Mi.1W0L4PChHRsKsdL7J41UTq3IVCKtJuS', '089646756511', 1, NULL, '2026-03-10 15:34:38', '2026-03-10 15:35:14');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
