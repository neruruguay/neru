-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2012 a las 19:23:44
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `CmsDev2013`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `defaultLanguage` varchar(3) NOT NULL DEFAULT 'esp',
  `TemplateSite` varchar(100) NOT NULL DEFAULT 'default',
  `Width` enum('Fluid','Fixed') NOT NULL DEFAULT 'Fixed',
  `SiteName` varchar(100) NOT NULL DEFAULT 'S&eacute;kito <sup><em>CMS </em><strong>v.6</strong></sup>',
  `SiteSlogan` varchar(100) DEFAULT NULL,
  `Emailto` varchar(100) NOT NULL DEFAULT 'martin.daguerre@negociosenred.uy',
  `CurrencyDolar` decimal(9,2) NOT NULL DEFAULT '21.05',
  `PercentStockSafe` int(2) NOT NULL DEFAULT '90',
  `s` varchar(50) NOT NULL,
  `u` varchar(50) NOT NULL,
  `p` varchar(50) NOT NULL,
  `e` varchar(50) NOT NULL DEFAULT '|',
  `r` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `site`
--

INSERT INTO `site` (`defaultLanguage`, `TemplateSite`, `Width`, `SiteName`, `SiteSlogan`, `Emailto`, `CurrencyDolar`, `PercentStockSafe`, `s`, `u`, `p`, `e`, `r`) VALUES
('eng', 'CmsDev2013', 'Fixed', 'CmsDev CMS', 'Advanced web solutions ', 'martin.daguerre@negociosenred.uy', 20.00, 90, 'CmsDevcms', 'zapatero', '3788047', '|', 'Full');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
