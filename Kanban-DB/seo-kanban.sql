-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 19 avr. 2021 à 11:03
-- Version du serveur :  10.5.4-MariaDB
-- Version de PHP : 7.4.12

START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `seo-kanban`
--

-- --------------------------------------------------------

--
-- Structure de la table `board`
--

DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_foreign_key_name` (`user_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `board_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_foreign_key_name` (`board_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `card_item`
--

DROP TABLE IF EXISTS `card_item`;
CREATE TABLE IF NOT EXISTS `card_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_foreign_key_name` (`card_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `column_board`
--

DROP TABLE IF EXISTS `column_board`;
CREATE TABLE IF NOT EXISTS `column_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_foreign_key_name` (`board_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'SUPERUSER');

-- --------------------------------------------------------

--
-- Structure de la table `user_role_permission`
--

DROP TABLE IF EXISTS `user_role_permission`;
CREATE TABLE IF NOT EXISTS `user_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `page` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `user_role_permission`
--

INSERT INTO `user_role_permission` (`id`, `user_role_id`, `page`) VALUES
(1, 1, '/boards'),
(2, 1, '/board/:text/:id'),
(3, 1, '/board/add'),
(4, 1, '/board/edit/:id'),
(5, 1, '/board/delete/:id'),
(6, 1, '/column/add'),
(7, 1, '/column/edit/:id'),
(8, 1, '/column/delete/:id'),
(9, 1, '/card/:id'),
(10, 1, '/card/add'),
(11, 1, '/card/edit/:id'),
(12, 1, '/card/delete/:id'),
(13, 1, '/item/add'),
(14, 1, '/item/edit/:id'),
(15, 1, '/item/delete/:id'),
(16, 2, '/boards'),
(17, 2, '/board/:text/:id'),
(18, 2, '/board/add'),
(19, 2, '/board/edit/:id'),
(20, 2, '/board/delete/:id'),
(21, 2, '/column/add'),
(22, 2, '/column/edit/:id'),
(23, 2, '/column/delete/:id'),
(24, 2, '/card/:id'),
(25, 2, '/card/add'),
(26, 2, '/card/edit/:id'),
(27, 2, '/card/delete/:id'),
(28, 2, '/item/add'),
(29, 2, '/item/edit/:id'),
(30, 2, '/item/delete/:id');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
