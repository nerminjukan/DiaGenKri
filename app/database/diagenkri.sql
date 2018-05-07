-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 28. apr 2018 ob 22.30
-- Različica strežnika: 10.1.22-MariaDB
-- Različica PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `diagenkri`
--

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `e-mail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `e-mail`, `password`) VALUES
(7, 'Nermin', 'Jukan', 'nermin.jukan@mail.si', '$2y$10$JLY1v.riSAokIaXDrWAttOXUooz7u075xduhf.zE0b65QX.f33EXu'),
(8, 'test', 'test', 'test@test', '$2y$10$2JEoPoPmmJp5rJr1ZSTzg.pCGZRFDFAuDUg6woD8Zj5XtEWynJNrq'),
(21, 'wdaawf', 'afawf', 'faawf@awdawd', '$2y$10$dmaicJ5BTZm4LiAUKhcQhui2p7H4lPpkmJ3nCi4KkXloA/0PsheFq'),
(22, 'wdwd', 'wdwd', 'dwdwdwd@dwdwd', '$2y$10$n.E3jsLYzH3gXn/AjMEXQe9X6XaSQr6KNLd2PsPwVCsMICpIW3yAm'),
(23, 'asd', 'asd', 'asd@dsa', '$2y$10$80YHa9rTkett64iKYief6.2ArF5iSQ0U0LaHH0gNudjxzsDUMW/56'),
(24, 'ssss', 'ssss', 'ssss@ssss', '$2y$10$JwDv1h26qt8QiuwKgMEAc.eBwVlc7qGUZrXyhK4JuX9znxB1sfUKq'),
(25, 'ddddeee', 'ddddeee', 'ddddeee@ddddeee', '$2y$10$zVr1nhiS3j2C7oQbl1y/H.ijiklxYs559NNkaw45mE1oac2NrWA0K'),
(26, 'asasas', 'asasas', 'asas@asas', '$2y$10$qlxHHl/E.Qu4vDrrV0iWWes/EaWnJYLhY5mxUvn6YjvQfmb2bLtMG'),
(27, 'affafww', 'awfarfq3', 'qq3q3t@afaefe', '$2y$10$GV7swPInZTytqe1M6Yr.r.TuckPe1L./hUk9W/nCvle6I2z97UqyW'),
(28, 'adawd', 'adwdawd', 'dwdw@dw', '$2y$10$cCc6QK5opUyYUeh0vX463.chgkx4KCoUC1xvbPDZorlSoeau6c/8a'),
(29, 'wdawdaw', 'dawdw', 'awwd@wad', '$2y$10$RyiIOL2JBEZCWeaVSXPLdeWVNzQYbRiYOZKqUHNFP.Ado5RG4Iy2G'),
(30, 'ddd', 'ddd', 'www@ww', '$2y$10$T3tKrM1T2qGwe.3RwX60fOlZae7chTn8VDyzPhI55b/8WiHlGAMua'),
(31, 'fb', 'bfb', 'dwd@wdw', '$2y$10$7lga2swfZKwCmXSXh.iRO.IDcazsNdRju2LPcXKdEfLfkv57YdKrO'),
(32, 'aaa', 'eee', 'www@w', '$2y$10$YJt.jBWfY88KEf6AqOh.4uBGi6cq8gb5PIVEhcxYlwYvlm0xGtWKC'),
(33, 'dwadwd', 'dwadw', 'ddd@www', '$2y$10$rGW2fmESJl/Yo6o5N9TFdeqCJSH1yvajAEaWyjaLTLI9DzHSRcvem'),
(34, 'ddddeee', 'ddd', 'ddd@ddd', '$2y$10$3/PPQa7zaB4svnM5Yb4y8exf2HLtaHToJU6J917uVF8so93FNxjYS'),
(35, 'dwad', 'dwdw', 'dwdw@wdwd', '$2y$10$.81UxCWW3M9vEVRsZs1VruBvgKfYiosNyPUHR.1zKOUowGlEAwixK');

-- --------------------------------------------------------

--
-- Struktura tabele `user_profile`
--

CREATE TABLE `user_profile` (
  `e-mail` varchar(100) NOT NULL,
  `lastaccess` datetime NOT NULL,
  `fieldofwork` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `readPR` tinyint(4) NOT NULL DEFAULT '0',
  `editPR` tinyint(4) NOT NULL DEFAULT '0',
  `deletePR` tinyint(4) NOT NULL DEFAULT '0',
  `addPR` tinyint(4) NOT NULL DEFAULT '0',
  `confirmPR` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `user_profile`
--

INSERT INTO `user_profile` (`e-mail`, `lastaccess`, `fieldofwork`, `admin`, `readPR`, `editPR`, `deletePR`, `addPR`, `confirmPR`) VALUES
('asas@asas', '2018-04-16 11:27:54', NULL, 0, 0, 0, 0, 0, 0),
('asd@dsa', '2018-04-16 11:27:20', NULL, 0, 1, 0, 0, 0, 0),
('awwd@wad', '2018-04-16 15:38:47', NULL, 0, 0, 0, 0, 0, 0),
('ddd@ddd', '2018-04-16 15:39:40', NULL, 0, 0, 0, 0, 0, 0),
('ddd@www', '2018-04-16 15:39:34', NULL, 0, 0, 0, 0, 0, 0),
('ddddeee@ddddeee', '2018-04-16 11:27:41', NULL, 0, 0, 0, 0, 0, 0),
('dwd@wdw', '2018-04-16 15:39:12', NULL, 1, 1, 1, 1, 1, 1),
('dwdw@dw', '2018-04-16 15:38:34', NULL, 0, 0, 0, 0, 0, 0),
('dwdw@wdwd', '2018-04-18 21:55:50', NULL, 0, 0, 0, 0, 0, 0),
('dwdwdwd@dwdwd', '2018-04-16 11:27:12', NULL, 0, 0, 0, 0, 1, 1),
('faawf@awdawd', '2018-04-16 11:27:04', NULL, 0, 1, 1, 0, 1, 1),
('nermin.jukan@mail.si', '2018-03-23 11:23:53', NULL, 1, 1, 1, 1, 1, 1),
('qq3q3t@afaefe', '2018-04-16 15:38:25', NULL, 0, 0, 0, 0, 0, 0),
('ssss@ssss', '2018-04-16 11:27:29', NULL, 0, 1, 0, 1, 1, 1),
('test@test', '2018-04-26 14:54:24', NULL, 0, 0, 0, 1, 1, 0),
('www@w', '2018-04-16 15:39:20', NULL, 0, 0, 0, 0, 0, 0),
('www@ww', '2018-04-16 15:38:56', NULL, 0, 0, 0, 0, 0, 0);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `e-mail` (`e-mail`);

--
-- Indeksi tabele `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`e-mail`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`e-mail`) REFERENCES `user` (`e-mail`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
