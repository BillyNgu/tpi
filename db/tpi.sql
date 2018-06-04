-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 04 juin 2018 à 08:23
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

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
CREATE TABLE `blindtest_contains` (
  `quizz_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blindtest_defines`
--

DROP TABLE IF EXISTS `blindtest_defines`;
CREATE TABLE `blindtest_defines` (
  `user_id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE `music` (
  `music_id` int(11) NOT NULL,
  `music_title` varchar(50) NOT NULL,
  `music_description` varchar(50) NOT NULL,
  `music_file` text NOT NULL,
  `music_cover` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `music_type`
--

DROP TABLE IF EXISTS `music_type`;
CREATE TABLE `music_type` (
  `music_type_id` int(11) NOT NULL,
  `music_type` varchar(50) NOT NULL,
  `music_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters` (
  `parameters_id` int(11) NOT NULL,
  `parameters_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE `quizz` (
  `quizz_id` int(11) NOT NULL,
  `quizz_date` date NOT NULL,
  `quizz_score` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_nickname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_profilepic` blob NOT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blindtest_contains`
--
ALTER TABLE `blindtest_contains`
  ADD PRIMARY KEY (`quizz_id`,`music_id`),
  ADD KEY `blindtest_contains_music0_FK` (`music_id`);

--
-- Index pour la table `blindtest_defines`
--
ALTER TABLE `blindtest_defines`
  ADD PRIMARY KEY (`user_id`,`parameters_id`),
  ADD KEY `blindtest_defines_parameters0_FK` (`parameters_id`);

--
-- Index pour la table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`music_id`);

--
-- Index pour la table `music_type`
--
ALTER TABLE `music_type`
  ADD PRIMARY KEY (`music_type_id`),
  ADD KEY `music_type_music_FK` (`music_id`);

--
-- Index pour la table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`parameters_id`);

--
-- Index pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD PRIMARY KEY (`quizz_id`),
  ADD KEY `quizz_parameters_FK` (`parameters_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `music`
--
ALTER TABLE `music`
  MODIFY `music_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `music_type`
--
ALTER TABLE `music_type`
  MODIFY `music_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `parameters_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `quizz`
--
ALTER TABLE `quizz`
  MODIFY `quizz_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
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
-- Contraintes pour la table `blindtest_defines`
--
ALTER TABLE `blindtest_defines`
  ADD CONSTRAINT `blindtest_defines_parameters0_FK` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`parameters_id`),
  ADD CONSTRAINT `blindtest_defines_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `music_type`
--
ALTER TABLE `music_type`
  ADD CONSTRAINT `music_type_music_FK` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`);

--
-- Contraintes pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD CONSTRAINT `quizz_parameters_FK` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`parameters_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
