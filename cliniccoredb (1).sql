-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 05:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cliniccoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `appointment_time` datetime NOT NULL,
  `status` enum('scheduled','completed','cancelled') DEFAULT 'scheduled',
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `token_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `department_id`, `appointment_time`, `status`, `createdat`, `doctor_id`, `token_number`) VALUES
(2, 6, NULL, '2025-09-25 20:48:00', 'scheduled', '2025-09-20 15:19:08', NULL, NULL),
(6, 6, 1, '2025-09-30 21:25:00', 'scheduled', '2025-09-20 15:55:51', 7, NULL),
(7, 7, 10, '2025-10-30 21:34:00', 'scheduled', '2025-09-20 16:04:11', 11, NULL),
(8, 9, 1, '2025-09-30 19:29:00', 'scheduled', '2025-09-22 13:59:32', 8, NULL),
(9, 10, 8, '2025-10-22 19:33:00', 'scheduled', '2025-09-22 14:03:16', 9, NULL),
(10, 11, 8, '2025-11-21 19:46:00', 'scheduled', '2025-09-22 14:16:50', 9, NULL),
(11, 18, 12, '2025-09-28 10:30:00', 'scheduled', '2025-09-24 07:01:46', 13, NULL),
(12, 19, 12, '2025-09-26 10:00:00', 'scheduled', '2025-09-24 13:23:21', 13, NULL),
(13, 20, 8, '2025-09-30 19:37:53', 'scheduled', '2025-09-24 14:10:42', 9, NULL),
(14, 21, 10, '2025-09-25 20:04:15', 'scheduled', '2025-09-24 14:48:15', 11, NULL),
(15, 22, 12, '2025-10-06 21:00:00', 'scheduled', '2025-09-24 15:23:29', 13, NULL),
(16, 22, 3, '2025-10-04 05:00:00', 'scheduled', '2025-09-24 15:23:46', 6, NULL),
(20, 25, 7, '2025-10-06 10:00:00', 'scheduled', '2025-09-25 05:25:49', 12, NULL),
(22, 23, 1, '2025-10-04 17:00:00', 'scheduled', '2025-09-25 16:06:38', 8, 1),
(24, 21, 8, '2025-09-30 19:37:53', 'scheduled', '2025-09-25 16:09:55', 9, 1),
(26, 24, 1, '2025-10-04 19:00:00', 'scheduled', '2025-10-03 15:08:53', 8, 2),
(27, 24, 10, '2025-10-06 03:00:00', 'scheduled', '2025-10-04 13:40:24', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_slots`
--

CREATE TABLE `appointment_slots` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `slot_time` datetime NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `booked_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_slots`
--

INSERT INTO `appointment_slots` (`id`, `doctor_id`, `slot_time`, `is_booked`, `booked_by`, `created_at`) VALUES
(4, 9, '2025-09-23 10:00:00', 0, NULL, '2025-09-22 16:43:36'),
(5, 9, '2025-09-23 11:00:00', 0, NULL, '2025-09-22 16:43:36'),
(6, 9, '2025-09-23 12:00:00', 0, NULL, '2025-09-22 16:43:36'),
(8, 10, '2025-09-25 10:00:00', 0, NULL, '2025-09-24 05:48:07'),
(9, 11, '2025-09-25 11:00:00', 0, NULL, '2025-09-24 05:48:07'),
(10, 12, '2025-09-25 10:30:00', 1, 16, '2025-09-24 05:48:07'),
(11, 13, '2025-09-26 10:00:00', 1, 19, '2025-09-24 06:54:03'),
(12, 13, '2025-09-27 11:00:00', 1, 17, '2025-09-24 06:54:03'),
(13, 13, '2025-09-28 10:30:00', 1, 18, '2025-09-24 06:54:03'),
(14, 9, '2025-09-30 19:37:53', 1, 20, '2025-09-24 14:09:07'),
(15, 9, '2025-09-30 19:37:53', 1, 21, '2025-09-24 14:09:17'),
(16, 11, '2025-09-25 20:04:15', 1, 21, '2025-09-24 14:34:57'),
(17, 6, '2025-10-03 21:00:00', 0, NULL, '2025-09-24 15:20:41'),
(18, 7, '2025-10-04 07:00:00', 0, NULL, '2025-09-24 15:20:41'),
(19, 8, '2025-10-04 17:00:00', 1, 23, '2025-09-24 15:20:41'),
(20, 10, '2025-10-05 13:00:00', 0, NULL, '2025-09-24 15:20:41'),
(21, 11, '2025-10-05 23:00:00', 0, NULL, '2025-09-24 15:20:41'),
(22, 12, '2025-10-06 09:00:00', 1, 23, '2025-09-24 15:20:41'),
(23, 9, '2025-10-05 03:00:00', 1, 23, '2025-09-24 15:20:41'),
(24, 13, '2025-10-06 19:00:00', 0, NULL, '2025-09-24 15:20:41'),
(25, 6, '2025-10-03 22:00:00', 0, NULL, '2025-09-24 15:20:41'),
(26, 7, '2025-10-04 08:00:00', 0, NULL, '2025-09-24 15:20:41'),
(27, 8, '2025-10-04 18:00:00', 0, NULL, '2025-09-24 15:20:41'),
(28, 10, '2025-10-05 14:00:00', 0, NULL, '2025-09-24 15:20:41'),
(29, 11, '2025-10-06 00:00:00', 0, NULL, '2025-09-24 15:20:41'),
(30, 12, '2025-10-06 10:00:00', 1, 25, '2025-09-24 15:20:41'),
(31, 9, '2025-10-05 04:00:00', 0, NULL, '2025-09-24 15:20:41'),
(32, 13, '2025-10-06 20:00:00', 1, 24, '2025-09-24 15:20:41'),
(33, 6, '2025-10-03 23:00:00', 0, NULL, '2025-09-24 15:20:41'),
(34, 7, '2025-10-04 09:00:00', 0, NULL, '2025-09-24 15:20:41'),
(35, 8, '2025-10-04 19:00:00', 1, 24, '2025-09-24 15:20:41'),
(36, 10, '2025-10-05 15:00:00', 0, NULL, '2025-09-24 15:20:41'),
(37, 11, '2025-10-06 01:00:00', 0, NULL, '2025-09-24 15:20:41'),
(38, 12, '2025-10-06 11:00:00', 0, NULL, '2025-09-24 15:20:41'),
(39, 9, '2025-10-05 05:00:00', 0, NULL, '2025-09-24 15:20:41'),
(40, 13, '2025-10-06 21:00:00', 1, 22, '2025-09-24 15:20:41'),
(41, 6, '2025-10-04 00:00:00', 0, NULL, '2025-09-24 15:20:41'),
(42, 7, '2025-10-04 10:00:00', 0, NULL, '2025-09-24 15:20:41'),
(43, 8, '2025-10-04 20:00:00', 0, NULL, '2025-09-24 15:20:41'),
(44, 10, '2025-10-05 16:00:00', 0, NULL, '2025-09-24 15:20:41'),
(45, 11, '2025-10-06 02:00:00', 0, NULL, '2025-09-24 15:20:41'),
(46, 12, '2025-10-06 12:00:00', 1, 24, '2025-09-24 15:20:41'),
(47, 9, '2025-10-05 06:00:00', 0, NULL, '2025-09-24 15:20:41'),
(48, 13, '2025-10-06 22:00:00', 0, NULL, '2025-09-24 15:20:41'),
(49, 6, '2025-10-04 01:00:00', 0, NULL, '2025-09-24 15:20:41'),
(50, 7, '2025-10-04 11:00:00', 0, NULL, '2025-09-24 15:20:41'),
(51, 8, '2025-10-04 21:00:00', 0, NULL, '2025-09-24 15:20:41'),
(52, 10, '2025-10-05 17:00:00', 0, NULL, '2025-09-24 15:20:41'),
(53, 11, '2025-10-06 03:00:00', 1, 24, '2025-09-24 15:20:41'),
(54, 12, '2025-10-06 13:00:00', 0, NULL, '2025-09-24 15:20:41'),
(55, 9, '2025-10-05 07:00:00', 0, NULL, '2025-09-24 15:20:41'),
(56, 13, '2025-10-06 23:00:00', 0, NULL, '2025-09-24 15:20:41'),
(57, 6, '2025-10-04 02:00:00', 0, NULL, '2025-09-24 15:20:41'),
(58, 7, '2025-10-04 12:00:00', 0, NULL, '2025-09-24 15:20:41'),
(59, 8, '2025-10-04 22:00:00', 0, NULL, '2025-09-24 15:20:41'),
(60, 10, '2025-10-05 18:00:00', 0, NULL, '2025-09-24 15:20:41'),
(61, 11, '2025-10-06 04:00:00', 0, NULL, '2025-09-24 15:20:41'),
(62, 12, '2025-10-06 14:00:00', 0, NULL, '2025-09-24 15:20:41'),
(63, 9, '2025-10-05 08:00:00', 1, 24, '2025-09-24 15:20:41'),
(64, 13, '2025-10-07 00:00:00', 0, NULL, '2025-09-24 15:20:41'),
(65, 6, '2025-10-04 03:00:00', 0, NULL, '2025-09-24 15:20:41'),
(66, 7, '2025-10-04 13:00:00', 0, NULL, '2025-09-24 15:20:41'),
(67, 8, '2025-10-04 23:00:00', 0, NULL, '2025-09-24 15:20:41'),
(68, 10, '2025-10-05 19:00:00', 0, NULL, '2025-09-24 15:20:41'),
(69, 11, '2025-10-06 05:00:00', 0, NULL, '2025-09-24 15:20:41'),
(70, 12, '2025-10-06 15:00:00', 0, NULL, '2025-09-24 15:20:41'),
(71, 9, '2025-10-05 09:00:00', 0, NULL, '2025-09-24 15:20:41'),
(72, 13, '2025-10-07 01:00:00', 0, NULL, '2025-09-24 15:20:41'),
(73, 6, '2025-10-04 04:00:00', 0, NULL, '2025-09-24 15:20:41'),
(74, 7, '2025-10-04 14:00:00', 0, NULL, '2025-09-24 15:20:41'),
(75, 8, '2025-10-05 00:00:00', 0, NULL, '2025-09-24 15:20:41'),
(76, 10, '2025-10-05 20:00:00', 0, NULL, '2025-09-24 15:20:41'),
(77, 11, '2025-10-06 06:00:00', 0, NULL, '2025-09-24 15:20:41'),
(78, 12, '2025-10-06 16:00:00', 0, NULL, '2025-09-24 15:20:41'),
(79, 9, '2025-10-05 10:00:00', 0, NULL, '2025-09-24 15:20:41'),
(81, 6, '2025-10-04 05:00:00', 1, 22, '2025-09-24 15:20:41'),
(82, 7, '2025-10-04 15:00:00', 0, NULL, '2025-09-24 15:20:41'),
(83, 8, '2025-10-05 01:00:00', 0, NULL, '2025-09-24 15:20:41'),
(84, 10, '2025-10-05 21:00:00', 0, NULL, '2025-09-24 15:20:41'),
(85, 11, '2025-10-06 07:00:00', 0, NULL, '2025-09-24 15:20:41'),
(86, 12, '2025-10-06 17:00:00', 0, NULL, '2025-09-24 15:20:41'),
(87, 9, '2025-10-05 11:00:00', 0, NULL, '2025-09-24 15:20:41'),
(88, 13, '2025-10-07 03:00:00', 0, NULL, '2025-09-24 15:20:41'),
(89, 6, '2025-10-04 06:00:00', 0, NULL, '2025-09-24 15:20:41'),
(90, 7, '2025-10-04 16:00:00', 0, NULL, '2025-09-24 15:20:41'),
(91, 8, '2025-10-05 02:00:00', 0, NULL, '2025-09-24 15:20:41'),
(92, 10, '2025-10-05 22:00:00', 0, NULL, '2025-09-24 15:20:41'),
(93, 11, '2025-10-06 08:00:00', 0, NULL, '2025-09-24 15:20:41'),
(94, 12, '2025-10-06 18:00:00', 0, NULL, '2025-09-24 15:20:41'),
(95, 9, '2025-10-05 12:00:00', 0, NULL, '2025-09-24 15:20:41'),
(96, 13, '2025-10-07 04:00:00', 0, NULL, '2025-09-24 15:20:41'),
(97, 13, '2025-09-30 21:00:00', 0, NULL, '2025-09-25 15:56:52'),
(98, 13, '2026-01-25 21:28:00', 1, 23, '2025-09-25 15:58:49');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Neurology', 'Neurology is the medical specialty focused on diagnosing, treating, and managing disorders of the nervous system.', '2025-09-18 01:36:03'),
(3, 'Cardiology', 'Cardiology is the medical specialty focused on the diagnosis and treatment of heart and circulatory system disorders.', '2025-09-18 06:21:49'),
(6, 'Dental', 'Dealing with the teeth, their structure and development, and their diseases.', '2025-09-19 13:43:00'),
(7, 'Ortho', 'Focuses on conditions of the musculoskeletal system.', '2025-09-20 14:27:02'),
(8, 'ENT', 'For year nose and throat.', '2025-09-20 14:28:49'),
(9, 'Gyno', 'Female reproductive system.', '2025-09-20 14:30:14'),
(10, 'Nephro', 'Related with kidneys.', '2025-09-20 14:32:32'),
(11, 'GM', 'General Medicine', '2025-09-20 14:40:28'),
(12, 'Derm', '', '2025-09-24 06:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `license_no` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `full_name`, `department_id`, `specialization`, `license_no`, `created_at`) VALUES
(6, 1, 'Delvin', 3, 'Surgen', '5675', '2025-09-18 15:52:41'),
(7, 1, 'Erics', 1, 'Nothing', '2345', '2025-09-18 15:55:09'),
(8, 1, 'Dr Danish salim', 1, 'MEdicine', '432535', '2025-09-19 08:25:32'),
(9, 20, 'Navas T O', 8, 'Head&Neck Surgen', '2425', '2025-09-20 06:50:54'),
(10, 1, 'Dr. Priya Menon', 9, 'Maternal-Fetal medicine', '657568', '2025-09-20 14:38:56'),
(11, 1, 'Jojo Mathew', 10, 'Chronic kidney disease.', '676789', '2025-09-20 14:42:40'),
(12, 1, 'Sanitha', 7, 'surgery', '967857', '2025-09-22 08:41:19'),
(13, 25, 'Supriya Menon', 12, 'MD', '21324235', '2025-09-24 06:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('unpaid','paid','partial') DEFAULT 'unpaid',
  `createdat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'male',
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `dob`, `gender`, `phone`, `email`, `password`, `address`, `createdat`, `department_id`, `doctor_id`) VALUES
(5, 'Varun', 'Nair', '2025-09-12', 'male', '3436578', 'varun@gmail.com', NULL, 'Varun house ,Tvm', '2025-09-20 14:53:42', 8, 9),
(6, 'Hardik', 'Pandya', '2025-09-05', 'male', '3245677', 'hardik@gmail.com', NULL, 'Hardik,Mumbai', '2025-09-20 15:18:36', 1, 7),
(7, 'Ishan', 'Kishan', '2025-09-06', 'male', '48656975', 'ishan@gmail.com', NULL, 'Ishan,Mumbai', '2025-09-20 15:38:56', 10, 11),
(8, 'erics', 'ghtr', '2025-09-12', 'male', '6586598', 'erics@gmail.com', NULL, 'rsyjydtikyrkudtlktdl', '2025-09-22 05:56:25', 1, 8),
(9, 'Abdul', '', '2025-09-05', 'male', '', 'abdul@gmail.com', NULL, '', '2025-09-22 13:58:55', 1, 8),
(10, 'Afrdi', '', '2025-09-29', 'male', '54647437', 'afridi@gmail.com', NULL, '', '2025-09-22 14:02:25', 8, 9),
(11, 'Aromal', '', '2024-02-07', 'male', '3563', 'aromal@gmail.com', NULL, '', '2025-09-22 14:16:22', 8, 9),
(12, 'Anurag', '', '2025-05-21', 'male', '477665545', 'anurag@gmail.com', '$2y$10$Xyst9S7/LB0FMxU534dJM.273jcOhNFalS8eTVNbCP7YyXutqbUii', 'retyeyytr', '2025-09-23 16:01:21', 8, 9),
(13, 'Vimal', '', '2025-09-02', 'male', '', 'vimal@gmail.com', '$2y$10$LEZp2iti9T61em1PfTmXEeXJljbxpFGUbcNOkkXyHQLmy3rDoR.UO', 'yte', '2025-09-23 16:06:26', 9, 10),
(14, 'Ravi', '', '2025-02-19', 'male', '4578568', 'ravi@gmail.com', '$2y$10$z7YJerueCCIPz8oI.BKJ1ebUlF02n5iFQt.cVYWH80SEndhWAptpu', 'rerttrc', '2025-09-23 16:10:05', 8, 9),
(15, 'Joseph', '', '2024-09-29', 'male', '986865', 'joseph@gmail.com', '$2y$10$nSOPKbD5ttlbXJZjAP47H.vU1fzudQYI.2zGKQ0HFCpSmjotaAgmi', '', '2025-09-24 05:50:56', 9, 10),
(16, 'Mariya', '', '2005-07-16', 'male', '', 'mariya@gmail.com', '$2y$10$ycVlliNjwJbcCkOuOSl3FeMnEZau11twmjYtNJSqX11kY1oaZrNNa', '', '2025-09-24 06:08:39', 7, 12),
(17, 'Mrunal', '', '2025-09-09', 'male', '', 'mrunal@gmail.com', '$2y$10$4J/ZT7RVC4cWzEMOX2pGKeVo.IoAL7NNC7tghRktf.k/kSs5/7JQi', 'Eranakulam', '2025-09-24 06:54:28', 12, 13),
(18, 'indu', '', '2025-09-02', 'female', '', 'indu@gmail.com', '$2y$10$uvNHBwYa1TXRB/m.TedeFOy5iSF4HahbcPIq8m33AVeWmuP1Qyhx2', 'Induu', '2025-09-24 07:01:38', 12, 13),
(19, 'Parvathi', '', '2025-05-21', 'female', '897674235677', 'parvathi@gmail.com', '$2y$10$SPAokgu7VshzMlMzy7ERouHUhnBY7duXLRhsWAja3mWQo4DKQfX4.', 'Kailasam', '2025-09-24 13:23:14', 12, 13),
(20, 'Anoop', '', '2025-08-21', 'male', '897907', 'anoop@gmail.com', '$2y$10$o2brw.g6wcpEzuedQkQjQ.i/fSqNWAavhcwxCPJuU0apMmSjXsD1.', '', '2025-09-24 14:10:40', 8, 9),
(21, 'Rithu', '', '2025-06-05', 'female', '895679695', 'rithu@gmail.com', '$2y$10$7kmnGPqemfvNVwbQFWCRsOGQxECRg44wKG7ZGago7eSrN7EnbQaSu', '', '2025-09-24 14:45:01', 10, 11),
(22, 'Merina', '', '2025-11-12', 'female', '5676589', 'merina@gmail.com', '$2y$10$fqw8cy7CWlEhspi/b77f8ubsU09IoOkv3LNUS.wtYeOJhyeHlezNa', 'Calicut.', '2025-09-24 15:23:00', 12, 13),
(23, 'Eva', '', '2025-05-16', 'female', '5453464', 'eva@gmail.com', '$2y$10$wxVWCJT3G5WaKqqIb.ygAeN2lzYR7d2nT116yvz3kTCtlIsdk8NAC', 'Texas.', '2025-09-24 15:36:11', 8, 9),
(24, 'Eve', '', '0000-00-00', 'female', '7473574', 'eve@gmail.com', '$2y$10$gfqGJgPc1DfstPLcUPi2fOjLYtSHcgAXtvolNQE0EvTWgheVgR6R2', '', '2025-09-24 15:52:49', 10, 11),
(25, 'Kannan', 'sami', '2001-08-06', 'male', '3537295352', 'kannan@gmail.com', '$2y$10$I41AKrAMw7CR4NUQOvOfVOJwwQ0sMIIM8jOvTB4EjTdlY4Mw4reoa', 'kottayam', '2025-09-25 05:25:14', 7, 12),
(26, 'Modi', '', '2025-01-30', 'male', '5656352323', 'modi@gmail.com', '$2y$10$IzyDUzOpjS9KC5V.hikkZ.8rpEBfQrUEdg/QkdOv96Zl9xaqvDQCy', '', '2025-09-30 14:06:40', 12, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','staff') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `phone`, `createdat`) VALUES
(1, 'Admin', 'User', 'admin@example.com', '$2y$10$EwIrlMDp35sl6NhSjRvx4.gGJ4ER79lgBj2P3frj/b2LpftLy0T1m', 'admin', NULL, '2025-09-17 14:28:52'),
(5, 'Dr', 'Renjith', 'renjitth@123', '$2y$10$JGEalVpK1od/MaXsnXBNc.fpISSrvbWt4cwegPGhL8UtjR.qO8poq', 'doctor', '6758569', '2025-09-19 09:51:11'),
(6, 'Erisk mon', '', 'erisj@1lkljhit', '$2y$10$TfIkuj8oY5BI6H.wKsV4POvdk3CRKM3iJb2bOMh46veCumkpY2BYG', '', '6547', '2025-09-19 09:51:54'),
(11, 'sdgh', 'agsreyh', 'asrf@gmail.com', '$2y$10$pGwc9GANdOlyVWnXrpANluBKt/uOzqMNTgtaYu9DqP/8bLp2wGugi', '', '1', '2025-09-19 16:38:57'),
(13, 'alaan', 'eeer', 'alan1@gmai.com', '$2y$10$YKQBEBzYEjYsgNzJv79fqOI8Tq8o.AnvpTiT6dZC5lReffDqVNtW6', '', '1', '2025-09-19 16:40:14'),
(14, 'dr', 'benjamin luis', 'ben@gmail.com', '$2y$10$yRyp3FZh95WpPtiG8nMPCuY3TGPZLMuKo7u7vEn6W3CUnez8/9KFW', 'doctor', '1', '2025-09-20 04:36:38'),
(18, 'Lionel', 'messi', 'leo@gmail.com', '$2y$10$AZWtRK4c.hYYCLYCr.mYqOBnDgxff0.d9PRBE.iiWxwHi8oN21i2O', '', '33462436', '2025-09-20 06:22:03'),
(19, 'Mathew', 'Abraham', 'mathewabraham@gmail.com', '$2y$10$ahBwQ7lQJkbL6R78qh7AvOoN5RGuQ88WHhI7FRedESIVwBHBRXPMS', 'doctor', '9807643471', '2025-09-20 06:31:47'),
(20, 'Navas', 'T O', 'navas@gmail.com', '$2y$10$BRWObJ1.BTxMSnSbK3fzA.ioRhZtY6de/lVfLIBgAZvlaoSwKf9fC', 'doctor', '097587975', '2025-09-20 06:50:54'),
(21, 'Anil', 'kumar', 'anil@gmail.com', '$2y$10$Zlt7UNyfEQ8Ieh/erORqVuMWt/lyEDBKWfQfVa0jmQgvWJIvBQJSi', '', '0987077', '2025-09-20 10:46:32'),
(22, 'manu', 'jose', 'manu@gmail.com', '$2y$10$9YNDsJp54KiXrJkFuk9BX.Hd0C508L40MW9Vt/wYyR52sKu/iul4a', '', '9786', '2025-09-22 06:59:46'),
(23, 'Surya', 'yadav', 'sky@gmail.com', '$2y$10$TFiITuAtSVwHf7J26HsLFuAkokd5gH0ku1pHqaZLgflihb.PUOLcO', '', '7689433', '2025-09-22 08:04:34'),
(24, 'Amal', 'Devis', 'amaldevis@gmail.com', '$2y$10$QynCvnVOGMwNJGxQ2/wg8eWiCuOGyFuUD1HpNhQ4Rr6BShcJVPWje', 'staff', '56765456', '2025-09-22 08:27:59'),
(25, 'Supriya', 'Menon', 'supriyagmail.@gmail.com', '$2y$10$bkktwomjY307Zi9WbaJqfO6FwCswZCNt1/.B/EGr6lyXlYuNoJo3W', 'doctor', '786970870', '2025-09-24 06:41:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_appointments_doctor` (`doctor_id`),
  ADD KEY `fk_appointments_department` (`department_id`);

--
-- Indexes for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `booked_by` (`booked_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_appointments_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointments_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  ADD CONSTRAINT `appointment_slots_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
