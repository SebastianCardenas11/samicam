CREATE TABLE IF NOT EXISTS tbl_prestamos (
  id_prestamos INT AUTO_INCREMENT PRIMARY KEY,
  tipo_funcionario ENUM('planta', 'ops') NOT NULL DEFAULT 'planta',
  funcionario_responsable VARCHAR(100) NOT NULL,
  dependencia VARCHAR(100) NOT NULL,
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
  equipo_id INT DEFAULT NULL,
  equipo_tipo VARCHAR(50) DEFAULT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
  equipo_id INT DEFAULT NULL,
  equipo_tipo VARCHAR(50) DEFAULT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
  equipo_id INT DEFAULT NULL,
  equipo_tipo VARCHAR(50) DEFAULT NULL,
  observaciones TEXT DEFAULT NULL,
  status TINYINT(1) DEFAULT 1,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

-- Agregar numero_activo a tablas de inventario si no existen
ALTER TABLE tbl_impresoras 
ADD COLUMN IF NOT EXISTS numero_activo VARCHAR(100);

ALTER TABLE tbl_escaneres 
ADD COLUMN IF NOT EXISTS numero_activo VARCHAR(100);

-- Crear tabla de funcionarios planta si no existe
CREATE TABLE IF NOT EXISTS tbl_funcionarios_planta (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(200) NOT NULL,
  dependencia VARCHAR(100) NOT NULL,
  cargo VARCHAR(100) NOT NULL,
  status TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Crear tabla de funcionarios OPS si no existe
CREATE TABLE IF NOT EXISTS tbl_funcionarios_ops (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(200) NOT NULL,
  dependencia VARCHAR(100) NOT NULL,
  cargo VARCHAR(100) NOT NULL,
  status TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Índices para mejorar rendimiento
CREATE INDEX IF NOT EXISTS idx_prestamos_funcionario ON tbl_prestamos(funcionario_responsable);
CREATE INDEX IF NOT EXISTS idx_prestamos_fecha ON tbl_prestamos(fecha_prestamo);
CREATE INDEX IF NOT EXISTS idx_prestamos_equipo ON tbl_prestamos(equipo_id, equipo_tipo);

CREATE INDEX IF NOT EXISTS idx_salidas_fecha ON tbl_psi_salidas(fecha);
CREATE INDEX IF NOT EXISTS idx_salidas_equipo ON tbl_psi_salidas(equipo_id, equipo_tipo);

CREATE INDEX IF NOT EXISTS idx_ingresos_fecha ON tbl_psi_ingresos(fecha);
CREATE INDEX IF NOT EXISTS idx_ingresos_equipo ON tbl_psi_ingresos(equipo_id, equipo_tipo);
