-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 07:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL,
  `type` varchar(225) NOT NULL,
  `account_firstName` varchar(225) NOT NULL,
  `account_lastName` varchar(225) NOT NULL,
  `account_email` varchar(225) NOT NULL,
  `account_nickname` varchar(225) DEFAULT NULL,
  `account_department` varchar(225) DEFAULT 'unset',
  `account_img` varchar(225) NOT NULL DEFAULT 'default.png',
  `account_hireDate` date DEFAULT NULL,
  `account_state` varchar(225) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `type`, `account_firstName`, `account_lastName`, `account_email`, `account_nickname`, `account_department`, `account_img`, `account_hireDate`, `account_state`, `last_activity`, `token`) VALUES
(139, '', 'test', 'lang', 'test@findme.com.ph', 'test', 'unset', 'https://lh3.googleusercontent.com/a/ACg8ocJzHGklmfZ-Fw3zCUCoj6uEM2V3j-jH8asKRikrYIxx=s96-c', NULL, 'pending', '2024-01-10 05:39:29', '109646329294506866830');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `id` int(11) NOT NULL,
  `email` varchar(225) NOT NULL,
  `type` enum('head-administrator','super-admin','co-admin') NOT NULL,
  `dept` varchar(225) NOT NULL,
  `admin_fname` varchar(225) NOT NULL,
  `admin_lname` varchar(225) NOT NULL,
  `account_nickname` varchar(225) NOT NULL,
  `hiredate` varchar(225) NOT NULL,
  `account_img` varchar(225) NOT NULL,
  `token` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`id`, `email`, `type`, `dept`, `admin_fname`, `admin_lname`, `account_nickname`, `hiredate`, `account_img`, `token`) VALUES
(12, 'erocampo@findme.com.ph', 'head-administrator', '', '', '', '', '', '', ''),
(25, 'gumalabanan@findme.com.ph', 'head-administrator', '', '', '', '', '', '', ''),
(29, 'marlon.delima@neu.edu.ph', 'head-administrator', '', 'Delima,', 'Marlon Jr. G.', 'MarlonDelima', '', 'https://lh3.googleusercontent.com/a/ACg8ocJLAV1yIkdBrvsBNsn1kmwhTabkZVR94UWfERbN0LW02og=s96-c', '116005388241243771211');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` varchar(225) NOT NULL,
  `announcement_img` varchar(225) NOT NULL,
  `announcement_date` date NOT NULL,
  `announcement_time` time NOT NULL,
  `announcement_department` varchar(225) NOT NULL,
  `announcement_summary` varchar(225) NOT NULL,
  `announcement_description` text NOT NULL,
  `post_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`announcement_id`, `announcement_title`, `announcement_img`, `announcement_date`, `announcement_time`, `announcement_department`, `announcement_summary`, `announcement_description`, `post_date`) VALUES
(12, 'Announcement1', '1701218549qwert.jpg', '2023-11-23', '12:00:00', 'it_ops', 'summary', 'Description', '2023-11-29'),
(13, 'Announcement2', '1701218606qwer.jpg', '2023-11-08', '08:00:00', 'it_ops', 'summary', 'description', '2023-11-29'),
(14, 'Announcement3', '1701218760qwe.jpg', '2023-11-29', '11:22:00', 'it_ops', 'summary', 'testing announcement', '2023-11-29'),
(15, 'ANNOUNCEMENT FOR ALL', '17012939773da30dba91d3ebd91b1c5b1b50f6779c.jpg', '2023-11-23', '12:00:00', 'all', 'summary', 'this is for description', '2023-11-30'),
(35, 'TEST', '1701416481AdobeStock_175062069-2048x1365.jpeg', '2023-12-15', '12:33:00', 'it_ops', 'Announcement summary', 'description', '2023-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emailtemplates`
--

CREATE TABLE `tbl_emailtemplates` (
  `id` int(11) NOT NULL,
  `type` varchar(225) NOT NULL,
  `subject` varchar(225) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_emailtemplates`
--

INSERT INTO `tbl_emailtemplates` (`id`, `type`, `subject`, `body`) VALUES
(1, 'create_account', 'Account Creation Request', 'Dear employee,\r\n        \r\nThank you for creating an account with our platform. We have received your account creation request, and it is currently being reviewed by our team.\r\n        \r\nPlease note that your account is pending approval, and you will be notified via email once your account is approved and ready to use.\r\n\r\nWe appreciate your patience and understanding during this process. If you have any questions or need further assistance, please feel free to contact our support team.\r\n\r\nBest Regards,\r\nManagement'),
(2, 'approve_account', 'Account Approval', 'Dear employee,\r\n\r\nWe are pleased to inform you that your account on our platform has been approved and is now ready for use.\r\n\r\nYou can now log in to your account and enjoy the services and features available to you.\r\n\r\nIf you have any questions or need further assistance, please do not hesitate to contact our support team.\r\n'),
(3, 'deletion_account', 'Account Deletion', 'Dear employee,\r\n\r\nWe regret to inform you that your account on our platform has been deleted and is no longer active.\r\n\r\nIf you believe this is in error or have any questions, please do not hesitate to contact our support team for further assistance.\r\n\r\nWe appreciate your understanding during this process.\r\n\r\nBest regards,\r\nManagement');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_notification_send`
--

CREATE TABLE `tbl_email_notification_send` (
  `id` int(11) NOT NULL,
  `target_department` varchar(225) NOT NULL,
  `type` varchar(225) NOT NULL,
  `message` text NOT NULL,
  `number` int(11) NOT NULL,
  `isSent` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_email_notification_send`
--

INSERT INTO `tbl_email_notification_send` (`id`, `target_department`, `type`, `message`, `number`, `isSent`) VALUES
(2, 'it_ops', 'form', 'new form has been uploaded', 3, b'0'),
(3, 'it_ops', 'announcement', 'new announcement has been uploaded', 1, b'0'),
(4, 'it_ops', 'event', 'new event has been uploaded', 1, b'0'),
(5, 'marketing', 'form', 'new form has been uploaded', 1, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_settings`
--

CREATE TABLE `tbl_email_settings` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `app_password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_email_settings`
--

INSERT INTO `tbl_email_settings` (`id`, `username`, `app_password`) VALUES
(1, 'webcast000@gmail.com', 'kbwrwtpvsdgucovr');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(225) NOT NULL,
  `event_img` varchar(225) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_department` varchar(225) NOT NULL,
  `event_summary` varchar(225) NOT NULL,
  `event_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`event_id`, `event_title`, `event_img`, `event_date`, `event_time`, `event_department`, `event_summary`, `event_description`) VALUES
(14, 'newEvent', '17022719303da30dba91d3ebd91b1c5b1b50f6779c.jpg', '2023-12-21', '12:00:00', 'marketing', 'summary', 'description');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forms`
--

CREATE TABLE `tbl_forms` (
  `form_id` int(11) NOT NULL,
  `form_title` varchar(225) NOT NULL,
  `form_link` varchar(225) NOT NULL,
  `form_department` varchar(225) NOT NULL,
  `form_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_forms`
--

INSERT INTO `tbl_forms` (`form_id`, `form_title`, `form_link`, `form_department`, `form_added`) VALUES
(21, 'NewForm', 'https://www.google.com/', 'hr', '2023-10-18'),
(27, 'TryNotification', 'notification.com', 'it_ops', '2023-12-11'),
(28, 'tryAgain', 'google.com', 'it_ops', '2023-12-11'),
(29, 'form_number 2', 'link.com', 'it_ops', '2023-12-11'),
(30, 'for marketing', 'marlon.com', 'marketing', '2023-12-11'),
(31, 'ForITOPS', 'https://www.google.com/', 'it_ops', '2024-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general`
--

CREATE TABLE `tbl_general` (
  `id` int(11) NOT NULL,
  `img` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_general`
--

INSERT INTO `tbl_general` (`id`, `img`, `status`) VALUES
(26, '1700528253try2.png', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `notif_type` varchar(225) NOT NULL,
  `notif_target` varchar(225) NOT NULL,
  `title` varchar(225) NOT NULL,
  `message` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `content_id`, `notif_type`, `notif_target`, `title`, `message`) VALUES
(14, 21, 'form', 'Dept5', 'New Form Added', 'NewForm'),
(16, 7, 'announcement', 'Dept3', 'New Announcement Added', 'a little text for yall'),
(18, 8, 'announcement', 'it_ops', 'New Announcement Added', ''),
(19, 9, 'announcement', 'it_ops', 'New Announcement Added', ''),
(20, 10, 'announcement', 'it_ops', 'New Announcement Added', '213'),
(21, 11, 'announcement', 'it_ops', 'New Announcement Added', 'sdfsdfd'),
(24, 14, 'announcement', 'it_ops', 'New Announcement Added', 'summary'),
(25, 15, 'announcement', 'all', 'New Announcement Added', 'summary'),
(26, 17, 'announcement', 'it_ops', 'New Announcement Added', 'malkr'),
(27, 18, 'announcement', 'it_ops', 'New Announcement Added', 'hello'),
(28, 19, 'announcement', 'it_ops', 'New Announcement Added', 'hello'),
(29, 20, 'announcement', 'it_ops', 'New Announcement Added', 'sadasd'),
(30, 21, 'announcement', 'it_ops', 'New Announcement Added', 'sad'),
(36, 27, 'announcement', 'it_ops', 'New Announcement Added', 'Join us this afternoon'),
(37, 28, 'announcement', 'it_ops', 'New Announcement Added', 'Join us in the afternoon'),
(38, 29, 'announcement', 'it_ops', 'New Announcement Added', 'join us in the afternoon'),
(39, 30, 'announcement', 'it_ops', 'New Announcement Added', 'join us in the afternoon'),
(40, 31, 'announcement', 'it_ops', 'New Announcement Added', 'join us in the afternoon'),
(41, 32, 'announcement', 'it_ops', 'New Announcement Added', 'join us'),
(42, 33, 'announcement', 'cs', 'New Announcement Added', 'marlon'),
(43, 34, 'announcement', 'it_ops', 'New Announcement Added', 'nays'),
(44, 35, 'announcement', 'it_ops', 'New Announcement Added', 'Announcement summary'),
(49, 27, 'form', 'it_ops', 'New Form Added', 'TryNotification'),
(50, 28, 'form', 'it_ops', 'New Form Added', 'tryAgain'),
(51, 29, 'form', 'it_ops', 'New Form Added', 'form_number 2'),
(53, 14, 'event', 'it_ops', 'New Event Added', ''),
(54, 30, 'form', 'marketing', 'New Form Added', 'for marketing'),
(55, 31, 'form', 'it_ops', 'New Form Added', 'ForITOPS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_check`
--

CREATE TABLE `tbl_notification_check` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `isRead` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_videogallery`
--

CREATE TABLE `tbl_videogallery` (
  `id` int(11) NOT NULL,
  `link` varchar(225) NOT NULL,
  `category` varchar(225) NOT NULL,
  `isShown` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_videogallery`
--

INSERT INTO `tbl_videogallery` (`id`, `link`, `category`, `isShown`) VALUES
(25, '1E6pYtaf21jQFXneOOwKc9WFGNS__vvCu', 'corporates', ''),
(29, '1E6pYtaf21jQFXneOOwKc9WFGNS__vvCu', 'corporates', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `tbl_emailtemplates`
--
ALTER TABLE `tbl_emailtemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_notification_send`
--
ALTER TABLE `tbl_email_notification_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_settings`
--
ALTER TABLE `tbl_email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_forms`
--
ALTER TABLE `tbl_forms`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `tbl_general`
--
ALTER TABLE `tbl_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification_check`
--
ALTER TABLE `tbl_notification_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_videogallery`
--
ALTER TABLE `tbl_videogallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_emailtemplates`
--
ALTER TABLE `tbl_emailtemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_email_notification_send`
--
ALTER TABLE `tbl_email_notification_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_email_settings`
--
ALTER TABLE `tbl_email_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_forms`
--
ALTER TABLE `tbl_forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_general`
--
ALTER TABLE `tbl_general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_notification_check`
--
ALTER TABLE `tbl_notification_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_videogallery`
--
ALTER TABLE `tbl_videogallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
