-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 30 Mai 2022 à 15:55
-- Version du serveur :  10.3.31-MariaDB-0+deb10u1
-- Version de PHP :  7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdd_shinegg`
--

-- --------------------------------------------------------

--
-- Structure de la table `entry`
--

CREATE TABLE `entry` (
  `entry_id` int(20) NOT NULL,
  `tournament_id` int(20) NOT NULL,
  `player_id` int(20) NOT NULL,
  `placement` int(5) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `entry`
--

INSERT INTO `entry` (`entry_id`, `tournament_id`, `player_id`, `placement`, `status`) VALUES
(1, 1, 1, 0, 1),
(2, 1, 2, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `match_id` int(20) NOT NULL,
  `tournament_id` int(20) NOT NULL,
  `player1_id` int(20) NOT NULL,
  `player1_score` int(2) NOT NULL DEFAULT 0,
  `player1_agreement` int(1) NOT NULL DEFAULT 0,
  `player2_id` int(20) NOT NULL,
  `player2_score` int(2) NOT NULL DEFAULT 0,
  `player2_agreement` int(1) NOT NULL DEFAULT 0,
  `score_max` int(1) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `match`
--

INSERT INTO `match` (`match_id`, `tournament_id`, `player1_id`, `player1_score`, `player1_agreement`, `player2_id`, `player2_score`, `player2_agreement`, `score_max`) VALUES
(1, 1, 1, 3, 1, 2, 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(20) NOT NULL,
  `owner_id` int(5) NOT NULL,
  `tournament_picture` char(180) DEFAULT NULL,
  `region` char(20) NOT NULL DEFAULT 'US_EC',
  `online` tinyint(1) NOT NULL DEFAULT 1,
  `price` float NOT NULL DEFAULT 0,
  `debut_date` date NOT NULL,
  `max_participants` int(4) NOT NULL DEFAULT 48
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `tournaments`
--

INSERT INTO `tournaments` (`id`, `owner_id`, `tournament_picture`, `region`, `online`, `price`, `debut_date`, `max_participants`) VALUES
(1, 0, 'https://pbs.twimg.com/profile_images/979421865503424512/QMTKhLWZ_400x400.jpg', 'US_EC', 1, 0, '2022-05-18', 16);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `name` char(40) NOT NULL DEFAULT '',
  `region` char(20) NOT NULL DEFAULT 'US_EC',
  `main_char` varchar(20) DEFAULT NULL,
  `profile_picture` char(180) DEFAULT NULL,
  `password` text NOT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `region`, `main_char`, `profile_picture`, `password`, `bio`) VALUES
(1, 'Firquen', 'EU', NULL, 'https://pbs.twimg.com/media/FSwMJzNXsAAHYer.jpg', 'passwordtrèscompliqué', NULL),
(2, 'Namu', 'EU', NULL, 'https://cdn.discordapp.com/attachments/556553671501021194/962312307415871528/1577619071292.png', 'pi', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `tournament_id` (`tournament_id`),
  ADD KEY `entry_ibfk_3` (`player_id`);

--
-- Index pour la table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `player1_id` (`player1_id`),
  ADD KEY `player2_id` (`player2_id`),
  ADD KEY `tournament_id` (`tournament_id`);

--
-- Index pour la table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `entry`
--
ALTER TABLE `entry`
  ADD CONSTRAINT `entry_ibfk_2` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  ADD CONSTRAINT `entry_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`player1_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`player2_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
