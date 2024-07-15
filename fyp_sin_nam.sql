-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3304
-- Generation Time: Jul 12, 2024 at 09:46 AM
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
(6, 'Chee Cheong', '2024-07-16', 1234, 'CC@gmail.com', '$2y$10$xgy/sQluwITYBtqjrOTf7eaNgpSQaBmUKfixNmo2yBxwftfdfYKCe', 'New', 'Admin', '2024-07-11 16:33:47', 'UNPAID', 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE `relation` (
  `relation_id` int(11) NOT NULL,
  `relation_name` varchar(255) NOT NULL,
  `appointment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `role`) VALUES
(2, 'Admin Lee', 'admin_sn@gmal.com', '$2y$10$JvcpPIKigD30Nm65JwMKbO9KiO2LebS7vsSwA8vQkiqG4DuxZ08AO', 'Admin'),
(4, 'admin2', 'admin_lee@gmail.com', '$2y$10$vPwZF1xUJV4ZUc5.ZhvpuOpCwafavn0TqVYmRLoRRqQ2uwiB8k3i.', 'Admin'),
(5, 'Doctor123', 'doctor123@gmail.com', '$2y$10$LOZAAHBekZpoxs1ZGhStveJLq4s9W00igailp1acKLWCaTpAVOxru', 'Doctor');

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
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `relation`
--
ALTER TABLE `relation`
  ADD CONSTRAINT `relation_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
