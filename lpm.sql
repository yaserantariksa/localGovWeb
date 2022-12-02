-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2020 at 04:08 PM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.2.34-8+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpm`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `aboutid` int(1) DEFAULT NULL,
  `aboutus` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appmenu`
--

CREATE TABLE `appmenu` (
  `amid` int(5) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_link` varchar(100) NOT NULL,
  `urutan` tinyint(2) NOT NULL,
  `div` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appmenu`
--

INSERT INTO `appmenu` (`amid`, `menu_name`, `menu_link`, `urutan`, `div`) VALUES
(5, 'Gallery', 'galery', 5, 'sf-file-picture'),
(6, 'Tentang Kami', 'tentang', 6, 'sf-map-marker '),
(7, 'Berita', 'berita', 8, 'sf-news '),
(12, 'Data Kelurahan', 'kelurahan/list', 4, 'sf-building');

-- --------------------------------------------------------

--
-- Table structure for table `appsubmenu`
--

CREATE TABLE `appsubmenu` (
  `asmid` int(3) NOT NULL,
  `amid` tinyint(3) NOT NULL,
  `submenu_name` varchar(100) NOT NULL,
  `submenu_link` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `urutan` int(2) NOT NULL,
  `div` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appsubmenu`
--

INSERT INTO `appsubmenu` (`asmid`, `amid`, `submenu_name`, `submenu_link`, `description`, `urutan`, `div`) VALUES
(19, 5, 'List Gallery', 'gallery/list_gallery', '', 1, ''),
(18, 7, 'List Berita', 'news/list_news', '', 1, ''),
(24, 6, 'Tentang Kami', 'aboutus/list_aboutus/1', '', 1, ''),
(31, 12, 'Data Kelurahan', 'kelurahan/data_kelurahan', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `asid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userpass` varchar(255) NOT NULL,
  `user_group` text,
  `user_module` text,
  `is_admin` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `user_store` text,
  `user_permission` text,
  `lastactivity` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`asid`, `pid`, `username`, `userpass`, `user_group`, `user_module`, `is_admin`, `is_active`, `user_store`, `user_permission`, `lastactivity`, `avatar`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_kelurahan`
--

CREATE TABLE `data_kelurahan` (
  `dkid` tinyint(4) NOT NULL,
  `nama_kelurahan` varchar(200) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kelurahan`
--

INSERT INTO `data_kelurahan` (`dkid`, `nama_kelurahan`, `content`) VALUES
(1, 'Ciketing Udik', '<table cellspacing=\"0\" border=\"1\" class=\"table table-responsive\">\n	<colgroup span=\"18\" width=\"85\"></colgroup>\n	<tr>\n		<td  height=\"32\" align=\"center\"><b>No</b></td>\n		<td  align=\"center\"><b>Nama Lengkap </b></td>\n		<td  align=\"center\"><b>Tempat</b></td>\n		<td  align=\"left\"><b> Tanggal Lahir</b></td>\n		<td  align=\"center\"><b>Nomor KTP</b></td>\n		<td  align=\"center\"><b>Warga Negara</b></td>\n		<td  align=\"center\"><b>Jenis kelamin</b></td>\n		<td  align=\"center\"><b>Agama</b></td>\n		<td  align=\"center\"><b>Alamat RT/RW</b></td>\n		<td  align=\"center\"><b>Kelurahan</b></td>\n		<td  align=\"center\"><b>kecanmatan</b></td>\n		<td  align=\"center\"><b>Pendidikan Terakhir</b></td>\n		<td  align=\"center\"><b>Pengalaman Organisasi</b></td>\n		<td  align=\"center\"><b>Jabatan dalam Kepengurusan</b></td>\n		<td  colspan=2 align=\"center\"><b>Lama menjadi PengurusLPM</b></td>\n		<td  align=\"center\"><b>Motto</b></td>\n		<td  align=\"center\"><b>Saran/kritik untuk LPM</b></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\"><b>ADIM SANJAYA</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">05 Agustus 1974</td>\n		<td  align=\"left\">3275070508740009</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 003/006</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMP</td>\n		<td  align=\"left\">Ketua RT</td>\n		<td  align=\"left\">Bidang pendiikan dan Kebudayaan</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"2\" sdnum=\"1033;\">2</td>\n		<td  align=\"left\"><b>ASEP SUHERMAN</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">17 April 1980</td>\n		<td  align=\"left\">3275071704800021</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 002/001</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMK</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\">Bidang Ekonomi dan Pembangunan</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"3\" sdnum=\"1033;\">3</td>\n		<td  align=\"left\"><b>ENCIH SUARASIH</b></td>\n		<td  align=\"left\">Bogor</td>\n		<td  align=\"center\">04 Mei 1972</td>\n		<td  align=\"left\">3275074405720023</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Perempuan</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 001/010</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMK</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\">Bidang UMKM</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"4\" sdnum=\"1033;\">4</td>\n		<td  align=\"left\"><b>FAJAR MAULUDIN</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">06 Desember 1990 </td>\n		<td  align=\"left\">3275070410900005</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 002/003</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMK</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\">Bidang Pemuda dan Olahraga</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"5\" sdnum=\"1033;\">5</td>\n		<td  align=\"left\"><b><font face=\"Calibri\">IYAS SANUSI</b></td>\n		<td  align=\"left\"><font face=\"Calibri\">Bekasi</td>\n		<td  align=\"center\"><font face=\"Calibri\">10 Oktober 1970</td>\n		<td  align=\"left\"><font face=\"Calibri\">3275071010700019</td>\n		<td  align=\"center\"><font face=\"Calibri\">Indonesia</td>\n		<td  align=\"left\"><font face=\"Calibri\">Laki-laki</td>\n		<td  align=\"left\"><font face=\"Calibri\">Islam</td>\n		<td  align=\"center\"><font face=\"Calibri\">RT 003/004</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\"><font face=\"Calibri\">Bantargebang</td>\n		<td  align=\"center\"><font face=\"Calibri\">SMA</td>\n		<td  align=\"left\"><font face=\"Calibri\">Ketua RT</td>\n		<td  align=\"left\"><font face=\"Calibri\">Bidang UMKM</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"6\" sdnum=\"1033;\">6</td>\n		<td  align=\"left\"><b>JAENAL ABIDIN</b></td>\n		<td  align=\"left\">Jakarta</td>\n		<td  align=\"center\">24 Agustus 1974</td>\n		<td  align=\"left\">3275072408740025</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 002/007</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SLTA </td>\n		<td  align=\"left\">Ketua RW</td>\n		<td  align=\"left\">Bidang Kesejahteraan Sosial</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"7\" sdnum=\"1033;\">7</td>\n		<td  align=\"left\"><b>AL ACHMAD KHAMALUTHFI</b></td>\n		<td  align=\"left\">Bogor</td>\n		<td  align=\"center\">06 Desember 1985</td>\n		<td  align=\"left\">3275070612950001</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 003/002</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMK</td>\n		<td  align=\"left\">Karang Taruna </td>\n		<td  align=\"left\">Bidang Humas</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"8\" sdnum=\"1033;\">8</td>\n		<td  align=\"left\"><b>M. NURDIN</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">11 Agustus 1981</td>\n		<td  align=\"left\">3275071108810018</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 001/002</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMK</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\"><font face=\"Calibri\">Sekretaris</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"9\" sdnum=\"1033;\">9</td>\n		<td  align=\"left\"><b>SALIM SAMSUDIN,SE</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">13 April 1984</td>\n		<td  align=\"left\">3275071304840014</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 001/002</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">Strata 1</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\">Ketua LPM</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"10\" sdnum=\"1033;\">10</td>\n		<td  align=\"left\"><b>SOLIM HAMIZ WIJAYA</b></td>\n		<td  align=\"left\">Bekasi</td>\n		<td  align=\"center\">19 Mei 1971</td>\n		<td  align=\"left\">3275071905710001</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 002/005</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMA</td>\n		<td  align=\"left\">Karang Taruna</td>\n		<td  align=\"left\">Wakil ketua</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n	<tr>\n		<td  height=\"18\" align=\"center\" sdval=\"11\" sdnum=\"1033;\">11</td>\n		<td  align=\"left\"><b>NANA SUPRIATNA</b></td>\n		<td  align=\"left\">Subang</td>\n		<td  align=\"center\">13 April 1974</td>\n		<td  align=\"left\">3275071304740009</td>\n		<td  align=\"center\">Indonesia</td>\n		<td  align=\"left\">Laki-laki</td>\n		<td  align=\"left\">Islam</td>\n		<td  align=\"center\">RT 001/006</td>\n		<td  align=\"left\">Ciketingudik</td>\n		<td  align=\"left\">Bantargebang</td>\n		<td  align=\"center\">SMA</td>\n		<td  align=\"left\">Pengurus LPM</td>\n		<td  align=\"left\">Bidang Keagamaan</td>\n		<td  align=\"center\" sdval=\"1\" sdnum=\"1033;\">1</td>\n		<td  align=\"left\">Tahun</td>\n		<td  align=\"left\"><br></td>\n		<td  align=\"left\"><br></td>\n	</tr>\n</table>'),
(2, 'Cikiwul', ''),
(3, 'Sumur Batu', '');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gid` int(6) NOT NULL,
  `kgid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `urutan` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gid`, `kgid`, `filename`, `title`, `urutan`) VALUES
(286, 3, '20201130_photo_-_1444422051.jpeg', '-', '0'),
(285, 3, '20201130_photo_-_492726919.jpeg', '-', '0'),
(284, 4, '20201130_photo_-_378356826.jpeg', '-', '0'),
(283, 4, '20201130_photo_-_97652225.jpeg', '-', '0'),
(282, 4, '20201130_photo_-_441995950.jpeg', '-', '0'),
(273, 5, '20201130_photo_-_269876474.jpeg', '-', '1'),
(274, 5, '20201130_photo_-_247620305.jpeg', '-', '2'),
(275, 5, '20201130_photo_-_1316479033.jpeg', '-', '3'),
(276, 5, '20201130_photo_-_2070875600.jpeg', '-', '0'),
(277, 5, '20201130_photo_-_125750319.jpeg', '-', '0'),
(278, 5, '20201130_photo_-_397281486.jpeg', '-', '0'),
(279, 5, '20201130_photo_-_331876475.jpeg', '-', '0'),
(280, 5, '20201130_photo_-_1335115216.jpeg', '-', '0'),
(281, 4, '20201130_photo_-_1230249132.jpeg', '-', '0'),
(287, 3, '20201130_photo_-_1027706424.jpeg', '-', '0');

-- --------------------------------------------------------

--
-- Table structure for table `kat_gallery`
--

CREATE TABLE `kat_gallery` (
  `kgid` tinyint(3) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kat_gallery`
--

INSERT INTO `kat_gallery` (`kgid`, `nama_kategori`) VALUES
(1, 'Pekerjaan paping blok Rt. 04 rw 01 Triwul III  2020'),
(2, 'Pekerjaan saluran lingkungan Rt. 05 rw.4 Triwulan III  2020'),
(3, 'Pengerjaan saluran lingkungan Rt. 04 rw. 01 Triwulan III  2020'),
(4, 'Perbaikan Jalan Ciketing Udik'),
(5, 'Saluran lingkungan Rt. 03 rw. 05  Triwulan III  2020');

-- --------------------------------------------------------

--
-- Table structure for table `m_submenu`
--

CREATE TABLE `m_submenu` (
  `msid` bigint(20) UNSIGNED NOT NULL,
  `mmid` int(11) DEFAULT NULL,
  `submenu` varchar(100) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `msid_parent` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_display` tinyint(1) DEFAULT '1',
  `segment` smallint(6) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` tinyint(5) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uri` varchar(500) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `images` varchar(200) NOT NULL,
  `pdf` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `content`, `tanggal`, `uri`, `user`, `images`, `pdf`) VALUES
(38, 'Etika Batuk dan Bersin', '<p>MENGAPA ANDA MESTI<br />\nMENUTUP MULUT KETIKA<br />\nBATUK ATAU BERSIN ?</p>\n', '2019-07-29 09:42:59', 'Etika-Batuk-dan-Bersin', NULL, 'about_01.jpg', '20190729_Etika_Batuk_dan_Bersin.pdf'),
(36, '6 LANGKAH CUCI TANGAN', '<p>Ayoo Cuci Tangan...</p>\n', '2019-07-29 09:37:51', '6-LANGKAH-CUCI-TANGAN', NULL, 'about_01.jpg', '20190729_6_LANGKAH_CUCI_TANGAN.pdf'),
(37, 'Penggunaan Antibiotik', '<p>KENAPA BAKTERI MENJADI RESISTEN ?</p>\n\n<p><br />\n1.&nbsp; Dipicu oleh penggunaan antibiotik yang salah<br />\n2.&nbsp; Sering meng-gunakan anti-biotik<br />\n3.&nbsp;&nbsp;Konsumsi makanan yang mengandung residu antibi-otik<br />\n4.&nbsp; Tertular pasien infeksi bakteri</p>\n', '2019-07-29 09:41:41', 'Penggunaan-Antibiotik', NULL, 'about_01.jpg', '20190729_Penggunaan_Antibiotik.pdf'),
(39, 'Inisiasi Menyusui Dini', '<p>Inisiasi Menyusui Dini (IMD) adalah memberikan ASI segera setelah bayi dilahirkan, biasanya dalam waktu 30 menit&mdash;1 jam pasca<br />\nbayi dilahirkan.</p>\n', '2019-07-29 09:44:41', 'IMD-(Inisiasi-Menyusui-Dini)', NULL, 'about_01.jpg', '20190729_IMD_(Inisiasi_Menyusui_Dini).pdf'),
(40, 'Tuberkulosis', '<p>Apa Itu TBC..?</p>\n', '2019-07-29 09:50:43', 'Tuberkulosis-(TBC)', NULL, 'about_01.jpg', '20190729_Tuberkulosis_(TBC).pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tentang`
--

CREATE TABLE `tentang` (
  `tid` int(5) NOT NULL,
  `nama` text NOT NULL,
  `konten` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tentang`
--

INSERT INTO `tentang` (`tid`, `nama`, `konten`) VALUES
(1, 'about', '<div class=\"MsoNormal\" style=\"line-height: 200%; text-align: justify; text-indent: .5in;\">\nPembangunan\nyang baik adalah pembangunan yang dilaksanakan berdasarkan perencanaan dan\nkeinginan masyarakat sehingga akan membawa manfaat yang baik dan bisa dinikmati\noleh masyarakat sebagai salah satu pembangunan.</div>\n<div class=\"MsoNormal\" style=\"line-height: 200%; text-align: justify; text-indent: .5in;\">\nLembaga\nPemberdayaan Masyarakat ( LPM ) yang dibentuk oleh masyarakat dan sebagai mitra\npemerintahan desa mempunyai tugas dan penyusunan rencana pembangunan secara\npartisipatif, mengerahkan swadaya gotong royong masyarakat, melaksanakan dan\npenegendalian pembangunan serta menggali berbagai macam potensi ekonomi, sosial\ndesa. </div>\n<div class=\"MsoNormal\" style=\"line-height: 200%; text-align: justify; text-indent: .5in;\">\nLembaga\nPemberdayaan Masyarakat ( LPM ) mempunyai tugas dan fungsi yang sangat\nstrategis sesuai dengan Peratuan Menteri Dalam Negeri Nomor 5 Tahun 2007\ntentang Pedoman Penataan Lembaga Kemasyarakatan, Lembaga Pemberdayaan\nMasyarakat (LPM) yaitu sebagai lembaga penampung aspirasi masyarakat dalam\npebangunan sehingga perencanaan pembangunan benar-benar atas dasar arus dari\nbawah dan keinginan dari masyarakat atau bersifat <i>Bottom Up planning</i>.\nDalam hal ini LPM diharapkan dapat menjadi motor penggerak dalam menampung\nsegala aspirasi dan semua kebutuhan masyarakat dalam hal perencanaan\npembangunan. Perencanaan partisipatif diharapkan benar-benar diharapkan dengan\nadanya LPM.</div>\n<div class=\"MsoNormal\" style=\"line-height: 200%; text-align: justify; text-indent: .5in;\">\nSelain\nitu LPM juga merupakan lembaga yang menggerakkan dan melestarikan budaya gotong\nroyong masyarakat sebagai bentuk partisipasi masyarakat dalam pembangunan di\ndesanya. Dengan adanya LPM diharapkan dapat menjadi motor penggerak partisipasi\nmasyarakat dalam pelaksanaan pembangunan. Dalam hal ini kelanjutannya\nmenimbulkan perasaan dan anggapan dimasyarakat bahwa pembangunan itu bukan\nhanya milik pemerintah namun juga milik masyarakat secara keseluruhan.</div>\n<div class=\"MsoNormal\" style=\"line-height: 200%; text-align: justify; text-indent: .5in;\">\n<br /></div>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appmenu`
--
ALTER TABLE `appmenu`
  ADD PRIMARY KEY (`amid`);

--
-- Indexes for table `appsubmenu`
--
ALTER TABLE `appsubmenu`
  ADD PRIMARY KEY (`asmid`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`asid`);

--
-- Indexes for table `data_kelurahan`
--
ALTER TABLE `data_kelurahan`
  ADD PRIMARY KEY (`dkid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `kat_gallery`
--
ALTER TABLE `kat_gallery`
  ADD PRIMARY KEY (`kgid`);

--
-- Indexes for table `m_submenu`
--
ALTER TABLE `m_submenu`
  ADD UNIQUE KEY `msid` (`msid`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appmenu`
--
ALTER TABLE `appmenu`
  MODIFY `amid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `appsubmenu`
--
ALTER TABLE `appsubmenu`
  MODIFY `asmid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `asid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `data_kelurahan`
--
ALTER TABLE `data_kelurahan`
  MODIFY `dkid` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;
--
-- AUTO_INCREMENT for table `kat_gallery`
--
ALTER TABLE `kat_gallery`
  MODIFY `kgid` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `m_submenu`
--
ALTER TABLE `m_submenu`
  MODIFY `msid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tentang`
--
ALTER TABLE `tentang`
  MODIFY `tid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
