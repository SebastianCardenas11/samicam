-- Añadir campo de visibilidad a la tabla permisos
ALTER TABLE permisos ADD COLUMN v TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Permiso de visibilidad';