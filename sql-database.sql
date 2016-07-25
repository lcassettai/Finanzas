-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.13-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para finanzas_personales
CREATE DATABASE IF NOT EXISTS `finanzas_personales` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `finanzas_personales`;


-- Volcando estructura para tabla finanzas_personales.ahorros
CREATE TABLE IF NOT EXISTS `ahorros` (
  `cod_ahorro` int(11) NOT NULL AUTO_INCREMENT,
  `monto` double DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comentario` varchar(300) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_tipo_moneda` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_ahorro`),
  KEY `fk_usuario_ahorro` (`id_usuario`),
  KEY `fk_tipomoenda_ahorro` (`id_tipo_moneda`),
  CONSTRAINT `fk_tipomoenda_ahorro` FOREIGN KEY (`id_tipo_moneda`) REFERENCES `tipo_monedas` (`id_tipo_moneda`),
  CONSTRAINT `fk_usuario_ahorro` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.gastos
CREATE TABLE IF NOT EXISTS `gastos` (
  `cod_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `monto` double DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comentario` varchar(400) DEFAULT NULL,
  `id_tipo_gasto` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_gasto`),
  KEY `id_tipo_gasto` (`id_tipo_gasto`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `tipo_gastos` (`id_tipo_gasto`),
  CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.ingresos
CREATE TABLE IF NOT EXISTS `ingresos` (
  `cod_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `monto` double DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comentario` varchar(400) DEFAULT NULL,
  `id_tipo_ingreso` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_ingreso`),
  KEY `id_tipo_ingreso` (`id_tipo_ingreso`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`id_tipo_ingreso`) REFERENCES `tipo_ingresos` (`id_tipo_ingreso`),
  CONSTRAINT `ingresos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.tipo_gastos
CREATE TABLE IF NOT EXISTS `tipo_gastos` (
  `id_tipo_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_gasto` varchar(200) NOT NULL,
  PRIMARY KEY (`id_tipo_gasto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.tipo_ingresos
CREATE TABLE IF NOT EXISTS `tipo_ingresos` (
  `id_tipo_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ingreso` varchar(200) NOT NULL,
  PRIMARY KEY (`id_tipo_ingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.tipo_monedas
CREATE TABLE IF NOT EXISTS `tipo_monedas` (
  `id_tipo_moneda` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_moneda` varchar(200) NOT NULL,
  PRIMARY KEY (`id_tipo_moneda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla finanzas_personales.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activo` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
