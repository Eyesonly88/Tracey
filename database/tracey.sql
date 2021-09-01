/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : tracey

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2011-09-18 03:53:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `component`
-- ----------------------------
DROP TABLE IF EXISTS `component`;
CREATE TABLE `component` (
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
  KEY `componentcreatorindex` (`Creator`) USING BTREE,
  CONSTRAINT `componentcreator` FOREIGN KEY (`Creator`) REFERENCES `user` (`UserId`) ON DELETE CASCADE,
  CONSTRAINT `project` FOREIGN KEY (`ProjectId`) REFERENCES `project` (`ProjectId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of component
-- ----------------------------

-- ----------------------------
-- Table structure for `componentwatches`
-- ----------------------------
DROP TABLE IF EXISTS `componentwatches`;
CREATE TABLE `componentwatches` (
  `ComponentId` bigint(20) NOT NULL DEFAULT '0',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ComponentId`,`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of componentwatches
-- ----------------------------

-- ----------------------------
-- Table structure for `issue`
-- ----------------------------
DROP TABLE IF EXISTS `issue`;
CREATE TABLE `issue` (
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
  KEY `Priority` (`Priority`),
  CONSTRAINT `assignee` FOREIGN KEY (`AssigneeId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE,
  CONSTRAINT `component` FOREIGN KEY (`ComponentId`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE,
  CONSTRAINT `issuetype` FOREIGN KEY (`IssueType`) REFERENCES `issuetype` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `priority` FOREIGN KEY (`Priority`) REFERENCES `issuepriority` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `reporter` FOREIGN KEY (`ReporterId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issue
-- ----------------------------

-- ----------------------------
-- Table structure for `issuehour`
-- ----------------------------
DROP TABLE IF EXISTS `issuehour`;
CREATE TABLE `issuehour` (
  `IssueHourId` bigint(255) NOT NULL AUTO_INCREMENT,
  `IssueId` bigint(11) NOT NULL,
  `Hours` bigint(100) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `UserId` bigint(20) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`IssueHourId`),
  KEY `issuehourissueidINDEX` (`IssueId`) USING BTREE,
  KEY `issuehouruserid` (`UserId`),
  CONSTRAINT `issuehourissueid` FOREIGN KEY (`IssueId`) REFERENCES `issue` (`IssueId`) ON DELETE CASCADE,
  CONSTRAINT `issuehouruserid` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuehour
-- ----------------------------

-- ----------------------------
-- Table structure for `issuepriority`
-- ----------------------------
DROP TABLE IF EXISTS `issuepriority`;
CREATE TABLE `issuepriority` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuepriority
-- ----------------------------
INSERT INTO `issuepriority` VALUES ('1', 'High', null);
INSERT INTO `issuepriority` VALUES ('2', 'Normal', null);
INSERT INTO `issuepriority` VALUES ('3', 'Low', null);

-- ----------------------------
-- Table structure for `issuestatus`
-- ----------------------------
DROP TABLE IF EXISTS `issuestatus`;
CREATE TABLE `issuestatus` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuestatus
-- ----------------------------
INSERT INTO `issuestatus` VALUES ('1', 'Open', null);
INSERT INTO `issuestatus` VALUES ('2', 'Resolved', null);
INSERT INTO `issuestatus` VALUES ('3', 'In Progress', null);

-- ----------------------------
-- Table structure for `issuetype`
-- ----------------------------
DROP TABLE IF EXISTS `issuetype`;
CREATE TABLE `issuetype` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuetype
-- ----------------------------
INSERT INTO `issuetype` VALUES ('1', 'public', null);
INSERT INTO `issuetype` VALUES ('2', 'private', null);

-- ----------------------------
-- Table structure for `milestone`
-- ----------------------------
DROP TABLE IF EXISTS `milestone`;
CREATE TABLE `milestone` (
  `MilestoneId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ComponentId` bigint(20) NOT NULL DEFAULT '0',
  `MilestoneStatus` bigint(20) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`MilestoneId`,`ComponentId`),
  KEY `component2` (`ComponentId`),
  CONSTRAINT `component2` FOREIGN KEY (`ComponentId`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of milestone
-- ----------------------------

-- ----------------------------
-- Table structure for `notification`
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `TypeId` int(11) NOT NULL,
  `TypeEntityId` int(11) NOT NULL,
  `StatusId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `status_id` (`StatusId`),
  KEY `type_id` (`TypeId`),
  CONSTRAINT `status_id` FOREIGN KEY (`StatusId`) REFERENCES `notificationstatus` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `type_id` FOREIGN KEY (`TypeId`) REFERENCES `notificationtype` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notification
-- ----------------------------

-- ----------------------------
-- Table structure for `notificationstatus`
-- ----------------------------
DROP TABLE IF EXISTS `notificationstatus`;
CREATE TABLE `notificationstatus` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notificationstatus
-- ----------------------------
INSERT INTO `notificationstatus` VALUES ('1', 'New', 'Means notification should be pushed to the receiver and has not been viewed yet or no action is done yet');
INSERT INTO `notificationstatus` VALUES ('2', 'Accepted', 'Means notification should be removed from notification bar and has been viewed and action taken to accept it');
INSERT INTO `notificationstatus` VALUES ('3', 'Rejected', 'Means notification should be removed from notification bar and has been viewed and action taken to reject it.');

-- ----------------------------
-- Table structure for `notificationtype`
-- ----------------------------
DROP TABLE IF EXISTS `notificationtype`;
CREATE TABLE `notificationtype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notificationtype
-- ----------------------------
INSERT INTO `notificationtype` VALUES ('1', 'ProjectInvite', 'Project invites sent by managers(SenderId) to users(ReceiverId)');
INSERT INTO `notificationtype` VALUES ('2', 'IssueAssigned', 'Issues assigned to the user(ReceiverId) by other users(SenderId)');

-- ----------------------------
-- Table structure for `priviledge`
-- ----------------------------
DROP TABLE IF EXISTS `priviledge`;
CREATE TABLE `priviledge` (
  `PriviledgeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PriviledgeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of priviledge
-- ----------------------------

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `ProjectId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProjectName` varchar(255) DEFAULT NULL,
  `ProjectType` bigint(20) DEFAULT NULL,
  `ProjectLeader` bigint(20) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `ProjectStatus` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ProjectId`),
  KEY `projectlead` (`ProjectLeader`),
  CONSTRAINT `projectlead` FOREIGN KEY (`ProjectLeader`) REFERENCES `user` (`UserId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project
-- ----------------------------

-- ----------------------------
-- Table structure for `projecttype`
-- ----------------------------
DROP TABLE IF EXISTS `projecttype`;
CREATE TABLE `projecttype` (
  `Id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of projecttype
-- ----------------------------
INSERT INTO `projecttype` VALUES ('1', 'solo');
INSERT INTO `projecttype` VALUES ('2', 'team');

-- ----------------------------
-- Table structure for `projectwatches`
-- ----------------------------
DROP TABLE IF EXISTS `projectwatches`;
CREATE TABLE `projectwatches` (
  `ProjectId` bigint(20) NOT NULL,
  `UserId` bigint(20) NOT NULL,
  PRIMARY KEY (`ProjectId`,`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of projectwatches
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserId` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` bigint(20) DEFAULT NULL,
  `UserType` bigint(11) DEFAULT NULL,
  `Nickname` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Salt` varchar(255) NOT NULL,
  `UDashboardJSON` varchar(255) DEFAULT NULL,
  `PDashboardJSON` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  KEY `user_usertype` (`UserType`),
  CONSTRAINT `user_usertype` FOREIGN KEY (`UserType`) REFERENCES `usertypes` (`UserTypeId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `usercomponent`
-- ----------------------------
DROP TABLE IF EXISTS `usercomponent`;
CREATE TABLE `usercomponent` (
  `UserID` bigint(20) NOT NULL DEFAULT '0',
  `ComponentID` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`ComponentID`),
  KEY `usercomponentCOMPONENTID` (`ComponentID`),
  CONSTRAINT `usercomponentCOMPONENTID` FOREIGN KEY (`ComponentID`) REFERENCES `component` (`ComponentId`) ON DELETE CASCADE,
  CONSTRAINT `usercomponentUSERID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usercomponent
-- ----------------------------

-- ----------------------------
-- Table structure for `useropenid`
-- ----------------------------
DROP TABLE IF EXISTS `useropenid`;
CREATE TABLE `useropenid` (
  `UserID` bigint(20) NOT NULL DEFAULT '0',
  `OpenID` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`OpenID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of useropenid
-- ----------------------------

-- ----------------------------
-- Table structure for `usertypes`
-- ----------------------------
DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE `usertypes` (
  `UserTypeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserTypeName` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usertypes
-- ----------------------------
INSERT INTO `usertypes` VALUES ('1', 'admin', 'boss');
INSERT INTO `usertypes` VALUES ('2', 'traceyuser', 'normal user');
INSERT INTO `usertypes` VALUES ('3', null, null);
