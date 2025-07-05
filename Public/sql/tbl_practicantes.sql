-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 05-07-2025 a las 06:31:27
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
-- Estructura de tabla para la tabla `tbl_practicantes`
--

CREATE TABLE `tbl_practicantes` (
  `idepracticante` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `numero_identificacion` varchar(20) NOT NULL,
  `arl` varchar(100) NOT NULL,
  `edad` int(3) NOT NULL,
  `sexo` enum('masculino','femenino') NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` text NOT NULL,
  `dependencia_fk` int(11) NOT NULL,
  `cargo_hacer` varchar(200) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `contrato_practicante_fk` int(11) NOT NULL,
  `formacion_academica` varchar(100) NOT NULL,
  `programa_estudio` varchar(100) NOT NULL,
  `institucion_educativa` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_practicantes`
--

INSERT INTO `tbl_practicantes` (`idepracticante`, `nombre_completo`, `numero_identificacion`, `arl`, `edad`, `sexo`, `correo_electronico`, `telefono`, `direccion`, `dependencia_fk`, `cargo_hacer`, `fecha_ingreso`, `fecha_salida`, `contrato_practicante_fk`, `formacion_academica`, `programa_estudio`, `institucion_educativa`, `status`) VALUES
(4, 'Juan Carlos Pérez López', '1234567890', 'Colmena', 22, 'masculino', 'juan.perez@ejemplo.com', '3001234567', 'Calle 15 # 25-30, La Jagua', 1, 'Apoyo en gestión administrativa y desarrollo de sistemas', '2024-01-15', '2024-06-15', 1, 'Técnico', 'Técnico en Sistemas', 'SENA', 1),
(5, 'María Fernanda Rodríguez', '9876543210', 'Sura', 21, 'femenino', 'maria.rodriguez@ejemplo.com', '3109876543', 'Carrera 8 # 12-45, La Jagua', 2, 'Apoyo en atención al ciudadano y programación web', '2024-02-01', '2024-07-01', 2, 'Técnico', 'Técnico en Programación', 'Instituto Tecnológico', 1),
(6, 'Carlos Andrés Morales', '1122334455', 'Colpatria', 20, 'masculino', 'carlos.morales@ejemplo.com', '3156789012', 'Avenida 5 # 10-20, La Jagua', 3, 'Desarrollo de aplicaciones y mantenimiento de sistemas', '2024-03-01', '2024-08-01', 3, 'Técnico', 'Técnico en Desarrollo de Software', 'SENA', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  ADD PRIMARY KEY (`idepracticante`),
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD KEY `dependencia_fk` (`dependencia_fk`),
  ADD KEY `contrato_practicante_fk` (`contrato_practicante_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  MODIFY `idepracticante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  ADD CONSTRAINT `fk_practicantes_contrato` FOREIGN KEY (`contrato_practicante_fk`) REFERENCES `tbl_contratos_practicantes` (`id_contrato_practicante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_practicantes_dependencia` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
