-- Script para BORRAR todos los permisos excepto los del Superadministrador
-- Ejecutar en phpMyAdmin

-- 1. Eliminar todos los registros de permisos que no sean del Superadministrador
DELETE FROM permisos WHERE rolid != 1;

-- 2. Asegurar que el Superadministrador tenga todos los permisos
UPDATE permisos SET r=1, w=1, u=1, d=1, v=1 WHERE rolid = 1;

-- 3. Verificar el resultado
SELECT 
    r.nombrerol, 
    COUNT(p.idpermiso) as total_permisos
FROM rol r
LEFT JOIN permisos p ON r.idrol = p.rolid
WHERE r.status = 1
GROUP BY r.idrol, r.nombrerol
ORDER BY r.nombrerol;