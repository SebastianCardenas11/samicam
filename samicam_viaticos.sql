-- Crear tabla para el presupuesto anual de viáticos
CREATE TABLE IF NOT EXISTS `tbl_capital_viaticos` (
  `idCapital` int(11) NOT NULL AUTO_INCREMENT,
  `anio` int(4) NOT NULL,
  `capital_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `capital_disponible` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idCapital`),
  UNIQUE KEY `anio_unique` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para los viáticos
CREATE TABLE IF NOT EXISTS `tbl_viaticos` (
  `idViatico` int(11) NOT NULL AUTO_INCREMENT,
  `funci_fk` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha` date NOT NULL,
  `uso` text NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idViatico`),
  KEY `funci_fk` (`funci_fk`),
  CONSTRAINT `tbl_viaticos_ibfk_1` FOREIGN KEY (`funci_fk`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar presupuesto para el año actual
INSERT INTO `tbl_capital_viaticos` (`anio`, `capital_total`, `capital_disponible`) VALUES
(YEAR(CURRENT_DATE()), 500000000.00, 500000000.00);