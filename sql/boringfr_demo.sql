-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2013 at 02:00 AM
-- Server version: 5.5.30-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `boringfr_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('general','sport','restaurant','movie','music','art') NOT NULL,
  `radius` smallint(6) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `location` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `type`, `radius`, `start`, `end`, `pid`, `title`, `description`, `city`, `location`) VALUES
(1, 'sport', 8, '2013-04-08 19:00:00', '2013-04-08 21:00:00', 4, 'Волейбол за аматьори.', 'Търсим 4 човека.', 'София', 'Зала Академик, кв. Гео Милев'),
(2, 'sport', 5, '2013-04-08 20:00:00', '2013-04-08 21:00:00', 5, 'Тенис за ветерани.', 'Търсим 2 човека за каре. Ниво – средно.', 'София', 'Кортове 15:40, кв. Гео Милев'),
(3, 'sport', 4, '2013-04-08 18:00:00', '2013-04-08 21:00:00', 6, 'Баскетбол 18-30 год.', 'Организираме любителски турнир.', 'София', 'Училище СУЧЕМ Иван Вазов в двора, кв. Гео Милев'),
(4, 'sport', 2, '2013-04-08 19:00:00', '2013-04-08 21:00:00', 7, 'Някой да тичаме заедно в Борисовата.', 'На 35 г. съм и обикновено бягам по 5 км.', 'София', 'Зала Академик, кв. Гео Милев'),
(5, 'restaurant', 10, '2013-04-08 10:00:00', '2013-04-08 11:00:00', 0, 'Понички за ученици – 50 ст.', 'Уникална промоция днес в DunkinDonuts – поничка – 50 ст. Поничка с кола – 90 ст.', 'София', 'Dunkin Donuts – бул. Шипченски проход 7'),
(6, 'restaurant', 6, '2013-04-08 15:00:00', '2013-04-08 18:00:00', 0, 'Малка пица в Дон Вито – 3.50 лв.', 'Само при нас всеки ден след обяд – малка пица за 3.50.', 'София', 'Пицерия Дон Вито, ул. Гео Милев 37а'),
(7, 'restaurant', 5, '2013-04-08 09:00:00', '2013-04-08 11:00:00', 0, 'Промоция на Heineken', 'Елате, изпите най-много бири за 5 мин. и спечелете 5 пъти по толкова.', 'София', 'VIVACOM HQ, – бул. Цариградско шосе 115И, ет.5'),
(8, 'restaurant', 2, '2013-04-08 09:00:00', '2013-04-08 11:00:00', 3, 'Някой за кафе...', 'Да обича фотографията. Да е жена. Или мъж. Може и двете.', 'София', 'НБУ');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `interests` set('sport','restaurant','movie','music','art') NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `photo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `name`, `pass`, `interests`, `phone`, `email`, `photo`) VALUES
(3, 'Ivo', '202cb962ac59075b964b07152d234b70', 'sport,movie,art', '+359 800 000 000', 'test@test.test', 'data:image/jpeg;base64,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'),
(4, 'Stefan', '202cb962ac59075b964b07152d234b70', 'sport,restaurant,movie,music,art', '+359 800 000 000', 'test@test.test', 'data:image/jpeg;base64,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'),
(5, 'Plamen', '202cb962ac59075b964b07152d234b70', 'restaurant,music', '+359 800 000 000', 'test@test.test', ''),
(6, 'Rossen', '202cb962ac59075b964b07152d234b70', 'sport,restaurant,movie,music', '+359 800 000 000', 'test@test.test', ''),
(7, 'Georgi', '202cb962ac59075b964b07152d234b70', 'sport,movie', '+359 800 000 000', 'test@test.test', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
