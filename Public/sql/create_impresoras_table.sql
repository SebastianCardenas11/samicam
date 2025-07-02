-- Crear tabla de impresoras
CREATE TABLE IF NOT EXISTS `tbl_impresoras` (
  `id_impresora` INT AUTO_INCREMENT PRIMARY KEY,
  `numero_impresora` VARCHAR(50) NOT NULL,
  `marca` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `serial` VARCHAR(100) NOT NULL,
  `consumible` VARCHAR(100) DEFAULT NULL,
  `estado` VARCHAR(50) DEFAULT NULL,
  `disponibilidad` VARCHAR(50) DEFAULT NULL,
  `id_dependencia` INT(255) DEFAULT NULL,
  `oficina` VARCHAR(100) DEFAULT NULL,
  `id_funcionario` INT(11) DEFAULT NULL,
  `id_cargo` VARCHAR(100) DEFAULT NULL,
  `id_contacto` VARCHAR(100) DEFAULT NULL,
  `status` TINYINT(1) DEFAULT 1,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia`(`dependencia_pk`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta`(`idefuncionario`) ON DELETE SET NULL ON UPDATE CASCADE
);