-- Script para actualizar la estructura de la base de datos
-- Renombrar la tabla actual de funcionarios a funcionarios_planta
RENAME TABLE tbl_funcionarios TO tbl_funcionarios_planta;

-- Crear la nueva tabla para funcionarios OPS
CREATE TABLE `tbl_funcionarios_ops` (
  `idefuncionario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `imagen` varchar(300) DEFAULT NULL,
  `nm_identificacion` int(255) DEFAULT NULL,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `contrato_fk` int(10) NOT NULL,
  `celular` int(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo_elc` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `hijos` int(11) DEFAULT NULL,
  `nombres_de_hijos` varchar(255) DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `lugar_de_residencia` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `formacion_academica` varchar(255) DEFAULT NULL,
  `nombre_formacion` varchar(255) DEFAULT NULL,
  `status` int(15) NOT NULL,
  PRIMARY KEY (`idefuncionario`),
  KEY `cargo_fk` (`cargo_fk`),
  KEY `dependencia_fk` (`dependencia_fk`),
  KEY `contrato_fk` (`contrato_fk`),
  CONSTRAINT `tbl_funcionarios_ops_ibfk_1` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`),
  CONSTRAINT `tbl_funcionarios_ops_ibfk_2` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_funcionarios_ops_ibfk_3` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Migrar los funcionarios OPS de la tabla original a la nueva tabla
INSERT INTO tbl_funcionarios_ops (
  idefuncionario, nombre_completo, imagen, nm_identificacion, cargo_fk, 
  dependencia_fk, contrato_fk, celular, direccion, correo_elc, 
  fecha_ingreso, hijos, nombres_de_hijos, sexo, lugar_de_residencia, 
  edad, estado_civil, religion, formacion_academica, nombre_formacion, status
)
SELECT 
  idefuncionario, nombre_completo, imagen, nm_identificacion, cargo_fk, 
  dependencia_fk, contrato_fk, celular, direccion, correo_elc, 
  fecha_ingreso, hijos, nombres_de_hijos, sexo, lugar_de_residencia, 
  edad, estado_civil, religion, formacion_academica, nombre_formacion, status
FROM tbl_funcionarios_planta
WHERE contrato_fk IN (SELECT id_contrato FROM tbl_contrato WHERE tipo_cont IN ('Ops', 'Otros'));

-- Eliminar los funcionarios OPS de la tabla de funcionarios de planta
DELETE FROM tbl_funcionarios_planta 
WHERE contrato_fk IN (SELECT id_contrato FROM tbl_contrato WHERE tipo_cont IN ('Ops', 'Otros'));

-- Actualizar las referencias en la tabla de vacaciones
ALTER TABLE tbl_vacaciones
ADD COLUMN tipo_funcionario ENUM('planta', 'ops') DEFAULT 'planta';

-- Actualizar las referencias en la tabla de permisos
ALTER TABLE tbl_permisos
ADD COLUMN tipo_funcionario ENUM('planta', 'ops') DEFAULT 'planta';

-- Actualizar las referencias en la tabla de historial_permisos
ALTER TABLE tbl_historial_permisos
ADD COLUMN tipo_funcionario ENUM('planta', 'ops') DEFAULT 'planta';

-- Actualizar las referencias en la tabla de notificaciones
ALTER TABLE tbl_notificaciones
ADD COLUMN tipo_funcionario ENUM('planta', 'ops') DEFAULT 'planta';

-- Actualizar las referencias en la tabla de viaticos
ALTER TABLE tbl_viaticos
ADD COLUMN tipo_funcionario ENUM('planta', 'ops') DEFAULT 'planta';