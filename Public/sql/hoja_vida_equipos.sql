-- Actualización para módulo Hoja de Vida de Equipos
-- Fecha: 2025-01-27

-- Insertar el nuevo módulo en la tabla modulo
INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(19, 'Hoja de Vida Equipos', 'Gestión de hojas de vida de equipos tecnológicos', 1);

-- Asignar permisos al rol de Superadministrador (rol 1)
INSERT INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(1, 19, 1, 1, 1, 1, 1);

-- Asignar permisos al rol de Técnico NTIC (rol 5)
INSERT INTO `permisos` (`rolid`, `moduloid`, `r`, `w`, `u`, `d`, `v`) VALUES
(5, 19, 1, 1, 1, 1, 1);