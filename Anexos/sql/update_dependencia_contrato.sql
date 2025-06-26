-- Agregar campo dependencia_id a la tabla seguimiento_contrato
ALTER TABLE seguimiento_contrato 
ADD COLUMN dependencia_id INT NULL AFTER numero_contrato,
ADD FOREIGN KEY (dependencia_id) REFERENCES tbl_dependencia(dependencia_pk);

-- Comentario: Este campo almacenará el ID de la dependencia de donde proviene el contrato