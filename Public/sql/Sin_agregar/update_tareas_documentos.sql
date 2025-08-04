ALTER TABLE `tbl_tareas` 
ADD COLUMN `archivo_adjunto` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Nombre del archivo adjunto' AFTER `observacion`,
ADD COLUMN `nombre_archivo_original` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Nombre original del archivo' AFTER `archivo_adjunto`;
