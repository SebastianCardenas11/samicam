-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2025 a las 17:51:29
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
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `id_categoria`, `nombre`, `descripcion`, `archivo`, `extension`, `fecha_creacion`) VALUES
(1, 8, 'Certificacion', 'Certificacion', '2ae47bb309e683e9ae03139f8d380e1c.docx', 'docx', '2025-05-18 23:00:30'),
(3, 8, 'pdf 2', 'pdf 2', '0a006ee701b6ef45666604d584e7b9ca.pdf', 'pdf', '2025-05-18 23:09:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_archivos`
--

CREATE TABLE `categorias_archivos` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_archivos`
--

INSERT INTO `categorias_archivos` (`id_categoria`, `nombre`, `descripcion`, `status`, `fecha_creacion`) VALUES
(1, 'Documentos Administrativos', 'Documentos relacionados con procesos administrativos', 1, '2025-06-05 10:01:34'),
(2, 'Recursos Humanos', 'Documentos del área de recursos humanos', 1, '2025-06-05 10:01:34'),
(3, 'Contratos', 'Documentos contractuales y acuerdos', 1, '2025-06-05 10:01:34'),
(4, 'Informes', 'Informes y reportes varios', 1, '2025-06-05 10:01:34'),
(5, 'Certificaciones', 'Certificados y documentos oficiales', 1, '2025-06-05 10:01:34'),
(6, 'Memorandos', 'Memorandos internos y comunicaciones', 1, '2025-06-05 10:01:34'),
(7, 'Resoluciones', 'Resoluciones y documentos legales', 1, '2025-06-05 10:01:34'),
(8, 'Otros', 'Documentos varios sin categoría específica', 1, '2025-06-05 10:01:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Inicio', 'Inicio', 1),
(2, 'Usuarios', 'Gestión de usuarios', 1),
(3, 'Roles', 'Gestión de roles', 1),
(4, 'Funcionarios Ops', 'Gestión de funcionarios Ops', 1),
(5, 'Funcionarios Planta', 'Gestión de funcionarios de planta', 1),
(6, 'Vacaciones', 'Gestión de vacaciones', 1),
(7, 'Viáticos', 'Gestión de viáticos', 1),
(8, 'Archivos', 'Gestión de archivos', 1),
(9, 'Cargos', 'Gestión de cargos', 1),
(11, 'Tareas', 'Gestión de Tareas', 1),
(12, 'Publicaciones', 'Gestión de Publicaciones', 1),
(13, 'Dependencian', 'Gestión de dependencias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0,
  `v` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Permiso de visibilidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(507, 1, 1, 1, 1, 1, 1, 1),
(508, 1, 2, 1, 1, 1, 1, 1),
(509, 1, 3, 1, 1, 1, 1, 1),
(510, 1, 4, 1, 1, 1, 1, 1),
(511, 1, 6, 1, 1, 1, 1, 1),
(512, 1, 7, 1, 1, 1, 1, 1),
(513, 1, 8, 1, 1, 1, 1, 1),
(514, 1, 9, 1, 1, 1, 1, 1),
(515, 1, 5, 1, 1, 1, 1, 1),
(516, 1, 10, 1, 1, 1, 1, 1),
(634, 1, 13, 1, 1, 1, 1, 1),
(635, 2, 1, 0, 0, 0, 0, 0),
(636, 2, 7, 1, 1, 1, 1, 1),
(637, 2, 2, 0, 0, 0, 0, 0),
(638, 2, 8, 0, 0, 0, 0, 1),
(639, 2, 3, 0, 0, 0, 0, 0),
(640, 1, 9, 1, 1, 1, 1, 1),
(641, 2, 4, 0, 0, 0, 0, 0),
(642, 2, 5, 0, 0, 0, 0, 0),
(643, 2, 6, 1, 1, 1, 1, 1),
(644, 2, 7, 1, 1, 1, 1, 1),
(645, 2, 8, 0, 0, 0, 0, 1),
(646, 2, 9, 1, 1, 1, 1, 1),
(692, 4, 1, 0, 0, 0, 0, 0),
(693, 4, 2, 0, 0, 0, 0, 0),
(694, 4, 3, 0, 0, 0, 0, 0),
(695, 4, 4, 0, 0, 0, 0, 0),
(696, 4, 5, 0, 0, 0, 0, 0),
(697, 4, 6, 0, 0, 0, 0, 0),
(698, 4, 7, 0, 0, 0, 0, 0),
(699, 4, 8, 1, 1, 1, 1, 1),
(700, 4, 9, 0, 0, 0, 0, 0),
(701, 11, 1, 1, 1, 1, 1, 1),
(702, 11, 2, 0, 0, 0, 0, 1),
(703, 11, 3, 0, 0, 0, 0, 1),
(704, 11, 4, 0, 0, 0, 0, 1),
(705, 11, 5, 0, 0, 0, 0, 1),
(706, 11, 6, 0, 0, 0, 0, 1),
(707, 11, 7, 0, 0, 0, 0, 1),
(708, 11, 8, 0, 0, 0, 0, 1),
(709, 11, 9, 0, 0, 0, 0, 1),
(710, 1, 11, 1, 1, 1, 1, 1),
(711, 3, 1, 1, 0, 0, 0, 1),
(712, 3, 2, 0, 0, 0, 0, 1),
(713, 3, 3, 0, 0, 0, 0, 1),
(714, 3, 4, 1, 0, 0, 0, 1),
(715, 3, 5, 1, 0, 0, 0, 1),
(716, 3, 6, 1, 0, 0, 0, 1),
(717, 3, 7, 0, 0, 0, 0, 1),
(718, 3, 8, 1, 0, 0, 0, 1),
(719, 3, 9, 0, 0, 0, 0, 1),
(720, 3, 11, 1, 1, 1, 1, 1),
(761, 1, 12, 1, 1, 1, 1, 1),
(784, 7, 1, 1, 1, 1, 1, 1),
(785, 7, 2, 0, 0, 0, 0, 1),
(786, 7, 3, 0, 0, 0, 0, 1),
(787, 7, 4, 0, 0, 0, 0, 1),
(788, 7, 5, 0, 0, 0, 0, 1),
(789, 7, 6, 0, 0, 0, 0, 1),
(790, 7, 7, 0, 0, 0, 0, 1),
(791, 7, 8, 1, 1, 1, 1, 1),
(792, 7, 9, 0, 0, 0, 0, 1),
(793, 7, 11, 1, 1, 1, 1, 1),
(794, 7, 12, 0, 0, 0, 0, 1),
(817, 5, 1, 1, 1, 1, 1, 1),
(818, 5, 2, 1, 0, 0, 0, 1),
(819, 5, 3, 0, 0, 0, 0, 1),
(820, 5, 4, 0, 0, 0, 0, 1),
(821, 5, 5, 0, 0, 0, 0, 1),
(822, 5, 6, 0, 0, 0, 0, 1),
(823, 5, 7, 0, 0, 0, 0, 1),
(824, 5, 8, 0, 0, 0, 0, 1),
(825, 5, 9, 0, 0, 0, 0, 1),
(826, 5, 11, 1, 1, 1, 1, 1),
(827, 5, 12, 0, 0, 0, 0, 1),
(839, 12, 1, 1, 1, 1, 1, 1),
(840, 12, 2, 0, 0, 0, 0, 1),
(841, 12, 3, 0, 0, 0, 0, 1),
(842, 12, 4, 0, 0, 0, 0, 1),
(843, 12, 5, 0, 0, 0, 0, 1),
(844, 12, 6, 0, 0, 0, 0, 1),
(845, 12, 7, 0, 0, 0, 0, 1),
(846, 12, 8, 0, 0, 0, 0, 1),
(847, 12, 9, 0, 0, 0, 0, 1),
(848, 12, 11, 0, 0, 0, 0, 1),
(849, 12, 12, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id_publicacion` int(11) NOT NULL,
  `nombre_publicacion` varchar(255) NOT NULL,
  `fecha_recibido` date NOT NULL,
  `correo_recibido` varchar(100) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `respuesta_envio` enum('Si','No') NOT NULL DEFAULT 'No',
  `enlace_publicacion` varchar(500) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id_publicacion`, `nombre_publicacion`, `fecha_recibido`, `correo_recibido`, `asunto`, `fecha_publicacion`, `respuesta_envio`, `enlace_publicacion`, `dependencia_fk`, `status`) VALUES
(7, 'yes', '2025-06-05', 'carlos@gmial.com', 'yes', '2025-06-20', 'Si', 'www.com', 16, 0),
(8, 'Prueba', '2025-06-05', 'Prueba@xnpublicacin-obb', 'Prueba', '2025-06-05', 'Si', 'www.com', 11, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `nombrerol` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Superadministrador', 'Acceso a todo el sistema', 1),
(2, 'Jefe Talento Humano', 'Acceso total al área de Talento Humano', 1),
(3, 'Secretaria TH', 'Apoyo administrativo en el area de Talento Humano', 1),
(4, 'Contratación', 'Acceso total al área de Contratación', 1),
(5, 'Tecnico Ntic', 'Apoyo técnico en el área de Ntic', 1),
(6, 'Usuario', 'el sugeto no presenta cambios', 0),
(7, 'Secretaria Ntic', 'Apoyo administrativo en el área de Ntic ', 1),
(11, 'Prueba', '1', 0),
(12, 'Gobierno digital', 'Gestión de redes sociales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_capital_viaticos`
--

CREATE TABLE `tbl_capital_viaticos` (
  `idCapital` int(11) NOT NULL,
  `anio` int(4) NOT NULL,
  `capital_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `capital_disponible` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_capital_viaticos`
--

INSERT INTO `tbl_capital_viaticos` (`idCapital`, `anio`, `capital_total`, `capital_disponible`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 2025, 99999999.99, 99999999.99, '2025-05-15 19:38:53', '2025-06-04 19:46:50'),
(2, 2023, 99999999.99, 99999999.99, '2025-05-17 21:14:06', '2025-05-17 21:14:06'),
(3, 2024, 99999999.99, 99999999.99, '2025-05-17 21:14:08', '2025-05-17 21:14:08'),
(4, 2026, 99999999.99, 99999999.99, '2025-05-17 21:14:12', '2025-05-17 21:14:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cargos`
--

CREATE TABLE `tbl_cargos` (
  `idecargos` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `salario` decimal(15,2) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cargos`
--

INSERT INTO `tbl_cargos` (`idecargos`, `nombre`, `nivel`, `salario`, `estatus`) VALUES
(3, 'Técnico Administrativo (GS 3)', 'Técnico', 2825896.00, 1),
(33, 'Tecnico Administrativo (GS 4)', 'Técnico', 3468469.00, 1),
(35, 'Ayudante (GS 3)', 'Asistencial', 2009543.00, 1),
(36, 'Ayudante (GS 2)', 'Asistencial', 1863226.00, 1),
(37, 'Conductor', 'Asistencial', 2809334.00, 1),
(38, 'Secretaria Ejecutiva', 'Asistencial', 2775379.00, 1),
(39, 'Celador', 'Asistencial', 1863226.00, 1),
(40, 'Auxiliar de Servicios Generales', 'Asistencial', 1573388.00, 1),
(41, 'Auxiliar Administrativo (GS 2)', 'Asistencial', 1863226.00, 1),
(42, 'Auxiliar Administrativo (GS 4)', 'Asistencial', 2775397.00, 1),
(43, 'Secretaria Ejecutiva del Despacho del alcalde', 'Asistencial', 2810573.00, 1),
(44, 'Inspector de Policia', 'Técnico', 2825896.00, 1),
(45, 'Inspector de Transito y Transporte', 'Técnico', 2825896.00, 1),
(46, 'Técnico Operativo', 'Técnico', 2825896.00, 1),
(47, 'Agente de Transito', 'Técnico', 2825896.00, 1),
(48, 'Inspector de Policía Rural', 'Técnico', 1863360.00, 1),
(49, 'Alcalde', 'Directivo', 7889729.00, 1),
(50, 'Secretario de Despacho', 'Directivo', 5982216.00, 1),
(51, 'Secretario Local de Salud', 'Directivo', 5982216.00, 1),
(52, 'Jefe de Oficina de Control Interno Disciplinario', 'Directivo', 5982216.00, 1),
(53, 'Jefe de Oficina de Tics', 'Directivo', 5982216.00, 1),
(54, 'Jefe de Oficina de Contratación', 'Directivo', 5982216.00, 1),
(55, 'Asesor de Despacho', 'Asesor', 5982216.00, 1),
(56, 'Jefe de Oficina de Control Interno y Sistema de Gestión de Calidad', 'Asesor', 5982216.00, 1),
(57, 'Jefe de Oficina Asesora de Talento Humano', 'Asesor', 5982216.00, 1),
(58, 'Jefe de Oficina Asesora Jurídica, Legales y Administrativo', 'Asesor', 5982216.00, 1),
(59, 'Tesorera General', 'Profesional', 5095929.00, 1),
(60, 'Comisario de Familia', 'Profesional', 5095929.00, 1),
(61, 'Almacenista General', 'Profesional', 5095929.00, 1),
(62, 'Profesional Universitario (GS 2)', 'Profesional', 5095929.00, 1),
(63, 'Profesional Universitario (GS 1)', 'Profesional', 4202612.00, 1),
(64, 'Profesional Universitario Área de Salud (GS 2)', 'Profesional', 5095929.00, 1),
(65, 'Profesional Universitario Área de Salud (GS 1)', 'Profesional', 4202612.00, 1),
(66, 'Profesional Especializado', 'Profesional', 5542687.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_contrato`
--

CREATE TABLE `tbl_contrato` (
  `id_contrato` int(10) NOT NULL,
  `tipo_cont` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_contrato`
--

INSERT INTO `tbl_contrato` (`id_contrato`, `tipo_cont`) VALUES
(1, 'Carrera'),
(2, 'Libre Nombramiento'),
(3, 'Ops'),
(4, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dependencia`
--

CREATE TABLE `tbl_dependencia` (
  `dependencia_pk` int(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_dependencia`
--

INSERT INTO `tbl_dependencia` (`dependencia_pk`, `nombre`) VALUES
(1, 'Oficina de las NTIC'),
(3, 'Secretaría de Gobierno'),
(4, 'Secretaría de Educación, Cultura y Deporte'),
(5, 'Secretaría de Tránsito y Transporte'),
(6, 'Secretaría de Agricultura'),
(7, 'Secretaría de Salud'),
(8, 'Secretaría de Medio Ambiente y Turismo'),
(9, 'Secretaría de Planeación'),
(10, 'Secretaría de Infraestructura y Obras'),
(11, 'Secretaría de Hacienda'),
(12, 'Secretaría de la Mujer e Inclusión Social'),
(13, 'Oficina de Talento Humano'),
(14, 'Oficina de Control Interno de Gestión'),
(15, 'Oficina de Control Interno Disciplinario'),
(16, 'Oficina de Contratación'),
(17, 'Despacho del alcaldes'),
(18, 'Almacenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funcionarios_ops`
--

CREATE TABLE `tbl_funcionarios_ops` (
  `id` int(11) NOT NULL,
  `anio` year(4) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nombre_entidad` varchar(255) DEFAULT NULL,
  `numero_contrato` varchar(50) DEFAULT NULL,
  `fecha_firma_contrato` date DEFAULT NULL,
  `numero_proceso` varchar(50) DEFAULT NULL,
  `forma_contratacion` varchar(100) DEFAULT NULL,
  `codigo_banco_proyecto` varchar(50) DEFAULT NULL,
  `linea_estrategia` varchar(255) DEFAULT NULL,
  `fuente_recurso` varchar(100) DEFAULT NULL,
  `objeto` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `plazo_contrato` varchar(50) DEFAULT NULL,
  `valor_contrato` decimal(15,2) DEFAULT NULL,
  `clase_contrato` varchar(100) DEFAULT NULL,
  `nombre_contratista` varchar(255) DEFAULT NULL,
  `identificacion_contratista` varchar(20) DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `direccion_domicilio` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `entidad_bancaria` varchar(100) DEFAULT NULL,
  `tipo_cuenta` varchar(50) DEFAULT NULL,
  `numero_cuenta_bancaria` varchar(50) DEFAULT NULL,
  `numero_disp_presupuestal` varchar(50) DEFAULT NULL,
  `fecha_disp_presupuestal` date DEFAULT NULL,
  `valor_disp_presupuestal` decimal(15,2) DEFAULT NULL,
  `numero_registro_presupuestal` varchar(50) DEFAULT NULL,
  `fecha_registro_presupuestal` date DEFAULT NULL,
  `valor_registro_presupuestal` decimal(15,2) DEFAULT NULL,
  `cod_rubro` varchar(50) DEFAULT NULL,
  `rubro` varchar(100) DEFAULT NULL,
  `fuente_financiacion` varchar(100) DEFAULT NULL,
  `asignado_interventor` varchar(100) DEFAULT NULL,
  `unidad_ejecucion` varchar(100) DEFAULT NULL,
  `nombre_interventor` varchar(255) DEFAULT NULL,
  `identificacion_interventor` varchar(20) DEFAULT NULL,
  `tipo_vinculacion_interventor` varchar(100) DEFAULT NULL,
  `fecha_aprobacion_garantia` date DEFAULT NULL,
  `anticipo_contrato` decimal(15,2) DEFAULT NULL,
  `valor_pagado_anticipo` decimal(15,2) DEFAULT NULL,
  `fecha_pago_anticipo` date DEFAULT NULL,
  `numero_adiciones` int(11) DEFAULT NULL,
  `valor_total_adiciones` decimal(15,2) DEFAULT NULL,
  `numero_prorrogas` int(11) DEFAULT NULL,
  `tiempo_prorrogas` varchar(50) DEFAULT NULL,
  `numero_suspensiones` int(11) DEFAULT NULL,
  `tiempo_suspensiones` varchar(50) DEFAULT NULL,
  `valor_total_pagos` decimal(15,2) DEFAULT NULL,
  `fecha_terminacion` date DEFAULT NULL,
  `fecha_acta_liquidacion` date DEFAULT NULL,
  `estado_contrato` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `proviene_recurso_reactivacion` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funcionarios_planta`
--

CREATE TABLE `tbl_funcionarios_planta` (
  `idefuncionario` int(11) NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `imagen` varchar(300) DEFAULT NULL,
  `nm_identificacion` int(255) DEFAULT NULL,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `contrato_fk` int(10) NOT NULL,
  `celular` int(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo_elc` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `hijos` int(11) DEFAULT NULL,
  `nombres_de_hijos` varchar(255) DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `lugar_de_residencia` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `formacion_academica` varchar(255) DEFAULT NULL,
  `nombre_formacion` varchar(255) DEFAULT NULL,
  `permisos_fk` int(25) DEFAULT NULL,
  `status` int(15) NOT NULL,
  `periodos_vacaciones` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios_planta`
--

INSERT INTO `tbl_funcionarios_planta` (`idefuncionario`, `nombre_completo`, `imagen`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`) VALUES
(17, 'Elías José Iguaran Márquez', 'func_ed747eb4ecb9ce403cadc57cef932997.jpg', 1003379050, 3, 1, 2, 2147483647, 'Dg 6 5N - 86 / Luis Carlos Galan', 'helias.iguaran@gmail.com', '2025-03-10', 0, '', 'masculino', 'La Jagua de Ibirico', 22, 'soltero', 'catolico', 'tecnico', 'Técnico en Sistemas', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historial_permisos`
--

CREATE TABLE `tbl_historial_permisos` (
  `id_historial` int(25) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `mes` int(2) NOT NULL,
  `anio` int(4) NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_historial_permisos`
--

INSERT INTO `tbl_historial_permisos` (`id_historial`, `id_funcionario`, `fecha_permiso`, `mes`, `anio`, `motivo`, `estado`, `fecha_registro`, `tipo_funcionario`) VALUES
(9, 17, '2025-06-05', 6, 2025, 'Calamidad doméstica', 'Aprobado', '2025-06-05 10:16:34', 'planta');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_notificaciones`
--

CREATE TABLE `tbl_notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_observaciones`
--

CREATE TABLE `tbl_observaciones` (
  `id_observacion` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` bigint(32) NOT NULL,
  `observacion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos`
--

CREATE TABLE `tbl_permisos` (
  `id_permiso` int(25) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `mes` int(2) NOT NULL,
  `anio` int(4) NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Aprobado',
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`id_permiso`, `id_funcionario`, `fecha_permiso`, `mes`, `anio`, `motivo`, `estado`, `tipo_funcionario`) VALUES
(23, 10, '2025-05-16', 5, 2025, 'Cita médica', 'Aprobado', 'planta'),
(24, 10, '2025-06-17', 6, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(25, 10, '2025-07-17', 7, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(26, 10, '2025-11-17', 8, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(27, 10, '2025-05-17', 9, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(28, 10, '2025-09-17', 6, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(29, 10, '2025-08-17', 6, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(30, 10, '2025-08-17', 9, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(31, 10, '2025-05-17', 8, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(32, 10, '2025-05-16', 5, 2025, 'Cita médica', 'Aprobado', 'planta'),
(33, 10, '2025-05-16', 5, 2025, 'Cita médica', 'Aprobado', 'planta'),
(34, 10, '2025-05-17', 9, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(35, 10, '2025-06-17', 8, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(36, 10, '2025-06-17', 8, 2025, 'Calamidad doméstica', 'Aprobado', 'planta'),
(37, 17, '2025-05-30', 5, 2025, 'Capacitación', 'Aprobado', 'planta'),
(38, 17, '2025-05-31', 5, 2025, 'Cita médica', 'Aprobado', 'planta'),
(39, 17, '2025-06-01', 6, 2025, 'Capacitación', 'Aprobado', 'planta'),
(40, 17, '2025-06-05', 6, 2025, 'Calamidad doméstica', 'Aprobado', 'planta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tareas`
--

CREATE TABLE `tbl_tareas` (
  `id_tarea` int(11) NOT NULL,
  `id_usuario_creador` bigint(32) NOT NULL,
  `id_usuario_asignado` bigint(32) NOT NULL,
  `tipo` enum('administrativa','técnica') NOT NULL,
  `descripcion` text NOT NULL,
  `dependencia_fk` int(255) NOT NULL,
  `estado` enum('sin empezar','en curso','completada') NOT NULL DEFAULT 'sin empezar',
  `observacion` text DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `fecha_completada` datetime DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tareas_usuarios`
--

CREATE TABLE `tbl_tareas_usuarios` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` bigint(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `ideusuario` bigint(32) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `imgperfil` varchar(300) DEFAULT 'sin-imagen.png',
  `rolid` bigint(20) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ideusuario`, `nombres`, `correo`, `password`, `imgperfil`, `rolid`, `status`) VALUES
(1, 'Luis Carlos Duran', 'admin.ntic@gmail.com.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'perfil_1.webp', 1, 1),
(16, 'Tatiana Martínez Meneses', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'b3bac4078570ff255b11047d393c5a94a5e94767c426e7fc52e6eba3f44a6b8c', 'sin-imagen.png', 12, 1),
(17, 'Maria Del Pilar Ureche Cobo', 'contratacion@lajaguadeibirico-cesar.gov.co', 'f952d6714fe2c4580aa988789b437e60619e87fc63baa4d54a6cda71566516c4', 'sin-imagen.png', 4, 1),
(18, 'Moises Xavier Paternina', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'dbd1810444163ba9fde385331a2c457a4b2245473e85bbdfd0cebaa270cd5d3f', 'sin-imagen.png', 2, 1);

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
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `tbl_vacaciones`
--
DELIMITER $$
CREATE TRIGGER `check_vacaciones_fin` BEFORE UPDATE ON `tbl_vacaciones` FOR EACH ROW BEGIN
    DECLARE nombre_func VARCHAR(255);
    
    -- Si el estado cambia a 'Cumplidas' y antes era 'Aprobado'
    IF NEW.estado = 'Aprobado' AND DATEDIFF(NEW.fecha_fin, CURDATE()) = 1 THEN
        -- Obtener el nombre del funcionario
        SELECT nombre_completo INTO nombre_func 
        FROM tbl_funcionarios 
        WHERE idefuncionario = NEW.id_funcionario;
        
        -- Insertar notificación
        INSERT INTO tbl_notificaciones (id_funcionario, tipo, mensaje)
        VALUES (NEW.id_funcionario, 'vacaciones_fin', 
                CONCAT('Las vacaciones de ', nombre_func, ' terminan mañana (', NEW.fecha_fin, ')'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_viaticos`
--

CREATE TABLE `tbl_viaticos` (
  `idViatico` int(11) NOT NULL,
  `funci_fk` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fecha_aprobacion` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_regreso` date NOT NULL,
  `uso` text NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_archivo_categoria` (`id_categoria`);

--
-- Indices de la tabla `categorias_archivos`
--
ALTER TABLE `categorias_archivos`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `rolid` (`rolid`),
  ADD KEY `moduloid` (`moduloid`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `dependencia_fk` (`dependencia_fk`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tbl_capital_viaticos`
--
ALTER TABLE `tbl_capital_viaticos`
  ADD PRIMARY KEY (`idCapital`),
  ADD UNIQUE KEY `anio_unique` (`anio`);

--
-- Indices de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  ADD PRIMARY KEY (`idecargos`);

--
-- Indices de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  ADD PRIMARY KEY (`dependencia_pk`);

--
-- Indices de la tabla `tbl_funcionarios_ops`
--
ALTER TABLE `tbl_funcionarios_ops`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  ADD PRIMARY KEY (`idefuncionario`),
  ADD KEY `cargo_fk` (`cargo_fk`),
  ADD KEY `dependencia_fk` (`dependencia_fk`),
  ADD KEY `contrato_fk` (`contrato_fk`),
  ADD KEY `permisos_fk` (`permisos_fk`);

--
-- Indices de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  ADD PRIMARY KEY (`id_observacion`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_usuario_creador` (`id_usuario_creador`),
  ADD KEY `id_usuario_asignado` (`id_usuario_asignado`),
  ADD KEY `dependencia_fk` (`dependencia_fk`);

--
-- Indices de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ideusuario`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD PRIMARY KEY (`id_vacaciones`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  ADD PRIMARY KEY (`idViatico`),
  ADD KEY `funci_fk` (`funci_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias_archivos`
--
ALTER TABLE `categorias_archivos`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=850;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_capital_viaticos`
--
ALTER TABLE `tbl_capital_viaticos`
  MODIFY `idCapital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `idecargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  MODIFY `id_contrato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  MODIFY `dependencia_pk` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_ops`
--
ALTER TABLE `tbl_funcionarios_ops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `fk_archivo_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_archivos` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`);

--
-- Filtros para la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  ADD CONSTRAINT `tbl_funcionarios_planta_ibfk_1` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`),
  ADD CONSTRAINT `tbl_funcionarios_planta_ibfk_2` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_funcionarios_planta_ibfk_3` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_funcionarios_planta_ibfk_4` FOREIGN KEY (`permisos_fk`) REFERENCES `tbl_permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  ADD CONSTRAINT `tbl_historial_permisos_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  ADD CONSTRAINT `tbl_notificaciones_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  ADD CONSTRAINT `tbl_observaciones_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tbl_tareas` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_observaciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  ADD CONSTRAINT `tbl_tareas_ibfk_1` FOREIGN KEY (`id_usuario_creador`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_tareas_ibfk_2` FOREIGN KEY (`id_usuario_asignado`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_tareas_ibfk_3` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  ADD CONSTRAINT `tbl_tareas_usuarios_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tbl_tareas` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_tareas_usuarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD CONSTRAINT `fk_vacaciones_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
