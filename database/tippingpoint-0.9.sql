-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2011 at 09:40 PM
-- Server version: 5.0.92
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `polaris_wtbal`
--

-- --------------------------------------------------------

--
-- Table structure for table `aircraft`
--

CREATE TABLE IF NOT EXISTS `aircraft` (
  `id` int(11) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default '1',
  `tailnumber` char(25) NOT NULL,
  `makemodel` char(50) NOT NULL,
  `emptywt` float NOT NULL,
  `emptycg` float NOT NULL,
  `maxwt` float NOT NULL,
  `cglimits` char(60) NOT NULL,
  `cgwarnfwd` float NOT NULL,
  `cgwarnaft` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `aircraft_cg`
--

CREATE TABLE IF NOT EXISTS `aircraft_cg` (
  `id` int(11) NOT NULL auto_increment,
  `tailnumber` int(11) NOT NULL,
  `arm` float NOT NULL,
  `weight` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `aircraft_weights`
--

CREATE TABLE IF NOT EXISTS `aircraft_weights` (
  `id` int(11) NOT NULL auto_increment,
  `tailnumber` int(11) NOT NULL,
  `order` smallint(3) NOT NULL,
  `item` char(50) NOT NULL,
  `weight` float NOT NULL,
  `arm` float NOT NULL,
  `emptyweight` enum('true','false') NOT NULL default 'false',
  `fuel` enum('true','false') NOT NULL default 'false',
  `fuelwt` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) NOT NULL auto_increment,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `who` char(24) NOT NULL,
  `what` varchar(32768) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=293 ;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL auto_increment,
  `item` char(30) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` char(24) NOT NULL,
  `password` char(24) NOT NULL,
  `name` char(48) NOT NULL,
  `email` char(48) NOT NULL,
  `superuser` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
