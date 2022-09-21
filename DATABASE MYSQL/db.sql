/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - tabungan_lpd_kayubihi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tabungan_lpd_kayubihi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tabungan_lpd_kayubihi`;

/*Table structure for table `m_nasabah` */

DROP TABLE IF EXISTS `m_nasabah`;

CREATE TABLE `m_nasabah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nasabah` varchar(15) NOT NULL,
  `nama_nasabah` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_ktp` varchar(16) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  PRIMARY KEY (`id`,`id_nasabah`),
  KEY `m_nasabah_fk1` (`user_id`),
  CONSTRAINT `m_nasabah_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_nasabah` */

insert  into `m_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat`,`jenis_kelamin`,`telepon`,`pekerjaan`,`tanggal_lahir`,`no_ktp`,`user_id`,`tanggal_daftar`) values 
(1,'NS00001','Ni Nyoman Kari','Bangli','Perempuan','081999897123','Swasta','1998-01-01','01239131231223',1,'2022-09-21'),
(6,'NS00002','I Wayan Jana Antara','Bangli','Laki-Laki','081999897123','PNS','1990-01-20','01239131231223',6,'2022-09-20');

/*Table structure for table `m_pegawai` */

DROP TABLE IF EXISTS `m_pegawai`;

CREATE TABLE `m_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` varchar(15) NOT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_pegawai`),
  KEY `m_pegawai_fk1` (`user_id`),
  CONSTRAINT `m_pegawai_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_pegawai` */

/*Table structure for table `m_produk_tabungan` */

DROP TABLE IF EXISTS `m_produk_tabungan`;

CREATE TABLE `m_produk_tabungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` varchar(15) NOT NULL,
  `bunga` float DEFAULT NULL,
  `pemegang` varchar(50) DEFAULT NULL,
  `jenis_rekening` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_produk_tabungan` */

/*Table structure for table `m_tabungan` */

DROP TABLE IF EXISTS `m_tabungan`;

CREATE TABLE `m_tabungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_rekening` varchar(20) NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `saldo` float DEFAULT 0,
  PRIMARY KEY (`id`,`no_rekening`),
  KEY `m_tabungan_fk1` (`nasabah_id`),
  CONSTRAINT `m_tabungan_fk1` FOREIGN KEY (`nasabah_id`) REFERENCES `m_nasabah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_tabungan` */

insert  into `m_tabungan`(`id`,`no_rekening`,`nasabah_id`,`tanggal_daftar`,`saldo`) values 
(9,'2109202200001',1,'2022-09-21',0),
(10,'2109202200002',6,'2022-09-20',0);

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(15) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_user` */

insert  into `m_user`(`id`,`id_user`,`nama`,`alamat`,`jenis_kelamin`,`username`,`password`,`jabatan`) values 
(1,'U00001','Ni Nyoman Kari','Bangli','Perempuan','nasabah','$2y$10$43/EXZ8iN8duAzcXJtEaJO/wQFFhS7ZC.D2I/znpO9bq3CAE0c0y6','Nasabah'),
(2,'U00002','I Wayan Jana Antara','Bangli','Laki-Laki','antara','$2y$10$oRdsQCWZJzAdN6aczCQ7S.OZmIpBxpNoJcHSxgab3LMx4xsh8PSLi','Nasabah'),
(6,'U00003','I Wayan Jana Antara','Bangli','Laki-Laki','antara','$2y$10$/fr.6vIVqKFGhs0jePJ1L.ZevXC/CgP9Fxy8z/reQJuzwC9u9vBEy','Nasabah');

/*Table structure for table `t_simpan_tabungan` */

DROP TABLE IF EXISTS `t_simpan_tabungan`;

CREATE TABLE `t_simpan_tabungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jumlah_simpanan` float DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tabungan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_simpan_tabungan_fk1` (`user_id`),
  KEY `t_simpan_tabungan_fk2` (`tabungan_id`),
  CONSTRAINT `t_simpan_tabungan_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_simpan_tabungan_fk2` FOREIGN KEY (`tabungan_id`) REFERENCES `m_tabungan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `t_simpan_tabungan` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
