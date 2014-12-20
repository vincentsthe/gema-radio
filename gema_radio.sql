-- MySQL dump 10.13  Distrib 5.6.11, for Win32 (x86)
--
-- Host: localhost    Database: gema_radio
-- ------------------------------------------------------
-- Server version	5.6.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akun`
--

DROP TABLE IF EXISTS `akun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `parent` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `kode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun`
--

LOCK TABLES `akun` WRITE;
/*!40000 ALTER TABLE `akun` DISABLE KEYS */;
INSERT INTO `akun` VALUES (1,'Transaksi',0,0,NULL),(3,'Aktiva',0,0,NULL),(5,'Aktiva Lancar',3,0,NULL),(6,'Kas',5,0,'111'),(7,'Bank',5,0,'112'),(8,'Piutang',5,0,'113'),(9,'Aktiva Tetap',3,0,NULL),(10,'Hibah',9,0,NULL),(11,'Saham',10,0,'1211'),(12,'Tanah',10,0,'1212'),(13,'Gedung',10,0,'1213'),(14,'Barang Kantor',10,0,'1214'),(15,'Barang Elektronik',10,0,'1215'),(16,'Pembelian',9,0,NULL),(17,'Saham BPR RASUNA',16,0,'1221'),(18,'Tanah',16,0,'1222'),(19,'Gedung',16,0,'1223'),(20,'Barang Kantor',16,0,'1224'),(21,'Barang Elektronik',16,0,'1225'),(22,'Akumulasi Penyusutan Aktiva Tetap',9,0,NULL),(23,'Saham BPR Rasuna',22,0,'1231'),(24,'Tanah',22,0,'1232'),(25,'Gedung',22,0,'1233'),(26,'Barang Kantor',22,0,'1234'),(27,'Barang Elektronik',22,0,'1235'),(28,'Pasiva',0,0,NULL),(29,'Pasiva Lancar',28,0,NULL),(30,'Hutang',29,0,'211'),(31,'Beban Segera Dibayar',29,0,'212'),(32,'Selisih Kas',29,0,'213'),(33,'Pendapatan yang masih akan diterima',29,0,'214'),(34,'Cadangan',28,0,NULL),(35,'Cadangan Umum',34,0,'221'),(36,'Cadangan Tujuan',34,0,'222'),(37,'Modal',0,0,NULL),(38,'Modal Disetor',37,0,'31'),(39,'Modal Tambahan',37,0,'32'),(40,'Modal Hibah',37,0,'33'),(41,'Pendapatan Usaha',0,5000,NULL),(42,'Iklan',41,0,'41'),(43,'Barang Kehilangan',41,0,'42'),(44,'Pengumuman',41,0,'43'),(45,'Hasil Rekaman',41,0,'44'),(46,'Non air',41,5000,NULL),(47,'Biaya Usaha',0,-7000,NULL),(48,'Produksi Siaran',47,0,NULL),(49,'Sumber Daya Manusia',47,-7000,NULL),(50,'Administrasi Umum',47,0,NULL),(51,'Humas dan Promosi',47,0,NULL),(63,'Kegiatan Off Air',46,5000,'451'),(64,'Penjualan Produk',46,0,'452'),(65,'Biaya Operasional Off Air',46,0,'453'),(66,'Produksi Acara',48,0,'511'),(67,'Tilphun',48,0,'512'),(68,'Listrik',48,0,'513'),(69,'Tehnik',48,0,'514'),(70,'Materi Berita/Musik',48,0,'515'),(71,'Gaji',49,0,'521'),(72,'Tunjangan Hari Tua',49,0,'522'),(73,'Tunjangan Pangan',49,0,'523'),(74,'Tunjangan Kesehatan',49,0,'524'),(75,'THR',49,0,'525'),(76,'Seragam',49,0,'526'),(77,'Tenaga Part Timer',49,-7000,'527'),(78,'Pesangon dan Penghargaan Purna Tugas',49,0,'528'),(79,'Alat Tulis/Kantor',50,0,'531'),(80,'Tilphun',50,0,'532'),(81,'PBB',50,0,'533'),(82,'Jamuan Kantor',50,0,'534'),(83,'Keperluan Gedung',50,0,'535'),(84,'Listrik Rumah Tangga',50,0,'536'),(85,'Bingkisan Lebaran',50,0,'537'),(86,'Transportasi',50,0,'538'),(87,'Perijinan, Orgssi PRSSNI',50,0,'539'),(88,'Bantuan Sosial',51,0,'541'),(89,'Duka Cita/Kematian',51,0,'542'),(90,'Pengajian Wih. Ummah',51,0,'543'),(91,'Marketing AMRI',51,0,'544'),(92,'Penerbitan / Spanduk dll',51,0,'545'),(93,'Lain lain / HUT RGS',51,0,'546');
/*!40000 ALTER TABLE `akun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekaman`
--

DROP TABLE IF EXISTS `rekaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rekaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time DEFAULT NULL,
  `checked` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  CONSTRAINT `rekaman_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekaman`
--

LOCK TABLES `rekaman` WRITE;
/*!40000 ALTER TABLE `rekaman` DISABLE KEYS */;
INSERT INTO `rekaman` VALUES (1,45,'2014-12-07','10:42:00',0),(2,54,'2014-12-08','08:51:00',0);
/*!40000 ALTER TABLE `rekaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siaran`
--

DROP TABLE IF EXISTS `siaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `transaksi_id` int(11) NOT NULL,
  `waktu` time DEFAULT NULL,
  `checked` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  CONSTRAINT `siaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2057 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siaran`
--

LOCK TABLES `siaran` WRITE;
/*!40000 ALTER TABLE `siaran` DISABLE KEYS */;
INSERT INTO `siaran` VALUES (1,'2014-10-01',2,'10:00:00',0),(2,'2014-10-02',1,'11:08:37',0),(3,'2014-11-03',2,'17:00:00',1),(4,'2014-10-12',6,'10:00:00',0),(5,'2014-10-12',6,'10:52:00',0),(6,'2014-10-12',8,'10:57:00',0),(7,'2014-10-12',8,'10:57:00',0),(8,'2014-10-12',9,'11:00:00',0),(9,'2014-11-03',9,'09:00:00',0),(22,'2014-11-03',10,'19:00:00',1),(23,'2014-11-03',10,'19:00:00',0),(24,'2014-11-03',10,'21:00:00',0),(25,'2014-11-03',11,'22:00:00',0),(26,'2014-11-03',11,'19:00:00',1),(1864,'2014-11-04',41,'14:54:00',0),(1865,'2014-11-04',41,'15:00:00',0),(1866,'2014-11-05',41,'14:54:00',0),(1867,'2014-11-05',41,'15:00:00',0),(1868,'2014-11-06',41,'14:54:00',0),(1869,'2014-11-06',41,'15:00:00',0),(2046,'2014-11-04',42,'21:00:00',0),(2047,'2014-11-04',42,'22:00:00',0),(2048,'2014-12-07',43,'10:21:00',0),(2049,'2014-12-08',46,'08:51:00',0),(2050,'2014-12-08',47,'08:51:00',0),(2051,'2014-12-08',48,'08:51:00',0),(2052,'2014-12-08',50,'08:51:00',0),(2053,'2014-12-08',51,'08:51:00',0),(2054,'2014-12-08',52,'08:51:00',0),(2055,'2014-12-08',53,'08:51:00',0),(2056,'2014-12-08',54,'08:51:00',0);
/*!40000 ALTER TABLE `siaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabungan_hari_tua`
--

DROP TABLE IF EXISTS `tabungan_hari_tua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabungan_hari_tua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `jenis_kegiatan` varchar(150) NOT NULL,
  `nominal` int(11) NOT NULL,
  `jenis_transaksi` enum('debit','kredit') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabungan_hari_tua`
--

LOCK TABLES `tabungan_hari_tua` WRITE;
/*!40000 ALTER TABLE `tabungan_hari_tua` DISABLE KEYS */;
INSERT INTO `tabungan_hari_tua` VALUES (1,'2014-10-18','Nabung',100000,'debit'),(2,'2014-10-20','Beli ini',30000,'kredit'),(3,'2014-10-16','nabung',10000,'debit'),(4,'2014-10-23','beli itu',10000,'kredit'),(5,'2014-10-18','nyoba nabung',50000,'debit');
/*!40000 ALTER TABLE `tabungan_hari_tua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` VALUES (1,'belum terkonfirmasi, taun 2010','2010-10-01',NULL,'PT XYZ',500000,'lima ratus ribu rupiah',1,1,'tes teks','',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(2,'Terkonfirmasi, tanggal 2016','2016-10-01',NULL,'PT ABC',500000,'lima ratus ribu rupiah',1,1,'tes teks','Iklan nasional',1,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(3,'belum terkonfirmasi, tahun 2016','2016-10-12',NULL,NULL,1000,'seribu rupiah',2,2,'lalala','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(4,'lalala','2014-10-12',NULL,NULL,1000,'seribu rupiah',2,2,'lalala','Iklan nasional',1,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(5,'lalala','2014-10-12',NULL,NULL,1000,'seribu rupiah',2,2,'lalala','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(6,'lalala','2014-10-12',NULL,NULL,1000,'seribu rupiah',2,2,'lalala','Iklan nasional',1,'2000-01-01','2000-01-01','siaran',NULL,'2014-12-07',NULL),(7,'lelelele','2014-10-12',NULL,NULL,2000,'dua ribu ripiah',2,2,'asdasdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(8,'lelelele','2014-10-12',NULL,NULL,2000,'dua ribu ripiah',0,2,'asdasdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(9,'lelelele','2014-10-12',NULL,NULL,2000,'dua ribu ripiah',2,2,'asdasdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(10,'lelelel','2014-10-13',NULL,NULL,1000,'seribu rupiah',4,3,'asdasdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(11,'lalala','2014-10-13',NULL,NULL,2000,'dua ribu rupiah',2,2,'ssdfsdf','Rekaman',1,'2000-01-01','2000-01-01','siaran',NULL,'2014-12-08',NULL),(12,'lalala','2014-10-20',NULL,NULL,5000,'lima ribu rupiah',2,2,'ssfsdf','Berita Kehilangan',0,'2014-10-19','2014-09-21','siaran',NULL,NULL,NULL),(13,'yang baru','2014-11-03',NULL,NULL,1000,'seribu rupiah',1,NULL,'asdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(14,'yang baru','2014-11-03',NULL,NULL,1000,'seribu rupiah',1,NULL,'asdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(16,'rekaman','2014-11-03',NULL,NULL,1000,'seribu rupiah',1,NULL,'asdadsa','Rekaman',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(17,'rekaman','2014-11-03',NULL,NULL,1000,'seribu3',1,NULL,'asdadsa','Rekaman',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(18,'rekaman2','2014-11-03',NULL,NULL,1000,'seribu rupiah',1,NULL,'adasda','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(38,'asfasd','2014-11-04',NULL,NULL,1000,'asdasasd',NULL,2,'asdasd','Berita Kehilangan',0,'2014-11-04','2014-11-05','periode',1,NULL,NULL),(39,'asfasd','2014-11-04',NULL,NULL,1000,'asdasasd',NULL,2,'asdasd','Berita Kehilangan',0,'2014-11-04','2014-11-05','periode',1,NULL,NULL),(40,'asfasd','2014-11-04',NULL,NULL,1000,'asdasasd',NULL,2,'asdasd','Berita Kehilangan',0,'2014-11-04','2014-11-05','periode',1,NULL,NULL),(41,'asdasd','2014-11-04',NULL,NULL,1000,'seribu rupiah',NULL,2,'asdasd','Berita Kehilangan',0,'2014-11-04','2014-11-06','periode',1,NULL,NULL),(42,'asdasd','2014-11-04',NULL,NULL,1000,'seribu rupiah3',NULL,2,'asdasd','Berita Kehilangan',0,'2014-11-04','2014-11-05','periode',2,NULL,NULL),(43,'asdasda','2014-12-08',NULL,NULL,5000,'lima ribu rupiah',1,NULL,'asdadasdasd','Berita Kehilangan',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(44,'asdasd','2014-12-08',NULL,NULL,123123,'sdfsdsdf',1,NULL,'asdadasd','Rekaman',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(45,'asdasd','2014-12-08',NULL,NULL,123123,'sdfsdsdf',1,NULL,'asdadasd','Rekaman',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,NULL),(46,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-26'),(47,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-27'),(48,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-28'),(49,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-29'),(50,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-30'),(51,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-31'),(52,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-32'),(53,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-33'),(54,'sdsdf','2014-12-08',323423,NULL,1000,'seribu rupiah',1,NULL,'sfdsdfsd','Iklan nasional',0,'2000-01-01','2000-01-01','siaran',NULL,NULL,'A22014/12/08-34');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_lain`
--

DROP TABLE IF EXISTS `transaksi_lain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi_lain` (
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
  KEY `akun_id` (`akun_id`),
  CONSTRAINT `transaksi_lain_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_lain`
--

LOCK TABLES `transaksi_lain` WRITE;
/*!40000 ALTER TABLE `transaksi_lain` DISABLE KEYS */;
INSERT INTO `transaksi_lain` VALUES (23,'Rekaman',41,'kredit','2014-10-13',2000,'dua ribu rupiah','','41-2014/10/13-1'),(24,'Rekaman',45,'debit','2014-10-13',2000,'dua ribu rupiah','','45-2014/10/13-2');
/*!40000 ALTER TABLE `transaksi_lain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'vincentsthe','db043b2055cb3a47b2eb0b5aebf4e114a8c24a5a','Vincent Sebastian The',1,0,0,1,3),(2,'admin','db043b2055cb3a47b2eb0b5aebf4e114a8c24a5a','admin',1,1,1,1,3);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-20 13:04:36
