-- phpMyAdmin SQL Dump
-- version 4.0.6-rc2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2013 at 03:40 am
-- Server version: 5.6.14
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
  `CuID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuName` text COLLATE utf8_bin,
  `CuDescr` text COLLATE utf8_bin,
  `CuPicPath` text COLLATE utf8_bin,
  `Avaliability` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `CuAvaliability` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CuCuisine` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CuType` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CuPrice` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CuRating` int(1) DEFAULT NULL,
  `RestID` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `CuReview` int(1) DEFAULT NULL,
  `CuOrder` int(1) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  PRIMARY KEY (`CuID`),
  UNIQUE KEY `CuOrder_UNIQUE` (`CuOrder`),
  KEY `RestID_idxfk` (`RestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Cuisine`
--

INSERT INTO `Cuisine` (`CuID`, `CuName`, `CuDescr`, `CuPicPath`, `Avaliability`, `CuAvaliability`, `CuCuisine`, `CuType`, `CuPrice`, `CuRating`, `RestID`, `CuReview`, `CuOrder`, `Price`) VALUES
('C4196472792', 'adaw', 'dawda', 'http://b2c.com.au/assets/assets-imgs/CuisinePic/WaterMarkersmall-1382412635.jpg', 'Yes', '11AM - 1PM', 'Itanlian', 'Soup', '0 - 5', 0, 'R3374652900', 0, 2, 2),
('C4926171532', 'fhgfhgf', 'hghjghjjhg', NULL, 'Yes', '11AM - 1PM', 'Itanlian', 'Soup', '0 - 5', 0, 'R3374652900', 0, 6, 2),
('C7289743366', 'fdsfds', 'fsefs', 'http://b2c.com.au/assets/assets-imgs/CuisinePic/small-1382412615.jpg', 'Yes', '11AM - 1PM', 'Itanlian', 'Vegetarian', '0 - 5', 0, 'R3374652900', 0, 1, 2),
('C7810246245', 'dsfsd', 'fdsfdsfsdfs', 'http://b2c.com.au/assets/assets-imgs/CuisinePic/WaterMarkersmall-1382412871.jpeg', 'Yes', '11AM - 1PM', 'Itanlian', 'Haial', '10 - 15', 0, 'R3374652900', 0, 7, 22),
('C8611452204', 'dawdaw', 'dwadawd', 'http://b2c.com.au/assets/assets-imgs/CuisinePic/WaterMarkersmall-1382412843.jpg', 'Yes', '11AM - 1PM', 'Itanlian', 'Soup', '0 - 5', 0, 'R3374652900', 0, 4, 22),
('C9567612750', 'adwad', 'a22', 'http://b2c.com.au/assets/assets-imgs/CuisinePic/WaterMarkersmall-1382412734.jpg', 'Yes', '11AM - 1PM', 'Itanlian', 'Soup', '0 - 5', 0, 'R3374652900', 0, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `CuisineComment`
--

CREATE TABLE IF NOT EXISTS `CuisineComment` (
  `UserID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `CuID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
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
(0, 'a:3:{i:0;s:10:"11AM - 1PM";i:1;s:9:"1PM - 4PM";i:2;s:9:"4PM - 8PM";}', 'a:8:{i:0;s:0:"";i:1;s:8:"Itanlian";i:2;s:7:"Chinese";i:3;s:8:"japanese";i:4;s:6:"Indian";i:5;s:6:"Korean";i:6;s:10:"Australian";i:7;s:9:"Cantonese";}', 'a:8:{i:0;s:4:"Soup";i:1;s:5:"Pizza";i:2;s:10:"Vegetarian";i:3;s:5:"Haial";i:4;s:8:"sandwich";i:5;s:7:"Seafood";i:6;s:5:"Snack";i:7;s:3:"Pie";}', 'a:5:{i:0;s:5:"0 - 5";i:1;s:7:"10 - 15";i:2;s:7:"15 - 20";i:3;s:7:"20 - 30";i:4;s:7:"30 - 40";}');

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE IF NOT EXISTS `Location` (
  `LocationID` int(11) NOT NULL AUTO_INCREMENT,
  `LevelOnePic` text COLLATE utf8_bin,
  `LevelOne` text COLLATE utf8_bin,
  `LevelTwo` text COLLATE utf8_bin,
  PRIMARY KEY (`LocationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=65 ;

--
-- Dumping data for table `Location`
--

INSERT INTO `Location` (`LocationID`, `LevelOnePic`, `LevelOne`, `LevelTwo`) VALUES
(63, 'http://b2c.com.au/assets/assets-imgs/LocationPic/MTM4MDk1NTg2Ni5wbmc=', 'a:1:{s:2:"SH";s:15:"Sydney Hospital";}', 'a:2:{s:2:"ab";s:6:"Auburn";s:2:"BM";s:14:"Blue Mountains";}'),
(64, 'http://b2c.com.au/assets/assets-imgs/LocationPic/MTM4MDk2Njk1OC5wbmc=', 'a:1:{s:3:"SMA";s:24:"Sydney Metropolitan Area";}', 'a:7:{s:2:"B1";s:10:"Building 1";s:2:"B2";s:10:"Building 2";s:2:"B3";s:10:"Building 3";s:2:"B4";s:10:"Building 4";s:2:"bb";s:15:"BuildingBuildin";s:2:"dd";s:8:"sasdasss";s:2:"xx";s:14:"dasdsadwzxcsad";}');

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
  `RestID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ResName` text COLLATE utf8_bin,
  `ResOpenTime` text COLLATE utf8_bin,
  `ResAddress` text COLLATE utf8_bin,
  `ResPicPath` text COLLATE utf8_bin,
  `ResRating` int(11) DEFAULT NULL,
  `ResAvaliability` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ResCuisine` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ResReview` int(1) DEFAULT NULL,
  `UserID` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`RestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Restaurants`
--

INSERT INTO `Restaurants` (`RestID`, `ResName`, `ResOpenTime`, `ResAddress`, `ResPicPath`, `ResRating`, `ResAvaliability`, `ResCuisine`, `ResReview`, `UserID`) VALUES
('R3374652900', 'Kingsleys Steak & Crabhouse', 'a:7:{s:6:"Sunday";s:15:"12:30am-12:30am";s:6:"Monday";s:13:"1:00am-1:30am";s:7:"Tuesday";s:13:"1:00am-1:00am";s:9:"Wednesday";s:13:"2:30am-2:00am";s:8:"Thursday";s:13:"1:30am-2:30am";s:6:"Friday";s:13:"1:30am-2:30am";s:8:"Saturday";s:13:"3:30am-2:30am";}', '10/6 Cowper Wharf Roadway,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital,Sydney Hospital', 'http://b2c.com.au/assets/assets-imgs/RestaurantPic/1382350577.jpg', NULL, '11AM - 1PM', 'Korean', 0, '3374652900');

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantsComments`
--

CREATE TABLE IF NOT EXISTS `RestaurantsComments` (
  `UserID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `RestID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
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
-- Table structure for table `SecondLevelofCuisine`
--

CREATE TABLE IF NOT EXISTS `SecondLevelofCuisine` (
  `SecLevelCuID` int(11) NOT NULL AUTO_INCREMENT,
  `SeLevelTitle` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `SeLevelMultiple` longtext COLLATE utf8_bin,
  `CuID` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`SecLevelCuID`),
  UNIQUE KEY `SecLevelCuID_UNIQUE` (`SecLevelCuID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `SecondLevelofCuisine`
--

INSERT INTO `SecondLevelofCuisine` (`SecLevelCuID`, `SeLevelTitle`, `SeLevelMultiple`, `CuID`) VALUES
(9, 'adawd', 'a:2:{s:15:"SubSecondLevel0";a:2:{s:4:"name";s:4:"dawd";s:5:"price";s:1:"3";}s:15:"SubSecondLevel1";a:2:{s:4:"name";s:4:"dwad";s:5:"price";s:1:"2";}}', 'C4196472792');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `TempActiveCode`
--

INSERT INTO `TempActiveCode` (`TempActiveID`, `TempActiveCode`) VALUES
(7, '110e72389bb02d22ce809c87aa2268de'),
(13, '2a571c79ca03a7cedc9a8bab6ccc137e'),
(14, '3d8fbb9adf3365d815bc5c4ebd6612b9'),
(9, '78047528fd2b2340bda0e1d51dce2563'),
(10, '7d68164a8ced944e4f9ada976cf6e0c1'),
(12, '924d12cd8d1b3e8386926ce4d17a5a4f');

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
  `UserPhone` int(15) DEFAULT NULL,
  `UserPhotoPath` text COLLATE utf8_bin,
  `UserMail` text COLLATE utf8_bin,
  `UserAddress` text COLLATE utf8_bin,
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
('100001305895961', 'Shepard Zhao', 'Shepard', 'Zhao', NULL, 1232132131, 'https://graph.facebook.com/100001305895961/picture', 'zhaoxun321@163.com', '', NULL, NULL, 'Facebook', 1),
('100003754417076', 'Skittles Zhao', 'Skittles', 'Zhao', NULL, NULL, 'https://graph.facebook.com/100003754417076/picture', 'zhaoxun321@gmail.com', NULL, NULL, NULL, 'Facebook', 1),
('134031667', 'zhaoxun321', NULL, NULL, '24b126c506fe76b65cb830934e6669de', 321321321, '', 'Administrator@b2c.com', NULL, NULL, NULL, 'Administrator', 1),
('2871733205', NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', NULL, NULL, '', NULL, NULL, NULL, 'Restaturant', 1),
('3374652900', 'King wa', NULL, NULL, 'b5adf222424b067becdc4cee85fc4472', 432817462, NULL, 'zxqwe123@163.com', NULL, NULL, NULL, 'Restaturant', 1),
('7316088162', NULL, NULL, NULL, 'b5adf222424b067becdc4cee85fc4472', NULL, NULL, '61507279@qq.com', NULL, NULL, NULL, 'Users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `UserAddressBook`
--

CREATE TABLE IF NOT EXISTS `UserAddressBook` (
  `AddressBookID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `AddreNickName` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `AddrePhone` int(15) DEFAULT NULL,
  `AddresAddress` text COLLATE utf8_bin,
  `AddreStatus` int(1) DEFAULT NULL,
  PRIMARY KEY (`AddressBookID`),
  UNIQUE KEY `AddressBookID_UNIQUE` (`AddressBookID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=31 ;

--
-- Dumping data for table `UserAddressBook`
--

INSERT INTO `UserAddressBook` (`AddressBookID`, `UserID`, `AddreNickName`, `AddrePhone`, `AddresAddress`, `AddreStatus`) VALUES
(26, '100001305895961', 'sony', 321321, 'fesfesf, Building 2, Sydney Metropolitan Area', 0),
(29, '3829527059', 'john', 3434324, '3344, Building 4, Sydney Metropolitan Area', 1),
(30, '100001305895961', 'hello', 23432, 'faefesfes, Blue Mountains, Sydney Hospital', 0);

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
