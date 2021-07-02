-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2021 at 01:37 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_trainingsystem`
--
CREATE DATABASE IF NOT EXISTS `db_trainingsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_trainingsystem`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_proposal` (IN `index_proposal` INT)  NO SQL
SELECT
	proposal.id_proposal,
    proposal.tanggal_dikirim,
    proposal.pelatihan_ke,
    sum(training_list.biaya_training) as total_biaya,
    proposal.approvedby_HRD,
    proposal.approvedby_HC
from
	proposal INNER JOIN training_list ON proposal.pelatihan_ke = training_list.pelatihan_ke
WHERE
	proposal.pelatihan_ke = index_proposal$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hitung_totalbiaya` (IN `index_hitung` INT)  NO SQL
SELECT
	training_list.pelatihan_ke,
	SUM(training_list.biaya_training) as total_biaya
FROM training_list
WHERE training_list.pelatihan_ke = index_hitung$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_peserta` (IN `index_peserta` INT)  NO SQL
    DETERMINISTIC
select 
	training_list.pelatihan_ke,
    karyawan.id_karyawan,
    karyawan.nama,
    training_list.nama_training,
	training_list.tanggal_training
from 
	training_list INNER JOIN karyawan ON karyawan.id_karyawan = training_list.id_karyawan
where
training_list.pelatihan_ke = index_peserta$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal lahir` date NOT NULL,
  `unit` varchar(20) NOT NULL,
  `posisi` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_level` enum('HR','HC','Manager','Employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `alamat`, `tanggal lahir`, `unit`, `posisi`, `username`, `password`, `access_level`) VALUES
(1, 'Azizah', '.', '2000-07-28', 'Production', 'Project Manager', 'Azizah', 'Azizah', 'Manager'),
(2, 'Viera Veranda', 'Cimahi', '2000-06-21', 'Production', 'Unit', 'vie', 'vie', 'Manager'),
(3, 'Ibnu', 'Karawang', '2000-06-21', 'Production', 'Designer', 'ibnu', 'ibnu', 'Employee'),
(4, 'HR', 'HR', '2000-01-01', 'HR', 'HR', 'HR', 'HR', 'HR'),
(5, 'HC', 'HC', '2000-01-01', 'HC', 'HC', 'HC', 'HC', 'HC'),
(8, 'Manager', 'Manager', '2021-06-01', 'Manager', 'Manager', 'manager', 'manager', 'Manager'),
(9, 'Employee', 'Employee', '2021-06-01', 'Employee', 'Employee', 'employee', 'employee', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `id_proposal` int(11) NOT NULL,
  `tanggal_dikirim` date NOT NULL,
  `pelatihan_ke` int(11) NOT NULL,
  `approvedby_HRD` enum('Approved','Rejected','On Review') NOT NULL DEFAULT 'On Review',
  `approvedby_HC` enum('Approved','Rejected','On Review') NOT NULL DEFAULT 'On Review'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`id_proposal`, `tanggal_dikirim`, `pelatihan_ke`, `approvedby_HRD`, `approvedby_HC`) VALUES
(1, '2021-06-23', 1, 'Approved', 'Approved'),
(2, '2021-06-24', 2, 'On Review', 'On Review'),
(3, '2021-06-30', 3, 'On Review', 'On Review');

-- --------------------------------------------------------

--
-- Table structure for table `training_list`
--

CREATE TABLE `training_list` (
  `id_pelatihan` int(11) NOT NULL,
  `pelatihan_ke` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nama_training` text NOT NULL,
  `tanggal_training` date NOT NULL,
  `biaya_training` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_list`
--

INSERT INTO `training_list` (`id_pelatihan`, `pelatihan_ke`, `id_karyawan`, `nama_training`, `tanggal_training`, `biaya_training`) VALUES
(1, 1, 1, 'AWS Associate Cloud', '2021-06-21', 1000000),
(2, 1, 2, 'Github Project Management', '2021-06-22', 3500000),
(3, 2, 1, 'PLSQL Basic', '2021-06-21', 1000000),
(4, 2, 3, 'Desain Grafis', '2021-06-24', 2500000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id_proposal`),
  ADD KEY `pelatihan_ke` (`pelatihan_ke`);

--
-- Indexes for table `training_list`
--
ALTER TABLE `training_list`
  ADD PRIMARY KEY (`id_pelatihan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `training_list`
--
ALTER TABLE `training_list`
  MODIFY `id_pelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `training_list`
--
ALTER TABLE `training_list`
  ADD CONSTRAINT `training_list_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
