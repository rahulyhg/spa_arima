-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2017 at 06:01 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

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
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pack_dealer_id` int(3) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `pack_code` varchar(15) NOT NULL,
  `pack_name` varchar(60) NOT NULL,
  `pack_qty` int(4) NOT NULL COMMENT 'จำนวน',
  `pack_unit` varchar(20) NOT NULL,
  `pack_price` float(7,2) NOT NULL,
  `pack_created` datetime NOT NULL,
  `pack_emp_id` int(11) NOT NULL,
  `pack_updated` datetime NOT NULL,
  `pack_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pack_dealer_id`, `pack_id`, `pack_code`, `pack_name`, `pack_qty`, `pack_unit`, `pack_price`, `pack_created`, `pack_emp_id`, `pack_updated`, `pack_sequence`) VALUES
(0, 2, 'A01', 'TRADITIONAL THAI BODY MASSAGE', 1, 'hour', 350.00, '2017-04-24 16:20:22', 6, '2017-05-08 05:33:03', 1),
(0, 3, 'A02', 'HEAD MASSAGE', 1, 'hour', 350.00, '2017-04-24 16:30:20', 6, '2017-05-08 05:33:27', 2),
(0, 4, 'A03', 'FOOT MASSAGE', 1, 'hour', 350.00, '2017-04-24 16:30:42', 6, '2017-05-08 05:33:35', 3),
(0, 5, 'A04', 'EAR CLEANING', 30, 'minute', 350.00, '2017-04-24 16:32:55', 6, '2017-05-08 05:33:39', 4),
(0, 6, 'A05', 'MANICURE', 40, 'minute', 350.00, '2017-04-24 16:33:17', 6, '2017-05-08 05:33:42', 5),
(0, 7, 'A06', 'PEDICURE', 30, 'minute', 350.00, '2017-04-24 16:33:33', 6, '2017-05-08 05:33:47', 6),
(0, 8, 'A07', 'OIL MASSAGE', 1, 'hour', 700.00, '2017-04-24 16:38:34', 6, '2017-05-08 05:34:10', 7),
(0, 9, 'A07', 'FACIAL MASSAGE', 50, 'minute', 700.00, '2017-04-24 16:39:55', 6, '2017-05-08 05:34:14', 8),
(0, 10, 'A08', 'FACIAL MASSAGE, FACIAL PACK', 1, 'hour', 1000.00, '2017-04-24 16:43:42', 6, '2017-05-08 05:34:22', 9),
(0, 11, 'B01', 'SHOWER', 1, 'time', 150.00, '2017-04-24 17:30:51', 6, '2017-05-08 05:29:29', 10),
(0, 12, 'B02', 'SAUNA', 1, 'time', 500.00, '2017-04-26 12:57:00', 6, '2017-05-08 05:29:23', 11),
(0, 13, 'B03', 'AKASURI', 1, 'time', 300.00, '2017-04-26 13:00:07', 6, '2017-05-08 05:19:56', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pack_id`),
  ADD KEY `pack_id` (`pack_id`),
  ADD KEY `pack_emp_id` (`pack_emp_id`),
  ADD KEY `pack_dealer_id` (`pack_dealer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
