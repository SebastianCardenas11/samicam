-- Script completo de actualización para la tabla tbl_todo_en_uno
-- Agregar campos de teclado, mouse y seriales + datos de ejemplo
-- Fecha: 2025-01-01

-- 1. Agregar las nuevas columnas
ALTER TABLE `tbl_todo_en_uno` 
ADD COLUMN `teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del teclado' AFTER `numero_activo`,
ADD COLUMN `serial_teclado` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del teclado' AFTER `teclado`,
ADD COLUMN `mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Marca/modelo del mouse' AFTER `serial_teclado`,
ADD COLUMN `serial_mouse` VARCHAR(100) DEFAULT NULL COMMENT 'Serial del mouse' AFTER `mouse`;

-- 2. Actualizar algunos registros existentes con datos de ejemplo (opcional)
-- Puedes descomentar y modificar estas líneas según tus necesidades

/*
UPDATE `tbl_todo_en_uno` 
SET 
    `teclado` = 'Logitech K120',
    `serial_teclado` = 'LGT001234567',
    `mouse` = 'Logitech B100',
    `serial_mouse` = 'LGM001234567'
WHERE `id_todo_en_uno` = 1;

UPDATE `tbl_todo_en_uno` 
SET 
    `teclado` = 'HP KB216',
    `serial_teclado` = 'HP001234567',
    `mouse` = 'HP X500',
    `serial_mouse` = 'HPM001234567'
WHERE `id_todo_en_uno` = 2;

UPDATE `tbl_todo_en_uno` 
SET 
    `teclado` = 'Dell KB216',
    `serial_teclado` = 'DL001234567',
    `mouse` = 'Dell MS116',
    `serial_mouse` = 'DLM001234567'
WHERE `id_todo_en_uno` = 3;
*/

-- 3. Verificar la estructura actualizada
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'samicam' 
AND TABLE_NAME = 'tbl_todo_en_uno'
ORDER BY ORDINAL_POSITION;

-- 4. Mostrar algunos registros para verificar
SELECT 
    id_todo_en_uno,
    numero_pc,
    marca,
    modelo,
    teclado,
    serial_teclado,
    mouse,
    serial_mouse,
    estado,
    disponibilidad
FROM `tbl_todo_en_uno` 
LIMIT 5;