-- Script para actualizar la tabla seguimiento_contrato existente
-- Ejecutar estos comandos en la base de datos para agregar el campo tipo_plazo

-- 1. Agregar el campo tipo_plazo
ALTER TABLE `seguimiento_contrato` ADD COLUMN `tipo_plazo` enum('dias','meses') NOT NULL DEFAULT 'meses' AFTER `plazo_meses`;

-- 2. Cambiar el nombre del campo plazo_meses a plazo
ALTER TABLE `seguimiento_contrato` CHANGE `plazo_meses` `plazo` int(11) NOT NULL;

-- 3. Verificar que los cambios se aplicaron correctamente
DESCRIBE `seguimiento_contrato`; 