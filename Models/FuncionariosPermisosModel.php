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
            u.fecha_ingreso,
            u.hijos,
            u.nombres_de_hijos,
            u.sexo,
            u.lugar_de_residencia,
            u.edad,
            u.estado_civil,
            u.religion,
            u.formacion_academica,
            u.nombre_formacion,
            (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND tipo_funcionario = 'planta' AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())) as permisos_mes_actual
        FROM tbl_funcionarios_planta u
        INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
        INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
        INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
        WHERE u.status != 0 " . $whereAdmin . "
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
                u.hijos,
                u.nombres_de_hijos,
                u.sexo,
                u.lugar_de_residencia,
                u.edad,
                u.estado_civil,
                u.religion,
                u.formacion_academica,
                u.nombre_formacion,
                (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND tipo_funcionario = 'planta' AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())) as permisos_mes_actual
            FROM tbl_funcionarios_planta u
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
            AND p.tipo_funcionario = 'planta'
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
                p.estado,
                p.tipo_funcionario
            FROM tbl_permisos p
            WHERE p.id_permiso = $idPermiso";
        
        $request = $this->select($sql);
        return $request;
    }

    public function getPermisosEnMes($idFuncionario)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                    WHERE id_funcionario = ? 
                    AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
                    AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
                    AND tipo_funcionario = 'planta'";
            $arrData = array($idFuncionario);
            $request = $this->select($sql, $arrData);
            return $request['total'];
        } catch (Exception $e) {
            error_log("Error en getPermisosEnMes: " . $e->getMessage());
            return 0;
        }
    }

    public function existePermisoEnFecha($idFuncionario, $fecha)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                    WHERE id_funcionario = ? 
                    AND fecha_permiso = ?
                    AND tipo_funcionario = 'planta'";
            $arrData = array($idFuncionario, $fecha);
            $request = $this->select($sql, $arrData);
            return $request['total'] > 0;
        } catch (Exception $e) {
            error_log("Error en existePermisoEnFecha: " . $e->getMessage());
            return false;
        }
    }

    public function insertPermiso($idFuncionario, $fechaPermiso, $idMotivo, $esPermisoEspecial = 0, $justificacionEspecial = '')
    {
        try {
            // Verificar si ya existe un permiso en la misma fecha
            if ($this->existePermisoEnFecha($idFuncionario, $fechaPermiso)) {
                return -1; // Código especial para indicar permiso duplicado
            }

            // Obtener el texto del motivo
            $sql_motivo = "SELECT descripcion FROM tbl_motivo_permiso WHERE id_motivo = ?";
            $arrMotivo = array($idMotivo);
            $request_motivo = $this->select($sql_motivo, $arrMotivo);
            
            if (empty($request_motivo)) {
                return 0;
            }
            
            $motivo_texto = $request_motivo['descripcion'];
            
            // Extraer mes y año de la fecha
            $fecha = new DateTime($fechaPermiso);
            $mes = $fecha->format('m');
            $anio = $fecha->format('Y');
            
            // Insertar en la tabla tbl_permisos
            $sql = "INSERT INTO tbl_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado, tipo_funcionario) 
                    VALUES(?, ?, ?, ?, ?, ?, ?)";
            
            $arrData = array(
                $idFuncionario,
                $fechaPermiso,
                $mes,
                $anio,
                $motivo_texto,
                'Aprobado',
                'planta'
            );
            
            $request = $this->insert($sql, $arrData);
            
            if ($request > 0) {
                // También insertar en el historial
                $sql_historial = "INSERT INTO tbl_historial_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado, tipo_funcionario) 
                                VALUES(?, ?, ?, ?, ?, ?, ?)";
                $this->insert($sql_historial, $arrData);
            }
            
            return $request;
            
        } catch (Exception $e) {
            error_log("Error en insertPermiso: " . $e->getMessage());
            return 0;
        }
    }

    public function getMotivosPermisos()
    {
        $sql = "SELECT id_motivo as id, descripcion as motivo FROM tbl_motivo_permiso WHERE status = 1";
        $request = $this->select_all($sql);
        return $request;
    }
}