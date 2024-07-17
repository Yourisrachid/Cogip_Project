-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 17 juil. 2024 à 20:09
-- Version du serveur : 11.3.2-MariaDB
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cogip`
--
CREATE DATABASE IF NOT EXISTS `cogip` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cogip`;

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `tva` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `companies`
--

TRUNCATE TABLE `companies`;
--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `name`, `type_id`, `country`, `tva`, `created_at`, `updated_at`) VALUES
(3, 'Upton-Turner', 1, 'Honduras', 'CL795682410', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(4, 'Kling, Greenfelder and Gleason', 2, 'Bermuda', 'NZ912961268', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(5, 'Bailey-Luettgen', 1, 'Bermuda', 'LB112387129', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(6, 'Zboncak and Sons', 1, 'Senegal', 'IM313853362', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(7, 'Halvorson, Walker and Howe', 2, 'Cyprus', 'CR335279487', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(8, 'Barton Ltd', 1, 'French Southern Territories', 'SR709997008', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(9, 'Koch, Rath and Frami', 1, 'Tuvalu', 'GI138660910', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(10, 'Weissnat Group', 1, 'Finland', 'AQ544204196', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(11, 'Thiel-Wisoky', 2, 'Venezuela', 'CV825448302', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(12, 'Feest-Fritsch', 1, 'Ecuador', 'NL282258282', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(13, 'Fisher-Mills', 2, 'Honduras', 'BB583660818', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(14, 'Witting Inc', 2, 'India', 'GY941356058', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(15, 'Schoen, Lynch and Zemlak', 2, 'Somalia', 'RW873465971', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(16, 'Schuster Group', 1, 'Palau', 'SJ686378686', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(17, 'Thompson and Sons', 2, 'Burkina Faso', 'PR899782589', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(18, 'Hansen Inc', 1, 'United Kingdom', 'MS710123664', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(19, 'Greenfelder-Trantow', 2, 'Andorra', 'AD732299906', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(20, 'Hand-Waters', 2, 'Costa Rica', 'AO910974823', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(21, 'Kshlerin, Lakin and Friesen', 2, 'Martinique', 'GP198022571', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(22, 'Blanda PLC', 1, 'Belize', 'MA306229002', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(23, 'Kulas-Lehner', 2, 'Burundi', 'BL199673227', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(24, 'Funk Group', 1, 'Panama', 'SL791702283', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(25, 'Weimann and Sons', 1, 'Hong Kong', 'RS323524377', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(26, 'Fahey, Hickle and Waters', 1, 'Tajikistan', 'AU399560876', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(27, 'Denesik LLC', 1, 'Eritrea', 'MC352664637', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(28, 'Herman-Pfeffer', 2, 'Macedonia', 'JM258289718', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(29, 'Wehner-Mosciski', 1, 'Yemen', 'AE900108841', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(30, 'O\'Hara, Zboncak and Feest', 1, 'China', 'VG189260050', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(31, 'Thiel, Schoen and Klein', 1, 'Saint Helena', 'NI762869200', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(32, 'Jacobi-Morar', 2, 'Yemen', 'NA258222146', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(33, 'Walter, Robel and Botsford', 1, 'Kuwait', 'MU478976309', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(34, 'Boyer Group', 2, 'Sierra Leone', 'AL661277543', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(35, 'Lueilwitz Group', 2, 'Antarctica (the territory South of 60 deg S)', 'CC668321111', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(36, 'Monahan, Osinski and Heidenreich', 2, 'Central African Republic', 'GA202232057', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(37, 'Conn, Bernier and Hills', 2, 'Malta', 'DJ556463643', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(38, 'Okuneva Group', 1, 'Heard Island and McDonald Islands', 'KH662498703', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(39, 'Hansen PLC', 2, 'Azerbaijan', 'CK124529531', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(40, 'Conn, Schiller and Lindgren', 2, 'Saint Lucia', 'HN933015226', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(41, 'Runolfsdottir Inc', 1, 'Belize', 'BN307367066', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(42, 'Lind-Heller', 2, 'Sudan', 'RU402450151', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(43, 'Batz, Ward and Von', 2, 'Saint Pierre and Miquelon', 'MZ231429644', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(44, 'Rippin, Hansen and Koch', 1, 'Georgia', 'HR917144378', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(45, 'Terry-Quigley', 1, 'Antarctica (the territory South of 60 deg S)', 'BJ159263078', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(46, 'Schaden-Beahan', 1, 'New Caledonia', 'CZ427824030', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(47, 'Farrell Group', 1, 'South Africa', 'IQ809993931', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(48, 'Hayes, Harber and Pfeffer', 2, 'Libyan Arab Jamahiriya', 'KZ321644094', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(49, 'Raynor Ltd', 2, 'Sao Tome and Principe', 'SH287940101', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(50, 'Franecki Inc', 1, 'Gambia', 'CK194316605', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(51, 'Durgan, Larkin and Johnson', 1, 'Kuwait', 'SL174074433', '2024-07-17 20:51:42', '2024-07-17 20:51:42'),
(52, 'Haag, Dibbert and Schimmel', 1, 'New Caledonia', 'DZ175463343', '2024-07-17 20:51:42', '2024-07-17 20:51:42');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `contacts`
--

TRUNCATE TABLE `contacts`;
--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `company_id`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Chasity Stamm', 15, 'desmond12@nader.biz', '661-902-5678', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(2, 'Glenda Jakubowski', 23, 'sydni.sauer@kovacek.com', '(938) 226-1911', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(3, 'Anjali Friesen', 36, 'leonardo28@von.com', '+16182748644', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(4, 'Wilbert Morar', 51, 'dejuan.blanda@yahoo.com', '704.324.3036', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(5, 'Gwen Parker', 22, 'demarco.langworth@gmail.com', '+1.951.314.3717', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(6, 'Reva Hane', 29, 'maymie14@hotmail.com', '+1.281.961.6707', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(7, 'Deanna Beer', 39, 'malika.kohler@ritchie.info', '+1-732-891-0187', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(8, 'Christ Kertzmann', 36, 'szieme@mitchell.org', '+1-432-363-2463', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(9, 'Rickie Satterfield', 44, 'rosalia48@gmail.com', '+1 (619) 821-0823', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(10, 'Christy Durgan', 41, 'astrid07@carroll.com', '+1.940.254.4213', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(11, 'Reed Nader', 23, 'ygleason@terry.org', '(619) 356-6896', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(12, 'Mary Feeney', 4, 'kovacek.barton@berge.com', '1-504-645-6896', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(13, 'Camryn White', 7, 'becker.oliver@walter.com', '+1-941-802-2543', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(14, 'Malinda Beier', 19, 'xlabadie@lind.com', '551.799.6612', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(15, 'Alanna O\'Reilly', 15, 'hamill.alessandro@hotmail.com', '520-700-3454', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(16, 'Nathanael Hermann', 23, 'glehner@bednar.com', '775.659.3742', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(17, 'Will Becker', 47, 'trosenbaum@gmail.com', '951.680.7523', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(18, 'Carole Hansen', 5, 'ledner.mafalda@yahoo.com', '(925) 725-1968', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(19, 'Roy Dare', 50, 'edgardo.halvorson@price.com', '(458) 393-7966', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(20, 'King Roberts', 35, 'tiara.bogan@rohan.com', '+1-361-286-7677', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(21, 'Norwood Mann', 40, 'kovacek.kaleb@gmail.com', '(559) 832-7238', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(22, 'Jordane Kuhn', 52, 'annabelle.davis@hotmail.com', '+18183790694', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(23, 'Trevion Little', 46, 'dana.goldner@dicki.com', '+1.763.500.1046', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(24, 'Waldo Lynch', 8, 'lela.rodriguez@yahoo.com', '531.761.4204', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(25, 'Jordan Mraz', 50, 'ubuckridge@quigley.com', '626.212.7920', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(26, 'Madilyn Kertzmann', 15, 'fritsch.vicente@gmail.com', '234-746-6939', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(27, 'Bobbie Raynor', 28, 'jesse45@yost.org', '(629) 314-4408', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(28, 'Erna Goyette', 31, 'tremblay.lurline@hotmail.com', '+1 (940) 225-4239', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(29, 'Imani Lubowitz', 19, 'beahan.larue@hotmail.com', '1-901-423-0380', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(30, 'Alvis Von', 48, 'abbey78@donnelly.com', '+1.984.647.1458', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(31, 'Triston Champlin', 19, 'wiza.rossie@baumbach.com', '(941) 971-9701', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(32, 'Lukas Armstrong', 48, 'kirsten.wilderman@schmidt.net', '+1-484-261-2150', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(33, 'Joe Emard', 19, 'jessika.welch@schiller.com', '316.577.6945', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(34, 'Pansy Nicolas', 22, 'libbie.schowalter@ziemann.com', '559-789-2289', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(35, 'Filomena Kertzmann', 42, 'nnader@dietrich.org', '828.764.8544', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(36, 'Elfrieda Kirlin', 38, 'aletha73@connelly.com', '1-678-774-2017', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(37, 'Fatima Bailey', 10, 'estoltenberg@hotmail.com', '878.654.6350', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(38, 'Raoul Kozey', 16, 'blanda.ima@dicki.net', '(878) 897-3172', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(39, 'Omari Tromp', 8, 'yundt.halle@hotmail.com', '1-872-279-4977', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(40, 'Neal Okuneva', 23, 'laron.osinski@gmail.com', '1-351-303-6718', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(41, 'Francesco Conroy', 42, 'madeline.crooks@hotmail.com', '+1-909-284-8166', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(42, 'Ryan Ward', 19, 'buckridge.melyssa@gmail.com', '1-951-964-1296', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(43, 'Alene Rowe', 29, 'louie63@gmail.com', '+1-813-285-8176', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(44, 'Dallas Kirlin', 23, 'block.tevin@bauch.com', '503.705.7155', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(45, 'Wendell Macejkovic', 5, 'fmccullough@yahoo.com', '+16144601566', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(46, 'Zakary Sporer', 21, 'conn.colleen@robel.biz', '1-240-908-6407', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(47, 'Lilian Hettinger', 18, 'teresa72@friesen.biz', '607-428-0099', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(48, 'Rowan Collins', 14, 'myrna.luettgen@pacocha.com', '+15397632378', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(49, 'Tanner Sporer', 36, 'godfrey59@hotmail.com', '+1-540-471-0918', '2024-07-17 21:27:03', '2024-07-17 21:27:03'),
(50, 'Christina Daniel', 32, 'wilton.gutmann@yahoo.com', '239.831.2196', '2024-07-17 21:27:03', '2024-07-17 21:27:03');

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `id_company` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `invoices`
--

TRUNCATE TABLE `invoices`;
-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `permissions`
--

TRUNCATE TABLE `permissions`;
-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `roles`
--

TRUNCATE TABLE `roles`;
-- --------------------------------------------------------

--
-- Structure de la table `roles_permission`
--

DROP TABLE IF EXISTS `roles_permission`;
CREATE TABLE `roles_permission` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `roles_permission`
--

TRUNCATE TABLE `roles_permission`;
-- --------------------------------------------------------

--
-- Structure de la table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `role_permission`
--

TRUNCATE TABLE `role_permission`;
-- --------------------------------------------------------

--
-- Structure de la table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `types`
--

TRUNCATE TABLE `types`;
--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'supplier', '2024-07-17 18:33:35', '2024-07-17 18:33:35'),
(2, 'customer', '2024-07-17 18:33:35', '2024-07-17 18:33:35');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tronquer la table avant d'insérer `users`
--

TRUNCATE TABLE `users`;
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles_permission`
--
ALTER TABLE `roles_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_id` (`permission_id`,`role_id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles_permission`
--
ALTER TABLE `roles_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `roles_permission`
--
ALTER TABLE `roles_permission`
  ADD CONSTRAINT `roles_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `roles_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
