-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 20 Feb 2021 om 12:58
-- Serverversie: 5.1.37
-- PHP-Versie: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ultima_casa_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `biedingen`
--

CREATE TABLE IF NOT EXISTS `biedingen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` date DEFAULT NULL,
  `FKrelatiesID` int(11) NOT NULL COMMENT 'Welke relatie heeft dit bod uitgebracht?',
  `FKhuizenID` int(11) DEFAULT NULL,
  `Bod` int(11) DEFAULT NULL,
  `FKstatussenID` int(11) NOT NULL DEFAULT '1',
  `StatusDatum` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UKHuisIDRelatieID` (`FKrelatiesID`,`FKhuizenID`),
  KEY `FKrelatiesID` (`FKrelatiesID`),
  KEY `FKhuizenID` (`FKhuizenID`),
  KEY `FKstatussenID` (`FKstatussenID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=270 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Criterium` varchar(30) NOT NULL,
  `Type` tinyint(1) DEFAULT NULL,
  `Volgorde` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `huiscriteria`
--

CREATE TABLE IF NOT EXISTS `huiscriteria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Waarde` int(11) NOT NULL,
  `FKhuizenID` int(11) NOT NULL,
  `FKcriteriaID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UKHuisIDcriteriaID` (`FKhuizenID`,`FKcriteriaID`),
  KEY `IFKcriteriaID` (`FKcriteriaID`),
  KEY `IFKhuizenID` (`FKhuizenID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3206 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `huizen`
--

CREATE TABLE IF NOT EXISTS `huizen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StartDatum` date NOT NULL,
  `FKrelatiesID` int(11) NOT NULL,
  `Straat` varchar(30) NOT NULL,
  `Postcode` varchar(6) NOT NULL,
  `Plaats` varchar(30) NOT NULL,
  `Gewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `FKrelatiesID` (`FKrelatiesID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=364 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mijncriteria`
--

CREATE TABLE IF NOT EXISTS `mijncriteria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Van` int(11) DEFAULT NULL,
  `Tem` int(11) DEFAULT NULL,
  `FKrelatiesID` int(11) NOT NULL,
  `FKcriteriaID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Icriteriarelaties` (`FKrelatiesID`,`FKcriteriaID`),
  KEY `IFKrelatiesID` (`FKrelatiesID`),
  KEY `IFKcriteriaID` (`FKcriteriaID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `relaties`
--

CREATE TABLE IF NOT EXISTS `relaties` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Telefoon` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `Wachtwoord` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `FKrollenID` int(11) NOT NULL DEFAULT '7',
  `Gewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `IEmail` (`Email`),
  KEY `FKrollenID` (`FKrollenID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=508 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rollen`
--

CREATE TABLE IF NOT EXISTS `rollen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(20) NOT NULL,
  `Omschrijving` varchar(200) DEFAULT NULL,
  `Waarde` tinyint(11) NOT NULL,
  `Landingspagina` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `statussen`
--

CREATE TABLE IF NOT EXISTS `statussen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StatusCode` tinyint(4) NOT NULL,
  `Status` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `biedingen`
--
ALTER TABLE `biedingen`
  ADD CONSTRAINT `biedingen_ibfk_1` FOREIGN KEY (`FKrelatiesID`) REFERENCES `relaties` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biedingen_ibfk_2` FOREIGN KEY (`FKhuizenID`) REFERENCES `huizen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biedingen_ibfk_3` FOREIGN KEY (`FKstatussenID`) REFERENCES `statussen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `huiscriteria`
--
ALTER TABLE `huiscriteria`
  ADD CONSTRAINT `huiscriteria_ibfk_1` FOREIGN KEY (`FKcriteriaID`) REFERENCES `criteria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `huiscriteria_ibfk_2` FOREIGN KEY (`FKhuizenID`) REFERENCES `huizen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `huizen`
--
ALTER TABLE `huizen`
  ADD CONSTRAINT `huizen_ibfk_3` FOREIGN KEY (`FKrelatiesID`) REFERENCES `relaties` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `mijncriteria`
--
ALTER TABLE `mijncriteria`
  ADD CONSTRAINT `mijncriteria_ibfk_1` FOREIGN KEY (`FKcriteriaID`) REFERENCES `criteria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mijncriteria_ibfk_2` FOREIGN KEY (`FKrelatiesID`) REFERENCES `relaties` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `relaties`
--
ALTER TABLE `relaties`
  ADD CONSTRAINT `relaties_ibfk_3` FOREIGN KEY (`FKrollenID`) REFERENCES `rollen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;