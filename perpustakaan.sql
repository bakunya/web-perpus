-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2021 at 11:29 AM
-- Server version: 10.5.9-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(20) NOT NULL,
  `password` longtext NOT NULL,
  `token` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `token`) VALUES
('kawaii', '$2y$12$CSGg/YMPRVSZ2FILH2/yLu1VzH8jvHLC.jd6IHod0UKF46uJVmKT2', '1620990398609e59be743f91.91010127');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `no_anggota` int(5) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `jk` enum('male','female') NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` varchar(70) NOT NULL,
  `email` varchar(40) NOT NULL,
  `entry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`no_anggota`, `nama`, `jk`, `telp`, `alamat`, `email`, `entry_date`) VALUES
(21, 'Neko', 'male', '00019812', 'Tokyo', 'neko@mail.com', '2021-01-19'),
(23, 'bakunya', 'male', '00129312312', 'tokyo', 'bakunya@mail.com', '2021-01-22');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode` char(8) NOT NULL,
  `isbn` varchar(25) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `penulis_kode` char(6) NOT NULL,
  `penerbit` varchar(20) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tidak_dipinjam` varchar(4) NOT NULL,
  `entry_date` date NOT NULL,
  `images` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode`, `isbn`, `judul`, `penulis_kode`, `penerbit`, `tahun_terbit`, `jumlah`, `tidak_dipinjam`, `entry_date`, `images`) VALUES
('book-1', '23', 'adachi to shimamura', '8881', 'neko', 2019, 23, '23', '2021-05-14', 'book-1-162098907737-adachi.jpeg'),
('book-2', '12345', 'adachi to shimamura 2', '8881', 'neko', 2020, 12, '12', '2021-05-14', 'book-2-162099148242-book-1-162098907737-adachi.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(16) NOT NULL,
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `image`) VALUES
(15, 'img1.jpeg'),
(16, 'img2.jpeg'),
(17, '161111386444-rem.jpg'),
(18, '161111569515-Screenshot_2020-09-11_09-40-09.png'),
(19, '16209906077-img5.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `kode` char(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`kode`, `nama`, `alamat`, `telp`) VALUES
('12121', 'Bang Hajime', 'Paradise', '09192121'),
('8881', 'Masashi Kisimoto', 'tokyo', '0091231');

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE `pinjam` (
  `id` varchar(40) NOT NULL,
  `kode_peminjam` int(5) NOT NULL,
  `kode_buku` char(8) NOT NULL,
  `tenggat` int(3) NOT NULL,
  `denda` int(4) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `lunas` tinyint(1) NOT NULL,
  `total_denda` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjam`
--

INSERT INTO `pinjam` (`id`, `kode_peminjam`, `kode_buku`, `tenggat`, `denda`, `date_start`, `date_end`, `lunas`, `total_denda`) VALUES
('1609e5ad85c29c', 21, 'book-1', 7, 1000, '2021-05-14', '2021-05-21', 1, 18000),
('1609e5c5a162a5', 21, 'book-1', 7, 1000, '2021-05-14', '2021-05-21', 1, 18000),
('1609e5c66762aa', 21, 'book-1', -4, 1000, '2021-05-14', '2021-05-10', 1, 18000),
('1609e5cabe7f51', 21, 'book-1', 7, 1000, '2021-05-04', '2021-05-11', 1, 18000),
('1609e5ce929fb0', 21, 'book-1', 7, 2000, '2021-05-10', '2021-05-05', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`no_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `penulis_kode` (`penulis_kode`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_buku` (`kode_buku`),
  ADD KEY `kode_peminjam` (`kode_peminjam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `penulis_kode` FOREIGN KEY (`penulis_kode`) REFERENCES `penulis` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD CONSTRAINT `kode_buku` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kode_peminjam` FOREIGN KEY (`kode_peminjam`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
