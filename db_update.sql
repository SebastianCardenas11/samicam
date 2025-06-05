-- Añadir campo status a la tabla tbl_funcionarios_ops
ALTER TABLE tbl_funcionarios_ops ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 1;

-- Actualizar registros existentes para que tengan status = 1
UPDATE tbl_funcionarios_ops SET status = 1 WHERE status IS NULL; 