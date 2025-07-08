-- ==================== ACTUALIZACIÓN TABLA VACACIONES ====================

-- Agregar campo tipo_vacaciones (compensadas/disfrutadas) y valor a la tabla de vacaciones
ALTER TABLE `tbl_vacaciones`
ADD COLUMN `tipo_vacaciones` ENUM('Compensadas','Disfrutadas') DEFAULT 'Disfrutadas' AFTER `tipo_funcionario`,
ADD COLUMN `valor` DECIMAL(12,2) DEFAULT 0 AFTER `tipo_vacaciones`; 