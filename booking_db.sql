-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2023 at 11:58 PM
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
-- Database: `booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `ID` int(11) NOT NULL,
  `Start_date` date NOT NULL,
  `Number_of_days` int(11) DEFAULT NULL,
  `Number_of_people` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Hotel_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`ID`, `Start_date`, `Number_of_days`, `Number_of_people`, `User_ID`, `Hotel_ID`) VALUES
(1, '2023-06-19', 3, 2, 10002, 1),
(2, '2023-03-06', 3, 2, 10003, 1),
(3, '2023-03-06', 44, 4, 10003, 1),
(4, '2023-03-07', 100, 1, 10003, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `User_ID` int(11) NOT NULL,
  `Hotel_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `Hotel_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(3000) NOT NULL,
  `Price` int(11) NOT NULL,
  `Images` blob DEFAULT NULL,
  `Number_of_rooms` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Location_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`Hotel_ID`, `Name`, `Description`, `Price`, `Images`, `Number_of_rooms`, `User_ID`, `Location_ID`) VALUES
(1, 'The prime hotel', 'This is the best hotel in the word', 100, NULL, 10, 1, 1),
(2, 'Rogner Hotel', 'A Very Very good hotel. You want be disappointed', 200, NULL, 5, 1, 1),
(3, 'California', 'Just like in Amerika', 1000, NULL, 10, 10002, NULL),
(4, 'One hotel', 'The best place to find a replacing place', 10, NULL, 3, 10002, 1);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `Name` varchar(100) NOT NULL,
  `Location_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`Name`, `Location_ID`) VALUES
('Earth', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `access_level` int(11) NOT NULL,
  `Telephone_Number` varchar(20) DEFAULT NULL,
  `Date_Created` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `username`, `email`, `password`, `access_level`, `Telephone_Number`, `Date_Created`, `firstName`, `lastName`) VALUES
(1, 'techstones', 'kevin@gmail.com', '12345', 0, '333-333-3333', 2017, '0', '0'),
(10002, 'test', 'test@gmail.com', '$2y$10$/QWT7cuQ2I10k482ORkgfO0RfXYghYAi6DnZhoNlv1s/q1KOawkhm', 1, '111-111-1111', 2011, 'Testing', 'Testing'),
(10003, 'twsting', 'a@a.com', '$2y$10$B57trg4iJmck39w/eFEpTOrDYZCj3MFjEwGFNM0Jpp9exr7lmvoE2', 0, '111-111-1111', 2022, 'Kevin', 'Kevin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Hotel_ID` (`Hotel_ID`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Hotel_ID` (`Hotel_ID`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`Hotel_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Location_ID` (`Location_ID`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`Location_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `Username` (`username`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `Hotel_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `Location_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10004;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotels` (`Hotel_ID`);

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotels` (`Hotel_ID`);

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `hotels_ibfk_2` FOREIGN KEY (`Location_ID`) REFERENCES `locations` (`Location_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
