-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 08:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `subject_id` smallint(6) DEFAULT NULL,
  `teacher_id` smallint(6) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Paid','Unpaid','Partial') DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` tinyint(4) NOT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `grade` varchar(1) DEFAULT NULL,
  `standard_id` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` smallint(6) NOT NULL,
  `teacher_id` smallint(6) DEFAULT NULL,
  `status` enum('A','C','P','R') DEFAULT NULL,
  `approved_by` smallint(6) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `subject_id` smallint(6) DEFAULT NULL,
  `exam_name` varchar(100) DEFAULT NULL,
  `marks` decimal(5,2) DEFAULT NULL,
  `grade` varchar(1) DEFAULT NULL,
  `teacher_id` smallint(6) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` smallint(6) NOT NULL,
  `staff_id` smallint(6) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `salary_status` enum('S','P','C','Pr') DEFAULT NULL,
  `attendance` decimal(5,2) DEFAULT NULL,
  `leaves` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `profile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `storage_filename` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `role_id` smallint(2) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `department`, `role`, `profile`, `email`, `password`, `phone`, `storage_filename`, `status`, `created_at`, `updated_at`, `user_id`, `dob`, `gender`, `role_id`) VALUES
(1, 'admin', 'administrator', 'admin', 'DABI .png', 'admin@example.com', '$2y$10$srulZF4AqjKDQplEyFcmre6/ym6NQGHNCD3H0fwogLlpfVuaZW/vm', '1233214', '2842883cabdaaa5935c74081b07fceed.png', '1', '2024-07-19 16:36:21', '2024-07-19 16:36:21', 1, '1980-01-01', 'M', 3),
(12, 'Jane Smith', 'Science', 'Teacher', '', 'jane.smith@example.com', 'password2', '1234213123', '3f21e7f03d955cc68f85a1b23e91e4e1.jpg', '1', '2024-07-19 16:33:36', '2024-07-19 16:33:36', 2, '1985-05-05', 'O', 2),
(13, 'Metch Johnson', 'English', 'Teacher', '', 'alice.johnson@example.com', 'password3', '1234213411', '', '1', '2024-07-19 16:33:36', '2024-07-19 16:33:36', 3, '1990-10-10', 'M', 2),
(14, 'Robert Brown', 'History', 'Teacher', '', 'robert.brown@example.com', 'password4', '123421342', '', '0', '2024-07-19 16:33:36', '2024-07-19 16:33:36', 4, '1975-07-07', 'M', 2),
(15, 'Emily Davis', 'Geography', 'Teacher', '', 'emily.davis@example.com', 'password5', '12342132', '', '1', '2024-07-19 16:33:36', '2024-07-19 16:33:36', 5, '1988-08-08', 'F', 2),
(16, 'Michael Wilson', 'Mathematics', 'Teacher', '', 'michael.wilson@example.com', 'password6', '1351221', '', '1', '2024-07-19 16:33:36', '2024-07-19 16:33:36', 6, '1982-02-02', 'M', 2);

--
-- Triggers `staff`
--
DELIMITER $$
CREATE TRIGGER `after_staff_delete` AFTER DELETE ON `staff` FOR EACH ROW BEGIN
    DELETE FROM users
    WHERE rel_id = OLD.id AND rel_type = 'teacher';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_staff_insert` AFTER INSERT ON `staff` FOR EACH ROW BEGIN
    INSERT INTO users (rel_type, rel_id, email, password, token)
    VALUES ('teacher', NEW.id, NEW.email, NEW.password, NULL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_staff_update` AFTER UPDATE ON `staff` FOR EACH ROW BEGIN
    UPDATE users
    SET email = NEW.email,
        password = NEW.password
    WHERE rel_id = NEW.id ;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `standards`
--

CREATE TABLE `standards` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standards`
--

INSERT INTO `standards` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, '2', '2024-07-23 18:05:13', '2024-07-23 18:05:13'),
(3, '3', '2024-07-23 18:05:13', '2024-07-23 18:05:13'),
(4, '4', '2024-07-23 18:05:13', '2024-07-23 18:05:13'),
(5, '5', '2024-07-23 18:05:13', '2024-07-23 18:05:13'),
(20, '1', '2024-08-07 19:53:17', '2024-08-07 19:53:17');

-- --------------------------------------------------------

--
-- Table structure for table `std_sub`
--

CREATE TABLE `std_sub` (
  `id` int(11) NOT NULL,
  `standard_id` tinyint(4) NOT NULL,
  `subject_id` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='relation between standard and subject';

--
-- Dumping data for table `std_sub`
--

INSERT INTO `std_sub` (`id`, `standard_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(197, 2, 1, '2024-08-03 11:30:40', '2024-08-03 11:30:40'),
(199, 4, 6, '2024-08-05 14:50:06', '2024-08-05 14:50:06'),
(200, 5, 104, '2024-08-05 14:50:06', '2024-08-05 14:50:06'),
(203, 20, 1, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(204, 20, 2, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(206, 20, 4, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(208, 20, 6, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(209, 20, 100, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(210, 20, 101, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(211, 20, 102, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(212, 20, 103, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(213, 20, 104, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(214, 20, 105, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(215, 20, 106, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(216, 20, 107, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(217, 20, 108, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(218, 20, 109, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(219, 20, 110, '2024-08-07 19:53:18', '2024-08-07 19:53:18'),
(236, 20, 5, '2024-08-10 12:05:38', '2024-08-10 12:05:38'),
(237, 2, 5, '2024-08-10 12:14:21', '2024-08-10 12:14:21'),
(238, 2, 2, '2024-08-12 10:53:33', '2024-08-12 10:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `password` varchar(50) NOT NULL DEFAULT '0',
  `enrollment` varchar(50) NOT NULL DEFAULT '0',
  `standard_id` tinyint(4) NOT NULL,
  `roll_no` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `dob`, `gender`, `address`, `phone`, `email`, `password`, `enrollment`, `standard_id`, `roll_no`, `created_at`, `updated_at`) VALUES
(2, 'testt', 'testt', '2015-08-21', 'O', 'asdfasdf', '7202800803', 'akatsukioffical21@gmail.com', '$2y$10$yMOrkIS.9fLeKgMhlhKnmOlktuG86Np31LWkFyNU9eR', '', 3, 0, '2024-07-18 11:08:04', '2024-07-29 11:01:33'),
(3, 'testt', 'testt', '2015-08-21', 'O', 'asdfasdf', '7202800803', 'test2@gmail.com', '$2y$10$yBGjoNodNnyuI.dpeAvufexWJZUjcr8dJL7BiCrnzOE', '', 3, 0, '2024-07-18 11:08:54', '2024-07-29 11:01:38'),
(12, 'John', 'Doe', '2010-05-14', 'M', '123 Elm St', '1234567890', 'john.doe@example.com', 'password1', '', 5, 0, '2024-07-23 17:53:01', '2024-07-29 11:01:47');

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `student` FOR EACH ROW BEGIN
    INSERT INTO `users` SET `rel_type`='studnet', `email`=NEW.email, `rel_id`=NEW.id, `password`=NEW.password;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Math', 'SUB001', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(2, 'English', 'SUB002', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(3, 'Php', 'SUB003', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(4, 'Biology', 'SUB004', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(5, 'Chemistry', 'SUB005', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(6, 'Physics', 'SUB006', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(100, 'Javascript', 'SUB121', '2024-07-29 18:38:27', '2024-07-29 18:38:27'),
(101, 'HTML', 'SUB122', '2024-07-29 18:45:31', '2024-07-29 18:45:31'),
(102, 'React', 'SUB124', '2024-07-29 18:49:54', '2024-07-29 18:49:54'),
(103, 'Node', 'SUB125', '2024-07-29 18:51:01', '2024-07-29 18:51:01'),
(104, 'Rust', 'SUB126', '2024-07-29 18:57:00', '2024-07-29 18:57:00'),
(105, 'StructuredQL', 'SUB127', '2024-07-29 19:18:26', '2024-07-29 19:18:26'),
(106, 'PostgresQL', 'SUB128', '2024-07-29 19:19:15', '2024-07-29 19:19:15'),
(107, 'MongoDB', 'SUB129', '2024-07-29 19:19:47', '2024-07-29 19:19:47'),
(108, 'Gujarati', 'SUB130', '2024-07-29 19:20:42', '2024-07-29 19:20:42'),
(109, 'Social Studies', 'SUB131', '2024-07-29 19:21:24', '2024-07-29 19:21:24'),
(110, 'Science', 'SUB141', '2024-07-29 19:47:41', '2024-07-29 19:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` smallint(6) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `last_name`, `dob`, `gender`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', '1980-01-15', 'M', '123 Elm Street', '5551234567', 'john.doe@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(2, 'Jane', 'Smith', '1985-03-22', 'F', '456 Oak Street', '5552345678', 'jane.smith@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(3, 'Alice', 'Johnson', '1990-07-30', 'F', '789 Pine Street', '5553456789', 'alice.johnson@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(4, 'Robert', 'Brown', '1975-11-10', 'M', '101 Maple Avenue', '5554567890', 'robert.brown@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(5, 'Emily', 'Davis', '1988-06-25', 'F', '202 Birch Lane', '5555678901', 'emily.davis@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(6, 'Michael', 'Wilson', '1982-12-14', 'M', '303 Cedar Road', '5556789012', 'michael.wilson@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(7, 'Sarah', 'Lee', '1992-09-05', 'F', '404 Spruce Circle', '5557890123', 'sarah.lee@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51'),
(8, 'David', 'Kim', '1984-04-18', 'M', '505 Walnut Way', '5558901234', 'david.kim@example.com', '2024-07-23 17:50:51', '2024-07-23 17:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `teachers_std`
--

CREATE TABLE `teachers_std` (
  `id` int(11) NOT NULL,
  `teacher_id` smallint(6) NOT NULL,
  `standard_id` tinyint(4) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive\r\n',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_std`
--

INSERT INTO `teachers_std` (`id`, `teacher_id`, `standard_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 5, '1', '2024-07-29 11:56:17', '2024-07-29 11:56:17'),
(2, 14, 4, '0', '2024-07-29 11:56:17', '2024-07-29 11:56:17'),
(4, 14, 2, '1', '2024-07-29 11:56:17', '2024-07-29 11:56:17'),
(5, 14, 5, '1', '2024-07-29 11:56:17', '2024-07-29 11:56:17'),
(38, 12, 20, '0', '2024-08-07 19:53:17', '2024-08-07 19:53:17'),
(39, 13, 20, '1', '2024-08-07 19:53:17', '2024-08-07 19:53:17'),
(40, 14, 20, '1', '2024-08-07 19:53:17', '2024-08-07 19:53:17'),
(41, 15, 20, '1', '2024-08-07 19:53:17', '2024-08-07 19:53:17'),
(42, 16, 20, '1', '2024-08-07 19:53:17', '2024-08-07 19:53:17'),
(48, 12, 2, '0', '2024-08-09 17:12:41', '2024-08-09 17:12:41'),
(49, 12, 3, '0', '2024-08-09 17:26:11', '2024-08-09 17:26:11'),
(50, 12, 20, '0', '2024-08-09 19:51:30', '2024-08-09 19:51:30'),
(51, 13, 2, '1', '2024-08-12 10:53:32', '2024-08-12 10:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` int(10) NOT NULL,
  `teacher_id` smallint(6) NOT NULL,
  `subject_id` smallint(6) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='teacher with subject ';

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`id`, `teacher_id`, `subject_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 5, '1', '2024-07-29 11:03:08', '2024-07-29 11:03:08'),
(2, 13, 3, '1', '2024-07-29 11:03:31', '2024-07-29 11:03:31'),
(3, 14, 3, '1', '2024-07-29 11:03:31', '2024-07-29 11:03:31'),
(5, 12, 2, '0', '2024-07-29 19:45:24', '2024-07-29 19:45:24'),
(108, 12, 110, '0', '2024-08-08 12:22:23', '2024-08-08 12:22:23'),
(109, 12, 3, '0', '2024-08-08 12:28:32', '2024-08-08 12:28:32'),
(111, 12, 4, '1', '2024-08-09 19:00:59', '2024-08-09 19:00:59'),
(117, 12, 2, '1', '2024-08-09 19:48:33', '2024-08-09 19:48:33'),
(118, 12, 101, '1', '2024-08-09 19:48:40', '2024-08-09 19:48:40'),
(119, 12, 1, '1', '2024-08-10 10:37:32', '2024-08-10 10:37:32'),
(120, 14, 5, '1', '2024-08-10 12:27:15', '2024-08-10 12:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `rel_type` enum('student','teacher','admin') NOT NULL,
  `rel_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` text DEFAULT NULL,
  `role` smallint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `rel_type`, `rel_id`, `email`, `password`, `token`, `role`) VALUES
(1, 'admin', 1, 'admin@example.com', '$2y$10$srulZF4AqjKDQplEyFcmre6/ym6NQGHNCD3H0fwogLlpfVuaZW/vm', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MjMyOTUxNzYsIm5iZiI6MTcyMzI5NTE3NiwiZXhwIjoxNzIzMjk4Nzc2LCJkYXRhIjp7InVzZXJfaWQiOjEsInVzZXJfcmVsX2lkIjoxLCJ1c2VyX3JlbF90eXBlIjoiYWRtaW4iLCJlbWFpbCI6ImFkbWluQGV4YW1wbGUuY29tIiwiZXhwaXJlIjoxNzIzMjk4Nzc2fX0.lzahhgsR2gw-RE71lUsgvaybrVkORFt904HwbIVRYQM', 1),
(2, 'teacher', 2001, 'teacher1@example.com', 'teacher1_password', 'asdfsad', NULL),
(3, 'teacher', 2002, 'teacher2@example.com', 'teacher2_password', 'asdfsadfasdf', NULL),
(4, 'student', 3001, 'student1@example.com', 'student1_password', 'asdfasdf', NULL),
(5, 'student', 3002, 'student2@example.com', 'student2_password', 'sdaasdf', NULL),
(6, '', 1, 'admin@example.com', '$2y$10$srulZF4AqjKDQplEyFcmre6/ym6NQGHNCD3H0fwogLlpfVuaZW/vm', 'asdfasdfasdfasdf', NULL),
(7, '', 2, 'akatsukioffical21@gmail.com', '$2y$10$yMOrkIS.9fLeKgMhlhKnmOlktuG86Np31LWkFyNU9eR', 'adfsd;flkajsdf;lkasjdf', NULL),
(8, '', 3, 'test2@gmail.com', '$2y$10$yBGjoNodNnyuI.dpeAvufexWJZUjcr8dJL7BiCrnzOE', 'asldkfaslkdjfhsakldfhasdf', NULL),
(15, '', 11, 'test22@gmail.com', '$2y$10$5WOZHoO5o9KfGVnne7EuHekgWXfO5EAnELyl9pJe89y', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MjEyODY5MzksIm5iZiI6MTcyMTI4NjkzOSwiZXhwIjoxNzIxMjkwNTM5LCJkYXRhIjp7InVzZXJfaWQiOjgsInVzZXJfcmVsX2lkIjozLCJ1c2VyX3JlbF90eXBlIjoiIiwiZW1haWwiOiJ0ZXN0MkBnbWFpbC5jb20iLCJleHBpcmUiOjE3MjEyOTA1Mzl9fQ.3LcrkUgKh7g', NULL),
(25, 'teacher', 12, 'jane.smith@example.com', 'password2', NULL, NULL),
(26, 'teacher', 13, 'alice.johnson@example.com', 'password3', NULL, NULL),
(27, 'teacher', 14, 'robert.brown@example.com', 'password4', NULL, NULL),
(28, 'teacher', 15, 'emily.davis@example.com', 'password5', NULL, NULL),
(29, 'teacher', 16, 'michael.wilson@example.com', 'password6', NULL, NULL),
(34, '', 12, 'jane.smith@example.com', 'password2', NULL, NULL),
(35, '', 13, 'alice.johnson@example.com', 'password3', NULL, NULL),
(36, '', 14, 'robert.brown@example.com', 'password4', NULL, NULL),
(37, '', 15, 'emily.davis@example.com', 'password5', NULL, NULL),
(38, '', 16, 'michael.wilson@example.com', 'password6', NULL, NULL),
(39, '', 17, 'sarah.lee@example.com', 'password7', NULL, NULL),
(40, '', 18, 'david.kim@example.com', 'password8', NULL, NULL),
(41, '', 19, 'frank.miller@example.com', 'password8', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` smallint(2) NOT NULL DEFAULT 3,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`) VALUES
(1, 'admin'),
(3, 'student'),
(2, 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `class_id` (`standard_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_us_id` (`user_id`);

--
-- Indexes for table `standards`
--
ALTER TABLE `standards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `std_sub`
--
ALTER TABLE `std_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_std_id_2` (`standard_id`),
  ADD KEY `fk_sub_id_2` (`subject_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_std_id` (`standard_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teachers_std`
--
ALTER TABLE `teachers_std`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teacher_id_2` (`teacher_id`),
  ADD KEY `fk_std_id_3` (`standard_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teacher_id` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `token` (`token`) USING HASH,
  ADD KEY `fk_role_id` (`role`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `standards`
--
ALTER TABLE `standards`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `std_sub`
--
ALTER TABLE `std_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers_std`
--
ALTER TABLE `teachers_std`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `results_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_us_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `std_sub`
--
ALTER TABLE `std_sub`
  ADD CONSTRAINT `fk_std_id_2` FOREIGN KEY (`standard_id`) REFERENCES `standards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sub_id_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_std_id` FOREIGN KEY (`standard_id`) REFERENCES `standards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers_std`
--
ALTER TABLE `teachers_std`
  ADD CONSTRAINT `fk_std_id_3` FOREIGN KEY (`standard_id`) REFERENCES `standards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teacher_id_2` FOREIGN KEY (`teacher_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `fk_sub_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
