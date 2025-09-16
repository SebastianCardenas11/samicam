-- Script para corregir el módulo de peticiones
-- Verificar y crear tablas faltantes

-- Crear tabla de tipos de petición si no existe
CREATE TABLE IF NOT EXISTS `tbl_tipos_peticion` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `dias_habiles_plazo` int(11) NOT NULL,
  `color_semaforo` varchar(7) DEFAULT '#28a745',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar tipos de peticiones básicos si no existen
INSERT IGNORE INTO `tbl_tipos_peticion` (`id_tipo`, `nombre`, `descripcion`, `dias_habiles_plazo`, `color_semaforo`) VALUES
(1, 'Derecho de petición', 'Solicitudes de información o documentos bajo derecho de petición', 15, '#ffc107'),
(2, 'Tutela', 'Acciones de tutela según disposición judicial', 1, '#dc3545'),
(3, 'Documentos e información', 'Solicitudes de documentos e información general', 10, '#17a2b8'),
(4, 'Consulta', 'Consultas generales y orientación', 30, '#28a745'),
(5, 'Entre entidades', 'Comunicaciones oficiales entre entidades', 10, '#6f42c1'),
(6, 'Ente de control', 'Solicitudes de entes de control y supervisión', 5, '#fd7e14');

-- Verificar que la tabla tbl_peticiones tenga la estructura correcta
-- Si no existe, crearla
CREATE TABLE IF NOT EXISTS `tbl_peticiones` (
  `id_peticion` int(11) NOT NULL AUTO_INCREMENT,
  `numero_radicado` varchar(50) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `nombre_peticionario` varchar(255) NOT NULL,
  `descripcion_solicitud` text NOT NULL,
  `id_tipo_peticion` int(11) NOT NULL,
  `dependencia_responsable` int(11) DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `dias_habiles_restantes` int(11) DEFAULT 0,
  `estado_semaforo` enum('verde','amarillo','rojo') DEFAULT 'verde',
  `estado` enum('radicada','en_proceso','respondida','desistida','remitida','vencida') DEFAULT 'radicada',
  `fecha_respuesta` date DEFAULT NULL,
  `dias_habiles_respuesta` int(11) DEFAULT NULL,
  `archivo_respuesta` varchar(255) DEFAULT NULL,
  `comentario_respuesta` text DEFAULT NULL,
  `area_remitida` int(11) DEFAULT NULL,
  `motivo_remision` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `usuario_creador` bigint(20) NOT NULL,
  `usuario_responsable` bigint(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_peticion`),
  UNIQUE KEY `numero_radicado` (`numero_radicado`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  KEY `idx_estado` (`estado`),
  KEY `idx_estado_semaforo` (`estado_semaforo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de historial si no existe
CREATE TABLE IF NOT EXISTS `tbl_peticiones_historial` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_peticion` int(11) NOT NULL,
  `estado_anterior` varchar(50) DEFAULT NULL,
  `estado_nuevo` varchar(50) NOT NULL,
  `comentario` text DEFAULT NULL,
  `usuario` bigint(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_historial`),
  KEY `idx_peticion` (`id_peticion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de notificaciones si no existe
CREATE TABLE IF NOT EXISTS `tbl_peticiones_notificaciones` (
  `id_notificacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_peticion` int(11) NOT NULL,
  `tipo_notificacion` enum('creacion','vencimiento_proximo','vencida','respondida','remitida') NOT NULL,
  `mensaje` text NOT NULL,
  `usuarios_notificados` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `enviado` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_notificacion`),
  KEY `idx_peticion` (`id_peticion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Verificar que el módulo esté en la tabla de módulos
INSERT IGNORE INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(20, 'Peticiones PQRs', 'Gestión de Peticiones, Quejas, Reclamos y Sugerencias', 1);

-- Verificar permisos para el superadministrador
INSERT IGNORE INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(1, 20, 1, 1, 1, 1, 1);