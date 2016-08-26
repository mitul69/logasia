-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2016 at 08:29 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logasia`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numberOfVehicles` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `numberOfVehicles`) VALUES
(1, 'Semi-trailer truck', 3),
(2, '20 foot swap-body truck', 4),
(3, '28.5 foot pup trailer', 5);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_request`
--

CREATE TABLE `vehicle_request` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `numberOfVehicles` smallint(6) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicle_request`
--

INSERT INTO `vehicle_request` (`id`, `date`, `numberOfVehicles`, `category_id`, `price`) VALUES
(1, '2016-08-01', 0, 1, 0),
(2, '2016-08-02', 2, 1, 2000),
(3, '2016-08-05', 2, 1, 2000),
(4, '2016-08-03', 2, 1, 2000),
(5, '2016-08-06', 2, 1, 2000),
(6, '2016-08-04', 2, 1, 2000),
(7, '2016-08-06', 0, 2, 0),
(8, '2016-08-07', 0, 2, 0),
(9, '2016-08-08', 0, 2, 0),
(10, '2016-08-09', 0, 2, 0),
(11, '2016-08-10', 0, 2, 0),
(12, '2016-08-11', 0, 2, 0),
(13, '2016-08-12', 0, 2, 0),
(26, '2016-08-06', 0, 3, 0),
(27, '2016-08-07', 0, 3, 0),
(28, '2016-08-08', 0, 3, 0),
(29, '2016-08-01', 0, 2, 0),
(30, '2016-08-02', 0, 2, 0),
(31, '2016-08-03', 0, 2, 0),
(32, '2016-08-04', 0, 2, 0),
(33, '2016-08-05', 0, 2, 0),
(34, '2016-08-13', 0, 2, 0),
(35, '2016-08-14', 0, 2, 0),
(36, '2016-08-15', 0, 2, 0),
(37, '2016-08-16', 0, 2, 0),
(38, '2016-08-17', 0, 2, 0),
(39, '2016-08-18', 0, 2, 0),
(40, '2016-08-19', 0, 2, 0),
(41, '2016-08-20', 0, 2, 0),
(42, '2016-08-21', 0, 2, 0),
(43, '2016-08-22', 0, 2, 0),
(44, '2016-08-23', 0, 2, 0),
(45, '2016-08-24', 0, 2, 0),
(46, '2016-08-25', 0, 2, 0),
(47, '2016-08-26', 0, 2, 0),
(48, '2016-08-27', 0, 2, 0),
(49, '2016-08-28', 0, 2, 0),
(50, '2016-08-29', 0, 2, 0),
(51, '2016-08-30', 0, 2, 0),
(52, '2016-08-02', 0, 3, 0),
(53, '2016-08-01', 0, 3, 0),
(54, '2016-08-07', 2, 1, 2000),
(55, '2016-08-08', 2, 1, 2000),
(56, '2016-08-09', 2, 1, 2000),
(57, '2016-08-10', 2, 1, 2000),
(58, '2016-08-11', 2, 1, 2000),
(59, '2016-08-12', 2, 1, 2000),
(60, '2016-08-13', 2, 1, 2000),
(61, '2016-08-14', 2, 1, 2000),
(62, '2016-08-15', 2, 1, 2000),
(63, '2016-08-16', 2, 1, 2000),
(64, '2016-08-17', 2, 1, 2000),
(65, '2016-08-18', 2, 1, 2000),
(66, '2016-08-19', 2, 1, 2000),
(67, '2016-08-20', 2, 1, 2000),
(68, '2016-08-21', 0, 1, 0),
(69, '2016-08-22', 2, 1, 2000),
(70, '2016-08-23', 2, 1, 2000),
(71, '2016-08-24', 2, 1, 2000),
(72, '2016-08-25', 2, 1, 2000),
(73, '2016-08-26', 0, 1, 0),
(74, '2016-08-27', 0, 1, 0),
(75, '2016-08-28', 0, 1, 0),
(76, '2016-08-29', 0, 1, 0),
(77, '2016-08-30', 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Indexes for table `vehicle_request`
--
ALTER TABLE `vehicle_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24E4D2F012469DE2` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vehicle_request`
--
ALTER TABLE `vehicle_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `vehicle_request`
--
ALTER TABLE `vehicle_request`
  ADD CONSTRAINT `FK_24E4D2F012469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
