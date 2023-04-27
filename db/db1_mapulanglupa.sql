-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2023 at 02:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db1_mapulanglupa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE `tbl_event` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(50) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_description` varchar(100) DEFAULT NULL,
  `event_poster` blob DEFAULT NULL,
  `event_limit` int(11) DEFAULT NULL,
  `event_DateCreated` date DEFAULT NULL,
  `event_Type` varchar(20) DEFAULT NULL CHECK (`event_Type` in ('Seminars','Meeting','Webinar','Sports','Community Service')),
  `event-covered` enum('residents-only','open-for-all') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`event_id`, `event_title`, `event_date`, `event_description`, `event_poster`, `event_limit`, `event_DateCreated`, `event_Type`, `event-covered`) VALUES
(4, 'Dart and Chess Tryout1', '2023-04-20', 'open for all', 0x75706c6f6164732f646172742e6a7067, 50, '2023-04-19', 'Sports', 'open-for-all'),
(7, 'Basketball League', '2023-04-21', 'mahabangdescriptionmahabangdescriptionmahabangdescriptionmahabangdescriptionmahabangdescriptionmahab', 0x75706c6f6164732f686168612e6a7067, 80, '2023-04-19', 'Sports', 'open-for-all'),
(8, 'Sample Seminar', '2023-04-28', 'seminar para sa lahat hahaha', 0x75706c6f6164732f6576656e745f6c6f676f2e706e67, 100, '2023-04-25', 'Seminars', 'open-for-all'),
(9, 'Sample Meeting', '2023-04-17', 'Kunyare meeting', 0x75706c6f6164732f6576656e745f6c6f676f2e706e67, 40, '2023-04-25', 'Meeting', 'open-for-all'),
(10, 'Cyber Security Webinar', '2023-04-19', 'webinar para sayo', 0x75706c6f6164732f6576656e745f6c6f676f2e706e67, 50, '2023-04-25', 'Webinar', 'open-for-all'),
(11, 'Sample Community Service', '2023-04-21', 'Magwawalis lang haha', 0x75706c6f6164732f6576656e745f6c6f676f2e706e67, 51, '2023-04-25', 'Community Service', 'open-for-all'),
(12, 'Linis mo tapat mo', '2023-04-28', 'linis daw hahah', 0x75706c6f6164732f6576656e745f6c6f676f2e706e67, 50, '2023-04-25', 'Community Service', 'residents-only');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_small_occasion`
--

CREATE TABLE `tbl_small_occasion` (
  `request_id` int(11) NOT NULL,
  `request_title` varchar(255) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_description` text DEFAULT NULL,
  `approval_status` varchar(50) DEFAULT 'pending',
  `request_username` varchar(255) DEFAULT NULL,
  `request_email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_small_occasion`
--

INSERT INTO `tbl_small_occasion` (`request_id`, `request_title`, `request_date`, `request_description`, `approval_status`, `request_username`, `request_email`, `first_name`, `last_name`) VALUES
(1, 'Lamay', '2023-04-22', '50 CHAIRS', 'rejected', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit'),
(2, 'Inuman birthday ko', '2023-04-22', '50 kainuman', 'approved', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit'),
(3, 'Speech', '2023-04-21', 'Tanod 10', 'rejected', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit'),
(4, 'Kantahan', '2023-04-27', 'Tanod', 'rejected', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit'),
(5, 'Suntukan', '2023-04-22', 'Suntukan matira matibay 24/7', 'rejected', 'testuser', 'johnpatrickhaguimit@gmail.com', 'John Patrick', 'Haguimit'),
(6, 'Terrorism', '2023-04-29', 'Terrorista 10', 'pending', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit'),
(7, 'E-sports', '2023-04-29', 'Tanod', 'pending', 'testuser', 'random@gmail.com', 'John Patrick', 'Haguimit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','member') NOT NULL,
  `user_resident` enum('non-resident','resident') NOT NULL,
  `user_proof` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `name`, `username`, `email`, `password`, `user_type`, `user_resident`, `user_proof`) VALUES
(1, 'David', 'Ceron', 'David Ceron', 'davidceron17', 'johndavid.ceron117@gmail.com', '$2y$10$zAMUTRwhOO9lNN00jsUb/OepUntxJBqRXz9jYdvD5xUiU6O4ihwUG', 'member', 'resident', NULL),
(2, 'admin', 'admin', 'admin admin', 'admin', 'admin@gmail.com', '$2y$10$ObGEw/3XXKwlAfyMNxTbhOoTtBNAgDkFUUzH5z7I1LTiUgYDMPdtu', 'admin', 'resident', NULL),
(4, 'member1', 'member1', 'member1 member1', 'member1', 'member1@gmail.com', '$2y$10$/oGS9bPh0lrrPBs/SOeTjeZ4TL5KO0LFha2tdVDPbK44Ou.Vakk8C', 'member', 'resident', NULL),
(5, 'guest', 'guest', 'guest guest', 'guest', 'guest@gmail.com', '$2y$10$iZLJn7UAyt5p.6mkpqY56uX131wdomS5ZlF47D.T6IHDC9cgnNq2O', 'member', 'non-resident', NULL),
(6, 'guest1', 'guest1', 'guest1 guest1', 'guest1', 'guest1@gmail.com', '$2y$10$qJLOEvheJ05.fmLeCNb.HeYyQuV9uJ4bTLr.gwi3oXIxzWUmpfssu', 'member', 'non-resident', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_small_occasion`
--
ALTER TABLE `tbl_small_occasion`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_small_occasion`
--
ALTER TABLE `tbl_small_occasion`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
