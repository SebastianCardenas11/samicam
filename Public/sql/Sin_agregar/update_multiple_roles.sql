
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

