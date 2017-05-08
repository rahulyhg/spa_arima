-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2017 at 06:58 AM
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
-- Table structure for table `customers_expired`
--

CREATE TABLE `customers_expired` (
  `ex_id` int(11) NOT NULL,
  `ex_cus_id` int(11) NOT NULL,
  `ex_start_date` date NOT NULL,
  `ex_end_date` date NOT NULL,
  `ex_updated` datetime NOT NULL,
  `ex_emp_id` int(11) NOT NULL,
  `ex_status` enum('run','expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers_expired`
--

INSERT INTO `customers_expired` (`ex_id`, `ex_cus_id`, `ex_start_date`, `ex_end_date`, `ex_updated`, `ex_emp_id`, `ex_status`) VALUES
(1, 1, '2015-09-02', '2016-09-02', '2017-05-08 10:16:20', 6, 'expired'),
(2, 2, '2016-04-10', '2017-04-10', '2017-05-08 10:46:25', 6, 'expired'),
(3, 3, '2016-11-29', '2017-11-29', '2017-05-08 10:49:05', 6, 'run'),
(4, 4, '2016-08-08', '2017-08-08', '2017-05-08 11:09:34', 6, 'run'),
(5, 5, '2014-06-09', '2015-06-09', '2017-05-08 11:10:26', 6, 'expired'),
(6, 6, '2014-07-05', '2015-07-05', '2017-05-08 11:11:15', 6, 'expired');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers_expired`
--
ALTER TABLE `customers_expired`
  ADD PRIMARY KEY (`ex_id`),
  ADD KEY `ex_cus_id` (`ex_cus_id`),
  ADD KEY `ex_emp_id` (`ex_emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers_expired`
--
ALTER TABLE `customers_expired`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
