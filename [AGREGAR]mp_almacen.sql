-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-05-2013 a las 21:48:59
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
-- Estructura de tabla para la tabla `mp_almacen`
--

CREATE TABLE IF NOT EXISTS `mp_almacen` (
  `NoLote` varchar(10) NOT NULL,
  `idProveedor` varchar(10) NOT NULL,
  `idMateriaPrima` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`NoLote`),
  KEY `idProveedor` (`idProveedor`),
  KEY `idMateriaPrima` (`idMateriaPrima`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `mp_almacen`
--

INSERT INTO `mp_almacen` (`NoLote`, `idProveedor`, `idMateriaPrima`, `cantidad`) VALUES
('AV1', 'JILC910413', 13, 3000),
('MA1', 'JILC910413', 1, 3000),
('MA2', 'JILC910413', 1, 20),
('MA3', 'JILC910413', 1, 150);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `mp_almacen`
--
ALTER TABLE `mp_almacen`
  ADD CONSTRAINT `mp_almacen_ibfk_1` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`RFC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mp_almacen_ibfk_2` FOREIGN KEY (`idMateriaPrima`) REFERENCES `materiaprima` (`idMateriaPrima`) ON DELETE CASCADE ON UPDATE CASCADE;
