-- Script para agregar escáneres al historial existente
-- Fecha: 2025-01-27

-- Agregar columna funcionario_planta_id a tabla de escáneres si no existe
ALTER TABLE tbl_escaneres 
ADD COLUMN IF NOT EXISTS funcionario_planta_id INT NULL,
ADD INDEX IF NOT EXISTS idx_funcionario_planta (funcionario_planta_id);

-- Insertar registros históricos de escáneres que ya tengan funcionario asignado
INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_escaner, 'Escáner', funcionario_planta_id, 'Sistema'
FROM tbl_escaneres 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;