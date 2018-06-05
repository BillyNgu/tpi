-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 05 juin 2018 à 11:18
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
-- Structure de la table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `music_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_title` varchar(50) NOT NULL COMMENT 'Title of the song',
  `music_description` varchar(50) NOT NULL COMMENT 'Description of the song',
  `music_file` text NOT NULL COMMENT 'The directory of the file',
  `music_cover` blob NOT NULL COMMENT 'The cover of the song',
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
  `parameters_time` int(11) NOT NULL COMMENT 'The time in second',
  `parameters_questions` int(11) NOT NULL COMMENT 'The number of questions',
  `parameters_type` int(11) NOT NULL COMMENT '1 -> image, 2 -> song, 3 -> both',
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
  `quizz_date` date NOT NULL COMMENT 'Date of the day of the quizz',
  `quizz_score` int(11) NOT NULL COMMENT 'The score got during the quizz',
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
  `user_name` varchar(50) NOT NULL COMMENT 'Name of the user',
  `user_nickname` varchar(50) NOT NULL COMMENT 'Nickname of the user',
  `user_email` varchar(50) NOT NULL COMMENT 'Email of the user',
  `user_password` varchar(50) NOT NULL COMMENT 'Password of the user',
  `user_profilepic` text NOT NULL COMMENT 'Profile picture of the user (dir)',
  `user_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_nickname` (`user_nickname`,`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_nickname`, `user_email`, `user_password`, `user_profilepic`, `user_status`) VALUES
(1, 'root', 'root', 'root@admin.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'root-WWDTM_logo_clr_stacked_highres.jpg', 1),
(2, 'guess', 'guess', 'guess@guess.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'guess-blindtest.png', 0),
(3, 'test', 'test', 'test@test.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'test-loginformatique_dir_couleur.png', 0);

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
-- Contraintes pour la table `music_style`
--
ALTER TABLE `music_style`
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
