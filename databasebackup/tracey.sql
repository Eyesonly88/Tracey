-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2011 at 01:32 p.m.
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
  PRIMARY KEY (`ComponentId`,`ProjectId`),
  KEY `ComponentId` (`ComponentId`),
  KEY `project` (`ProjectId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`Name`, `ComponentId`, `ProjectId`, `CreationDate`, `RequiredHours`, `DueDate`) VALUES
('Comp1', 54, 119, NULL, NULL, NULL),
('Comp2', 55, 120, NULL, NULL, NULL),
('Comp3', 56, 121, NULL, NULL, NULL),
('Comp4', 57, 122, NULL, NULL, NULL),
('Comp5', 58, 123, NULL, NULL, NULL),
('Default', 69, 138, NULL, 500, '2011-08-13'),
('Default', 70, 139, NULL, 500, '2011-08-20');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`IssueId`, `ComponentId`, `ReporterId`, `AssigneeId`, `IssueType`, `Priority`, `CreationDate`, `IssueStatus`, `ResolvedDate`, `LastModificationDate`, `Description`, `name`) VALUES
(3, 54, 21, 22, 1, 2, NULL, 1, NULL, NULL, '', 'Issue 3 Title 345345'),
(4, 54, 21, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 55, 22, 21, 2, 3, NULL, 3, NULL, NULL, 'Some random test issue :D', 'testname222'),
(6, 55, 21, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 55, 23, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 54, 21, 23, 2, 3, NULL, 3, NULL, NULL, 'fadsfzfzv', 'stsdrg436');

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
  PRIMARY KEY (`IssueHourId`),
  KEY `issuehourissueidINDEX` (`IssueId`) USING BTREE,
  KEY `issuehouruserid` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `issuehour`
--

INSERT INTO `issuehour` (`IssueHourId`, `IssueId`, `Hours`, `Description`, `UserId`) VALUES
(10, 5, 5, 'read books for 5 hours', 21);

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
(1, 'high', NULL),
(2, 'medium', NULL),
(3, 'low', NULL);

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
(2, 'Closed', NULL),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`Id`, `SenderId`, `ReceiverId`, `TypeId`, `TypeEntityId`, `StatusId`) VALUES
(1, 21, 23, 1, 2, 1),
(2, 22, 23, 1, 3, 1),
(3, 22, 23, 2, 12, 1),
(4, 22, 21, 1, 2, 2),
(5, 23, 21, 1, 2, 3),
(6, 22, 21, 1, 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ProjectId`, `ProjectName`, `ProjectType`, `ProjectLeader`, `CreationDate`, `ProjectStatus`) VALUES
(119, 'Project1', NULL, 21, NULL, NULL),
(120, 'Project2', NULL, 21, NULL, NULL),
(121, 'Project3', NULL, 21, NULL, NULL),
(122, 'HelloByronProject', NULL, 21, NULL, NULL),
(123, 'SupWatdoProject', NULL, 21, NULL, NULL),
(138, 'testcreate', 1, 21, NULL, NULL),
(139, 'sup', 1, 21, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`, `Password`, `Salt`) VALUES
(21, 'Adeeb', 'Rahman', 'ttc_rulz@hotmail.com', 0, 1, 'Armalite', '01a5f11f60ec37402c740c90fc901840ff10cf6d', '7637ab7d2675e59628efce'),
(22, 'Random', 'Dude', 'random@random.com', 0, 1, 'Random', '8bcda560d747e29632013e36614f59943365175e', 'a3e076c0b29f6ceed5079c'),
(23, 'Mido', 'Basim', 'mo@mo.com', 0, 1, 'mo', '6ce174da3a2cc409a4a4ddd7bb06180df2173a37', 'c8c685b65a06446ed6ca87');

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
(21, 54),
(22, 54),
(23, 54),
(21, 55),
(22, 55),
(23, 55);

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
