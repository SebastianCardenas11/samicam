-- Script de rollback para revertir cambios en tbl_todo_en_uno
-- Eliminar campos de teclado, mouse y seriales
-- Fecha: 2025-01-01

-- ADVERTENCIA: Este script eliminará las columnas y todos los datos en ellas
-- Asegúrate de hacer un backup antes de ejecutar

-- Eliminar las columnas agregadas
ALTER TABLE `tbl_todo_en_uno` 
DROP COLUMN `serial_mouse`,
DROP COLUMN `mouse`,
DROP COLUMN `serial_teclado`,
DROP COLUMN `teclado`;

-- Verificar que las columnas fueron eliminadas
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