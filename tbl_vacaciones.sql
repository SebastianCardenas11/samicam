-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 15-05-2025 a las 06:11:08
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
-- Estructura de tabla para la tabla `tbl_vacaciones`
--

CREATE TABLE `tbl_vacaciones` (
  `id_vacaciones` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `periodo` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Pendiente',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_vacaciones`
--

INSERT INTO `tbl_vacaciones` (`id_vacaciones`, `id_funcionario`, `fecha_inicio`, `fecha_fin`, `periodo`, `estado`, `fecha_registro`) VALUES
(1, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 21:12:24'),
(2, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 21:12:30'),
(3, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 22:07:27'),
(4, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 22:07:33'),
(5, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 22:32:08'),
(6, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 22:32:13'),
(7, 6, '2025-05-14', '2025-05-29', 1, 'Cancelado', '2025-05-14 22:32:36'),
(8, 6, '2025-05-14', '2025-05-14', 1, 'Cancelado', '2025-05-14 22:32:42'),
(9, 6, '2025-05-14', '2025-05-29', 2, 'Aprobado', '2025-05-14 22:54:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD PRIMARY KEY (`id_vacaciones`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD CONSTRAINT `fk_vacaciones_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
