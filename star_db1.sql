-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 15, 2023 at 05:28 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `star_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_i_follow`
--

DROP TABLE IF EXISTS `content_i_follow`;
CREATE TABLE IF NOT EXISTS `content_i_follow` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `userid` bigint NOT NULL,
  `contentid` bigint NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `contentid` (`contentid`),
  KEY `disabled` (`disabled`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meassges`
--

DROP TABLE IF EXISTS `meassges`;
CREATE TABLE IF NOT EXISTS `meassges` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `msgid` varchar(60) NOT NULL,
  `sender` bigint NOT NULL,
  `receiver` bigint NOT NULL,
  `message` text,
  `file` varchar(500) DEFAULT NULL,
  `received` tinyint(1) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_sender` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `msgid` (`msgid`),
  KEY `sender` (`sender`),
  KEY `received` (`received`),
  KEY `seen` (`seen`),
  KEY `receiver` (`receiver`),
  KEY `deleted_sender` (`deleted_sender`),
  KEY `deleted_receiver` (`deleted_receiver`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `userid` bigint NOT NULL,
  `activity` varchar(10) NOT NULL,
  `contentid` bigint NOT NULL,
  `content_owner` bigint NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `contentid` (`contentid`),
  KEY `content_owner` (`content_owner`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_seen`
--

DROP TABLE IF EXISTS `notification_seen`;
CREATE TABLE IF NOT EXISTS `notification_seen` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `userid` bigint NOT NULL,
  `notification_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `notification_id` (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `postid` bigint NOT NULL,
  `post` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `has_image` tinyint(1) NOT NULL,
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `parent` bigint NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` bigint NOT NULL,
  `stars` int NOT NULL,
  `comments` tinyint NOT NULL,
  ` title` varchar(2048) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postid` (`postid`),
  KEY `date` (`date`),
  KEY `userid` (`userid`),
  KEY `comments` (`comments`),
  KEY `stars` (`stars`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

DROP TABLE IF EXISTS `stars`;
CREATE TABLE IF NOT EXISTS `stars` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `stars` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `contentid` bigint NOT NULL,
  `following` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `contentid` (`contentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `userid` bigint NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `profile_image` varchar(500) NOT NULL,
  `cover_image` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `online` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `stars` int NOT NULL,
  `about` text NOT NULL,
  `title` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `date` (`date`),
  KEY `online` (`online`),
  KEY `email` (`email`),
  KEY `url_address` (`url_address`),
  KEY `stars` (`stars`) USING BTREE,
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `first_name`, `last_name`, `gender`, `profile_image`, `cover_image`, `date`, `online`, `email`, `password`, `url_address`, `stars`, `about`, `title`) VALUES
(1, 7348023179899108, 'Hridoy', 'Jomadder', 'Male', 'uploads/7348023179899108/OqzYYPIywZHgQR4.jpg', 'uploads/7348023179899108/k3JgEU513XMiPxZ.jpg', '0000-00-00 00:00:00', 1694755639, 'contacthridoyjomadder@gmail.com', '123', 'hridoy.jomadder', 0, 'Rules & Regulations\r\n1. Obligations of the applicant\r\na.	) The Applicant guarantees that all information in, or related to, a CV that is either uploaded by him/her validated by him/her, is correct, complete and accurate.\r\nb.	) The Applicant agrees that he/she is solely responsible for the content of any information placed on the Website by him/her, and for any consequence that may arise out of such placement.\r\nc.	) The Applicant undertakes not to use the Website to (i) download, send, or disseminate data containing viruses, worms, spyware, malware or any other similar malicious programs; or (ii) carry out any calculations, operations or transactions that may interrupt, destroy or restrict the functionality of the operation of the Website.\r\nd.	) Services on the Website are only accessible in case of complete and correct registration on the Website. Access to the services offered on the Website requires the combination of a login and a password. The Applicant undertakes to comply strictly with the appropriate procedures regarding access to the Website. The information regarding login and password are strictly personal and the Applicant is responsible for the safeguarding, confidentiality, security and appropriate use by him and undertakes to take all steps to prevent any unauthorised third party from gaining knowledge and making use thereof. The Applicant will notify Startup Bangladesh immediately of the loss, theft, breach of confidentiality or any risk of misuse of the login process. The Applicant is fully responsible for any use of the Website, as well as for any detrimental consequences that may arise directly or indirectly therefrom, until the time that such notification is made.\r\n', 'CEO-Star'),
(2, 762276656392054, 'Tuba', 'Islam', 'Female', 'uploads/762276656392054/qAeXmI9akZW0kY2.jpg', 'uploads/762276656392054/1fOUFyicU55aZwb.jpg', '0000-00-00 00:00:00', 1694667118, 'tuba@gmail.com', '123', 'tuba.islam', 0, 'i am tuba', 'CEO-Star'),
(3, 98143294600, 'Masud', 'Howlader', 'Male', 'uploads/98143294600/L0IzfiCHRdiS8h6.jpg', '', '0000-00-00 00:00:00', 1693669569, 'masud@gmail.com', '123', 'masud.howlader', 0, '', ''),
(4, 5904812520371, 'Rabby', 'Jomadder', 'Male', 'uploads/5904812520371/5ElIB5JbL46FRvF.jpg', '', '0000-00-00 00:00:00', 1693399582, 'rabbyjomadder@gmail.com', '123', 'rabby.jomadder', 0, '', ''),
(5, 481, 'Reza', 'Islam', 'Male', 'uploads/481/vVe3FuUg3ryic55.jpg', '', '0000-00-00 00:00:00', 1694363141, 'reza@gmail.com', '123', 'reza.islam', 0, '', ''),
(6, 84621538018125, 'Rani', 'Akter', 'Female', 'uploads/84621538018125/ekNKQfEgZmTdyVp.jpg', '', '0000-00-00 00:00:00', 1694014540, 'rani@gmail.com', '123', 'rani.akter', 0, '', ''),
(7, 636421473799392, '????', '?????????', 'Male', '', '', '0000-00-00 00:00:00', 1694146637, 'demo@demo.com', '123', '????.?????????', 0, '', ''),
(8, 647616355381812, '?????', '????', 'Male', '', '', '0000-00-00 00:00:00', 1694314281, 'demo1@demo.com', '123', '?????.????', 0, '', '????');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
