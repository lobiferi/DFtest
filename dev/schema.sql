-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost
-- Létrehozás ideje: 2015. Feb 17. 00:56
-- Szerver verzió: 5.5.41-0ubuntu0.14.10.1
-- PHP verzió: 5.5.12-2ubuntu4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `dutch_frontiers_blog`
--
CREATE DATABASE IF NOT EXISTS `dutch_frontiers_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dutch_frontiers_blog`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Comments`
--

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE IF NOT EXISTS `Comments` (
`id` int(11) NOT NULL,
  `text` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `Users_id` int(11) NOT NULL,
  `Posts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Details`
--

DROP TABLE IF EXISTS `Details`;
CREATE TABLE IF NOT EXISTS `Details` (
`id` int(11) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `text` longtext,
  `Posts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Posts`
--

DROP TABLE IF EXISTS `Posts`;
CREATE TABLE IF NOT EXISTS `Posts` (
`id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `Users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
`id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- A tábla adatainak kiíratása `Users`
--

INSERT INTO `Users` (`id`, `name`, `email`, `date`, `active`) VALUES
(1, 'Admin', 'admin@dutchfrontiers.local', '2015-02-15 20:27:52', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_Comments_Users1_idx` (`Users_id`), ADD KEY `fk_Comments_Posts1_idx` (`Posts_id`);

--
-- Indexes for table `Details`
--
ALTER TABLE `Details`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_Details_Posts_idx` (`Posts_id`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_Posts_Users1_idx` (`Users_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Details`
--
ALTER TABLE `Details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `Comments`
--
ALTER TABLE `Comments`
ADD CONSTRAINT `fk_Comments_Posts1` FOREIGN KEY (`Posts_id`) REFERENCES `Posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_Comments_Users1` FOREIGN KEY (`Users_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `Details`
--
ALTER TABLE `Details`
ADD CONSTRAINT `fk_Details_Posts` FOREIGN KEY (`Posts_id`) REFERENCES `Posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `Posts`
--
ALTER TABLE `Posts`
ADD CONSTRAINT `fk_Posts_Users1` FOREIGN KEY (`Users_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;