-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2021 at 05:03 PM
-- Server version: 5.6.21
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workflow-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info`
--

CREATE TABLE IF NOT EXISTS `attendance_info` (
`aten_id` int(20) NOT NULL,
  `atn_user_id` int(20) NOT NULL,
  `in_time` varchar(200) DEFAULT NULL,
  `out_time` varchar(150) DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`aten_id`, `atn_user_id`, `in_time`, `out_time`, `total_duration`) VALUES
(38, 18, '22-03-2021 13:51:01', NULL, NULL),
(35, 17, '22-03-2021 11:37:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

CREATE TABLE IF NOT EXISTS `task_info` (
  `task_id` int(50) NOT NULL,
  `t_email` varchar(100) NULL,
  `t_title` varchar(120) NOT NULL,
  `t_description` text,
  `t_start_time` varchar(100) DEFAULT NULL,
  `t_time_stamp` datetime default current_timestamp,
  `t_end_time` varchar(100) DEFAULT NULL,
  `t_user_id` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = incomplete, 1 = In progress, 2 = complete'
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `t_email`, `t_title`, `t_description`, `t_start_time`, `t_end_time`, `t_user_id`, `status`) VALUES
(15, 'terror.tivani@gmail.com', 'reception', 'You''re assigned to handle incoming calls and other communication-based tasks within the office.', '2022-11-16 12:00', '2022-11-16 13:00', 17, 2),
(17, 'hannonmulaudzi@gmail.com', 'Verifying & Auditing', 'You''re assigned to Verify & Audit the system within the office.', '2022-11-18 10:00', '2022-11-20 15:10', 19, 1),
(16, 'ramolefo.moriti@gmail.com', 'Filing', 'You''re assigned to the management of filing system within the office.', '2022-11-17 10:00', '2022-11-17 15:10', 18, 0);


-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
`user_id` int(20) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `user_role` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `temp_password`, `user_role`) VALUES
(1, 'Terror Mayimele', 'admin', 'terror.tivani@gmail.com', '0192023a7bbd73250516f069df18b500', NULL, 1), 
(2, 'Moriti Ramolefo', 'admin1', 'ramolefo.moriti@gmail.com', '0192023a7bbd73250516f069df18b500', NULL, 1), 
(3, 'Hannon Mulaudzi', 'admin2', 'hannonmulaudzi@gmail.com', '0192023a7bbd73250516f069df18b500', NULL, 1), 
(17, 'Terror Tivani', 'user', 'terror.tivani@gmail.com', '3e7898bd2fc53a4ced081380893bcab3', '', 2),
(18, 'Moriti Ramolefo', 'user1', 'ramolefo.moriti@gmail.com', 'eb8ed5db82587f7a9bdbab2c55cbea4a', '', 2),
(19, 'Hannon Mulaudzi', 'user2', 'hannonmulaudzi@gmail.com', '0a8da84de683d6defdf4b87fcedbb993', '', 2);

--

CREATE TABLE tbl_notity AS (
SELECT `task_info`.`t_start_time`,`task_info`.`t_time_stamp`,`task_info`.`t_end_time`, 
      `tbl_admin`.`fullname`,`tbl_admin`.`email`
FROM `task_info`
INNER JOIN `tbl_admin` ON (`task_info`.`t_user_id` = `tbl_admin`.`user_id`)
ORDER BY `task_info`.`task_id`DESC
);


-- Indexes for dumped tables
--

--
-- Table structure for table `drive_files`
--
CREATE TABLE `drive_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_drive_file_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for table `attendance_info`
--
ALTER TABLE `attendance_info`
 ADD PRIMARY KEY (`aten_id`);

--
-- Indexes for table `task_info`
--
ALTER TABLE `task_info`
 ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `drive_files`
--
ALTER TABLE `drive_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_info`
--
ALTER TABLE `attendance_info`
MODIFY `aten_id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `task_info`
--
ALTER TABLE `task_info`
MODIFY `task_id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `drive_files`
--
ALTER TABLE `drive_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- INSERT INTO tbl_notity( t_start_time, t_time_stamp, t_end_time, fullname, email)
-- SELECT task_info.t_start_time,task_info.t_time_stamp,task_info.t_end_time, 
--       tbl_admin.fullname,tbl_admin.email
-- FROM task_info
-- INNER JOIN tbl_admin ON (task_info.t_user_id = tbl_admin.user_id)
-- ORDER BY task_info.task_id;
