-- TABLAS DE EQUIPOS DE CÓMPUTO (CORREGIDAS Y CON LLAVES FORÁNEAS)

CREATE TABLE IF NOT EXISTS tbl_pc_torre (
  id_pc_torre INT AUTO_INCREMENT PRIMARY KEY,
  numero_pc VARCHAR(50),
  marca VARCHAR(100),
  serial VARCHAR(100),
  modelo VARCHAR(100),
  ram VARCHAR(50),
  velocidad_ram VARCHAR(50),
  procesador VARCHAR(100),
  velocidad_procesador VARCHAR(50),
  disco_duro VARCHAR(50),
  capacidad VARCHAR(50),
  sistema_operativo VARCHAR(100),
  numero_activo VARCHAR(50),
  monitor VARCHAR(100),
  numero_activo_monitor VARCHAR(50),
  serial_monitor VARCHAR(100),
  estado ENUM('Bueno', 'Regular', 'Dañado', 'Baja') NOT NULL,
  disponibilidad ENUM('Disponible', 'En uso', 'Prestado') NOT NULL,
  id_dependencia INT, -- sectorial
  oficina VARCHAR(100),
  id_funcionario INT, -- asignado
  id_cargo INT,       -- cargo del funcionario
  id_contacto INT,    -- contacto
  status TINYINT(1) DEFAULT 1,
  FOREIGN KEY (id_dependencia) REFERENCES tbl_dependencia(dependencia_pk),
  FOREIGN KEY (id_funcionario) REFERENCES tbl_funcionarios_planta(idefuncionario),
  FOREIGN KEY (id_cargo) REFERENCES tbl_cargos(idecargos),
  FOREIGN KEY (id_contacto) REFERENCES tbl_funcionarios_planta(idefuncionario)
);

CREATE TABLE IF NOT EXISTS tbl_todo_en_uno (
  id_todo_en_uno INT AUTO_INCREMENT PRIMARY KEY,
  numero_pc VARCHAR(50),
  marca VARCHAR(100),
  modelo VARCHAR(100),
  ram VARCHAR(50),
  velocidad_ram VARCHAR(50),
  procesador VARCHAR(100),
  velocidad_procesador VARCHAR(50),
  disco_duro VARCHAR(50),
  capacidad VARCHAR(50),
  serial VARCHAR(100),
  sistema_operativo VARCHAR(100),
  numero_activo VARCHAR(50),
  estado ENUM('Bueno', 'Regular', 'Dañado', 'Baja') NOT NULL,
  disponibilidad ENUM('Disponible', 'En uso', 'Prestado') NOT NULL,
  id_dependencia INT, -- sectorial
  oficina VARCHAR(100),
  id_funcionario INT, -- asignado
  id_cargo INT,       -- cargo del funcionario
  id_contacto INT,    -- contacto
  status TINYINT(1) DEFAULT 1,
  FOREIGN KEY (id_dependencia) REFERENCES tbl_dependencia(dependencia_pk),
  FOREIGN KEY (id_funcionario) REFERENCES tbl_funcionarios_planta(idefuncionario),
  FOREIGN KEY (id_cargo) REFERENCES tbl_cargos(idecargos),
  FOREIGN KEY (id_contacto) REFERENCES tbl_funcionarios_planta(idefuncionario)
);

CREATE TABLE IF NOT EXISTS tbl_portatiles (
  id_portatil INT AUTO_INCREMENT PRIMARY KEY,
  numero_pc VARCHAR(50),
  marca VARCHAR(100),
  modelo VARCHAR(100),
  ram VARCHAR(50),
  velocidad_ram VARCHAR(50),
  procesador VARCHAR(100),
  velocidad_procesador VARCHAR(50),
  disco_duro VARCHAR(50),
  capacidad VARCHAR(50),
  serial VARCHAR(100),
  sistema_operativo VARCHAR(100),
  numero_activo VARCHAR(50),
  estado ENUM('Bueno', 'Regular', 'Dañado', 'Baja') NOT NULL,
  disponibilidad ENUM('Disponible', 'En uso', 'Prestado') NOT NULL,
  id_dependencia INT, -- sectorial
  oficina VARCHAR(100),
  id_funcionario INT, -- asignado
  id_cargo INT,       -- cargo del funcionario
  id_contacto INT,    -- contacto
  status TINYINT(1) DEFAULT 1,
  FOREIGN KEY (id_dependencia) REFERENCES tbl_dependencia(dependencia_pk),
  FOREIGN KEY (id_funcionario) REFERENCES tbl_funcionarios_planta(idefuncionario),
  FOREIGN KEY (id_cargo) REFERENCES tbl_cargos(idecargos),
  FOREIGN KEY (id_contacto) REFERENCES tbl_funcionarios_planta(idefuncionario)
);

-- Índices para equipos de cómputo
ALTER TABLE tbl_pc_torre
  ADD KEY `fk_pc_torre_dependencia` (`id_dependencia`),
  ADD KEY `fk_pc_torre_funcionario` (`id_funcionario`),
  ADD KEY `fk_pc_torre_cargo` (`id_cargo`),
  ADD KEY `fk_pc_torre_contacto` (`id_contacto`);

ALTER TABLE tbl_todo_en_uno
  ADD KEY `fk_todo_en_uno_dependencia` (`id_dependencia`),
  ADD KEY `fk_todo_en_uno_funcionario` (`id_funcionario`),
  ADD KEY `fk_todo_en_uno_cargo` (`id_cargo`),
  ADD KEY `fk_todo_en_uno_contacto` (`id_contacto`);

ALTER TABLE tbl_portatiles
  ADD KEY `fk_portatiles_dependencia` (`id_dependencia`),
  ADD KEY `fk_portatiles_funcionario` (`id_funcionario`),
  ADD KEY `fk_portatiles_cargo` (`id_cargo`),
  ADD KEY `fk_portatiles_contacto` (`id_contacto`); 