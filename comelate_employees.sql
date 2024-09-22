-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2024 at 09:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal_hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `comelate_employees`
--

CREATE TABLE `comelate_employees` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_terlambat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_security` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `comelate_employees`
--

INSERT INTO `comelate_employees` (`id`, `nik`, `name`, `department`, `shift`, `alasan_terlambat`, `nama_security`, `tanggal`, `jam`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 23116001, 'Devi Patma Febrianti', 'PROD.1', '', 'Telat Berangkat', 'Artikah', '2024-07-01', '07:09:00', '12', NULL, '2024-06-30 17:00:00', NULL),
(2, 22015466, 'Prasasti Geomarca Angguni Mala', 'QC', '', 'Macet Lalulintas', 'Muhamad Ridwan', '2024-07-01', '08:01:00', '12', NULL, '2024-06-30 17:00:00', NULL),
(3, 19084481, 'Sugih Yanto', 'NPI', '', 'Macet Lalulintas', 'Muhamad Ridwan', '2024-07-02', '08:02:00', '12', NULL, '2024-07-01 17:00:00', NULL),
(4, 14051082, 'Devi Permatasary', 'WH', '', 'Telat Berangkat', 'Muhamad Ridwan', '2024-07-02', '08:55:00', '12', NULL, '2024-07-01 17:00:00', NULL),
(5, 15052831, 'Dian Fadillah', 'WH', '', 'Telat Berangkat', 'Wahyu Anggoro', '2024-07-02', '15:10:00', '12', NULL, '2024-07-01 17:00:00', NULL),
(6, 23116001, 'Wuwuh Susilo Putro', 'PROD.1', '', 'Macet Lalulintas', 'Yustinus', '2024-07-03', '07:01:00', '12', NULL, '2024-07-02 17:00:00', NULL),
(7, 23116001, 'Widodo', 'PROD.1', '', 'Telat Berangkat', 'Yustinus', '2024-07-03', '07:15:00', '12', NULL, '2024-07-02 17:00:00', NULL),
(8, 21075167, 'Ratnasari', 'NPI', '', 'Telat Berangkat', 'Yustinus', '2024-07-03', '18:35:00', '12', NULL, '2024-07-02 17:00:00', NULL),
(9, 22085616, 'Suhanto', 'WH', '', 'Telat Berangkat', 'Andry Lestyo', '2024-07-05', '12:31:00', '12', NULL, '2024-07-04 17:00:00', NULL),
(10, 23035848, 'Ully Nuha', 'WH', '', 'Macet Lalulintas', 'Yustinus', '2024-07-06', '17:58:00', '12', NULL, '2024-07-05 17:00:00', NULL),
(11, 21085211, 'Annisa Nurfitria', 'PROD.1', '', 'Macet Lalulintas', 'Erik Ricko Suprapto', '2024-07-06', '17:50:00', '12', NULL, '2024-07-05 17:00:00', NULL),
(12, 14040795, 'Fany Laelasari', 'NPI', '', 'Keperluan Keluarga', 'Wahyu Anggoro', '2024-07-09', '08:03:00', '12', NULL, '2024-07-08 17:00:00', NULL),
(13, 14111902, 'Fikri Haikal', 'PROD.2', '', 'Telat Berangkat', 'Eneng Imas Tuti', '2024-07-10', '07:30:00', '12', NULL, '2024-07-09 17:00:00', NULL),
(14, 24016019, 'Ratnasari', 'PROD.1', '', 'Telat Berangkat', 'Yustinus', '2024-07-10', '07:02:00', '12', NULL, '2024-07-09 17:00:00', NULL),
(15, 22015466, 'Nia', 'QC', '', 'Macet Lalulintas', 'Yustinus', '2024-07-10', '08:03:00', '12', NULL, '2024-07-09 17:00:00', NULL),
(16, 19064404, 'Nicky Lauda', 'IT', '', 'Telat Berangkat', 'Erik Ricko Suprapto', '2024-07-12', '08:18:00', '12', NULL, '2024-07-11 17:00:00', NULL),
(17, 21095220, 'Dwi Indriyani', 'WH', '', 'Macet Lalulintas', 'Aldi Apriadi', '2024-07-13', '07:02:00', '12', NULL, '2024-07-12 17:00:00', NULL),
(18, 19114618, 'Santi Juniarti', 'WH', '', 'Telat Berangkat', 'Aldi Apriadi', '2024-07-13', '15:45:00', '12', NULL, '2024-07-12 17:00:00', NULL),
(19, 23115993, 'Reva Nurul Pauziah', 'PROD.1', '', 'Keperluan Keluarga', 'Erik Ricko Suprapto', '2024-07-15', '12:40:00', '12', NULL, '2024-07-14 17:00:00', NULL),
(20, 14081599, 'Dimas Ari Seno', 'WH', '', 'Telat Berangkat', 'Erik Ricko Suprapto', '2024-07-15', '08:02:00', '12', NULL, '2024-07-14 17:00:00', NULL),
(21, 12110032, 'Medi Rofik', 'Accounting', '', 'Keperluan Keluarga', 'Muhamad Ridwan', '2024-07-15', '08:53:00', '12', NULL, '2024-07-14 17:00:00', NULL),
(22, 21125431, 'Retno Pujiastuti', 'PPC', '', 'Telat Berangkat', 'Yustinus', '2024-07-15', '15:20:00', '12', NULL, '2024-07-14 17:00:00', NULL),
(23, 19064404, 'Nurwan Fariedh', 'IT', '', 'Telat Berangkat', 'Yustinus', '2024-07-18', '15:20:00', '12', NULL, '2024-07-17 17:00:00', NULL),
(24, 19064404, 'Nurwan Fariedh', 'IT', '', 'Telat Berangkat', 'Wahyu Anggoro', '2024-07-18', '08:35:00', '12', NULL, '2024-07-17 17:00:00', NULL),
(25, 21125398, 'Aulia Dinda Permata', 'QC', '', 'Keperluan Keluarga', 'Yustinus', '2024-07-19', '15:05:00', '12', NULL, '2024-07-18 17:00:00', NULL),
(26, 21125411, 'Mutiara Violita', 'QC', '', 'Telat Berangkat', 'Yustinus', '2024-07-19', '15:55:00', '12', NULL, '2024-07-18 17:00:00', NULL),
(27, 23015785, 'Wildan Prakoso', 'NPI', '', 'Telat Berangkat', 'Wahyu Anggoro', '2024-07-19', '08:04:00', '12', NULL, '2024-07-18 17:00:00', NULL),
(28, 23075907, 'Dimas Ari Seno', 'WH', '', 'Telat Berangkat', 'Muhamad Ridwan', '2024-07-20', '07:17:00', '12', NULL, '2024-07-19 17:00:00', NULL),
(29, 14111902, 'Inatsa Latvia', 'PROD.2', '', 'Telat Berangkat', 'Yustinus', '2024-07-22', '07:17:00', '12', NULL, '2024-07-21 17:00:00', NULL),
(30, 15042671, 'Binu Hartoko', 'NPI', '', 'Telat Berangkat', 'Wahyu Anggoro', '2024-07-23', '08:21:00', '12', NULL, '2024-07-22 17:00:00', NULL),
(31, 21115296, 'Daniswara Prayitno', 'PPC', '', 'Telat Berangkat', 'Yustinus', '2024-07-24', '08:43:00', '12', NULL, '2024-07-23 17:00:00', NULL),
(32, 22085623, 'Iqbal Mirza', 'PROD.2', '', 'Macet Lalulintas', 'Andry Lestyo', '2024-07-25', '08:10:00', '12', NULL, '2024-07-24 17:00:00', NULL),
(33, 19084481, 'Irma Hermawati', 'NPI', '', 'Telat Berangkat', 'Eneng Imas Tuti', '2024-07-25', '08:01:00', '12', NULL, '2024-07-24 17:00:00', NULL),
(34, 15022496, 'Nicky Lauda', 'PROD.1', '', 'Macet Lalulintas', 'Muhamad Ridwan', '2024-07-25', '08:25:00', '12', NULL, '2024-07-24 17:00:00', NULL),
(35, 23075907, 'Dimas Ari Seno', 'WH', '', 'Telat Berangkat', 'Andry Lestyo', '2024-07-26', '07:17:00', '12', NULL, '2024-07-25 17:00:00', NULL),
(36, 14111902, 'Novalina Purba', 'PROD.2', '', 'Telat Berangkat', 'Erik Ricko Suprapto', '2024-07-27', '07:17:00', '12', NULL, '2024-07-26 17:00:00', NULL),
(37, 21115296, 'Daniswara Prayitno', 'PPC', '', 'Telat Berangkat', 'Yustinus', '2024-07-29', '08:43:00', '12', NULL, '2024-07-28 17:00:00', NULL),
(38, 22085623, 'Iqbal Mirza', 'PROD.2', '', 'Macet Lalulintas', 'Andry Lestyo', '2024-07-31', '08:10:00', '12', NULL, '2024-07-30 17:00:00', NULL),
(39, 19084481, 'Irma Hermawati', 'NPI', '', 'Telat Berangkat', 'Yustinus', '2024-07-31', '08:01:00', '12', NULL, '2024-07-30 17:00:00', NULL),
(40, 15022496, 'Nicky Lauda', 'PROD.1', '', 'Macet Lalulintas', 'Yustinus', '2024-07-31', '08:25:00', '12', NULL, '2024-07-30 17:00:00', NULL),
(41, 18080019, 'Siti Kuraesin', 'SI', '', 'Keperluan Keluarga', 'Aldi Apriadi', '2024-08-01', '08:57:53', '12', NULL, '2024-08-07 18:29:06', '2024-08-07 18:29:06'),
(42, 21125432, 'Indra Dwi Yanto', 'WH', '', 'Macet Lalulintas', 'Aldi Apriadi', '2024-08-03', '07:12:30', '12', NULL, '2024-08-07 18:30:44', '2024-08-07 18:30:44'),
(43, 14061182, 'Jupentinus Y', 'WH', '', 'Telat Berangkat', 'Aldi Apriadi', '2024-08-03', '07:23:00', '12', NULL, '2024-08-07 18:38:32', '2024-08-07 18:38:32'),
(44, 23075914, 'Nurul Aprilia', 'QC', '', 'Telat Berangkat', 'Yustinus', '2024-08-03', '12:31:00', '12', NULL, '2024-08-07 18:39:19', '2024-08-07 18:39:19'),
(45, 15052831, 'Solihin', 'WH', '', 'Keperluan Keluarga', 'Yustinus', '2024-08-03', '18:00:00', '12', NULL, '2024-08-07 18:42:15', '2024-08-07 18:42:15'),
(46, 21055058, 'Reza Maulana', 'PROD.2', '', 'Macet Lalulintas', 'Yustinus', '2024-08-05', '07:04:00', '12', NULL, '2024-08-07 18:43:11', '2024-08-07 18:43:11'),
(47, 13070569, 'Akhmad Fauzi', 'Admin', '', 'Macet Lalulintas', 'Artikah', '2024-08-05', '08:02:00', '12', NULL, '2024-08-07 18:44:01', '2024-08-07 18:44:01'),
(48, 20014730, 'Syarif Chandra Kurniawan', 'FG', '', 'Cuti Setengah Hari', 'Yustinus', '2024-08-08', '10:03:00', '12', NULL, '2024-08-07 20:39:12', '2024-08-07 20:39:12'),
(49, 22085623, 'Iqbal Mirza', 'Production', '', 'Macet Lalu lintas', 'Andri Lestyo', '2024-08-09', '08:06:00', '17', '17', '2024-08-08 18:11:21', '2024-08-08 18:11:54'),
(50, 24016036, 'Nofan Agung Hp', 'IT', '', 'Macet Lalu lintas', 'Yustinus', '2024-08-09', '08:15:00', '17', '17', '2024-08-08 18:16:47', '2024-08-08 18:17:21'),
(51, 13010064, 'Renny kumala', 'Production', '', 'Cuti Setengah Hari', 'Yustinus', '2024-08-09', '11:50:00', '17', NULL, '2024-08-08 21:52:07', '2024-08-08 21:52:07'),
(52, 22125741, 'Fajar Maulana', 'Prod 2', '', 'Telat berangkat', 'Wahyu Anggoro', '2024-08-09', '15:15:00', '17', '17', '2024-08-09 01:20:36', '2024-08-09 01:21:05'),
(53, 21125432, 'Indra Dwi yanto', 'FG', '', 'Cuti Setengah Hari', 'Yustinus', '2024-08-09', '18:50:00', '17', NULL, '2024-08-09 05:30:34', '2024-08-09 05:30:34'),
(54, 23105983, 'zhiva fazrian ilhami', 'PROD.2', '', 'Keperluan keluarga', 'artikah', '2024-08-10', '13:10:00', '17', '12', '2024-08-09 23:15:31', '2024-08-13 19:58:31'),
(55, 22125758, 'M. Nursaiful Anwar', 'IT', 'Shift 2', 'Cuti Setengah Hari', 'Aldi', '2024-08-13', '17:09:00', '17', '12', '2024-08-13 03:15:58', '2024-08-13 22:00:10'),
(56, 19104601, 'ully nuha', 'PROD.2', 'Shift 1', 'Telat berangkat', 'Aldy apriadi', '2024-08-14', '07:40:00', '17', '12', '2024-08-13 17:43:43', '2024-08-13 21:59:49'),
(57, 12110032, 'Ratnasari', 'Accounting', 'Non Shift', 'Cuti Setengah Hari', 'Husen', '2024-08-14', '09:10:00', '17', '17', '2024-08-13 19:13:20', '2024-08-13 20:20:22'),
(59, 23015785, 'Wildan Prakoso', 'NPI', 'Non Shift', 'Telat Berangkat', 'Andri Lestyo', '2024-08-15', '08:03:00', '17', NULL, '2024-08-14 18:06:37', '2024-08-14 18:06:37'),
(60, 21085174, 'Ismail', 'PROD.1', 'Non Shift', 'Cuti Setengah Hari', 'Yustinus', '2024-08-15', '11:38:00', '17', NULL, '2024-08-14 21:41:38', '2024-08-14 21:41:38'),
(61, 14040795, 'Aris Fariastanto Adi Purnomo', 'NPI', 'Non Shift', 'Macet Lalulintas', 'Andri Lestyo', '2024-08-16', '08:01:00', '17', NULL, '2024-08-15 18:09:11', '2024-08-15 18:09:11'),
(62, 21065084, 'Retno Pujiastuti', 'PROD.1', 'Non Shift', 'Macet Lalulintas', 'Andri Lestyo', '2024-08-16', '08:01:00', '17', NULL, '2024-08-15 18:09:48', '2024-08-15 18:09:48'),
(63, 15042671, 'Binu Hartoko', 'PROD.2', 'Non Shift', 'Macet Lalulintas', 'Andri Lestyo', '2024-08-16', '08:01:00', '17', NULL, '2024-08-15 18:10:20', '2024-08-15 18:10:20'),
(64, 20014730, 'Syarif Chandra Kurniawan', 'FG', 'Shift 2', 'Keperluan Pribadi', 'Wahyu Anggoro', '2024-08-16', '15:25:00', '17', NULL, '2024-08-16 02:44:06', '2024-08-16 02:44:06'),
(65, 17063857, 'Prasasti Geomarca Angguni Mala', 'PROD.1', 'Shift 2', 'Cuti Setengah Hari', 'Husen', '2024-08-20', '16:01:00', '17', NULL, '2024-08-20 02:03:03', '2024-08-20 02:03:03'),
(66, 24016019, 'Adhitya Prasetya Yunanda', 'PROD.1', 'Shift 1', 'Telat Berangkat', 'Andri Lestyo', '2024-08-21', '07:01:00', '17', NULL, '2024-08-20 17:08:34', '2024-08-20 17:08:34'),
(67, 19084481, 'Irma Hermawati', 'NPI', 'Non Shift', 'Telat Berangkat', 'Andri Lestyo', '2024-08-21', '08:02:00', '17', NULL, '2024-08-20 18:03:41', '2024-08-20 18:03:41'),
(68, 14051082, 'Rah Adi Susanto', 'FG', 'Non Shift', 'Telat Berangkat', 'Husen', '2024-08-21', '08:55:00', '17', NULL, '2024-08-20 19:04:43', '2024-08-20 19:04:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comelate_employees`
--
ALTER TABLE `comelate_employees`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comelate_employees`
--
ALTER TABLE `comelate_employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
