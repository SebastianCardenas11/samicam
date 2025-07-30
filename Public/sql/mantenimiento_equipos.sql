-- Tabla para registrar mantenimientos de equipos
CREATE TABLE IF NOT EXISTS `tbl_mantenimientos_equipos` (
  `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT,
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
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_mantenimiento`),
  KEY `idx_equipo_tipo` (`id_equipo`, `tipo_equipo`),
  KEY `idx_fecha` (`fecha_mantenimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;