-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2016 at 09:49 AM
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
-- Table structure for table `jdih_konten`
--

CREATE TABLE IF NOT EXISTS `jdih_konten` (
  `id_kontent` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT NULL COMMENT '1:prasyarat;2:about',
  `title` varchar(150) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id_kontent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jdih_konten`
--

INSERT INTO `jdih_konten` (`id_kontent`, `type`, `title`, `content`) VALUES
(1, 1, 'Prasyarat Penggunaan Website JDIH BSN', '<p><strong>Prasyarat</strong></p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel. Iusto harum est illum consequatur sint accusamus illo error beatae sit officiis quidem eius aliquid hic quisquam minima ducimus fugiat, qui nihil quis amet. Nemo unde accusantium ipsam inventore repudiandae excepturi molestias sapiente amet officia laboriosam facilis consectetur blanditiis, aut, cumque temporibus, quam beatae. Alias qui sint, numquam accusantium necessitatibus! Nostrum nesciunt possimus rem dolorem, sapiente vero placeat, quaerat dolore voluptate esse nisi eveniet suscipit iure magnam illum ullam pariatur fugiat repellendus sunt, blanditiis recusandae assumenda quisquam! Doloremque provident laboriosam numquam fuga, asperiores, expedita nesciunt vero, hic voluptatum laborum cumque modi aut nemo deserunt ratione sequi iste. Nobis, quis, error. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel. Iusto harum est illum consequatur sint accusamus illo error beatae sit officiis quidem eius aliquid hic quisquam minima ducimus fugiat, qui nihil quis amet. Nemo unde accusantium ipsam inventore repudiandae excepturi molestias sapiente amet officia laboriosam facilis consectetur blanditiis, aut, cumque temporibus, quam beatae. Alias qui sint, numquam accusantium necessitatibus! Nostrum nesciunt possimus rem dolorem, sapiente vero placeat, quaerat dolore voluptate esse nisi eveniet suscipit iure magnam illum ullam pariatur fugiat repellendus sunt, blanditiis recusandae assumenda quisquam! Doloremque provident laboriosam numquam fuga, asperiores, expedita nesciunt vero, hic voluptatum laborum cumque modi aut nemo deserunt ratione sequi iste. Nobis, quis, error.</p>\r\n'),
(2, 2, 'Tentang JDIH BSN', '<p>Tentang JDIH</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/jdih/admin/plugins/kcfinder/upload/images/Logo_Gundar.png" style="height:99px; width:100px" /></p>\r\n\r\n<p>Sejarah JDIH Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel. Iusto harum est illum consequatur sint accusamus illo error beatae sit officiis quidem eius aliquid hic quisquam minima ducimus fugiat, qui nihil quis amet. Nemo unde accusantium ipsam inventore repudiandae excepturi molestias sapiente amet officia laboriosam facilis consectetur blanditiis, aut, cumque temporibus, quam beatae. Alias qui sint, numquam accusantium necessitatibus! Nostrum nesciunt possimus rem dolorem, sapiente vero placeat, quaerat dolore voluptate esse nisi eveniet suscipit iure magnam illum ullam pariatur fugiat repellendus sunt, blanditiis recusandae assumenda quisquam! Doloremque provident laboriosam numquam fuga, asperiores, expedita nesciunt vero, hic voluptatum laborum cumque modi aut nemo deserunt ratione sequi iste. Nobis, quis, error. Tentang Kami Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel. Iusto harum est illum consequatur sint accusamus illo error beatae sit officiis quidem eius aliquid hic quisquam minima ducimus fugiat, qui nihil quis amet. Nemo unde accusantium ipsam inventore repudiandae excepturi molestias sapiente amet officia laboriosam facilis consectetur blanditiis, aut, cumque temporibus, quam beatae. Alias qui sint, numquam accusantium necessitatibus! Nostrum nesciunt possimus rem dolorem, sapiente vero placeat, quaerat dolore voluptate esse nisi eveniet suscipit iure magnam illum ullam pariatur fugiat repellendus sunt, blanditiis recusandae assumenda quisquam! Doloremque provident laboriosam numquam fuga, asperiores, expedita nesciunt vero, hic voluptatum laborum cumque modi aut nemo deserunt ratione sequi iste. Nobis, quis, error.</p>\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
