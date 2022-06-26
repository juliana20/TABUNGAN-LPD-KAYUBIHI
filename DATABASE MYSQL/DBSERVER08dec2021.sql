/*
SQLyog Ultimate v10.42 
MySQL - 5.7.21-log : Database - sia_ksu_ari_canti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sia_ksu_ari_canti` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sia_ksu_ari_canti`;

/*Table structure for table `tb_akun` */

DROP TABLE IF EXISTS `tb_akun`;

CREATE TABLE `tb_akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(50) NOT NULL,
  `saldo_awal` float DEFAULT '0',
  `debet` float DEFAULT '0',
  `kredit` float DEFAULT '0',
  `saldo_akhir` float DEFAULT '0',
  `golongan` varchar(50) DEFAULT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `normal_pos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_akun` */

insert  into `tb_akun`(`id`,`id_akun`,`nama_akun`,`saldo_awal`,`debet`,`kredit`,`saldo_akhir`,`golongan`,`kelompok`,`normal_pos`) values (1,'10101','Kas Koperasi',10000000,0,0,0,'Aktiva','Aktiva Lancar','Debit'),(2,'10102','Bank Koperasi',0,0,0,0,'Aktiva','Aktiva Lancar','Debit'),(3,'40101','Pendapatan Koperasi',0,0,0,0,'Pendapatan','Pendapatan Operasional','Kredit'),(4,'40102','Pendapatan Lain-lain',0,0,0,0,'Pendapatan','Pendapatan Non Operasional','Kredit'),(5,'20101','Hutang Nasabah',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),(6,'20102','Hutang Lain-lain',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),(7,'30101','Modal',0,0,0,0,'Modal','Modal','Kredit'),(8,'60101','Biaya Gaji Karyawan',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(9,'60102','Biaya Marketing',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(10,'60103','Biaya ATK',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(11,'60104','Biaya Fotocopy',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(13,'60105','Biaya Internet',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(14,'60106','Biaya Listrik dan Air',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(15,'11001','Bangunan',0,0,0,0,'Aktiva','Aktiva Tetap','Debit'),(16,'11002','Akm. Penyusutan Bangunan',0,0,0,0,'Aktiva','Aktiva Tetap','Kredit'),(17,'11003','Peralatan Kantor',0,0,0,0,'Aktiva','Aktiva Tetap','Debit'),(18,'11004','Akm. Penyusutan Peralatan Kantor',0,0,0,0,'Aktiva','Aktiva Tetap','Kredit'),(19,'60107','Biaya Penyusutan Bangunan',0,0,0,0,'Biaya','Biaya Operasional','Debit'),(20,'40103','Pendapatan Bunga Bank',0,0,0,0,'Pendapatan','Pendapatan Non Operasional','Kredit'),(21,'40104','Pendapatan Denda Pinjaman',0,0,0,0,'Pendapatan','Pendapatan Operasional','Debit'),(22,'20103','Tabungan Sukarela',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),(23,'20104','Tabungan Berjangka',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),(24,'20105','Simpanan Wajib',0,0,0,0,'Hutang','Hutang Lancar','Kredit'),(25,'20106','Simpanan Pokok',0,0,0,0,'Hutang','Hutang Lancar','Kredit');

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_jurnal` */

/*Table structure for table `tb_jurnal` */

DROP TABLE IF EXISTS `tb_jurnal`;

CREATE TABLE `tb_jurnal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `status_batal` tinyint(1) DEFAULT '0',
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_jurnal`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jurnal` */

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
  `status_batal` tinyint(1) DEFAULT '0',
  `debet` float DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_mutasi_kas`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_mutasi_kas` */

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_mutasi_kas_detail` */

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
  `aktif` smallint(1) DEFAULT '1',
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
  `berhenti_anggota` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`,`id_nasabah`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`jenis_kelamin`,`no_telp`,`pekerjaan`,`aktif`,`tanggal_lahir`,`no_ktp`,`tanggal_daftar`,`anggota`,`no_anggota`,`no_rek_sim_pokok`,`no_rek_sim_wajib`,`no_rek_tabungan`,`bunga`,`id_user`,`berhenti_anggota`) values (11,'NS005','I Putu Sandiyasa','Br. Tarukan, Mas, Ubud','Laki-Laki','085342891356','Swasta',1,'1989-09-20','5104050805690001','2021-12-07',1,'AG004','SP2112070004','SW2112070004',NULL,NULL,16,0),(10,'NS004','Ni Made Giriani','Br. Juga, Mas, Ubud','Perempuan','087432987144','Wiraswasta',1,'1996-11-07','5104070506790001','2021-11-09',1,'AG003','SP2112070003','SW2112070003',NULL,NULL,15,0),(9,'NS003','Ni Kadek Sugiari','Br, Gagaan Kaja, Pejeng Kangin','Perempuan','083114974050','Swasta',1,'1992-08-02','5104044208000002','2021-10-07',NULL,NULL,NULL,NULL,'TB2112080001',0.3,14,0),(8,'NS002','I Wayan Adi Bramasta','Br. Gelumpang, Sukawati','Laki-Laki','081665532985','Swasta',1,'1997-04-10','5104011408040001','2021-10-08',1,'AG002','SP2112070002','SW2112070002','TB2112080002',0.3,13,0),(7,'NS001','I Nyoman Wijaya','Br. Abianseka, Mas, Ubud','Laki-Laki','087861396626','Wiraswasta',1,'1969-06-06','5104050506690002','2021-10-07',1,'AG001','SP2112070001','SW2112070001',NULL,NULL,12,0),(12,'NS006','Ni Wayan Novik Yulita','Br. Kediri, Singapadu','Perempuan','081665567890','Swasta',1,'1993-10-25','5104050903100004','2021-11-19',1,'AG005','SP2112070005','SW2112070005',NULL,NULL,17,0),(13,'NS007','I Kadek Krisna','Br. Yeh Tengah, Kelusa, Payangan','Laki-Laki','087758055940','Mahasiswa',1,'1999-10-02','5104070210990001','2021-11-16',NULL,NULL,NULL,NULL,NULL,NULL,18,0),(14,'NS008','Ni Wayan Trisna Dewi','Br. Klumpu, Nusa Penida','Perempuan','085792175873','Karyawan Swasta',1,'1992-10-11','5104055110920001','2021-12-05',NULL,NULL,NULL,NULL,NULL,NULL,19,0),(15,'NS009','I Wayan Rahadi','Br. Tengah, Kenderan, Tegalalang','Laki-Laki','089667431984','Karyawan Swasta',1,'1980-03-01','5104060103900002','2021-11-16',NULL,NULL,NULL,NULL,NULL,NULL,20,0),(16,'NS010','Ni Ketut Wartini','Jl. Taman Sari No 46 Badung','Perempuan','085720934876','Pedagang',1,'1975-12-31','5103017112760142','2021-11-20',1,'AG006','SP2112070006','SW2112070006',NULL,NULL,21,0),(17,'NS011','I Dewa Gede Ramana','Lingk. Triwangsa, Beng','Laki-Laki','083118898145','Tidak Bekerja',1,'1983-06-12','5104031206830001','2021-09-10',1,'AG007','SP2112070007','SW2112070007',NULL,NULL,22,0),(18,'NS012','Pande Putu Widya','Br Juga, Mas, Ubud','Perempuan','085737480867','Mahasiswa',1,'1999-09-11','5104055109000002','2021-09-23',1,'AG008','SP2112070008','SW2112070008',NULL,NULL,23,0),(19,'NS013','Ni Wayan Puji','Link. Kelod Kauh, Beng','Perempuan','08565398689','Ibu Rumah Tangga',1,'1975-06-22','5104036206750002','2021-09-03',1,'AG009','SP2112070009','SW2112070009',NULL,NULL,24,0),(20,'NS014','Desak Putu  Eka Prikanti','Br. Roban, Tulikup, Gianyar','Perempuan','089543987765','Buruh Lepas',1,'1985-04-27','5104036704830002','2021-09-15',1,'AG010','SP2112070010','SW2112070010',NULL,NULL,25,0),(21,'NS015','Ni Ketut Widiani','Br. Bakas, Klungkung','Perempuan','081567894567','Karyawan Swasta',1,'1976-05-14','5104055405760001','2021-09-21',1,'AG011','SP2112070011','SW2112070011',NULL,NULL,26,0);

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
  `sisa_bunga` float DEFAULT '0',
  `id_akun` varchar(10) DEFAULT NULL,
  `saldo_tabungan` float DEFAULT NULL,
  `bunga_pinjaman` float DEFAULT NULL,
  `nominal_bunga` float DEFAULT NULL,
  `menetap` smallint(1) DEFAULT NULL,
  `lunas` smallint(1) DEFAULT NULL,
  `harga_pasar_jaminan` float DEFAULT NULL,
  `maksimal_pinjaman` float DEFAULT NULL,
  PRIMARY KEY (`id`,`id_pinjaman`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman` */

insert  into `tb_pinjaman`(`id`,`id_pinjaman`,`tgl_realisasi`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`jaminan`,`jangka_waktu`,`jatuh_tempo`,`jumlah_pinjaman`,`biaya_materai`,`biaya_asuransi`,`biaya_admin`,`jumlah_diterima`,`angsuran`,`sisa_pinjaman`,`sisa_bunga`,`id_akun`,`saldo_tabungan`,`bunga_pinjaman`,`nominal_bunga`,`menetap`,`lunas`,`harga_pasar_jaminan`,`maksimal_pinjaman`) values (14,'KR08122021001','2021-12-08','1','NS010',NULL,'HONDA ATI1IB01 A/T','12','2022-12-08',5000000,30000,0,150000,4820000,416667,5000000,50000,'10101',0,0.01,50000,1,NULL,NULL,NULL);

/*Table structure for table `tb_pinjaman_detail` */

DROP TABLE IF EXISTS `tb_pinjaman_detail`;

CREATE TABLE `tb_pinjaman_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pokok` float DEFAULT '0',
  `bunga` float DEFAULT '0',
  `denda` float DEFAULT '0',
  `id_akun` varchar(10) DEFAULT NULL,
  `total` float DEFAULT '0',
  `sisa_pinjaman` float DEFAULT '0',
  `sisa_bunga` float DEFAULT NULL,
  `proses` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pinjaman_detail` */

/*Table structure for table `tb_posted` */

DROP TABLE IF EXISTS `tb_posted`;

CREATE TABLE `tb_posted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `no_bukti` varchar(20) DEFAULT NULL,
  `id_akun` varchar(20) DEFAULT NULL,
  `debet` float DEFAULT '0',
  `kredit` float DEFAULT '0',
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_simpanan_wajib` */

insert  into `tb_simpanan_wajib`(`id`,`id_simpanan_wajib`,`id_user`,`id_nasabah`,`no_rek_sim_wajib`,`tanggal`,`total_simp_wajib`,`debet`,`kredit`,`id_akun`) values (14,'TSW006','1','NS011','SW2112070007','2021-11-10',1300000,NULL,300000,'10101'),(13,'TSW005','1','NS011','SW2112070007','2021-10-10',1000000,NULL,1000000,'10101'),(12,'TSW004','1','NS004','SW2112070003','2021-12-09',500000,NULL,500000,'10101'),(11,'TSW003','1','NS002','SW2112070002','2021-12-08',500000,NULL,400000,'10101'),(10,'TSW002','1','NS002','SW2112070002','2021-11-08',100000,NULL,100000,'10101'),(9,'TSW001','1','NS001','SW2112070001','2021-12-07',800000,NULL,300000,'10101'),(8,'TSW000','1','NS001','SW2112070001','2021-11-07',500000,NULL,500000,'10101'),(15,'TSW007','1','NS012','SW2112070008','2021-10-23',100000,NULL,100000,'10101'),(16,'TSW008','1','NS012','SW2112070008','2021-11-23',300000,NULL,200000,'10101'),(17,'TSW009','1','NS013','SW2112070009','2021-10-03',300000,NULL,300000,'10101'),(18,'TSW010','1','NS013','SW2112070009','2021-11-03',500000,NULL,200000,'10101'),(19,'TSW011','1','NS013','SW2112070009','2021-12-03',1000000,NULL,500000,'10101'),(20,'TSW012','1','NS014','SW2112070010','2021-10-15',500000,NULL,500000,'10101'),(21,'TSW013','1','NS014','SW2112070010','2021-11-15',600000,NULL,100000,'10101'),(22,'TSW014','1','NS015','SW2112070011','2021-10-21',100000,NULL,100000,'10101'),(23,'TSW015','1','NS015','SW2112070011','2021-11-21',400000,NULL,300000,'10101');

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
  `status_tabungan_berjangka` tinyint(1) DEFAULT '1',
  `denda_pinalti` float DEFAULT '0',
  PRIMARY KEY (`id`,`id_tabungan_berjangka`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_berjangka` */

insert  into `tb_tabungan_berjangka`(`id`,`id_tabungan_berjangka`,`id_user`,`id_nasabah`,`jangka_waktu`,`jangka_waktu_hari`,`jangka_waktu_bulan`,`tanggal_awal`,`jatuh_tempo`,`bunga_tabungan_berjangka`,`total_bunga`,`nominal_tabungan_berjangka`,`total_tabungan_berjangka`,`status_tabungan_berjangka`,`denda_pinalti`) values (11,'TD08120112115','1','NS011','1',365,'12','2021-09-25','2022-09-25',0.5,100000,200000,2500000,1,0),(10,'TD08120111404','1','NS006','1',365,'12','2021-12-08','2022-12-08',0.5,250000,500000,6250000,1,0);

/*Table structure for table `tb_tabungan_berjangka_detail` */

DROP TABLE IF EXISTS `tb_tabungan_berjangka_detail`;

CREATE TABLE `tb_tabungan_berjangka_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tabungan_berjangka` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `debet` float DEFAULT '0',
  `kredit` float DEFAULT '0',
  `id_user` varchar(10) DEFAULT NULL,
  `id_akun` varchar(11) DEFAULT NULL,
  `proses` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_berjangka_detail` */

insert  into `tb_tabungan_berjangka_detail`(`id`,`id_tabungan_berjangka`,`tanggal`,`debet`,`kredit`,`id_user`,`id_akun`,`proses`) values (37,'TD08120112115','2021-11-25',0,200000,'1','10101',1),(36,'TD08120112115','2021-10-25',0,200000,'1','10101',1),(35,'TD08120112115','2021-12-08',0,200000,'1','10101',1),(34,'TD08120111404','2021-12-08',0,500000,'1','10101',1);

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
  `proses` smallint(1) DEFAULT '1',
  `bunga` float DEFAULT '0',
  PRIMARY KEY (`id`,`id_tabungan_sukarela`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tabungan_sukarela` */

insert  into `tb_tabungan_sukarela`(`id`,`id_tabungan_sukarela`,`id_user`,`id_nasabah`,`no_rek_tabungan`,`tanggal`,`debet`,`kredit`,`saldo`,`id_akun`,`proses`,`bunga`) values (36,'TTB08120111029','1','NS002','TB2112080002','2021-12-08',NULL,100000,100000,'10101',1,0),(35,'TTB08120110643','1','NS003','TB2112080001','2021-12-08',NULL,50000,50000,'10101',1,0);

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
  `aktif` smallint(1) DEFAULT '1',
  PRIMARY KEY (`id`,`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`id_user`,`nama_user`,`username`,`password`,`alamat`,`no_telp`,`jenis_kelamin`,`jabatan`,`aktif`) values (1,'U001','Gusti Ayu Ratih','admin123','$2y$10$2olP.22UmeWt06f05kFBpOYXOL0AuJfTjirkGShlJ.M4QKnFQn3S6','Ubud','081999777666','Perempuan','Admin',1),(2,'U002','I Nyoman Musna','keuangan','$2y$10$ZAlnFE9pRueI3.0CIe/qyeioiQtqLOBik7xtElihNjDjh.l9ooKI.','Mas, Ubud','081999777555','Laki-Laki','Keuangan',1),(3,'U003','I Nyoman Murja Antara','manager','$2y$10$Z5fIA7ZHR8ijS5geTtDamuejqVqaagHNfQrkZIcYntDkEZ3ut1qr6','Peliatan, Ubud','081999777123','Laki-Laki','Manager',1),(16,'U016','I Putu Sandiyasa','sandiyasa','$2y$10$GdtiFNLseq1le5pSC/pvUO3i43T5x5D8ciYoadjXc.NghIspadrru','Br. Tarukan, Mas, Ubud','085342891356','Laki-Laki','Nasabah',1),(15,'U015','Ni Made Giriani','giriani','$2y$10$ZClppWM8MbeCLKRmj4sOIe5bbbBlhiYnPtM0BZysjlRqLXZBd69nO','Br. Juga, Mas, Ubud','087432987144','Perempuan','Nasabah',1),(14,'U014','Ni Kadek Sugiari','sugiari','$2y$10$UbrgvWGZNgm7iwbSmd0wiuiJ5uXzDO5DgoUbSS0luwz.Ug5X9n5AC','Br, Gagaan Kaja, Pejeng Kangin','083114974050','Perempuan','Nasabah',1),(8,'U008','Ni Putu Ayu Wati','wati1234','$2y$10$A5hZ80LmSuqCjslaHtCoY.GGyt9/Ml73tJJB8Pj19kRLlvToDIF3K','Sukawati, Gianyar','083117789955','Perempuan','Admin',1),(13,'U013','I Wayan Adi Bramasta','bramasta','$2y$10$PvmrqRxmGpB5ImvAnpsMUe0NDnpomJdOXl.2.bjTGZYXVaM1qtjhG','Br. Gelumpang, Sukawati','081665532985','Laki-Laki','Nasabah',1),(12,'U012','I Nyoman Wijaya','wijaya','$2y$10$3KtT4I/hmq75s0TNUIq2LeK5ZaaJxg77oCBdG39AYYeg5h.8ha2g2','Br. Abianseka, Mas, Ubud','087861396626','Laki-Laki','Nasabah',1),(11,'U011','I Nyoman Sastra','sastra321','$2y$10$o.NQlhxlcrmlGOA75GP0jOhCHAhDZLdOu5hMnGCfnD36Q9.Dsrd0y','Mas, Ubud','085667231190','Laki-Laki','Manager',1),(17,'U017','Ni Wayan Novik Yulita','yulita','$2y$10$uoB63m9ntyF9pILkfoipYuqT4gpUWvruv/4CAv/5wtGkFfzdUSI1O','Br. Kediri, Singapadu','081665567890','Perempuan','Nasabah',1),(18,'U018','I Kadek Krisna','krisna','$2y$10$Vt0ABv9N1QAxpH6EX.KHiumCaFgbYPOJGDNndo4axzH1RJ83InxQ.','Br. Yeh Tengah, Kelusa, Payangan','087758055940','Laki-Laki','Nasabah',1),(19,'U019','Ni Wayan Trisna Dewi','trisna','$2y$10$ufUYfmDyQVqPKx7SyD56Fepj8qA1HymyixZCKUo1kop4BC3Gtf/FS','Br. Klumpu, Nusa Penida','085792175873','Perempuan','Nasabah',1),(20,'U020','I Wayan Rahadi','rahadi','$2y$10$S4QNkmLGu3gs3sYTo2c8teIlTx4TqV4XLZB9S0OZVx20FfMy5WEQm','Br. Tengah, Kenderan, Tegalalang','089667431984','Laki-Laki','Nasabah',1),(21,'U021','Ni Ketut Wartini','wartini','$2y$10$/XrFCBDmUNqPbbfpUu2GWu6kVKSCnbhypY/lfScTDhKpUyFC1iEga','Jl. Taman Sari No 46 Badung','085720934876','Perempuan','Nasabah',1),(22,'U022','I Dewa Gede Ramana','ramana','$2y$10$YZmC8ROq9d./i7vfPvRVOuUdWhGr7.H.5X0.oQLnACJD.QBJ2yidG','Lingk. Triwangsa, Beng','083118898145','Laki-Laki','Nasabah',1),(23,'U023','Pande Putu Widya','widya','$2y$10$jpBZqfrt2ofsNZ4BUDWWa./oLlCVlGu4DQbZrueb6/hdsb7Kup9Z.','Br Juga, Mas, Ubud','085737480867','Perempuan','Nasabah',1),(24,'U024','Ni Wayan Puji','puji','$2y$10$w/wyTrEWjQKsf1y1P7zxxOtrwm9tTqnjdkT2lV/dLJyP146ecv/q6','Link. Kelod Kauh, Beng','08565398689','Perempuan','Nasabah',1),(25,'U025','Desak Putu  Eka Prikanti','prikanti','$2y$10$RGAYWBkyAqZvo5yv2671gOJuNU1urgeqo1z/y752olRlBtfKZ78.i','Br. Roban, Tulikup, Gianyar','089543987765','Perempuan','Nasabah',1),(26,'U026','Ni Ketut Widiani','widiani','$2y$10$YATCjleduiCG64JJWfQFb.oxE4tlWUCiCp4yADr.NawydThcS/.eC','Br. Bakas, Klungkung','081567894567','Perempuan','Nasabah',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
