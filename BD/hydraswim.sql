-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2024 a las 21:39:14
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hydraswim`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calentamiento`
--

CREATE TABLE `calentamiento` (
  `id_calentamiento` int(11) NOT NULL,
  `id_entrenamiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_calentamiento`
--

CREATE TABLE `ejercicios_calentamiento` (
  `id_ejercicio` int(11) NOT NULL,
  `id_parte` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `metros` int(11) DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `estilo` varchar(50) DEFAULT NULL,
  `tecnica` varchar(50) DEFAULT NULL,
  `ritmo` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_parte_principal`
--

CREATE TABLE `ejercicios_parte_principal` (
  `id_ejercicio` int(11) NOT NULL,
  `id_parte` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `metros` int(11) DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `estilo` varchar(50) DEFAULT NULL,
  `tecnica` varchar(50) DEFAULT NULL,
  `ritmo` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_vuelta_calma`
--

CREATE TABLE `ejercicios_vuelta_calma` (
  `id_ejercicio` int(11) NOT NULL,
  `id_parte` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `metros` int(11) DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `estilo` varchar(50) DEFAULT NULL,
  `tecnica` varchar(50) DEFAULT NULL,
  `ritmo` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenamientos`
--

CREATE TABLE `entrenamientos` (
  `id_entrenamiento` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parte_principal`
--

CREATE TABLE `parte_principal` (
  `id_parte_principal` int(11) NOT NULL,
  `id_entrenamiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelta_calma`
--

CREATE TABLE `vuelta_calma` (
  `id_vuelta_calma` int(11) NOT NULL,
  `id_entrenamiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calentamiento`
--
ALTER TABLE `calentamiento`
  ADD PRIMARY KEY (`id_calentamiento`),
  ADD KEY `id_entrenamiento` (`id_entrenamiento`);

--
-- Indices de la tabla `ejercicios_calentamiento`
--
ALTER TABLE `ejercicios_calentamiento`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `id_parte` (`id_parte`);

--
-- Indices de la tabla `ejercicios_parte_principal`
--
ALTER TABLE `ejercicios_parte_principal`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `id_parte` (`id_parte`);

--
-- Indices de la tabla `ejercicios_vuelta_calma`
--
ALTER TABLE `ejercicios_vuelta_calma`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `id_parte` (`id_parte`);

--
-- Indices de la tabla `entrenamientos`
--
ALTER TABLE `entrenamientos`
  ADD PRIMARY KEY (`id_entrenamiento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `parte_principal`
--
ALTER TABLE `parte_principal`
  ADD PRIMARY KEY (`id_parte_principal`),
  ADD KEY `id_entrenamiento` (`id_entrenamiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vuelta_calma`
--
ALTER TABLE `vuelta_calma`
  ADD PRIMARY KEY (`id_vuelta_calma`),
  ADD KEY `id_entrenamiento` (`id_entrenamiento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calentamiento`
--
ALTER TABLE `calentamiento`
  MODIFY `id_calentamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicios_calentamiento`
--
ALTER TABLE `ejercicios_calentamiento`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicios_parte_principal`
--
ALTER TABLE `ejercicios_parte_principal`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicios_vuelta_calma`
--
ALTER TABLE `ejercicios_vuelta_calma`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrenamientos`
--
ALTER TABLE `entrenamientos`
  MODIFY `id_entrenamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parte_principal`
--
ALTER TABLE `parte_principal`
  MODIFY `id_parte_principal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vuelta_calma`
--
ALTER TABLE `vuelta_calma`
  MODIFY `id_vuelta_calma` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calentamiento`
--
ALTER TABLE `calentamiento`
  ADD CONSTRAINT `calentamiento_ibfk_1` FOREIGN KEY (`id_entrenamiento`) REFERENCES `entrenamientos` (`id_entrenamiento`);

--
-- Filtros para la tabla `ejercicios_calentamiento`
--
ALTER TABLE `ejercicios_calentamiento`
  ADD CONSTRAINT `ejercicios_calentamiento_ibfk_1` FOREIGN KEY (`id_parte`) REFERENCES `calentamiento` (`id_calentamiento`);

--
-- Filtros para la tabla `ejercicios_parte_principal`
--
ALTER TABLE `ejercicios_parte_principal`
  ADD CONSTRAINT `ejercicios_parte_principal_ibfk_1` FOREIGN KEY (`id_parte`) REFERENCES `parte_principal` (`id_parte_principal`);

--
-- Filtros para la tabla `ejercicios_vuelta_calma`
--
ALTER TABLE `ejercicios_vuelta_calma`
  ADD CONSTRAINT `ejercicios_vuelta_calma_ibfk_1` FOREIGN KEY (`id_parte`) REFERENCES `vuelta_calma` (`id_vuelta_calma`);

--
-- Filtros para la tabla `entrenamientos`
--
ALTER TABLE `entrenamientos`
  ADD CONSTRAINT `entrenamientos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `parte_principal`
--
ALTER TABLE `parte_principal`
  ADD CONSTRAINT `parte_principal_ibfk_1` FOREIGN KEY (`id_entrenamiento`) REFERENCES `entrenamientos` (`id_entrenamiento`);

--
-- Filtros para la tabla `vuelta_calma`
--
ALTER TABLE `vuelta_calma`
  ADD CONSTRAINT `vuelta_calma_ibfk_1` FOREIGN KEY (`id_entrenamiento`) REFERENCES `entrenamientos` (`id_entrenamiento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
