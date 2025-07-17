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
        $sql = "SELECT i.* FROM tbl_impresoras i WHERE i.status != 0 ORDER BY i.numero_impresora ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectImpresora($idImpresora)
    {
        $sql = "SELECT i.* FROM tbl_impresoras i WHERE i.id_impresora = $idImpresora AND i.status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertImpresora($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_impresoras(numero_impresora, marca, modelo, serial, consumible, estado, disponibilidad, status) VALUES(?,?,?,?,?,?,?,?)";
        $arrData = array($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateImpresora($idImpresora, $numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad)
    {
        $sql = "UPDATE tbl_impresoras SET numero_impresora = ?, marca = ?, modelo = ?, serial = ?, consumible = ?, estado = ?, disponibilidad = ? WHERE id_impresora = ?";
        $arrData = array($numeroImpresora, $marca, $modelo, $serial, $consumible, $estado, $disponibilidad, $idImpresora);
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
        $sql = "SELECT * FROM tbl_escaneres WHERE status != 0 ORDER BY numero_escaner ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectEscaner($idEscaner)
    {
        $sql = "SELECT * FROM tbl_escaneres WHERE id_escaner = $idEscaner AND status != 0";
        $data = $this->select($sql);
        return $data;
    }

    public function insertEscaner($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_escaneres(numero_escaner, marca, modelo, serial, estado, disponibilidad, status) VALUES(?,?,?,?,?,?,?)";
        $arrData = array($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, 1);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateEscaner($idEscaner, $numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad)
    {
        $sql = "UPDATE tbl_escaneres SET numero_escaner = ?, marca = ?, modelo = ?, serial = ?, estado = ?, disponibilidad = ? WHERE id_escaner = ?";
        $arrData = array($numeroEscaner, $marca, $modelo, $serial, $estado, $disponibilidad, $idEscaner);
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



    // ==================== DEPENDENCIAS ====================
    public function selectDependencias()
    {
        $sql = "SELECT dependencia_pk AS id_dependencia, nombre AS nombre_dependencia 
                FROM tbl_dependencia 
                ORDER BY nombre ASC";
        $data = $this->select_all($sql);
        return $data;
    }



    // ==================== TINTAS Y TÓNER ====================
    public function selectTintasToner()
    {
        $sql = "SELECT t.*, i.numero_impresora FROM tbl_tintas_toner t LEFT JOIN tbl_impresoras i ON t.impresora = i.id_impresora WHERE t.status != 0 ORDER BY t.item ASC";
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

    public function getImpresorasActivas()
    {
        $sql = "SELECT id_impresora, numero_impresora FROM tbl_impresoras WHERE status != 0 ORDER BY numero_impresora ASC";
        return $this->select_all($sql);
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
        $sql = "SELECT * FROM tbl_pc_torre WHERE status != 0 ORDER BY numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectPcTorreById($idPcTorre)
    {
        $sql = "SELECT * FROM tbl_pc_torre WHERE id_pc_torre = ? AND status != 0";
        $data = $this->select($sql, array($idPcTorre));
        return $data;
    }

    public function insertPcTorre($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_pc_torre(numero_pc, marca, serial, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, sistema_operativo, numero_activo, monitor, numero_activo_monitor, serial_monitor, estado, disponibilidad, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad);
        try {
            $request_insert = $this->insert($query_insert, $arrData);
            return $request_insert;
        } catch (Exception $e) {
            return ['error' => $e->getMessage(), 'query' => $query_insert, 'data' => $arrData];
        }
    }

    public function updatePcTorre($id_pc_torre, $numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad)
    {
        $sql = "UPDATE tbl_pc_torre SET numero_pc=?, marca=?, serial=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, sistema_operativo=?, numero_activo=?, monitor=?, numero_activo_monitor=?, serial_monitor=?, estado=?, disponibilidad=? WHERE id_pc_torre=?";
        $arrData = array($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_pc_torre);
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
        $sql = "SELECT * FROM tbl_todo_en_uno WHERE status != 0 ORDER BY numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectTodoEnUnoById($idTodoEnUno)
    {
        $sql = "SELECT * FROM tbl_todo_en_uno WHERE id_todo_en_uno = ? AND status != 0";
        $data = $this->select($sql, array($idTodoEnUno));
        return $data;
    }

    public function insertTodoEnUno($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_todo_en_uno(numero_pc, marca, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, serial, sistema_operativo, numero_activo, estado, disponibilidad, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
        try {
            $request_insert = $this->insert($query_insert, $arrData);
            return $request_insert;
        } catch (Exception $e) {
            return ['error' => $e->getMessage(), 'query' => $query_insert, 'data' => $arrData];
        }
    }

    public function updateTodoEnUno($id_todo_en_uno, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad)
    {
        $sql = "UPDATE tbl_todo_en_uno SET numero_pc=?, marca=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, serial=?, sistema_operativo=?, numero_activo=?, estado=?, disponibilidad=? WHERE id_todo_en_uno=?";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_todo_en_uno);
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
        $sql = "SELECT * FROM tbl_portatiles WHERE status != 0 ORDER BY numero_pc ASC";
        $data = $this->select_all($sql);
        return $data;
    }

    public function selectPortatilById($idPortatil)
    {
        $sql = "SELECT * FROM tbl_portatiles WHERE id_portatil = ? AND status != 0";
        $data = $this->select($sql, array($idPortatil));
        return $data;
    }

    public function insertPortatil($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad)
    {
        $query_insert = "INSERT INTO tbl_portatiles(numero_pc, marca, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, serial, sistema_operativo, numero_activo, estado, disponibilidad, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
        try {
            $request_insert = $this->insert($query_insert, $arrData);
            return $request_insert;
        } catch (Exception $e) {
            return ['error' => $e->getMessage(), 'query' => $query_insert, 'data' => $arrData];
        }
    }

    public function updatePortatil($id_portatil, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad)
    {
        $sql = "UPDATE tbl_portatiles SET numero_pc=?, marca=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, serial=?, sistema_operativo=?, numero_activo=?, estado=?, disponibilidad=? WHERE id_portatil=?";
        $arrData = array($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_portatil);
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

    // ==================== MOVIMIENTOS DE EQUIPOS ====================
    public function insertMovimientoEquipo($idEquipo, $tipoEquipo, $tipoMovimiento, $observacion, $usuario) {
        $sql = "INSERT INTO tbl_equipos_movimientos (id_equipo, tipo_equipo, tipo_movimiento, observacion, fecha_hora, usuario) VALUES (?, ?, ?, ?, NOW(), ?)";
        $arrData = array($idEquipo, $tipoEquipo, $tipoMovimiento, $observacion, $usuario);
        return $this->insert($sql, $arrData);
    }

    public function getMovimientosEquipo($idEquipo, $tipoEquipo) {
        $sql = "SELECT * FROM tbl_equipos_movimientos WHERE id_equipo = ? AND tipo_equipo = ? ORDER BY fecha_hora DESC";
        $arrData = array($idEquipo, $tipoEquipo);
        return $this->select_all($sql, $arrData);
    }
    
    public function getUltimoMovimientoEquipo($idEquipo, $tipoEquipo) {
        $sql = "SELECT * FROM tbl_equipos_movimientos WHERE id_equipo = ? AND tipo_equipo = ? ORDER BY fecha_hora DESC LIMIT 1";
        $arrData = array($idEquipo, $tipoEquipo);
        return $this->select($sql, $arrData);
    }
    
    public function actualizarDisponibilidadEquipo($idEquipo, $tipoEquipo, $disponibilidad) {
        $sql = "";
        switch($tipoEquipo) {
            case 'impresora':
                $sql = "UPDATE tbl_impresoras SET disponibilidad = ? WHERE id_impresora = ?";
                break;
            case 'escaner':
                $sql = "UPDATE tbl_escaneres SET disponibilidad = ? WHERE id_escaner = ?";
                break;
            case 'pc_torre':
                $sql = "UPDATE tbl_pc_torre SET disponibilidad = ? WHERE id_pc_torre = ?";
                break;
            case 'todo_en_uno':
                $sql = "UPDATE tbl_todo_en_uno SET disponibilidad = ? WHERE id_todo_en_uno = ?";
                break;
            case 'portatil':
                $sql = "UPDATE tbl_portatiles SET disponibilidad = ? WHERE id_portatil = ?";
                break;
        }
        
        if (!empty($sql)) {
            $arrData = array($disponibilidad, $idEquipo);
            return $this->update($sql, $arrData);
        }
        return false;
    }
    
    public function getHistoricoGlobal() {
        $sql = "SELECT m.*, 
                CASE 
                    WHEN m.tipo_equipo = 'impresora' THEN (SELECT numero_impresora FROM tbl_impresoras WHERE id_impresora = m.id_equipo)
                    WHEN m.tipo_equipo = 'escaner' THEN (SELECT numero_escaner FROM tbl_escaneres WHERE id_escaner = m.id_equipo)
                    WHEN m.tipo_equipo = 'pc_torre' THEN (SELECT numero_pc FROM tbl_pc_torre WHERE id_pc_torre = m.id_equipo)
                    WHEN m.tipo_equipo = 'todo_en_uno' THEN (SELECT numero_pc FROM tbl_todo_en_uno WHERE id_todo_en_uno = m.id_equipo)
                    WHEN m.tipo_equipo = 'portatil' THEN (SELECT numero_pc FROM tbl_portatiles WHERE id_portatil = m.id_equipo)
                    ELSE 'Desconocido'
                END AS nombre_equipo
                FROM tbl_equipos_movimientos m 
                ORDER BY m.fecha_hora DESC";
        return $this->select_all($sql);
    }
    
    public function getEstadisticasEstadoEquipos() {
        $sql = "SELECT 'Impresoras' as tipo, estado, COUNT(*) as cantidad FROM tbl_impresoras WHERE status != 0 GROUP BY estado
                UNION ALL
                SELECT 'Escáneres' as tipo, estado, COUNT(*) as cantidad FROM tbl_escaneres WHERE status != 0 GROUP BY estado
                UNION ALL
                SELECT 'PC Torre' as tipo, estado, COUNT(*) as cantidad FROM tbl_pc_torre WHERE status != 0 GROUP BY estado
                UNION ALL
                SELECT 'Todo en Uno' as tipo, estado, COUNT(*) as cantidad FROM tbl_todo_en_uno WHERE status != 0 GROUP BY estado
                UNION ALL
                SELECT 'Portátiles' as tipo, estado, COUNT(*) as cantidad FROM tbl_portatiles WHERE status != 0 GROUP BY estado";
        return $this->select_all($sql);
    }
    
    public function getEstadisticasDisponibilidadEquipos() {
        $sql = "SELECT 'Impresoras' as tipo, disponibilidad, COUNT(*) as cantidad FROM tbl_impresoras WHERE status != 0 GROUP BY disponibilidad
                UNION ALL
                SELECT 'Escáneres' as tipo, disponibilidad, COUNT(*) as cantidad FROM tbl_escaneres WHERE status != 0 GROUP BY disponibilidad
                UNION ALL
                SELECT 'PC Torre' as tipo, disponibilidad, COUNT(*) as cantidad FROM tbl_pc_torre WHERE status != 0 GROUP BY disponibilidad
                UNION ALL
                SELECT 'Todo en Uno' as tipo, disponibilidad, COUNT(*) as cantidad FROM tbl_todo_en_uno WHERE status != 0 GROUP BY disponibilidad
                UNION ALL
                SELECT 'Portátiles' as tipo, disponibilidad, COUNT(*) as cantidad FROM tbl_portatiles WHERE status != 0 GROUP BY disponibilidad";
        return $this->select_all($sql);
    }
    
    public function getEstadisticasMovimientosPorMes() {
        $sql = "SELECT 
                DATE_FORMAT(fecha_hora, '%Y-%m') as mes,
                COUNT(*) as total_movimientos,
                SUM(CASE WHEN tipo_movimiento = 'entrada' THEN 1 ELSE 0 END) as entradas,
                SUM(CASE WHEN tipo_movimiento = 'salida' THEN 1 ELSE 0 END) as salidas
                FROM tbl_equipos_movimientos
                WHERE fecha_hora >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(fecha_hora, '%Y-%m')
                ORDER BY mes ASC";
        return $this->select_all($sql);
    }
    
    public function getEquiposConMasMantenimientos() {
        $sql = "SELECT 
                m.tipo_equipo,
                m.id_equipo,
                CASE 
                    WHEN m.tipo_equipo = 'impresora' THEN (SELECT CONCAT('Impresora #', numero_impresora) FROM tbl_impresoras WHERE id_impresora = m.id_equipo)
                    WHEN m.tipo_equipo = 'escaner' THEN (SELECT CONCAT('Escáner #', numero_escaner) FROM tbl_escaneres WHERE id_escaner = m.id_equipo)
                    WHEN m.tipo_equipo = 'pc_torre' THEN (SELECT CONCAT('PC Torre #', numero_pc) FROM tbl_pc_torre WHERE id_pc_torre = m.id_equipo)
                    WHEN m.tipo_equipo = 'todo_en_uno' THEN (SELECT CONCAT('Todo en Uno #', numero_pc) FROM tbl_todo_en_uno WHERE id_todo_en_uno = m.id_equipo)
                    WHEN m.tipo_equipo = 'portatil' THEN (SELECT CONCAT('Portátil #', numero_pc) FROM tbl_portatiles WHERE id_portatil = m.id_equipo)
                    ELSE CONCAT(m.tipo_equipo, ' #', m.id_equipo)
                END AS nombre_equipo,
                COUNT(*) as total_mantenimientos,
                SUM(CASE WHEN m.tipo_movimiento = 'entrada' THEN 1 ELSE 0 END) as entradas,
                SUM(CASE WHEN m.tipo_movimiento = 'salida' THEN 1 ELSE 0 END) as salidas,
                MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_equipos_movimientos m
                GROUP BY m.tipo_equipo, m.id_equipo
                ORDER BY total_mantenimientos DESC
                LIMIT 10";
        return $this->select_all($sql);
    }
}
