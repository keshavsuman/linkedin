-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 09:24 AM
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
  `admin_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `password`) VALUES
('admin', '$2y$10$DnAKwyLtrX1JbMRVibwLUOLxENze0HhnSgE2iqNqWk4.refLW6rb6');

-- --------------------------------------------------------

--
-- Table structure for table `connection`
--

CREATE TABLE `connection` (
  `user_id` varchar(255) NOT NULL,
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
  `news_id` int(255) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `news_content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `startdate`, `enddate`, `news_content`) VALUES
(1, 'sahgd', '2019-11-14', '2019-11-20', 'sdhsdgthjaestgaofigjh urhy gifj gpioasjfgpijfpig jipjipooifgiujebqeg'),
(2, 'sahgd', '2019-11-14', '2019-11-20', 'sdhsdgthjaestgaofigjh urhy gifj gpioasjfgpijfpig jipjipooifgiujebqeg');

-- --------------------------------------------------------

--
-- Table structure for table `unconfirmed_signup`
--

CREATE TABLE `unconfirmed_signup` (
  `Name` varchar(255) NOT NULL,
  `Enrollment` varchar(20) NOT NULL,
  `Class` varchar(12) NOT NULL,
  `Branch` varchar(12) NOT NULL,
  `Year` varchar(12) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `institute` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `Enrollment` varchar(255) NOT NULL,
  `fileaddress` varchar(255) NOT NULL,
  `upload_id` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `likes` int(20) NOT NULL DEFAULT '0',
  `dislikes` int(20) NOT NULL DEFAULT '0',
  `share` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`Enrollment`, `fileaddress`, `upload_id`, `description`, `date`, `time`, `likes`, `dislikes`, `share`) VALUES
('0827IT171036', '0827IT171036-Success.png', 1, '', '0000-00-00', '00:00:00.000000', 0, 0, 0),
('0827IT171036', '0827IT171036-Dontcompromise.png', 3, '', '0000-00-00', '00:00:00.000000', 0, 0, 0),
('0827IT171036', '0827IT171036-pressure.png', 4, '', '0000-00-00', '00:00:00.000000', 0, 1, 0),
('0827IT171019', '0827IT171019-Never_hurt.png', 5, '', '0000-00-00', '00:00:00.000000', 1, 0, 0),
(' 0827IT17103', '_0827IT171034-news.png', 7, '', '0000-00-00', '00:00:00.000000', 0, 0, 0),
('0827IT171033', '0827IT171033-news.png', 8, '', '0000-00-00', '00:00:00.000000', 7, 1, 0),
('0827IT171036', '0827IT171036-Capture.PNG', 10, '', '0000-00-00', '00:00:00.000000', 0, 0, 0),
('0827IT171036', '0827IT171036-imagecrousel.PNG', 11, '', '0000-00-00', '00:00:00.000000', 0, 0, 0),
('0827IT171036', '0827IT171036-work_like.png', 13, '', '0000-00-00', '00:00:00.000000', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Name` varchar(255) NOT NULL,
  `Enrollment` varchar(20) NOT NULL,
  `Class` varchar(12) NOT NULL,
  `Branch` varchar(12) NOT NULL,
  `Year` varchar(12) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `institute` varchar(255) NOT NULL,
  `profilepic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Name`, `Enrollment`, `Class`, `Branch`, `Year`, `Password`, `email`, `institute`, `profilepic`) VALUES
('Hritik karma', ' 0827IT171034', 'IT-1', 'IT', '2017', '$2y$10$dHRcntGI80T0TRdVe/ae9e1vGeNK.LTkz5hjZ9YWlpFXGD0UjLXhq', 'keshavthegreat.ks@gmail.com', '', ''),
('Astha jain ', '0827IT171019', 'IT-1', 'IT', '2017', '$2y$10$ILDNmD/okITymAfCIQdygOS8aitA4k2VStsld7Tdl.GBa8k2udBuO', 'keshavsuman96@gmail.com', '', ''),
('Harshit pathak', '0827IT171032', 'IT', 'it', '2017', '$2y$10$PStDtQtNiaYe4Ao/M5LJ4uodQpL/oSG/nF.lpzbR6AlhR3Bn6Mwfy', 'keshavsuman96@gmail.com', '', ''),
('keshavsuman96', '0827IT171033', 'IT-1', 'IT', '2017', '$2y$10$Es8oQheQvVO8wr2ojQtCVOwH4sLpaYaSj63y9EGhvfuhs19OTDOxG', 'keshavsuman96@gmail.com', 'Acropolis Institute of Technology And Research', ''),
('keshav suman ', '0827IT171036', 'IT-1', 'IT', '2017', '$2y$10$rNG.mtZYcyq38t54Glw4leKUv7QtHi09LxZ0FoLIBeV8yjPar7B4O', 'keshavsuman96@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `waiting`
--

CREATE TABLE `waiting` (
  `Enrollment` varchar(12) NOT NULL,
  `fileaddress` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `upload_id` varchar(20) NOT NULL
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
  ADD PRIMARY KEY (`Enrollment`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
