-- Script SQL para el módulo de Hojas de Vida de Equipos
-- Verificar si la tabla de movimientos de equipos existe, si no, crearla

CREATE TABLE IF NOT EXISTS `tbl_equipos_movimientos` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` int(11) NOT NULL,
  `tipo_equipo` varchar(50) NOT NULL,
  `tipo_movimiento` enum('entrada','salida') NOT NULL,
  `observacion` text,
  `fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(100) NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `idx_equipo_tipo` (`id_equipo`, `tipo_equipo`),
  KEY `idx_fecha` (`fecha_hora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos datos de ejemplo si la tabla está vacía
INSERT IGNORE INTO `tbl_equipos_movimientos` (`id_equipo`, `tipo_equipo`, `tipo_movimiento`, `observacion`, `fecha_hora`, `usuario`) VALUES
(1, 'impresora', 'entrada', 'Mantenimiento preventivo programado', '2024-01-15 09:00:00', 'admin'),
(1, 'impresora', 'salida', 'Mantenimiento completado exitosamente', '2024-01-15 11:30:00', 'admin'),
(2, 'pc_torre', 'entrada', 'Actualización de sistema operativo', '2024-01-20 14:00:00', 'admin'),
(2, 'pc_torre', 'salida', 'Sistema actualizado y funcionando correctamente', '2024-01-20 16:45:00', 'admin');