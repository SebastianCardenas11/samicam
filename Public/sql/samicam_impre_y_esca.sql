-- Tabla de Préstamos
CREATE TABLE IF NOT EXISTS `tbl_prestamos` (
  `id_prestamo` INT AUTO_INCREMENT PRIMARY KEY,
  `id_funcionario` INT NOT NULL,
  `fecha_prestamo` DATE NOT NULL,
  `fecha_devolucion` VARCHAR(50) DEFAULT 'INDEFINIDO',
  `item` INT NOT NULL,
  `dispositivo` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `activo` VARCHAR(50),
  `serial` VARCHAR(100),
  `estado` VARCHAR(50),
  `mac` VARCHAR(50),
  `observaciones` TEXT,
  `status` TINYINT(1) DEFAULT 1,
  FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios_planta`(`idefuncionario`)
);

-- Para obtener el cargo y la dependencia, se hace JOIN con tbl_funcionarios_planta, tbl_cargos y tbl_dependencia.

-- Tabla de Salidas
CREATE TABLE IF NOT EXISTS `tbl_salidas` (
  `id_salida` INT AUTO_INCREMENT PRIMARY KEY,
  `item` INT NOT NULL,
  `descripcion_dispositivo` VARCHAR(150) NOT NULL,
  `marca` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `num_activo` VARCHAR(50),
  `sn` VARCHAR(100),
  `dependencia` VARCHAR(100) NOT NULL,
  `observaciones` TEXT,
  `status` TINYINT(1) DEFAULT 1
);

-- Tabla de Ingresos
CREATE TABLE IF NOT EXISTS `tbl_ingresos` (
  `id_ingreso` INT AUTO_INCREMENT PRIMARY KEY,
  `item` INT NOT NULL,
  `descripcion_dispositivo` VARCHAR(150) NOT NULL,
  `marca_modelo` VARCHAR(150) NOT NULL,
  `num_activo` VARCHAR(50),
  `sn` VARCHAR(100),
  `dependencia` VARCHAR(100) NOT NULL,
  `observaciones` TEXT,
  `status` TINYINT(1) DEFAULT 1
);

-- El resto de tablas ya están definidas arriba 