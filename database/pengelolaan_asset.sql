-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Feb 2022 pada 14.25
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management_asset`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `no_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `kondisi` varchar(255) NOT NULL DEFAULT 'baik',
  `id_detail_pengajuan` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `no_barang`, `nama_barang`, `qty`, `kondisi`, `id_detail_pengajuan`, `id_unit_kerja`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'UGD00001', 'A', 6, 'rusak', 9, 6, 'Hilang', '2022-02-07 15:36:40', '2022-02-07 17:55:48'),
(3, 'UGD00002', 'A', 6, 'rusak', 11, 6, 'Rusak', '2022-02-07 15:40:37', '2022-02-07 17:57:46'),
(4, 'UGD00003', 'C', 7, 'baik', 12, 6, NULL, '2022-02-07 15:40:37', NULL),
(5, 'PPTK00001', 'Barang 1', 4, 'baik', 13, 7, NULL, '2022-02-15 06:14:17', NULL),
(6, 'PPTK00002', 'Barang 1', 4, 'baik', 13, 7, NULL, '2022-02-15 06:18:56', NULL),
(7, 'LOG00001', 'Barang xyz', 20, 'baik', 14, 8, NULL, '2022-02-15 06:24:12', NULL),
(8, 'LOG00002', 'Barang xyz', 20, 'baik', 14, 8, NULL, '2022-02-15 06:25:58', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int(11) NOT NULL,
  `no_pengajuan` varchar(255) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'menunggu',
  `tanda_terima` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `no_pengajuan`, `tgl_pengajuan`, `id_user`, `id_unit_kerja`, `status`, `tanda_terima`, `created_at`, `updated_at`) VALUES
(5, 'P-UGD00001', '2022-02-07', 6, 6, 'diterima', 'P-UGD00001.png', '2022-02-07 05:09:17', '2022-02-07 15:37:16'),
(6, 'P-UGD00002', '2022-02-07', 6, 6, 'diterima', NULL, '2022-02-07 05:21:00', '2022-02-07 15:40:37'),
(7, 'P-PPTK00001', '2022-02-15', 5, 7, 'diterima', 'P-PPTK00001.png', '2022-02-15 06:00:02', '2022-02-15 06:18:56'),
(8, 'P-LOG00001', '2022-02-15', 7, 8, 'diterima', 'P-LOG00001.png', '2022-02-15 06:21:58', '2022-02-15 06:25:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_detail`
--

CREATE TABLE `pengajuan_detail` (
  `id` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'menunggu',
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengajuan_detail`
--

INSERT INTO `pengajuan_detail` (`id`, `id_pengajuan`, `nama_barang`, `qty`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(9, 5, 'A', 6, 'disetujui', '', '2022-02-07 05:09:17', '2022-02-07 13:49:07'),
(10, 5, 'C', 7, 'ditolak', '', '2022-02-07 05:09:17', '2022-02-07 13:49:07'),
(11, 6, 'A', 6, 'disetujui', 'Boleh', '2022-02-07 05:21:00', '2022-02-07 14:04:58'),
(12, 6, 'C', 7, 'disetujui', 'Wadaw', '2022-02-07 05:21:00', '2022-02-07 14:04:58'),
(13, 7, 'Barang 1', 4, 'disetujui', '', '2022-02-15 06:00:02', '2022-02-15 06:00:19'),
(14, 8, 'Barang xyz', 20, 'disetujui', '', '2022-02-15 06:21:58', '2022-02-15 06:22:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id` int(11) NOT NULL,
  `nama_unit_kerja` varchar(255) NOT NULL,
  `kode_unit_kerja` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `unit_kerja`
--

INSERT INTO `unit_kerja` (`id`, `nama_unit_kerja`, `kode_unit_kerja`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'BEM', 'LOG', '2022-02-05 06:01:29', '2022-02-06 08:27:10', '2022-02-06 08:27:10'),
(6, 'Unit Gawat Darurat', 'UGD', '2022-02-06 20:27:00', NULL, NULL),
(7, 'PPTK', 'PPTK', '2022-02-15 05:53:15', NULL, NULL),
(8, 'Logistik', 'LOG', '2022-02-15 06:02:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_unit_kerja` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama_user`, `username`, `password`, `role`, `id_unit_kerja`, `created_at`, `updated_at`) VALUES
(5, 'Admin', 'admin', '$2y$10$qjpZOVyb7fjk7Vr/YLqTuetIxWE1BwrpkhkGpc/m2LMqejfiJbk0y', 'admin', 7, '2022-02-06 08:27:47', '2022-02-15 06:11:38'),
(6, 'Sulaeman', 'sulaeman', '$2y$10$srxe/orjMVoqClUeo.T1aOW581jiiS1BD1YHpJixgmMjdSKpU1TKe', 'unit_kerja', 6, '2022-02-06 20:27:16', '2022-02-15 06:12:40'),
(7, 'Ilman', 'ilman', '$2y$10$fyqmmv3fGiCh0HPpbyg2qeKctBlXJbKja4trS6SVGIRYvddQvP8vy', 'logistik', 8, '2022-02-07 14:16:51', '2022-02-15 06:12:50');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan_detail`
--
ALTER TABLE `pengajuan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_detail`
--
ALTER TABLE `pengajuan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `unit_kerja`
--
ALTER TABLE `unit_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
