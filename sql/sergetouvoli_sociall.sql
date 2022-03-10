-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : dim. 06 mars 2022 à 22:13
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sergetouvoli_sociall`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `category_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_author`) VALUES
(1, 'Sport', 3),
(2, 'Politique', 3),
(3, 'Autres', 3);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `comment_valid` tinyint(4) NOT NULL DEFAULT '1',
  `comment_post` int(11) NOT NULL,
  `comment_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_date`, `comment_content`, `comment_valid`, `comment_post`, `comment_author`) VALUES
(8, '2022-03-06 21:53:04', 'test', 1, 12, 3);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `contact_date` datetime NOT NULL,
  `contact_object` varchar(50) NOT NULL,
  `contact_content` text NOT NULL,
  `contact_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`contact_id`, `contact_date`, `contact_object`, `contact_content`, `contact_author`) VALUES
(1, '2022-02-25 23:12:00', 'Premier Message', 'ckfsnyudbgoyidbiudfui dfhdsfbudfshbdf', 3),
(9, '2022-03-03 04:06:10', '&lt;script&gt; alert («XSS»); &lt;/script&gt;', '&lt;script&gt; alert («XSS»); &lt;/script&gt;', 3),
(10, '2022-03-03 22:34:46', 'Suggestion', 'ampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et m', 9);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `post_content` longtext NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`post_id`, `post_date`, `post_title`, `post_image`, `post_content`, `post_author`, `post_category`) VALUES
(10, '2022-03-02 22:32:09', 'ARTICLE', '621fe25992938-img22.jpeg', 'the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 3, 1),
(12, '2022-03-04 20:42:15', 'ARTICLE 2', '62226b97f0c63-img24.jpeg', 'Lorem Ipsum est simplement un faux texte de l\'industrie de l\'impression et de la composition. Le Lorem Ipsum est le texte factice standard de l\'industrie depuis les ann&eacute;es 1500, lorsqu\'un imprimeur inconnu a pris une gal&egrave;re de caract&egrave;res et l\'a brouill&eacute; pour en faire un livre de sp&eacute;cimens de caract&egrave;res. Il a surv&eacute;cu non seulement &agrave; cinq si&egrave;cles, mais aussi au saut dans la composition &eacute;lectronique, restant essentiellement inchang&eacute;. Il a &eacute;t&eacute; popularis&eacute; dans les ann&eacute;es 1960 avec la sortie de feuilles Letraset contenant des passages de Lorem Ipsum, et plus r&eacute;cemment avec des logiciels de publication assist&eacute;e par ordinateur comme Aldus PageMaker comprenant des versions de Lorem Ipsum.', 3, 2),
(13, '2022-03-04 20:42:28', 'ARTICLE 3', '62226ba45ae75-user.png', 'Lorem Ipsum est simplement un faux texte de l\'industrie de l\'impression et de la composition. Le Lorem Ipsum est le texte factice standard de l\'industrie depuis les ann&eacute;es 1500, lorsqu\'un imprimeur inconnu a pris une gal&egrave;re de caract&egrave;res et l\'a brouill&eacute; pour en faire un livre de sp&eacute;cimens de caract&egrave;res. Il a surv&eacute;cu non seulement &agrave; cinq si&egrave;cles, mais aussi au saut dans la composition &eacute;lectronique, restant essentiellement inchang&eacute;. Il a &eacute;t&eacute; popularis&eacute; dans les ann&eacute;es 1960 avec la sortie de feuilles Letraset contenant des passages de Lorem Ipsum, et plus r&eacute;cemment avec des logiciels de publication assist&eacute;e par ordinateur comme Aldus PageMaker comprenant des versions de Lorem Ipsum.', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_mail` varchar(100) NOT NULL,
  `user_avatar` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` varchar(250) NOT NULL DEFAULT 'user',
  `user_valid` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_lastname`, `user_firstname`, `user_mail`, `user_avatar`, `user_password`, `user_role`, `user_valid`) VALUES
(3, 'Touvoli', 'Serge', 'sergetouvoli@outlook.fr', 'serge2.jpg', '$2y$10$LAvTVd8glrJrAVydmGK/w.xYMZk0aGjWvjRwMmCpbcttSIhhj7qua', 'admin', 1),
(4, 'Ballo', 'TOUVOLI', 'stouvoli@gmail.com', 'silhouette.png', '$2y$10$lwttk86jknl4lo8JaRr6reyDTMFqtKnrv6iuvbxnWh9bfIZWNddmS', 'user', 1),
(5, 'Bi Ballo Charles', 'TOUVOLI', 'drtouvoli@yahoo.fr', 'silhouette.png', '$2y$10$pWUeZZizjOnA2TAdVYD2t.pLZgzM4yl3UltyXcGjfwZfCAcv1U35u', 'user', 1),
(7, 'François', 'TOUVOLI', 'serget513@gmail.com', '622132dc61352-img.jpg', '$2y$10$WEUdrCb5U74GrPt3zlcjTOMVwiTFA41ZE48Y2sJIW9G5ggLvC6AOK', 'user', 1),
(9, 'Daphnee', 'KONAN', 'daphneekonan@gmail.com', 'silhouette.png', '$2y$10$nnzYhhD2nKM2TP8Jdvz.SeSg97nGuHyYeq70DFxJKyorxW7691CgW', 'user', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_author` (`category_author`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_author` (`comment_author`),
  ADD KEY `comment_post` (`comment_post`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_author` (`contact_author`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_author` (`post_author`),
  ADD KEY `post_category` (`post_category`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_author` FOREIGN KEY (`category_author`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_author` FOREIGN KEY (`comment_author`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`comment_post`) REFERENCES `posts` (`post_id`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_author` FOREIGN KEY (`contact_author`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_author` FOREIGN KEY (`post_author`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `post_category` FOREIGN KEY (`post_category`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
