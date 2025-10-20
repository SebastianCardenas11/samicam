-- Script para crear tabla de historial de funcionarios asignados a equipos
-- Fecha: 2025-01-27
-- Solo funcionarios de planta pueden tener equipos asignados

-- Crear tabla de historial de funcionarios por equipo
CREATE TABLE IF NOT EXISTS tbl_historial_funcionarios_equipos (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_equipo INT NOT NULL,
    tipo_equipo VARCHAR(50) NOT NULL,
    funcionario_planta_id INT NOT NULL,
    fecha_asignacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_desasignacion DATETIME NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    observaciones TEXT NULL,
    usuario_registro VARCHAR(100) NOT NULL,
    INDEX idx_equipo (id_equipo, tipo_equipo),
    INDEX idx_funcionario_planta (funcionario_planta_id),
    INDEX idx_fecha_asignacion (fecha_asignacion),
    INDEX idx_estado (estado)
);

-- Insertar registros históricos basados en asignaciones actuales
INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_pc_torre, 'PC Torre', funcionario_planta_id, 'Sistema'
FROM tbl_pc_torre 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;

INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_portatil, 'Portátil', funcionario_planta_id, 'Sistema'
FROM tbl_portatiles 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;

INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_todo_en_uno, 'Todo en Uno', funcionario_planta_id, 'Sistema'
FROM tbl_todo_en_uno 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;

INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_impresora, 'Impresora', funcionario_planta_id, 'Sistema'
FROM tbl_impresoras 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;

INSERT INTO tbl_historial_funcionarios_equipos 
(id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
SELECT id_escaner, 'Escáner', funcionario_planta_id, 'Sistema'
FROM tbl_escaneres 
WHERE funcionario_planta_id IS NOT NULL AND status = 1;