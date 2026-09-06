-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 10:55 PM
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
-- Database: `db_kalikurmo`
--

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `jenis_media` enum('foto','video') DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `status` enum('pending','tayang') DEFAULT 'pending',
  `waktu_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `user_id`, `nama_user`, `avatar`, `jenis_media`, `media_url`, `caption`, `status`, `waktu_upload`) VALUES
(10, 6, NULL, NULL, 'foto', 'gambar/galeri/1781035913_f61095463658f357b9712739809df644.jpg', 'Naik offroad sambil liat pemandangan indah, apalagi lewat hutan sama area desa. Gak rugi jauh\" dr luar Jawa untuk ke sini seharian hehe...', 'tayang', '2026-06-09 20:11:53'),
(11, 7, NULL, NULL, 'foto', 'gambar/galeri/1781036143_0790a8c79f97c8c779a9c6222256d7f4.jpg', 'Suasana hutan di desa asri banget sama adem kalo pas nyampe sini, rating 9/10 deh...', 'tayang', '2026-06-09 20:15:43'),
(12, 8, NULL, NULL, 'foto', 'gambar/galeri/1781036321_99aeca5fdd60ed15154fb288a3c3284c.jpg', 'Naik offroad sambil ngefoto suasana desa, untungnya saya ganti hp dulu sebelum pergi ke desa ini.', 'tayang', '2026-06-09 20:18:41'),
(13, 9, NULL, NULL, 'foto', 'gambar/galeri/1781036525_0e2196cb2ad6d6eb898d809ba8db213a.jpg', 'Kepala dusunnya baik banget sampe pengen minta dokumentasiin desa pake drone, pas habis dokumentasi dikasi makan siang dr warga desa :)', 'tayang', '2026-06-09 20:22:05'),
(15, 10, NULL, NULL, 'foto', 'gambar/galeri/1781036739_04c3cbfab63f8fae3853a7883edc8485.jpg', 'Naik offroad sambil lewat kang pardi wkwk', 'tayang', '2026-06-09 20:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `paket_wisata`
--

CREATE TABLE `paket_wisata` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `durasi` varchar(50) NOT NULL,
  `kapasitas` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_wisata`
--

INSERT INTO `paket_wisata` (`id`, `nama_paket`, `harga`, `durasi`, `kapasitas`, `deskripsi`, `gambar`) VALUES
(1, 'Paket Fun Road (Wisata)', 400000, 'Seperempat Hari', '1 Mobil (Termasuk Makan & Snack)', 'Rute santai berawal dari Desa Kenteng, masuk hutan hingga puncak Gunung Gapuk, turun ke lapangan pohon beringin.', 'gambar/gambar4.jpg'),
(2, 'Paket Off Road (Profesional)', 400000, '1 Hari Penuh', '1 Mobil (Termasuk Makan & Snack)', 'Naik dari arah barat ke puncak Gunung Gapuk, turun melewati sungai ekstrem hingga finish di lapangan pohon beringin.', 'gambar/gambar5.jpg'),
(3, 'River Tubing', 500000, 'Menyesuaikan', 'Grup / Komunitas', 'Selain off road, nikmati potensi keseruan menyusuri aliran sungai alami di Kalikurmo menggunakan ban pelampung.', 'gambar/gambar6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `kode_reservasi` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `total_biaya` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi Admin','Selesai','Dibatalkan') DEFAULT 'Menunggu Konfirmasi Admin',
  `waktu_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `kode_reservasi`, `user_id`, `id_paket`, `nama_paket`, `nama_pemesan`, `whatsapp`, `tanggal_kunjungan`, `jumlah_orang`, `harga_satuan`, `total_biaya`, `catatan`, `status`, `waktu_pesan`) VALUES
(7, 'RSV-20260609788', 6, 2, 'Paket Off Road (Profesional)', 'Jojo', '0812345', '2026-06-26', 2, 400000, 800000, 'Naik mobil sendiri ke Desa Kalikurmo mas', 'Menunggu Konfirmasi Admin', '2026-06-09 13:12:31'),
(8, 'RSV-20260609444', 7, 3, 'River Tubing', 'Diska', '111', '2026-06-30', 3, 500000, 1500000, 'Gak ada catatan khusus', 'Menunggu Konfirmasi Admin', '2026-06-09 13:14:15'),
(9, 'RSV-20260609608', 8, 3, 'River Tubing', 'Theo', '34567', '2026-06-28', 6, 500000, 3000000, 'Jemput kami di Dawung ya mas', 'Menunggu Konfirmasi Admin', '2026-06-09 13:17:12'),
(10, 'RSV-20260609785', 9, 1, 'Paket Fun Road (Wisata)', 'Naya', '123', '2026-09-14', 2, 400000, 800000, 'Gak ada catatan', 'Menunggu Konfirmasi Admin', '2026-06-09 13:20:06'),
(11, 'RSV-20260609819', 10, 3, 'River Tubing', 'Hendra', '34', '2026-08-17', 3, 500000, 1500000, 'Jemput di rumah kang pardi', 'Menunggu Konfirmasi Admin', '2026-06-09 13:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('wisatawan','admin') DEFAULT 'wisatawan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Imam', 'imamadi@gmail.com', '$2y$12$kZIrnjSljk5XaVtFbNCFCujNAcKHUCCc3twjczWWiZ5LfOlJvfkvK', 'wisatawan', '2026-05-12 19:20:27'),
(5, 'Admin Kalikurmo', 'admin_kali@gmail.com', '$2y$12$JwDtvOGz2QNy6sAeEWp/tekriTUsN6tCgl4dhMBEDsWgk3YGpxMvy', 'admin', '2026-05-13 14:43:54'),
(6, 'Jojo', 'jojo@gmail.com', '$2y$12$k7mtH6rqoB7J9xnyrRHmNuwpVNeWiQ6UMpYDokf1xEekv7ZSrYlfa', 'wisatawan', '2026-06-09 20:10:18'),
(7, 'Diska', 'diska@gmail.com', '$2y$12$FAxr5O4ll6ZTM5K4fWaweed.i9FujNt8rRfbOmay7p3zjCnLuhmO2', 'wisatawan', '2026-06-09 20:13:40'),
(8, 'Theo', 'theo@gmail.com', '$2y$12$m1s9RppoeQ/Eu1OVK3I8Ne93JytzAPdasLhyOleBP1nSramHS6wFq', 'wisatawan', '2026-06-09 20:16:30'),
(9, 'Naya', 'naya@gmail.com', '$2y$12$AibxodyxCVwwugaBbLRt4e.WFwdVMr36ESgLjEHnuyuXcF439i9yu', 'wisatawan', '2026-06-09 20:19:33'),
(10, 'Hendra', 'hendra@gmail.com', '$2y$12$Rjyyg150aCacdaTxf2l62eVPbsZN/zRh74nxg6GDj9aGRnUFKrOrS', 'wisatawan', '2026-06-09 20:23:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_reservasi` (`kode_reservasi`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
