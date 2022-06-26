/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - sia_ksu_ari_canti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sia_ksu_ari_canti` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `sia_ksu_ari_canti`;

/*Table structure for table `tb_akun` */

DROP TABLE IF EXISTS `tb_akun`;

CREATE TABLE `tb_akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(50) NOT NULL,
  `saldo_awal` float DEFAULT 0,
  `debet` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  `saldo_akhir` float DEFAULT 0,
  `golongan` varchar(50) DEFAULT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `normal_pos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_akun` */

insert  into `tb_akun`(`id`,`id_akun`,`nama_akun`,`saldo_awal`,`debet`,`kredit`,`saldo_akhir`,`golongan`,`kelompok`,`normal_pos`) values 
(1,'10101','Kas Koperasi',0,0,0,0,'Aktiva','Aktiva Lancar','Debit'),
(2,'10102','Bank Koperasi',0,0,0,0,'Aktiva','Aktiva Lancar','Debit'),
(3,'40101','Pendapatan Koperasi',0,0,0,0,'Pendapatan','Pendapatan Operasional','Kredit'),
(4,'40102','Pendapatan Lain-lain',0,0,0,0,'Pendapatan','Pendapatan Non Operasional','Kredit'),
(5,'20101','Hutang Nasabah',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),
(6,'20102','Hutang Lain-lain',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),
(7,'30101','Modal',0,0,0,0,'Modal','Modal','Kredit'),
(8,'60101','Biaya Gaji Karyawan',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(9,'60102','Biaya Marketing',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(10,'60103','Biaya ATK',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(11,'60104','Biaya Fotocopy',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(13,'60105','Biaya Internet',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(14,'60106','Biaya Listrik dan Air',0,0,0,0,'Biaya','Biaya Operasional','Debit'),
(15,'11001','Bangunan',0,0,0,0,'Aktiva','Aktiva Tetap','Debit'),
(16,'11002','Akm. Penyusutan Bangunan',0,0,0,0,'Aktiva','Aktiva Tetap','Kredit'),
(17,'11003','Peralatan Kantor',0,0,0,0,'Aktiva','Aktiva Tetap','Debit'),
(18,'11004','Akm. Penyusutan Peralatan Kantor',0,0,0,0,'Aktiva','Aktiva Tetap','Kredit');

/*Table structure for table `tb_detail_jurnal` */

DROP TABLE IF EXISTS `tb_detail_jurnal`;

CREATE TABLE `tb_detail_jurnal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` varchar(10) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_akun`,`id_jurnal`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_jurnal` */

insert  into `tb_detail_jurnal`(`id`,`id_akun`,`id_jurnal`,`keterangan`,`debet`,`kredit`) values 
(4,'40101','JUM-211004-0001',NULL,0,500000),
(3,'10101','JUM-211004-0001',NULL,500000,0),
(5,'10101','JUM-211004-0002',NULL,500000,0),
(6,'40101','JUM-211004-0002',NULL,0,500000);

/*Table structure for table `tb_jurnal` */

DROP TABLE IF EXISTS `tb_jurnal`;

CREATE TABLE `tb_jurnal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `status_batal` tinyint(1) DEFAULT 0,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_jurnal`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jurnal` */

insert  into `tb_jurnal`(`id`,`id_jurnal`,`tanggal`,`keterangan`,`status_batal`,`id_user`) values 
(3,'JUM-211004-0001','2021-10-04 12:00:00','-',1,2),
(4,'JUM-211004-0002','2021-10-04 12:00:00','-',0,2);

/*Table structure for table `tb_mutasi_kas` */

DROP TABLE IF EXISTS `tb_mutasi_kas`;

CREATE TABLE `tb_mutasi_kas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mutasi_kas` varchar(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis_mutasi` varchar(25) DEFAULT NULL,
  `akun_id` varchar(10) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `status_batal` tinyint(1) DEFAULT 0,
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_mutasi_kas`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_mutasi_kas` */

insert  into `tb_mutasi_kas`(`id`,`id_mutasi_kas`,`id_user`,`tanggal`,`jenis_mutasi`,`akun_id`,`total`,`keterangan`,`status_batal`,`debet`,`kredit`) values 
(2,'MUT-211003-0001','2','2021-10-03 12:00:00','Pengeluaran','10101',900000,'Pengeluaran bulan october',1,NULL,900000),
(4,'MUT-211003-0003','2','2021-10-03 12:00:00','Penerimaan','10101',1000000,'-',0,1000000,NULL),
(3,'MUT-211003-0002','2','2021-10-03 12:00:00','Pengeluaran','10102',250000,'Pengeluaran bank',0,NULL,250000),
(5,'MUT-211010-0004','2','2021-10-10 12:00:00','Penerimaan','10101',1000000,'Penerimaan Uang Bantuan',0,1000000,0),
(6,'MUT-211010-0005','2','2021-10-10 12:00:00','Pengeluaran','10101',2000000,'Biaya Gaji Karyawan',0,0,2000000),
(7,'MUT-211014-0006','2','2021-10-14 12:00:00','Penerimaan','10101',10000000,'-',0,10000000,0),
(8,'MUT-211014-0007','2','2021-10-14 12:00:00','Penerimaan','10102',12000000,'-',0,12000000,0),
(9,'MUT-211014-0008','2','2021-10-14 12:00:00','Pengeluaran','10101',2000000,'Bayar Gaji',0,0,2000000);

/*Table structure for table `tb_mutasi_kas_detail` */

DROP TABLE IF EXISTS `tb_mutasi_kas_detail`;

CREATE TABLE `tb_mutasi_kas_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mutasi_kas` varchar(20) DEFAULT NULL,
  `akun_id` varchar(10) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_mutasi_kas_detail` */

insert  into `tb_mutasi_kas_detail`(`id`,`id_mutasi_kas`,`akun_id`,`keterangan`,`nominal`,`kredit`) values 
(1,'MUT-211003-0001','60102','-',300000,NULL),
(2,'MUT-211003-0001','60103','Beli Kertas',600000,NULL),
(3,'MUT-211003-0002','60104','Fotocopy berkas nasabah',250000,NULL),
(4,'MUT-211003-0003','40101','Denda Nasabah',0,1000000),
(5,'MUT-211010-0004','40101','Sukarelawan',0,1000000),
(6,'MUT-211010-0005','60101','Gaji Bulan Oktober',2000000,0),
(7,'MUT-211014-0006','40101','Sumbangan dari pemerintah',0,0),
(8,'MUT-211014-0007','40101','Pendapatan Deposito',0,0),
(9,'MUT-211014-0008','60101','Bulan October',2000000,0);

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
  `id_user` int(11) DEFAULT NULL,
  `berhenti_anggota` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`,`id_nasabah`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`jenis_kelamin`,`no_telp`,`pekerjaan`,`aktif`,`tanggal_lahir`,`no_ktp`,`tanggal_daftar`,`anggota`,`no_anggota`,`no_rek_sim_pokok`,`no_rek_sim_wajib`,`no_rek_tabungan`,`bunga`,`id_user`,`berhenti_anggota`) values 
(1,'NS001','Putri Adnyani','Mas, Ubud','Perempuan','081999777444','Pedagang',1,'1996-01-20','51019209022933009','2021-09-05',1,'AG001','SP2109050001','SW2109050001','TB2109150001',0.3,4,1),
(2,'NS002','I Wayan Subawa','Batubulan','Laki-Laki','081999777564','Petani',1,'1980-01-02','51019209022933099','2021-09-05',1,'AG003','SP2109050003','SW2109050003','TB2109150002',0.3,5,1),
(3,'NS003','Ni Nyoman Kari','Mas, Ubud','Perempuan','081999777121','Pedagang',1,'1975-01-20','51019209022933111','2021-09-05',1,'AG004','SP2109050004','SW2109050004','TB2109260003',0.3,6,0),
(4,'NS004','I Nyoman Sampun','Mas, Ubud','Laki-Laki','081999777767','Petani',1,'1990-01-20','51019209022933122','2021-09-05',0,NULL,NULL,NULL,'',NULL,7,0),
(5,'NS005','I Wayan Jana','Mas, Ubud','Laki-Laki','082999888776','Swasta',1,'1997-01-20','01239131231222','2021-11-02',NULL,NULL,NULL,NULL,NULL,NULL,8,0);

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
  `biaya_admin` float DEFAULT NULL,
  `jumlah_diterima` float DEFAULT NULL,
  `angsuran` float DEFAULT NULL,
  `sisa_pinjaman` float DEFAULT NULL,
  `sisa_bunga` float DEFAULT 0,
  `id_akun` varchar(10) DEFAULT NULL,
  `saldo_tabungan` float DEFAULT NULL,
  `bunga_pinjaman` float DEFAULT NULL,
  `nominal_bunga` float DEFAULT NULL,
  `menetap` smallint(1) DEFAULT NULL,
  `lunas` smallint(1) DEFAULT NULL,
  `harga_pasar_jaminan` float DEFAULT NULL,
  `maksimal_pinjaman` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_pinjaman`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman` */

insert  into `tb_pinjaman`(`id`,`id_pinjaman`,`tgl_realisasi`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`jaminan`,`jangka_waktu`,`jatuh_tempo`,`jumlah_pinjaman`,`biaya_materai`,`biaya_asuransi`,`biaya_admin`,`jumlah_diterima`,`angsuran`,`sisa_pinjaman`,`sisa_bunga`,`id_akun`,`saldo_tabungan`,`bunga_pinjaman`,`nominal_bunga`,`menetap`,`lunas`,`harga_pasar_jaminan`,`maksimal_pinjaman`) values 
(10,'KR06112021612','2021-11-06','1','NS003','TB2109260003','Sertifikat Tanah dan Rumah','12','2022-11-06',10000000,0,0,300000,9700000,833333,10000000,150000,'10101',500000,0.015,150000,0,NULL,NULL,NULL),
(9,'KR06112021001','2021-11-06','1','NS002','TB2109150002','Sertifikat Tanah','12','2022-11-06',12000000,0,0,360000,11640000,1000000,10820000,0,'10101',350000,0.015,180000,0,NULL,NULL,NULL);

/*Table structure for table `tb_pinjaman_detail` */

DROP TABLE IF EXISTS `tb_pinjaman_detail`;

CREATE TABLE `tb_pinjaman_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pokok` float DEFAULT 0,
  `bunga` float DEFAULT 0,
  `denda` float DEFAULT 0,
  `id_akun` varchar(10) DEFAULT NULL,
  `total` float DEFAULT 0,
  `sisa_pinjaman` float DEFAULT 0,
  `sisa_bunga` float DEFAULT NULL,
  `proses` smallint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman_detail` */

insert  into `tb_pinjaman_detail`(`id`,`id_pinjaman`,`tanggal`,`id_user`,`pokok`,`bunga`,`denda`,`id_akun`,`total`,`sisa_pinjaman`,`sisa_bunga`,`proses`) values 
(9,'KR06112021001','2021-11-06',1,1000000,180000,0,'10101',1180000,10820000,0,1);

/*Table structure for table `tb_posted` */

DROP TABLE IF EXISTS `tb_posted`;

CREATE TABLE `tb_posted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `no_bukti` varchar(20) DEFAULT NULL,
  `id_akun` varchar(20) DEFAULT NULL,
  `debet` float DEFAULT 0,
  `kredit` float DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_posted` */

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_simpanan_wajib` */

insert  into `tb_simpanan_wajib`(`id`,`id_simpanan_wajib`,`id_user`,`id_nasabah`,`no_rek_sim_wajib`,`tanggal`,`total_simp_wajib`,`debet`,`kredit`,`id_akun`) values 
(1,'TSW14092021001','1','NS001','SW2109050001','2021-09-14',100000,NULL,100000,'10101'),
(2,'TSW14092021141','1','NS001','SW2109050001','2021-09-14',300000,NULL,200000,'10101'),
(3,'TSW15092021141','1','NS001','SW2109050001','2021-09-15',100000,200000,NULL,'10101'),
(4,'TSW15092021151','1','NS002','SW2109050003','2021-09-15',50000,NULL,50000,'10101'),
(5,'TSW05112021151','1','NS001','SW2109050001','2021-11-05',110000,NULL,10000,'10101'),
(6,'TSW05112021152','1','NS003','SW2109050004','2021-11-05',100000,NULL,100000,'10101'),
(7,'TSW21474836481','1','NS003','SW2109050004','2021-11-05',150000,NULL,50000,'10101'),
(8,'TSW21474836482','1','NS003','SW2109050004','2021-11-05',200000,NULL,50000,'10101'),
(9,'TSW21474836483','1','NS003','SW2109050004','2021-11-05',300000,NULL,100000,'10101'),
(10,'TSW21474836484','1','NS001','SW2109050001','2021-11-07',0,NULL,0,'10101');

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
(4,'TD25092021510','1','NS004','3',1096,'36','2021-09-25','2024-09-25',0.5,150000,100000,3750000,0,2000);

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
  `proses` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_berjangka_detail` */

insert  into `tb_tabungan_berjangka_detail`(`id`,`id_tabungan_berjangka`,`tanggal`,`debet`,`kredit`,`id_user`,`id_akun`,`proses`) values 
(2,'TD25092021001','2021-09-25',0,50000,'1','10101',0),
(3,'TD25092021001','2021-09-25',0,50000,'1','10101',1),
(17,'TD25092021510','2021-09-25',0,100000,'1','10101',1),
(16,'TD25092021001','2021-09-25',99000,0,'1','10101',1),
(18,'TD25092021510','2021-10-20',0,100000,'1','10101',1),
(19,'TD25092021510','2021-11-09',198000,0,'1','10101',1);

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
  `proses` smallint(1) DEFAULT 1,
  `bunga` float DEFAULT 0,
  PRIMARY KEY (`id`,`id_tabungan_sukarela`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_sukarela` */

insert  into `tb_tabungan_sukarela`(`id`,`id_tabungan_sukarela`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`tanggal`,`debet`,`kredit`,`saldo`,`id_akun`,`proses`,`bunga`) values 
(2,'TTB15092021001','1','NS001','TB2109150001','2021-09-15',NULL,100000,100000,'10101',1,0),
(3,'TTB15092021151','1','NS002','TB2109150002','2021-09-15',NULL,200000,200000,'10101',1,0),
(4,'TTB16092021151','1','NS001','TB2109150001','2021-09-16',NULL,200000,200000,'10101',1,0),
(5,'TTB16092021161','1','NS001','TB2109150001','2021-09-16',100000,NULL,0,'10101',1,0),
(6,'TTB18092021161','1','NS001','TB2109150001','2021-09-18',NULL,200000,400000,'10101',1,0),
(7,'TTB26092021181','1','NS003','TB2109260003','2021-09-26',NULL,500000,500000,'10101',1,0),
(8,'TTB20102021261','1','NS001','TB2109150001','2021-10-20',NULL,100000,500000,'10101',1,0),
(9,'TTB20102021262','1','NS002','TB2109150002','2021-10-20',50000,NULL,150000,'10101',1,0),
(10,'TTB20102021263','1','NS002','TB2109150002','2021-10-20',NULL,100000,300000,'10101',1,0),
(11,'TTB20102021264','1','NS002','TB2109150002','2021-10-20',50000,NULL,150000,'10101',1,0),
(12,'TTB20102021182','1','NS002','TB2109150002','2021-10-20',NULL,100000,300000,'10101',1,0),
(13,'TTB20102021183','1','NS002','TB2109150002','2021-10-20',NULL,100000,300000,'10101',1,0),
(14,'TTB20102021001','1','NS001','TB2109150001','2021-10-20',NULL,50000,450000,'10101',1,0),
(15,'TTB20102021007','1','NS001','TB2109150001','2021-10-20',NULL,50000,450000,'10101',1,0),
(16,'TTB20102021016','1','NS001','TB2109150001','2021-10-20',50000,NULL,350000,'10101',1,0),
(17,'TTB20100100805','1','NS001','TB2109150001','2021-10-20',NULL,40000,440000,'10101',1,0),
(18,'TTB20100100856','1','NS003','TB2109260003','2021-10-20',100000,NULL,400000,'10101',1,0),
(19,'TTB31100113028','1','NS001','TB2109150001','2021-10-31',100000,NULL,400000,'10101',1,0),
(20,'TTB31100113105','1','NS001','TB2109150001','2021-10-31',NULL,100000,500000,'10101',1,0),
(21,'TTB07110081617','1','NS001','TB2109150001','2021-11-07',NULL,0,0,'10101',1,0),
(22,'TTB07110081643','1','NS001','TB2109150001','2021-11-07',NULL,0,0,'10101',1,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`id_user`,`nama_user`,`username`,`password`,`alamat`,`no_telp`,`jenis_kelamin`,`jabatan`,`aktif`) values 
(1,'U001','Gusti Ayu Ratih','admin123','$2y$10$2olP.22UmeWt06f05kFBpOYXOL0AuJfTjirkGShlJ.M4QKnFQn3S6','Ubud','081999777666','Perempuan','Admin',1),
(2,'U002','I Nyoman Musna','keuangan','$2y$10$ZAlnFE9pRueI3.0CIe/qyeioiQtqLOBik7xtElihNjDjh.l9ooKI.','Mas, Ubud','081999777555','Laki-Laki','Keuangan',1),
(3,'U003','I Nyoman Murja Antara','manager','$2y$10$Z5fIA7ZHR8ijS5geTtDamuejqVqaagHNfQrkZIcYntDkEZ3ut1qr6','Peliatan, Ubud','081999777123','Laki-Laki','Manager',1),
(4,'U004','Putri Adnyani','adnyani','$2y$10$54EXYCNsA82mVr6h831lm.h9YZ00SEKmslNEvACV6BCOwXiuN1HHO','Mas, Ubud','081999777444','Perempuan','Nasabah',1),
(5,'U005','I Wayan Subawa','subawa','$2y$10$NzBjKueroNtdiqW8KoLO/eGchBdEwltI56pSRxoP9Ulqtgs6YJhN.','Batubulan','081999777564','Laki-Laki','Nasabah',1),
(6,'U006','Ni Nyoman Kari','nyomankari','$2y$10$fdXoDMS1L42MHrG3kj.qR.T5HJlSq/taVCk5F/6ezewyfcsh2llHm','Mas, Ubud','081999777121','Perempuan','Nasabah',1),
(7,'U007','I Nyoman Sampun','sampun','$2y$10$AOsYDeT.1nM7weRzp24TOeqcVckOHnYQ.QGFtaAVEp5CleE8y/wGe','Mas, Ubud','081999777767','Laki-Laki','Nasabah',1),
(8,'U008','I Wayan Jana','wayanjana','$2y$10$RqtykYNBEKCmL9j8aF3OtunvRGTrqlM3NkXNecw74mEycgqzSVXUq','Mas, Ubud','082999888776','Laki-Laki','Nasabah',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
