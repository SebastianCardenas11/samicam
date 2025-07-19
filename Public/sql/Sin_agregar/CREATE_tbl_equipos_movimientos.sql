-- ========================================
-- CREAR TABLA: tbl_equipos_movimientos (Histórico global de movimientos de equipos)
-- ========================================

CREATE TABLE IF NOT EXISTS `tbl_equipos_movimientos` (
  `id_movimiento` INT NOT NULL AUTO_INCREMENT,
  `id_equipo` INT NOT NULL,
  `tipo_equipo` ENUM('impresora','pc_torre','todo_en_uno','portatil','escaner','herramienta','otro') NOT NULL,
  `tipo_movimiento` ENUM('entrada','salida') NOT NULL,
  `observacion` TEXT,
  `fecha_hora` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `idx_equipo` (`id_equipo`, `tipo_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar algunos datos de ejemplo para pruebas
INSERT INTO `tbl_equipos_movimientos` (`id_equipo`, `tipo_equipo`, `tipo_movimiento`, `observacion`, `usuario`) VALUES
(1, 'impresora', 'entrada', 'Mantenimiento preventivo', 'Sistema'),
(1, 'impresora', 'salida', 'Mantenimiento completado', 'Sistema'),
(2, 'pc_torre', 'entrada', 'Reparación de disco duro', 'Sistema'),
(3, 'portatil', 'entrada', 'Cambio de teclado', 'Sistema'); 