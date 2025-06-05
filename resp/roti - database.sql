-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 04:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resp`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `total_pesanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `email`, `total_pesanan`) VALUES
(1, 'Sanjii', '$2y$10$S6HdX0EOueFjS.SYnXHXvOGvJDi0ZlvIzKhEQ74tpe8MrmMbAkUt2', 'sanji@gmail.com', 0),
(2, 'saa', '$2y$10$949AtBVuNMleNADsYzoFIu4iFp4qLIlIVyBBuVJ51GgJI4SIz/20O', 'sijaim2003@gmail.com', 2),
(3, 'Sedap', '$2y$10$MEXziGa/H3cddXMix/tlP.2sLO1KV17mJNfSyoHHv9WwthTtuWYoS', 'sedap@gmail.com', 0),
(4, 'Aloha', '$2y$10$suy1cAX6413Z7FlMYCrmFuiAjhx5AaSa/BBpw13xWemoMDowPNs62', 'aloha@gmail.com', 0),
(5, 'mamang', '$2y$10$qryXLVo.A9ut9t5kptEqtuM14A0GokhKseIHp1cNBdBkPU3RLMSAG', 'mamang@gmail.com', 0),
(6, 'Rifai', '$2y$10$Zu62HN7aHV4bBRp4Ho1pvus7SQqsOGQRsbnXoLxd4cfvM7SXLqu7.', 'rifai@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pengguna`, `total_harga`, `tanggal_pesanan`) VALUES
(43, 0, 100000, '2024-12-30 05:50:24'),
(44, 0, 2000, '2024-12-30 05:51:31'),
(45, 0, 50000, '2024-12-30 05:53:16'),
(46, 0, 4000, '2025-01-09 15:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_detail`, `id_pesanan`, `id_produk`, `quantity`, `total_harga`) VALUES
(27, 43, 1, 5, 50000),
(28, 43, 7, 5, 50000),
(29, 44, 2, 1, 2000),
(30, 45, 7, 5, 50000),
(31, 46, 2, 2, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `harga`, `gambar`) VALUES
(1, 'Luti Gendang', 10000, 'luti_gendang.jpg'),
(2, 'Roti Panada', 2000, 'roti_panada.jpg'),
(3, 'Roti Gambang', 5000, 'roti_gambang.jpg'),
(4, 'Odading', 2000, 'odading.jpg'),
(5, 'Roti Buaya', 7500, 'rotibuaya.jpeg'),
(6, 'Roti Bluder', 4000, 'rotibluder.jpeg'),
(7, 'Paratha', 10000, 'paratha.jpg'),
(8, 'Kare pan', 4500, 'karepan.jpg'),
(9, 'Roti Canai', 15000, 'roticanai.jpg'),
(10, 'Damper', 20000, 'damper.jpg'),
(11, 'Shaobing', 3000, 'shaobing.jpg'),
(12, 'Baguette', 10000, 'baguette.webp'),
(13, 'Pai bao', 20000, 'paibao.jpg'),
(14, 'Ciabatta', 16000, 'ciabatta.jpg'),
(15, 'Roti Gembong', 15000, 'gwmbong.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`,`id_produk`),
  ADD KEY `total_harga` (`total_harga`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
