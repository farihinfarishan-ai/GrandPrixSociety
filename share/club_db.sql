-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2026 at 11:36 AM
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
-- Database: `club_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `ann_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`ann_id`, `title`, `content`, `posted_by`, `created_at`, `updated_at`, `image`, `image_url`) VALUES
(1, 'Welcome to Grand Prix Society 2026!', 'We are excited to kick off the new season with our biggest lineup of events yet. Stay tuned for race day announcements and karting sessions.', NULL, '2026-06-21 12:19:51', '2026-06-21 15:28:49', NULL, '/CartClub/image/welcome.jpg'),
(2, 'Sign-ups Now Open for Karting Workshop', 'Limited slots available for our hands-on karting workshop this semester. Register early to secure your spot before seats run out.', NULL, '2026-06-21 12:19:51', '2026-06-21 15:29:36', NULL, '/CartClub/image/cart.png'),
(3, 'National Awards Recap', 'Congratulations to our members for winning 3 national awards this year! Read the full recap of our achievements on campus.', NULL, '2026-06-21 12:19:51', '2026-06-21 15:32:00', NULL, '/CartClub/image/award.avif');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`award_id`, `title`, `description`, `year`, `category`, `created_at`) VALUES
(1, 'Best University Club', NULL, '2025', 'National', '2026-06-21 09:52:41'),
(2, 'Most Active Society', NULL, '2024', 'National', '2026-06-21 09:52:41'),
(3, 'Innovation Award', NULL, '2024', 'Regional', '2026-06-21 09:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `committee`
--

CREATE TABLE `committee` (
  `committee_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `position` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee`
--

INSERT INTO `committee` (`committee_id`, `name`, `position`, `bio`, `photo_url`, `display_order`, `created_at`) VALUES
(1, 'Said Tan', 'President', 'Leading the society into its biggest season yet, with a passion for motorsport strategy and team management.', '/CartClub/image/pres.png', 1, '2026-06-21 16:11:05'),
(2, 'Said Tan', 'Vice President', 'Overseeing events and partnerships, bringing years of motorsport club experience to the table.', '/CartClub/image/vice.png', 2, '2026-06-21 16:11:05'),
(3, 'Said Tan', 'Treasurer', 'Managing the society finances, budgeting, and sponsorship deals.', '/CartClub/image/vice.png', 3, '2026-06-21 16:11:05'),
(4, 'Said Tan', 'Secretary', 'Coordinating communications and official records for the society.', '/CartClub/image/vice3.png', 4, '2026-06-21 16:11:05'),
(5, 'Said Tan', 'Events Director', 'Planning watch parties, track days, and sim racing tournaments all season long.', '/CartClub/image/pres4.png', 5, '2026-06-21 16:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `event_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `location`, `created_by`, `created_at`, `event_time`) VALUES
(1, 'Australian GP Watch Party', NULL, '2026-07-05', 'Lecture Theatre 2', NULL, '2026-06-21 14:36:53', '15:00:00'),
(2, 'Car Mechanic Workshop', NULL, '2026-07-12', 'Pomen Arif', NULL, '2026-06-21 14:36:53', NULL),
(3, 'Track Day at Sepang Circuit', NULL, '2026-07-22', 'Sepang International', NULL, '2026-06-21 14:36:53', '08:00:00'),
(4, 'Go Cart Racing', 'main said tan', '0000-00-00', NULL, NULL, '2026-06-22 11:24:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `joined_date` date DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `address`, `joined_date`, `role`, `created_at`) VALUES
(1, 'Admin1', 'lewis@club.com', 'lewispass', NULL, NULL, NULL, 'admin', '2026-06-15 18:51:37'),
(2, 'Ahmad Faiz', 'ahmadfaiz@gmail.com', 'password', NULL, NULL, NULL, 'user', '2026-06-22 11:05:04'),
(3, 'Alex Percival', 'alex07@gmail.com', 'password2', NULL, NULL, NULL, 'user', '2026-06-22 11:06:30'),
(4, 'Firdaus', 'firdausdanial@gmail.com', 'password3', NULL, NULL, NULL, 'user', '2026-06-22 11:09:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`ann_id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `committee`
--
ALTER TABLE `committee`
  ADD PRIMARY KEY (`committee_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `ann_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `committee`
--
ALTER TABLE `committee`
  MODIFY `committee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
