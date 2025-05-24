-- Crear tabla para el capital de viáticos si no existe
CREATE TABLE IF NOT EXISTS `tbl_capital_viaticos` (
  `idCapital` int(11) NOT NULL AUTO_INCREMENT,
  `anio` int(11) NOT NULL,
  `capital_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `capital_disponible` decimal(15,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`idCapital`),
  UNIQUE KEY `anio_UNIQUE` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar capital inicial para el año actual si no existe
INSERT INTO `tbl_capital_viaticos` (`anio`, `capital_total`, `capital_disponible`) 
VALUES (YEAR(CURDATE()), 500000000.00, 500000000.00)
ON DUPLICATE KEY UPDATE `anio` = `anio`;