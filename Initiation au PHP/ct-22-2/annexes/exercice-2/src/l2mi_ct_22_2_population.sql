-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 31 mai 2023 à 17:59
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `l2mi_ct_22_2_population`
--
CREATE DATABASE IF NOT EXISTS `l2mi_ct_22_2_population` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `l2mi_ct_22_2_population`;

-- --------------------------------------------------------

--
-- Structure de la table `VILLE`
--

CREATE TABLE `VILLE` (
  `id_ville` int(8) NOT NULL,
  `nom_ville` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `nom_region` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `population` int(8) NOT NULL,
  `prefecture` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `VILLE`
--

INSERT INTO `VILLE` (`id_ville`, `nom_ville`, `nom_region`, `population`, `prefecture`) VALUES
(1, 'Nantes', 'Pays de la Loire', 282047, 1),
(2, 'Avignon', 'Provence-Alpes-Côte d\'Azur', 89592, 1),
(3, 'Marseille', 'Provence-Alpes-Côte d\'Azur', 850602, 1),
(4, 'Toulon', 'Provence-Alpes-Côte d\'Azur', 165514, 1),
(5, 'Cholet', 'Pays de la Loire', 60000, 0),
(6, 'Angers', 'Pays de la Loire', 155876, 1),
(7, 'Les Ponts-de-Cé', 'Pays de la Loire', 12589, 0),
(8, 'Montaigu', 'Pays de la Loire', 5211, 0),
(9, 'Paris', 'Ile-de-France', 2145906, 1),
(10, 'Nanterre', 'Ile-de-France', 95782, 1),
(11, 'Fleury-Mérogis', 'Ile-de-France', 13708, 0),
(12, 'Versailles', 'Ile-de-France', 83583, 0),
(13, 'Falaise', 'Normandie', 7849, 0),
(14, 'Caen', 'Normandie', 107250, 1),
(15, 'Oissel', 'Normandie', 12266, 0),
(16, 'Rouen', 'Normandie', 114187, 1),
(17, 'Aix-en-Provence', 'Provence-Alpes-Côte d\'Azur', 147122, 0),
(18, 'Embrun', 'Provence-Alpes-Côte d\'Azur', 6435, 0),
(19, 'Bollène', 'Provence-Alpes-Côte d\'Azur', 13830, 0),
(20, 'Sanary-sur-Mer', 'Provence-Alpes-Côte d\'Azur', 17173, 0),
(21, 'Lézardrieux', 'Bretagne', 1532, 0),
(22, 'Saint-Brieuc', 'Bretagne', 44166, 1),
(23, 'Brest', 'Bretagne', 139456, 0),
(24, 'Quimper', 'Bretagne', 63473, 1),
(25, 'Fougères', 'Bretagne', 20505, 0),
(26, 'Rennes', 'Bretagne', 222485, 1),
(27, 'Bono', 'Bretagne', 2533, 0),
(28, 'Vannes', 'Bretagne', 54017, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `VILLE`
--
ALTER TABLE `VILLE`
  ADD PRIMARY KEY (`id_ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `VILLE`
--
ALTER TABLE `VILLE`
  MODIFY `id_ville` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
