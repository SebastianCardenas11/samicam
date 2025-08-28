-- Script para corregir el campo EPS en la tabla de practicantes
-- El problema es que el campo 'eps' está definido como INT pero se está usando como VARCHAR

-- Cambiar el tipo de dato del campo eps de INT a VARCHAR
ALTER TABLE `tbl_practicantes` 
MODIFY COLUMN `eps` VARCHAR(100) NOT NULL;

-- Opcional: Si quieres actualizar los registros existentes que tienen 0
-- UPDATE `tbl_practicantes` SET `eps` = 'No especificado' WHERE `eps` = '0' OR `eps` = '';