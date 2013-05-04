-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-05-2013 a las 16:17:49
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cookies`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE IF NOT EXISTS `lote` (
  `noLote` int(11) NOT NULL AUTO_INCREMENT,
  `productoAsociado` varchar(50) NOT NULL,
  `cantidadProducto` int(11) NOT NULL,
  `fechaElaboracion` date NOT NULL,
  `fechaCaducidad` date NOT NULL,
  PRIMARY KEY (`noLote`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Volcar la base de datos para la tabla `lote`
--

INSERT INTO `lote` (`noLote`, `productoAsociado`, `cantidadProducto`, `fechaElaboracion`, `fechaCaducidad`) VALUES
(1, '3', 3000, '2014-04-01', '2013-08-22'),
(2, '2', 2000, '2013-04-02', '2014-04-02'),
(3, '3', 4000, '2013-04-03', '2014-04-03'),
(9, '4', 3000, '2013-04-04', '2014-04-04'),
(10, '6', 3000, '2013-04-17', '2013-07-31'),
(62, '2', 2000, '2013-05-15', '2013-08-27'),
(63, '6', 2000, '2013-05-16', '2013-08-21'),
(64, '6', 2000, '2013-05-16', '2013-08-21'),
(65, '4', 4000, '2013-05-22', '2013-08-27'),
(129, '1', 1000, '2013-05-15', '2013-08-25');
