-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2018 at 08:50 PM
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
-- Table structure for table `blindtest_answers`
--

DROP TABLE IF EXISTS `blindtest_answers`;
CREATE TABLE IF NOT EXISTS `blindtest_answers` (
  `music_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  PRIMARY KEY (`music_id`,`choice_id`),
  KEY `ma_choice_FK` (`choice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blindtest_possesses`
--

DROP TABLE IF EXISTS `blindtest_possesses`;
CREATE TABLE IF NOT EXISTS `blindtest_possesses` (
  `music_style_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`music_style_id`,`music_id`),
  KEY `blindtest_possesses_music0_FK` (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

DROP TABLE IF EXISTS `choice`;
CREATE TABLE IF NOT EXISTS `choice` (
  `choice_id` int(11) NOT NULL AUTO_INCREMENT,
  `choice_name` varchar(50) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`choice_id`),
  UNIQUE KEY `ui1_music_choice_name` (`music_id`,`choice_name`)
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
  `music_cover` text NOT NULL,
  PRIMARY KEY (`music_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`music_id`, `music_title`, `music_description`, `music_file`, `music_cover`) VALUES
(1, '24K Magic', 'Bruno Mars', 'root-24K Magic.mp3', '24K Magic-bruno-mars-24k-magic');

-- --------------------------------------------------------

--
-- Table structure for table `music_style`
--

DROP TABLE IF EXISTS `music_style`;
CREATE TABLE IF NOT EXISTS `music_style` (
  `music_style_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_style` varchar(50) NOT NULL,
  PRIMARY KEY (`music_style_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE IF NOT EXISTS `parameters` (
  `parameters_id` int(11) NOT NULL AUTO_INCREMENT,
  `parameters_time` int(11) NOT NULL,
  `parameters_questions_number` int(11) NOT NULL,
  `parameters_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`parameters_id`),
  KEY `parameters_users_FK` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_date` date NOT NULL,
  `score` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`score_id`),
  KEY `score_music_FK` (`music_id`),
  KEY `score_users0_FK` (`user_id`)
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
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_nickname` (`user_nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_nickname`, `user_email`, `user_password`, `user_profilepic`, `user_status`) VALUES
(1, 'root', 'root', 'root@admin.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, 1),
(2, 'guess', 'guess', 'guess@guess.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'guess-ApplicationFrameHost_2018-06-05_13-46-49.png', 0),
(3, 'test', 'test', 'test@test.com', '1161e6ffd3637b302a5cd74076283a7bd1fc20d3', NULL, 0),
(4, 'user4', 'user4', 'user4@user.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, 0),
(5, 'user5', 'user5', 'user5@user.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, 0),
(6, 'user6', 'user6', 'user6@user.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, 0),
(7, 'user7', 'user7', 'user7@user.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user7-1510755737.jpg', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blindtest_answers`
--
ALTER TABLE `blindtest_answers`
  ADD CONSTRAINT `ma_choice_FK` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`),
  ADD CONSTRAINT `ma_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`);

--
-- Constraints for table `blindtest_possesses`
--
ALTER TABLE `blindtest_possesses`
  ADD CONSTRAINT `blindtest_possesses_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_possesses_music_style_FK` FOREIGN KEY (`music_style_id`) REFERENCES `music_style` (`music_style_id`);

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`);

--
-- Constraints for table `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `score_users0_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
