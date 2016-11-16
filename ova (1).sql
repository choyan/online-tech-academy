-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2016 at 03:10 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ova`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`) VALUES
(6, '3D & Motion Graphics'),
(4, 'Code'),
(8, 'Computer Skills'),
(3, 'Design & Illustration'),
(7, 'Game Development'),
(5, 'Web Design');

-- --------------------------------------------------------

--
-- Table structure for table `course_info`
--

CREATE TABLE `course_info` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `course_category_id` int(20) NOT NULL,
  `course_title` varchar(60) NOT NULL,
  `course_summary` varchar(500) NOT NULL,
  `course_requirement` varchar(300) NOT NULL,
  `course_price` int(20) NOT NULL,
  `course_description` varchar(500) NOT NULL,
  `banner_img` varchar(200) NOT NULL,
  `published` varchar(30) NOT NULL,
  `sell_count` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_info`
--

INSERT INTO `course_info` (`id`, `user_id`, `course_category_id`, `course_title`, `course_summary`, `course_requirement`, `course_price`, `course_description`, `banner_img`, `published`, `sell_count`) VALUES
(1, 2, 3, 'React 101', 'Summary', 'Req', 2000, 'Desc', '1476884465.jpg', '2016-10-19 19:41:04', 0),
(2, 3, 3, 'Go Live With WebRTC', 'WebRTC is a new standard that provides web and mobile apps with real-time communications. WebRTC makes it easy to deliver streaming video and audio communications to the browser and mobile platforms.', 'HTML\r\nCSS\r\nJS', 3000, 'In this course, Envato Tuts+ instructor Reggie Dawson will teach you how to use WebRTC to enable audio, video and data communications in the browser. Along the way, youll use the WebRTC API to build a', '1477920457.jpg', '2016-10-31 19:27:36', 0),
(3, 3, 1, 'fsdfsdj', 'fglkfgklkl', 'dfgfkdsgkl', 45454, 'sfgfsdhgfj', '1478268447.jpg', '2016-11-04 15:07:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_subcategories`
--

CREATE TABLE `course_subcategories` (
  `id` int(10) NOT NULL,
  `course_category_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_subcategories`
--

INSERT INTO `course_subcategories` (`id`, `course_category_id`, `name`) VALUES
(1, 4, 'Web Developmnet'),
(2, 4, 'Mobile Development'),
(3, 4, 'Javascript'),
(4, 4, 'Wordpress');

-- --------------------------------------------------------

--
-- Table structure for table `course_transaction`
--

CREATE TABLE `course_transaction` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_transaction`
--

INSERT INTO `course_transaction` (`id`, `user_id`, `course_id`, `amount`) VALUES
(1, 2, 1, 2000),
(2, 2, 1, 2000),
(3, 3, 1, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `institute` varchar(100) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `office` varchar(50) NOT NULL,
  `paypal` varchar(100) NOT NULL,
  `bkash` int(50) NOT NULL,
  `status` int(10) NOT NULL,
  `credit_amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `user_id`, `institute`, `designation`, `office`, `paypal`, `bkash`, `status`, `credit_amount`) VALUES
(1, 2, 'Kodeeo', 'Frontend Developer', 'Uttara', 'choyan.009@gmail.com', 1722922274, 1, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(10) NOT NULL,
  `course_section_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` varchar(20) DEFAULT '1',
  `video_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `course_section_id`, `title`, `description`, `status`, `video_url`) VALUES
(1, 1, 'Welcome', 'Welcome to Getting Started With React! This course will cover everything you need to know to get up to speed with React. We''ll look at how React differs from other frameworks, before diving into some of the key concepts, applications, and best practices.', '1', 'https://code.tutsplus.com/courses/getting-started-with-reactjs/lessons/welcome'),
(2, 8, '3.1 One-Way Directional Flow of Data', 'This lesson will cover the best practice for dealing with state and props in React. We''ll also go over dealing with callbacks for changing our top-level state.', '1', 'https://code.tutsplus.com/courses/getting-started-with-reactjs/lessons/one-way-directional-flow-of-data'),
(3, 1, 'Welcome 2', 'bloody move', '1', '1477142432.mp4'),
(4, 9, 'Intro bla bla', 'In this lesson I will explain WebRTC and its basic components.', '1', '1477920952.mp4'),
(5, 9, 'sdfsdsdf', 'JFDJKHGKJSHGJSDHGJ', '1', '1477921576.mp4'),
(6, 9, 'adasdsa', 'sdfsdfsdfsdf', '1', '1478083026.mp4'),
(7, 10, 'adasdg;klh sj', 'jdkgjhslfdkghlsj', '1', '1478083049.mp4'),
(8, 2, 'adsad', 'assdsadas', '1', '1478503608.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `course_id`, `title`, `description`) VALUES
(1, 1, 'Introduction', 'Just intro text'),
(2, 1, 'Component Basics', 'idea about basic components'),
(8, 1, 'Data Flow', 'Data Flow'),
(9, 2, 'Introduction 2', 'In this lesson I will explain WebRTC and its basic components.'),
(10, 2, 'sdfdsf', 'sddsdkfjdslkfjdskf');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `date_taken` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`id`, `user_id`, `course_id`, `date_taken`) VALUES
(1, 2, 1, '2016-10-29 17:24:53'),
(2, 2, 1, '2016-10-29 17:24:53'),
(3, 3, 1, '2016-10-29 17:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `full_name` varchar(25) NOT NULL,
  `session_id` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` int(20) DEFAULT NULL,
  `about_me` varchar(300) DEFAULT NULL,
  `user_status` varchar(20) DEFAULT '1',
  `verified` int(5) NOT NULL DEFAULT '0',
  `role` int(10) NOT NULL DEFAULT '0',
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `session_id`, `password`, `email`, `phone`, `about_me`, `user_status`, `verified`, `role`, `address`) VALUES
(1, 'dfdsf', 'adas', NULL, 'dfdf', 'choyan', NULL, NULL, '1', 0, 0, NULL),
(2, 'choyan', 'Zahidul Hossain', NULL, '91929394', 'choyan@outlook.com', 1829677463, 'aboyt me', '1', 0, 1, 'sdfsdfsdfsdfds'),
(3, 'masud', 'Masud Rana', NULL, '91929394', 'masud@choyan.me', NULL, NULL, '1', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction`
--

CREATE TABLE `user_transaction` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `time` varchar(50) NOT NULL,
  `course_id` int(10) NOT NULL,
  `status` int(10) DEFAULT '0',
  `pay_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_transaction`
--

INSERT INTO `user_transaction` (`id`, `user_id`, `payment_method`, `time`, `course_id`, `status`, `pay_address`) VALUES
(1, 2, 'paypal', '2016-10-29 17:24:53', 1, 1, ''),
(2, 3, 'bKash', '2016-10-29 17:27:44', 1, 1, '44545454');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `course_info`
--
ALTER TABLE `course_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_subcategories`
--
ALTER TABLE `course_subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_transaction`
--
ALTER TABLE `course_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `user_transaction`
--
ALTER TABLE `user_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `course_info`
--
ALTER TABLE `course_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `course_subcategories`
--
ALTER TABLE `course_subcategories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `course_transaction`
--
ALTER TABLE `course_transaction`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_transaction`
--
ALTER TABLE `user_transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
