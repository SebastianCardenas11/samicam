-- Tabla para gestionar las liquidaciones de contratos
CREATE TABLE IF NOT EXISTS `liquidaciones` (
  `id_liquidacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `tipo_liquidacion` varchar(50) NOT NULL,
  `fecha_liquidacion` date NOT NULL,
  `valor_liquidado` decimal(15,2) NOT NULL DEFAULT 0.00,
  `estado` enum('Pendiente','En Proceso','Completada','Rechazada') NOT NULL DEFAULT 'Pendiente',
  `responsable` varchar(100) NOT NULL,
  `numero_acta` varchar(50) DEFAULT NULL,
  `valor_ejecutado` decimal(15,2) DEFAULT 0.00,
  `saldo_por_ejecutar` decimal(15,2) DEFAULT 0.00,
  `multas` decimal(15,2) DEFAULT 0.00,
  `descuentos` decimal(15,2) DEFAULT 0.00,
  `observaciones` text,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_liquidacion`),
  KEY `fk_liquidacion_contrato` (`id_contrato`),
  CONSTRAINT `fk_liquidacion_contrato` FOREIGN KEY (`id_contrato`) REFERENCES `seguimiento_contrato` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Insertar algunos datos de ejemplo
INSERT INTO `liquidaciones` (`id_contrato`, `tipo_liquidacion`, `fecha_liquidacion`, `valor_liquidado`, `estado`, `responsable`, `numero_acta`, `valor_ejecutado`, `saldo_por_ejecutar`, `multas`, `descuentos`, `observaciones`) VALUES
(1, 'Total', '2024-01-15', 50000000.00, 'Completada', 'Juan Pérez', 'ACT-001-2024', 48000000.00, 2000000.00, 0.00, 0.00, 'Liquidación total del contrato ejecutada satisfactoriamente'),
(2, 'Parcial', '2024-02-20', 25000000.00, 'En Proceso', 'María González', 'ACT-002-2024', 23000000.00, 2000000.00, 500000.00, 0.00, 'Liquidación parcial - primer avance del proyecto'),
(3, 'Anticipada', '2024-03-10', 15000000.00, 'Pendiente', 'Carlos Rodríguez', NULL, 14000000.00, 1000000.00, 0.00, 200000.00, 'Liquidación anticipada por terminación del contrato');

-- Índices adicionales para mejorar el rendimiento
CREATE INDEX idx_liquidaciones_fecha ON liquidaciones(fecha_liquidacion);
CREATE INDEX idx_liquidaciones_estado ON liquidaciones(estado);
CREATE INDEX idx_liquidaciones_tipo ON liquidaciones(tipo_liquidacion);