-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 05:05 PM
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
-- Database: `carpoolingapplication`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `RideID` int(11) DEFAULT NULL,
  `PassengerID` int(11) DEFAULT NULL,
  `BookingTime` datetime DEFAULT NULL,
  `Status` enum('Pending','Confirmed','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`BookingID`, `RideID`, `PassengerID`, `BookingTime`, `Status`) VALUES
(1, 1, 2, '2024-05-09 14:00:00', 'Confirmed'),
(2, 2, 1, '2024-05-11 16:30:00', 'Confirmed'),
(3, 3, 3, '2024-05-14 12:45:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `driverprofile`
--

CREATE TABLE `driverprofile` (
  `DriverID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `LicenseNumber` varchar(50) DEFAULT NULL,
  `CarModel` varchar(100) DEFAULT NULL,
  `CarCapacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driverprofile`
--

INSERT INTO `driverprofile` (`DriverID`, `UserID`, `LicenseNumber`, `CarModel`, `CarCapacity`) VALUES
(1, 1, 'ABC123', 'Toyota Camry', 4),
(2, 3, 'XYZ456', 'Honda Civic', 5),
(3, 2, 'DEF789', 'Ford Explorer', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `NotificationType` varchar(50) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NotificationID`, `UserID`, `NotificationType`, `Message`, `Timestamp`) VALUES
(1, 1, 'BookingRequest', 'You have a new booking request.', '2024-05-09 14:05:00'),
(2, 2, 'BookingConfirmed', 'Your booking has been confirmed.', '2024-05-10 10:05:00'),
(3, 3, 'BookingRequest', 'You have a new booking request.', '2024-05-11 16:35:00'),
(4, 4, 'BookingConfirmed', 'Your booking has been confirmed.', '2024-05-12 11:35:00'),
(5, 3, 'BookingRequest', 'You have a new booking request.', '2024-05-14 12:50:00'),
(6, 2, 'BookingConfirmed', 'Your booking has been confirmed.', '2024-05-15 13:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `PassengerID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `RideID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`PassengerID`, `UserID`, `RideID`) VALUES
(1, 2, 1),
(2, 4, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `Status` enum('Pending','Completed','Failed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `BookingID`, `Amount`, `PaymentMethod`, `Status`) VALUES
(1, 3, 2500.00, 'Credit Card', 'Completed'),
(2, 2, 30000.00, 'PayPal', 'Completed'),
(3, 1, 22000.00, 'Cash', 'Pending'),
(4, 2, 7500.00, 'momo', 'Failed');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `RideID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `RideID`, `Rating`, `Comment`, `Timestamp`) VALUES
(1, 2, 5, 'Great ride, friendly driver!', '2024-05-10 10:00:00'),
(2, 3, 4, 'Comfortable journey, would recommend.', '2024-05-12 11:30:00'),
(3, 1, 3, 'Average experience, could be better.', '2024-05-15 13:15:00'),
(4, 2, 2, 'Disappointing experience, the driver was rude.', '2024-05-11 11:00:00'),
(5, 1, 5, 'Excellent service and smooth ride.', '2024-05-11 09:15:00'),
(7, 3, 4, 'Great ride, highly recommended.', '2024-05-11 08:30:00'),
(8, 1, 3, 'The ride was okay, but could be improved.', '2024-05-11 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `RideID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `DepartureLocation` varchar(100) DEFAULT NULL,
  `Destination` varchar(100) DEFAULT NULL,
  `DepartureTime` datetime DEFAULT NULL,
  `AvailableSeats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`RideID`, `DriverID`, `DepartureLocation`, `Destination`, `DepartureTime`, `AvailableSeats`) VALUES
(1, 1, 'City A', 'City B', '2024-05-10 08:00:00', 3),
(2, 3, 'City C', 'City D', '2024-05-12 10:00:00', 2),
(3, 2, 'City E', 'City F', '2024-05-15 09:30:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `RouteID` int(11) NOT NULL,
  `RideID` int(11) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`RouteID`, `RideID`, `Location`) VALUES
(1, 3, 'kigali city'),
(2, 1, 'kamonyi'),
(3, 1, 'burera'),
(4, 2, 'nyaruguru'),
(5, 2, 'rwinkwavu'),
(6, 3, 'kabarore');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `activation_code` varchar(50) DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `creationdate`, `activation_code`, `is_activated`) VALUES
(1, 'batamuriza', 'phiona', 'phiobatamuriza', 'phiobatamuriza@gmail.com', '0791234555', '$2y$10$XKCj7r0jFO/6bumAp9ntg.kc2icJy9XlUaRvbZXRO2pWGG9Jfjooy', '2024-05-16 14:46:07', '65432', 0),
(2, 'didie', 'ishimwe', 'didieshmw', 'didieishimwe@gmail.com', '0789876542', '$2y$10$1egAV/Qqbsx8kQL3jz1CCO7CeIbP/A1jmjaGDO0EM/.SIwN3/kk82', '2024-05-16 14:47:01', '76543', 0),
(3, 'pierre', 'manirafasha', 'pierrem', 'manirafashapierre@gmail.com', '072345676543', '$2y$10$6ysZLRYl7YU40vGhwFBkRewdoeCgJwvi9hV4LzXh0ynjwu2eCjHNa', '2024-05-16 14:48:00', '12345', 0),
(4, 'kadukuli', 'john', 'kadubili', 'johnkadkl@gmail.com', '07855544423', '$2y$10$94KzVcJzYpFEDlmiyigO3.6be9At99RqslmzzaYqlbCX1ABVb2Oxq', '2024-05-16 14:48:45', '098765', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `VehicleType` varchar(50) DEFAULT NULL,
  `PlateNumber` varchar(20) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `DriverID`, `VehicleType`, `PlateNumber`, `Year`) VALUES
(1, 2, 'Sedan', 'ABC1234', 2019),
(2, 3, 'Sedan', 'XYZ5678', 2020),
(3, 1, 'SUV', 'DEF9876', 2018);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `RideID` (`RideID`),
  ADD KEY `PassengerID` (`PassengerID`);

--
-- Indexes for table `driverprofile`
--
ALTER TABLE `driverprofile`
  ADD PRIMARY KEY (`DriverID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`PassengerID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RideID` (`RideID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `RideID` (`RideID`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`RideID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`RouteID`),
  ADD KEY `RideID` (`RideID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driverprofile`
--
ALTER TABLE `driverprofile`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `PassengerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `RideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `RouteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`RideID`) REFERENCES `rides` (`RideID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`PassengerID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `driverprofile`
--
ALTER TABLE `driverprofile`
  ADD CONSTRAINT `driverprofile_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `passengers_ibfk_2` FOREIGN KEY (`RideID`) REFERENCES `rides` (`RideID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`RideID`) REFERENCES `rides` (`RideID`);

--
-- Constraints for table `rides`
--
ALTER TABLE `rides`
  ADD CONSTRAINT `rides_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `driverprofile` (`DriverID`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`RideID`) REFERENCES `rides` (`RideID`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `driverprofile` (`DriverID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
