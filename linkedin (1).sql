-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2020 at 01:28 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkedin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$CnBLNWWURGCrcmlI5fx8weDjwiV2d7hP0V/5yHYRkPn67R8WJt3qe');

-- --------------------------------------------------------

--
-- Table structure for table `connection`
--

CREATE TABLE `connection` (
  `user_id` int(10) NOT NULL,
  `linked_id` varchar(255) NOT NULL,
  `followers` varchar(255) NOT NULL,
  `following` varchar(255) NOT NULL,
  `post` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(10) NOT NULL,
  `news_title` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `news_content` varchar(255) NOT NULL,
  `news_image_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `startdate`, `enddate`, `news_content`, `news_image_path`) VALUES
(1, 'sahgd', '2019-11-14', '2019-11-20', 'sdhsdgthjaestgaofigjh urhy gifj gpioasjfgpijfpig jipjipooifgiujebqeg', ''),
(2, 'sahgd', '2019-11-14', '2019-11-20', 'sdhsdgthjaestgaofigjh urhy gifj gpioasjfgpijfpig jipjipooifgiujebqeg', ''),
(3, 'sahgd', '2020-01-02', '2020-01-17', 'dszgldsfoghnsodfnbgouigdhg\r\n', '');

-- --------------------------------------------------------

--
-- Table structure for table `unconfirmed_signup`
--

CREATE TABLE `unconfirmed_signup` (
  `Name` varchar(20) NOT NULL,
  `Enrollment` varchar(20) NOT NULL,
  `Class` varchar(12) NOT NULL,
  `Branch` varchar(12) NOT NULL,
  `Year` int(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `institute` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unconfirmed_signup`
--

INSERT INTO `unconfirmed_signup` (`Name`, `Enrollment`, `Class`, `Branch`, `Year`, `Password`, `email`, `institute`) VALUES
('', '', '', 'Branch', 20, '$2y$10$VGaqjD47DQux6t9h0/YtCOpuA7OtSGP1ZOhbWC/xuxEb88pTf0Nwa', '', 'Acropolis Institute of Technology and Research'),
('', '', '', 'Branch', 20, '$2y$10$PvOGtEcJXI62hlo9DTf10eRsIhhyeb.vTtLOBv/zcpRDdHSiTIRzK', '', 'Acropolis Institute of Technology and Research');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `user_id` int(10) NOT NULL,
  `fileaddress` varchar(255) NOT NULL,
  `upload_id` int(10) NOT NULL,
  `createdon` datetime NOT NULL,
  `likes` int(20) NOT NULL DEFAULT '0',
  `share` int(20) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Enrollment` varchar(20) NOT NULL,
  `Class` varchar(12) NOT NULL,
  `Branch` varchar(50) NOT NULL,
  `Year` int(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `institute` varchar(100) NOT NULL,
  `profilepic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Name`, `Enrollment`, `Class`, `Branch`, `Year`, `Password`, `email`, `institute`, `profilepic`) VALUES
(6, 'keshav suman ', '0827IT171036', 'IT-1', 'IT', 2017, '$2y$10$rNG.mtZYcyq38t54Glw4leKUv7QtHi09LxZ0FoLIBeV8yjPar7B4O', 'keshavsuman96@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `waiting`
--

CREATE TABLE `waiting` (
  `user_id` int(10) NOT NULL,
  `enrollment` varchar(20) NOT NULL,
  `fileaddress` varchar(255) NOT NULL,
  `upload_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `upload_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
