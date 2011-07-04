/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : tracey

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2011-07-04 17:40:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `component`
-- ----------------------------
DROP TABLE IF EXISTS `component`;
CREATE TABLE `component` (
  `ComponentId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProjectId` bigint(20) NOT NULL DEFAULT '0',
  `CreationDate` datetime DEFAULT NULL,
  `RequiredHours` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ComponentId`,`ProjectId`),
  KEY `ComponentId` (`ComponentId`),
  KEY `project` (`ProjectId`),
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
-- Table structure for `issuepriority`
-- ----------------------------
DROP TABLE IF EXISTS `issuepriority`;
CREATE TABLE `issuepriority` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuepriority
-- ----------------------------

-- ----------------------------
-- Table structure for `issuestatus`
-- ----------------------------
DROP TABLE IF EXISTS `issuestatus`;
CREATE TABLE `issuestatus` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuestatus
-- ----------------------------

-- ----------------------------
-- Table structure for `issuetype`
-- ----------------------------
DROP TABLE IF EXISTS `issuetype`;
CREATE TABLE `issuetype` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of issuetype
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES ('62', 'Test1', null, '21', null, null);
INSERT INTO `project` VALUES ('63', 'SandboxTest1', null, '21', null, null);
INSERT INTO `project` VALUES ('64', 'SandboxTest1', null, '21', null, null);
INSERT INTO `project` VALUES ('65', 'SandboxTest1', null, '21', null, null);

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
  PRIMARY KEY (`UserId`),
  KEY `user_usertype` (`UserType`),
  CONSTRAINT `user_usertype` FOREIGN KEY (`UserType`) REFERENCES `usertypes` (`UserTypeId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('21', '', '', 'ttc_rulz@hotmail.com', '0', '1', 'Armalite', '01a5f11f60ec37402c740c90fc901840ff10cf6d', '7637ab7d2675e59628efce');
INSERT INTO `user` VALUES ('22', '', '', 'random@random.com', '0', '1', 'Random', '8bcda560d747e29632013e36614f59943365175e', 'a3e076c0b29f6ceed5079c');

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
