USE samicam;

-- Eliminar columnas innecesarias
ALTER TABLE `tbl_funcionarios_planta`
  DROP COLUMN `estudios_realizados`,
  DROP COLUMN `ciudad_residencia`;

-- Agregar nueva columna
ALTER TABLE `tbl_funcionarios_planta`
  ADD COLUMN `edades_hijos` TEXT DEFAULT NULL;

-- Ver estructura final
DESCRIBE `tbl_funcionarios_planta`;
