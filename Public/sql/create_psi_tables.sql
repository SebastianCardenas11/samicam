-- ==================== TABLAS DE PSI ====================

-- Tabla de Préstamos
CREATE TABLE IF NOT EXISTS `tbl_psi_prestamos` (
  `id_prestamo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `elemento` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` enum('Activo','Devuelto','Pendiente') NOT NULL DEFAULT 'Activo',
  `observaciones` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_prestamo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Salidas
CREATE TABLE IF NOT EXISTS `tbl_psi_salidas` (
  `id_salida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `elemento` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_salida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Ingresos
CREATE TABLE IF NOT EXISTS `tbl_psi_ingresos` (
  `id_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `elemento` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `origen` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_ingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 