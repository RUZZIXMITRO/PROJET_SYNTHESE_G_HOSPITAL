-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 13 avr. 2025 à 20:30
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_stages`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `ID_ADM` int(11) NOT NULL,
  `NOM_ADM` varchar(50) NOT NULL CHECK (`NOM_ADM` <> ''),
  `PRN_ADM` varchar(50) NOT NULL CHECK (`PRN_ADM` <> ''),
  `MAIL_ADM` varchar(50) NOT NULL CHECK (`MAIL_ADM` like '%_@_%._%'),
  `MDP_ADM` varchar(255) NOT NULL CHECK (char_length(`MDP_ADM`) >= 8),
  `IMG_ADM` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `encadrant`
--

CREATE TABLE `encadrant` (
  `ID_ENC` int(11) NOT NULL,
  `NOM_ENC` varchar(50) NOT NULL CHECK (`NOM_ENC` <> ''),
  `PRN_ENC` varchar(50) NOT NULL CHECK (`PRN_ENC` <> ''),
  `MAIL_ENC` varchar(50) NOT NULL CHECK (`MAIL_ENC` like '%_@_%._%'),
  `MDP_ENC` varchar(255) NOT NULL CHECK (char_length(`MDP_ENC`) >= 8),
  `IMG_ENC` varchar(255) DEFAULT NULL,
  `TEL_ENC` varchar(20) DEFAULT NULL CHECK (`TEL_ENC` regexp '^[0-9+ -]{10,20}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `encadrant`
--

INSERT INTO `encadrant` (`ID_ENC`, `NOM_ENC`, `PRN_ENC`, `MAIL_ENC`, `MDP_ENC`, `IMG_ENC`, `TEL_ENC`) VALUES
(1, 'Echadli', 'Kassem', 'kassem12345@gmail.com', '$2y$10$0xOAtAmVfjMpagEHnguFGuTJNjXXQSiv7onrwGWJplB7GmHosWUBe', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `ID_GRP` int(11) NOT NULL,
  `NUM_GRP` varchar(50) NOT NULL CHECK (`NUM_GRP` <> ''),
  `ID_NIV` int(11) NOT NULL,
  `ID_STAGE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`ID_GRP`, `NUM_GRP`, `ID_NIV`, `ID_STAGE`) VALUES
(11, 'Groupe 1', 1, 1),
(12, 'Groupe 2', 1, 1),
(13, 'Groupe 3', 1, 1),
(14, 'Groupe 4', 1, 1),
(15, 'Groupe 5', 1, 1),
(16, 'Groupe 6', 1, 1),
(17, 'Groupe 7', 1, 1),
(18, 'Groupe 8', 1, 1),
(19, 'Groupe 9', 1, 1),
(20, 'Groupe 10', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messagerie`
--

CREATE TABLE `messagerie` (
  `ID_MSG` int(11) NOT NULL,
  `CONT_MSG` varchar(255) NOT NULL CHECK (`CONT_MSG` <> ''),
  `DATE_MSG` date NOT NULL,
  `ID_ENC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `ID_NIV` int(11) NOT NULL,
  `NUM_NIV` varchar(50) NOT NULL CHECK (`NUM_NIV` <> '')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`ID_NIV`, `NUM_NIV`) VALUES
(1, '1ère année médecine'),
(2, '2ème année médecine'),
(3, '3ème année médecine'),
(4, '4ème année médecine'),
(5, '5ème année médecine'),
(6, '6ème année médecine'),
(7, '7ème année médecine (internat)');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `ID_NOTIF` int(11) NOT NULL,
  `DATE_NOTIF` date NOT NULL,
  `CONT_NOTIF` varchar(255) NOT NULL CHECK (`CONT_NOTIF` <> ''),
  `ID_ADM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poser`
--

CREATE TABLE `poser` (
  `ID_MSG` int(11) NOT NULL,
  `ID_STG` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recu`
--

CREATE TABLE `recu` (
  `ID_ENC` int(11) NOT NULL,
  `ID_NOTIF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `ID_SER` int(11) NOT NULL,
  `NOM_SER` varchar(50) NOT NULL CHECK (`NOM_SER` <> ''),
  `ID_STAGE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE `stage` (
  `ID_STAGE` int(11) NOT NULL,
  `DATE_DEB_STG` date NOT NULL,
  `DATE_FIN_STG` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stage`
--

INSERT INTO `stage` (`ID_STAGE`, `DATE_DEB_STG`, `DATE_FIN_STG`) VALUES
(1, '2025-05-01', '2025-06-30');

-- --------------------------------------------------------

--
-- Structure de la table `stagiaire`
--

CREATE TABLE `stagiaire` (
  `ID_STG` int(11) NOT NULL,
  `NOM_STG` varchar(50) NOT NULL CHECK (`NOM_STG` <> ''),
  `PRN_STG` varchar(50) NOT NULL CHECK (`PRN_STG` <> ''),
  `DNAISS_STG` date NOT NULL,
  `MAIL_STG` varchar(50) NOT NULL CHECK (`MAIL_STG` like '%_@_%._%'),
  `MDP_STG` varchar(255) NOT NULL CHECK (char_length(`MDP_STG`) >= 8),
  `IMG_STG` varchar(255) DEFAULT NULL,
  `TEL_STG` varchar(20) DEFAULT NULL CHECK (`TEL_STG` regexp '^[0-9+ -]{10,20}$'),
  `ID_ENC` int(11) NOT NULL,
  `ID_NIV` int(11) NOT NULL,
  `ID_GRP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stagiaire`
--

INSERT INTO `stagiaire` (`ID_STG`, `NOM_STG`, `PRN_STG`, `DNAISS_STG`, `MAIL_STG`, `MDP_STG`, `IMG_STG`, `TEL_STG`, `ID_ENC`, `ID_NIV`, `ID_GRP`) VALUES
(3, 'hello', 'test', '0000-00-00', 'heueue@gmail.com', '$2y$10$lbhPHLcGjAo9lI1nW06OeuFxFuX9vyqoKFzXZPH.tcoylw7feijs6', NULL, NULL, 1, 4, 18);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_ADM`),
  ADD UNIQUE KEY `MAIL_ADM` (`MAIL_ADM`);

--
-- Index pour la table `encadrant`
--
ALTER TABLE `encadrant`
  ADD PRIMARY KEY (`ID_ENC`),
  ADD UNIQUE KEY `MAIL_ENC` (`MAIL_ENC`),
  ADD UNIQUE KEY `TEL_ENC` (`TEL_ENC`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`ID_GRP`),
  ADD KEY `ID_NIV` (`ID_NIV`),
  ADD KEY `ID_STAGE` (`ID_STAGE`);

--
-- Index pour la table `messagerie`
--
ALTER TABLE `messagerie`
  ADD PRIMARY KEY (`ID_MSG`),
  ADD KEY `ID_ENC` (`ID_ENC`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`ID_NIV`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID_NOTIF`),
  ADD KEY `ID_ADM` (`ID_ADM`);

--
-- Index pour la table `poser`
--
ALTER TABLE `poser`
  ADD PRIMARY KEY (`ID_MSG`,`ID_STG`),
  ADD KEY `ID_STG` (`ID_STG`);

--
-- Index pour la table `recu`
--
ALTER TABLE `recu`
  ADD PRIMARY KEY (`ID_ENC`,`ID_NOTIF`),
  ADD KEY `ID_NOTIF` (`ID_NOTIF`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`ID_SER`),
  ADD KEY `ID_STAGE` (`ID_STAGE`);

--
-- Index pour la table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`ID_STAGE`);

--
-- Index pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`ID_STG`),
  ADD UNIQUE KEY `MAIL_STG` (`MAIL_STG`),
  ADD UNIQUE KEY `TEL_STG` (`TEL_STG`),
  ADD KEY `ID_ENC` (`ID_ENC`),
  ADD KEY `ID_NIV` (`ID_NIV`),
  ADD KEY `ID_GRP` (`ID_GRP`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_ADM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `encadrant`
--
ALTER TABLE `encadrant`
  MODIFY `ID_ENC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `ID_GRP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `messagerie`
--
ALTER TABLE `messagerie`
  MODIFY `ID_MSG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `ID_NIV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID_NOTIF` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `ID_SER` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stage`
--
ALTER TABLE `stage`
  MODIFY `ID_STAGE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `ID_STG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `groupe_ibfk_1` FOREIGN KEY (`ID_NIV`) REFERENCES `niveau` (`ID_NIV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupe_ibfk_2` FOREIGN KEY (`ID_STAGE`) REFERENCES `stage` (`ID_STAGE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `messagerie`
--
ALTER TABLE `messagerie`
  ADD CONSTRAINT `messagerie_ibfk_1` FOREIGN KEY (`ID_ENC`) REFERENCES `encadrant` (`ID_ENC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`ID_ADM`) REFERENCES `admin` (`ID_ADM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `poser`
--
ALTER TABLE `poser`
  ADD CONSTRAINT `poser_ibfk_1` FOREIGN KEY (`ID_MSG`) REFERENCES `messagerie` (`ID_MSG`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `poser_ibfk_2` FOREIGN KEY (`ID_STG`) REFERENCES `stagiaire` (`ID_STG`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `recu`
--
ALTER TABLE `recu`
  ADD CONSTRAINT `recu_ibfk_1` FOREIGN KEY (`ID_ENC`) REFERENCES `encadrant` (`ID_ENC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recu_ibfk_2` FOREIGN KEY (`ID_NOTIF`) REFERENCES `notification` (`ID_NOTIF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`ID_STAGE`) REFERENCES `stage` (`ID_STAGE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD CONSTRAINT `stagiaire_ibfk_1` FOREIGN KEY (`ID_ENC`) REFERENCES `encadrant` (`ID_ENC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stagiaire_ibfk_2` FOREIGN KEY (`ID_NIV`) REFERENCES `niveau` (`ID_NIV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stagiaire_ibfk_3` FOREIGN KEY (`ID_GRP`) REFERENCES `groupe` (`ID_GRP`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
