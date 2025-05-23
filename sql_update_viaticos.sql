-- Modificar la tabla tbl_viaticos para renombrar el campo fecha y añadir nuevos campos
ALTER TABLE `tbl_viaticos` 
CHANGE COLUMN `fecha` `fecha_aprobacion` DATE NOT NULL,
ADD COLUMN `fecha_salida` DATE NOT NULL AFTER `fecha_aprobacion`,
ADD COLUMN `fecha_regreso` DATE NOT NULL AFTER `fecha_salida`;