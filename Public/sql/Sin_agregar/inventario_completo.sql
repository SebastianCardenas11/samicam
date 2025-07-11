-- ========================================
-- MÓDULO DE INVENTARIO - SAMICAM
-- Estructura completa de tablas
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- TABLA: tbl_impresoras
-- ========================================
CREATE TABLE `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL AUTO_INCREMENT,
  `numero_impresora` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `consumible` varchar(200) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_impresora`),
  KEY `idx_dependencia` (`id_dependencia`),
  KEY `idx_funcionario` (`id_funcionario`),
  KEY `idx_cargo` (`id_cargo`),
  KEY `idx_contacto` (`id_contacto`),
  CONSTRAINT `fk_impresoras_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL,
  CONSTRAINT `fk_impresoras_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL,
  CONSTRAINT `fk_impresoras_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_escaneres
-- ========================================
CREATE TABLE `tbl_escaneres` (
  `id_escaner` int(11) NOT NULL AUTO_INCREMENT,
  `numero_escaner` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_escaner`),
  KEY `idx_dependencia` (`id_dependencia`),
  KEY `idx_funcionario` (`id_funcionario`),
  KEY `idx_cargo` (`id_cargo`),
  KEY `idx_contacto` (`id_contacto`),
  CONSTRAINT `fk_escaneres_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL,
  CONSTRAINT `fk_escaneres_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL,
  CONSTRAINT `fk_escaneres_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_pc_torre
-- ========================================
CREATE TABLE `tbl_pc_torre` (
  `id_pc_torre` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `monitor` varchar(100) DEFAULT NULL,
  `numero_activo_monitor` varchar(100) DEFAULT NULL,
  `serial_monitor` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_pc_torre`),
  KEY `idx_dependencia` (`id_dependencia`),
  KEY `idx_funcionario` (`id_funcionario`),
  KEY `idx_cargo` (`id_cargo`),
  KEY `idx_contacto` (`id_contacto`),
  CONSTRAINT `fk_pc_torre_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL,
  CONSTRAINT `fk_pc_torre_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL,
  CONSTRAINT `fk_pc_torre_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_todo_en_uno
-- ========================================
CREATE TABLE `tbl_todo_en_uno` (
  `id_todo_en_uno` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_todo_en_uno`),
  KEY `idx_dependencia` (`id_dependencia`),
  KEY `idx_funcionario` (`id_funcionario`),
  KEY `idx_cargo` (`id_cargo`),
  KEY `idx_contacto` (`id_contacto`),
  CONSTRAINT `fk_todo_en_uno_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL,
  CONSTRAINT `fk_todo_en_uno_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL,
  CONSTRAINT `fk_todo_en_uno_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_portatiles
-- ========================================
CREATE TABLE `tbl_portatiles` (
  `id_portatil` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `velocidad_ram` varchar(50) DEFAULT NULL,
  `procesador` varchar(100) NOT NULL,
  `velocidad_procesador` varchar(50) DEFAULT NULL,
  `disco_duro` enum('HDD','SSD','Híbrido') NOT NULL DEFAULT 'HDD',
  `capacidad` varchar(50) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `id_dependencia` int(11) DEFAULT NULL,
  `oficina` varchar(100) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_portatil`),
  KEY `idx_dependencia` (`id_dependencia`),
  KEY `idx_funcionario` (`id_funcionario`),
  KEY `idx_cargo` (`id_cargo`),
  KEY `idx_contacto` (`id_contacto`),
  CONSTRAINT `fk_portatiles_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL,
  CONSTRAINT `fk_portatiles_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta` (`idefuncionario`) ON DELETE SET NULL,
  CONSTRAINT `fk_portatiles_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_papeleria
-- ========================================
CREATE TABLE `tbl_papeleria` (
  `id_papeleria` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(200) NOT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_papeleria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_tintas_toner
-- ========================================
CREATE TABLE `tbl_tintas_toner` (
  `id_tinta_toner` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(200) NOT NULL,
  `disponibles` int(11) NOT NULL DEFAULT 0,
  `impresora` varchar(100) DEFAULT NULL,
  `modelos_compatibles` text DEFAULT NULL,
  `fecha_ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tinta_toner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_herramientas
-- ========================================
CREATE TABLE `tbl_herramientas` (
  `id_herramienta` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(200) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_herramienta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- DATOS DE EJEMPLO
-- ========================================

-- Insertar datos de ejemplo para papelería
INSERT INTO `tbl_papeleria` (`item`, `disponibilidad`) VALUES
('Papel Bond Carta', 50),
('Papel Bond Oficio', 30),
('Bolígrafos Azules', 100),
('Bolígrafos Negros', 80),
('Lápices', 60),
('Borradores', 25),
('Correctores', 15),
('Grapas', 200),
('Clips', 500),
('Carpetas Manila', 40),
('Folders', 35),
('Sobres Manila', 100),
('Marcadores', 20),
('Resaltadores', 15);

-- Insertar datos de ejemplo para tintas y tóner
INSERT INTO `tbl_tintas_toner` (`item`, `disponibles`, `impresora`, `modelos_compatibles`) VALUES
('Tóner HP 85A Negro', 5, 'HP LaserJet', 'P1102, P1102w, M1132, M1212nf'),
('Tinta Canon PG-245 Negro', 8, 'Canon PIXMA', 'MG2420, MG2520, MG2920, MX492'),
('Tinta Canon CL-246 Color', 6, 'Canon PIXMA', 'MG2420, MG2520, MG2920, MX492'),
('Tóner Brother TN-450 Negro', 3, 'Brother', 'HL-2240, HL-2270DW, MFC-7360N'),
('Tinta Epson T664 Negro', 4, 'Epson EcoTank', 'L120, L220, L365, L375'),
('Tinta Epson T664 Cian', 3, 'Epson EcoTank', 'L120, L220, L365, L375'),
('Tinta Epson T664 Magenta', 3, 'Epson EcoTank', 'L120, L220, L365, L375'),
('Tinta Epson T664 Amarillo', 3, 'Epson EcoTank', 'L120, L220, L365, L375');

-- Insertar datos de ejemplo para herramientas
INSERT INTO `tbl_herramientas` (`item`, `marca`, `disponibilidad`) VALUES
('Destornillador Phillips', 'Stanley', 5),
('Destornillador Plano', 'Stanley', 4),
('Alicate Universal', 'Klein Tools', 3),
('Multímetro Digital', 'Fluke', 2),
('Pistola de Calor', 'Black & Decker', 1),
('Kit Destornilladores Precisión', 'iFixit', 2),
('Aspiradora Portátil', 'Black & Decker', 1),
('Spray Limpiador Contactos', 'CRC', 3),
('Aire Comprimido', 'Dust-Off', 10),
('Pasta Térmica', 'Arctic Silver', 5);

COMMIT;