-- Crear tablas faltantes para peticiones

-- Tabla de tipos de peticiones
CREATE TABLE `tbl_tipos_peticion` (
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
INSERT INTO `tbl_tipos_peticion` (`nombre`, `descripcion`, `dias_habiles_plazo`) VALUES
('Derecho de petición', 'Solicitudes de información o documentos', 15),
('Tutela', 'Acciones de tutela según disposición judicial', 1),
('Documentos e información', 'Solicitudes de documentos e información general', 10),
('Consulta', 'Consultas generales y orientación', 30),
('Entre entidades', 'Comunicaciones oficiales entre entidades', 10),
('Ente de control', 'Solicitudes de entes de control', 5);

-- Tabla de dependencias
CREATE TABLE `tbl_dependencia` (
  `dependencia_pk` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dependencia_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar dependencias básicas
INSERT INTO `tbl_dependencia` (`nombre`) VALUES
('Secretaría General'),
('Tesorería'),
('Planeación'),
('Obras Públicas'),
('Salud'),
('Educación');

-- Tabla principal de peticiones
CREATE TABLE `tbl_peticiones` (
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
  PRIMARY KEY (`id_peticion`),
  FOREIGN KEY (`id_tipo_peticion`) REFERENCES `tbl_tipos_peticion`(`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de días festivos
CREATE TABLE `tbl_dias_festivos` (
  `id_festivo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL UNIQUE,
  `descripcion` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_festivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar días festivos 2025
INSERT INTO `tbl_dias_festivos` (`fecha`, `descripcion`) VALUES
('2025-01-01', 'Año Nuevo'),
('2025-01-06', 'Reyes Magos'),
('2025-04-17', 'Jueves Santo'),
('2025-04-18', 'Viernes Santo'),
('2025-05-01', 'Día del Trabajo'),
('2025-07-20', 'Día de la Independencia'),
('2025-08-07', 'Batalla de Boyacá'),
('2025-12-25', 'Navidad');