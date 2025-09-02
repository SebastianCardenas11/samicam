ALTER TABLE `tbl_impresoras` ADD `numero_activo` VARCHAR(100) DEFAULT NULL AFTER `consumible`;
ALTER TABLE `tbl_escaneres` ADD `numero_activo` VARCHAR(100) DEFAULT NULL AFTER `serial`;
