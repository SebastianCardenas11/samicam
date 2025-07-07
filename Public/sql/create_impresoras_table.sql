-- Tabla de Impresoras para SAMICAM (solo referencia a funcionario)
CREATE TABLE IF NOT EXISTS `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL AUTO_INCREMENT,
  `numero_impresora` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `consumible` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Dañado','Baja') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','Prestado') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(255) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_contacto` varchar(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_impresora`),
  UNIQUE KEY `numero_impresora` (`numero_impresora`),
  KEY `fk_impresora_funcionario` (`id_funcionario`),
  CONSTRAINT `fk_impresora_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;