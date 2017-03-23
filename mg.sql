-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2017 at 05:36 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

--
-- Database: `mg`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

CREATE TABLE `accessory` (
  `acc_id` int(11) NOT NULL,
  `acc_store_id` int(11) NOT NULL,
  `acc_model_id` int(11) NOT NULL,
  `acc_name` varchar(128) NOT NULL,
  `acc_detail` text NOT NULL,
  `acc_cost` float(11,2) NOT NULL,
  `acc_price` float(11,2) NOT NULL,
  `acc_created` datetime NOT NULL,
  `acc_updated` datetime NOT NULL,
  `acc_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`acc_id`, `acc_store_id`, `acc_model_id`, `acc_name`, `acc_detail`, `acc_cost`, `acc_price`, `acc_created`, `acc_updated`, `acc_user_id`) VALUES
(7, 2, 2, 'ชุดเเต่ง MG3 Speed (เสกิร์ตรอบคัน+สปอยเล่อร์แนบสีดำด้าน 5 ชิ้น )', '', 11000.00, 17600.00, '2017-02-15 13:12:07', '2017-02-15 13:12:07', 6),
(8, 2, 2, 'ชุดแต่ง MG3 Accessories (เสกิร์ตรอบคัน+สปอยเล่อร์แนบ 5 ชิ้น)', '', 12000.00, 19800.00, '2017-02-15 13:14:45', '2017-02-15 13:14:45', 6),
(9, 2, 2, 'ชุดแต่ง MG3 Mini (เสกิร์ตรอบคันพร้อมคิ้วล้อ+สปอยเล่อร์แนบสีดำด้าน 9 ชิ้น)', '', 15000.00, 25000.00, '2017-02-15 13:16:33', '2017-02-15 13:16:33', 6),
(10, 2, 3, 'ชุดแต่ง MG5 Accessories (เสกิร์ตรอบคัน+สปอยเล่อร์แนบ 5 ชิ้น) ', '', 13000.00, 22000.00, '2017-02-15 13:19:12', '2017-02-15 13:19:12', 6),
(11, 2, 3, 'ชุดแต่ง MG5 Sport (เสกิร์ตรอบคัน+สปอยเล่อร์แนบ 5 ชิ้น)', '', 15000.00, 26400.00, '2017-02-15 13:21:44', '2017-02-15 13:21:44', 6),
(12, 2, 3, 'ชุดแต่ง MG5 SANTO (เสกิร์ตรอบคัน+สปอยเล่อร์แนบ+Roof 6 ชิ้น)', '', 14000.00, 24000.00, '2017-02-15 13:23:17', '2017-02-15 13:23:17', 6),
(13, 2, 4, 'ชุดแต่ง MG GS SANTO (เสกิร์ตคอบคัน 4 ชิ้น)', '', 17000.00, 25000.00, '2017-02-15 13:25:27', '2017-02-15 13:25:27', 6),
(14, 0, 2, 'ชุดแต่ง MG 3 มาตรฐาน (Accessories MG Progress 2016) ', '-Sticker กระจกมองข้าง+ฝา่ถังน้ำมัน\r\n-Sticker หลังคา\r\n-คิ้วบรรโดสแตลเลสไม่มีขอบยาง\r\n-ถ้ายใส่ของท้ายรถ\r\n-พรมกระดูกมีรองพื้นปุ่ม (EI) ืกระดุมเหล้ก\r\n-กันรอยด้านหลัง\r\n-กันสาดประตู\r\n-ผ้าคลุมรถซิลเวอร์โค๊ท', 6500.00, 11000.00, '2017-02-15 13:36:28', '2017-02-15 13:36:28', 6),
(15, 0, 2, 'Sticker หลังคา (Accessories MG Progress 2016) ', '', 2000.00, 3000.00, '2017-02-15 13:37:41', '2017-02-15 13:37:41', 6),
(16, 0, 2, 'คิ้วบรรไดสแตลเลสไม่มีขอบยาง (Accessories MG Progress 2016) ', '', 550.00, 950.00, '2017-02-15 13:41:36', '2017-02-15 13:41:36', 6),
(17, 0, 3, 'คิ้วบรรไดสแตลเลสไม่มีขอบยาง (Accessories MG Progress 2016) ', '', 600.00, 1000.00, '2017-02-15 13:42:50', '2017-02-15 13:42:50', 6),
(18, 0, 2, 'ถ้ายใส่ของท้ายรถ (Accessories MG Progress 2016) ', '', 700.00, 1200.00, '2017-02-15 13:44:05', '2017-02-15 13:44:05', 6),
(19, 0, 3, 'ถ้ายใส่ของท้ายรถ (Accessories MG Progress 2016) ', '', 800.00, 1450.00, '2017-02-15 13:44:40', '2017-02-15 13:44:40', 6),
(20, 0, 2, 'พรมกระดูกมีรองพื้นปุ่ม (EI) กระดุมเหล็ก (Accessories MG Progress 2016) ', '', 2000.00, 3250.00, '2017-02-15 13:46:07', '2017-02-15 13:46:07', 6),
(21, 0, 3, 'พรมกระดูกมีรองพื้นปุ่ม (EI) กระดุมเหล็ก (Accessories MG Progress 2016) ', '', 2000.00, 3250.00, '2017-02-15 13:46:41', '2017-02-15 13:46:41', 6),
(22, 0, 2, 'กันรอยด้านหลัง (Accessories MG Progress 2016) ', '', 750.00, 1375.00, '2017-02-15 13:47:40', '2017-02-15 13:47:40', 6),
(23, 0, 2, 'กันสาดประตู (Accessories MG Progress 2016) ', '', 800.00, 1425.00, '2017-02-15 13:48:38', '2017-02-15 13:48:38', 6),
(24, 0, 3, 'กันสาดประตู (Accessories MG Progress 2016) ', '', 850.00, 1700.00, '2017-02-15 13:49:40', '2017-02-15 13:49:40', 6),
(25, 0, 1, 'กันสาดประตู (Accessories MG Progress 2016) ', '', 850.00, 1725.00, '2017-02-15 13:50:55', '2017-02-15 13:50:55', 6),
(26, 0, 2, 'ผ้าคลุมรถซิลเวอร์โค๊ท (Accessories MG Progress 2016) ', '', 650.00, 1050.00, '2017-02-15 13:52:05', '2017-02-15 13:52:05', 6),
(27, 0, 3, 'ผ้าคลุมรถซิลเวอร์โค๊ท (Accessories MG Progress 2016) ', '', 650.00, 1200.00, '2017-02-15 13:52:31', '2017-02-15 13:52:31', 6),
(28, 0, 2, 'ผ้ายางทับทิม (Accessories MG Progress 2016)  ผืนละ', '', 50.00, 50.00, '2017-02-15 13:55:02', '2017-02-15 13:55:02', 6),
(29, 3, 2, 'ชุดแต่ง MG3 Mini G1 (สีดำด้าน ท่อเหลี่ยม 9 ชิ้น)', '', 14500.00, 23000.00, '2017-02-15 13:57:30', '2017-02-15 13:57:30', 6),
(30, 3, 2, 'ชุดแต่ง MG3 Mini G2 (สีดำด้าน ท่อกลม 9 ชิ้น)', '', 15000.00, 24500.00, '2017-02-15 13:59:51', '2017-02-15 13:59:51', 6),
(31, 3, 2, 'ชุดแต่ง MG3 Mini G3 (สีดำด้าน ท่อกลม 17 ชิ้น)', '', 20000.00, 28000.00, '2017-02-15 14:00:58', '2017-02-15 14:00:58', 6),
(32, 3, 2, 'ชุดแต่ง MG3 Accessories (หน้า/ข้างซ้าย-ขวา/ท้าย/สปอยเล่อร์ 5 ชิ้น )', '', 10500.00, 20000.00, '2017-02-15 14:03:10', '2017-02-15 14:03:10', 6),
(33, 3, 3, 'ชุดแต่ง MG5 G-Sport 4 ชิ้น (หน้า/ข้างซ้าย-ขวา/ท้าย)', '', 14500.00, 23000.00, '2017-02-15 14:09:07', '2017-02-15 14:09:07', 6),
(34, 3, 3, 'ชุดแต่ง MG5 G-Sport 5 ชิ้น (หน้า/ข้างซ้าย-ขวา/ท้าย/สปอยเล่อร์)', '', 15000.00, 24500.00, '2017-02-15 14:11:05', '2017-02-15 14:11:05', 6),
(35, 3, 3, 'ชุดแต่ง MG5 (แยกชิ้น) สปอยเล่อร์หลัง ', '', 3500.00, 4500.00, '2017-02-15 14:17:17', '2017-02-15 14:17:17', 6),
(36, 3, 3, 'ชุดแต่ง MG5 (แยกชิ้น) เสกิร์ตหน้า', '', 5500.00, 6500.00, '2017-02-15 14:19:14', '2017-02-15 14:19:14', 6),
(37, 3, 3, 'ชุดแต่ง MG5 (แยกชิ้น) เสกิร์ตหลัง', '', 4500.00, 5500.00, '2017-02-15 14:20:31', '2017-02-15 14:20:31', 6),
(38, 3, 3, 'ชุดแต่ง MG5 (แยกชิ้น) เสกิร์ตข้างซ้าย', '', 4500.00, 5500.00, '2017-02-15 14:22:57', '2017-02-15 14:22:57', 6),
(39, 3, 3, 'ชุดแต่ง MG5 (แยกชิ้น) เสกิร์ตข้างขวา', '', 4500.00, 5500.00, '2017-02-15 14:23:46', '2017-02-15 14:23:46', 6),
(40, 0, 2, 'เบาะหนังแท้ 100 %', '', 15000.00, 22000.00, '2017-02-15 14:30:02', '2017-02-15 14:30:02', 6),
(41, 0, 3, 'เบาะหนังแท้ 100 %', '', 15000.00, 22000.00, '2017-02-15 14:30:36', '2017-02-15 14:30:36', 6),
(42, 0, 1, 'เบาะหนังแท้ 100 %', '', 15000.00, 22000.00, '2017-02-15 14:31:10', '2017-02-15 14:31:10', 6),
(43, 0, 4, 'เบาะหนังแท้ 100 %', '', 16000.00, 23000.00, '2017-02-15 14:31:45', '2017-02-15 14:31:45', 6),
(44, 0, 2, 'เบาะ  PVC ล้วน (003)', '', 5500.00, 12000.00, '2017-02-15 14:44:06', '2017-02-15 14:44:06', 6),
(45, 0, 3, 'เบาะ  PVC ล้วน (003)', '', 5500.00, 12000.00, '2017-02-15 14:44:36', '2017-02-15 14:44:36', 6),
(46, 0, 1, 'เบาะ  PVC ล้วน (003)', '', 5500.00, 12000.00, '2017-02-15 14:45:08', '2017-02-15 14:45:08', 6),
(47, 0, 2, 'เคลือบแก้วสีรถยนต์  1 set', '', 5500.00, 10000.00, '2017-02-15 14:52:30', '2017-02-15 14:52:30', 6),
(48, 0, 3, 'เคลือบแก้วสีรถยนต์  1 set', '', 5500.00, 10000.00, '2017-02-15 14:53:11', '2017-02-15 14:53:11', 6),
(49, 0, 1, 'เคลือบแก้วสีรถยนต์  1 set', '', 7000.00, 12000.00, '2017-02-15 14:54:30', '2017-02-15 14:54:30', 6),
(50, 0, 4, 'เคลือบแก้วสีรถยนต์  1 set', '', 7500.00, 12500.00, '2017-02-15 14:55:00', '2017-02-15 14:55:00', 6),
(51, 0, 2, 'เบาะ Spac โรงงานหน้าเต็ม (002)', '', 9000.00, 16000.00, '2017-02-15 15:12:11', '2017-02-15 15:12:11', 6),
(52, 0, 3, 'เบาะ Spac โรงงานหน้าเต็ม (002)', '', 9000.00, 16000.00, '2017-02-15 15:12:50', '2017-02-15 15:12:50', 6),
(53, 0, 1, 'เบาะ Spac โรงงานหน้าเต็ม (002)', '', 9000.00, 16000.00, '2017-02-15 15:13:13', '2017-02-15 15:13:13', 6),
(54, 0, 4, 'เบาะ Spac โรงงานหน้าเต็ม (002)', '', 12000.00, 19000.00, '2017-02-15 15:13:33', '2017-02-15 15:13:33', 6);

-- --------------------------------------------------------

--
-- Table structure for table `accessory_stores`
--

CREATE TABLE `accessory_stores` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(128) NOT NULL,
  `store_created` datetime NOT NULL,
  `store_updated` datetime NOT NULL,
  `store_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accessory_stores`
--

INSERT INTO `accessory_stores` (`store_id`, `store_name`, `store_created`, `store_updated`, `store_user_id`) VALUES
(2, 'ร้านเลิศ', '2017-02-10 11:21:34', '2017-02-10 11:21:34', 6),
(3, 'ร้านสุบิน', '2017-02-10 11:21:43', '2017-02-10 11:21:43', 6);

-- --------------------------------------------------------

--
-- Table structure for table `accessory_types`
--

CREATE TABLE `accessory_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(128) NOT NULL,
  `type_updated` datetime NOT NULL,
  `type_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `book_created` datetime NOT NULL,
  `book_date` date NOT NULL COMMENT 'วันที่จอง',
  `book_cus_refer` int(11) NOT NULL COMMENT 'ที่มา',
  `book_number` int(11) NOT NULL,
  `book_page` int(11) NOT NULL,
  `book_sale_id` int(11) NOT NULL,
  `book_cus_id` int(11) NOT NULL,
  `book_model_id` int(11) NOT NULL,
  `book_pro_id` int(11) NOT NULL,
  `book_pro_price` float(11,2) NOT NULL,
  `book_accessory_price` float(9,2) NOT NULL,
  `book_net_price` float(11,2) NOT NULL,
  `book_deposit_type_options` varchar(255) NOT NULL,
  `book_pay_type` varchar(10) NOT NULL,
  `book_pay_type_options` varchar(255) NOT NULL,
  `book_color` int(11) NOT NULL,
  `book_deposit` int(11) NOT NULL COMMENT 'มัดจำ',
  `book_due` date NOT NULL,
  `book_deposit_type` varchar(10) NOT NULL,
  `book_updated` datetime NOT NULL,
  `book_status` varchar(20) NOT NULL,
  `book_note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_id`, `book_created`, `book_date`, `book_cus_refer`, `book_number`, `book_page`, `book_sale_id`, `book_cus_id`, `book_model_id`, `book_pro_id`, `book_pro_price`, `book_accessory_price`, `book_net_price`, `book_deposit_type_options`, `book_pay_type`, `book_pay_type_options`, `book_color`, `book_deposit`, `book_due`, `book_deposit_type`, `book_updated`, `book_status`, `book_note`) VALUES
(1, '2017-03-07 04:57:20', '2017-03-06', 1, 125, 11, 22, 5, 4, 40, 0.00, 0.00, 897000.00, '', 'cash', '', 5, 50000, '2017-03-04', 'cash', '2017-03-07 04:57:20', 'booking', ''),
(2, '2017-02-25 00:00:00', '2017-03-06', 1, 50, 13, 8, 6, 1, 20, 0.00, 0.00, 908000.00, '', 'hier', '{"finance_name":"\\u0e2a\\u0e35\\u0e25\\u0e21\\u0e0a\\u0e27\\u0e19\\u0e40\\u0e0a\\u0e48\\u0e32","down_payment_percent":"30","down_payment_price":"300000","interest":"0","supply":"begin","finance_amount":"50","Interest":"32","pay_monthly":"18000"}', 7, 40000, '2017-02-04', 'cash', '2017-02-28 06:23:34', 'booking', ''),
(3, '2017-02-28 00:00:00', '2017-03-06', 1, 34, 234, 8, 7, 4, 38, 0.00, 0.00, 1317000.00, '', 'cash', '', 4, 35000, '2017-02-24', 'cash', '2017-02-28 06:30:49', 'booking', '');

-- --------------------------------------------------------

--
-- Table structure for table `booking_accessory`
--

CREATE TABLE `booking_accessory` (
  `option_book_id` int(11) NOT NULL,
  `option_name` varchar(128) NOT NULL,
  `option_value` float(11,2) NOT NULL,
  `option_cost` float(11,2) NOT NULL,
  `option_rate` float(11,2) NOT NULL,
  `option_type` varchar(10) NOT NULL,
  `option_has_etc` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking_accessory`
--

INSERT INTO `booking_accessory` (`option_book_id`, `option_name`, `option_value`, `option_cost`, `option_rate`, `option_type`, `option_has_etc`) VALUES
(1, '43', 23000.00, 16000.00, 23000.00, 'accessory', 0),
(1, '50', 12500.00, 7500.00, 12500.00, 'accessory', 0),
(1, '54', 19000.00, 12000.00, 19000.00, 'accessory', 0),
(1, 'ทดสอบ 1', 500.00, 0.00, 0.00, 'accessory', 1),
(1, 'ทดสอบ 2', 200.00, 0.00, 0.00, 'accessory', 0),
(1, '13', 25000.00, 17000.00, 25000.00, 'foc', 0),
(1, 'ของแถม 1', 700.00, 0.00, 0.00, 'foc', 1),
(1, 'ของแถม 2', 250.00, 0.00, 0.00, 'foc', 0),
(2, '25', 1725.00, 850.00, 1725.00, 'accessory', 0),
(3, '13', 25000.00, 17000.00, 25000.00, 'accessory', 0),
(3, '43', 23000.00, 16000.00, 23000.00, 'accessory', 0),
(3, '54', 19000.00, 12000.00, 19000.00, 'accessory', 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_condition`
--

CREATE TABLE `booking_condition` (
  `con_book_id` int(11) NOT NULL,
  `con_name` varchar(128) NOT NULL,
  `con_value` varchar(50) NOT NULL,
  `con_type` varchar(10) NOT NULL,
  `con_has_etc` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking_condition`
--

INSERT INTO `booking_condition` (`con_book_id`, `con_name`, `con_value`, `con_type`, `con_has_etc`) VALUES
(1, '1', '908000', 'income', 0),
(1, '1', '897000', 'income', 0),
(1, '4', '21050', 'income', 0),
(1, '5', '55200', 'income', 0),
(1, '6', '50000', 'less', 0),
(2, '1', '908000', 'income', 0),
(2, '4', '21050', 'income', 0),
(2, '5', 'NaN', 'income', 0),
(2, '6', '40000', 'less', 0),
(3, '1', '1317000', 'income', 0),
(3, '4', '21050', 'income', 0),
(3, '5', 'NaN', 'income', 0),
(3, '6', '35000', 'less', 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_insurance`
--

CREATE TABLE `booking_insurance` (
  `ins_book_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL,
  `ins_name` varchar(128) NOT NULL,
  `ins_party` varchar(30) NOT NULL,
  `ins_pledge` float(11,2) NOT NULL,
  `ins_sure` int(1) NOT NULL,
  `ins_premium` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking_insurance`
--

INSERT INTO `booking_insurance` (`ins_book_id`, `ins_id`, `ins_name`, `ins_party`, `ins_pledge`, `ins_sure`, `ins_premium`) VALUES
(1, 1, 'bb c', 'd', 0.00, 1, 'd'),
(1, 2, 'สินมั่นคง', 'ชั้น 1', 500000.00, 1, '21050'),
(2, 3, 'สินมั่นคง', 'ชั้น 1', 500000.00, 1, '21050'),
(3, 4, 'สินมั่นคง', 'ชั้น 1', 500000.00, 1, '21050');

-- --------------------------------------------------------

--
-- Table structure for table `book_conditions`
--

CREATE TABLE `book_conditions` (
  `condition_id` int(11) NOT NULL,
  `condition_name` varchar(128) NOT NULL,
  `condition_income` tinyint(1) NOT NULL,
  `condition_lock` tinyint(1) NOT NULL,
  `condition_keyword` varchar(30) NOT NULL,
  `condition_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_conditions`
--

INSERT INTO `book_conditions` (`condition_id`, `condition_name`, `condition_income`, `condition_lock`, `condition_keyword`, `condition_order`) VALUES
(1, 'ค่ารถยนต์/Car price', 1, 1, 'carprice', 0),
(2, 'เงินดาวน์/Down payment', 1, 0, 'paydown', 0),
(3, 'ค่าจดทะเบียน/Registration Fee', 1, 0, '', 0),
(4, 'ค่าเบี้ยประกันภัย/Insurance Premium', 1, 0, 'insurance', 0),
(5, 'ค่าอุปกรณ์ตกแต่ง/Accessory', 1, 0, 'accessory', 0),
(6, 'หัก เงินมัดจำ/Deposit', 0, 0, 'deposit', 0),
(7, 'หัก เงินค่ารถเก่า/Used car trade-in', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_cus_refer`
--

CREATE TABLE `book_cus_refer` (
  `refer_id` int(11) NOT NULL,
  `refer_name` varchar(128) NOT NULL,
  `refer_note` text NOT NULL,
  `refer_created` datetime NOT NULL,
  `refer_updated` datetime NOT NULL,
  `refer_emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_cus_refer`
--

INSERT INTO `book_cus_refer` (`refer_id`, `refer_name`, `refer_note`, `refer_created`, `refer_updated`, `refer_emp_id`) VALUES
(1, 'โชว์รูม', '', '2017-03-02 15:55:49', '2017-03-02 15:55:49', 6),
(2, 'บูธ', '', '2017-03-02 15:55:56', '2017-03-02 15:55:56', 6),
(3, 'ลูกค้าโทรเข้ามา', '', '2017-03-02 15:56:17', '2017-03-02 15:56:17', 6),
(4, 'ลูกค้าแนะนำ', '', '2017-03-02 15:56:22', '2017-03-02 15:56:22', 6),
(5, 'ลูกค้าเก่า', '', '2017-03-02 15:56:31', '2017-03-02 15:56:31', 6);

-- --------------------------------------------------------

--
-- Table structure for table `book_status`
--

CREATE TABLE `book_status` (
  `status_id` int(3) NOT NULL,
  `status_label` varchar(128) CHARACTER SET utf8 NOT NULL,
  `status_lock` tinyint(1) NOT NULL,
  `status_order` int(2) NOT NULL,
  `status_enable` tinyint(1) NOT NULL,
  `status_color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_status`
--

INSERT INTO `book_status` (`status_id`, `status_label`, `status_lock`, `status_order`, `status_enable`, `status_color`) VALUES
(1, 'จองล่วงหน้า', 1, 1, 0, '#cccccc'),
(2, 'จอง', 1, 0, 0, '#1a8aca'),
(4, 'ยื่นขอไฟแนนซ์', 1, 0, 0, '#22bba7'),
(5, 'ไฟแนนซ์ไม่ผ่าน', 1, 0, 0, '#ea8006'),
(6, 'ส่งมอบเรียบร้อย', 1, 0, 0, '#77bb22'),
(7, 'คืนเงินมัดจำ', 1, 0, 0, '#55007c'),
(8, 'ยกเลิก', 1, 0, 0, '#bb2244'),
(9, 'เป็นโมฆะ', 1, 0, 0, '#999999');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_created` datetime NOT NULL,
  `car_cus_id` int(11) NOT NULL,
  `car_emp_id` int(11) NOT NULL,
  `car_pro_id` int(11) NOT NULL,
  `car_plate` varchar(10) NOT NULL COMMENT 'เลขทะเบียน',
  `car_red_plate` varchar(10) NOT NULL COMMENT 'ป้ายแดง',
  `car_VIN` varchar(20) NOT NULL COMMENT 'เลขตัวถัง',
  `car_engine` varchar(20) NOT NULL COMMENT 'เลขเครื่องยนต์',
  `car_color_code` varchar(20) NOT NULL COMMENT 'รหัสสีรถ',
  `car_color_text` varchar(20) NOT NULL COMMENT 'ชื่อสี',
  `car_mile` int(8) NOT NULL COMMENT 'เลขไมล์รถ',
  `car_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_created`, `car_cus_id`, `car_emp_id`, `car_pro_id`, `car_plate`, `car_red_plate`, `car_VIN`, `car_engine`, `car_color_code`, `car_color_text`, `car_mile`, `car_updated`) VALUES
(1, '2017-02-26 04:10:20', 3, 6, 43, 'กพ-55', '', 'b-555', 'SLD52', '', 'Metal Grey', 5000, '2017-02-28 06:53:12'),
(2, '2017-02-26 06:18:18', 4, 6, 43, 'กท-11', '', 'a-123', 'RR', '', 'Metal Grey', 200, '2017-02-27 03:10:13'),
(3, '2017-02-28 06:35:51', 7, 6, 21, 'กก-44', '', 'a-121', 'dsfsdf44', '#1f1e24', 'Graite Grey', 200, '2017-02-28 06:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(5) NOT NULL,
  `city_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `city_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `city_geo_id` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_code`, `city_name`, `city_geo_id`) VALUES
(1, '10', 'กรุงเทพมหานคร', 2),
(2, '11', 'สมุทรปราการ', 2),
(3, '12', 'นนทบุรี', 2),
(4, '13', 'ปทุมธานี', 2),
(5, '14', 'พระนครศรีอยุธยา', 2),
(6, '15', 'อ่างทอง', 2),
(7, '16', 'ลพบุรี', 2),
(8, '17', 'สิงห์บุรี', 2),
(9, '18', 'ชัยนาท', 2),
(10, '19', 'สระบุรี', 2),
(11, '20', 'ชลบุรี', 5),
(12, '21', 'ระยอง', 5),
(13, '22', 'จันทบุรี', 5),
(14, '23', 'ตราด', 5),
(15, '24', 'ฉะเชิงเทรา', 5),
(16, '25', 'ปราจีนบุรี', 5),
(17, '26', 'นครนายก', 2),
(18, '27', 'สระแก้ว', 5),
(19, '30', 'นครราชสีมา', 3),
(20, '31', 'บุรีรัมย์', 3),
(21, '32', 'สุรินทร์', 3),
(22, '33', 'ศรีสะเกษ', 3),
(23, '34', 'อุบลราชธานี', 3),
(24, '35', 'ยโสธร', 3),
(25, '36', 'ชัยภูมิ', 3),
(26, '37', 'อำนาจเจริญ', 3),
(27, '39', 'หนองบัวลำภู', 3),
(28, '40', 'ขอนแก่น', 3),
(29, '41', 'อุดรธานี', 3),
(30, '42', 'เลย', 3),
(31, '43', 'หนองคาย', 3),
(32, '44', 'มหาสารคาม', 3),
(33, '45', 'ร้อยเอ็ด', 3),
(34, '46', 'กาฬสินธุ์', 3),
(35, '47', 'สกลนคร', 3),
(36, '48', 'นครพนม', 3),
(37, '49', 'มุกดาหาร', 3),
(38, '50', 'เชียงใหม่', 1),
(39, '51', 'ลำพูน', 1),
(40, '52', 'ลำปาง', 1),
(41, '53', 'อุตรดิตถ์', 1),
(42, '54', 'แพร่', 1),
(43, '55', 'น่าน', 1),
(44, '56', 'พะเยา', 1),
(45, '57', 'เชียงราย', 1),
(46, '58', 'แม่ฮ่องสอน', 1),
(47, '60', 'นครสวรรค์', 2),
(48, '61', 'อุทัยธานี', 2),
(49, '62', 'กำแพงเพชร', 2),
(50, '63', 'ตาก', 4),
(51, '64', 'สุโขทัย', 2),
(52, '65', 'พิษณุโลก', 2),
(53, '66', 'พิจิตร', 2),
(54, '67', 'เพชรบูรณ์', 2),
(55, '70', 'ราชบุรี', 4),
(56, '71', 'กาญจนบุรี', 4),
(57, '72', 'สุพรรณบุรี', 2),
(58, '73', 'นครปฐม', 2),
(59, '74', 'สมุทรสาคร', 2),
(60, '75', 'สมุทรสงคราม', 2),
(61, '76', 'เพชรบุรี', 4),
(62, '77', 'ประจวบคีรีขันธ์', 4),
(63, '80', 'นครศรีธรรมราช', 6),
(64, '81', 'กระบี่', 6),
(65, '82', 'พังงา', 6),
(66, '83', 'ภูเก็ต', 6),
(67, '84', 'สุราษฎร์ธานี', 6),
(68, '85', 'ระนอง', 6),
(69, '86', 'ชุมพร', 6),
(70, '90', 'สงขลา', 6),
(71, '91', 'สตูล', 6),
(72, '92', 'ตรัง', 6),
(73, '93', 'พัทลุง', 6),
(74, '94', 'ปัตตานี', 6),
(75, '95', 'ยะลา', 6),
(76, '96', 'นราธิวาส', 6),
(77, '97', 'บึงกาฬ', 3);

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
  `cus_bookmark` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_created`, `cus_prefix_name`, `cus_first_name`, `cus_last_name`, `cus_nickname`, `cus_birthday`, `cus_address`, `cus_zip`, `cus_city_id`, `cus_email`, `cus_phone`, `cus_lineID`, `cus_card_id`, `cus_updated`, `cus_emp_id`, `cus_bookmark`) VALUES
(1, '2017-02-08 11:39:05', 'Mr.', 'พชร', 'นันทอาภา', 'ต้น', '1993-11-01', '414 ม.4 ซ.3 ต.ท่าผา อ.เกาะคา', 52130, 40, 'email@email.com', '0882267030', 'lineID', '1529900668255', '2017-02-10 13:10:46', 6, 0),
(2, '2017-02-20 00:00:00', 'Ms.', 'รัตนา', 'นุ่มนวล', 'หลิน', '0000-00-00', '{"number":"20","mu":"2","village":"2","alley":"","street":"","district":"5","amphur":"\\u0e2b","city":"16","zip":"45111"}', 45111, 16, '0839524512', '0843635952', '', '', '2017-02-28 02:59:37', 0, 0),
(3, '2017-02-27 16:15:10', 'Mr.', 'ภุชงค์', 'สวนแจ้ง', 'ชง', '1989-07-05', '{"number":"20","mu":"10","village":"","alley":"5","street":"555","district":"\\u0e1a\\u0e49\\u0e32\\u0e19\\u0e42\\u0e1b\\u0e48\\u0e07","amphur":"\\u0e07\\u0e32\\u0e27","city":"40","zip":"52110"}', 52110, 40, 'monkey.d.chong@gmail.com', '0843635525', 'shiichong', '1520500075275', '2017-03-10 10:25:03', 6, 0),
(4, '2017-02-27 17:25:29', 'Ms.', 'จิตรดา', 'จันแดง', 'ก้อย', '1990-11-12', '{"number":"20","mu":"10","village":"\\u0e1a\\u0e49\\u0e32\\u0e19\\u0e41\\u0e21\\u0e48\\u0e15\\u0e35\\u0e1a","alley":"5","street":"","district":"\\u0e1a\\u0e49\\u0e32\\u0e19\\u0e41\\u0e21\\u0e48\\u0e15\\u0e35\\u0e1a","amphur":"\\u0e07\\u0e32\\u0e27","city":"40","zip":"52110"}', 52110, 40, 'goi_nana@hotmail.com', '0843635952', '', '1520500075175', '2017-03-03 15:38:32', 6, 0),
(5, '2017-02-28 03:19:06', 'Mr.', 'ทองคำ', 'มันส์ดี', 'คำ', '0000-00-00', '{"number":"2","mu":"4","village":"","alley":"","street":"","district":"5","amphur":"4","city":"1","zip":"10110"}', 10110, 1, 'chong@gmail.com', '084557811', '', '', '2017-03-07 14:10:42', 6, 0),
(6, '2017-02-28 06:23:33', 'Mr.', 'ระยอง', 'ฮิฮฺ', 'ยองยอย', '0000-00-00', '{"number":"20","mu":"","village":"","alley":"","street":"","district":"","amphur":"","city":"64","zip":""}', 0, 64, NULL, '08884452265', NULL, '', '2017-02-28 06:23:33', 6, 0),
(7, '2017-02-28 06:30:49', 'Mr.', 'เกียรติศักดิ์', 'สุรินทร์', 'ต้อม', '1988-02-02', '{"number":"18","mu":"10","village":"","alley":"","street":"","district":"\\u0e1a\\u0e32\\u0e07\\u0e19\\u0e32","amphur":"\\u0e1a\\u0e32\\u0e07\\u0e19\\u0e32","city":"1","zip":"10200"}', 10200, 1, 'goi.d@hotmail.com', '088362545', 'goiy', '1521012154', '2017-03-10 10:28:40', 6, 0),
(8, '2017-03-03 14:32:50', 'Mr.', 'มีไหม', 'มีมั้ง', 'มั้ง', '0001-01-01', '{"number":"20","mu":"10","village":"","alley":"73","street":"\\u0e25\\u0e32\\u0e0b\\u0e32\\u0e25","district":"\\u0e1a\\u0e32\\u0e07\\u0e19\\u0e32","amphur":"\\u0e1a\\u0e32\\u0e19\\u0e32","city":"1","zip":"12000"}', 12000, 1, 'ms', '088567991', 'loidd', '11', '2017-03-03 14:42:23', 6, 0),
(9, '2017-03-09 17:23:06', '', '', '', '', '0000-00-00', '{"number":"","mu":"","village":"","alley":"","street":"","district":"","amphur":"","city":"64","zip":""}', 0, 64, '', '', '', '', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers_options`
--

CREATE TABLE `customers_options` (
  `option_customer_id` int(11) NOT NULL,
  `option_id` int(20) NOT NULL,
  `option_type` varchar(20) NOT NULL,
  `option_label` varchar(60) NOT NULL,
  `option_value` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers_options`
--

INSERT INTO `customers_options` (`option_customer_id`, `option_id`, `option_type`, `option_label`, `option_value`) VALUES
(1, 7, 'email', 'Personal Email', 'email@email.com'),
(1, 8, 'phone', 'Mobile Phone', '0882267030'),
(1, 9, 'social', 'Line ID', 'lineID'),
(2, 10, 'email', 'Personal Email', '0839524512'),
(3, 11, 'email', 'อีเมล์ส่วนตัว', 'monkey.d.chong@gmail.com'),
(3, 12, 'email', 'อีเมล์ที่ทำงาน', 'n.ln@gmail.com'),
(3, 13, 'phone', 'เบอร์มือถือ', '0843635525'),
(4, 14, 'email', 'อีเมล์ส่วนตัว', 'goi_nana@hotmail.com'),
(2, 17, 'phone', 'Mobile Phone', '0843635952'),
(5, 18, 'email', 'อีเมล์ส่วนตัว', 'chong@gmail.com'),
(5, 19, 'phone', 'เบอร์มือถือ', '084557811'),
(6, 20, 'phone', 'Mobile Phone', '08884452265'),
(6, 21, 'social', 'Line ID', ''),
(7, 22, 'email', 'อีเมล์ส่วนตัว', 'goi.d@hotmail.com'),
(8, 24, 'email', 'Personal Email', 'ms'),
(8, 25, 'phone', 'Mobile Phone', '088567991'),
(8, 26, 'social', 'Line ID', 'loidd'),
(4, 27, 'phone', 'เบอร์มือถือ', '0843635952'),
(3, 28, 'social', 'Line ID', 'shiichong'),
(7, 29, 'phone', 'เบอร์มือถือ', '088362545'),
(9, 30, 'email', 'อีเมล์ส่วนตัว', ''),
(9, 31, 'phone', 'เบอร์มือถือ', ''),
(9, 32, 'social', 'Line ID', ''),
(7, 33, 'social', 'Line ID', 'goiy');

-- --------------------------------------------------------

--
-- Table structure for table `dealer`
--

CREATE TABLE `dealer` (
  `dealer_id` int(11) NOT NULL,
  `dealer_name` varchar(128) NOT NULL,
  `dealer_created` datetime NOT NULL,
  `dealer_address` varchar(255) NOT NULL,
  `dealer_license` varchar(30) NOT NULL,
  `dealer_tel` varchar(30) NOT NULL,
  `dealer_mobile_phone` varchar(30) NOT NULL,
  `dealer_fax` varchar(30) NOT NULL,
  `dealer_email` varchar(60) NOT NULL,
  `dealer_emp_id` int(4) NOT NULL,
  `dealer_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dealer`
--

INSERT INTO `dealer` (`dealer_id`, `dealer_name`, `dealer_created`, `dealer_address`, `dealer_license`, `dealer_tel`, `dealer_mobile_phone`, `dealer_fax`, `dealer_email`, `dealer_emp_id`, `dealer_updated`) VALUES
(1, 'บริษัท จีเอ็มจี โปรเกรส (2016) จำกัด', '2017-02-14 23:18:05', '81 หมู่ที่ 1 ถนน รังสิต-ปทุมธานี ต.บ้านกลาง อ.เมื่องปทุมธานี จ.ปทุมธานี 12000', '0135559009031', '02-5673-555, 025671-255', '095-814-6065', '02-567-1256', 'mgprogress2016@gmail.com', 6, '2017-02-15 00:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_dealer_id` int(3) NOT NULL,
  `emp_dep_id` int(2) NOT NULL,
  `emp_pos_id` int(3) NOT NULL,
  `emp_id` int(4) NOT NULL,
  `emp_created` datetime NOT NULL,
  `emp_prefix_name` varchar(5) NOT NULL,
  `emp_first_name` varchar(40) NOT NULL,
  `emp_last_name` varchar(50) NOT NULL,
  `emp_image_id` int(11) NOT NULL,
  `emp_nickname` varchar(20) NOT NULL,
  `emp_username` varchar(15) NOT NULL,
  `emp_password` varchar(64) NOT NULL,
  `emp_phone_number` varchar(10) NOT NULL,
  `emp_email` varchar(128) NOT NULL,
  `emp_line_id` varchar(30) NOT NULL,
  `emp_address` varchar(128) NOT NULL,
  `emp_city_id` int(3) NOT NULL,
  `emp_zip` varchar(5) NOT NULL,
  `emp_birthday` date NOT NULL,
  `emp_updated` datetime NOT NULL,
  `emp_display` enum('disabled','enabled') NOT NULL,
  `emp_notes` text NOT NULL,
  `emp_mode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_dealer_id`, `emp_dep_id`, `emp_pos_id`, `emp_id`, `emp_created`, `emp_prefix_name`, `emp_first_name`, `emp_last_name`, `emp_image_id`, `emp_nickname`, `emp_username`, `emp_password`, `emp_phone_number`, `emp_email`, `emp_line_id`, `emp_address`, `emp_city_id`, `emp_zip`, `emp_birthday`, `emp_updated`, `emp_display`, `emp_notes`, `emp_mode`) VALUES
(1, 4, 2, 6, '2016-12-11 14:42:30', 'Mr.', 'ภุชงค์', 'สวนแจ้ง', 0, '', 'admin', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '0843635952', 'monkey.d.chong@gmail.com', 'shiichong', '', 0, '', '0000-00-00', '2017-03-07 15:41:26', 'enabled', '', 'dark'),
(1, 2, 1, 8, '2017-02-07 22:48:07', 'Mr.', 'ทดสอบ', 'ทดสอบ', 0, '', 'demo12', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '0888888888', '', '', '', 0, '', '0000-00-00', '2017-02-23 13:18:18', 'enabled', '', ''),
(1, 2, 3, 9, '2017-02-08 11:27:09', 'Mr.', 'rrdd', 'tet', 0, '', 'tonza', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '0888888888', '', '', '', 0, '', '0000-00-00', '2017-02-23 13:17:18', 'enabled', '', ''),
(1, 2, 3, 13, '2017-02-08 15:25:41', 'Mr.', 'ธนัท', 'สัครพันธ์', 0, '', 'sale1', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 10:43:35', 'enabled', '', ''),
(1, 2, 1, 14, '2017-02-08 15:26:07', 'Ms.', 'จิราพร', 'แสงโดด', 0, '', 'sale2', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:57:03', 'enabled', '', ''),
(1, 2, 1, 15, '2017-02-08 15:27:20', 'Mr.', 'จิรายุ', 'วัชรศิริโชค', 0, '', 'sale3', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:56:54', 'enabled', '', ''),
(1, 2, 1, 16, '2017-02-08 15:27:46', 'Ms.', 'นงนุช', 'ปิ่นแก้ว', 0, '', 'sale4', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:56:44', 'enabled', '', ''),
(1, 2, 1, 17, '2017-02-08 15:28:10', 'Mr.', 'ณัฐวุฒิ', 'ทองสุข', 0, '', 'sale5', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:56:32', 'enabled', '', ''),
(1, 2, 1, 18, '2017-02-08 15:28:29', 'Ms.', 'บุษกร', 'เพ็ชรมาลัย', 0, '', 'sale6', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:39:23', 'enabled', '', ''),
(1, 2, 1, 19, '2017-02-08 15:28:50', 'Mr.', 'อัยยะ', 'สมสุข', 0, '', 'sale7', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:56:12', 'enabled', '', ''),
(1, 2, 4, 20, '2017-02-08 15:29:38', 'Ms.', 'ลภัสรดา', 'ธิสา', 0, '', 'sale8', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:38:04', 'enabled', '', ''),
(1, 2, 1, 21, '2017-02-08 15:30:12', 'Ms.', 'สุญาดา', 'พันธุ์เถาว์', 0, '', 'sale9', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:37:57', 'enabled', '', ''),
(1, 2, 1, 22, '2017-02-08 15:30:33', 'Ms.', 'ววิษา', 'เต็งกุลศล', 0, '', 'sale10', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:38:09', 'enabled', '', ''),
(1, 2, 1, 23, '2017-02-08 15:31:08', 'Mr.', 'ยศพล', 'เสฏฐ์คณา', 0, '', 'sale11', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:38:17', 'enabled', '', ''),
(1, 2, 1, 24, '2017-02-08 15:31:31', 'Mr.', 'อุดร', 'ดิษฐประสพ', 0, '', 'sale12', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:38:34', 'enabled', '', ''),
(1, 2, 1, 25, '2017-02-08 15:31:52', 'Ms.', 'อัมพวัน', 'วงษ์ทอง', 0, '', 'sale13', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:38:41', 'enabled', '', ''),
(1, 2, 1, 26, '2017-02-08 15:32:14', 'Ms.', 'จิรนิตย์', 'พันธ์หว้า', 0, '', 'sale14', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-10 09:37:10', 'enabled', '', ''),
(1, 4, 2, 27, '2017-02-21 10:10:49', 'Mr.', 'dd', 'fff', 0, '', 'sd', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-21 10:10:49', 'enabled', '', ''),
(1, 2, 0, 28, '2017-02-21 10:12:14', 'Mr.', 'ss', 'dd', 0, '', 'admin2', '96f6056b20bfa4ee2bdfbe3d885026b70b0aee8bb1ef70436571dd22cd127e74', '', '', '', '', 0, '', '0000-00-00', '2017-02-23 12:14:56', 'enabled', '', ''),
(1, 5, 0, 29, '2017-03-07 04:18:10', 'Mr.', 'ช่างโย', 'งานหนัก', 0, '', 'test11', '905fb67e23193e5fd18974b8fa69eeeec81c01e6968f6b543013d55798d72cb3', '', '', '', '{"number":"","mu":"","village":"","alley":"","street":"","district":"","amphur":"","city":"64","zip":""}', 64, '', '0000-00-00', '2017-03-07 04:18:10', 'enabled', '', ''),
(1, 5, 0, 30, '2017-03-07 04:19:03', 'Mr.', 'ไมค์', 'ภิรมย์พร', 0, '', 'test12', '9942b731578d6bc137f9f47caeb0ae299cb114f7105a25602a02f7a1aada4d86', '', '', '', '{"number":"","mu":"","village":"","alley":"","street":"","district":"","amphur":"","city":"64","zip":""}', 64, '', '0000-00-00', '2017-03-07 04:19:03', 'enabled', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `emp_department`
--

CREATE TABLE `emp_department` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(40) NOT NULL,
  `dep_notes` text NOT NULL,
  `dep_is_admin` tinyint(1) NOT NULL COMMENT '1 = admin',
  `dep_permission` varchar(255) NOT NULL,
  `dep_is_sale` tinyint(1) NOT NULL,
  `dep_is_tec` tinyint(1) NOT NULL,
  `dep_is_service` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_department`
--

INSERT INTO `emp_department` (`dep_id`, `dep_name`, `dep_notes`, `dep_is_admin`, `dep_permission`, `dep_is_sale`, `dep_is_tec`, `dep_is_service`) VALUES
(1, 'Manager', '', 1, '', 0, 0, 0),
(2, 'Sales', 'จัดการ บริการส่วนของการจอง', 0, '', 1, 0, 0),
(3, 'Service', 'จัดการ บริการส่วนบริการลูกค้า', 0, '', 0, 0, 1),
(4, 'Admin', 'สามารถทำได้ทุกอย่าง', 1, '', 0, 0, 0),
(5, 'ช่างซ่อม', '', 0, '', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `emp_position`
--

CREATE TABLE `emp_position` (
  `pos_id` int(11) NOT NULL,
  `pos_dep_id` int(11) NOT NULL,
  `pos_name` varchar(50) NOT NULL,
  `pos_notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_position`
--

INSERT INTO `emp_position` (`pos_id`, `pos_dep_id`, `pos_name`, `pos_notes`) VALUES
(1, 2, 'ที่ปรึกษาการขาย', ''),
(2, 4, 'หัวหน้าฝ่าย IT', ''),
(3, 2, 'ทีมขาย A', ''),
(4, 2, 'ทีมขาย B', '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_cus_id` int(11) NOT NULL,
  `event_emp_id` int(11) NOT NULL,
  `event_title` varchar(128) NOT NULL,
  `event_detail` text NOT NULL,
  `event_when` datetime NOT NULL,
  `event_created` datetime NOT NULL,
  `event_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events_obj_permit`
--

CREATE TABLE `events_obj_permit` (
  `event_id` int(11) NOT NULL,
  `obj_id` int(11) NOT NULL,
  `obj_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `inv_id` int(11) NOT NULL,
  `inv_code` varchar(8) NOT NULL,
  `inv_status` enum('cash','credit','check') NOT NULL,
  `inv_created` datetime NOT NULL,
  `inv_type_id` int(11) NOT NULL,
  `inv_type_obj` varchar(10) NOT NULL,
  `inv_amount` float(11,2) NOT NULL,
  `inv_vat` int(4) NOT NULL,
  `inv_pay` float(7,2) NOT NULL,
  `inv_change` float(5,2) NOT NULL,
  `inv_poster_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `pro_model_id` int(11) NOT NULL,
  `pro_name` varchar(128) NOT NULL,
  `pro_cc` varchar(10) NOT NULL,
  `pro_mfy` varchar(10) NOT NULL,
  `pro_price` float(11,2) NOT NULL,
  `pro_balance` int(4) NOT NULL COMMENT 'คงเหลือ',
  `pro_subtotal` int(4) NOT NULL COMMENT 'รวมทั้งสิ้น',
  `pro_booking` int(4) NOT NULL COMMENT 'ยอดจอง',
  `pro_soldtotal` int(4) NOT NULL COMMENT 'ขายไปแล้ว',
  `pro_order_total` int(4) NOT NULL COMMENT 'สั่งเพิ่ม',
  `pro_total` int(4) NOT NULL COMMENT 'รวมทั้งหมด',
  `pro_updated` datetime NOT NULL,
  `pro_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_model_id`, `pro_name`, `pro_cc`, `pro_mfy`, `pro_price`, `pro_balance`, `pro_subtotal`, `pro_booking`, `pro_soldtotal`, `pro_order_total`, `pro_total`, `pro_updated`, `pro_created`) VALUES
(13, 2, 'MG3 Hatchback 1.5C', '1500', '2016', 479000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 09:47:22', '2017-02-16 09:47:22'),
(14, 2, 'MG3 Hatchback 1.5D (Monotone)', '1500', '2016', 509000.00, 1, 2, 1, 0, 0, 2, '2017-02-16 09:52:49', '2017-02-16 09:52:49'),
(15, 2, 'MG3 Hatchback 1.5D (twotone)', '1500', '2016', 514000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 10:00:03', '2017-02-16 10:00:03'),
(16, 2, 'MG3 Hatchback 1.5 x Sunroof (Monotone)', '1500', '2016', 559000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 10:08:08', '2017-02-16 10:08:08'),
(17, 2, 'MG3 Hatchback 1.5 x Sunroof (Twotone)', '1500', '2016', 564000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 10:12:59', '2017-02-16 10:12:59'),
(18, 2, 'MG3 Xross 1.5 X', '1500', '2016', 595000.00, 1, 2, 1, 0, 0, 2, '2017-02-16 10:19:02', '2017-02-16 10:19:02'),
(19, 2, 'MG3 Hatchback 1.5V Sunroof ', '1500', '2016', 579000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 10:22:44', '2017-02-16 10:22:44'),
(20, 1, 'MG6 Fastback 1.8 C Turbo', '1800', '2016', 908000.00, -1, 1, 2, 0, 0, 2, '2017-02-16 10:30:29', '2017-02-16 10:30:29'),
(21, 1, 'MG6 Fastback 1.8 C Turbo (Black top)', '1800', '2016', 918000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 10:35:58', '2017-02-16 10:35:58'),
(22, 1, 'MG6 Fastback 1.8 D Turbo', '1800', '2016', 998000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 10:40:16', '2017-02-16 10:40:16'),
(23, 1, 'MG6 Fastback 1.8 D Turbo (Black top)', '1800', '2016', 1008000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 10:43:39', '2017-02-16 10:43:39'),
(24, 1, 'MG6 Fastback 1.8 D Turbo sunroof', '1800', '2016', 1028000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 10:47:25', '2017-02-16 10:47:25'),
(25, 1, 'MG6 Fastback 1.8 D Turbo sunroof (Black top)', '1800', '2016', 1038000.00, 2, 3, 1, 0, 0, 3, '2017-02-16 10:53:32', '2017-02-16 10:53:32'),
(26, 1, 'MG6 Fastback 1.8 X Turbo', '1800', '2016', 1108000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 10:57:45', '2017-02-16 10:57:45'),
(27, 1, 'MG6 Fastback 1.8 X Turbo (Black top)', '1800', '2016', 1118000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:00:48', '2017-02-16 11:00:48'),
(28, 1, 'MG6 Fastback 1.8 X Turbo sunroof', '1800', '2016', 1138000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:07:04', '2017-02-16 11:07:04'),
(29, 1, 'MG6 Fastback 1.8 X Turbo sunroof (Black top)', '1800', '2016', 1148000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:12:00', '2017-02-16 11:12:00'),
(30, 1, 'MG6 Sedan 1.8 C Turbo', '1800', '2016', 898000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 11:17:18', '2017-02-16 11:17:18'),
(31, 1, 'MG6 Sedan 1.8 D Turbo', '1800', '2016', 988000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:20:06', '2017-02-16 11:20:06'),
(32, 1, 'MG6 Sedan 1.8 D Turbo Sunroof', '1800', '2016', 1018000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 11:23:17', '2017-02-16 11:23:17'),
(33, 1, 'MG6 Sedan 1.8 X Turbo', '1800', '2016', 1098000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:25:25', '2017-02-16 11:25:25'),
(34, 1, 'MG6 Sedan 1.8 X Turbo Sunroof', '1800', '2016', 1128000.00, 1, 2, 1, 0, 0, 2, '2017-02-16 11:30:10', '2017-02-16 11:30:10'),
(35, 4, 'MG GS 2.0 2WD D', '2000', '2016', 1210000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:42:24', '2017-02-16 11:42:24'),
(36, 4, 'MG GS 2.0 2WD D (Black top)', '2000', '2016', 1217000.00, 2, 3, 1, 0, 0, 3, '2017-02-16 11:45:58', '2017-02-16 11:45:58'),
(37, 4, 'MG GS 2.0 AWD X Sunroof', '2000', '2016', 1310000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:49:38', '2017-02-16 11:49:38'),
(38, 4, 'MG GS 2.0 AWD X Sunroof (Black top)', '2000', '2016', 1317000.00, -1, 2, 3, 0, 0, 2, '2017-02-16 11:52:49', '2017-02-16 11:52:49'),
(39, 4, 'MG GS 1.5 2WD D', '1500', '2016', 890000.00, 3, 3, 0, 0, 0, 3, '2017-02-16 11:55:52', '2017-02-16 11:55:52'),
(40, 4, 'MG GS 1.5 2WD D (Black top)', '1500', '2016', 897000.00, 2, 3, 1, 0, 0, 3, '2017-02-16 11:58:26', '2017-02-16 11:58:26'),
(41, 4, 'MG GS 1.5 2WD X Sunroof', '1500', '2016', 990000.00, 2, 2, 0, 0, 0, 2, '2017-02-16 12:01:07', '2017-02-16 12:01:07'),
(42, 4, 'MG GS 1.5 2WD X Sunroof (Black top)', '1500', '2016', 997000.00, 5, 5, 0, 0, 0, 5, '2017-02-23 15:25:58', '2017-02-16 12:04:17'),
(43, 3, 'MG5 DEMO', '1500', '2017', 1500.00, 3, 3, 0, 0, 0, 3, '2017-02-24 10:25:11', '2017-02-23 09:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `products_activity`
--

CREATE TABLE `products_activity` (
  `act_id` int(11) NOT NULL,
  `act_pro_id` int(11) NOT NULL,
  `act_cost` float(11,2) NOT NULL,
  `act_qty` int(4) NOT NULL,
  `act_updated` datetime NOT NULL,
  `act_emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_activity`
--

INSERT INTO `products_activity` (`act_id`, `act_pro_id`, `act_cost`, `act_qty`, `act_updated`, `act_emp_id`) VALUES
(4, 7, 550000.00, 2, '2017-02-10 11:02:20', 6),
(7, 10, 800000.00, 2, '2017-02-10 11:11:23', 6),
(8, 11, 900000.00, 1, '2017-02-10 11:15:19', 6),
(9, 12, 1234567.00, 1, '2017-02-14 18:33:32', 6),
(10, 13, 450000.00, 3, '2017-02-16 09:53:05', 6),
(11, 14, 480000.00, 2, '2017-02-16 09:52:49', 6),
(12, 15, 480000.00, 3, '2017-02-16 10:00:03', 6),
(13, 16, 500000.00, 3, '2017-02-16 10:08:08', 6),
(14, 17, 525000.00, 2, '2017-02-16 10:13:00', 6),
(15, 18, 559000.00, 2, '2017-02-16 10:19:02', 6),
(16, 19, 554000.00, 3, '2017-02-16 10:22:44', 6),
(17, 20, 890000.00, 2, '2017-02-16 10:30:29', 6),
(18, 21, 895000.00, 2, '2017-02-16 10:35:58', 6),
(19, 22, 969000.00, 3, '2017-02-16 10:40:16', 6),
(20, 23, 989000.00, 2, '2017-02-16 10:43:39', 6),
(21, 24, 989000.00, 2, '2017-02-16 10:47:25', 6),
(22, 25, 998000.00, 3, '2017-02-16 10:53:32', 6),
(23, 26, 999000.00, 2, '2017-02-16 10:57:45', 6),
(24, 27, 1000000.00, 3, '2017-02-16 11:00:48', 6),
(25, 28, 1050000.00, 3, '2017-02-16 11:07:04', 6),
(26, 29, 1060000.00, 3, '2017-02-16 11:12:00', 6),
(27, 30, 695000.00, 2, '2017-02-16 11:17:18', 6),
(28, 31, 795000.00, 3, '2017-02-16 11:20:07', 6),
(29, 32, 950000.00, 2, '2017-02-16 11:23:17', 6),
(30, 33, 969000.00, 3, '2017-02-16 11:25:25', 6),
(31, 34, 995000.00, 2, '2017-02-16 11:30:10', 6),
(32, 35, 1100000.00, 3, '2017-02-16 11:42:24', 6),
(33, 36, 1100000.00, 3, '2017-02-16 11:45:58', 6),
(34, 37, 1150000.00, 3, '2017-02-16 11:49:39', 6),
(35, 38, 1159000.00, 2, '2017-02-16 11:52:49', 6),
(36, 39, 699000.00, 3, '2017-02-16 11:55:52', 6),
(37, 40, 699000.00, 3, '2017-02-16 11:58:27', 6),
(38, 41, 799000.00, 2, '2017-02-16 12:01:07', 6),
(40, 43, 600000.00, 1, '2017-02-23 10:20:40', 6),
(45, 42, 650000.00, 2, '2017-02-23 15:18:00', 6),
(46, 42, 650000.00, 2, '2017-02-23 15:19:36', 6),
(47, 42, 650000.00, 1, '2017-02-23 15:25:58', 6),
(48, 43, 600000.00, 2, '2017-02-24 10:21:08', 6),
(49, 43, 600000.00, 1, '2017-02-24 10:25:12', 6);

-- --------------------------------------------------------

--
-- Table structure for table `products_brands`
--

CREATE TABLE `products_brands` (
  `brand_id` int(11) NOT NULL,
  `brand_created` datetime NOT NULL,
  `brand_name` varchar(128) NOT NULL,
  `brand_notes` varchar(160) NOT NULL,
  `brand_updated` datetime NOT NULL,
  `brand_emp_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_brands`
--

INSERT INTO `products_brands` (`brand_id`, `brand_created`, `brand_name`, `brand_notes`, `brand_updated`, `brand_emp_id`) VALUES
(1, '2017-02-14 23:44:28', 'MG', '', '2017-02-14 23:44:47', 6);

-- --------------------------------------------------------

--
-- Table structure for table `products_items`
--

CREATE TABLE `products_items` (
  `item_pro_id` int(11) NOT NULL,
  `item_act_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_color` int(2) NOT NULL,
  `item_vin` varchar(17) NOT NULL,
  `item_engine` varchar(17) NOT NULL,
  `item_updated` datetime NOT NULL,
  `item_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_items`
--

INSERT INTO `products_items` (`item_pro_id`, `item_act_id`, `item_id`, `item_color`, `item_vin`, `item_engine`, `item_updated`, `item_status`) VALUES
(13, 10, 11, 13, 'mg12345abc0012016', 'mg15201601', '2017-02-23 14:51:21', 'standby'),
(13, 10, 12, 12, 'mg12345abc0022016', 'mg15201602', '2017-02-23 14:51:21', 'standby'),
(13, 10, 13, 14, 'mg12345abc0032016', 'mg15201603', '2017-02-23 14:51:21', 'standby'),
(14, 11, 14, 12, 'MGmo123a2016hb001', 'mg0012016a01', '2017-02-23 14:51:19', 'standby'),
(14, 11, 15, 14, 'MGmo123a2016hb002', 'mg0012016a02', '2017-02-23 14:51:19', 'standby'),
(15, 12, 16, 12, 'Mg001tw2016001uke', 'mg001216ab01', '2017-02-23 14:51:17', 'standby'),
(15, 12, 17, 13, 'Mg002tw2016002uke', 'mg002216ab02', '2017-02-23 14:51:17', 'standby'),
(15, 12, 18, 11, 'Mg003tw2016003uke', 'mg003216ab03', '2017-02-23 14:51:17', 'standby'),
(16, 13, 19, 13, 'MGs001Mo2016hb001', 'mg301s201601', '2017-02-23 14:51:14', 'standby'),
(16, 13, 20, 15, 'MGs002Mo2016hb002', 'mg301s201602', '2017-02-23 14:51:14', 'standby'),
(16, 13, 21, 16, 'MGs003Mo2016hb003', 'mg301s201603', '2017-02-23 14:51:14', 'standby'),
(17, 14, 22, 12, 'MG3001hb2016uk001', 'mg300a201601', '2017-02-23 14:51:11', 'standby'),
(17, 14, 23, 14, 'MG3002hb2016uk002', 'mg300a201602', '2017-02-23 14:51:11', 'standby'),
(18, 15, 24, 14, 'MG300ax2016x00uk0', 'mg300x201601', '2017-02-23 14:51:08', 'standby'),
(18, 15, 25, 11, 'MG300ax2016x00uk0', 'mg300x201602', '2017-02-23 14:51:08', 'standby'),
(19, 16, 26, 11, 'MG300h201615v0001', 'mg300v201601', '2017-02-23 14:51:06', 'standby'),
(19, 16, 27, 13, 'MG300h201615v0002', 'mg300v201602', '2017-02-23 14:51:06', 'standby'),
(19, 16, 28, 16, 'MG300h201615v0003', 'mg300v201603', '2017-02-23 14:51:06', 'standby'),
(20, 17, 29, 9, 'MG618ctb2016001fb', 'mg600ctb0001', '2017-02-23 14:52:03', 'standby'),
(20, 17, 30, 10, 'MG618ctb2016002fb', 'mg600ctb0002', '2017-02-23 14:52:03', 'standby'),
(21, 18, 31, 8, 'MG618ctb2016001bt', 'mg600ctb01bt', '2017-02-23 14:52:01', 'standby'),
(21, 18, 32, 7, 'MG618ctb2016002bt', 'mg600ctb02bt', '2017-02-23 14:52:01', 'standby'),
(22, 19, 33, 8, 'MG618dtb2016001fb', 'mg600dtb01fb', '2017-02-23 14:51:59', 'standby'),
(22, 19, 34, 9, 'MG618dtb2016002fb', 'mg600dtb02fb', '2017-02-23 14:51:59', 'standby'),
(22, 19, 35, 10, 'MG618dtb2016002fb', 'mg600dtb03fb', '2017-02-23 14:51:59', 'standby'),
(23, 20, 36, 6, 'MG618dtb2016001bt', 'mg600dtb01bt', '2017-02-23 14:51:56', 'standby'),
(23, 20, 37, 9, 'MG618dtb2016001bt', 'mg600dtb02bt', '2017-02-23 14:51:56', 'standby'),
(24, 21, 38, 7, 'MG618dtb2016001sr', 'mg600dtb01sr', '2017-02-23 14:51:54', 'standby'),
(24, 21, 39, 10, 'MG618dtb2016002sr', 'mg600dtb02sr', '2017-02-23 14:51:54', 'standby'),
(25, 22, 40, 10, 'MG618dtb201601sbt', 'mg60dtb01sbt', '2017-02-23 14:51:51', 'standby'),
(25, 22, 41, 7, 'MG618dtb201602sbt', 'mg60dtb02sbt', '2017-02-23 14:51:51', 'standby'),
(25, 22, 42, 6, 'MG618dtb201602sbt', 'mg60dtb02sbt', '2017-02-23 14:51:52', 'standby'),
(26, 23, 43, 8, 'MG618xtb2016001fb', 'mg600xtb01fb', '2017-02-23 14:51:49', 'standby'),
(26, 23, 44, 7, 'MG618xtb2016002fb', 'mg600xtb02fb', '2017-02-23 14:51:49', 'standby'),
(27, 24, 45, 10, 'MG618xtb2016001bt', 'mg600xtb01bt', '2017-02-23 14:51:46', 'standby'),
(27, 24, 46, 9, 'MG618xtb2016002bt', 'mg600xtb02bt', '2017-02-23 14:51:46', 'standby'),
(27, 24, 47, 8, 'MG618xtb2016003bt', 'mg600xtb03bt', '2017-02-23 14:51:46', 'standby'),
(28, 25, 48, 7, 'MG618xtb2016001sr', 'mg600xtb01sr', '2017-02-23 14:51:44', 'standby'),
(28, 25, 49, 6, 'MG618xtb2016002sr', 'mg600xtb02sr', '2017-02-23 14:51:44', 'standby'),
(28, 25, 50, 10, 'MG618xtb2016003sr', 'mg600xtb03sr', '2017-02-23 14:51:44', 'standby'),
(29, 26, 51, 6, 'MG618xtb201601sbt', 'mg60xtb01sbt', '2017-02-23 14:51:38', 'standby'),
(29, 26, 52, 7, 'MG618xtb201602sbt', 'mg60xtb02sbt', '2017-02-23 14:51:38', 'standby'),
(29, 26, 53, 8, 'MG618xtb201603sbt', 'mg60xtb03sbt', '2017-02-23 14:51:38', 'standby'),
(30, 27, 54, 6, 'MG618ctb2016001Sd', 'mg600ctb01Sd', '2017-02-23 14:51:36', 'standby'),
(30, 27, 55, 7, 'MG618ctb2016002Sd', 'mg600ctb02Sd', '2017-02-23 14:51:36', 'standby'),
(31, 28, 56, 7, 'MG618dtb2016001Sd', 'mg600dtb01Sd', '2017-02-23 14:51:33', 'standby'),
(31, 28, 57, 9, 'MG618dtb2016002Sd', 'mg600dtb02Sd', '2017-02-23 14:51:33', 'standby'),
(31, 28, 58, 10, 'MG618dtb2016003Sd', 'mg600dtb03Sd', '2017-02-23 14:51:33', 'standby'),
(32, 29, 59, 9, 'MG618dtb201601Ssr', 'mg60dtb01Ssr', '2017-02-23 14:51:30', 'standby'),
(32, 29, 60, 10, 'MG618dtb201602Ssr', 'mg60dtb02Ssr', '2017-02-23 14:51:30', 'standby'),
(33, 30, 61, 6, 'MG618xtb2016001Sd', 'mg600xtb01Sd', '2017-02-23 14:51:27', 'standby'),
(33, 30, 62, 7, 'MG618xtb2016002Sd', 'mg600xtb02Sd', '2017-02-23 14:51:27', 'standby'),
(33, 30, 63, 10, 'MG618xtb2016003Sd', 'mg600xtb03Sd', '2017-02-23 14:51:27', 'standby'),
(34, 31, 64, 10, 'MG618xtb201601Ssr', 'mg60xtb01Ssr', '2017-02-23 14:51:23', 'standby'),
(34, 31, 65, 6, 'MG618xtb201602Ssr', 'mg60xtb02Ssr', '2017-02-23 14:51:23', 'standby'),
(35, 32, 66, 22, 'MGGS202wd2016001d', 'mggs20wd001d', '2017-02-23 14:51:01', 'standby'),
(35, 32, 67, 2, 'MGGS202wd2016002d', 'mggs20wd002d', '2017-02-23 14:51:01', 'standby'),
(35, 32, 68, 3, 'MGGS202wd2016003d', 'mggs20wd003d', '2017-02-23 14:51:01', 'standby'),
(36, 33, 69, 3, 'MGGS202wd201601db', 'mggs20wd01db', '2017-02-23 14:51:00', 'standby'),
(36, 33, 70, 22, 'MGGS202wd201602db', 'mggs20wd02db', '2017-02-23 14:51:00', 'standby'),
(36, 33, 71, 5, 'MGGS202wd201603db', 'mggs20wd03db', '2017-02-23 14:51:00', 'standby'),
(37, 34, 72, 5, 'MGGS20awd201601XS', 'mggs2awd01xs', '2017-02-23 14:50:59', 'standby'),
(37, 34, 73, 3, 'MGGS20awd201602XS', 'mggs2awd02xs', '2017-02-23 14:50:59', 'standby'),
(37, 34, 74, 2, 'MGGS20awd201603XS', 'mggs2awd03xs', '2017-02-23 14:50:59', 'standby'),
(38, 35, 75, 22, 'MGGS2awd201601XSb', 'mggs2awd1xsb', '2017-02-23 14:50:58', 'standby'),
(38, 35, 76, 2, 'MGGS2awd201602XSb', 'mggs2awd2xsb', '2017-02-23 14:50:58', 'standby'),
(39, 36, 77, 3, 'MGGS152wd2016001d', 'mggs152wd001d', '2017-02-23 14:50:56', 'standby'),
(39, 36, 78, 4, 'MGGS152wd2016002d', 'mggs152wd002d', '2017-02-23 14:50:56', 'standby'),
(39, 36, 79, 22, 'MGGS152wd2016003d', 'mggs152wd003d', '2017-02-23 14:50:56', 'standby'),
(40, 37, 80, 2, 'MGGS152wd201601db', 'mggs152wd01db', '2017-02-23 14:50:54', 'standby'),
(40, 37, 81, 3, 'MGGS152wd201602db', 'mggs152wd02db', '2017-02-23 14:50:54', 'standby'),
(40, 37, 82, 22, 'MGGS152wd201603db', 'mggs152wd03db', '2017-02-23 14:50:54', 'standby'),
(41, 38, 83, 2, 'MGGS152wd201601XS', 'mggs152wd01xs', '2017-02-23 14:50:52', 'standby'),
(41, 38, 84, 22, 'MGGS152wd201602XS', 'mggs152wd02xs', '2017-02-23 14:50:52', 'standby'),
(42, 45, 95, 2, 'KL1JA6989EK62675', '2ZR-FXE', '2017-02-23 15:18:01', 'standby'),
(42, 45, 96, 5, 'KL1JA6989EK62612', '2ZR-OBF', '2017-02-23 15:18:01', 'standby'),
(42, 46, 97, 2, 'KL1JA6989EK62675', '2ZR-FXE', '2017-02-23 15:19:36', 'standby'),
(42, 46, 98, 5, 'KL1JA6989EK62612', '2ZR-OBF', '2017-02-23 15:19:36', 'standby'),
(42, 47, 100, 3, 'KL1JA6989EK66122', '2ZR-OBF', '2017-02-23 15:24:10', 'standby'),
(43, 48, 101, 18, 'TESTDEMOVIN1', 'TEST1', '2017-02-24 10:21:23', 'standby'),
(43, 48, 102, 19, 'TESTDEMOVIN2', 'TEST2', '2017-02-24 10:21:08', 'standby'),
(43, 49, 103, 20, 'TESTDEMOVIN3', 'TEST3', '2017-02-24 10:25:11', 'standby');

-- --------------------------------------------------------

--
-- Table structure for table `products_models`
--

CREATE TABLE `products_models` (
  `model_brand_id` int(11) NOT NULL,
  `model_dealer_id` int(3) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_name` varchar(128) NOT NULL,
  `model_amount_reservation` int(4) NOT NULL COMMENT 'ยอดจอง',
  `model_amount_balance` int(4) NOT NULL COMMENT 'คงเหลือ',
  `model_amount_order` int(4) NOT NULL COMMENT 'สั่งเพิ่ม',
  `model_amount_total` int(4) NOT NULL COMMENT 'รวมทั้งหมด',
  `model_amount_sales` int(4) NOT NULL COMMENT 'ยอดขาย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_models`
--

INSERT INTO `products_models` (`model_brand_id`, `model_dealer_id`, `model_id`, `model_name`, `model_amount_reservation`, `model_amount_balance`, `model_amount_order`, `model_amount_total`, `model_amount_sales`) VALUES
(1, 1, 1, 'MG6', 0, 0, 0, 0, 0),
(1, 1, 2, 'MG3', 0, 0, 0, 0, 0),
(1, 1, 3, 'MG5', 0, 0, 0, 0, 0),
(1, 1, 4, 'MG GS', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_models_colors`
--

CREATE TABLE `products_models_colors` (
  `color_model_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `color_name` varchar(20) NOT NULL,
  `color_primary` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_models_colors`
--

INSERT INTO `products_models_colors` (`color_model_id`, `color_id`, `color_name`, `color_primary`) VALUES
(4, 2, 'Pitch Black', '#131021'),
(4, 3, 'Burnt Orange', '#6e240b'),
(4, 4, 'Mocha Brown', '#2b211f'),
(4, 5, 'Platinum Silver', '#c2c2c2'),
(1, 6, 'Pitch Black', '#131021'),
(1, 7, 'Regal Red', '#590d0f'),
(1, 8, 'Graite Grey', '#1f1e24'),
(1, 9, 'Platinum Silver', '#747570'),
(1, 10, 'Arctic White', '#ffffff'),
(2, 11, 'Pitch Black', '#131021'),
(2, 12, 'Regal Red', '#850010'),
(2, 13, 'Platinum Silver', '#c4bfbf'),
(2, 14, 'Arctic White', '#ffffff'),
(2, 15, 'Themes Blue ', '#412dba'),
(2, 16, 'Tudor Yellow', '#cde91c'),
(3, 17, 'Black Knigth', '#0c0d0f'),
(3, 18, 'Solid Red', '#6b060a'),
(3, 19, 'Metal Grey', '#555e65'),
(3, 20, 'Silver Metallic', '#cdcdcd'),
(3, 21, 'Windsor White', '#ffffff'),
(4, 22, 'Arctic White', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_car_id` int(11) NOT NULL,
  `service_total_price` float(11,2) NOT NULL COMMENT 'ราคารวม',
  `service_total_list` int(3) NOT NULL COMMENT 'จำนวนรายการซ่อม',
  `service_created` datetime NOT NULL,
  `service_emp_id` int(11) NOT NULL COMMENT 'คนรับเรื่อง',
  `service_status` varchar(20) NOT NULL,
  `service_date_repair` datetime NOT NULL COMMENT 'วันที่นัดซ่อม',
  `service_tec_id` int(11) NOT NULL COMMENT 'ช่าง',
  `service_is_owner` tinyint(1) NOT NULL COMMENT 'เจ้าของมาซ่องเอง=1, ญาติมาซ่อม=0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_car_id`, `service_total_price`, `service_total_list`, `service_created`, `service_emp_id`, `service_status`, `service_date_repair`, `service_tec_id`, `service_is_owner`) VALUES
(26, 1, 500.00, 0, '2017-02-28 00:20:35', 6, 'due', '2017-03-06 02:13:19', 30, 0),
(29, 2, 1700.00, 0, '2017-02-28 00:31:30', 6, 'due', '0000-00-00 00:00:00', 25, 0),
(31, 3, 1700.00, 0, '2017-02-28 00:31:30', 6, 'due', '0000-00-00 00:00:00', 25, 0),
(32, 32, 0.00, 0, '2017-03-09 17:23:06', 6, 'run', '2017-03-09 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `services_options`
--

CREATE TABLE `services_options` (
  `sop_ser_id` int(11) NOT NULL,
  `sop_name` varchar(128) NOT NULL,
  `sop_value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services_sender`
--

CREATE TABLE `services_sender` (
  `sender_cus_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_prefix_name` varchar(5) NOT NULL,
  `sender_first_name` varchar(50) NOT NULL,
  `sender_last_name` varchar(50) NOT NULL,
  `sender_nickname` varchar(30) NOT NULL,
  `sender_relationship` varchar(30) NOT NULL,
  `sender_mobile_phone` varchar(15) NOT NULL,
  `sender_tel` varchar(15) NOT NULL,
  `sender_line_id` varchar(30) NOT NULL,
  `sender_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services_sender_premit`
--

CREATE TABLE `services_sender_premit` (
  `service_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `option_name` varchar(160) NOT NULL,
  `option_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`option_name`, `option_value`) VALUES
('type', 'article'),
('name', 'บริษัท จีเอ็มจี โปรเกรส (2016) จำกัด'),
('address', '81 หมู่ที่ 1 ถนน รังสิต-ปทุมธานี ต.บ้านกลาง อ.เมื่องปทุมธานี จ.ปทุมธานี 12000'),
('phone', '02-5673-555, 025671-255'),
('mobile_phone', '095-814-6065'),
('fax', '02-567-1256'),
('license', '0135559009031'),
('email', 'mgprogress2016@gmail.com'),
('title', 'MG Chong');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ser_id` int(11) NOT NULL,
  `ser_cus_id` int(11) NOT NULL,
  `ser_car_id` int(11) NOT NULL,
  `ser_car_type` varchar(10) NOT NULL,
  `ser_created` datetime NOT NULL,
  `ser_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessory`
--
ALTER TABLE `accessory`
  ADD PRIMARY KEY (`acc_id`),
  ADD KEY `acc_store_id` (`acc_store_id`),
  ADD KEY `acc_model_id` (`acc_model_id`),
  ADD KEY `acc_user_id` (`acc_user_id`);

--
-- Indexes for table `accessory_stores`
--
ALTER TABLE `accessory_stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `accessory_types`
--
ALTER TABLE `accessory_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `book_sale_id` (`book_sale_id`),
  ADD KEY `book_sale_id_2` (`book_sale_id`),
  ADD KEY `book_model_id` (`book_model_id`),
  ADD KEY `book_pro_id` (`book_pro_id`),
  ADD KEY `book_cus_id` (`book_cus_id`);

--
-- Indexes for table `booking_accessory`
--
ALTER TABLE `booking_accessory`
  ADD KEY `option_book_id` (`option_book_id`);

--
-- Indexes for table `booking_insurance`
--
ALTER TABLE `booking_insurance`
  ADD PRIMARY KEY (`ins_id`);

--
-- Indexes for table `book_conditions`
--
ALTER TABLE `book_conditions`
  ADD PRIMARY KEY (`condition_id`);

--
-- Indexes for table `book_cus_refer`
--
ALTER TABLE `book_cus_refer`
  ADD PRIMARY KEY (`refer_id`);

--
-- Indexes for table `book_status`
--
ALTER TABLE `book_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `car_pro_id` (`car_pro_id`),
  ADD KEY `car_cus_id` (`car_cus_id`),
  ADD KEY `car_emp_id` (`car_emp_id`),
  ADD KEY `car_red_plate` (`car_red_plate`),
  ADD KEY `car_plate` (`car_plate`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD KEY `cus_sale_id` (`cus_emp_id`);

--
-- Indexes for table `customers_options`
--
ALTER TABLE `customers_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `dealer`
--
ALTER TABLE `dealer`
  ADD PRIMARY KEY (`dealer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `emp_dep_id` (`emp_dep_id`),
  ADD KEY `emp_pos_id` (`emp_pos_id`),
  ADD KEY `emp_dealer_id` (`emp_dealer_id`),
  ADD KEY `emp_image_id` (`emp_image_id`);

--
-- Indexes for table `emp_department`
--
ALTER TABLE `emp_department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `emp_position`
--
ALTER TABLE `emp_position`
  ADD PRIMARY KEY (`pos_id`),
  ADD KEY `pos_dep_id` (`pos_dep_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_cus_id` (`event_cus_id`),
  ADD KEY `event_emp_id` (`event_emp_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `pro_model_id` (`pro_model_id`);

--
-- Indexes for table `products_activity`
--
ALTER TABLE `products_activity`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `products_brands`
--
ALTER TABLE `products_brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `products_items`
--
ALTER TABLE `products_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `products_models`
--
ALTER TABLE `products_models`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `model_brand_id` (`model_brand_id`),
  ADD KEY `model_dealer_id` (`model_dealer_id`);

--
-- Indexes for table `products_models_colors`
--
ALTER TABLE `products_models_colors`
  ADD PRIMARY KEY (`color_id`),
  ADD KEY `color_model_id` (`color_model_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `service_emp_id` (`service_emp_id`),
  ADD KEY `service_tec_id` (`service_tec_id`),
  ADD KEY `service_car_id` (`service_car_id`);

--
-- Indexes for table `services_sender`
--
ALTER TABLE `services_sender`
  ADD PRIMARY KEY (`sender_id`),
  ADD KEY `sender_cus_id` (`sender_cus_id`);

--
-- Indexes for table `services_sender_premit`
--
ALTER TABLE `services_sender_premit`
  ADD KEY `service_id` (`service_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD KEY `option_name` (`option_name`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ser_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessory`
--
ALTER TABLE `accessory`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `accessory_stores`
--
ALTER TABLE `accessory_stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `accessory_types`
--
ALTER TABLE `accessory_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `booking_insurance`
--
ALTER TABLE `booking_insurance`
  MODIFY `ins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `book_conditions`
--
ALTER TABLE `book_conditions`
  MODIFY `condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `book_cus_refer`
--
ALTER TABLE `book_cus_refer`
  MODIFY `refer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `book_status`
--
ALTER TABLE `book_status`
  MODIFY `status_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `customers_options`
--
ALTER TABLE `customers_options`
  MODIFY `option_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `dealer`
--
ALTER TABLE `dealer`
  MODIFY `dealer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `emp_department`
--
ALTER TABLE `emp_department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `emp_position`
--
ALTER TABLE `emp_position`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `products_activity`
--
ALTER TABLE `products_activity`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `products_brands`
--
ALTER TABLE `products_brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products_items`
--
ALTER TABLE `products_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `products_models`
--
ALTER TABLE `products_models`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products_models_colors`
--
ALTER TABLE `products_models_colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `services_sender`
--
ALTER TABLE `services_sender`
  MODIFY `sender_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ser_id` int(11) NOT NULL AUTO_INCREMENT;
