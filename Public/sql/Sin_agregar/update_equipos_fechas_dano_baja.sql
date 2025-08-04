-- ========================================
-- ACTUALIZACIÓN MÓDULO DE INVENTARIO - SAMICAM
-- Agregar campos de fecha de daño y fecha de baja
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- AGREGAR CAMPOS A TABLA: tbl_impresoras
-- ========================================
ALTER TABLE `tbl_impresoras` 
ADD COLUMN `fecha_dano` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo' AFTER `disponibilidad`,
ADD COLUMN `fecha_baja` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja' AFTER `fecha_dano`;

-- ========================================
-- AGREGAR CAMPOS A TABLA: tbl_escaneres
-- ========================================
ALTER TABLE `tbl_escaneres` 
ADD COLUMN `fecha_dano` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo' AFTER `disponibilidad`,
ADD COLUMN `fecha_baja` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja' AFTER `fecha_dano`;

-- ========================================
-- AGREGAR CAMPOS A TABLA: tbl_pc_torre
-- ========================================
ALTER TABLE `tbl_pc_torre` 
ADD COLUMN `fecha_dano` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo' AFTER `disponibilidad`,
ADD COLUMN `fecha_baja` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja' AFTER `fecha_dano`;

-- ========================================
-- AGREGAR CAMPOS A TABLA: tbl_todo_en_uno
-- ========================================
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `fecha_dano` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo' AFTER `disponibilidad`,
ADD COLUMN `fecha_baja` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja' AFTER `fecha_dano`;

-- ========================================
-- AGREGAR CAMPOS A TABLA: tbl_portatiles
-- ========================================
ALTER TABLE `tbl_portatiles` 
ADD COLUMN `fecha_dano` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se marcó como dañado/malo' AFTER `disponibilidad`,
ADD COLUMN `fecha_baja` DATE NULL DEFAULT NULL COMMENT 'Fecha cuando el equipo se dio de baja' AFTER `fecha_dano`;

-- ========================================
-- CREAR ÍNDICES PARA OPTIMIZAR CONSULTAS
-- ========================================
ALTER TABLE `tbl_impresoras` ADD INDEX `idx_fecha_dano` (`fecha_dano`);
ALTER TABLE `tbl_impresoras` ADD INDEX `idx_fecha_baja` (`fecha_baja`);

ALTER TABLE `tbl_escaneres` ADD INDEX `idx_fecha_dano` (`fecha_dano`);
ALTER TABLE `tbl_escaneres` ADD INDEX `idx_fecha_baja` (`fecha_baja`);

ALTER TABLE `tbl_pc_torre` ADD INDEX `idx_fecha_dano` (`fecha_dano`);
ALTER TABLE `tbl_pc_torre` ADD INDEX `idx_fecha_baja` (`fecha_baja`);

ALTER TABLE `tbl_todo_en_uno` ADD INDEX `idx_fecha_dano` (`fecha_dano`);
ALTER TABLE `tbl_todo_en_uno` ADD INDEX `idx_fecha_baja` (`fecha_baja`);

ALTER TABLE `tbl_portatiles` ADD INDEX `idx_fecha_dano` (`fecha_dano`);
ALTER TABLE `tbl_portatiles` ADD INDEX `idx_fecha_baja` (`fecha_baja`);

COMMIT;

-- ========================================
-- NOTAS DE IMPLEMENTACIÓN:
-- ========================================
-- 1. Los campos fecha_dano y fecha_baja son opcionales (NULL por defecto)
-- 2. fecha_dano se debe llenar cuando el estado del equipo cambie a 'Malo' o 'Dañado'
-- 3. fecha_baja se debe llenar cuando la disponibilidad cambie a 'Fuera de servicio'
-- 4. Se agregaron índices para optimizar consultas por fechas
-- 5. Los campos tienen comentarios descriptivos para facilitar el mantenimiento