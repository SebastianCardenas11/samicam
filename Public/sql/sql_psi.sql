CREATE TABLE IF NOT EXISTS tbl_prestamos (
  id_prestamos INT AUTO_INCREMENT PRIMARY KEY,
  dependencia VARCHAR(100) NOT NULL,
  funcionario_responsable VARCHAR(100) NOT NULL,
  cargo_funcionario VARCHAR(100) NOT NULL,
  fecha_prestamo DATE NOT NULL,
  fecha_devolucion DATE DEFAULT NULL,
  item VARCHAR(100) NOT NULL,
  dispositivo VARCHAR(100) NOT NULL,
  marca_modelo VARCHAR(100) NOT NULL,
  activo VARCHAR(100) NOT NULL,
  serial VARCHAR(100) NOT NULL,
  estado VARCHAR(50) NOT NULL,
  mac VARCHAR(50) DEFAULT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 