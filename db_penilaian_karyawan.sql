-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 11:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penilaian_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id_attachment` int(11) NOT NULL,
  `atch1` varchar(255) NOT NULL,
  `atch2` varchar(255) NOT NULL,
  `atch3` varchar(255) NOT NULL,
  `atch4` varchar(255) NOT NULL,
  `atch5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id_attachment`, `atch1`, `atch2`, `atch3`, `atch4`, `atch5`) VALUES
(17, '67f9051c6ebfd.png', '67f9051c6efff.png', '67f9051c6f6d6.png', '', ''),
(20, '180SX RED 1.png', '180SX RED 2.png', '180SX RED 3.png', '', ''),
(21, 'localhost_php_razan_pweb_SiPeka_PenilaianKaryawan_.png', '', '', '', ''),
(23, 'logo.png', '', '', '', ''),
(28, 'infinity1.png', 'infinityBanner.png', 'infinityBannerShade.png', 'infinityLogo.png', ''),
(29, 'Cd Effect Lines Geometric Album Cover (1).png', '', '', '', ''),
(30, 'Pass.png', '', '', '', ''),
(31, 'ALFS-OrderList.pdf', '', '', '', ''),
(32, 'CoverDVD.png', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(11, 'Departemen'),
(12, 'Tech Support'),
(13, 'Bagian Wibu');

-- --------------------------------------------------------

--
-- Table structure for table `jobsheet`
--

CREATE TABLE `jobsheet` (
  `id_jobsheet` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `tasked_at` datetime NOT NULL DEFAULT current_timestamp(),
  `finished_at` datetime DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `status` enum('PENDING','ON PROGRESS','COMPLETED') NOT NULL DEFAULT 'PENDING',
  `id_user` int(11) NOT NULL,
  `references_id` int(11) DEFAULT NULL,
  `attach_result_id` int(11) DEFAULT NULL,
  `current_revision` int(11) NOT NULL DEFAULT 0,
  `is_revision` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobsheet`
--

INSERT INTO `jobsheet` (`id_jobsheet`, `title`, `description`, `tasked_at`, `finished_at`, `deadline`, `status`, `id_user`, `references_id`, `attach_result_id`, `current_revision`, `is_revision`) VALUES
(2, 'buatlah diagram sequence', 'diagram sequence untuk web alfs orderlist', '2025-04-11 16:02:03', '2025-04-16 16:06:18', '2025-04-15 16:02:00', 'COMPLETED', 5, NULL, 31, 0, 0),
(4, 'Game Developmetn', '', '2025-04-11 16:56:41', NULL, '2025-04-17 14:41:00', 'PENDING', 2, 17, NULL, 4, 1),
(5, 'asd', '', '2025-04-11 17:23:53', '2025-04-16 16:04:59', '2025-04-16 17:23:00', 'COMPLETED', 5, NULL, 30, 0, 0),
(15, 'buatlah logo untuk PT. Infinite Genius Solutions', '', '2025-04-15 10:51:53', '2025-04-16 15:59:50', '2025-04-18 10:52:00', 'COMPLETED', 2, NULL, 28, 0, 0),
(16, 'membuat cover dvd', 'buatlah cover dvd untuk aplikasi sipeka\r\n', '2025-04-15 13:48:27', '2025-04-16 16:32:32', '2025-04-17 16:31:00', 'COMPLETED', 2, 21, 32, 1, 1),
(17, 'bikin web INFINITY WORKS', '', '2025-04-16 15:43:59', NULL, '2025-04-18 15:44:00', 'PENDING', 2, NULL, NULL, 0, 0),
(18, 'buatlah manual book siska', 'kayak gini mungkin', '2025-04-16 16:03:24', NULL, '2025-04-17 16:03:00', 'ON PROGRESS', 5, 29, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobsheet_revisions`
--

CREATE TABLE `jobsheet_revisions` (
  `id_revision` int(11) NOT NULL,
  `id_jobsheet` int(11) NOT NULL,
  `revision_count` int(11) NOT NULL DEFAULT 1,
  `previous_status` enum('PENDING','ON PROGRESS','COMPLETED') NOT NULL,
  `revised_at` datetime NOT NULL DEFAULT current_timestamp(),
  `revised_by` int(11) NOT NULL,
  `revision_note` text DEFAULT NULL,
  `karyawan comment` text DEFAULT NULL,
  `previous_result_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobsheet_revisions`
--

INSERT INTO `jobsheet_revisions` (`id_revision`, `id_jobsheet`, `revision_count`, `previous_status`, `revised_at`, `revised_by`, `revision_note`, `karyawan comment`, `previous_result_id`) VALUES
(1, 4, 1, 'COMPLETED', '2025-04-16 11:59:24', 6, '123', '', 20),
(4, 4, 2, 'COMPLETED', '2025-04-16 13:49:27', 6, 'salah lagi euy', '', NULL),
(6, 4, 3, 'COMPLETED', '2025-04-16 14:37:00', 6, 'masih sala brow ah gimana ish', '', NULL),
(7, 4, 4, 'COMPLETED', '2025-04-16 14:41:52', 6, 'salah kamu nih gimana ish', '', NULL),
(8, 16, 1, 'COMPLETED', '2025-04-16 16:31:48', 6, 'kurang lengkap', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telp` varchar(16) NOT NULL,
  `role` enum('Admin','Karyawan','Tim Penilai','KepSek') NOT NULL DEFAULT 'Karyawan',
  `id_divisi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `no_telp`, `role`, `id_divisi`) VALUES
(1, 'theMostPowerfulAdmin', 'realPowerful', 'Powerful Admin', '081238314426', 'Admin', NULL),
(2, 'haranara', 'thisisteto', 'Hafizh Dirgantara', '081315714570', 'Karyawan', 11),
(5, 'LingdaoZhe', 'KoLingdao', 'Muhammad Imam Maulana', '08999307018', 'Karyawan', 12),
(6, 'timPenilai1', 'abcdefghi', 'Penilai 1', '08912938918', 'Tim Penilai', NULL),
(7, 'timPenilai2', 'hijklmnopqrs', 'Penilai 2', '082746261245', 'Tim Penilai', NULL),
(8, 'akunKepSek', 'igasarok', 'Kepala Sekolah', '02278005871', 'KepSek', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id_attachment`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `jobsheet`
--
ALTER TABLE `jobsheet`
  ADD PRIMARY KEY (`id_jobsheet`),
  ADD KEY `id_attachment` (`references_id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `attach_result_id` (`attach_result_id`);

--
-- Indexes for table `jobsheet_revisions`
--
ALTER TABLE `jobsheet_revisions`
  ADD PRIMARY KEY (`id_revision`),
  ADD KEY `id_jobsheet` (`id_jobsheet`),
  ADD KEY `revised_by` (`revised_by`),
  ADD KEY `previous_result_id` (`previous_result_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_divisi` (`id_divisi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id_attachment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobsheet`
--
ALTER TABLE `jobsheet`
  MODIFY `id_jobsheet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobsheet_revisions`
--
ALTER TABLE `jobsheet_revisions`
  MODIFY `id_revision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobsheet`
--
ALTER TABLE `jobsheet`
  ADD CONSTRAINT `jobsheet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `jobsheet_ibfk_2` FOREIGN KEY (`references_id`) REFERENCES `attachments` (`id_attachment`),
  ADD CONSTRAINT `jobsheet_ibfk_3` FOREIGN KEY (`attach_result_id`) REFERENCES `attachments` (`id_attachment`);

--
-- Constraints for table `jobsheet_revisions`
--
ALTER TABLE `jobsheet_revisions`
  ADD CONSTRAINT `jobsheet_revisions_ibfk_1` FOREIGN KEY (`id_jobsheet`) REFERENCES `jobsheet` (`id_jobsheet`),
  ADD CONSTRAINT `jobsheet_revisions_ibfk_2` FOREIGN KEY (`revised_by`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `jobsheet_revisions_ibfk_3` FOREIGN KEY (`previous_result_id`) REFERENCES `attachments` (`id_attachment`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
