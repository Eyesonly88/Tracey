-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2011 at 08:48 p.m.
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tracey`
--

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE IF NOT EXISTS `component` (
  `Name` varchar(50) DEFAULT NULL,
  `ComponentId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProjectId` bigint(20) NOT NULL DEFAULT '0',
  `CreationDate` datetime DEFAULT NULL,
  `RequiredHours` bigint(20) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `IsDefault` int(11) DEFAULT NULL,
  `Creator` bigint(20) NOT NULL,
  PRIMARY KEY (`ComponentId`,`ProjectId`),
  KEY `ComponentId` (`ComponentId`),
  KEY `project` (`ProjectId`),
  KEY `componentcreatorindex` (`Creator`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`Name`, `ComponentId`, `ProjectId`, `CreationDate`, `RequiredHours`, `DueDate`, `IsDefault`, `Creator`) VALUES
('Default', 78, 147, NULL, 1000, '2011-08-29', 1, 21),
('Default', 79, 148, NULL, 0, '2011-08-29', 1, 21),
('Default', 80, 149, NULL, 55, '2011-08-18', 1, 21),
('Default', 81, 150, NULL, 5, '2011-08-29', 1, 21),
('Default', 82, 151, '2011-08-29 02:58:37', 5, '2011-08-29', 1, 21),
('Default', 83, 152, '2011-08-29 04:05:28', 22, '2011-08-30', 1, 21),
('Default', 84, 153, '2011-08-29 06:09:48', 2222, '2011-08-30', 1, 21),
('Default', 85, 154, '2011-08-29 13:24:29', 50, '2011-08-30', 1, 21),
('Default', 86, 155, '2011-08-29 14:08:38', 54, '2011-08-31', 1, 21),
('Default', 87, 156, '2011-08-29 15:41:21', 200, '2011-09-05', 1, 21),
('Default', 88, 157, '2011-08-29 16:30:47', 9001, '2011-09-05', 1, 21),
('Default', 89, 158, '2011-08-29 17:00:33', 40, '2011-09-05', 1, 21),
('Default', 90, 159, '2011-08-29 17:31:21', 9001, '2020-02-01', 1, 21),
('Default', 91, 160, '2011-08-29 17:32:21', 9001, '2011-09-05', 1, 21),
('Default', 92, 161, '2011-08-29 18:14:53', 90, '2011-09-05', 1, 21),
('Default', 93, 162, '2011-08-29 18:14:53', 90, '2011-09-05', 1, 21),
('Default', 94, 163, '2011-09-13 04:20:12', 55, '2011-09-15', 1, 21),
('some name', 95, 163, '2011-09-13 04:20:39', 50, '2011-09-20', 0, 21),
('Component 2', 96, 147, '2011-09-13 05:17:39', 5, '2011-09-15', 0, 21),
('hi renamed', 97, 155, '2011-09-13 05:21:44', 555, '2011-09-22', 0, 21),
('Default', 98, 164, '2011-09-13 05:45:06', 500, '2011-09-30', 1, 32),
('Component 2', 99, 164, '2011-09-13 05:51:58', 5, '2011-09-20', 0, 32),
('c3', 100, 164, '2011-09-13 05:52:07', 555, '2011-09-20', 0, 32),
('c4', 101, 164, '2011-09-13 05:52:15', 55555, '2011-09-18', 0, 32);

-- --------------------------------------------------------

--
-- Table structure for table `componentwatches`
--

CREATE TABLE IF NOT EXISTS `componentwatches` (
  `ComponentId` bigint(20) NOT NULL DEFAULT '0',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ComponentId`,`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `componentwatches`
--


-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE IF NOT EXISTS `issue` (
  `IssueId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ComponentId` bigint(20) NOT NULL DEFAULT '0',
  `ReporterId` bigint(20) DEFAULT NULL,
  `AssigneeId` bigint(20) DEFAULT NULL,
  `IssueType` bigint(20) DEFAULT NULL,
  `Priority` bigint(20) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `IssueStatus` bigint(20) DEFAULT NULL,
  `ResolvedDate` datetime DEFAULT NULL,
  `LastModificationDate` datetime DEFAULT NULL,
  `Description` varchar(2000) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IssueId`),
  KEY `ComponentId` (`ComponentId`),
  KEY `ReporterId` (`ReporterId`),
  KEY `AssigneeId` (`AssigneeId`),
  KEY `IssueType` (`IssueType`),
  KEY `Priority` (`Priority`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`IssueId`, `ComponentId`, `ReporterId`, `AssigneeId`, `IssueType`, `Priority`, `CreationDate`, `IssueStatus`, `ResolvedDate`, `LastModificationDate`, `Description`, `name`) VALUES
(11, 78, 21, 21, 1, 2, NULL, 2, '2011-09-13 03:11:34', '2011-09-13 03:11:34', 'wat', '710 Assignment44'),
(12, 78, 21, 21, 1, 1, NULL, 1, NULL, NULL, 'undefined', 'test issue'),
(13, 78, 21, 21, 1, 1, NULL, 1, NULL, NULL, 'undefined', 'hello mo test'),
(14, 81, 21, 21, 1, 1, NULL, 1, NULL, NULL, 'undefined', 'Something Needs Fixing'),
(15, 78, 21, 21, 1, 1, NULL, 1, NULL, NULL, 'undefined', 'Some issue'),
(16, 78, 21, 21, 1, 1, NULL, 1, NULL, NULL, 'undefined', 'Another issue'),
(17, 78, 21, 21, 1, 2, '2011-08-28 21:15:17', 1, NULL, NULL, 'test', 'test creation date'),
(19, 78, 21, 21, 1, 2, '2011-08-28 22:31:57', 1, NULL, NULL, '234234324dsfsfdsdsfaadsfsda', 'test'),
(20, 78, 21, 21, 1, 2, '2011-08-29 04:37:39', 1, NULL, NULL, 'hello there!', 'Test issue notif'),
(21, 85, 21, 21, 1, 2, '2011-08-29 13:25:24', 2, '2011-08-29 14:06:26', '2011-08-29 14:06:26', 'well this is my brilliant idea loljkwtfstfu', 'my brilliant idea'),
(22, 87, 27, 27, 1, 2, '2011-08-29 15:43:54', 1, NULL, NULL, 'Kill the person who invented Skynet', 'Assassination'),
(23, 88, 28, 28, 1, 2, '2011-08-29 16:35:13', 1, NULL, '2011-08-29 16:37:17', 'blah blah', 'brilliant idea'),
(24, 89, 29, 29, 1, 1, '2011-08-29 17:04:30', 1, NULL, '2011-08-29 17:06:22', 'This is my brilliant idea!', 'brillient idea'),
(25, 90, 30, 30, 1, 1, '2011-08-29 17:36:08', 2, '2011-08-29 17:51:24', '2011-08-29 17:51:24', 'every type of unit in the race is invisible', 'Make a new race called Adeeb'),
(26, 92, 31, 31, 1, 2, '2011-08-29 18:18:28', 1, NULL, '2011-08-29 18:20:38', 'gjhgjgjlkhk;jhlkjgljkhj', 'pen island'),
(27, 78, 21, 21, 2, 3, '2011-09-13 05:14:34', 1, NULL, NULL, 'asdgasgsdfghsdfghsdfgdfgsdfg', 'blablabla'),
(28, 100, 21, 21, 1, 2, '2011-09-13 06:36:22', 3, NULL, NULL, 'hi', 'issue for c3');

-- --------------------------------------------------------

--
-- Table structure for table `issuehour`
--

CREATE TABLE IF NOT EXISTS `issuehour` (
  `IssueHourId` bigint(255) NOT NULL AUTO_INCREMENT,
  `IssueId` bigint(11) NOT NULL,
  `Hours` bigint(100) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `UserId` bigint(20) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`IssueHourId`),
  KEY `issuehourissueidINDEX` (`IssueId`) USING BTREE,
  KEY `issuehouruserid` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `issuehour`
--

INSERT INTO `issuehour` (`IssueHourId`, `IssueId`, `Hours`, `Description`, `UserId`, `CreationDate`) VALUES
(11, 13, 50, 'shit', 21, NULL),
(12, 13, 0, '', 21, NULL),
(15, 11, 33, 'loldidnothing', 21, '2011-08-25 13:28:52'),
(16, 11, 21, '21 hours of 9898awerjkasasdf', 21, '2011-08-25 23:32:18'),
(18, 11, 10, 'something lol', 21, '2011-08-28 20:51:29'),
(19, 21, 3, 'Planning my brilliant idea', 21, '2011-08-29 13:26:32'),
(20, 22, 0, '', 27, '2011-08-29 15:44:50'),
(21, 22, 0, '', 27, '2011-08-29 15:44:53'),
(22, 22, 0, '', 27, '2011-08-29 15:44:53'),
(23, 22, 0, '', 27, '2011-08-29 15:44:53'),
(24, 22, 0, '', 27, '2011-08-29 15:44:53'),
(25, 22, 0, '', 27, '2011-08-29 15:44:54'),
(26, 22, 0, '', 27, '2011-08-29 15:44:54'),
(27, 22, 0, '', 27, '2011-08-29 15:44:54'),
(28, 22, 0, '', 27, '2011-08-29 15:44:54'),
(29, 22, 0, '', 27, '2011-08-29 15:44:54'),
(30, 22, 0, '', 27, '2011-08-29 15:44:54'),
(31, 22, 0, '', 27, '2011-08-29 15:44:55'),
(32, 22, 0, '', 27, '2011-08-29 15:44:55'),
(33, 22, 0, '', 27, '2011-08-29 15:44:55'),
(34, 22, 0, '', 27, '2011-08-29 15:44:55'),
(35, 22, 0, '', 27, '2011-08-29 15:44:55'),
(36, 22, 0, '', 27, '2011-08-29 15:44:56'),
(37, 22, 0, '', 27, '2011-08-29 15:44:56'),
(38, 22, 0, '', 27, '2011-08-29 15:44:56'),
(39, 22, 0, '', 27, '2011-08-29 15:44:56'),
(40, 22, 0, '', 27, '2011-08-29 15:44:56'),
(41, 22, 0, '', 27, '2011-08-29 15:44:58'),
(42, 22, 0, '', 27, '2011-08-29 15:44:58'),
(43, 22, 0, '', 27, '2011-08-29 15:44:58'),
(44, 22, 0, '', 27, '2011-08-29 15:44:59'),
(45, 22, 0, '', 27, '2011-08-29 15:44:59'),
(46, 22, 0, '', 27, '2011-08-29 15:44:59'),
(47, 22, 0, '', 27, '2011-08-29 15:44:59'),
(48, 22, 0, '', 27, '2011-08-29 15:45:00'),
(49, 22, 0, '', 27, '2011-08-29 15:45:00'),
(50, 22, 0, '', 27, '2011-08-29 15:45:05'),
(51, 22, 3, '', 27, '2011-08-29 15:45:08'),
(52, 22, 3, '', 27, '2011-08-29 15:45:08'),
(53, 22, 3, '', 27, '2011-08-29 15:45:09'),
(54, 22, 3, 'Thinking up this brilliant plan', 27, '2011-08-29 15:45:24'),
(55, 23, 98, 'mabu', 28, '2011-08-29 16:40:48'),
(56, 23, 10, 'fggg', 28, '2011-08-29 16:41:18'),
(57, 24, 3, 'Did some brainstorming', 29, '2011-08-29 17:06:14'),
(58, 25, 3, 'sleeping', 30, '2011-08-29 17:37:56'),
(60, 26, 3, 'lk;j;lkj;lj;lkj', 31, '2011-08-29 18:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `issuepriority`
--

CREATE TABLE IF NOT EXISTS `issuepriority` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `issuepriority`
--

INSERT INTO `issuepriority` (`ID`, `Name`, `Description`) VALUES
(1, 'High', NULL),
(2, 'Normal', NULL),
(3, 'Low', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issuestatus`
--

CREATE TABLE IF NOT EXISTS `issuestatus` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `issuestatus`
--

INSERT INTO `issuestatus` (`ID`, `Name`, `Description`) VALUES
(1, 'Open', NULL),
(2, 'Resolved', NULL),
(3, 'In Progress', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issuetype`
--

CREATE TABLE IF NOT EXISTS `issuetype` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `issuetype`
--

INSERT INTO `issuetype` (`ID`, `Name`, `Description`) VALUES
(1, 'public', NULL),
(2, 'private', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `milestone`
--

CREATE TABLE IF NOT EXISTS `milestone` (
  `MilestoneId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ComponentId` bigint(20) NOT NULL DEFAULT '0',
  `MilestoneStatus` bigint(20) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`MilestoneId`,`ComponentId`),
  KEY `component2` (`ComponentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `milestone`
--


-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `TypeId` int(11) NOT NULL,
  `TypeEntityId` int(11) NOT NULL,
  `StatusId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `status_id` (`StatusId`),
  KEY `type_id` (`TypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`Id`, `SenderId`, `ReceiverId`, `TypeId`, `TypeEntityId`, `StatusId`) VALUES
(18, 21, 24, 1, 147, 2),
(19, 21, 24, 1, 148, 2),
(20, 0, 0, 2, 0, 1),
(21, 21, 21, 2, 0, 1),
(22, 21, 21, 2, 0, 1),
(23, 21, 21, 2, 0, 1),
(24, 21, 21, 2, 0, 1),
(25, 21, 21, 2, 0, 1),
(26, 21, 0, 2, 0, 1),
(27, 21, 21, 2, 0, 1),
(28, 21, 21, 2, 0, 1),
(29, 21, 21, 2, 21, 1),
(30, 27, 24, 1, 156, 1),
(31, 27, 27, 2, 22, 1),
(32, 28, 24, 1, 157, 1),
(33, 28, 28, 2, 23, 1),
(34, 29, 0, 1, 158, 1),
(35, 29, 29, 2, 24, 1),
(36, 30, 24, 1, 159, 1),
(37, 30, 30, 2, 25, 1),
(38, 31, 24, 1, 161, 1),
(39, 31, 31, 2, 26, 1),
(40, 21, 21, 2, 27, 1),
(41, 32, 21, 1, 164, 2),
(42, 21, 21, 2, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notificationstatus`
--

CREATE TABLE IF NOT EXISTS `notificationstatus` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notificationstatus`
--

INSERT INTO `notificationstatus` (`Id`, `Name`, `Description`) VALUES
(1, 'New', 'Means notification should be pushed to the receiver and has not been viewed yet or no action is done yet'),
(2, 'Accepted', 'Means notification should be removed from notification bar and has been viewed and action taken to accept it'),
(3, 'Rejected', 'Means notification should be removed from notification bar and has been viewed and action taken to reject it.');

-- --------------------------------------------------------

--
-- Table structure for table `notificationtype`
--

CREATE TABLE IF NOT EXISTS `notificationtype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `notificationtype`
--

INSERT INTO `notificationtype` (`Id`, `Name`, `Description`) VALUES
(1, 'ProjectInvite', 'Project invites sent by managers(SenderId) to users(ReceiverId)'),
(2, 'IssueAssigned', 'Issues assigned to the user(ReceiverId) by other users(SenderId)');

-- --------------------------------------------------------

--
-- Table structure for table `priviledge`
--

CREATE TABLE IF NOT EXISTS `priviledge` (
  `PriviledgeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PriviledgeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `priviledge`
--


-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `ProjectId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProjectName` varchar(255) DEFAULT NULL,
  `ProjectType` bigint(20) DEFAULT NULL,
  `ProjectLeader` bigint(20) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `ProjectStatus` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ProjectId`),
  KEY `projectlead` (`ProjectLeader`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ProjectId`, `ProjectName`, `ProjectType`, `ProjectLeader`, `CreationDate`, `ProjectStatus`) VALUES
(147, 'Project Tracey 2', 2, 21, NULL, NULL),
(148, 'Project Tracey 3', 2, 21, NULL, NULL),
(149, 'hi', 2, 21, NULL, NULL),
(150, 'Project Tracey 4', 2, 21, NULL, NULL),
(151, 'Test component date', 2, 21, NULL, NULL),
(152, 'test comp date lol', 2, 21, NULL, NULL),
(153, 'test refresh', 2, 21, NULL, NULL),
(154, 'Brilliant idea', 2, 21, NULL, NULL),
(155, 'Another idea', 2, 21, NULL, NULL),
(156, 'The Rebellion', 2, 27, NULL, NULL),
(157, 'stfu', 2, 28, NULL, NULL),
(158, 'Sarahs Project', 2, 29, NULL, NULL),
(159, 'Make Starcraft 3', 2, 30, NULL, NULL),
(160, 'Make Starcraft3', 2, 30, NULL, NULL),
(161, 'poo', 2, 31, NULL, NULL),
(162, 'poo', 2, 31, NULL, NULL),
(163, 'test after component', 1, 21, NULL, NULL),
(164, 'John''s project', 2, 32, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projecttype`
--

CREATE TABLE IF NOT EXISTS `projecttype` (
  `Id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `projecttype`
--

INSERT INTO `projecttype` (`Id`, `name`) VALUES
(1, 'solo'),
(2, 'team');

-- --------------------------------------------------------

--
-- Table structure for table `projectwatches`
--

CREATE TABLE IF NOT EXISTS `projectwatches` (
  `ProjectId` bigint(20) NOT NULL,
  `UserId` bigint(20) NOT NULL,
  PRIMARY KEY (`ProjectId`,`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectwatches`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserId` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` bigint(20) DEFAULT NULL,
  `UserType` bigint(11) DEFAULT NULL,
  `Nickname` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Salt` varchar(255) NOT NULL,
  PRIMARY KEY (`UserId`),
  KEY `user_usertype` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`, `Password`, `Salt`) VALUES
(21, 'Adeeb', 'Rahman', 'ttc_rulz@hotmail.com', 0, 1, 'Armalite', '01a5f11f60ec37402c740c90fc901840ff10cf6d', '7637ab7d2675e59628efce'),
(22, 'Random', 'Dude', 'random@random.com', 0, 1, 'Random', '8bcda560d747e29632013e36614f59943365175e', 'a3e076c0b29f6ceed5079c'),
(23, 'Mido', 'Basim', 'mo@mo.com', 0, 1, 'mo', '6ce174da3a2cc409a4a4ddd7bb06180df2173a37', 'c8c685b65a06446ed6ca87'),
(24, 'John', 'Doe', 'john@doe.com', 0, 1, 'student', 'd5d05fbf89ee9491fe5f419e8c9c4b7ff33c7400', '4659f6646e7d3cfd636cab'),
(25, '', '', 'jkim332@auckland.ac.nz', 0, 1, 'Hanho', '84cb7a055a4082cc0c33235995491e69045daf24', 'a02cc7963b2c91e231b363'),
(26, '', '', 'jkim@auckland.ac.nz', 0, 1, 'Jae Soon 2', '289162f6267818f17fdbd6a62e9f5610aa162cb6', '6c30e989b56c299ffc30b7'),
(27, '', '', 's.e.connor@sky.net', 0, 1, 's.e.connor', '948ad95454ad8b740d98829ce4de26a91b6574c2', '54b5aa7345c95e5ecb0679'),
(28, '', '', 'a@hotmail.com', 0, 1, 'a', 'f74ad89a084d07739ae7b206b5e09ed0740c426a', '729bc61f4b94f9a3f1cc67'),
(29, '', '', 'SarahConner@gmail.com', 0, 1, 'SarahC', '43da124c22a8a8a9d1b596a58b4bc77247f8e80c', '5e9463a99a014d60b81e2d'),
(30, '', '', 'joeyanglx@hotmail.com', 0, 1, 'Lykos', '91692f1ef2c9001b169785ce67e971ca4a288bec', '1014ea8e3d74d08046ae76'),
(31, '', '', 'rowanjkw@gmail.com', 0, 1, 'My Adeeb', 'd67a3ad96ab2be5d58ee33476c2450be8552aa61', '7fd639826feca58682ac64'),
(32, '', '', 'john@john.com', 0, 1, 'johnny', 'd4012deac2719bb7c57a652e25c7ebc381efa86f', '0b634d2aa0cab0afb85505');

-- --------------------------------------------------------

--
-- Table structure for table `usercomponent`
--

CREATE TABLE IF NOT EXISTS `usercomponent` (
  `UserID` bigint(20) NOT NULL DEFAULT '0',
  `ComponentID` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`ComponentID`),
  KEY `usercomponentCOMPONENTID` (`ComponentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usercomponent`
--

INSERT INTO `usercomponent` (`UserID`, `ComponentID`) VALUES
(21, 78),
(21, 79),
(21, 80),
(21, 81),
(21, 82),
(21, 83),
(21, 84),
(21, 85),
(21, 86),
(27, 87),
(28, 88),
(29, 89),
(30, 90),
(30, 91),
(31, 92),
(31, 93),
(21, 94),
(21, 95),
(21, 96),
(21, 97),
(21, 98),
(32, 98),
(21, 99),
(32, 99),
(21, 100),
(32, 100),
(21, 101),
(32, 101);

-- --------------------------------------------------------

--
-- Table structure for table `useropenid`
--

CREATE TABLE IF NOT EXISTS `useropenid` (
  `UserID` bigint(20) NOT NULL DEFAULT '0',
  `OpenID` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`OpenID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useropenid`
--


-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE IF NOT EXISTS `usertypes` (
  `UserTypeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserTypeName` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`UserTypeId`, `UserTypeName`, `Description`) VALUES
(1, 'admin', 'boss'),
(2, 'traceyuser', 'normal user'),
(3, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `component`
--
ALTER TABLE `component`
  ADD CONSTRAINT `componentcreator` FOREIGN KEY (`Creator`) REFERENCES `user` (`UserId`) ON DELETE CASCADE,
  ADD CONSTRAINT `project` FOREIGN KEY (`ProjectId`) REFERENCES `project` (`ProjectId`) ON DELETE CASCADE;

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `assignee` FOREIGN KEY (`AssigneeId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE,
  ADD CONSTRAINT `component` FOREIGN KEY (`ComponentId`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE,
  ADD CONSTRAINT `issuetype` FOREIGN KEY (`IssueType`) REFERENCES `issuetype` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `priority` FOREIGN KEY (`Priority`) REFERENCES `issuepriority` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reporter` FOREIGN KEY (`ReporterId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `issuehour`
--
ALTER TABLE `issuehour`
  ADD CONSTRAINT `issuehourissueid` FOREIGN KEY (`IssueId`) REFERENCES `issue` (`IssueId`) ON DELETE CASCADE,
  ADD CONSTRAINT `issuehouruserid` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `milestone`
--
ALTER TABLE `milestone`
  ADD CONSTRAINT `component2` FOREIGN KEY (`ComponentId`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `status_id` FOREIGN KEY (`StatusId`) REFERENCES `notificationstatus` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `type_id` FOREIGN KEY (`TypeId`) REFERENCES `notificationtype` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `projectlead` FOREIGN KEY (`ProjectLeader`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_usertype` FOREIGN KEY (`UserType`) REFERENCES `usertypes` (`UserTypeId`) ON DELETE CASCADE;

--
-- Constraints for table `usercomponent`
--
ALTER TABLE `usercomponent`
  ADD CONSTRAINT `usercomponentCOMPONENTID` FOREIGN KEY (`ComponentID`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE,
  ADD CONSTRAINT `usercomponentUSERID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;
