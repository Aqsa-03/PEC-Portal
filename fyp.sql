-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2024 at 02:02 PM
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
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignTask`
--

CREATE TABLE `assignTask` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `adminAttachFile` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT NULL,
  `interneeAttachFile` varchar(255) DEFAULT NULL,
  `taskComment` text DEFAULT NULL,
  `internee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignTask`
--

INSERT INTO `assignTask` (`id`, `title`, `description`, `adminAttachFile`, `deadline`, `isDone`, `interneeAttachFile`, `taskComment`, `internee_id`, `created_at`) VALUES
(10, 'tes', 'jkh', '', '2024-08-01', 1, '../uploads/10/submited/ 94609942161.png', 'hello world', 1, '2024-07-31 10:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `completedinternees`
--

CREATE TABLE `completedinternees` (
  `id` int(10) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `ntnNumber` varchar(50) NOT NULL,
  `cnicNo` varchar(20) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `phoneNo` int(10) DEFAULT NULL,
  `dateofBirth` date NOT NULL,
  `graduationYear` int(10) NOT NULL,
  `education` varchar(20) NOT NULL,
  `discipline` varchar(20) NOT NULL,
  `industry` varchar(20) NOT NULL,
  `preferredCity` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `uploadResume` varchar(10000) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirmPassword` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `internship_status` varchar(10) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currentinternees`
--

CREATE TABLE `currentinternees` (
  `id` int(10) NOT NULL DEFAULT 0,
  `fullName` varchar(100) NOT NULL,
  `ntnNumber` varchar(50) NOT NULL,
  `cnicNo` varchar(20) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `phoneNo` int(10) DEFAULT NULL,
  `dateofBirth` date NOT NULL,
  `graduationYear` int(10) NOT NULL,
  `education` varchar(20) NOT NULL,
  `discipline` varchar(20) NOT NULL,
  `industry` varchar(20) NOT NULL,
  `preferredCity` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `uploadResume` varchar(10000) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirmPassword` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `internship_status` varchar(10) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internees`
--

CREATE TABLE `internees` (
  `id` int(10) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `ntnNumber` varchar(50) NOT NULL,
  `cnicNo` varchar(20) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `phoneNo` varchar(15) DEFAULT NULL,
  `dateofBirth` date NOT NULL,
  `graduationYear` int(10) NOT NULL,
  `education` varchar(20) NOT NULL,
  `discipline` varchar(20) NOT NULL,
  `industry` varchar(20) NOT NULL,
  `preferredCity` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `uploadResume` varchar(10000) NOT NULL,
  `password` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `internship_status` varchar(10) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internees`
--

INSERT INTO `internees` (`id`, `fullName`, `ntnNumber`, `cnicNo`, `emailAddress`, `phoneNo`, `dateofBirth`, `graduationYear`, `education`, `discipline`, `industry`, `preferredCity`, `address`, `uploadResume`, `password`, `reset_token`, `registrationTimestamp`, `internship_status`) VALUES
(1, 'Hamza Waheed', '12345/hamza', '8210281954371', 'hamzawaheed057@gmail.com', '3143288112', '2002-02-02', 2024, 'Bachelors', 'Mechanical', 'R&D', 'Islamabad', 'i10', 'uploads/', 'Hamza@1122', NULL, '2024-07-23 11:11:09', 'active'),
(2, 'M Naveed', '12345/naveed', '4892898987890', 'naveed@codehuntspk.com', '33123277889', '2001-07-04', 2024, 'Bachelors', 'Mechanical', 'R&D', 'Islamabad', 'i10', 'uploads/', 'Naveed@1122', NULL, '2024-07-23 11:24:02', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `sno` int(10) NOT NULL,
  `cName` varchar(200) NOT NULL,
  `cNtnNumber` varchar(200) NOT NULL,
  `internees` varchar(200) NOT NULL,
  `discipline` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quitterinternees`
--

CREATE TABLE `quitterinternees` (
  `id` int(10) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `ntnNumber` varchar(50) NOT NULL,
  `cnicNo` varchar(20) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `phoneNo` int(10) DEFAULT NULL,
  `dateofBirth` date NOT NULL,
  `graduationYear` int(10) NOT NULL,
  `education` varchar(20) NOT NULL,
  `discipline` varchar(20) NOT NULL,
  `industry` varchar(20) NOT NULL,
  `preferredCity` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `uploadResume` varchar(10000) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirmPassword` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `internship_status` varchar(10) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signauthority`
--

CREATE TABLE `signauthority` (
  `sno` int(10) NOT NULL,
  `cName` varchar(200) NOT NULL,
  `cNtnNumber` bigint(50) NOT NULL,
  `saName` varchar(200) NOT NULL,
  `saDesignation` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignTask`
--
ALTER TABLE `assignTask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internees`
--
ALTER TABLE `internees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `signauthority`
--
ALTER TABLE `signauthority`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignTask`
--
ALTER TABLE `assignTask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `internees`
--
ALTER TABLE `internees`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `signauthority`
--
ALTER TABLE `signauthority`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
