-- Triggers para registrar automáticamente cambios en el historial de funcionarios
-- Fecha: 2025-01-27

DELIMITER $$

-- Trigger para PC Torre
CREATE TRIGGER tr_pc_torre_funcionario_update
AFTER UPDATE ON tbl_pc_torre
FOR EACH ROW
BEGIN
    -- Si cambió el funcionario asignado
    IF OLD.funcionario_planta_id != NEW.funcionario_planta_id THEN
        -- Desactivar el registro anterior si existe
        IF OLD.funcionario_planta_id IS NOT NULL THEN
            UPDATE tbl_historial_funcionarios_equipos 
            SET estado = 'inactivo', fecha_desasignacion = NOW()
            WHERE id_equipo = OLD.id_pc_torre 
            AND tipo_equipo = 'PC Torre' 
            AND funcionario_planta_id = OLD.funcionario_planta_id 
            AND estado = 'activo';
        END IF;
        
        -- Crear nuevo registro si se asignó un funcionario
        IF NEW.funcionario_planta_id IS NOT NULL THEN
            INSERT INTO tbl_historial_funcionarios_equipos 
            (id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
            VALUES (NEW.id_pc_torre, 'PC Torre', NEW.funcionario_planta_id, 'Sistema');
        END IF;
    END IF;
END$$

-- Trigger para Portátiles
CREATE TRIGGER tr_portatiles_funcionario_update
AFTER UPDATE ON tbl_portatiles
FOR EACH ROW
BEGIN
    IF OLD.funcionario_planta_id != NEW.funcionario_planta_id THEN
        IF OLD.funcionario_planta_id IS NOT NULL THEN
            UPDATE tbl_historial_funcionarios_equipos 
            SET estado = 'inactivo', fecha_desasignacion = NOW()
            WHERE id_equipo = OLD.id_portatil 
            AND tipo_equipo = 'Portátil' 
            AND funcionario_planta_id = OLD.funcionario_planta_id 
            AND estado = 'activo';
        END IF;
        
        IF NEW.funcionario_planta_id IS NOT NULL THEN
            INSERT INTO tbl_historial_funcionarios_equipos 
            (id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
            VALUES (NEW.id_portatil, 'Portátil', NEW.funcionario_planta_id, 'Sistema');
        END IF;
    END IF;
END$$

-- Trigger para Todo en Uno
CREATE TRIGGER tr_todo_en_uno_funcionario_update
AFTER UPDATE ON tbl_todo_en_uno
FOR EACH ROW
BEGIN
    IF OLD.funcionario_planta_id != NEW.funcionario_planta_id THEN
        IF OLD.funcionario_planta_id IS NOT NULL THEN
            UPDATE tbl_historial_funcionarios_equipos 
            SET estado = 'inactivo', fecha_desasignacion = NOW()
            WHERE id_equipo = OLD.id_todo_en_uno 
            AND tipo_equipo = 'Todo en Uno' 
            AND funcionario_planta_id = OLD.funcionario_planta_id 
            AND estado = 'activo';
        END IF;
        
        IF NEW.funcionario_planta_id IS NOT NULL THEN
            INSERT INTO tbl_historial_funcionarios_equipos 
            (id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
            VALUES (NEW.id_todo_en_uno, 'Todo en Uno', NEW.funcionario_planta_id, 'Sistema');
        END IF;
    END IF;
END$$

-- Trigger para Impresoras
CREATE TRIGGER tr_impresoras_funcionario_update
AFTER UPDATE ON tbl_impresoras
FOR EACH ROW
BEGIN
    IF OLD.funcionario_planta_id != NEW.funcionario_planta_id THEN
        IF OLD.funcionario_planta_id IS NOT NULL THEN
            UPDATE tbl_historial_funcionarios_equipos 
            SET estado = 'inactivo', fecha_desasignacion = NOW()
            WHERE id_equipo = OLD.id_impresora 
            AND tipo_equipo = 'Impresora' 
            AND funcionario_planta_id = OLD.funcionario_planta_id 
            AND estado = 'activo';
        END IF;
        
        IF NEW.funcionario_planta_id IS NOT NULL THEN
            INSERT INTO tbl_historial_funcionarios_equipos 
            (id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
            VALUES (NEW.id_impresora, 'Impresora', NEW.funcionario_planta_id, 'Sistema');
        END IF;
    END IF;
END$$

-- Trigger para Escáneres
CREATE TRIGGER tr_escaneres_funcionario_update
AFTER UPDATE ON tbl_escaneres
FOR EACH ROW
BEGIN
    IF OLD.funcionario_planta_id != NEW.funcionario_planta_id THEN
        IF OLD.funcionario_planta_id IS NOT NULL THEN
            UPDATE tbl_historial_funcionarios_equipos 
            SET estado = 'inactivo', fecha_desasignacion = NOW()
            WHERE id_equipo = OLD.id_escaner 
            AND tipo_equipo = 'Escáner' 
            AND funcionario_planta_id = OLD.funcionario_planta_id 
            AND estado = 'activo';
        END IF;
        
        IF NEW.funcionario_planta_id IS NOT NULL THEN
            INSERT INTO tbl_historial_funcionarios_equipos 
            (id_equipo, tipo_equipo, funcionario_planta_id, usuario_registro)
            VALUES (NEW.id_escaner, 'Escáner', NEW.funcionario_planta_id, 'Sistema');
        END IF;
    END IF;
END$$

DELIMITER ;