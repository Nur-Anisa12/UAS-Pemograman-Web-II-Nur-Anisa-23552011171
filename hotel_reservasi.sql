-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2026 at 09:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_reservasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'checkin', 'booking', 'Check-in tamu Aisyah di kamar 101', '2026-06-30 02:25:34', '2026-06-30 02:25:34'),
(2, 2, 'checkin', 'booking', 'Check-in tamu Aisyah di kamar 101', '2026-06-30 02:37:36', '2026-06-30 02:37:36'),
(3, 1, 'create', 'kamar', 'Menambahkan kamar baru 205', '2026-06-30 02:45:02', '2026-06-30 02:45:02'),
(4, 1, 'update', 'kamar', 'Memperbarui kamar 205', '2026-06-30 02:45:44', '2026-06-30 02:45:44'),
(5, 1, 'login', 'auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 02:55:04', '2026-06-30 02:55:04'),
(6, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:00:55', '2026-06-30 03:00:55'),
(7, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:00:55', '2026-06-30 03:00:55'),
(8, 1, 'login', 'Users', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 03:01:07', '2026-06-30 03:01:07'),
(9, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:01:37', '2026-06-30 03:01:37'),
(10, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:01:37', '2026-06-30 03:01:37'),
(11, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 03:01:47', '2026-06-30 03:01:47'),
(12, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:07:31', '2026-06-30 03:07:31'),
(13, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:07:31', '2026-06-30 03:07:31'),
(14, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-06-30 03:08:15', '2026-06-30 03:08:15'),
(15, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-06-30 03:08:15', '2026-06-30 03:08:15'),
(16, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 03:28:05', '2026-06-30 03:28:05'),
(17, 2, 'login', 'Auth', 'Petugas Front Desk login ke sistem', '2026-06-30 03:28:44', '2026-06-30 03:28:44'),
(18, 2, 'create', 'booking', 'Membuat booking 30 untuk tamu Aisyah', '2026-06-30 03:29:03', '2026-06-30 03:29:03'),
(19, 2, 'create', 'booking', 'Membuat booking untuk tamu Ariana', '2026-06-30 03:31:47', '2026-06-30 03:31:47'),
(20, 2, 'checkin', 'booking', 'Check-in tamu Ariana di kamar 102', '2026-06-30 03:32:20', '2026-06-30 03:32:20'),
(21, 2, 'checkin', 'booking', 'Check-in tamu Aisyah di kamar 101', '2026-06-30 03:32:23', '2026-06-30 03:32:23'),
(22, 2, 'checkout', 'booking', 'Check-out tamu Ariana di kamar 102', '2026-06-30 03:32:42', '2026-06-30 03:32:42'),
(23, 2, 'checkout', 'booking', 'Check-out tamu Aisyah di kamar 101', '2026-06-30 03:32:50', '2026-06-30 03:32:50'),
(24, 1, 'create', 'fasilitas', 'Menambahkan fasilitas Bathtub', '2026-06-30 03:34:20', '2026-06-30 03:34:20'),
(25, 1, 'update', 'fasilitas', 'Memperbarui fasilitas Bathtubb', '2026-06-30 03:34:49', '2026-06-30 03:34:49'),
(26, 1, 'delete', 'fasilitas', 'Menghapus fasilitas Bathtubb', '2026-06-30 03:35:02', '2026-06-30 03:35:02'),
(27, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:35:12', '2026-06-30 03:35:12'),
(28, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 03:35:12', '2026-06-30 03:35:12'),
(29, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-06-30 03:35:51', '2026-06-30 03:35:51'),
(30, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-06-30 03:35:51', '2026-06-30 03:35:51'),
(31, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 14:22:18', '2026-06-30 14:22:18'),
(32, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 14:22:28', '2026-06-30 14:22:28'),
(33, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-06-30 14:22:28', '2026-06-30 14:22:28'),
(34, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 15:06:59', '2026-06-30 15:06:59'),
(35, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 15:09:30', '2026-06-30 15:09:30'),
(36, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-06-30 15:41:02', '2026-06-30 15:41:02'),
(37, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-07-01 12:50:44', '2026-07-01 12:50:44'),
(38, 1, 'create', 'booking', 'Membuat booking untuk tamu Nur Anisa', '2026-07-01 14:17:27', '2026-07-01 14:17:27'),
(39, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-01 14:38:45', '2026-07-01 14:38:45'),
(40, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-01 14:38:45', '2026-07-01 14:38:45'),
(41, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-07-01 14:38:58', '2026-07-01 14:38:58'),
(42, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-01 14:46:15', '2026-07-01 14:46:15'),
(43, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-01 14:46:15', '2026-07-01 14:46:15'),
(44, 2, 'login', 'Auth', 'Petugas Front Desk login ke sistem', '2026-07-01 14:46:26', '2026-07-01 14:46:26'),
(45, 2, 'cancel', 'booking', 'Membatalkan booking #32', '2026-07-01 14:49:55', '2026-07-01 14:49:55'),
(46, 2, 'login', 'Auth', 'Petugas Front Desk login ke sistem', '2026-07-01 23:49:21', '2026-07-01 23:49:21'),
(47, 2, 'create', 'booking', 'Membuat booking untuk tamu Sari Dewi', '2026-07-02 00:02:55', '2026-07-02 00:02:55'),
(48, 2, 'checkin', 'booking', 'Check-in tamu Sari Dewi di kamar 401', '2026-07-02 00:03:18', '2026-07-02 00:03:18'),
(49, 2, 'checkout', 'booking', 'Check-out tamu Sari Dewi di kamar 401', '2026-07-02 00:03:31', '2026-07-02 00:03:31'),
(50, 2, 'create', 'booking', 'Membuat booking untuk tamu Mark Lee', '2026-07-02 00:16:16', '2026-07-02 00:16:16'),
(51, 2, 'cancel', 'booking', 'Membatalkan booking #34', '2026-07-02 00:16:32', '2026-07-02 00:16:32'),
(52, 2, 'create', 'booking', 'Membuat booking untuk tamu Ariana', '2026-07-02 00:17:09', '2026-07-02 00:17:09'),
(53, 2, 'check_in', 'booking', 'Check In booking 35 kamar 401', '2026-07-02 00:17:18', '2026-07-02 00:17:18'),
(54, 2, 'create', 'booking', 'Membuat booking untuk tamu Sari Dewi', '2026-07-02 00:19:46', '2026-07-02 00:19:46'),
(55, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-07-05 05:03:09', '2026-07-05 05:03:09'),
(56, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-05 05:28:58', '2026-07-05 05:28:58'),
(57, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-05 05:28:58', '2026-07-05 05:28:58'),
(58, 2, 'login', 'Auth', 'Petugas Front Desk login ke sistem', '2026-07-05 05:29:15', '2026-07-05 05:29:15'),
(59, 2, 'checkin', 'booking', 'Check-in tamu Sari Dewi di kamar 101', '2026-07-05 05:29:26', '2026-07-05 05:29:26'),
(60, 2, 'checkout', 'booking', 'Check-out tamu Ariana di kamar 401', '2026-07-05 05:29:35', '2026-07-05 05:29:35'),
(61, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-07-05 05:29:40', '2026-07-05 05:29:40'),
(62, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-07-05 05:29:40', '2026-07-05 05:29:40'),
(63, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-07-05 05:29:56', '2026-07-05 05:29:56'),
(64, 1, 'login', 'Auth', 'Admin Hotel Ajaa login ke sistem', '2026-07-05 08:18:24', '2026-07-05 08:18:24'),
(65, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-05 08:20:46', '2026-07-05 08:20:46'),
(66, 1, 'logout', 'auth', 'Admin Hotel Ajaa logout dari sistem', '2026-07-05 08:20:46', '2026-07-05 08:20:46'),
(67, 2, 'login', 'Auth', 'Petugas Front Desk login ke sistem', '2026-07-05 08:20:57', '2026-07-05 08:20:57'),
(68, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-07-05 08:21:36', '2026-07-05 08:21:36'),
(69, 2, 'logout', 'auth', 'Petugas Front Desk logout dari sistem', '2026-07-05 08:21:36', '2026-07-05 08:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int UNSIGNED NOT NULL,
  `tamu_id` int UNSIGNED NOT NULL,
  `kamar_id` int UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_malam` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `tamu_id`, `kamar_id`, `check_in_date`, `check_out_date`, `total_malam`, `total_harga`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2026-05-06', '2026-06-03', 27, 14850000.00, 'cancelled', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(2, 1, 4, '2026-04-29', '2026-06-13', 44, 24200000.00, 'cancelled', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(3, 2, 2, '2026-05-05', '2026-05-22', 16, 5600000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(4, 1, 6, '2026-04-19', '2026-06-08', 49, 41650000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-29 17:35:36'),
(5, 1, 4, '2026-06-22', '2026-06-25', 2, 1100000.00, 'checked_out', 'Tenetur tempore vero totam delectus maiores.', '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(6, 1, 1, '2026-06-16', '2026-06-20', 3, 1050000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-28 08:03:43'),
(7, 1, 4, '2026-05-11', '2026-05-24', 13, 7150000.00, 'cancelled', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(8, 2, 6, '2026-04-12', '2026-06-08', 57, 48450000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-29 17:35:39'),
(9, 2, 6, '2026-04-01', '2026-06-29', 89, 75650000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-29 16:13:04'),
(10, 2, 4, '2026-04-24', '2026-05-29', 35, 19250000.00, 'checked_out', 'Ut incidunt aut et et quae saepe est corrupti.', '2026-06-28 02:12:05', '2026-06-30 01:08:10'),
(11, 1, 2, '2026-06-22', '2026-06-28', 5, 1750000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-29 17:28:17'),
(12, 1, 2, '2026-05-05', '2026-06-09', 34, 11900000.00, 'cancelled', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(13, 1, 2, '2026-06-17', '2026-07-01', 14, 4900000.00, 'checked_out', 'Incidunt repudiandae enim sequi dicta laboriosam dicta aut.', '2026-06-28 02:12:05', '2026-06-30 01:11:16'),
(14, 1, 5, '2026-05-06', '2026-05-21', 15, 18000000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(15, 1, 1, '2026-04-22', '2026-05-07', 15, 5250000.00, 'checked_out', 'Occaecati voluptate enim quos.', '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(16, 1, 6, '2026-05-06', '2026-05-12', 5, 4250000.00, 'checked_out', 'Molestiae non consectetur facilis rerum.', '2026-06-28 02:12:05', '2026-06-30 01:11:32'),
(17, 1, 5, '2026-05-06', '2026-06-19', 44, 52800000.00, 'checked_out', 'Facere reiciendis ut rerum fuga et.', '2026-06-28 02:12:05', '2026-06-30 01:11:35'),
(18, 1, 4, '2026-04-04', '2026-05-02', 27, 14850000.00, 'checked_out', 'Perferendis ullam vel neque ut distinctio.', '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(19, 1, 3, '2026-06-06', '2026-06-24', 18, 9900000.00, 'checked_out', NULL, '2026-06-28 02:12:05', '2026-06-29 16:12:23'),
(20, 1, 6, '2026-04-28', '2026-06-25', 57, 48450000.00, 'checked_out', 'Neque fuga qui est quaerat quis praesentium quibusdam.', '2026-06-28 02:12:05', '2026-06-29 17:35:42'),
(21, 3, 1, '2026-06-28', '2026-06-30', 2, 700000.00, 'checked_out', 'Heoperrier', '2026-06-28 02:57:33', '2026-06-29 16:12:37'),
(22, 1, 2, '2026-06-28', '2026-06-29', 1, 350000.00, 'checked_out', NULL, '2026-06-28 06:32:32', '2026-06-29 08:07:38'),
(23, 5, 3, '2026-06-28', '2026-06-29', 1, 550000.00, 'checked_out', NULL, '2026-06-28 07:06:16', '2026-06-29 08:08:30'),
(24, 7, 3, '2026-06-30', '2026-07-02', 2, 1100000.00, 'checked_out', NULL, '2026-06-29 15:45:15', '2026-06-29 16:10:27'),
(25, 6, 4, '2026-06-30', '2026-07-02', 2, 1100000.00, 'checked_out', NULL, '2026-06-29 16:11:11', '2026-06-29 17:29:40'),
(26, 7, 4, '2026-06-30', '2026-07-02', 2, 1100000.00, 'checked_out', NULL, '2026-06-29 17:27:25', '2026-06-29 17:27:57'),
(27, 5, 6, '2026-06-30', '2026-07-01', 1, 850000.00, 'checked_out', 'Haloooo', '2026-06-30 01:13:19', '2026-06-30 01:18:02'),
(28, 5, 1, '2026-06-30', '2026-07-01', 1, 350000.00, 'checked_out', 'hhhhhhhhh', '2026-06-30 01:29:51', '2026-06-30 01:34:44'),
(29, 5, 1, '2026-06-30', '2026-07-01', 1, 350000.00, 'checked_out', 'hghjghjh', '2026-06-30 02:25:19', '2026-06-30 02:37:36'),
(30, 5, 1, '2026-06-30', '2026-07-02', 2, 700000.00, 'checked_out', 'aaaaaaaa', '2026-06-30 03:29:03', '2026-06-30 03:32:50'),
(31, 6, 2, '2026-06-30', '2026-07-03', 3, 1050000.00, 'checked_out', 'jjjjj', '2026-06-30 03:31:47', '2026-06-30 03:32:42'),
(32, 3, 1, '2026-07-01', '2026-07-02', 1, 350000.00, 'cancelled', NULL, '2026-07-01 14:17:27', '2026-07-01 14:49:55'),
(33, 2, 6, '2026-07-02', '2026-07-04', 2, 1700000.00, 'checked_out', NULL, '2026-07-02 00:02:55', '2026-07-02 00:03:31'),
(34, 7, 2, '2026-07-02', '2026-07-03', 1, 350000.00, 'cancelled', NULL, '2026-07-02 00:16:16', '2026-07-02 00:16:32'),
(35, 6, 6, '2026-07-02', '2026-07-03', 1, 850000.00, 'checked_out', NULL, '2026-07-02 00:17:09', '2026-07-05 05:29:35'),
(36, 2, 1, '2026-07-03', '2026-07-04', 1, 350000.00, 'checked_in', NULL, '2026-07-02 00:19:46', '2026-07-05 05:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int UNSIGNED NOT NULL,
  `nama_fasilitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_fasilitas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `deskripsi_fasilitas`, `created_at`, `updated_at`) VALUES
(1, 'Wi-Fi', 'Akses internet nirkabel cepat dan stabil.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(2, 'AC', 'Sistem pendingin udara untuk kenyamanan tamu.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(3, 'TV', 'Televisi layar datar dengan saluran kabel.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(4, 'Kamar Mandi Pribadi', 'Kamar mandi pribadi dengan shower dan perlengkapan mandi.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(5, 'Lemari', 'Lemari untuk menyimpan pakaian dan barang pribadi.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(7, 'Mini Bar', 'Mini bar dengan minuman ringan dan camilan.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(8, 'Balkon', 'Balkon pribadi dengan pemandangan luar.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(9, 'Brankas', 'Brankas untuk menyimpan barang berharga.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(10, 'Telepon', 'Telepon untuk melakukan panggilan lokal dan internasional.', '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(11, 'PS', NULL, '2026-06-28 06:42:54', '2026-06-28 06:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_tipe_kamar`
--

CREATE TABLE `fasilitas_tipe_kamar` (
  `tipe_kamar_id` int UNSIGNED NOT NULL,
  `fasilitas_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas_tipe_kamar`
--

INSERT INTO `fasilitas_tipe_kamar` (`tipe_kamar_id`, `fasilitas_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(2, 3),
(3, 3),
(4, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` int UNSIGNED NOT NULL,
  `tipe_kamar_id` int UNSIGNED NOT NULL,
  `nomor_kamar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('tersedia','terisi','perawatan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `tipe_kamar_id`, `nomor_kamar`, `status`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 1, '101', 'terisi', 'Kamar standar nyaman', '2026-06-28 02:12:05', '2026-07-05 05:29:26'),
(2, 1, '102', 'tersedia', 'Kamar standar nyaman', '2026-06-28 02:12:05', '2026-06-30 03:32:42'),
(3, 2, '201', 'tersedia', 'Kamar deluxe dengan view', '2026-06-28 02:12:05', '2026-06-29 08:08:30'),
(4, 2, '202', 'tersedia', 'Kamar deluxe dengan view', '2026-06-28 02:12:05', '2026-06-30 01:08:10'),
(5, 3, '301', 'tersedia', 'Kamar suite mewah', '2026-06-28 02:12:05', '2026-06-30 01:11:35'),
(6, 4, '401', 'tersedia', 'Kamar keluarga luas', '2026-06-28 02:12:05', '2026-07-05 05:29:35'),
(7, 3, '205', 'tersedia', 'Tes', '2026-06-30 02:45:02', '2026-06-30 02:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_25_033120_create_tipe_kamar_table', 1),
(5, '2026_06_25_033705_create_fasilitas_table', 1),
(6, '2026_06_25_034114_create_fasilitas_tipe_kamar_table', 1),
(7, '2026_06_25_034500_create_kamar_table', 1),
(8, '2026_06_25_034951_create_tamu_table', 1),
(9, '2026_06_25_035242_create_booking_table', 1),
(10, '2026_06_28_090636_create_user_profiles', 1),
(11, '2026_06_30_090217_create_activity_logs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aWYLYtkEqC43NsdPkV0Gg5DAFclDgBAohQLukJAT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVXV4U2FxWEtpUGNJR0I2QUVmS1FQZjh6SEpHWjZ6eXY4dVlGQmZuVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hZG1pbi9hY3Rpdml0eS1sb2ciO3M6NToicm91dGUiO3M6MjQ6ImFkbWluLmFjdGl2aXR5LWxvZy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783229650),
('bTfDCnIMQifpYj4uBsL1eKafs8fJoBsyyevwcgzr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUZVZkd1MTVna3lpdlp4WmRMVHpzT1RKbVFFS005NDlDb081UUR4VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783243119),
('IF7QNyBgqNE7vNX1kpO8nfdoeNVpNDNN2ImvD1x8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXk0NmpZNXdWVkZFaE9BeWxjc2I5c29SeHlCQ2FZbldwUlBTTE5wMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1783239697),
('UGqfnih8K3eiS9dH0zAErEDktNAGWq3OqkbS505L', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2ZiZWtRUTM1VVNEUk1IZUxlMGJXd1oyRVB1ek9xTTJScFByckdsTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXR1Z2FzL2Jvb2tpbmdzIjtzOjU6InJvdXRlIjtzOjIyOiJwZXR1Z2FzLmJvb2tpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1782952015),
('YZcRIYuk4yLodPfB5BGsiYvp4ebUY4l13k3ZOKVn', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQk1NTHk1TWpPQWlHSHhRQ1NHeFdLSWE1emltVXRwVXVCeks2aG54ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXR1Z2FzL2Jvb2tpbmdzIjtzOjU6InJvdXRlIjtzOjIyOiJwZXR1Z2FzLmJvb2tpbmdzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1782917396);

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id` int UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id`, `nama_lengkap`, `identity_number`, `no_telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', '3201234567890001', '08123456789', 'Jl. Merdeka No.5, Bandung', '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(2, 'Sari Dewi', '3201234567890002', '08987654321', 'Jl. Sudirman No.10, Jakarta', '2026-06-28 02:12:05', '2026-06-28 02:12:05'),
(3, 'Nur Anisa', '31222222222222222222', '0831545444646', 'jshbdshgd', '2026-06-28 02:55:51', '2026-06-28 02:55:51'),
(4, 'Nur Anisa', '32653555555555555555', '02564888888888', 'Sdbsdbsdsd', '2026-06-28 02:56:44', '2026-06-28 02:56:44'),
(5, 'Aisyah', '36020412118000', '089766788778', 'bandung', '2026-06-28 06:23:18', '2026-06-28 06:23:18'),
(6, 'Ariana', '111122333', '0223381281', NULL, '2026-06-28 07:07:08', '2026-06-28 07:07:08'),
(7, 'Mark Lee', '98977767', '0223381281', NULL, '2026-06-28 07:19:24', '2026-06-28 07:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kamar`
--

CREATE TABLE `tipe_kamar` (
  `id` int UNSIGNED NOT NULL,
  `nama_tipe_kamar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_kamar` text COLLATE utf8mb4_unicode_ci,
  `harga_per_malam` decimal(10,2) NOT NULL,
  `kapasitas` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipe_kamar`
--

INSERT INTO `tipe_kamar` (`id`, `nama_tipe_kamar`, `deskripsi_kamar`, `harga_per_malam`, `kapasitas`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 'Kamar standar nyaman', 350000.00, 2, '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(2, 'Deluxe', 'Kamar deluxe dengan view', 550000.00, 2, '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(3, 'Suite', 'Kamar suite mewah', 1200000.00, 4, '2026-06-28 02:12:04', '2026-06-28 02:12:04'),
(4, 'Family', 'Kamar keluarga luas', 850000.00, 6, '2026-06-28 02:12:04', '2026-06-28 02:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Hotel Ajaa', 'admin@hotel.com', '$2y$12$MRGrdt7bo0YOToi8IsC7E.qERcp7BtZ3lukqx5Q43NFK4SW5WlGmG', 'admin', '2026-06-28 02:12:04', '2026-06-28 02:49:40'),
(2, 'Petugas Front Desk', 'petugas@hotel.com', '$2y$12$vZORTBLrDrdUvGKb.O1QDuAkNZ/CzhTgtpxKSmxv/GCUF1/CdoqHS', 'petugas', '2026-06-28 02:12:04', '2026-06-28 02:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id_user_profile` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id_user_profile`, `id_user`, `no_telepon`, `jenis_kelamin`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, '02564888888888', 'Perempuan', 'avatars/hV7Z6XlbNThG1YfBLWRxN1jCHClsbtOM7DIN3Kqc.png', '2026-06-28 03:19:53', '2026-06-28 03:20:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_tamu_id_foreign` (`tamu_id`),
  ADD KEY `booking_kamar_id_foreign` (`kamar_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas_tipe_kamar`
--
ALTER TABLE `fasilitas_tipe_kamar`
  ADD PRIMARY KEY (`tipe_kamar_id`,`fasilitas_id`),
  ADD KEY `fasilitas_tipe_kamar_fasilitas_id_foreign` (`fasilitas_id`);

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
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kamar_nomor_kamar_unique` (`nomor_kamar`),
  ADD KEY `kamar_tipe_kamar_id_foreign` (`tipe_kamar_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tamu_identity_number_unique` (`identity_number`);

--
-- Indexes for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id_user_profile`),
  ADD UNIQUE KEY `user_profiles_id_user_unique` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id_user_profile` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_kamar_id_foreign` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_tamu_id_foreign` FOREIGN KEY (`tamu_id`) REFERENCES `tamu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fasilitas_tipe_kamar`
--
ALTER TABLE `fasilitas_tipe_kamar`
  ADD CONSTRAINT `fasilitas_tipe_kamar_fasilitas_id_foreign` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fasilitas_tipe_kamar_tipe_kamar_id_foreign` FOREIGN KEY (`tipe_kamar_id`) REFERENCES `tipe_kamar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_tipe_kamar_id_foreign` FOREIGN KEY (`tipe_kamar_id`) REFERENCES `tipe_kamar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
