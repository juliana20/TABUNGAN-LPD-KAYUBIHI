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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_biaya` */

insert  into `tb_biaya`(`id`,`id_kk`,`id_kelas`,`angkatan`,`nominal`) values 
(23,13,6,'2016',120000),
(22,14,6,'2016',30000),
(21,13,5,'2017',120000),
(20,14,5,'2017',30000),
(19,13,4,'2018',120000),
(18,14,4,'2018',30000),
(17,13,3,'2019',120000),
(16,14,3,'2019',30000),
(15,14,2,'2020',30000),
(14,13,2,'2020',120000);

/*Table structure for table `tb_jabatan` */

DROP TABLE IF EXISTS `tb_jabatan`;

CREATE TABLE `tb_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(50) DEFAULT NULL,
  `status_jabatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jabatan` */

insert  into `tb_jabatan`(`id`,`jabatan`,`status_jabatan`) values 
(1,'Kepala Sekolah','Aktif'),
(2,'Bendahara','Aktif'),
(3,'Komite Sekolah','Aktif'),
(4,'Siswa','Aktif'),
(5,'Ketua Yayasan','Aktif'),
(6,'Guru','Aktif');

/*Table structure for table `tb_kategori_keuangan` */

DROP TABLE IF EXISTS `tb_kategori_keuangan`;

CREATE TABLE `tb_kategori_keuangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kk` varchar(50) DEFAULT NULL,
  `jenis_kk` varchar(50) DEFAULT NULL,
  `status_kk` varchar(50) DEFAULT NULL,
  `no_akun` varchar(20) NOT NULL,
  PRIMARY KEY (`id`,`no_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kategori_keuangan` */

insert  into `tb_kategori_keuangan`(`id`,`nama_kk`,`jenis_kk`,`status_kk`,`no_akun`) values 
(20,'Belanja Barang/ Peralatan Kantor','Pengeluaran','Aktif','601'),
(19,'Pemeliharaan Gedung','Pengeluaran','Aktif','602'),
(18,'Air','Pengeluaran','Aktif','603'),
(17,'Listrik','Pengeluaran','Aktif','604'),
(16,'Dana Pemerintah','Pemasukan','Aktif','501'),
(15,'Dana Masyarakat','Pemasukan','Aktif','502'),
(14,'Pembayaran Uangan Gedung','Pembayaran','Aktif','401'),
(13,'Pembayaran SPP','Pembayaran','Aktif','402');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kelas` */

insert  into `tb_kelas`(`id`,`kode_kelas`,`tingkat_kelas`,`status_kelas`,`nik`,`jurusan`) values 
(1,'KLS001','Kelas III','Aktif','4444444','Bahasa'),
(2,'KLS002','Kelas IV','Aktif','0004990120011','IPA'),
(3,'KLS003','Kelas II','Aktif','2804990120555','guru Bahasa'),
(4,'KLS004','Kelas I','Aktif','1662470066021','guru Agama'),
(5,'KLS005','Kelas III','Aktif','2804990120047','Kesenian dan IPS'),
(6,'KLS006','Kelas V','Aktif','001145782369','Matematika'),
(7,'KLS007','Kelas VI','Aktif','11235150158070','IPA'),
(8,'KLS008','-','Non-Aktif','01898999222345','-');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_keuangan` */

insert  into `tb_keuangan`(`id`,`no_transaksi`,`id_user`,`sumber_dana`,`nominal`,`tanggal`,`keterangan`,`batal`,`id_kk`) values 
(12,'PNL002',2,'Dana Bos',900000,'2021-01-05','dibayar per bulan',0,18),
(11,'PMK003',2,'sumbangan wali murid',1000000,'2021-01-05','untuk perbaikan gedung sekolah \" AN : Bapak Budi \"',0,15),
(10,'PNL001',2,'Dana Bos',6500000,'2021-02-01','Pembayaran Listrik dilakukan / 3 bulan',0,17),
(9,'PMK002',2,'Dana Bos',30000000,'2021-01-15','untuk /3 bulan',0,16),
(8,'PMK001',2,'organisasi Desa',5000000,'2021-02-01','dana sumbangan',0,15),
(13,'PNL003',2,'Dana Bos',800000,'2021-02-10','bayar air per bulan',0,18),
(14,'PMK004',2,'sumbangan wali murid',2000000,'2021-03-10','atas nama bpak yanto',0,15);

/*Table structure for table `tb_keuangan_detail` */

DROP TABLE IF EXISTS `tb_keuangan_detail`;

CREATE TABLE `tb_keuangan_detail` (
  `id_keuangan` int(11) DEFAULT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `jumlah` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_keuangan_detail` */

insert  into `tb_keuangan_detail`(`id_keuangan`,`deskripsi`,`jumlah`) values 
(8,'sumbangan perbaikan jalan',5000000),
(9,'Penerimaan Dana Bos',30000000),
(10,'Bayar Listrik',6500000),
(11,'sumbangan wali murid',1000000),
(12,'Air Bulan Januari',900000),
(13,'Air Bulan februari',800000),
(14,'sumbangan wali murid',2000000);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pegawai` */

insert  into `tb_pegawai`(`id`,`nik`,`nama_pegawai`,`jenis_kelamin`,`tanggal_lahir`,`telepon`,`alamat`,`email`,`status_pegawai`,`id_user`) values 
(1,'01898999222882','Eka Timaya Laily Rahmah,S.Pd','Perempuan','1988-09-09','08174753904','Denpasar','suryaning@gmail.com','Aktif',1),
(2,'01898999222345','Indah Purnama Dewi S.pd','Perempuan','1988-05-15','08174753905','Kediri, Tabanan','indahdewi@gmail.com','Aktif',2),
(3,'02929291212121','Agus Harifin, S.pd','Laki-Laki','1988-08-14','08174753966','Badung','saplaragus@gmail.com','Aktif',3),
(4,'001145782369','Dessy Puspitasari, S.Pd','Perempuan','1992-01-12','01337547665','tabanan','dessy@gmail.com','Aktif',10),
(5,'3886470030078','Suharsono','Laki-Laki','1973-05-08','081554477666','kediri','suharsono@gmail.com','Aktif',12),
(6,'1662470066021','Nur Azizah','Perempuan','1999-01-14','08144566789','Kediri Tabanan','Azizahh@gmail.com','Aktif',13),
(7,'2804990120047','Nia Baiturohma','Perempuan','1995-04-05','08765432188','tabanan','nia@gmail.com','Aktif',14),
(8,'11235150158070','Alfiya Nazilah, S.Pd.','Perempuan','1998-02-06','08765432199','jln. Jepun Gg Krisna','siti@gmail.com','Aktif',15),
(9,'0004990120011','Zian Aini, S.Pd','Perempuan','1995-04-15','081336232544','Tabanan','Ziann@gmail.com','Aktif',16),
(10,'2804990120555','Laila Alfiana Azizah, S.Pd','Perempuan','1993-07-18','081337273633','Tabanan','Algianan@gmail.com','Aktif',17),
(11,'2804990150011','Ike Rahayu Margi Lestari, S.Pd','Perempuan','1995-10-17','082137452633','Tabanan','rahayu@gmail.com','Aktif',18),
(12,'2804990121234','Lif Imel Wahidatus Solehah','Perempuan','1999-12-23','081980453211','Kediri,Tabanan','Wahidatus@gmail.com','Aktif',19),
(13,'2804990120005','Putri Retno Wosari, S.PdI','Perempuan','1983-03-12','087113444411','tabanan','Retno@gmail.com','Aktif',20),
(14,'2804990120012','Mikratul Ani, S.Pd','Perempuan','1991-07-02','081222434366','Ob Tabanan','mikratul@gmail.com','Aktif',21);

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
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_siswa` */

insert  into `tb_siswa`(`id`,`nis`,`nama_siswa`,`tanggal_lahir`,`alamat`,`telepon_siswa`,`telepon_ortu`,`angkatan`,`email`,`status_siswa`,`id_kelas`,`id_user`) values 
(83,'160516','Mohammad Arjun Muzaky','2010-10-22','Perum GMJ B Exklusif',NULL,'08197977000','2016',NULL,'Aktif',6,NULL),
(82,'160515','Moh Ferdi Ardiansyah','2010-12-08','GMJ B8 No. 49 Sanggulan',NULL,'08197977093','2016',NULL,'Aktif',6,NULL),
(81,'160514','Moh Faruq Faza Abdillah','2010-01-01','BTN Sanggulan',NULL,'08197975467','2016',NULL,'Aktif',6,NULL),
(80,'160513','M.Andika Juliano','2009-07-01','Perum Geria Sandan Sari',NULL,'08197976789','2016',NULL,'Aktif',6,NULL),
(79,'160512','Jasmine Hafidzah Az Zahra',NULL,'BSI BTN Sanggulan',NULL,'08197977978','2016',NULL,'Aktif',6,NULL),
(78,'160511','Jannatul Aliyah','2010-09-01','Asrama Rindam IX/Udayana',NULL,'08197977576','2016',NULL,'Aktif',6,NULL),
(77,'160510','Ilham Mubarok','2008-10-08','Jl. S. Parman Br Taman Mekar Sari',NULL,'08197977123','2016',NULL,'Aktif',6,NULL),
(76,'160509','Khamdah Khalidah','2009-03-10','Porum Pandak Dewata',NULL,'08197977545','2016',NULL,'Aktif',6,NULL),
(75,'160508','Gladys Prillia Prenaturia',NULL,'BTN Tanah Bang ( Permai A/16)',NULL,'08197977521','2016',NULL,'Aktif',6,NULL),
(74,'160507','Giskha Wulan Ramadhanti','2009-01-27','BTN Tanahbang',NULL,'08197977544','2016',NULL,'Aktif',6,NULL),
(73,'160506','Carissa Aninda Devia Rahma','2009-07-09','Jl. Tukad Ayung B5',NULL,'08197977533','2016',NULL,'Aktif',6,NULL),
(72,'160505','Cahaya Rosana Aira Kurnia Cantik','2010-01-15','Tukad Saba Sanggulan ',NULL,'08197977547','2016',NULL,'Aktif',6,NULL),
(71,'160504','Atha Fakhri Putra','2010-04-02','BTN Puskopad II sanggulan',NULL,'08197977556','2016',NULL,'Aktif',6,NULL),
(70,'160503','Arsya Naura Ayu','2009-07-15','Sandan Sari B.E',NULL,'08197977098','2016',NULL,'Aktif',6,NULL),
(69,'160502','Annisa Qoerynov Putri Maryanto','2009-11-20','Mengewi',NULL,'08197977799','2016',NULL,'Aktif',6,NULL),
(68,'160501','Amira Panji Nurmelya Shanti','2010-05-02','GMJ Blok 5 No 22 Sanggulan Kediri',NULL,'08197977788','2016',NULL,'Aktif',6,NULL),
(67,'150621','Titis Ario Widjaksono','2009-09-27','GMJ Sanggulan Kediri',NULL,'08197977145','2015',NULL,'Aktif',7,NULL),
(66,'150620','Syifaul Qolbi Al Mekka Putri Ahmad','2008-12-24','Jl Kakak Tua No 5 X',NULL,'08197377552','2015',NULL,'Aktif',7,NULL),
(65,'150619','Safira Raya Maulani','2008-12-25','GMJ Sanggulan Kediri',NULL,'08197977456','2015',NULL,'Aktif',7,NULL),
(64,'150618','Putu Najwarista Radika Putri','2009-04-03','Ponpes Rodhatu Hufads',NULL,'08197977980','2015',NULL,'Aktif',7,NULL),
(63,'150617','Nazwa Rivana Arahman','2008-06-26','Jl. Yeh empas',NULL,'08197975503','2015',NULL,'Aktif',7,NULL),
(62,'150616','Najwa Ainun Zulfa','2009-01-31','Bukit Sanggulan',NULL,'08197977000','2015',NULL,'Aktif',7,NULL),
(61,'150615','Muhammad Kafi Arsyl Adhimi','2009-01-05','Banjar Anyar',NULL,'08197977093','2015',NULL,'Aktif',7,NULL),
(60,'150614','Muhammad Hilal Faiq Chairudin','2008-09-17','Perum. Aditya Sentana, Jl. Beiji Kerambitan',NULL,'08197975467','2015',NULL,'Aktif',7,NULL),
(59,'150613','Mikhail Muhammad Iksan','2009-04-15','Jl. Tukad Yeh Empas Blok IV No. 22 Sanggulan',NULL,'08197976789','2015',NULL,'Aktif',7,NULL),
(58,'150612','Lufthansa Rafael Dewandaru','2009-04-15','Perum Sandan Sari,Br jadi',NULL,'08197977978','2015',NULL,'Aktif',7,NULL),
(57,'150611','Luffiatuz Zahra','2008-08-31','Bukit Sanggulan',NULL,'08197977576','2015',NULL,'Aktif',7,NULL),
(56,'150610','Liyu Finujum Riski','2009-07-07','Br. Tuka, Perean tengah, Baturiti',NULL,'08197977123','2015',NULL,'Aktif',7,NULL),
(55,'150609','Kirana Aura Natrisya','2009-01-21','Perum. Graha satelit C/58 Jadi Desa',NULL,'08197977545','2015',NULL,'Aktif',7,NULL),
(54,'150608','Keyla Aura Syahla','2009-04-06','BTN Panorama Sanggulan',NULL,'08197977521','2015',NULL,'Aktif',7,NULL),
(53,'150607','Ibrahim Ghifahry','2009-03-19','Puskopad II',NULL,'08197977544','2015',NULL,'Aktif',7,NULL),
(52,'150606','Fira Salsabilla','2008-12-20','Tabanan',NULL,'08197977533','2015',NULL,'Aktif',7,NULL),
(51,'150605','Denis Alifta Ramadhana','2008-09-08','Kampung Jawa, Kediri',NULL,'08197977547','2015',NULL,'Aktif',7,NULL),
(50,'150604','Cika Aulia Pratiwi','2009-08-04','Perm BCA GMJ 9 N0. 46',NULL,'08197977556','2015',NULL,'Aktif',7,NULL),
(49,'150603','Bima Satria Wahyu Adi Nugraha','2009-05-07','Pandak Badung',NULL,'08197977098','2015',NULL,'Aktif',7,NULL),
(48,'150602','Ayu Navira Aprilia','2009-04-05','Sandan Sari',NULL,'08197977799','2015',NULL,'Aktif',7,NULL),
(47,'150601','Abidah Azmi Ayu Imtiyaaz','2009-04-05','GMJ Sanggulan Kediri',NULL,'08197977788','2015',NULL,'Aktif',7,NULL),
(84,'160517','Muhammad Arina Manasikana','2010-07-22','GMJ VII No. B6 Sanggulan',NULL,'08197975503','2016',NULL,'Aktif',6,NULL),
(85,'160518','Muhammad Avatar',NULL,'BTN Puskopad 1 Sanggulan',NULL,'08197977980','2016',NULL,'Aktif',6,NULL),
(86,'160519','Muhammad Naufal Ghathfan Amrullah','2012-11-11','Perum Sanggulan Blok 33A No32',NULL,'08197977456','2016',NULL,'Aktif',6,NULL),
(87,'160520','Nadin Queen Safitri','2012-12-11','BTN Mawar Indah Sanggulan',NULL,'08197377552','2016',NULL,'Aktif',6,NULL),
(88,'160521','Narendra Fatani Rafan','2009-11-16','Br. Jaga Satru Kediri',NULL,'08197377552','2016',NULL,'Aktif',6,NULL),
(89,'160522','Mohammad Ramadhani Alfarisi','2010-08-11','Jl. Tudad Yeh Bakung B23',NULL,'08197377552','2016',NULL,'Aktif',6,NULL),
(90,'160523','Muhamad Putra Adi Prasetyo','2011-03-31','Puskopad I BB',NULL,'08197377552','2016',NULL,'Aktif',6,NULL),
(91,'160524','Muhammad Adha Bibana Torres','2010-11-16','Jl. Tukad Yeh Pas',NULL,'08197377552','2016',NULL,'Aktif',6,NULL),
(92,'170401','Abdullah Akbar','2010-06-08','GMJ Blok 5 No 22 Sanggulan Kediri',NULL,'08197977788','2017',NULL,'Aktif',5,NULL),
(93,'170402','Adinda Alina Dwi Putri','2011-04-16','Mengewi',NULL,'08197977799','2017',NULL,'Aktif',5,NULL),
(94,'170403','Adistya Rifatus Zahra','2010-08-03','Sandan Sari B.E',NULL,'08197977098','2017',NULL,'Aktif',5,NULL),
(95,'170404','Ahmad Andika Juli Antonio','2011-07-04','BTN Puskopad II sanggulan',NULL,'08197977556','2017',NULL,'Aktif',5,NULL),
(96,'170405','Ahmad Naufal Ghadafi','2011-05-25','Tukad Saba Sanggulan ',NULL,'08197977547','2017',NULL,'Aktif',5,NULL),
(97,'170406','Almira Fauziah Akbar','2010-09-24','Jl. Tukad Ayung B5',NULL,'08197977533','2017',NULL,'Aktif',5,NULL),
(98,'170407','Alsya Nurjatun Syawalia','2010-09-12','BTN Tanahbang',NULL,'08197977544','2017',NULL,'Aktif',5,NULL),
(99,'170408','Ananda Sabrina Laila Khumaira','2011-09-29','BTN Tanah Bang ( Permai A/16)',NULL,'08197977521','2017',NULL,'Aktif',5,NULL),
(100,'170409','Anggarabintang Ramadhani','2010-08-13','Porum Pandak Dewata',NULL,'08197977545','2017',NULL,'Aktif',5,NULL),
(101,'170410','Atiqah Affidatuzzara','2011-01-31','Jl. S. Parman Br Taman Mekar Sari',NULL,'08197977123','2017',NULL,'Aktif',5,NULL),
(102,'170411','Dika Arta Pratama','2010-10-22','Asrama Rindam IX/Udayana',NULL,'08197977576','2017',NULL,'Aktif',5,NULL),
(103,'170412','Dinda Kirana Ramadhani','2011-08-10','BSI BTN Sanggulan',NULL,'08197977978','2017',NULL,'Aktif',5,NULL),
(104,'170413','Facthur Moh Hidayat','2011-06-21','Perum Geria Sandan Sari',NULL,'08197976789','2017',NULL,'Aktif',5,NULL),
(105,'170414','Fajar Maulana Wilson','2010-06-09','BTN Sanggulan',NULL,'08197975467','2017',NULL,'Aktif',5,NULL),
(106,'170415','Gita Safara Pratiwi','2011-02-01','GMJ B8 No. 49 Sanggulan',NULL,'08197977093','2017',NULL,'Aktif',5,NULL),
(107,'170416','Justine Daniel Lutfi','2011-06-05','Perum GMJ B Exklusif',NULL,'08197977000','2017',NULL,'Aktif',5,NULL),
(108,'170417','Kyla Maysha Agung Wibowo','2011-05-21','GMJ VII No. B6 Sanggulan',NULL,'08197975503','2017',NULL,'Aktif',5,NULL),
(109,'170418','M. Toriq Sabilillah','2010-01-07','BTN Puskopad 1 Sanggulan',NULL,'08197977980','2017',NULL,'Aktif',5,NULL),
(110,'170419','Melvin Aesar Rabbani','2011-09-07','Perum Sanggulan Blok 33A No32',NULL,'08197977456','2017',NULL,'Aktif',5,NULL),
(111,'170420','Messi Auliani Putri','2011-03-30','BTN Mawar Indah Sanggulan',NULL,'08197377552','2017',NULL,'Aktif',5,NULL),
(112,'170421','Mohammad Ikbal','2011-05-19','Br. Jaga Satru Kediri',NULL,'08197377552','2017',NULL,'Aktif',5,NULL),
(113,'170422','Mohammad Ramadhani Alfarisi','2010-08-11','Jl. Tudad Yeh Bakung B23',NULL,'08197377552','2017',NULL,'Aktif',5,NULL),
(114,'170423','Muhamad Putra Adi Prasetyo','2011-03-31','Puskopad I BB',NULL,'08197377552','2017',NULL,'Aktif',5,NULL),
(115,'170424','Muhammad Adha Bibana Torres','2010-11-16','Jl. Tukad Yeh Pas',NULL,'08197377552','2017',NULL,'Aktif',5,NULL),
(116,'180301','Ahmad Daffa Muzayyin Hamid','2011-11-20','Br Karangjung Sembung',NULL,'08197977788','2018',NULL,'Aktif',4,NULL),
(117,'180302','Aisyah Bryna Atha Nahda','2011-11-16','Jl. Darmawangsa No.4 Gang I Taman Sari Tabanan',NULL,'08197977799','2018',NULL,'Aktif',4,NULL),
(118,'180303','Albian Fathurohman','2011-09-07','Puskopad III Blok A No 3',NULL,'08197977098','2018',NULL,'Aktif',4,NULL),
(119,'180304','Alif Vania Putri Purnama','2011-09-21','Jl Tukad Pancoran Bukit sanggulan No.14',NULL,'08197977556','2018',NULL,'Aktif',4,NULL),
(120,'180305','Ardhya Wardhana','2012-07-22','Griyamulti Jadi',NULL,'08197977547','2018',NULL,'Aktif',4,NULL),
(121,'180306','Cahaya Kumalasari','2011-02-11','Sanggulan',NULL,'08197977533','2018',NULL,'Aktif',4,NULL),
(122,'180307','Calvin Chakravartee Atmaja','2012-02-27','Perm GMJ Karania Graha C1 sanggulan',NULL,'08197977544','2018',NULL,'Aktif',4,NULL),
(123,'180308','Dava Aly Dzakwan','2011-05-25','BTN Panorama Sanggulan',NULL,'08197977521','2018',NULL,'Aktif',4,NULL),
(124,'180309','Eva Hera Septya','2011-09-19','Jl. S Parman Perum BCA Land Kediri No.10',NULL,'08197977545','2018',NULL,'Aktif',4,NULL),
(125,'180310','Fadhil Nur Robbiansyah','2011-06-22','Asrama Rindam',NULL,'08197977123','2018',NULL,'Aktif',4,NULL),
(126,'180311','Fathir Idrus Zain','2011-12-08',NULL,NULL,'08197977576','2018',NULL,'Aktif',4,NULL),
(127,'180312','Gilang Wahyu Putra','2011-06-30','Sanggulan',NULL,'08197977978','2018',NULL,'Aktif',4,NULL),
(128,'180313','Hafizh Aisy Rohman','2012-03-06','BTN Tukad Sang-sang',NULL,'08197976789','2018',NULL,'Aktif',4,NULL),
(129,'180314','Ibnati Salsabila Lirobbiha','2012-09-06','GMJ Sanggulan Kediri',NULL,'08197975467','2018',NULL,'Aktif',4,NULL),
(130,'180315','Keysha Zian Azzahro','2011-07-23','Jl. Tukad Yeh Empas Blok IV No. 22 Sanggulan',NULL,'08197977093','2018',NULL,'Aktif',4,NULL),
(131,'180316','Khaira Talita Rumi','2012-07-17','Jl.Tukad Petanu BN No.6 sanggulan Anyar',NULL,'08197977000','2018',NULL,'Aktif',4,NULL),
(132,'180317','Khaansaa Raabihah Arza Istiqomah','2011-10-31','GMJ Manik Asri 7 No.3 Sanggulan',NULL,'08197975503','2018',NULL,'Aktif',4,NULL),
(133,'180318','M. Fadlan Tegar Saputra','2012-02-05','GMJ Blok 8/Karina Graha C 4',NULL,'08197977980','2018',NULL,'Aktif',4,NULL),
(134,'180319','Marwah Kirana Angraini','2011-12-09','Br Dinas Sanngulan',NULL,'08197977456','2018',NULL,'Aktif',4,NULL),
(135,'180320','Maulidatul Finta Rizki Ramadhani','2012-01-27','GMJ Sanggulan Kediri',NULL,'08197377522','2018',NULL,'Aktif',4,NULL),
(136,'180321','Meysya Pengestika','2011-07-05','Sanggulan',NULL,'08197377512','2018',NULL,'Aktif',4,NULL),
(137,'180322','Muhamad Azka Maulana','2011-07-26','GMJ Sanggulan Kediri',NULL,'08197377577','2018',NULL,'Aktif',4,NULL),
(138,'180323','Muhammad Iqbal Muzaki','2011-08-05','GMJ Blok 4/16 Sanggulan',NULL,'08197377576','2018',NULL,'Aktif',4,NULL),
(139,'180324','Muhammad Azzam Faiz Ramdhan','2012-07-20','Sanggulan',NULL,'08197377555','2018',NULL,'Aktif',4,NULL),
(140,'180325','Muhammad Naufal Zaki \'Azizi','2011-11-19','GMJ Sanggulan No. 12',NULL,'08197377566','2018',NULL,'Aktif',4,NULL),
(141,'180326','Muhammad Rangga Putra Asidik','2011-06-06','GMJ',NULL,'08197377534','2018',NULL,'Aktif',4,NULL),
(142,'180327','Muhammad Riski','2011-01-29','GMJ Sanggulan Kediri',NULL,'08197377590','2018',NULL,'Aktif',4,NULL),
(143,'180328','Natasya Febriyani','2012-02-26','Banjar Pemenang',NULL,'08197377556','2018',NULL,'Aktif',4,NULL),
(144,'190201','Adinda Bilqeez Az Zahra','2013-10-12','Jl. Raya Munggu',NULL,'08197977788','2019',NULL,'Aktif',3,NULL),
(145,'190202','Adinda Putri Amira','2013-08-03','Jl. Tukad Sang Sang Land II No.1',NULL,'08197977799','2019',NULL,'Aktif',3,NULL),
(146,'190203','Afiqa Rofiatul Azizah','2013-09-01','Jl. Tukad Petanu BM No 2',NULL,'08197977098','2019',NULL,'Aktif',3,NULL),
(147,'190204','Afiz Azra Saputra','2012-04-04','Banjar Semo, Kediri',NULL,'08197977556','2019',NULL,'Aktif',3,NULL),
(148,'190205','Ahmad Deren Arya Putra','2012-07-17','Br. Panti Pandak Gede ',NULL,'08197977547','2019',NULL,'Aktif',3,NULL),
(149,'190206','Aira Dwi Rahmadani','2012-12-08','Jl. Tukai Perean Tengah, Baturiti',NULL,'08197977533','2019',NULL,'Aktif',3,NULL),
(150,'190207','Aisyah Nur Faidah','2012-10-22','Jl. A. Yani 26 Kediri',NULL,'08197977544','2019',NULL,'Aktif',3,NULL),
(151,'190208','Alfiana Medina Nurul Lathifa','2012-07-22','Jl. Tukad Ayung Blok 5 No. 3',NULL,'08197977521','2019',NULL,'Aktif',3,NULL),
(152,'190209','Alifa Nauvalyn Dzikria',NULL,'Perum GMJ Blok VIII A',NULL,'08197977545','2019',NULL,'Aktif',3,NULL),
(153,'190210','Alifia Dian Arif','2012-11-11','Perum Multi Wira Asri D 8 BTN Puskopat 2',NULL,'08197977123','2019',NULL,'Aktif',3,NULL),
(154,'190211','Anastasya Ayu Desvitasari','2012-12-11','GMJ Sanggulan',NULL,'08197977576','2019',NULL,'Aktif',3,NULL),
(155,'190212','Anisatul Farrohah','2012-11-18','Lembah Sanggulan Kediri',NULL,'08197977978','2019',NULL,'Aktif',3,NULL),
(156,'190213','Areta Asha Ramadani','2012-04-07','Jl. Cempaka Hijau',NULL,'08197976789','2019',NULL,'Aktif',3,NULL),
(157,'190214','Atika Zahra Ratifa','2013-04-20','Puskopat I Blok A 8 ',NULL,'08197975467','2019',NULL,'Aktif',3,NULL),
(158,'190215','Aulia Syafira','2013-09-19','Puskopad 3 Blok A No. 3',NULL,'08197977093','2019',NULL,'Aktif',3,NULL),
(159,'190216','Azka Maulana Zikri Imron','2013-01-18','BTN Puskopad 2 Blok C-7',NULL,'08197977000','2019',NULL,'Aktif',3,NULL),
(160,'190217','Calista Aqilah ','2012-03-12','Perum griya Multi Jadi',NULL,'08197975503','2019',NULL,'Aktif',3,NULL),
(161,'190218','Chelsea Vivi Nur Azizah','2012-03-25','Munggu Bjr Pemaron',NULL,'08197977980','2019',NULL,'Aktif',3,NULL),
(162,'190219','Dendra Apriliadi','2012-04-22','jalan mawar tabanan',NULL,'08197977456','2019',NULL,'Aktif',3,NULL),
(163,'190220','Efbira Kaisah','2012-04-19','BTN Puskopad I Blok B N0. 27',NULL,'08197377522','2019',NULL,'Aktif',3,NULL),
(164,'190221','Fatihah Latinka Octavio Mustafa','2012-04-10','Mengwitani',NULL,'08197377512','2019',NULL,'Aktif',3,NULL),
(165,'190222','Isfa Safinatun Naja','2012-09-06','Gang Mawar Kediri',NULL,'08197377577','2019',NULL,'Aktif',3,NULL),
(166,'190223','Jordan Stevano','2013-01-30','Perum Cempaka Mas',NULL,'08197377576','2019',NULL,'Aktif',3,NULL),
(167,'190224','Luthfi Arsyifa Salsabila','2012-01-26','Br. Jadi',NULL,'08197377555','2019',NULL,'Aktif',3,NULL),
(168,'190225','M. Falah Ramadani','2012-07-25','Br. Tengah Dajan Puri, Marga',NULL,'08197377566','2019',NULL,'Aktif',3,NULL),
(169,'200101','Abid Luthfi','2013-03-15','Puri Jadi Lestari A7, Br. Jadi Babakan, Kediri',NULL,'08197977788','2020',NULL,'Aktif',2,NULL),
(170,'200102','Abidzar Syauqi Kamil','2013-09-11','Jl. Gatot Subroto II No 21 Br Sanggulan Kediri',NULL,'08197977799','2020',NULL,'Aktif',2,NULL),
(171,'200103','Achmad Azfar Khadafi ','2013-02-05','Jalan Tukad Petanu 13 Puskopad I',NULL,'08197977098','2020',NULL,'Aktif',2,NULL),
(172,'200104','Achmad Fahrudin Ramadhani','2013-06-22','Jl. Tendean No 75B  Br. Tanah Bang Banjar Anyar',NULL,'08197977556','2020',NULL,'Aktif',2,NULL),
(173,'200105','Achmad Bintang Ar Raafi Murdianto','2013-08-15','Perum Andika Graha No 85 Br Jadi',NULL,'08197977547','2020',NULL,'Aktif',2,NULL),
(174,'200106','Ahmad Jazil Widad','2013-11-06','Kediri',NULL,'08197977533','2020',NULL,'Aktif',2,NULL),
(175,'200107','Aldo Habibulloh Pratama','2014-03-07','Perum BCA Multi Jadi IC Tahap 2 No 46',NULL,'08197977544','2020',NULL,'Aktif',2,NULL),
(176,'200108','Alisya Marsya Nur Ginaa','2014-06-30','Puskopad II C 61 Jadi Anyar',NULL,'08197977521','2020',NULL,'Aktif',2,NULL),
(177,'200109','Alvaro Dika Bilfaqih ','2013-10-08','Puskopad Ii Blok D Sanggulan',NULL,'08197977545','2020',NULL,'Aktif',2,NULL),
(178,'200110','Anugerah Ramdhan Ahmad','2013-07-09','Perum Rafika Permai No A7 Br Sema Kediri',NULL,'08197977123','2020',NULL,'Aktif',2,NULL),
(179,'200111','Aqeefa Nayla Davita','2013-09-10','Jl. Tukad Yeh Leh B. 30 No. 23',NULL,'08197977576','2020',NULL,'Aktif',2,NULL),
(180,'200112','Athar Dwi Daffa Putra','2014-03-04','Perum Sandan Sari Blok G bawah no 28  Sanggulan',NULL,'08197977978','2020',NULL,'Aktif',2,NULL),
(181,'200113','Azzahra Nur Ramadhani','2013-07-07','Kediri',NULL,'08197976789','2020',NULL,'Aktif',2,NULL),
(182,'200114','Devitalia Dwi Eri Damayanti','2013-09-02','Br. Bedil Desa Baha Mengwi',NULL,'08197975467','2020',NULL,'Aktif',2,NULL),
(183,'200115','Dewita Maharani','2013-12-10','Sanggulan',NULL,'08197977093','2020',NULL,'Aktif',2,NULL),
(184,'200116','Dhiaz Anastasya Meydina Pratama Putri','2013-03-19','Jl. Rajawali Pesona Village Blok F/12',NULL,'08197977000','2020',NULL,'Aktif',2,NULL),
(185,'200117','Diyan Septiyan Hadi ','2013-09-16','Br. Mengening Desa Nyitdah Kediri',NULL,'08197975503','2020',NULL,'Aktif',2,NULL),
(186,'200118','Rizki Aditya Putra Pratama','2013-04-05','Denpasar',NULL,'08197977980','2020',NULL,'Aktif',2,NULL),
(187,'200119','El Dwi Surya Alamsyah','2013-04-05','GMJ Blok VIII 15 A Sanggulan',NULL,'08197977456','2020',NULL,'Aktif',2,NULL),
(188,'200120','Fatimatus Zehroh','2013-05-07','Jalan S. Parman Gg Anggrek',NULL,'08197377522','2020',NULL,'Aktif',2,NULL),
(189,'200121','Ferdy Armada','2013-08-04','BTN Mawar Indah Br Anyar',NULL,'08197377512','2020',NULL,'Aktif',2,NULL),
(190,'200122','Garan Rakha Ghaisan','2013-11-07','Perum Karang Teduh Blok B/4 Br. Pande Kediri',NULL,'08197377577','2020',NULL,'Aktif',2,NULL),
(191,'200123','Hayfa Dera Hanania','2014-04-16','Jl. Gatot Subroto II No 8b Sanggulan Kediri',NULL,'08197377576','2020',NULL,'Aktif',2,NULL),
(192,'200124','Jessen Dionel Lutfi','2013-11-30','Perum GMJ Blok 4-2',NULL,'08197377555','2020',NULL,'Aktif',2,NULL),
(193,'200125','Kagy Runako','2013-09-08','Banjar Pande Kediri',NULL,'08197377566','2020',NULL,'Aktif',2,NULL),
(194,'200126','Kaila Azzahra Ramadani','2013-12-20','Perum Rafika Permai 2/ No 3 Br. Sema',NULL,'08197377560','2020',NULL,'Aktif',2,NULL),
(195,'200127','Kinara Islah Hidayat','2013-03-19','Jalan Tukad Yeh mawa Blok 29 No 19 B51',NULL,'08197377000','2020',NULL,'Aktif',2,NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_transaksi` */

insert  into `tb_transaksi`(`id`,`id_user`,`id_kk`,`no_transaksi`,`tanggal`,`nis`,`tahun_ajaran`,`total`,`batal`) values 
(47,'2',14,'PMB017','2021-01-10','200103','2020/2021',30000,0),
(46,'2',13,'PMB016','2021-01-10','200103','2020/2021',120000,0),
(45,'2',14,'PMB015','2021-06-10','200102','2020/2021',150000,0),
(44,'2',13,'PMB014','2021-06-01','200102','2020/2021',600000,0),
(43,'2',14,'PMB013','2021-01-10','200102','2020/2021',30000,0),
(42,'2',13,'PMB012','2021-01-10','200102','2020/2021',120000,0),
(41,'2',14,'PMB011','0021-02-10','200101','2020/2021',150000,0),
(40,'2',13,'PMB010','2021-02-10','200101','2020/2021',600000,0),
(39,'2',14,'PMB009','2021-01-10','200101','2020/2021',30000,0),
(38,'2',13,'PMB008','2021-01-10','200101','2020/2021',120000,0),
(37,'2',13,'PMB007','2021-06-10','160501','2020/2021',240000,0),
(36,'2',14,'PMB006','2021-04-10','160501','2020/2021',30000,0),
(35,'2',13,'PMB005','2021-04-10','160501','2020/2021',120000,0),
(34,'2',14,'PMB004','2021-02-10','160501','2020/2021',60000,0),
(33,'2',13,'PMB003','2021-02-10','160501','2020/2021',240000,0),
(32,'2',14,'PMB002','2021-01-10','160501','2020/2021',30000,0),
(31,'2',13,'PMB001','2021-01-10','160501','2020/2021',120000,0),
(48,'2',13,'PMB018','2021-01-01','180301','2020/2021',120000,0),
(49,'2',14,'PMB019','2021-01-10','180301','2020/2021',30000,0),
(50,'2',13,'PMB020','2021-01-10','190201','2020/2021',120000,0),
(51,'2',13,'PMB021','2021-03-01','190201','2020/2021',120000,0),
(52,'2',14,'PMB022','2021-01-10','190201','2020/2021',30000,0),
(53,'2',14,'PMB023','2021-03-10','190201','2020/2021',30000,0),
(54,'2',14,'PMB024','2021-03-10','200104','2020/2021',90000,0),
(55,'2',13,'PMB025','2021-03-10','200104','2020/2021',360000,0),
(56,'2',13,'PMB026','2021-04-10','190202','2020/2021',480000,0),
(57,'2',14,'PMB027','2021-04-10','190202','2020/2021',120000,0),
(58,'2',13,'PMB028','2021-01-10','200105','2020/2021',600000,0),
(59,'2',14,'PMB029','2021-01-10','200105','2020/2021',150000,0),
(60,'2',13,'PMB030','2021-02-10','190201','2020/2021',120000,0),
(61,'2',13,'PMB032','2021-04-10','190201','2020/2021',120000,0),
(62,'2',13,'PMB033','2021-07-02','160516','2020/2021',120000,0),
(63,'2',13,'PMB033','2021-07-02','160516','2020/2021',120000,0),
(64,'2',13,'PMB033','2021-07-02','160516','2020/2021',120000,0),
(65,'2',13,'PMB034','2021-03-10','190201','2020/2021',120000,0);

/*Table structure for table `tb_transaksi_detail` */

DROP TABLE IF EXISTS `tb_transaksi_detail`;

CREATE TABLE `tb_transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `nominal_bayar` float DEFAULT NULL,
  `jenis_iuran` enum('Wajib','Sukarela') DEFAULT 'Wajib',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_transaksi_detail` */

insert  into `tb_transaksi_detail`(`id`,`id_transaksi`,`bulan`,`nominal_bayar`,`jenis_iuran`) values 
(103,31,'Januari',120000,'Wajib'),
(104,32,'Januari',30000,'Wajib'),
(105,33,'Februari',120000,'Wajib'),
(106,33,'Maret',120000,'Wajib'),
(107,34,'Februari',30000,'Wajib'),
(108,34,'Maret',30000,'Wajib'),
(109,35,'April',120000,'Wajib'),
(110,36,'April',30000,'Wajib'),
(111,37,'Mei',120000,'Wajib'),
(112,37,'Juni',120000,'Wajib'),
(113,38,'Januari',120000,'Wajib'),
(114,39,'Januari',30000,'Wajib'),
(115,40,'Februari',120000,'Wajib'),
(116,40,'Maret',120000,'Wajib'),
(117,40,'April',120000,'Wajib'),
(118,40,'Mei',120000,'Wajib'),
(119,40,'Juni',120000,'Wajib'),
(120,41,'Februari',30000,'Wajib'),
(121,41,'Maret',30000,'Wajib'),
(122,41,'April',30000,'Wajib'),
(123,41,'Mei',30000,'Wajib'),
(124,41,'Juni',30000,'Wajib'),
(125,42,'Januari',120000,'Wajib'),
(126,43,'Januari',30000,'Wajib'),
(127,44,'Februari',120000,'Wajib'),
(128,44,'Maret',120000,'Wajib'),
(129,44,'April',120000,'Wajib'),
(130,44,'Mei',120000,'Wajib'),
(131,44,'Juni',120000,'Wajib'),
(132,45,'Februari',30000,'Wajib'),
(133,45,'Maret',30000,'Wajib'),
(134,45,'April',30000,'Wajib'),
(135,45,'Mei',30000,'Wajib'),
(136,45,'Juni',30000,'Wajib'),
(137,46,'Januari',120000,'Wajib'),
(138,47,'Januari',30000,'Wajib'),
(139,48,'Januari',120000,'Wajib'),
(140,49,'Januari',30000,'Wajib'),
(141,50,'Januari',120000,'Wajib'),
(142,51,'Maret',120000,'Wajib'),
(143,52,'Januari',30000,'Wajib'),
(144,53,'Maret',30000,'Wajib'),
(145,54,'Januari',30000,'Wajib'),
(146,54,'Februari',30000,'Wajib'),
(147,54,'Maret',30000,'Wajib'),
(148,55,'Januari',120000,'Wajib'),
(149,55,'Februari',120000,'Wajib'),
(150,55,'Maret',120000,'Wajib'),
(151,56,'Januari',120000,'Wajib'),
(152,56,'Februari',120000,'Wajib'),
(153,56,'Maret',120000,'Wajib'),
(154,56,'April',120000,'Wajib'),
(155,57,'Januari',30000,'Wajib'),
(156,57,'Februari',30000,'Wajib'),
(157,57,'Maret',30000,'Wajib'),
(158,57,'April',30000,'Wajib'),
(159,58,'Januari',120000,'Wajib'),
(160,58,'Februari',120000,'Wajib'),
(161,58,'Maret',120000,'Wajib'),
(162,58,'April',120000,'Wajib'),
(163,58,'Mei',120000,'Wajib'),
(164,59,'Januari',30000,'Wajib'),
(165,59,'Februari',30000,'Wajib'),
(166,59,'Maret',30000,'Wajib'),
(167,59,'April',30000,'Wajib'),
(168,59,'Mei',30000,'Wajib'),
(169,60,'Februari',120000,'Wajib'),
(171,61,'Mei',120000,'Wajib'),
(172,63,'Januari',120000,'Wajib'),
(173,62,'Januari',120000,'Wajib'),
(174,64,'Januari',120000,'Wajib'),
(175,65,'Juni',120000,'Wajib');

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`nama`,`username`,`password`,`aktif`,`id_jabatan`) values 
(1,'Eka Timaya Laily Rahmah,S.Pd','kepalasekolah','$2y$10$ihr9h4sr1M9JhFwwjuW0mufQVWxfgEe3GDauW5JBzb6w5m8kiFX8O',1,1),
(2,'Indah Purnama Dewi S.pd','bendahara','$2y$10$.bMup0UWZE/QMAnqVYP2LeJ/8zWocNyVTD2PayjEN1pQn9Z/TKafa',1,2),
(3,'Agus Harifin, S.pd','ketuayayasan','$2y$10$4YHmseIHj2px496.AyQlWOm.IXAmk0RkAoD1.pBdeF3HMY9CBRxN2',1,5),
(4,'Arif wijaya','201600900892','$2y$10$8wFmSLbM6ZAgWazVurXmteEHHhG9SLnrK0ptM8ywWmaNiUK2nPT5q',1,4),
(6,'Lukmah Hakim','201600900333','$2y$10$ZRhK3su5VfUqErVGA9UJTeIeWMEhVstf8Gzs.oU1vjSRGbWMB6eaa',1,4),
(7,'Panji Pamungkas','201600900443','$2y$10$J.R25c7AFewbMRsS17GYJePN0/BFi4YXzyVcNQZWiDYQm2vzuN.6.',1,4),
(9,'Bianca Joly','201600900733','$2y$10$bq70c.9qv3iAgaGEwlnQ3.RRUUrwFOIy7JnVfYlnE.Fir9iGvGeaO',1,4),
(10,'Dessy Puspitasari, S.Pd',NULL,'$2y$10$MH/axxEXRJ9sGcvYuIgvceBgDMwN6JJgUAx/gwH3i9ci/mXgvbekq',1,6),
(11,'Adinda Marosa','kepalasekolah','$2y$10$W7LX2VxL988p/r/oS13Nz.L1vqUWYIZAye9hCKprnaOETDe8JERhG',1,4),
(12,'Suharsono',NULL,'$2y$10$29c6eC91IizdIceIeBW.uOBd/FOn3EOrA4WN.H.dXBIz7vGTkKdx.',1,6),
(13,'Nur Azizah',NULL,'$2y$10$Cj06on1f83BG5Cv/j0hApexe5soiQaytKYM8CMPy9MH2LHRbhAt.S',1,6),
(14,'Nia Baiturohma',NULL,'$2y$10$.fQhzclERKphHb0gNBz57e5jIkbCLeEUjT0R8kZRqFtPufrZ.szSO',1,6),
(15,'Alfiya Nazilah, S.Pd.',NULL,'$2y$10$T1M1w4HXFAWC5UeecMure.aE0DxVwS8tfRjDro6JDFhXvbgkOZyeS',1,6),
(16,'Zian Aini, S.Pd',NULL,'$2y$10$g3JKg6LRzvom88BtKlDa6Ozl7hjJaIXYlB9h.ggrgdq4wOT0rcXUK',1,6),
(17,'Laila Alfiana Azizah, S.Pd',NULL,'$2y$10$/eSCWufC8ngQn5VrSht6zevOzemUO0xiRlUav7orxDlVv2iSFBicK',1,6),
(18,'Ike Rahayu Margi Lestari, S.Pd',NULL,'$2y$10$/9oCvWkcwyvtovZP0IrNoOPM4pISE2KACTPLIl3n0LxQTF7Tf417S',1,6),
(19,'Lif Imel Wahidatus Solehah',NULL,'$2y$10$g7oROON9uXdady3caoEh6.tsrQ2nvnf3A.02m31tcKpNfQ.Hm3guu',1,6),
(20,'Putri Retno Wosari, S.PdI',NULL,'$2y$10$hPRoe2fsGHccRgsx/ch8z.29T90BVozpJUn4/TFo0aI2/RJfXrRZC',1,6),
(21,'Mikratul Ani, S.Pd',NULL,'$2y$10$yO/4kqNbxDdBpWeBZewkKO7KEswDsK9Maji5zjhWCkThdtX0iRqA2',1,6);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
