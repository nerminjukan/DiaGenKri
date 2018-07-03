-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 29. jun 2018 ob 09.18
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
-- Struktura tabele `graph`
--

CREATE TABLE `graph` (
  `id` int(11) NOT NULL,
  `e-mail` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT 'Untitled',
  `description` varchar(255) DEFAULT 'Ni opisa',
  `visual` tinyint(4) NOT NULL DEFAULT '1',
  `algorithm_type` int(11) NOT NULL DEFAULT '0',
  `data` longtext NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `graph`
--

INSERT INTO `graph` (`id`, `e-mail`, `name`, `description`, `visual`, `algorithm_type`, `data`, `created`) VALUES
(2, 'test@test', 'TEST', '', 0, 4, '[{\"data\":{\"id\":\"at3dc\",\"setName\":\"nameat3dc\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":277,\"y\":281,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"at3dc\"},{\"data\":{\"id\":\"fcq3k\",\"setName\":\"nameat3dc\",\"parentID\":\"at3dc\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",282,291],[\"L\",292,291],[\"M\",287,286],[\"L\",287,296]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"fcq3k\"},{\"data\":{\"id\":\"cymt8\",\"setName\":\"nameat3dc\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":327,\"y\":301,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"cymt8\"},{\"data\":{\"id\":\"mdohg\",\"setName\":\"namemdohg\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":139,\"y\":124,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"mdohg\"},{\"data\":{\"id\":\"3ogvp\",\"setName\":\"namemdohg\",\"parentID\":\"mdohg\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",144,134],[\"L\",154,134],[\"M\",149,129],[\"L\",149,139]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"3ogvp\"},{\"data\":{\"id\":\"i0ao1\",\"setName\":\"namemdohg\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":189,\"y\":144,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"i0ao1\"},{\"data\":{\"id\":\"xmfpm\",\"setName\":\"name2\",\"fromTo\":\"mdohg at3dc\",\"type\":\"connection\",\"id_connection\":2},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#000\",\"path\":[[\"M\",240,144],[\"C\",258,144,258,301,276,301]],\"arrow-end\":\"classic-wide-long\",\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"xmfpm\"},{\"data\":{\"id\":\"f3594\",\"type\":\"sub_path\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#f1f1f1\",\"path\":[[\"M\",254.59044554568692,193.95132159978925],[\"C\",256.63757257137024,209.74547375886985,258.48004603134706,227.32465979661265,260.4723079094547,243.59735796510358]],\"stroke-width\":\"6\",\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"f3594\"},{\"data\":{\"id\":\"y6558\",\"type\":\"connection_text\",\"id_connection\":2},\"type\":\"text\",\"attrs\":{\"x\":257.5713893356151,\"y\":218.76407222720445,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":12,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"y6558\"}]', '2018-06-29 07:05:40'),
(3, 'test@test', 'NEKI', '', 0, 3, '[{\"data\":{\"id\":\"8s1wh\",\"setName\":\"name8s1wh\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":180,\"y\":62,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"8s1wh\"},{\"data\":{\"id\":\"806o8\",\"setName\":\"name8s1wh\",\"parentID\":\"8s1wh\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",196,104],[\"L\",206,104],[\"M\",201,99],[\"L\",201,109]],\"stroke-width\":3,\"x\":-11,\"y\":-32},\"transform\":\"\",\"id\":\"806o8\"},{\"data\":{\"id\":\"okcm7\",\"setName\":\"name8s1wh\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":230,\"y\":82,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"okcm7\"},{\"data\":{\"id\":\"3l8ez\",\"setName\":\"name3l8ez\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":493,\"y\":287,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"3l8ez\"},{\"data\":{\"id\":\"g4qjo\",\"setName\":\"name3l8ez\",\"parentID\":\"3l8ez\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",301,245],[\"L\",311,245],[\"M\",306,240],[\"L\",306,250]],\"stroke-width\":3,\"x\":197,\"y\":52},\"transform\":\"\",\"id\":\"g4qjo\"},{\"data\":{\"id\":\"p853q\",\"setName\":\"name3l8ez\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":543,\"y\":307,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"p853q\"},{\"data\":{\"id\":\"0cfe0\",\"setName\":\"name0cfe0\",\"type\":\"decision\"},\"type\":\"rect\",\"attrs\":{\"x\":141.0000000131909,\"y\":244.0000000131909,\"width\":50,\"height\":50,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"0cfe0\"},{\"data\":{\"id\":\"zbuid\",\"setName\":\"name0cfe0\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":166,\"y\":269,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"zbuid\"},{\"data\":{\"id\":\"48gcm\",\"setName\":\"name3\",\"fromTo\":\"0cfe0 3l8ez\",\"type\":\"connection\",\"id_connection\":3},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"black\",\"path\":[[\"M\",202.355,269],[\"C\",347.178,269,347.178,307,492,307]],\"arrow-end\":\"classic-wide-long\",\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"48gcm\"},{\"data\":{\"id\":\"23z6n\",\"type\":\"sub_path\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#f1f1f1\",\"path\":[[\"M\",306.98916496633893,278.3055086877492],[\"C\",333.450347815304,283.6938643001249,354.4961173728708,290.50315729590346,380.02481453446495,296.13616035180166]],\"stroke-width\":\"6\",\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"23z6n\"},{\"data\":{\"id\":\"h7q4r\",\"type\":\"connection_text\",\"id_connection\":3},\"type\":\"text\",\"attrs\":{\"x\":343.5435823649071,\"y\":287.04710840174084,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":12,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"h7q4r\"},{\"data\":{\"id\":\"241ou\",\"setName\":\"name4\",\"fromTo\":\"8s1wh 0cfe0\",\"type\":\"connection\",\"id_connection\":4},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"black\",\"path\":[[\"M\",179,82],[\"C\",169,82,166,157.322,166,232.645]],\"arrow-end\":\"classic-wide-long\",\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"241ou\"},{\"data\":{\"id\":\"yvwqa\",\"type\":\"sub_path\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#f1f1f1\",\"path\":[[\"M\",167.92386065509385,142.55754250626777],[\"C\",167.59366136857366,148.80685731772147,167.31152455140378,155.38309008761436,167.0733090471649,162.20826180528093]],\"stroke-width\":\"6\",\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"yvwqa\"},{\"data\":{\"id\":\"in7is\",\"type\":\"connection_text\",\"id_connection\":4},\"type\":\"text\",\"attrs\":{\"x\":167.45502181318443,\"y\":152.37741163736953,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":12,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"in7is\"}]', '2018-06-29 07:10:09'),
(4, 'test@test', 'eg', '', 0, 0, '[{\"data\":{\"id\":\"23yuh\",\"setName\":\"name23yuh\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":335,\"y\":319,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"23yuh\"},{\"data\":{\"id\":\"fx1op\",\"setName\":\"name23yuh\",\"parentID\":\"23yuh\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",340,329],[\"L\",350,329],[\"M\",345,324],[\"L\",345,334]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"fx1op\"},{\"data\":{\"id\":\"wonwo\",\"setName\":\"name23yuh\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":385,\"y\":339,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"wonwo\"}]', '2018-06-29 07:16:07'),
(5, 'test@test', 'oh', '', 0, 0, '[{\"data\":{\"id\":\"2y8z7\",\"setName\":\"name2y8z7\",\"type\":\"decision\"},\"type\":\"rect\",\"attrs\":{\"x\":289.0000000131909,\"y\":274.0000000131909,\"width\":50,\"height\":50,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"2y8z7\"},{\"data\":{\"id\":\"kgfce\",\"setName\":\"name2y8z7\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":314,\"y\":299,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"kgfce\"}]', '2018-06-29 07:17:07'),
(6, 'test@test', 'PRVI PRAVI', 'Moj opis prvega grafa.', 0, 4, '[{\"data\":{\"id\":\"u6y82\",\"setName\":\"nameu6y82\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":140,\"y\":160,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"u6y82\"},{\"data\":{\"id\":\"06ntf\",\"setName\":\"nameu6y82\",\"parentID\":\"u6y82\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",145,170],[\"L\",155,170],[\"M\",150,165],[\"L\",150,175]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"06ntf\"},{\"data\":{\"id\":\"qmqiw\",\"setName\":\"nameu6y82\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":190,\"y\":180,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"qmqiw\"},{\"data\":{\"id\":\"0myr8\",\"setName\":\"name0myr8\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":285,\"y\":287,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"0myr8\"},{\"data\":{\"id\":\"2uiq3\",\"setName\":\"name0myr8\",\"parentID\":\"0myr8\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",290,297],[\"L\",300,297],[\"M\",295,292],[\"L\",295,302]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"2uiq3\"},{\"data\":{\"id\":\"3h23z\",\"setName\":\"name0myr8\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":335,\"y\":307,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"3h23z\"},{\"data\":{\"id\":\"o33py\",\"setName\":\"nameo33py\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":109,\"y\":332,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"o33py\"},{\"data\":{\"id\":\"h2wkz\",\"setName\":\"nameo33py\",\"parentID\":\"o33py\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",114,342],[\"L\",124,342],[\"M\",119,337],[\"L\",119,347]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"h2wkz\"},{\"data\":{\"id\":\"hsqgg\",\"setName\":\"nameo33py\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":159,\"y\":352,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"hsqgg\"},{\"data\":{\"id\":\"7osx6\",\"setName\":\"name3\",\"fromTo\":\"u6y82 o33py\",\"type\":\"connection\",\"id_connection\":3},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#000\",\"path\":[[\"M\",190,201],[\"C\",190,266,159,266,159,331]],\"arrow-end\":\"classic-wide-long\",\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"7osx6\"},{\"data\":{\"id\":\"7qxht\",\"type\":\"sub_path\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#f1f1f1\",\"path\":[[\"M\",185.2243466119454,239.35477887985388],[\"C\",180.10572304082658,257.39323134381556,171.9265171271076,269.0143337345834,166.06346554341144,285.49188875281834]],\"stroke-width\":\"6\",\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"7qxht\"},{\"data\":{\"id\":\"gnmvf\",\"type\":\"connection_text\",\"id_connection\":3},\"type\":\"text\",\"attrs\":{\"x\":176.10947723477148,\"y\":262.61445642472245,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":12,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"gnmvf\"},{\"data\":{\"id\":\"2eivc\",\"setName\":\"name4\",\"fromTo\":\"u6y82 0myr8\",\"type\":\"connection\",\"id_connection\":4},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#000\",\"path\":[[\"M\",241,180],[\"C\",262.5,180,262.5,307,284,307]],\"arrow-end\":\"classic-wide-long\",\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"2eivc\"},{\"data\":{\"id\":\"yye6d\",\"type\":\"sub_path\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"#f1f1f1\",\"path\":[[\"M\",257.4006657340356,215.20901705056662],[\"C\",260.5187908761619,230.46188523408654,263.17350184684483,248.45213015124938,266.1661944052903,264.4459256895352]],\"stroke-width\":\"6\",\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"yye6d\"},{\"data\":{\"id\":\"0ttjz\",\"type\":\"connection_text\",\"id_connection\":4},\"type\":\"text\",\"attrs\":{\"x\":261.87373954967734,\"y\":239.80440845492194,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":12,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"0ttjz\"}]', '2018-06-29 07:19:42'),
(7, 'test@test', 'pih', 'šoj', 1, 1, '[{\"data\":{\"id\":\"cvkgh\",\"setName\":\"namecvkgh\",\"desc\":\"default-text\",\"type\":\"rect\"},\"type\":\"rect\",\"attrs\":{\"x\":178,\"y\":217,\"width\":100,\"height\":40,\"rx\":0,\"ry\":0,\"fill\":\"white\",\"stroke\":\"#000\",\"cursor\":\"move\"},\"transform\":\"\",\"id\":\"cvkgh\"},{\"data\":{\"id\":\"qpt1d\",\"setName\":\"namecvkgh\",\"parentID\":\"cvkgh\",\"type\":\"hide\"},\"type\":\"path\",\"attrs\":{\"fill\":\"none\",\"stroke\":\"rgb(0, 200, 0)\",\"path\":[[\"M\",183,227],[\"L\",193,227],[\"M\",188,222],[\"L\",188,232]],\"stroke-width\":3,\"x\":0,\"y\":0},\"transform\":\"\",\"id\":\"qpt1d\"},{\"data\":{\"id\":\"wlm3t\",\"setName\":\"namecvkgh\",\"type\":\"shape_text\"},\"type\":\"text\",\"attrs\":{\"x\":228,\"y\":237,\"text-anchor\":\"middle\",\"text\":\"default-text\",\"font-family\":\"\\\"Arial\\\"\",\"font-size\":10,\"stroke\":\"none\",\"fill\":\"black\"},\"transform\":\"\",\"id\":\"wlm3t\"}]', '2018-06-29 07:30:21'),
(8, 'test@test', 'pih', 'šoj', 1, 1, '[]', '2018-06-29 07:31:31');

-- --------------------------------------------------------

--
-- Struktura tabele `graph-edits`
--

CREATE TABLE `graph-edits` (
  `id` int(11) NOT NULL,
  `graph-id` int(11) NOT NULL,
  `edited-by` varchar(100) NOT NULL,
  `edit-date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('test@test', '2018-06-29 03:24:41', NULL, 0, 0, 0, 1, 0, 0),
('www@w', '2018-04-16 15:39:20', NULL, 0, 0, 0, 0, 0, 0),
('www@ww', '2018-04-16 15:38:56', NULL, 0, 0, 0, 0, 0, 0);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `graph`
--
ALTER TABLE `graph`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USER E-MAIL` (`e-mail`);

--
-- Indeksi tabele `graph-edits`
--
ALTER TABLE `graph-edits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `GRAPH-ID` (`graph-id`);

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
-- AUTO_INCREMENT tabele `graph`
--
ALTER TABLE `graph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT tabele `graph-edits`
--
ALTER TABLE `graph-edits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `graph`
--
ALTER TABLE `graph`
  ADD CONSTRAINT `graph_ibfk_1` FOREIGN KEY (`e-mail`) REFERENCES `user_profile` (`e-mail`);

--
-- Omejitve za tabelo `graph-edits`
--
ALTER TABLE `graph-edits`
  ADD CONSTRAINT `graph-edits_ibfk_1` FOREIGN KEY (`graph-id`) REFERENCES `graph` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omejitve za tabelo `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`e-mail`) REFERENCES `user` (`e-mail`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
