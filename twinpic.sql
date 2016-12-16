-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2016 a las 15:09:37
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `twinpic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `idDevice` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `positives` int(11) DEFAULT NULL,
  `negatives` int(11) DEFAULT NULL,
  `warnings` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `picture`
--

INSERT INTO `picture` (`id`, `idDevice`, `latitude`, `longitude`, `positives`, `negatives`, `warnings`, `date`, `file`) VALUES
(1, '1', 1, 1, 0, 0, 0, '2016-12-13 22:33:51', 'carita.png'),
(2, '2', 2, 2, 0, 0, 0, '2016-12-13 22:33:54', 'Chrysanthemum.jpg'),
(3, '3', 3, 3, 0, 0, 0, '2016-12-13 22:33:56', 'Desert.jpg'),
(4, '4', 4, 4, 0, 0, 0, '2016-12-13 22:33:57', 'Hydrangeas.jpg'),
(5, '5', 5, 5, 0, 0, 0, '2016-12-13 22:33:58', 'Jellyfish.jpg'),
(6, '6', 6, 6, 0, 0, 0, '2016-12-13 22:33:59', 'Koala.jpg'),
(7, '7', 7, 7, 0, 0, 0, '2016-12-13 22:33:59', 'Lighthouse.jpg'),
(8, '8', 8, 8, 0, 0, 0, '2016-12-13 22:34:00', 'Tulips.jpg'),
(9, '832c12d4c6770f03', -23.6618658, -70.403049, 0, 0, 0, '2016-12-16 07:17:00', '832c12d4c6770f032016_12_16_07_17'),
(10, '832c12d4c6770f03', -23.6619243, -70.4031113, 0, 0, 0, '2016-12-16 07:59:00', '832c12d4c6770f032016_12_16_07_59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twin`
--

CREATE TABLE `twin` (
  `idDevice` varchar(255) NOT NULL,
  `id1` bigint(20) NOT NULL,
  `id2` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `twin`
--

INSERT INTO `twin` (`idDevice`, `id1`, `id2`) VALUES
('1', 1, 5),
('2', 2, 6),
('3', 3, 7),
('4', 4, 8),
('832c12d4c6770f03', 8, 5),
('832c12d4c6770f03', 9, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDevice` (`idDevice`);

--
-- Indices de la tabla `twin`
--
ALTER TABLE `twin`
  ADD PRIMARY KEY (`idDevice`,`id1`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
