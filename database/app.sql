-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 27 avr. 2025 à 22:44
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app`
--

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

DROP TABLE IF EXISTS `boutique`;
CREATE TABLE IF NOT EXISTS `boutique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credits_amount` int NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boutique`
--

INSERT INTO `boutique` (`id`, `product`, `credits_amount`, `price`, `currency`) VALUES
(1, 'Starter Pack', 2300, 9.99, 'EUR'),
(2, 'Master Pack', 4800, 21.99, 'EUR'),
(3, 'Premium Pack', 10600, 49.99, 'EUR');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250129092630', '2025-01-29 09:26:35', 63),
('DoctrineMigrations\\Version20250129151134', '2025-01-29 15:11:41', 144),
('DoctrineMigrations\\Version20250130102146', '2025-01-30 10:21:54', 214),
('DoctrineMigrations\\Version20250130190626', '2025-01-30 19:08:27', 309),
('DoctrineMigrations\\Version20250203093138', '2025-02-03 09:31:50', 178),
('DoctrineMigrations\\Version20250206083654', '2025-02-06 08:37:08', 341),
('DoctrineMigrations\\Version20250206111924', '2025-02-06 11:19:30', 71);

-- --------------------------------------------------------

--
-- Structure de la table `machines`
--

DROP TABLE IF EXISTS `machines`;
CREATE TABLE IF NOT EXISTS `machines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `games` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `state` tinyint(1) NOT NULL,
  `price` double NOT NULL,
  `compatibility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maintenance` tinyint(1) NOT NULL,
  `storage` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `machines`
--

INSERT INTO `machines` (`id`, `name`, `games`, `address`, `created_at`, `state`, `price`, `compatibility`, `maintenance`, `storage`) VALUES
(275, 'GameMaster', 'Jeux en ligne, eSports, action, plateforme', '192.168.5.3', '2025-01-28 13:26:28', 0, 2000, 'Windows, Xbox, PS5', 0, '500 Go'),
(276, 'TurboX Elite', 'Jeux de combat, aventure, multi-joueurs', '192.168.5.4', '2025-01-28 13:27:26', 0, 2700, 'Windows 10, Mac, PS4, Xbox One', 1, '500 GO'),
(277, 'PowerX', 'Jeux AAA, simulation, jeux de rôle, stratégie', '192.168.5.5', '2025-01-28 13:28:22', 1, 3300, 'Windows 10, Mac, Linux', 0, '1 TO'),
(278, 'UltraCore', 'Simulation, open world, FPS', '192.168.5.6', '2025-01-28 13:29:23', 0, 4000, 'Windows 11, Mac', 0, '1 TO'),
(279, 'VR Titan', 'Réalité virtuelle, jeux d\'aventure', '192.168.5.7', '2025-01-28 13:30:09', 0, 4600, 'Windows 10, Mac, VR supporté', 0, '1 TO'),
(280, 'QuantumX', 'Open-world, stratégie, action', '192.168.5.8', '2025-01-28 13:30:36', 0, 5300, 'Windows 11, Mac, PS5', 0, '1 TO');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `machine_id` int NOT NULL,
  `id_user` int NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `machine_id` (`machine_id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount_credit` int NOT NULL,
  `total_price` int NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount_credit`, `total_price`, `method`, `state`, `date`, `reference`) VALUES
(5, 64, 10600, 49, 'EUR', 'Valide', '2025-02-03 12:41:18', '#ARGAME-2f30332254'),
(6, 64, 10600, 49, 'EUR', 'Valide', '2025-02-03 12:41:29', '#ARGAME-f2c68a3dd8'),
(7, 64, 10600, 49, 'EUR', 'Valide', '2025-02-03 12:41:30', '#ARGAME-7cf3fe45e7'),
(8, 64, 10600, 49, 'EUR', 'Valide', '2025-02-03 12:41:30', '#ARGAME-8503bc26db'),
(9, 72, 2300, 9, 'EUR', 'Valide', '2025-02-03 12:45:28', '#ARGAME-5d933d6833'),
(10, 72, 4800, 21, 'EUR', 'Valide', '2025-02-03 12:45:36', '#ARGAME-731b5246df'),
(11, 89, 2300, 9, 'EUR', 'Valide', '2025-02-03 18:11:38', '#ARGAME-513498e809'),
(12, 64, 10600, 49, 'EUR', 'Valide', '2025-02-03 18:13:19', '#ARGAME-c84105f895'),
(13, 64, 10600, 49, 'EUR', 'Valide', '2025-02-05 09:14:55', '#ARGAME-b41c20d0c9'),
(14, 64, 2300, 9, 'EUR', 'Valide', '2025-02-05 14:53:37', '#ARGAME-f295d13397'),
(15, 64, 10600, 49, 'EUR', 'Valide', '2025-02-05 14:57:33', '#ARGAME-5a5a892f12'),
(16, 64, 10600, 49, 'EUR', 'Valide', '2025-02-06 10:30:59', '#ARGAME-392c6338a4'),
(17, 64, 4800, 21, 'EUR', 'Valide', '2025-02-07 10:51:25', '#ARGAME-a1744e4976'),
(18, 64, 10600, 49, 'EUR', 'Valide', '2025-02-23 21:04:28', '#ARGAME-4a6d369e47'),
(19, 64, 2300, 9, 'EUR', 'Valide', '2025-02-24 08:55:20', '#ARGAME-70f78f1aa7'),
(20, 64, 10600, 49, 'EUR', 'Valide', '2025-02-24 09:45:03', '#ARGAME-6c6965471e'),
(21, 64, 10600, 49, 'EUR', 'Valide', '2025-02-26 08:13:39', '#ARGAME-20d65b0ded'),
(22, 64, 2300, 9, 'EUR', 'Valide', '2025-03-31 08:48:10', '#ARGAME-c609210b65'),
(23, 64, 10600, 49, 'EUR', 'Valide', '2025-04-15 12:55:24', '#ARGAME-cfe5b12fc4'),
(24, 64, 10600, 49, 'EUR', 'Valide', '2025-04-15 13:58:43', '#ARGAME-4b3c5462b5'),
(25, 64, 10600, 49, 'EUR', 'Valide', '2025-04-15 13:58:45', '#ARGAME-91b3fadf27');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_credit` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `full_name`, `pseudo`, `created_at`, `updated_at`, `user_credit`) VALUES
(64, 'zbriand@noos.fr', '[\"ROLE_ADMIN\"]', '$2y$13$AmpCzyfY3lWTg1eU7Ppuz.MSDTCPwVZGbj6AhYL108cv9XzK4MCPS', 'André Lebrun-Godard', 'Bernadette', '2025-01-20 11:14:36', '2025-01-24 10:30:42', 40400),
(65, 'picard.eleonore@free.fr', '[\"ROLE_USER\"]', '$2y$13$oTVm.ifm52O2BeTTtkQdfOZWRGXMjkv3MYO0TDxs6iFXIBO5Rr4Ne', 'Juliette-Adélaïde Bazin', 'Yayaya', '2025-01-20 11:14:36', '2025-01-30 09:21:24', 0),
(66, 'lemoine.emmanuel@diallo.org', '[\"ROLE_USER\"]', '$2y$13$7tMx9hfQdhLTPlKvxkcmKOH11P1WXzPtcY0Oq84g1wq7UJsF/nnqu', 'Olivie de la Mary', 'Margot', '2025-01-20 11:14:36', '0000-00-00 00:00:00', 0),
(67, 'joubert.adelaide@peron.com', '[\"ROLE_USER\"]', '$2y$13$6iJ.PL6YZSqzqk9g8nhFiem/Dlps4xFU0gKo2pBPP2LlYBhf6z/Ui', 'Luc Laporte', 'Luc', '2025-01-20 11:14:37', '2025-02-03 13:02:23', 0),
(68, 'yves.guillon@wanadoo.fr', '[\"ROLE_USER\"]', '$2y$13$JTzBe8Jsx3ZGbLFLJRbszeK0vhCm0VH9NBTXtiROKg5gPdXVUGIkG', 'Françoise Besson', 'Édouard', '2025-01-20 11:14:37', '0000-00-00 00:00:00', 0),
(69, 'rene.vincent@besnard.net', '[\"ROLE_USER\"]', '$2y$13$DsWxvsaodaYeYYF/dC6vK.CELnAgC42GL4zD5IcpsVU2mURiMkruO', 'Anouk Perez-Mercier', 'Emmanuel', '2025-01-20 11:14:38', '0000-00-00 00:00:00', 1800),
(70, 'denis.frederique@couturier.fr', '[\"ROLE_USER\"]', '$2y$13$NeqJpWi.2Wtybyr/6XOxCuMTeVTa.BWxS/05NGEwYaCwPesbrNwrW', 'Richard de la Paul', NULL, '2025-01-20 11:14:38', '0000-00-00 00:00:00', 0),
(71, 'blondel.georges@free.fr', '[\"ROLE_USER\"]', '$2y$13$rY9o0gOEITHK7CkwROU2J.UXKJO6eTchIqAqlmWqNt33rxfOr9Zaq', 'Laurence-Édith Vallet', 'Hugues', '2025-01-20 11:14:39', '0000-00-00 00:00:00', 1172100),
(72, 'alfred22@jacob.fr', '[\"ROLE_USER\"]', '$2y$13$ROQYOE9mLu4Wv1cXXoZ24eA4Fb3EDeEK.NtpqhCetk9J7Ie/u4FcC', 'Dorothée Maillet', 'Jacob', '2025-01-20 11:14:39', '2025-02-03 12:45:20', 4400),
(74, 'vrocher@wanadoo.fr', '[\"ROLE_USER\"]', '$2y$13$mOUdjJ8fVnm1sEPbIGkBquaH3P7xRVgG2vmXy/Ooi8aPzQQ4WbLyS', 'test', 'ss', '2025-01-20 11:14:40', '0000-00-00 00:00:00', 0),
(75, 'laurent.denis@clerc.com', '[\"ROLE_USER\"]', '$2y$13$wtF8qR23cE3vnPipdOdxqeGMhAq/cm4neSBloKL5TPOFD741pp.cq', 'Honoré du Carlier', NULL, '2025-01-20 11:14:40', '0000-00-00 00:00:00', 0),
(76, 'sletellier@free.fr', '[\"ROLE_USER\"]', '$2y$13$wCS3zQVnY2OK6gp.0OfpfetSOZpSVnzaxarACk0e/hcFLhOaoDxwG', 'Stéphane Hubert', NULL, '2025-01-20 11:14:41', '0000-00-00 00:00:00', 0),
(77, 'nklein@gallet.org', '[\"ROLE_USER\"]', '$2y$13$MUFjXhRkN/aK6l78ArHlBOybjn0cqZlULTrVQ8AR66U7ovu5T9j.a', 'Jacques Bonneau-Cohen', NULL, '2025-01-20 11:14:41', '0000-00-00 00:00:00', 0),
(78, 'bmary@lopes.com', '[\"ROLE_USER\"]', '$2y$13$RMJm9L5SNLjmEbwEIPmEhORRV.65PJM2T6LKlsbK1l7A0LNIg6GfS', 'Clémence-Alex Millet', 'Gérard', '2025-01-20 11:14:42', '0000-00-00 00:00:00', 0),
(79, 'adrienne.courtois@tele2.fr', '[\"ROLE_USER\"]', '$2y$13$icwn6LPvFnz84kaXNcfUsOJeHcY8bRyyUIFlC4fJEtN1zZgJobzV2', 'Thierry Loiseau', 'Nath', '2025-01-20 11:14:42', '0000-00-00 00:00:00', 0),
(80, 'emmanuelle70@free.fr', '[\"ROLE_USER\"]', '$2y$13$nUtV.4PEg1SZg9dhzQqV1OpwWUPFq1XkEe.iZvcD/p8R.UbT4GWMi', 'Laurent Lefebvre', NULL, '2025-01-20 11:14:43', '0000-00-00 00:00:00', 0),
(81, 'leclerc.raymond@marion.com', '[\"ROLE_USER\"]', '$2y$13$8FNSFdadGoH.4uMJPA3kvemeykq90dSFTUAowWT7cpXL0QcwQtB06', 'Pierre Bodin-Duhamel', NULL, '2025-01-20 11:14:43', '0000-00-00 00:00:00', 0),
(82, 'patrick49@tele2.fr', '[\"ROLE_USER\"]', '$2y$13$awh6JiFTdYuBffvQaEcKQO/O8coF27bolvFgU2azfPcGznM0lZFZG', 'Louis Lambert', NULL, '2025-01-20 11:14:43', '0000-00-00 00:00:00', 0),
(83, 'gmace@daniel.fr', '[\"ROLE_USER\"]', '$2y$13$R1j6rri8/rWDP7jgyCzm3.N2fRU15nVskhr.x.d.fj5tkxGcNDdTy', 'Lucas Leveque', 'Yves', '2025-01-20 11:14:44', '0000-00-00 00:00:00', 0),
(84, 'lucas.tristan@sfr.fr', '[\"ROLE_USER\"]', '$2y$13$6xo2y4bXRPrk86ujM/Ay5O6iHMdw9S5pvH/PPLDcQPmpflZj2iczO', 'Chantal Le Barre', NULL, '2025-01-20 11:14:44', '0000-00-00 00:00:00', 0),
(85, 'm@m.fr', '[]', 'password', 'm m', NULL, '2025-01-21 09:52:26', '0000-00-00 00:00:00', 0),
(86, 't@m.fr', '[]', 'password', 't t', NULL, '2025-01-21 09:55:24', '0000-00-00 00:00:00', 0),
(87, 'aa@a.fr', '[]', '$2y$13$eUOfGRd357JxbgmKR3F3Re/KmYRzYjeZit6StwozDFpwUiXvVVqw.', 't t', NULL, '2025-01-21 10:04:13', '0000-00-00 00:00:00', 0),
(89, 'maxence.remy26@gmail.com', '[\"ROLE_USER\"]', '$2y$13$U/72Lx6uoiJxvmrbEKkytOyjrbZzxf/H/QIRXMhDtpFxLonD40qsO', 'Maxence Rémy', 'chmax', '2025-02-03 18:10:39', '2025-02-03 18:10:39', 300);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`),
  ADD CONSTRAINT `token_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `ChangeStateMachine`$$
CREATE DEFINER=`root`@`localhost` EVENT `ChangeStateMachine` ON SCHEDULE EVERY 2 HOUR STARTS '2025-02-06 11:29:48' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE machines
SET state = 0
WHERE id IN (
    SELECT machine_id
    FROM token
    WHERE hours < NOW() - INTERVAL 2 HOUR
)$$

DROP EVENT IF EXISTS `DeleteExpiredTokens`$$
CREATE DEFINER=`root`@`localhost` EVENT `DeleteExpiredTokens` ON SCHEDULE EVERY 2 HOUR STARTS '2025-02-05 15:48:12' ON COMPLETION PRESERVE ENABLE DO DELETE FROM token WHERE hours < NOW() - INTERVAL 2 HOUR$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
