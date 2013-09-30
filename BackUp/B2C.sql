-- phpMyAdmin SQL Dump
-- version 4.0.6-rc2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2013 at 12:55 pm
-- Server version: 5.6.11
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `B2C`
--

-- --------------------------------------------------------

--
-- Table structure for table `Cuisine`
--

CREATE TABLE IF NOT EXISTS `Cuisine` (
  `CuID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuName` text COLLATE utf8_bin,
  `CuDescr` text COLLATE utf8_bin,
  `CuPicPath` text COLLATE utf8_bin,
  `CuAvaliability` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `CuCuisine` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `CuType` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `CuPrice` int(11) DEFAULT NULL,
  `CuRating` int(11) DEFAULT NULL,
  `RestID` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CuReview` int(1) DEFAULT NULL,
  PRIMARY KEY (`CuID`),
  KEY `RestID_idxfk` (`RestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `CuisineComment`
--

CREATE TABLE IF NOT EXISTS `CuisineComment` (
  `UserID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuisineCommentID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuisineComent` text COLLATE utf8_bin,
  `CuCommentDate` date DEFAULT NULL,
  `CuCommentRating` int(11) DEFAULT NULL,
  `CuCommentLike` int(11) DEFAULT NULL,
  `CuCommentDislike` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`CuID`,`CuisineCommentID`),
  KEY `CuID_idxfk` (`CuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `CuisineTags`
--

CREATE TABLE IF NOT EXISTS `CuisineTags` (
  `CuisineTagesID` int(1) NOT NULL,
  `Availability` longtext COLLATE utf8_bin,
  `Cuisine` longtext COLLATE utf8_bin,
  `Type` longtext COLLATE utf8_bin,
  `Price` longtext COLLATE utf8_bin,
  PRIMARY KEY (`CuisineTagesID`),
  UNIQUE KEY `CuisineTagesID_UNIQUE` (`CuisineTagesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `CuisineTags`
--

INSERT INTO `CuisineTags` (`CuisineTagesID`, `Availability`, `Cuisine`, `Type`, `Price`) VALUES
(0, 'a:2:{i:0;s:9:"new stuff";i:1;s:4:"good";}', 'a:2:{i:0;s:5:"fesfs";i:1;s:7:"chinese";}', 'a:2:{i:0;s:7:"chinese";i:1;s:8:"japanese";}', 'a:3:{i:0;s:7:"300-400";i:1;s:7:"400-500";i:2;s:7:"600-700";}');

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE IF NOT EXISTS `Location` (
  `LocationID` int(11) NOT NULL AUTO_INCREMENT,
  `LevelOne` text COLLATE utf8_bin,
  `LevelTwo` text COLLATE utf8_bin,
  PRIMARY KEY (`LocationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=58 ;

--
-- Dumping data for table `Location`
--

INSERT INTO `Location` (`LocationID`, `LevelOne`, `LevelTwo`) VALUES
(56, 'adw', 'a:1:{i:0;s:6:"dwadwa";}'),
(57, 'sydney hosttal', 'a:2:{i:0;s:5:"abcde";i:1;s:4:"abde";}');

-- --------------------------------------------------------

--
-- Table structure for table `MailSetting`
--

CREATE TABLE IF NOT EXISTS `MailSetting` (
  `UserMailActiveID` varchar(30) COLLATE utf8_bin NOT NULL,
  `UserMailSender` text COLLATE utf8_bin,
  `UserMailTitle` text COLLATE utf8_bin,
  `UserMailConstructer` text COLLATE utf8_bin,
  PRIMARY KEY (`UserMailActiveID`),
  UNIQUE KEY `UserMailActiveID_UNIQUE` (`UserMailActiveID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `MailSetting`
--

INSERT INTO `MailSetting` (`UserMailActiveID`, `UserMailSender`, `UserMailTitle`, `UserMailConstructer`) VALUES
('ActivactionMail', 'Administrator@b2c.com', 'Welcome to B2C online order system,please read this mail carefully', '<p>Hello there,&nbsp;</p>\n\n<p>Welcome to&nbsp;board, please click below link to active your account, Thank you !</p>\n'),
('AdMail', NULL, NULL, NULL),
('PushMail', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Option`
--

CREATE TABLE IF NOT EXISTS `Option` (
  `WebTitle` text COLLATE utf8_bin,
  `WebDescription` text COLLATE utf8_bin,
  `WebUrl` text COLLATE utf8_bin,
  `EMail` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `WebStatus` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `OptionID` int(1) DEFAULT '1',
  `WebPolicy` longtext COLLATE utf8_bin,
  UNIQUE KEY `OptionID_UNIQUE` (`OptionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Option`
--

INSERT INTO `Option` (`WebTitle`, `WebDescription`, `WebUrl`, `EMail`, `WebStatus`, `OptionID`, `WebPolicy`) VALUES
('abcd', 'dwa', 'http://b2c.com.au', 'Administrator@b2c.com', 'Running', 1, 'temp');

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE IF NOT EXISTS `Order` (
  `UserID` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `OrderID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `OrderAddress` text COLLATE utf8_bin,
  `OrderCuisineData` text COLLATE utf8_bin,
  `OrderStatus` text COLLATE utf8_bin,
  `OrderDate` int(11) DEFAULT NULL,
  `OrderPoint` int(11) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID_idxfk` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Restaurants`
--

CREATE TABLE IF NOT EXISTS `Restaurants` (
  `RestID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ResName` text COLLATE utf8_bin,
  `ResOpenTime` text COLLATE utf8_bin,
  `ResAddress` text COLLATE utf8_bin,
  `ResPicPath` text COLLATE utf8_bin,
  `ResRating` int(11) DEFAULT NULL,
  `ResAvaliability` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ResCuisine` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ResReview` int(1) DEFAULT NULL,
  PRIMARY KEY (`RestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantsComments`
--

CREATE TABLE IF NOT EXISTS `RestaurantsComments` (
  `UserID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `RestID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ResCommentID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ResComment` text COLLATE utf8_bin,
  `ResCommentRating` int(11) DEFAULT NULL,
  `ResCommentDate` date DEFAULT NULL,
  `ResCommentLike` int(11) DEFAULT NULL,
  `ResCommentDislike` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`RestID`,`ResCommentID`),
  KEY `RestID_idxfk_1` (`RestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantTags`
--

CREATE TABLE IF NOT EXISTS `RestaurantTags` (
  `RestaurantTagsID` int(1) NOT NULL DEFAULT '0',
  `Availability` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `Cuisine` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`RestaurantTagsID`),
  UNIQUE KEY `RestaurantTagsID_UNIQUE` (`RestaurantTagsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `RestaurantTags`
--

INSERT INTO `RestaurantTags` (`RestaurantTagsID`, `Availability`, `Cuisine`) VALUES
(0, 'a:1:{i:0;s:9:"new staff";}', 'a:1:{i:0;s:13:"what the hell";}');

-- --------------------------------------------------------

--
-- Table structure for table `TempActiveCode`
--

CREATE TABLE IF NOT EXISTS `TempActiveCode` (
  `TempActiveID` int(11) NOT NULL AUTO_INCREMENT,
  `TempActiveCode` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`TempActiveID`),
  UNIQUE KEY `TempActiveID_UNIQUE` (`TempActiveID`),
  UNIQUE KEY `TempActiveCode_UNIQUE` (`TempActiveCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `TempActiveCode`
--

INSERT INTO `TempActiveCode` (`TempActiveID`, `TempActiveCode`) VALUES
(7, '110e72389bb02d22ce809c87aa2268de');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `UserID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `UserName` text COLLATE utf8_bin,
  `UserFirstName` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `UserLastName` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `UserPassWord` text COLLATE utf8_bin,
  `UserPhone` int(11) DEFAULT NULL,
  `UserPhotoPath` text COLLATE utf8_bin,
  `UserMail` text COLLATE utf8_bin,
  `UserAddress` longtext COLLATE utf8_bin,
  `UserPoints` int(11) DEFAULT NULL,
  `UserADPosition` text COLLATE utf8_bin,
  `UserType` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `UserStatus` int(1) DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `UserName`, `UserFirstName`, `UserLastName`, `UserPassWord`, `UserPhone`, `UserPhotoPath`, `UserMail`, `UserAddress`, `UserPoints`, `UserADPosition`, `UserType`, `UserStatus`) VALUES
('100001305895961', 'Shepard Zhao', 'Shepard', 'Zhao', NULL, NULL, NULL, 'zhaoxun321@163.com', NULL, NULL, NULL, 'Facebook', 1),
('100003754417076', 'Skittles Zhao', 'Skittles', 'Zhao', NULL, NULL, NULL, 'zhaoxun321@gmail.com', NULL, NULL, NULL, 'Facebook', 1),
('134031667', 'zhaoxun321', NULL, NULL, '24b126c506fe76b65cb830934e6669de', 321321321, 'http://127.0.0.1/B2C/assets/assets-imgs/UserPic/MTM4MDIzNTQwMi5qcGc=', 'Administrator@b2c.com', NULL, NULL, NULL, 'Administrator', 1),
('9354570317', NULL, NULL, NULL, 'b5adf222424b067becdc4cee85fc4472', NULL, NULL, '61507279@qq.com', NULL, NULL, NULL, 'Users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Userfavorite`
--

CREATE TABLE IF NOT EXISTS `Userfavorite` (
  `UserID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuID` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `FavoriteStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`CuID`),
  KEY `CuID_idxfk_1` (`CuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cuisine`
--
ALTER TABLE `Cuisine`
  ADD CONSTRAINT `cuisine_ibfk_1` FOREIGN KEY (`RestID`) REFERENCES `Restaurants` (`RestID`);

--
-- Constraints for table `CuisineComment`
--
ALTER TABLE `CuisineComment`
  ADD CONSTRAINT `cuisinecomment_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `cuisinecomment_ibfk_2` FOREIGN KEY (`CuID`) REFERENCES `Cuisine` (`CuID`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`);

--
-- Constraints for table `RestaurantsComments`
--
ALTER TABLE `RestaurantsComments`
  ADD CONSTRAINT `restaurantscomments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `restaurantscomments_ibfk_2` FOREIGN KEY (`RestID`) REFERENCES `Restaurants` (`RestID`);

--
-- Constraints for table `Userfavorite`
--
ALTER TABLE `Userfavorite`
  ADD CONSTRAINT `userfavorite_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `userfavorite_ibfk_2` FOREIGN KEY (`CuID`) REFERENCES `Cuisine` (`CuID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
