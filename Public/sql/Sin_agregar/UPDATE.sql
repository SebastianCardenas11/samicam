USE samicam;

ALTER TABLE `tbl_funcionarios_planta`
DROP COLUMN `estudios_realizados`,
DROP COLUMN `ciudad_residencia`;

DESCRIBE `tbl_funcionarios_planta`;
