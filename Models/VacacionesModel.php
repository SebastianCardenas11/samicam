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
                WHEN TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) > 0 THEN 
                    LEAST(3, TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) - u.periodos_vacaciones)
                ELSE 0
            END as periodos_disponibles
        FROM tbl_funcionarios u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.status != 0 
          AND ct.tipo_cont IN ('Carrera', 'Libre Nombramiento') " . $whereAdmin;

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
                WHEN TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) > 0 THEN 
                    LEAST(3, TIMESTAMPDIFF(YEAR, u.fecha_ingreso, CURRENT_DATE()) - u.periodos_vacaciones)
                ELSE 0
            END as periodos_disponibles
        FROM tbl_funcionarios u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.idefuncionario = $idefuncionario";

        $request = $this->select($sql);
        return $request;
    }

    public function getHistorialVacaciones(int $idFuncionario)
    {
        $sql = "SELECT 
                id_vacaciones,
                fecha_inicio,
                fecha_fin,
                periodo,
                estado,
                fecha_registro
            FROM tbl_vacaciones
            WHERE id_funcionario = $idFuncionario
            ORDER BY fecha_inicio DESC";
        
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertVacaciones(int $idFuncionario, string $fechaInicio, string $fechaFin, int $periodo)
    {
        $this->intIdFuncionario = $idFuncionario;
        $this->dateFechaInicio = $fechaInicio;
        $this->dateFechaFin = $fechaFin;
        $this->intPeriodo = $periodo;
        
        // Verificar si el funcionario tiene períodos disponibles
        $funcionario = $this->selectFuncionario($idFuncionario);
        if ($funcionario['periodos_disponibles'] <= 0) {
            return ["status" => false, "msg" => "El funcionario no tiene períodos de vacaciones disponibles."];
        }
        
        // Insertar registro de vacaciones
        $query_insert = "INSERT INTO tbl_vacaciones(id_funcionario, fecha_inicio, fecha_fin, periodo, estado) 
                        VALUES(?,?,?,?,?)";
        
        $arrData = array(
            $this->intIdFuncionario,
            $this->dateFechaInicio,
            $this->dateFechaFin,
            $this->intPeriodo,
            'Aprobado'
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        
        if ($request_insert > 0) {
            // Actualizar períodos tomados por el funcionario
            $sql_update = "UPDATE tbl_funcionarios SET periodos_vacaciones = periodos_vacaciones + ? WHERE idefuncionario = ?";
            $arrData_update = array($periodo, $idFuncionario);
            $this->update($sql_update, $arrData_update);
            
            return ["status" => true, "msg" => "Vacaciones registradas correctamente", "id" => $request_insert];
        } else {
            return ["status" => false, "msg" => "Error al registrar las vacaciones"];
        }
    }

    public function cancelarVacaciones(int $idVacaciones)
    {
        $this->intIdVacaciones = $idVacaciones;
        
        // Obtener información de las vacaciones
        $sql = "SELECT id_funcionario, periodo FROM tbl_vacaciones WHERE id_vacaciones = $this->intIdVacaciones";
        $vacacion = $this->select($sql);
        
        if (empty($vacacion)) {
            return ["status" => false, "msg" => "Registro de vacaciones no encontrado."];
        }
        
        // Actualizar estado de las vacaciones
        $sql_update = "UPDATE tbl_vacaciones SET estado = ? WHERE id_vacaciones = ?";
        $arrData = array('Cancelado', $this->intIdVacaciones);
        $request = $this->update($sql_update, $arrData);
        
        if ($request) {
            // Devolver los períodos al funcionario
            $sql_update_func = "UPDATE tbl_funcionarios SET periodos_vacaciones = periodos_vacaciones - ? WHERE idefuncionario = ?";
            $arrData_func = array($vacacion['periodo'], $vacacion['id_funcionario']);
            $this->update($sql_update_func, $arrData_func);
            
            return ["status" => true, "msg" => "Vacaciones canceladas correctamente"];
        } else {
            return ["status" => false, "msg" => "Error al cancelar las vacaciones"];
        }
    }
}