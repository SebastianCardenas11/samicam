-- Script para eliminar el campo 'estudios_realizados' de la tabla tbl_funcionarios_planta
-- Este campo es redundante ya que existe 'formacion_academica' y 'nombre_formacion'

USE samicam;

-- Eliminar la columna estudios_realizados
ALTER TABLE `tbl_funcionarios_planta` DROP COLUMN `estudios_realizados`;

-- Verificar que la columna fue eliminada
DESCRIBE `tbl_funcionarios_planta`;