-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2016 at 04:48 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

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
-- Table structure for table `jdih_hit`
--

CREATE TABLE IF NOT EXISTS `jdih_hit` (
`id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tipe` int(5) DEFAULT NULL COMMENT '1:produk;2:berita;3:referensi',
  `tanggal` date DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `jdih_hit`
--

INSERT INTO `jdih_hit` (`id`, `parent_id`, `tipe`, `tanggal`, `jumlah`) VALUES
(1, 3, 1, '2016-06-23', 1),
(2, 3, 1, '2016-06-23', 1),
(3, 3, 1, '2016-06-23', 1),
(4, 3, 1, '2016-06-23', 1),
(5, 3, 1, '2016-06-23', 1),
(6, 3, 1, '2016-06-23', 1),
(7, 3, 1, '2016-06-23', 1),
(8, 3, 1, '2016-06-23', 1),
(9, 3, 1, '2016-06-23', 1),
(10, 2, 1, '2016-06-23', 1),
(11, 3, 1, '2016-06-23', 1),
(12, 3, 1, '2016-06-23', 1),
(13, 2, 1, '2016-06-23', 1),
(14, 1, 1, '2016-06-23', 1),
(15, 1, 1, '2016-06-23', 1),
(16, 3, 1, '2016-06-23', 1),
(17, 2, 1, '2016-06-23', 1),
(18, 1, 1, '2016-06-23', 1),
(19, 3, 2, '2016-06-23', 1),
(20, 3, 2, '2016-06-23', 1),
(21, 3, 1, '2016-06-23', 1),
(22, 3, 1, '2016-06-23', 1),
(23, 3, 1, '2016-06-23', 1),
(24, 3, 1, '2016-06-23', 1),
(25, 3, 1, '2016-06-23', 1),
(26, 3, 1, '2016-06-23', 1),
(27, 3, 1, '2016-06-23', 1),
(28, 3, 1, '2016-06-23', 1),
(29, 3, 2, '2016-06-23', 1),
(30, 2, 1, '2016-06-23', 1),
(31, 3, 2, '2016-06-23', 1),
(32, 3, 2, '2016-06-23', 1),
(33, 3, 2, '2016-06-23', 1),
(34, 3, 2, '2016-06-23', 1),
(35, 3, 2, '2016-06-23', 1),
(36, 3, 2, '2016-06-23', 1),
(37, 3, 2, '2016-06-23', 1),
(38, 3, 2, '2016-06-23', 1),
(39, 3, 2, '2016-06-23', 1),
(40, 3, 2, '2016-06-23', 1),
(41, 3, 2, '2016-06-23', 1),
(42, 3, 2, '2016-06-23', 1),
(43, 3, 2, '2016-06-23', 1),
(44, 3, 2, '2016-06-23', 1),
(45, 3, 2, '2016-06-23', 1),
(46, 2, 2, '2016-06-23', 1),
(47, 2, 2, '2016-06-23', 1),
(48, 3, 2, '2016-06-23', 1),
(49, 3, 1, '2016-06-23', 1),
(50, 2, 1, '2016-06-23', 1),
(51, 3, 2, '2016-06-23', 1),
(52, 3, 1, '2016-06-24', 1),
(53, 4, 2, '2016-06-23', 1),
(54, 4, 1, '2016-06-23', 1),
(55, 4, 1, '2016-06-23', 1),
(56, 4, 1, '2016-06-23', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jdih_hit`
--
ALTER TABLE `jdih_hit`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jdih_hit`
--
ALTER TABLE `jdih_hit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
