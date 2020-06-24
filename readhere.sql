-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 07:23 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `readhere`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminName` varchar(32) NOT NULL,
  `adminPass` varchar(32) NOT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminName`, `adminPass`, `readable`) VALUES
('hunter10bt', 'August150800', 1),
('nichokevin', 'Nick', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `chapterID` bigint(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `storyID` bigint(11) NOT NULL,
  `summary` varchar(128) NOT NULL,
  `category` varchar(64) DEFAULT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapterID`, `title`, `storyID`, `summary`, `category`, `readable`) VALUES
(6, 'fdsa', 10, 'asdfdfsa', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` bigint(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `discussionID` bigint(11) DEFAULT NULL,
  `targetCommentID` bigint(20) DEFAULT NULL,
  `user` varchar(32) NOT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `comment`, `discussionID`, `targetCommentID`, `user`, `readable`) VALUES
(1, 'sdafsafdsafsa', 1, NULL, 'hunter10bt', 1),
(2, 'e', 1, NULL, 'hunter10bt', 0),
(3, 'sdafdsafds', 1, NULL, 'hunter10bt', 0),
(4, 'fdsasdf', 1, NULL, 'hunter10bt', 0),
(5, 'fsdafdsaf', NULL, 1, 'hunter10bt', 0),
(6, 'sdfafdsasdf', NULL, 5, 'hunter10bt', 1),
(7, 'asdfdsadfsa', NULL, 5, 'hunter10bt', 0),
(8, 'halo?', 1, NULL, 'hunter10bt', 0),
(9, 'ddwq', NULL, 8, 'hunter10bt', 1),
(10, 'sdfsdfsdfa', 2, NULL, 'hunter10bt', 0),
(11, 'woohoo', NULL, 9, 'reg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE `discussion` (
  `discussionID` bigint(11) NOT NULL,
  `dateCreated` date DEFAULT curdate(),
  `title` varchar(64) NOT NULL,
  `user` varchar(32) NOT NULL,
  `storyID` bigint(11) NOT NULL,
  `franchiseID` varchar(64) NOT NULL,
  `content` varchar(256) NOT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussion`
--

INSERT INTO `discussion` (`discussionID`, `dateCreated`, `title`, `user`, `storyID`, `franchiseID`, `content`, `readable`) VALUES
(1, '2020-06-10', 'sdfa', 'hunter10bt', 0, 'asdfdasds', 'sdfafdsa', 1),
(2, '2020-06-10', 'dsfsafsdafsadfsad', 'hunter10bt', 0, 'asdfdasds', 'afsdfsafsdafdsa', 0),
(3, '2020-06-11', 'fdsafsda', 'hunter10bt', 0, 'asdfdasds', 'asdfsdafdsds', 0),
(4, '2020-06-11', 'dfasfds', 'hunter10bt', 0, 'asdfdasds', 'asdfdsafsda', 1),
(5, '2020-06-11', 'sdfafdsaf', 'hunter10bt', 7, '', 'asdfdsafdsafsdafds', 1),
(6, '2020-06-11', 'dfsasdfa', 'hunter10bt', 7, '', 'sdfa', 1),
(7, '2020-06-16', 'dsa', 'hunter10bt', 10, '', 'adsasdsa', 1),
(8, '2020-06-21', 'Halo?', 'hunter10bt', 0, 'asdfdasds', 'halo', 0),
(9, '2020-06-24', 'asd', 'hunter10bt', 0, 'asdfdasds', 'sdafdasfdsa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `franchise`
--

CREATE TABLE `franchise` (
  `franchiseIDName` varchar(64) NOT NULL,
  `Franchise Name` varchar(128) NOT NULL,
  `Summary` varchar(100) NOT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `franchise`
--

INSERT INTO `franchise` (`franchiseIDName`, `Franchise Name`, `Summary`, `readable`) VALUES
('asdfdasds', 'fasdfdsa', 'fds', 1),
('asfdsa', 'asfdfdsafds', 'asdfdfsadasf', 1),
('dummy', 'A Dummy Franchise', 'This is a dummy franchise. Beep.', 0),
('fsdafasd', 'fsdafasd', 'fdafdsafdsa', 1),
('konosuba', 'Konosuba', 'A parody of isekai genre', 1),
('test', 'Test', 'this is a dummy franchise.', 1),
('tos', 'tos', 'tos', 1);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` bigint(20) NOT NULL,
  `submitter` varchar(32) NOT NULL,
  `userTgtID` varchar(32) DEFAULT NULL,
  `storyID` bigint(20) DEFAULT NULL,
  `franchiseIDName` varchar(64) DEFAULT NULL,
  `discussionID` bigint(20) DEFAULT NULL,
  `commentID` bigint(20) DEFAULT NULL,
  `title` varchar(32) NOT NULL,
  `detail` varchar(256) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportID`, `submitter`, `userTgtID`, `storyID`, `franchiseIDName`, `discussionID`, `commentID`, `title`, `detail`, `resolved`) VALUES
(1, 'hunter10bt', NULL, NULL, NULL, NULL, 1, 'dsfafdas', 'asdfas', 0),
(2, 'hunter10bt', NULL, NULL, NULL, 1, NULL, 'asfddsa', 'afsdfdsafsd', 0),
(3, 'hunter10bt', NULL, NULL, NULL, NULL, 9, 'sdfa', 'sdaffdsa', 0),
(4, 'hunter10bt', NULL, NULL, NULL, NULL, 9, 'dsf', 'sdfadfsa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `storyID` bigint(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `author` varchar(32) NOT NULL,
  `summary` varchar(256) NOT NULL,
  `dateAdded` date DEFAULT curdate(),
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`storyID`, `title`, `author`, `summary`, `dateAdded`, `readable`) VALUES
(1, 'Something', 'hunter10bt', 'This is just a story. Beep.', '2020-06-09', 1),
(2, 'Ho Ho', 'bob', 'asfddasdfsdfsdfsda', '2020-06-09', 1),
(3, 'asfdffsda', 'nick', 'asfsdafsdafsdafsad', '2020-06-09', 1),
(4, 'asdfdsa', 'regan', 'safdsadfsafsdfsa', '2020-06-09', 1),
(5, 'fsdafasdfsad', 'hunter10bt', 'asdffsafsafsdafas', '2020-06-09', 1),
(6, 'Hahaha', 'hunter10bt', 'hahahahahahaha', '2020-06-08', 1),
(7, 'Test', 'hunter10bt', 'tes 1 2 3', '2020-06-11', 1),
(10, 'Halo', 'hunter10bt', 'saya di sini', '2020-06-11', 1),
(12, 'asdfdfsadf', 'hunter10bt', 'adsf', '2020-06-22', 0),
(13, 'Haloo', 'hunter10bt', 'Saya di sinii', '2020-06-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tagdetails`
--

CREATE TABLE `tagdetails` (
  `franchiseID` varchar(64) NOT NULL,
  `storyID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tagdetails`
--

INSERT INTO `tagdetails` (`franchiseID`, `storyID`) VALUES
('asdfdasds', 1),
('asdfdasds', 7),
('asdfdasds', 10),
('asdfdasds', 12),
('asdfdasds', 13),
('asfdsa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(32) NOT NULL,
  `password` varchar(25) NOT NULL,
  `readable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `readable`) VALUES
('bob', 'bob', 1),
('hunter10bt', 'August150800', 1),
('nick', 'kevin', 1),
('reg', 'regan', 1),
('test', 'tester', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminName`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapterID`),
  ADD UNIQUE KEY `title-storyID_combination` (`storyID`,`title`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`discussionID`);

--
-- Indexes for table `franchise`
--
ALTER TABLE `franchise`
  ADD PRIMARY KEY (`franchiseIDName`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`storyID`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `tagdetails`
--
ALTER TABLE `tagdetails`
  ADD PRIMARY KEY (`franchiseID`,`storyID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapterID` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `discussionID` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `story`
--
ALTER TABLE `story`
  MODIFY `storyID` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
