-- Crear tablas para el módulo de peticiones

-- Tabla de tipos de peticiones
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

-- Insertar tipos de peticiones
INSERT INTO `tbl_tipos_peticion` (`nombre`, `descripcion`, `dias_habiles_plazo`, `color_semaforo`) VALUES
('Derecho de petición', 'Solicitudes de información o documentos bajo derecho de petición', 15, '#ffc107'),
('Tutela', 'Acciones de tutela según disposición judicial', 1, '#dc3545'),
('Documentos e información', 'Solicitudes de documentos e información general', 10, '#17a2b8'),
('Consulta', 'Consultas generales y orientación', 30, '#28a745'),
('Entre entidades', 'Comunicaciones oficiales entre entidades', 10, '#6f42c1'),
('Ente de control', 'Solicitudes de entes de control y supervisión', 5, '#fd7e14');

-- Tabla de dependencias ya existe en la base de datos
-- No es necesario crearla

-- Insertar algunas dependencias básicas
INSERT INTO `tbl_dependencia` (`nombre`) VALUES
('Secretaría General'),
('Tesorería'),
('Planeación'),
('Obras Públicas'),
('Salud'),
('Educación');

-- Tabla principal de peticiones
CREATE TABLE IF NOT EXISTS `tbl_peticiones` (
  `id_peticion` int(11) NOT NULL AUTO_INCREMENT,
  `numero_radicado` varchar(50) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `nombre_peticionario` varchar(255) NOT NULL,
  `descripcion_solicitud` text NOT NULL,
  `id_tipo_peticion` int(11) NOT NULL,
  `areas_responsables` text DEFAULT NULL,
  `fecha_remision` date DEFAULT NULL,
  `consecutivo` varchar(100) DEFAULT NULL,
  `dias_vencer` int(11) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('radicada','en_proceso','respondida','desistida','remitida','vencida') DEFAULT 'radicada',
  `usuario_creador` bigint(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_peticion`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  KEY `idx_estado` (`estado`),
  FOREIGN KEY (`id_tipo_peticion`) REFERENCES `tbl_tipos_peticion`(`id_tipo`),
  FOREIGN KEY (`usuario_creador`) REFERENCES `tbl_usuarios`(`ideusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de días festivos
CREATE TABLE IF NOT EXISTS `tbl_dias_festivos` (
  `id_festivo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL UNIQUE,
  `descripcion` varchar(255) NOT NULL,
  `tipo` enum('nacional','local','religioso') DEFAULT 'nacional',
  `anio` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_festivo`),
  KEY `idx_fecha` (`fecha`),
  KEY `idx_anio` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar días festivos de Colombia 2025
INSERT INTO `tbl_dias_festivos` (`fecha`, `descripcion`, `tipo`, `anio`) VALUES
('2025-01-01', 'Año Nuevo', 'nacional', 2025),
('2025-01-06', 'Día de los Reyes Magos', 'nacional', 2025),
('2025-03-24', 'Día de San José', 'nacional', 2025),
('2025-04-17', 'Jueves Santo', 'religioso', 2025),
('2025-04-18', 'Viernes Santo', 'religioso', 2025),
('2025-05-01', 'Día del Trabajo', 'nacional', 2025),
('2025-05-26', 'Ascensión del Señor', 'religioso', 2025),
('2025-06-16', 'Corpus Christi', 'religioso', 2025),
('2025-06-23', 'Sagrado Corazón de Jesús', 'religioso', 2025),
('2025-06-30', 'San Pedro y San Pablo', 'nacional', 2025),
('2025-07-20', 'Día de la Independencia', 'nacional', 2025),
('2025-08-07', 'Batalla de Boyacá', 'nacional', 2025),
('2025-08-18', 'Asunción de la Virgen', 'religioso', 2025),
('2025-10-13', 'Día de la Raza', 'nacional', 2025),
('2025-11-03', 'Todos los Santos', 'religioso', 2025),
('2025-11-17', 'Independencia de Cartagena', 'nacional', 2025),
('2025-12-08', 'Inmaculada Concepción', 'religioso', 2025),
('2025-12-25', 'Navidad', 'religioso', 2025);

-- Agregar permisos para el módulo de peticiones
INSERT INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(1, 20, 1, 1, 1, 1, 1);