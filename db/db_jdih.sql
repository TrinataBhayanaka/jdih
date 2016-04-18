-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2016 at 11:37 AM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_jdih`
--

-- --------------------------------------------------------

--
-- Table structure for table `bsn_users`
--

CREATE TABLE IF NOT EXISTS `bsn_users` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `projectList` text,
  `nik` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jenis_kelamin` tinyint(1) DEFAULT NULL,
  `tempat_lahir` tinytext,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `institusi` tinytext,
  `jenis_pekerjaan` varchar(255) DEFAULT NULL,
  `hp` tinytext,
  `alamat` text,
  `other_data` text,
  `type` int(11) DEFAULT NULL COMMENT '1:admin,2:user',
  `salt` varchar(200) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `email_token` varchar(255) DEFAULT NULL,
  `is_online` int(11) NOT NULL DEFAULT '0',
  `n_status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bsn_users`
--

INSERT INTO `bsn_users` (`id`, `projectList`, `nik`, `name`, `username`, `email`, `password`, `register_date`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `pendidikan`, `institusi`, `jenis_pekerjaan`, `hp`, `alamat`, `other_data`, `type`, `salt`, `login_count`, `email_token`, `is_online`, `n_status`) VALUES
(1, NULL, NULL, 'admin', 'admin', 'admin@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2016-01-11 14:19:28', 0, 'Jakarta', '1989-09-08', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 1),
(4, '', NULL, 'Andreass Bayu', 'andreassbayu', 'andreass.bayu@gmail.com', '8e7ade691e55def6d2984a2272a0fb9e75b8c7bc', '2016-01-15 00:53:26', NULL, NULL, NULL, 'S2', 'Gunadarma', 'Information Management', NULL, NULL, NULL, 3, '1234567890', 0, NULL, 0, 1),
(5, '1,2,3', NULL, 'Verra Theresia', 'veynicks', 'verra@gmail.com', 'fdb9f5f5d30065406c0635eba10fc07257c0bfdc', '2016-01-16 14:25:59', NULL, 'Cirebon', '1989-11-20', NULL, 'Fransiskus II', 'Perbankan', NULL, NULL, NULL, 2, '1234567890', 0, NULL, 0, 1),
(6, NULL, NULL, 'yuki', 'yuki', 'yuki@gmail.com', '4b738cccae22c51d2e1db5b98d8ebcef14d4c624', '2016-01-16 16:25:53', NULL, NULL, NULL, 'S1', 'Bina Nusantara', 'Manager', NULL, NULL, NULL, 2, '1234567890', 0, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ck_activity_log`
--

CREATE TABLE IF NOT EXISTS `ck_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `activity_desc` varchar(250) NOT NULL,
  `source` varchar(20) NOT NULL,
  `datetimes` datetime NOT NULL,
  `n_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ck_admin_member`
--

CREATE TABLE IF NOT EXISTS `ck_admin_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(46) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `menu_akses` varchar(300) DEFAULT NULL,
  `username` varchar(46) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1:admin, 2:verifikator, 3:evaluator, 4: balai',
  `salt` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `n_status` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ck_admin_member`
--

INSERT INTO `ck_admin_member` (`id`, `name`, `nickname`, `email`, `register_date`, `menu_akses`, `username`, `type`, `salt`, `password`, `n_status`) VALUES
(1, 'admin', 'admin', 'admin@example.com', '2014-08-07 15:56:36', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'admin', 1, 'codekir v3.0', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jdih_jenis`
--

CREATE TABLE IF NOT EXISTS `jdih_jenis` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(250) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `jdih_jenis`
--

INSERT INTO `jdih_jenis` (`id_jenis`, `nama`, `create_date`, `n_status`) VALUES
(1, 'UUD NRI Tahun 1945', '2016-04-12 04:18:40', 1),
(2, 'Undang-undang', '2016-04-12 04:18:40', 1),
(3, 'Perpu', '2016-04-12 04:20:33', 1),
(4, 'Peraturan Pemerintah (PP)', '2016-04-12 04:20:33', 1),
(5, 'Peraturan Presiden (perpres)', '2016-04-12 04:20:33', 1),
(6, 'Keputusan Presiden (Keppres)', '2016-04-12 04:20:33', 1),
(7, 'Instruksi Presiden (Inpres)', '2016-04-12 04:20:33', 1),
(8, 'Pemberlakuan Wajib SNI', '2016-04-12 04:21:42', 1),
(9, 'Peraturan Kepala BSN', '2016-04-12 04:21:42', 1),
(10, 'Keputusan Kepala BSN', '2016-04-12 04:21:42', 1),
(11, 'Surat Edaran Kepala BSN', '2016-04-12 04:21:42', 1),
(12, 'Rancangan', '2016-04-12 04:21:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jdih_produk`
--

CREATE TABLE IF NOT EXISTS `jdih_produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `judul` varchar(250) DEFAULT NULL,
  `nomor` varchar(100) DEFAULT NULL,
  `tahun` int(4) DEFAULT NULL,
  `tentang` varchar(250) DEFAULT NULL,
  `deskripsi` text,
  `file` varchar(250) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `status_akhir` varchar(50) DEFAULT NULL,
  `posisi` tinyint(1) DEFAULT NULL COMMENT '1:headline;2:alur',
  `publish` tinyint(1) DEFAULT NULL COMMENT '1:publish;2:non-publish',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jdih_produk`
--

INSERT INTO `jdih_produk` (`id_produk`, `tanggal`, `id_jenis`, `judul`, `nomor`, `tahun`, `tentang`, `deskripsi`, `file`, `file_name`, `status_akhir`, `posisi`, `publish`, `create_date`, `n_status`) VALUES
(1, '2016-04-27', 1, 'Judul produk hukum', 'nomor produk hukum', 2016, 'Tentang produk hukum', '&amp;lt;p&amp;gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel.&amp;lt;/p&amp;gt;\r\n', 'file/490c1b5aebdc7d532f811dfc6bf8fb36.pdf', 'Alur JDIH BSN.pdf', 'Rancangan', 1, 1, '2016-04-12 06:33:08', 1),
(2, '2016-04-11', 3, 'Tax Airport [update]', 'nomor produk hukum [update]', 2016, 'Tentang produk hukum [update]', '&amp;lt;p&amp;gt;Asdasd asdasdas update&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n', 'file/950c07628f242b6ed08e9f9f7337c50a.pdf', 'Alur JDIH BSN.pdf', 'Perubahan', 1, 2, '2016-04-18 04:23:56', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
