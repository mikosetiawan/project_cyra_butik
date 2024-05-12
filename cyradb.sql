-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2024 at 09:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cyradb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pesanan`
--

CREATE TABLE `tbl_pesanan` (
  `id_pesanan` int(10) NOT NULL,
  `kd_pesanan` varchar(10) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `harga_satuan` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pesanan`
--

INSERT INTO `tbl_pesanan` (`id_pesanan`, `kd_pesanan`, `id_produk`, `id_user`, `qty`, `harga_satuan`) VALUES
(28, 'rqd15', 5, 11, 1, 0),
(29, 'w86zx', 3, 11, 1, 0),
(33, 'br2g8', 5, 11, 1, 0),
(34, 'br2g8', 6, 11, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(10) NOT NULL,
  `nama_produk` varchar(30) NOT NULL,
  `deskripsi_produk` varchar(255) NOT NULL,
  `jenis_produk` varchar(100) NOT NULL,
  `harga_produk` float NOT NULL,
  `stok` int(10) NOT NULL DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `nama_produk`, `deskripsi_produk`, `jenis_produk`, `harga_produk`, `stok`, `img`, `date_created`) VALUES
(3, 'Blouse Linen By Mayafi', 'Adem', 'Blouse', 110000, 15, 'f77e02b82e535fa795e6ca3286978f3d.jpg', '2024-05-08 10:01:04'),
(4, 'Dress CANDY MARBLE By Nara', 'Katun', 'Dress', 165000, 5, 'd58abd21c10d7e63097e5a17f0033e38.jpg', '2024-05-08 10:01:04'),
(5, 'Dress Crincle By Nara', 'Katun', 'Dress', 165000, 5, '16fd1143d845076637a00eefd0538a90.jpg', '2024-05-08 10:01:04'),
(6, 'Dress SAVAYA LUXURY 4 By Nara', 'Katun', 'Dress', 175000, 5, 'df8de1b5c7495c76003f131fbecc933a.jpg', '2024-05-08 10:01:04'),
(7, 'Dress SIENNA By Nara', 'Katun', 'Dress', 175000, 5, 'a6aa87f3364fcf744eff6c80488a6edc.jpg', '2024-05-08 10:01:04'),
(8, 'Dress SIENNA Series 2 By Nara', 'Katun', 'Dress', 175000, 5, '4a8e4df35ed669411d86a80f378c5f27.jpg', '2024-05-08 10:01:04'),
(9, 'Dress SIENNA Series 2 By Nara', 'Katun', 'Dress', 175000, 5, 'b4feaa0e4042e20b67011caed8aed143.jpeg', '2024-05-08 10:01:04'),
(10, 'Dress SYAKILLA R49 By ARA', 'Woll', 'Dress', 135000, 2, '8d054b400b3f073eda715fae4f2f82f5.jpg', '2024-05-08 10:01:04'),
(11, 'Setelan ETNIK By NARA', 'Woll', 'Dress', 135000, 2, 'f7d077e2941a727f30ed1614f85a4aba.jpeg', '0000-00-00 00:00:00'),
(12, 'Setelan UMAIRA Series By NARA', 'Woll', 'Dress', 135000, 2, 'b465e529a621b6279b1472aef274a2ea.jpg', '0000-00-00 00:00:00'),
(13, 'Setelan UMAIRA Series By NARA', 'Woll', 'Dress', 135000, 2, 'b759261a5d6f8d495baa9aabdccaa011.jpeg', '0000-00-00 00:00:00'),
(14, 'Setelan UMAIRA Series By NARA', 'Woll', 'Dress', 135000, 2, '36fcf13b1f3d3d80bf1cf7ca86e23eb9.jpg', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tracking`
--

CREATE TABLE `tbl_tracking` (
  `kd_pesanan` varchar(5) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ongkir` float NOT NULL,
  `total_tagihan` float NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `status_pesanan` int(5) NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tracking`
--

INSERT INTO `tbl_tracking` (`kd_pesanan`, `id_user`, `ongkir`, `total_tagihan`, `bukti_pembayaran`, `status_pesanan`, `date_updated`, `date_created`) VALUES
('br2g8', 11, 3000, 133000, '2ec5ab5da8b088a7a14d6b544ea3e820.jpg', 2, '2024-05-12 07:51:46', '2024-05-12 07:21:19'),
('rqd15', 11, 10000, 165000, 'b69ba098754c32ec34813a5c6a9dd63d.jpg', 4, '2024-05-12 06:39:27', '2024-05-11 12:32:25'),
('w86zx', 11, 10000, 110000, '57828ea454250b4ee47780e183dcaa30.jpg', 4, '2024-05-12 06:39:24', '2024-05-11 14:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(10) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `alamat` varchar(64) DEFAULT NULL,
  `roles` varchar(10) NOT NULL DEFAULT 'pelanggan',
  `img` varchar(255) NOT NULL,
  `whatsapp` varchar(14) DEFAULT NULL,
  `instagram` varchar(15) DEFAULT NULL,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `nama`, `username`, `password`, `alamat`, `roles`, `img`, `whatsapp`, `instagram`, `date_updated`, `date_created`) VALUES
(4, 'Ahmad', 'mrasr', '25d55ad283aa400af464c76d713c07ad', 'Desa Kramatwatu, Jalan H. Suhaemi', 'owner', '337a7e4e937fa69a27d9ad658c339964.png', '0895619087807', 'kertasjenius', '2024-05-03 18:19:45', '2024-05-03 18:19:45'),
(9, '', 'miko', '25d55ad283aa400af464c76d713c07ad', NULL, 'admin', '2c597574970c3d0d7fa2fba767412367.png', NULL, NULL, '2024-05-11 18:29:48', '0000-00-00 00:00:00'),
(11, 'Ahmad Sofiyurrohman', 'ahmad', '25d55ad283aa400af464c76d713c07ad', 'Jl. Raya Cilegon No.km.8, Serang, Kec. Kramatwatu, Kabupaten Ser', 'pelanggan', '', '0895619087807', 'kertasjenius', '2024-05-12 07:51:46', '2024-05-11 04:00:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tbl_tracking`
--
ALTER TABLE `tbl_tracking`
  ADD PRIMARY KEY (`kd_pesanan`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  MODIFY `id_pesanan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
