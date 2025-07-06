-- Script para mejorar la gestión de permisos de funcionarios
-- Ejecutar después de la base de datos principal

-- Tabla para tipos de permisos con configuración específica
CREATE TABLE IF NOT EXISTS `tbl_tipos_permisos` (
  `id_tipo_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `requiere_justificacion` tinyint(1) NOT NULL DEFAULT 0,
  `dias_maximos_mes` int(11) DEFAULT NULL,
  `requiere_aprobacion` tinyint(1) NOT NULL DEFAULT 1,
  `color_display` varchar(7) DEFAULT '#007bff',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tipo_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar tipos de permisos básicos
INSERT INTO `tbl_tipos_permisos` (`nombre`, `descripcion`, `requiere_justificacion`, `dias_maximos_mes`, `requiere_aprobacion`, `color_display`) VALUES
('Cita médica', 'Permiso para asistir a citas médicas', 0, 3, 1, '#28a745'),
('Calamidad doméstica', 'Permiso por situaciones de emergencia familiar', 1, 2, 1, '#dc3545'),
('Diligencia personal', 'Permiso para trámites personales', 0, 2, 1, '#17a2b8'),
('Capacitación', 'Permiso para asistir a capacitaciones', 0, NULL, 1, '#6f42c1'),
('Asunto familiar', 'Permiso por asuntos familiares importantes', 1, 1, 1, '#fd7e14'),
('Muerte familiar', 'Permiso por fallecimiento de familiar', 1, 5, 0, '#6c757d');

-- Tabla para configuración de límites de permisos por cargo/dependencia
CREATE TABLE IF NOT EXISTS `tbl_configuracion_permisos_cargo` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(11) DEFAULT NULL,
  `tipo_permiso_fk` int(11) NOT NULL,
  `limite_mensual` int(11) NOT NULL DEFAULT 3,
  `limite_anual` int(11) DEFAULT NULL,
  `requiere_reemplazo` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_config`),
  KEY `cargo_fk` (`cargo_fk`),
  KEY `dependencia_fk` (`dependencia_fk`),
  KEY `tipo_permiso_fk` (`tipo_permiso_fk`),
  CONSTRAINT `fk_config_cargo` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE CASCADE,
  CONSTRAINT `fk_config_dependencia` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE,
  CONSTRAINT `fk_config_tipo_permiso` FOREIGN KEY (`tipo_permiso_fk`) REFERENCES `tbl_tipos_permisos` (`id_tipo_permiso`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Actualizar tabla de permisos existente para usar el nuevo sistema
ALTER TABLE `tbl_permisos` 
ADD COLUMN `tipo_permiso_fk` int(11) DEFAULT NULL AFTER `motivo`,
ADD COLUMN `observaciones` text DEFAULT NULL AFTER `justificacion_especial`,
ADD KEY `tipo_permiso_fk` (`tipo_permiso_fk`),
ADD CONSTRAINT `fk_permiso_tipo` FOREIGN KEY (`tipo_permiso_fk`) REFERENCES `tbl_tipos_permisos` (`id_tipo_permiso`) ON DELETE SET NULL;

-- Actualizar tabla de historial de permisos
ALTER TABLE `tbl_historial_permisos` 
ADD COLUMN `tipo_permiso_fk` int(11) DEFAULT NULL AFTER `motivo`,
ADD COLUMN `observaciones` text DEFAULT NULL AFTER `justificacion_especial`,
ADD KEY `tipo_permiso_fk` (`tipo_permiso_fk`),
ADD CONSTRAINT `fk_historial_tipo` FOREIGN KEY (`tipo_permiso_fk`) REFERENCES `tbl_tipos_permisos` (`id_tipo_permiso`) ON DELETE SET NULL;

-- Vista para consultar permisos con información completa
CREATE OR REPLACE VIEW `vista_permisos_funcionarios` AS
SELECT 
    p.id_permiso,
    f.nombre_completo,
    f.nm_identificacion,
    c.nombre as cargo,
    d.nombre as dependencia,
    p.fecha_permiso,
    tp.nombre as tipo_permiso,
    tp.color_display,
    p.motivo,
    p.estado,
    p.tipo_funcionario,
    p.es_permiso_especial,
    p.fecha_registro,
    tp.requiere_justificacion,
    tp.requiere_aprobacion
FROM tbl_permisos p
LEFT JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.idefuncionario
LEFT JOIN tbl_cargos c ON f.cargo_fk = c.idecargos
LEFT JOIN tbl_dependencia d ON f.dependencia_fk = d.dependencia_pk
LEFT JOIN tbl_tipos_permisos tp ON p.tipo_permiso_fk = tp.id_tipo_permiso
WHERE p.tipo_funcionario = 'planta'

UNION ALL

SELECT 
    p.id_permiso,
    o.nombre_contratista as nombre_completo,
    o.identificacion_contratista as nm_identificacion,
    'Contratista OPS' as cargo,
    'OPS' as dependencia,
    p.fecha_permiso,
    tp.nombre as tipo_permiso,
    tp.color_display,
    p.motivo,
    p.estado,
    p.tipo_funcionario,
    p.es_permiso_especial,
    p.fecha_registro,
    tp.requiere_justificacion,
    tp.requiere_aprobacion
FROM tbl_permisos p
LEFT JOIN tbl_funcionarios_ops o ON p.id_funcionario = o.id
LEFT JOIN tbl_tipos_permisos tp ON p.tipo_permiso_fk = tp.id_tipo_permiso
WHERE p.tipo_funcionario = 'ops';

-- Función para validar límites de permisos
DELIMITER $$
CREATE OR REPLACE FUNCTION validar_limite_permisos(
    p_funcionario_id INT,
    p_tipo_permiso_id INT,
    p_fecha_permiso DATE,
    p_tipo_funcionario ENUM('planta','ops')
) RETURNS JSON
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE v_limite_mensual INT DEFAULT 3;
    DECLARE v_permisos_mes INT DEFAULT 0;
    DECLARE v_resultado JSON;
    DECLARE v_cargo_id INT;
    DECLARE v_dependencia_id INT;
    
    -- Obtener cargo y dependencia del funcionario
    IF p_tipo_funcionario = 'planta' THEN
        SELECT cargo_fk, dependencia_fk INTO v_cargo_id, v_dependencia_id
        FROM tbl_funcionarios_planta 
        WHERE idefuncionario = p_funcionario_id;
    END IF;
    
    -- Obtener límite configurado
    SELECT COALESCE(limite_mensual, 3) INTO v_limite_mensual
    FROM tbl_configuracion_permisos_cargo
    WHERE (cargo_fk = v_cargo_id OR cargo_fk IS NULL)
    AND (dependencia_fk = v_dependencia_id OR dependencia_fk IS NULL)
    AND tipo_permiso_fk = p_tipo_permiso_id
    AND status = 1
    ORDER BY cargo_fk DESC, dependencia_fk DESC
    LIMIT 1;
    
    -- Contar permisos del mes
    SELECT COUNT(*) INTO v_permisos_mes
    FROM tbl_permisos
    WHERE id_funcionario = p_funcionario_id
    AND tipo_permiso_fk = p_tipo_permiso_id
    AND MONTH(fecha_permiso) = MONTH(p_fecha_permiso)
    AND YEAR(fecha_permiso) = YEAR(p_fecha_permiso)
    AND tipo_funcionario = p_tipo_funcionario;
    
    -- Crear resultado
    SET v_resultado = JSON_OBJECT(
        'permitido', IF(v_permisos_mes < v_limite_mensual, TRUE, FALSE),
        'limite_mensual', v_limite_mensual,
        'permisos_usados', v_permisos_mes,
        'permisos_restantes', v_limite_mensual - v_permisos_mes
    );
    
    RETURN v_resultado;
END$$
DELIMITER ;