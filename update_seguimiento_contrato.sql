-- Actualización de la tabla seguimiento_contrato
-- Agregar campos tipo_proceso y proceso_contratacion

ALTER TABLE seguimiento_contrato 
ADD COLUMN tipo_proceso VARCHAR(255) NOT NULL DEFAULT 'No especificado' AFTER liquidacion;

ALTER TABLE seguimiento_contrato 
ADD COLUMN proceso_contratacion VARCHAR(255) NOT NULL DEFAULT 'No especificado' AFTER tipo_proceso;