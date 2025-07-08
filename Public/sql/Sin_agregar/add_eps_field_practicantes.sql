-- Agregar campo EPS a la tabla tbl_practicantes
-- Ejecutar este script para actualizar la estructura de la base de datos

USE samicam;

-- Agregar el campo eps después del campo arl
ALTER TABLE tbl_practicantes 
ADD COLUMN eps VARCHAR(100) NOT NULL DEFAULT '' AFTER arl;

-- Actualizar registros existentes con un valor por defecto (opcional)
-- UPDATE tbl_practicantes SET eps = 'Sin especificar' WHERE eps = '';

-- Verificar que el campo se agregó correctamente
DESCRIBE tbl_practicantes; 