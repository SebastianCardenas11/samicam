-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 18:28:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `samicam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_motivo_permiso`
--

CREATE TABLE `tbl_motivo_permiso` (
  `id_motivo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_motivo_permiso`
--

INSERT INTO `tbl_motivo_permiso` (`id_motivo`, `descripcion`, `status`) VALUES
(1, 'Cita médica', 1),
(2, 'Calamidad doméstica', 1),
(3, 'Diligencia personal', 1),
(4, 'Capacitación', 1),
(5, 'Asunto familiar', 1),
(6, 'Muerte familiar', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  ADD PRIMARY KEY (`id_motivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
