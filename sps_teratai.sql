-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2026 pada 13.16
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
-- Database: `sps_teratai`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `kode_kelas` varchar(20) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `wali_kelas` varchar(100) DEFAULT NULL,
  `tingkat` enum('A','B','C') NOT NULL DEFAULT 'A',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_sessions_table', 1),
(3, '0001_01_01_000002_create_murid_table', 1),
(4, '0001_01_01_000003_create_perkembangan_table', 1),
(5, '0001_01_01_000004_add_foto_to_murid_table', 1),
(6, '0001_01_01_000005_add_is_read_to_perkembangan_table', 1),
(7, '0001_01_01_000006_add_skor_to_perkembangan_table', 1),
(8, '0001_01_01_000007_add_parent_info_to_murid_table', 1),
(9, '2026_04_08_100451_add_measurements_to_murid_table', 1),
(10, '2026_04_15_000001_create_kelas_table', 1),
(11, '2026_05_13_144521_increase_aspek_column_length_in_perkembangan_table', 1),
(12, '2026_05_14_125825_change_skor_column_in_perkembangan_table', 1),
(13, '2026_05_14_185410_update_tingkat_column_in_kelas_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `murid`
--

CREATE TABLE `murid` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `berat_badan` double DEFAULT NULL,
  `tinggi_badan` double DEFAULT NULL,
  `lingkar_kepala` double DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `rombel` varchar(50) DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_user_orangtua` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_orang_tua` varchar(100) DEFAULT NULL,
  `email_orang_tua` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `perkembangan`
--

CREATE TABLE `perkembangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `murid_id` bigint(20) UNSIGNED NOT NULL,
  `user_id_guru` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `aspek` varchar(100) NOT NULL,
  `skor` varchar(2) NOT NULL,
  `catatan` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('guru','orang_tua') NOT NULL DEFAULT 'orang_tua',
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `orang_tua_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `guru_id`, `orang_tua_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nur Ikhlash', 'nurikhlashazisanusi06@gmail.com', '$2y$12$2t0bkogi7tuDTx2lm/qnxudgWw5UaRiae/uwNe.lJbfs2ZmWYQg3K', 'orang_tua', NULL, NULL, NULL, '2026-05-21 06:34:20', '2026-05-21 06:34:20'),
(2, 'Guru', 'guru@paud.com', '$2y$12$ozL0pYWzovI4QLR/vpOfXe7ytmFv2T967ewK4YHXfNxIIyR1za1Ja', 'guru', NULL, NULL, NULL, '2026-05-21 06:34:20', '2026-05-21 06:34:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_kode_kelas_unique` (`kode_kelas`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `murid_id_user_orangtua_index` (`id_user_orangtua`),
  ADD KEY `murid_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `perkembangan`
--
ALTER TABLE `perkembangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perkembangan_murid_id_index` (`murid_id`),
  ADD KEY `perkembangan_user_id_guru_index` (`user_id_guru`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `murid`
--
ALTER TABLE `murid`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `perkembangan`
--
ALTER TABLE `perkembangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `murid`
--
ALTER TABLE `murid`
  ADD CONSTRAINT `murid_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
