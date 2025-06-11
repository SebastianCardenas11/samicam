<?php
class VacacionesModel extends Mysql
{
    private $intIdVacaciones;
    private $intIdFuncionario;
    private $dateFechaInicio;
    private $dateFechaFin;
    private $intPeriodo;
    private $strEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectFuncionarios()
    {
        $whereAdmin = "";
        if ($_SESSION['idUser'] != 1) {
            $whereAdmin = " and u.idefuncionario != 1 ";
        }
        $sql = "SELECT DISTINCT
            u.idefuncionario,
            u.nombre_completo,
            u.nm_identificacion,
            c.nombre AS cargo_nombre,
            d.nombre AS dependencia_nombre,
            u.fecha_ingreso,
            u.periodos_vacaciones,
            TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) as anos_servicio,
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) >= 1 THEN 
                    GREATEST(0, 3 - u.periodos_vacaciones)
                ELSE 0 
            END as periodos_disponibles
        FROM tbl_funcionarios_planta u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.status != 0 " . $whereAdmin . "
        GROUP BY u.idefuncionario";

        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFuncionario(int $idefuncionario)
    {
        $sql = "SELECT 
            u.idefuncionario,
            u.nombre_completo,
            u.nm_identificacion,
            c.nombre AS cargo_nombre,
            d.nombre AS dependencia_nombre,
            u.fecha_ingreso,
            u.periodos_vacaciones,
            TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) as anos_servicio,
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) >= 1 THEN 
                    GREATEST(0, 3 - u.periodos_vacaciones)
                ELSE 0 
            END as periodos_disponibles
        FROM tbl_funcionarios_planta u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.idefuncionario = $idefuncionario";

        $request = $this->select($sql);
        return $request;
    }

    public function getHistorialVacaciones(int $idFuncionario)
    {
        // Primero actualizamos el estado de las vacaciones que ya han finalizado
        $this->actualizarEstadoVacaciones();
        
        $sql = "SELECT 
                id_vacaciones,
                fecha_inicio,
                fecha_fin,
                periodo,
                estado,
                fecha_registro
            FROM tbl_vacaciones
            WHERE id_funcionario = $idFuncionario
            AND tipo_funcionario = 'planta'
            ORDER BY fecha_inicio DESC";
        
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function actualizarEstadoVacaciones()
    {
        // Usar la fecha y hora actual del servidor con zona horaria correcta
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');
        
        // Actualizar vacaciones que ya han finalizado a estado "Cumplidas"
        $sql = "UPDATE tbl_vacaciones 
                SET estado = 'Cumplidas' 
                WHERE estado = 'Aprobado' 
                AND DATE(fecha_fin) <= '$fechaActual'";
        
        return $this->update($sql, []);
    }

    public function insertVacaciones(int $idFuncionario, string $fechaInicio, string $fechaFin, int $periodo)
    {
        // Asegurar que estamos usando la zona horaria correcta
        date_default_timezone_set('America/Bogota');
        
        $this->intIdFuncionario = $idFuncionario;
        $this->dateFechaInicio = $fechaInicio;
        $this->dateFechaFin = $fechaFin;
        $this->intPeriodo = $periodo;
        
        // Verificar si el funcionario tiene períodos disponibles
        $funcionario = $this->selectFuncionario($idFuncionario);
        if ($funcionario['periodos_disponibles'] < $periodo) {
            return ["status" => false, "msg" => "El funcionario no tiene suficientes períodos de vacaciones disponibles."];
        }
        
        // Verificar si ya hay vacaciones pendientes o aprobadas para este funcionario
        $sql_check = "SELECT COUNT(*) as total FROM tbl_vacaciones 
                     WHERE id_funcionario = $this->intIdFuncionario 
                     AND tipo_funcionario = 'planta'
                     AND estado IN ('Pendiente', 'Aprobado')";
        
        $result_check = $this->select($sql_check);
        if ($result_check['total'] > 0) {
            return ["status" => false, "msg" => "El funcionario ya tiene vacaciones pendientes o aprobadas. No se pueden crear más hasta que se completen o cancelen las existentes."];
        }
        
        // Establecer el estado inicial como Pendiente
        $estado = 'Pendiente';
        
        // Insertar registro de vacaciones
        $query_insert = "INSERT INTO tbl_vacaciones(id_funcionario, fecha_inicio, fecha_fin, periodo, estado, tipo_funcionario) 
                        VALUES(?,?,?,?,?,?)";
        
        $arrData = array(
            $this->intIdFuncionario,
            $this->dateFechaInicio,
            $this->dateFechaFin,
            $this->intPeriodo,
            $estado,
            'planta'
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        
        if ($request_insert > 0) {
            return ["status" => true, "msg" => "Vacaciones registradas correctamente. Pendientes de aprobación.", "id" => $request_insert];
        } else {
            return ["status" => false, "msg" => "Error al registrar las vacaciones"];
        }
    }

    public function aprobarVacaciones(int $idVacaciones)
    {
        $this->intIdVacaciones = $idVacaciones;
        
        // Obtener información de las vacaciones
        $sql = "SELECT id_funcionario, periodo, estado FROM tbl_vacaciones WHERE id_vacaciones = $this->intIdVacaciones";
        $vacacion = $this->select($sql);
        
        if (empty($vacacion)) {
            return ["status" => false, "msg" => "Registro de vacaciones no encontrado."];
        }
        
        // Verificar si las vacaciones están en estado pendiente
        if ($vacacion['estado'] != 'Pendiente') {
            return ["status" => false, "msg" => "Solo se pueden aprobar vacaciones en estado pendiente."];
        }
        
        // Actualizar estado de las vacaciones
        $sql_update = "UPDATE tbl_vacaciones SET estado = ? WHERE id_vacaciones = ?";
        $arrData = array('Aprobado', $this->intIdVacaciones);
        $request = $this->update($sql_update, $arrData);
        
        if ($request) {
            // Actualizar períodos tomados por el funcionario (incrementar los períodos tomados)
            $sql_update_func = "UPDATE tbl_funcionarios_planta SET periodos_vacaciones = periodos_vacaciones + 1 WHERE idefuncionario = ?";
            $arrData_func = array($vacacion['id_funcionario']);
            $this->update($sql_update_func, $arrData_func);
            
            return ["status" => true, "msg" => "Vacaciones aprobadas correctamente"];
        } else {
            return ["status" => false, "msg" => "Error al aprobar las vacaciones"];
        }
    }

    public function cancelarVacaciones(int $idVacaciones)
    {
        $this->intIdVacaciones = $idVacaciones;
        
        // Obtener información de las vacaciones
        $sql = "SELECT id_funcionario, periodo, estado, fecha_fin FROM tbl_vacaciones WHERE id_vacaciones = $this->intIdVacaciones";
        $vacacion = $this->select($sql);
        
        if (empty($vacacion)) {
            return ["status" => false, "msg" => "Registro de vacaciones no encontrado."];
        }
        
        // Verificar si las vacaciones ya están cumplidas
        if ($vacacion['estado'] == 'Cumplidas') {
            return ["status" => false, "msg" => "No se pueden cancelar vacaciones que ya han sido cumplidas."];
        }
        
        // Actualizar estado de las vacaciones
        $sql_update = "UPDATE tbl_vacaciones SET estado = ? WHERE id_vacaciones = ?";
        $arrData = array('Cancelado', $this->intIdVacaciones);
        $request = $this->update($sql_update, $arrData);
        
        if ($request) {
            // Solo devolver los períodos al funcionario si estaban aprobadas
            if ($vacacion['estado'] == 'Aprobado') {
                $sql_update_func = "UPDATE tbl_funcionarios_planta SET periodos_vacaciones = periodos_vacaciones - 1 WHERE idefuncionario = ?";
                $arrData_func = array($vacacion['id_funcionario']);
                $this->update($sql_update_func, $arrData_func);
            }
            
            return ["status" => true, "msg" => "Vacaciones canceladas correctamente"];
        } else {
            return ["status" => false, "msg" => "Error al cancelar las vacaciones"];
        }
    }
}