/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - db_sipakes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_sipakes` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_sipakes`;

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `key` varchar(50) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `config` */

insert  into `config`(`key`,`value`) values 
('tahun_ajaran','2020/2021');

/*Table structure for table `tb_biaya` */

DROP TABLE IF EXISTS `tb_biaya`;

CREATE TABLE `tb_biaya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kk` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `angkatan` varchar(50) DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_biaya` */

insert  into `tb_biaya`(`id`,`id_kk`,`id_kelas`,`angkatan`,`nominal`) values 
(1,1,1,'2016',200000),
(2,2,1,'2016',30000);

/*Table structure for table `tb_jabatan` */

DROP TABLE IF EXISTS `tb_jabatan`;

CREATE TABLE `tb_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(50) DEFAULT NULL,
  `status_jabatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jabatan` */

insert  into `tb_jabatan`(`id`,`jabatan`,`status_jabatan`) values 
(1,'Kepala Sekolah','Aktif'),
(2,'Bendahara','Aktif'),
(3,'Komite Sekolah','Aktif'),
(5,'Ketua Yayasan','Aktif');

/*Table structure for table `tb_kategori_keuangan` */

DROP TABLE IF EXISTS `tb_kategori_keuangan`;

CREATE TABLE `tb_kategori_keuangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_akun` varchar(20) NOT NULL,
  `nama_kk` varchar(50) DEFAULT NULL,
  `jenis_kk` varchar(50) DEFAULT NULL,
  `status_kk` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`no_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kategori_keuangan` */

insert  into `tb_kategori_keuangan`(`id`,`no_akun`,`nama_kk`,`jenis_kk`,`status_kk`) values 
(1,'501','Pembayaran SPP','Pembayaran','Aktif'),
(2,'502','Pembayaran Gedung','Pembayaran','Aktif'),
(3,'601','Pengeluaran Lainnya','Pengeluaran','Aktif'),
(4,'504','Pemasukan Lainnya','Pemasukan','Aktif'),
(5,'503','Pembayaran Administrasi','Pembayaran','Aktif');

/*Table structure for table `tb_kelas` */

DROP TABLE IF EXISTS `tb_kelas`;

CREATE TABLE `tb_kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(10) DEFAULT NULL,
  `tingkat_kelas` varchar(20) DEFAULT NULL,
  `status_kelas` varchar(50) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `jurusan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kelas` */

insert  into `tb_kelas`(`id`,`kode_kelas`,`tingkat_kelas`,`status_kelas`,`nik`,`jurusan`) values 
(1,'KLS001','Kelas III','Aktif','01898999222345','RPL'),
(2,'KLS002','Kelas II','Aktif','01898999222334','TI');

/*Table structure for table `tb_keuangan` */

DROP TABLE IF EXISTS `tb_keuangan`;

CREATE TABLE `tb_keuangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(10) DEFAULT NULL,
  `id_user` int(20) DEFAULT NULL,
  `sumber_dana` varchar(20) DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `batal` tinyint(4) DEFAULT 0,
  `id_kk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_keuangan` */

insert  into `tb_keuangan`(`id`,`no_transaksi`,`id_user`,`sumber_dana`,`nominal`,`tanggal`,`keterangan`,`batal`,`id_kk`) values 
(1,'PNL001',2,'Kas Kecil Sekolah',35000,'2021-03-26','Pengeluaran Rutin',0,3),
(2,'PNL002',3,'BOS',11000,'2021-04-29','-',0,3),
(3,'PMK001',3,'-',1500000,'2021-04-29','-',0,4);

/*Table structure for table `tb_keuangan_detail` */

DROP TABLE IF EXISTS `tb_keuangan_detail`;

CREATE TABLE `tb_keuangan_detail` (
  `id_keuangan` int(11) DEFAULT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `jumlah` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_keuangan_detail` */

insert  into `tb_keuangan_detail`(`id_keuangan`,`deskripsi`,`jumlah`) values 
(1,'Beli Canang dan Bunga',35000),
(2,'Beli Dupa',5000),
(2,'Beli Canang',6000),
(3,'Biaya Parkir',1200000),
(3,'Biaya Toilet',300000);

/*Table structure for table `tb_log_notifikasi` */

DROP TABLE IF EXISTS `tb_log_notifikasi`;

CREATE TABLE `tb_log_notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_notifikasi` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_log_notifikasi` */

/*Table structure for table `tb_log_siswa` */

DROP TABLE IF EXISTS `tb_log_siswa`;

CREATE TABLE `tb_log_siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_log_siswa` */

/*Table structure for table `tb_notifikasi` */

DROP TABLE IF EXISTS `tb_notifikasi`;

CREATE TABLE `tb_notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kk` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `waktu` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_notifikasi` */

insert  into `tb_notifikasi`(`id`,`id_kk`,`keterangan`,`waktu`) values 
(1,2,'Jatuh Tempo','2021-04-03');

/*Table structure for table `tb_pegawai` */

DROP TABLE IF EXISTS `tb_pegawai`;

CREATE TABLE `tb_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status_pegawai` varchar(20) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pegawai` */

insert  into `tb_pegawai`(`id`,`nik`,`nama_pegawai`,`jenis_kelamin`,`tanggal_lahir`,`telepon`,`alamat`,`email`,`status_pegawai`,`id_user`) values 
(1,'01898999222882','Ni Wayan Suryaning S.Kom','Perempuan','1993-03-14','08174753904','Denpasar','suryaning@gmail.com','Aktif',1),
(2,'01898999222345','I Komang Juliana','Laki-Laki','1990-03-15','08174753905','Gianyar','ikomangjuliana@gmail.com','Aktif',2),
(3,'02929291212121','I Wayan Suyasa','Laki-Laki','1991-03-14','08174753966','Badung','saplar@gmail.com','Aktif',3),
(4,'01898999222334','Ni Kadek Surya S.pda','Perempuan','1990-06-01','0817475388','Denpasar','surya@gmail.com','Aktif',10);

/*Table structure for table `tb_rkas` */

DROP TABLE IF EXISTS `tb_rkas`;

CREATE TABLE `tb_rkas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kk` int(11) DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_rkas` */

insert  into `tb_rkas`(`id`,`id_kk`,`nominal`,`tanggal`) values 
(1,3,2000000,'2021-04-03');

/*Table structure for table `tb_siswa` */

DROP TABLE IF EXISTS `tb_siswa`;

CREATE TABLE `tb_siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) DEFAULT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `telepon_siswa` varchar(15) DEFAULT NULL,
  `telepon_ortu` varchar(15) DEFAULT NULL,
  `angkatan` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_siswa` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_siswa` */

insert  into `tb_siswa`(`id`,`nis`,`nama_siswa`,`tanggal_lahir`,`alamat`,`telepon_siswa`,`telepon_ortu`,`angkatan`,`email`,`status_siswa`,`id_kelas`,`id_user`) values 
(1,'20169899002','I Wayan Suyasa','2000-03-15','Denpasar, Bali','08174753955','08174753565','2016','saplar@gmail.com','Aktif',1,3),
(2,'201600900892','I Wayan Arif','1990-02-02','Susut, Bangli','08197977788','08197977788','2016','sangkur@gmail.com','Aktif',1,4),
(3,'201600900333','Ni Made Sukinem','1990-02-03','Denpasar Barat','09877121773','08197977799','2017','sukinem@gmail.com','Aktif',1,6),
(4,'201600900443','Ni Kadek Surati Sukma','1990-02-04','Mengwi, Badung','08198989988','08197977098','2016','surati@gmail.com','Aktif',1,7),
(5,'201600900766','I Komang Juliana','1990-02-05','Pejeng, Gianyar','08174753904','08197977556','2016','juliana@gmail.com','Aktif',1,2),
(6,'201600900733','I Wayan Sugili','1990-02-01','Denpasar','08174733904','08197977533','2016','sugili@gmail.com','Aktif',1,9),
(7,'201698990044','Ni Made Devi Sari','2004-06-01','Denpasar',NULL,'08174753577','2021',NULL,'Aktif',1,NULL);

/*Table structure for table `tb_tahun_ajaran` */

DROP TABLE IF EXISTS `tb_tahun_ajaran`;

CREATE TABLE `tb_tahun_ajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tahun_ajaran` */

insert  into `tb_tahun_ajaran`(`id`,`tahun_ajaran`) values 
(1,'2020/2021'),
(2,'2021/2022');

/*Table structure for table `tb_transaksi` */

DROP TABLE IF EXISTS `tb_transaksi`;

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(20) DEFAULT NULL,
  `id_kk` int(11) DEFAULT NULL,
  `no_transaksi` varchar(6) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `batal` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_transaksi` */

insert  into `tb_transaksi`(`id`,`id_user`,`id_kk`,`no_transaksi`,`tanggal`,`nis`,`tahun_ajaran`,`total`,`batal`) values 
(1,'2',1,'PMB001','2021-03-24','201600900892','2020/2021',90000,0),
(2,'3',2,'PMB002','2021-02-01','201600900766','2020/2021',60000,0),
(3,'3',2,'PMB003','2021-04-04','201600900443','2020/2021',60000,0),
(4,'3',1,'PMB004','2021-05-05','201600900892','2020/2021',200000,0),
(5,'3',1,'PMB005','2021-02-05','201600900766','2020/2021',200000,0),
(6,'3',1,'PMB006','2021-06-03','201600900892','2020/2021',200000,0),
(7,'3',1,'PMB007','2021-06-03','201600900892','2020/2021',200000,0);

/*Table structure for table `tb_transaksi_detail` */

DROP TABLE IF EXISTS `tb_transaksi_detail`;

CREATE TABLE `tb_transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `nominal_bayar` float DEFAULT NULL,
  `jenis_iuran` enum('Wajib','Sukarela') DEFAULT 'Wajib',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_transaksi_detail` */

insert  into `tb_transaksi_detail`(`id`,`id_transaksi`,`bulan`,`nominal_bayar`,`jenis_iuran`) values 
(9,1,'Februari',30000,'Wajib'),
(8,1,'Januari',30000,'Wajib'),
(10,1,'Maret',30000,'Wajib'),
(11,2,'Januari',30000,'Wajib'),
(12,2,'Februari',30000,'Wajib'),
(13,3,'Januari',30000,'Wajib'),
(14,3,'Februari',30000,'Wajib'),
(15,4,'April',200000,'Wajib'),
(16,5,'Januari',200000,'Wajib'),
(17,6,'Mei',200000,'Wajib'),
(18,7,'Juni',200000,'Wajib');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `aktif` smallint(6) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`nama`,`username`,`password`,`aktif`,`id_jabatan`) values 
(1,'Ni Wayan Suryaning S.Kom','kepalasekolah','$2y$10$ihr9h4sr1M9JhFwwjuW0mufQVWxfgEe3GDauW5JBzb6w5m8kiFX8O',1,1),
(2,'I Komang Juliana','ketuayayasan','$2y$10$B.H/5vfuz2Bxn/QHfpxf7.AyHj8G0krAqq/EZnrT9MGIReHKPz1yO',1,5),
(3,'I Wayan Suyasa','bendahara','$2y$10$.ivmzuNZyKbJWcInEDuCeOoU76Z1wHeAx9PeSC7hLyrI72FVHcqA6',1,2),
(10,'Ni Kadek Surya S.pda',NULL,'$2y$10$uGqnE2Mn5Fj80vFjbywupOTxkkUm.YR46Z7JBSsKeWY51wOxNMlwO',1,3);

/* Procedure structure for procedure `lap_biaya` */

/*!50003 DROP PROCEDURE IF EXISTS  `lap_biaya` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `lap_biaya`()
BEGIN
		select 
			tb_kategori_keuangan.nama_kk as nama_kategori,
			tb_biaya.nominal,
			tb_biaya.angkatan
		from tb_biaya inner join tb_kategori_keuangan on tb_biaya.id_kk=tb_kategori_keuangan.id;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
