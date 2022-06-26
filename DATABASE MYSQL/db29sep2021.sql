/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - kanc6697_ksuaricanti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kanc6697_ksuaricanti` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `kanc6697_ksuaricanti`;

/*Table structure for table `tb_akun` */

DROP TABLE IF EXISTS `tb_akun`;

CREATE TABLE `tb_akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` varchar(10) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `id_mutasi_kas` varchar(10) DEFAULT NULL,
  `nama_akun` varchar(50) NOT NULL,
  `saldo_awal` float DEFAULT 0,
  `saldo_akhir` float DEFAULT 0,
  `golongan` varchar(50) DEFAULT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `normal_pos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_akun` */

insert  into `tb_akun`(`id`,`id_akun`,`id_user`,`id_mutasi_kas`,`nama_akun`,`saldo_awal`,`saldo_akhir`,`golongan`,`kelompok`,`normal_pos`) values 
(1,'10101',NULL,NULL,'KAS',0,0,'Aktiva','Aktiva Tetap','Debit'),
(2,'10102',NULL,NULL,'BANK',0,0,'Aktiva','Aktiva Tetap','Debit');

/*Table structure for table `tb_detail_jurnal` */

DROP TABLE IF EXISTS `tb_detail_jurnal`;

CREATE TABLE `tb_detail_jurnal` (
  `id_akun` varchar(10) NOT NULL,
  `id_jurnal` varchar(10) NOT NULL,
  PRIMARY KEY (`id_akun`,`id_jurnal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_jurnal` */

/*Table structure for table `tb_jurnal` */

DROP TABLE IF EXISTS `tb_jurnal`;

CREATE TABLE `tb_jurnal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurnal` varchar(10) NOT NULL,
  `tanggal` datetime NOT NULL,
  `debit` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  `reff` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_jurnal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jurnal` */

/*Table structure for table `tb_mutasi_kas` */

DROP TABLE IF EXISTS `tb_mutasi_kas`;

CREATE TABLE `tb_mutasi_kas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mutasi_kas` varchar(10) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `debit` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  `reff` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_mutasi_kas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_mutasi_kas` */

/*Table structure for table `tb_nasabah` */

DROP TABLE IF EXISTS `tb_nasabah`;

CREATE TABLE `tb_nasabah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nasabah` varchar(10) NOT NULL,
  `nama_nasabah` varchar(50) NOT NULL,
  `alamat_nasabah` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(50) DEFAULT NULL,
  `no_telp` varchar(14) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `aktif` smallint(1) DEFAULT 1,
  `tanggal_lahir` date DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `anggota` smallint(1) DEFAULT NULL,
  `no_anggota` varchar(10) DEFAULT NULL,
  `no_rek_sim_pokok` varchar(15) DEFAULT NULL,
  `no_rek_sim_wajib` varchar(15) DEFAULT NULL,
  `no_rek_tabungan` varchar(15) DEFAULT NULL,
  `bunga` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_nasabah`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`jenis_kelamin`,`no_telp`,`pekerjaan`,`aktif`,`tanggal_lahir`,`no_ktp`,`tanggal_daftar`,`anggota`,`no_anggota`,`no_rek_sim_pokok`,`no_rek_sim_wajib`,`no_rek_tabungan`,`bunga`) values 
(1,'NS001','Putri Adnyani','Mas, Ubud','Perempuan','081999777444','Pedagang',1,'1996-01-20','51019209022933009','2021-09-05',1,'AG001','SP2109050001','SW2109050001','TB2109150001',0.3),
(2,'NS002','I Wayan Subawa','Batubulan','Laki-Laki','081999777564','Petani',1,'1980-01-02','51019209022933099','2021-09-05',1,'AG003','SP2109050003','SW2109050003','TB2109150002',0.3),
(3,'NS003','Ni Nyoman Kari','Mas, Ubud','Perempuan','081999777121','Pedagang',1,'1975-01-20','51019209022933111','2021-09-05',1,'AG004','SP2109050004','SW2109050004','TB2109260003',0.3),
(4,'NS004','I Nyoman Sampun','Mas, Ubud','Laki-Laki','081999777767','Petani',1,'1990-01-20','51019209022933122','2021-09-05',0,NULL,NULL,NULL,'',NULL);

/*Table structure for table `tb_pinjaman` */

DROP TABLE IF EXISTS `tb_pinjaman`;

CREATE TABLE `tb_pinjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` varchar(20) NOT NULL,
  `tgl_realisasi` date DEFAULT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_nasabah` varchar(10) NOT NULL,
  `no_rek_tabungan` varchar(20) DEFAULT NULL,
  `jaminan` varchar(50) DEFAULT NULL,
  `jangka_waktu` varchar(50) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `jumlah_pinjaman` float DEFAULT NULL,
  `biaya_materai` float DEFAULT NULL,
  `biaya_asuransi` float DEFAULT NULL,
  `biaya_lainnya` float DEFAULT NULL,
  `propisi` float DEFAULT NULL,
  `jumlah_diterima` float DEFAULT NULL,
  `angsuran` float DEFAULT NULL,
  `sisa_pinjaman` float DEFAULT NULL,
  `id_akun` varchar(10) DEFAULT NULL,
  `saldo_tabungan` float DEFAULT NULL,
  `bunga_pinjaman` float DEFAULT NULL,
  `nominal_bunga` float DEFAULT NULL,
  `menetap` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_pinjaman`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman` */

insert  into `tb_pinjaman`(`id`,`id_pinjaman`,`tgl_realisasi`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`jaminan`,`jangka_waktu`,`jatuh_tempo`,`jumlah_pinjaman`,`biaya_materai`,`biaya_asuransi`,`biaya_lainnya`,`propisi`,`jumlah_diterima`,`angsuran`,`sisa_pinjaman`,`id_akun`,`saldo_tabungan`,`bunga_pinjaman`,`nominal_bunga`,`menetap`) values 
(6,'KR26092021001','2021-09-26','1','NS001','TB2109150001','Sertifikat tanah','12','2022-09-26',10000000,10000,0,0,0,9990000,933333,11200000,'10101',400000,0.01,1200000,1);

/*Table structure for table `tb_pinjaman_detail` */

DROP TABLE IF EXISTS `tb_pinjaman_detail`;

CREATE TABLE `tb_pinjaman_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `debet` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  `saldo` float DEFAULT 0,
  `id_akun` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman_detail` */

insert  into `tb_pinjaman_detail`(`id`,`id_pinjaman`,`tanggal`,`id_user`,`debet`,`kredit`,`saldo`,`id_akun`) values 
(6,'KR26092021001','2021-09-26',1,0,9990000,9990000,'10101');

/*Table structure for table `tb_simpanan_pokok` */

DROP TABLE IF EXISTS `tb_simpanan_pokok`;

CREATE TABLE `tb_simpanan_pokok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_simpanan_pokok` varchar(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_nasabah` varchar(10) NOT NULL,
  `no_rek_sim_pokok` varchar(20) DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_simp_pokok` float DEFAULT NULL,
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  `id_akun` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_simpanan_pokok`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_simpanan_pokok` */

/*Table structure for table `tb_simpanan_wajib` */

DROP TABLE IF EXISTS `tb_simpanan_wajib`;

CREATE TABLE `tb_simpanan_wajib` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_simpanan_wajib` varchar(20) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `id_nasabah` varchar(10) DEFAULT NULL,
  `no_rek_sim_wajib` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_simp_wajib` float DEFAULT NULL,
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  `id_akun` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_simpanan_wajib`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_simpanan_wajib` */

insert  into `tb_simpanan_wajib`(`id`,`id_simpanan_wajib`,`id_user`,`id_nasabah`,`no_rek_sim_wajib`,`tanggal`,`total_simp_wajib`,`debet`,`kredit`,`id_akun`) values 
(1,'TSW14092021001','1','NS001','SW2109050001','2021-09-14',100000,NULL,100000,'10101'),
(2,'TSW14092021141','1','NS001','SW2109050001','2021-09-14',300000,NULL,200000,'10101'),
(3,'TSW15092021141','1','NS001','SW2109050001','2021-09-15',100000,200000,NULL,'10101'),
(4,'TSW15092021151','1','NS002','SW2109050003','2021-09-15',50000,NULL,50000,'10101');

/*Table structure for table `tb_tabungan_berjangka` */

DROP TABLE IF EXISTS `tb_tabungan_berjangka`;

CREATE TABLE `tb_tabungan_berjangka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tabungan_berjangka` varchar(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_nasabah` varchar(10) NOT NULL,
  `jangka_waktu` varchar(50) DEFAULT NULL,
  `jangka_waktu_hari` int(20) DEFAULT NULL,
  `jangka_waktu_bulan` varchar(20) DEFAULT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `bunga_tabungan_berjangka` float DEFAULT NULL,
  `total_bunga` float DEFAULT NULL,
  `nominal_tabungan_berjangka` float DEFAULT NULL,
  `total_tabungan_berjangka` float DEFAULT NULL,
  `status_tabungan_berjangka` tinyint(1) DEFAULT 1,
  `denda_pinalti` float DEFAULT 0,
  PRIMARY KEY (`id`,`id_tabungan_berjangka`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_berjangka` */

insert  into `tb_tabungan_berjangka`(`id`,`id_tabungan_berjangka`,`id_user`,`id_nasabah`,`jangka_waktu`,`jangka_waktu_hari`,`jangka_waktu_bulan`,`tanggal_awal`,`jatuh_tempo`,`bunga_tabungan_berjangka`,`total_bunga`,`nominal_tabungan_berjangka`,`total_tabungan_berjangka`,`status_tabungan_berjangka`,`denda_pinalti`) values 
(3,'TD25092021001','1','NS003','3',1460,'36','2021-09-25','2025-09-24',0.5,75000,50000,1875000,0,1000),
(4,'TD25092021510','1','NS004','3',1096,'36','2021-09-25','2024-09-25',0.5,150000,100000,3750000,1,0);

/*Table structure for table `tb_tabungan_berjangka_detail` */

DROP TABLE IF EXISTS `tb_tabungan_berjangka_detail`;

CREATE TABLE `tb_tabungan_berjangka_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tabungan_berjangka` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `debet` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  `id_user` varchar(10) DEFAULT NULL,
  `id_akun` varchar(11) DEFAULT NULL,
  `proses` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_berjangka_detail` */

insert  into `tb_tabungan_berjangka_detail`(`id`,`id_tabungan_berjangka`,`tanggal`,`debet`,`kredit`,`id_user`,`id_akun`,`proses`) values 
(2,'TD25092021001','2021-09-25',0,50000,'1','10101',0),
(3,'TD25092021001','2021-09-25',0,50000,'1','10101',0),
(17,'TD25092021510','2021-09-25',0,100000,'1','10101',1),
(16,'TD25092021001','2021-09-25',99000,0,'1','10101',1);

/*Table structure for table `tb_tabungan_sukarela` */

DROP TABLE IF EXISTS `tb_tabungan_sukarela`;

CREATE TABLE `tb_tabungan_sukarela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tabungan_sukarela` varchar(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_nasabah` varchar(10) NOT NULL,
  `no_rek_tabungan` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `id_akun` varchar(10) DEFAULT NULL,
  `proses` smallint(1) DEFAULT 0,
  PRIMARY KEY (`id`,`id_tabungan_sukarela`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_sukarela` */

insert  into `tb_tabungan_sukarela`(`id`,`id_tabungan_sukarela`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`tanggal`,`debet`,`kredit`,`saldo`,`id_akun`,`proses`) values 
(2,'TTB15092021001','1','NS001','TB2109150001','2021-09-15',NULL,100000,100000,'10101',1),
(3,'TTB15092021151','1','NS002','TB2109150002','2021-09-15',NULL,200000,200000,'10101',1),
(4,'TTB16092021151','1','NS001','TB2109150001','2021-09-16',NULL,200000,300000,'10101',1),
(5,'TTB16092021161','1','NS001','TB2109150001','2021-09-16',100000,NULL,200000,'10101',1),
(6,'TTB18092021161','1','NS001','TB2109150001','2021-09-18',NULL,200000,400000,'10101',1),
(7,'TTB26092021181','1','NS003','TB2109260003','2021-09-26',NULL,500000,500000,'10101',1);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(10) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_telp` varchar(14) DEFAULT NULL,
  `jenis_kelamin` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL,
  `aktif` smallint(1) DEFAULT 1,
  PRIMARY KEY (`id`,`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`id_user`,`nama_user`,`username`,`password`,`alamat`,`no_telp`,`jenis_kelamin`,`jabatan`,`aktif`) values 
(1,'U001','Gusti Ayu Ratih','admin123','$2y$10$2olP.22UmeWt06f05kFBpOYXOL0AuJfTjirkGShlJ.M4QKnFQn3S6','Ubud','081999777666','Perempuan','Admin',1),
(2,'U002','I Nyoman Musna','keuangan','$2y$10$ZAlnFE9pRueI3.0CIe/qyeioiQtqLOBik7xtElihNjDjh.l9ooKI.','Mas, Ubud','081999777555','Laki-Laki','Keuangan',1),
(3,'U003','I Nyoman Murja Antara','manager','$2y$10$Z5fIA7ZHR8ijS5geTtDamuejqVqaagHNfQrkZIcYntDkEZ3ut1qr6','Peliatan, Ubud','081999777123','Laki-Laki','Manager',1),
(4,'U004','Anak Agung Ratih Semara','nasabah','$2y$10$KK6ax1zu.HSjIiF3icAIlOR1EzBjIQIgy1.AbyUlC9PJ5n385fVWG','Mas ubud','081999777766','Perempuan','Nasabah',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
