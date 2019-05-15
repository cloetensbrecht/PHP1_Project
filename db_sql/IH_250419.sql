-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 25, 2019 at 09:15 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `InspirationHunter`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `likes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `foto`, `tags`, `time`, `likes_id`) VALUES
(1, 234466, 'https://www.db-m.nl/wp-content/uploads/2014/10/geenfoto-1024x683.jpg', '#image #profiel #me', '2019-04-24 00:00:00', 3),
(2, 234466, 'https://www.db-m.nl/wp-content/uploads/2014/10/geenfoto-1024x683.jpg', '#image #profiel #me', '2019-04-24 00:00:00', 3),
(3, 324, 'https://dsocdn.akamaized.net/Assets/Images_Upload/2017/07/13/c5d28dac-67b9-11e7-8c3c-11de46a62a49_web_translate_-1.1e-5_-4e-6__scale_0.4669987_0.4669987__.jpg?maxheight=416&maxwidth=568', 'aap profiel #myfaceispretty', '2019-04-17 00:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `POSTID` int(3) NOT NULL,
  `POSTTITLE` varchar(100) NOT NULL,
  `POSTDETAILS` varchar(10000) NOT NULL,
  `POSTLINK` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `postText` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `postText`, `time`) VALUES
(1, 'dit is de titel', 'bla bla bla', '2019-04-24 17:39:32'),
(2, 'PHP Lover', 'i love php ', '2019-04-24 17:39:57'),
(3, 'PHP lover', 'We love php', '2019-04-24 17:53:24'),
(4, 'Ajax', 'we love ajax', '2019-04-24 17:53:24'),
(5, 'PHP lover', 'We love php', '2019-04-24 17:53:30'),
(6, 'Ajax', 'we love ajax', '2019-04-24 17:53:30'),
(7, 'PHP lover', 'We love php', '2019-04-24 17:53:43'),
(8, 'Ajax', 'we love ajax', '2019-04-24 17:53:43'),
(9, 'PHP lover', 'We love php', '2019-04-24 17:53:43'),
(10, 'Ajax', 'we love ajax', '2019-04-24 17:53:43'),
(11, 'PHP lover', 'We love php', '2019-04-24 17:53:43'),
(12, 'Ajax', 'we love ajax', '2019-04-24 17:53:43'),
(13, 'PHP lover', 'We love php', '2019-04-24 17:53:43'),
(14, 'Ajax', 'we love ajax', '2019-04-24 17:53:43'),
(15, 'PHP lover', 'We love php', '2019-04-24 17:53:53'),
(16, 'Ajax', 'we love ajax', '2019-04-24 17:53:53'),
(17, 'PHP lover', 'We love php', '2019-04-24 17:53:53'),
(18, 'Ajax', 'we love ajax', '2019-04-24 17:53:53'),
(19, 'PHP lover', 'We love php', '2019-04-24 17:53:53'),
(20, 'Ajax', 'we love ajax', '2019-04-24 17:53:53'),
(21, 'PHP lover', 'We love php', '2019-04-24 17:53:53'),
(22, 'Ajax', 'we love ajax', '2019-04-24 17:53:53'),
(23, 'PHP lover', 'We love php', '2019-04-24 17:54:03'),
(24, 'Ajax', 'we love ajax', '2019-04-24 17:54:03'),
(25, 'PHP lover', 'We love php', '2019-04-24 17:54:03'),
(26, 'Ajax', 'we love ajax', '2019-04-24 17:54:03'),
(27, 'PHP lover', 'We love php', '2019-04-24 17:54:03'),
(28, 'Ajax', 'we love ajax', '2019-04-24 17:54:03'),
(29, 'PHP lover', 'We love php', '2019-04-24 17:54:03'),
(30, 'Ajax', 'we love ajax', '2019-04-24 17:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'eleni', 'eleni'),
(2, 'eleni@gmail.com', 'testtest'),
(3, 'eleni@gmail.com', 'testtest'),
(4, '', '$2y$12$qh1BPSpf1CWMPTJE.EX1EezEVc2EleYbRVTCaEdRyi3b7.VgvqVy.'),
(5, '', '$2y$12$7VftaAjJ6UzHCuJhbo2PKuLauhMZOBHgc65vE8k6HIg3iLx4fyU8S'),
(6, '', '$2y$12$HywkLzRNm.RzY5FFj9W1GOK2rw43ewZmoKbnct.kzAyicsYIw12Ue'),
(7, '', '$2y$12$SKptcOX9jjfZR75rt8hrq.fZ0fV5CODkkzjtrM39sJEnOCi1woKzS'),
(8, 'eleni.bosschaerts@gmail.com', '$2y$12$NhgsksBDXR9oM73Cy3NYQ.fH88BwvGTinki2f/QqVv1LQ7NC3Si8u'),
(9, 'lksjf', '$2y$12$Pp5poLR40w/.yDF0EkUd6.fIvdrWDjPYofLCHpjwBksm83ll5oQPS'),
(10, 'eleni', '$2y$12$Ir/O40AbcU2YUA7agbEwqOL05MYEl5hrSTJmY1X1CFs9596aNYCg6'),
(11, 'eleni@info.be', '$2y$12$DH1tzyu.ES275jS/IELVSOOHicEUA7fLDbrha7GXMkFV3juvOOHPi'),
(12, 'eleni@gmail.com', '$2y$12$sYt.3tvJsbdJIXfA2B4bA.5r14.N.wJd0OPA9Y.WSgZ9oTmrFuDR6'),
(13, 'Lotte@gmail.com', '$2y$12$DtnTnAJfOjgf1t3Ya6.I3eo3/qFAKJKIdvgxOWTWYXt7oZnvr5a7u'),
(14, '', '$2y$12$NZle/VmOPpXeRUjxmolzQeoQZeWEbRkLQ0dEq2BWZNvUI7VqMWb1W'),
(15, 'jasper@hotmail.com', '$2y$12$FpBsC1469lKOk40VfsM5UOXEXfVsSuhTUHn.Cp8s9LuNqY78OaocW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
