-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2017 at 07:45 AM
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
  `cus_level_id` int(2) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `cus_code` varchar(10) NOT NULL,
  `cus_created` datetime NOT NULL,
  `cus_prefix_name` varchar(5) NOT NULL,
  `cus_first_name` varchar(20) NOT NULL,
  `cus_last_name` varchar(20) NOT NULL,
  `cus_nickname` varchar(20) NOT NULL,
  `cus_birthday` date NOT NULL,
  `cus_card_id` varchar(20) NOT NULL,
  `cus_address` text NOT NULL,
  `cus_zip` int(5) NOT NULL,
  `cus_city_id` int(11) NOT NULL,
  `cus_email` varchar(30) DEFAULT NULL,
  `cus_phone` varchar(15) DEFAULT NULL,
  `cus_lineID` varchar(128) DEFAULT NULL,
  `cus_updated` datetime NOT NULL,
  `cus_emp_id` int(11) NOT NULL,
  `cus_image_id` int(11) NOT NULL,
  `cus_bookmark` tinyint(1) NOT NULL,
  `cus_status` enum('run','expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_level_id`, `cus_id`, `cus_code`, `cus_created`, `cus_prefix_name`, `cus_first_name`, `cus_last_name`, `cus_nickname`, `cus_birthday`, `cus_card_id`, `cus_address`, `cus_zip`, `cus_city_id`, `cus_email`, `cus_phone`, `cus_lineID`, `cus_updated`, `cus_emp_id`, `cus_image_id`, `cus_bookmark`, `cus_status`) VALUES
(1, 1, '0476', '2017-05-08 10:15:57', '', 'อาราอิ', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:33:04', 6, 0, 0, 'expired'),
(1, 2, '0477', '2017-05-08 10:46:25', '', 'อเดียงโน่', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:33:12', 6, 0, 0, 'expired'),
(1, 3, '0480', '2017-05-08 10:49:05', '', 'มัตซึชิม่า', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:33:27', 6, 0, 0, 'run'),
(1, 4, '0469', '2017-05-08 11:09:34', '', 'โยชิ', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:33:37', 6, 0, 0, 'run'),
(1, 5, '0478', '2017-05-08 11:10:26', '', 'นากายาม่า', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:33:46', 6, 0, 0, 'expired'),
(1, 6, '0479', '2017-05-08 11:11:15', '', 'ทาโร่', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:34:01', 6, 0, 0, 'expired'),
(2, 7, '', '2017-05-08 14:23:52', '', 'ชง', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:31:36', 6, 0, 0, 'run'),
(1, 8, '0412', '2017-05-16 12:37:57', '', 'พยัคฆ์ร้าย', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:37:57', 6, 0, 0, 'expired'),
(1, 9, '0432', '2017-05-16 12:38:44', '', 'แดน', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:38:44', 6, 0, 0, 'expired'),
(1, 10, '0436', '2017-05-16 12:40:13', '', 'วัฒน์', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:40:13', 6, 0, 0, 'run'),
(1, 11, '0453', '2017-05-16 12:41:09', '', 'ทากาฮาชิ', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:41:09', 6, 0, 0, 'run'),
(1, 12, '0463', '2017-05-16 12:41:43', '', 'ยูกิ', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:41:43', 6, 0, 0, 'expired'),
(1, 13, '0473', '2017-05-16 12:42:14', '', 'อามาโนะ', '', '', '0000-00-00', '', '{\"number\":\"\",\"mu\":\"\",\"village\":\"\",\"alley\":\"\",\"street\":\"\",\"district\":\"\",\"amphur\":\"\",\"city\":\"\",\"zip\":\"\"}', 0, 0, '', '', '', '2017-05-16 12:42:14', 6, 0, 0, 'run');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD KEY `cus_sale_id` (`cus_emp_id`),
  ADD KEY `cus_level_id` (`cus_level_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `cus_city_id` (`cus_city_id`),
  ADD KEY `cus_image_id` (`cus_image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
