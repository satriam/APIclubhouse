-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Des 2022 pada 01.08
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jsonwebtoken`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin`
--

CREATE TABLE `checkin` (
  `id` int(11) NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `checkin`
--

INSERT INTO `checkin` (`id`, `lokasi_id`, `created_at`, `user_id`) VALUES
(125, 1, '2022-12-04 16:17:07', 12),
(146, 2, '2022-12-04 16:17:07', 12),
(147, 1, '2022-12-05 21:13:54', 12),
(148, 2, '2022-12-06 07:51:30', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `nama_lokasi`, `kode`, `gambar`) VALUES
(1, 'pool townsite tanjung enim', 'e2fc714c4727ee9395f324cd2e7f331f', 'https://img2.pngdownload.id/20180706/fyq/kisspng-laurel-municipal-swimming-pool-logo-west-laurel-sw-chicken-logo-5b3f200914a229.8630405415308636250845.jpg'),
(2, 'biliard tanah putih', 'aabb', 'https://cdn1.localstartupfest.id/wp-content/uploads/1646/87/download-bola-billiard-.png.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-07-03-122141', 'App\\Database\\Migrations\\Users', 'default', 'App', 1645417936, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `nama`) VALUES
(1, 'admin kolam'),
(2, 'user'),
(3, 'admin billiard');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `nopeg` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `nama`, `role_id`, `nopeg`) VALUES
(11, 'satt1@gmail.com', '$2y$10$jH6yp.z6ybBd74.p.e3NQ.HRKCBNU2pYsmZ83LPYnmoV4Pu5HtrLe', 'admin satt', 1, '28019'),
(12, 'satt11@gmail.com', '$2y$10$DxweD5HnQhEpjD.gk7VVu.sxZ2lcbRiZplR3APHlbPgfpx0Yfv3Tm', 'satria', 2, '444154');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lokasi` (`lokasi_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `checkin`
--
ALTER TABLE `checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `fk_lokasi` FOREIGN KEY (`lokasi_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
