-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 10, 2024 at 06:44 AM
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
-- Database: `fyp_sin_nam`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_start_time` time NOT NULL,
  `appointment_end_time` time NOT NULL,
  `appointment_status` varchar(45) NOT NULL DEFAULT 'UPCOMING',
  `booked_by` varchar(255) NOT NULL,
  `booked_datetime` datetime NOT NULL,
  `patient_id` int(11) NOT NULL,
  `queue_no` int(11) NOT NULL,
  `appointment_remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `appointment_date`, `appointment_start_time`, `appointment_end_time`, `appointment_status`, `booked_by`, `booked_datetime`, `patient_id`, `queue_no`, `appointment_remarks`) VALUES
(9, '2024-06-27', '12:00:00', '12:30:00', 'UPCOMING', 'pookie', '2024-06-14 07:00:50', 1, 0, NULL),
(10, '2024-06-27', '14:00:00', '14:15:00', 'UPCOMING', 'lebron', '2024-06-14 07:02:10', 2, 0, NULL),
(14, '2024-06-28', '12:00:00', '12:30:00', 'UPCOMING', 'pookie', '2024-06-15 10:42:31', 1, 0, NULL),
(15, '2024-07-02', '15:30:00', '16:00:00', 'UPCOMING', 'pookie', '2024-06-16 08:19:13', 1, 0, NULL),
(33, '2024-07-03', '15:00:00', '15:30:00', 'CANCELLED', 'pookie', '2024-06-22 09:29:46', 1, 0, NULL),
(35, '2024-08-09', '13:30:00', '14:00:00', 'CANCELLED', 'pookie', '2024-06-23 10:43:48', 1, 0, NULL),
(39, '2024-07-04', '12:30:00', '13:00:00', 'CANCELLED', 'pookie', '2024-07-03 10:10:57', 1, 0, NULL),
(40, '2024-07-10', '12:00:00', '12:30:00', 'COMPLETED', 'pookie', '2024-07-08 13:53:00', 1, 0, NULL),
(41, '2024-07-09', '12:30:00', '13:00:00', 'UPCOMING', 'pookie', '2024-07-08 13:57:18', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `holiday_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `holiday_name`, `holiday_date`) VALUES
(1, 'New Year\'s Day', '2024-01-01'),
(2, 'Chinese New Year', '2024-02-10'),
(3, 'Chinese New Year', '2024-02-11'),
(4, 'Good Friday', '2024-03-29'),
(5, 'Hari Raya Puasa', '2024-04-10'),
(6, 'Labour Day', '2024-05-01'),
(7, 'Vesak Day', '2024-05-22'),
(8, 'Hari Raya Haji', '2024-06-17'),
(9, 'National Day', '2024-08-09'),
(10, 'Deepavali', '2024-10-31'),
(11, 'Christmas Day', '2024-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_dob` date NOT NULL,
  `patient_phoneNo` int(11) NOT NULL,
  `patient_email` varchar(255) NOT NULL,
  `patient_password` varchar(255) NOT NULL,
  `patient_status` varchar(45) NOT NULL DEFAULT 'NEW',
  `last_updated_by` varchar(255) NOT NULL,
  `last_updated_datetime` datetime NOT NULL,
  `payment_status` varchar(45) NOT NULL,
  `amount_payable` float NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_name`, `patient_dob`, `patient_phoneNo`, `patient_email`, `patient_password`, `patient_status`, `last_updated_by`, `last_updated_datetime`, `payment_status`, `amount_payable`, `is_verified`) VALUES
(1, 'pookie', '2014-04-08', 12345678, 'pookie@gmail.com', 'Password234', 'NEW', '', '2024-06-09 10:15:03', '', 0, 0),
(2, 'lebron', '2014-04-10', 56784321, 'lebron@gmail.com', 'Password12345', 'CURRENT', '', '2024-06-09 10:18:38', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE `relation` (
  `relation_id` int(11) NOT NULL,
  `relation_name` varchar(255) NOT NULL,
  `appointment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`relation_id`, `relation_name`, `appointment_id`) VALUES
(1, 'friend', 14);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `settings_key` varchar(255) NOT NULL,
  `settings_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `settings_key`, `settings_value`) VALUES
(1, 'weekday_open_time', '11.00'),
(2, 'weekday_close_time', '16.30'),
(3, 'weekend_open_time', '10.30'),
(4, 'weekend_close_time', '16.30'),
(5, 'opening_days', 'Tuesday, Wednesday, Thursday, Friday, Saturday'),
(9, 'appointment_duration', '15'),
(10, 'new_appointment_duration', '30'),
(11, 'last_queue_no', '01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`relation_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `relation`
--
ALTER TABLE `relation`
  ADD CONSTRAINT `relation_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
