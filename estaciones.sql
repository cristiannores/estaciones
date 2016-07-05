-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-07-2016 a las 00:55:47
-- Versión del servidor: 5.5.47-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `estaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE IF NOT EXISTS `privilegio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `recurso_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_privilegio_rol_idx` (`rol_id`),
  KEY `fk_privilegio_recurso1_idx` (`recurso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE IF NOT EXISTS `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `es_menu` tinyint(1) NOT NULL,
  `recurso_id` int(11) DEFAULT NULL,
  `titulo_menu` varchar(100) DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `clase` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recurso_recurso1_idx` (`recurso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `habilitado`) VALUES
(1, 'Aministrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_jerarquia`
--

CREATE TABLE IF NOT EXISTS `rol_jerarquia` (
  `rol_id` int(11) NOT NULL,
  `padre_id` int(11) NOT NULL,
  PRIMARY KEY (`rol_id`,`padre_id`),
  KEY `fk_rol_has_rol_rol2_idx` (`padre_id`),
  KEY `fk_rol_has_rol_rol1_idx` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `correo` varchar(45) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `ap_pat` varchar(45) NOT NULL,
  `ap_mat` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `run` varchar(45) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `fecha_expiracion` datetime DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email_confirmado` tinyint(1) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `habilita_correo` tinyint(1) DEFAULT '1',
  `verifica_facebook` tinyint(1) DEFAULT '0',
  `id_facebook` int(11) DEFAULT NULL,
  `verifica_gmail` tinyint(1) DEFAULT '0',
  `id_gmail` int(11) DEFAULT NULL,
  PRIMARY KEY (`correo`),
  UNIQUE KEY `correo_2` (`correo`),
  UNIQUE KEY `correo_3` (`correo`,`rol_id`),
  KEY `fk_usuario_rol1_idx` (`rol_id`),
  KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`correo`, `nombres`, `ap_pat`, `ap_mat`, `fecha_nacimiento`, `run`, `habilitado`, `fecha_expiracion`, `password`, `email_confirmado`, `fecha_registro`, `rol_id`, `habilita_correo`, `verifica_facebook`, `id_facebook`, `verifica_gmail`, `id_gmail`) VALUES
('ariel.larraguibel@gmail.com', 'Ariel', 'Larraguibel', '', NULL, '', NULL, NULL, '24f8309a3b4d38e2c3e50a04733795a4', NULL, '2016-04-27 15:33:59', 1, 1, NULL, NULL, NULL, NULL),
('cristian.nores@gmail.com', 'Cristian', 'Nores', '', NULL, '', NULL, NULL, '9cd18b0cd484cdb440b148a97e84b065', NULL, '2016-04-22 15:36:56', 1, 1, NULL, NULL, NULL, NULL),
('raulfuent@gmail.com', 'raul', 'fuentes', '', NULL, '', NULL, NULL, '8b20a6e4afea00f5f2751f84a52f0404', NULL, '2016-04-27 15:19:19', 1, 1, NULL, NULL, NULL, NULL),
('wolv1614@gmail.com', 'Cristian', 'nores', '', NULL, '', NULL, NULL, 'bcd3990a1244477c79580537a9905caa', NULL, '2016-04-27 12:41:44', 1, 1, NULL, NULL, NULL, NULL),
('wolvterrohack@gmaill.com', 'Cristian', 'Nores', '', NULL, '', NULL, NULL, '9cd18b0cd484cdb440b148a97e84b065', NULL, '2016-04-27 14:30:54', 1, 1, NULL, NULL, NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD CONSTRAINT `fk_privilegio_recurso1` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_privilegio_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `fk_recurso_recurso1` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_jerarquia`
--
ALTER TABLE `rol_jerarquia`
  ADD CONSTRAINT `fk_rol_has_rol_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_has_rol_rol2` FOREIGN KEY (`padre_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
