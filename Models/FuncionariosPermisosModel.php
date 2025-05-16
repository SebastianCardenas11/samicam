<?php
class FuncionariosPermisosModel extends Mysql
{
    private $intIdeFuncionarios;
    private $strCorreoFuncionarios;
    private $strNombresFuncionarios;
    private $strImagen;
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
        $sql = "SELECT DISTINCT
            u.idefuncionario,
            u.correo_elc,
            u.nombre_completo,
            u.imagen,
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
            (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())) as permisos_mes_actual
        FROM tbl_funcionarios u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.status != 0 
        AND ct.tipo_cont IN ('Carrera', 'Libre Nombramiento')" . $whereAdmin . "
        GROUP BY u.idefuncionario";

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
                u.imagen,
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
                (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())) as permisos_mes_actual
            FROM tbl_funcionarios u
            INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
            INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
            WHERE u.idefuncionario = $this->intIdeFuncionarios";

        $request = $this->select($sql);
        return $request;
    }

    public function getHistorialPermisos(int $idFuncionario)
    {
        $sql = "SELECT 
                p.id_permiso,
                p.fecha_permiso,
                p.motivo,
                p.estado
            FROM tbl_permisos p
            WHERE p.id_funcionario = $idFuncionario
            ORDER BY p.fecha_permiso DESC";
        
        $request = $this->select_all($sql);
        return $request;
    }

    public function getPermiso(int $idPermiso)
    {
        $sql = "SELECT 
                p.id_permiso,
                p.id_funcionario,
                p.fecha_permiso,
                p.motivo,
                p.estado
            FROM tbl_permisos p
            WHERE p.id_permiso = $idPermiso";
        
        $request = $this->select($sql);
        return $request;
    }

    public function insertPermiso(int $idFuncionario, string $fechaPermiso, int $idMotivo)
    {
        $this->intIdFuncionario = $idFuncionario;
        $this->dateFechaPermiso = $fechaPermiso;
        $this->intIdMotivo = $idMotivo;
        
        // Extraer mes y año para contabilizar permisos
        $fecha = new DateTime($fechaPermiso);
        $this->intMes = $fecha->format('m');
        $this->intAnio = $fecha->format('Y');
        
        // Verificar si el funcionario ya tiene un permiso en la misma fecha
        $sql_check_same_day = "SELECT COUNT(*) as total FROM tbl_permisos 
                    WHERE id_funcionario = $this->intIdFuncionario 
                    AND fecha_permiso = '$this->dateFechaPermiso'";
        
        $result_same_day = $this->select($sql_check_same_day);
        if ($result_same_day['total'] > 0) {
            return ["status" => false, "msg" => "¡Ya existe un permiso registrado para este funcionario en la misma fecha!"];
        }
        
        // Verificar si el funcionario ya tiene 3 permisos en el mes actual
        $sql_check = "SELECT COUNT(*) as total FROM tbl_permisos 
                    WHERE id_funcionario = $this->intIdFuncionario 
                    AND MONTH(fecha_permiso) = $this->intMes 
                    AND YEAR(fecha_permiso) = $this->intAnio";
        
        $result = $this->select($sql_check);
        if ($result['total'] >= 3) {
            return ["status" => false, "msg" => "El funcionario ya ha utilizado los 3 permisos permitidos para este mes."];
        }
        
        // Obtener el texto del motivo
        $sql_motivo = "SELECT descripcion FROM tbl_motivo_permiso WHERE id_motivo = $this->intIdMotivo";
        $motivo_result = $this->select($sql_motivo);
        $motivo_texto = $motivo_result ? $motivo_result['descripcion'] : "Otro";
        
        // Insertar registro de permiso
        $query_insert = "INSERT INTO tbl_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado) 
                        VALUES(?,?,?,?,?,?)";
        
        $arrData = array(
            $this->intIdFuncionario,
            $this->dateFechaPermiso,
            $this->intMes,
            $this->intAnio,
            $motivo_texto,
            'Aprobado'
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        
        if ($request_insert > 0) {
            return ["status" => true, "msg" => "Permiso registrado correctamente", "id" => $request_insert];
        } else {
            return ["status" => false, "msg" => "Error al registrar el permiso"];
        }
    }

    public function getMotivosPermisos()
    {
        $sql = "SELECT id_motivo as id, descripcion as motivo FROM tbl_motivo_permiso WHERE status = 1";
        $request = $this->select_all($sql);
        return $request;
    }
}