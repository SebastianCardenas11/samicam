-- Script para agregar columnas de funcionarios a las tablas de inventario
-- Ejecutar este script si las columnas de funcionarios no existen

-- Agregar columnas a tabla de impresoras
ALTER TABLE tbl_impresoras 
ADD COLUMN IF NOT EXISTS funcionario_ops_id INT NULL,
ADD COLUMN IF NOT EXISTS funcionario_planta_id INT NULL;

-- Agregar columnas a tabla de PC Torre
ALTER TABLE tbl_pc_torre 
ADD COLUMN IF NOT EXISTS funcionario_ops_id INT NULL,
ADD COLUMN IF NOT EXISTS funcionario_planta_id INT NULL;

-- Agregar columnas a tabla de PC Todo en Uno
ALTER TABLE tbl_todo_en_uno 
ADD COLUMN IF NOT EXISTS funcionario_ops_id INT NULL,
ADD COLUMN IF NOT EXISTS funcionario_planta_id INT NULL;

-- Agregar columnas a tabla de Portátiles
ALTER TABLE tbl_portatiles 
ADD COLUMN IF NOT EXISTS funcionario_ops_id INT NULL,
ADD COLUMN IF NOT EXISTS funcionario_planta_id INT NULL;

-- Agregar índices para mejorar el rendimiento
ALTER TABLE tbl_impresoras 
ADD INDEX IF NOT EXISTS idx_funcionario_ops (funcionario_ops_id),
ADD INDEX IF NOT EXISTS idx_funcionario_planta (funcionario_planta_id);

ALTER TABLE tbl_pc_torre 
ADD INDEX IF NOT EXISTS idx_funcionario_ops (funcionario_ops_id),
ADD INDEX IF NOT EXISTS idx_funcionario_planta (funcionario_planta_id);

ALTER TABLE tbl_todo_en_uno 
ADD INDEX IF NOT EXISTS idx_funcionario_ops (funcionario_ops_id),
ADD INDEX IF NOT EXISTS idx_funcionario_planta (funcionario_planta_id);

ALTER TABLE tbl_portatiles 
ADD INDEX IF NOT EXISTS idx_funcionario_ops (funcionario_ops_id),
ADD INDEX IF NOT EXISTS idx_funcionario_planta (funcionario_planta_id);

-- Crear tabla de movimientos de equipos si no existe
CREATE TABLE IF NOT EXISTS tbl_equipos_movimientos (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_equipo INT NOT NULL,
    tipo_equipo VARCHAR(50) NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida', 'cambio_estado') NOT NULL,
    observacion TEXT,
    fecha_hora DATETIME NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    INDEX idx_equipo (id_equipo, tipo_equipo),
    INDEX idx_fecha (fecha_hora)
);

-- Verificar que las tablas de funcionarios existan
CREATE TABLE IF NOT EXISTS tbl_funcionarios_ops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(255) NOT NULL,
    status TINYINT DEFAULT 1,
    INDEX idx_status (status)
);

CREATE TABLE IF NOT EXISTS tbl_funcionarios_planta (
    idefuncionario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(255) NOT NULL,
    status TINYINT DEFAULT 1,
    INDEX idx_status (status)
);