-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 05 juin 2018 à 13:56
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tpi`
--
CREATE DATABASE IF NOT EXISTS `tpi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tpi`;

-- --------------------------------------------------------

--
-- Structure de la table `blindtest_contains`
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
-- Structure de la table `choice`
--

DROP TABLE IF EXISTS `choice`;
CREATE TABLE IF NOT EXISTS `choice` (
  `choice_id` int(11) NOT NULL AUTO_INCREMENT,
  `choice` varchar(50) NOT NULL,
  `choice_is_answer` tinyint(1) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  PRIMARY KEY (`choice_id`),
  KEY `choice_quizz_FK` (`quizz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `music_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_title` varchar(50) NOT NULL,
  `music_description` varchar(50) NOT NULL,
  `music_file` text NOT NULL,
  `music_cover` text NOT NULL,
  PRIMARY KEY (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `music_type`
--

DROP TABLE IF EXISTS `music_type`;
CREATE TABLE IF NOT EXISTS `music_type` (
  `music_style_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_style` varchar(50) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`music_style_id`),
  KEY `music_type_music_FK` (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parameters`
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
-- Structure de la table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE IF NOT EXISTS `quizz` (
  `quizz_id` int(11) NOT NULL AUTO_INCREMENT,
  `quizz_date` date NOT NULL,
  `quizz_score` int(11) NOT NULL,
  `quizz_question` varchar(50) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  PRIMARY KEY (`quizz_id`),
  KEY `quizz_parameters_FK` (`parameters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blindtest_contains`
--
ALTER TABLE `blindtest_contains`
  ADD CONSTRAINT `blindtest_contains_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_contains_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`);

--
-- Contraintes pour la table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`);

--
-- Contraintes pour la table `music_type`
--
ALTER TABLE `music_type`
  ADD CONSTRAINT `music_type_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`);

--
-- Contraintes pour la table `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD CONSTRAINT `quizz_parameters_FK` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`parameters_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
