-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2020 at 09:33 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `alternatif_kode` varchar(5) NOT NULL,
  `alternatif_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`alternatif_kode`, `alternatif_nama`) VALUES
('A1', 'Alter 1'),
('A2', 'Alter 2'),
('A3', 'Alter 3');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_rank`
--

CREATE TABLE `hasil_rank` (
  `hr_id` int(11) NOT NULL,
  `alternatif_kode` varchar(5) NOT NULL,
  `hr_value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_rank`
--

INSERT INTO `hasil_rank` (`hr_id`, `alternatif_kode`, `hr_value`) VALUES
(47, 'A1', 0.434),
(48, 'A2', 0.341),
(49, 'A3', 0.792);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `kriteria_kode` varchar(5) NOT NULL,
  `kriteria_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`kriteria_kode`, `kriteria_nama`) VALUES
('B1', 'reveneu'),
('B2', 'Nilai Tes Kompetensi'),
('B3', 'Absensi'),
('B4', 'Jumlah Prioritas'),
('B5', 'Pelanggaran SOP');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `nilai_id` int(11) NOT NULL,
  `alternatif_kode` varchar(5) NOT NULL,
  `parameter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`nilai_id`, `alternatif_kode`, `parameter_id`) VALUES
(31, 'A1', 3),
(32, 'A1', 7),
(33, 'A1', 12),
(34, 'A1', 15),
(35, 'A1', 20),
(36, 'A2', 4),
(37, 'A2', 6),
(38, 'A2', 10),
(39, 'A2', 17),
(40, 'A2', 19),
(41, 'A3', 2),
(42, 'A3', 7),
(43, 'A3', 9),
(44, 'A3', 14),
(45, 'A3', 20);

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `parameter_id` int(11) NOT NULL,
  `kriteria_kode` varchar(5) NOT NULL,
  `parameter_ukuran` varchar(50) NOT NULL,
  `parameter_nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`parameter_id`, `kriteria_kode`, `parameter_ukuran`, `parameter_nilai`) VALUES
(1, 'B1', '10.000.000 s/d 13.000.000', 5),
(2, 'B1', '7.000.000 s/d 9.900.000', 4),
(3, 'B1', '4.000.000 s/d 6.900.000', 3),
(4, 'B1', '1.000.000 s/d 3.900.000', 2),
(5, 'B1', '< 1.000.000', 1),
(6, 'B2', '100', 5),
(7, 'B2', '75 s/d 99', 4),
(8, 'B2', '< 75', 3),
(9, 'B3', '0 Kali', 5),
(10, 'B3', '1 Kali s/d 3 Kali', 4),
(11, 'B3', '4        Kali s/d 6', 3),
(12, 'B3', '>6 Kali', 2),
(13, 'B4', '37 aplikasi s/d 50 aplikasi', 5),
(14, 'B4', '30 aplikasi s/d 36 aplikasi', 4),
(15, 'B4', '20 aplikasi s/d 29 aplikasi', 3),
(16, 'B4', '10 aplikasi s/d 19 aplikasi', 2),
(17, 'B4', '< 10 aplikasi', 1),
(18, 'B5', '0 Kali', 5),
(19, 'B5', '1 Kali s/d 3 Kali', 4),
(20, 'B5', '>3Kali', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `sk_id` varchar(5) NOT NULL,
  `kriteria_kode` varchar(5) NOT NULL,
  `sk_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(25) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_nama` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_tel` char(12) NOT NULL,
  `user_alamat` text NOT NULL,
  `user_jk` enum('L','P') NOT NULL,
  `user_role` enum('admin','supervisor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_nama`, `user_email`, `user_tel`, `user_alamat`, `user_jk`, `user_role`) VALUES
(7, 'adityads', '202cb962ac59075b964b07152d234b70', 'Aditya Dharmawan Saputra', 'adityads@ymail.com', '082371373347', '', 'L', 'admin'),
(8, 'super', '202cb962ac59075b964b07152d234b70', 'super', 'super@aaa.com', '08999', 'aaa', 'L', 'supervisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`alternatif_kode`);

--
-- Indexes for table `hasil_rank`
--
ALTER TABLE `hasil_rank`
  ADD PRIMARY KEY (`hr_id`),
  ADD KEY `alternatif_kode` (`alternatif_kode`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kriteria_kode`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`nilai_id`),
  ADD KEY `alternatif_kode` (`alternatif_kode`),
  ADD KEY `parameter_id` (`parameter_id`);

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`parameter_id`),
  ADD KEY `kriteria_kode` (`kriteria_kode`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`sk_id`),
  ADD KEY `kriteria_kode` (`kriteria_kode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_rank`
--
ALTER TABLE `hasil_rank`
  MODIFY `hr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `nilai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_rank`
--
ALTER TABLE `hasil_rank`
  ADD CONSTRAINT `hasil_rank_ibfk_1` FOREIGN KEY (`alternatif_kode`) REFERENCES `alternatif` (`alternatif_kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`alternatif_kode`) REFERENCES `alternatif` (`alternatif_kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`parameter_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parameter`
--
ALTER TABLE `parameter`
  ADD CONSTRAINT `parameter_ibfk_1` FOREIGN KEY (`kriteria_kode`) REFERENCES `kriteria` (`kriteria_kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`kriteria_kode`) REFERENCES `kriteria` (`kriteria_kode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
