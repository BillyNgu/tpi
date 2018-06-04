-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2018 at 02:55 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpi`
--
CREATE DATABASE IF NOT EXISTS `tpi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tpi`;

-- --------------------------------------------------------

--
-- Table structure for table `blindtest_contains`
--

DROP TABLE IF EXISTS `blindtest_contains`;
CREATE TABLE IF NOT EXISTS `blindtest_contains` (
  `quizz_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`quizz_id`,`music_id`),
  KEY `blindtest_contains_music0_FK` (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blindtest_defines`
--

DROP TABLE IF EXISTS `blindtest_defines`;
CREATE TABLE IF NOT EXISTS `blindtest_defines` (
  `user_id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`parameters_id`),
  KEY `blindtest_defines_parameters0_FK` (`parameters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `music_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_title` varchar(50) NOT NULL,
  `music_description` varchar(50) NOT NULL,
  `music_file` text NOT NULL,
  `music_cover` blob NOT NULL,
  PRIMARY KEY (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `music_type`
--

DROP TABLE IF EXISTS `music_type`;
CREATE TABLE IF NOT EXISTS `music_type` (
  `music_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_type` varchar(50) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`music_type_id`),
  KEY `music_type_music_FK` (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE IF NOT EXISTS `parameters` (
  `parameters_id` int(11) NOT NULL AUTO_INCREMENT,
  `parameters_name` varchar(50) NOT NULL,
  PRIMARY KEY (`parameters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE IF NOT EXISTS `quizz` (
  `quizz_id` int(11) NOT NULL AUTO_INCREMENT,
  `quizz_date` date NOT NULL,
  `quizz_score` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  PRIMARY KEY (`quizz_id`),
  KEY `quizz_parameters_FK` (`parameters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_nickname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_profilepic` text,
  `user_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blindtest_contains`
--
ALTER TABLE `blindtest_contains`
  ADD CONSTRAINT `blindtest_contains_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_contains_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`);

--
-- Constraints for table `blindtest_defines`
--
ALTER TABLE `blindtest_defines`
  ADD CONSTRAINT `blindtest_defines_parameters0_FK` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`parameters_id`),
  ADD CONSTRAINT `blindtest_defines_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `music_type`
--
ALTER TABLE `music_type`
  ADD CONSTRAINT `music_type_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`);

--
-- Constraints for table `quizz`
--
ALTER TABLE `quizz`
  ADD CONSTRAINT `quizz_parameters_FK` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`parameters_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
