-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2025 a las 23:31:59
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
-- Estructura de tabla para la tabla `seguimiento_contrato`
--

CREATE TABLE `seguimiento_contrato` (
  `id` int(11) NOT NULL,
  `objeto_contrato` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_terminacion` date NOT NULL,
  `plazo` int(11) NOT NULL,
  `tipo_plazo` varchar(255) NOT NULL,
  `valor_total_contrato` decimal(20,2) NOT NULL,
  `dia_corte_informe` date NOT NULL,
  `observaciones_ejecucion` text DEFAULT NULL,
  `evidenciado_secop` varchar(255) DEFAULT NULL,
  `fecha_verificacion` date DEFAULT NULL,
  `liquidacion` decimal(20,2) DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1,
  `numero_contrato` varchar(50) DEFAULT NULL,
  `fecha_aprobacion_entidad` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento_contrato`
--

INSERT INTO `seguimiento_contrato` (`id`, `objeto_contrato`, `fecha_inicio`, `fecha_terminacion`, `plazo`, `tipo_plazo`, `valor_total_contrato`, `dia_corte_informe`, `observaciones_ejecucion`, `evidenciado_secop`, `fecha_verificacion`, `liquidacion`, `estado`, `numero_contrato`, `fecha_aprobacion_entidad`) VALUES
(1, 'SUMINISTRO DE REPUESTOS Y MANO DE OBRA PARA LA REPARACIÓN DE LOS EQUIPOS DE IMPRESIÓN Y ESCÁNER EXISTENTES DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR', '2025-04-09', '2025-05-09', 3, 'meses', 37591000.00, '2025-05-12', 'TODO OK', 'SI', '2025-06-13', 37591000.00, 3, '176-2025', '2025-04-03'),
(2, 'COMPRAVENTA DE LICENCIAS DE ANTIVIRUS PARA LOS EQUIPOS DE CÓMPUTO DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR.', '2025-06-25', '2025-06-30', 12, 'dias', 28920000.00, '2025-06-23', 'TODO OK', 'SI', '2025-05-26', 28920000.00, 1, '215-2025', '2025-05-12'),
(5, 'COMPRAVENTA DE LICENCIAS DE ANTIVIRUS PARA LOS EQUIPOS DE CÓMPUTO DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR.', '2025-05-13', '2025-05-30', 12, 'dias', 28920000.00, '2025-06-23', 'TODO OK', 'SI', '2025-05-26', 28920000.00, 3, '215-2025', '2025-05-12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Tabla para prórrogas de contrato
CREATE TABLE `prorrogas_contrato` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_contrato` INT NOT NULL,
  `fecha_anterior` DATE NOT NULL,
  `nueva_fecha` DATE NOT NULL,
  `dias_prorroga` INT NOT NULL,
  `motivo` TEXT,
  `fecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_contrato`) REFERENCES seguimiento_contrato(`id`)
);
