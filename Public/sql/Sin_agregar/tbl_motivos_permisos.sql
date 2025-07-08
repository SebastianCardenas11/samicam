-- Tabla para motivos de permisos
CREATE TABLE IF NOT EXISTS `tbl_motivos_permisos` (
  `id_motivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_motivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos motivos por defecto
INSERT INTO `tbl_motivos_permisos` (`nombre`, `descripcion`, `status`) VALUES
('Cita médica', 'Permiso para asistir a cita médica personal', 1),
('Diligencias personales', 'Permiso para realizar diligencias de carácter personal', 1),
('Emergencia familiar', 'Permiso por emergencia o situación familiar urgente', 1),
('Trámites bancarios', 'Permiso para realizar trámites en entidades bancarias', 1),
('Cita odontológica', 'Permiso para asistir a cita odontológica', 1),
('Gestión académica', 'Permiso para asuntos relacionados con estudios', 1);