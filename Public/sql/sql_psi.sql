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

CREATE TABLE IF NOT EXISTS tbl_psi_salidas (
  id_salida INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL,
  item VARCHAR(100) NOT NULL,
  tipo_dispositivo ENUM('interno', 'externo') NOT NULL,
  descripcion_dispositivo VARCHAR(255) NOT NULL,
  marca VARCHAR(100) NOT NULL,
  modelo VARCHAR(100) NOT NULL,
  numero_activo VARCHAR(100) NOT NULL,
  serial VARCHAR(100) NOT NULL,
  dependencia VARCHAR(100) NOT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_psi_ingresos (
  id_ingreso INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL,
  item VARCHAR(100) NOT NULL,
  tipo_dispositivo ENUM('interno', 'externo') NOT NULL,
  descripcion_dispositivo VARCHAR(255) NOT NULL,
  marca VARCHAR(100) NOT NULL,
  modelo VARCHAR(100) NOT NULL,
  numero_activo VARCHAR(100) NOT NULL,
  serial VARCHAR(100) NOT NULL,
  dependencia VARCHAR(100) NOT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

-- para agregar el numero de activo a las tablas de impresoras y escaneres

ALTER TABLE tbl_impresoras
ADD COLUMN numero_activo VARCHAR(100);

ALTER TABLE tbl_escaneres
ADD COLUMN numero_activo VARCHAR(100);
