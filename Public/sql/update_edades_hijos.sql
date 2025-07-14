-- Agregar campo para edades de los hijos
ALTER TABLE funcionarios_planta ADD COLUMN edades_hijos TEXT DEFAULT NULL COMMENT 'Edades de los hijos separadas por comas';