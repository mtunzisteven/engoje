-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2022 at 06:10 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comza`
--

-- --------------------------------------------------------

--
-- Table structure for table `warninglog`
--

CREATE TABLE `warninglog` (
  `warningId` int(11) NOT NULL,
  `warning` varchar(256) NOT NULL,
  `warningLocation` varchar(86) DEFAULT NULL,
  `warningNumber` int(11) NOT NULL,
  `warningDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warninglog`
--

INSERT INTO `warninglog` (`warningId`, `warning`, `warningLocation`, `warningNumber`, `warningDate`) VALUES
(1, 'Undefined variable $n', NULL, 2, '2022-02-01 05:00:59'),
(2, 'Undefined variable $n', NULL, 2, '2022-02-01 05:02:05'),
(3, 'Undefined variable $numnum', NULL, 2, '2022-02-01 05:03:40'),
(4, 'Undefined variable $numnum', 'Main Index', 2, '2022-02-01 05:07:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `warninglog`
--
ALTER TABLE `warninglog`
  ADD PRIMARY KEY (`warningId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `warninglog`
--
ALTER TABLE `warninglog`
  MODIFY `warningId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
