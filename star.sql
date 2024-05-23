-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 05:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

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
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `email`, `code`, `expire`) VALUES
(1, 'contacthridoyjomadder@gmail.com', '59223', 1695968851),
(4, 'reza@gmail.com', '58908', 1706793313),
(5, 'reza@gmail.com', '77185', 1706793542);

-- --------------------------------------------------------

--
-- Table structure for table `content_i_follow`
--

CREATE TABLE `content_i_follow` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `contentid` bigint(20) NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meassges`
--

CREATE TABLE `meassges` (
  `id` bigint(20) NOT NULL,
  `msgid` varchar(60) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `receiver` bigint(20) NOT NULL,
  `message` text DEFAULT NULL,
  `file` varchar(500) DEFAULT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_sender` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `activity` varchar(10) NOT NULL,
  `contentid` bigint(20) NOT NULL,
  `content_owner` bigint(20) NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userid`, `activity`, `contentid`, `content_owner`, `content_type`, `date`) VALUES
(103, 7348023179899108, 'follow', 98143294600, 0, '', '2024-04-21 11:38:08'),
(104, 481, 'follow', 7348023179899108, 0, '', '2024-04-21 11:54:01'),
(105, 5904812520371, 'follow', 7348023179899108, 0, '', '2024-04-22 06:54:40'),
(106, 7348023179899108, 'follow', 481, 0, '', '2024-04-22 07:04:55'),
(107, 7348023179899108, 'star', 870794763804005715, 0, 'post', '2024-05-10 05:43:29'),
(108, 7348023179899108, 'star', 870794763804005715, 0, 'post', '2024-05-10 05:56:42'),
(109, 7348023179899108, 'star', 870794763804005715, 0, 'post', '2024-05-10 05:58:28'),
(110, 7348023179899108, 'star', 85765, 0, 'post', '2024-05-10 06:19:14'),
(111, 762276656392054, 'star', 85765, 0, 'post', '2024-05-10 06:34:34'),
(112, 762276656392054, 'follow', 7348023179899108, 0, '', '2024-05-10 06:35:06'),
(113, 7348023179899108, 'follow', 762276656392054, 0, '', '2024-05-10 06:37:19'),
(114, 7348023179899108, 'star', 1176715409989612, 0, 'post', '2024-05-10 19:12:12'),
(115, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:18:20'),
(116, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:18:34'),
(117, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:19:32'),
(118, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:19:34'),
(119, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:19:40'),
(120, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:19:51'),
(121, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:20:06'),
(122, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:20:07'),
(123, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:20:25'),
(124, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:20:28'),
(125, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:21:06'),
(126, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:21:17'),
(127, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:21:20'),
(128, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:23:13'),
(129, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:23:40'),
(130, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:27:26'),
(131, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:27:28'),
(132, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:27:38'),
(133, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-11 19:52:17'),
(134, 7348023179899108, 'star', 42459884, 0, 'post', '2024-05-12 05:58:22'),
(135, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 06:03:09'),
(136, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 06:06:30'),
(137, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 06:06:37'),
(138, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 11:46:00'),
(139, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 11:46:08'),
(140, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 11:50:42'),
(141, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 11:51:25'),
(142, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 11:51:29'),
(143, 7348023179899108, 'follow', 98143294600, 0, '', '2024-05-12 11:59:23'),
(144, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 12:03:49'),
(145, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 12:08:35'),
(146, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-12 12:32:33'),
(147, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-16 19:13:39'),
(148, 7348023179899108, 'star', 385101712, 0, 'post', '2024-05-17 17:20:29'),
(149, 7348023179899108, 'star', 3631065467, 0, 'comment', '2024-05-17 17:20:56'),
(150, 7348023179899108, 'star', 67900, 0, 'post', '2024-05-17 18:15:23'),
(151, 7348023179899108, 'star', 67900, 0, 'post', '2024-05-17 18:15:27'),
(152, 7348023179899108, 'star', 67900, 0, 'post', '2024-05-17 18:31:27'),
(153, 7348023179899108, 'follow', 98143294600, 0, '', '2024-05-21 17:39:22'),
(154, 7348023179899108, 'follow', 481, 0, '', '2024-05-21 21:51:36'),
(155, 762276656392054, 'follow', 7348023179899108, 0, '', '2024-05-22 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `notification_seen`
--

CREATE TABLE `notification_seen` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `notification_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `post` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) NOT NULL,
  `has_image` tinyint(1) NOT NULL,
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `parent` bigint(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `userid` bigint(20) NOT NULL,
  `stars` int(11) NOT NULL,
  `comments` tinyint(4) NOT NULL,
  ` title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `postid`, `post`, `image`, `has_image`, `is_profile_image`, `is_cover_image`, `parent`, `date`, `userid`, `stars`, `comments`, ` title`) VALUES
(118, 7552076, 'Hi', 'uploads/7348023179899108/driDWAJaeYBXh0L.jpeg', 1, 0, 0, 0, '2024-05-22 01:56:24', 7348023179899108, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

CREATE TABLE `stars` (
  `id` bigint(20) NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contentid` bigint(20) NOT NULL,
  `stars` text NOT NULL,
  `following` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stars`
--

INSERT INTO `stars` (`id`, `type`, `contentid`, `stars`, `following`) VALUES
(185, 'user', 98143294600, '[{\"userid\":\"7348023179899108\",\"date\":\"2024-05-21 17:39:22\"}]', ''),
(186, 'user', 7348023179899108, '', '[{\"userid\":\"98143294600\",\"date\":\"2024-05-21 17:39:22\"},{\"userid\":\"481\",\"date\":\"2024-05-21 21:51:36\"}]'),
(187, 'user', 481, '[{\"userid\":\"7348023179899108\",\"date\":\"2024-05-21 21:51:36\"}]', ''),
(188, 'user', 7348023179899108, '[{\"userid\":\"762276656392054\",\"date\":\"2024-05-22 15:11:57\"}]', ''),
(189, 'user', 762276656392054, '', '[{\"userid\":\"7348023179899108\",\"date\":\"2024-05-22 15:11:57\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `first_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(6) NOT NULL,
  `profile_image` varchar(500) NOT NULL,
  `cover_image` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `online` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `stars` int(11) NOT NULL,
  `about` text NOT NULL,
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified` varchar(100) DEFAULT NULL,
  `ip_address` varchar(15) NOT NULL,
  `browser_name` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `school` varchar(20) NOT NULL,
  `college` varchar(20) NOT NULL,
  `university` varchar(20) NOT NULL,
  `url` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `first_name`, `last_name`, `gender`, `profile_image`, `cover_image`, `date`, `online`, `email`, `password`, `url_address`, `stars`, `about`, `title`, `email_verified`, `ip_address`, `browser_name`, `country`, `school`, `college`, `university`, `url`) VALUES
(1, 7348023179899108, 'Hridoy', 'Jomadder', 'Male', 'uploads/7348023179899108/UIcdz2iF9SvtVhG.jpg', 'uploads/7348023179899108/zlIi24AK0Xow30b.jpg', '0000-00-00 00:00:00', 1716476427, 'contacthridoyjomadder@gmail.com', '123456', 'hridoy.jomadder', 1, 'Rules & Regulations\r\n1. Obligations of the applicant\r\na.	) The Applicant guarantees that all information in, or related to, a CV that is either uploaded by him/her validated by him/her, is correct, complete and accurate.\r\nb.	) The Applicant agrees that he/she is solely responsible for the content of any information placed on the Website by him/her, and for any consequence that may arise out of such placement.\r\nc.	) The Applicant undertakes not to use the Website to (i) download, send, or disseminate data containing viruses, worms, spyware, malware or any other similar malicious programs; or (ii) carry out any calculations, operations or transactions that may interrupt, destroy or restrict the functionality of the operation of the Website.\r\nd.	) Services on the Website are only accessible in case of complete and correct registration on the Website. Access to the services offered on the Website requires the combination of a login and a password. The Applicant undertakes to comply strictly with the appropriate procedures regarding access to the Website. The information regarding login and password are strictly personal and the Applicant is responsible for the safeguarding, confidentiality, security and appropriate use by him and undertakes to take all steps to prevent any unauthorised third party from gaining knowledge and making use thereof. The Applicant will notify Startup Bangladesh immediately of the loss, theft, breach of confidentiality or any risk of misuse of the login process. The Applicant is fully responsible for any use of the Website, as well as for any detrimental consequences that may arise directly or indirectly therefrom, until the time that such notification is made.\r\n', 'CEO-Star', '', '127.0.0.1', 'Mozilla Firefox', 'Unknown', 'Barguna zilla school', 'Barguna govt college', 'Dhaka university', 'star.com'),
(3, 98143294600, 'Masud', 'Howlader', 'Male', 'uploads/98143294600/L0IzfiCHRdiS8h6.jpg', '', '0000-00-00 00:00:00', 1715611163, 'masud@gmail.com', '123', 'masud.howlader', 1, '', 'Howlader', NULL, '127.0.0.1', 'Mozilla Firefox', 'Unknown', '0', '0', '0', '0'),
(4, 5904812520371, 'Rabby', 'Jomadder', 'Male', 'uploads/5904812520371/5ElIB5JbL46FRvF.jpg', '', '0000-00-00 00:00:00', 1713761707, 'rabbyjomadder@gmail.com', '123', 'rabby.jomadder', 0, '', '', NULL, '127.0.0.1', 'Mozilla Firefox', 'Unknown', '0', '0', '0', '0'),
(5, 481, 'Reza', 'Islam', 'Male', 'uploads/481/vVe3FuUg3ryic55.jpg', '', '0000-00-00 00:00:00', 1713693246, 'reza@gmail.com', '123456', 'reza.islam', 1, '', '', NULL, '127.0.0.1', 'Mozilla Firefox', 'Unknown', '0', '0', '0', '0'),
(6, 762276656392054, 'راني', 'الخلف', 'Female', 'uploads/84621538018125/ekNKQfEgZmTdyVp.jpg', '', '0000-00-00 00:00:00', 1716383613, 'rani@gmail.com', '123', 'rani.akter', 1, '', 'راني', NULL, '127.0.0.1', 'Mozilla Firefox', 'Unknown', '0', '0', '0', '0'),
(89, 1127062466426, 'Hridoy', 'Jomadder', 'Male', '', '', '0000-00-00 00:00:00', 1713715999, 'contacthridoyjomadder1@gmail.com', '123', 'hridoy.jomadder', 0, '', '', NULL, '127.0.0.1', 'Mozilla Firefox', 'Unknown', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` bigint(20) NOT NULL,
  `code` bigint(20) NOT NULL,
  `expires` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tag` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `userid`, `video`, `title`, `description`, `tag`, `url`, `upload_date`) VALUES
(177, 7348023179899108, 'videos/HTML is the standard markup language for Web pages. With HTML you can create your own Website. HTML is easy to learn - You will enjoy it!.mp4', 'Html class 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin lacinia pharetra rhoncus. Fusce egestas tempus urna sed consectetur. Aenean ut faucibus nulla. Vivamus vitae fringilla dolor, in imperdiet nisl. Donec cursus condimentum lectus, sodales ultricies lorem aliquet et. Nulla lectus dolor, feugiat id tortor et, interdum posuere magna. Ut vulputate velit at justo aliquam luctus. Donec et urna ac ipsum semper scelerisque. In faucibus diam ac ornare aliquet. Fusce feugiat mi eget fringilla viverra. Cras faucibus nunc eget mi aliquam, id pulvinar erat accumsan. Cras dapibus justo et dolor vulputate placerat. Duis lobortis eros leo, a semper nulla vulputate vel. Duis dignissim vulputate lorem, quis mattis quam facilisis vitae. ', 'Html class 1', 'http://localhost/Star/profile.php?section=videos&id=6619774aa1a2b', '2024-04-12 18:02:50'),
(178, 7348023179899108, 'videos/Class 2.mp4', 'Title: Html class 2', 'Description:  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin lacinia pharetra rhoncus. Fusce egestas tempus urna sed consectetur. Aenean ut faucibus nulla. Vivamus vitae fringilla dolor, in imperdiet nisl. Donec cursus condimentum lectus, sodales ultricies lorem aliquet et. Nulla lectus dolor, feugiat id tortor et, interdum posuere magna. Ut vulputate velit at justo aliquam luctus. Donec et urna ac ipsum semper scelerisque. In faucibus diam ac ornare aliquet. Fusce feugiat mi eget fringilla viverra. Cras faucibus nunc eget mi aliquam, id pulvinar erat accumsan. Cras dapibus justo et dolor vulputate placerat. Duis lobortis eros leo, a semper nulla vulputate vel. Duis dignissim vulputate lorem, quis mattis quam facilisis vitae. ', 'Html class 2', 'http://localhost/Star/profile.php?section=videos&id=661a0adb59d11', '2024-04-13 04:32:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expire` (`expire`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `content_i_follow`
--
ALTER TABLE `content_i_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `contentid` (`contentid`),
  ADD KEY `disabled` (`disabled`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `meassges`
--
ALTER TABLE `meassges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `msgid` (`msgid`),
  ADD KEY `sender` (`sender`),
  ADD KEY `received` (`received`),
  ADD KEY `seen` (`seen`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `deleted_sender` (`deleted_sender`),
  ADD KEY `deleted_receiver` (`deleted_receiver`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `contentid` (`contentid`),
  ADD KEY `content_owner` (`content_owner`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `notification_seen`
--
ALTER TABLE `notification_seen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `notification_id` (`notification_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`),
  ADD KEY `date` (`date`),
  ADD KEY `userid` (`userid`),
  ADD KEY `comments` (`comments`),
  ADD KEY `stars` (`stars`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `contentid` (`contentid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `date` (`date`),
  ADD KEY `online` (`online`),
  ADD KEY `email` (`email`),
  ADD KEY `url_address` (`url_address`),
  ADD KEY `stars` (`stars`) USING BTREE,
  ADD KEY `title` (`title`) USING BTREE,
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `country` (`country`),
  ADD KEY `browser_name` (`browser_name`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expires` (`expires`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `content_i_follow`
--
ALTER TABLE `content_i_follow`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meassges`
--
ALTER TABLE `meassges`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `notification_seen`
--
ALTER TABLE `notification_seen`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `stars`
--
ALTER TABLE `stars`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
