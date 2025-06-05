-- Agregar campo status si no existe
SET @exist := (SELECT COUNT(*) 
               FROM information_schema.COLUMNS 
               WHERE TABLE_SCHEMA = 'samicam' 
               AND TABLE_NAME = 'tbl_funcionarios_ops' 
               AND COLUMN_NAME = 'status');

SET @query = IF(@exist = 0,
    'ALTER TABLE tbl_funcionarios_ops ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 1',
    'SELECT "Campo status ya existe"');

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Actualizar registros existentes
UPDATE tbl_funcionarios_ops SET status = 1 WHERE status IS NULL; 