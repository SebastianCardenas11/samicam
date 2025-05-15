<?php
class FuncionariosPermisosModel extends Mysql
{
    private $intIdeFuncionarios;
    private $strCorreoFuncionarios;
    private $strNombresFuncionarios;
    private $strStatusFuncionarios;
    private $strIdentificacion;
    private $intCargo;
    private $intDependencia;
    private $intContrato;
    private $strCelular;
    private $strDireccion;
    private $strFechaIngreso;
    private $strFechaVacaciones;
    private $strVacaciones;
    private $intHijos;
    private $strNombreHijos;
    private $strSexo;
    private $strLugarResidencia;
    private $intEdad;
    private $strEstadoCivil;
    private $strReligion;
    private $strFormacionAcademica;
    private $strNombreFormacion;
    private $strPermiso;
    
    // Variables para permisos
    private $intIdPermiso;
    private $intIdFuncionario;
    private $dateFechaPermiso;
    private $intMes;
    private $intAnio;
    private $intIdMotivo;
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
            u.correo_elc,
            u.nombre_completo,
            u.status,
            u.nm_identificacion,
            c.nombre AS cargo_nombre,
            d.nombre AS dependencia_nombre,
            ct.tipo_cont AS contrato_nombre,
            u.celular,
            u.direccion,
            u.vacaciones,
            u.fecha_ingreso,
            u.fecha_vacaciones,
            u.hijos,
            u.nombres_de_hijos,
            u.sexo,
            u.lugar_de_residencia,
            u.edad,
            u.estado_civil,
            u.religion,
            u.formacion_academica,
            u.nombre_formacion,
            u.permisos_fk,
            (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND mes = MONTH(CURRENT_DATE()) AND anio = YEAR(CURRENT_DATE())) as permisos_mes_actual
        FROM tbl_funcionarios u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.status != 0 
          AND ct.tipo_cont IN ('Carrera', 'Libre Nombramiento') " . $whereAdmin;

        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFuncionario(int $idefuncionarios)
    {
        $this->intIdeFuncionarios = $idefuncionarios;

        $sql = "SELECT 
                    u.idefuncionario,
                    u.correo_elc,
                    u.nombre_completo,
                    u.status,
                    u.nm_identificacion,
                    u.cargo_fk,
                    c.nombre AS cargo_nombre,
                    u.dependencia_fk,
                    d.nombre AS dependencia_nombre,
                    u.contrato_fk,
                    ct.tipo_cont AS contrato_nombre,
                    u.celular,
                    u.direccion,
                    u.fecha_ingreso,
                    u.vacaciones,
                    u.fecha_vacaciones,
                    u.hijos,
                    u.nombres_de_hijos,
                    u.sexo,
                    u.lugar_de_residencia,
                    u.edad,
                    u.estado_civil,
                    u.religion,
                    u.formacion_academica,
                    u.nombre_formacion,
                    u.permisos_fk,
                    (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND mes = MONTH(CURRENT_DATE()) AND anio = YEAR(CURRENT_DATE())) as permisos_mes_actual
                FROM tbl_funcionarios u
                INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
                INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
                INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
                WHERE u.idefuncionario = $this->intIdeFuncionarios";

        $request = $this->select($sql);
        return $request;
    }

    public function getPermisosHistorial(int $idFuncionario)
    {
        $sql = "SELECT 
                    p.id_permiso,
                    p.fecha_permiso,
                    p.mes,
                    p.anio,
                    p.motivo,
                    p.estado
                FROM tbl_permisos p
                WHERE p.id_funcionario = $idFuncionario
                ORDER BY p.fecha_permiso DESC";
        
        $request = $this->select_all($sql);
        return $request;
    }

    public function contarPermisosMes(int $idFuncionario, int $mes, int $anio)
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                WHERE id_funcionario = $idFuncionario 
                AND mes = $mes 
                AND anio = $anio";
        
        $request = $this->select($sql);
        return $request['total'];
    }

    public function insertPermiso(int $idFuncionario, string $fecha, int $idMotivo)
    {
        $this->intIdFuncionario = $idFuncionario;
        $this->dateFechaPermiso = $fecha;
        $this->intIdMotivo = $idMotivo;
        $this->intMes = date('n', strtotime($fecha));
        $this->intAnio = date('Y', strtotime($fecha));
        
        // Verificar si ya tiene 3 permisos en el mes
        $totalPermisos = $this->contarPermisosMes($idFuncionario, $this->intMes, $this->intAnio);
        
        if ($totalPermisos >= 3) {
            // Crear notificación de límite excedido
            $this->crearNotificacion($idFuncionario, "El funcionario ha excedido el límite de 3 permisos para el mes " . $this->intMes . "/" . $this->intAnio);
            return ["status" => false, "msg" => "El funcionario ya ha utilizado los 3 permisos permitidos para este mes."];
        }
        
        // Obtener el motivo para el historial
        $motivo = $this->getMotivo($this->intIdMotivo);
        
        $query_insert = "INSERT INTO tbl_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado) 
                        VALUES(?,?,?,?,?,?)";
        
        $arrData = array(
            $this->intIdFuncionario,
            $this->dateFechaPermiso,
            $this->intMes,
            $this->intAnio,
            $motivo,
            'Aprobado'
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        
        // Registrar en historial
        if ($request_insert > 0) {
            $this->registrarHistorial($idFuncionario, $fecha, $this->intMes, $this->intAnio, $motivo, 'Aprobado');
            
            // Si es el tercer permiso, crear notificación
            if ($totalPermisos == 2) {
                $this->crearNotificacion($idFuncionario, "El funcionario ha utilizado sus 3 permisos para el mes " . $this->intMes . "/" . $this->intAnio);
            }
            
            return ["status" => true, "msg" => "Permiso registrado correctamente", "id" => $request_insert];
        } else {
            return ["status" => false, "msg" => "Error al registrar el permiso"];
        }
    }

    private function getMotivo(int $idMotivo)
    {
        $sql = "SELECT motivo FROM tbl_motivos_permisos WHERE id = $idMotivo";
        $request = $this->select($sql);
        return $request['motivo'];
    }

    private function registrarHistorial(int $idFuncionario, string $fecha, int $mes, int $anio, string $motivo, string $estado)
    {
        try {
            $query_insert = "INSERT INTO tbl_historial_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado) 
                            VALUES(?,?,?,?,?,?)";
            
            $arrData = array(
                $idFuncionario,
                $fecha,
                $mes,
                $anio,
                $motivo,
                $estado
            );
            
            return $this->insert($query_insert, $arrData);
        } catch (Exception $e) {
            // Registrar el error pero continuar con la ejecución
            error_log("Error al registrar historial: " . $e->getMessage());
            return false;
        }
    }

    private function crearNotificacion(int $idFuncionario, string $mensaje)
    {
        $query_insert = "INSERT INTO tbl_notificaciones(id_funcionario, mensaje) 
                        VALUES(?,?)";
        
        $arrData = array(
            $idFuncionario,
            $mensaje
        );
        
        $this->insert($query_insert, $arrData);
    }
    
    public function selectMotivosPermisos()
    {
        $sql = "SELECT id, motivo FROM tbl_motivos_permisos WHERE status = 1 ORDER BY motivo ASC";
        $request = $this->select_all($sql);
        return $request;
    }
}