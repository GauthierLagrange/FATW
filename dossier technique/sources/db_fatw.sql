-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 28 avr. 2023 à 10:49
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_fatw`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `idImg` int(11) NOT NULL,
  `lien_img_de_profil` varchar(50) NOT NULL,
  `lien_img_de_face` varchar(40) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prix` int(11) NOT NULL,
  `theme` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`idImg`, `lien_img_de_profil`, `lien_img_de_face`, `nom`, `prix`, `theme`) VALUES
(1, 'img/Plane/BluePlane1.png', '0', 'BluePlane', 0, 'defaut'),
(2, 'img/Plane/PurplePlane.png', '0', 'PurplePlane', 0, 'defaut'),
(3, 'img/Plane/GreenPlane.png', '0', 'GreenPlane', 0, 'defaut'),
(4, 'img/Plane/OrangePlane.png', '0', 'OrangePlane', 0, 'defaut'),
(5, 'img/Plane/RedPlane.png', '0', 'RedPlane', 0, 'defaut'),
(6, 'img/Plane/lapointedefeuille.png', '', 'La Pointe de Feuille', 250, 'avion'),
(7, 'img/Plane/leblanc.png', '', 'Le Blanc', 500, 'avion'),
(8, 'img/Plane/etoileduciel.png', '', 'Etoile du Ciel', 750, 'avion'),
(9, 'img/Plane/Harpie.png', '', 'Harpie', 1000, 'avion'),
(10, 'img/Personnage/Ernest.png', 'img/Personnage/Ernest.png', 'Ernest', 400, 'personnage'),
(11, 'img/Personnage/Poppy.png', 'img/Personnage/Poppy.png', 'Poppy', 400, 'personnage'),
(12, 'img/Personnage/Asher.png', 'img/Personnage/Asher.png', 'Asher', 400, 'personnage'),
(13, 'img/Personnage/Blue.png', 'img/Personnage/Blue.png', 'Blue', 0, 'defaut_perso'),
(14, 'img/Personnage/Purple.png', 'img/Personnage/Purple.png', 'Purple', 0, 'defaut_perso'),
(15, 'img/Personnage/Green.png', 'img/Personnage/Green.png', 'Green', 0, 'defaut_perso'),
(16, 'img/Personnage/Orange.png', 'img/Personnage/Orange.png', 'Orange', 0, 'defaut_perso'),
(17, 'img/Personnage/Red.png', 'img/Personnage/Red.png', 'Red', 0, 'defaut_perso');

-- --------------------------------------------------------

--
-- Structure de la table `image_possede`
--

CREATE TABLE `image_possede` (
  `idImg` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `favori` tinyint(1) NOT NULL DEFAULT 0,
  `equipe` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `total_games`
--

CREATE TABLE `total_games` (
  `idPlayer` int(11) NOT NULL,
  `Score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_data`
--

CREATE TABLE `user_data` (
  `idUser` int(11) NOT NULL,
  `Pseudo` varchar(20) NOT NULL,
  `Mail` varchar(30) NOT NULL,
  `MDP` varchar(100) NOT NULL,
  `Nationalite` varchar(20) NOT NULL,
  `Money` int(11) NOT NULL,
  `theme_jeu` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`idImg`);

--
-- Index pour la table `image_possede`
--
ALTER TABLE `image_possede`
  ADD PRIMARY KEY (`idImg`,`idUser`),
  ADD KEY `fk_idUser_image_possede` (`idUser`);

--
-- Index pour la table `total_games`
--
ALTER TABLE `total_games`
  ADD KEY `fk_idPlayer_total.games` (`idPlayer`);

--
-- Index pour la table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `idImg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `image_possede`
--
ALTER TABLE `image_possede`
  ADD CONSTRAINT `fk_idImg_image_possede` FOREIGN KEY (`idImg`) REFERENCES `image` (`idImg`),
  ADD CONSTRAINT `fk_idUser_image_possede` FOREIGN KEY (`idUser`) REFERENCES `user_data` (`idUser`);

--
-- Contraintes pour la table `total_games`
--
ALTER TABLE `total_games`
  ADD CONSTRAINT `fk_idPlayer_total.games` FOREIGN KEY (`idPlayer`) REFERENCES `user_data` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
