-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2023 a las 22:59:16
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `studium_dws_p2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elegir`
--

CREATE TABLE `elegir` (
  `idElegir` int NOT NULL,
  `idNinoFK` int NOT NULL,
  `idRegaloFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `elegir`
--

INSERT INTO `elegir` (`idElegir`, `idNinoFK`, `idRegaloFK`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 4),
(4, 4, 2),
(5, 5, 7),
(6, 6, 3),
(7, 2, 11),
(8, 6, 4),
(9, 5, 1),
(10, 2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninos`
--

CREATE TABLE `ninos` (
  `idNino` int NOT NULL,
  `nombreNino` varchar(45) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `apellidoNino` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fechaNacimientoNino` date NOT NULL,
  `buenoMalo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `ninos`
--

INSERT INTO `ninos` (`idNino`, `nombreNino`, `apellidoNino`, `fechaNacimientoNino`, `buenoMalo`) VALUES
(1, 'Alberto', 'Alcántara', '1994-10-13', 0),
(2, 'Beatriz', 'Bueno', '1982-04-18', 1),
(3, 'Carlos', 'Crepo', '1998-12-01', 1),
(4, 'Diana', 'Domínguez', '1987-09-02', 0),
(5, 'Emilio', 'Enamorado', '1996-08-12', 1),
(6, 'Francisca', 'Fernández', '1990-07-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regalos`
--

CREATE TABLE `regalos` (
  `idRegalo` int NOT NULL,
  `nombreRegalo` varchar(50) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `precioRegalo` double(6,2) NOT NULL,
  `idReyMagoFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `regalos`
--

INSERT INTO `regalos` (`idRegalo`, `nombreRegalo`, `precioRegalo`, `idReyMagoFK`) VALUES
(1, 'Aula de ciencia: Robot Mini ERP', 159.95, 1),
(2, 'Carbón', 0.00, 1),
(3, 'Cochecito Classic', 99.95, 1),
(4, 'Consola PS4 1 TB', 349.90, 1),
(5, 'Lego Villa familiar modular', 64.99, 2),
(6, 'Magia Borras Clásica 10 trucos con luz', 30.99, 2),
(7, 'Nenuco Hace pompas', 29.95, 2),
(8, 'Peluche delfín rosa', 34.00, 2),
(9, 'Pequeordenador', 22.95, 3),
(10, 'Robot Coji', 69.95, 3),
(11, 'Twister', 17.95, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reyesmagos`
--

CREATE TABLE `reyesmagos` (
  `idReyMago` int NOT NULL,
  `nombreReyMago` varchar(45) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `reyesmagos`
--

INSERT INTO `reyesmagos` (`idReyMago`, `nombreReyMago`) VALUES
(1, 'Melchor'),
(2, 'Gaspar'),
(3, 'Baltasar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `elegir`
--
ALTER TABLE `elegir`
  ADD PRIMARY KEY (`idElegir`),
  ADD KEY `idNino` (`idNinoFK`),
  ADD KEY `idRegalo` (`idRegaloFK`);

--
-- Indices de la tabla `ninos`
--
ALTER TABLE `ninos`
  ADD PRIMARY KEY (`idNino`);

--
-- Indices de la tabla `regalos`
--
ALTER TABLE `regalos`
  ADD PRIMARY KEY (`idRegalo`);

--
-- Indices de la tabla `reyesmagos`
--
ALTER TABLE `reyesmagos`
  ADD PRIMARY KEY (`idReyMago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `elegir`
--
ALTER TABLE `elegir`
  MODIFY `idElegir` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ninos`
--
ALTER TABLE `ninos`
  MODIFY `idNino` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `regalos`
--
ALTER TABLE `regalos`
  MODIFY `idRegalo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `reyesmagos`
--
ALTER TABLE `reyesmagos`
  MODIFY `idReyMago` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `elegir`
--
ALTER TABLE `elegir`
  ADD CONSTRAINT `elegir_ibfk_1` FOREIGN KEY (`idNinoFK`) REFERENCES `ninos` (`idNino`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `elegir_ibfk_2` FOREIGN KEY (`idRegaloFK`) REFERENCES `regalos` (`idRegalo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `reyesmagos`
--
ALTER TABLE `reyesmagos`
  ADD CONSTRAINT `reyesmagos_ibfk_1` FOREIGN KEY (`idReyMago`) REFERENCES `regalos` (`idRegalo`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
