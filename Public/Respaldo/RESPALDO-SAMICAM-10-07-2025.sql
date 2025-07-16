-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2025 a las 18:55:58
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
(18, 'PSI', 'Gestión de PSI', 1);

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
(1336, 2, 18, 0, 0, 0, 0, 1);

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
(82, 'CONTRATOS', '2025-07-14', 'lajaguasigep20@gmail.com', 'CONTRATOS RENDIDOS EN EL MES DE JUNIO DE 2025', '2025-07-14', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/tema/contrataciones', 16, 1);

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
(7, 2025, 50000000.00, 0.00, '2025-07-08 21:30:11', '2025-07-11 21:05:23'),
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
-- Estructura de tabla para la tabla `tbl_escaneres`
--

CREATE TABLE `tbl_escaneres` (
  `id_escaner` int(11) NOT NULL,
  `numero_escaner` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(75, 'MALDONADO AVILA JOSE MARIA', '1065567850', 50, 5, 2, '3016451820', 'DG 1 9- 139 BRR OVELIO JIMENEZ', 'chema_9-5@hotmail.com', '2025-06-19', 0, '', 'masculino', 'LA JAGUA DE IBIRICO', 40, 'soltero', 'catolico', 'Profesional', 'ADMINISTRADOR PUBLICO', NULL, 1, 0, 'Cesar, Valledupar', 'Si', 'libre_nombramiento', 'DIRECTIVO', 5982216.00, 'Decreto 00082', '2025-06-19', '4107', '2025-06-19', '28 días', '020', '01', '1984-11-05', 'Cesar, La Jagua de Ibirico', 'AB+', 'ADMINISTRADOR PUBLICO', 'Si', 'NO', '599124690', 'BANCO DE BOGOTA', 'CAJACOPI', 'PROTECCION', 'COLFONDOS', 'POSITIVA', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_herramientas`
--

CREATE TABLE `tbl_herramientas` (
  `id_herramienta` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(6, 'Gestión académica', 'Permiso para asuntos relacionados con estudios', 1, '2025-07-08 13:50:15', '2025-07-08 13:50:15');

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
(16, 28, 1, 'Este formato diligenciado lo envía la oficina de control interno de gestión', '2025-07-10 20:55:37'),
(17, 29, 1, 'Los formatos para diligenciar fueron enviados a control interno el 2 de julio 2025', '2025-07-10 21:03:20'),
(18, 27, 22, 'La Publicación de los reportes se realizaron satisfactoria mente y se enviaron los soportes por correo electrónico.', '2025-07-10 21:52:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_papeleria`
--

CREATE TABLE `tbl_papeleria` (
  `id_papeleria` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
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
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta',
  `es_permiso_especial` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si es un permiso especial (1) o normal (0)',
  `justificacion_especial` text DEFAULT NULL COMMENT 'Justificación detallada para permisos especiales',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro del permiso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(27, 1, 22, 'administrativa', 'Reporte Sirecci:\r\nM-71- OBRAS CIVILES INCONCLUSAS O SIN USO\r\nM-7.3: REGALIAS - CONTRATOS Y PROYECTOS\r\nM-70: DELITOS CONTRA LA ADMON PUBLICA', 1, 'completada', NULL, '2025-07-10 00:00:00', '2025-07-14 00:00:00', '2025-07-10 00:00:00', '2025-07-10 20:49:03', '2025-07-10 21:54:13'),
(28, 1, 22, 'administrativa', 'Reporte Sireci:\r\nM-3: PLAN DE MEJORAMIENTO', 14, 'sin empezar', NULL, '2025-07-10 00:00:00', '2025-07-21 00:00:00', NULL, '2025-07-10 20:55:37', '2025-07-10 20:55:37'),
(29, 1, 22, 'administrativa', 'reporte del SIA CONTRALORÍAS - Primer semestre', 1, 'sin empezar', NULL, '2025-07-02 00:00:00', '2025-07-20 00:00:00', NULL, '2025-07-10 21:03:20', '2025-07-10 21:03:20'),
(30, 1, 22, 'administrativa', 'Diligenciar los formatos f20_cgdc del SIA Contraloria Departamental y reportarlo', 1, 'sin empezar', NULL, '2025-07-11 00:00:00', '2025-07-15 00:00:00', NULL, '2025-07-11 20:10:29', '2025-07-11 20:10:29');

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
(61, 29, 22),
(62, 29, 25),
(63, 29, 1),
(64, 30, 22),
(65, 30, 25),
(66, 30, 1);

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
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
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
  `status` int(32) NOT NULL,
  `notificaciones_activas` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ideusuario`, `nombres`, `correo`, `password`, `imgperfil`, `rolid`, `status`, `notificaciones_activas`) VALUES
(1, 'Luis Carlos Duran', 'sistemas@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'perfil_1.png', 1, 1, 1),
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
(32, 1, 1, '2025-07-11 15:31:52');

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
(8, 21, 'Técnico Administrativo (GS 3)', 'Oficina de las NTIC', 'cosas', '12', 'Becerril', 'nose', 'asdasd', 50000.00, '2025-07-10', '2025-07-11', '2025-07-12', 2, 10000.00, 400000.00, 30000000.00, 'Interno', 1, '2025-07-10 15:48:52');

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
-- Indices de la tabla `tbl_escaneres`
--
ALTER TABLE `tbl_escaneres`
  ADD PRIMARY KEY (`id_escaner`),
  ADD KEY `idx_dependencia` (`id_dependencia`);

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
  ADD KEY `idx_dependencia` (`id_dependencia`);

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
  ADD KEY `idx_dependencia` (`id_dependencia`);

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
  ADD KEY `idx_dependencia` (`id_dependencia`);

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
  ADD KEY `idx_dependencia` (`id_dependencia`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias_archivos`
--
ALTER TABLE `categorias_archivos`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1337;

--
-- AUTO_INCREMENT de la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `seguimiento_contrato`
--
ALTER TABLE `seguimiento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de la tabla `tbl_escaneres`
--
ALTER TABLE `tbl_escaneres`
  MODIFY `id_escaner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_ops`
--
ALTER TABLE `tbl_funcionarios_ops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `tbl_herramientas`
--
ALTER TABLE `tbl_herramientas`
  MODIFY `id_herramienta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  MODIFY `id_impresora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_motivos_permisos`
--
ALTER TABLE `tbl_motivos_permisos`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_papeleria`
--
ALTER TABLE `tbl_papeleria`
  MODIFY `id_papeleria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_pc_torre`
--
ALTER TABLE `tbl_pc_torre`
  MODIFY `id_pc_torre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `tbl_portatiles`
--
ALTER TABLE `tbl_portatiles`
  MODIFY `id_portatil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  MODIFY `idepracticante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `tbl_tintas_toner`
--
ALTER TABLE `tbl_tintas_toner`
  MODIFY `id_tinta_toner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_todo_en_uno`
--
ALTER TABLE `tbl_todo_en_uno`
  MODIFY `id_todo_en_uno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Filtros para la tabla `tbl_escaneres`
--
ALTER TABLE `tbl_escaneres`
  ADD CONSTRAINT `fk_escaneres_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL;

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
-- Filtros para la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  ADD CONSTRAINT `fk_impresoras_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL;

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
-- Filtros para la tabla `tbl_pc_torre`
--
ALTER TABLE `tbl_pc_torre`
  ADD CONSTRAINT `fk_pc_torre_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tbl_portatiles`
--
ALTER TABLE `tbl_portatiles`
  ADD CONSTRAINT `fk_portatiles_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL;

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
-- Filtros para la tabla `tbl_todo_en_uno`
--
ALTER TABLE `tbl_todo_en_uno`
  ADD CONSTRAINT `fk_todo_en_uno_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL;

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
