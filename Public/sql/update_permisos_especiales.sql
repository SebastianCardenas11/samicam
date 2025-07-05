-- Script para agregar columnas de permisos especiales a la tabla tbl_permisos
-- Ejecutar este script en la base de datos para habilitar la funcionalidad de permisos especiales

-- Agregar columna para indicar si es un permiso especial
ALTER TABLE `tbl_permisos` 
ADD COLUMN `es_permiso_especial` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT 'Indica si es un permiso especial (1) o normal (0)';

-- Agregar columna para la justificación del permiso especial
ALTER TABLE `tbl_permisos` 
ADD COLUMN `justificacion_especial` TEXT NULL 
COMMENT 'Justificación detallada para permisos especiales';

-- Agregar columna para la fecha de registro del permiso
ALTER TABLE `tbl_permisos` 
ADD COLUMN `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora de registro del permiso';

-- Agregar índices para mejorar el rendimiento
ALTER TABLE `tbl_permisos` 
ADD INDEX `idx_es_permiso_especial` (`es_permiso_especial`),
ADD INDEX `idx_fecha_registro` (`fecha_registro`);

-- También agregar las mismas columnas a la tabla de historial
ALTER TABLE `tbl_historial_permisos` 
ADD COLUMN `es_permiso_especial` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT 'Indica si es un permiso especial (1) o normal (0)';

ALTER TABLE `tbl_historial_permisos` 
ADD COLUMN `justificacion_especial` TEXT NULL 
COMMENT 'Justificación detallada para permisos especiales';

-- Agregar índices para la tabla de historial
ALTER TABLE `tbl_historial_permisos` 
ADD INDEX `idx_es_permiso_especial` (`es_permiso_especial`); 