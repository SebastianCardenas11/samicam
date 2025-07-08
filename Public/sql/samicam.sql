-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2025 a las 15:56:32
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
(1, 2, 5000000.00, 'Ha', '2025-06-26 08:47:12'),
(2, 2, 8000000.00, 'Aaa', '2025-06-26 08:48:04'),
(3, 2, 1460000.00, 'A', '2025-06-26 08:48:19'),
(4, 5, 10000000.00, 'pa los bolis', '2025-06-26 11:16:55'),
(5, 5, 4000000.00, 'pa las frias', '2025-06-26 11:17:38'),
(6, 5, 460000.00, 'las aspirinas', '2025-06-26 11:19:56');

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
(5, 6, 'Tecnico Ntic', 'aa', 'e563c9982e66703755e03686a4f6a8d1.pdf', 'pdf', '2025-06-08 23:02:23', 0),
(6, 4, 'Chelist', '', 'bc9d4635d92970a9c4bc522ec8289b6b.jpg', 'jpg', '2025-06-24 15:58:12', 0),
(7, NULL, 'Gola', '', 'b4a9cccee763aba293afd92ede286887.pdf', 'pdf', '2025-06-25 11:02:30', 1);

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
(1224, 1, 17, 1, 1, 1, 1, 1);

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
(1, 2, '2025-06-30', '2025-06-30', 121, 'dsasa', '2025-06-25 17:15:43'),
(2, 2, '2025-06-30', '2025-07-03', 3, 'Cosas', '2025-06-25 17:34:44'),
(3, 5, '2025-05-30', '2025-06-30', 31, 'T5t', '2025-06-25 17:57:58'),
(4, 5, '2025-06-30', '2025-07-01', 1, 'Rrr', '2025-06-25 17:58:23');

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
(74, 'RESOLUCIÓN 16062025 - RETIRO DE BENEFICIARIOS DEL PROGRAMA COLOMBIA MAYOR', '2025-07-02', 'secretariadelamujer@lajaguadeibirico-cesar.gov.co', 'RESOLUCION PARA PUBLICAR', '2025-07-02', 'Si', 'https://www.lajaguadeibirico-cesar.gov.co/normatividad/resolucion-16062025-retiro-de-beneficiarios-del-programa', 12, 1);

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
(1, 'SUMINISTRO DE REPUESTOS Y MANO DE OBRA PARA LA REPARACIÓN DE LOS EQUIPOS DE IMPRESIÓN Y ESCÁNER EXISTENTES DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR', '2025-04-09', '2025-05-09', 3, 'meses', 'acta parcial', 1, 37591000.00, '2025-05-12', 'TODO OK', 'SI', '2025-06-13', 37591000.00, 3, '176-2025', 4, '2025-04-03'),
(2, 'COMPRAVENTA DE LICENCIAS DE ANTIVIRUS PARA LOS EQUIPOS DE CÓMPUTO DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR.', '2025-06-25', '2025-07-03', 12, 'dias', 'mes vencido', 1, 28920000.00, '2025-06-23', 'TODO O', 'SI', '2025-05-26', 28920000.00, 1, '215-2025', 18, '2025-05-12'),
(5, 'COMPRAVENTA DE LICENCIAS DE ANTIVIRUS PARA LOS EQUIPOS DE CÓMPUTO DE LA ALCALDÍA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR.', '2025-05-13', '2025-07-01', 12, 'dias', 'mes vencido', 1, 28920000.00, '2025-06-23', 'TODO OK', 'SI', '2025-05-26', 28920000.00, 1, '215-2025', 18, '2025-05-12');

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
(5, 2025, 400000000.00, 389499977.00, '2025-06-11 14:17:16', '2025-07-07 14:31:43'),
(6, 2026, 500000000.00, 500000000.00, '2025-06-11 14:18:09', '2025-06-11 14:18:09');

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
(20, 'Oficina de PQRS');

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

--
-- Volcado de datos para la tabla `tbl_funcionarios_ops`
--

INSERT INTO `tbl_funcionarios_ops` (`id`, `anio`, `nit`, `nombre_entidad`, `numero_contrato`, `fecha_firma_contrato`, `numero_proceso`, `forma_contratacion`, `codigo_banco_proyecto`, `linea_estrategia`, `fuente_recurso`, `objeto`, `fecha_inicio`, `plazo_contrato`, `valor_contrato`, `clase_contrato`, `nombre_contratista`, `identificacion_contratista`, `sexo`, `direccion_domicilio`, `telefono_contacto`, `correo_electronico`, `edad`, `entidad_bancaria`, `tipo_cuenta`, `numero_cuenta_bancaria`, `numero_disp_presupuestal`, `fecha_disp_presupuestal`, `valor_disp_presupuestal`, `numero_registro_presupuestal`, `fecha_registro_presupuestal`, `valor_registro_presupuestal`, `cod_rubro`, `rubro`, `fuente_financiacion`, `asignado_interventor`, `unidad_ejecucion`, `nombre_interventor`, `identificacion_interventor`, `tipo_vinculacion_interventor`, `fecha_aprobacion_garantia`, `anticipo_contrato`, `valor_pagado_anticipo`, `fecha_pago_anticipo`, `numero_adiciones`, `valor_total_adiciones`, `numero_prorrogas`, `tiempo_prorrogas`, `numero_suspensiones`, `tiempo_suspensiones`, `valor_total_pagos`, `fecha_terminacion`, `fecha_acta_liquidacion`, `estado_contrato`, `observaciones`, `proviene_recurso_reactivacion`, `status`) VALUES
(1, '2025', '800108683', 'ALCALDIA MUNICIPAL DE LA JAGUA DE IBIRICO', '001-2025', '2025-01-28', 'CD 001-2025', 'CONTRATACIÓN DIRECTA', '0', 'N/A', 'ICLD PROPIOS', 'SERVICIOS PROFESIONALES PARA EL REPORTE, SEGUIMIENTO Y MONITOREO DEL SISTEMA ELECTRONICO DE CONTRATACION PUBLICA (SECOP I y SECOP II) EN LA ALCALDIA MUNICIPAL DE LA JAGUA DE IBIRICO, CESAR', '2025-01-28', 'SEIS (06) MESES', 20400000.00, 'PRESTACIÓN DE SERVICIOS PROFESIONALES', 'DINA LUZ ALARCÓN CUELLO', '49.722.659', 'Femenino', 'CALLE 13B N°14-46 BARRIO OBRERO VALLEDUPAR', '5709810', 'dinany1@hotmail.com', 40, 'BBVA COLOMBIA', 'Ahorros', '940344914', 'CDP0021', '2025-01-28', 20400000.00, 'RP0033', '2025-01-29', 20400000.00, '2.1.2.02.02.008.01', 'FUNCIONAMIENTO', 'ICLD-INGRESOS CORRIENTES DE LIBRE DESTINACIÓN', 'SUPERVISOR', 'OFICINA DE CONTRATACIÓN', 'MARIA DEL PILAR URECHE COBO', '26.988.705', 'FUNCIONARIO PÚBLICO', NULL, 0.00, 0.00, NULL, 0, 0.00, 0, '0', 0, '0', 0.00, '2025-01-28', NULL, 'En ejecución', '', 0, 1),
(2, '2025', '800108683', 'ALCALDIA MUNICIPAL DE LA JAGUA DE IBIRICO', '115-2025', '2025-02-28', 'CD 115-2025', 'CONTRATACIÓN DIRECTA', '2025-820400-001', 'N/A', '0', 'SERVICIOS TÉCNICOS DE APOYO A LA GESTIÓN EN LOS PROCESOS DE DIVULGACIÓN Y GENERACIÓN DE CONTENIDO DIGITAL DE LA SECRETARÍA DE PLANEACIÓN Y DESARROLLO ECONÓMICO EN EL MUNICIPIO DE LA JAGUA DE IBIRICO, CESAR', '2025-02-28', 'SEIS (06) MESES', 13194000.00, 'PRESTACIÓN DE SERVICIOS PROFESIONALES', 'ANA CAROLINA MENDOZA MOJICA', '1.007.624.430', 'Femenino', 'CRA 5 # 9-44 BARRIO 5 DE MARZO', '3224558203', 'anacarolinamendozamojica@gmail.com', 24, 'BANCOLOMBIA S.A', 'Ahorros', '91275524820', 'CDP0151', '2025-02-10', 13194000.00, 'RP0245', '2025-02-28', 13194000.00, '2.3.2.02.02.009.45.4599.031', 'INVERSIÓN', 'NACIÓN-DESTINACIÓN ESPECIFICA-SGP', 'SUPERVISOR', '9', 'MAHER SANTOS SOSA', '1.064.117.224', 'FUNCIONARIO PÚBLICO', NULL, 0.00, 0.00, NULL, 0, 0.00, 0, '0', 0, '0', 0.00, NULL, NULL, 'En ejecución', '', 0, 1);

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
  `ciudad_residencia` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `rh` varchar(5) DEFAULT NULL,
  `estudios_realizados` varchar(255) DEFAULT NULL,
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
  `prepensionado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios_planta`
--

INSERT INTO `tbl_funcionarios_planta` (`idefuncionario`, `nombre_completo`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`, `lugar_expedicion`, `libreta_militar`, `tipo_nombramiento`, `nivel`, `salario_basico`, `acto_administrativo`, `fecha_acto_nombramiento`, `no_acta_posesion`, `fecha_acta_posesion`, `tiempo_laborado`, `codigo`, `grado`, `ciudad_residencia`, `fecha_nacimiento`, `lugar_nacimiento`, `rh`, `estudios_realizados`, `titulo`, `tarjeta_profesional`, `otros_estudios`, `cuenta_no`, `banco`, `eps`, `afp`, `afc`, `arl`, `sindicalizado`, `madre_cabeza_hogar`, `prepensionado`) VALUES
(17, 'Elías José Iguaran Márquez', '1003379050', 3, 1, 2, '2147483647', 'Dg 6 5N - 86 / Luis Carlos Galan', 'helias.iguaran@gmail.com', '2025-03-10', 0, '', 'masculino', 'La Jagua de Ibirico', 22, 'casado', 'catolico', 'tecnico', 'Técnico en Sistemas', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Juan Jose pertuz', '123223', 3, 18, 1, '123', '123', 'Juan@gmail.com', '2024-01-02', 0, '', 'masculino', '13', 123, 'casado', 'cristiano', 'bachiller', 'sadasd', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Sebastian tres carnes', '594582384', 33, 11, 2, '1423434', 'Dg 6 5N - 86 / Luis Carlos Galan', 'sofi_castillo@gmail.Ntic.co.com', '2021-06-11', 0, '', 'masculino', 'la jagua de ibirico', 89, 'viudo', 'otro', 'tecnico', 'sadasd', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'juan cardenas', '12324536434', 33, 1, 1, '345678906', '123', 'Juan12@gmail.com', '2023-10-11', 0, '', 'masculino', 'la jagua', 22, 'soltero', 'catolico', 'tecnico', 'sistemas', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(17, 17, '2025-07-07', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-07 14:27:25', 'planta', 0, ''),
(18, 17, '2025-07-08', 7, 2025, 'Asunto familiar', 'Aprobado', '2025-07-07 14:27:34', 'planta', 0, ''),
(19, 20, '2025-07-07', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-07 14:27:39', 'planta', 0, ''),
(20, 18, '2025-07-08', 7, 2025, 'Cita médica', 'Aprobado', '2025-07-07 14:27:46', 'planta', 0, ''),
(21, 19, '2025-07-07', 7, 2025, 'Calamidad doméstica', 'Aprobado', '2025-07-07 15:01:59', 'planta', 0, '');

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

--
-- Volcado de datos para la tabla `tbl_notificaciones`
--

INSERT INTO `tbl_notificaciones` (`id_notificacion`, `id_funcionario`, `tipo`, `mensaje`, `fecha_creacion`, `leido`, `tipo_funcionario`) VALUES
(1, 19, 'tarea', 'Se te ha asignado una nueva tarea: Hola', '2025-06-19 14:57:14', 0, 'planta');

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
  `tipo_funcionario` enum('planta','ops') DEFAULT 'planta',
  `es_permiso_especial` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si es un permiso especial (1) o normal (0)',
  `justificacion_especial` text DEFAULT NULL COMMENT 'Justificación detallada para permisos especiales',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro del permiso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`id_permiso`, `id_funcionario`, `fecha_permiso`, `mes`, `anio`, `motivo`, `estado`, `tipo_funcionario`, `es_permiso_especial`, `justificacion_especial`, `fecha_registro`) VALUES
(48, 17, '2025-07-07', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-07 14:27:25'),
(49, 17, '2025-07-08', 7, 2025, 'Asunto familiar', 'Aprobado', 'planta', 0, '', '2025-07-07 14:27:34'),
(50, 20, '2025-07-07', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-07 14:27:39'),
(51, 18, '2025-07-08', 7, 2025, 'Cita médica', 'Aprobado', 'planta', 0, '', '2025-07-07 14:27:46'),
(52, 19, '2025-07-07', 7, 2025, 'Calamidad doméstica', 'Aprobado', 'planta', 0, '', '2025-07-07 15:01:59');

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
  `status` int(32) NOT NULL,
  `notificaciones_activas` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ideusuario`, `nombres`, `correo`, `password`, `imgperfil`, `rolid`, `status`, `notificaciones_activas`) VALUES
(1, 'Luis Carlos Duran', 'admin.ntic@gmail.com.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'perfil_1.png', 1, 1, 1),
(16, 'Tatiana Alejandra Martínez Meneses', 'gobiernodigital@lajaguadeibirico-cesar.gov.co', 'b3bac4078570ff255b11047d393c5a94a5e94767c426e7fc52e6eba3f44a6b8c', 'sin-imagen.png', 12, 1, 1),
(17, 'Maria Del Pilar Ureche Cobo', 'contratacion@lajaguadeibirico-cesar.gov.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'sin-imagen.png', 4, 1, 1),
(18, 'Moises Xavier Paternina', 'talentohumano@lajaguadeibirico-cesar.gov.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'sin-imagen.png', 2, 1, 1),
(19, 'Fabián Duran Ortiz', 'fabianduran18@hotmail.com', '33882b27b999581a5679bcbe699e4cc2e3cfd37067791c051f17473843e009e8', 'sin-imagen.png', 5, 1, 1),
(20, 'Jesus David Usma Días', 'jesususma721@gmail.com', '34fc34ff9be8e43e04aa773835016ce53a88749408ad81e891bc39e971399ba1', 'sin-imagen.png', 5, 1, 1),
(21, 'Frank Luis Salcedo Redondo', 'fsalcedoredondo@gmail.com', '7cfd9a952732762e1ab94b5cadc90db27bf74720fd24d5aa8876e65f706ab6f4', 'perfil_21.jpg', 5, 1, 1),
(22, 'Elías Iguaran Márquez', 'helias.iguaran@gmail.com', '7e82e7429c766d829ecd23ea74961495b99a065422a670c0a9404716c7343451', 'perfil_22.jpg', 5, 1, 1),
(23, 'Luisa Fernanda Moreno', 'auxiliartic2024@gmail.com', '39253295aea0fd1ade2779006cf41b49376942284013bdb6e5316fcd322a567b', 'sin-imagen.png', 7, 1, 1),
(24, 'Ana Carolina Mendoza', 'anacarolinamendozamojica@gmail.com', '0352709ad6ec43c6d165e948957d5e9b55e2519116147eed3e9f41fab47d91e6', 'sin-imagen.png', 12, 1, 1);

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
(1, 1, 1, '2025-07-07 14:23:16'),
(3, 17, 4, '2025-07-07 14:23:16'),
(4, 18, 2, '2025-07-07 14:23:16'),
(5, 19, 5, '2025-07-07 14:23:16'),
(6, 20, 5, '2025-07-07 14:23:16'),
(7, 21, 5, '2025-07-07 14:23:16'),
(8, 22, 5, '2025-07-07 14:23:16'),
(9, 23, 7, '2025-07-07 14:23:16'),
(10, 24, 12, '2025-07-07 14:23:16'),
(16, 16, 5, '2025-07-07 14:33:52'),
(17, 16, 12, '2025-07-07 14:33:52');

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
-- Volcado de datos para la tabla `tbl_vacaciones`
--

INSERT INTO `tbl_vacaciones` (`id_vacaciones`, `id_funcionario`, `fecha_inicio`, `fecha_fin`, `periodo`, `estado`, `fecha_registro`, `tipo_funcionario`, `tipo_vacaciones`, `valor`, `fecha_pago`) VALUES
(49, 17, '2025-06-11', '2025-06-26', 1, 'Cumplidas', '2025-06-11 02:22:35', 'planta', 'Disfrutadas', 0.00, NULL),
(50, 17, '2025-06-11', '2025-06-26', 1, 'Cumplidas', '2025-06-11 02:27:22', 'planta', 'Disfrutadas', 0.00, NULL),
(51, 17, '2025-06-11', '2025-06-26', 1, 'Cancelado', '2025-06-11 02:34:57', 'planta', 'Disfrutadas', 0.00, NULL),
(52, 17, '2025-06-11', '2025-06-26', 1, 'Cumplidas', '2025-06-11 02:36:33', 'planta', 'Disfrutadas', 0.00, NULL),
(53, 17, '2025-06-11', '2025-06-26', 1, 'Pendiente', '2025-06-11 02:38:56', 'planta', 'Disfrutadas', 0.00, NULL),
(54, 18, '2025-06-11', '2025-06-26', 1, 'Cumplidas', '2025-06-11 02:40:46', 'planta', 'Disfrutadas', 0.00, NULL),
(55, 19, '2025-06-11', '2025-06-26', 1, 'Cumplidas', '2025-06-11 02:40:52', 'planta', 'Disfrutadas', 0.00, NULL),
(56, 20, '2025-06-20', '2025-07-10', 1, 'Aprobado', '2025-06-13 10:17:45', 'planta', 'Disfrutadas', 0.00, NULL),
(57, 18, '2025-07-07', '2025-07-22', 1, 'Pendiente', '2025-07-07 15:07:45', 'planta', 'Disfrutadas', 0.00, NULL);

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
(6, 17, 'salida local', 500000.00, '2025-06-13', '2025-06-16', '2025-06-16', 'transporte y viaticos', 1, '2025-06-13 15:29:25'),
(7, 17, 'asdasd', 10000023.00, '2025-07-07', '2025-07-09', '2025-07-16', 'sadsad', 1, '2025-07-07 14:31:43');

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
-- Indices de la tabla `tbl_motivos_permisos`
--
ALTER TABLE `tbl_motivos_permisos`
  ADD PRIMARY KEY (`id_motivo`);

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
  ADD KEY `idx_fecha_registro` (`fecha_registro`);

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
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1225;

--
-- AUTO_INCREMENT de la tabla `prorrogas_contrato`
--
ALTER TABLE `prorrogas_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

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
  MODIFY `idCapital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT de la tabla `tbl_contratos_practicantes`
--
ALTER TABLE `tbl_contratos_practicantes`
  MODIFY `id_contrato_practicante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  MODIFY `dependencia_pk` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_ops`
--
ALTER TABLE `tbl_funcionarios_ops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios_planta`
--
ALTER TABLE `tbl_funcionarios_planta`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_motivos_permisos`
--
ALTER TABLE `tbl_motivos_permisos`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_observaciones`
--
ALTER TABLE `tbl_observaciones`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tbl_practicantes`
--
ALTER TABLE `tbl_practicantes`
  MODIFY `idepracticante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas_usuarios`
--
ALTER TABLE `tbl_tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios_roles`
--
ALTER TABLE `tbl_usuarios_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
