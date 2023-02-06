-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 02:07 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET GLOBAL general_log = 'ON';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plantdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `growingtime`
--

CREATE TABLE `growingtime` (
  `id` char(36) NOT NULL,
  `plantId` char(36) NOT NULL,
  `daysToGermination` mediumint(1) NOT NULL,
  `datesToHarvest` mediumint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `coldWarmPlant` varchar(4) NOT NULL,
  `plantingDateOffestType` varchar(20) NOT NULL,
  `plantingDateOffestDays` mediumint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plantgrowingrelationship`
--

CREATE TABLE `plantgrowingrelationship` (
  `id` char(36) NOT NULL,
  `plantIdOne` char(36) NOT NULL,
  `plantIdTwo` char(36) NOT NULL,
  `relationship` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plantgrowingzone`
--

CREATE TABLE `plantgrowingzone` (
  `id` char(36) NOT NULL,
  `plantId` char(36) NOT NULL,
  `plantingZoneId` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plantingzone`
--

CREATE TABLE `plantingzone` (
  `id` char(36) NOT NULL,
  `number` char(2) NOT NULL,
  `coldPlantStart` datetime NULL,
  `coldPlantEnd` datetime NULL,
  `warmPlantStart` datetime NULL,
  `warmPlantEnd` datetime NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `zipcode`
--

CREATE TABLE `zipcode` (
  `id` char(36) NOT NULL,
  `zipCode` char(5) NOT NULL,
  `plantingZoneId` char(36) NOT NULL,
  `plantingZoneSub` char(1) NOT NULL,
  `tempRange` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `growingtime`
--
ALTER TABLE `growingtime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantId` (`plantId`);

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plantgrowingrelationship`
--
ALTER TABLE `plantgrowingrelationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantIdOne` (`plantIdOne`),
  ADD KEY `plantIdTwo` (`plantIdTwo`);

--
-- Indexes for table `plantgrowingzone`
--
ALTER TABLE `plantgrowingzone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantId` (`plantId`),
  ADD KEY `plantingZoneId` (`plantingZoneId`);

--
-- Indexes for table `plantingzone`
--
ALTER TABLE `plantingzone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zipcode`
--
ALTER TABLE `zipcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantingZoneId` (`plantingZoneId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `growingtime`
--
ALTER TABLE `growingtime`
  ADD CONSTRAINT `growingtime_ibfk_1` FOREIGN KEY (`plantId`) REFERENCES `plant` (`id`);

--
-- Constraints for table `plantgrowingrelationship`
--
ALTER TABLE `plantgrowingrelationship`
  ADD CONSTRAINT `plantgrowingrelationship_ibfk_1` FOREIGN KEY (`plantIdOne`) REFERENCES `plant` (`id`),
  ADD CONSTRAINT `plantgrowingrelationship_ibfk_2` FOREIGN KEY (`plantIdTwo`) REFERENCES `plant` (`id`);

--
-- Constraints for table `plantgrowingzone`
--
ALTER TABLE `plantgrowingzone`
  ADD CONSTRAINT `plantgrowingzone_ibfk_1` FOREIGN KEY (`plantId`) REFERENCES `plant` (`id`),
  ADD CONSTRAINT `plantgrowingzone_ibfk_2` FOREIGN KEY (`plantingZoneId`) REFERENCES `plantingzone` (`id`);

--
-- Constraints for table `zipcode`
--
ALTER TABLE `zipcode`
  ADD CONSTRAINT `zipcode_ibfk_1` FOREIGN KEY (`plantingZoneId`) REFERENCES `plantingzone` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
