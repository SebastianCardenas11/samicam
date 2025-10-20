-- Script SQL para el módulo de Radicados
USE samicam;

-- Crear tabla principal de radicados
CREATE TABLE IF NOT EXISTS `tbl_radicados` (
  `id_radicado` int(11) NOT NULL AUTO_INCREMENT,
  `asunto_comunicacion` varchar(500) NOT NULL,
  `entidad_envio` varchar(255) NOT NULL,
  `medio_envio` enum('Correo','Fisico') NOT NULL DEFAULT 'Correo',
  `fecha_envio` date NOT NULL,
  `numero_radicado` varchar(50) NOT NULL,
  `fecha_radicado` date NOT NULL,
  `usuario_creador` bigint(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_radicado`),
  UNIQUE KEY `numero_radicado` (`numero_radicado`),
  KEY `idx_fecha_envio` (`fecha_envio`),
  KEY `idx_fecha_radicado` (`fecha_radicado`),
  KEY `idx_medio_envio` (`medio_envio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar el módulo en la tabla modulo si no existe
INSERT IGNORE INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES 
(21, 'Radicados', 'Gestión de radicados de comunicaciones', 1);

-- Asignar permisos completos al superadministrador (rol ID 1)
INSERT IGNORE INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) 
VALUES (1, 21, 1, 1, 1, 1, 1);

-- Verificar que se creó correctamente
SELECT 'Módulo de Radicados instalado correctamente' as mensaje;