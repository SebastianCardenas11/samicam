-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 05-07-2025 a las 06:31:52
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
-- Estructura de tabla para la tabla `tbl_contratos_practicantes`
--

CREATE TABLE `tbl_contratos_practicantes` (
  `id_contrato_practicante` int(11) NOT NULL,
  `nombre_contrato` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_contratos_practicantes`
--

INSERT INTO `tbl_contratos_practicantes` (`id_contrato_practicante`, `nombre_contrato`, `descripcion`, `status`) VALUES
(1, 'Pasantías', 'Contrato de pasantías para estudiantes universitarios', 1),
(2, 'Contrato de Aprendizaje', 'Contrato de aprendizaje para formación laboral', 1),
(3, 'Práctica Profesional', 'Práctica profesional para estudiantes de últimos semestres', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  ADD PRIMARY KEY (`id_contrato_practicante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  MODIFY `id_contrato_practicante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
