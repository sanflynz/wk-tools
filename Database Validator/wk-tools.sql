-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2016 at 05:53 AM
-- Server version: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wk_databases`
--
CREATE DATABASE IF NOT EXISTS `wk_databases` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wk_databases`;

-- --------------------------------------------------------

--
-- Table structure for table `email_chk`
--

CREATE TABLE IF NOT EXISTS `email_chk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table` varchar(20) NOT NULL,
  `table_id` int(10) NOT NULL,
  `hasEmail` enum('0','1') NOT NULL,
  `formatOK` enum('0','1') NOT NULL,
  `domainOK` enum('0','1') NOT NULL,
  `checkOK` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39960 ;
--
-- Database: `wk_ees`
--
CREATE DATABASE IF NOT EXISTS `wk_ees` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wk_ees`;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `anz_sfdc_contact_id` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`anz_sfdc_contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `List` enum('0','1') NOT NULL DEFAULT '0',
  `Delivered` enum('0','1') NOT NULL DEFAULT '0',
  `Opened` enum('0','1') NOT NULL DEFAULT '0',
  `Clicked` enum('0','1') NOT NULL DEFAULT '0',
  `Softbounce` enum('0','1') NOT NULL DEFAULT '0',
  `Hardbounce` enum('0','1') NOT NULL DEFAULT '0',
  `Unsubscribed` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`List`, `Delivered`, `Opened`, `Clicked`, `Softbounce`, `Hardbounce`, `Unsubscribed`) VALUES
('0', '0', '0', '0', '0', '0', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
