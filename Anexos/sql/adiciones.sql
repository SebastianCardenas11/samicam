CREATE TABLE adiciones_contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    valor_adicion DECIMAL(15,2) NOT NULL,
    motivo VARCHAR(255),
    fecha_adicion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_contrato) REFERENCES seguimiento_contrato(id)
);