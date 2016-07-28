/*
 Navicat Premium Data Transfer

 Source Server         : MySql
 Source Server Type    : MySQL
 Source Server Version : 50713
 Source Host           : localhost
 Source Database       : db_jdih

 Target Server Type    : MySQL
 Target Server Version : 50713
 File Encoding         : utf-8

 Date: 07/28/2016 22:08:43 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `jdih_produk`
-- ----------------------------
DROP TABLE IF EXISTS `jdih_produk`;
CREATE TABLE `jdih_produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `judul` varchar(250) DEFAULT NULL,
  `nomor` varchar(100) DEFAULT NULL,
  `tahun` int(4) DEFAULT NULL,
  `subjenis` varchar(150) DEFAULT NULL,
  `subsub` varchar(150) DEFAULT NULL,
  `tentang` varchar(250) DEFAULT NULL,
  `deskripsi` text,
  `file` varchar(250) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `cover` varchar(250) DEFAULT NULL,
  `status_akhir` varchar(50) DEFAULT NULL,
  `posisi` tinyint(1) DEFAULT NULL COMMENT '1:headline;2:alur',
  `publish` tinyint(1) DEFAULT NULL COMMENT '1:publish;2:non-publish',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `jdih_produk`
-- ----------------------------
BEGIN;
INSERT INTO `jdih_produk` VALUES ('1', '2016-04-27', '2', 'Judul produk hukum', 'nomor produk hukum', '2016', null, null, 'Tentang produk hukum', '&amp;lt;p&amp;gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus hic dolor eaque quidem animi ullam quod veritatis magnam laborum, omnis quia placeat, aperiam voluptatibus, et! Praesentium cum iure quae voluptate ut? Praesentium id accusamus a fuga, quas quae non iusto, aspernatur saepe! Esse ratione eum suscipit, voluptatum omnis placeat vel.&amp;lt;/p&amp;gt;\r\n', 'file/3d91b5c02751a454ab3242b3e29f73aa.pdf', '103-281-1-PB.pdf', null, 'Rancangan', '1', '1', '2016-04-21 19:47:47', '1'), ('2', '2016-04-11', '3', 'Tax Airport [update]', 'nomor produk hukum [update]', '2016', null, null, 'Tentang produk hukum [update]', '&amp;lt;p&amp;gt;Asdasd asdasdas update&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n', 'file/ea0b60a77852b27c4b0d6547750c35ed.pdf', '04 STRUKTUR PERULANGAN.pdf', null, 'Perubahan', '1', '1', '2016-06-21 09:51:28', '1'), ('3', '2016-06-19', '1', 'judul', '1', '2016', null, null, 'tentang', '&amp;lt;p&amp;gt;deskripsi singkat&amp;lt;/p&amp;gt;\r\n', 'file/d4e6dab0ad9a5141fae0dd71e11f65ca.pdf', 'USB.pdf', null, 'Berlaku', '1', '1', '2016-06-21 09:51:32', '1'), ('4', '2016-06-25', '1', 'coba perpres', 'x111', '2016', null, null, '', '&amp;lt;p&amp;gt;&amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Peraturan_Perundang-undangan_di_Indonesia&amp;quot;&amp;gt;Peraturan Perundang-undangan&amp;lt;/a&amp;gt; yang dibentuk oleh &amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Dewan_Perwakilan_Rakyat_Daerah&amp;quot;&amp;gt;Dewan Perwakilan Rakyat Daerah&amp;lt;/a&amp;gt; dengan persetujuan bersama Kepala Daerah (&amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Gubernur&amp;quot;&amp;gt;gubernur&amp;lt;/a&amp;gt; atau &amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Bupati&amp;quot;&amp;gt;bupati&amp;lt;/a&amp;gt;/&amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Wali_kota&amp;quot;&amp;gt;wali kota&amp;lt;/a&amp;gt;). Peraturan Daerah terdiri atas: Peraturan Daerah Provinsi dan Peraturan Daerah Kabupaten/Kuota Xl . Di Provinsi &amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Aceh&amp;quot;&amp;gt;Aceh&amp;lt;/a&amp;gt;, Peraturan Daerah dikenal dengan istilah &amp;lt;em&amp;gt;&amp;lt;a href=&amp;quot;https://id.wikipedia.org/wiki/Qanun&amp;quot;&amp;gt;Qanun&amp;lt;/a&amp;gt;&amp;lt;/em&amp;gt;.&amp;lt;/p&amp;gt;\r\n', 'file/80a104a5139081a78895dca658bb44ec.pdf', '66MP9B_payment.pdf', null, 'Rancangan', '1', '1', '2016-06-23 12:26:33', '1'), ('6', '2016-07-19', '4', 'Ini Alasan Pemerintah Salurkan Raskin Lewat Voucher', '12', '2016', null, null, null, '&amp;lt;p&amp;gt;Jakarta -Pemerintah ingin mengubah pola penyaluran beras untuk masyarakat miskin (raskin) tahun depan, yaitu dengan penggunaan electronic voucher (e-voucher). Ada beberapa alasan pemerintah mengambil kebijakan tersebut.&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\nBambang Widianto, Sekretaris Eksekutif Tim Nasional Percepatan dan Penanggulangan Kemiskinan menjelaskan, alasan pertama penyaluran raskin selama ini tidak tepat jumlah.&amp;lt;/p&amp;gt;\r\n', 'file/', '', 'file/', 'Rancangan', '2', '1', '2016-07-19 20:34:31', '1'), ('7', '2016-07-27', '4', '123asda', '123/131/121', '2016', '', '', '', '&amp;lt;p&amp;gt;acasdasd&amp;lt;/p&amp;gt;\r\n', 'file/', '', 'file/', 'Rancangan', '2', '2', '2016-07-27 21:57:44', '1'), ('8', '2016-07-28', '10', 'judul', '1231231', '2016', 'Standar Nasional Indonesia', 'Penetapan Revisi', null, '&amp;lt;p&amp;gt;asdasd&amp;lt;/p&amp;gt;\r\n', 'file/', '', 'file/', 'Rancangan', '1', '2', '2016-07-28 21:28:22', '1'), ('10', '2016-07-27', '7', 'judulasa', 'asda232', '2016', null, null, null, '&amp;lt;p&amp;gt;asdasda&amp;lt;/p&amp;gt;\r\n', 'file/', '', 'file/', 'Berlaku', '2', '2', '2016-07-28 21:31:33', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
