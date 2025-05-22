-- Asegurarse de que todos los módulos estén en la tabla modulo
INSERT INTO modulo (idmodulo, titulo, descripcion, status)
SELECT 9, 'Notificaciones', 'Gestión de notificaciones', 1
WHERE NOT EXISTS (SELECT 1 FROM modulo WHERE idmodulo = 9);

INSERT INTO modulo (idmodulo, titulo, descripcion, status)
SELECT 10, 'Capital Viáticos', 'Gestión de capital para viáticos', 1
WHERE NOT EXISTS (SELECT 1 FROM modulo WHERE idmodulo = 10);

INSERT INTO modulo (idmodulo, titulo, descripcion, status)
SELECT 11, 'Motivos Permisos', 'Gestión de motivos de permisos', 1
WHERE NOT EXISTS (SELECT 1 FROM modulo WHERE idmodulo = 11);

INSERT INTO modulo (idmodulo, titulo, descripcion, status)
SELECT 12, 'Cargos', 'Gestión de cargos', 1
WHERE NOT EXISTS (SELECT 1 FROM modulo WHERE idmodulo = 12);

-- Agregar permisos para los roles existentes para los módulos que faltan
-- Para el rol Superadministrador (idrol = 1)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 7, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 7);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 8, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 8);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 9, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 9);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 10, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 10);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 11, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 11);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 1, 12, 1, 1, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 1 AND moduloid = 12);

-- Para el rol Jefe Talento Humano (idrol = 2)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 2, 6, 1, 1, 1, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 2 AND moduloid = 6);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 2, 7, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 2 AND moduloid = 7);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 2, 8, 1, 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 2 AND moduloid = 8);

-- Para el rol Secretaria TH (idrol = 3)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 3, 6, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 3 AND moduloid = 6);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 3, 7, 0, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 3 AND moduloid = 7);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 3, 8, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 3 AND moduloid = 8);

-- Para el rol Contratación (idrol = 4)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 4, 6, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 4 AND moduloid = 6);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 4, 7, 1, 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 4 AND moduloid = 7);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 4, 8, 1, 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 4 AND moduloid = 8);

-- Para el rol Tecnico Ntic (idrol = 5)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 5, 1, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 5 AND moduloid = 1);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 5, 8, 1, 1, 1, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 5 AND moduloid = 8);

-- Para el rol Secretaria Ntic (idrol = 7)
INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 7, 1, 1, 0, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 7 AND moduloid = 1);

INSERT INTO permisos (rolid, moduloid, r, w, u, d)
SELECT 7, 8, 1, 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM permisos WHERE rolid = 7 AND moduloid = 8);