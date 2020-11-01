-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2020 at 08:01 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zebraci`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `studentId`, `date`, `time`) VALUES
(1, 1, '2020-10-16', '16:23:50'),
(2, 1, '2020-10-17', '01:32:26'),
(3, 5, '2020-10-17', '07:01:39'),
(4, 7, '2020-10-17', '07:45:11'),
(5, 6, '2020-10-17', '07:53:28'),
(6, 11, '2020-10-17', '07:54:13'),
(7, 12, '2020-10-17', '07:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfid` text NOT NULL,
  `swinId` text NOT NULL,
  `fullname` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `rfid`, `swinId`, `fullname`) VALUES
(1, '123456799', '100085175', 'JOHN DOE'),
(3, '123456790', '100086125', 'JOHN DOE'),
(4, '123456791', '100086129', 'JOHN DOE'),
(5, '1234567', '100086125', 'JOHN DOE'),
(6, '123456777', '100086125', 'JOHN DOE'),
(12, '123456789', '100085175', 'KAVEEJA PRAVEEN JAYAKODY');

-- --------------------------------------------------------

--
-- Table structure for table `tbltoken`
--

CREATE TABLE IF NOT EXISTS `tbltoken` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `token` text NOT NULL,
  `username` text NOT NULL,
  `expireTime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbltoken`
--

INSERT INTO `tbltoken` (`id`, `token`, `username`, `expireTime`) VALUES
(1, 'TVRZd01qUXlOelkwTlN3M05qWTJNemN3TlRNPQ==', '766637053', 1602427645),
(2, 'TVRZd01qUXlOemczTUN3M05qWTJNemN3TlRNPQ==', '766637053', 1602427870),
(3, 'TVRZd01qUXlPREV4Tml3M05qWTJNemN3TlRJPQ==', '766637052', 1602428116),
(4, 'TVRZd01qUXpOekV6TkN3M05qWTJNemN3TlRJPQ==', '766637052', 1602437134),
(5, 'TVRZd01qUXpOelkzTUN4aFpHMXBiZz09', 'admin', 1602437670),
(6, 'TVRZd01qUXpOemN3Tnl4aFpHMXBiZz09', 'admin', 1602437707),
(7, 'TVRZd01qUTJPVFUyTWl3M05qWTJNemN3TlRJPQ==', '766637052', 1602469562),
(8, 'TVRZd01qUTJPVGc0TVN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469881),
(9, 'TVRZd01qUTJPVGt5TVN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469921),
(10, 'TVRZd01qUTJPVGswTlN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469945),
(11, 'TVRZd01qVXhORE0xT1N4aFpHMXBiZz09', 'admin', 1602514359),
(12, 'TVRZd05UUXlOVEE1T0N4aFpHMXBiZz09', 'admin', 1605425098),
(13, 'TVRZd05qZzBNek0xTml4aFpHMXBiZz09', 'admin', 1606843356),
(14, 'TVRZd05qZzBPRE15T1N4emQybHU=', 'swin', 1606848329);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the user',
  `activated` int(11) NOT NULL DEFAULT '0' COMMENT '1 if active; 0 if not',
  `email` varchar(20) NOT NULL COMMENT 'Email of the user (unique)',
  `password` varchar(255) NOT NULL COMMENT 'Hash of the password',
  `fullname` varchar(200) NOT NULL COMMENT 'Human readable full name',
  `rawPassword` text NOT NULL COMMENT 'DEBUG ONLY',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '0 for admin and 1 for user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `activated`, `email`, `password`, `fullname`, `rawPassword`, `type`) VALUES
(1, 1, 'swin', '$2y$10$p.PoHwvmmni2xxcI70WtQu3yF1cQoFx3W8Qfs1G4zATtDqYU9qkwa', 'Administrator', 'decrease', 0),
(2, 1, '766637052', '$2y$10$p.PoHwvmmni2xxcI70WtQu3yF1cQoFx3W8Qfs1G4zATtDqYU9qkwa', 'Praveen Jayakody', '', 2),
(11, 0, '766637056', '$2y$10$rZXNuUaxNMqekAYj3AMbfeFECRNCkVwSjtZDxwJcXt3UcMvHcg1xa', 'Mail Example', '', 1),
(12, 1, '766637052', '$2y$10$Icx296pO7PNy6icSSA1Fu.KCtiVImUK95ZSPGk0f9Z9VfgHXw27xS', 'Praveen Jayakody', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE IF NOT EXISTS `verify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` int(6) NOT NULL,
  `username` text NOT NULL,
  `expireTime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
