-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3309
-- Generation Time: Jun 16, 2025 at 02:16 PM
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
-- Database: `pedal_malaysia`
--

-- --------------------------------------------------------

--
-- Table structure for table `bicycles`
--

CREATE TABLE `bicycles` (
  `bike_id` int(11) NOT NULL,
  `bike_name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `price_per_hour` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deposit` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bicycles`
--

INSERT INTO `bicycles` (`bike_id`, `bike_name`, `image_url`, `price_per_hour`, `description`, `created_at`, `deposit`) VALUES
(1, 'City Bike', 'city-bicycle.jpg', '10.00', 'A comfortable urban commuter bike.', '2025-06-16 10:38:05', '0.00'),
(2, 'Hybrid Bike', 'hybrid.jpeg', '10.00', 'A mix of road and mountain features.', '2025-06-16 10:38:05', '0.00'),
(3, 'Tandem Bike', 'OIP.jpeg', '10.00', 'Ride together with this 2-seater bike.', '2025-06-16 10:38:05', '0.00'),
(4, 'Cruiser Bike', 'OIP (2).jpeg', '10.00', 'Relaxed riding for leisure.', '2025-06-16 10:38:05', '0.00'),
(5, 'Electric Bike', 'RadRover.jpeg', '10.00', 'Boosted ride with electric motor.', '2025-06-16 10:38:05', '0.00'),
(6, 'Touring Bike', 'touring.jpg', '10.00', 'Perfect for long-distance rides.', '2025-06-16 10:38:05', '0.00'),
(7, 'Mountain Bike', 'OIP (3).jpeg', '10.00', 'Great for off-road trails.', '2025-06-16 10:38:05', '0.00'),
(8, 'Fixie Bike', 'fixie.jpeg', '10.00', 'Single-speed for simplicity.', '2025-06-16 10:38:05', '0.00'),
(9, 'Folding Bike', 'OIP (4).jpeg', '10.00', 'Compact and easy to store.', '2025-06-16 10:38:05', '0.00'),
(12, 'BMX Bike', NULL, '10.00', 'Ideal for stunt riding and off-road tracks.\r\n\r\n', '2025-06-16 18:17:39', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `inquiry_type` varchar(50) DEFAULT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `nric` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `full_name`, `email`, `phone_number`, `nric`, `username`, `created_at`, `password`) VALUES
(6, 2, 'Raudah', 'sitiraudah2011@gmail.com', '0126918961', '030222-14-0648', 'sraudah', '2025-06-16 16:18:10', '$2y$10$aZfztlfx5qRviaBwyt7.z.bZGBdh20MS7Jh5doSKjM3k0sopTBooy'),
(7, 10, 'amirah', 'mira@gmail.com', '0126918961', '03014-14-1444', 'amirahh', '2025-06-16 18:22:25', '$2y$10$7cAO5T91VMTf6xU.FKZbbe5vgC.9ExbrNct4iZqbkJpcXWjAaoWfO'),
(8, 11, 'ardini', 'ardini@gmail.com', '012345678', '030222-14-4615', 'sardini', '2025-06-16 19:53:55', '$2y$10$Zr/3PAoYtVt/FQ1BG.f7geKfGv39X7ca8Dw4XUJ60v3n5TDi1zEai');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `rental_hours` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `booking_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `user_id`, `bike_id`, `booking_date`, `rental_hours`, `total_price`, `created_at`, `booking_time`) VALUES
(2, 10, 2, '2025-06-17', 2, '20.00', '2025-06-16 12:44:21', '11:00:00'),
(3, 11, 1, '2025-06-18', 3, '30.00', '2025-06-16 13:55:04', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'sraudah', '$2y$10$aZfztlfx5qRviaBwyt7.z.bZGBdh20MS7Jh5doSKjM3k0sopTBooy', 'customer'),
(3, 'raudah', 'raudah111', 'admin'),
(4, 'amirah', 'amirah222', 'admin'),
(5, 'aufa', 'aufa333', 'admin'),
(6, 'ardini', 'ardini444', 'admin'),
(7, 'hawa', 'hawa555', 'admin'),
(10, 'amirahh', '$2y$10$7cAO5T91VMTf6xU.FKZbbe5vgC.9ExbrNct4iZqbkJpcXWjAaoWfO', 'customer'),
(11, 'sardini', '$2y$10$Zr/3PAoYtVt/FQ1BG.f7geKfGv39X7ca8Dw4XUJ60v3n5TDi1zEai', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bicycles`
--
ALTER TABLE `bicycles`
  ADD PRIMARY KEY (`bike_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bike_id` (`bike_id`);

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
-- AUTO_INCREMENT for table `bicycles`
--
ALTER TABLE `bicycles`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `bicycles` (`bike_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
