-- ========================================
-- MÓDULO DE INVENTARIO - SAMICAM (SIN FUNCIONARIOS)
-- Estructura simplificada de tablas
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- TABLA: tbl_impresoras (SIMPLIFICADA)
-- ========================================
CREATE TABLE `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL AUTO_INCREMENT,
  `numero_impresora` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `consumible` varchar(200) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_impresora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_escaneres (SIMPLIFICADA)
-- ========================================
CREATE TABLE `tbl_escaneres` (
  `id_escaner` int(11) NOT NULL AUTO_INCREMENT,
  `numero_escaner` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_escaner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_pc_torre (SIMPLIFICADA)
-- ========================================
CREATE TABLE `tbl_pc_torre` (
  `id_pc_torre` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pc` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
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
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_pc_torre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_todo_en_uno (SIMPLIFICADA)
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
  `serial` varchar(100) DEFAULT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_todo_en_uno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_portatiles (SIMPLIFICADA)
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
  `serial` varchar(100) DEFAULT NULL,
  `sistema_operativo` varchar(100) DEFAULT NULL,
  `numero_activo` varchar(100) DEFAULT NULL,
  `estado` enum('Excelente','Bueno','Regular','Malo','Dañado') NOT NULL DEFAULT 'Bueno',
  `disponibilidad` enum('Disponible','En uso','En reparación','Fuera de servicio') NOT NULL DEFAULT 'Disponible',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_portatil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TABLA: tbl_papeleria (SIN CAMBIOS)
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
-- TABLA: tbl_tintas_toner (SIN CAMBIOS)
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
-- TABLA: tbl_herramientas (SIN CAMBIOS)
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

COMMIT;