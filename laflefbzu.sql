-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2019 at 04:01 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laflefbzu`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `cid` bigint(10) NOT NULL,
  `date` date NOT NULL,
  `rid` int(11) NOT NULL,
  `additions` varchar(45) NOT NULL,
  `invoice` double NOT NULL,
  `pnum` int(11) NOT NULL,
  PRIMARY KEY (`bid`,`pid`,`cid`),
  UNIQUE KEY `bid` (`bid`),
  KEY `pid` (`pid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bid`, `pid`, `cid`, `date`, `rid`, `additions`, `invoice`, `pnum`) VALUES
(19, 2, 1000000004, '2019-05-11', 21, 'None', 200, 4),
(22, 1, 1000000004, '2019-05-14', 23, 'None', 150, 3),
(26, 12, 1000000004, '2019-05-14', 24, 'Birthday-Cake for 5', 450, 5),
(27, 12, 1000000001, '2019-05-14', 24, 'Birthday cake For 3', 270, 3),
(28, 12, 1000000001, '2019-05-14', 24, 'Birthday cake For 3', 270, 3);

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

DROP TABLE IF EXISTS `credit`;
CREATE TABLE IF NOT EXISTS `credit` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `num` bigint(20) NOT NULL,
  `expiredate` date NOT NULL,
  `bank` varchar(30) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`rid`, `name`, `num`, `expiredate`, `bank`) VALUES
(21, 'Visa', 4444555555, '2020-04-20', 'alarabi'),
(22, 'Master', 5555222222, '2020-10-20', 'alarabi'),
(23, 'American-Express', 6666589612, '2020-07-20', 'Palestine'),
(24, 'Master-Card', 5555745258, '2020-09-19', 'Palestine'),
(25, 'American-Express', 6666745258, '2020-04-20', 'Palestine');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cid` bigint(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL,
  `username` text NOT NULL,
  `phone` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(30) NOT NULL,
  `DOB` date NOT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cid` (`email`,`phone`),
  UNIQUE KEY `cid_2` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cid`, `name`, `email`, `username`, `phone`, `password`, `address`, `DOB`) VALUES
(1000000000, 'loay', 'loay1998@gmail.com', 'loay-soso', '0569677544', 'c84aff04c59592c5ed68462afd7d323e', 'abo falah', '1998-11-25'),
(1000000001, 'amjad ', 'amjadmoqade98@gmail.com', 'Amjadmoqade', '0569636479', 'd4d1f243801f059e2cd8e305e76ae2c1', 'alzawya', '1998-10-07'),
(1000000002, 'waleed', 'waleed@gmail.com', 'waleedSwalih', '0569677544', 'b8f5fab46c4306f2a2a479868a211079', 'birzeit', '2019-05-31'),
(1000000003, 'mustafa', 'mustafa@1990.gmail', 'steve b3irat', '0591234569', 'd05dadd3bddfe8e54a61ecd81d557d01', 'kafrMalek', '2019-05-22'),
(1000000004, 'Mustafa Birat', '1160813@student.birzeit.edu', 'Mustafa', '0598894790', 'd77d5693ca6b04261498234c25d9b944', 'Ramallah', '1998-04-20'),
(1000000005, 'Harry Sevreoius', 'mr.mustrobot@yahoo.com', 'laflefteam', '0598894790', 'd77d5693ca6b04261498234c25d9b944', 'Ramallah', '1998-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(13) NOT NULL,
  `password` varchar(12) NOT NULL,
  `email` varchar(70) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`mid`, `username`, `password`, `email`) VALUES
(1, 'Mustafa', 'mustafa', 'mustafaadwi@gmail.com'),
(2, 'Waleed', 'waleed', 'waleedswaileh@g.com'),
(3, 'Amjad', 'amjad', 'amjadmoqade@g.com');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`) VALUES
(41, 'waleed', 'w@s', 'fsafsfa'),
(42, 'WALEED', 'W@s', 'Heeey'),
(43, 'gdsg', 'w@sss', 'aetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagioaetagio'),
(44, 'Waleed khalid mustafa saleh hussein saleh Swaileh', 'w@s', 'safsgagssgagsga'),
(45, 'Waleedd', 'waleed@gmail.com', 'Heeeeyyyyyy adminnnsssss i just want to saaay heeeeyyyyyyyy'),
(46, 'Waleedddddd', 'w@s', 'Heeeyyyyyy adminsnsssssas â¤â¤â¤'),
(47, 'eee', 'mustafaadwi', 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `news` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`nid`),
  KEY `mid_fk` (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`nid`, `mid`, `news`, `created_at`) VALUES
(1, 1, 'Our Website is going to be developed step by step to serve you and to reach with you one of the best picnics websites.', '2019-05-15 00:17:00'),
(6, 3, '<p>Welcome all to our website!&nbsp;<img alt=\"heart\" src=\"http://localhost/WebProject1.0/ckeditor/plugins/smiley/images/heart.png\" style=\"height:23px; width:23px\" title=\"heart\" />â€‹â€‹â€‹â€‹â€‹â€‹â€‹</p>\r\n', '2019-05-15 00:28:55'),
(7, 2, '<p>We all Work together to earn your trust&nbsp;<img alt=\"laugh\" src=\"http://localhost/WebProject1.0/ckeditor/plugins/smiley/images/teeth_smile.png\" style=\"height:23px; width:23px\" title=\"laugh\" />, Stay Tuned,</p>\r\n', '2019-05-15 00:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `picnic`
--

DROP TABLE IF EXISTS `picnic`;
CREATE TABLE IF NOT EXISTS `picnic` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `food` varchar(128) NOT NULL,
  `cost` double NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL,
  `returntime` time NOT NULL,
  `arrivaltime` time NOT NULL,
  `departuretime` time NOT NULL,
  `date` date NOT NULL,
  `departurelocation` varchar(45) NOT NULL,
  `place` varchar(45) NOT NULL,
  `activities` text NOT NULL,
  `images` varchar(45) NOT NULL DEFAULT 'default.jpg;default.jpg;default.jpg',
  `title` varchar(45) NOT NULL,
  `escorts` varchar(30) NOT NULL,
  `escorttel` int(12) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picnic`
--

INSERT INTO `picnic` (`pid`, `food`, `cost`, `capacity`, `description`, `returntime`, `arrivaltime`, `departuretime`, `date`, `departurelocation`, `place`, `activities`, `images`, `title`, `escorts`, `escorttel`) VALUES
(1, 'Shawerma', 50, 50, 'Beautiful Picnic it will be, dont be afraid my dear', '08:19:18', '06:18:00', '05:00:00', '2019-07-09', 'Ramallah-Alhambra Palace', 'Jenin', 'hiking, chilling, barbecue party and photography party ', 'default', 'Faquaa', 'Mustafa', 598894790),
(2, 'Shawrma', 50, 4, 'it will be wonderful picnic my dear don\'t hesitate to join us ', '08:19:18', '06:18:00', '05:00:00', '2019-07-09', 'Ramallah-Alhambra Palace', 'Jenin', 'Hiking, barbecue party, photography party  ', 'default', 'Faquaa2', 'Waleed', 569145236),
(3, 'Shawrma', 50, 30, 'it will be wonderful picnic my dear don\'t hesitate to join us ', '08:19:18', '06:18:00', '05:00:00', '2019-05-09', 'Ramallah-Alhambra Palace', 'Jenin', 'Hiking, barbecue party, photography party  ', 'default', 'JENIN', 'Amjad', 568123621),
(12, 'Shawrma, Barbecue', 70, 35, '<p><strong>Wadi-Alquielt</strong></p>\r\n\r\n<p>A wounderfull hiking&amp;nbsp;and walking picnic there will be photographers, Instructions:</p>\r\n\r\n<p><br />\r\n&nbsp; &nbsp; Wear proper shoes and sport clothes.<br />\r\n&nbsp;&nbsp; &nbsp;Children under 10 is not allowed.<img alt=\"frown\" src=\"http://localhost/WebProject1.0/ckeditor/plugins/smiley/images/confused_smile.png\" style=\"height:23px; width:23px\" title=\"frown\" /><br />\r\n&nbsp; &nbsp; Time is sharp so do not\r\n be late.<br />\r\n&nbsp;</p>\r\n\r\n<p>more information about the place:</p>\r\n\r\n<p><a href=\"https://en.wikipedia.org/wiki/Wadi_Qelt\">Wadi-Qelt/wikipedia</a></p>\r\n\r\n<p><sub>Laflef</sub> <sup>Team</sup></p>\r\n', '22:00:00', '10:00:00', '08:00:00', '2019-05-20', 'Ramllah-alhambarah-palace', 'Jericho', 'Hiking , there will be Guitar players', '12_1;12_2;12_3', 'Wadi-Alquilt', 'Mohammed', 599851123),
(13, 'Falafel,Shwrma', 60, 20, '<p><strong>Hebron</strong></p>\r\n\r\n<p>Fantasy picnic with the old buildings of hepron,instructions:</p>\r\n\r\n<ol>\r\n	<li>Wear proper shoes and clothes.</li>\r\n	<li>Children are allowed on thier parent&#39;s responsibilities.<img alt=\"smiley\" src=\"http://localhost/webProject1.0/ckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></li>\r\n	<li>Time is shartp so don&#39;t be late.<img alt=\"angel\" src=\"http://localhost/webProject1.0/ckeditor/plugins/smiley/images/angel_smile.png\" style=\"height:23px; width:23px\" title=\"angel\" /></li>\r\n</ol>\r\n\r\n<p>Laflef Team</p>\r\n', '23:00:00', '11:00:00', '10:00:00', '2019-08-20', 'Ramllah-alhambarah-palace', 'nowhere', 'Hiking', '13_1;13_2;13_3', 'Hebron', 'Zaher', 597412563);

-- --------------------------------------------------------

--
-- Table structure for table `scheduledby`
--

DROP TABLE IF EXISTS `scheduledby`;
CREATE TABLE IF NOT EXISTS `scheduledby` (
  `mid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mid`,`pid`,`date`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scheduledby`
--

INSERT INTO `scheduledby` (`mid`, `pid`, `date`) VALUES
(1, 1, '2019-04-30 17:43:24'),
(1, 1, '2019-04-30 17:43:26');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `picnic` (`pid`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `customers` (`cid`),
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`rid`) REFERENCES `credit` (`rid`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `manager` (`mid`);

--
-- Constraints for table `scheduledby`
--
ALTER TABLE `scheduledby`
  ADD CONSTRAINT `scheduledby_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `manager` (`mid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
