-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2014 at 09:40 AM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `message`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(100) unsigned DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` varchar(1200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_count` int(10) unsigned NOT NULL DEFAULT '1',
  `end_time` int(100) unsigned DEFAULT NULL,
  `expired` int(10) NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `login_id`, `nickname`, `subject`, `body`, `image_url`, `message_id`, `password`, `read_count`, `end_time`, `expired`, `modified`, `created`) VALUES
(1, 1, 'quan', 's1', 'c1', 'i11', NULL, 'p1', 4, 3, 0, '2014-06-29 16:47:00', '2014-06-29 16:42:44'),
(2, 1, 'abc2', 's22', 'c2', 'i2', NULL, '12121', 2121, 11, 0, '2014-06-29 17:53:06', '2014-06-29 16:47:52'),
(3, 0, 'n3', 's3', 'm3', 'i3', NULL, 'sff', 3, 3, 0, '2014-06-29 17:50:51', '2014-06-29 17:50:51'),
(4, 0, 'asd', 'asd', 'sad', 'sad', NULL, 'cz', 1, 1, 0, '2014-06-29 17:56:11', '2014-06-29 17:56:11'),
(5, 0, 'asd', 'asd', 'sad', 'sad', NULL, 'fsd', 1, 1, 0, '2014-06-29 17:56:44', '2014-06-29 17:56:44'),
(6, 2, 'das', 'dasd', 'dsad', 'dsad', NULL, 'sad', 11, 2, 0, '2014-06-29 17:57:45', '2014-06-29 17:57:45'),
(7, NULL, 'quan', 'ss', 'bb', '123', NULL, '111', 1, 1, 0, '2014-07-01 06:10:08', '2014-07-01 06:10:08'),
(8, NULL, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:07:21', '2014-07-01 07:07:21'),
(9, NULL, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:55:08', '2014-07-01 07:55:08'),
(10, NULL, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:57:06', '2014-07-01 07:57:06'),
(11, NULL, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:57:47', '2014-07-01 07:57:47'),
(12, NULL, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:58:07', '2014-07-01 07:58:07'),
(13, 58, 'quan', 'ss', '11', 'image', NULL, '123', 1, 1, 0, '2014-07-01 07:59:35', '2014-07-01 07:59:35'),
(14, 2, '11', '22', '33', 'files/thumbnails/', NULL, 'sqw', 1, 1, 0, '2014-07-01 09:40:07', '2014-07-01 09:40:07'),
(15, 2, '11', '22', '33', 'files/thumbnails/', NULL, 'ddsds', 1, 1, 0, '2014-07-01 09:41:31', '2014-07-01 09:41:31'),
(16, 2, '11', '22', '33', 'files/thumbnails/1404200696_thumbnail_1404200696_ã‚¯ãƒ­ã‚¹ãƒ¯ãƒ¼ãƒ‰æŒ‡æ‘˜äº‹é …ï¼”ï¼”ç”»åƒ.PNG', NULL, '123', 1, 1, 0, '2014-07-01 09:44:56', '2014-07-01 09:44:56'),
(17, 0, '4324', '4234', '23423', '/Applications/MAMP/htdocs/cakeFramework/app/webroot/files/thumbnails/1404200935_thumbnail_blockHyper_01_touch.png', NULL, '213', 22, 0, 0, '2014-07-01 09:48:55', '2014-07-01 09:48:55'),
(18, 0, '4324', '4234', '23423', '/cakeFramework/files/thumbnails/1404201112_thumbnail_1404201112_blockHyper_01_touch.png', NULL, '2323', 22, 0, 0, '2014-07-01 09:51:52', '2014-07-01 09:51:52'),
(19, 0, 'fsf', 'fdsfsdf', 'fsdf', '/cakeFramework/files/thumbnails/1404201301_thumbnail_1404201301_blockSuper_01_touch.png', NULL, 'dasdas', 323, 164, 0, '2014-07-01 09:55:01', '2014-07-01 09:55:01'),
(20, 0, 'fsf', 'fdsfsdf', 'fsdf', 'http://localhost:8888/cakeFramework/files/thumbnails/1404201749_thumbnail_1404201749_blockHyper_01_touch.png', NULL, 'fsfs', 323, 164, 0, '2014-07-01 10:02:29', '2014-07-01 09:56:05'),
(21, NULL, NULL, NULL, NULL, 'http://localhost:8888/cakeFramework/files/thumbnails/1404205212_thumbnail_blockSuper_01.png', NULL, NULL, 0, NULL, 0, '2014-07-01 11:00:12', '2014-07-01 11:00:12'),
(22, NULL, NULL, NULL, NULL, 'http://localhost:8888/cakeFramework/files/thumbnails/1404205232_thumbnail_iOS Simulator Screen shot Jun 27, 2014 10.05.31 AM.png', NULL, NULL, 0, NULL, 0, '2014-07-01 11:00:32', '2014-07-01 11:00:32'),
(23, NULL, NULL, NULL, NULL, 'http://localhost:8888/cakeFramework/files/thumbnails/1404205313_thumbnail_1404205313_iOS Simulator Screen shot Jun 27, 2014 10.05.31 AM.png', NULL, NULL, 0, NULL, 0, '2014-07-01 11:01:53', '2014-07-01 11:01:53'),
(24, 58, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404205404_thumbnail_1404205404_iOS Simulator Screen shot Jun 27, 2014 10.05.31 AM.png', NULL, '123', 1, 1, 0, '2014-07-01 11:03:24', '2014-07-01 11:03:24'),
(25, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404288882_thumbnail_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', '5f421968', '123', 1, 1, 0, '2014-07-02 10:14:42', '2014-07-02 10:14:42'),
(26, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404288909_thumbnail_1404288909_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', '8e10b5c8', '123', 1, 1, 0, '2014-07-02 10:15:09', '2014-07-02 10:15:09'),
(27, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404289121_thumbnail_1404289121_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', 'a934658a', '123', 1, 1, 0, '2014-07-02 10:18:41', '2014-07-02 10:18:41'),
(28, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404289189_thumbnail_1404289189_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', '3a1aa439', '123', 1, 1, 0, '2014-07-02 10:19:49', '2014-07-02 10:19:49'),
(29, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404289192_thumbnail_1404289192_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', 'be23db46', '123', 0, 1, 0, '2014-07-03 07:06:41', '2014-07-02 10:19:52'),
(30, 1, 'quan', 'ss', '11', 'http://localhost:8888/cakeFramework/files/thumbnails/1404291111_thumbnail_1404291111_iOS Simulator Screen shot Jul 1, 2014 8.25.45 PM.png', '64d28e31', '123', 1, 1, 0, '2014-07-02 10:51:51', '2014-07-02 10:51:51'),
(31, 1, 'quan', 'ss', '11', NULL, '6e17bdf5', '123', 1, 1, 0, '2014-07-03 05:52:32', '2014-07-03 05:52:32'),
(32, 1, 'quan', 'ss', '11', NULL, '43083431', '123', 0, 1, 1, '2014-07-03 09:37:55', '2014-07-03 05:57:28'),
(33, 1, 'quan', 'ss', '11', NULL, 'fb47501c', '123', 1, 1, 0, '2014-07-03 06:32:25', '2014-07-03 06:32:25'),
(34, 1, 'quan', 'ss', '11', NULL, '54df4a49', '123', 1, 1, 0, '2014-07-03 08:20:49', '2014-07-03 08:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT '0',
  `tokenhash` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tokensecret` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social` int(10) unsigned DEFAULT '0',
  `social_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=60 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`, `active`, `tokenhash`, `tokensecret`, `social`, `social_id`, `created`, `modified`) VALUES
(1, 'admin', 'quan', 'quanbeodt1@gmail.com', '65acacb1eb1b7ebeef9555bb9f2e3f185966da41', 1, '', '', 0, NULL, '2011-09-26 00:34:07', '2014-07-03 08:23:43'),
(58, 'user', 'quan11', 'quanbeodt1@gmail.com', '2248083320-Peag50OAq5vv9eyDHWjAeuprAZb4J10KcgPQC9f', 1, '2248083320-Peag50OAq5vv9eyDHWjAeuprAZb4J10KcgPQC9f', '0aBHGRf51gZ8mJbrJEp9WuNRFQZwNdeOYbV7ByzpQcCmM', 2, NULL, '2014-06-30 15:47:34', '2014-07-01 05:02:06'),
(59, 'user', 'quan11', 'quanbeodt1@gmail.com', 'CAAIsxxePtL0BAFxbAW1FzBBrbmKPZA9ogZAJsT9Ylr5qoY5i7nlleMTBFMHTH7zQuRq8KAFV7ZByaQzcsbxYpBtUeUZCuEFpLj5MvI928L5hFwk0jjfrcq9yjmkBFS1KHx0H147hAZAVnlZAFAFb0P1GBR6rwAprHWZBCogul1hlyEloMWrTzRrersIBRqp9F0ZD', 1, 'CAAIsxxePtL0BAFxbAW1FzBBrbmKPZA9ogZAJsT9Ylr5qoY5i7nlleMTBFMHTH7zQuRq8KAFV7ZByaQzcsbxYpBtUeUZCuEFpLj5MvI928L5hFwk0jjfrcq9yjmkBFS1KHx0H147hAZAVnlZAFAFb0P1GBR6rwAprHWZBCogul1hlyEloMWrTzRrersIBRqp9F0ZD', NULL, 1, NULL, '2014-07-01 04:09:30', '2014-07-01 04:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(10) unsigned NOT NULL,
  `token` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `registed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=115 ;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`id`, `login_id`, `token`, `registed`) VALUES
(114, 1, 'a8777c743af4056dbf954ecaba288a8da6349eb8', '2014-07-02 09:35:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
