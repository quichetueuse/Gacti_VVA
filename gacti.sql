-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 15 avr. 2025 à 06:11
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gacti`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `CODEANIM` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `DATEACT` date NOT NULL,
  `CODEETATACT` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `HRRDVACT` time DEFAULT NULL,
  `PRIXACT` decimal(7,2) DEFAULT NULL,
  `HRDEBUTACT` time DEFAULT NULL,
  `HRFINACT` time DEFAULT NULL,
  `DATEANNULEACT` date DEFAULT NULL,
  `NOMRESP` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PRENOMRESP` char(30) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`CODEANIM`, `DATEACT`, `CODEETATACT`, `HRRDVACT`, `PRIXACT`, `HRDEBUTACT`, `HRFINACT`, `DATEANNULEACT`, `NOMRESP`, `PRENOMRESP`) VALUES
('CUEILCOL', '2025-04-29', 'OP', '15:00:00', 4.00, '15:30:00', '18:00:00', NULL, 'Montalou', 'Daniel'),
('CUEILCOL', '2025-04-30', 'IN', '10:00:00', 4.00, '10:15:00', '14:00:00', NULL, 'Passemoitou', 'Kevin'),
('LAUZET', '2025-04-28', 'IN', '18:00:00', 44.00, '18:30:00', '22:00:00', NULL, 'Smadja', 'Emmanuel'),
('LAUZET', '2025-05-01', 'IN', '17:00:00', 44.00, '17:30:00', '21:00:00', NULL, 'Smadja', 'Emmanuel'),
('LAUZET', '2025-05-03', 'IN', '06:00:00', 44.00, '06:30:00', '12:00:00', NULL, 'Montalou', 'Daniel'),
('LES2ALPE', '2025-04-30', 'OP', '05:00:00', 54.00, '06:00:00', '12:00:00', NULL, 'Montalou', 'Daniel'),
('LES2ALPE', '2025-05-01', 'OP', '05:00:00', 54.00, '06:00:00', '12:00:00', NULL, 'Montalou', 'Daniel'),
('LES2ALPE', '2025-05-03', 'OP', '05:00:00', 54.00, '06:00:00', '12:00:00', NULL, 'Montalou', 'Daniel'),
('NEUFCOUL', '2025-04-29', 'OP', '20:00:00', 47.00, '20:15:00', '23:59:00', NULL, 'Smadja', 'Emmanuel'),
('NEUFCOUL', '2025-05-02', 'OP', '20:00:00', 47.00, '20:15:00', '23:59:00', NULL, 'Smadja', 'Emmanuel'),
('WILDEXP', '2025-04-28', 'IN', '15:00:00', 11.00, '15:15:00', '19:00:00', NULL, 'Smadja', 'Emmanuel'),
('WILDEXP', '2025-04-29', 'IN', '15:00:00', 11.00, '15:15:00', '19:00:00', NULL, 'Passemoitou', 'Kevin'),
('WILDEXP', '2025-05-01', 'IN', '15:00:00', 11.00, '15:15:00', '19:00:00', NULL, 'Passemoitou', 'Kevin');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `act_view`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `act_view` (
`CODEANIM` char(8)
,`CODEETATACT` char(2)
,`COMMENTANIM` char(250)
,`DATEACT` date
,`DATEANNULEACT` date
,`DESCRIPTANIM` char(250)
,`DIFFICULTEANIM` char(40)
,`DUREEANIM` double(5,0)
,`HRDEBUTACT` time
,`HRFINACT` time
,`HRRDVACT` time
,`LIMITEAGE` int
,`NBREPLACEANIM` int
,`NOMANIM` char(40)
,`NOMRESP` char(40)
,`PRENOMRESP` char(30)
,`PRIXACT` decimal(7,2)
);

-- --------------------------------------------------------

--
-- Structure de la table `animation`
--

CREATE TABLE `animation` (
  `CODEANIM` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `CODETYPEANIM` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `NOMANIM` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DATECREATIONANIM` date DEFAULT NULL,
  `DATEVALIDITEANIM` date DEFAULT NULL,
  `DUREEANIM` double(5,0) DEFAULT NULL,
  `LIMITEAGE` int DEFAULT NULL,
  `TARIFANIM` decimal(7,2) DEFAULT NULL,
  `NBREPLACEANIM` int DEFAULT NULL,
  `DESCRIPTANIM` char(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `COMMENTANIM` char(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DIFFICULTEANIM` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animation`
--

INSERT INTO `animation` (`CODEANIM`, `CODETYPEANIM`, `NOMANIM`, `DATECREATIONANIM`, `DATEVALIDITEANIM`, `DUREEANIM`, `LIMITEAGE`, `TARIFANIM`, `NBREPLACEANIM`, `DESCRIPTANIM`, `COMMENTANIM`, `DIFFICULTEANIM`) VALUES
('CUEILCOL', 'CUEIL', 'Cueillette de champignons Lautaret.', '2025-03-28', '2025-09-19', 360, 4, 4.00, 39, 'Allez cueillir des champignons au Col du Lautaret, ou vous trouverez les meilleurs champignons de lentièreté des Alpes. Un cours de cuisine à la fin est également offert et est animé par le célèbre chef étoilé Philippe Etchebest.', 'Les différentes espèces de champignons trouvable sont: Les girolles et les pieds de moutons.', ''),
('LAUZET', 'BAIGN', 'Baignade du lac de Lauzet', '2025-01-19', '2025-07-09', 180, 40, 7.00, 23, 'Profitez d\'une vue à couper le souffle  au bord d\'une lac vieux de près de 1000 ans!', '', 'Aucune difficulté'),
('LES2ALPE', 'BOARD', 'Demi-journée dans la station Les 2 Alpes', '2025-01-19', '2025-07-09', 240, 18, 64.00, 47, 'Profitez de la qualité des pistes fournies par le personnel de la station \"Les 2 alpes\"', 'Pour ceux ayant des difficulté avec le snowboard, des moniteur expérimentés seront à votre disposition afin de vous apprendre les bases de ce superbe sport', 'Nécessite une maitrise basique'),
('NEUFCOUL', 'BAIGN', 'Baignade dans le Lac des neuf couleurs', '2025-01-19', '2025-07-09', 150, 4, 44.00, 27, 'Profitez de leau naturellement chaude que propose ce magnifique lac dont comme le nom lindique possède 9 teintes de couleur bleues différentes!', '', 'Aucune difficulté'),
('tes', 'TRAIL', 'teste', '2025-04-01', '2025-04-01', 2, 5, 4.00, 1, 'teste', 'teste', 'tes'),
('WILDEXP', 'TRAIN', 'Promenade en chiens de traineau', '2025-03-28', '2025-06-30', 240, 58, 9.00, 14, 'Grâce à lexpertise de la société Wild Experiences, vivez une expérience inoubliable avec des chiens adorables qui vous feront découvrir des lieux tous plus beaux les uns que les autres!', '', 'Ouvert à tous');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `USER` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `MDP` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NOMCOMPTE` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PRENOMCOMPTE` char(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEFERME` date DEFAULT NULL,
  `TYPEPROFIL` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DATEDEBSEJOUR` date DEFAULT NULL,
  `DATEFINSEJOUR` date DEFAULT NULL,
  `DATENAISCOMPTE` date DEFAULT NULL,
  `ADRMAILCOMPTE` char(70) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NOTELCOMPTE` char(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`USER`, `MDP`, `NOMCOMPTE`, `PRENOMCOMPTE`, `DATEINSCRIP`, `DATEFERME`, `TYPEPROFIL`, `DATEDEBSEJOUR`, `DATEFINSEJOUR`, `DATENAISCOMPTE`, `ADRMAILCOMPTE`, `NOTELCOMPTE`) VALUES
('ADMIN', 'f323eef0e8cc37806e28125931b3e33874bd4636', 'Administrateur', 'Administrateur', '2025-03-01', NULL, '1', '2025-03-01', '2025-03-01', '2015-03-02', 'admin.admin@gmail.com', '01011010'),
('DANIEL', '31cd7cdc2961b8b048ed75535f2cc8d8ee0eeb1d', 'Montalou', 'Daniel', '2025-03-01', NULL, '1', '2025-03-01', '2025-03-01', '2005-01-05', 'daniel.montalou@free.fr', '01000001'),
('DIYAADDA', '077ec3387ab28c612dfa378b3832f58039732e41', 'Addala', 'Diya', '2025-04-19', NULL, '0', '2025-04-23', '2025-05-07', '2005-02-26', 'diya.addala@sfr.com', '01001111'),
('EMANU', 'bcf52b2d5413267df620c42c8b0af6375cfcd1e7', 'Smadja', 'Emmanuel', '2025-03-01', NULL, '1', '2025-03-01', '2025-03-01', '1984-09-21', 'emmanuel.smadja@mpowerfinancing.org', '01010111'),
('KEVIN', '291683765a784558f47f01102c2a83668be845fa', 'Passemoitou', 'Kevin', '2025-03-01', NULL, '1', '2025-03-01', '2025-03-01', '1997-06-11', 'kevin.passemoitou@yahoo.free', '00100000'),
('KYKYBALA', 'e79410cfc7c4f94ceeee3fbb26a1e44b9a6ae5e3', 'Balain', 'Kylliann', '2025-04-15', NULL, '0', '2025-04-17', '2025-05-17', '2005-10-11', 'kylliann.balain@monlycee.net', '01010101'),
('REMYBAUC', 'd8aa87de288ea2bb28d75e636f92d07ed7f05224', 'Bauchet', 'Remy', '2025-04-01', NULL, '0', '2025-04-29', '2025-05-01', '2005-01-13', 'bauchet.remy@gmx.com', '01010010'),
('THEOCABR', 'c89f6f2f8df74f90938ca5cff7eeac5d76850356', 'Cabrelli', 'Théo', '2025-04-09', NULL, '0', '2025-04-23', '2025-05-05', '2005-06-17', 'theo.cabrelli@orange.fr', '01000001'),
('WILLIAMF', '826b8d326030546f60f8c88c0b43e38d3839d7ad', 'Fourcade', 'William', '2025-03-24', NULL, '0', '2025-04-21', '2025-05-11', '2004-07-23', 'william.fourcade2sn@gmail.com', '01000100');

-- --------------------------------------------------------

--
-- Structure de la table `etat_act`
--

CREATE TABLE `etat_act` (
  `CODEETATACT` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `NOMETATACT` char(25) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etat_act`
--

INSERT INTO `etat_act` (`CODEETATACT`, `NOMETATACT`) VALUES
('CA', 'Annulée'),
('IN', 'Incertaine'),
('OP', 'Ouverte');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `NOINSCRIP` bigint NOT NULL,
  `USER` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `CODEANIM` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `DATEACT` date NOT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEANNULE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`NOINSCRIP`, `USER`, `CODEANIM`, `DATEACT`, `DATEINSCRIP`, `DATEANNULE`) VALUES
(64, 'REMYBAUC', 'WILDEXP', '2025-04-29', '2025-04-28', NULL),
(65, 'REMYBAUC', 'LES2ALPE', '2025-04-30', '2025-04-29', NULL),
(66, 'KYKYBALA', 'LES2ALPE', '2025-05-03', '2025-04-20', NULL),
(67, 'KYKYBALA', 'NEUFCOUL', '2025-05-02', '2025-03-21', NULL),
(69, 'KYKYBALA', 'CUEILCOL', '2025-04-30', '2025-04-27', NULL),
(70, 'THEOCABR', 'WILDEXP', '2025-05-01', '2025-04-25', NULL),
(71, 'THEOCABR', 'LAUZET', '2025-05-01', '2025-04-23', NULL),
(72, 'DIYAADDA', 'NEUFCOUL', '2025-05-02', '2025-04-24', NULL),
(73, 'WILLIAMF', 'WILDEXP', '2025-04-29', '2025-04-23', NULL),
(74, 'THEOCABR', 'WILDEXP', '2025-04-29', '2025-03-28', NULL),
(75, 'THEOCABR', 'WILDEXP', '2025-04-28', '2025-03-28', NULL),
(76, 'DIYAADDA', 'WILDEXP', '2025-05-01', '2025-03-28', NULL),
(77, 'DIYAADDA', 'NEUFCOUL', '2025-04-29', '2025-03-28', NULL),
(78, 'WILLIAMF', 'LES2ALPE', '2025-05-01', '2025-03-28', NULL),
(79, 'WILLIAMF', 'LAUZET', '2025-05-03', '2025-03-28', NULL),
(80, 'WILLIAMF', 'LES2ALPE', '2025-04-30', '2025-03-28', NULL),
(81, 'REMYBAUC', 'CUEILCOL', '2025-04-29', '2025-03-28', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `type_anim`
--

CREATE TABLE `type_anim` (
  `CODETYPEANIM` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `NOMTYPEANIM` char(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_anim`
--

INSERT INTO `type_anim` (`CODETYPEANIM`, `NOMTYPEANIM`) VALUES
('BAIGN', 'Baignade'),
('BOARD', 'Snowboard'),
('CUEIL', 'Cueillette de champignons'),
('CYCLI', 'Cyclisme'),
('ESCAL', 'Escalade'),
('PARAP', 'Parapente'),
('PEDES', 'Sortie Pédestre'),
('PHOTO', 'Photographie'),
('RANDO', 'Randonnée'),
('SKI', 'Ski alpin'),
('TRAIL', 'Trail running'),
('TRAIN', 'Chiens de traîneau');

-- --------------------------------------------------------

--
-- Structure de la vue `act_view`
--
DROP TABLE IF EXISTS `act_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `act_view`  AS SELECT `act`.`CODEANIM` AS `CODEANIM`, `act`.`DATEACT` AS `DATEACT`, `act`.`CODEETATACT` AS `CODEETATACT`, `act`.`HRRDVACT` AS `HRRDVACT`, `act`.`PRIXACT` AS `PRIXACT`, `act`.`HRDEBUTACT` AS `HRDEBUTACT`, `act`.`HRFINACT` AS `HRFINACT`, `act`.`DATEANNULEACT` AS `DATEANNULEACT`, `act`.`NOMRESP` AS `NOMRESP`, `act`.`PRENOMRESP` AS `PRENOMRESP`, `anim`.`NOMANIM` AS `NOMANIM`, `anim`.`DESCRIPTANIM` AS `DESCRIPTANIM`, `anim`.`COMMENTANIM` AS `COMMENTANIM`, `anim`.`DIFFICULTEANIM` AS `DIFFICULTEANIM`, `anim`.`NBREPLACEANIM` AS `NBREPLACEANIM`, `anim`.`DUREEANIM` AS `DUREEANIM`, `anim`.`LIMITEAGE` AS `LIMITEAGE` FROM (`activite` `act` join `animation` `anim` on((`anim`.`CODEANIM` = `act`.`CODEANIM`))) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`CODEANIM`,`DATEACT`),
  ADD KEY `I_FK_ACTIVITE_ANIMATION` (`CODEANIM`),
  ADD KEY `I_FK_ACTIVITE_ETAT_ACT` (`CODEETATACT`);

--
-- Index pour la table `animation`
--
ALTER TABLE `animation`
  ADD PRIMARY KEY (`CODEANIM`),
  ADD KEY `I_FK_ANIMATION_TYPE_ANIM` (`CODETYPEANIM`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`USER`);

--
-- Index pour la table `etat_act`
--
ALTER TABLE `etat_act`
  ADD PRIMARY KEY (`CODEETATACT`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`NOINSCRIP`),
  ADD KEY `I_FK_INSCRIPTION_COMPTE` (`USER`),
  ADD KEY `I_FK_INSCRIPTION_ACTIVITE` (`CODEANIM`,`DATEACT`);

--
-- Index pour la table `type_anim`
--
ALTER TABLE `type_anim`
  ADD PRIMARY KEY (`CODETYPEANIM`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `NOINSCRIP` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`CODEANIM`) REFERENCES `animation` (`CODEANIM`),
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`CODEETATACT`) REFERENCES `etat_act` (`CODEETATACT`);

--
-- Contraintes pour la table `animation`
--
ALTER TABLE `animation`
  ADD CONSTRAINT `animation_ibfk_1` FOREIGN KEY (`CODETYPEANIM`) REFERENCES `type_anim` (`CODETYPEANIM`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `compte` (`USER`),
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`CODEANIM`,`DATEACT`) REFERENCES `activite` (`CODEANIM`, `DATEACT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
