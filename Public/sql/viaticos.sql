ALTER TABLE `tbl_viaticos`
-- Cambiar nombre de columnas
CHANGE COLUMN `monto` `valor_viatico` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
CHANGE COLUMN `uso` `tipo_transporte` VARCHAR(255) NOT NULL,

-- Agregar nuevas columnas
ADD COLUMN `cargo` VARCHAR(255) NOT NULL AFTER `funci_fk`,
ADD COLUMN `dependencia` VARCHAR(255) NOT NULL AFTER `cargo`,
ADD COLUMN `motivo_gasto` VARCHAR(255) NOT NULL AFTER `dependencia`,
ADD COLUMN `lugar_comision_departamento` VARCHAR(255) NOT NULL AFTER `motivo_gasto`,
ADD COLUMN `lugar_comision_ciudad` VARCHAR(255) NOT NULL AFTER `lugar_comision_departamento`,
ADD COLUMN `finalidad_comision` TEXT NOT NULL AFTER `lugar_comision_ciudad`,
ADD COLUMN `n_dias` INT(3) NOT NULL AFTER `fecha_regreso`,
ADD COLUMN `valor_dia` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `n_dias`,
ADD COLUMN `valor_transporte` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `valor_dia`,
ADD COLUMN `total_liquidado` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `valor_transporte`,

-- Cambiar la columna `estatus` (por si no tiene valor por defecto)
MODIFY COLUMN `estatus` TINYINT(1) NOT NULL DEFAULT 1,

-- Asegurar campo fecha_creacion
MODIFY COLUMN `fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
