-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 07:35 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms_bit`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `specialization` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `work_hospital` varchar(45) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `doctor_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `specialization`, `phone`, `work_hospital`, `users_id`, `doctor_category_id`) VALUES
(3, 'ENT', '0779776800', 'karapitiya base hospital', 14, 1),
(4, 'Neurology', '0779776808', 'karapitiya base hospital', 21, 3),
(5, 'cardio', '119', 'galle', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `available_date` date DEFAULT NULL,
  `max_appointments` int(11) DEFAULT 5,
  `current_appointments` int(11) DEFAULT 0,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `available_date`, `max_appointments`, `current_appointments`, `doctor_id`) VALUES
(10, '2025-03-11', 20, 0, 3),
(11, '2025-03-14', 20, 0, 3),
(15, '2025-03-12', 5, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_category`
--

CREATE TABLE `doctor_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor_category`
--

INSERT INTO `doctor_category` (`id`, `name`, `price`) VALUES
(1, 'ENT', '3000.00'),
(2, 'Cardiology', '5000.00'),
(3, 'Neurology', '7000.00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `message`, `created_at`, `updated_at`, `patient_id`, `doctor_id`) VALUES
(10, 'huuuuuu', '2025-03-10 12:21:52', '2025-03-10 12:21:52', 6, 14),
(11, 'huu huuuuuuuuuuu', '2025-03-10 12:22:10', '2025-03-10 12:22:10', 6, 14),
(12, 'nice', '2025-03-10 13:03:28', '2025-03-10 13:03:28', 6, 21);

-- --------------------------------------------------------

--
-- Table structure for table `lab_reports`
--

CREATE TABLE `lab_reports` (
  `id` int(11) NOT NULL,
  `test_name` varchar(255) DEFAULT NULL,
  `result` text DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `id` int(11) NOT NULL,
  `diagnosis` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `treatment` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`id`, `diagnosis`, `created_at`, `updated_at`, `doctor_id`, `patient_id`, `treatment`) VALUES
(2, 'eye pain and head pain', '2025-03-09 15:00:11', '2025-03-09 15:00:11', 14, 6, 'get some rest and get panadol and use eye drop'),
(3, 'hand pain', '2025-03-09 15:03:39', '2025-03-09 15:03:39', 21, 6, 'get medicine and regulary check blood preashure and take rest');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `DOB` date DEFAULT NULL,
  `blood_group` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `DOB`, `blood_group`, `phone`, `users_id`) VALUES
(1, '1999-07-15', 'O+', '077 9776809', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(95) NOT NULL,
  `password` varchar(145) DEFAULT NULL,
  `role` enum('admin','doctor','patient','lab_assistant') DEFAULT 'patient',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`, `profile_photo`) VALUES
(1, 'admin', 'user', 'admin@gmail.com', '$2y$10$KLnpMqidaSCRCSTu9d9VBOMnGaJoXoqdi6Bl7sZivl4bLCtDMjpHK', 'admin', 'active', '2025-03-02 13:40:59', '2025-03-02 13:40:59', NULL),
(3, 'chandana', 'perera', 'cardio@gmail.com', '$2y$10$0mWo4FCr58YvgjO0fZ8IVu4Zg70HPg9/pYBOzKT0zUXSEOlxQoJNy', 'doctor', 'active', '2025-03-02 13:52:35', '2025-03-10 09:37:58', NULL),
(4, 'patient', 'user', 'patient@gmail.com', '$2y$10$ojfQSAH2HKm5ngzgQYJbB.U/jk5RGKJd8ghUsRQ/o1ZnELKf8YzJi', 'patient', 'active', '2025-03-03 05:41:59', '2025-03-03 05:41:59', NULL),
(6, 'pasindu', 'Dilmin', 'pdminipura@gmail.com', '$2y$10$9SnD3pZNiyQlgTVAkLhSx.17R2p5IAvhvX9VVdV4uqTkothHyvBBi', 'patient', 'active', '2025-03-03 11:01:09', '2025-03-08 12:51:53', '1741458113.jpg'),
(7, 'pasindu', 'Dilmin', 'pdminipura2@gmail.com', '$2y$10$icb/aRu9HeXydi4WBmdt3uvOgcPn2bfoIjouPe0rARjgzU01kbAzG', 'patient', 'active', '2025-03-03 11:26:10', '2025-03-03 11:26:10', NULL),
(14, 'Upul', 'Perera', 'ENT@gmail.com', '$2y$10$8iNsg1rXYVeTY17G3G0iJ.ZSREqQvSXewSbXrYaL7YjAqrNWSKOmO', 'doctor', 'active', '2025-03-05 12:27:45', '2025-03-07 08:24:46', NULL),
(20, 'pasindu', 'Dilmin', 'p@gmail.com', '$2y$10$9AGdrDwrtFqmKOl90EovT.ocOIvkuSYGYVQBp2H1.I8o5fpJB3HnO', 'patient', 'active', '2025-03-05 12:33:58', '2025-03-05 12:33:58', NULL),
(21, 'neurology', 'doctor', 'neurologist@gmail.com', '$2y$10$FuDXUewZokPufAJ2I4vfNeSj1hYi/TL5X.xwKp4WpQNMHnh4rJV56', 'doctor', 'active', '2025-03-05 12:34:48', '2025-03-05 12:34:48', NULL),
(24, 'ENT', 'Doctor', 'EN@gmail.com', NULL, 'patient', 'active', '2025-03-06 12:47:25', '2025-03-06 12:47:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_appointments_users1_idx` (`patient_id`),
  ADD KEY `fk_appointments_users2_idx` (`doctor_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor_users1_idx` (`users_id`),
  ADD KEY `fk_doctor_doctor_category1_idx` (`doctor_category_id`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqe_doctor_date` (`available_date`,`doctor_id`),
  ADD KEY `fk_doctor_availability_users1_idx` (`doctor_id`);

--
-- Indexes for table `doctor_category`
--
ALTER TABLE `doctor_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_users1_idx` (`patient_id`),
  ADD KEY `fk_feedback_users2_idx` (`doctor_id`);

--
-- Indexes for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lab_reports_users1_idx` (`patient_id`),
  ADD KEY `fk_lab_reports_users2_idx` (`doctor_id`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medical_history_users1_idx` (`doctor_id`),
  ADD KEY `fk_medical_history_users2_idx` (`patient_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_users_idx` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doctor_category`
--
ALTER TABLE `doctor_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lab_reports`
--
ALTER TABLE `lab_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_users1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointments_users2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_doctor_category1` FOREIGN KEY (`doctor_category_id`) REFERENCES `doctor_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_doctor_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD CONSTRAINT `fk_doctor_availability_users1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_users1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_feedback_users2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD CONSTRAINT `fk_lab_reports_users1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lab_reports_users2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `fk_medical_history_users1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medical_history_users2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `fk_patient_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
