-- Script de actualización para la tabla tbl_todo_en_uno
-- Agregar campos de teclado, mouse y seriales
-- Fecha: 2025-01-01

-- Agregar columnas para teclado
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del teclado' AFTER `numero_activo`,
ADD COLUMN `serial_teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del teclado' AFTER `teclado`;

-- Agregar columnas para mouse
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del mouse' AFTER `serial_teclado`,
ADD COLUMN `serial_mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del mouse' AFTER `mouse`;

-- Verificar la estructura actualizada
-- DESCRIBE tbl_todo_en_uno;