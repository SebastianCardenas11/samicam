-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2025 a las 02:16:05
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
(8, 19, 'MANUAL DE INSTALACION DE SCHIP CONTABLE', '', '5a088ea0a6d3ab6df3d97d1e5bd6a23d.pdf', 'pdf', '2025-08-13 15:28:45', 1),
(9, 19, 'MANUAL DE INSTALACION DE CERTICAMARA SAC. DE SALUD', '', 'efb9d363c34dc7def835f7ed4f8a9042.pdf', 'pdf', '2025-08-13 15:29:46', 1),
(10, NULL, 'MANUAL DE CONFIGURACION DE SERVIDOR WINDOWS SERVER 2019.', '', '728a995ac9bd77ef1ad29a052c1f0890.pdf', 'pdf', '2025-08-13 15:31:22', 0),
(11, 19, 'MANUAL DE CONFIGURACION DE SERVIDOR WINDOWS SERVER 2019.', '', '7a46b9017e96393617e36c18442a48b5.pdf', 'pdf', '2025-08-13 15:32:33', 1);

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
(19, 'MANUALES', '', 1, '2025-08-13 15:28:00');

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
(10, 'Practicantes', 'Gestión de Practicantes', 1),
(11, 'Tareas', 'Gestión de Tareas', 1),
(12, 'Publicaciones', 'Gestión de Publicaciones', 1),
(13, 'Dependencian', 'Gestión de dependencias', 1),
(14, 'Seguimiento de Contrato', 'Gestión de Seguimiento de Contrato', 1),
(15, 'Inventario', 'Gestión de inventario', 1),
(16, 'Registros WhatsApp', 'Gestión de Registros WhatsApp', 1),
(18, 'PSI', 'Gestión de PSI', 1),
(19, 'Hoja de Vida Equipos', 'Gestión de hojas de vida de equipos tecnológicos', 1);

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
(516, 1, 15, 1, 1, 1, 1, 1),
(634, 1, 13, 1, 1, 1, 1, 1),
(710, 1, 11, 1, 1, 1, 1, 1),
(761, 1, 12, 1, 1, 1, 1, 1),
(874, 1, 14, 1, 1, 1, 1, 1),
(1141, 1, 16, 1, 1, 1, 1, 1),
(1142, 1, 10, 1, 1, 1, 1, 1),
(1143, 1, 18, 1, 1, 1, 1, 1),
(1224, 1, 17, 1, 1, 1, 1, 1),
(1273, 5, 1, 1, 1, 1, 1, 1),
(1274, 5, 2, 0, 0, 0, 0, 1),
(1275, 5, 3, 0, 0, 0, 0, 1),
(1276, 5, 4, 0, 0, 0, 0, 1),
(1277, 5, 5, 0, 0, 0, 0, 1),
(1278, 5, 6, 0, 0, 0, 0, 1),
(1279, 5, 7, 0, 0, 0, 0, 1),
(1280, 5, 8, 1, 1, 1, 1, 1),
(1281, 5, 10, 0, 0, 0, 0, 1),
(1282, 5, 11, 1, 1, 1, 1, 1),
(1283, 5, 12, 0, 0, 0, 0, 1),
(1284, 5, 13, 0, 0, 0, 0, 1),
(1285, 5, 14, 0, 0, 0, 0, 1),
(1286, 5, 15, 1, 1, 1, 1, 1),
(1287, 5, 16, 0, 0, 0, 0, 1),
(1288, 5, 18, 1, 1, 1, 1, 1),
(1289, 12, 1, 0, 0, 0, 0, 1),
(1290, 12, 2, 0, 0, 0, 0, 1),
(1291, 12, 3, 0, 0, 0, 0, 1),
(1292, 12, 4, 0, 0, 0, 0, 1),
(1293, 12, 5, 0, 0, 0, 0, 1),
(1294, 12, 6, 0, 0, 0, 0, 1),
(1295, 12, 7, 0, 0, 0, 0, 1),
(1296, 12, 8, 0, 0, 0, 0, 1),
(1297, 12, 10, 0, 0, 0, 0, 1),
(1298, 12, 11, 0, 0, 0, 0, 1),
(1299, 12, 12, 1, 1, 1, 1, 1),
(1300, 12, 13, 1, 1, 1, 1, 1),
(1301, 12, 14, 0, 0, 0, 0, 1),
(1302, 12, 15, 0, 0, 0, 0, 1),
(1303, 12, 16, 0, 0, 0, 0, 1),
(1304, 12, 18, 0, 0, 0, 0, 1),
(1305, 3, 1, 1, 1, 1, 1, 1),
(1306, 3, 2, 0, 0, 0, 0, 1),
(1307, 3, 3, 0, 0, 0, 0, 1),
(1308, 3, 4, 1, 1, 1, 1, 1),
(1309, 3, 5, 1, 1, 1, 1, 1),
(1310, 3, 6, 1, 1, 1, 1, 1),
(1311, 3, 7, 1, 1, 1, 1, 1),
(1312, 3, 8, 0, 0, 0, 0, 1),
(1313, 3, 10, 1, 1, 1, 1, 1),
(1314, 3, 11, 0, 0, 0, 0, 1),
(1315, 3, 12, 0, 0, 0, 0, 1),
(1316, 3, 13, 1, 1, 1, 1, 1),
(1317, 3, 14, 0, 0, 0, 0, 1),
(1318, 3, 15, 0, 0, 0, 0, 1),
(1319, 3, 16, 0, 0, 0, 0, 1),
(1320, 3, 18, 0, 0, 0, 0, 1),
(1321, 2, 1, 1, 1, 1, 1, 1),
(1322, 2, 2, 0, 0, 0, 0, 1),
(1323, 2, 3, 0, 0, 0, 0, 1),
(1324, 2, 4, 1, 1, 1, 1, 1),
(1325, 2, 5, 1, 1, 1, 1, 1),
(1326, 2, 6, 1, 1, 1, 1, 1),
(1327, 2, 7, 1, 1, 1, 1, 1),
(1328, 2, 8, 0, 0, 0, 0, 1),
(1329, 2, 10, 1, 1, 1, 1, 1),
(1330, 2, 11, 0, 0, 0, 0, 1),
(1331, 2, 12, 0, 0, 0, 0, 1),
(1332, 2, 13, 1, 1, 1, 1, 1),
(1333, 2, 14, 0, 0, 0, 0, 1),
(1334, 2, 15, 0, 0, 0, 0, 1),
(1335, 2, 16, 0, 0, 0, 0, 1),
(1336, 2, 18, 0, 0, 0, 0, 1),
(1337, 1, 19, 1, 1, 1, 1, 1),
(1338, 5, 19, 1, 1, 1, 1, 1);

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
(9, 'Calendario tributario 2025', '2025-01-07', 'comunicaciones@lajaguadeibirico-cesar.gov.co', 'Calendario tributario 2025', '2025-01-08', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/informacion-tributaria-municipal/calendario-tributario-2025', 19, 1),
(10, 'RESOLUCIÓN GCE-00001 DEL 7 DE ENERO 2025', '2025-01-09', 'contratacion@lajaguadeibirico-cesar.gov.co', 'RESOLUCIÓN GCE-00001 DEL 7 DE ENERO 2025', '2025-01-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-gce00001-del-7-de-enero-2025', 16, 1),
(11, 'Informe Derecho de Autor vigencia 2024', '2025-02-18', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Informe Derecho de Autor vigencia 2024', '2025-02-19', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-de-derecho-de-autor-vigencia-2024', 14, 1),
(12, 'Plan institucional de Bienestar 2025', '2025-02-24', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'Plan institucional de Bienestar 2025', '2025-02-24', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/planes/plan-institucional-de-bienestar-2025', 13, 1),
(13, 'RESOLUCIÓN GGE-00045 del 05 de Febrero de 2025', '2025-02-24', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'RESOLUCIÓN GGE-00045 del 05 de Febrero de 2025', '2025-02-24', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-gge00045', 13, 1),
(14, 'DECRETO GGE-00037', '2025-02-27', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'DECRETO GGE-00037', '2025-02-27', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decretogge00037-del-17-de-febrero-de-2025', 13, 1),
(15, 'Estrategia de Rendición de cuenta', '2025-03-17', 'loraine.mipg2024@gmail.com', 'Estrategia de Rendición de cuenta', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/estrategia-de-rendicion-de-cuentas-2024', 9, 1),
(16, 'Notificación por aviso web', '2025-03-17', 'contratacion@lajaguadeibirico-cesar.gov.co', 'Notificación por aviso web', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/gaceta/notificacion-por-aviso-web', 16, 1),
(17, 'Acuerdo Municipal No. 003 del 08 de enero de 2025', '2025-03-04', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'Acuerdos 001, 002, 003 y 004 de 2025', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/acuerdo-municipal-no-003-del-13-febrero-de-2025', 17, 1),
(18, 'Acuerdo Municipal No. 002 del 31 de enero de 2025', '2025-03-04', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'Acuerdos 001, 002, 003 y 004 de 2025', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/acuerdo-municipal-no-002-del-31-de-enero-de-2025', 17, 1),
(21, 'Acuerdo Municipal No. 002 del 31 de enero de 2025', '2025-03-04', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'Acuerdos 001, 002, 003 y 004 de 2025', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/acuerdo-municipal-no-002-del-31-de-enero-de-2025', 17, 1),
(22, 'Plan de auditoria', '2025-03-18', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Plan de auditoria y las auditorias', '2025-03-25', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/plan-de-auditoria-2024', 14, 1),
(23, 'Informe de Rendición de Cuentas Vigencia 2024 Implementación del Acuerdo Final de Paz (SIRCAP)5', '2025-03-31', 'planeacion@lajaguadeibirico-cesar.gov.co', 'INFORME RENDICION DE CUENTAS ACUERDO FINAL DE PAZ', '2025-03-31', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control/informe-de-rendicion-de-cuentas-vigencia-2024-implementacion', 9, 1),
(24, 'INFORME DE EVALUACIÓN DE LA GESTIÓN Y RESULTADOS POR DEPENDENCIAS. vigencia 2024', '2025-04-01', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Informe de Evaluacion pór dependencia vigencia 2024', '2025-04-01', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-de-evaluacion-de-la-gestion-y-resultados-por-188970', 14, 1),
(25, 'ESTADOS FINANCIEROS 2025', '2025-04-02', 'contabilidad@lajaguadeibirico-cesar.gov.co', 'ESTADOS FINANCIEROS 2025', '2025-04-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/presupuesto/estados-financieros-corte-31-de-diciembre2024', 11, 1),
(26, 'DECRETO 00053 DEL 1 DE ABRIL DEL 2025', '2025-04-02', 'loraine.mipg2024@gmail.com', 'DECRETO 00053 DEL 1 DE ABRIL DEL 2025', '2025-04-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-00053-del-1-de-abril-del-2025', 9, 1),
(27, 'RESPUESTA DENUNCIA ANONIMA', '2025-04-07', 'contactenos@lajaguadeibirico-cesar.gov.co', 'Publicación denuncia Anónima', '2025-04-07', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/protocolo-de-atencion-922735/respuesta-denuncia-anonima', 20, 1),
(28, 'rendición de cuentas', '2025-04-02', 'loraine.mipg2024@gmail.com', 'rendición de cuentas', '2025-04-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control/rendicion-de-cuentas-2024', 9, 1),
(29, 'Actualización PAA 2025', '2025-04-08', 'almacen@lajaguadeibirico-cesar.gov.co', 'Actualización PAA 2025', '2025-04-08', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/planes/actualizacion-plan-anual-de-adquisicion-2025', 18, 1),
(30, 'MANUAL DE CONFLICTOS DE INTERESES O DECISIÓN DE IMPEDIMENTOS, RECUSACIONES, INHABILIDADES O INCOMPATIBILIDADES DE LA ALCALDÍA DE LA JAGUA DE IBIRICO', '2025-04-10', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'MANUAL DE CONFLICTOS DE INTERESES O DECISIÓN DE IMPEDIMENTOS, RECUSACIONES, INHABILIDADES O INCOMPATIBILIDADES DE LA ALCALDÍA DE LA JAGUA DE IBIRICO', '2025-04-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/manuales/manual-de-conflictos-de-intereses-o-decision-de-impedimentos-637770', 13, 1),
(31, 'RESOLUCIÓN CONFORMACIÓN DE COMITÉS DE SEGURIDAD Y SALUD EN EL TRABAJO COPASST Y COCOLA DE LA ALCALDÍA DE LA JAGUA DE IBIRICO', '2025-04-10', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'RESOLUCIÓN CONFORMACIÓN DE COMITÉS DE SEGURIDAD Y SALUD EN EL TRABAJO COPASST Y COCOLA DE LA ALCALDÍA DE LA JAGUA DE IBIRICO', '2025-04-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-conformacion-de-comites-de-seguridad-y-salud', 13, 1),
(32, 'CONTRATOS', '2025-04-11', 'lajaguasigep20@gmail.com', 'CONTRATOS RENDIDOS EN EL MES DE MARZO 2025', '2025-04-21', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1),
(33, 'NORMOGRAMA INSTITUCIONAL DE LA ALCALDÍA DE LA JAGUA DE IBIRÍCO, CESAR- 2024', '2025-04-21', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Normagrama,para publicar.', '2025-04-21', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/normograma-institucional-de-la-alcaldia-de-la-jagua', 14, 1),
(34, 'Informe Primer Trimestre de PQRS - 2025', '2025-04-22', 'contactenos@lajaguadeibirico-cesar.gov.co', 'Informe trimestral PQRS', '2025-04-22', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/protocolo-de-atencion-922735/informe-primer-trimestre-de-pqrs2025', 20, 1),
(35, 'Acuerdo Municipal No. 004 del 14 de febrero de 2025', '2025-03-04', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'Acuerdos 001, 002, 003 y 004 de 2025', '2025-03-17', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/acuerdo-municipal-no-004-del-14-de-febrero-de-2025', 17, 1),
(36, 'DECRETO 00058 DEL 11 DE ABRIL DEL 2025', '2025-04-22', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'Publicar Decreto en la pagina Web', '2025-04-22', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-00058-del-11-de-abril-del-2025', 13, 1),
(37, 'Notificación por aviso web', '2025-04-23', 'contratacion@lajaguadeibirico-cesar.gov.co', 'Notificación por aviso web', '2025-04-23', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/gaceta/notificacion-por-aviso-web-453423', 16, 1),
(38, 'Notificación por aviso web', '2025-05-08', 'contratacion@lajaguadeibirico-cesar.gov.co', 'Notificación por aviso web', '2025-05-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/gaceta/notificacion-por-aviso-web-406386', 16, 1),
(39, 'CONTRATOS', '2025-05-09', 'contratacion@lajaguadeibirico-cesar.gov.co', 'CONTRATOS RENDIDOS DEL MES DE ABRIL-2025', '2025-05-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1),
(40, 'Respuesta queja radicada en la Página Institucional de manera anónima.', '2025-05-15', 'contactenos@lajaguadeibirico-cesar.gov.co', 'Respuesta queja radicada en la Página Institucional de manera anónima.', '2025-05-16', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/protocolo-de-atencion-922735/respuesta-queja-radicada-en-la-pagina-institucional', 20, 1),
(41, 'PROGRAMA DE TRANSPARENCIA Y ETICA PUBLICA (PTEP)', '2025-05-20', 'loraine.mipg2024@gmail.com', 'PROGRAMA DE TRANSPARENCIA Y ETICA PUBLICA (PTEP)', '2025-05-21', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/planes/programa-de-transparencia-y-etica-publica-ptep-2025', 9, 1),
(42, 'NOTIFICACION DE ORDEN DE COMPARENDO A SIXTA TULIA BAEZ JARABA', '2025-05-27', 'transito@lajaguadeibirico-cesar.gov.co', 'SOLICTUD PUBLICACION DE COMPARENDOS EN LA PAGINA WEB INSTITUCIONAL', '2025-05-28', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-de-orden-de-comparendo-a-sixta-tulia-baez', 5, 1),
(43, 'NOTIFICACION DE ORDEN DE COMPARENDO A YANDY CAROLINA LAGUNA RIOCAMPO', '2025-05-27', 'transito@lajaguadeibirico-cesar.gov.co', 'SOLICTUD PUBLICACION DE COMPARENDOS EN LA PAGINA WEB INSTITUCIONAL', '2025-05-28', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-de-orden-de-comparendo-a-yandy-carolina', 5, 1),
(44, 'NOTIFICACION DE ORDEN DE COMPARENDO POR AVISO SINDY PAOLA GARAVITO MONTERROSA', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-por-aviso-sindy-paola', 5, 1),
(45, 'NOTIFICACION DE ORDEN DE COMPARENDO POR AVISO FLORALBA BEDOYA ORTIZ', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-por-aviso-floralba', 5, 1),
(46, 'NOTIFICACION DE ORDEN DE COMPARENDO YAMERLI PERALES URIBE', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://la-jagua-de-ibirico.micolombiadigital.gov.co/sites/la-jagua-de-ibirico/content/files/001563/78130_notificacion-00122025comparendo-no-47565593notificacion-por-aviso.pdf', 5, 1),
(47, 'NOTIFICACION DE ORDEN DE COMPARENDO POR AVISO FILBERTO MANUEL MACEA HERRERA', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-por-aviso-filiberto', 5, 1),
(48, 'NOTIFICACION DE ORDEN DE COMPARENDO POR AVISO HECTOR FIDEL HERNANDEZ RODRIGUEZ', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-por-aviso-hector-fidel', 5, 1),
(49, 'NOTIFICACION DE ORDEN DE COMPARENDO MANUEL GREGORIO FERREIRA RIVALDO', '2025-06-05', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-06', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-por-aviso-manuel-gregorio', 5, 1),
(50, 'EJECUCIÓN DE CONTRATOS 2025', '2025-06-09', 'secoplajagua2023@gmail.com', 'INFORMACIÓN PARA PÁGINA WEB', '2025-06-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/ejecucion-de-contratos-176727/ejecucion-de-contratos-2025', 16, 1),
(51, 'INFORME PRELIMINAR AUDITORÍA DE CUMPLIMIENTO A-C ALUMBRADO PÚBLICO', '2025-06-09', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'INFOMRE DEFINITO AUDITORIA ALUMBRADO PUEBLICO', '2025-06-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-preliminar-auditoria-de-cumplimiento-ac-alumbrado', 14, 1),
(52, 'CONTRATOS', '2025-06-10', 'lajaguasigep20@gmail.com', 'CONTRATOS RENDIDOS DEL MES DE MAYO-2025', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1),
(53, 'NOTIFICACIÓN ORDEN DE COMPARENDO CLEOTILDE DEL CARMEN VEGA DIAZ', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-cleotilde-del-carmen', 5, 1),
(54, 'NOTIFICACIÓN ORDEN DE COMPARENDO EQUIMAC DEL CESAR SAS', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-equimac-del-cesar-sas', 5, 1),
(55, 'NOTIFICACIÓN ORDEN DE COMPARENDO ALVARO DE JESUS BOLAÑO LOPEZ', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-alvaro-de-jesus-bolano', 5, 1),
(56, 'NOTIFICACIÓN ORDEN DE COMPARENDO KATHERIN YULIETH CARRILLO GOMEZ', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-katherin-yulieth-carrillo', 5, 1),
(57, 'PLAN DE MEJORAMIENTO ALUMBRADO PUBLICO 2025', '2025-06-10', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'PUBLICACIION PLAN DE MEJORAMIENTO ALUMBRADO PUBLICO', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/plan-de-mejoramiento-alumbrado-publico-2025', 14, 1),
(58, 'NOTIFICACIÓN ORDEN DE COMPARENDO MAYERLIS RINCON CASTILLEJO', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-mayerlis-rincon-castillejo', 5, 1),
(59, 'NOTIFICACIÓN ORDEN DE COMPARENDO RAFAEL LEONEL LOPEZ BARROS', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-rafael-leonel-lopez', 5, 1),
(60, 'NOTIFICACIÓN ORDEN DE COMPARENDO EVER ANDRES SANCHEZ CHAVEZ', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-ever-andres-sanchez', 5, 1),
(61, 'NOTIFICACIÓN ORDEN DE COMPARENDO JUAN CAMILO VANEGAS MIELES', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-juan-camilo-vanegas', 5, 1),
(62, 'NOTIFICACIÓN ORDEN DE COMPARENDO ROBERTH ARLEY BANAVIDES VILLA', '2025-06-10', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-10', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-roberth-arley-banavides', 5, 1),
(63, 'NOTIFICACIÓN ORDEN DE COMPARENDO EDUARDO ANDRES NIETO MEDEZ', '2025-06-11', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-eduardo-andres-nieto', 5, 1),
(64, 'NOTIFICACIÓN ORDEN DE COMPARENDO TRANSPORTE JONCAR SAS', '2025-06-11', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-transporte-joncar-sas', 5, 1),
(65, 'NOTIFICACIÓN ORDEN DE COMPARENDO FERMIN HOYOS CHACON', '2025-06-11', 'transito@lajaguadeibirico-cesar.gov.co', 'Solicitud Notificación Por Aviso de Comparendos en Pagina WEB', '2025-06-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/transito/notificacion-orden-de-comparendo-fermin-hoyos-chacon', 5, 1),
(66, 'Constancia de fijación de aviso agencia nacional de tierras ANT auto No 202577000051509 del 09-06-2025', '2025-06-13', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'PUBLICAR AVISO', '0000-00-00', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/gaceta/constancia-de-fijacion-de-aviso-agencia-nacional-de', 17, 1),
(67, 'Acuerdo Municipal No. 005 del 07 de Mayo de 2025', '2025-06-13', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'Acuerdos 005 y 006', '2025-06-13', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/acuerdo-municipal-no-006-del-13-de-mayo-de-2025', 17, 1),
(68, 'Constancia de fijación de aviso agencia nacional de tierras ANT auto No 202577001778736 del 25-06-2025', '2025-06-25', 'alcaldia@lajaguadeibirico-cesar.gov.co', 'PUBLICAR AVISO', '2025-06-26', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/gaceta/constancia-de-fijacion-de-aviso-agencia-nacional-de-843364', 17, 1),
(69, 'Registro de Activos de Información', '2025-05-22', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'Registro de Activos de Información', '2025-05-22', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/instrumento-de-gestion-de-la-informacion/registro-de-activos-de-informacion', 1, 1),
(70, 'Esquema de Publicación de Información', '2025-05-27', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'Esquema de Publicación de Información', '2025-05-27', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/instrumento-de-gestion-de-la-informacion/esquema-de-publicacion-de-informacion-791756', 1, 1),
(71, 'DECRETO No. 00081 de 18 DE JUNIO DE 2025', '2025-07-02', 'educacion@lajaguadeibirico-cesar.gov.co', 'DECRETO No. 00081', '2025-07-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-no-00081-de-18-de-junio-de-2025', 4, 1),
(72, 'DECRETO 00086 de 24 JUNIO 2025', '2025-07-02', 'educacion@lajaguadeibirico-cesar.gov.co', 'DECRETO 00086', '2025-07-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-00086-de-24-junio-2025', 4, 1),
(73, 'Convocatoria N.º 001 de 2025 para Representación Juvenil en el CMJ – Jóvenes de Población Desplazada', '2025-07-02', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'Convocatoria N.º 001', '2025-07-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/convocatorias/convocatoria-n-001-de-2025-para-representacion-juvenil', 3, 1),
(74, 'RESOLUCIÓN 16062025 - RETIRO DE BENEFICIARIOS DEL PROGRAMA COLOMBIA MAYOR', '2025-07-02', 'secretariadelamujer@lajaguadeibirico-cesar.gov.co', 'RESOLUCION PARA PUBLICAR', '2025-07-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-16062025-retiro-de-beneficiarios-del-programa', 12, 1),
(75, 'II informe Trimestral PQRS 2025', '2025-07-10', 'contactenos@lajaguadeibirico-cesar.gov.co', 'Informe II semestre', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/protocolo-de-atencion-922735/ii-informe-trimestral-pqrs-2025', 20, 1),
(76, 'Compendio normativo del Sisbén IV', '2025-07-11', 'sisben@lajaguadeibirico-cesar.gov.co', 'información solicitada para publicación', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/sisben-651780/compendio-normativo-del-sisben-iv', 21, 1),
(77, 'procesos internos de la oficina del sisben IV', '2025-07-11', 'sisben@lajaguadeibirico-cesar.gov.co', 'información solicitada para publicación', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/sisben-651780/procesos-internos-de-la-oficina-del-sisben-iv-2025', 21, 1),
(78, 'Informacion de Gestion Sisben IV', '2025-07-11', 'sisben@lajaguadeibirico-cesar.gov.co', 'información solicitada para publicación', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/sisben-651780/informe-de-gestion-sisben-ivvigencia-2024', 21, 1),
(79, 'Programa de Afiliación y Aplicación del Sisbén IV', '2025-07-11', 'sisben@lajaguadeibirico-cesar.gov.co', 'información solicitada para publicación', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/sisben-651780/programa-de-afiliacion-y-aplicacion-del-sisben-iv', 21, 1),
(80, 'Servicios que presta la oficina del Sisben IV Municipal', '2025-07-11', 'sisben@lajaguadeibirico-cesar.gov.co', 'información solicitada para publicación', '2025-07-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/sisben-651780/servicios-que-presta-la-oficina-del-sisben-iv-municipal', 21, 1),
(81, 'RESOLUCION GGE-00504 del 27 de junio de 2025', '2025-07-09', 'secretariadelamujer@lajaguadeibirico-cesar.gov.co', 'RESOLUCION PARA PUBLICAR', '2025-07-09', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-gge00504-del-27-de-junio-de-2025', 12, 1),
(82, 'CONTRATOS', '2025-07-14', 'lajaguasigep20@gmail.com', 'CONTRATOS RENDIDOS EN EL MES DE JUNIO DE 2025', '2025-07-14', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1),
(83, 'DECRETO GGE-00094 DEL 15 DE JULIO DE 2025', '2025-07-15', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'DECRETO GGE-00094 DEL 15 DE JULIO DE 2025', '2025-07-15', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-gge00094-del-15-de-julio-de-2025', 3, 1),
(84, 'INFORME CONSOLIDADO DE PQRS Y PQRD - PRIMER SEMESTRE 2025', '2025-07-25', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Informe consoplidado de PQR', '2025-07-25', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-consolidado-de-pqrs-y-pqrd-primer-semestre-2025', 14, 1),
(85, 'Política de Administración de Riesgo', '2025-08-04', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Polita de Riesgo Actualizada 2025', '2025-08-04', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/politica-de-administracion-de-riesgo', 14, 1),
(86, 'INFORME DE AUDITORIA DE CONTROL INTERNO DE GESTIÓN REALIZADA A LA OFICINA DE TALENTO HUMANO DEL CENTRO ADMINISTRATIVO MUNICIPAL DE LA JAGUA DE IBIRICO', '2025-08-04', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Informe de la Auditoría Interna de Carrera Administrativa de la Alcaldía de La Jagua de Ibirico, Cesar, vigencia 2025.', '2025-08-04', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-de-auditoria-de-control-interno-de-gestion-realizada-346652', 14, 1),
(87, 'Solicitud de cancelación en el Registro Público de Carrera Administrativa de exfuncionarios', '2025-08-04', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'Solicitud de cancelación en el Registro Público de Carrera Administrativa de exfuncionarios', '2025-08-04', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/avisos/solicitud-de-cancelacion-en-el-registro-publico-de-carrera', 13, 1),
(88, 'DECRETO 00101 23 JULIO 2025 “Por Medio Del Cual Se Regula La Publicidad YO Propaganda Electoral, Con Ocasión De Las Elecciones De Los Consejos .', '2025-08-06', 'gobierno@lajaguadeibirico-cesar.gov.co', 'DECRETO PARA PUBLICAR', '2025-08-08', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-00101-23-julio-2025-por-medio-del-cual-se-regula', 3, 1),
(89, 'EDICTO EMPLAZATORIO.', '2025-08-08', 'planeacion@lajaguadeibirico-cesar.gov.co', 'SOLICITUD DE PUBLICACION DEDE EDICTO EMPLAZATORIO EN LA PAGINA WEB INSTITUCIONAL', '2025-08-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/edicto-emplazatorio-129861', 9, 1),
(90, 'CONTRATOS', '2025-08-11', 'contratacion@lajaguadeibirico-cesar.gov.co', 'CONTRATOS RENDIDOS MES DE JULIO', '2025-08-11', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1),
(91, 'Plan de Mejoramiento Institucional 2025', '2025-08-13', 'loraine.mipg2024@gmail.com', 'Plan de Mejoramiento MIPG', '2025-08-13', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/planes/plan-de-mejoramiento-institucional-2025', 9, 1),
(92, 'DECRETO 00113 15 de agosto POR MEDIO DEL CUAL SE DISPONEN MEDIDAS PARA LA CONSERVACIÓN DEL ORDEN PÚBLICO PARA EL XVII ENCUENTRO DE TAMBORA Y FIESTA', '2025-08-15', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'DECRETO 00113 DE 2025', '2025-08-15', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/decreto-00113-15-de-agosto-por-medio-del-cual-se-disponen', 3, 1),
(93, 'VEEDURÍA No. 007 DE 2025 CONSTRUCCIÓN DEL TRAMO VIAL Y OBRAS COMPLEMENTARIAS ENTRE LOS DOS 2 PUENTES DEL SECTOR LOS CARACOLÍSES EN LA VÍA QUE COND', '2025-08-22', 'desarrollocomunitario@lajaguadeibirico-cesar.gov.co', 'PUBLICACION VEEDURIAS 007 Y 008 DEL 2025', '2025-08-22', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-ciudadano/veeduria-no-007-de-2025-construccion-del-tramo-vial', 3, 1),
(94, 'VEEDURÍA No. 008 DE 2025 “CONSTRUCCIÓN DE PAVIMENTO RÍGIDO Y OBRAS COMPLEMENTARIAS EN EL BARRIO NUEVO AMANECER DEL MUNICIPIO DE LA JAGUA DE IBIRICO', '2025-08-22', 'desarrollocomunitario@lajaguadeibirico-cesar.gov.co', 'PUBLICACION VEEDURIAS 007 Y 008 DEL 2025', '2025-08-22', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-ciudadano/veeduria-no-008-de-2025-construccion-de-pavimento-rigido', 3, 1),
(95, 'RESOLUCIÓN 19082025 Consecutivo GGE – 00801 “POR MEDIO DE LA CUAL SE REALIZAN ACTIVACIÓN DE BENEFICIARIO DEL PROGRAMA PROSPERIDAD SOCIAL “COLOMBI', '2025-08-25', 'secretariadelamujer@lajaguadeibirico-cesar.gov.co', 'RESOLUCION ACTIVACION PROGRAMA ADULTO MAYOR', '2025-08-25', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-19082025-consecutivo-gge-00801-por-medio', 12, 1),
(96, 'INFORME SEMESTRAL DECONTROL INTERNO', '2025-08-25', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'INFORME SEMESTRAL', '2025-08-25', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-semestral-decontrol-interno', 14, 1),
(97, 'Informe semestral de control interno- 30 de junio 2025', '2025-08-25', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'INFORME SEMESTRAL', '2025-08-26', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-semestral-del-esta-de-control-interno-de-la', 14, 1),
(98, 'Resolución N°002 13 DE AGOSTO DEL 2025 “POR MEDIO DE LA CUAL SE PUBLICAN LOS RESULTADOS DE LOS JÓVENES QUE CUMPLIERON LOS REQUISITOS PARA PARTICIPA', '2025-08-26', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'Resoliciónn', '2025-08-26', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-n002-13-de-agosto-del-2025-por-medio-de-la', 3, 1),
(99, 'INFORME DE AUSTERIDAD Y EFICIENCIA DEL GASTO PÚBLICO VIGENCIA Segundo Trimestre 2025', '2025-08-26', 'controlinterno@lajaguadeibirico-cesar.gov.co', 'Informe de austeridad segundo trimestre', '2025-08-27', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/control-interno/informe-de-austeridad-y-eficiencia-del-gasto-publico-900868', 14, 1);

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
-- Estructura de tabla para la tabla `seguimiento_contrato`
--

CREATE TABLE `seguimiento_contrato` (
  `id` int(11) NOT NULL,
  `objeto_contrato` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_terminacion` date NOT NULL,
  `plazo` int(11) NOT NULL,
  `tipo_plazo` varchar(255) NOT NULL,
  `tipo_informe` enum('acta parcial','mes vencido') DEFAULT 'acta parcial',
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
(6, 'SUMINISTRO DE REPUESTOS Y MANO DE OBRA PARA LA REPARACIÓN DE LOS EQUIPOS DE IMPRESIÓN Y ESCÁNER EXISTENTES DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR', '2025-04-09', '2025-05-09', 1, 'meses', 'mes vencido', 1, 37591000.00, '2025-05-09', 'AMJI CMC 012 DE 2025', 'SI', '2025-05-28', 37591000.00, 3, '176-2025', 1, '2025-04-03'),
(7, 'COMPRAVENTA DE LICENCIAS DE ANTIVIRUS PARA LOS EQUIPOS DE CÓMPUTO DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR.', '2025-05-13', '2025-05-22', 10, 'dias', 'mes vencido', 1, 28920000.00, '2025-05-23', 'AMJI CMC 021 DE 2025', '', '0000-00-00', 28920000.00, 3, '215-2025', 1, '2025-05-12'),
(8, 'COMPRAVENTA DE TINTAS Y TÓNER PARA LAS IMPRESORAS EXISTENTES DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR', '2025-08-08', '2025-08-22', 10, 'dias', 'mes vencido', 1, 36120000.00, '2025-08-25', 'Aun en espera de las entradas y salidas de Almancen para pasar informes', '', '0000-00-00', 0.00, 1, '274-2025', 1, '2025-08-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_capital_viaticos`
--

CREATE TABLE `tbl_capital_viaticos` (
  `idCapital` int(11) NOT NULL,
  `anio` int(4) NOT NULL,
  `capital_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `capital_disponible` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_capital_viaticos`
--

INSERT INTO `tbl_capital_viaticos` (`idCapital`, `anio`, `capital_total`, `capital_disponible`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(7, 2025, 70000000.00, 69750000.00, '2025-07-08 21:30:11', '2025-08-14 21:48:06'),
(8, 2026, 500000000.00, 500000000.00, '2025-07-11 21:08:19', '2025-07-11 21:08:19');

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
(3, 'Supernumerario'),
(5, 'Remoción'),
(7, 'Provisionalidad'),
(8, 'Periodo Fijo'),
(9, 'Periodo de prueba'),
(10, 'Elección');

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
(17, 'Despacho'),
(18, 'Almacen'),
(19, 'Comunicaciones'),
(20, 'PQRS'),
(21, 'Oficina de SISBEN'),
(22, 'OFICINA ASESORIA JURIDICA Y ASUNTOS LEGALES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_equipos_movimientos`
--

CREATE TABLE `tbl_equipos_movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `tipo_equipo` enum('impresora','pc_torre','todo_en_uno','portatil','escaner','herramienta','otro') NOT NULL,
  `tipo_movimiento` enum('entrada','salida') NOT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_escaneres`
--

CREATE TABLE `tbl_escaneres` (
  `id_escaner` int(11) NOT NULL,
  `numero_escaner` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malo','De Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_dano` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo',
  `fecha_baja` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_escaneres`
--

INSERT INTO `tbl_escaneres` (`id_escaner`, `numero_escaner`, `marca`, `modelo`, `serial`, `estado`, `disponibilidad`, `fecha_dano`, `fecha_baja`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(3, 'ESC-1', 'EPSON', 'DS-530', 'X2HJ057752', 'Regular', 'No Disponible', NULL, NULL, '2025-08-01 14:56:46', '2025-08-01 14:56:46', 1);

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
  `proviene_recurso_reactivacion` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funcionarios_planta`
--

CREATE TABLE `tbl_funcionarios_planta` (
  `idefuncionario` int(11) NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `nm_identificacion` varchar(20) DEFAULT NULL,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `contrato_fk` int(10) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
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
  `status` int(15) NOT NULL DEFAULT 1,
  `periodos_vacaciones` int(11) NOT NULL DEFAULT 0,
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
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `rh` varchar(5) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `tarjeta_profesional` varchar(100) DEFAULT NULL,
  `otros_estudios` varchar(255) DEFAULT NULL,
  `cuenta_no` varchar(100) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `eps` varchar(100) DEFAULT NULL,
  `afp` varchar(100) DEFAULT NULL,
  `afc` varchar(100) DEFAULT NULL,
  `arl` varchar(100) DEFAULT NULL,
  `sindicalizado` tinyint(1) DEFAULT NULL,
  `madre_cabeza_hogar` tinyint(1) DEFAULT NULL,
  `prepensionado` tinyint(1) DEFAULT NULL,
  `edades_hijos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios_planta`
--

INSERT INTO `tbl_funcionarios_planta` (`idefuncionario`, `nombre_completo`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`, `lugar_expedicion`, `libreta_militar`, `tipo_nombramiento`, `nivel`, `salario_basico`, `acto_administrativo`, `fecha_acto_nombramiento`, `no_acta_posesion`, `fecha_acta_posesion`, `tiempo_laborado`, `codigo`, `grado`, `fecha_nacimiento`, `lugar_nacimiento`, `rh`, `titulo`, `tarjeta_profesional`, `otros_estudios`, `cuenta_no`, `banco`, `eps`, `afp`, `afc`, `arl`, `sindicalizado`, `madre_cabeza_hogar`, `prepensionado`, `edades_hijos`) VALUES
(22, 'YULEIMA AGUILAR LIMA', '36572640', 38, 13, 1, '3126958245', 'TV 16 # 6-32 Barrio Juan Ramon', 'yuleimaaguilarlima@gmail.com', '2019-01-18', 1, 'CESAR RICARDO PEREZ AGUILAR', 'femenino', 'LA JAGUA DE IBIRICO', 46, 'viudo', 'cristiano', 'tecnico', 'RECURSOS HUMANOS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Decreto 00016', '2019-01-14', '2637', '2019-01-18', '6 años, 5 meses', '425', '04', '1978-08-25', 'Cesar, La Jagua de Ibirico', 'O+', 'RECURSOS HUMANOS', 'NO APLICA', 'NO', '4-2442-0-06966-3', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 1, 0, ''),
(23, 'ALCENDRA GUTIERREZ KAREN MARGARITA', '1064106342', 41, 4, 1, '3207173167', 'carrera 3E 8-48 Camilo Torres', 'alcendra.km@gmail.com', '2023-05-18', 0, 'CESAR RICARDO PEREZ AGUILAR', 'femenino', 'LA JAGUA DE IBIRICO', 42, 'union libre', 'catolico', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00420', '0000-00-00', '3017', '2023-05-18', '2 años, 1 mes', '407', '02', '1983-06-01', 'Cesar, La Jagua de Ibirico', 'O-', 'BACHILLER ACADEMICO', 'NO APLICA', 'NO', '4-244-20-05953-6', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 1, 0, 0, ''),
(24, 'ALVAREZ ROBLES ALFREDO', '18971282', 62, 9, 1, '3206902530', 'calle 8 n° 21-109', 'unidosprogresamos@gmail.com', '2023-06-01', 0, '', 'masculino', 'CURUMANI', 53, 'soltero', 'catolico', 'Selecciona una opción', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, Curumaní', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00359', '2023-04-27', '3037', '2023-06-01', '2 años, 1 mes', '219', '02', '1972-06-16', '', 'A+', 'ADMINISTRADOR PUBLICO', 'SI', 'ESPECIALISTA EN EVALUACION SOCIAL DE PROYECTOS', '305099897', 'BANCO DE BOGOTA', 'SANITAS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, ''),
(25, 'ARAUJO DAZA DIOMEDES ENRIQUE', '77158144', 62, 11, 1, '3194948391', 'CARRERA 38N BIS 5 148 MZ B', 'diomedes.araujo@gmail.com', '2024-03-01', 0, '', 'masculino', 'CARRERA 38N BIS 5 148 MZ B', 50, 'casado', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Cesar, Agustín Codazzi', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00043', '2024-02-19', '4028', '2024-03-01', '1 año, 4 meses', '219', '02', '1975-06-19', 'Cesar, Agustín Codazzi', 'O+', 'CONTADOR PUBLICO', 'SI', 'NO', '863157673', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'FONDO NACIONAL DE AHORRO', 'COLFONDOS', 'POSITIVA', 1, 0, 0, ''),
(26, 'ARAUJO SAENZ MIRLETT', '36572872', 38, 12, 1, '3205990278', 'MZ 2 CASA 63 URB. SORORIA', 'mirlettaraujosaens@gmail.com', '2024-04-01', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 47, 'union libre', 'catolico', 'tecnico', 'SECRETARIADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00215', '2024-03-11', '4030', '2024-04-01', '1 año, 3 meses', '425', '04', '1977-09-24', 'Cesar, Agustín Codazzi', 'A-', 'SECRETARIADO', 'NO APLICA', 'NO', '599270345', 'BANCO DE BOGOTA', 'NUEVA EPS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(27, 'ARIAS ANGARITA DIVELSY', '36574046', 61, 11, 2, '3115395281', 'CALLE 2 # 5 60', 'divelsiariasangarita@gmail.com', '2025-02-03', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 42, 'divorciado', 'catolico', 'Profesional', 'ADMINISTRADORA DE EMPRESAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'PROFESIONAL', 5095929.00, 'Decreto 00030', '2025-01-30', '4879', '2025-02-03', '5 meses', '215', '02', '1983-05-15', 'Cesar, La Jagua de Ibirico', 'O+', 'ADMINISTRADORA DE EMPRESAS', 'SI', 'NO', '424420089494', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(28, 'ARIAS BENJUMEA JUAN HIPOLITO', '84033687', 36, 13, 2, '3106136744', 'Diag. 10 # 1A - 56 B. Luis Carlos Galan', 'juan.arias0406@hotmail.com', '2013-08-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 57, 'casado', 'cristiano', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, 'La Guajira, Riohacha', 'No', 'provisionalidad', 'ASISTENCIAL', 2009543.00, 'Decreto 131', '2013-07-29', '1990', '2013-08-02', '11 años, 11 meses', '472', '03', '1968-04-06', 'La Guajira, Villanueva', 'B+', 'BACHILLER ACADEMICO', 'NO APLICA', 'NO', '4-2442-0-04536-5', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(29, 'ARZUAGA MANJARRES ALEXIS', '36571587', 38, 7, 1, '3148665493', 'Carrera 1D # 10-44 Camilo Torres', 'alexisarzuaga1234@gmail.com', '2019-02-04', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 53, 'casado', 'catolico', 'tecnico', 'SECRETARIADO EJECUTIVO SISTEMATIZADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Decreto 00028', '2019-01-30', '2645', '2019-02-04', '6 años, 5 meses', '425', '04', '1972-06-04', 'Cesar, La Jagua de Ibirico', 'B+', 'SECRETARIADO EJECUTIVO SISTEMATIZADO', 'NO APLICA', 'NO', '0-244-20-062-90-3', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(32, 'BARBOSA FERNANDEZ TOMAS EDUARDO', '77096046', 63, 7, 1, '3113099080', 'carrera 16 9C 4', 'tomas.edu.barbosa@gmail.com', '2024-01-05', 0, '', 'masculino', 'BECERRIL', 40, 'soltero', 'catolico', 'Profesional', 'BACTERIOLOGO Y LABORATORISTA CLINICO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00784', '2023-11-29', '4008', '2024-01-05', '1 año, 6 meses', '237', '02', '1985-02-09', 'Cesar, Becerril', 'A+', 'BACTERIOLOGO Y LABORATORISTA CLINICO', 'SI', 'NO', '0-9070369670', 'BANCOLOMBIA', 'SANITAS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(33, 'prueba', '000', 3, 1, 5, '000', '000', '000@gmail.com', '2005-04-10', 0, '', 'masculino', '000', 33, 'soltero', 'catolico', 'Profesional', '000', NULL, 0, 0, 'Bogotá, Bogotá D.C.', 'No', 'supernumerario', '000', 0.00, '000', '1990-02-10', '000', '2020-09-10', '20 años, 3 meses', '000', '000', '1992-04-10', 'Caquetá, Belén de Los Andaquies', 'B-', '000', '000', '000', '000', 'BANCO DE BOGOTA', 'NUEVA EPS', 'FONDO NACIONAL DE AHORRO', 'PORVENIR', 'POSITIVA', 0, 1, 0, NULL),
(34, 'BAUTISTA TRIANA MAYERLIGH', '39650491', 3, 9, 2, '3127037429', 'OVELIO JIMENEZ', 'may-bau@hotmail.com', '2025-06-03', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 56, 'soltero', 'catolico', 'tecnico', 'TECNICO EN ADMINISTRACION DE EMPRESAS Y MERCADEO SISTEMATIZADO', NULL, 1, 0, 'Santander, Socorro', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolución 00385', '2025-05-22', '4104', '2025-06-03', '1 mes', '367', '03', '1969-02-12', 'Cesar, Becerril', 'O-', 'TECNICO EN ADMINISTRACION DE EMPRESAS Y MERCADEO SISTEMATIZADO', 'NO APLICA', 'NO', '460410021030', 'BANCO AGRARIO', 'NUEVA EPS', 'COLPENSIONES', '', 'POSITIVA', 1, 0, 0, ''),
(35, 'BECERRA SANCHEZ DANIEL ALBERTO', '13543317', 62, 9, 2, '3166273181', 'Diagonal 5 10- 46 Brr LosComuneros', 'danielalbertobecerra@gmail.com', '2024-04-17', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 46, 'Selecciona una opción', 'catolico', 'Profesional', 'INGENIERIA MECANICA', NULL, 1, 0, 'Santander, Bucaramanga', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00214', '2024-03-11', '4037', '2024-04-17', '1 año, 2 meses', '219', '02', '1978-09-06', 'Bogotá, Bogotá D.C.', 'O+', 'INGENIERIA MECANICA', 'SI', 'MAGISTER EN ADMINISTRACION DE EMPRESAS CON ESPECIALIDAD EN DIRECCION DE PROYECTOS', '599270550', 'BANCO DE BOGOTA', 'SANITAS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(36, 'BORREGO DAZA ALEJANDRO ELIAS', '12521793', 47, 5, 7, '3148869293', 'CRA 3B No. 11 - 68', 'alejandroborregodaza@hotmail.com', '2018-11-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 59, 'union libre', 'catolico', 'tecnico', 'AGENTE DE TRANSITO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'provisionalidad', 'TECNICO', 2825896.00, 'Decreto 00140', '2018-10-31', '2622', '2018-11-02', '6 años, 8 meses', '340', '03', '1966-06-16', 'Cesar, La Jagua de Ibirico', 'O+', 'BACHILLER ACADEMICO', 'NO APLICA', 'NO', '4-2442-0-06184-0', 'BANCO DE BOGOTA', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(37, 'BULA CARO YOLISMAR', '1064116344', 38, 9, 1, '3163349331', 'Carrera 1C 3B 78 Brr Simon Bolivar', 'jolie_2995@hotmail.com', '2024-01-05', 0, '', 'Selecciona una opción', 'LA JAGUA DE IBIRICO', 30, 'Selecciona una opción', 'catolico', 'tecnologo', 'GESTION EMPRESARIAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', '', 'carrera_administrativa', 'ASISTENCIAL', 2775378.00, 'Resolucion 00840', '2023-12-27', '4009', '2024-01-05', '1 año, 6 meses', '425', '04', '1995-01-29', 'Cesar, La Jagua de Ibirico', 'O+', 'GESTION EMPRESARIAL', 'NO APLICA', 'NO', '88400000808', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 1, NULL),
(38, 'CADENA TORRES LUIS EDUARDO', '1064114925', 56, 15, 2, '3234877633', 'TRANS 12 # 4-65 BRR JUAN RAMON', 'abogadoluis1093@gmail.com', '2024-01-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 31, 'union libre', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'ASESOR', 5982216.00, 'Decreto 00013', '2024-01-02', '3099', '2024-01-02', '1 año, 6 meses', '006', '01', '1993-10-02', 'Cesar, La Jagua de Ibirico', 'O+', 'ABOGADO', 'SI', 'NO', '42442010171-0', 'BANCO AGRARIO', 'COOSALUD', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(39, 'CAMARGO VEGA STANLEE LEONARDO', '1064118704', 62, 10, 9, '3145551082', 'MZ 19 CASA 639 ALTOS DE LA MINA', 'sleonardocv@gmail.com', '2024-09-10', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 32, 'casado', 'catolico', 'Profesional', 'PERIODO DE PRUEBA', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'periodo_de_prueba', 'PROFESIONAL', 5095929.00, 'Decreto 00145', '2024-09-09', '4055', '2024-09-10', '10 meses', '219', '02', '1992-09-22', 'Cesar, La Jagua de Ibirico', 'A+', 'INGENIERO CIVIL', 'SI', 'ESPECIALISTA EN ESTRUCTURAS', '599085677', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(40, 'CAMARGO ZAMBRANO LAINE', '1094243818', 62, 10, 1, '3216194053', 'Diagonal 4 # 3-17 Juan Ramon', 'lainec1011@gmail.com', '2023-05-10', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 38, 'soltero', 'catolico', 'Profesional', 'ARQUITECTA', NULL, 1, 0, 'Norte de Santander, Pamplona', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00361', '2023-04-27', '3022', '2023-05-19', '2 años, 2 meses', '219', '02', '1986-11-10', 'Cesar, Curumaní', 'B+', 'ARQUITECTA', 'SI', 'ESPECIALIZACION EN INTERVENTORIA', '599144789', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(41, 'CAMPO CASTRO ANGEL DE JESUS', '1065611342', 42, 11, 1, '3147091302', 'Calle7 N° 2-85', 'angelccr16@gmail.com', '2023-05-17', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 35, 'union libre', 'catolico', 'tecnologo', 'AUXILIAR ADMINISTRATIVO', NULL, 1, 0, '', 'Si', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00417', '2023-05-03', '3015', '2023-05-17', '2 años, 1 mes', '407', '04', '1989-10-11', 'Cesar, Agustín Codazzi', 'O+', 'TECNOLO EN GESTION ADMINISTRATIVA', 'NO APLICA', 'NO', '91240319930', 'BANCOLOMBIA', 'SALUD TOTAL', 'PROTECCION', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(42, 'CARREÑO PABA IVAN DAVID', '1064718589', 63, 3, 1, '3142330551', 'Calle 4 2 127', 'ivanovidacapa@g.com', '2023-05-19', 0, '', 'masculino', 'CURUMANI', 31, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, Curumaní', 'Si', 'carrera_administrativa', 'TECNICO', 1863360.00, 'Resolucion 00377', '2023-04-27', '3023', '2023-05-19', '2 años, 1 mes', '306', '01', '1993-11-12', 'Cesar, Curumaní', 'AB-', 'ABOGADO', 'SI', 'NO', '424420098388', 'BANCO AGRARIO', 'ASMETSALUD', 'PORVENIR', 'PORVENIR', 'POSITIVA', 1, 0, 0, ''),
(43, 'CARVAJAL CORDOBA DUBIS MILENA', '1064106881', 62, 4, 1, '3135485100', 'Diagonal 1 N 7-20', 'dubysept14@hotmail.com', '2020-01-03', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 38, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR DE EMPRESAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Decreto 00003', '2020-01-02', '2719', '2020-01-03', '5 años, 6 meses', '219', '02', '1986-09-14', 'Cesar, Becerril', 'A-', 'ADMINISTRADORA DE EMPRESAS', 'SI', 'COMUNICADOR SOCIAL', '4-2442-0-04370-2', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(44, 'CASTAÑO TORRES OLGA LUCIA', '32796676', 66, 13, 1, '3117030947', 'Carrera 7 No. 3 - 40', 'olgaluciacastaotorres@yahoo.com', '2019-04-09', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 48, 'union libre', 'catolico', 'Profesional', 'GESTIÓN HUMANA', NULL, 1, 0, 'Atlántico, Barranquilla', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5542587.00, 'Decreto 00074', '2019-04-09', '2657', '2019-04-09', '6 años, 3 meses', '222', '03', '1976-08-09', 'Cesar, Tamalameque', 'O+', 'GESTIÓN HUMANA', 'SI', 'NO', '4-2442-0-05975-7', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(45, 'CASTRO RONCALLO JOSE LUIS', '77171225', 39, 13, 1, '3002885603', 'Diagonal 25 N° 61-41 leandro Diaz Etapa 3', 'joseluiscastroroncallo@gmail.com', '2024-04-01', 0, '', 'masculino', 'VALLEDUPAR', 52, 'casado', 'catolico', 'tecnico', 'PRODUCCION DIGITAL', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00216', '2024-03-11', '4031', '2024-04-01', '1 año, 3 meses', '477', '02', '1972-10-27', 'Cesar, Valledupar', 'O+', 'PRODUCCION DIGITAL', 'NO APLICA', 'NO', '599266293', 'BANCO DE BOGOTA', 'NUEVA EPS', 'PROTECCION', 'PROTECCION', 'POSITIVA', 1, 0, 0, NULL),
(46, 'COBO JIMENEZ MELVIS CECILIA', '66949795', 40, 13, 1, '3194195036', 'Manzana 8 casa 270 altos de la mina', 'cecicobojimenez@gmail.com', '2023-05-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 50, 'union libre', 'catolico', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, 'Valle del Cauca, Cali', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1573388.00, 'Resolucion 00429', '2023-05-03', '3026', '2023-05-23', '2 años, 1 mes', '470', '01', '1975-01-24', 'Cesar, Valledupar', 'O+', 'BACHILLER ACADEMICO', 'NO APLICA', 'NO', '4-2442-0-00842-0', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(47, 'CONTRERAS TOLOZA LUZ DARYS', '36572854', 62, 11, 2, '3104441925', 'Transv 13 N° 6-29 Brr Juan Ramon', 'luzdacont@htomail.com', '2024-01-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 45, 'union libre', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'PROFESIONAL', 5095929.00, 'Decreto 00008', '2024-01-02', '3098', '2024-01-02', '1 año, 6 meses', '201', '02', '1979-12-01', 'Cesar, La Jagua de Ibirico', 'O+', 'CONTADOR PUBLICO', 'SI', 'NO', '599270360', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(48, 'CORRALES RAMOS SARA', '52984085', 33, 13, 1, '3145300090', 'Calle 4 No. 1 - 11 simon bolivar', 's.corralesramos@gmail.com', '2019-04-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 41, 'divorciado', 'catolico', 'tecnico', 'AUXILIAR ADMINISTRATIVO', NULL, 1, 0, 'Bogotá, Bogotá D.C.', 'No Aplica', 'carrera_administrativa', 'TECNICO', 3468469.00, 'Decreto 00083', '2019-04-12', '2658', '2019-04-12', '6 años, 3 meses', '367', '04', '1983-12-30', 'Cesar, Astrea', 'O+', 'ADMINISTRACIÓN DEL RECURSO HUMANO', 'NO APLICA', 'NO', '4-244-20-04375-3', 'BANCO AGRARIO', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(49, 'CUADRADO CANTILLO MALENA', '1064115418', 38, 6, 1, '3107112535', 'Trav 12 No. 4-19', 'malenacuadrado@gmail.com', '2024-04-09', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 31, 'soltero', 'catolico', 'tecnico', 'RECURSOS HUMANOS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolución 00260', '2024-03-20', '4035', '2024-04-09', '1 año, 3 meses', '425', '04', '1993-12-24', 'Bolívar, Magangué', 'O+', 'RECURSOS HUMANOS', 'NO APLICA', 'NO', '52447222477', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(50, 'CUADRO ORTIZ YENIS PATRICIA', '36571119', 63, 9, 1, '3126604422', 'calle 5', 'ypcudroortiz@gmail.com', '2019-05-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 56, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR DE EMPRESAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Decreto 00098', '2019-05-02', '2670', '2019-05-02', '6 años, 2 meses', '219', '01', '1969-06-22', 'Cesar, La Jagua de Ibirico', 'B+', 'ADMINISTRADOR DE EMPRESAS', 'SI', 'NO', '4-2442-0-07787-9', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(51, 'DAZA VEGA LUIS CARLOS', '77172721', 52, 17, 8, '3103654507', 'Calle 4 No. 5-37', 'lucas.314@hotmail.com', '2018-01-01', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 52, 'union libre', 'catolico', 'Profesional', 'ECONOMISTA', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'periodo_fijo', 'ASESOR', 5982216.00, 'Decreto 00152', '2017-12-26', '2569', '2018-01-01', '7 años, 6 meses', '105', '02', '1973-03-14', 'Cesar, La Jagua de Ibirico', 'B+', 'ECONOMISTA', 'SI', 'NO', '599102837', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(52, 'DE LA CRUZ VILLERO YOMAR ANDRES', '1065662798', 46, 10, 1, '3043671957', 'Diagonal 5 h 27 17 de febrero', 'andres_199@outlook.es', '2023-05-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 34, 'soltero', 'catolico', 'tecnico', 'CONSTRUCCION', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00383', '2023-04-27', '3005', '2023-05-12', '2 años, 2 meses', '214', '03', '1991-05-16', 'Cesar, Valledupar', 'B+', 'CONSTRUCCION', 'NO APLICA', 'NO', '938618402', 'BBVA COLOMBIA', 'CAJACOPI', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(53, 'DIAZ CASTRO YADIRIS ESTHER', '49767723', 62, 11, 1, '3126650316', 'Diagonal 16 B 24 17', 'yadiazca@hotmail.com', '2024-02-01', 0, '', 'femenino', 'VALLEDUPAR', 53, 'soltero', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00768', '2023-11-16', '4015', '2024-02-01', '1 año, 5 meses', '219', '02', '1972-04-27', 'Cesar, La Jagua de Ibirico', 'O+', 'CONTADOR PUBLICO', 'SI', 'NO', '424420106992', 'BANCO AGRARIO', 'SALUD TOTAL', 'FONDO NACIONAL DE AHORRO', 'FONDO NACIONAL DE AHORRO', 'POSITIVA', 1, 1, 0, ''),
(54, 'DURAN FUENTES LUIS CARLOS', '1065616637', 63, 1, 2, '3163819809', 'CARRERA 2 # 7-19 APARTAMENTO', 'duran.fuentesluis@gmail.com', '2024-02-01', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 35, 'union libre', 'catolico', 'Profesional', 'INGENIERO DE SISTEMAS', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00050', '2024-02-01', '4017', '2024-02-01', '1 año, 5 meses', '006', '01', '1990-03-25', 'Cesar, La Jagua de Ibirico', 'O+', 'INGENIERO DE SISTEMAS', 'SI', 'NO', '52300000440', 'BANCOLOMBIA', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(55, 'DURAN QUINTERO ISLEY DAYANA', '1100838030', 46, 9, 1, '316864768', 'Carrera 3 N° 4-26', 'isdayduran@hotmail.com', '2023-10-10', 0, '', 'femenino', 'PINCHOTE', 38, 'soltero', 'catolico', 'Profesional', 'INGENIERO CIVIL', NULL, 1, 0, 'Santander, Pinchote', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00384', '2023-04-27', '3072', '2023-10-10', '1 año, 9 meses', '314', '03', '1986-08-30', 'Santander, Pinchote', 'A+', 'INGENIERO CIVIL', 'SI', 'NO', '32224930568', 'BANCOLOMBIA', 'SANITAS', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(56, 'FLOREZ CASTELLANOS KHEIZA DANIELA', '1064120393', 3, 9, 1, '3136201494', 'CALLE 1B 32 BRR CAÑAGUATE', 'khey_florez@hotmail.com', '2023-12-28', 0, '', 'femenino', 'VALLEDUPAR', 27, 'soltero', 'catolico', 'tecnico', 'ASISTENTE ADMINISTRATIVO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00787', '2023-11-02', '3082', '2023-12-28', '1 año, 6 meses', '367', '03', '1997-12-23', 'Cesar, Agustín Codazzi', 'O+', 'ASISTENTE ADMINISTRATIVO', 'NO APLICA', 'NO', '599277175', 'BANCO DE BOGOTA', 'DUSAKAWI', 'PROTECCION', 'FONDO NACIONAL DE AHORRO', 'POSITIVA', 0, 0, 0, NULL),
(57, 'FUENTES BUELVAS LUIS CARLOS', '1065630530', 3, 11, 1, '3003681449', 'Calle 45 N° 6 47', 'luisbuelvas@hotmail.es', '2023-10-12', 0, '', 'masculino', 'VALLEDUPAR', 34, 'soltero', 'catolico', 'tecnologo', 'GESTION DOCUMENTAL', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00406', '2023-05-03', '3073', '2023-10-12', '1 año, 9 meses', '367', '03', '1991-06-22', 'Cesar, Valledupar', 'AB+', 'GESTION DOCUMENTAL', 'NO APLICA', 'NO', '52424047830', 'BANCOLOMBIA', 'SALUD TOTAL', 'PROTECCION', 'FONDO NACIONAL DE AHORRO', 'POSITIVA', 1, 0, 0, NULL),
(58, 'GALLEGO MEJIA LUIS MIGUEL', '1064117633', 50, 10, 2, '3137925957', 'TRANS 10 1-38, Los comuneros', 'luismiguelgallego788o@gmail.com', '2025-01-28', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 29, 'soltero', 'catolico', 'Profesional', 'ARQUITECTO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00024', '2025-01-27', '4078', '2025-01-28', '5 meses', '020', '01', '1995-07-31', 'Cesar, La Jagua de Ibirico', 'O-', 'ARQUITECTO', 'SI', 'NO', '599112729', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(59, 'GALVIS MANJARRES DANIEL EDUARDO', '1082935301', 3, 9, 1, '3116561027', 'Diagoaal 24 # 61-38', 'dagalvis04@hotmail.com', '2023-05-17', 0, '', 'masculino', 'VALLEDUPAR', 34, 'casado', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Magdalena, Santa Marta', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolución 00387', '2023-04-27', '3014', '2023-05-17', '2 años, 1 mes', '367', '03', '1991-04-04', 'Cesar, Valledupar', 'O+', 'CONTADOR PUBLICO', 'SI', 'NO', '65687096074', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(60, 'GIL GAMEZ MAYRA CRISTINA', '1067712945', 62, 3, 1, '3114294762', 'Calle 12 # 8 - 59', 'kema983@hotmail.com', '2023-05-12', 0, '', 'femenino', 'BECERRIL', 38, 'soltero', 'catolico', 'Profesional', 'COMUNICADORA SOCIAL', NULL, 1, 0, 'Cesar, Agustín Codazzi', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00369', '2023-04-27', '3006', '2023-05-12', '2 años, 2 meses', '219', '02', '1986-08-16', 'Cesar, Becerril', 'O+', 'COMUNICADORA SOCIAL', 'SI', 'ESP MARKETING DIGITAL', '19797981985', 'BANCOLOMBIA', 'NUEVA EPS', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, ''),
(61, 'GOMEZ ORTA LUIS FERNANDO', '77104486', 63, 3, 1, '3015880297', 'CALLE 3 No.5-17', 'luiferorta@gmail.com', '2023-05-12', 0, '', 'masculino', 'CHIRIGUANA', 47, 'soltero', 'catolico', 'Profesional', 'PSICOLOGO', NULL, 1, 0, 'Cesar, Chiriguaná', 'Si', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolucion 00366', '2023-04-27', '3007', '2023-05-12', '2 años, 2 meses', '219', '01', '1977-08-08', 'Cesar, Chiriguaná', 'B+', 'PSICOLOGO', 'SI', 'ESP EN GESTION DE PROCESOS PSICOSOCIALES', '599269628', 'BANCO DE BOGOTA', 'NUEVA EPS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(62, 'GUERRA FERNANDEZ LILA MARGARITA', '1064111556', 41, 3, 1, '3106561117', 'TOSCANO', 'lila1790@hotmail.com', '2016-01-06', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 35, 'union libre', 'catolico', 'tecnologo', 'CONTABILIDAD Y FINANZAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00014', '2016-01-06', '2344', '2016-01-06', '9 años, 6 meses', '407', '02', '1990-05-26', 'Cesar, San Diego', 'O+', 'CONTABILIDAD Y FINANZAS', 'NO APLICA', 'NO', '599269552', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(63, 'GUERRA FERNANDEZ LINA MARCELA', '36574072', 38, 17, 2, '3161351912', 'Carrera 6 2 54', 'lguerrafernandez@hotmail.com', '2024-01-09', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 38, 'casado', 'catolico', 'tecnologo', 'TECNOLO EN RECURSOS HUMANOS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'ASISTENCIAL', 2775379.00, 'Decreto 00033', '2024-01-09', '4011', '2024-01-09', '1 año, 6 meses', '438', '06', '1986-08-26', 'Cesar, San Diego', 'A+', 'TECNOLO EN RECURSOS HUMANOS', 'NO APLICA', 'NO', '599269644', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(64, 'HERNADEZ MIER JORGE LUIS', '1064118459', 36, 17, 2, '3233890084', 'CALLE 2 3 126', 'jlhndz96@gmail.com', '2024-01-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 29, 'Selecciona una opción', 'catolico', 'tecnico', 'APOYO LOGISTICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'ASISTENCIAL', 1863226.00, 'Decreto 00021', '2024-01-02', '4003', '2024-01-02', '1 año, 6 meses', '472', '02', '1996-06-05', 'Cesar, La Jagua de Ibirico', 'O+', 'APOYO LOGISTICO', 'No Aplica', 'NO', '599270212', 'BANCO DE BOGOTA', 'COOSALUD', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(65, 'HERNANDEZ CATAÑO LEONARDO FABIO', '1065571582', 49, 17, 10, '3123903095', 'Calle 5 N° 4 -77 B. Centro', 'leonardohernandez4@hotmail.com', '2024-01-01', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 39, 'soltero', 'catolico', 'Profesional', 'MEDICO GENERAL', NULL, 1, 0, 'Santander, Bucaramanga', 'Si', 'eleccion', 'DIRECTIVO', 7889729.00, 'Acta', '2024-01-01', '1', '2024-01-01', '1 año, 6 meses', '005', '0', '1986-06-11', 'Cesar, Valledupar', 'A+', 'MEDICO GENERAL', 'Si', 'ORTOPEDIA', '863069035', 'BANCO DE BOGOTA', 'SANITAS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(66, 'HERNANDEZ PAEZ JUAN DAVID', '1064120750', 50, 8, 2, '3114346792', 'LA VICTORIA DE SAN ISIDRO', 'juna17naju@gmail.com', '2024-01-02', 0, '', 'masculino', 'LA VICTORIA DE SAN ISIDRO', 27, 'soltero', 'catolico', 'Profesional', 'INGENIERO AMBIENTAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto N°. 00012', '2024-01-02', '3095', '2024-01-02', '1 año, 6 meses', '020', '01', '1998-04-02', 'Cesar, Becerril', 'A+', 'INGENIERO AMBIENTAL', 'Si', 'NO', '424420101966', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(67, 'HERRERA CUADRO YANIVIS SHIRLEYS', '49724249', 38, 16, 1, '3137615519', 'Mz 2 casa 60 Rumualdo Avila', 'sivinay.26@hotmail.com', '2023-08-01', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 41, 'casado', 'catolico', 'tecnico', 'ASISTENTE EN PLANEACION ADMINISTRATIVA', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00566', '2023-07-04', '3056', '2023-08-01', '1 año, 11 meses', '425', '04', '1984-03-01', 'Cesar, La Jagua de Ibirico', 'A+', 'ASISTENTE EN PLANEACION ADMINISTRATIVA', 'No Aplica', 'NO', '599269503', 'BANCO DE BOGOTA', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(68, 'HURTADO CANTILLO DIANA PATRICIA', '36573442', 38, 11, 1, '3126223341', 'Urb altos de la mina Mz 9', 'karydoug@hotmail.com', '2017-11-07', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 45, 'soltero', 'catolico', 'tecnico', 'RECURSOS HUMANOS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolución 00116', '2017-11-07', '2555', '2017-11-07', '7 años, 8 meses', '425', '04', '1980-01-10', 'Cesar, La Jagua de Ibirico', 'O+', 'RECURSOS HUMANOS', 'No Aplica', 'NO', '4-2442-0-06536-6', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(69, 'IGUARAN MARQUEZ ELIAS JOSE', '1003379050', 3, 1, 7, '3113825599', 'DIAGONAL 6 # 5 86', 'helias.iguaran@gmail.com', '2025-03-10', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 22, 'soltero', 'catolico', 'tecnico', 'SISTEMAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'provisionalidad', 'TECNICO', 2825896.00, 'DECRETO 00045', '2025-03-07', '0', '2025-03-10', '4 meses', '367', '03', '2002-10-08', 'Cesar, Valledupar', 'O+', 'SISTEMAS', 'No Aplica', 'NO', '76565023566', 'BANCOLOMBIA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(70, 'JIMENEZ CONTRERAS YULITZA FERNANDA', '1065910174', 38, 5, 1, '3145453127', 'calle 8 6 11', 'yfjimunezc@ufpso.edu.co', '2024-02-01', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 28, 'soltero', 'catolico', 'tecnico', 'SISTEMAS', NULL, 1, 0, 'Cesar, Aguachica', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00004', '2024-01-12', '4014', '2024-02-01', '1 año, 5 meses', '425', '04', '1997-04-01', 'Cesar, Aguachica', 'O+', 'SISTEMAS', 'No Aplica', 'UNIVERSITARIOS-ADM EMPRESAS', '48606967597', 'BANCOLOMBIA', 'NUEVA EPS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, ''),
(71, 'JIMENEZ GOMEZ JOSE JULIAN', '1098636346', 62, 12, 1, '3177890332', 'calle 6 # 4-16 Brr Centro', 'juliangomezabogado@hotmail.com', '2024-01-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 38, 'union libre', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Santander, Bucaramanga', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00841', '2023-02-21', '4013', '2024-01-12', '1 año, 6 meses', '219', '02', '1986-12-12', 'Santander, Mogotes', 'O+', 'ABOGADO', 'Si', 'ESPECILISTA EN DERECHO PROCESAL', '599269735', 'BANCO DE BOGOTA', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(72, 'JINETE BLANCO YEIMIS DEL CARMEN', '44156723', 38, 4, 1, '3205691636', 'CARRERA 10 4 -58 Simon Bolivar', 'yeimis22@hotmail.com', '2023-05-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 42, 'casado', 'catolico', 'tecnologo', 'CONTABILIDAD Y FINANZAS', NULL, 1, 0, 'Atlántico, Soledad', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolución 00421', '2023-05-03', '3001', '2023-05-12', '2 años, 2 meses', '425', '04', '1983-05-22', 'Atlántico, Barranquilla', 'B+', 'CONTABILIDAD Y FINANZAS', 'No Aplica', 'NO', '4-2442-0-05491-7', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(73, 'JULIAO LEMUS ERIC', '77188976', 62, 9, 1, '3167541553', 'transversal 10A N° 8A -91 bello Horizonte', 'ericjuliao15@gmail.com', '2024-02-13', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 48, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00013', '2024-01-24', '4020', '2024-02-13', '1 año, 5 meses', '219', '02', '1977-07-15', 'Bolívar, Cartagena', 'O+', 'ADMINISTRADOR PUBLICO', 'Si', 'NO', '599269602', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(74, 'LEMUS SANJUAN CELIAR', '1032421017', 3, 7, 1, '3126565977', 'calle 4 N° 11 05', 'makialemus@hotmail.com', '2023-07-24', 0, '', 'masculino', 'MANAURE', 36, 'casado', 'catolico', 'tecnico', 'SEGURIDAD OCUPACIONAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00569', '2023-07-05', '3052', '2023-07-24', '1 año, 11 meses', '367', '03', '1988-09-22', 'Cesar, La Jagua de Ibirico', 'O+', 'SEGURIDAD OCUPACIONAL', 'No Aplica', 'NO', '52400003427', 'BANCOLOMBIA', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(75, 'MALDONADO AVILA JOSE MARIA', '1065567850', 50, 5, 2, '3016451820', 'DG 1 9- 139 BRR OVELIO JIMENEZ', 'chema_9-5@hotmail.com', '2025-06-19', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 40, 'soltero', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00082', '2025-06-19', '4107', '2025-06-19', '28 días', '020', '01', '1984-11-05', 'Cesar, La Jagua de Ibirico', 'AB+', 'ADMINISTRADOR PUBLICO', 'Si', 'NO', '599124690', 'BANCO DE BOGOTA', 'CAJACOPI', 'PROTECCION', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(76, 'MARQUEZ LEON INES YADIRIS', '1091654714', 38, 22, 1, '3229442043', 'Calle 6 - 6-35', 'yadirismarquez@yohoo.es', '2023-05-19', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 39, 'soltero', 'catolico', 'tecnico', 'RECURSOS HUMANOS', NULL, 1, 0, 'Norte de Santander, Ocaña', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00425', '2023-05-03', '3020', '2023-05-19', '2 años, 1 mes', '425', '04', '1986-04-03', 'Norte de Santander, Convención', 'A-', 'RECURSOS HUMANOS', 'No Aplica', 'NO', '599269669', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(77, 'MARQUEZ REDONDO OLGA LUCIA', '36573983', 38, 8, 1, '3164648819', 'Carrera 2 # 10- 70 Barrio Camilo Torres', 'ollumare@gmail.com', '2016-11-21', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 40, 'soltero', 'catolico', 'tecnico', 'PROGRAMACION DE SOFTWARE', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00697', '2016-11-21', '2511', '2016-11-21', '8 años, 7 meses', '425', '04', '1984-10-28', 'Córdoba, Montería', 'A+', 'PROGRAMACION DE SOFTWARE', 'No Aplica', 'NO', '4-2442-0-06397-5', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(78, 'MARTINEZ PLATA MELISSA LISETH', '1065834272', 3, 11, 1, '3103521357', 'CALLE 25A 4 H 83', 'melise9726@gmail.com', '2023-07-05', 0, '', 'femenino', 'VALLEDUPAR', 27, 'soltero', 'catolico', 'Profesional', 'CONTADORA PUBLICA', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00414', '2023-05-03', '', '2023-07-05', '2 años', '367', '03', '1997-07-28', 'Cesar, Agustín Codazzi', 'O+', 'CONTADORA PUBLICA', 'No', 'NO', '599269479', 'BANCO DE BOGOTA', 'FAMISANAR', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(79, 'MEJIA RINCON DIGNA MARIA', '1102351900', 38, 14, 1, '3216622010', 'MZ 19 casa 650 altos de la mina', 'dignademyfe@hotmail.com', '2016-01-06', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 38, 'casado', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Santander, Piedecuesta', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00017', '2016-01-06', '2346', '2016-01-06', '9 años, 6 meses', '425', '04', '1987-01-06', 'Cesar, La Jagua de Ibirico', 'O+', 'ABOGADO', 'No', 'NO', '599269545', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(80, 'MENDOZA MAESTRE LINNY GREYS', '1064110813', 3, 13, 1, '3105939684', 'MZ 7 CASA 209 URBANIZACION SORORIA', 'ligremendo@hotmail.com', '2016-01-21', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 35, 'soltero', 'catolico', 'tecnologo', 'SALUD OCUPACIONAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00034', '2016-01-18', '2369', '2016-01-21', '9 años, 5 meses', '367', '03', '1990-05-12', 'Cesar, La Jagua de Ibirico', 'O+', 'SALUD OCUPACIONAL', 'No Aplica', 'NO', '4-2442-0-05978-1', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 1, 0, NULL),
(81, 'MENDOZA NIEBLES PAOLA ANDREA', '1064797333', 3, 16, 1, '3014684244', 'calle 17 carrera 38a 65', 'paydaamor@hotmail.com', '2023-05-23', 0, '', 'femenino', 'CHIRIGUANA', 32, 'casado', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, Chiriguaná', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00413', '2023-05-03', '3024', '2023-05-23', '2 años, 1 mes', '367', '03', '1993-03-11', 'Cesar, Chiriguaná', 'A+', 'ABOGADO', 'No', 'DIPLOMADO DERECHO LABORAL', '4-244-20-09823-1', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(82, 'MENDOZA ORTIZ WILLIAM ENRIQUE', '77027901', 3, 4, 1, '3216439752', 'Cra 5 N 9-44 BARRIO 5 DE MARZO', 'WILLIAMKIKE20@YAHOO.ES', '2019-07-25', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 57, 'casado', 'catolico', 'tecnico', 'ADMINISTRACION DEL TALENTO HUMANO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Decreto 00149', '2019-07-25', '2691', '2019-07-27', '5 años, 11 meses', '367', '03', '1968-04-08', 'Cesar, Valledupar', 'O+', 'ADMINISTRACION DEL TALENTO HUMANO', 'No Aplica', 'NO', '599269537', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 1, 0, 0, NULL),
(83, 'MENDOZA SILVA YERALDITH CAROLINA', '1091663617', 62, 10, 1, '3014832602', 'Calle 8 No. 2-101 las malvinas', 'yera1804@hotmail.com', '2019-02-04', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 35, 'union libre', 'catolico', 'Profesional', 'INGENIERO CIVIL', NULL, 1, 0, 'Norte de Santander, Ocaña', '', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Decreto 00029', '2019-01-30', '2644', '2019-02-04', '6 años, 5 meses', '219', '02', '1990-04-18', 'Cesar, La Jagua de Ibirico', 'A+', 'INGENIERO CIVIL', 'No', 'NO', '599269495', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(84, 'MOJICA MAYUSA ASTRITH LEONOR', '1065599502', 63, 7, 1, '3218472276', 'Carrera 4 B N0. 9 - 43 B. 5 De Marzo', 'astridmojica_07@hotmail.com', '2016-02-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 36, 'union libre', 'catolico', 'Profesional', 'BACTERIOLOGA Y LABORATORISTA CLINICO', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolucion 00130', '2016-02-23', '2375', '2016-02-23', '9 años, 4 meses', '237', '01', '1988-11-07', 'Cesar, Valledupar', 'O+', 'BACTERIOLOGA Y LABORATORISTA CLINICO', 'No', 'NO', '4-244-20-05749-5', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(85, 'MONTERROSA MADRID JAVIER ALBERTO', '98686747', 37, 17, 2, '3105050749', 'Carrera 2A mz 2 casa 50', 'jalmoma_2@hotmail.com', '2024-01-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 46, 'casado', 'catolico', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, '', 'Si', 'libre_nombramiento', 'ASISTENCIAL', 2809334.00, 'Decreto 00011', '2024-01-02', '3094', '2024-01-02', '1 año, 6 meses', '480', '05', '1979-03-02', 'Antioquia, Arboletes', 'O+', 'BACHILLER ACADEMICO', 'No Aplica', 'NO', '599269578', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(86, 'MORALES OSPINO JORGE RAFAEL', '1065584396', 62, 8, 9, '3005172751', 'CARREARA 20 N° 29 17 BRR 1 DE MAYO', 'ingenieroambientalmorals@gmail.com', '2025-04-03', 0, '', 'masculino', 'VALLEDUPAR', 38, 'casado', 'catolico', 'Profesional', 'INGENIERA AMBIENTAL Y SANITARIO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'periodo_de_prueba', 'PROFESIONAL', 5095929.00, 'RESOLUCION 00003', '2025-01-09', '4101', '2025-04-03', '3 meses', '219', '02', '1987-03-22', 'Cesar, Valledupar', 'O+', 'INGENIERA AMBIENTAL Y SANITARIO', 'Si', 'NO', '52328634951', 'BANCOLOMBIA', 'SANITAS', '', '', 'POSITIVA', 0, 0, 0, NULL),
(87, 'MUÑOZ ROMERO LISETH', '1064112218', 36, 17, 2, '3104383268', 'Transv 14 N° 8-06 Brr Juan Ramon', 'liseth_munoz@hotmail.com', '2024-01-05', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 35, 'soltero', 'catolico', 'tecnico', 'ASISTENCIA EN ORGANIZACIÓN DE ARCHIVOS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No', 'libre_nombramiento', 'ASISTENCIAL', 1863226.00, 'Decreto 00032', '2024-01-05', '4010', '2024-01-05', '1 año, 6 meses', '472', '02', '1990-04-15', 'Cesar, La Jagua de Ibirico', 'A+', 'ASISTENCIA EN ORGANIZACIÓN DE ARCHIVOS', 'No Aplica', 'NO', '599269636', 'BANCO DE BOGOTA', 'COOSALUD', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(88, 'NARVAEZ MEJIA JESSICA ELINOR', '1065817403', 46, 8, 1, '3044221255', 'Calle 33 24 46', 'ing.jessicanarvaez@gmail.com', '2023-05-24', 0, '', 'femenino', 'VALLEDUPAR', 29, 'soltero', 'catolico', 'Profesional', 'INGENIERA AMBIENTAL Y SANITARIA', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'RESOLUCION 00380', '2023-04-27', '3032', '2023-05-24', '2 años, 1 mes', '214', '03', '1995-08-13', 'Cesar, Valledupar', 'O+', 'INGENIERA AMBIENTAL Y SANITARIA', 'No', 'NO', '704-214543-35', 'BANCOLOMBIA', 'SALUD TOTAL', 'COLPENSIONES', 'FONDO NACIONAL DE AHORRO', 'POSITIVA', 1, 0, 0, NULL),
(89, 'NAVAS SOLANO LUILLY JOBANNYS', '77105429', 3, 4, 1, '3218075307', 'carrera 19a No 17a-20', 'lnavas1981@gmail.com', '2023-05-12', 0, '', 'masculino', 'VALLEDUPAR', 44, 'casado', 'catolico', 'Profesional', 'INGENIERO DE SISTEMAS', NULL, 1, 0, 'Cesar, Chiriguaná', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00412', '2023-05-03', '3004', '2023-05-12', '2 años, 2 meses', '367', '03', '1981-01-25', 'Cesar, Chiriguaná', 'A+', 'INGENIERO DE SISTEMAS', 'No', 'NO', '599268943', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(90, 'NIEBLES CARCAMO CARMEN ELENA', '1047337992', 3, 11, 1, '3137494979', 'Mz 8 Casa 255 Urb. Alto de la Mina', 'carmennieblescarcamo@hotmail.com', '2023-05-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 36, 'casado', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Atlántico, Santo Tomás', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00416', '2023-05-03', '3029', '2023-05-23', '2 años, 1 mes', '367', '03', '1988-10-24', 'Atlántico, Barranquilla', 'O+', 'CONTADOR PUBLICO', 'No', 'NO', '614000432', 'BBVA COLOMBIA', 'ASMETSALUD', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(91, 'OCHOA NIETO NELSON JAVIER', '12523982', 50, 7, 2, '3166220822', 'CALLE 5 4 117', 'nelsonochoaodontologor@outlook.com', '2024-01-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 44, 'casado', 'catolico', 'Profesional', 'ODONTOLOGO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00013', '2024-01-02', '3096', '2024-01-02', '1 año, 6 meses', '097', '01', '1980-10-17', 'Cesar, La Jagua de Ibirico', 'O+', 'ODONTOLOGO', 'No', 'NO', '52477296033', 'BANCOLOMBIA', 'FAMISANAR', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(92, 'ORTEGA MORENO JOSE MANUEL', '15174200', 63, 3, 1, '3106150888', 'Diagonal 1B # 32', 'concejalortega1@gmail.com', '2023-05-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 44, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, Valledupar', 'No', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolucion 00365', '2023-04-27', '2990', '2023-05-12', '2 años, 2 meses', '219', '01', '1981-03-14', 'Cesar, La Jagua de Ibirico', 'O+', 'ADMINISTRADOR PUBLICO', 'No', 'ESPECIALISTA EN GESTION PUBLICA', '599040839', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(93, 'OTALORA DUARTE SANDRA YANETH', '60260710', 42, 7, 1, '3132419824', 'sector 1 manzana 8 casa 18', 'sandra.otalora@outlook.es', '2023-05-30', 0, '', 'femenino', 'BECERRIL', 49, 'soltero', 'catolico', 'tecnologo', 'REGENCIA EN FARMACIA', NULL, 1, 0, 'Norte de Santander, Pamplona', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775397.00, 'Resolucion 00418', '2023-05-03', '3036', '2023-05-30', '2 años, 1 mes', '425', '04', '1976-01-10', 'Cesar, La Jagua de Ibirico', 'O+', 'REGENCIA DE FARMACIA', 'No', 'NO', '488423585386', 'DAVIVIENDA', 'NUEVA EPS', 'COLPENSIONES', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(94, 'OZUNA COGOLLO JAIR DE JESUS', '1067910427', 48, 3, 1, '3015573075', 'cll 41a 16-18', 'jairoazuna0@hotmail.com', '2023-05-25', 0, '', 'masculino', 'MONTERIA', 33, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Córdoba, Montería', 'Si', 'carrera_administrativa', 'TECNICO', 1863360.00, 'Resolucion 00378', '2023-04-27', '3034', '2023-05-25', '2 años, 1 mes', '306', '01', '1992-04-16', 'Córdoba, Tierralta', 'O+', 'ABOGADO', 'No', 'NO', '16668761422', 'BANCOLOMBIA', 'SANITAS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(95, 'PATERNINA VASQUEZ MOISES XAVIER', '1007027860', 57, 13, 2, '3012471106', 'CALLE 7A 5-69', 'moisesxavier44@gmail.com', '2024-01-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 39, 'casado', 'catolico', 'Profesional', 'INGENIERO INDUSTRIAL', NULL, 1, 0, 'Norte de Santander, Los Patios', 'Si', 'libre_nombramiento', 'ASESOR', 5982216.00, 'Decreto 00002', '2024-02-02', '3085', '2024-01-02', '1 año, 6 meses', '105', '02', '1986-04-09', 'Cesar, La Jagua de Ibirico', 'O+', 'INGENIERO INDUSTRIAL', 'No', 'ESPECIALIZACION EN SEGURIDAD Y SALUD EN EL TRABAJO', '599273513', 'BANCO DE BOGOTA', 'COOSALUD', 'PROTECCION', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(96, 'PAYANENE BAENA KRISTIAN EDUARDO', '1062812554', 44, 3, 1, '3116622051', 'carrera 7 No. 14 - 21', 'kristianpayanene@gmail.com', '2023-06-26', 0, '', 'masculino', 'BECERRIL', 30, 'casado', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, Becerril', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00477', '2023-05-24', '3044', '2023-06-26', '2 años', '303', '03', '1995-05-01', 'Cesar, Becerril', 'O+', 'ABOGADO', 'No', 'NO', '424420098892', 'BANCO AGRARIO', 'NUEVA EPS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(97, 'PAYARES ORTIZ ALEXI', '1050918234', 62, 6, 1, '3102873824', 'Carrera 8 # 4-21', 'negro-0904-@hotmail.com', '2023-07-17', 0, '', 'masculino', 'SIMITI', 39, 'soltero', 'catolico', 'Profesional', 'MEDICO VETERINARIO Y ZOOTECNISTA', NULL, 1, 0, 'Bolívar, Simití', 'Si', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolución 00548', '2023-06-21', '3051', '2023-07-17', '2 años', '219', '02', '1985-09-04', 'Bolívar, Simití', 'A+', 'MEDICO VETERINARIO Y ZOOTECNISTA', 'No', 'ESPECIALISTA EN GESTION PUBLICA', '13445639710', 'BANCOLOMBIA', 'NUEVA EPS', 'PROTECCION', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(98, 'PEINADO SANGUINO JOHN JAIRO', '72233215', 3, 4, 1, '3114115900', 'Manzana 2 casa 46 Urb Rumualdo Avila', 'johnpeinado98@gmail.com', '2023-05-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 48, 'union libre', 'catolico', 'Profesional', 'LICENCIADO EN EDUCACION FISICA', NULL, 1, 0, 'Atlántico, Barranquilla', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00411', '2023-05-03', '2999', '2023-05-12', '2 años, 2 meses', '367', '03', '1977-06-19', 'Atlántico, Barranquilla', 'B+', 'LICENCIADO EN EDUCACION FISICA', 'No', 'NO', '4-244-20-01538-5', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(99, 'PINTO DIAZ CARMEN CRISTINA', '1065598563', 58, 22, 2, '3007845855', 'calle 3 5 20', 'carmenpinto99@hotmail.com', '2024-01-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 37, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'libre_nombramiento', 'ASESOR', 5982216.00, 'Decreto 00017', '2024-01-02', '4000', '2024-01-02', '1 año, 6 meses', '115', '02', '1988-06-09', 'Cesar, Valledupar', 'A+', 'ABOGADO', 'No', 'ESPECIALISTA EN DERECHO ADMINISTRATIVO', '599235124', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(100, 'PINTO GARCIA KELLY JOHANNA', '1064110039', 36, 17, 2, '3212375834', 'mz 15 casa 535 altos de la mina', 'mivallenatalinda@hotmail.com', '2024-01-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 36, 'soltero', 'catolico', 'tecnico', 'AUXILIAR ADMINISTRATIVO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'ASISTENCIAL', 1863226.00, 'Decreto 00038', '2024-01-12', '4012', '2024-01-12', '1 año, 6 meses', '472', '02', '1989-05-29', 'Cesar, Valledupar', 'O+', 'AUXILIAR ADMINISTRATIVO', 'No Aplica', 'NO', '424420101850', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(101, 'PINZON MANJARREZ BERENICE', '49767243', 63, 3, 1, '3103693388', 'Clle 7 No. 4-56 Barrio Ovelio Jimenez', 'berenice.029@hotmail.com', '2023-05-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 52, 'soltero', 'catolico', 'Profesional', 'ADMINISTRADORA DE EMPRESAS', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolucion 00367', '2023-04-27', '3025', '2023-05-23', '2 años, 1 mes', '219', '01', '1973-01-29', 'Cesar, Valledupar', 'O-', 'ADMINISTRADORA DE EMPRESAS', 'No', 'NO', '52452190745', 'BANCOLOMBIA', 'NUEVA EPS', 'FONDO NACIONAL DE AHORRO', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(102, 'POLANCO BARRETO CARMEN ELENA', '1131064779', 41, 4, 1, '3118634041', 'CALLE 2 SUR 3-45', 'carmenpolanco87@gmail.com', '2019-05-17', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 44, 'union libre', 'catolico', 'tecnico', 'CONTABILIZACION DE OPERACIONES COMERCIALES Y FINANCIERAS', NULL, 1, 0, 'La Guajira, Albania', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Decreto 00114', '2019-05-17', '2678', '2019-05-17', '6 años, 2 meses', '407', '02', '1981-01-06', 'Magdalena, Ariguaní', 'O-', 'CONTABILIZACION DE OPERACIONES COMERCIALES Y FINANCIERAS', 'No Aplica', 'NO', '4-2442-0-077745-3', 'BANCO AGRARIO', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL);
INSERT INTO `tbl_funcionarios_planta` (`idefuncionario`, `nombre_completo`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`, `lugar_expedicion`, `libreta_militar`, `tipo_nombramiento`, `nivel`, `salario_basico`, `acto_administrativo`, `fecha_acto_nombramiento`, `no_acta_posesion`, `fecha_acta_posesion`, `tiempo_laborado`, `codigo`, `grado`, `fecha_nacimiento`, `lugar_nacimiento`, `rh`, `titulo`, `tarjeta_profesional`, `otros_estudios`, `cuenta_no`, `banco`, `eps`, `afp`, `afc`, `arl`, `sindicalizado`, `madre_cabeza_hogar`, `prepensionado`, `edades_hijos`) VALUES
(103, 'PRIETO MONICA', '49795635', 63, 16, 9, '3225685318', 'Manzana 13 casa 369 urb Sororia', 'monicaprieto1979@gmail.com', '2025-03-04', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 45, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'periodo_de_prueba', 'PROFESIONAL', 4202612.00, 'Resolucion 01088', '2024-09-24', '4091', '2025-03-04', '4 meses', '219', '01', '1979-11-14', 'Bogotá, Bogotá D.C.', 'A+', 'ABOGADO', 'No', 'ESPECIALISTA EN DERECHO ADMINISTRATIVO', '599279346', 'BANCO DE BOGOTA', '', '', '', 'POSITIVA', 0, 1, 0, NULL),
(104, 'QUINTERO CARRASCAL JASMIN', '36573432', 50, 3, 2, '3234892630', 'carrera 3A # 11-72 Brr Malvinas', 'jasminquintero82@hotmail.com', '2024-01-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 42, 'soltero', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00005', '2024-01-02', '3088', '2024-01-02', '1 año, 6 meses', '020', '01', '1982-10-05', 'Cesar, La Jagua de Ibirico', 'B+', 'ADMINISTRADOR PUBLICO', 'No', 'NO', '7650000620', 'BANCOLOMBIA', 'CAJACOPI', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(105, 'QUIÑONEZ FUENTES DEICY ZORAIMA', '1098630865', 47, 5, 1, '3107008303', 'TRANSV 2 DIAG 16 CASA 3 VILLA ESPERANZA', 'dezoquifu@hotmail.com', '2019-03-14', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 38, 'union libre', 'catolico', 'tecnico', 'CONTROL Y SEGURIDAD VIAL', NULL, 1, 0, 'Santander, Bucaramanga', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Decreto 00058', '2019-03-13', '2652', '2019-03-14', '6 años, 4 meses', '340', '03', '1986-12-13', 'Santander, Bucaramanga', 'O+', 'CONTROL Y SEGURIDAD VIAL', 'No', 'NO', '4-2442-0-07701-1', 'BANCO AGRARIO', 'ASMETSALUD', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(106, 'QUIROZ CAMARGO IVAN RENE', '1064114809', 3, 11, 1, '3234882027', 'Trav 12 No. 7-07', 'ivanquiroz_2018@hotmail.com', '2023-05-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 31, 'soltero', 'catolico', 'Profesional', 'ECONOMISTA', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolución 00410', '2023-05-03', '2998', '2023-05-12', '2 años, 2 meses', '367', '03', '1993-12-31', 'Cesar, Valledupar', 'O+', 'ECONOMISTA', 'No', 'NO', '599269651', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(107, 'REYES FLOREZ MARTHA CECILIA', '37746699', 3, 3, 1, '3116854563', 'MZ 1 CASA 36 URB. SORORIA', 'cecireyes22@hotmail.com', '2018-11-01', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 46, 'casado', 'catolico', 'Profesional', 'ADMINISTRADORA COMERCIAL Y DE SISTEMAS', NULL, 1, 0, 'Santander, Bucaramanga', 'No Aplica', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Decreto 00139', '2018-10-31', '2621', '2018-11-01', '6 años, 8 meses', '367', '03', '1979-02-22', 'Cesar, Becerril', 'A+', 'ADMINISTRADORA COMERCIAL Y DE SISTEMAS', 'No', 'NO', '599022514', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(108, 'RODRIGUEZ CASTAÑO ADRIANA', '63558242', 33, 16, 9, '3215444972', 'CARRERA 9 n° 21-12 CASA LA CUMBRE', 'adrianarc1509@gmsi.com', '2025-04-01', 0, '', 'femenino', 'SAN MARTIN', 40, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Santander, Bucaramanga', 'No Aplica', 'periodo_de_prueba', 'TECNICO', 3468469.00, 'Resolución 00214', '2025-03-17', '4099', '2025-04-01', '3 meses', '367', '04', '1985-03-15', 'Cesar, San Martín', 'B+', 'ABOGADO', 'Si', 'ESPECIALISTA EN DERECHO CONSTITUCIONAL', '420021446', 'BANCO DE BOGOTA', 'NUEVA EPS', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 1, 0, NULL),
(109, 'RODRIGUEZ RIVERA KAREN LICETH', '1064113036', 55, 17, 2, '3147771502', 'CARRERA 4 10 23 BRR 5 DE MARZO', 'karenliceth92@gmail.com', '2025-01-14', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 32, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'ASESOR', 5982216.00, 'Decreto 00009', '2025-01-14', '4076', '2025-01-14', '6 meses', '105', '02', '1992-09-26', 'Cesar, La Jagua de Ibirico', 'O+', 'ABOGADO', 'Si', 'ESPECIALISTA EN CONTRATACION ESTATAL', '599036308', 'BANCO DE BOGOTA', 'SURA', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(110, 'RODRIGUEZ VANSTRAHLENS JHOANA PATRICIA', '1064109903', 63, 17, 2, '3017932092', 'calle 5 2 Brr centro', 'jhoanapatriciarodriguezvanstra@gmail.com', '2024-01-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 36, 'soltero', 'catolico', 'Profesional', 'TRABAJADOR SOCIAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'PROFESIONAL', 4202612.00, 'Decreto 00008', '2024-01-02', '3097', '2024-01-02', '1 año, 6 meses', '219', '01', '1989-03-09', 'Cesar, La Jagua de Ibirico', 'O+', 'TRABAJADOR SOCIAL', 'No', 'NO', '76571533932', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(111, 'ROJAS DAZA MARTHA REMEDIO', '1065631055', 50, 12, 2, '3114392615', 'carrera 7 # 6-1 Brr Centro', 'rojas_martha1@hotmail.com', '2024-01-02', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 33, 'casado', 'catolico', 'Profesional', 'PSICOLOGO', NULL, 1, 0, 'Cesar, Valledupar', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto No. 00009', '2024-01-02', '3092', '2024-01-02', '1 año, 6 meses', '020', '01', '1991-07-30', 'Cesar, Valledupar', 'B+', 'PSICOLOGO', 'No', 'ESPECIALISTA EN GERENCIA DEL TALENTO HUMANO', '599270048', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(112, 'ROSADO MAESTRE YECID ARMANDO', '15174499', 39, 13, 1, '3116659406', 'CALLE 35A 91 MZ 77 CASA 15', 'yeroma82@hotmail.com', '2024-04-01', 0, '', 'masculino', 'VALLEDUPAR', 43, 'casado', 'catolico', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolución 00213', '2024-11-11', '4032', '2024-04-01', '1 año, 3 meses', '477', '02', '1982-03-05', 'Cesar, Valledupar', 'O+', 'BACHILLER ACADEMICO', 'No Aplica', 'NO', '19765230244', 'BANCOLOMBIA', 'SALUD TOTAL', 'PROTECCION', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(113, 'RUIDIAZ DAVILA MAGALIS ESTHER', '49748671', 40, 13, 1, '3218348309', 'Manzana 12 casa 337 urb Sosoria', 'magacaro25@gmail.com', '2023-05-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 53, 'union libre', 'catolico', 'bachiller', 'BACHILLER ACADEMICO', NULL, 1, 0, 'Cesar, Becerril', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1573388.00, 'Resolución 00428', '2023-05-03', '3009', '2023-05-12', '2 años, 2 meses', '470', '01', '1972-05-22', 'Cesar, La Jagua de Ibirico', 'O+', 'BACHILLER ACADEMICO', 'No Aplica', 'NO', '599270014', 'BANCO DE BOGOTA', 'NUEVA EPS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(114, 'SAENZ DIAZ KARIN MARCELA', '1064115930', 48, 3, 7, '3173303738', 'Transversal 4 N° 3 - 03 Brr La Florida', 'karinmarcelas@gmail.com', '2022-11-01', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 30, 'soltero', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'provisionalidad', 'TECNICO', 1863360.00, 'Decreto 00151', '2022-11-01', '2951', '2022-11-01', '2 años, 8 meses', '306', '01', '1994-11-06', 'Cesar, La Jagua de Ibirico', 'A+', 'ABOGADO', 'Si', 'NO', '599087038', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(115, 'SAENZ FUENTES MIRIAM', '36570588', 38, 3, 7, '3114178938', 'Transv 6 # 2 - 49', 'miriamsanezfuentes@hotmail.com', '2012-01-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 65, 'casado', 'catolico', 'tecnico', 'SECRETARIA EJECUTIVA', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'provisionalidad', 'ASISTENCIAL', 2775379.00, 'Decreto 00037', '2012-01-10', '1818', '2012-01-12', '13 años, 6 meses', '425', '04', '1960-05-16', 'Cesar, La Jagua de Ibirico', 'A+', 'SECRETARIA EJECUTIVA', 'No Aplica', 'NO', '4-2442200330-9', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 1, NULL),
(116, 'SALAZAR AVILA SONIA ROSA', '36571203', 60, 3, 1, '3106016235', 'Diagonal 1 No 2 - 54 Brr La Ye', 'sonisalazar8@hotmail.com', '2022-06-28', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 55, 'casado', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 5095929.00, 'Resolucion 00540', '2022-06-28', '2923', '2022-06-28', '3 años', '202', '02', '1969-12-24', 'Cesar, La Jagua de Ibirico', 'AB+', 'ABOGADO', 'No', 'ESP. EN DERECHO ADMINISTRATIVO', '599269347', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(117, 'SANCHEZ ESCORCIA THAIS BEATRIZ', '39056847', 50, 11, 2, '3106362712', 'CALLE 5 # 6 30', 'thaysanz@hotmail.com', '2025-02-03', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 46, 'casado', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Magdalena, Ciénaga', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00032', '2025-01-31', '4881', '2025-02-03', '5 meses', '020', '01', '1979-02-11', 'Magdalena, Ciénaga', 'O+', 'CONTADOR PUBLICO', 'Si', 'ESPECIALISTA EN GESTION PUBLICA', '42442007231-1', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(118, 'SANCHEZ USMA IRIS DANIELA', '1064111427', 63, 12, 1, '3218594255', 'MZ 5 CASA 1-159 URB. ALTOS DE LA MINA', 'isasancheusma@hotmail.com', '2019-04-25', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 34, 'union libre', 'catolico', 'Profesional', 'PSICOLOGO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Decreto 00093', '2019-04-24', '2664', '2019-04-25', '6 años, 2 meses', '219', '01', '1990-12-05', 'Cesar, La Jagua de Ibirico', 'O+', 'PSICOLOGO', 'No', 'NO', '599270204', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(119, 'SANTOS SOSA MAHER', '1064117224', 50, 9, 2, '3205188915', 'CALLE 3A N° 4-109', 'mahersantossosa@gmail.com', '2024-12-06', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 29, 'soltero', 'catolico', 'Profesional', 'ARQUITECTO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00182', '2024-12-05', '4067', '2024-12-06', '7 meses', '020', '01', '1995-09-09', 'Cesar, Pailitas', 'O+', 'ARQUITECTO', 'Si', 'ESPECIALISTA EN ALTA GERENCIA', '48349663751', 'BANCOLOMBIA', 'SANITAS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(120, 'SEGUANES RANGEL SARA ESTHER', '49696825', 38, 4, 1, '3116348653', 'DIAGONAL 5 1B 05 B GALAN', 'sarestherseguanes@hotmail.com', '2023-05-25', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 45, 'casado', 'catolico', 'tecnologo', 'ANALISIS Y DESARROLLO DE SISTEMAS DE INFORMACION', NULL, 1, 0, 'Cesar, Agustín Codazzi', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00427', '2023-05-03', '3033', '2023-05-25', '2 años, 1 mes', '425', '04', '1980-01-10', 'Cesar, Agustín Codazzi', 'O+', 'ANALISIS Y DESARROLLO DE SISTEMAS DE INFORMACION', 'No Aplica', 'NO', '424420096997', 'BANCO AGRARIO', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(121, 'TAMAYO ARGOTE OSMEIRY', '32794032', 41, 3, 1, '3235126380', 'Calle 7A # 4-72', 'tamayoargoteosmeiry@gmail.com', '2023-05-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 50, 'viudo', 'catolico', 'tecnico', 'PREESCOLAR Y ATENCION A LA PRIMERA INFANCIA', NULL, 1, 0, 'Atlántico, Barranquilla', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00419', '2023-05-03', '3030', '2023-05-23', '2 años, 1 mes', '407', '02', '1975-02-15', 'Atlántico, Barranquilla', 'A+', 'PREESCOLAR Y ATENCION A LA PRIMERA INFANCIA', 'No Aplica', 'NO', '599027166', 'BANCO DE BOGOTA', 'NUEVA EPS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(122, 'TELLEZ RANGEL YASMER', '1003038374', 3, 3, 1, '3218975568', 'CALLE 9 # 2-92 La victoria de San Isidro', 'yasmertellez@gmail.com', '2023-05-12', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 29, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR DE EMPRESAS', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00405', '2023-05-03', '3000', '2023-05-12', '2 años, 2 meses', '367', '03', '1996-04-21', 'Cesar, Becerril', 'A+', 'ADMINISTRADOR DE EMPRESAS', 'No', 'NO', '91252204984', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(123, 'TRILLO JACOME LUIS FRANKLIN', '13175770', 46, 6, 1, '3506602042', 'CALLE 3 N° 7-23 B TOSCANO', 'ftjacome31@gmail.com', '2024-12-03', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 41, 'casado', 'catolico', 'Profesional', 'AGRONOMO', NULL, 1, 0, 'Norte de Santander, Ocaña', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00944', '2024-07-22', '4066', '2024-12-03', '7 meses', '214', '03', '1983-09-14', 'Cesar, La Jagua de Ibirico', 'A+', 'AGRONOMO', 'No', 'NO', '52400003669', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 1, 0, 0, NULL),
(124, 'URECHE COBO MARIA DEL PILAR', '26988705', 54, 16, 2, '3136103375', 'CALLE 5 4 3', 'pilarurechecob@gmail.com', '2025-01-14', 0, '', 'femenino', 'BARRANCAS', 42, 'divorciado', 'catolico', 'Profesional', 'ABOGADO', NULL, 2, 0, 'La Guajira, Barrancas', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00008', '2025-01-14', '4076', '2025-01-14', '6 meses', '006', '01', '1982-10-12', 'La Guajira, Barrancas', 'B+', 'ABOGADO', 'No', 'ESPECIALISTA EN CONTRATACION ESTATAL', '599277738', 'BANCO DE BOGOTA', 'SANITAS', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, ''),
(125, 'VARGAS CERPA JEAN CARLOS', '1064121351', 41, 11, 1, '3114201187', 'transversal 1F 2A 03', 'jeancarlos90lbs@gmail.com', '2023-08-02', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 26, 'soltero', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'Si', 'carrera_administrativa', 'ASISTENCIAL', 1863226.00, 'Resolucion 00430', '2023-05-03', '3057', '2023-08-02', '1 año, 11 meses', '407', '02', '1998-08-23', 'Cesar, Valledupar', 'A+', 'CONTADOR PUBLICO', 'No', 'NO', '599269511', 'BANCO DE BOGOTA', 'COOSALUD', '', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(126, 'VASQUEZ GUARIN LILA ALEJANDRA', '52727729', 63, 7, 1, '3205717491', 'calle 8 #1D 12 B Camilo Torres', 'lilitav18@hotmail.com', '2023-05-23', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 43, 'soltero', 'catolico', 'Profesional', 'BACTERIOLOGA Y LABORATORISTA CLINICO', NULL, 1, 0, 'Bogotá, Bogotá D.C.', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolución 00375', '2023-04-27', '2394', '2023-05-23', '2 años, 1 mes', '237', '01', '1981-10-18', 'Cesar, La Jagua de Ibirico', 'O+', 'BACTERIOLOGA Y LABORATORISTA CLINICO', 'No', 'NO', '52445647764', 'BANCOLOMBIA', 'SALUD TOTAL', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(127, 'VASQUEZ GUARIN MARIA MAGDALENA', '52765647', 38, 10, 9, '3166410923', 'carrera 3 N° 12 79 Brr Paraiso', 'mmvasquezg.mmv@gmail.com', '2025-04-10', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 45, 'casado', 'catolico', 'Profesional', 'ADMINISTRADORA DE EMPRESAS', NULL, 1, 0, 'Bogotá, Bogotá D.C.', 'No Aplica', 'periodo_de_prueba', 'ASISTENCIAL', 2775379.00, 'Resolucion 00237', '2025-01-31', '4104', '2025-04-10', '3 meses', '425', '04', '1979-10-18', 'Cesar, La Jagua de Ibirico', 'O+', 'ADMINISTRADORA DE EMPRESAS', 'No', 'NO', '51323316787', 'BANCOLOMBIA', 'SALUD TOTAL', 'COLPENSIONES', 'COLPENCIONES', 'POSITIVA', 0, 0, 0, NULL),
(128, 'VASQUEZ ORTIZ YUZKENSY MILAGRO', '1064111810', 63, 3, 1, '3003234482', 'calle 7a No. 5-57 barrio ovelio Jimenez', 'kensi17@hotmail.com', '2016-01-22', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 34, 'soltero', 'catolico', 'Profesional', 'TRABAJADOR SOCIAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolución 00053', '2016-01-22', '2371', '2016-01-22', '9 años, 6 meses', '219', '01', '1991-05-11', 'Cesar, La Jagua de Ibirico', 'A+', 'TRABAJADOR SOCIAL', 'No', 'NO', '599269594', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 1, 0, NULL),
(129, 'VASQUEZ VIDES ANGEL VIVIANA', '1064113751', 65, 11, 1, '3118793330', 'Carrera 9 No. 6-09', 'anvivavi@gmail.com', '2023-07-13', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 32, 'soltero', 'catolico', 'Profesional', 'CONTADOR PUBLICO', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'PROFESIONAL', 4202612.00, 'Resolucion 00358', '2023-04-27', '3050', '2023-07-13', '2 años', '219', '01', '1993-05-23', 'Cesar, La Jagua de Ibirico', 'O+', 'CONTADOR PUBLICO', 'No', 'NO', '599269255', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'PORVENIR', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL),
(130, 'VERA MARTINEZ DORA ARGEMIRA', '36572346', 50, 4, 2, '3126210729', 'Manzana 6 casa 190 Urb Sosororia', 'doravr94@gmail.com', '2025-03-03', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 48, 'soltero', 'catolico', 'Profesional', 'LICENCIADO EN EDUCACION BASICA CON ENFASIS EN EDUCACION ARTISTICA', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00039', '2025-02-19', '4090', '2025-03-03', '4 meses', '020', '01', '1976-10-01', 'Cesar, Chiriguaná', 'O+', 'LICENCIADO EN EDUCACION BASICA CON ENFASIS EN EDUCACION ARTISTICA', 'No', 'ESP PEDAGOGIA DE LA LUDICA', '489289077', 'BBVA COLOMBIA', 'ASMETSALUD', '', '', 'POSITIVA', 0, 0, 0, NULL),
(131, 'VERA OSORIO CESAR ROLANDO', '88283325', 45, 5, 1, '3153719004', 'CRA 1c No. 3a-32', 'crvoss77@hotmail.com', '2023-06-27', 0, '', 'masculino', 'GONZALES', 48, 'casado', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Norte de Santander, Ocaña', 'Si', 'carrera_administrativa', 'TECNICO', 2825896.00, 'Resolucion 00379', '2023-04-27', '3045', '2023-06-27', '2 años', '312', '03', '1977-07-07', 'Cesar, González', 'O+', 'ADMINISTRADOR PUBLICO', 'No', 'NO', '31809961209', 'BANCOLOMBIA', 'SANITAS', 'COLPENSIONES', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(132, 'VILARDY ORTIZ LAID CAROLINA', '1065568790', 38, 3, 1, '3126774422', 'DIAGONAL 6 # 16-88 NUEVO MILENIO', 'lacavior3011@gmail.com', '2023-05-12', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 39, 'casado', 'catolico', 'tecnico', 'ASISTENCIA ADMINISTRATIVA', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'carrera_administrativa', 'ASISTENCIAL', 2775379.00, 'Resolucion 00422', '2023-05-03', '3008', '2023-05-12', '2 años, 2 meses', '425', '02', '1985-11-30', 'Cesar, Chiriguaná', 'O+', 'ASISTENCIA ADMINISTRATIVA', 'No Aplica', 'NO', '599269610', 'BANCO DE BOGOTA', 'SALUD TOTAL', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 1, 0, 0, NULL),
(133, 'ZULETA VEGA VERONICA', '1064115282', 50, 6, 2, '3218391342', 'Transversal 12 # 7 -14', 'zuleta_veronica@hotmail.com', '2025-03-13', 0, '', 'femenino', 'LA JAGUA DE IBIRICO', 31, 'soltero', 'catolico', 'Profesional', 'INGENIERA AMBIENTAL', NULL, 1, 0, 'Cesar, La Jagua de Ibirico', 'No Aplica', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00048', '2025-03-13', '4096', '2025-03-13', '4 meses', '020', '01', '1994-05-09', 'Cesar, Manaure', 'O+', 'INGENIERO AMBIENTAL', 'Si', 'ESPECIALISTA GESTION DE PROYECTOS', '91213852278', 'BANCOLOMBIA', 'SALUD TOTAL', 'PORVENIR', 'PORVENIR', 'POSITIVA', 0, 0, 0, NULL),
(134, 'EDGAR ISAAC BELEÑO QUIROZ', '85446119', 54, 16, 2, '3164066227', 'CALLE 6C N° 33 75', 'edgarabogado2001@gmail.com', '2025-07-31', 2, 'YISELL CAROLINA BELEÑO SAMBRANO, ISAAC DAVID BELEÑO SAMBRANO', 'masculino', 'VALLEDUPAR', 49, 'casado', 'catolico', 'Profesional', 'ABOGADO', NULL, 1, 0, 'Magdalena, Ariguaní', 'Si', 'libre_nombramiento', 'DIRECTIVO', 6400971.00, 'DECRET 00106', '2025-07-30', '4113', '2025-07-31', '23 días', '006', '01', '1975-11-02', 'Magdalena, Ariguaní', 'O+', 'ABOGADO', 'Si', 'ESPECIALISTA EN DERECHO PUBLICO', '51322860424', 'BANCOLOMBIA', 'SANITAS', 'COLFONDOS', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_herramientas`
--

CREATE TABLE `tbl_herramientas` (
  `id_herramienta` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_herramientas`
--

INSERT INTO `tbl_herramientas` (`id_herramienta`, `item`, `marca`, `disponibilidad`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(2, 'Kit de destornilladores', 'Generica', 'No Disponible', '2025-08-20 04:23:28', '2025-08-20 04:23:28', 1),
(3, 'Pulsera antiestática', 'Generica', 'No Disponible', '2025-08-20 04:23:53', '2025-08-20 04:23:53', 1),
(4, 'Pinzas de punta fina', 'Generica', 'No Disponible', '2025-08-20 04:24:14', '2025-08-20 04:24:14', 1),
(5, 'Multímetro', 'Generica', 'No Disponible', '2025-08-20 04:24:45', '2025-08-20 04:24:45', 1),
(6, 'Cautín y soldadura', 'Generica', 'Disponible', '2025-08-20 04:25:10', '2025-08-20 04:25:10', 1),
(7, 'Líquido de limpieza de cabezales', 'Generico', 'Disponible', '2025-08-20 04:25:43', '2025-08-20 04:25:43', 1),
(8, 'Alcohol isopropílico', 'Generica', 'No Disponible', '2025-08-20 04:26:15', '2025-08-20 04:26:15', 1),
(9, 'Brochas', 'Generico', 'No Disponible', '2025-08-20 04:26:44', '2025-08-20 04:26:44', 1),
(10, 'Paños de microfibra', 'Generico', 'No Disponible', '2025-08-20 04:27:04', '2025-08-20 04:27:04', 1),
(11, 'Aire comprimido o soplador', 'Generico', 'No Disponible', '2025-08-20 04:27:32', '2025-08-20 04:27:32', 1),
(12, 'Aspiradora de mano', 'Generico', 'No Disponible', '2025-08-20 04:28:57', '2025-08-20 04:28:57', 1),
(13, 'Espuma limpiadora', 'Generico', 'No Disponible', '2025-08-20 04:29:34', '2025-08-20 04:29:34', 1),
(14, 'Hojas de limpieza', 'Generico', 'No Disponible', '2025-08-20 04:30:06', '2025-08-20 04:30:06', 1);

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
(23, 73, '2025-07-28', 7, 2025, 'Dia del cumpleaños', 'Aprobado', '2025-07-22 15:54:31', 'planta', 0, ''),
(24, 131, '2025-08-08', 8, 2025, 'Dia del cumpleaños', 'Aprobado', '2025-07-22 15:55:42', 'planta', 0, ''),
(25, 108, '2025-07-25', 7, 2025, 'Dia de la Familia', 'Aprobado', '2025-07-23 11:34:51', 'planta', 0, ''),
(26, 36, '2025-07-25', 7, 2025, 'Dia de la Familia', 'Aprobado', '2025-07-23 11:35:17', 'planta', 0, ''),
(27, 119, '2025-07-25', 7, 2025, 'Diligencias personales', 'Aprobado', '2025-07-23 11:41:36', 'planta', 0, ''),
(28, 51, '2025-07-28', 7, 2025, 'Diligencias personales', 'Aprobado', '2025-07-23 11:44:16', 'planta', 0, ''),
(29, 58, '2025-08-01', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-23 11:44:56', 'planta', 0, ''),
(30, 109, '2025-08-15', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-28 10:12:38', 'planta', 0, ''),
(31, 41, '2025-08-08', 8, 2025, 'Dia de la Familia', 'Aprobado', '2025-07-28 10:13:06', 'planta', 0, ''),
(32, 83, '2025-07-29', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-28 10:14:32', 'planta', 0, ''),
(33, 105, '2025-08-18', 8, 2025, 'Dia de la Familia', 'Aprobado', '2025-07-28 10:15:17', 'planta', 0, ''),
(34, 26, '2025-08-01', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-29 09:08:00', 'planta', 0, ''),
(35, 71, '2025-08-12', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-29 09:10:23', 'planta', 0, ''),
(36, 71, '2025-08-13', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-29 09:10:47', 'planta', 0, ''),
(37, 87, '2025-08-14', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-29 09:13:27', 'planta', 0, ''),
(38, 87, '2025-08-15', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-29 09:13:45', 'planta', 0, ''),
(39, 87, '2025-08-19', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-07-29 09:14:01', 'planta', 0, ''),
(40, 29, '2025-08-06', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-29 09:24:56', 'planta', 0, ''),
(41, 29, '2025-08-08', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-29 09:25:15', 'planta', 0, ''),
(42, 109, '2025-08-06', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-29 09:30:04', 'planta', 0, ''),
(43, 38, '2025-07-30', 7, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', '2025-07-29 09:54:12', 'planta', 0, ''),
(44, 24, '2025-08-01', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-29 10:03:01', 'planta', 0, ''),
(45, 57, '2025-08-15', 8, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', '2025-07-31 17:23:05', 'planta', 0, ''),
(46, 57, '2025-09-23', 9, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', '2025-07-31 17:23:30', 'planta', 0, ''),
(47, 84, '2025-08-04', 8, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', '2025-07-31 17:25:44', 'planta', 0, ''),
(48, 77, '2025-08-08', 8, 2025, 'Cita médica', 'Aprobado', '2025-07-31 17:26:11', 'planta', 0, ''),
(49, 61, '2025-08-08', 8, 2025, 'Dia del cumpleaños', 'Aprobado', '2025-07-31 17:26:57', 'planta', 0, ''),
(50, 38, '2025-07-31', 7, 2025, 'Emergencia familiar', 'Aprobado', '2025-07-31 17:27:32', 'planta', 0, ''),
(51, 38, '2025-08-01', 8, 2025, 'Emergencia familiar', 'Aprobado', '2025-07-31 17:31:02', 'planta', 0, ''),
(52, 121, '2025-07-31', 7, 2025, 'Diligencias personales', 'Aprobado', '2025-07-31 17:33:17', 'planta', 0, ''),
(53, 56, '2025-08-14', 8, 2025, 'Gestión académica', 'Aprobado', '2025-08-05 09:24:40', 'planta', 0, ''),
(54, 101, '2025-08-11', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-06 14:52:59', 'planta', 0, ''),
(55, 72, '2025-08-11', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-08 09:41:06', 'planta', 0, ''),
(56, 121, '2025-08-15', 8, 2025, 'Dia de la Familia', 'Aprobado', '2025-08-08 09:41:36', 'planta', 0, ''),
(57, 120, '2025-08-22', 8, 2025, 'Dia de la Familia', 'Aprobado', '2025-08-08 11:40:09', 'planta', 0, ''),
(58, 80, '2025-08-15', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-08-11 10:47:51', 'planta', 0, ''),
(59, 93, '2025-08-12', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-11 10:49:12', 'planta', 0, ''),
(60, 101, '2025-08-19', 8, 2025, 'Dia de la Familia', 'Aprobado', '2025-08-12 09:44:30', 'planta', 0, ''),
(61, 86, '2025-08-19', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-08-15 11:09:20', 'planta', 0, ''),
(62, 109, '2025-09-23', 9, 2025, 'Cita médica', 'Aprobado', '2025-08-15 11:12:12', 'planta', 0, ''),
(63, 107, '2025-08-20', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-15 11:13:12', 'planta', 0, ''),
(64, 78, '2025-08-19', 8, 2025, 'Trámites bancarios', 'Aprobado', '2025-08-15 11:14:05', 'planta', 0, ''),
(65, 78, '2025-08-20', 8, 2025, 'Trámites bancarios', 'Aprobado', '2025-08-15 11:14:36', 'planta', 0, ''),
(66, 78, '2025-08-21', 8, 2025, 'Gestión académica', 'Aprobado', '2025-08-15 11:15:21', 'planta', 0, ''),
(67, 83, '2025-08-21', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-08-20 11:09:49', 'planta', 0, ''),
(68, 112, '2025-09-06', 9, 2025, 'Dia de la Familia', 'Aprobado', '2025-08-20 11:14:07', 'planta', 0, ''),
(69, 63, '2025-08-22', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-22 10:14:56', 'planta', 0, ''),
(70, 73, '2025-08-22', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-08-22 10:15:37', 'planta', 0, ''),
(71, 39, '2025-08-25', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-22 10:16:28', 'planta', 0, ''),
(72, 113, '2025-08-26', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-22 10:17:07', 'planta', 0, ''),
(73, 121, '2025-08-26', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-22 10:17:29', 'planta', 0, ''),
(74, 25, '2025-08-29', 8, 2025, 'Diligencias personales', 'Aprobado', '2025-08-27 09:57:44', 'planta', 0, ''),
(75, 76, '2025-08-28', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-27 09:58:28', 'planta', 0, ''),
(76, 49, '2025-08-27', 8, 2025, 'Emergencia familiar', 'Aprobado', '2025-08-27 09:59:24', 'planta', 0, ''),
(77, 60, '2025-08-27', 8, 2025, 'Cita médica', 'Aprobado', '2025-08-27 10:01:08', 'planta', 0, ''),
(78, 55, '2025-09-01', 9, 2025, 'Cita médica', 'Aprobado', '2025-08-27 10:01:31', 'planta', 0, ''),
(79, 55, '2025-09-02', 9, 2025, 'Dia del cumpleaños', 'Aprobado', '2025-08-27 10:01:47', 'planta', 0, ''),
(80, 55, '2025-09-03', 9, 2025, 'Dia de la Familia', 'Aprobado', '2025-08-27 10:02:10', 'planta', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_impresoras`
--

CREATE TABLE `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL,
  `numero_impresora` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `consumible` varchar(200) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malo','De Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_dano` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo',
  `fecha_baja` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_impresoras`
--

INSERT INTO `tbl_impresoras` (`id_impresora`, `numero_impresora`, `marca`, `modelo`, `serial`, `consumible`, `estado`, `disponibilidad`, `fecha_dano`, `fecha_baja`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(11, 'IMP-1', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H7582LJW', '83A', 'Regular', 'No Disponible', NULL, NULL, '2025-08-01 14:58:54', '2025-08-20 04:04:13', 0),
(12, 'IMP-1', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H7582LJW', '83A', 'Regular', 'No Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-20 04:03:55', 1),
(13, 'IMP-2', 'RICOH', 'Aficio MP 305+SP', 'G582P350295', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(14, 'IMP-4', 'SAMSUNG', 'Xpress SL-M2070FW', '073YB8KG1A000GT', 'MLT-D111S', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(15, 'IMP-7', 'EPSON', 'EcoTank L5190', 'X5NQ139873', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:28:29', 1),
(16, 'IMP-10', 'RICOH', 'Aficio MP 305+SP', 'G581PB50010', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(17, 'IMP-15', 'HP', 'LaserJet Pro M203dw', 'VNB5DD1188', '30A', 'Regular', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(18, 'IMP-16', 'RICOH', 'Aficio MP 305+SP', 'G581EPBS0016', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(19, 'IMP-17', 'HP', 'LaserJet Pro M203dw', 'VNB5D11429', '30A', 'Regular', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(20, 'IMP-22', 'RICOH', 'Aficio MP 305+SP', 'G582P350016', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(21, 'IMP-24', 'RICOH', 'Aficio MP 305+SP', 'G582P350012', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(22, 'IMP-26', 'EPSON', 'EcoTank L6490', 'X94Z000993', 'TINTA', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(23, 'IMP-27', 'HP', 'LaserJet Pro M203dw', 'VND3B28504', '30A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(24, 'IMP-28', 'HP', 'LaserJet Pro M201dw', 'VNB3F10071', '83A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(25, 'IMP-30', 'HP', 'Lasert Jet Pro MFP M428Fdw', 'CNDRPBY352', '58X - CF258X', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(26, 'IMP-31', 'RICOH', 'Aficio MP 305+SP', 'G582P350284', 'MP305', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(27, 'IMP-32', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H280H5', '83A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(28, 'IMP-35', 'EPSON', 'EcoTank L6490', 'X94Z001039', 'TINTA', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(29, 'IMP-36', 'HP', 'LaserJet Pro P1102', 'VND3T00859', '85A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(30, 'IMP-38', 'HP', 'LaserJet Pro M521dn', 'CNCKL1N325', '55A-X', 'Malo', 'No Disponible', '2025-08-04', NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(31, 'IMP-41', 'HP', 'LaserJet Pro MFP M127fn', 'SNB9G42633', '83A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(32, 'IMP-42', 'HP', 'LaserJet 500 MFP M525', 'MXFCH6L0D2', 'CE255X', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(33, 'IMP-43', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H58LHW', '83A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(34, 'IMP-48', 'HP', 'Laserjet Enterprise Mfp M630', 'MXBCM2237', 'CF281A - 81AX', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(35, 'IMP-50', 'EPSON', 'EcoTank L3210', 'XAGB487365', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:26:58', 1),
(36, 'IMP-51', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H3W0BV', '83A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(37, 'IMP-52', 'HP', 'LaserJet Pro MFP M227fdw', 'WNG3210797', '230A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-20 03:52:34', 1),
(38, 'IMP-54', 'HP', 'LaserJet Pro M125a MFP', 'CNB6H3W65K', '83A', 'Malo', 'No Disponible', '2025-08-04', NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(39, 'IMP-55', 'EPSON', 'EcoTank L3110', 'X644509645', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:27:18', 1),
(40, 'IMP-56', 'EPSON', 'EcoTank L3110', 'XAGB352710', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:27:28', 1),
(41, 'IMP-57', 'EPSON', 'EcoTank L3110', 'X644507809', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:27:45', 1),
(42, 'IMP-63', 'HP', 'Color LaserJet Pro M454dw', 'VNB3D23979', 'W2022XC AM- MG-CIAN-NEGRO', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(43, 'IMP-64', 'HP', 'LaserJet Pro M127a MFP', 'CNB9G42633', '83A', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-20 13:52:28', 1),
(44, 'IMP-65', 'KYOCERA', 'Ecosys MA4500 IFX', 'WDE3802748', 'TK-3402', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(45, 'IMP-66', 'EPSON', 'EcoTank L3210', 'XAGB352835', 'Tinta Epson T544', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:28:14', 1),
(46, 'IMP-67', 'HP', 'LaserJet Pro M203dw', 'VNB5D11419', '30A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(47, 'IMP-68', 'HP', 'LaserJet Pro M203dw', 'VNB5D59434', '30A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(48, 'IMP-69', 'CANON', 'Pixma G4170 Megatank', 'KPJT02303', 'TINTA', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(49, 'IMP-70', 'CANON', 'Pixma G4170 Megatank', 'KPJT02058', 'TINTA', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(50, 'IMP-71', 'CANON', 'Pixma G4170 Megatank', 'KPJT01495', 'TINTA', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(51, 'IMP-72', 'HP', 'Laser MFP 137fnw', 'CNB2N46M1G', '105A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(52, 'IMP-73', 'HP', 'LaserJet Pro 400 MFP M425dn', '', '05A - 80A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-04 14:01:29', 1),
(53, 'IMP-74', 'Brother', 'DCP-T710W', '', 'Tinta Brother BTD60 y BT5001', 'Bueno', 'Disponible', NULL, NULL, '2025-08-04 14:01:29', '2025-08-06 19:31:02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mantenimientos_equipos`
--

CREATE TABLE `tbl_mantenimientos_equipos` (
  `id_mantenimiento` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `tipo_equipo` varchar(50) NOT NULL,
  `fecha_mantenimiento` date NOT NULL,
  `estacion_trabajo` varchar(100) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `cedula_usuario` varchar(20) NOT NULL,
  `tipo_dispositivo` varchar(50) NOT NULL,
  `error_reportado` text NOT NULL,
  `acciones_realizadas` text NOT NULL,
  `tecnico_servicio` varchar(100) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_mantenimientos_equipos`
--

INSERT INTO `tbl_mantenimientos_equipos` (`id_mantenimiento`, `id_equipo`, `tipo_equipo`, `fecha_mantenimiento`, `estacion_trabajo`, `nombre_usuario`, `cedula_usuario`, `tipo_dispositivo`, `error_reportado`, `acciones_realizadas`, `tecnico_servicio`, `fecha_registro`, `status`) VALUES
(5, 23, 'Todo en Uno', '2025-08-11', 'Almacen', 'Mariela Lopez', '1036989', 'Todo en Uno', 'Estrello el computador', 'Le partí la mesa en la cabeza', 'Elías Iguaran Márquez', '2025-08-11 10:10:28', 1),
(6, 43, 'Impresora', '2025-08-20', 'Secretaría de Gobierno', 'LAID VILARDY ORTIZ', '1065568790', 'Impresora', 'SOLICITAN CAMBIO DE TONER POR FALLAS CON EL ACTUAL LUEGO DE LA RECARGA DE ESTE.', 'SE REALIZA EL CAMBIO DE TONER, LA IMPRESORA QUEDA EN TOTAL FUNCIONAMIENTO.', 'Elías Iguaran Márquez', '2025-08-20 09:01:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_motivos_permisos`
--

CREATE TABLE `tbl_motivos_permisos` (
  `id_motivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_motivos_permisos`
--

INSERT INTO `tbl_motivos_permisos` (`id_motivo`, `nombre`, `descripcion`, `status`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Cita médica', 'Permiso para asistir a cita médica personal', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(2, 'Diligencias personales', 'Permiso para realizar diligencias de carácter personal', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(3, 'Emergencia familiar', 'Permiso por emergencia o situación familiar urgente', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(4, 'Trámites bancarios', 'Permiso para realizar trámites en entidades bancarias', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(5, 'Cita odontológica', 'Permiso para asistir a cita odontológica', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(6, 'Gestión académica', 'Permiso para asuntos relacionados con estudios', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15'),
(8, 'Dia del cumpleaños', 'Permiso compensatorio por el día del cumpleaños', 1, '2025-07-22 20:51:55', '2025-07-23 16:33:13'),
(9, 'Dia de la Familia', 'Permiso compensatorio por el día de la familia', 1, '2025-07-23 16:32:05', '2025-07-23 16:33:37'),
(10, 'Acompañamiento a familiar en exámenes médicos', 'Permiso para acompañar a familiar', 1, '2025-07-29 14:53:24', '2025-07-29 14:53:24');

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

--
-- Volcado de datos para la tabla `tbl_notificaciones`
--

INSERT INTO `tbl_notificaciones` (`id_notificacion`, `id_funcionario`, `tipo`, `mensaje`, `fecha_creacion`, `leido`, `tipo_funcionario`) VALUES
(52, 22, 'tarea', 'Se te ha asignado una nueva tarea: Diligenciar los formatos f20_cgdc del SIA Contraloria Departamental para reportarlo', '2025-07-17 08:58:06', 0, 'planta'),
(53, 25, 'tarea', 'Se te ha asignado una nueva tarea: Diligenciar los formatos f20_cgdc del SIA Contraloria Departamental para reportarlo', '2025-07-17 08:58:06', 0, 'planta'),
(55, 22, 'tarea', 'Se te ha asignado una nueva tarea: reporte del SIA CONTRALORÍAS - Primer semestre, seguimiento con control interno de gestión', '2025-07-17 08:59:01', 0, 'planta'),
(56, 25, 'tarea', 'Se te ha asignado una nueva tarea: reporte del SIA CONTRALORÍAS - Primer semestre, seguimiento con control interno de gestión', '2025-07-17 08:59:01', 0, 'planta');

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
(16, 28, 1, 'Este formato diligenciado lo envía la oficina de control interno de gestión', '2025-07-10 20:55:37'),
(17, 29, 1, 'Los formatos para diligenciar fueron enviados a control interno el 2 de julio 2025', '2025-07-10 21:03:20'),
(18, 27, 22, 'La Publicación de los reportes se realizaron satisfactoria mente y se enviaron los soportes por correo electrónico.', '2025-07-10 21:52:15'),
(19, 30, 25, 'Me permito informar que se notificó oportunamente a las diferentes Secretarías de la Alcaldía sobre el envío del informe correspondiente al Sistema de Información Administrativa (SIA).', '2025-07-17 20:29:45'),
(20, 29, 25, 'Me permito informar que se notificó oportunamente a las diferentes Secretarías de la Alcaldía sobre el envío del informe correspondiente al Sistema de Información Administrativa (SIA).', '2025-07-17 20:30:42'),
(21, 28, 25, 'Se informo al reponsable de esta informacion, LUIS CARLOS DAZA, y comenta que entre hoy y mañana envia la la informacion', '2025-07-17 20:35:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_papeleria`
--

CREATE TABLE `tbl_papeleria` (
  `id_papeleria` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `disponibilidad` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_papeleria`
--

INSERT INTO `tbl_papeleria` (`id_papeleria`, `item`, `disponibilidad`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(3, 'Resma Oficio', 9, '2025-08-20 04:07:41', '2025-08-20 04:07:41', 1),
(4, 'Resma Carta', 5, '2025-08-20 04:07:55', '2025-08-20 04:07:55', 1),
(5, 'Lapiceros Nunca Hay', 1, '2025-08-20 04:18:42', '2025-08-20 04:18:42', 1),
(6, 'Caja de Clips', 6, '2025-08-20 04:19:02', '2025-08-20 04:19:02', 1),
(7, 'Lápices', 1, '2025-08-20 04:31:31', '2025-08-20 04:31:31', 1),
(8, 'Marcadores', 5, '2025-08-20 04:31:52', '2025-08-20 04:31:52', 1),
(9, 'Resaltadores', 2, '2025-08-20 04:32:08', '2025-08-20 04:32:08', 1),
(10, 'Correctores', 1, '2025-08-20 04:32:20', '2025-08-20 04:32:20', 1),
(11, 'Sacapuntas', 2, '2025-08-20 04:32:31', '2025-08-20 04:32:31', 1),
(12, 'Borradores', 2, '2025-08-20 04:32:48', '2025-08-20 04:32:48', 1),
(13, 'Sobres', 25, '2025-08-20 04:33:08', '2025-08-20 04:33:08', 1),
(14, 'Grapas', 6, '2025-08-20 04:33:37', '2025-08-20 04:33:37', 1),
(15, 'Grapadora', 1, '2025-08-20 04:33:57', '2025-08-20 04:33:57', 1),
(16, 'Carpetas', 15, '2025-08-20 04:34:21', '2025-08-20 04:34:21', 1),
(17, 'Borrador de pizarra', 1, '2025-08-20 04:34:57', '2025-08-20 04:34:57', 1),
(18, 'Tableros', 2, '2025-08-20 04:35:55', '2025-08-20 04:35:55', 1),
(19, 'Perforadora de papel', 1, '2025-08-20 04:36:38', '2025-08-20 04:36:38', 1),
(20, 'Tijeras', 1, '2025-08-20 04:36:55', '2025-08-20 04:36:55', 1),
(21, 'Planilleros', 7, '2025-08-20 04:40:11', '2025-08-20 04:40:11', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pc_torre`
--

CREATE TABLE `tbl_pc_torre` (
  `id_pc_torre` int(11) NOT NULL,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `monitor` varchar(100) DEFAULT NULL,
  `numero_activo_monitor` varchar(100) DEFAULT NULL,
  `serial_monitor` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malo','De Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_dano` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo',
  `fecha_baja` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_pc_torre`
--

INSERT INTO `tbl_pc_torre` (`id_pc_torre`, `numero_pc`, `marca`, `serial`, `modelo`, `ram`, `velocidad_ram`, `procesador`, `velocidad_procesador`, `disco_duro`, `capacidad`, `sistema_operativo`, `numero_activo`, `monitor`, `numero_activo_monitor`, `serial_monitor`, `estado`, `disponibilidad`, `fecha_dano`, `fecha_baja`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(5, 'PC-123', 'Dell', '9Q5JPY2', 'Vostro 3470', '4 GB', '2400 Mhz', 'Intel(R) Core(TM) i5-9400', '2.90 GHz', 'HDD', '1 TB', 'Windows 10 Pro', '', 'LG', '', '', 'Regular', 'No Disponible', NULL, NULL, '2025-08-01 14:54:38', '2025-08-01 14:54:38', 1),
(6, 'PC-2', 'HP', 'MX2526001L', '', '8GB', '', 'Intel Xeon', '', 'HDD', '', 'WIN10', '', 'LENOVO', '', '1588-6782', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(7, 'PC-3', 'COMPUMAX', 'BRC41748R6', '', '8GB', '', 'Intel Xeon', '', 'HDD', '', 'WIN10', '', 'SAMSUNG', '', '04GYHCHN801617N', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(8, 'PC-4', 'COMPUMAX', '300SN49398', '', '4GB', '', 'Intel Core I5', '', 'HDD', '', 'WIN10', '', 'JANUS', '', 'J2213LE13050104857', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(9, 'PC-7', 'JANUS', 'N/A', '', '4GB', '', 'Pentium', '', 'HDD', '', 'WIN10', '', 'LG', '', '901NTHMSX249', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(10, 'PC-10', 'COMPUMAX', 'ES07619390', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'HP', '', '50210NBUS073', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(11, 'PC-11', 'LENOVO', 'S02NDMJ59079', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'LG', '', '209SN09423', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(12, 'PC-17', 'COMPUMAX', '102SN12521', '', '4GB', '', 'Pentium', '', 'HDD', '', 'WIN10', '', 'JANUS', '', 'J2213LE305010526', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(13, 'PC-20', 'COMPUMAX', 'N/A', '', '4GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'LG', '', '404DNBES639', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(14, 'PC-29', 'JANUS', '102SN30347', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'COMPUMAX', '', '102SN30324', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(15, 'PC-31', 'COMPUMAX', '2020CMHT7032047', '', '4GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'SAMSUNG', '', '045YHN6020D', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(16, 'PC-35', 'JANUS', 'N/A', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'SAMSUNG', '', 'VS-09A476', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(17, 'PC-39', 'LENOVO', 'MJ0H4JQ7', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'LENOVO', '', 'CN-0HN22V-FCC004M-AY6B-A07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(18, 'PC-45', 'COMPUMAX', '102SN3857', '', '4GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'DELL', '', '303NDJWHS719', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(19, 'PC-46', 'DELL', '102SN3857', '', '4GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'LG', '', '04GYCHN8016Z', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(20, 'PC-48', 'COMPUMAX', '102SN30381', '', '8GB', '', 'Intel Core i5', '', 'SSD', '', 'WIN10', '', 'SAMSUNG', '', 'J2015LE670302673', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(21, 'PC-49', 'JANUS', 'N/A', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'JANUS', '', 'J2213LE305010175', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(22, 'PC-50', 'COMPUMAX', '200SN69057', '', '8GB', '', 'Pentium', '', 'HDD', '', 'WIN10', '', 'JANUS', '', 'cn-0kn22b-fcc00-973-apb-a07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(23, 'PC-52', 'COMPUMAX', 'N/A', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'DELL', '', '279bcn86002ae', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(24, 'PC-53', 'COMPUMAX', '102SN30332', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'SAMSUNG', '', '04gyhcn80163w', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(25, 'PC-56', 'COMPUMAX', '102SN12522', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'N/A', '', '901nthm759', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(26, 'PC-57', 'COMPUMAX', '101SN00877', '', '8GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'LG', '', '2020CMHT7032063', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(27, 'PC-59', 'COMPUMAX', '200SN6989', '', '8GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'COMPUMAX', '', 'cn-0hn22v-fcc00-35p-ac3b-a07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(28, 'PC-62', 'COMPUMAX', '300SN34397', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'DELL', '', 'UKX314J0059a', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(29, 'PC-63', 'COMPUMAX', '102SN30358', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'viewsonic', '', '412NDNX24589', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(30, 'PC-67', 'DELL', '9q7spq2', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN7', '', 'DELL', '', '412NDNX24583', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(31, 'PC-69', 'COMPUMAX', '102SN30394', '', '8GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'LG', '', 'J2213LE305010231', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(32, 'PC-70', 'COMPUMAX', '200SN66711', '', '8GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'LG', '', 'sn-0kn22b-fcc00-95p-ec4b-a07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(33, 'PC-73', 'COMPUMAX', '200SN86713', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'JANUS', '', '103021475', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(34, 'PC-74', 'DELL', '300SN58746', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'DELL', '', 'COM2020CMHT7031570', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(35, 'PC-81', 'COMPUMAX', '9u514t2', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'DELL', '', 'CN-0HL22V-FCC00-95P-CJ2B-07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(36, 'PC-85', 'COMPUMAX', '102SN30327', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'COMPUMAX', '', 'COM2020CMHT7032486', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(37, 'PC-100', 'HP', '4CE5932327', 'Generico', '8GB', '', 'Intel Core i5', '', 'SSD', '240 GB', 'WIN10', '', 'DELL', '', 'J2213LE305010', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 19:55:22', 1),
(38, 'PC-100', 'DELL', 'N/A', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'HP', '', 'N/A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(39, 'PC-103', 'COMPUMAX', '102SN30352', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'DELL', '', '901nthm523', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(40, 'PC-105', 'DELL', '9q4lt42', '', '8GB', '', 'Intel Core i7', '', 'HDD', '', 'WIN10', '', 'DELL', '', 'COM2020CMHT7031570', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(41, 'PC-106', 'COMPUMAX', 'N/A', '', '8GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'COMPUMAX', '', 'CN-0HL22V-FCC00-95P-CJ2B-07', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(42, 'PC-107', 'COMPUMAX', '102SN30339', '', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'WIN10', '', 'COMPUMAX', '', 'COM2020CMHT7032486', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(43, 'PC-111', 'JANUS', '9J5JFY2', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'LG', '', 'N/A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1),
(44, 'PC-123', 'DELL', '102SN12561', '', '4GB', '', 'Intel Core i5', '', 'HDD', '', 'WIN10', '', 'LG', '', 'N/A', 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:09:56', '2025-08-27 05:09:56', 1);

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
(54, 73, '2025-07-28', 7, 2025, 'Dia del cumpleaños', 'Aprobado', 'planta', 0, '', '2025-07-22 15:54:31'),
(55, 131, '2025-08-08', 8, 2025, 'Dia del cumpleaños', 'Aprobado', 'planta', 0, '', '2025-07-22 15:55:42'),
(56, 108, '2025-07-25', 7, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-07-23 11:34:51'),
(57, 36, '2025-07-25', 7, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-07-23 11:35:17'),
(58, 119, '2025-07-25', 7, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-23 11:41:36'),
(59, 51, '2025-07-28', 7, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-23 11:44:16'),
(60, 58, '2025-08-01', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-23 11:44:56'),
(61, 109, '2025-08-15', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-28 10:12:38'),
(62, 41, '2025-08-08', 8, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-07-28 10:13:06'),
(63, 83, '2025-07-29', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-28 10:14:32'),
(64, 105, '2025-08-18', 8, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-07-28 10:15:17'),
(65, 26, '2025-08-01', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-29 09:08:00'),
(66, 71, '2025-08-12', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-29 09:10:23'),
(67, 71, '2025-08-13', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-29 09:10:47'),
(68, 87, '2025-08-14', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-29 09:13:27'),
(69, 87, '2025-08-15', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-29 09:13:45'),
(70, 87, '2025-08-19', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-29 09:14:01'),
(71, 29, '2025-08-06', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-29 09:24:56'),
(72, 29, '2025-08-08', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-29 09:25:15'),
(73, 109, '2025-08-06', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-29 09:30:04'),
(74, 38, '2025-07-30', 7, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', 'planta', 0, '', '2025-07-29 09:54:12'),
(75, 24, '2025-08-01', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-29 10:03:01'),
(76, 57, '2025-08-15', 8, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', 'planta', 0, '', '2025-07-31 17:23:05'),
(77, 57, '2025-09-23', 9, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', 'planta', 0, '', '2025-07-31 17:23:30'),
(78, 84, '2025-08-04', 8, 2025, 'Acompañamiento a familiar en exámenes médicos', 'Aprobado', 'planta', 0, '', '2025-07-31 17:25:44'),
(79, 77, '2025-08-08', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-31 17:26:11'),
(80, 61, '2025-08-08', 8, 2025, 'Dia del cumpleaños', 'Aprobado', 'planta', 0, '', '2025-07-31 17:26:57'),
(81, 38, '2025-07-31', 7, 2025, 'Emergencia familiar', 'Aprobado', 'planta', 0, '', '2025-07-31 17:27:32'),
(82, 38, '2025-08-01', 8, 2025, 'Emergencia familiar', 'Aprobado', 'planta', 0, '', '2025-07-31 17:31:02'),
(83, 121, '2025-07-31', 7, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-07-31 17:33:17'),
(84, 56, '2025-08-14', 8, 2025, 'Gestión académica', 'Aprobado', 'planta', 0, '', '2025-08-05 09:24:40'),
(85, 101, '2025-08-11', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-06 14:52:59'),
(86, 72, '2025-08-11', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-08 09:41:06'),
(87, 121, '2025-08-15', 8, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-08-08 09:41:36'),
(88, 120, '2025-08-22', 8, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-08-08 11:40:09'),
(89, 80, '2025-08-15', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-08-11 10:47:51'),
(90, 93, '2025-08-12', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-11 10:49:12'),
(91, 101, '2025-08-19', 8, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-08-12 09:44:30'),
(92, 86, '2025-08-19', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-08-15 11:09:20'),
(93, 109, '2025-09-23', 9, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-15 11:12:12'),
(94, 107, '2025-08-20', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-15 11:13:12'),
(95, 78, '2025-08-19', 8, 2025, 'Trámites bancarios', 'Aprobado', 'planta', 0, '', '2025-08-15 11:14:05'),
(96, 78, '2025-08-20', 8, 2025, 'Trámites bancarios', 'Aprobado', 'planta', 0, '', '2025-08-15 11:14:36'),
(97, 78, '2025-08-21', 8, 2025, 'Gestión académica', 'Aprobado', 'planta', 0, '', '2025-08-15 11:15:21'),
(98, 83, '2025-08-21', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-08-20 11:09:49'),
(99, 112, '2025-09-06', 9, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-08-20 11:14:07'),
(100, 63, '2025-08-22', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-22 10:14:56'),
(101, 73, '2025-08-22', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-08-22 10:15:37'),
(102, 39, '2025-08-25', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-22 10:16:28'),
(103, 113, '2025-08-26', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-22 10:17:07'),
(104, 121, '2025-08-26', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-22 10:17:29'),
(105, 25, '2025-08-29', 8, 2025, 'Diligencias personales', 'Aprobado', 'planta', 0, '', '2025-08-27 09:57:44'),
(106, 76, '2025-08-28', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-27 09:58:28'),
(107, 49, '2025-08-27', 8, 2025, 'Emergencia familiar', 'Aprobado', 'planta', 0, '', '2025-08-27 09:59:24'),
(108, 60, '2025-08-27', 8, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-27 10:01:08'),
(109, 55, '2025-09-01', 9, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-08-27 10:01:31'),
(110, 55, '2025-09-02', 9, 2025, 'Dia del cumpleaños', 'Aprobado', 'planta', 0, '', '2025-08-27 10:01:47'),
(111, 55, '2025-09-03', 9, 2025, 'Dia de la Familia', 'Aprobado', 'planta', 0, '', '2025-08-27 10:02:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_portatiles`
--

CREATE TABLE `tbl_portatiles` (
  `id_portatil` int(11) NOT NULL,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malo','De Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_dano` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo',
  `fecha_baja` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_portatiles`
--

INSERT INTO `tbl_portatiles` (`id_portatil`, `numero_pc`, `marca`, `modelo`, `ram`, `velocidad_ram`, `procesador`, `velocidad_procesador`, `disco_duro`, `capacidad`, `serial`, `sistema_operativo`, `numero_activo`, `estado`, `disponibilidad`, `fecha_dano`, `fecha_baja`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(4, 'PC-109', 'Dell', 'Inspiron 3493', '8 GB', '2667 Mhz', 'Intel(R) Core(TM) i5-1035G1', '1.00GHz', 'Híbrido', '1.25 TB', 'CDJ7J33', 'Windows 11 Home', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-01 14:47:25', '2025-08-01 14:47:25', 1),
(5, 'PC-65', 'DELL', '', '4GB', NULL, 'Intel Core i3', NULL, 'HDD', '', '26832216927', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(6, 'PC-97', 'HP', '', '8GB', NULL, 'Intel Core i5', NULL, 'HDD', '', '5CG131G1K', 'WIN11', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(7, 'PC-109', 'DELL', '', '8GB', NULL, 'Core i5-1035G1', '1,00 GHZ', 'SSD', '240 GB', 'CD7J33', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(8, 'PC-110', 'DELL', '', '8GB', NULL, 'Intel Core i7', NULL, 'HDD', '', '6KP5FT2', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(9, 'PC-122', 'HP', '', '4GB', NULL, 'Intel Core i5', NULL, 'HDD', '', '5CG9391NN9', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(10, 'PC-00', 'LENOVO', 'PORTATILES', '4GB', NULL, 'Intel Core i3', NULL, 'HDD', '', 'CB31509115', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(11, 'PC-00', 'LENOVO', 'B40-70', '4GB', NULL, 'Intel Core i3', NULL, 'HDD', '', 'CB31508803', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(12, 'PC-00', 'LENOVO', 'B40-70', '4GB', NULL, 'Intel Core i3', NULL, 'HDD', '', 'CB3148502B', 'WIN10', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:11:57', 1),
(13, 'PC-00', 'LENOVO', 'B40-70', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'CB31508829', 'WIN10', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:12:21', 1),
(14, 'PC-00', 'LENOVO', 'B40-70', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'CB31510561', 'WIN10', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:12:28', 1),
(15, 'PC-00', 'LENOVO', 'B40-70', '4GB', '', 'Intel Core i3', '', 'HDD', '', 'CB31508923', 'WIN10', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:13:02', 1),
(16, 'PC-00', 'LENOVO', 'B40-70', '4GB', '', 'Intel Core i3', '', 'HDD', '', '5100157C', 'WIN10', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:12:58', 1),
(17, 'PC-00', 'LENOVO', 'B40-70', '4GB', '', 'Intel Core i3', '', 'HDD', '', '?', 'WIN10', '', 'Bueno', 'No Disponible', NULL, NULL, '2025-08-27 05:11:57', '2025-08-27 05:12:53', 1);

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
  `eps` int(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_practicantes`
--

INSERT INTO `tbl_practicantes` (`idepracticante`, `nombre_completo`, `numero_identificacion`, `arl`, `edad`, `sexo`, `correo_electronico`, `telefono`, `direccion`, `dependencia_fk`, `cargo_hacer`, `fecha_ingreso`, `fecha_salida`, `contrato_practicante_fk`, `formacion_academica`, `programa_estudio`, `institucion_educativa`, `eps`, `status`) VALUES
(7, 'KAROL MARGARITA MOLINA GALVIS', '1003123558', 'Aseguradora_solidaria', 22, 'femenino', 'karolmolinag0@gmail.com', '3153553753', 'TRANSVERSAL 7 2-03', 13, 'APOYO A LA GESTION EN AREA DE ARCHIVO', '2025-06-13', '2025-09-13', 2, 'Técnico', 'AUXILIAR ADMINISTRATIVO', 'ITN', 0, 1),
(8, 'JUAN DAVID REYES RODRIGUEZ', '1064106690', 'Positiva', 21, 'masculino', 'JUANDREYESR26@GMAIL.COM', '3045502625', 'CALLE 2 SUR #2-09 BARRIO SAN JOSE', 10, 'APOYO EN LA SECTORIAL DE INFRAESTRUCTURA Y OBRAS', '2025-07-14', '2026-01-14', 1, 'Profesional', 'INGENIERO CIVIL', 'UNIVERSIDAD DE PAMPLONA', 0, 1),
(9, 'LADY YURELIS JAIMES SARAVIA', '1064107722', 'Positiva', 39, 'femenino', 'LADYJAIIMES@GMAIL.COM', '3113858797', 'MZ 11 CASA 394 ALTOS DE LA MINA', 6, 'APOYO A SECRETARIA DE AGRICULTURA', '2025-07-08', '2026-01-08', 2, 'Profesional', 'INGENIERIA INDUSTRIAL', 'UNAD', 0, 1),
(10, 'MARTHA CECILIA BAUTISTA AGUILAR', '1003122802', 'Positiva', 31, 'femenino', 'APRILNALETH12@GMAIL.COM', '3245639859', 'LA JAGUA DE IBIRICO', 3, 'APOYO EN SECRETERIA DE GOBIERNO', '2025-07-21', '2026-01-21', 1, 'Profesional', 'ADMINISTRACION DE EMPRESAS', 'UNAD', 0, 1),
(11, 'DIOVANNYS RAFAEL TRESPALACIOS MONTESIO', '1003122944', '', 26, 'masculino', 'tresparafa20@gmail.com', '3225319080', 'LA JAGUA DE IBIRICO', 11, 'APOYO EN SECRETARIA DE HACIENDA', '2025-04-28', '2025-10-28', 1, 'Profesional', 'CONTADOR PUBLICO', 'UNIVERSIDAD DE PAMPLONA', 0, 1),
(12, 'KATY YULIETH DIAZ GARCIA', '1064109129', 'Positiva', 19, 'femenino', 'katyjulieth16@gmail.com', '3207192975', 'calle 3A #2-22', 5, 'APOYO EN LAS ACTIVIDADES DE LEVANTAMIENTO DE CADAVERES EN SINIESTROS VIALES', '2025-03-15', '2025-05-30', 2, 'Técnico', 'T.P PROCESOS JUDICIALES', 'F.I.T', 0, 2),
(13, 'ANDREA SANDRITH HERNANDEZ PAREJO', '1064121054', 'Positiva', 27, 'femenino', 'andreahzp67@gmail.com', '3017004637', 'MZ 1 CASA 30 ALTOS DE LA MINA', 9, 'APOYO A LA OFICINA DE VIVIENDA, ACTUALIZAR Y ORGANIZAR LA BASE DE DATOS RELACIONADA CON LOS PROCESOS DE INCLUSION Y EXCLUSION, BRINDAR ORIENTACION Y INFORMACION', '2025-04-01', '2025-08-01', 3, 'Profesional', 'AMINISTRACION PUBLICA TERRITORIAL', 'ESAP', 0, 1),
(14, 'YEISO DAVID PALACIOS REAL', '1064118651', 'Positiva', 29, 'masculino', 'Ydpalaciosr@ufpso.edu.co', '3223846747', 'transversal 14 #9-18 juan ramon', 4, 'APOYO A PROCESOS DE EDUCACION SUPERIOR EN EL MUNICIPIO, APOYO A LA GESTION ADMINISTRATIVA DE LA SECTORIA DE EDUCACION, APOYO EN LA ASESORIA O LOS PROGRAMAS Y PROYECTOS ORIENTADOS', '2025-03-18', '2025-07-18', 2, 'Profesional', 'ADMINISTRACION DE EMPRESAS', 'UNIVERSIDAD FRANCISCO DE PAULA SANTANDER', 0, 2),
(15, 'JESUS DAVIS USMA DIAZ', '1064108547', 'Positiva', 19, 'masculino', 'jesususma721@gmail.com', '3126067887', 'KR 4 3A 15 CENTRO', 1, 'APOYO EN LAS PLATAFORMAS', '2025-03-03', '2025-09-03', 2, 'Técnico', 'SISTEMAS TELEINFORMATICOS', 'SENA', 0, 1),
(16, 'INGRID PAOLA LIÑAN TORRES', '1065580758', 'Positiva', 39, 'femenino', 'jesuvaleemma3@gmail.com', '3182964281', 'calle 9# 2-48 las malvinas', 3, 'APOYO', '2024-11-01', '2025-05-01', 2, 'Técnico', 'TECNICO EN RECURSOS HUMANOS', 'SENA', 0, 2),
(17, 'JUAN SEBASTIAN CARDENAS GUERRERO', '1193579239', 'Positiva', 22, 'masculino', 'juan.cardenasg.89@gmail.com', '3242611872', 'calle 8 #2-30 las malvinas', 1, 'APOYO', '2025-03-14', '2025-09-14', 2, 'Técnico', 'PROGRAMACION DE SOFTWARE', 'SENA', 0, 1),
(18, 'JICETH PAOLA MANCERA PALOMINO', '1064107559', 'Positiva', 28, 'femenino', 'mjiceth@gmail.com', '3146741318', 'Dg 2 1f-17', 14, 'APOYO', '2025-03-06', '2025-09-06', 3, 'Profesional', 'INGENIERIA INDUSTRIAL', 'UNAD', 0, 1),
(19, 'MARTHA LILIANA PEREZ CORDOBA', '10641080688', 'Positiva', 38, 'femenino', 'marlipercor@gmail.com', '3146356719', 'DIAGONAL 7 #16-23 NUEVO MILENIO', 10, 'APOYO', '2024-08-01', '2025-08-01', 2, 'Técnico', 'RECURSOS HUMANO', 'SENA', 0, 2),
(20, 'JESSIKA JULIETH SAAVEDRA PAJARO', '1064124478', 'Positiva', 30, 'femenino', 'JESSIKASAAVEDRA4@GMAIL.COM', '3233934289', 'CARRERA 3 #10-39 LAS MALVINAS', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(21, 'CLERIS MARIA MONTERROSA DAZA', '1064122162', 'Positiva', 26, 'femenino', 'CLERI.MA852@GMAIL.COM', '3116885332', 'CRA 1A- 13 BARRIO ELPARAISO', 7, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(22, 'LINA MARCELA GUERRA FERNANDEZ', '36574072', 'Positiva', 40, 'femenino', 'lguerrafernandez@hotmail.com', '3156149783', 'carrera 6 #2-54', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(23, 'Juan Carlos Pérez López', '1', 'Sura', 18, 'masculino', 'juan.perez@ejemplo.com', '1', '1', 18, 'asd', '2025-08-11', '2025-08-21', 2, 'Tecnólogo', 'asdasd', 'asdasds', 0, 0),
(24, 'ANA LAUDITH GUETTE VILORIA', '1065600302', 'Positiva', 37, 'femenino', 'alguettev@unadvirtual.edu.co', '3136801001', 'calle 2 # 2-103 barrio santander', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(25, 'SANDRA MILENA CONTRERAS OROZCO', '1064113576', 'Positiva', 32, 'femenino', 'MILENAC32@GMAIL.COM', '3205854186', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2025-03-03', '2025-05-08', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(26, 'ELIS JULIANA PACHECO ECHAVEZ', '1192773969', 'Positiva', 24, 'femenino', 'epacheco2001@oulook.com', '3207416837', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2025-03-03', '2025-05-08', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(27, 'NAYELIS SALINA BERMUDEZ', '1065653263', 'Positiva', 31, 'femenino', 'naye2013@oulook.com', '3205517204', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2025-03-03', '2025-05-08', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(28, 'AMIRA PAOLA GARCIA MOLINA', '1064121242', 'Positiva', 27, 'femenino', 'amira15@hotmail.com', '3004252594', 'CALLE 8 #5-14', 3, 'APOYO', '2025-03-03', '2025-05-08', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(29, 'MARIA CAMILA MOLINA RIVERA', '1003123459', 'Positiva', 23, 'femenino', 'XXXX@GMAL.COM', '3207805913', 'BOQUERON', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(30, 'DAIBELIS JENNIFER HERNANDEZ MARTINEZ', '1064719145', 'Positiva', 31, 'femenino', 'daibelista@gmail.com', '3148174080', 'DIAGONAL 8 #9-13', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(31, 'WILMARY CARDILES MORALES', '1066097271', 'Positiva', 28, 'femenino', 'dra.wilmarycardiles07@oulook.com', '3008682681', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(32, 'DIANA CAROLINA ISAZA RICO', '1064114553', 'Positiva', 22, 'femenino', 'dianarico2009@hotmail.com', '3216762121', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(33, 'ANDREA CAROLINA MORATO CAMPO', '1007561572', 'Positiva', 24, 'femenino', 'solimar222019@gmail.com', '3117993302', 'BOQUERON', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(34, 'LINA MARCELA BELTRAN PEREZ', '1082879514', 'Positiva', 22, 'femenino', 'XXXXXX@GMAIL.COM', '3208799814', 'MZ 2 CS 12 URB NANCY LOBO', 3, 'APOYO', '2024-10-01', '2025-02-03', 1, 'Profesional', 'ADMINISTRACION DE EMPRESAS', 'UNAD', 0, 1),
(35, 'KATHERINE VERGEL RODRIGUEZ', '1007387317', 'Positiva', 32, 'femenino', 'vergel-katy@hotmail.com', '3215461263', 'calle 1 #2 este 31', 9, 'APOYO', '2024-10-02', '2025-02-02', 1, 'Profesional', 'ADMINISTRACION DE EMPRESAS', 'UNAD', 0, 2),
(36, 'YUNEIDYS DURAN OROZCO', '1007356239', 'Positiva', 25, 'femenino', 'yuneidis.duran19@gmail.com', '3105208216', 'LA JAGUA DE IBIRICO', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(37, 'ALBA ROSA PADILLA CAMPO', '1085175962', 'Positiva', 32, 'femenino', 'padillacampoalba@gmail.com', '3013339315', 'tranversal 2 #4-21', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(38, 'ANYULI JOHANA MEDINA ZAPATA', '1065571281', 'Positiva', 40, 'femenino', 'anyulimedinaz1601@gmail.com', '3118918440', 'dg 6A #16-100 nuevo milenio', 7, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(39, 'CENITH MILENA TOSCANO QUINTERO', '1064112795', 'Positiva', 33, 'femenino', 'milena19922009@hotmail.com', '3126777801', 'calle 1 N # 1E-75', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(40, 'SANDRA MILENA BARRETO DITTA', '36572513', 'Positiva', 48, 'femenino', 'sandra77milena26@gmail.com', '3135027473', 'trsnsversal 10 #7-73', 3, 'APOYO', '2024-03-06', '2024-06-06', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(41, 'MAYERLIS URIBE ROZO', '1064110172', 'Positiva', 36, 'femenino', 'mauro.al@oulook.es', '3215897053', 'diagonal 6 #14-24 juan ramon', 14, 'APOYO', '2024-10-02', '2025-02-02', 1, 'Profesional', 'ADMINISTRACION DE EMPRESAS', 'UNAD', 0, 2),
(42, 'SANDRITH JULIETH MARTINEZ CARRANZA', '1064115255', 'Positiva', 31, 'femenino', 'sandrithjmartinez@gmail.com', '3117993302', 'BOQUERON', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(43, 'SHIRLEY KATERINE PEREZ PUELLO', '1193097303', 'Positiva', 34, 'femenino', 'shirlyperezp@gmail.com', '3103521055', 'transversal 15 #6-32', 3, 'APOYO', '2024-09-11', '2024-11-27', 3, 'Profesional', 'PSICOLOGA', 'UNAD', 0, 2),
(44, 'WILSON REYES QUINTANA', '77182128', 'Positiva', 50, 'masculino', 'wilsonreyes70@hotmail.com', '0000000000', 'LA JAGUA DE IBIRICO', 6, 'APOYO', '2024-12-01', '2025-06-01', 1, 'Técnico', 'PRODUCCION EN AGROPECUARIA', 'SENA', 0, 2),
(45, 'ANDERSON MAURICIO RIOS JULIO', '1064118243', 'Positiva', 29, 'masculino', 'gicear7@gmail.com', '3207870193', 'diagonal 6 #15-13 juan ramon', 11, 'APOYO', '2021-03-08', '2021-12-08', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UNIVERSIDAD POPULAR DEL CESAR', 0, 2),
(46, 'EDGAR JOSE ROBLES BONETT', '1003123167', 'Positiva', 23, 'masculino', 'edgarrobles0328@gmail.com', '3108233839', 'carrero 3a #10-33', 11, 'APOYO', '2024-02-26', '2024-11-26', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UDES', 0, 1),
(47, 'YISELL CAROLINA RIOS RUIDIAZ', '1007624710', 'Sura', 23, 'femenino', 'yisellrios19@gmail.com', '3208896634', 'diagonal 4 # 12-30', 14, 'APOYO', '2024-02-16', '2024-11-20', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UNIVERSIDAD COOPERATIVA DE COLOMBIA', 0, 1),
(48, 'MARIA ALEJANDRA MUÑOZ PEÑALOZA', '1064122314', 'Positiva', 26, 'femenino', 'marialejamp69@gmail.com', '3117520996', 'tranversal 13 #4-58', 3, 'APOYO', '2024-04-12', '2024-10-12', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UDES', 0, 2),
(49, 'JANY WINETH VEGA MEJIA', '1064118353', 'Positiva', 21, 'femenino', 'janyvegamejia09@gmail.com', '3012835220', 'LA JAGUA DE IBIRICO', 9, 'APOYO', '2025-02-12', '2025-04-23', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UNIVERSIDAD DEL MAGDALENA', 0, 1),
(50, 'DANIELA VANESSA OCHOA CLAVIJO', '1003123848', 'Positiva', 22, 'femenino', 'danielaochoaclavijo@gmail.com', '3216147420', 'LA JAGUA DE IBIRICO', 16, 'APOYO', '2024-07-08', '2024-10-21', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UNIVERSIDAD DEL MAGDALENA', 0, 2),
(51, 'DANIRIS ADRIANA MEDRANO GARCIA', '1193542764', 'Sura', 22, 'femenino', 'danirismedrano232@gmail.com', '3212930767', 'diagonal 10 1a-18', 10, 'APOYO', '2024-02-23', '2024-09-06', 1, 'Profesional', 'AUXILIAR JURIDICO AD HONOREM', 'UNIVERSIDAD AUTONOMA DEL CARIBE', 0, 2);

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
  `archivo_adjunto` varchar(255) DEFAULT NULL COMMENT 'Nombre del archivo adjunto',
  `nombre_archivo_original` varchar(255) DEFAULT NULL COMMENT 'Nombre original del archivo',
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `fecha_completada` datetime DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tareas`
--

INSERT INTO `tbl_tareas` (`id_tarea`, `id_usuario_creador`, `id_usuario_asignado`, `tipo`, `descripcion`, `dependencia_fk`, `estado`, `observacion`, `archivo_adjunto`, `nombre_archivo_original`, `fecha_inicio`, `fecha_fin`, `fecha_completada`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(27, 1, 22, 'administrativa', 'Reporte Sirecci:\r\nM-71- OBRAS CIVILES INCONCLUSAS O SIN USO\r\nM-7.3: REGALIAS - CONTRATOS Y PROYECTOS\r\nM-70: DELITOS CONTRA LA ADMON PUBLICA', 1, 'completada', NULL, NULL, NULL, '2025-07-10 00:00:00', '2025-07-14 00:00:00', '2025-07-10 00:00:00', '2025-07-10 20:49:03', '2025-07-10 21:54:13'),
(28, 1, 22, 'administrativa', 'Reporte Sireci:\r\nM-3: PLAN DE MEJORAMIENTO', 14, 'completada', NULL, NULL, NULL, '2025-07-10 00:00:00', '2025-07-21 00:00:00', '2025-08-08 00:00:00', '2025-07-10 20:55:37', '2025-08-08 12:56:12'),
(29, 1, 22, 'administrativa', 'reporte del SIA CONTRALORÍAS - Primer semestre, seguimiento con control interno de gestión', 1, 'completada', NULL, NULL, NULL, '2025-07-01 00:00:00', '2025-07-19 00:00:00', '2025-08-08 00:00:00', '2025-07-10 21:03:20', '2025-08-08 12:56:04'),
(30, 1, 22, 'administrativa', 'Diligenciar los formatos f20_cgdc del SIA Contraloria Departamental para reportarlo', 1, 'completada', NULL, NULL, NULL, '2025-07-10 00:00:00', '2025-07-18 00:00:00', '2025-08-08 00:00:00', '2025-07-11 20:10:29', '2025-08-08 12:55:55');

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
(55, 27, 22),
(56, 27, 25),
(57, 27, 1),
(58, 28, 22),
(59, 28, 25),
(60, 28, 1),
(67, 30, 22),
(68, 30, 25),
(69, 30, 1),
(70, 29, 22),
(71, 29, 25),
(72, 29, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tintas_toner`
--

CREATE TABLE `tbl_tintas_toner` (
  `id_tinta_toner` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `disponibles` int(11) NOT NULL DEFAULT 0,
  `impresora` varchar(100) DEFAULT NULL,
  `modelos_compatibles` text DEFAULT NULL,
  `fecha_ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tintas_toner`
--

INSERT INTO `tbl_tintas_toner` (`id_tinta_toner`, `item`, `disponibles`, `impresora`, `modelos_compatibles`, `fecha_ultima_actualizacion`, `fecha_registro`, `status`) VALUES
(4, '83A', 11, '11', 'HP LaserJet Pro M125a MFP - M127fn -M201dw', '2025-08-20 03:27:42', '2025-08-20 03:20:59', 1),
(5, '30A', 7, '17', 'HP LaserJet Pro M203dw - M227fdw', '2025-08-20 03:52:54', '2025-08-20 03:23:02', 1),
(6, '32A', 5, '17', 'HP LaserJet Pro M203dw', '2025-08-20 03:28:00', '2025-08-20 03:24:10', 1),
(7, '58X', 5, '25', 'HP Lasert Jet Pro MFP M428Fdw', '2025-08-20 03:36:21', '2025-08-20 03:26:27', 1),
(8, 'Mp305', 33, '16', 'RICOH Aficio MP 305+SP', '2025-08-20 03:27:29', '2025-08-20 03:27:29', 1),
(9, 'T544 Negro, Cyan, Yellow, Magenta', 2, '28', 'EPSON EcoTank - L3110 -L3210 - L5190 - L6490', '2025-08-20 03:38:23', '2025-08-20 03:31:57', 1),
(10, '85A', 5, '29', 'HP LaserJet Pro P1102', '2025-08-20 03:55:15', '2025-08-20 03:39:23', 1),
(11, '81A-X', 5, '34', 'HP Laserjet Enterprise Mfp M630', '2025-08-20 03:41:37', '2025-08-20 03:41:15', 1),
(12, '55A-X', 5, '30', 'HP LaserJet Pro M521dn', '2025-08-20 03:43:35', '2025-08-20 03:42:56', 1),
(13, 'Negro, Cyan, Yellow, Magenta', 0, '48', 'CANON Pixma G4170 Megatank', '2025-08-20 03:44:54', '2025-08-20 03:44:54', 1),
(14, '05A-X', 5, '52', 'HP LaserJet Pro 400 MFP M425dn', '2025-08-20 03:46:53', '2025-08-20 03:46:29', 1),
(15, 'MLT-D111S', 0, '14', 'SAMSUNG Xpress SL-M2070FW', '2025-08-20 03:49:05', '2025-08-20 03:48:45', 1),
(16, 'Tinta Brother BTD60 y BT5001', 0, '53', 'Brother DCP-T710W', '2025-08-20 03:54:36', '2025-08-20 03:54:08', 1),
(17, 'TK-3402', 5, '44', 'KYOCERA Ecosys MA4500 IFX', '2025-08-20 03:56:52', '2025-08-20 03:56:08', 1),
(18, '105A', 3, '51', 'HP Laser MFP 137fnw', '2025-08-20 03:58:34', '2025-08-20 03:58:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_todo_en_uno`
--

CREATE TABLE `tbl_todo_en_uno` (
  `id_todo_en_uno` int(11) NOT NULL,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malo','De Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','No Disponible') NOT NULL DEFAULT 'Disponible',
  `fecha_dano` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo',
  `fecha_baja` date DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_todo_en_uno`
--

INSERT INTO `tbl_todo_en_uno` (`id_todo_en_uno`, `numero_pc`, `marca`, `modelo`, `ram`, `velocidad_ram`, `procesador`, `velocidad_procesador`, `disco_duro`, `capacidad`, `serial`, `sistema_operativo`, `numero_activo`, `estado`, `disponibilidad`, `fecha_dano`, `fecha_baja`, `fecha_registro`, `fecha_actualizacion`, `status`) VALUES
(1, 'PC-OO', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503949', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(2, 'PC-8', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503949', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(3, 'PC-14', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393V', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(4, 'PC-15', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150394J', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(5, 'PC-16', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393J', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(6, 'PC-18', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC15038MK', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(7, 'PC-19', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC10530NJ', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(8, 'PC-20', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC15038YF', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(9, 'PC-24', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '88CC150394C', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(10, 'PC-25', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150394W', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(11, 'PC-26', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC8040FRS', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(12, 'PC-32', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC15038Y4', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(13, 'PC-34', 'HP', '200 G4 22 All-in-One', '8GB', '2400MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503944', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(14, 'PC-36', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393T', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(15, 'PC-38', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'Intel Core i5', NULL, 'HDD', '1 TB', '8CC0213224', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(16, 'PC-39', 'HP', '', '4GB', '2400 MHz', 'Intel Core i5', NULL, 'HDD', '1 TB', '8CC0213224', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(17, 'PC-41', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393R', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(18, 'PC-42', 'HP', '200 G4 22 All-in-One', '16GB', '', 'Core i7', '', 'SSD', '512 GB', '', 'Windows 10 Pro', '', 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:32:01', 1),
(19, 'PC-43', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503942', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(20, 'PC-47', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC15037G4', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(21, 'PC-51', 'HP', '200 G4 22 All-in-One', '8GB', '2400MHz', 'I5 10210U', '1.60 GHz', 'SSD', '480 GB', '8CC14854CG', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(22, 'PC-54', 'HP', '200 G4 22 All-in-One', '8GB', '2400MHz', 'I5 10210U', '1.60 GHz', 'SSD', '480 GB', '8CC14854GX', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(23, 'PC-55', 'HP', '200 G4 22 All-in-One', '8GB', '2400MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150399S', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(24, 'PC-58', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393W', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(25, 'PC-61', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503943', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(26, 'PC-64', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503950', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(27, 'PC-66', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150394F', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(28, 'PC-71', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150394Y', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(29, 'PC-72', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503940', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(30, 'PC-76', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393L', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(31, 'PC-77', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC0133WNX', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(32, 'PC-80', 'HP', '200 G4 22 All-in-One', '8GB', '2400 MHz', 'I5 10210U', '1.60 GHz', 'SSD', '240 GB', '8C13226MNM', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(33, 'PC-82', 'HP', '200 G4 22 All-in-One', '8GB', '2400 MHz', 'I5 10210U', '1.60 GHz', 'SSD', '240 GB', '8CC13226M1', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(34, 'PC-84', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC1503947', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(35, 'PC-89', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'Intel Core i5', NULL, 'HDD', '1 TB', '8CC02132Z4', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(36, 'PC-93', 'HP', '', '4GB', '2400 MHz', 'Intel Core i5', NULL, 'HDD', '1 TB', '8CC120PKB', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(37, 'PC-94', 'HP', '', '4GB', '2400 MHz', 'Intel Core i5', NULL, 'HDD', '1 TB', '8CC01220033', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(38, 'PC-99', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150394H', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(39, 'PC-101', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC15038PG', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(40, 'PC-104', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC0380ZZP', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(41, 'PC-121', 'HP', 'ProOne 400 G1', '4GB', '2400 MHz', 'i5 -4570T', '2.90GHz', 'HDD', '500 GB', 'MXL4281NXS', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1),
(42, 'PC-124', 'HP', '200 G4 22 All-in-One', '4GB', '2400 MHz', 'I3-10110U', '2.10 GHz', 'HDD', '1 TB', '8CC150393Y', 'Windows 10 Pro', NULL, 'Bueno', 'Disponible', NULL, NULL, '2025-08-01 20:31:21', '2025-08-01 20:31:21', 1);

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
(1, 'Luis Carlos Duran', 'sistema@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'perfil_1.jpg', 1, 1, 1),
(16, 'Tatiana Alejandra Martínez Meneses', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'b3bac4078570ff255b11047d393c5a94a5e94767c426e7fc52e6eba3f44a6b8c', 'sin-imagen.png', 12, 1, 1),
(17, 'Maria Del Pilar Ureche Cobo', 'contratacion@lajaguadeibirico-cesar.gov.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'sin-imagen.png', 4, 1, 1),
(18, 'Moises Xavier Paternina', 'talentohumano@lajaguadeibirico-cesar.gov.co', 'f6ab67656b99857c4a0c4970886a9bc70fb18b4ac99173732a46a743846bc4ea', 'sin-imagen.png', 2, 1, 1),
(19, 'Fabián Duran Ortiz', 'fabianduran18@hotmail.com', '33882b27b999581a5679bcbe699e4cc2e3cfd37067791c051f17473843e009e8', 'sin-imagen.png', 5, 1, 1),
(20, 'Jesus David Usma Días', 'jesususma721@gmail.com', '34fc34ff9be8e43e04aa773835016ce53a88749408ad81e891bc39e971399ba1', 'sin-imagen.png', 5, 1, 1),
(21, 'Frank Luis Salcedo Redondo', 'fsalcedoredondo@gmail.com', '7cfd9a952732762e1ab94b5cadc90db27bf74720fd24d5aa8876e65f706ab6f4', 'perfil_21.jpg', 5, 1, 1),
(22, 'Elías Iguaran Márquez', 'helias.iguaran@gmail.com', '7e82e7429c766d829ecd23ea74961495b99a065422a670c0a9404716c7343451', 'perfil_22.png', 5, 1, 1),
(23, 'Luisa Fernanda Moreno', 'auxiliartic2024@gmail.com', '39253295aea0fd1ade2779006cf41b49376942284013bdb6e5316fcd322a567b', 'sin-imagen.png', 7, 1, 1),
(24, 'Ana Carolina Mendoza', 'anacarolinamendozamojica@gmail.com', '0352709ad6ec43c6d165e948957d5e9b55e2519116147eed3e9f41fab47d91e6', 'sin-imagen.png', 12, 1, 1),
(25, 'Luilly Navas', 'lnavas1981@gmail.com', '1628b489ba589115ec0cf8c41702470d4c3059c9a217638ef0f7af7e82b3af9b', 'perfil_25.png', 5, 1, 1),
(26, 'Yuleima Aguilar', 'yuleimaaguilarlima@gmail.com', '24b9219619f4c73eb7dd95e7f4f29a9e97feaae912de00c78c876c51b1360c76', 'sin-imagen.png', 2, 1, 1),
(27, 'Oscar Ivan Rojas', 'seguridadinformaticalajagua@gmail.com', '0128df21ed2cff855783da81cde5ec7ddf580d16d2fb44ab57199bb2f4920180', 'sin-imagen.png', 5, 1, 1),
(28, 'Ing. Carlos Lopez', 'carloslxpxz@gmail.com', 'ee89131cb45aba511f7a06452717caabce0438b5d654e73a5ad15e58ea4cf717', 'sin-imagen.png', 5, 1, 1),
(29, 'Sebastian Cardenas', 'sbt.cardenas.g@gmail.com', '33118bf33ad867c1e6dd2677584a15be9d7719d3085159818af590f8d97572e8', 'perfil_29.jpg', 5, 1, 1);

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
(3, 17, 4, '2025-07-07 14:23:16'),
(4, 18, 2, '2025-07-07 14:23:16'),
(5, 19, 5, '2025-07-07 14:23:16'),
(6, 20, 5, '2025-07-07 14:23:16'),
(7, 21, 5, '2025-07-07 14:23:16'),
(9, 23, 7, '2025-07-07 14:23:16'),
(10, 24, 12, '2025-07-07 14:23:16'),
(16, 16, 5, '2025-07-07 14:33:52'),
(17, 16, 12, '2025-07-07 14:33:52'),
(28, 22, 5, '2025-07-11 15:27:20'),
(29, 22, 12, '2025-07-11 15:27:20'),
(34, 1, 1, '2025-07-17 14:11:11');

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
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta',
  `tipo_vacaciones` enum('Compensadas','Disfrutadas') DEFAULT 'Disfrutadas',
  `valor` decimal(12,2) DEFAULT 0.00,
  `fecha_pago` datetime DEFAULT NULL
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
  `cargo` varchar(255) NOT NULL,
  `dependencia` varchar(255) NOT NULL,
  `motivo_gasto` varchar(255) NOT NULL,
  `lugar_comision_departamento` varchar(255) NOT NULL,
  `lugar_comision_ciudad` varchar(255) NOT NULL,
  `finalidad_comision` text NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `valor_viatico` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fecha_aprobacion` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_regreso` date NOT NULL,
  `n_dias` int(3) NOT NULL,
  `valor_dia` decimal(12,2) NOT NULL DEFAULT 0.00,
  `valor_transporte` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_liquidado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tipo_transporte` varchar(255) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_viaticos`
--

INSERT INTO `tbl_viaticos` (`idViatico`, `funci_fk`, `cargo`, `dependencia`, `motivo_gasto`, `lugar_comision_departamento`, `lugar_comision_ciudad`, `finalidad_comision`, `descripcion`, `valor_viatico`, `fecha_aprobacion`, `fecha_salida`, `fecha_regreso`, `n_dias`, `valor_dia`, `valor_transporte`, `total_liquidado`, `tipo_transporte`, `estatus`, `fecha_creacion`) VALUES
(10, 91, 'Secretario de Despacho', 'Secretaría de Salud', 'CAPACITACION', 'Cesar', 'Valledupar', 'CAPACITACION SOBRE LA', 'CAPACITACION SOBRE LA', 180000.00, '2025-08-13', '2025-08-19', '2025-08-19', 1, 180000.00, 70000.00, 250000.00, 'Interno', 1, '2025-08-14 21:48:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `whatsapp_config`
--

CREATE TABLE `whatsapp_config` (
  `id` int(11) NOT NULL,
  `type` enum('task','general') NOT NULL,
  `phone` varchar(20) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `whatsapp_config`
--

INSERT INTO `whatsapp_config` (`id`, `type`, `phone`, `api_key`, `status`) VALUES
(1, 'task', '573183687660', '8086746', 1),
(2, 'general', '573163819809', '1234652', 2);

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
-- Indices de la tabla `tbl_equipos_movimientos`
--
ALTER TABLE `tbl_equipos_movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `idx_equipo` (`id_equipo`,`tipo_equipo`);

--
-- Indices de la tabla `tbl_escaneres`
--
ALTER TABLE `tbl_escaneres`
  ADD PRIMARY KEY (`id_escaner`),
  ADD KEY `idx_fecha_dano` (`fecha_dano`),
  ADD KEY `idx_fecha_baja` (`fecha_baja`);

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
-- Indices de la tabla `tbl_herramientas`
--
ALTER TABLE `tbl_herramientas`
  ADD PRIMARY KEY (`id_herramienta`);

--
-- Indices de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `idx_es_permiso_especial` (`es_permiso_especial`);

--
-- Indices de la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  ADD PRIMARY KEY (`id_impresora`),
  ADD KEY `idx_fecha_dano` (`fecha_dano`),
  ADD KEY `idx_fecha_baja` (`fecha_baja`);

--
-- Indices de la tabla `tbl_mantenimientos_equipos`
--
ALTER TABLE `tbl_mantenimientos_equipos`
  ADD PRIMARY KEY (`id_mantenimiento`),
  ADD KEY `idx_equipo_tipo` (`id_equipo`,`tipo_equipo`),
  ADD KEY `idx_fecha` (`fecha_mantenimiento`);

--
-- Indices de la tabla `tbl_motivos_permisos`
--
ALTER TABLE `tbl_motivos_permisos`
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
-- Indices de la tabla `tbl_papeleria`
--
ALTER TABLE `tbl_papeleria`
  ADD PRIMARY KEY (`id_papeleria`);

--
-- Indices de la tabla `tbl_pc_torre`
--
ALTER TABLE `tbl_pc_torre`
  ADD PRIMARY KEY (`id_pc_torre`),
  ADD KEY `idx_fecha_dano` (`fecha_dano`),
  ADD KEY `idx_fecha_baja` (`fecha_baja`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `idx_es_permiso_especial` (`es_permiso_especial`),
  ADD KEY `idx_fecha_registro` (`fecha_registro`);

--
-- Indices de la tabla `tbl_portatiles`
--
ALTER TABLE `tbl_portatiles`
  ADD PRIMARY KEY (`id_portatil`),
  ADD KEY `idx_fecha_dano` (`fecha_dano`),
  ADD KEY `idx_fecha_baja` (`fecha_baja`);

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
-- Indices de la tabla `tbl_tintas_toner`
--
ALTER TABLE `tbl_tintas_toner`
  ADD PRIMARY KEY (`id_tinta_toner`);

--
-- Indices de la tabla `tbl_todo_en_uno`
--
ALTER TABLE `tbl_todo_en_uno`
  ADD PRIMARY KEY (`id_todo_en_uno`),
  ADD KEY `idx_fecha_dano` (`fecha_dano`),
  ADD KEY `idx_fecha_baja` (`fecha_baja`);

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
-- Indices de la tabla `whatsapp_config`
--
ALTER TABLE `whatsapp_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adiciones_contrato`
--
ALTER TABLE `adiciones_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `categorias_archivos`
--
ALTER TABLE `categorias_archivos`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1339;

--
-- AUTO_INCREMENT de la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_capital_viaticos`
--
ALTER TABLE `tbl_capital_viaticos`
  MODIFY `idCapital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `idecargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  MODIFY `id_contrato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  MODIFY `id_contrato_practicante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  MODIFY `dependencia_pk` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbl_equipos_movimientos`
--
ALTER TABLE `tbl_equipos_movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_escaneres`
--
ALTER TABLE `tbl_escaneres`
  MODIFY `id_escaner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_ops`
--
ALTER TABLE `tbl_funcionarios_ops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `tbl_herramientas`
--
ALTER TABLE `tbl_herramientas`
  MODIFY `id_herramienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  MODIFY `id_impresora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `tbl_mantenimientos_equipos`
--
ALTER TABLE `tbl_mantenimientos_equipos`
  MODIFY `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_motivos_permisos`
--
ALTER TABLE `tbl_motivos_permisos`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_papeleria`
--
ALTER TABLE `tbl_papeleria`
  MODIFY `id_papeleria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_pc_torre`
--
ALTER TABLE `tbl_pc_torre`
  MODIFY `id_pc_torre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `tbl_portatiles`
--
ALTER TABLE `tbl_portatiles`
  MODIFY `id_portatil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  MODIFY `idepracticante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `tbl_tintas_toner`
--
ALTER TABLE `tbl_tintas_toner`
  MODIFY `id_tinta_toner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_todo_en_uno`
--
ALTER TABLE `tbl_todo_en_uno`
  MODIFY `id_todo_en_uno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `whatsapp_config`
--
ALTER TABLE `whatsapp_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
