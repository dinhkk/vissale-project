-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2016 at 08:51 AM
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
CREATE DATABASE IF NOT EXISTS `fbsale_dinhkk_com` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fbsale_dinhkk_com`;

-- --------------------------------------------------------

--
-- Table structure for table `billing_prints`
--

DROP TABLE IF EXISTS `billing_prints`;
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

DROP TABLE IF EXISTS `bundles`;
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

DROP TABLE IF EXISTS `fb_blacklists`;
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

DROP TABLE IF EXISTS `fb_configs`;
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

DROP TABLE IF EXISTS `fb_conversation`;
CREATE TABLE `fb_conversation` (
  `id` int(11) NOT NULL,
  `conversation_id` varchar(100) NOT NULL,
  `fb_customer_id` int(11) NOT NULL,
  `fb_user_id` varchar(100) NOT NULL COMMENT 'congmt: id cua user inbox',
  `page_id` varchar(50) DEFAULT NULL,
  `fb_page_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `last_conversation_time` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='danh sach cac conversation cua page';

--
-- Dumping data for table `fb_conversation`
--

INSERT INTO `fb_conversation` (`id`, `conversation_id`, `fb_customer_id`, `fb_user_id`, `page_id`, `fb_page_id`, `group_id`, `last_conversation_time`, `link`, `status`, `created`, `modified`) VALUES
(1, 't_mid.1458747874955:c4cc468582aa231e71', 8, '10204353645080711', '734899429950601', 6, 1, 1458752877, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A1817380164&threadid=mid.1458747874955%3Ac4cc468582aa231e71&folder=inbox', 0, '2016-03-23 22:47:54', '2016-03-23 23:08:05'),
(3, 't_mid.1458747979012:ea167b204e2562ff91', 0, '10201419679451205', '734899429950601', 6, 1, 1458752879, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A1751406993&threadid=mid.1458747979012%3Aea167b204e2562ff91&folder=inbox', 0, '2016-03-23 23:06:08', '2016-03-23 23:08:04'),
(4, 't_mid.1458744909503:6edab9a9a4ed7c2921', 0, '734899429950601', '734899429950601', 6, 1, 1458752879, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100005300466333&threadid=mid.1458744909503%3A6edab9a9a4ed7c2921&folder=inbox', 0, '2016-03-23 23:06:12', '2016-03-23 23:08:03'),
(5, 't_mid.1458731598873:6e236024ada4c4bf66', 0, '734899429950601', '734899429950601', 6, 1, 1458752880, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100001497473692&threadid=mid.1458731598873%3A6e236024ada4c4bf66&folder=inbox', 0, '2016-03-23 23:06:14', '2016-03-23 23:08:01'),
(6, 't_mid.1458730529512:5cf485aa16d0f14694', 1, '176718519385100', '734899429950601', 6, 1, 1458752881, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100011408598171&threadid=mid.1458730529512%3A5cf485aa16d0f14694&folder=inbox', 0, '2016-03-23 23:06:16', '2016-03-23 23:07:59'),
(7, 't_mid.1423815438741:08950771566a90bc92', 0, '734899429950601', '734899429950601', 6, 1, 1458752882, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100009086388170&threadid=mid.1423815438741%3A08950771566a90bc92&folder=inbox', 0, '2016-03-23 23:06:18', '2016-03-23 23:07:57'),
(8, 't_mid.1423735863693:b80290022fb9d37209', 0, '734899429950601', '734899429950601', 6, 1, 1458752883, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100000241525017&threadid=mid.1423735863693%3Ab80290022fb9d37209&folder=inbox', 0, '2016-03-23 23:06:21', '2016-03-23 23:07:56'),
(9, 't_mid.1458726506823:850ed9acd7b707cb06', 0, '734899429950601', '734899429950601', 6, 1, 1458752884, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100006638891142&threadid=mid.1458726506823%3A850ed9acd7b707cb06&folder=inbox', 0, '2016-03-23 23:06:23', '2016-03-23 23:07:54'),
(10, 't_mid.1423739335272:5c385ccc9d89f60880', 0, '1568971496750083', '734899429950601', 6, 1, 1458752885, '/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100009117427534&threadid=mid.1423739335272%3A5c385ccc9d89f60880&folder=inbox', 0, '2016-03-23 23:06:25', '2016-03-23 23:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `fb_conversation_messages`
--

DROP TABLE IF EXISTS `fb_conversation_messages`;
CREATE TABLE `fb_conversation_messages` (
  `id` int(11) NOT NULL,
  `fb_conversation_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fb_customer_id` int(11) DEFAULT NULL,
  `fb_user_id` varchar(50) DEFAULT NULL,
  `fb_page_id` int(11) DEFAULT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fb_conversation_messages`
--

INSERT INTO `fb_conversation_messages` (`id`, `fb_conversation_id`, `group_id`, `fb_customer_id`, `fb_user_id`, `fb_page_id`, `message_id`, `content`, `status`, `user_created`, `created`, `modified`) VALUES
(0, 1, 1, 0, '734899429950601', 6, 'm_mid.1458749285346:ce53465fc366481128', 'Ban vui long de lai SDT', 0, 1458749285, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 1, 1, 0, '734899429950601', 6, 'm_mid.1458749164851:9e8b3b402831f9a891', 'Chung toi se lien lac lai sau.', 0, 1458749164, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 1, 1, 0, '10204353645080711', 6, 'm_mid.1458748297223:eb5d01193d59c8cc55', '0123456789', 0, 1458748297, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 1, 1, 0, '10204353645080711', 6, 'm_mid.1458748290522:dbaae24e95fadd9a10', 'sao lien lac the', 0, 1458748290, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 1, 1, 0, '734899429950601', 6, 'm_mid.1458748053464:cfffd08763e6209d41', 'Chung toi se lien lac lai sau.', 0, 1458748053, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 1, 1, 0, '10204353645080711', 6, 'm_mid.1458747874955:c4cc468582aa231e71', 'gá»i cho mÃ¬nh theo sá»‘ 01689999999', 0, 1458747875, '2016-03-24 00:07:58', '2016-03-24 00:07:58'),
(0, 3, 1, 0, '734899429950601', 6, 'm_mid.1458750217699:a4faf821dedb905369', 'sao :D', 0, 1458750217, '2016-03-24 00:07:59', '2016-03-24 00:07:59'),
(0, 3, 1, 0, '734899429950601', 6, 'm_mid.1458749283968:6e196452145bac9200', 'Ban vui long de lai SDT', 0, 1458749284, '2016-03-24 00:07:59', '2016-03-24 00:07:59'),
(0, 3, 1, 0, '734899429950601', 6, 'm_mid.1458749168199:c492d08b6529508c77', 'Ban vui long de lai SDT', 0, 1458749168, '2016-03-24 00:07:59', '2016-03-24 00:07:59'),
(0, 3, 1, 0, '10201419679451205', 6, 'm_mid.1458747980945:eed31392779dd32a55', ':v', 0, 1458747980, '2016-03-24 00:07:59', '2016-03-24 00:07:59'),
(0, 3, 1, 0, '10201419679451205', 6, 'm_mid.1458747979012:ea167b204e2562ff91', 'eh', 0, 1458747979, '2016-03-24 00:07:59', '2016-03-24 00:07:59'),
(0, 4, 1, 0, '734899429950601', 6, 'm_mid.1458749282690:2518b33f2923935d85', 'Ban vui long de lai SDT', 0, 1458749282, '2016-03-24 00:08:00', '2016-03-24 00:08:00'),
(0, 4, 1, 0, '734899429950601', 6, 'm_mid.1458749171931:4864a1bce3badd3901', 'Ban vui long de lai SDT', 0, 1458749171, '2016-03-24 00:08:00', '2016-03-24 00:08:00'),
(0, 4, 1, 0, '734899429950601', 6, 'm_mid.1458745391025:b521197c5004e8e963', 'Chung toi se lien lac lai sau.', 0, 1458745391, '2016-03-24 00:08:00', '2016-03-24 00:08:00'),
(0, 4, 1, 0, '507876442732367', 6, 'm_mid.1458744909503:6edab9a9a4ed7c2921', 'cho 100likes nhe 0946368463', 0, 1458744911, '2016-03-24 00:08:00', '2016-03-24 00:08:00'),
(0, 5, 1, 0, '734899429950601', 6, 'm_mid.1458749281168:cb7ee8268c95b2f973', 'Ban vui long de lai SDT', 0, 1458749281, '2016-03-24 00:08:01', '2016-03-24 00:08:01'),
(0, 5, 1, 0, '734899429950601', 6, 'm_mid.1458749173549:748dbe22f389d52e04', 'Ban vui long de lai SDT', 0, 1458749173, '2016-03-24 00:08:01', '2016-03-24 00:08:01'),
(0, 5, 1, 0, '734899429950601', 6, 'm_mid.1458731979650:117bd02f8e15091d66', 'asjhfkls', 0, 1458731979, '2016-03-24 00:08:01', '2016-03-24 00:08:01'),
(0, 5, 1, 0, '734899429950601', 6, 'm_mid.1458731699037:e6c21a03920ef70891', 'Chung toi se lien lac lai sau.', 0, 1458731699, '2016-03-24 00:08:01', '2016-03-24 00:08:01'),
(0, 5, 1, 0, '1062616503798255', 6, 'm_mid.1458731598873:6e236024ada4c4bf66', 'can 1tr like 0966496489', 0, 1458731599, '2016-03-24 00:08:01', '2016-03-24 00:08:01'),
(0, 6, 1, 0, '734899429950601', 6, 'm_mid.1458749279173:e59ca356b1b8ed0b79', 'Ban vui long de lai SDT', 0, 1458749279, '2016-03-24 00:08:02', '2016-03-24 00:08:02'),
(0, 6, 1, 0, '734899429950601', 6, 'm_mid.1458749176296:99211d7c4747f15e55', 'Chung toi se lien lac lai sau.', 0, 1458749176, '2016-03-24 00:08:02', '2016-03-24 00:08:02'),
(0, 6, 1, 0, '176718519385100', 6, 'm_mid.1458731017895:35304d0f0ae5477367', 'toi muon dat mua them 1tr likes 0966496489', 0, 1458731017, '2016-03-24 00:08:02', '2016-03-24 00:08:02'),
(0, 6, 1, 0, '734899429950601', 6, 'm_mid.1458730583233:0b48fae44c7f973587', 'Chung toi se lien lac lai sau.', 0, 1458730583, '2016-03-24 00:08:02', '2016-03-24 00:08:02'),
(0, 6, 1, 0, '176718519385100', 6, 'm_mid.1458730529512:5cf485aa16d0f14694', 'toi muon dat mua 1000 like nhe 0966496489', 0, 1458730529, '2016-03-24 00:08:02', '2016-03-24 00:08:02'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458749277527:5a79e1b3c4f829a274', 'Ban vui long de lai SDT', 0, 1458749277, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458749177790:b5e9490df066c48054', 'Ban vui long de lai SDT', 0, 1458749178, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458726840792:9e53413a2844b46700', 'Ban vui long de lai SDT', 0, 1458726840, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458726136604:12e720d3dc47d42a02', '', 0, 1458726136, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458145175884:1744fc48c7e553be33', 'thoi ko chat nua', 0, 1458145175, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458145175883:28ec859a74a716d480', 'thoi ko chat nua', 0, 1458145175, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458144888450:b607b4a2798a41a052', 'hehehe, dc day nhi :D', 0, 1458144888, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458144803941:7a7541f1c7da569373', 'hehehe, dc day nhi :D', 0, 1458144804, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458026350157:a229cb29e402fd0806', 'duoc roi, cu binh tinh :D', 0, 1458026350, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '734899429950601', 6, 'm_mid.1458025157758:0e7e1e4b19de446f54', 'xin chao ban', 0, 1458025157, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 7, 1, 0, '1561110310868500', 6, 'm_mid.1423815438741:08950771566a90bc92', '2015-02-13 03:17:18 : Free fb like/comment, go to http://gainsocialfollowers.com/facebook-package-0/', 0, 1423815438, '2016-03-24 00:08:03', '2016-03-24 00:08:03'),
(0, 8, 1, 0, '734899429950601', 6, 'm_mid.1458749275410:1aa8bf4cb5416e9754', 'Ban vui long de lai SDT', 0, 1458749275, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 8, 1, 0, '734899429950601', 6, 'm_mid.1458749180946:3a2bcd6f78078cbc27', 'Ban vui long de lai SDT', 0, 1458749181, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 8, 1, 0, '734899429950601', 6, 'm_mid.1458726839815:6f9dae54624ae0f376', 'Ban vui long de lai SDT', 0, 1458726839, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 8, 1, 0, '734899429950601', 6, 'm_mid.1458726331961:1b1597cdde089c0d37', '', 0, 1458726332, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 8, 1, 0, '734899429950601', 6, 'm_mid.1458025152197:1ca52583373526a968', 'hehe', 0, 1458025152, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 8, 1, 0, '1190410200977019', 6, 'm_mid.1423735863693:b80290022fb9d37209', '2015-02-12 17:10:56 : Free fb like/comment, go to http://gainsocialfollowers.com/facebook-package-0/', 0, 1423735863, '2016-03-24 00:08:04', '2016-03-24 00:08:04'),
(0, 9, 1, 0, '734899429950601', 6, 'm_mid.1458749274082:dd9109aa1ffb774459', 'Ban vui long de lai SDT', 0, 1458749274, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 9, 1, 0, '734899429950601', 6, 'm_mid.1458749182512:b041183ff96959d962', 'Ban vui long de lai SDT', 0, 1458749182, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 9, 1, 0, '734899429950601', 6, 'm_mid.1458726660720:21ca2519d463d92430', 'Chung toi se lien lac lai sau.', 0, 1458726660, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 9, 1, 0, '1744063649158248', 6, 'm_mid.1458726506823:850ed9acd7b707cb06', 'toi dat hang may tinh 0977777777', 0, 1458726507, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 10, 1, 0, '1568971496750083', 6, 'm_mid.1423813620609:18cc52ff0989431411', '2015-02-13 02:47:00 : Free fb like/comment, go to http://gainsocialfollowers.com/facebook-package-0/', 0, 1423813620, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 10, 1, 0, '1568971496750083', 6, 'm_mid.1423801154425:13d35f83ed0c0c8615', '2015-02-12 23:19:14 : Free fb like/comment, go to http://gainsocialfollowers.com/facebook-package-0/', 0, 1423801154, '2016-03-24 00:08:05', '2016-03-24 00:08:05'),
(0, 10, 1, 0, '1568971496750083', 6, 'm_mid.1423739335272:5c385ccc9d89f60880', '2015-02-12 06:08:55 : Free fb like/comment, go to http://gainsocialfollowers.com/facebook-package-0/', 0, 1423739335, '2016-03-24 00:08:05', '2016-03-24 00:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `fb_cron_config`
--

DROP TABLE IF EXISTS `fb_cron_config`;
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
(1, 'hide_phone_comment', 1, '', '1', '2016-03-23 00:30:39', '2016-03-23 00:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `fb_customers`
--

DROP TABLE IF EXISTS `fb_customers`;
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
(1, 1, '176718519385100', NULL, 'Tien Cong Mac', NULL, '0966496489', NULL, NULL, '2016-03-22 19:58:15', '2016-03-23 23:06:15'),
(6, 1, '1744063649158248', NULL, 'Trá»‹nh Tháº¿ Äá»‹nh', NULL, '0977434994', NULL, NULL, '2016-03-23 15:14:25', '2016-03-23 15:14:32'),
(8, 1, '10204353645080711', NULL, 'Ngo Quang Trung', NULL, '01689999999', NULL, NULL, '2016-03-23 22:47:24', '2016-03-23 22:47:24'),
(9, 1, '10204353645080711', NULL, 'Ngo Quang Trung', NULL, '01689405616', NULL, NULL, '2016-03-23 22:52:14', '2016-03-23 22:52:14'),
(10, 1, '507876442732367', NULL, 'Luong Mac', NULL, '0945386465', NULL, NULL, '2016-03-23 22:52:16', '2016-03-23 22:52:16'),
(11, 1, '10204353645080711', NULL, 'Ngo Quang Trung', NULL, '0123456789', NULL, NULL, '2016-03-23 23:06:04', '2016-03-23 23:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `fb_pages`
--

DROP TABLE IF EXISTS `fb_pages`;
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
(6, 1, '734899429950601', 'Gain Social Followers', 'CAANwODEJRXABAElVBEO0H6ZCyUPxMWEs8WRJSrKJBmZCMOeQZAYvJZAvk2d6sJuHQzN4vrIZB9t29Gy4CY7WcL8LdgvZBSWXsHw0oRLzcHLIv5mVYCqa0Vfmb7ZCtoNfDcBcRcIIO2CBZBFUYK6AdO2fBZAMBUnHis03Vk5NvPM2VZCsGiYZC3yp8Rl4MJLI265vLhHtXiAno4YQgZDZD', 1423813620, 0, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(7, 1, '286947824664766', 'vteen.vn', 'CAANwODEJRXABAKbyWJOZAfKjP082TXCr1gS1riFHEjnZAq4UhD7UE8FzLTIw6lwRovei2fvWP7IZCSwwecAhPbnF7lDqWF9NRHret2wvbBuh96f0EkgMbDosUwZC0ujFsYy7CwHSMAPZBgwHAsDYr5xvr16MK2n1ViNR1L5AzAUGbBqC8rOA5243l6SH9euG6MEJDhuwpDQZDZD', NULL, 1, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(8, 1, '749336251850712', 'MacShop', 'CAANwODEJRXABACRZBeOPPGIJD0c6YP4ZBE9HGK0ARqMvhaMKmNy8sw00fqNNAce4ndgQJU8vzs4N3YMEl4sWdZAR6SriaQA6gwy5ZAMBnvdHNxlVwBnvhHtVwoUQhaBluMEuviX217NlZAdaLFwmuu04T7iTjOYzaOkGZC2QYeZChDr3A2jLZA8uv5UZARDcljoPqpwblSiZAUKQZDZD', NULL, 1, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(9, 1, '1466625843584680', 'Test', 'CAANwODEJRXABAHeAcrspvFZCSsqhYi7w4E2kyvouetgZBOVZBPH0DGSoTCSQ9If43a3B1ZCuh4J8nRoV6Us4O08F07QP26k2OobINfv3aJF8LAivrGrp82hoAb3QM54ZAyGFfV6xYVO3udgIIZA1egxCtKcmIoU1SNkYZA9gSkE3quhg4DDZBlZAZBANvKAwSX4LJ6sc1vGSC7pAZDZD', NULL, 1, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18'),
(10, 1, '1454002211514575', 'TestPage', 'CAANwODEJRXABAEJyr2IRStRbJPusszv3YVlaK69W7LxdVZAoh00qdqCxn78FeE7WjQD8krLuCLbwpQk3wtkN5ZCmurXdX6X1hZBFnYVNMxiCvCBLcpZAvyO6a6wnLZBGHx92JFVpqCiCjXpeZAx4yZAUa8Bg1i2ZCWHTEML03Tnni9EO0PLlIiqEfdyMKKKAjmaqTPgrTInhZBQZDZD', NULL, 1, 1458549378, '2016-03-21 15:36:18', '2016-03-21 15:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `fb_posts`
--

DROP TABLE IF EXISTS `fb_posts`;
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
  `hide_phone_comment` tinyint(4) DEFAULT '0',
  `last_time_fetch_comment` int(11) DEFAULT NULL COMMENT AS `congmt: thoi diem thuc hien lay order (comment) cuoi cung`,
  `next_time_fetch_comment` int(11) DEFAULT NULL COMMENT AS `congmt: thoi diem thuc hien lay order tiep theo`,
  `level_fetch_comment` tinyint(4) NOT NULL DEFAULT '0'COMMENT
) ;

--
-- Dumping data for table `fb_posts`
--

INSERT INTO `fb_posts` (`id`, `group_id`, `page_id`, `post_id`, `fb_page_id`, `fb_post_id`, `description`, `product_id`, `bundle_id`, `answer_phone`, `answer_nophone`, `disable_comment`, `last_time_fetch_comment`, `next_time_fetch_comment`, `level_fetch_comment`, `status`, `server_ip`, `nodata_number_day`, `created`, `modified`) VALUES
(2, 1, '734899429950601', '734899429950601_739601006147110', 6, 2, NULL, 1, 1, 'từ từ để gọi', 'để lại SĐT rồi nói chuyện', 1, 1458748312, 1458585089, 0, 0, NULL, 0, '2016-03-21 00:00:00', '2016-03-23 22:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `fb_post_comments`
--

DROP TABLE IF EXISTS `fb_post_comments`;
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
(2, 1, 1, 6, '734899429950601', 2, '734899429950601_739601006147110', '739601006147110_947473955359813', 'lam phat 1tr like xem sao 0966496489', '0', 0, NULL, '2016-03-22 20:22:05', '2016-03-22 20:22:05'),
(3, 1, 9, 6, '734899429950601', 2, '734899429950601_739601006147110', '739601006147110_948612741912601', 'test 01689405616', '0', 0, NULL, '2016-03-23 22:52:14', '2016-03-23 22:52:14'),
(4, 1, 10, 6, '734899429950601', 2, '734899429950601_739601006147110', '739601006147110_948576241916251', 'cho toi 100like 0945386465', '0', 0, NULL, '2016-03-23 22:52:16', '2016-03-23 22:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
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

DROP TABLE IF EXISTS `file_usage`;
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

DROP TABLE IF EXISTS `groups`;
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

DROP TABLE IF EXISTS `inventories`;
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

DROP TABLE IF EXISTS `orders`;
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
(4, 1, 6, 6, 2, 0, 1, '57OkckhQE8', NULL, 'Trá»‹nh Tháº¿ Äá»‹nh', '0977434994', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-23 15:14:32', '2016-03-23 15:14:32'),
(5, 1, 9, 6, 2, 3, 1, 'RgW4ufSHFX', NULL, 'Ngo Quang Trung', '01689405616', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-23 22:52:14', '2016-03-23 22:52:14'),
(6, 1, 10, 6, 2, 4, 1, 'OFxicNzi78', NULL, 'Luong Mac', '0945386465', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 1, 1, 10000, 0, 0, 0, 10000, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-23 22:52:16', '2016-03-23 22:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

DROP TABLE IF EXISTS `orders_products`;
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
(4, 4, 1, 10000, 1, '2016-03-23 15:14:32', '2016-03-23 15:14:32'),
(5, 5, 1, 10000, 1, '2016-03-23 22:52:14', '2016-03-23 22:52:14'),
(6, 6, 1, 10000, 1, '2016-03-23 22:52:16', '2016-03-23 22:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `order_changes`
--

DROP TABLE IF EXISTS `order_changes`;
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

DROP TABLE IF EXISTS `order_imports`;
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

DROP TABLE IF EXISTS `order_revisions`;
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

DROP TABLE IF EXISTS `perms`;
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

DROP TABLE IF EXISTS `products`;
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

DROP TABLE IF EXISTS `roles`;
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

DROP TABLE IF EXISTS `roles_perms`;
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

DROP TABLE IF EXISTS `shipping_services`;
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

DROP TABLE IF EXISTS `statuses`;
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

DROP TABLE IF EXISTS `stocks`;
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

DROP TABLE IF EXISTS `stock_books`;
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

DROP TABLE IF EXISTS `stock_deliverings`;
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

DROP TABLE IF EXISTS `stock_deliverings_products`;
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

DROP TABLE IF EXISTS `stock_receivings`;
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

DROP TABLE IF EXISTS `stock_receivings_products`;
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

DROP TABLE IF EXISTS `suppliers`;
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

DROP TABLE IF EXISTS `units`;
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

DROP TABLE IF EXISTS `users`;
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

DROP TABLE IF EXISTS `users_roles`;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `fb_customers`
--
ALTER TABLE `fb_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
