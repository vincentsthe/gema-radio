-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2015 at 02:48 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gema_radio`
--
CREATE DATABASE IF NOT EXISTS `gema_radio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gema_radio`;

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

DROP TABLE IF EXISTS `akun`;
CREATE TABLE IF NOT EXISTS `akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `parent` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `kode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `nama`, `parent`, `harga`, `kode`) VALUES
(1, 'Transaksi', 0, 0, NULL),
(3, 'Aktiva', 0, 1315000, NULL),
(5, 'Aktiva Lancar', 3, 1315000, NULL),
(6, 'Kas', 5, 1615000, '111'),
(7, 'Bank', 5, -200000, '112'),
(8, 'Piutang', 5, -100000, '113'),
(9, 'Aktiva Tetap', 3, 0, NULL),
(10, 'Hibah', 9, 0, NULL),
(11, 'Saham', 10, 0, '1211'),
(12, 'Tanah', 10, 0, '1212'),
(13, 'Gedung', 10, 0, '1213'),
(14, 'Barang Kantor', 10, 0, '1214'),
(15, 'Barang Elektronik', 10, 0, '1215'),
(16, 'Pembelian', 9, 0, NULL),
(17, 'Saham BPR RASUNA', 16, 0, '1221'),
(18, 'Tanah', 16, 0, '1222'),
(19, 'Gedung', 16, 0, '1223'),
(20, 'Barang Kantor', 16, 0, '1224'),
(21, 'Barang Elektronik', 16, 0, '1225'),
(22, 'Akumulasi Penyusutan Aktiva Tetap', 9, 0, NULL),
(23, 'Saham BPR Rasuna', 22, 0, '1231'),
(24, 'Tanah', 22, 0, '1232'),
(25, 'Gedung', 22, 0, '1233'),
(26, 'Barang Kantor', 22, 0, '1234'),
(27, 'Barang Elektronik', 22, 0, '1235'),
(28, 'Pasiva', 0, -100000, NULL),
(29, 'Pasiva Lancar', 28, -100000, NULL),
(30, 'Hutang', 29, -100000, '211'),
(31, 'Beban Segera Dibayar', 29, 0, '212'),
(32, 'Selisih Kas', 29, 0, '213'),
(33, 'Pendapatan yang masih akan diterima', 29, 0, '214'),
(34, 'Cadangan', 28, 0, NULL),
(35, 'Cadangan Umum', 34, 0, '221'),
(36, 'Cadangan Tujuan', 34, 0, '222'),
(37, 'Modal', 0, -750000, NULL),
(38, 'Modal Disetor', 37, 150000, '31'),
(39, 'Modal Tambahan', 37, -400000, '32'),
(40, 'Modal Hibah', 37, -500000, '33'),
(41, 'Pendapatan Usaha', 0, -475000, NULL),
(42, 'Iklan', 41, -250000, '41'),
(43, 'Barang Kehilangan', 41, -100000, '42'),
(44, 'Pengumuman', 41, -75000, '43'),
(45, 'Hasil Rekaman', 41, -50000, '44'),
(46, 'Non air', 41, 0, NULL),
(47, 'Biaya Usaha', 0, 10000, NULL),
(48, 'Produksi Siaran', 47, 0, NULL),
(49, 'Sumber Daya Manusia', 47, 0, NULL),
(50, 'Administrasi Umum', 47, 10000, NULL),
(51, 'Humas dan Promosi', 47, 0, NULL),
(63, 'Kegiatan Off Air', 46, 0, '451'),
(64, 'Penjualan Produk', 46, 0, '452'),
(65, 'Biaya Operasional Off Air', 46, 0, '453'),
(66, 'Produksi Acara', 48, 0, '511'),
(67, 'Tilphun', 48, 0, '512'),
(68, 'Listrik', 48, 0, '513'),
(69, 'Tehnik', 48, 0, '514'),
(70, 'Materi Berita/Musik', 48, 0, '515'),
(71, 'Gaji', 49, 0, '521'),
(72, 'Tunjangan Hari Tua', 49, 0, '522'),
(73, 'Tunjangan Pangan', 49, 0, '523'),
(74, 'Tunjangan Kesehatan', 49, 0, '524'),
(75, 'THR', 49, 0, '525'),
(76, 'Seragam', 49, 0, '526'),
(77, 'Tenaga Part Timer', 49, 0, '527'),
(78, 'Pesangon dan Penghargaan Purna Tugas', 49, 0, '528'),
(79, 'Alat Tulis/Kantor', 50, 10000, '531'),
(80, 'Tilphun', 50, 0, '532'),
(81, 'PBB', 50, 0, '533'),
(82, 'Jamuan Kantor', 50, 0, '534'),
(83, 'Keperluan Gedung', 50, 0, '535'),
(84, 'Listrik Rumah Tangga', 50, 0, '536'),
(85, 'Bingkisan Lebaran', 50, 0, '537'),
(86, 'Transportasi', 50, 0, '538'),
(87, 'Perijinan Orgssi PRSSNI', 50, 0, '539'),
(88, 'Bantuan Sosial', 51, 0, '541'),
(89, 'Duka Cita/Kematian', 51, 0, '542'),
(90, 'Pengajian Wih. Ummah', 51, 0, '543'),
(91, 'Marketing AMRI', 51, 0, '544'),
(92, 'Penerbitan / Spanduk dll', 51, 0, '545'),
(93, 'Lain lain / HUT RGS', 51, 0, '546');

-- --------------------------------------------------------

--
-- Table structure for table `rekaman`
--

DROP TABLE IF EXISTS `rekaman`;
CREATE TABLE IF NOT EXISTS `rekaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time DEFAULT NULL,
  `checked` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `siaran`
--

DROP TABLE IF EXISTS `siaran`;
CREATE TABLE IF NOT EXISTS `siaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `transaksi_id` int(11) NOT NULL,
  `waktu` time DEFAULT NULL,
  `checked` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabungan_hari_tua`
--

DROP TABLE IF EXISTS `tabungan_hari_tua`;
CREATE TABLE IF NOT EXISTS `tabungan_hari_tua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `jenis_kegiatan` varchar(150) NOT NULL,
  `nominal` int(11) NOT NULL,
  `jenis_transaksi` enum('debit','kredit') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tabungan_hari_tua`
--

INSERT INTO `tabungan_hari_tua` (`id`, `tanggal`, `jenis_kegiatan`, `nominal`, `jenis_transaksi`) VALUES
(1, '2014-10-18', 'Nabung', 100000, 'debit'),
(2, '2014-10-20', 'Beli ini', 30000, 'kredit'),
(3, '2014-10-16', 'nabung', 10000, 'debit'),
(4, '2014-10-23', 'beli itu', 10000, 'kredit'),
(5, '2014-10-18', 'nyoba nabung', 50000, 'debit'),
(6, '2014-12-23', 'Hibah dari Donatur', 500000, 'debit'),
(7, '2014-12-23', 'Hibah dari Donatur', 500000, 'debit'),
(8, '2014-12-23', 'Hibah dari Donatur 2', 500000, 'debit');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `no_order` int(11) DEFAULT NULL,
  `produk` varchar(100) DEFAULT NULL,
  `nominal` int(11) NOT NULL,
  `terbilang` varchar(300) NOT NULL,
  `jumlah_siaran` int(11) DEFAULT NULL,
  `siaran_per_hari` int(11) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `jenis_transaksi` enum('Berita Kehilangan','Iklan nasional','Iklan lokal','Rekaman','Pengumuman') NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `periode_awal` date DEFAULT '2000-01-01',
  `periode_akhir` date DEFAULT '2000-01-01',
  `jenis_periode` enum('siaran','periode') DEFAULT 'siaran',
  `frekuensi` int(11) DEFAULT NULL,
  `date_confirmed` date DEFAULT NULL,
  `nomor` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_lain`
--

DROP TABLE IF EXISTS `transaksi_lain`;
CREATE TABLE IF NOT EXISTS `transaksi_lain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan` varchar(100) NOT NULL,
  `akun_id` int(11) DEFAULT NULL,
  `jenis_transaksi` enum('debit','kredit') NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `terbilang` varchar(300) NOT NULL,
  `deskripsi` varchar(256) DEFAULT NULL,
  `nomor` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `akun_id` (`akun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `transaksi_lain`
--

INSERT INTO `transaksi_lain` (`id`, `kegiatan`, `akun_id`, `jenis_transaksi`, `tanggal`, `nominal`, `terbilang`, `deskripsi`, `nomor`) VALUES
(31, 'iklan', 6, 'debit', '2014-12-25', 250000, 'dua ratus lima puluh ribu', 'iklan masuk', '6-2014/12/25-1'),
(32, 'iklan', 42, 'kredit', '2014-12-25', 250000, 'dua ratus lima puluh ribu', 'pendapatan masuk', '42-2014/12/25-2'),
(33, 'berita kehilangan', 6, 'debit', '2014-12-25', 100000, 'seratus ribu', 'uang masuk', '6-2014/12/25-3'),
(34, 'berita kehilangan', 43, 'kredit', '2014-12-25', 100000, 'seratus ribu', 'pendapatan masuk', '43-2014/12/25-4'),
(35, 'kas', 6, 'debit', '2014-12-25', 50000, 'lima puluh ribu', 'uang masuk', '6-2014/12/25-5'),
(36, 'rekaman', 45, 'kredit', '2014-12-25', 50000, 'lima puluh ribu', 'pendapatan masuk', '45-2014/12/25-6'),
(37, 'pengumuman', 6, 'debit', '2014-12-25', 75000, 'tujuh puluh lima ribu rupiah', 'uang masuk', '6-2014/12/25-7'),
(38, 'pengumuman', 44, 'kredit', '2014-12-25', 75000, 'tujuh puluh lima ribu rupiah', 'pendapatan masuk', '44-2015/12/25-1'),
(39, 'beli alat tulis', 6, 'kredit', '2014-12-25', 10000, 'sepuluh ribu', 'uang keluar', '6-2014/12/25-9'),
(40, 'beli alat tulis', 79, 'debit', '2014-12-25', 10000, 'sepuluh ribu', 'akun alat tulis/kantor nambah', '79-2014/12/25-10'),
(41, 'berhutang', 6, 'debit', '2014-12-25', 300000, 'tiga ratus ribu', 'uang masuk dari ngutang', '6-2014/12/25-11'),
(42, 'berhutang', 30, 'kredit', '2014-12-25', 300000, 'tiga ratus ribu', 'akun hutang nambah', '30-2014/12/25-12'),
(43, 'bayar hutang', 7, 'kredit', '2014-12-25', 200000, 'dua ratus ribu', 'uang keluar', '7-2014/12/25-13'),
(44, 'bayar hutang', 30, 'debit', '2014-12-25', 200000, 'dua ratus ribu', 'nilai hutang berkurang', '30-2014/12/25-14'),
(45, 'piutang dibayar', 6, 'debit', '2014-12-25', 100000, 'seratus ribu', 'uang masuk', '6-2014/12/25-15'),
(46, 'piutang dibayar', 8, 'kredit', '2014-12-25', 100000, 'sepuluh ribu', 'akun piutang berkurang', '8-2014/12/25-16'),
(47, 'modal diambil', 6, 'kredit', '2014-12-25', 150000, 'seratus lima puluh ribu', 'uang keluar', '6-2014/12/25-17'),
(48, 'modal diambil', 38, 'debit', '2014-12-25', 150000, 'seratus lima puluh ribu', 'modal berkurang', '38-2014/12/25-18'),
(49, 'nambah modal', 6, 'debit', '2014-12-25', 400000, 'empat ratus ribu', 'uang masuk', '6-2014/12/25-19'),
(50, 'nambah modal', 39, 'kredit', '2014-12-25', 400000, 'empat ratus ribu', 'modal nambah', '39-2014/12/25-20'),
(51, 'saldo awal', 6, 'debit', '2014-01-01', 500000, 'lima ratus ribu', 'saldo awal', '6-2014/01/01-21'),
(52, 'saldo awal', 40, 'kredit', '2014-01-01', 500000, 'lima ratus ribu', 'saldo awal\r\n', '40-2014/01/01-22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `is_admin`, `is_direktur`, `is_manajer`, `is_petugas`, `login_trial`) VALUES
(1, 'vincentsthe', 'db043b2055cb3a47b2eb0b5aebf4e114a8c24a5a', 'Vincent Sebastian The', 1, 0, 0, 1, 3),
(2, 'admin', 'db043b2055cb3a47b2eb0b5aebf4e114a8c24a5a', 'admin', 1, 1, 1, 1, 3),
(5, 'manajer', 'a13fb40490e7d01a1a6ad6da8dab0fd4daff6d0d', 'manajer', 0, 0, 1, 0, 3),
(6, 'direktur', 'ef55c764d670377f3b24cf6d065252f06ee031c5', 'direktur', 0, 1, 0, 0, 3),
(7, 'petugas', '670489f94b6997a870b148f74744ee5676304925', 'petugas', 0, 0, 0, 1, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rekaman`
--
ALTER TABLE `rekaman`
  ADD CONSTRAINT `rekaman_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `siaran`
--
ALTER TABLE `siaran`
  ADD CONSTRAINT `siaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_lain`
--
ALTER TABLE `transaksi_lain`
  ADD CONSTRAINT `transaksi_lain_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
