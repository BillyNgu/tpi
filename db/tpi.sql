-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 06 juin 2018 à 11:15
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
-- Structure de la table `blindtest_possesses`
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
-- Structure de la table `music_style`
--

DROP TABLE IF EXISTS `music_style`;
CREATE TABLE IF NOT EXISTS `music_style` (
  `music_style_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_style` varchar(50) NOT NULL,
  PRIMARY KEY (`music_style_id`)
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
  `quizz_question` varchar(50) NOT NULL,
  PRIMARY KEY (`quizz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_date` date NOT NULL,
  `score` int(11) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`score_id`),
  KEY `score_quizz_FK` (`quizz_id`),
  KEY `score_users0_FK` (`user_id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
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
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blindtest_contains`
--
ALTER TABLE `blindtest_contains`
  ADD CONSTRAINT `blindtest_contains_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_contains_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`);

--
-- Contraintes pour la table `blindtest_possesses`
--
ALTER TABLE `blindtest_possesses`
  ADD CONSTRAINT `blindtest_possesses_music0_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`),
  ADD CONSTRAINT `blindtest_possesses_music_style_FK` FOREIGN KEY (`music_style_id`) REFERENCES `music_style` (`music_style_id`);

--
-- Contraintes pour la table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`);

--
-- Contraintes pour la table `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_quizz_FK` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`quizz_id`),
  ADD CONSTRAINT `score_users0_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
