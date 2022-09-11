-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2022 at 05:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `misc`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `user_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `pfp` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`name`, `email`, `password`, `pfp`) VALUES
('g4o2', 'g4o2@protonmail.com', '22ef11db0e238b9c8e47404b1cbbacae', NUll),
('Beiop', 'Beiop@Beiop.com', '9538470c5829ba265f5cc2c10be74544', NULL),
('guest', 'guest@guest.com', '1082300051ce843262e8c8b3c278709e', NUll),
('NeroGizmo', 'nero@pi-mail.ml', '520fcd7939ee4d45aceef49b408092d0', NULL),
('MrAnonymous', 'MrAnonymous7122@gmail.com', '3f23037b15413583c3245209e12a3d1b', NULL),
('Wallee', 'Wallee@wallee.com', 'c349c661996b0346bea04e77b89d9cb3', NULL),
('PythonScratcher', 'PythonScratcher@PythonScratcher.com', '24e8bb75267bab880ba2772263c1479e', NULL),
('Elegant', 'Elegant@Elegant.com', 'a5105ed23e989032818a4be075d1a580', NULL),
('Bigjango', 'Bigjango@Bigjango.com', 'f8a04c65d6ffff65c1d3cdb0773189d6', NULL),
('Willfa10', 'Willfa10@Willfa10.com', '0754c1a9517ad4f6bb789222aff97e42', NULL);
--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
