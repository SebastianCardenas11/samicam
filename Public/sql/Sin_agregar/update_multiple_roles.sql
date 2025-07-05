-- =====================================================
-- ACTUALIZACIÓN PARA IMPLEMENTAR MÚLTIPLES ROLES POR USUARIO
-- =====================================================

-- 1. Crear tabla intermedia para la relación muchos a muchos
CREATE TABLE IF NOT EXISTS `tbl_usuarios_roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(32) NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  UNIQUE KEY `usuario_rol_unique` (`id_usuario`, `id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Migrar datos existentes de la tabla tbl_usuarios a la nueva tabla
INSERT IGNORE INTO `tbl_usuarios_roles` (`id_usuario`, `id_rol`, `fecha_asignacion`)
SELECT `ideusuario`, `rolid`, NOW()
FROM `tbl_usuarios` 
WHERE `status` != 0;

-- 3. Agregar restricciones de clave foránea
ALTER TABLE `tbl_usuarios_roles`
  ADD CONSTRAINT `fk_usuarios_roles_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_roles_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 4. Crear índices adicionales para optimizar consultas
CREATE INDEX `idx_usuarios_roles_usuario` ON `tbl_usuarios_roles` (`id_usuario`);
CREATE INDEX `idx_usuarios_roles_rol` ON `tbl_usuarios_roles` (`id_rol`);

-- 5. Comentario sobre la migración
-- NOTA: La columna 'rolid' en tbl_usuarios se mantiene por compatibilidad
-- pero ahora se usa principalmente para el rol principal del usuario
-- Los roles adicionales se manejan a través de la tabla tbl_usuarios_roles

-- =====================================================
-- VERIFICACIÓN DE LA MIGRACIÓN
-- =====================================================

-- Verificar que todos los usuarios tengan al menos un rol asignado
SELECT 
    u.ideusuario,
    u.nombres,
    u.rolid as rol_principal,
    COUNT(ur.id_rol) as total_roles_asignados
FROM tbl_usuarios u
LEFT JOIN tbl_usuarios_roles ur ON u.ideusuario = ur.id_usuario
WHERE u.status != 0
GROUP BY u.ideusuario, u.nombres, u.rolid
ORDER BY u.ideusuario;

-- =====================================================
-- INSTRUCCIONES PARA EL DESARROLLADOR
-- =====================================================

/*
INSTRUCCIONES PARA IMPLEMENTAR MÚLTIPLES ROLES:

1. Ejecutar este script SQL en la base de datos
2. Actualizar el modelo UsuariosModel.php para manejar múltiples roles
3. Modificar la vista modalFormUsuario.php para permitir selección múltiple
4. Actualizar el controlador Usuarios.php para manejar la asignación múltiple
5. Modificar las funciones JavaScript para manejar múltiples roles
6. Actualizar la lógica de permisos para considerar todos los roles del usuario

NOTAS IMPORTANTES:
- La columna 'rolid' en tbl_usuarios se mantiene como rol principal
- Los roles adicionales se almacenan en tbl_usuarios_roles
- Se debe mantener compatibilidad con el código existente
- Los permisos se calculan combinando todos los roles del usuario
*/ 