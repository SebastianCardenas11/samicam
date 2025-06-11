-- Modificar la estructura de la tabla tbl_funcionarios_planta
ALTER TABLE `tbl_funcionarios_planta` 
MODIFY `celular` varchar(20) DEFAULT NULL,
MODIFY `nm_identificacion` varchar(20) DEFAULT NULL,
MODIFY `status` int(15) NOT NULL DEFAULT 1;

-- Agregar índices y restricciones faltantes
ALTER TABLE `tbl_funcionarios_planta` 
ADD CONSTRAINT `fk_funcionario_cargo` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_funcionario_dependencia` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_funcionario_contrato` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON DELETE RESTRICT ON UPDATE CASCADE; 