-- Crear tablas para el sistema de tareas si no existen

-- Tabla principal de tareas
CREATE TABLE IF NOT EXISTS `tbl_tareas` (
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_creador` int(11) NOT NULL,
  `id_usuario_asignado` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `dependencia_fk` int(11) NOT NULL,
  `estado` enum('sin empezar','en curso','completada') DEFAULT 'sin empezar',
  `observacion` text,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_completada` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tarea`),
  KEY `idx_usuario_asignado` (`id_usuario_asignado`),
  KEY `idx_usuario_creador` (`id_usuario_creador`),
  KEY `idx_dependencia` (`dependencia_fk`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_fin` (`fecha_fin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de relación tareas-usuarios (para múltiples asignados)
CREATE TABLE IF NOT EXISTS `tbl_tareas_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tarea_usuario` (`id_tarea`,`id_usuario`),
  KEY `idx_tarea` (`id_tarea`),
  KEY `idx_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de observaciones de tareas
CREATE TABLE IF NOT EXISTS `tbl_observaciones` (
  `id_observacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `observacion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_observacion`),
  KEY `idx_tarea` (`id_tarea`),
  KEY `idx_usuario` (`id_usuario`),
  KEY `idx_fecha` (`fecha_creacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo para pruebas (solo si no existen tareas)
INSERT IGNORE INTO `tbl_tareas` (`id_tarea`, `id_usuario_creador`, `id_usuario_asignado`, `tipo`, `descripcion`, `dependencia_fk`, `estado`, `fecha_inicio`, `fecha_fin`, `fecha_completada`) VALUES
(1, 1, 1, 'Mantenimiento', 'Actualización de sistema operativo en equipos de oficina', 1, 'completada', '2024-12-01', '2024-12-05', '2024-12-04'),
(2, 1, 1, 'Soporte Técnico', 'Configuración de red en nueva oficina', 1, 'en curso', '2024-12-10', '2024-12-20', NULL),
(3, 1, 1, 'Desarrollo', 'Implementación de módulo de reportes', 1, 'sin empezar', '2024-12-15', '2024-12-30', NULL),
(4, 1, 1, 'Mantenimiento', 'Backup de base de datos mensual', 1, 'completada', '2024-11-01', '2024-11-02', '2024-11-01'),
(5, 1, 1, 'Soporte Técnico', 'Instalación de software en equipos nuevos', 1, 'completada', '2024-11-15', '2024-11-18', '2024-11-17');

-- Insertar relaciones tarea-usuario de ejemplo
INSERT IGNORE INTO `tbl_tareas_usuarios` (`id_tarea`, `id_usuario`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1);

-- Insertar observaciones de ejemplo
INSERT IGNORE INTO `tbl_observaciones` (`id_tarea`, `id_usuario`, `observacion`) VALUES
(1, 1, 'Tarea completada exitosamente. Todos los equipos actualizados.'),
(2, 1, 'Progreso del 60%. Configuración de switches completada.'),
(4, 1, 'Backup realizado sin inconvenientes.'),
(5, 1, 'Software instalado en 15 equipos nuevos.');