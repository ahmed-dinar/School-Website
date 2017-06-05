-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2017 at 04:23 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_bsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE IF NOT EXISTS `administration` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(100) NOT NULL,
  `t_designation` int(3) NOT NULL,
  `t_qualification` varchar(200) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `t_phn` varchar(30) NOT NULL,
  `t_mail` varchar(100) NOT NULL,
  `t_img` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `position2` varchar(2) NOT NULL,
  `address` text NOT NULL,
  `about` text NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`t_id`, `t_name`, `t_designation`, `t_qualification`, `subject`, `t_phn`, `t_mail`, `t_img`, `position`, `position2`, `address`, `about`) VALUES
(1, 'Omar Hasan', 3, 'BSC Eng in CSE', 'IT', '01765708783', 'omar@gmail.com', '1.jpg', 'Assistant Teacher', 'T', 'Jessore', 'Hy'),
(2, 'Omar Hasan', 1, 'BSC Eng in CSE', 'IT', '01765708783', 'omar@gmail.com', '2.jpg', 'Principal', 'T', 'Jessore', 'This is text'),
(3, 'Kamal Hasan', 2, 'BSC Eng in CSE', 'IT', '01765708783', 'omar@gmail.com', '3.jpg', 'Assistant Head Master', 'T', 'Khulna', 'This is kamal'),
(4, 'à¦†à¦¬à§à¦¦à§à¦² à¦†à¦²à¦®', 2, 'à¦…à¦¨à¦¾à¦‰à¦°à¦¸', 'à¦¬à¦¾à¦‚à¦²à¦¾', '01765708783', 'omar@gmail.com', '4.jpg', 'Assistant Teacher', 'T', 'à¦¯à§‹à¦¶à¦°à§‡ ', 'à¦†à¦®à¦¿ à¦†à¦²à¦¾à¦®'),
(5, 'Abdul Kader', 2, 'Hons', '', '01765708783', 'omar@gmail.com', '5.jpg', 'à¦…à¦«à¦¿à¦¸ à¦¸à¦¹à¦•à¦¾à¦°à§€ ', 'S', 'Jessore', 'This is kader'),
(6, 'à¦†à¦¬à§à¦¦à§à¦² à¦†à¦²à¦®', 1, 'SSC', '', '01765708783', 'omar@gmail.com', '6.jpg', 'à¦¸à¦¹à¦•à¦¾à¦°à§€ à¦—à§à¦°à¦¨à§à¦¥à¦¾à¦—à¦¾à¦°à', 'S', 'à¦¯à§‹à¦¶à¦°à§‡', 'This is abdul'),
(7, 'Pantho', 3, 'Hons', '', '01765708783', 'omar@gmail.com', '7.jpg', 'à¦…à¦­à¦¿à¦­à¦¾à¦¬à¦• à¦¸à¦¦à¦¸à§à¦¯', 'E', 'Jessore', 'This is Pantho'),
(8, 'Borua Thakur', 2, 'BSC Eng in CSE', '', '01765708783', 'omar@gmail.com', 'blank-profile.png', 'à¦¸à¦šà¦¿à¦¬', 'E', 'Jessore', ''),
(10, 'Abul Sheikh', 3, 'Hons', 'English', '01765708783', 'omarhasan@gmail.com', '10.jpg', 'Assistant Teacher', 'T', 'Khulna', 'hy'),
(11, 'Anupoma', 3, 'Hons', 'Religion', '01765708783', 'omar@gmail.com', 'blank-profile.png', 'Assistant Teacher', 'T', 'Jessore', 'This is anupoma');

-- --------------------------------------------------------

--
-- Table structure for table `alumnai`
--

CREATE TABLE IF NOT EXISTS `alumnai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `present_address` varchar(80) NOT NULL,
  `parmanent_address` varchar(80) NOT NULL,
  `current_status` varchar(30) NOT NULL,
  `group` varchar(15) NOT NULL,
  `current_org` varchar(50) NOT NULL,
  `about` text NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `img` varchar(11) NOT NULL,
  `fb_link` varchar(256) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(32) NOT NULL,
  `tokenExpire` TIMESTAMP NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '0',
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `hide_phone` TINYINT(1) NOT NULL DEFAULT '0',
  `hide_email` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


INSERT INTO `alumnai` (`name`, `passing_year`,`group`,`email`,`phone`,`img`,`password`,`salt`,`status`) VALUES
  ('Example Name 1','1965','Science','example1@gmail.com','01733333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '1'),
  ('Example Name 2','1995','Science','example2@gmail.com','01833333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '1'),
  ('Example Name 3','1975','Commerce','example3@gmail.com','01933333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '1'),
  ('Example Name 4','1975','Science','example4@gmail.com','01633333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '2'),
  ('Example Name 5','1980','Science','example5@gmail.com','01753333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '1'),
  ('Example Name 6','1980','Commerce','example6@gmail.com','01853333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '2'),
  ('Example Name 7','1980','Science','example7@gmail.com','01953333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '2'),
  ('Example Name 8','1973','Humanities','example8@gmail.com','01653333333','', '724ad26737a12d566f598af7d1961f311ec89a19cd9124a9e5908664a65c3cc7', '±«ñIÿû«íÔCŸi=¬\Z¼S\0vœ¼˜„¤+†ž†üN', '2');



CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


INSERT INTO `admin` (`username`, `password`,`salt`) VALUES
  ('admin', 'b90186d1a27cc09ef40c21cec20a3b5f737c936a8170cf712394c2448edcc093', 'ä2kvR•íñÃôµîÞR÷¤XñÎ1fÝõÙi%');


CREATE TABLE IF NOT EXISTS `academic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `class` TINYINT(3) NOT NULL,
  `group` varchar(20) NOT NULL,
  `file` varchar(100) NOT NULL,
  `year` YEAR(4) NOT NULL,
  `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `content` TEXT NOT NULL,
  `img` varchar(11) NOT NULL,
  `posted` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `post_date` VARCHAR(15) NOT NULL,
  `event_title` varchar(500) NOT NULL,
  `event` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `post_date`, `event_title`, `event`) VALUES
(1, '0000-00-00', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦¯à¦¶à§‹à¦° à¦œà§‡à¦²à¦¾à¦° à¦¸à¦¦à¦° à¦‰à¦ªà¦œà§‡à¦²à¦¾à¦° à¦¬à¦¸à§à¦¨à§à¦¦à¦¿à§Ÿà¦¾ à¦¬à¦¾à¦œà¦¾à¦°à§‡à¦° à¦ªà¦¾à¦¶à§‡ --- à¦à¦•à¦° à¦œà¦®à¦¿à¦° à¦‰à¦ªà¦° à¦¬à¦¿à¦¦à§à¦¯à¦¾à¦²à¦¯à¦¼à§‡ à¦ªà§à¦°à¦¤à¦¿à¦·à§à¦ à¦¿à¦¤à¥¤ \r\nà¦¬à¦¿à¦¦à§à¦¯à¦¾à¦²à¦¯à¦¼à§‡ ---à¦¤à¦²à¦¾ à¦ªà§à¦°à¦¶à¦¾à¦¸à¦¨à¦¿à¦• à¦­à¦¬à¦¨à¦¸à¦¹ à¦®à§‹à¦Ÿ------à¦Ÿà¦¿ à¦ªà§ƒà¦¥à¦• à¦­à¦¬à¦¨ à¦°à¦¯à¦¼à§‡à¦›à§‡à¥¤ à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯ à¦‰à¦²à§à¦²à§‡à¦–à¦¯à§‹à¦—à§à¦¯ à¦…à¦¬à¦•à¦¾à¦ à¦¾à¦®à§‹à¦° à¦®à¦§à§à¦¯à§‡ à¦†à¦›à§‡ à§§à¦Ÿà¦¿ à¦›à¦¾à¦¤à§à¦°à¦¾à¦¬à¦¾à¦¸, à§§à¦Ÿà¦¿ à¦®à¦¸à¦œà¦¿à¦¦, 1à¦Ÿà¦¿ à¦–à§‡à¦²à¦¾à¦° à¦®à¦¾à¦ ,  1à¦Ÿà¦¿ à¦ªà§à¦•à§à¦°à¥¤\r\n'),
(2, '0000-00-00', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤'),
(4, '0000-00-00', 'Type Event Title: (Use Bangla or English, Within two lines will be bettre)', 'Type Event Title: (Use Bangla or English, Within two lines will be bettre)Type Event Title: (Use Bangla or English, Within two lines will be bettre)Type Event Title: (Use Bangla or English, Within two lines will be bettre)'),
(5, '0000-00-00', 'This is a Title of Event.This is a Title of Event.This is a Title of Event', 'This is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of EventThis is a Title of Event');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `img_file` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `img_file`) VALUES
(1, 'This is a title', '1.PNG'),
(2, 'My Image', '2.PNG'),
(4, 'This is Image caption', '4.PNG'),
(5, 'My image', '5.jpg'),
(6, 'Awesome Image', '6.jpg'),
(7, 'My Imahe', '7.jpg'),
(8, 'This is caption', '8.jpg'),
(12, 'This is image', '12.jpg'),
(13, 'This is image', '13.jpg'),
(14, 'This is image', '14.jpg'),
(15, 'This is img', '15.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `local_result`
--

CREATE TABLE IF NOT EXISTS `local_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `result_year` int(5) NOT NULL,
  `publish_date` VARCHAR(15) NOT NULL,
  `file` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE IF NOT EXISTS `noticeboard` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_date` varchar(30) NOT NULL,
  `notice_title` varchar(500) NOT NULL,
  `notice` text NOT NULL,
  `file_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `noticeboard`
--

INSERT INTO `noticeboard` (`id`, `post_date`, `notice_title`, `notice`, `file_name`) VALUES
(1, '14-04-2017', 'Hello World Hello World Hello World Hello World Hello World', 'Hello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello World', ''),
(2, '14-04-2017', 'Hello World Hello World Hello World Hello World Hello World', 'Hello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello WorldHello World Hello World Hello World Hello World Hello World', ''),
(3, '14-04-2017', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', ''),
(4, '14-04-2017', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', ''),
(5, '14-04-2017', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', ''),
(6, '14-04-2017', 'dsfffsggs', 'dsfffsggsdsfffsggsvdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggsdsfffsggs', '6.pdf'),
(7, '14-04-2017', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', 'à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤à¦†à¦—à¦¾à¦®à§€ à¦•à¦¾à¦² à¦†à¦®à¦°à¦¾ à¦à¦•à¦Ÿà¦¿ à¦«à§à¦Ÿ à¦¬à¦² à¦ªà§à¦°à¦¤à¦¿à¦¯à§‹à¦—à¦¿à¦¤à¦¾ à¦†à¦‡à§Ÿà¦œà¦¨ à¦•à¦°à§‡à¦›à¦¿à¥¤', ''),
(8, '26-04-2017', 'Hello World Hello World Hello World Hello World Hello World....Read More', 'Hello World Hello World Hello World Hello World Hello World....Read MoreHello World Hello World Hello World Hello World Hello World....Read MoreHello World Hello World Hello World Hello World Hello World....Read More', '');

-- --------------------------------------------------------

--
-- Table structure for table `result_public`
--

CREATE TABLE IF NOT EXISTS `result_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_name` varchar(10) NOT NULL,
  `exam_priority` int(5) NOT NULL,
  `group` varchar(20) NOT NULL,
  `result_year` int(8) NOT NULL,
  `file_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `result_public`
--

INSERT INTO `result_public` (`id`, `exam_name`, `exam_priority`, `group`, `result_year`, `file_name`) VALUES
(4, 'HSC', 3, 'Arts', 2016, '4.pdf'),
(5, 'HSC', 2, 'Commerce', 2016, '5.pdf'),
(6, 'HSC', 1, 'Science', 2016, '6.pdf'),
(7, 'HSC', 2, 'Commerce', 2017, '7.pdf'),
(8, 'HSC', 1, 'Science', 2017, '8.pdf'),
(9, 'HSC', 3, 'Arts', 2017, '9.pdf'),
(10, 'SSC', 1, 'Science', 2017, '10.pdf'),
(11, 'SSC', 2, 'Commerce', 2017, '11.pdf'),
(12, 'SSC', 3, 'Arts', 2017, '12.pdf'),
(13, 'SSC', 2, 'Commerce', 2018, '13.pdf'),
(14, 'SSC', 3, 'Arts', 2018, '14.pdf'),
(15, 'SSC', 1, 'Science', 2018, '15.pdf'),
(19, 'HSC', 1, 'Science', 2015, '19.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` int(3) NOT NULL,
  `classString` int(3) NOT NULL,
  `section` VARCHAR(2) NOT NULL,
  `ac_year` VARCHAR(6) NOT NULL,
  `file` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
