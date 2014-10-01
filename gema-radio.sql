-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2014 at 10:22 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gema_radio`
--
CREATE DATABASE IF NOT EXISTS `gema_radio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gema_radio`;

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE IF NOT EXISTS `akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rekaman`
--

CREATE TABLE IF NOT EXISTS `rekaman` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_deadline` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siaran`
--

CREATE TABLE IF NOT EXISTS `siaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanngal` date NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `no_order` int(11) DEFAULT NULL,
  `produk` varchar(100) DEFAULT NULL,
  `nominal` int(11) NOT NULL,
  `terbilang` varchar(300) NOT NULL,
  `jumlah_siaran` int(11) NOT NULL,
  `siaran_per_hari` int(11) NOT NULL,
  `teks_spot` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `jenis_transaksi` enum('Berita Kehilangan','Iklan nasional','Iklan lokal','Rekaman','Pengumuman') NOT NULL,
  `akun_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `akun_id` (`akun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_lain`
--

CREATE TABLE IF NOT EXISTS `transaksi_lain` (
  `id` int(11) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `akun_id` int(11) DEFAULT NULL,
  `jenis_transaksi` enum('debit','kredit') NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `terbilang` varchar(300) NOT NULL,
  KEY `akun_id` (`akun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_direktur` tinyint(1) NOT NULL DEFAULT '0',
  `is_manajer` tinyint(1) NOT NULL DEFAULT '0',
  `is_petugas` tinyint(1) NOT NULL DEFAULT '0',
  `login_trial` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rekaman`
--
ALTER TABLE `rekaman`
  ADD CONSTRAINT `rekaman_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siaran`
--
ALTER TABLE `siaran`
  ADD CONSTRAINT `siaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_lain`
--
ALTER TABLE `transaksi_lain`
  ADD CONSTRAINT `transaksi_lain_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
