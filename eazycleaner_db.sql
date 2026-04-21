-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Apr 2026 pada 09.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eazycleaner_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `carwash_orders`
--

CREATE TABLE `carwash_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `vehicle_type` enum('motor','mobil','mobil_mewah') NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','proses','selesai','batal') NOT NULL DEFAULT 'pending',
  `order_date` date NOT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carwash_orders`
--

INSERT INTO `carwash_orders` (`id`, `order_code`, `customer_name`, `customer_phone`, `vehicle_type`, `service_id`, `price`, `status`, `order_date`, `scheduled_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'CW-0001', 'Wendo', NULL, 'mobil', 84, 175000.00, 'selesai', '2026-01-23', NULL, 6, '2026-01-23 00:48:02', '2026-01-23 00:48:04'),
(2, 'CW-0002', 'Heri', NULL, 'mobil', 80, 60000.00, 'proses', '2026-02-26', NULL, 6, '2026-02-25 21:51:00', '2026-02-27 19:24:18'),
(3, 'CW-0003', 'Bobi', '81915895228', 'mobil', 80, 60000.00, 'batal', '2026-02-26', NULL, 6, '2026-02-25 22:00:59', '2026-02-27 19:23:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cucian_motor_orders`
--

CREATE TABLE `cucian_motor_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` enum('motor') NOT NULL DEFAULT 'motor',
  `status` enum('pending','proses','selesai','batal') NOT NULL DEFAULT 'pending',
  `order_date` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cucian_motor_orders`
--

INSERT INTO `cucian_motor_orders` (`id`, `order_code`, `customer_name`, `customer_phone`, `service_id`, `vehicle_type`, `status`, `order_date`, `created_by`, `created_at`, `updated_at`, `total`) VALUES
(1, 'CM-00001', 'Rigan', NULL, 78, 'motor', 'selesai', '2026-01-23 07:35:49', 7, '2026-01-23 00:35:49', '2026-01-23 00:37:30', 0.00),
(2, 'CM-00002', 'Bobi', '81915895228', 77, 'motor', 'pending', '2026-02-26 05:20:29', 7, '2026-02-25 22:20:29', '2026-02-25 22:20:29', 0.00),
(3, 'CM-00003', 'Wendo', '81915895228', 78, 'motor', 'proses', '2026-02-26 05:22:15', 7, '2026-02-25 22:22:15', '2026-02-26 18:32:27', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailing_orders`
--

CREATE TABLE `detailing_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('menunggu','proses','selesai','diambil') DEFAULT 'menunggu',
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `homeclean_orders`
--

CREATE TABLE `homeclean_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `batch_code` varchar(255) DEFAULT NULL,
  `order_code` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `service_type` varchar(50) NOT NULL,
  `unit_value` int(11) DEFAULT NULL,
  `manual_price` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `status` enum('menunggu','proses','selesai','diambil') DEFAULT 'menunggu',
  `order_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `homeclean_orders`
--

INSERT INTO `homeclean_orders` (`id`, `batch_code`, `order_code`, `customer_name`, `customer_phone`, `service_type`, `unit_value`, `manual_price`, `total`, `status`, `order_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 'HC-000001', 'Wendo', NULL, '46', NULL, NULL, 200000, 'diambil', '2026-01-23', '2026-01-22 20:57:13', '2026-01-22 21:13:47'),
(2, NULL, 'HC-000002', 'Rigan', NULL, '35', NULL, NULL, 1000000, 'selesai', '2026-01-23', '2026-01-22 21:03:14', '2026-01-22 21:13:44'),
(3, NULL, 'HC-000003', 'Bobi', NULL, '42', NULL, NULL, 300000, 'menunggu', '2026-02-26', '2026-02-25 20:34:12', '2026-02-25 20:34:12'),
(4, NULL, 'HC-000004', 'Acaa', '81915895228', '39', NULL, NULL, 200000, 'menunggu', '2026-02-26', '2026-02-25 20:36:21', '2026-02-25 20:36:21'),
(5, NULL, 'HC-000005', 'Kevin', '81915895228', '36', 1, NULL, 275000, 'menunggu', '2026-04-14', '2026-04-13 19:51:33', '2026-04-13 19:51:33'),
(6, NULL, 'HC-000006', 'Kevin', '81915895228', '37', 1, NULL, 250000, 'menunggu', '2026-04-14', '2026-04-13 19:51:33', '2026-04-13 19:51:33'),
(7, 'HC-000007', 'HC-000007', 'rigan', '81915895228', '46', 2, NULL, 400000, 'menunggu', '2026-04-14', '2026-04-13 21:58:23', '2026-04-13 21:58:23'),
(8, 'HC-000007', 'HC-000007', 'rigan', '81915895228', '45', 6, NULL, 450000, 'menunggu', '2026-04-14', '2026-04-13 21:58:23', '2026-04-13 21:58:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

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
-- Struktur dari tabel `job_batches`
--

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
-- Struktur dari tabel `karsobed_orders`
--

CREATE TABLE `karsobed_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `bed_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','proses','selesai','batal') NOT NULL DEFAULT 'pending',
  `order_date` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karsobed_orders`
--

INSERT INTO `karsobed_orders` (`id`, `order_code`, `customer_name`, `service_id`, `bed_type`, `price`, `status`, `order_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ORD-AA89BL9HNX', 'kevin', 35, 'king', 350000.00, 'selesai', '2026-01-21 16:04:58', 8, '2026-01-21 09:04:58', '2026-01-21 09:05:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laundry_orders`
--

CREATE TABLE `laundry_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_code` varchar(255) DEFAULT NULL,
  `order_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('kiloan','satuan') NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `status` enum('menunggu','proses','selesai','diambil') NOT NULL DEFAULT 'menunggu',
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `laundry_orders`
--

INSERT INTO `laundry_orders` (`id`, `batch_code`, `order_code`, `customer_name`, `customer_phone`, `service_id`, `type`, `weight`, `qty`, `total`, `status`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 'LD-000001', 'LD-000001', 'rigan', '852369741', 7, 'kiloan', 6.00, NULL, 54000, 'menunggu', '2026-04-14', '2026-04-13 21:56:12', '2026-04-13 21:56:12'),
(2, 'LD-000001', 'LD-000001', 'rigan', '852369741', 10, 'kiloan', 4.00, NULL, 160000, 'menunggu', '2026-04-14', '2026-04-13 21:56:12', '2026-04-13 21:56:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_12_080721_create_laundry_services_table', 1),
(5, '2026_01_12_081852_create_services_table', 2),
(6, '2026_01_13_122642_add_role_to_users_table', 3),
(7, '2026_01_17_044812_create_orders_table', 3),
(8, '2026_01_20_023808_create_user_eazy_table', 4),
(9, '2026_01_20_025006_add_role_and_status_to_users_table', 5),
(10, '2026_01_20_045002_create_testimonials_table', 6),
(11, '2026_01_20_083450_create_laundry_orders_table', 7),
(12, '2026_01_23_020636_create_laundry_services_table', 8),
(13, '2026_02_07_022321_add_customer_phone_number_to_laundry_orders_table', 9),
(14, '2026_02_10_065547_create_service_videos_table', 10),
(15, '2026_04_14_000001_add_batch_code_to_laundry_and_homeclean_orders', 11),
(16, '2026_04_14_000002_drop_unique_order_code_on_laundry_orders', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `order_date` date NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','process','done') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `service_id`, `order_code`, `customer_name`, `phone`, `order_date`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ORD-ECZ029', 'Customer HKL', '085537979016', '2026-01-12', 20000.00, 'pending', '2026-01-12 00:38:45', '2026-01-17 00:38:46'),
(2, 1, 'ORD-RTH101', 'Customer FGF', '081580667388', '2026-01-15', 50000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(3, 1, 'ORD-VON016', 'Customer YXH', '083888975851', '2026-01-10', 40000.00, 'pending', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(4, 1, 'ORD-ZLO239', 'Customer EGN', '087956547979', '2026-01-12', 40000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(5, 1, 'ORD-UVB993', 'Customer SXQ', '087260866829', '2026-01-15', 40000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(6, 1, 'ORD-NRV516', 'Customer AHH', '087255280101', '2026-01-10', 30000.00, 'process', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(7, 2, 'ORD-WHI297', 'Customer FOB', '082753242214', '2026-01-16', 35000.00, 'process', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(8, 2, 'ORD-VQW306', 'Customer IHY', '081222007309', '2026-01-13', 140000.00, 'pending', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(9, 2, 'ORD-LFH721', 'Customer ZSS', '085239402889', '2026-01-15', 70000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(10, 2, 'ORD-JIS076', 'Customer QBV', '082965464714', '2026-01-15', 175000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(11, 2, 'ORD-QLZ399', 'Customer AGP', '085046095069', '2026-01-17', 175000.00, 'done', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(12, 3, 'ORD-OIA481', 'Customer SZE', '087669898816', '2026-01-13', 16000.00, 'process', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(13, 3, 'ORD-GYG549', 'Customer SUN', '088238114565', '2026-01-14', 4000.00, 'process', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(14, 3, 'ORD-JVA032', 'Customer FWT', '085726013633', '2026-01-17', 8000.00, 'done', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(15, 3, 'ORD-ZKP742', 'Customer UUF', '085983897673', '2026-01-10', 8000.00, 'process', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(16, 3, 'ORD-LHP804', 'Customer BQP', '085668664436', '2026-01-11', 12000.00, 'pending', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(17, 3, 'ORD-FON963', 'Customer KMR', '088815442692', '2026-01-13', 20000.00, 'process', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(18, 4, 'ORD-CDL278', 'Customer BIU', '085370158149', '2026-01-15', 20000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(19, 4, 'ORD-YYF302', 'Customer CUF', '083324570388', '2026-01-14', 20000.00, 'pending', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(20, 4, 'ORD-EAI745', 'Customer NDU', '089462536503', '2026-01-15', 10000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(21, 4, 'ORD-FNR883', 'Customer EHX', '083502430625', '2026-01-16', 5000.00, 'done', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(22, 5, 'ORD-CKX127', 'Customer ACQ', '089044644808', '2026-01-12', 45000.00, 'done', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(23, 5, 'ORD-IJJ087', 'Customer MDL', '086881798766', '2026-01-12', 75000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(24, 5, 'ORD-VHC518', 'Customer PRH', '082198995823', '2026-01-12', 75000.00, 'process', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(25, 5, 'ORD-CUF860', 'Customer RXZ', '087737762832', '2026-01-14', 75000.00, 'process', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(26, 6, 'ORD-CNU816', 'Customer VAR', '081657505753', '2026-01-11', 100000.00, 'pending', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(27, 6, 'ORD-UHC634', 'Customer JBH', '081629584537', '2026-01-12', 80000.00, 'process', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(28, 6, 'ORD-ZOG653', 'Customer ROS', '081869727439', '2026-01-11', 20000.00, 'process', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(29, 6, 'ORD-MOG816', 'Customer XLY', '085743855732', '2026-01-17', 60000.00, 'pending', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(30, 6, 'ORD-UGI221', 'Customer FVZ', '084584359067', '2026-01-17', 60000.00, 'done', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(31, 6, 'ORD-MKK561', 'Customer KSL', '086859502609', '2026-01-14', 100000.00, 'pending', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(32, 6, 'ORD-PVD346', 'Customer IFJ', '088027108231', '2026-01-16', 80000.00, 'done', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(33, 7, 'ORD-VGS985', 'Customer EXJ', '086912491311', '2026-01-10', 20000.00, 'pending', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(34, 7, 'ORD-SJM071', 'Customer QFT', '088877411587', '2026-01-13', 80000.00, 'pending', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(35, 7, 'ORD-SUV894', 'Customer HKA', '084110407555', '2026-01-17', 60000.00, 'done', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(36, 7, 'ORD-HDA887', 'Customer CYU', '083210291022', '2026-01-16', 40000.00, 'pending', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(37, 8, 'ORD-AXP896', 'Customer QBF', '082630248408', '2026-01-17', 90000.00, 'pending', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(38, 8, 'ORD-BLH239', 'Customer IGR', '082603419357', '2026-01-11', 90000.00, 'pending', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(39, 8, 'ORD-JZD109', 'Customer MJN', '082229494596', '2026-01-10', 90000.00, 'done', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(40, 8, 'ORD-EHO137', 'Customer AUS', '087773981162', '2026-01-10', 18000.00, 'pending', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(41, 8, 'ORD-IYK151', 'Customer AFW', '087170828370', '2026-01-15', 72000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(42, 9, 'ORD-FRI674', 'Customer IZY', '083881925179', '2026-01-15', 45000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(43, 9, 'ORD-VJN171', 'Customer CFQ', '087127310555', '2026-01-12', 75000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(44, 9, 'ORD-DVV413', 'Customer YSE', '084839096166', '2026-01-16', 30000.00, 'process', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(45, 9, 'ORD-DUO381', 'Customer TNB', '084710782409', '2026-01-13', 45000.00, 'pending', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(46, 10, 'ORD-BZI046', 'Customer TTZ', '087950913848', '2026-01-15', 120000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(47, 10, 'ORD-TDZ766', 'Customer GWR', '081238263932', '2026-01-15', 200000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(48, 10, 'ORD-TYC126', 'Customer BIH', '086013384603', '2026-01-15', 120000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(49, 10, 'ORD-GBI909', 'Customer GDM', '089496824699', '2026-01-12', 120000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(50, 10, 'ORD-VXV732', 'Customer NZA', '086697602682', '2026-01-11', 80000.00, 'process', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(51, 10, 'ORD-EXO131', 'Customer PQP', '082314608032', '2026-01-12', 80000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(52, 11, 'ORD-HZC725', 'Customer FSI', '081819067595', '2026-01-13', 50000.00, 'process', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(53, 11, 'ORD-EFO458', 'Customer VXL', '084251980460', '2026-01-16', 50000.00, 'done', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(54, 11, 'ORD-HLT768', 'Customer ZNV', '084087870552', '2026-01-16', 50000.00, 'pending', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(55, 11, 'ORD-UKY835', 'Customer IAI', '084200619466', '2026-01-12', 250000.00, 'done', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(56, 11, 'ORD-QBC268', 'Customer AKF', '082133959130', '2026-01-16', 250000.00, 'done', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(57, 11, 'ORD-GKS590', 'Customer PYG', '089765791353', '2026-01-10', 100000.00, 'done', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(58, 12, 'ORD-UDD420', 'Customer RGE', '087941910684', '2026-01-13', 195000.00, 'done', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(59, 12, 'ORD-IDL557', 'Customer MIX', '086713298412', '2026-01-10', 65000.00, 'pending', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(60, 12, 'ORD-VPR794', 'Customer IJQ', '089558394565', '2026-01-15', 195000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(61, 12, 'ORD-JNF248', 'Customer HOZ', '088577129131', '2026-01-15', 260000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(62, 12, 'ORD-QIP031', 'Customer CRS', '088291424470', '2026-01-14', 65000.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(63, 13, 'ORD-QMJ006', 'Customer PTQ', '086482820255', '2026-01-11', 325000.00, 'done', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(64, 13, 'ORD-TUN946', 'Customer MBL', '085139835343', '2026-01-13', 195000.00, 'process', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(65, 13, 'ORD-FRZ363', 'Customer BAU', '088458001443', '2026-01-17', 130000.00, 'process', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(66, 13, 'ORD-HVP526', 'Customer CVG', '088091162406', '2026-01-15', 130000.00, 'pending', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(67, 14, 'ORD-SHW557', 'Customer ZYT', '089232142076', '2026-01-12', 150000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(68, 14, 'ORD-RXM589', 'Customer WPL', '087625047341', '2026-01-13', 100000.00, 'process', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(69, 14, 'ORD-UZF701', 'Customer HEG', '087539749895', '2026-01-16', 250000.00, 'pending', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(70, 14, 'ORD-CNZ746', 'Customer IBE', '081343410015', '2026-01-11', 100000.00, 'pending', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(71, 14, 'ORD-JGJ777', 'Customer QXG', '085394778334', '2026-01-11', 150000.00, 'pending', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(72, 14, 'ORD-UIP106', 'Customer EEF', '081754674574', '2026-01-14', 200000.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(73, 15, 'ORD-EZZ206', 'Customer FZS', '085505427281', '2026-01-14', 250000.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(74, 15, 'ORD-RBN804', 'Customer YLK', '087769793328', '2026-01-16', 150000.00, 'pending', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(75, 15, 'ORD-OEP284', 'Customer OVS', '086631541055', '2026-01-15', 250000.00, 'done', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(76, 15, 'ORD-BQP771', 'Customer IQP', '083841975072', '2026-01-12', 50000.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(77, 16, 'ORD-MEO540', 'Customer XMB', '081612363497', '2026-01-14', 21000.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(78, 16, 'ORD-GAZ646', 'Customer XAA', '087018506949', '2026-01-15', 21000.00, 'process', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(79, 16, 'ORD-PIL621', 'Customer UAM', '081406991310', '2026-01-17', 35000.00, 'pending', '2026-01-17 00:38:47', '2026-01-17 00:38:47'),
(80, 16, 'ORD-YYM758', 'Customer TND', '083382267807', '2026-01-14', 35000.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(81, 17, 'ORD-LLQ716', 'Customer TUP', '083212218828', '2026-01-10', 22500.00, 'process', '2026-01-10 00:38:47', '2026-01-17 00:38:47'),
(82, 17, 'ORD-JQR371', 'Customer DUN', '085643436080', '2026-01-11', 22500.00, 'process', '2026-01-11 00:38:47', '2026-01-17 00:38:47'),
(83, 17, 'ORD-KOF563', 'Customer GTI', '081959521486', '2026-01-15', 22500.00, 'done', '2026-01-15 00:38:47', '2026-01-17 00:38:47'),
(84, 17, 'ORD-TJT379', 'Customer YMH', '087402895058', '2026-01-14', 22500.00, 'pending', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(85, 17, 'ORD-UDY305', 'Customer IBG', '081756641320', '2026-01-13', 13500.00, 'pending', '2026-01-13 00:38:47', '2026-01-17 00:38:47'),
(86, 17, 'ORD-TWF783', 'Customer IPA', '087618405150', '2026-01-14', 22500.00, 'done', '2026-01-14 00:38:47', '2026-01-17 00:38:47'),
(87, 17, 'ORD-XWG988', 'Customer WDI', '086764631644', '2026-01-16', 9000.00, 'done', '2026-01-16 00:38:47', '2026-01-17 00:38:47'),
(88, 18, 'ORD-YEK952', 'Customer OIE', '087793537148', '2026-01-12', 13500.00, 'pending', '2026-01-12 00:38:47', '2026-01-17 00:38:47'),
(89, 18, 'ORD-LYR997', 'Customer NXO', '083365861559', '2026-01-17', 13500.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(90, 18, 'ORD-XYL336', 'Customer MTX', '081174207448', '2026-01-13', 4500.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(91, 18, 'ORD-CZD102', 'Customer MWM', '087511297968', '2026-01-10', 13500.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(92, 18, 'ORD-OQE790', 'Customer KRR', '086594281186', '2026-01-11', 18000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(93, 18, 'ORD-ZLA845', 'Customer LHD', '088166797104', '2026-01-10', 9000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(94, 19, 'ORD-THW354', 'Customer ZOH', '082481848811', '2026-01-15', 10000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(95, 19, 'ORD-ACO598', 'Customer JVJ', '089952467942', '2026-01-14', 50000.00, 'done', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(96, 19, 'ORD-ACS522', 'Customer HGY', '088011218125', '2026-01-10', 40000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(97, 19, 'ORD-XFD359', 'Customer HMQ', '087036694685', '2026-01-16', 30000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(98, 19, 'ORD-SVN701', 'Customer KRM', '085528887767', '2026-01-13', 20000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(99, 20, 'ORD-BOD863', 'Customer XXF', '088081970309', '2026-01-11', 30000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(100, 20, 'ORD-QNP467', 'Customer UGJ', '089175481016', '2026-01-10', 60000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(101, 20, 'ORD-UBR755', 'Customer FTL', '083925599141', '2026-01-10', 15000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(102, 20, 'ORD-QGT948', 'Customer TCV', '081496100142', '2026-01-17', 60000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(103, 20, 'ORD-CZJ480', 'Customer OYE', '081329246476', '2026-01-10', 30000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(104, 21, 'ORD-MEL048', 'Customer SWH', '088870344413', '2026-01-14', 25000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(105, 21, 'ORD-JDQ962', 'Customer RVF', '084332111799', '2026-01-11', 25000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(106, 21, 'ORD-YRI855', 'Customer VBF', '084145622153', '2026-01-17', 75000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(107, 21, 'ORD-WIN351', 'Customer USS', '089098252496', '2026-01-14', 125000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(108, 21, 'ORD-LTV665', 'Customer RFD', '084126875919', '2026-01-11', 100000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(109, 22, 'ORD-YGN825', 'Customer DCW', '082502513093', '2026-01-11', 90000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(110, 22, 'ORD-KLJ820', 'Customer SLC', '081911927292', '2026-01-15', 120000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(111, 22, 'ORD-ACK150', 'Customer UXI', '085398948387', '2026-01-14', 150000.00, 'pending', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(112, 22, 'ORD-NZW067', 'Customer PGI', '087158371045', '2026-01-17', 30000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(113, 22, 'ORD-XZO866', 'Customer XPU', '083381111754', '2026-01-11', 60000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(114, 23, 'ORD-YIK635', 'Customer YRN', '085136400362', '2026-01-13', 40000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(115, 23, 'ORD-NFM920', 'Customer FGL', '086771917014', '2026-01-14', 200000.00, 'pending', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(116, 23, 'ORD-CCV028', 'Customer LND', '085709929884', '2026-01-16', 200000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(117, 23, 'ORD-QXY084', 'Customer YUP', '087407301131', '2026-01-13', 80000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(118, 23, 'ORD-PJD803', 'Customer WGP', '086340451033', '2026-01-17', 80000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(119, 24, 'ORD-HSF864', 'Customer DHB', '087876789394', '2026-01-14', 180000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(120, 24, 'ORD-AXK170', 'Customer LOI', '089937986908', '2026-01-15', 45000.00, 'done', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(121, 24, 'ORD-GIH076', 'Customer OSO', '083807368677', '2026-01-13', 225000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(122, 24, 'ORD-CHG453', 'Customer RNZ', '082649047434', '2026-01-14', 90000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(123, 24, 'ORD-SVG976', 'Customer NVF', '081362440167', '2026-01-15', 135000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(124, 24, 'ORD-NQP724', 'Customer TKW', '084007198970', '2026-01-11', 90000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(125, 25, 'ORD-FDU982', 'Customer CQH', '084574491555', '2026-01-17', 40000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(126, 25, 'ORD-PBA359', 'Customer BCT', '087044405581', '2026-01-10', 24000.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(127, 25, 'ORD-VDB556', 'Customer IUH', '082769531352', '2026-01-17', 16000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(128, 25, 'ORD-DKI358', 'Customer DWM', '087178008642', '2026-01-12', 32000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(129, 25, 'ORD-XJA353', 'Customer IHL', '082370499079', '2026-01-17', 16000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(130, 25, 'ORD-RUM974', 'Customer RGC', '087990686787', '2026-01-11', 40000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(131, 26, 'ORD-CRL810', 'Customer FZC', '089785333608', '2026-01-10', 12000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(132, 26, 'ORD-PXB137', 'Customer EOL', '087100786957', '2026-01-15', 6000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(133, 26, 'ORD-LMI330', 'Customer ODX', '085751993318', '2026-01-15', 6000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(134, 26, 'ORD-EZI222', 'Customer TKB', '081913253402', '2026-01-13', 12000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(135, 27, 'ORD-ADG120', 'Customer GIW', '084929271859', '2026-01-14', 10000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(136, 27, 'ORD-VKI172', 'Customer UXN', '081397564367', '2026-01-17', 50000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(137, 27, 'ORD-BDZ138', 'Customer ASE', '084178075917', '2026-01-12', 10000.00, 'process', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(138, 27, 'ORD-ZYL953', 'Customer SFM', '086905250079', '2026-01-11', 50000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(139, 27, 'ORD-VYV981', 'Customer IGZ', '089017570067', '2026-01-13', 20000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(140, 28, 'ORD-XFE621', 'Customer QIT', '089679976047', '2026-01-16', 105000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(141, 28, 'ORD-VJJ361', 'Customer VTU', '088274596374', '2026-01-11', 35000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(142, 28, 'ORD-KZN114', 'Customer KSN', '089097533862', '2026-01-14', 175000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(143, 28, 'ORD-KII148', 'Customer USV', '084216616482', '2026-01-13', 175000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(144, 28, 'ORD-OXM077', 'Customer BNU', '085921053097', '2026-01-15', 140000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(145, 29, 'ORD-GLM722', 'Customer BAQ', '084476019803', '2026-01-15', 150000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(146, 29, 'ORD-BOB577', 'Customer NQL', '089097090524', '2026-01-16', 150000.00, 'process', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(147, 29, 'ORD-MLS512', 'Customer HQU', '084822568869', '2026-01-17', 200000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(148, 29, 'ORD-SKN928', 'Customer IOF', '089916618139', '2026-01-16', 50000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(149, 30, 'ORD-AIJ201', 'Customer CKJ', '088179630740', '2026-01-14', 240000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(150, 30, 'ORD-AVM191', 'Customer OTP', '085691058678', '2026-01-14', 400000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(151, 30, 'ORD-VWD398', 'Customer HWH', '087085014045', '2026-01-16', 320000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(152, 30, 'ORD-QYY306', 'Customer WRE', '087847683500', '2026-01-12', 240000.00, 'process', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(153, 30, 'ORD-CCQ351', 'Customer PXY', '084108430385', '2026-01-16', 80000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(154, 30, 'ORD-DKK392', 'Customer YGC', '085754341326', '2026-01-14', 400000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(155, 31, 'ORD-XEE072', 'Customer ZVK', '081571455681', '2026-01-16', 360000.00, 'process', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(156, 31, 'ORD-ISH740', 'Customer XAO', '085500506236', '2026-01-17', 360000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(157, 31, 'ORD-EES982', 'Customer ANH', '086333978312', '2026-01-10', 360000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(158, 31, 'ORD-BDR339', 'Customer NKQ', '081590551047', '2026-01-16', 240000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(159, 31, 'ORD-SWC726', 'Customer SRK', '082535301411', '2026-01-12', 120000.00, 'done', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(160, 32, 'ORD-AJC409', 'Customer DWS', '085967825467', '2026-01-12', 600000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(161, 32, 'ORD-NVF197', 'Customer TTT', '087873008064', '2026-01-11', 1000000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(162, 32, 'ORD-ZWF997', 'Customer ULC', '085923095198', '2026-01-12', 1000000.00, 'done', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(163, 32, 'ORD-ZYR946', 'Customer SGU', '082187134497', '2026-01-16', 400000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(164, 32, 'ORD-HEG943', 'Customer YMN', '087083200134', '2026-01-15', 800000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(165, 32, 'ORD-ERV013', 'Customer NYV', '088645761010', '2026-01-15', 800000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(166, 33, 'ORD-COX087', 'Customer DPX', '089091266656', '2026-01-14', 250000.00, 'pending', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(167, 33, 'ORD-OGB548', 'Customer TGS', '088203717220', '2026-01-12', 750000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(168, 33, 'ORD-OFY921', 'Customer NYN', '081441999096', '2026-01-16', 500000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(169, 33, 'ORD-FJM275', 'Customer LRY', '081255653862', '2026-01-10', 1250000.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(170, 33, 'ORD-RNX735', 'Customer ZWS', '089490032489', '2026-01-11', 500000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(171, 34, 'ORD-HJL905', 'Customer ZAR', '083390813884', '2026-01-10', 1500000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(172, 34, 'ORD-ZNK561', 'Customer HTC', '084821462505', '2026-01-13', 1200000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(173, 34, 'ORD-ORN031', 'Customer KLC', '086966763574', '2026-01-17', 300000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(174, 34, 'ORD-CJL620', 'Customer MFQ', '084333506267', '2026-01-17', 300000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(175, 34, 'ORD-PYL005', 'Customer DYR', '086276155016', '2026-01-11', 300000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(176, 34, 'ORD-PTO758', 'Customer FPQ', '082184518333', '2026-01-11', 1200000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(177, 35, 'ORD-NUE846', 'Customer XPF', '084416811747', '2026-01-11', 1400000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(178, 35, 'ORD-ZYZ953', 'Customer WNP', '081116665098', '2026-01-13', 1750000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(179, 35, 'ORD-PRW640', 'Customer TJX', '084959792609', '2026-01-11', 1050000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(180, 35, 'ORD-TZN910', 'Customer RHP', '086781591722', '2026-01-12', 700000.00, 'process', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(181, 35, 'ORD-AAO290', 'Customer IBN', '082345979213', '2026-01-10', 700000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(182, 36, 'ORD-KNK903', 'Customer MOG', '085165246896', '2026-01-10', 60000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(183, 36, 'ORD-LHT092', 'Customer NGJ', '082872145086', '2026-01-14', 150000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(184, 36, 'ORD-CUC724', 'Customer MXW', '083265623251', '2026-01-14', 60000.00, 'done', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(185, 36, 'ORD-RHR083', 'Customer UCP', '086530100573', '2026-01-17', 90000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(186, 37, 'ORD-HDF129', 'Customer YJO', '081617072198', '2026-01-15', 100000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(187, 37, 'ORD-TTG857', 'Customer QKR', '086315200516', '2026-01-12', 200000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(188, 37, 'ORD-KSV312', 'Customer VUO', '083754355102', '2026-01-15', 200000.00, 'done', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(189, 37, 'ORD-FYW219', 'Customer YAH', '085467133096', '2026-01-12', 200000.00, 'done', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(190, 38, 'ORD-NND628', 'Customer DUC', '083324460181', '2026-01-14', 40000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(191, 38, 'ORD-MNB232', 'Customer HSI', '085610160865', '2026-01-13', 60000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(192, 38, 'ORD-FAO643', 'Customer SKF', '089120616128', '2026-01-15', 100000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(193, 38, 'ORD-MYS512', 'Customer ZYE', '084646219892', '2026-01-13', 40000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(194, 38, 'ORD-EFU748', 'Customer EDA', '083037122109', '2026-01-16', 60000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(195, 38, 'ORD-NDZ766', 'Customer ONH', '084302618012', '2026-01-17', 100000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(196, 39, 'ORD-KKI194', 'Customer FMP', '085403471714', '2026-01-11', 60000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(197, 39, 'ORD-ODH373', 'Customer NPD', '081831243207', '2026-01-15', 20000.00, 'done', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(198, 39, 'ORD-UMB416', 'Customer CTJ', '082043641050', '2026-01-17', 20000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(199, 39, 'ORD-XXU590', 'Customer HQA', '085867423262', '2026-01-14', 20000.00, 'pending', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(200, 39, 'ORD-EPT073', 'Customer GWN', '089754415611', '2026-01-16', 20000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(201, 39, 'ORD-NNY404', 'Customer VDD', '083173490876', '2026-01-16', 60000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(202, 40, 'ORD-FZI089', 'Customer CTT', '081145205101', '2026-01-11', 5000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(203, 40, 'ORD-WTT985', 'Customer VMS', '087493069594', '2026-01-17', 10000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(204, 40, 'ORD-MAG283', 'Customer MKT', '088072837071', '2026-01-14', 25000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(205, 40, 'ORD-QIU617', 'Customer INV', '081989039356', '2026-01-13', 20000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(206, 41, 'ORD-DVT389', 'Customer TFR', '081580948575', '2026-01-11', 16000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(207, 41, 'ORD-RKV371', 'Customer XFB', '089224223435', '2026-01-13', 32000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(208, 41, 'ORD-ZSH660', 'Customer QDZ', '082996294612', '2026-01-11', 24000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(209, 41, 'ORD-BZI687', 'Customer MKZ', '086883633235', '2026-01-17', 24000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(210, 41, 'ORD-XPN304', 'Customer RKN', '084653488164', '2026-01-14', 16000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(211, 42, 'ORD-MLU942', 'Customer SBP', '089946793469', '2026-01-12', 140000.00, 'process', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(212, 42, 'ORD-WOS788', 'Customer EYC', '087443056634', '2026-01-10', 105000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(213, 42, 'ORD-BDW035', 'Customer LYJ', '087556893886', '2026-01-14', 70000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(214, 42, 'ORD-GVC971', 'Customer YCH', '082838552837', '2026-01-14', 35000.00, 'done', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(215, 42, 'ORD-QFV140', 'Customer JRG', '085889170390', '2026-01-14', 175000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(216, 43, 'ORD-USJ740', 'Customer HBT', '081948531835', '2026-01-12', 45000.00, 'done', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(217, 43, 'ORD-QRA168', 'Customer QLF', '082831637298', '2026-01-17', 225000.00, 'process', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(218, 43, 'ORD-FQC918', 'Customer FOC', '084334693900', '2026-01-10', 135000.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(219, 43, 'ORD-UDF832', 'Customer YFH', '087768625643', '2026-01-15', 180000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(220, 43, 'ORD-JHS070', 'Customer FJI', '087420221051', '2026-01-11', 45000.00, 'pending', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(221, 44, 'ORD-BKQ154', 'Customer PJX', '086003279077', '2026-01-10', 150000.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(222, 44, 'ORD-CQE402', 'Customer OXS', '088028583574', '2026-01-10', 100000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(223, 44, 'ORD-ACX799', 'Customer QFV', '081689672607', '2026-01-12', 100000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(224, 44, 'ORD-LNS460', 'Customer CAZ', '089777799318', '2026-01-12', 250000.00, 'done', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(225, 44, 'ORD-WZV388', 'Customer IWH', '087836799143', '2026-01-17', 250000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(226, 45, 'ORD-OUR804', 'Customer ZDK', '084739606125', '2026-01-15', 75000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(227, 45, 'ORD-XPX718', 'Customer MEX', '088696695763', '2026-01-14', 225000.00, 'pending', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(228, 45, 'ORD-XNG649', 'Customer YXS', '088541294971', '2026-01-10', 225000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(229, 45, 'ORD-MSX523', 'Customer NHJ', '083767492525', '2026-01-11', 150000.00, 'process', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(230, 45, 'ORD-RXE503', 'Customer LIK', '085385699528', '2026-01-16', 300000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(231, 45, 'ORD-JRS715', 'Customer EHU', '087526745407', '2026-01-16', 375000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(232, 46, 'ORD-BXF095', 'Customer DWS', '081643912387', '2026-01-16', 325000.00, 'process', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(233, 46, 'ORD-UGW472', 'Customer JBB', '081233884457', '2026-01-17', 325000.00, 'done', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(234, 46, 'ORD-HKQ085', 'Customer HCW', '088349855088', '2026-01-13', 65000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(235, 46, 'ORD-PYC484', 'Customer KIO', '086527907644', '2026-01-12', 325000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(236, 47, 'ORD-NLA598', 'Customer VEY', '089931567613', '2026-01-15', 110000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(237, 47, 'ORD-YCT106', 'Customer VKU', '082115781006', '2026-01-16', 440000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(238, 47, 'ORD-FBD473', 'Customer AUA', '082466511621', '2026-01-15', 440000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(239, 47, 'ORD-DUK058', 'Customer EWR', '087058686258', '2026-01-15', 220000.00, 'done', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(240, 47, 'ORD-DAO648', 'Customer AXN', '087073312094', '2026-01-13', 550000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(241, 47, 'ORD-PVN518', 'Customer FEK', '081893921228', '2026-01-12', 440000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(242, 48, 'ORD-KLO330', 'Customer MAY', '087665009711', '2026-01-14', 40000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(243, 48, 'ORD-FZB075', 'Customer UPQ', '088877087733', '2026-01-16', 120000.00, 'pending', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(244, 48, 'ORD-VKT954', 'Customer ZYU', '085119159188', '2026-01-13', 200000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(245, 48, 'ORD-DGD482', 'Customer VUD', '087637348458', '2026-01-13', 200000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(246, 48, 'ORD-XNR870', 'Customer WQY', '082633119720', '2026-01-15', 160000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(247, 48, 'ORD-JYF715', 'Customer MFM', '082236925136', '2026-01-15', 160000.00, 'pending', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(248, 49, 'ORD-WCY027', 'Customer PFP', '088552722148', '2026-01-17', 120000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48'),
(249, 49, 'ORD-IWM906', 'Customer LEA', '087345898662', '2026-01-14', 180000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(250, 49, 'ORD-AMH977', 'Customer GJP', '086383491789', '2026-01-12', 300000.00, 'pending', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(251, 49, 'ORD-YTA942', 'Customer WBD', '087505649281', '2026-01-10', 180000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(252, 49, 'ORD-NQG918', 'Customer YUL', '088359074154', '2026-01-16', 180000.00, 'process', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(253, 50, 'ORD-EVV237', 'Customer WDW', '083515692658', '2026-01-13', 105000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(254, 50, 'ORD-OSL067', 'Customer TES', '089838541208', '2026-01-13', 35000.00, 'process', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(255, 50, 'ORD-ZLI806', 'Customer ZXM', '081198183657', '2026-01-13', 105000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(256, 50, 'ORD-WIV906', 'Customer HAY', '088299104257', '2026-01-10', 35000.00, 'process', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(257, 50, 'ORD-MCJ362', 'Customer LXD', '088096739546', '2026-01-10', 70000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(258, 51, 'ORD-JVZ538', 'Customer YVC', '082355732409', '2026-01-15', 300000.00, 'process', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(259, 51, 'ORD-YLH626', 'Customer VGP', '082468042184', '2026-01-16', 120000.00, 'done', '2026-01-16 00:38:48', '2026-01-17 00:38:48'),
(260, 51, 'ORD-YPZ869', 'Customer VNV', '089199529094', '2026-01-14', 120000.00, 'done', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(261, 51, 'ORD-EFL491', 'Customer AHR', '088612891531', '2026-01-11', 180000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(262, 51, 'ORD-KTR153', 'Customer CYR', '088586451021', '2026-01-11', 60000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(263, 51, 'ORD-SHZ924', 'Customer GCS', '088262774833', '2026-01-13', 180000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(264, 51, 'ORD-FDB215', 'Customer ACQ', '084725205237', '2026-01-12', 180000.00, 'process', '2026-01-12 00:38:48', '2026-01-17 00:38:48'),
(265, 52, 'ORD-OOR060', 'Customer RLG', '085089553363', '2026-01-13', 200000.00, 'done', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(266, 52, 'ORD-QAJ932', 'Customer EKM', '084626301312', '2026-01-11', 100000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(267, 52, 'ORD-QSM946', 'Customer MKC', '083010889556', '2026-01-13', 300000.00, 'pending', '2026-01-13 00:38:48', '2026-01-17 00:38:48'),
(268, 52, 'ORD-VZO657', 'Customer XCA', '088587669226', '2026-01-14', 400000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(269, 52, 'ORD-CAM939', 'Customer OKZ', '085609478760', '2026-01-10', 300000.00, 'done', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(270, 52, 'ORD-YXO887', 'Customer DZQ', '089440315955', '2026-01-14', 400000.00, 'done', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(271, 53, 'ORD-QKS503', 'Customer GRM', '085296058870', '2026-01-14', 300000.00, 'process', '2026-01-14 00:38:48', '2026-01-17 00:38:48'),
(272, 53, 'ORD-VPR171', 'Customer IPJ', '085913439993', '2026-01-10', 450000.00, 'pending', '2026-01-10 00:38:48', '2026-01-17 00:38:48'),
(273, 53, 'ORD-QTV419', 'Customer MWJ', '088318622874', '2026-01-11', 450000.00, 'done', '2026-01-11 00:38:48', '2026-01-17 00:38:48'),
(274, 53, 'ORD-RJS774', 'Customer DZK', '088223925328', '2026-01-15', 750000.00, 'done', '2026-01-15 00:38:48', '2026-01-17 00:38:48'),
(275, 53, 'ORD-VZY999', 'Customer DON', '083253743034', '2026-01-17', 150000.00, 'pending', '2026-01-17 00:38:48', '2026-01-17 00:38:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `polish_orders`
--

CREATE TABLE `polish_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` enum('mobil','motor') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','proses','selesai','batal') NOT NULL DEFAULT 'pending',
  `order_date` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `polish_orders`
--

INSERT INTO `polish_orders` (`id`, `order_code`, `customer_name`, `service_id`, `vehicle_type`, `price`, `status`, `order_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ORD-KPIL5MXZBE', 'kevin', 13, 'mobil', 65000.00, 'selesai', '2026-01-21 16:38:45', 9, '2026-01-21 09:38:45', '2026-01-21 09:40:47'),
(2, 'ORD-QTCTGQGJLG', 'kevin', 13, 'mobil', 65000.00, 'pending', '2026-01-21 16:40:15', 9, '2026-01-21 09:40:15', '2026-01-21 09:40:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `category`, `name`, `type`, `unit`, `duration`, `description`, `price`, `note`, `created_at`, `updated_at`) VALUES
(1, 'laundry', 'Cuci Gosok', 'Ekspress', 'kg', '4 Jam', 'Cuci >> Kering >> Setrika', 12000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(2, 'laundry', 'Cuci Gosok', 'Kilat', 'kg', '1 Hari', 'Cuci >> Kering >> Setrika', 8000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(3, 'laundry', 'Cuci Gosok', 'Reguler', 'kg', '2 Hari', 'Cuci >> Kering >> Setrika', 6000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(4, 'laundry', 'Cuci Only', 'Ekspress', 'kg', '2 Jam', 'Cuci >> Kering', 9000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(5, 'laundry', 'Cuci Only', 'Kilat', 'kg', '1 Hari', 'Cuci >> Kering', 6000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(6, 'laundry', 'Cuci Only', 'Reguler', 'kg', '2 Hari', 'Cuci >> Kering', 4500, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(7, 'laundry', 'Setrika Only', 'Ekspress', 'kg', '2 Jam', 'Setrika', 9000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(8, 'laundry', 'Setrika Only', 'Kilat', 'kg', '1 Hari', 'Setrika', 6000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(9, 'laundry', 'Setrika Only', 'Reguler', 'kg', '2 Hari', 'Setrika', 4500, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(10, 'laundry', 'Bed Cover', 'XL', 'pcs', '6 Hari', 'Cuci >> Kering', 40000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(11, 'laundry', 'Bed Cover', 'L', 'pcs', '6 Hari', 'Cuci >> Kering', 30000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(12, 'laundry', 'Bed Cover', 'M', 'pcs', '6 Hari', 'Cuci >> Kering', 25000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(13, 'laundry', 'Bed Cover', 'S', 'pcs', '6 Hari', 'Cuci >> Kering', 15000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(14, 'laundry', 'Bed Cover Set All', 'XL', 'set', '6 Hari', 'Cuci >> Kering >> Setrika', 45000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(15, 'laundry', 'Bed Cover Set All', 'L', 'set', '6 Hari', 'Cuci >> Kering >> Setrika', 35000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(16, 'laundry', 'Bed Cover Set All', 'M', 'set', '6 Hari', 'Cuci >> Kering >> Setrika', 30000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(17, 'laundry', 'Bed Cover Set All', 'S', 'set', '6 Hari', 'Cuci >> Kering >> Setrika', 20000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(18, 'laundry', 'Selimut', 'XL', 'pcs', '6 Hari', 'Cuci >> Kering', 40000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(19, 'laundry', 'Selimut', 'L', 'pcs', '6 Hari', 'Cuci >> Kering', 30000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(20, 'laundry', 'Selimut', 'M', 'pcs', '6 Hari', 'Cuci >> Kering', 25000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(21, 'laundry', 'Selimut', 'S', 'pcs', '6 Hari', 'Cuci >> Kering', 15000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(22, 'laundry', 'Gorden', 'Reguler | Cuci Gosok', 'kg', '7 Hari', 'Cuci >> Kering >> Setrika', 7000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(23, 'laundry', 'Gorden', 'Reguler | Setrika Only', 'kg', '7 Hari', 'Setrika', 6000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(24, 'laundry', 'Bendera', 'Reguler | Cuci Gosok', 'kg', '7 Hari', 'Cuci >> Kering >> Setrika', 7000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(25, 'laundry', 'Bendera', 'Reguler | Setrika Only', 'kg', '7 Hari', 'Setrika', 6000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(26, 'laundry', 'Jas', 'Ekspress', 'pcs', '6 Jam', 'Cuci >> Kering >> Setrika', 30000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(27, 'laundry', 'Jas', 'Kilat', 'pcs', '1 Hari', 'Cuci >> Kering >> Setrika', 25000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(28, 'laundry', 'Jas', 'Reguler', 'pcs', '2 Hari', 'Cuci >> Kering >> Setrika', 20000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(29, 'laundry', 'Boneka', 'Besar', 'pcs', '3 Hari', 'Cuci >> Kering', 30000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(30, 'laundry', 'Boneka', 'Sedang', 'pcs', '3 Hari', 'Cuci >> Kering', 20000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(31, 'laundry', 'Boneka', 'Kecil', 'pcs', '3 Hari', 'Cuci >> Kering', 10000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(32, 'laundry', 'Sepatu', 'Reguler', 'psg', '3 Hari', 'Cuci >> Kering', 10000, NULL, '2026-01-23 03:00:20', '2026-01-23 03:00:20'),
(33, 'CLEANING', 'Room Cleaning', 'Cleaning', 'paket', NULL, 'Pembersihan rutin rumah, kantor, ruko & kos-kosan. Meliputi debu, sapu, pel, sawang-sawang', 300000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(34, 'CLEANING', 'Toilet Cleaning', 'Cleaning', 'paket', NULL, 'Pembersihan toilet menggunakan chemical standar Cleaning Service', 250000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(35, 'CLEANING', 'General Cleaning', 'Cleaning', 'paket', NULL, 'Pembersihan menyeluruh rumah, kantor, ruko & kos-kosan', 0, 'Admin', '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(36, 'CLEANING', 'Springbed', 'Superking 2m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 275000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(37, 'CLEANING', 'Springbed', 'King 1.8m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 250000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(38, 'CLEANING', 'Springbed', 'Queen 1.6m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 225000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(39, 'CLEANING', 'Springbed', 'Double 1.4m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 200000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(40, 'CLEANING', 'Springbed', 'Single Plus 1.2m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 175000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(41, 'CLEANING', 'Springbed', 'Single 1m x 2m', 'unit', NULL, 'Vakum anti-bakteri', 150000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(42, 'CLEANING', 'Sofa', 'Lipat / 4 seat', 'seat', NULL, 'Vakum anti-bakteri', 300000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(43, 'CLEANING', 'Sofa', '3 seat', 'seat', NULL, 'Vakum anti-bakteri', 225000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(44, 'CLEANING', 'Sofa', '2 seat', 'seat', NULL, 'Vakum anti-bakteri', 150000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(45, 'CLEANING', 'Sofa', '1 seat', 'seat', NULL, 'Vakum anti-bakteri', 75000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(46, 'CLEANING', 'Karpet', 'Besar', 'unit', NULL, 'Vakum anti-bakteri', 200000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(47, 'CLEANING', 'Karpet', 'Sedang', 'unit', NULL, 'Vakum anti-bakteri', 175000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(48, 'CLEANING', 'Karpet', 'Kecil', 'unit', NULL, 'Vakum anti-bakteri', 150000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(49, 'CLEANING', 'Gorden', 'Vakum', 'm', NULL, 'Vakum anti-bakteri', 50000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(50, 'CLEANING', 'Bantal', 'Vakum', 'pcs', NULL, 'Vakum anti-bakteri', 10000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(51, 'CLEANING', 'Cuci Karpet', 'Karpet Tile', 'pcs', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 15000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(52, 'CLEANING', 'Cuci Sofa', 'Besar / seat', 'seat', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 125000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(53, 'CLEANING', 'Cuci Sofa', 'Kecil / seat', 'seat', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 100000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(54, 'CLEANING', 'Cuci Springbed', 'Superking 2m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 350000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(55, 'CLEANING', 'Cuci Springbed', 'King 1.8m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 325000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(56, 'CLEANING', 'Cuci Springbed', 'Queen 1.6m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 300000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(57, 'CLEANING', 'Cuci Springbed', 'Double 1.4m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 175000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(58, 'CLEANING', 'Cuci Springbed', 'Single Plus 1.2m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 150000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(59, 'CLEANING', 'Cuci Springbed', 'Single 1m x 2m', 'unit', NULL, 'Cuci Ekstraksi (Wet Cleaning)', 125000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(60, 'CLEANING', 'Glass Cleaning', 'Rumah', 'm', NULL, 'Layanan Pembersihan Kaca', 15000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(61, 'CLEANING', 'Glass Cleaning', 'Gedung', 'm', NULL, 'Layanan Pembersihan Kaca', 25000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(62, 'CLEANING', 'Fogging', 'Aroma', 'm', NULL, 'Layanan Fogging', 6000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(63, 'CLEANING', 'Fogging', 'Disinfektan', 'm', NULL, 'Layanan Fogging', 8000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(64, 'CLEANING', 'Fogging', 'DBD', 'paket', NULL, 'Layanan Fogging', 300000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(65, 'CLEANING', 'Pressure Washing', 'Kanopi', 'm', NULL, 'Pembersihan Lumut', 30000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(66, 'CLEANING', 'Pressure Washing', 'Lantai & Dinding', 'm', NULL, 'Pembersihan Lumut', 20000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(67, 'CLEANING', 'Pressure Washing', 'Pagar Besi', 'm', NULL, 'Pembersihan Lumut', 15000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(68, 'CLEANING', 'Poles Stainless', 'Railing Stainless', 'm', NULL, 'Pembersihan stainless', 30000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(69, 'CLEANING', 'Poles Lantai', 'Marmer', 'm', NULL, 'Pembersihan lantai', 50000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(70, 'CLEANING', 'Poles Lantai', 'Granit', 'm', NULL, 'Pembersihan lantai', 45000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(71, 'CLEANING', 'Poles Lantai', 'Keramik', 'm', NULL, 'Pembersihan lantai', 35000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(72, 'CLEANING', 'Kristalisasi Lantai', 'Marmer', 'm', NULL, 'Pemolesan lantai', 135000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(73, 'CLEANING', 'Kristalisasi Lantai', 'Granit', 'm', NULL, 'Pemolesan lantai', 125000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(74, 'CLEANING', 'Kristalisasi Lantai', 'Terraso', 'm', NULL, 'Pemolesan lantai', 100000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(75, 'CLEANING', 'Gardening', 'Taman / Lahan', 'paket', NULL, 'Perawatan taman', 0, 'Admin', '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(76, 'CLEANING', 'Plumbing', 'Wastafel / Toilet', 'saluran', NULL, 'Mengatasi saluran mampet', 400000, NULL, '2026-01-23 03:30:03', '2026-01-23 03:30:03'),
(77, 'motorwash', 'Motor Kecil', NULL, 'unit', NULL, NULL, 15000, NULL, '2026-01-23 04:15:37', '2026-01-23 04:15:37'),
(78, 'motorwash', 'Motor Sedang', NULL, 'unit', NULL, NULL, 20000, NULL, '2026-01-23 04:15:37', '2026-01-23 04:15:37'),
(79, 'motorwash', 'Motor Besar', NULL, 'unit', NULL, NULL, 25000, NULL, '2026-01-23 04:15:37', '2026-01-23 04:15:37'),
(80, 'carwash', 'Reguler Carwash', 'Kecil & Menengah', 'mobil', NULL, 'Cuci mobil reguler', 60000, NULL, '2026-01-23 07:41:48', '2026-01-23 07:41:48'),
(81, 'carwash', 'Reguler Carwash', 'Besar', 'mobil', NULL, 'Cuci mobil reguler', 70000, NULL, '2026-01-23 07:41:48', '2026-01-23 07:41:48'),
(82, 'carwash', 'Reguler Carwash', 'Luxury', 'mobil', NULL, 'Cuci mobil reguler', 85000, NULL, '2026-01-23 07:41:48', '2026-01-23 07:41:48'),
(83, 'carwash', 'Premium Carwash', 'Kecil & Menengah', 'mobil', NULL, 'Cuci mobil premium', 150000, NULL, '2026-01-23 07:43:22', '2026-01-23 07:43:22'),
(84, 'carwash', 'Premium Carwash', 'Besar', 'mobil', NULL, 'Cuci mobil premium', 175000, NULL, '2026-01-23 07:43:22', '2026-01-23 07:43:22'),
(85, 'carwash', 'Premium Carwash', 'Luxury', 'mobil', NULL, 'Cuci mobil premium', 200000, NULL, '2026-01-23 07:43:22', '2026-01-23 07:43:22'),
(86, 'carwash', 'Poles Kaca', 'Kaca Depan', 'mobil', NULL, 'Poles kaca mobil', 200000, NULL, '2026-01-23 07:43:34', '2026-01-23 07:43:34'),
(87, 'carwash', 'Poles Kaca', 'Kaca Baret', 'mobil', NULL, 'Poles kaca baret', 350000, NULL, '2026-01-23 07:43:34', '2026-01-23 07:43:34'),
(88, 'carwash', 'Poles Kaca', 'Full', 'mobil', NULL, 'Poles seluruh kaca', 500000, NULL, '2026-01-23 07:43:34', '2026-01-23 07:43:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_videos`
--

CREATE TABLE `service_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` enum('Laundry','Cucian Motor','Carwash','Homecleaning') NOT NULL,
  `description` text DEFAULT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_videos`
--

INSERT INTO `service_videos` (`id`, `title`, `description`, `video_path`, `thumbnail`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'Cucian Motor', 'Solusi Motor Mengkilat Anda', 'assets/videos/1770968489-698ed5a908e1c.mp4', 'assets/thumbnails/1770968489-698ed5a9198b1.jpg', 1, '2026-02-13 00:41:29', '2026-02-13 00:41:29'),
(5, 'Cucian Motor', 'Cucian Hari Ini', 'assets/videos/1770969705-698eda6956beb.mp4', 'assets/thumbnails/1770969705-698eda695cb24.jpg', 1, '2026-02-13 01:01:45', '2026-02-13 01:01:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('d4gGH5D7Ibq4ezpqRp7A2YErVXu1ZQgmVflO6AQd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDh4NzRjRjRYelJsOGlFYXdGc2oxb2pwZDVncTNrV1VDd0tMdG1FRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776755257),
('dwLoRJ2otHA1vq8QNjnWA5b0R8ZyQHm11pdwCRcD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjZYNEdPaGZJamJSNHNEUHJ5SkVldGJFeHFvUzJVQUtaTnVnZUsyWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776755257),
('hm6klm6buY1SFfmrCe83lgkVIrABhpsZWV6316pg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDZzVW8zWTQ5Qkt1NlVraVRkMUk0N283bFE5SWhERHBGcVRmVXVRTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1776150337);

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `media` varchar(255) DEFAULT NULL,
  `media_type` enum('image') NOT NULL DEFAULT 'image',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `service`, `message`, `rating`, `media`, `media_type`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Rigan', 'Cuci Motor', 'Bersih', 5, 'testimoni/MhZdCstd7NRpgCkaCyCYqnQi1bNdkc1n2kY11OMg.png', 'image', 'approved', '2026-01-23 07:44:55', '2026-01-23 07:44:58'),
(7, 'Manda', 'Cuci Mobil', 'bagus', 5, 'testimoni/PfvsDeQMEl8cQojihnKWCCFAilzQrQeOr45F64IN.jpg', 'image', 'approved', '2026-01-23 07:59:29', '2026-01-23 09:38:31'),
(8, 'Kevin', 'Cuci mobil', 'bagus', 5, 'testimoni/915d08cc-cd13-4e7a-9a25-e2a3dcc08fae.jpg', 'image', 'approved', '2026-01-23 09:20:44', '2026-01-23 09:20:49'),
(9, 'rico', 'Cuci Mobil', 'bagus', 5, 'img/testimoni/c6923cb4-2f5c-4028-9eba-46526ab61c66.png', 'image', 'approved', '2026-01-23 10:02:14', '2026-01-23 10:05:10'),
(10, 'QWERT', 'QWWQRWQF', 'QFQEQEFEQ', 5, 'img/testimoni/ac02cf7c-3bf1-4d1c-84cc-1a91db715856.jpg', 'image', 'approved', '2026-01-23 10:05:33', '2026-01-23 10:05:35'),
(11, 'kevin', 'cuci motor', 'qwrqefwqfe', 5, 'img/testimoni/3e83613a-fbc4-439c-95c8-3dc0edddf7ec.png', 'image', 'approved', '2026-01-23 18:58:57', '2026-01-23 18:59:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','owner','admin_laundry','admin_homeclean','admin_detailing','admin_carwash','admin_cucianmotor','admin_karsobed','admin_polish') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('super_admin','owner','admin_laundry','admin_homeclean','admin_detailing','admin_carwash','admin_cucianmotor','admin_karsobed','admin_polish') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SUPER ADMIN', 'super_admin@app.test', 'super_admin', 1, NULL, '$2y$12$BghXk5b5/5Sy.GhiYFQFRO5F2Ae/f6dmMmRq5x0UIEopOztMRcBUy', NULL, '2026-01-19 19:53:21', '2026-01-19 19:53:21'),
(2, 'OWNER', 'owner@app.test', 'owner', 1, NULL, '$2y$12$ncK8UOyynyu9fZ5nP7lWhONHYLLQHpmwSASm9tqRtMgziXfHBHev.', NULL, '2026-01-19 19:53:21', '2026-01-19 19:53:21'),
(3, 'ADMIN LAUNDRY', 'admin_laundry@app.test', 'admin_laundry', 1, NULL, '$2y$12$OF9/PFFre7DY2YMzkHGohev5T5kFvpiKYGiHc1TQbJAGNVpPG.8ea', NULL, '2026-01-19 19:53:21', '2026-01-19 19:53:21'),
(4, 'ADMIN HOMECLEAN', 'admin_homeclean@app.test', 'admin_homeclean', 1, NULL, '$2y$12$ehzxweBZTKZjrU8J/cfsneV2CFTa0GJ3Qies/hnS7502ajNKzTQ5q', NULL, '2026-01-19 19:53:21', '2026-01-19 19:53:21'),
(6, 'ADMIN CARWASH', 'admin_carwash@app.test', 'admin_carwash', 1, NULL, '$2y$12$n9HIlh9p/H5SsL/GmqB6eu6XsUadkbtNILpRbnjsonJgIy0xpElC6', NULL, '2026-01-19 19:53:22', '2026-01-19 19:53:22'),
(7, 'ADMIN CUCIANMOTOR', 'admin_cucianmotor@app.test', 'admin_cucianmotor', 1, NULL, '$2y$12$4njDcXhaTtbrZ/54qmjl3OaPFKn5/QHKhkS9nO5WqUuKKfq.8vgVy', NULL, '2026-01-19 19:53:22', '2026-01-19 19:53:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `carwash_orders`
--
ALTER TABLE `carwash_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id_idx` (`service_id`);

--
-- Indeks untuk tabel `cucian_motor_orders`
--
ALTER TABLE `cucian_motor_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cucian_motor_service` (`service_id`);

--
-- Indeks untuk tabel `detailing_orders`
--
ALTER TABLE `detailing_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `homeclean_orders`
--
ALTER TABLE `homeclean_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karsobed_orders`
--
ALTER TABLE `karsobed_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_karsobed_service` (`service_id`);

--
-- Indeks untuk tabel `laundry_orders`
--
ALTER TABLE `laundry_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_laundry_orders_service` (`service_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_service_id_foreign` (`service_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `polish_orders`
--
ALTER TABLE `polish_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_polish_service` (`service_id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_videos`
--
ALTER TABLE `service_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `carwash_orders`
--
ALTER TABLE `carwash_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cucian_motor_orders`
--
ALTER TABLE `cucian_motor_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detailing_orders`
--
ALTER TABLE `detailing_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `homeclean_orders`
--
ALTER TABLE `homeclean_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karsobed_orders`
--
ALTER TABLE `karsobed_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laundry_orders`
--
ALTER TABLE `laundry_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT untuk tabel `polish_orders`
--
ALTER TABLE `polish_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `service_videos`
--
ALTER TABLE `service_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `carwash_orders`
--
ALTER TABLE `carwash_orders`
  ADD CONSTRAINT `fk_carwash_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cucian_motor_orders`
--
ALTER TABLE `cucian_motor_orders`
  ADD CONSTRAINT `fk_cucian_motor_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karsobed_orders`
--
ALTER TABLE `karsobed_orders`
  ADD CONSTRAINT `fk_karsobed_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laundry_orders`
--
ALTER TABLE `laundry_orders`
  ADD CONSTRAINT `fk_laundry_orders_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `polish_orders`
--
ALTER TABLE `polish_orders`
  ADD CONSTRAINT `fk_polish_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
