-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 11, 2018 at 05:48 AM
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
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `music_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_title` varchar(50) NOT NULL,
  `music_author` varchar(50) NOT NULL,
  `music_file` text,
  `music_cover` text,
  PRIMARY KEY (`music_id`),
  UNIQUE KEY `music_title` (`music_title`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`music_id`, `music_title`, `music_author`, `music_file`, `music_cover`) VALUES
(1, '24K Magic', 'Bruno Mars', '1-24K Magic.mp3', '1-bruno-mars-24k-magic.jpg'),
(2, 'Billie Jean', 'Michael Jackson', '2-Billie Jean.mp3', '2-s-l300.jpg'),
(3, 'Beat It', 'Michael Jackson', '3-Beat It.mp3', '3-beat it.jpg'),
(4, 'Smooth Criminal', 'Michael Jackson', '4-Smooth Criminal.mp3', '4-Smooth_Criminal.jpg'),
(5, 'We Are The World', 'Michael Jackson', '5-We Are The World (Demo).mp3', '5-Interesting-Facts-About-We-Are-the-World.jpg'),
(6, 'Maps', 'Maroon 5', '6-Maps.mp3', '6-maps_maroon5.jpg'),
(7, 'Cold feat. Future', 'Maroon 5', '7-Cold feat. Future.mp3', ''),
(8, 'Chandelier', 'Sia', '8-Chandelier.mp3', '8-Sia-Chandelier.jpg'),
(9, 'Animals', 'Maroon 5', '9-Animals.mp3', ''),
(10, 'Payphone feat. Wiz Khalifa', 'Maroon 5', '10-Payphone (feat. Wiz Khalifa).mp3', ''),
(11, 'Feelings', 'Maroon 5', '11-Feelings.mp3', ''),
(12, 'Moves Like Jagger feat. Christina Aguilera', 'Maroon 5', '12-Moves Like Jagger (feat. Christina Aguilera).mp3', ''),
(13, 'That&#39;s What I Like', 'Bruno Mars', '13-That’s What I Like.mp3', ''),
(14, 'Numb', 'Linkin Park', '14-Numb.mp3', ''),
(15, 'In The End', 'Linkin Park', '15-In The End.mp3', ''),
(16, 'Talking to Myself', 'Linkin Park', '16-Talking to Myself.mp3', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`parameters_id`, `parameters_time`, `parameters_questions_number`, `parameters_type`, `user_id`) VALUES
(1, 30, 10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

DROP TABLE IF EXISTS `party`;
CREATE TABLE IF NOT EXISTS `party` (
  `party_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`party_id`,`user_id`,`music_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_music_id` (`music_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`score_id`),
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_nickname`, `user_email`, `user_password`, `user_profilepic`, `user_status`) VALUES
(1, 'root', 'root', 'root@admin.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'root-blindtest.png', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blindtest_possesses`
--
ALTER TABLE `blindtest_possesses`
  ADD CONSTRAINT `blindtest_possesses_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_possesses_music_style_FK` FOREIGN KEY (`music_style_id`) REFERENCES `music_style` (`music_style_id`);

--
-- Constraints for table `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_users0_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
