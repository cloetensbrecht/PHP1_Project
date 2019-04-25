-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 25, 2019 at 09:12 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `InspirationHunter`
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
