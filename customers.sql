-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2017 at 06:59 AM
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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` int(11) NOT NULL,
  `cus_created` datetime NOT NULL,
  `cus_prefix_name` varchar(5) NOT NULL,
  `cus_first_name` varchar(20) NOT NULL,
  `cus_last_name` varchar(20) NOT NULL,
  `cus_nickname` varchar(20) NOT NULL,
  `cus_birthday` date NOT NULL,
  `cus_address` text NOT NULL,
  `cus_zip` int(5) NOT NULL,
  `cus_city_id` int(11) NOT NULL,
  `cus_email` varchar(30) DEFAULT NULL,
  `cus_phone` varchar(15) DEFAULT NULL,
  `cus_lineID` varchar(128) DEFAULT NULL,
  `cus_card_id` varchar(13) NOT NULL,
  `cus_updated` datetime NOT NULL,
  `cus_emp_id` int(11) NOT NULL,
  `cus_image_id` int(11) NOT NULL,
  `cus_bookmark` tinyint(1) NOT NULL,
  `cus_status` enum('run','expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_created`, `cus_prefix_name`, `cus_first_name`, `cus_last_name`, `cus_nickname`, `cus_birthday`, `cus_address`, `cus_zip`, `cus_city_id`, `cus_email`, `cus_phone`, `cus_lineID`, `cus_card_id`, `cus_updated`, `cus_emp_id`, `cus_image_id`, `cus_bookmark`, `cus_status`) VALUES
(1, '2017-05-08 10:15:57', '', 'อาราอิ', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 10:15:57', 6, 0, 0, 'expired'),
(2, '2017-05-08 10:46:25', '', 'อเดียงโน่', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 10:46:25', 6, 0, 0, 'expired'),
(3, '2017-05-08 10:49:05', '', 'มัตซึชิม่า', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 10:49:05', 6, 0, 0, 'run'),
(4, '2017-05-08 11:09:34', '', 'โยชิ', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 11:09:34', 6, 0, 0, 'run'),
(5, '2017-05-08 11:10:26', '', 'นากายาม่า', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 11:10:26', 6, 0, 0, 'expired'),
(6, '2017-05-08 11:11:15', '', 'ทาโร่', '', '', '0000-00-00', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '', '2017-05-08 11:11:15', 6, 0, 0, 'expired');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD KEY `cus_sale_id` (`cus_emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
