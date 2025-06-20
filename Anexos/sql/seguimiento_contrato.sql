CREATE TABLE `seguimiento_contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objeto_contrato` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_terminacion` date NOT NULL,
  `plazo_meses` int(11) NOT NULL,
  `valor_total_contrato` decimal(20,2) NOT NULL,
  `dia_corte_informe` date NOT NULL,
  `observaciones_ejecucion` text DEFAULT NULL,
  `evidenciado_secop` varchar(255) DEFAULT NULL,
  `fecha_verificacion` date DEFAULT NULL,
  `liquidacion` decimal(20,2) DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1,
  `numero_contrato` varchar(50) DEFAULT NULL,
  `fecha_aprobacion_entidad` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 