-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 15, 2019 at 12:23 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET time_zone
= "+00:00";

--
-- Database: `InspirationHunter`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments`
(
  `id` int
(11) NOT NULL,
  `user_id` int
(11) NOT NULL,
  `post_id` int
(11) NOT NULL,
  `test` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends`
(
  `id` int
(11) NOT NULL,
  `user_id` int
(11) NOT NULL,
  `user_id_friend` int
(11) NOT NULL,
  `status` tinyint
(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`
id`,
`user_id
`, `user_id_friend`, `status`) VALUES
(1, 15, 16, 1),
(3, 16, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes`
(
  `id` int
(11) NOT NULL,
  `user_id` int
(11) NOT NULL,
  `status` tinyint
(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts`
(
  `id` int
(11) NOT NULL,
  `image` varchar
(255) NOT NULL,
  `description` varchar
(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filter` varchar
(100) NOT NULL,
  `user_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`
id`,
`image
`, `description`, `time`, `filter`, `user_id`) VALUES
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
(99, 'maldives-1993704_1280.jpg', 'maladiven', '2019-05-06 15:10:15', 'Lark', 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
  `id` int
(11) NOT NULL,
  `email` varchar
(255) NOT NULL,
  `password` varchar
(255) NOT NULL,
  `profilePicture` varchar
(255) NOT NULL,
  `bio` text NOT NULL,
  `firstName` varchar
(255) NOT NULL,
  `lastName` varchar
(255) NOT NULL,
  `username` varchar
(255) NOT NULL,
  `mobile` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`
id`,
`email
`, `password`, `profilePicture`, `bio`, `firstName`, `lastName`, `username`, `mobile`) VALUES
(12, 'eleni@gmail.com', '$2y$12$sYt.3tvJsbdJIXfA2B4bA.5r14.N.wJd0OPA9Y.WSgZ9oTmrFuDR6', '', '', '', '', '', 0),
(14, 'Naamloos', '$2y$12$NZle/VmOPpXeRUjxmolzQeoQZeWEbRkLQ0dEq2BWZNvUI7VqMWb1W', '', '', '', '', '', 0),
(15, 'jasper@hotmail.com', '$2y$12$FpBsC1469lKOk40VfsM5UOXEXfVsSuhTUHn.Cp8s9LuNqY78OaocW', 'iceland_husavik-3654390_1280.jpg', 'kj', 'Jasper', 'Van den boss', 'JasperVDB', 2349384),
(16, 'ellen@gmail.com', '', 'abu_Dhabi_mosque-615415_1280.jpg', 'TEST', 'Ellen', 'TheuwenDeBeste', 'EllenIsTheBest', 4111111),
(17, 'Lotte@gmail.com', '$2y$12$DtnTnAJfOjgf1t3Ya6.I3eo3/qFAKJKIdvgxOWTWYXt7oZnvr5a7u', '', 'Lotte', 'Lotte', '', 'Lotte', 123456),
(18, 'eleni@gmail.com', '$2y$12$sYt.3tvJsbdJIXfA2B4bA.5r14.N.wJd0OPA9Y.WSgZ9oTmrFuDR6', '', '', 'Eleni', '', 'Eleni', 12345);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY
(`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
