<?php
class FuncionariosOpsPermisosModel extends Mysql
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
            u.nombre_formacion
        FROM tbl_funcionarios_ops u
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
                u.nombre_formacion
            FROM tbl_funcionarios_ops u
            INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
            INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
            WHERE u.idefuncionario = $this->intIdeFuncionarios";

        $request = $this->select($sql);
        return $request;
    }

    public function getMotivosPermisos()
    {
        $sql = "SELECT id_motivo as id, descripcion as motivo FROM tbl_motivo_permiso WHERE status = 1";
        $request = $this->select_all($sql);
        return $request;
    }
}