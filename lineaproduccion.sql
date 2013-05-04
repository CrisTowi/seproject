-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-05-2013 a las 16:17:40
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
-- Estructura de tabla para la tabla `lineaproduccion`
--

CREATE TABLE IF NOT EXISTS `lineaproduccion` (
  `numproduccion` int(11) NOT NULL AUTO_INCREMENT,
  `nolinea` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `encargadoLinea` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `estado` enum('pendiente','produccion','terminado') CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nolote` int(11) NOT NULL,
  PRIMARY KEY (`numproduccion`),
  KEY `nolote` (`nolote`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Volcar la base de datos para la tabla `lineaproduccion`
--

INSERT INTO `lineaproduccion` (`numproduccion`, `nolinea`, `encargadoLinea`, `estado`, `nolote`) VALUES
(1, '1', 'RULM910705HDFDPG08', 'terminado', 1),
(2, '2', 'RULM910705HDFDPG08', 'terminado', 2),
(3, '3', 'RULM910705HDFDPG08', 'pendiente', 3),
(4, '2', 'RULM910705HDFDPG08', 'pendiente', 9),
(53, '3', 'RULM910705HDFDPG08', 'pendiente', 62),
(54, '1', 'RULM910705HDFDPG08', 'pendiente', 63),
(55, '1', 'RULM910705HDFDPG08', 'pendiente', 64),
(56, '2', 'RULM910705HDFDPG08', 'pendiente', 65),
(106, '1', 'RULM910705HDFDPG08', 'pendiente', 129);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `lineaproduccion`
--
ALTER TABLE `lineaproduccion`
  ADD CONSTRAINT `lineaproduccion_ibfk_1` FOREIGN KEY (`nolote`) REFERENCES `lote` (`noLote`) ON DELETE CASCADE ON UPDATE CASCADE;
