<?php
class PsiModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // ==================== PRÉSTAMOS ====================
    public function selectPrestamos()
    {
        $sql = "SELECT * FROM tbl_prestamos WHERE status != 0 ORDER BY fecha_prestamo DESC";
        return $this->select_all($sql);
    }
    public function selectPrestamo($id)
    {
        $sql = "SELECT p.*, fp.idefuncionario as funcionario_id 
                FROM tbl_prestamos p 
                LEFT JOIN tbl_funcionarios_planta fp ON p.funcionario_responsable = fp.nombre_completo
                WHERE p.id_prestamos = ? AND p.status != 0";
        return $this->select($sql, array($id));
    }
    public function insertPrestamo($funcionario_data, $fecha_prestamo, $fecha_devolucion, $tipo_equipo, $equipo_id, $observaciones)
    {
        // Obtener datos del equipo según el tipo
        $equipoData = $this->getEquipoData($tipo_equipo, $equipo_id);
        
        $sql = "INSERT INTO tbl_prestamos (tipo_funcionario, funcionario_responsable, dependencia, cargo_funcionario,
                fecha_prestamo, fecha_devolucion, item, dispositivo, marca_modelo, activo, serial, estado, 
                observaciones, equipo_id, equipo_tipo, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            'planta', $funcionario_data['nombre_completo'], $funcionario_data['dependencia'], $funcionario_data['cargo'],
            $fecha_prestamo, $fecha_devolucion,
            $equipoData['item'], $equipoData['dispositivo'], $equipoData['marca_modelo'],
            $equipoData['activo'], $equipoData['serial'], $equipoData['estado'],
            $observaciones, $equipo_id, $tipo_equipo, 1
        ];
        return $this->insert($sql, $arrData);
    }
    public function updatePrestamo($id, $funcionario_data, $fecha_prestamo, $fecha_devolucion, $tipo_equipo, $equipo_id, $observaciones)
    {
        // Obtener datos del equipo según el tipo
        $equipoData = $this->getEquipoData($tipo_equipo, $equipo_id);
        
        $sql = "UPDATE tbl_prestamos SET funcionario_responsable=?, dependencia=?, cargo_funcionario=?,
                fecha_prestamo=?, fecha_devolucion=?, item=?, dispositivo=?, marca_modelo=?, activo=?, 
                serial=?, estado=?, observaciones=?, equipo_id=?, equipo_tipo=? WHERE id_prestamos=?";
        $arrData = [
            $funcionario_data['nombre_completo'], $funcionario_data['dependencia'], $funcionario_data['cargo'],
            $fecha_prestamo, $fecha_devolucion,
            $equipoData['item'], $equipoData['dispositivo'], $equipoData['marca_modelo'],
            $equipoData['activo'], $equipoData['serial'], $equipoData['estado'],
            $observaciones, $equipo_id, $tipo_equipo, $id
        ];
        return $this->update($sql, $arrData);
    }
    public function deletePrestamo($id)
    {
        $sql = "UPDATE tbl_prestamos SET status = 0 WHERE id_prestamos = ?";
        return $this->update($sql, [$id]);
    }


    public function getFuncionariosPlanta() {
        $sql = "SELECT fp.idefuncionario AS id, fp.nombre_completo, d.nombre AS dependencia, c.nombre AS cargo 
                FROM tbl_funcionarios_planta fp 
                LEFT JOIN tbl_dependencia d ON fp.dependencia_fk = d.dependencia_pk 
                LEFT JOIN tbl_cargos c ON fp.cargo_fk = c.idecargos 
                WHERE fp.status = 1 ORDER BY fp.nombre_completo";
        return $this->select_all($sql);
    }
    
    public function getFuncionarioById($id) {
        $sql = "SELECT fp.idefuncionario AS id, fp.nombre_completo, d.nombre AS dependencia, c.nombre AS cargo 
                FROM tbl_funcionarios_planta fp 
                LEFT JOIN tbl_dependencia d ON fp.dependencia_fk = d.dependencia_pk 
                LEFT JOIN tbl_cargos c ON fp.cargo_fk = c.idecargos 
                WHERE fp.idefuncionario = ? AND fp.status = 1";
        return $this->select($sql, [$id]);
    }

    public function getDependencias() {
        $sql = "SELECT dependencia_pk as id, nombre FROM tbl_dependencia ORDER BY nombre";
        return $this->select_all($sql);
    }
    
    // Métodos para obtener equipos por tipo
    public function selectPcTorre() {
        $sql = "SELECT id_pc_torre as id, numero_pc, marca, modelo, serial, estado 
                FROM tbl_pc_torre WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY numero_pc";
        return $this->select_all($sql);
    }
    
    public function selectTodoEnUno() {
        $sql = "SELECT id_todo_en_uno as id, numero_todo_en_uno, marca, modelo, serial, estado 
                FROM tbl_todo_en_uno WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY numero_todo_en_uno";
        return $this->select_all($sql);
    }
    
    public function selectPortatiles() {
        $sql = "SELECT id_portatil as id, numero_portatil, marca, modelo, serial, estado 
                FROM tbl_portatiles WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY numero_portatil";
        return $this->select_all($sql);
    }
    
    public function selectImpresoras() {
        $sql = "SELECT id_impresora as id, numero_impresora, marca, modelo, serial, estado 
                FROM tbl_impresoras WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY numero_impresora";
        return $this->select_all($sql);
    }
    
    public function selectEscaneres() {
        $sql = "SELECT id_escaner as id, numero_escaner, marca, modelo, serial, estado 
                FROM tbl_escaneres WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY numero_escaner";
        return $this->select_all($sql);
    }
    
    public function selectHerramientas() {
        $sql = "SELECT id_herramienta as id, item, marca, 'Herramienta' as modelo, '' as serial, 'Bueno' as estado 
                FROM tbl_herramientas WHERE status = 1 AND disponibilidad = 'Disponible' ORDER BY item";
        return $this->select_all($sql);
    }
    
    private function getEquipoData($tipo_equipo, $equipo_id) {
        $data = array(
            'item' => '',
            'dispositivo' => '',
            'marca_modelo' => '',
            'activo' => '',
            'serial' => '',
            'estado' => ''
        );
        
        switch($tipo_equipo) {
            case 'pc_torre':
                $sql = "SELECT numero_pc as item, CONCAT(marca, ' ', modelo) as dispositivo, 
                        CONCAT(marca, ' ', modelo) as marca_modelo, numero_activo as activo, 
                        serial, estado FROM tbl_pc_torre WHERE id_pc_torre = ?";
                break;
            case 'todo_en_uno':
                $sql = "SELECT numero_todo_en_uno as item, CONCAT(marca, ' ', modelo) as dispositivo, 
                        CONCAT(marca, ' ', modelo) as marca_modelo, numero_activo as activo, 
                        serial, estado FROM tbl_todo_en_uno WHERE id_todo_en_uno = ?";
                break;
            case 'portatil':
                $sql = "SELECT numero_portatil as item, CONCAT(marca, ' ', modelo) as dispositivo, 
                        CONCAT(marca, ' ', modelo) as marca_modelo, numero_activo as activo, 
                        serial, estado FROM tbl_portatiles WHERE id_portatil = ?";
                break;
            case 'impresora':
                $sql = "SELECT numero_impresora as item, CONCAT(marca, ' ', modelo) as dispositivo, 
                        CONCAT(marca, ' ', modelo) as marca_modelo, numero_activo as activo, 
                        serial, estado FROM tbl_impresoras WHERE id_impresora = ?";
                break;
            case 'escaner':
                $sql = "SELECT numero_escaner as item, CONCAT(marca, ' ', modelo) as dispositivo, 
                        CONCAT(marca, ' ', modelo) as marca_modelo, numero_activo as activo, 
                        serial, estado FROM tbl_escaneres WHERE id_escaner = ?";
                break;
            case 'herramienta':
                $sql = "SELECT item, marca as dispositivo, marca as marca_modelo, 
                        '' as activo, '' as serial, 'Bueno' as estado 
                        FROM tbl_herramientas WHERE id_herramienta = ?";
                break;
            default:
                return $data;
        }
        
        $result = $this->select($sql, array($equipo_id));
        if($result) {
            $data = $result;
        }
        
        return $data;
    }

    // ==================== SALIDAS ====================
    public function selectSalidas()
    {
        $sql = "SELECT s.*, COUNT(d.id_detalle) as total_equipos 
                FROM tbl_psi_salidas s 
                LEFT JOIN tbl_psi_salidas_detalle d ON s.id_salida = d.id_salida 
                WHERE s.status != 0 
                GROUP BY s.id_salida 
                ORDER BY s.fecha DESC";
        return $this->select_all($sql);
    }

    public function insertSalidaConEquipos($fecha, $dependencia, $observaciones, $equipos, $tipo_equipo)
    {
        // Insertar salida principal
        $sql = "INSERT INTO tbl_psi_salidas (fecha, dependencia, observaciones, status) VALUES (?, ?, ?, ?)";
        $id_salida = $this->insert($sql, [$fecha, $dependencia, $observaciones, 1]);
        
        if($id_salida) {
            // Insertar detalles de equipos
            foreach($equipos as $equipo_id) {
                $equipoData = $this->getEquipoData($tipo_equipo, $equipo_id);
                $sqlDetalle = "INSERT INTO tbl_psi_salidas_detalle (id_salida, item, descripcion_dispositivo, 
                              marca, modelo, numero_activo, serial, equipo_id, equipo_tipo) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->insert($sqlDetalle, [
                    $id_salida, $equipoData['item'], $equipoData['dispositivo'],
                    $equipoData['marca_modelo'], $equipoData['marca_modelo'], $equipoData['activo'],
                    $equipoData['serial'], $equipo_id, $tipo_equipo
                ]);
            }
        }
        
        return $id_salida;
    }

    public function selectSalida($id)
    {
        $sql = "SELECT s.*, d.* FROM tbl_psi_salidas s 
                LEFT JOIN tbl_psi_salidas_detalle d ON s.id_salida = d.id_salida 
                WHERE s.id_salida = ? AND s.status != 0";
        return $this->select_all($sql, [$id]);
    }

    public function updateSalida($id, $fecha, $item, $tipo, $descripcion, $marca, $modelo, $activo, $serial, $dependencia, $observaciones)
    {
        $sql = "UPDATE tbl_psi_salidas SET fecha=?, item=?, tipo_dispositivo=?, descripcion_dispositivo=?, 
                marca=?, modelo=?, numero_activo=?, serial=?, dependencia=?, observaciones=? WHERE id_salida=?";
        $arrData = [$fecha, $item, $tipo, $descripcion, $marca, $modelo, $activo, $serial, $dependencia, $observaciones, $id];
        return $this->update($sql, $arrData);
    }

    // ==================== INGRESOS ====================
    public function selectIngresos()
    {
        $sql = "SELECT * FROM tbl_psi_ingresos WHERE status != 0 ORDER BY fecha DESC";
        return $this->select_all($sql);
    }

    public function insertIngresoFromInventario($fecha, $tipo_equipo, $equipo_id, $dependencia, $observaciones)
    {
        $equipoData = $this->getEquipoData($tipo_equipo, $equipo_id);
        
        $sql = "INSERT INTO tbl_psi_ingresos (fecha, item, tipo_dispositivo, descripcion_dispositivo, 
                marca, modelo, numero_activo, serial, dependencia, equipo_id, equipo_tipo, observaciones, status) 
                VALUES (?, ?, 'interno', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            $fecha, $equipoData['item'], $equipoData['dispositivo'], 
            $equipoData['marca_modelo'], $equipoData['marca_modelo'], $equipoData['activo'], 
            $equipoData['serial'], $dependencia, $equipo_id, $tipo_equipo, $observaciones, 1
        ];
        return $this->insert($sql, $arrData);
    }

    public function selectIngreso($id)
    {
        $sql = "SELECT * FROM tbl_psi_ingresos WHERE id_ingreso = ? AND status != 0";
        return $this->select($sql, [$id]);
    }

    public function updateIngreso($id, $fecha, $item, $tipo, $descripcion, $marca, $modelo, $activo, $serial, $dependencia, $observaciones)
    {
        $sql = "UPDATE tbl_psi_ingresos SET fecha=?, item=?, tipo_dispositivo=?, descripcion_dispositivo=?, 
                marca=?, modelo=?, numero_activo=?, serial=?, dependencia=?, observaciones=? WHERE id_ingreso=?";
        $arrData = [$fecha, $item, $tipo, $descripcion, $marca, $modelo, $activo, $serial, $dependencia, $observaciones, $id];
        return $this->update($sql, $arrData);
    }

}
