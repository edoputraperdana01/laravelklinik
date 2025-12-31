-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2025 pada 12.23
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
-- Database: `laravel_klinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attachmentable`
--

CREATE TABLE `attachmentable` (
  `id` int(10) UNSIGNED NOT NULL,
  `attachmentable_type` varchar(255) NOT NULL,
  `attachmentable_id` int(10) UNSIGNED NOT NULL,
  `attachment_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `original_name` text NOT NULL,
  `mime` varchar(255) NOT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `size` bigint(20) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `path` text NOT NULL,
  `description` text DEFAULT NULL,
  `alt` text DEFAULT NULL,
  `hash` text DEFAULT NULL,
  `disk` varchar(255) NOT NULL DEFAULT 'public',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `browse` tinyint(1) NOT NULL DEFAULT 1,
  `read` tinyint(1) NOT NULL DEFAULT 1,
  `edit` tinyint(1) NOT NULL DEFAULT 1,
  `add` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `display_name_singular` varchar(255) NOT NULL,
  `display_name_plural` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwals`
--

CREATE TABLE `jadwals` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `tgl_jadwal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `status_masuk` tinyint(1) NOT NULL DEFAULT 0,
  `jumlah_maxpasien` int(11) NOT NULL DEFAULT 30,
  `jumlah_pasien_hari_ini` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwals`
--

INSERT INTO `jadwals` (`id_jadwal`, `tgl_jadwal`, `jam_masuk`, `jam_pulang`, `status_masuk`, `jumlah_maxpasien`, `jumlah_pasien_hari_ini`, `created_at`, `updated_at`) VALUES
(1, '1983-02-21', '20:11:03', '00:14:49', 1, 1, 8, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(2, '1987-03-28', '20:45:05', '19:33:51', 1, 11, 8, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(3, '2001-11-27', '07:52:24', '14:16:35', 1, 5, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(4, '1993-05-16', '02:11:00', '01:20:08', 1, 14, 7, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(5, '2021-04-16', '16:04:27', '02:52:31', 0, 20, 16, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(6, '2017-03-04', '01:27:48', '20:29:11', 1, 3, 12, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(7, '2002-09-24', '04:39:27', '04:06:48', 1, 16, 16, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(8, '1995-10-29', '20:18:57', '23:53:45', 0, 7, 15, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(9, '1996-06-23', '10:10:18', '14:38:53', 0, 9, 4, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(10, '1999-06-17', '14:13:15', '21:39:01', 1, 3, 4, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(11, '2025-12-31', '07:00:00', '20:00:00', 0, 98, 2, '2025-12-29 06:45:33', '2025-12-29 08:50:20'),
(12, '2025-12-29', '07:00:00', '20:00:00', 1, 100, 0, '2025-12-29 07:44:59', '2025-12-29 07:45:45'),
(13, '2025-12-30', '07:00:00', '20:00:00', 1, 100, 0, '2025-12-29 07:45:18', '2025-12-29 07:45:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_09_07_003020_create_jadwals_table', 1),
(5, '2022_09_09_011230_create_rekam_medis_table', 1),
(6, '2022_09_17_072321_create_reservasis_table', 1),
(7, '2015_04_12_000000_create_orchid_users_table', 2),
(8, '2015_10_19_214424_create_orchid_roles_table', 2),
(9, '2015_10_19_214425_create_orchid_role_users_table', 2),
(10, '2016_01_01_000000_add_voyager_user_fields', 2),
(11, '2016_01_01_000000_create_data_types_table', 2),
(12, '2016_05_19_173453_create_menu_table', 2),
(13, '2016_08_07_125128_create_orchid_attachmentstable_table', 2),
(14, '2017_09_17_125801_create_notifications_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('yanti@pasien.com', 'bD6H8Zx9ixiZQkVBySX5CYESUSejWurL1i8IOgjYX5rzts1glUTWZistGk0veb3K', '2025-12-29 06:39:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id_rekam_medis` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `kadar_gula_darah` varchar(255) NOT NULL DEFAULT '-',
  `kadar_kolesterol` varchar(255) NOT NULL DEFAULT '-',
  `kadar_asam_urat` varchar(255) NOT NULL DEFAULT '-',
  `tekanan_darah` varchar(255) NOT NULL DEFAULT '-',
  `alergi_makanan` varchar(255) NOT NULL DEFAULT '-',
  `tgl_periksa` date NOT NULL,
  `usia` int(11) NOT NULL,
  `keterangan` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`id_rekam_medis`, `user_id`, `nama_penyakit`, `nama_pasien`, `kadar_gula_darah`, `kadar_kolesterol`, `kadar_asam_urat`, `tekanan_darah`, `alergi_makanan`, `tgl_periksa`, `usia`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'consequatur', 'Padmi Vivi Pratiwi M.Kom.', '93', '35', '83', '76', 'quo', '2003-12-29', 69, 'et', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(2, 1, 'corporis', 'Shania Haryanti', '50', '48', '43', '14', 'qui', '1987-03-28', 35, 'ea', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(3, 0, 'sed', 'Latika Andriani', '95', '43', '53', '64', 'ipsam', '1971-04-29', 32, 'quisquam', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(4, 1, 'sint', 'Genta Silvia Oktaviani S.Farm', '5', '14', '64', '53', 'odio', '1987-05-06', 97, 'dolor', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(5, 1, 'beatae', 'Elvina Hassanah S.Pt', '43', '91', '64', '54', 'commodi', '1976-10-25', 49, 'maxime', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(6, 1, 'impedit', 'Martani Warsita Simbolon', '89', '2', '20', '28', 'occaecati', '1992-10-12', 35, 'quaerat', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(7, 2, 'qui', 'Hartana Mangunsong', '30', '57', '56', '7', 'voluptatem', '1980-11-27', 44, 'nobis', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(8, 2, 'sed', 'Ana Kiandra Wahyuni S.Sos', '68', '33', '5', '25', 'sequi', '1998-12-09', 32, 'et', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(9, 2, 'voluptatibus', 'Raden Wibowo', '82', '34', '18', '96', 'voluptate', '1993-06-05', 30, 'saepe', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(10, 1, 'tempora', 'Nadia Purwanti', '74', '90', '79', '49', 'repellendus', '1983-12-04', 16, 'aut', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(11, 0, 'ipsum', 'Laila Winarsih', '22', '69', '74', '54', 'neque', '1975-04-30', 48, 'rerum', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(12, 1, 'repudiandae', 'Zelda Rahayu', '8', '18', '22', '42', 'veritatis', '2002-06-01', 59, 'nam', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(13, 1, 'sit', 'Eka Firmansyah', '44', '40', '44', '43', 'similique', '1987-07-06', 30, 'optio', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(14, 2, 'aspernatur', 'Daryani Dabukke', '27', '88', '51', '91', 'harum', '1975-12-24', 52, 'iure', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(15, 2, 'alias', 'Sari Purnawati', '0', '77', '45', '94', 'eos', '1990-10-04', 29, 'sint', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(16, 1, 'et', 'Jatmiko Dwi Pradipta', '18', '1', '32', '64', 'repellat', '2020-06-16', 6, 'voluptates', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(17, 0, 'saepe', 'Lantar Narpati', '57', '41', '90', '62', 'sed', '1975-12-18', 19, 'autem', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(18, 1, 'voluptatem', 'Ajeng Ina Kuswandari S.T.', '90', '61', '50', '93', 'vitae', '2022-08-27', 50, 'totam', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(19, 0, 'maxime', 'Mulyanto Sitorus S.T.', '46', '68', '78', '83', 'optio', '2007-07-30', 67, 'quia', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(20, 2, 'eum', 'Fitria Permata', '4', '29', '99', '90', 'blanditiis', '2012-03-10', 74, 'ex', '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(21, 6, 'epilepsi', 'em@pasien.com', '80', '100', '50', '120/80', '-', '2025-12-31', 55, 'makan besi', '2025-12-29 08:57:36', '2025-12-29 08:57:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasis`
--

CREATE TABLE `reservasis` (
  `id_reservasi` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tgl_reservasi` date NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `keluhan` varchar(255) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status_hadir` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasis`
--

INSERT INTO `reservasis` (`id_reservasi`, `user_id`, `tgl_reservasi`, `nama_pasien`, `keluhan`, `no_antrian`, `status_hadir`, `created_at`, `updated_at`) VALUES
(1, 0, '1972-10-14', 'Carla Haryanti', 'et', 3, 0, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(2, 1, '1995-02-01', 'Lili Uyainah', 'consectetur', 4, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(3, 1, '2007-11-16', 'Mila Yessi Mardhiyah', 'et', 1, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(4, 0, '1989-09-09', 'Puti Faizah Kusmawati', 'eius', 12, 0, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(5, 1, '1982-09-02', 'Praba Anggriawan', 'similique', 8, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(6, 2, '1991-09-14', 'Ella Widiastuti', 'dolor', 11, 0, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(7, 1, '2012-05-26', 'Bajragin Dadi Sitorus', 'dolore', 9, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(8, 0, '2015-07-27', 'Mursinin Setiawan', 'ullam', 10, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(9, 0, '1991-10-09', 'Zelda Safitri S.E.', 'sequi', 14, 0, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(10, 1, '1991-06-20', 'Ophelia Nadine Wastuti', 'dolor', 11, 1, '2024-12-31 23:29:58', '2024-12-31 23:29:58'),
(11, 6, '2025-12-31', 'pasien', 'sakit kepala', 1, 1, '2025-12-29 07:29:01', '2025-12-29 08:51:36'),
(12, 6, '2025-12-31', 'pasien', 'edryik', 2, 1, '2025-12-29 07:46:49', '2025-12-29 08:51:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_users`
--

CREATE TABLE `role_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT '0',
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'users/default.png',
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `level`, `birthday`, `address`, `telp`, `email`, `avatar`, `password`, `image`, `created_at`, `updated_at`, `permissions`) VALUES
(1, NULL, 'bintang', '1', '2022-10-10', 'tarik', '081234567', 'admin@admin.com', 'users/default.png', '1234567890', NULL, '2024-12-31 23:29:58', '2024-12-31 23:29:58', NULL),
(2, NULL, 'bintang', '2', '2022-10-10', 'tarik', '081234567', 'doctor@doctor.com', 'users/default.png', '$2y$10$ez/IzA/DoPlBi6wxP8d8xOrA0E6hgvwhclElnULkZotGBmRafgMA6', NULL, '2024-12-31 23:29:58', '2024-12-31 23:29:58', NULL),
(3, NULL, 'Pasien 1', '0', '2025-01-01', 'Alamat 1', '08123456789', 'pasien1@gmail.com', 'users/default.png', '$2y$10$aCOj7X0mGtqt0A0bihACbevrUFopTcspSAIBC/IQE.lZRPGCJ.cVW', NULL, '2024-12-31 23:33:12', '2024-12-31 23:33:12', NULL),
(4, NULL, 'Dr. Em', '2', '2025-12-17', 'Jl. Tidar 239', '0878505050', 'em@dokter.com', 'users/default.png', '$2y$10$GcwhXrudEQPtWKM5h70U0e72mZFhBj/AoQIC2kmr78pdPUb3fBBRO', NULL, '2025-12-25 04:19:17', '2025-12-29 09:21:13', NULL),
(5, NULL, 'ADMIN1', '1', '1999-12-17', 'Jl. Surabaya', '087850429999', 'hanacarakadesain@gmail.com', 'users/default.png', '$2y$10$SbbI4xmmFh9hbzZfsnJoM.0ZjZN2jZCBKY8v6y5jsiTwDtGub34OC', NULL, '2025-12-25 04:26:17', '2025-12-25 05:53:33', NULL),
(6, NULL, 'Pasien A', '0', '2007-01-25', 'Jalan Jalan', '0987654321', 'em@pasien.com', 'users/default.png', '$2y$10$AclUMI1.VucLiX6l0J4K4u5jgpExeSTSec83w2bA6lNJZbJrn.W1W', NULL, '2025-12-25 04:42:56', '2025-12-29 09:55:52', NULL),
(7, NULL, 'angga', '0', '1993-05-04', 'jalan jalan', '082949585949', 'anggafreaks@gmail.com', 'users/default.png', '$2y$10$ZcxJuH51bPq/oQGpxGTyvuf1qpbdxcUttWPihwECpbUoYbWI6zxuK', NULL, '2025-12-25 04:58:11', '2025-12-25 04:58:11', NULL),
(8, NULL, 'Mas Edo', '0', '1992-05-04', 'Jl Surabaya', '08989898989', 'pasienedo@email.com', 'users/default.png', '$2y$10$yC3p/CmztBwwvZBkjjiU.uS9f3SO4gztlXtCIEH9s7tSZ4f15jwRK', NULL, '2025-12-29 06:22:02', '2025-12-29 06:22:02', NULL),
(9, NULL, 'Sarip', '0', '1995-04-05', 'Jl. Tidar', '01837474748', 'sarip@email.com', 'users/default.png', '$2y$10$RTflTSQwTANEgLNTHNBv1eBY/zOuhinDkMj7q3PISgw6qKoXMVgAy', NULL, '2025-12-29 06:27:49', '2025-12-29 06:27:49', NULL),
(10, NULL, 'yanti', '0', '2025-12-22', 'qwertyuio', '3456789', 'yanti@pasien.com', 'users/default.png', '$2y$10$.Ry8r4WeILOPdcUIZJROS.HDrS9tK139g6rebE4A1Um8Mwcib2e7u', NULL, '2025-12-29 06:38:37', '2025-12-29 06:38:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attachmentable`
--
ALTER TABLE `attachmentable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachmentable_attachmentable_type_attachmentable_id_index` (`attachmentable_type`,`attachmentable_id`),
  ADD KEY `attachmentable_attachment_id_foreign` (`attachment_id`);

--
-- Indeks untuk tabel `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indeks untuk tabel `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indeks untuk tabel `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam_medis`);

--
-- Indeks untuk tabel `reservasis`
--
ALTER TABLE `reservasis`
  ADD PRIMARY KEY (`id_reservasi`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indeks untuk tabel `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_users_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT untuk tabel `attachmentable`
--
ALTER TABLE `attachmentable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam_medis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `reservasis`
--
ALTER TABLE `reservasis`
  MODIFY `id_reservasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `attachmentable`
--
ALTER TABLE `attachmentable`
  ADD CONSTRAINT `attachmentable_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
