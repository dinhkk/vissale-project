-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2016 at 05:10 PM
-- Server version: 10.1.12-MariaDB-1~trusty
-- PHP Version: 5.6.19-6+deb.sury.org~trusty+5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fbsale_dinhkk_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_prints`
--

CREATE TABLE `billing_prints` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `template_uri` varchar(2000) DEFAULT NULL,
  `data` text COMMENT 'chuỗi json encode thể hiện cấu hình',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE `bundles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fb_blacklists`
--

CREATE TABLE `fb_blacklists` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fb_configs`
--

CREATE TABLE `fb_configs` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `answer_phone` varchar(500) DEFAULT NULL,
  `answer_nophone` varchar(500) DEFAULT NULL,
  `seeding_phone` text,
  `auto_like` tinyint(4) DEFAULT '1',
  `hide_phone` tinyint(4) DEFAULT '0',
  `hide_nophone` tinyint(4) DEFAULT '0',
  `answer_inbox` tinyint(4) DEFAULT '1',
  `assign_status` tinyint(4) DEFAULT '2',
  `token` text,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fb_conversation`
--

CREATE TABLE `fb_conversation` (
  `id` int(11) NOT NULL,
  `conversation_id` varchar(100) NOT NULL,
  `fb_customer_id` int(11) NOT NULL,
  `fb_user_id` varchar(100) NOT NULL COMMENT 'congmt: id cua user inbox',
  `page_id` int(11) NOT NULL,
  `fb_page_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `last_conversation_time` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='danh sach cac conversation cua page';

-- --------------------------------------------------------

--
-- Table structure for table `fb_conversation_messages`
--

CREATE TABLE `fb_conversation_messages` (
  `id` int(11) NOT NULL,
  `fb_conversation_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fb_customer_id` int(11) DEFAULT NULL,
  `fb_user_id` int(11) DEFAULT NULL,
  `fb_page_id` int(11) DEFAULT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fb_cron_config`
--

CREATE TABLE `fb_cron_config` (
  `group_id` int(11) DEFAULT NULL,
  `_key` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0 - text;1-json;2-array;3-int',
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_cron_config`
--

INSERT INTO `fb_cron_config` (`group_id`, `_key`, `type`, `description`, `value`, `created`, `updated`) VALUES
(1, 'fb_graph_post_limit', 3, NULL, '10', '2016-03-22 00:42:22', '2016-03-22 00:42:22'),
(1, 'fb_graph_limit_comment_post', 3, NULL, '20', '2016-03-22 00:42:22', '2016-03-22 00:42:22'),
(1, 'max_nodata_comment_day', 3, NULL, '2', '2016-03-22 00:45:13', '2016-03-22 00:45:13'),
(1, 'level_fetch_comment', 1, NULL, '{"0":120,"1":133}', '2016-03-22 00:45:13', '2016-03-22 00:45:13'),
(1, 'user_coment_filter', 2, NULL, '734899429950601,734899429950602', '2016-03-22 00:46:02', '2016-03-22 00:46:02'),
(1, 'preg_pattern_phone', 0, NULL, '[0-9]{10,12}', '2016-03-22 10:08:23', '2016-03-22 10:08:23'),
(1, 'max_comment_time_support', 3, NULL, '15552000', '2016-03-22 11:23:24', '2016-03-22 11:23:24'),
(1, 'fb_graph_limit_conversation_page', 3, NULL, '10', '2016-03-23 00:29:37', '2016-03-23 00:29:37'),
(1, 'fb_graph_limit_message_conversation', 3, '', '20', '2016-03-23 00:30:39', '2016-03-23 00:30:39'),
(1, 'reply_comment_has_phone', 0, NULL, 'Chung toi se lien lac lai sau.', '2016-03-23 16:17:15', '2016-03-23 16:17:15'),
(1, 'reply_comment_nophone', 0, NULL, 'Ban vui long de lai SDT', '2016-03-23 16:17:15', '2016-03-23 16:17:15'),
(1, 'reply_conversation_has_phone', 0, NULL, 'Chung toi se lien lac lai sau.', '2016-03-23 16:17:15', '2016-03-23 16:17:15'),
(1, 'reply_conversation_nophone', 0, NULL, 'Ban vui long de lai SDT', '2016-03-23 16:17:15', '2016-03-23 16:17:15'),
(1, 'hide_phone', 1, '', '1', '2016-03-23 00:30:39', '2016-03-23 00:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `fb_customers`
--

CREATE TABLE `fb_customers` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `fb_username` varchar(255) DEFAULT NULL,
  `fb_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_customers`
--

INSERT INTO `fb_customers` (`id`, `group_id`, `fb_id`, `fb_username`, `fb_name`, `email`, `phone`, `name`, `address`, `created`, `modified`) VALUES
(1, 1, '176718519385100', NULL, 'Tien Cong Mac', NULL, '0966496489', NULL, NULL, '2016-03-22 19:58:15', '2016-03-22 20:22:05'),
(6, 1, '1744063649158248', NULL, 'Trá»‹nh Tháº¿ Äá»‹nh', NULL, '0977434994', NULL, NULL, '2016-03-23 15:14:25', '2016-03-23 15:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `fb_pages`
--

CREATE TABLE `fb_pages` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `page_id` varchar(255) DEFAULT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `last_conversation_time` int(11) DEFAULT NULL COMMENT AS `congmt: thoi gian cua conversation moi nhat cua page`,
  `status` tinyint(4) DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_pages`
--

INSERT INTO `fb_pages` (`id`, `group_id`, `page_id`, `page_name`, `token`, `last_conversation_time`, `status`, `user_created`, `created`, `modified`) VALUES
(6, 1, '734899429950601', 'Gain Social Followers', 'CAANwODEJRXABAElVBEO0H6ZCyUPxMWEs8WRJSrKJBmZCMOeQZAYvJZAvk2d6sJuHQzN4vrIZB9t29Gy4CY7WcL8LdgvZBSWXsHw0oRLzcHLIv5mVYCqa0Vfmb7ZCtoNfDcBcRcIIO2CBZBFUYK6AdO2fBZAMBUnHis03Vk5NvPM2VZCsGiYZC3yp8Rl4MJLI265vLhHtXiAno4YQgZDZD', NULL, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(7, 1, '286947824664766', 'vteen.vn', 'CAANwODEJRXABAKbyWJOZAfKjP082TXCr1gS1riFHEjnZAq4UhD7UE8FzLTIw6lwRovei2fvWP7IZCSwwecAhPbnF7lDqWF9NRHret2wvbBuh96f0EkgMbDosUwZC0ujFsYy7CwHSMAPZBgwHAsDYr5xvr16MK2n1ViNR1L5AzAUGbBqC8rOA5243l6SH9euG6MEJDhuwpDQZDZD', NULL, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(8, 1, '749336251850712', 'MacShop', 'CAANwODEJRXABACRZBeOPPGIJD0c6YP4ZBE9HGK0ARqMvhaMKmNy8sw00fqNNAce4ndgQJU8vzs4N3YMEl4sWdZAR6SriaQA6gwy5ZAMBnvdHNxlVwBnvhHtVwoUQhaBluMEuviX217NlZAdaLFwmuu04T7iTjOYzaOkGZC2QYeZChDr3A2jLZA8uv5UZARDcljoPqpwblSiZAUKQZDZD', NULL, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(9, 1, '1466625843584680', 'Test', 'CAANwODEJRXABAHeAcrspvFZCSsqhYi7w4E2kyvouetgZBOVZBPH0DGSoTCSQ9If43a3B1ZCuh4J8nRoV6Us4O08F07QP26k2OobINfv3aJF8LAivrGrp82hoAb3QM54ZAyGFfV6xYVO3udgIIZA1egxCtKcmIoU1SNkYZA9gSkE3quhg4DDZBlZAZBANvKAwSX4LJ6sc1vGSC7pAZDZD', NULL, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(10, 1, '1454002211514575', 'TestPage', 'CAANwODEJRXABAEJyr2IRStRbJPusszv3YVlaK69W7LxdVZAoh00qdqCxn78FeE7WjQD8krLuCLbwpQk3wtkN5ZCmurXdX6X1hZBFnYVNMxiCvCBLcpZAvyO6a6wnLZBGHx92JFVpqCiCjXpeZAx4yZAUa8Bg1i2ZCWHTEML03Tnni9EO0PLlIiqEfdyMKKKAjmaqTPgrTInhZBQZDZD', NULL, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `fb_posts`
--

CREATE TABLE `fb_posts` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `page_id` varchar(255) NOT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `fb_page_id` int(11) NOT NULL,
  `fb_post_id` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `bundle_id` int(11) DEFAULT NULL,
  `answer_phone` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_nophone` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `disable_comment` tinyint(4) DEFAULT '0',
  `last_time_fetch_comment` int(11) DEFAULT NULL COMMENT AS `congmt: thoi diem thuc hien lay order (comment) cuoi cung`,
  `next_time_fetch_comment` int(11) DEFAULT NULL COMMENT AS `congmt: thoi diem thuc hien lay order tiep theo`,
  `level_fetch_comment` tinyint(4) NOT NULL DEFAULT '0'COMMENT
) ;

--
-- Dumping data for table `fb_posts`
--

INSERT INTO `fb_posts` (`id`, `group_id`, `page_id`, `post_id`, `fb_page_id`, `fb_post_id`, `description`, `product_id`, `bundle_id`, `answer_phone`, `answer_nophone`, `disable_comment`, `last_time_fetch_comment`, `next_time_fetch_comment`, `level_fetch_comment`, `status`, `server_ip`, `nodata_number_day`, `created`, `modified`) VALUES
(2, 1, '734899429950601', '734899429950601_739601006147110', 6, 2, NULL, 1, 1, 'từ từ để gọi', 'để lại SĐT rồi nói chuyện', 1, 1458720855, 1458584969, 0, 0, NULL, 0, '2016-03-21 00:00:00', '2016-03-23 15:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `fb_post_comments`
--

CREATE TABLE `fb_post_comments` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fb_customer_id` int(11) DEFAULT NULL,
  `fb_page_id` int(11) DEFAULT NULL,
  `page_id` varchar(255) DEFAULT NULL,
  `fb_post_id` int(11) DEFAULT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `comment_id` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `parent_comment_id` varchar(255) DEFAULT NULL COMMENT AS `Đây chính là 1 conversation trên fb`,
  `status` tinyint(4) DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_post_comments`
--

INSERT INTO `fb_post_comments` (`id`, `group_id`, `fb_customer_id`, `fb_page_id`, `page_id`, `fb_post_id`, `post_id`, `comment_id`, `content`, `parent_comment_id`, `status`, `user_created`, `created`, `modified`) VALUES
(1, 1, 1, 6, '734899429950601', 2, '734899429950601_739601006147110', '739601006147110_947477925359416', '1 ty likes :D 0966496489', '0', 0, NULL, '2016-03-22 20:22:03', '2016-03-22 20:22:03'),
(2, 1, 1, 6, '734899429950601', 2, '734899429950601_739601006147110', '739601006147110_947473955359813', 'lam phat 1tr like xem sao 0966496489', '0', 0, NULL, '2016-03-22 20:22:05', '2016-03-22 20:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uri` varchar(2000) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_usage`
--

CREATE TABLE `file_usage` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `file_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `weight` int(11) DEFAULT NULL,
  `fb_user_id` varchar(100) NOT NULL COMMENT 'congmt: fb user id dung de lay danh sach fanpage',
  `fb_user_token` tinytext NOT NULL COMMENT 'congmt: token user fb khi lay danh sach fanpage',
  `status` tinyint(4) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `code`, `description`, `weight`, `fb_user_id`, `fb_user_token`, `status`, `user_created`, `created`, `modified`) VALUES
(1, 'FBSales Company', 'FBSALES', 'FBSales Company', NULL, '', 'CAANwODEJRXABAHOXmZByrO53N6yVKgG7CDL8rvylZAnijsV7keze8CLGPAjnrXOHF01QqkCGonN5Db6iGOSeVv1ZBZCMJq9ExGSlr6QvneHZBwE9hDG3nBvohmFowmuF18ugbkwE3NFEx8v36rb3cY050fORIrJeMPtzvcWQM7J5u6aeIlWWYBhZB7anRo4zJK8gRyeXQ62uBwpLtFxOnB', NULL, 1458546608, '2016-03-21 00:00:00', '2016-03-21 15:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `stock_book_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `opening_qty` double DEFAULT NULL,
  `receiving_qty` double DEFAULT NULL,
  `delivering_qty` double DEFAULT NULL,
  `closing_qty` double DEFAULT NULL,
  `receiving_qty_forecast` double DEFAULT NULL,
  `delivering_qty_forecast` double DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fb_customer_id` int(11) DEFAULT NULL,
  `fb_page_id` int(11) DEFAULT NULL,
  `fb_post_id` int(11) DEFAULT NULL,
  `fb_comment_id` int(11) DEFAULT NULL,
  `total_qty` int(11) DEFAULT '1',
  `code` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `telco_code` varchar(255) DEFAULT NULL COMMENT AS `Phân tích dựa vào số mobile trước khi insert vào\r\ntelco_code: VIETTEL, MOBI, VINA, ...`,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `note1` varchar(500) DEFAULT NULL,
  `note2` varchar(500) DEFAULT NULL,
  `cancel_note` varchar(500) DEFAULT NULL,
  `shipping_note` varchar(500) DEFAULT NULL,
  `is_top_priority` tinyint(4) DEFAULT '0',
  `is_send_sms` tinyint(4) DEFAULT '0',
  `is_inner_city` tinyint(4) DEFAULT '0',
  `shipping_service_id` int(11) DEFAULT NULL,
  `bundle_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT '0',
  `discount_price` int(11) DEFAULT '0',
  `shipping_price` int(11) DEFAULT '0',
  `other_price` int(11) DEFAULT '0',
  `total_price` int(11) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `duplicate_id` int(11) DEFAULT NULL,
  `duplicate_note` varchar(500) DEFAULT NULL,
  `user_confirmed` int(11) DEFAULT NULL,
  `user_assigned` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `confirmed` datetime DEFAULT NULL,
  `delivered` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `group_id`, `fb_customer_id`, `fb_page_id`, `fb_post_id`, `fb_comment_id`, `total_qty`, `code`, `postal_code`, `customer_name`, `mobile`, `telco_code`, `city`, `address`, `note1`, `note2`, `cancel_note`, `shipping_note`, `is_top_priority`, `is_send_sms`, `is_inner_city`, `shipping_service_id`, `bundle_id`, `status_id`, `price`, `discount_price`, `shipping_price`, `other_price`, `total_price`, `weight`, `duplicate_id`, `duplicate_note`, `user_confirmed`, `user_assigned`, `user_created`, `user_modified`, `confirmed`, `delivered`, `created`, `modified`) VALUES
(1, 1, 1, 6, 2, 1, 1, '2tARjEwmi8', NULL, 'Tien Cong Mac', '0966496489', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-22 20:22:03', '2016-03-22 20:22:03'),
(2, 1, 1, 6, 2, 2, 1, '2QDrrkgBIX', NULL, 'Tien Cong Mac', '0966496489', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-22 20:22:05', '2016-03-22 20:22:05'),
(3, 1, 6, 6, 2, 0, 1, '7NOHfe9CkN', NULL, 'Trá»‹nh Tháº¿ Äá»‹nh', '0977434994', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-23 15:14:25', '2016-03-23 15:14:25'),
(4, 1, 6, 6, 2, 0, 1, '57OkckhQE8', NULL, 'Trá»‹nh Tháº¿ Äá»‹nh', '0977434994', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-23 15:14:32', '2016-03-23 15:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `product_id`, `product_price`, `qty`, `created`, `modified`) VALUES
(1, 1, 1, 10000, 1, '2016-03-22 20:22:03', '2016-03-22 20:22:03'),
(2, 2, 1, 10000, 1, '2016-03-22 20:22:05', '2016-03-22 20:22:05'),
(3, 3, 1, 10000, 1, '2016-03-23 15:14:25', '2016-03-23 15:14:25'),
(4, 4, 1, 10000, 1, '2016-03-23 15:14:32', '2016-03-23 15:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_changes`
--

CREATE TABLE `order_changes` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_revision_id` int(11) NOT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_label` varchar(255) DEFAULT NULL,
  `before_value` text,
  `value` text,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_imports`
--

CREATE TABLE `order_imports` (
  `id` int(11) NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `kg` double DEFAULT NULL,
  `order_total_price` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_revisions`
--

CREATE TABLE `order_revisions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `data` text COMMENT 'json_encode trạng thái trước khi chỉnh sửa',
  `before_order_status` tinyint(4) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perms`
--

CREATE TABLE `perms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `bundle_id` int(11) DEFAULT NULL,
  `made_in` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `price`, `color`, `size`, `unit_id`, `bundle_id`, `made_in`, `user_id`, `group_id`, `created`, `modified`) VALUES
(1, 'PR1', 'Product 1', 10000, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2016-03-22 00:00:00', '2016-03-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `data` text COMMENT 'Lưu cache quan hệ với perms, dưới dạng json_encode',
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles_perms`
--

CREATE TABLE `roles_perms` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_services`
--

CREATE TABLE `shipping_services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `group_id`, `is_default`, `weight`, `created`, `modified`) VALUES
(1, 'Tao boi cronjob', 1, 1, NULL, '2016-03-22 00:00:00', '2016-03-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_books`
--

CREATE TABLE `stock_books` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `begin_at` date NOT NULL,
  `end_at` date NOT NULL,
  `is_locked` tinyint(4) DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_deliverings`
--

CREATE TABLE `stock_deliverings` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `received` date NOT NULL,
  `stock_book_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_qty` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_deliverings_products`
--

CREATE TABLE `stock_deliverings_products` (
  `id` int(11) NOT NULL,
  `stock_delivering_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_receivings`
--

CREATE TABLE `stock_receivings` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `received` date NOT NULL,
  `stock_book_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_qty` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_receivings_products`
--

CREATE TABLE `stock_receivings_products` (
  `id` int(11) NOT NULL,
  `stock_receiving_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `data` text COMMENT 'Lưu cache quan hệ với perms, dưới dạng json_encode',
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_prints`
--
ALTER TABLE `billing_prints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_blacklists`
--
ALTER TABLE `fb_blacklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_configs`
--
ALTER TABLE `fb_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_conversation`
--
ALTER TABLE `fb_conversation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `fb_conversation_messages`
--
ALTER TABLE `fb_conversation_messages`
  ADD UNIQUE KEY `message_id` (`message_id`);

--
-- Indexes for table `fb_cron_config`
--
ALTER TABLE `fb_cron_config`
  ADD UNIQUE KEY `group_id` (`group_id`,`_key`);

--
-- Indexes for table `fb_customers`
--
ALTER TABLE `fb_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_id` (`group_id`,`fb_id`,`phone`);

--
-- Indexes for table `fb_pages`
--
ALTER TABLE `fb_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_id` (`page_id`);

--
-- Indexes for table `fb_post_comments`
--
ALTER TABLE `fb_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_usage`
--
ALTER TABLE `file_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `fb_user_id` (`fb_user_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_changes`
--
ALTER TABLE `order_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_imports`
--
ALTER TABLE `order_imports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_revisions`
--
ALTER TABLE `order_revisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perms`
--
ALTER TABLE `perms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_perms`
--
ALTER TABLE `roles_perms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_services`
--
ALTER TABLE `shipping_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_books`
--
ALTER TABLE `stock_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_deliverings`
--
ALTER TABLE `stock_deliverings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_deliverings_products`
--
ALTER TABLE `stock_deliverings_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_receivings`
--
ALTER TABLE `stock_receivings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_receivings_products`
--
ALTER TABLE `stock_receivings_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_prints`
--
ALTER TABLE `billing_prints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_blacklists`
--
ALTER TABLE `fb_blacklists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_configs`
--
ALTER TABLE `fb_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_conversation`
--
ALTER TABLE `fb_conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_customers`
--
ALTER TABLE `fb_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `fb_pages`
--
ALTER TABLE `fb_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fb_posts`
--
ALTER TABLE `fb_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_post_comments`
--
ALTER TABLE `fb_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `file_usage`
--
ALTER TABLE `file_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order_changes`
--
ALTER TABLE `order_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_imports`
--
ALTER TABLE `order_imports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_revisions`
--
ALTER TABLE `order_revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `perms`
--
ALTER TABLE `perms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles_perms`
--
ALTER TABLE `roles_perms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shipping_services`
--
ALTER TABLE `shipping_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_books`
--
ALTER TABLE `stock_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_deliverings`
--
ALTER TABLE `stock_deliverings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_deliverings_products`
--
ALTER TABLE `stock_deliverings_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_receivings`
--
ALTER TABLE `stock_receivings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_receivings_products`
--
ALTER TABLE `stock_receivings_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
