-- Script para actualizar la tabla seguimiento_contrato
-- Agrega los campos tipo_informe y cantidad_informes

ALTER TABLE seguimiento_contrato
ADD COLUMN tipo_informe ENUM('acta parcial', 'mes vencido') DEFAULT 'acta parcial' AFTER tipo_plazo,
ADD COLUMN cantidad_informes INT DEFAULT 1 AFTER tipo_informe; 