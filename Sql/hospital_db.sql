-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 06:22 AM
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
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled','Pending') NOT NULL,
  `patient_email` varchar(100) NOT NULL,
  `patient_phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_name`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `patient_email`, `patient_phone`) VALUES
(1, 'John Doe', 1, '2025-03-25', '10:30:00', 'Scheduled', 'john.doe@example.com', '9876543210'),
(2, 'Jane Smith', 2, '2025-03-26', '11:00:00', 'Completed', 'jane.smith@example.com', '9876543211'),
(3, 'Mike Johnson', 3, '2025-03-27', '09:15:00', 'Cancelled', 'mike.johnson@example.com', '9876543212'),
(4, 'Emily Davis', 1, '2025-03-28', '14:45:00', 'Completed', 'emily.davis@example.com', '9876543213'),
(5, 'David Brown', 2, '2025-03-29', '16:00:00', 'Scheduled', 'david.brown@example.com', '9876543214');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `email`, `phone`) VALUES
(1, 'Dr. John Smith', 'Cardiologist', 'john.smith@example.com', '9876543210'),
(2, 'Dr. Emily Johnson', 'Dermatologist', 'emily.johnson@example.com', '9876543211'),
(3, 'Dr. Michael Brown', 'Neurologist', 'michael.brown@example.com', '9876543212'),
(4, 'Dr. Sarah Lee', 'Orthopedic Surgeon', 'sarah.lee@example.com', '9876543213'),
(5, 'Dr. David Wilson', 'Pediatrician', 'david.wilson@example.com', '9876543214');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `treatment` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `patient_name`, `contact`, `doctor`, `treatment`, `amount`, `date`) VALUES
(2, 'Jane Smith', '9876543211', 'Dr. John Smith', 'Dental Cleaning', 1200.00, '2025-03-18'),
(3, 'Michael Johnson', '9876543212', 'Dr. Michael Brown', 'Eye Surgery', 25000.00, '2025-03-15'),
(4, 'Emily Davis', '9876543213', 'Dr. Sarah Lee', 'Physical Therapy', 1500.00, '2025-03-12'),
(5, 'Alex Brown', '9876543214', 'Dr. David Wilson', 'MRI Scan', 4500.00, '2025-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `age`, `gender`, `email`, `contact`, `address`) VALUES
(1, 'John Doe', 30, 'Male', 'john.doe@example.com', '9876543210', '123 Main St, New York, NY'),
(2, 'Jane Smith', 25, 'Female', 'jane.smith@example.com', '9876543211', '456 Elm St, Los Angeles, CA'),
(3, 'Michael Johnson', 40, 'Male', 'michael.johnson@example.com', '9876543212', '789 Oak St, Chicago, IL'),
(4, 'Emily Davis', 35, 'Female', 'emily.davis@example.com', '9876543213', '321 Pine St, Houston, TX'),
(5, 'Alex Brown', 28, 'Other', 'alex.brown@example.com', '9876543214', '654 Cedar St, Miami, FL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','moderator') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'john_doe', 'john@example.com', '123', 'admin'),
(2, 'jane_smith', 'jane@example.com', 'hashed_password_456', 'user'),
(3, 'michael_brown', 'michael@example.com', 'hashed_password_789', 'moderator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact` (`contact`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
