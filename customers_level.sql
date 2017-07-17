-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2017 at 06:02 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spa_arima`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers_level`
--

CREATE TABLE `customers_level` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(60) NOT NULL,
  `level_discount` int(3) NOT NULL,
  `level_sequence` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers_level`
--

INSERT INTO `customers_level` (`level_id`, `level_name`, `level_discount`, `level_sequence`) VALUES
(1, 'Normal 10', 10, 1),
(2, 'VIP', 50, 4),
(3, 'Free', 100, 5),
(4, 'Normal 20', 20, 2),
(5, 'Normal 30', 30, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers_level`
--
ALTER TABLE `customers_level`
  ADD PRIMARY KEY (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers_level`
--
ALTER TABLE `customers_level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
