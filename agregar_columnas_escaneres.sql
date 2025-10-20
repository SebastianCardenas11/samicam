-- Script para agregar columnas de funcionarios a la tabla tbl_escaneres
ALTER TABLE tbl_escaneres 
ADD COLUMN funcionario_ops_id INT NULL,
ADD COLUMN funcionario_planta_id INT NULL;

-- Agregar índices para mejorar el rendimiento
CREATE INDEX idx_funcionario_ops ON tbl_escaneres(funcionario_ops_id);
CREATE INDEX idx_funcionario_planta ON tbl_escaneres(funcionario_planta_id);