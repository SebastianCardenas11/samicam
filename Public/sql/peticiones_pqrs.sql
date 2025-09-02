-- =============================================
-- Script SQL para el Módulo de Peticiones/PQRs
-- Sistema SAMICAM
-- =============================================

-- Tabla de tipos de peticiones con sus plazos legales
CREATE TABLE `tbl_tipos_peticion` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `dias_habiles_plazo` int(11) NOT NULL,
  `color_semaforo` varchar(7) DEFAULT '#28a745',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar tipos de peticiones con sus plazos legales
INSERT INTO `tbl_tipos_peticion` (`nombre`, `descripcion`, `dias_habiles_plazo`, `color_semaforo`) VALUES
('Derecho de petición', 'Solicitudes de información o documentos bajo derecho de petición', 15, '#ffc107'),
('Tutela', 'Acciones de tutela según disposición judicial', 1, '#dc3545'),
('Documentos e información', 'Solicitudes de documentos e información general', 10, '#17a2b8'),
('Consulta', 'Consultas generales y orientación', 30, '#28a745'),
('Entre entidades', 'Comunicaciones oficiales entre entidades', 10, '#6f42c1'),
('Ente de control', 'Solicitudes de entes de control y supervisión', 5, '#fd7e14');

-- Tabla principal de peticiones/PQRs
CREATE TABLE `tbl_peticiones` (
  `id_peticion` int(11) NOT NULL AUTO_INCREMENT,
  `numero_radicado` varchar(50) NOT NULL UNIQUE,
  `fecha_ingreso` date NOT NULL,
  `nombre_peticionario` varchar(255) NOT NULL,
  `descripcion_solicitud` text NOT NULL,
  `id_tipo_peticion` int(11) NOT NULL,
  `dependencia_responsable` int(11) DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `dias_habiles_restantes` int(11) DEFAULT 0,
  `estado_semaforo` enum('verde','amarillo','rojo') DEFAULT 'verde',
  `estado` enum('radicada','en_proceso','respondida','desistida','remitida','vencida') DEFAULT 'radicada',
  `fecha_respuesta` date DEFAULT NULL,
  `dias_habiles_respuesta` int(11) DEFAULT NULL,
  `archivo_respuesta` varchar(255) DEFAULT NULL,
  `comentario_respuesta` text DEFAULT NULL,
  `area_remitida` int(11) DEFAULT NULL,
  `motivo_remision` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `usuario_creador` bigint(20) NOT NULL,
  `usuario_responsable` bigint(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_peticion`),
  KEY `idx_numero_radicado` (`numero_radicado`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  KEY `idx_estado` (`estado`),
  KEY `idx_estado_semaforo` (`estado_semaforo`),
  FOREIGN KEY (`id_tipo_peticion`) REFERENCES `tbl_tipos_peticion`(`id_tipo`),
  FOREIGN KEY (`dependencia_responsable`) REFERENCES `tbl_dependencia`(`dependencia_pk`),
  FOREIGN KEY (`area_remitida`) REFERENCES `tbl_dependencia`(`dependencia_pk`),
  FOREIGN KEY (`usuario_creador`) REFERENCES `tbl_usuarios`(`ideusuario`),
  FOREIGN KEY (`usuario_responsable`) REFERENCES `tbl_usuarios`(`ideusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de días festivos para cálculo de días hábiles
CREATE TABLE `tbl_dias_festivos` (
  `id_festivo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL UNIQUE,
  `descripcion` varchar(255) NOT NULL,
  `tipo` enum('nacional','local','religioso') DEFAULT 'nacional',
  `anio` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_festivo`),
  KEY `idx_fecha` (`fecha`),
  KEY `idx_anio` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar días festivos de Colombia 2025
INSERT INTO `tbl_dias_festivos` (`fecha`, `descripcion`, `tipo`, `anio`) VALUES
('2025-01-01', 'Año Nuevo', 'nacional', 2025),
('2025-01-06', 'Día de los Reyes Magos', 'nacional', 2025),
('2025-03-24', 'Día de San José', 'nacional', 2025),
('2025-04-17', 'Jueves Santo', 'religioso', 2025),
('2025-04-18', 'Viernes Santo', 'religioso', 2025),
('2025-05-01', 'Día del Trabajo', 'nacional', 2025),
('2025-05-26', 'Ascensión del Señor', 'religioso', 2025),
('2025-06-16', 'Corpus Christi', 'religioso', 2025),
('2025-06-23', 'Sagrado Corazón de Jesús', 'religioso', 2025),
('2025-06-30', 'San Pedro y San Pablo', 'nacional', 2025),
('2025-07-20', 'Día de la Independencia', 'nacional', 2025),
('2025-08-07', 'Batalla de Boyacá', 'nacional', 2025),
('2025-08-18', 'Asunción de la Virgen', 'religioso', 2025),
('2025-10-13', 'Día de la Raza', 'nacional', 2025),
('2025-11-03', 'Todos los Santos', 'religioso', 2025),
('2025-11-17', 'Independencia de Cartagena', 'nacional', 2025),
('2025-12-08', 'Inmaculada Concepción', 'religioso', 2025),
('2025-12-25', 'Navidad', 'religioso', 2025);

-- Tabla de historial de estados de peticiones
CREATE TABLE `tbl_peticiones_historial` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_peticion` int(11) NOT NULL,
  `estado_anterior` varchar(50) DEFAULT NULL,
  `estado_nuevo` varchar(50) NOT NULL,
  `comentario` text DEFAULT NULL,
  `usuario` bigint(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_historial`),
  KEY `idx_peticion` (`id_peticion`),
  FOREIGN KEY (`id_peticion`) REFERENCES `tbl_peticiones`(`id_peticion`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario`) REFERENCES `tbl_usuarios`(`ideusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de notificaciones automáticas para peticiones
CREATE TABLE `tbl_peticiones_notificaciones` (
  `id_notificacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_peticion` int(11) NOT NULL,
  `tipo_notificacion` enum('creacion','vencimiento_proximo','vencida','respondida','remitida') NOT NULL,
  `mensaje` text NOT NULL,
  `usuarios_notificados` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `enviado` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_notificacion`),
  KEY `idx_peticion` (`id_peticion`),
  FOREIGN KEY (`id_peticion`) REFERENCES `tbl_peticiones`(`id_peticion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Agregar el módulo de Peticiones a la tabla de módulos
INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(20, 'Peticiones PQRs', 'Gestión de Peticiones, Quejas, Reclamos y Sugerencias', 1);

-- Agregar permisos para el rol de Superadministrador
INSERT INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(1, 20, 1, 1, 1, 1, 1);

-- Función para calcular días hábiles entre dos fechas
DELIMITER //
CREATE FUNCTION calcular_dias_habiles(fecha_inicio DATE, fecha_fin DATE) 
RETURNS INT
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE dias_habiles INT DEFAULT 0;
    DECLARE fecha_actual DATE;
    DECLARE dia_semana INT;
    DECLARE es_festivo INT;
    
    SET fecha_actual = fecha_inicio;
    
    WHILE fecha_actual <= fecha_fin DO
        SET dia_semana = DAYOFWEEK(fecha_actual);
        
        -- Verificar si es día hábil (lunes a viernes)
        IF dia_semana BETWEEN 2 AND 6 THEN
            -- Verificar si no es día festivo
            SELECT COUNT(*) INTO es_festivo 
            FROM tbl_dias_festivos 
            WHERE fecha = fecha_actual AND status = 1;
            
            IF es_festivo = 0 THEN
                SET dias_habiles = dias_habiles + 1;
            END IF;
        END IF;
        
        SET fecha_actual = DATE_ADD(fecha_actual, INTERVAL 1 DAY);
    END WHILE;
    
    RETURN dias_habiles;
END //
DELIMITER ;

-- Función para calcular fecha de vencimiento en días hábiles
DELIMITER //
CREATE FUNCTION calcular_fecha_vencimiento(fecha_inicio DATE, dias_habiles INT) 
RETURNS DATE
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE fecha_vencimiento DATE;
    DECLARE dias_agregados INT DEFAULT 0;
    DECLARE fecha_actual DATE;
    DECLARE dia_semana INT;
    DECLARE es_festivo INT;
    
    SET fecha_actual = fecha_inicio;
    
    WHILE dias_agregados < dias_habiles DO
        SET fecha_actual = DATE_ADD(fecha_actual, INTERVAL 1 DAY);
        SET dia_semana = DAYOFWEEK(fecha_actual);
        
        -- Verificar si es día hábil (lunes a viernes)
        IF dia_semana BETWEEN 2 AND 6 THEN
            -- Verificar si no es día festivo
            SELECT COUNT(*) INTO es_festivo 
            FROM tbl_dias_festivos 
            WHERE fecha = fecha_actual AND status = 1;
            
            IF es_festivo = 0 THEN
                SET dias_agregados = dias_agregados + 1;
            END IF;
        END IF;
    END WHILE;
    
    SET fecha_vencimiento = fecha_actual;
    RETURN fecha_vencimiento;
END //
DELIMITER ;

-- Trigger para actualizar automáticamente los días hábiles restantes y estado del semáforo
DELIMITER //
CREATE TRIGGER actualizar_estado_peticion 
BEFORE UPDATE ON tbl_peticiones
FOR EACH ROW
BEGIN
    DECLARE dias_restantes INT;
    
    -- Solo actualizar si no está respondida, desistida o remitida
    IF NEW.estado IN ('radicada', 'en_proceso') THEN
        -- Calcular días hábiles restantes
        SET dias_restantes = calcular_dias_habiles(CURDATE(), NEW.fecha_vencimiento);
        
        -- Si la fecha actual es mayor a la de vencimiento, días restantes = 0
        IF CURDATE() > NEW.fecha_vencimiento THEN
            SET dias_restantes = 0;
            SET NEW.estado = 'vencida';
        END IF;
        
        SET NEW.dias_habiles_restantes = dias_restantes;
        
        -- Actualizar estado del semáforo
        IF dias_restantes <= 0 THEN
            SET NEW.estado_semaforo = 'rojo';
        ELSEIF dias_restantes <= 5 THEN
            SET NEW.estado_semaforo = 'rojo';
        ELSEIF dias_restantes <= 10 THEN
            SET NEW.estado_semaforo = 'amarillo';
        ELSE
            SET NEW.estado_semaforo = 'verde';
        END IF;
    END IF;
END //
DELIMITER ;

-- Trigger para calcular fecha de vencimiento al insertar nueva petición
DELIMITER //
CREATE TRIGGER calcular_vencimiento_peticion 
BEFORE INSERT ON tbl_peticiones
FOR EACH ROW
BEGIN
    DECLARE dias_plazo INT;
    DECLARE dias_restantes INT;
    
    -- Obtener días de plazo según el tipo de petición
    SELECT dias_habiles_plazo INTO dias_plazo 
    FROM tbl_tipos_peticion 
    WHERE id_tipo = NEW.id_tipo_peticion;
    
    -- Calcular fecha de vencimiento
    SET NEW.fecha_vencimiento = calcular_fecha_vencimiento(NEW.fecha_ingreso, dias_plazo);
    
    -- Calcular días hábiles restantes
    SET dias_restantes = calcular_dias_habiles(CURDATE(), NEW.fecha_vencimiento);
    SET NEW.dias_habiles_restantes = dias_restantes;
    
    -- Establecer estado del semáforo
    IF dias_restantes <= 0 THEN
        SET NEW.estado_semaforo = 'rojo';
    ELSEIF dias_restantes <= 5 THEN
        SET NEW.estado_semaforo = 'rojo';
    ELSEIF dias_restantes <= 10 THEN
        SET NEW.estado_semaforo = 'amarillo';
    ELSE
        SET NEW.estado_semaforo = 'verde';
    END IF;
END //
DELIMITER ;

-- Trigger para registrar historial de cambios de estado
DELIMITER //
CREATE TRIGGER registrar_historial_peticion 
AFTER UPDATE ON tbl_peticiones
FOR EACH ROW
BEGIN
    IF OLD.estado != NEW.estado THEN
        INSERT INTO tbl_peticiones_historial (id_peticion, estado_anterior, estado_nuevo, usuario)
        VALUES (NEW.id_peticion, OLD.estado, NEW.estado, NEW.usuario_responsable);
    END IF;
END //
DELIMITER ;