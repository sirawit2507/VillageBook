-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2026 at 08:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dd_systam`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `STATUS` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `place_id`, `booking_date`, `start_time`, `end_time`, `STATUS`) VALUES
(1, 1, NULL, '2025-12-22', '04:13:00', '05:13:00', 'pending'),
(2, 1, NULL, '2025-12-24', '19:23:00', '22:20:00', 'pending'),
(3, 1, 2, '2025-12-15', '23:28:00', '01:28:00', 'pending'),
(4, 1, 2, '2025-12-15', '23:28:00', '01:28:00', 'pending'),
(5, 1, 1, '2025-12-25', '01:15:00', '02:15:00', 'pending'),
(6, 1, 1, '2025-12-26', '01:17:00', '16:22:00', 'pending'),
(7, 2, 5, '2025-12-25', '12:40:00', '13:40:00', 'pending'),
(8, 2, 3, '2026-01-21', '06:37:00', '06:38:00', 'rejected'),
(9, 3, 4, '2026-01-16', '15:38:00', '16:38:00', 'pending'),
(10, 3, 2, '2026-01-22', '08:30:00', '18:59:00', 'rejected'),
(11, 3, 2, '2026-01-26', '23:09:00', '21:10:00', 'approved'),
(12, 3, 4, '2026-01-25', '17:54:00', '19:51:00', 'approved'),
(13, 7, 3, '2026-01-26', '20:01:00', '21:01:00', 'approved'),
(14, 9, 6, '2026-02-04', '22:22:00', '12:23:00', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `place_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `place_name`, `description`) VALUES
(1, 'สระว่ายน้ำ', NULL),
(2, 'ห้องฟิตเนส', NULL),
(3, 'ศาลาประชาคม', NULL),
(4, 'สนามกีฬา', NULL),
(5, 'ห้องประชุม', NULL),
(6, 'ห้องอบร้อน', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `PASSWORD`, `role`) VALUES
(1, 'game', '$2y$10$TDgrJNFNwmwYOUP2Xd7fW.k5C/kijBKeTn22tDrM1Ik0GFsKjvCTi', 'admin'),
(2, 'gameas', '1234', 'user'),
(3, 'yas123', '123456', 'user'),
(4, 'yas1234', '0123', 'user'),
(5, 'wae', '0000', 'user'),
(7, 'waeloh', '$2y$10$bLfjStOt5UoHeDKjV7UUv.epYp8oST8/I.OSGQzAFZ8onCyzr93/2', 'user'),
(8, 'admin1', '$2y$10$2WAZb39KptahPlkry/c0uePRXYW3NxV12nfvlfuZpqFhgFHZqbPKG', 'admin'),
(9, 'yasta0', '$2y$10$PjpMHkvLZTLfV0dhBrxZPe3.KRkqppF9QqYmFjc1w0YHE7hq8jHDu', 'user'),
(10, 'gaming', '$2y$10$02rdG.qvSluvyVBpWBIzbOI5HL2upyr21XcaDO1yanFoACjuldeDi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
