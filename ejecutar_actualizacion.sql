-- Script para ejecutar la actualización de la tabla tbl_todo_en_uno
-- Ejecutar este archivo en phpMyAdmin o MySQL Workbench

-- Usar la base de datos correcta (cambiar 'samicam' por el nombre de tu base de datos)
USE samicam;

-- Agregar columnas para teclado
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del teclado' AFTER `numero_activo`,
ADD COLUMN `serial_teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del teclado' AFTER `teclado`;

-- Agregar columnas para mouse
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del mouse' AFTER `serial_teclado`,
ADD COLUMN `serial_mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del mouse' AFTER `mouse`;

-- Verificar la estructura actualizada
DESCRIBE tbl_todo_en_uno;

-- Mensaje de confirmación
SELECT 'Actualización completada exitosamente. Los campos teclado, serial_teclado, mouse y serial_mouse han sido agregados a la tabla tbl_todo_en_uno.' AS mensaje;