-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 06-07-2025 a las 06:23:12
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
-- Estructura de tabla para la tabla `adiciones_contrato`
--

CREATE TABLE `adiciones_contrato` (
  `id` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `valor_adicion` decimal(15,2) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `fecha_adicion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adiciones_contrato`
--

INSERT INTO `adiciones_contrato` (`id`, `id_contrato`, `valor_adicion`, `motivo`, `fecha_adicion`) VALUES
(1, 7, 2000000.00, 'aa', '2025-06-26 01:11:13'),
(2, 7, 2000000.00, 'aaa', '2025-06-26 01:18:03');

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
  `fecha_creacion` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado del archivo: 1=activo, 0=eliminado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `id_categoria`, `nombre`, `descripcion`, `archivo`, `extension`, `fecha_creacion`, `status`) VALUES
(5, 6, 'Tecnico Ntic', 'aa', 'e563c9982e66703755e03686a4f6a8d1.pdf', 'pdf', '2025-06-08 23:02:23', 1);

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
(8, 'Otros', 'Documentos varios sin categoría específica', 1, '2025-06-05 10:01:34'),
(9, 'Informes', 'Informes y reportes varios', 1, '2025-06-05 10:01:34');

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
(10, 'Practicantes', 'Gestión de Practicantes', 1),
(11, 'Tareas', 'Gestión de Tareas', 1),
(12, 'Publicaciones', 'Gestión de Publicaciones', 1),
(13, 'Dependencian', 'Gestión de dependencias', 1),
(14, 'Seguimiento Contrato', 'Gestión de Seguimiento Contrato', 1),
(15, 'Inventario', 'Gestión de Inventario', 1),
(16, 'Registros Whatsapp', 'Gestión de Registros Whatsapp', 1);

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
(640, 1, 9, 1, 1, 1, 1, 1),
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
(720, 1, 11, 1, 1, 1, 1, 1),
(761, 1, 12, 1, 1, 1, 1, 1),
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
(849, 12, 12, 1, 1, 1, 1, 1),
(850, 4, 1, 0, 0, 0, 0, 1),
(851, 4, 2, 0, 0, 0, 0, 1),
(852, 4, 3, 0, 0, 0, 0, 1),
(853, 4, 4, 0, 0, 0, 0, 1),
(854, 4, 5, 0, 0, 0, 0, 1),
(855, 4, 6, 0, 0, 0, 0, 1),
(856, 4, 7, 0, 0, 0, 0, 1),
(857, 4, 8, 1, 1, 1, 1, 1),
(858, 4, 9, 0, 0, 0, 0, 1),
(859, 4, 11, 1, 1, 1, 1, 1),
(860, 4, 12, 0, 0, 0, 0, 1),
(861, 4, 13, 0, 0, 0, 0, 1),
(862, 2, 1, 0, 0, 0, 0, 1),
(863, 2, 2, 0, 0, 0, 0, 1),
(864, 2, 3, 0, 0, 0, 0, 1),
(865, 2, 4, 0, 0, 0, 0, 1),
(866, 2, 5, 0, 0, 0, 0, 1),
(867, 2, 6, 0, 0, 0, 0, 1),
(868, 2, 7, 0, 0, 0, 0, 1),
(869, 2, 8, 1, 1, 1, 1, 1),
(870, 2, 9, 0, 0, 0, 0, 1),
(871, 2, 11, 0, 0, 0, 0, 1),
(872, 2, 12, 0, 0, 0, 0, 1),
(873, 2, 13, 0, 0, 0, 0, 1),
(874, 1, 14, 1, 1, 1, 1, 1),
(875, 2, 14, 1, 1, 1, 1, 1),
(876, 3, 14, 1, 1, 1, 1, 1),
(877, 4, 14, 1, 1, 1, 1, 1),
(880, 12, 14, 1, 1, 1, 1, 1),
(881, 7, 1, 1, 1, 1, 1, 1),
(882, 7, 2, 0, 0, 0, 0, 1),
(883, 7, 3, 0, 0, 0, 0, 1),
(884, 7, 4, 0, 0, 0, 0, 1),
(885, 7, 5, 0, 0, 0, 0, 1),
(886, 7, 6, 0, 0, 0, 0, 1),
(887, 7, 7, 0, 0, 0, 0, 1),
(888, 7, 8, 0, 0, 0, 0, 1),
(889, 7, 9, 0, 0, 0, 0, 1),
(890, 7, 10, 0, 0, 0, 0, 1),
(891, 7, 11, 0, 0, 0, 0, 1),
(892, 7, 12, 1, 1, 1, 1, 1),
(893, 7, 13, 0, 0, 0, 0, 1),
(894, 7, 14, 0, 0, 0, 0, 1),
(978, 1, 15, 1, 1, 1, 1, 1),
(1084, 5, 1, 1, 1, 1, 1, 1),
(1085, 5, 2, 0, 0, 0, 0, 1),
(1086, 5, 3, 0, 0, 0, 0, 1),
(1087, 5, 4, 0, 0, 0, 0, 1),
(1088, 5, 5, 0, 0, 0, 0, 1),
(1089, 5, 6, 0, 0, 0, 0, 1),
(1090, 5, 7, 0, 0, 0, 0, 1),
(1091, 5, 8, 1, 1, 1, 1, 1),
(1092, 5, 9, 0, 0, 0, 0, 1),
(1093, 5, 10, 1, 1, 1, 1, 1),
(1094, 5, 11, 1, 1, 1, 1, 1),
(1095, 5, 12, 0, 0, 0, 0, 1),
(1096, 5, 13, 0, 0, 0, 0, 1),
(1097, 5, 14, 0, 0, 0, 0, 1),
(1098, 5, 15, 0, 0, 0, 0, 1),
(1099, 1, 15, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prorrogas_contrato`
--

CREATE TABLE `prorrogas_contrato` (
  `id` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `fecha_anterior` date NOT NULL,
  `nueva_fecha` date NOT NULL,
  `dias_prorroga` int(11) NOT NULL,
  `motivo` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prorrogas_contrato`
--

INSERT INTO `prorrogas_contrato` (`id`, `id_contrato`, `fecha_anterior`, `nueva_fecha`, `dias_prorroga`, `motivo`, `fecha_registro`) VALUES
(1, 5, '2025-06-22', '2025-06-30', 8, 'Cositas', '2025-06-25 23:51:10');

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
(7, 'yes', '2025-06-05', 'carlos@gmial.com', 'yes', '2025-06-20', 'Si', 'www.com', 16, 1),
(8, 'Prueba', '2025-06-05', 'Prueba@xnpublicacin-obb', 'Prueba', '2025-06-05', 'Si', 'www.com', 11, 1),
(9, '1', '2025-06-18', 'carlos@gmail.com', 'carta de aceptacion', '2025-06-19', 'Si', 'www.google.com.co', 7, 1),
(10, 'carlos', '2025-06-20', 'carlos@gmail.com', 'carta de aceptacion', '2025-06-20', 'Si', 'www.google.com.co', 18, 1);

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
(4, 'Contratación', 'Acceso total al área de Contratación', 0),
(5, 'Tecnico Ntic', 'Apoyo técnico en el área de Ntic', 1),
(6, 'Usuario', 'el sugeto no presenta cambios', 0),
(7, 'Secretaria Ntic', 'Apoyo administrativo en el área de Ntic ', 1),
(11, 'Prueba', '1', 0),
(12, 'Gobierno digital', 'Gestión de redes sociales', 1);

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
  `tipo_informe` enum('acta parcial','mes vencido') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci DEFAULT 'acta parcial',
  `cantidad_informes` int(11) DEFAULT 1,
  `valor_total_contrato` decimal(20,2) NOT NULL,
  `dia_corte_informe` date NOT NULL,
  `observaciones_ejecucion` text DEFAULT NULL,
  `evidenciado_secop` varchar(255) DEFAULT NULL,
  `fecha_verificacion` date DEFAULT NULL,
  `liquidacion` decimal(20,2) DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1,
  `numero_contrato` varchar(50) DEFAULT NULL,
  `dependencia_id` int(11) DEFAULT NULL,
  `fecha_aprobacion_entidad` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento_contrato`
--

INSERT INTO `seguimiento_contrato` (`id`, `objeto_contrato`, `fecha_inicio`, `fecha_terminacion`, `plazo`, `tipo_plazo`, `tipo_informe`, `cantidad_informes`, `valor_total_contrato`, `dia_corte_informe`, `observaciones_ejecucion`, `evidenciado_secop`, `fecha_verificacion`, `liquidacion`, `estado`, `numero_contrato`, `dependencia_id`, `fecha_aprobacion_entidad`) VALUES
(5, 'ENTIDAD PUBLICA', '2025-06-25', '2025-06-30', 23, 'dias', 'acta parcial', 1, 15000000.00, '2025-06-30', 'NINGUNA', 'OKKK', '2025-06-23', 20000000.00, 1, '614-23', 16, '2025-06-21'),
(6, 'Prestación de servicios de mantenimiento de equiposaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-01-15', '2025-06-15', 5, 'meses', 'acta parcial', 1, 15000000.00, '2025-01-30', 'Contrato liquidado', 'Si', '2025-06-10', 15000000.00, 1, 'CT-001-2025', 9, '2025-01-10'),
(7, 'Suministro de papelería', '2025-03-01', '2025-05-31', 3, 'meses', 'acta parcial', 1, 8000000.00, '2025-03-15', 'Contrato finalizado, pendiente liquidación', 'Si', '2025-06-01', 0.00, 1, 'CT-002-2025', 16, '2025-02-20'),
(8, 'asddddddddddddd', '2025-07-15', '2025-07-14', 123, 'meses', 'acta parcial', 2, 123123.00, '2025-07-23', 'qeqweqwe', 'wqeqwe', '2025-07-23', 1222222222222.00, 1, '1111', 18, '2025-07-04'),
(9, 'asddddddddddd', '2025-07-16', '2025-07-31', 12, 'dias', 'mes vencido', 1, 2111111111111100.00, '2025-07-10', 'dassssssssssss', 'asddasd', '2025-07-03', 1222222222223.00, 1, 'qweeeeeeee', 15, '2025-07-03');

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
(1, 2025, 99999999.99, 99989999.99, '2025-05-15 19:38:53', '2025-06-11 07:57:30'),
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
-- Estructura de tabla para la tabla `tbl_configuracion_permisos`
--

CREATE TABLE `tbl_configuracion_permisos` (
  `id_config` int(11) NOT NULL,
  `limite_permisos_diarios` int(11) NOT NULL DEFAULT 5,
  `hora_restablecimiento` time NOT NULL DEFAULT '00:00:00',
  `fecha_ultimo_reset` date NOT NULL DEFAULT curdate(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_configuracion_permisos`
--

INSERT INTO `tbl_configuracion_permisos` (`id_config`, `limite_permisos_diarios`, `hora_restablecimiento`, `fecha_ultimo_reset`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 5, '00:00:00', '2025-07-05', 1, '2025-07-05 05:29:52', '2025-07-05 05:29:52');

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
(2, 'Secretaría de Gobierno'),
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
  `nm_identificacion` varchar(20) DEFAULT NULL,
  `lugar_expedicion` varchar(255) DEFAULT NULL,
  `libreta_militar` varchar(50) DEFAULT NULL,
  `tipo_nombramiento` varchar(100) DEFAULT NULL,
  `nivel` varchar(100) DEFAULT NULL,
  `salario_basico` decimal(15,2) DEFAULT NULL,
  `acto_administrativo` varchar(255) DEFAULT NULL,
  `fecha_acto_nombramiento` date DEFAULT NULL,
  `no_acta_posesion` varchar(100) DEFAULT NULL,
  `fecha_acta_posesion` date DEFAULT NULL,
  `tiempo_laborado` varchar(100) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `grado` varchar(50) DEFAULT NULL,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `contrato_fk` int(10) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad_residencia` varchar(100) DEFAULT NULL,
  `correo_elc` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `rh` varchar(5) DEFAULT NULL,
  `estudios_realizados` varchar(255) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `tarjeta_profesional` varchar(100) DEFAULT NULL,
  `otros_estudios` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `hijos` int(11) DEFAULT NULL,
  `nombres_de_hijos` varchar(255) DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `lugar_de_residencia` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `cuenta_no` varchar(100) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `eps` varchar(100) DEFAULT NULL,
  `afp` varchar(100) DEFAULT NULL,
  `afc` varchar(100) DEFAULT NULL,
  `arl` varchar(100) DEFAULT NULL,
  `sindicalizado` tinyint(1) DEFAULT NULL,
  `madre_cabeza_hogar` tinyint(1) DEFAULT NULL,
  `prepensionado` tinyint(1) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `formacion_academica` varchar(255) DEFAULT NULL,
  `nombre_formacion` varchar(255) DEFAULT NULL,
  `permisos_fk` int(25) DEFAULT NULL,
  `status` int(15) NOT NULL DEFAULT 1,
  `periodos_vacaciones` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios_planta`
--

INSERT INTO `tbl_funcionarios_planta` (`idefuncionario`, `nombre_completo`, `nm_identificacion`, `lugar_expedicion`, `libreta_militar`, `tipo_nombramiento`, `nivel`, `salario_basico`, `acto_administrativo`, `fecha_acto_nombramiento`, `no_acta_posesion`, `fecha_acta_posesion`, `tiempo_laborado`, `codigo`, `grado`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `ciudad_residencia`, `correo_elc`, `fecha_nacimiento`, `lugar_nacimiento`, `rh`, `estudios_realizados`, `titulo`, `tarjeta_profesional`, `otros_estudios`, `fecha_ingreso`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `cuenta_no`, `banco`, `eps`, `afp`, `afc`, `arl`, `sindicalizado`, `madre_cabeza_hogar`, `prepensionado`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`) VALUES
(20, 'Juan Jose pertuz', '0000000000000', 'la jagua', 'no', 'adinisttrativo', '1', 9999999999999.99, '1111', '2025-06-25', '12312312', '2025-06-28', '23 meses', '12312', '3', 3, 1, 1, '12312', '12312312', 'la jagua', 'Juan@gmail.comsadddddddddddddd', '2025-06-26', 'sadasdd', 'ab+', '1', '11', '1', '1', '2025-06-24', 0, 'asdasd', 'masculino', '3123123123', 123, 'soltero', '11', '212', '1', '1212', '1212', '1212', 1, 1, 1, 'catolico', 'tecnico', 'asddasdasd', NULL, 1, 0),
(21, 'Juan Pérez', '12345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 1, '3001234567', 'Calle 123 #45-67', NULL, 'juan.perez@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-15', 0, '', 'masculino', 'La Jagua de Ibirico', 30, 'soltero', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'catolico', 'tecnico', 'Administración Pública', NULL, 1, 0);

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
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta',
  `es_permiso_especial` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si es un permiso especial (1) o normal (0)',
  `justificacion_especial` text DEFAULT NULL COMMENT 'Justificación detallada para permisos especiales'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_historial_permisos`
--

INSERT INTO `tbl_historial_permisos` (`id_historial`, `id_funcionario`, `fecha_permiso`, `mes`, `anio`, `motivo`, `estado`, `fecha_registro`, `tipo_funcionario`, `es_permiso_especial`, `justificacion_especial`) VALUES
(20, 20, '2025-07-05', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-05 00:41:46', 'planta', 0, ''),
(22, 20, '2025-07-14', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-05 00:55:23', 'planta', 0, ''),
(23, 20, '2025-07-30', 7, 2025, 'Capacitación', 'Aprobado', '2025-07-05 00:55:53', 'planta', 0, ''),
(30, 20, '2025-07-07', 7, 2025, 'Calamidad doméstica', 'Aprobado', '2025-07-05 01:22:25', 'planta', 0, '');

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

--
-- Volcado de datos para la tabla `tbl_observaciones`
--

INSERT INTO `tbl_observaciones` (`id_observacion`, `id_tarea`, `id_usuario`, `observacion`, `fecha_creacion`) VALUES
(8, 12, 1, 'asdasdasd', '2025-06-06 06:55:43'),
(12, 16, 17, 'Tvyv5', '2025-06-18 04:09:50'),
(13, 26, 1, 'asasddas', '2025-06-20 06:27:00'),
(14, 27, 1, 'asdasdasd', '2025-06-20 06:28:53'),
(15, 27, 1, 'Casi terminado por el', '2025-06-20 06:29:07');

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
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta',
  `es_permiso_especial` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si es un permiso especial (1) o normal (0)',
  `justificacion_especial` text DEFAULT NULL COMMENT 'Justificación detallada para permisos especiales',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro del permiso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`id_permiso`, `id_funcionario`, `fecha_permiso`, `mes`, `anio`, `motivo`, `estado`, `tipo_funcionario`, `es_permiso_especial`, `justificacion_especial`, `fecha_registro`) VALUES
(59, 17, '2025-07-05', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-05 01:18:05'),
(60, 17, '2025-07-06', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-05 01:22:19'),
(61, 20, '2025-07-07', 7, 2025, 'Calamidad doméstica', 'Aprobado', 'planta', 0, '', '2025-07-05 01:22:25'),
(62, 19, '2025-08-08', 8, 2025, 'Asunto familiar', 'Aprobado', 'planta', 0, '', '2025-07-05 01:22:31'),
(63, 19, '2025-07-05', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-05 01:22:36'),
(64, 17, '2025-08-09', 8, 2025, 'Capacitación', 'Aprobado', 'planta', 0, '', '2025-07-05 01:28:17'),
(65, 17, '2025-09-23', 9, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-05 01:29:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos_diarios`
--

CREATE TABLE `tbl_permisos_diarios` (
  `id_permiso_diario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total_permisos` int(11) NOT NULL DEFAULT 0,
  `limite_diario` int(11) NOT NULL DEFAULT 5,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_permisos_diarios`
--

INSERT INTO `tbl_permisos_diarios` (`id_permiso_diario`, `fecha`, `total_permisos`, `limite_diario`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, '2025-07-05', 0, 5, '2025-07-05 06:25:47', '2025-07-05 06:25:47'),
(2, '2025-08-09', 1, 5, '2025-07-05 06:28:17', '2025-07-05 06:28:17'),
(3, '2025-09-23', 1, 5, '2025-07-05 06:29:18', '2025-07-05 06:29:18');

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
(5, 'María Fernanda Rodríguez', '9876543210', 'Colpatria', 21, 'femenino', 'maria.rodriguez@ejemplo.com', '3109876543', 'Carrera 8 # 12-45, La Jagua', 2, 'Apoyo en atención al ciudadano y programación web', '2024-02-01', '2024-07-01', 2, 'Técnico', 'Técnico en Programación', 'Instituto Tecnológico', 0),
(6, 'Carlos Andrés Morales', '1122334455', 'Colpatria', 20, 'masculino', 'carlos.morales@ejemplo.com', '3156789012', 'Avenida 5 # 10-20, La Jagua', 3, 'Desarrollo de aplicaciones y mantenimiento de sistemas', '2024-03-01', '2024-08-01', 3, 'Técnico', 'Técnico en Desarrollo de Software', 'SENA', 1),
(7, 'Carlos David Lopez Tapia', '1065597082', 'Positiva', 19, 'masculino', 'carloslxpxz@gmail.com', '3216816858', 'calle 1c', 1, 'Programador', '2025-04-10', '2025-10-10', 1, 'Tecnico', 'Tecnico en Programacion de software', 'SENA', 1);

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

--
-- Volcado de datos para la tabla `tbl_tareas`
--

INSERT INTO `tbl_tareas` (`id_tarea`, `id_usuario_creador`, `id_usuario_asignado`, `tipo`, `descripcion`, `dependencia_fk`, `estado`, `observacion`, `fecha_inicio`, `fecha_fin`, `fecha_completada`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(12, 1, 1, 'administrativa', 'asdsd', 1, 'completada', NULL, '2025-06-19 00:00:00', '2025-06-27 00:00:00', '2025-06-06 00:00:00', '2025-06-06 06:55:31', '2025-06-06 07:05:48'),
(16, 1, 17, 'administrativa', 'fdfsdf', 1, 'completada', NULL, '2025-06-18 00:00:00', '2025-06-20 00:00:00', '2025-06-17 00:00:00', '2025-06-18 04:09:25', '2025-06-18 04:10:03'),
(23, 1, 17, 'administrativa', 'asdasd', 4, 'completada', NULL, '2025-06-20 00:00:00', '2025-06-23 00:00:00', '2025-06-20 00:00:00', '2025-06-20 06:16:16', '2025-06-20 06:21:06'),
(24, 1, 1, 'técnica', 'asdasd', 1, 'completada', NULL, '2025-06-20 00:00:00', '2025-06-22 00:00:00', '2025-06-20 00:00:00', '2025-06-20 06:22:08', '2025-06-20 06:24:10'),
(25, 1, 1, 'administrativa', 'asdasd', 5, 'completada', NULL, '2025-06-21 00:00:00', '2025-06-30 00:00:00', '2025-06-20 00:00:00', '2025-06-20 06:24:44', '2025-06-20 06:26:00'),
(26, 1, 1, 'técnica', 'sdASas', 1, 'completada', NULL, '2025-06-20 00:00:00', '2025-06-23 00:00:00', '2025-06-20 00:00:00', '2025-06-20 06:26:25', '2025-06-20 06:27:10'),
(27, 1, 1, 'técnica', 'asdasd', 5, 'completada', NULL, '2025-06-05 00:00:00', '2025-06-25 00:00:00', '2025-06-20 00:00:00', '2025-06-20 06:28:04', '2025-06-20 06:29:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tareas_usuarios`
--

CREATE TABLE `tbl_tareas_usuarios` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` bigint(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tareas_usuarios`
--

INSERT INTO `tbl_tareas_usuarios` (`id`, `id_tarea`, `id_usuario`) VALUES
(15, 12, 1),
(19, 16, 17),
(27, 23, 17),
(28, 24, 1),
(29, 25, 1),
(30, 26, 1),
(31, 27, 1);

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
  `status` int(32) NOT NULL,
  `notificaciones_activas` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ideusuario`, `nombres`, `correo`, `password`, `imgperfil`, `rolid`, `status`, `notificaciones_activas`) VALUES
(1, 'Luis Carlos Duran', 'admin.ntic@gmail.com.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'perfil_1.webp', 1, 1, 1),
(16, 'Tatiana Martínez Meneses', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'sin-imagen.png', 12, 1, 1),
(17, 'Maria Del Pilar Ureche Cobo', 'contratacion@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'sin-imagen.png', 5, 1, 1),
(18, 'Moises Xavier Paternina', 'talentohumano@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'sin-imagen.png', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios_roles`
--

CREATE TABLE `tbl_usuarios_roles` (
  `id` bigint(20) NOT NULL,
  `id_usuario` bigint(32) NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios_roles`
--

INSERT INTO `tbl_usuarios_roles` (`id`, `id_usuario`, `id_rol`, `fecha_asignacion`) VALUES
(1, 1, 1, '2025-07-05 05:00:33'),
(3, 17, 5, '2025-07-05 05:00:33'),
(4, 18, 2, '2025-07-05 05:00:33'),
(12, 16, 5, '2025-07-05 05:05:22'),
(13, 16, 12, '2025-07-05 05:05:22');

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
-- Volcado de datos para la tabla `tbl_viaticos`
--

INSERT INTO `tbl_viaticos` (`idViatico`, `funci_fk`, `descripcion`, `monto`, `fecha_aprobacion`, `fecha_salida`, `fecha_regreso`, `uso`, `estatus`, `fecha_creacion`) VALUES
(5, 18, 'prostibulo', 10000.00, '2025-06-11', '2025-06-12', '2025-06-14', 'cositas', 1, '2025-06-11 07:57:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adiciones_contrato`
--
ALTER TABLE `adiciones_contrato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contrato` (`id_contrato`);

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
-- Indices de la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contrato` (`id_contrato`);

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
-- Indices de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dependencia_id` (`dependencia_id`);

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
-- Indices de la tabla `tbl_configuracion_permisos`
--
ALTER TABLE `tbl_configuracion_permisos`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  ADD PRIMARY KEY (`id_contrato_practicante`);

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
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `idx_es_permiso_especial` (`es_permiso_especial`);

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
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `idx_es_permiso_especial` (`es_permiso_especial`),
  ADD KEY `idx_fecha_registro` (`fecha_registro`),
  ADD KEY `idx_permisos_fecha_tipo` (`fecha_permiso`,`tipo_funcionario`,`es_permiso_especial`);

--
-- Indices de la tabla `tbl_permisos_diarios`
--
ALTER TABLE `tbl_permisos_diarios`
  ADD PRIMARY KEY (`id_permiso_diario`),
  ADD UNIQUE KEY `fecha` (`fecha`),
  ADD KEY `idx_fecha` (`fecha`);

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
-- Indices de la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_rol_unique` (`id_usuario`,`id_rol`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `idx_usuarios_roles_usuario` (`id_usuario`),
  ADD KEY `idx_usuarios_roles_rol` (`id_rol`);

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
-- AUTO_INCREMENT de la tabla `adiciones_contrato`
--
ALTER TABLE `adiciones_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categorias_archivos`
--
ALTER TABLE `categorias_archivos`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1100;

--
-- AUTO_INCREMENT de la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT de la tabla `tbl_configuracion_permisos`
--
ALTER TABLE `tbl_configuracion_permisos`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  MODIFY `id_contrato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  MODIFY `id_contrato_practicante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos_diarios`
--
ALTER TABLE `tbl_permisos_diarios`
  MODIFY `id_permiso_diario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  MODIFY `idepracticante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adiciones_contrato`
--
ALTER TABLE `adiciones_contrato`
  ADD CONSTRAINT `adiciones_contrato_ibfk_1` FOREIGN KEY (`id_contrato`) REFERENCES `seguimiento_contrato` (`id`);

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
-- Filtros para la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  ADD CONSTRAINT `prorrogas_contrato_ibfk_1` FOREIGN KEY (`id_contrato`) REFERENCES `seguimiento_contrato` (`id`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`);

--
-- Filtros para la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  ADD CONSTRAINT `seguimiento_contrato_ibfk_1` FOREIGN KEY (`dependencia_id`) REFERENCES `tbl_dependencia` (`dependencia_pk`);

--
-- Filtros para la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  ADD CONSTRAINT `fk_funcionario_cargo` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_funcionario_contrato` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_funcionario_dependencia` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL ON UPDATE CASCADE,
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
-- Filtros para la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  ADD CONSTRAINT `fk_practicantes_contrato` FOREIGN KEY (`contrato_practicante_fk`) REFERENCES `tbl_contratos_practicantes` (`id_contrato_practicante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_practicantes_dependencia` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  ADD CONSTRAINT `fk_usuarios_roles_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_roles_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD CONSTRAINT `fk_vacaciones_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
