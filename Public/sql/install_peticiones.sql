-- Script de instalación rápida para módulo de Peticiones
-- Ejecutar este archivo en phpMyAdmin o línea de comandos

-- 1. Agregar módulo
INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(20, 'Peticiones PQRs', 'Gestión de Peticiones, Quejas, Reclamos y Sugerencias', 1);

-- 2. Agregar permisos para Superadministrador
INSERT INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(1, 20, 1, 1, 1, 1, 1);

-- 3. Crear tablas básicas
CREATE TABLE IF NOT EXISTS `tbl_tipos_peticion` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `dias_habiles_plazo` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_tipos_peticion` (`nombre`, `dias_habiles_plazo`) VALUES
('Derecho de petición', 15),
('Tutela', 1),
('Documentos e información', 10),
('Consulta', 30),
('Entre entidades', 10),
('Ente de control', 5);

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
  `observaciones` text DEFAULT NULL,
  `usuario_creador` bigint(20) NOT NULL,
  `usuario_responsable` bigint(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_peticion`),
  UNIQUE KEY `numero_radicado` (`numero_radicado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;