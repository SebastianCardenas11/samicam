<?php

class InventarioModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // ==================== IMPRESORAS ====================
    public function selectImpresoras()
    {
        $sql = "SELECT i.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_impresoras i
                LEFT JOIN tbl_dependencias d ON i.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON i.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON i.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON i.id_contacto = co.id_contacto
                WHERE i.status != 0
                ORDER BY i.numero_impresora ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectImpresora($idImpresora)
    {
        $sql = "SELECT i.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_impresoras i
                LEFT JOIN tbl_dependencias d ON i.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON i.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON i.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON i.id_contacto = co.id_contacto
                WHERE i.id_impresora = $idImpresora AND i.status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertImpresora($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto)
    {
        $query_insert = "INSERT INTO tbl_impresoras(numero_impresora, marca, modelo, serial, consumible, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateImpresora($idImpresora, $numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto)
    {
        $sql = "UPDATE tbl_impresoras SET numero_impresora = ?, marca = ?, modelo = ?, serial = ?, consumible = ?, estado = ?, disponibilidad = ?, id_dependencia = ?, oficina = ?, id_funcionario = ?, id_cargo = ?, id_contacto = ? WHERE id_impresora = ?";
        $arrData = array($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto, $idImpresora);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteImpresora($idImpresora)
    {
        $sql = "UPDATE tbl_impresoras SET status = ? WHERE id_impresora = ?";
        $arrData = array(0, $idImpresora);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== ESCÁNERES ====================
    public function selectEscaneres()
    {
        $sql = "SELECT e.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_escaneres e
                LEFT JOIN tbl_dependencias d ON e.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON e.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON e.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON e.id_contacto = co.id_contacto
                WHERE e.status != 0
                ORDER BY e.numero_escaner ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectEscaner($idEscaner)
    {
        $sql = "SELECT e.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_escaneres e
                LEFT JOIN tbl_dependencias d ON e.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON e.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON e.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON e.id_contacto = co.id_contacto
                WHERE e.id_escaner = $idEscaner AND e.status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertEscaner($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto)
    {
        $query_insert = "INSERT INTO tbl_escaneres(numero_escaner, marca, modelo, serial, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateEscaner($idEscaner, $numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto)
    {
        $sql = "UPDATE tbl_escaneres SET numero_escaner = ?, marca = ?, modelo = ?, serial = ?, estado = ?, disponibilidad = ?, id_dependencia = ?, oficina = ?, id_funcionario = ?, id_cargo = ?, id_contacto = ? WHERE id_escaner = ?";
        $arrData = array($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, $dependencia, $oficina, $funcionario, $cargo, $contacto, $idEscaner);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteEscaner($idEscaner)
    {
        $sql = "UPDATE tbl_escaneres SET status = ? WHERE id_escaner = ?";
        $arrData = array(0, $idEscaner);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== PAPELERÍA ====================
    public function selectPapeleria()
    {
        $sql = "SELECT * FROM tbl_papeleria WHERE status != 0 ORDER BY item ASC";
        $data = $this->select_all($sql);

        // Asegurar que disponibilidad sea int y agregar columna de opciones
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['disponibilidad'] = (int)$data[$i]['disponibilidad'];
                $btnEdit = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary btn-sm" onClick="editArticuloPapeleria(' . $data[$i]['id_papeleria'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }

                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="delArticuloPapeleria(' . $data[$i]['id_papeleria'] . ')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
                }

                $data[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
        }

        return $data;
    }

    public function selectArticuloPapeleria($idPapeleria)
    {
        $sql = "SELECT id_papeleria, item, disponibilidad, status
                FROM tbl_papeleria 
                WHERE id_papeleria = $idPapeleria AND status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertArticuloPapeleria($item, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_papeleria(item, disponibilidad, status) VALUES(?,?,?)";
        $arrData = array($item, $disponibilidad, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateArticuloPapeleria($idPapeleria, $item, $disponibilidad)
    {
        $sql = "UPDATE tbl_papeleria SET item = ?, disponibilidad = ? WHERE id_papeleria = ?";
        $arrData = array($item, $disponibilidad, $idPapeleria);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteArticuloPapeleria($idPapeleria)
    {
        $sql = "UPDATE tbl_papeleria SET status = ? WHERE id_papeleria = ?";
        $arrData = array(0, $idPapeleria);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== FUNCIONARIOS ====================
    public function selectFuncionarios()
    {
        $sql = "SELECT 
            f.idefuncionario AS id_funcionario, 
            f.nombre_completo, 
            f.dependencia_fk AS id_dependencia, 
            d.nombre_dependencia, 
            f.cargo_fk AS id_cargo, 
            c.nombre_cargo, 
            f.celular AS contacto
        FROM tbl_funcionarios_planta f
        LEFT JOIN tbl_dependencias d ON f.dependencia_fk = d.id_dependencia
        LEFT JOIN tbl_cargos c ON f.cargo_fk = c.id_cargo
        WHERE f.status = 1
        ORDER BY f.nombre_completo ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    // ==================== DEPENDENCIAS ====================
    public function selectDependencias()
    {
        $sql = "SELECT id_dependencia, nombre_dependencia 
                FROM tbl_dependencias 
                WHERE status != 0 
                ORDER BY nombre_dependencia ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    // ==================== CARGOS ====================
    public function selectCargos()
    {
        $sql = "SELECT id_cargo, nombre_cargo 
                FROM tbl_cargos 
                WHERE status != 0 
                ORDER BY nombre_cargo ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    // ==================== CONTACTOS ====================
    public function selectContactos()
    {
        $sql = "SELECT id_contacto, nombre_contacto 
                FROM tbl_contactos 
                WHERE status != 0 
                ORDER BY nombre_contacto ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    // ==================== TINTAS Y TÓNER ====================
    public function selectTintasToner()
    {
        $sql = "SELECT * FROM tbl_tintas_toner WHERE status != 0 ORDER BY item ASC";
        $data = $this->select_all($sql);

        // Agregar columna de opciones para cada registro
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $btnEdit = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary btn-sm" onClick="editTintaToner(' . $data[$i]['id_tinta_toner'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }

                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="delTintaToner(' . $data[$i]['id_tinta_toner'] . ')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
                }

                $data[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
        }

        return $data;
    }

    public function selectTintaToner($idTintaToner)
    {
        $sql = "SELECT id_tinta_toner, item, disponibles, impresora, modelos_compatibles, fecha_ultima_actualizacion, status
                FROM tbl_tintas_toner 
                WHERE id_tinta_toner = $idTintaToner AND status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertTintaToner($item, $disponibles, $impresora, $modelosCompatibles)
    {
        $query_insert = "INSERT INTO tbl_tintas_toner(item, disponibles, impresora, modelos_compatibles, fecha_ultima_actualizacion, status) VALUES(?,?,?,?,NOW(),?)";
        $arrData = array($item, $disponibles, $impresora, $modelosCompatibles, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateTintaToner($idTintaToner, $item, $disponibles, $impresora, $modelosCompatibles)
    {
        $sql = "UPDATE tbl_tintas_toner SET item = ?, disponibles = ?, impresora = ?, modelos_compatibles = ?, fecha_ultima_actualizacion = NOW() WHERE id_tinta_toner = ?";
        $arrData = array($item, $disponibles, $impresora, $modelosCompatibles, $idTintaToner);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteTintaToner($idTintaToner)
    {
        $sql = "UPDATE tbl_tintas_toner SET status = ? WHERE id_tinta_toner = ?";
        $arrData = array(0, $idTintaToner);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== PC TORRE ====================
    public function selectPcTorre()
    {
        $sql = "SELECT t.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_pc_torre t
                LEFT JOIN tbl_dependencias d ON t.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON t.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON t.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON t.id_contacto = co.id_contacto
                WHERE t.status != 0
                ORDER BY t.numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectPcTorreById($idPcTorre)
    {
        $sql = "SELECT t.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_pc_torre t
                LEFT JOIN tbl_dependencias d ON t.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON t.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON t.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON t.id_contacto = co.id_contacto
                WHERE t.id_pc_torre = ? AND t.status != 0";
        $data = $this->select($sql, array($idPcTorre));
        return $data;
    }

    public function insertPcTorre($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $query_insert = "INSERT INTO tbl_pc_torre(numero_pc, marca, serial, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, sistema_operativo, numero_activo, monitor, numero_activo_monitor, serial_monitor, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updatePcTorre($id_pc_torre, $numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $sql = "UPDATE tbl_pc_torre SET numero_pc=?, marca=?, serial=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, sistema_operativo=?, numero_activo=?, monitor=?, numero_activo_monitor=?, serial_monitor=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_pc_torre=?";
        $arrData = array($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto, $id_pc_torre);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deletePcTorre($id_pc_torre)
    {
        $sql = "UPDATE tbl_pc_torre SET status = 0 WHERE id_pc_torre = ?";
        $arrData = array($id_pc_torre);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== PC TODO EN UNO ====================
    public function selectTodoEnUno()
    {
        $sql = "SELECT t.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_todo_en_uno t
                LEFT JOIN tbl_dependencias d ON t.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON t.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON t.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON t.id_contacto = co.id_contacto
                WHERE t.status != 0
                ORDER BY t.numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectTodoEnUnoById($idTodoEnUno)
    {
        $sql = "SELECT t.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_todo_en_uno t
                LEFT JOIN tbl_dependencias d ON t.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON t.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON t.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON t.id_contacto = co.id_contacto
                WHERE t.id_todo_en_uno = ? AND t.status != 0";
        $data = $this->select($sql, array($idTodoEnUno));
        return $data;
    }

    public function insertTodoEnUno($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $query_insert = "INSERT INTO tbl_todo_en_uno(numero_pc, marca, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, serial, sistema_operativo, numero_activo, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateTodoEnUno($id_todo_en_uno, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $sql = "UPDATE tbl_todo_en_uno SET numero_pc=?, marca=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, serial=?, sistema_operativo=?, numero_activo=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_todo_en_uno=?";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto, $id_todo_en_uno);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteTodoEnUno($id_todo_en_uno)
    {
        $sql = "UPDATE tbl_todo_en_uno SET status = 0 WHERE id_todo_en_uno = ?";
        $arrData = array($id_todo_en_uno);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== PORTÁTILES ====================
    public function selectPortatiles()
    {
        $sql = "SELECT p.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_portatiles p
                LEFT JOIN tbl_dependencias d ON p.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON p.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON p.id_contacto = co.id_contacto
                WHERE p.status != 0
                ORDER BY p.numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectPortatilById($idPortatil)
    {
        $sql = "SELECT p.*, 
                       d.nombre_dependencia,
                       f.nombres as nombre_funcionario,
                       f.apellidos as apellido_funcionario,
                       c.nombre_cargo,
                       co.nombre_contacto
                FROM tbl_portatiles p
                LEFT JOIN tbl_dependencias d ON p.id_dependencia = d.id_dependencia
                LEFT JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.id_funcionario
                LEFT JOIN tbl_cargos c ON p.id_cargo = c.id_cargo
                LEFT JOIN tbl_contactos co ON p.id_contacto = co.id_contacto
                WHERE p.id_portatil = ? AND p.status != 0";
        $data = $this->select($sql, array($idPortatil));
        return $data;
    }

    public function insertPortatil($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $query_insert = "INSERT INTO tbl_portatiles(numero_pc, marca, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, serial, sistema_operativo, numero_activo, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updatePortatil($id_portatil, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto)
    {
        $sql = "UPDATE tbl_portatiles SET numero_pc=?, marca=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, serial=?, sistema_operativo=?, numero_activo=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_portatil=?";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto, $id_portatil);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deletePortatil($id_portatil)
    {
        $sql = "UPDATE tbl_portatiles SET status = 0 WHERE id_portatil = ?";
        $arrData = array($id_portatil);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // ==================== HERRAMIENTAS ====================
    public function selectHerramientas()
    {
        $sql = "SELECT id_herramienta, item, marca, disponibilidad FROM tbl_herramientas WHERE status != 0 ORDER BY item ASC";
        $data = $this->select_all($sql);
        
        // Agregar columna de opciones para cada registro
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $btnEdit = '';
                $btnDelete = '';
                
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary btn-sm" onClick="editHerramienta(' . $data[$i]['id_herramienta'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="delHerramienta(' . $data[$i]['id_herramienta'] . ')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
                }
                
                $data[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
        }
        
        return $data;
    }

    public function selectHerramientaById($idHerramienta)
    {
        $sql = "SELECT * FROM tbl_herramientas WHERE id_herramienta = ? AND status != 0";
        $data = $this->select($sql, array($idHerramienta));
        return $data;
    }

    public function insertHerramienta($item, $marca, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_herramientas(item, marca, disponibilidad, status) VALUES(?,?,?,1)";
        $arrData = array($item, $marca, $disponibilidad);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateHerramienta($id_herramienta, $item, $marca, $disponibilidad)
    {
        $sql = "UPDATE tbl_herramientas SET item=?, marca=?, disponibilidad=? WHERE id_herramienta=?";
        $arrData = array($item, $marca, $disponibilidad, $id_herramienta);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteHerramienta($id_herramienta)
    {
        $sql = "UPDATE tbl_herramientas SET status = 0 WHERE id_herramienta = ?";
        $arrData = array($id_herramienta);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
