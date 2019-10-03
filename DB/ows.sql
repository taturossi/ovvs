-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2019 a las 21:44:20
-- Versión del servidor: 5.7.17
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ows`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planservicio`
--

CREATE TABLE `planservicio` (
  `IdPlan` int(11) NOT NULL,
  `Codigo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `IdServicio` int(11) NOT NULL,
  `MontoNeto` float NOT NULL,
  `MontoIva` float NOT NULL,
  `FechaAlta` date NOT NULL,
  `FechaBaja` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `IdServicio` int(11) NOT NULL,
  `Codigo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `IdTipoAplicacionServicio` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoaplicacionservicio`
--

CREATE TABLE `tipoaplicacionservicio` (
  `IdTipoAplicacionServicio` int(11) NOT NULL,
  `Codigo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomovimiento`
--

CREATE TABLE `tipomovimiento` (
  `IdTipoMovimiento` int(11) NOT NULL,
  `Codigo` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FechaAlta` date NOT NULL,
  `FechaBaja` date DEFAULT NULL,
  `TipoImputacion` varchar(3) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipomovimiento`
--

INSERT INTO `tipomovimiento` (`IdTipoMovimiento`, `Codigo`, `Descripcion`, `FechaAlta`, `FechaBaja`, `TipoImputacion`) VALUES
(1, 'deb1', 'Carga de combustible', '2019-06-04', NULL, 'DEB'),
(2, 'DEB2', 'Carga de combustible', '2019-06-04', NULL, 'DEB'),
(3, 'DEB3', 'Gasto en almuerzo', '2019-06-04', NULL, 'DEB'),
(4, 'DEB4', 'Perdida por redondeo', '2019-06-04', NULL, 'DEB'),
(5, 'DEB5', 'Salida caja chica', '2019-06-04', NULL, 'DEB'),
(6, 'CRE1', 'Devolucion Iva', '2019-06-05', NULL, 'CRE'),
(8, 'cre2', 'credito2', '2019-06-05', NULL, 'CRE'),
(9, 'cre22', 'credito2', '2019-06-05', NULL, 'CRE'),
(10, 'cre223', 'credito2', '2019-06-05', NULL, 'CRE'),
(11, 'cre2232', 'credito2', '2019-06-05', NULL, 'CRE'),
(12, 'cre22321', 'credito2', '2019-06-05', NULL, 'CRE'),
(13, 'TM2', 'Movimietno', '2019-06-05', NULL, 'CRE'),
(14, 'Jip', 'jip2', '2019-06-05', NULL, 'CRE');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `planservicio`
--
ALTER TABLE `planservicio`
  ADD PRIMARY KEY (`IdPlan`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`IdServicio`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Indices de la tabla `tipoaplicacionservicio`
--
ALTER TABLE `tipoaplicacionservicio`
  ADD PRIMARY KEY (`IdTipoAplicacionServicio`),
  ADD UNIQUE KEY `UN_Codigo` (`Codigo`);

--
-- Indices de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  ADD PRIMARY KEY (`IdTipoMovimiento`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `planservicio`
--
ALTER TABLE `planservicio`
  MODIFY `IdPlan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `IdServicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipoaplicacionservicio`
--
ALTER TABLE `tipoaplicacionservicio`
  MODIFY `IdTipoAplicacionServicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  MODIFY `IdTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
