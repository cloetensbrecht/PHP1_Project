-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Machine: sql307.epizy.com
-- Genereertijd: 16 mei 2019 om 04:08
-- Serverversie: 5.6.41-84.1
-- PHP-versie: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `epiz_23910941_travelinspiration`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_id_friend` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `user_id_friend`, `status`) VALUES
(1, 15, 16, 1),
(3, 16, 15, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filter` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Gegevens worden uitgevoerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `image`, `description`, `time`, `filter`, `user_id`) VALUES
(83, 'inspire.png', 'beetje inspiratie ', '2019-05-02 08:55:55', 'test', 15),
(87, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-05 13:57:42', 'Lark', 16),
(88, 'dominicanRepublic_beach-1236581_1280.jpg', 'B&W', '2019-05-05 13:59:34', 'Willow', 15),
(89, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-05 13:57:42', 'Lark', 16),
(90, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-05 13:57:42', 'Lark', 16),
(91, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-05 13:57:42', 'Lark', 16),
(92, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:10', 'Lark', 16),
(93, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'Lark', 16),
(94, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-14 15:10:15', 'Lark', 17),
(95, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'Lark', 16),
(96, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'gingham', 16),
(97, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'Lark', 16),
(98, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-14 15:10:15', 'Lark', 16),
(99, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'Lark', 16),
(100, '59649478_2320141851645531_1153026735600566272_n.jpg', 'pretty please', '2019-05-16 07:18:36', 'Nashville', 0),
(101, 'how-to-travel-for-free.jpg', '', '2019-05-16 07:21:04', 'Lo-Fi', 0),
(102, 'fullscreen_square_retina-Arashi Beach Shoreline.jpg', 'nice beach', '2019-05-16 07:23:46', '1977', 0),
(103, 'fullscreen_square_retina-Arashi Beach Shoreline.jpg', 'nice beach', '2019-05-16 07:24:16', 'noFilter', 0),
(104, 'how-to-travel-for-free.jpg', 'ik kan dit vak ni zien', '2019-05-16 07:24:18', 'Lo-Fi', 0),
(105, 'Schermafbeelding 2019-05-15 om 10.05.51.png', 'dedede', '2019-05-16 07:26:47', 'Kelvin', 0),
(106, 'Schermafbeelding 2019-05-15 om 10.05.51.png', 'dejndewjdnw', '2019-05-16 07:30:23', 'Aden', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePicture` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mobile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `profilePicture`, `bio`, `firstName`, `lastName`, `username`, `mobile`) VALUES
(12, 'eleni@gmail.com', '$2y$12$sYt.3tvJsbdJIXfA2B4bA.5r14.N.wJd0OPA9Y.WSgZ9oTmrFuDR6', '', '', '', '', '', 0),
(14, 'Naamloos', '$2y$12$NZle/VmOPpXeRUjxmolzQeoQZeWEbRkLQ0dEq2BWZNvUI7VqMWb1W', '', '', '', '', '', 0),
(15, 'jasper@hotmail.com', '$2y$12$FpBsC1469lKOk40VfsM5UOXEXfVsSuhTUHn.Cp8s9LuNqY78OaocW', 'iceland_husavik-3654390_1280.jpg', 'kj', 'Jasper', 'Van den boss', 'JasperVDB', 2349384),
(16, 'ellen@gmail.com', '', 'abu_Dhabi_mosque-615415_1280.jpg', 'TEST', 'Ellen', 'TheuwenDeBeste', 'EllenIsTheBest', 4111111),
(17, 'Lotte@gmail.com', '$2y$12$DtnTnAJfOjgf1t3Ya6.I3eo3/qFAKJKIdvgxOWTWYXt7oZnvr5a7u', '', 'Lotte', 'Lotte', '', 'Lotte', 123456),
(18, 'eleni@gmail.com', '$2y$12$sYt.3tvJsbdJIXfA2B4bA.5r14.N.wJd0OPA9Y.WSgZ9oTmrFuDR6', '', '', 'Eleni', '', 'Eleni', 12345),
(20, 'tester@test.be<script>alert(''nice hack!'')</script>', '$2y$12$FpBsC1469lKOk40VfsM5UOXEXfVsSuhTUHn.Cp8s9LuNqY78OaocW', '', '<script>alert(''nice hack!'')</script>', '<script>alert(''nice hack!'')</script>', '<script>alert(''nice hack!'')</script>', '<script>alert(''nice hack!'')</script>', 0),
(23, 'vanlooa20@gmail.com', '$2y$12$8ZqSoqP4QjsnWm3BBfPL.uHb49HfkYciyE1WF4b4S6k3/3BBmGZ32', '', '', '', '', '', 0),
(22, 'tester@test.be', '$2y$12$FpBsC1469lKOk40VfsM5UOXEXfVsSuhTUHn.Cp8s9LuNqY78OaocW', '', '', '', '', '', 1234567),
(24, 'test@gmail.com', '$2y$12$XEtKe107UNvmiZDbEne.1OcweFdh5ExaLNluOVmHT7rLXDQRRdZ3m', '', '', '', '', '', 0),
(25, 'tester@test.be', '$2y$12$R.CXL18/V.jgW2t0zuCwV.U0FLGhz1I4goMrHsBo./fqCkn/.n8v.', '', '', '', '', '', 0),
(26, 'tester@test.be', '$2y$12$CyL2kl75zebCnLOli4c6cu/tO.sVw/rKUb40TnK5um1HD1nxnUGQy', '', '', '', '', '', 0),
(27, 'tester@test.be', '$2y$12$eJmSdoy2xR9qA.SZ21CzPe8.hoVBKG2Xb3Vts5URvS474sCjFg8oW', '', '', '', '', '', 0),
(28, 'wannes.vandael@gmail.com', '$2y$12$MGTFtAB0ArOA64bmdc1P4OPoaXFWRjDC.lOYoYXNEH4jCQCrzciDK', '', '', '<script>alert(''nice hack!'')</script>', '<script>alert(''nice hack!'')</script>', '<script>alert(''nice hack!'')</script>', 474468769);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
