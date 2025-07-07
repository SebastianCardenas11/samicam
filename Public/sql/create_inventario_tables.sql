-- ==================== TABLAS DE INVENTARIO ====================

-- Tabla de Impresoras
CREATE TABLE IF NOT EXISTS `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL AUTO_INCREMENT,
  `numero_impresora` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `consumible` varchar(100) DEFAULT NULL,
  `estado` enum('Activo','Inactivo','En Mantenimiento','Fuera de Servicio') NOT NULL DEFAULT 'Activo',
  `disponibilidad` enum('Disponible','En Uso','Reservado','No Disponible') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_impresora`),
  UNIQUE KEY `numero_impresora` (`numero_impresora`),
  KEY `fk_impresora_dependencia` (`id_dependencia`),
  KEY `fk_impresora_funcionario` (`id_funcionario`),
  KEY `fk_impresora_cargo` (`id_cargo`),
  KEY `fk_impresora_contacto` (`id_contacto`),
  CONSTRAINT `fk_impresora_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencias` (`id_dependencia`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_impresora_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`id_funcionario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_impresora_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`id_cargo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_impresora_contacto` FOREIGN KEY (`id_contacto`) REFERENCES `tbl_contactos` (`id_contacto`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Escáneres
CREATE TABLE IF NOT EXISTS `tbl_escaneres` (
  `id_escaner` int(11) NOT NULL AUTO_INCREMENT,
  `numero_escaner` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `estado` enum('Activo','Inactivo','En Mantenimiento','Fuera de Servicio') NOT NULL DEFAULT 'Activo',
  `disponibilidad` enum('Disponible','En Uso','Reservado','No Disponible') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_escaner`),
  UNIQUE KEY `numero_escaner` (`numero_escaner`),
  KEY `fk_escaner_dependencia` (`id_dependencia`),
  KEY `fk_escaner_funcionario` (`id_funcionario`),
  KEY `fk_escaner_cargo` (`id_cargo`),
  KEY `fk_escaner_contacto` (`id_contacto`),
  CONSTRAINT `fk_escaner_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencias` (`id_dependencia`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_escaner_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`id_funcionario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_escaner_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`id_cargo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_escaner_contacto` FOREIGN KEY (`id_contacto`) REFERENCES `tbl_contactos` (`id_contacto`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Papelería
CREATE TABLE IF NOT EXISTS `tbl_papeleria` (
  `id_articulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_articulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `unidad` enum('Unidades','Cajas','Resmas','Paquetes','Rollos','Libras','Kilogramos') NOT NULL DEFAULT 'Unidades',
  `estado` enum('Disponible','Agotado','En Reposición','Vencido') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_articulo`),
  UNIQUE KEY `nombre_articulo` (`nombre_articulo`),
  KEY `fk_papeleria_dependencia` (`id_dependencia`),
  KEY `fk_papeleria_funcionario` (`id_funcionario`),
  KEY `fk_papeleria_cargo` (`id_cargo`),
  KEY `fk_papeleria_contacto` (`id_contacto`),
  CONSTRAINT `fk_papeleria_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencias` (`id_dependencia`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_papeleria_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`id_funcionario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_papeleria_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`id_cargo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_papeleria_contacto` FOREIGN KEY (`id_contacto`) REFERENCES `tbl_contactos` (`id_contacto`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Contactos (si no existe)
CREATE TABLE IF NOT EXISTS `tbl_contactos` (
  `id_contacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_contacto` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== DATOS DE EJEMPLO ====================

-- Insertar algunos contactos de ejemplo
INSERT INTO `tbl_contactos` (`nombre_contacto`, `telefono`, `email`, `cargo`, `empresa`) VALUES
('Juan Pérez', '3001234567', 'juan.perez@empresa.com', 'Técnico de Soporte', 'TecnoServicios'),
('María García', '3109876543', 'maria.garcia@empresa.com', 'Coordinadora IT', 'SistemasPro'),
('Carlos López', '3155551234', 'carlos.lopez@empresa.com', 'Ingeniero de Sistemas', 'TechSolutions');

-- Insertar algunas impresoras de ejemplo
INSERT INTO `tbl_impresoras` (`numero_impresora`, `marca`, `modelo`, `serial`, `consumible`, `estado`, `disponibilidad`, `id_dependencia`, `oficina`, `id_funcionario`, `id_cargo`, `id_contacto`) VALUES
('IMP001', 'HP', 'LaserJet Pro M404n', 'HP123456789', 'Tóner HP 26A', 'Activo', 'En Uso', 1, 'Oficina Principal', 1, 1, 1),
('IMP002', 'Canon', 'Pixma TS8320', 'CAN987654321', 'Cartuchos Canon 245', 'Activo', 'Disponible', 2, 'Sala de Reuniones', NULL, NULL, 2),
('IMP003', 'Epson', 'WorkForce WF-3720', 'EPS456789123', 'Tintas Epson 101', 'En Mantenimiento', 'No Disponible', 1, 'Área Administrativa', 2, 2, 3);

-- Insertar algunos escáneres de ejemplo
INSERT INTO `tbl_escaneres` (`numero_escaner`, `marca`, `modelo`, `serial`, `estado`, `disponibilidad`, `id_dependencia`, `oficina`, `id_funcionario`, `id_cargo`, `id_contacto`) VALUES
('ESC001', 'HP', 'ScanJet Pro 2500 f1', 'HPSCN123456', 'Activo', 'En Uso', 1, 'Oficina Principal', 1, 1, 1),
('ESC002', 'Canon', 'CanoScan LiDE 300', 'CANSCN789012', 'Activo', 'Disponible', 2, 'Sala de Reuniones', NULL, NULL, 2),
('ESC003', 'Epson', 'Perfection V39', 'EPSSCN345678', 'Inactivo', 'No Disponible', 1, 'Área Administrativa', 2, 2, 3);

-- Insertar algunos artículos de papelería de ejemplo
INSERT INTO `tbl_papeleria` (`nombre_articulo`, `descripcion`, `cantidad`, `unidad`, `estado`, `id_dependencia`, `oficina`, `id_funcionario`, `id_cargo`, `id_contacto`) VALUES
('Papel Bond A4', 'Papel bond blanco tamaño A4', 50, 'Resmas', 'Disponible', 1, 'Oficina Principal', 1, 1, 1),
('Lápices HB', 'Lápices grafito HB marca Faber-Castell', 100, 'Unidades', 'Disponible', 2, 'Sala de Reuniones', NULL, NULL, 2),
('Marcadores Permanentes', 'Marcadores permanentes negros', 25, 'Unidades', 'En Reposición', 1, 'Área Administrativa', 2, 2, 3),
('Carpetas Manila', 'Carpetas manila tamaño carta', 30, 'Unidades', 'Disponible', 1, 'Oficina Principal', 1, 1, 1),
('Cinta Adhesiva', 'Cinta adhesiva transparente', 15, 'Rollos', 'Agotado', 2, 'Sala de Reuniones', NULL, NULL, 2); 