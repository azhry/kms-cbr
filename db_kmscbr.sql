-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 16 Feb 2019 pada 15.34
-- Versi Server: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kmscbr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `gejala` text NOT NULL,
  `representasi` int(11) NOT NULL DEFAULT '0',
  `status` enum('Verified','Pending') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `gejala`, `representasi`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Air Hujan Menggenang', 10, 'Verified', '2019-02-04 08:14:14', '2019-02-04 08:14:14'),
(4, 'Tanah Menjadi Lembut', 20, 'Verified', '2019-02-04 08:14:31', '2019-02-04 08:14:31'),
(5, 'Batu Pecah Terpencar', 30, 'Verified', '2019-02-04 08:14:50', '2019-02-04 08:14:50'),
(6, 'Banyak Terdapat Lobang', 10, 'Verified', '2019-02-04 08:15:02', '2019-02-04 08:15:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala_masalah`
--

CREATE TABLE `gejala_masalah` (
  `id` int(11) NOT NULL,
  `id_masalah` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala_masalah`
--

INSERT INTO `gejala_masalah` (`id`, `id_masalah`, `id_gejala`, `created_at`, `updated_at`) VALUES
(8, 3, 3, '2019-02-04 08:16:22', '2019-02-04 08:16:22'),
(9, 3, 4, '2019-02-04 08:16:22', '2019-02-04 08:16:22'),
(10, 4, 5, '2019-02-04 08:16:56', '2019-02-04 08:16:56'),
(11, 4, 4, '2019-02-04 08:16:56', '2019-02-04 08:16:56'),
(12, 5, 5, '2019-02-04 08:17:26', '2019-02-04 08:17:26'),
(13, 5, 6, '2019-02-04 08:17:26', '2019-02-04 08:17:26'),
(14, 6, 4, '2019-02-04 08:18:04', '2019-02-04 08:18:04'),
(15, 6, 3, '2019-02-04 08:18:04', '2019-02-04 08:18:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` tinyint(4) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`, `created_at`, `updated_at`) VALUES
(3, 'Tanaman', '2019-02-01 10:42:51', '2019-02-01 10:42:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_eksplisit`
--

CREATE TABLE `komentar_eksplisit` (
  `id_komentar` int(11) NOT NULL,
  `id_eksplisit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komentar_eksplisit`
--

INSERT INTO `komentar_eksplisit` (`id_komentar`, `id_eksplisit`, `id_pengguna`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'ini komentar', '2019-02-03 12:17:48', '2019-02-03 12:17:48'),
(2, 7, 1, 'ini juga komentar oh', '2019-02-03 12:18:05', '2019-02-03 12:18:05'),
(3, 7, 4, 'test', '2019-02-04 14:45:30', '2019-02-04 14:45:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_tacit`
--

CREATE TABLE `komentar_tacit` (
  `id_komentar` int(11) NOT NULL,
  `id_tacit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komentar_tacit`
--

INSERT INTO `komentar_tacit` (`id_komentar`, `id_tacit`, `id_pengguna`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'asdsad', '2019-02-03 12:22:44', '2019-02-03 12:22:44'),
(2, 2, 4, 'ini komen', '2019-02-04 14:01:34', '2019-02-04 14:01:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `like_eksplisit`
--

CREATE TABLE `like_eksplisit` (
  `id_like` int(11) NOT NULL,
  `id_eksplisit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `like_tacit`
--

CREATE TABLE `like_tacit` (
  `id_like` int(11) NOT NULL,
  `id_tacit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `like_tacit`
--

INSERT INTO `like_tacit` (`id_like`, `id_tacit`, `id_pengguna`, `created_at`, `updated_at`) VALUES
(7, 1, 2, '2019-02-14 15:34:34', '2019-02-14 15:34:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masalah`
--

CREATE TABLE `masalah` (
  `id_masalah` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `masalah`
--

INSERT INTO `masalah` (`id_masalah`, `id_unit`, `judul`, `created_at`, `updated_at`) VALUES
(3, 1, 'M1', '2019-02-04 08:16:22', '2019-02-04 08:16:22'),
(4, 1, 'M2', '2019-02-04 08:16:56', '2019-02-04 08:16:56'),
(5, 1, 'M3', '2019-02-04 08:17:26', '2019-02-04 08:17:26'),
(6, 1, 'M4', '2019-02-04 08:18:04', '2019-02-04 08:18:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_pengetahuan` int(11) NOT NULL,
  `jenis` enum('Tacit','Eksplisit','Tag Tacit','Tag Eksplisit') NOT NULL,
  `deskripsi` text NOT NULL,
  `dilihat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_pengguna`, `id_pengetahuan`, `jenis`, `deskripsi`, `dilihat`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 'Tacit', '', 1, '2019-02-14 14:28:44', '2019-02-16 14:13:05'),
(2, 4, 2, 'Tacit', '', 1, '2019-02-14 14:29:08', '2019-02-16 14:13:05'),
(3, 1, 2, 'Tag Tacit', '', 0, '2019-02-16 11:35:10', '2019-02-16 11:35:10'),
(4, 1, 8, 'Tag Eksplisit', '', 0, '2019-02-16 11:47:12', '2019-02-16 11:47:12'),
(5, 2, 8, 'Tag Eksplisit', '', 0, '2019-02-16 11:47:12', '2019-02-16 11:47:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerima_reward`
--

CREATE TABLE `penerima_reward` (
  `id` int(11) NOT NULL,
  `id_reward` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengetahuan_eksplisit`
--

CREATE TABLE `pengetahuan_eksplisit` (
  `id_eksplisit` int(11) NOT NULL,
  `id_kategori` tinyint(4) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `referensi` text NOT NULL,
  `lampiran` text NOT NULL,
  `status` enum('Valid','Pending') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengetahuan_eksplisit`
--

INSERT INTO `pengetahuan_eksplisit` (`id_eksplisit`, `id_kategori`, `id_pengguna`, `judul`, `keterangan`, `referensi`, `lampiran`, `status`, `created_at`, `updated_at`) VALUES
(7, 3, 1, 'Test', 'Test', 'ref', '44_(1).docx', 'Valid', '2019-02-03 12:04:06', '2019-02-04 14:44:46'),
(8, 3, 4, 'judul', 'keterangan', 'ref', '6347-11058-1-PB.pdf', 'Pending', '2019-02-16 11:41:48', '2019-02-16 11:41:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengetahuan_tacit`
--

CREATE TABLE `pengetahuan_tacit` (
  `id_tacit` int(11) NOT NULL,
  `id_kategori` tinyint(4) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('Valid','Pending') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengetahuan_tacit`
--

INSERT INTO `pengetahuan_tacit` (`id_tacit`, `id_kategori`, `id_pengguna`, `judul`, `isi`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'jduul', 'isiii', 'Valid', '2019-02-03 12:22:28', '2019-02-03 15:14:27'),
(2, 3, 4, 'judul 1e', 'asdasd', 'Valid', '2019-02-04 14:01:14', '2019-02-14 14:29:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nip` char(20) NOT NULL,
  `id_role` tinyint(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `password` char(32) NOT NULL,
  `poin` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nip`, `id_role`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `password`, `poin`, `created_at`, `updated_at`) VALUES
(1, '09021181419007', 1, 'Azhary Arliansyah', 'Laki-laki', 'Palembang', '1996-08-05', '985fabf8f96dc1c4c306341031569937', 0, '2019-02-01 11:36:31', '2019-02-04 13:48:53'),
(2, 'test', 2, 'Tests', 'Laki-laki', 'testr', '3231-12-31', '827ccb0eea8a706c4c34a16891f84e7b', 0, '2019-02-04 09:29:59', '2019-02-04 09:34:12'),
(4, 'user', 3, 'User', 'Laki-laki', 'test', '2122-12-12', '827ccb0eea8a706c4c34a16891f84e7b', 25, '2019-02-04 13:51:32', '2019-02-14 14:29:08'),
(5, 'admin', 4, 'Admin', 'Laki-laki', 'Palembang', '2019-02-03', '827ccb0eea8a706c4c34a16891f84e7b', 0, '2019-02-16 14:32:00', '2019-02-16 14:32:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reward`
--

CREATE TABLE `reward` (
  `id_reward` int(11) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `reward`
--

INSERT INTO `reward` (`id_reward`, `reward`, `poin`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 'Tunjangan Coding', 10, 'Tunjangan sebesar Rp. 2.000.000', '2019-02-04 11:54:23', '2019-02-04 11:54:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` tinyint(4) NOT NULL,
  `role` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `role`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Kasubbid', '', '2019-02-01 11:34:07', '2019-02-01 11:34:07'),
(2, 'Pakar', '', '2019-02-01 11:34:07', '2019-02-01 11:34:07'),
(3, 'Unit', '', '2019-02-01 15:03:19', '2019-02-14 15:51:37'),
(4, 'Admin', '', '2019-02-16 14:31:13', '2019-02-16 14:31:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id_solusi` int(11) NOT NULL,
  `id_masalah` int(11) NOT NULL,
  `solusi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id_solusi`, `id_masalah`, `solusi`, `created_at`, `updated_at`) VALUES
(9, 4, 'Menimbun dengan tanah kering atau batu kerikil', '2019-02-04 08:16:56', '2019-02-04 08:16:56'),
(10, 5, 'Diratakan kembali dengan stombal / alat berat', '2019-02-04 08:17:26', '2019-02-04 08:17:26'),
(11, 6, 'Ditimbun dengan kerikil / batu pecah', '2019-02-04 08:18:04', '2019-02-04 08:18:04'),
(12, 6, 'Kemudian digleder dengan alat berat', '2019-02-04 08:18:04', '2019-02-04 08:18:04'),
(13, 3, 'Menimbun dengan pelepah pohon', '2019-02-15 16:51:36', '2019-02-15 16:51:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tag_eksplisit`
--

CREATE TABLE `tag_eksplisit` (
  `id_tag` int(11) NOT NULL,
  `id_eksplisit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tag_eksplisit`
--

INSERT INTO `tag_eksplisit` (`id_tag`, `id_eksplisit`, `id_pengguna`, `created_at`, `updated_at`) VALUES
(1, 8, 1, '2019-02-16 11:47:12', '2019-02-16 11:47:12'),
(2, 8, 2, '2019-02-16 11:47:12', '2019-02-16 11:47:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tag_tacit`
--

CREATE TABLE `tag_tacit` (
  `id_tag` int(11) NOT NULL,
  `id_tacit` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tag_tacit`
--

INSERT INTO `tag_tacit` (`id_tag`, `id_tacit`, `id_pengguna`, `created_at`, `updated_at`) VALUES
(6, 2, 1, '2019-02-16 11:35:10', '2019-02-16 11:35:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit`
--

CREATE TABLE `unit` (
  `id_unit` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `kode_bagian` varchar(255) NOT NULL,
  `desa` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `unit`
--

INSERT INTO `unit` (`id_unit`, `unit`, `kode_bagian`, `desa`, `created_at`, `updated_at`) VALUES
(1, 'Unit 2', 'BBC', 'HGF', '2019-02-03 12:59:40', '2019-02-15 11:35:02'),
(2, 'Unit 1', 'AAB', 'BCD', '2019-02-15 11:33:49', '2019-02-15 11:33:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `gejala_masalah`
--
ALTER TABLE `gejala_masalah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_masalah` (`id_masalah`),
  ADD KEY `id_gejala` (`id_gejala`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentar_eksplisit`
--
ALTER TABLE `komentar_eksplisit`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_eksplisit` (`id_eksplisit`);

--
-- Indexes for table `komentar_tacit`
--
ALTER TABLE `komentar_tacit`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_tacit` (`id_tacit`);

--
-- Indexes for table `like_eksplisit`
--
ALTER TABLE `like_eksplisit`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_eksplisit` (`id_eksplisit`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `like_tacit`
--
ALTER TABLE `like_tacit`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_tacit` (`id_tacit`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `masalah`
--
ALTER TABLE `masalah`
  ADD PRIMARY KEY (`id_masalah`),
  ADD KEY `id_bagian` (`id_unit`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `penerima_reward`
--
ALTER TABLE `penerima_reward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengetahuan_eksplisit`
--
ALTER TABLE `pengetahuan_eksplisit`
  ADD PRIMARY KEY (`id_eksplisit`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengetahuan_tacit`
--
ALTER TABLE `pengetahuan_tacit`
  ADD PRIMARY KEY (`id_tacit`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`id_reward`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id_solusi`),
  ADD KEY `id_masalah` (`id_masalah`);

--
-- Indexes for table `tag_eksplisit`
--
ALTER TABLE `tag_eksplisit`
  ADD PRIMARY KEY (`id_tag`),
  ADD KEY `id_eksplisit` (`id_eksplisit`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tag_tacit`
--
ALTER TABLE `tag_tacit`
  ADD PRIMARY KEY (`id_tag`),
  ADD KEY `id_tacit` (`id_tacit`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gejala_masalah`
--
ALTER TABLE `gejala_masalah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komentar_eksplisit`
--
ALTER TABLE `komentar_eksplisit`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komentar_tacit`
--
ALTER TABLE `komentar_tacit`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `like_eksplisit`
--
ALTER TABLE `like_eksplisit`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `like_tacit`
--
ALTER TABLE `like_tacit`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `masalah`
--
ALTER TABLE `masalah`
  MODIFY `id_masalah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penerima_reward`
--
ALTER TABLE `penerima_reward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengetahuan_eksplisit`
--
ALTER TABLE `pengetahuan_eksplisit`
  MODIFY `id_eksplisit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengetahuan_tacit`
--
ALTER TABLE `pengetahuan_tacit`
  MODIFY `id_tacit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `id_reward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `solusi`
--
ALTER TABLE `solusi`
  MODIFY `id_solusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tag_eksplisit`
--
ALTER TABLE `tag_eksplisit`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tag_tacit`
--
ALTER TABLE `tag_tacit`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `gejala_masalah`
--
ALTER TABLE `gejala_masalah`
  ADD CONSTRAINT `gejala_masalah_ibfk_1` FOREIGN KEY (`id_masalah`) REFERENCES `masalah` (`id_masalah`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gejala_masalah_ibfk_2` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_eksplisit`
--
ALTER TABLE `komentar_eksplisit`
  ADD CONSTRAINT `komentar_eksplisit_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_eksplisit_ibfk_2` FOREIGN KEY (`id_eksplisit`) REFERENCES `pengetahuan_eksplisit` (`id_eksplisit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_tacit`
--
ALTER TABLE `komentar_tacit`
  ADD CONSTRAINT `komentar_tacit_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_tacit_ibfk_2` FOREIGN KEY (`id_tacit`) REFERENCES `pengetahuan_tacit` (`id_tacit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `like_eksplisit`
--
ALTER TABLE `like_eksplisit`
  ADD CONSTRAINT `like_eksplisit_ibfk_1` FOREIGN KEY (`id_eksplisit`) REFERENCES `pengetahuan_eksplisit` (`id_eksplisit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_eksplisit_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `like_tacit`
--
ALTER TABLE `like_tacit`
  ADD CONSTRAINT `like_tacit_ibfk_1` FOREIGN KEY (`id_tacit`) REFERENCES `pengetahuan_tacit` (`id_tacit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_tacit_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `masalah`
--
ALTER TABLE `masalah`
  ADD CONSTRAINT `masalah_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengetahuan_eksplisit`
--
ALTER TABLE `pengetahuan_eksplisit`
  ADD CONSTRAINT `pengetahuan_eksplisit_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengetahuan_eksplisit_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengetahuan_tacit`
--
ALTER TABLE `pengetahuan_tacit`
  ADD CONSTRAINT `pengetahuan_tacit_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengetahuan_tacit_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD CONSTRAINT `solusi_ibfk_1` FOREIGN KEY (`id_masalah`) REFERENCES `masalah` (`id_masalah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tag_eksplisit`
--
ALTER TABLE `tag_eksplisit`
  ADD CONSTRAINT `tag_eksplisit_ibfk_1` FOREIGN KEY (`id_eksplisit`) REFERENCES `pengetahuan_eksplisit` (`id_eksplisit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_eksplisit_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tag_tacit`
--
ALTER TABLE `tag_tacit`
  ADD CONSTRAINT `tag_tacit_ibfk_1` FOREIGN KEY (`id_tacit`) REFERENCES `pengetahuan_tacit` (`id_tacit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_tacit_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
