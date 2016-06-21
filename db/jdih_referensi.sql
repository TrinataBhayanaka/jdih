-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2016 at 04:05 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jdih`
--

-- --------------------------------------------------------

--
-- Table structure for table `jdih_referensi`
--

CREATE TABLE IF NOT EXISTS `jdih_referensi` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(250) DEFAULT NULL,
  `pengarang` varchar(250) DEFAULT NULL,
  `kode_panggil` varchar(250) DEFAULT NULL,
  `resensi` varchar(250) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT NULL COMMENT '1:publish;2:non-publish',
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_ref`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jdih_referensi`
--

INSERT INTO `jdih_referensi` (`id_ref`, `judul`, `pengarang`, `kode_panggil`, `resensi`, `tanggal`, `file`, `cover`, `file_name`, `publish`, `create_date`, `n_status`) VALUES
(1, 'ref25', 'ref25', '123', '234', '2018-01-04', 'ref/92d2501c375d973b9c1c35b64fca6c7e.jpg', NULL, 'IMG_20151218_134646.jpg', 2, '2016-04-25 02:02:15', 1),
(2, 'referensi26', 'referensi26', '2345', '3456', '2018-01-04', 'file/8f8a4bf55d05ce795da2a184f1327b8c.jpg', NULL, 'IMG_20151218_134646.jpg', 1, '2016-04-25 03:25:39', 1),
(3, 'ref26', 'ref26', '567', '789', '2018-02-04', 'file/adcd2c282302f0e5721c2b22f1d06e73.pdf', NULL, 'Chapter 2 SOFTWARE-DEVELOPMENT LIFE-CYCLE MODELS.pdf', 0, '2016-04-25 08:45:14', 2),
(4, 'ref26', 'referensi25', '2345', '3458', '2018-02-04', 'file/aedf245fa80cfaa638c712b120116984.pdf', NULL, 'CVPebi.docx (2).pdf', 2, '2016-06-18 02:51:14', 1),
(5, 'test21juni', 'test', '12', 'test,test,test', '2017-09-06', 'file/4a639d46d8202e21d08685bca92fb307.jpg', NULL, 'Desert.jpg', 2, '2016-06-21 12:21:02', 1),
(6, 'test22', '22', '22', '''test''', '2017-10-06', 'file/58bb2f8867bf33cb511c6c5f750d8474.jpg', NULL, 'Hydrangeas.jpg', 2, '2016-06-21 12:31:42', 1),
(7, 'test20', 'test', '20', 'test,test''test', '2017-08-06', 'ref/3118f0e923f681cf628a18445d57cb52.jpg', 'ref/3118f0e923f681cf628a18445d57cb52.jpg', 'Desert.jpg', 1, '2016-06-21 12:58:34', 1),
(9, 'test19', 'test', '19', 'test', '2017-07-06', 'ref/8fa06fe4f59f7aedd71b76d2ba373cdb.jpg', 'ref/4ca93ead75c5e2f33ba40c7cb34e88c4.jpg', 'Penguins.jpg', 1, '2016-06-21 13:02:32', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
