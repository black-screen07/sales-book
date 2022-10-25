-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 oct. 2022 à 23:54
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stock_pro`
--

-- --------------------------------------------------------

--
-- Structure de la table `r_sale_product`
--

DROP TABLE IF EXISTS `r_sale_product`;
CREATE TABLE IF NOT EXISTS `r_sale_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saleId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `saleId` (`saleId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_sale_product`
--

INSERT INTO `r_sale_product` (`id`, `saleId`, `productId`, `qte`, `price`, `enabled`, `created_at`, `updated_at`) VALUES
(18, 13, 7, 1, 2500000, 1, '2022-03-13 12:52:26', NULL),
(19, 14, 9, 1, 2455000, 1, '2022-03-13 12:59:02', NULL),
(20, 15, 7, 2, 2500000, 1, '2022-03-13 18:30:58', NULL),
(21, 16, 8, 1, 3000000, 1, '2022-03-13 18:37:11', NULL),
(22, 17, 10, 1, 5000000, 1, '2022-03-13 18:38:53', NULL),
(23, 18, 7, 2, 2500000, 1, '2022-03-14 11:37:19', NULL),
(24, 19, 11, 1, 800000, 1, '2022-03-14 11:39:45', NULL),
(25, 19, 10, 1, 5000000, 1, '2022-03-14 11:39:45', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_supplying_product`
--

DROP TABLE IF EXISTS `r_supplying_product`;
CREATE TABLE IF NOT EXISTS `r_supplying_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplyingId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplyingId` (`supplyingId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_category`
--

DROP TABLE IF EXISTS `t_category`;
CREATE TABLE IF NOT EXISTS `t_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_category`
--

INSERT INTO `t_category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PC Laptop', '2020-05-14 07:57:45', '2020-05-14 15:16:33'),
(2, 'PC UC', '2020-05-14 11:07:15', '2020-05-14 11:07:15'),
(3, 'Serveur', '2020-05-14 11:08:30', '2020-05-14 11:08:30'),
(5, 'Telephone portable', '2022-03-14 10:38:14', '2022-03-14 10:38:14');

-- --------------------------------------------------------

--
-- Structure de la table `t_charge`
--

DROP TABLE IF EXISTS `t_charge`;
CREATE TABLE IF NOT EXISTS `t_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_charge`
--

INSERT INTO `t_charge` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'CIE', '2020-05-14 11:22:21', '2020-05-14 11:22:21'),
(2, 'SODECI', '2022-03-13 16:22:15', NULL),
(3, 'CANAL+', '2022-03-13 16:23:40', NULL),
(4, 'CONNEXION INTERNET', '2022-03-13 16:23:40', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_chargecost`
--

DROP TABLE IF EXISTS `t_chargecost`;
CREATE TABLE IF NOT EXISTS `t_chargecost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` varchar(2) NOT NULL,
  `amount` int(11) NOT NULL,
  `chargeId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chargeId` (`chargeId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_chargecost`
--

INSERT INTO `t_chargecost` (`id`, `year`, `month`, `amount`, `chargeId`, `userId`, `created_at`, `updated_at`) VALUES
(1, 2020, '05', 14500, 1, NULL, '2020-05-14 11:22:21', '2020-05-14 11:22:21'),
(2, 2022, '02', 30000, 1, NULL, '2022-03-13 17:35:38', '2022-03-13 17:35:38');

-- --------------------------------------------------------

--
-- Structure de la table `t_customer`
--

DROP TABLE IF EXISTS `t_customer`;
CREATE TABLE IF NOT EXISTS `t_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(225) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_customer`
--

INSERT INTO `t_customer` (`id`, `fullName`, `phone`, `created_at`, `updated_at`) VALUES
(5, 'Egnin Aka', '07 67 66 54 62', '2022-03-13 11:52:26', '2022-03-13 11:52:26'),
(6, 'Ako Junior', '05 46 22 73 82', '2022-03-14 11:34:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_product`
--

DROP TABLE IF EXISTS `t_product`;
CREATE TABLE IF NOT EXISTS `t_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `price` int(11) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT '0',
  `img` text,
  `categoryId` int(11) DEFAULT NULL,
  `hasStock` int(1) DEFAULT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_product`
--

INSERT INTO `t_product` (`id`, `name`, `price`, `qte`, `img`, `categoryId`, `hasStock`, `enabled`, `created_at`, `updated_at`) VALUES
(7, 'Mac Book Pro', 2500000, 12, 'prod-7.jpg', 1, 1, 1, '2022-03-11 13:21:33', '2022-03-14 10:37:19'),
(8, 'PC Lenovo Gammer', 3000000, 4, 'prod-8.jpg', 1, 1, 1, '2022-03-11 13:23:48', '2022-03-13 17:37:11'),
(9, 'PC Accer Nitro Gammer', 2455000, 6, 'prod-9.jpg', 1, 1, 1, '2022-03-11 13:26:12', '2022-03-13 11:59:02'),
(10, 'Serveur Cisco', 5000000, 1, 'prod-10.jpg', 3, 1, 1, '2022-03-13 17:38:14', '2022-03-14 10:39:45'),
(11, 'Iphone 11', 800000, 46, 'prod-11.jpg', 5, 1, 1, '2022-03-14 10:38:14', '2022-03-14 10:39:45');

-- --------------------------------------------------------

--
-- Structure de la table `t_sale`
--

DROP TABLE IF EXISTS `t_sale`;
CREATE TABLE IF NOT EXISTS `t_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tt` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `customerId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `customerId` (`customerId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_sale`
--

INSERT INTO `t_sale` (`id`, `dateS`, `tt`, `cash`, `userId`, `customerId`, `created_at`, `updated_at`) VALUES
(1, '2020-05-14 07:59:13', 800, 1000, NULL, NULL, '2020-05-14 07:59:13', '2020-05-14 07:59:13'),
(2, '2020-05-14 10:48:56', 1200, 1000, 1, NULL, '2020-05-14 10:48:56', '2020-05-14 10:48:56'),
(3, '2020-05-14 11:03:43', 400, 1200, 1, NULL, '2020-05-14 11:03:43', '2020-05-14 11:03:43'),
(4, '2020-05-14 11:05:13', 400, 2000, 1, NULL, '2020-05-14 11:05:13', '2020-05-14 11:05:13'),
(5, '2020-05-14 11:33:06', 11275, 12000, 1, NULL, '2020-05-14 11:33:06', '2020-05-14 11:33:06'),
(6, '2020-05-14 11:35:11', 25000, 30000, 1, NULL, '2020-05-14 11:35:11', '2020-05-14 11:35:11'),
(7, '2020-05-14 11:36:54', 2500, 3000, 1, NULL, '2020-05-14 11:36:54', '2020-05-14 11:36:54'),
(8, '2020-05-14 15:05:17', 8300, 10000, 1, NULL, '2020-05-14 15:05:17', '2020-05-14 15:05:17'),
(9, '2020-05-14 15:06:18', 3000, 3000, 1, NULL, '2020-05-14 15:06:18', '2020-05-14 15:10:34'),
(10, '2020-05-14 15:09:45', 2500, 2400, 1, NULL, '2020-05-14 15:09:45', '2020-05-14 15:11:10'),
(11, '2020-05-14 15:19:51', 100, 3, 1, NULL, '2020-05-14 15:19:51', '2020-05-14 15:19:51'),
(13, '2022-03-13 12:52:26', 2500000, 2500000, 1, 5, '2022-03-13 11:52:26', '2022-03-13 11:52:26'),
(14, '2022-03-13 12:59:02', 2455000, 2455000, 1, 5, '2022-03-13 11:59:02', '2022-03-13 11:59:02'),
(15, '2022-03-13 18:30:58', 5000000, 5000000, 1, 5, '2022-03-13 17:30:58', '2022-03-13 17:30:58'),
(16, '2022-03-13 18:37:11', 3000000, 3000000, 1, 5, '2022-03-13 17:37:11', '2022-03-13 17:37:11'),
(17, '2022-03-13 18:38:53', 5000000, 6000000, 1, 5, '2022-03-13 17:38:53', '2022-03-13 17:38:53'),
(18, '2022-03-14 11:37:19', 5000000, 5000000, 1, 6, '2022-03-14 10:37:19', '2022-03-14 10:37:19'),
(19, '2022-03-14 11:39:45', 5800000, 6000000, 1, 5, '2022-03-14 10:39:45', '2022-03-14 10:39:45');

-- --------------------------------------------------------

--
-- Structure de la table `t_supplier`
--

DROP TABLE IF EXISTS `t_supplier`;
CREATE TABLE IF NOT EXISTS `t_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(225) NOT NULL,
  `adress` text,
  `phone` varchar(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_supplier`
--

INSERT INTO `t_supplier` (`id`, `fullName`, `adress`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Ayofe Ange', NULL, NULL, '2020-05-14 07:58:45', '2020-05-14 07:58:45');

-- --------------------------------------------------------

--
-- Structure de la table `t_supplying`
--

DROP TABLE IF EXISTS `t_supplying`;
CREATE TABLE IF NOT EXISTS `t_supplying` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deliverySheetCode` varchar(50) DEFAULT NULL,
  `dateS` date NOT NULL,
  `comment` text,
  `price` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `supplierId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `supplierId` (`supplierId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regNumber` varchar(50) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `adress` text,
  `enabled` int(1) NOT NULL DEFAULT '1',
  `userLevelCode` varchar(20) DEFAULT NULL,
  `img` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userLevelCode` (`userLevelCode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`id`, `regNumber`, `firstname`, `lastname`, `email`, `password`, `phone`, `adress`, `enabled`, `userLevelCode`, `img`, `created_at`, `updated_at`) VALUES
(1, 'MAT-098', 'Egnin', 'Aka Emmanuel Freddy', 'admin@salesbook.com', '$2y$10$7pgmfmIAIyKxYlkeN60nUexghrMbfJIktqd7JbQt6Q3BGFsGUniZO', '', '01 01 01 01', 1, 'admin', NULL, '2020-04-28 11:57:50', NULL),
(3, NULL, 'Black', 'Screen', 'dev@blackscreen.com', '$2y$10$jbwlj/sF.j0v5MUBnUMtMe7UDPrWtK4bBBiOftTPivs7irDoEWski', NULL, NULL, 1, 'admin', NULL, '2022-10-24 21:49:56', '2022-10-24 21:49:56');

-- --------------------------------------------------------

--
-- Structure de la table `t_userlevel`
--

DROP TABLE IF EXISTS `t_userlevel`;
CREATE TABLE IF NOT EXISTS `t_userlevel` (
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_userlevel`
--

INSERT INTO `t_userlevel` (`code`, `name`, `created_at`, `updated_at`) VALUES
('admin', 'Administrateur', '2020-05-12 10:11:37', NULL),
('caisse', 'Caissière', '2020-05-12 10:11:37', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `r_sale_product`
--
ALTER TABLE `r_sale_product`
  ADD CONSTRAINT `r_sale_product_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `r_sale_product_ibfk_2` FOREIGN KEY (`saleId`) REFERENCES `t_sale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_supplying_product`
--
ALTER TABLE `r_supplying_product`
  ADD CONSTRAINT `r_supplying_product_ibfk_1` FOREIGN KEY (`supplyingId`) REFERENCES `t_supplying` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `r_supplying_product_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_chargecost`
--
ALTER TABLE `t_chargecost`
  ADD CONSTRAINT `t_chargecost_ibfk_1` FOREIGN KEY (`chargeId`) REFERENCES `t_charge` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_chargecost_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `t_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_product`
--
ALTER TABLE `t_product`
  ADD CONSTRAINT `t_product_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `t_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_sale`
--
ALTER TABLE `t_sale`
  ADD CONSTRAINT `t_sale_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `t_sale_ibfk_2` FOREIGN KEY (`customerId`) REFERENCES `t_customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_supplying`
--
ALTER TABLE `t_supplying`
  ADD CONSTRAINT `t_supplying_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `t_supplying_ibfk_2` FOREIGN KEY (`supplierId`) REFERENCES `t_supplier` (`id`);

--
-- Contraintes pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`userLevelCode`) REFERENCES `t_userlevel` (`code`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
