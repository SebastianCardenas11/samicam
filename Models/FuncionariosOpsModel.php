<?php
class FuncionariosOpsModel extends Mysql
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

    public function __construct()
    {
        parent::__construct();
    }

    public function insertFuncionario(
        string $correo,
        string $nombres,
        string $imagen,
        int $status,
        string $identificacion,
        int $cargo,
        int $dependencia,
        int $contrato,
        string $celular,
        string $direccion,
        string $fechaIngreso,
        int $hijos,
        string $nombreHijos,
        string $sexo,
        string $lugarResidencia,
        int $edad,
        string $estadoCivil,
        string $religion,
        string $formacion,
        string $nombreformacion
    ) {
        // Asignar los valores de los campos
        $this->strCorreoFuncionarios = $correo;
        $this->strNombresFuncionarios = $nombres;
        $this->strImagen = $imagen;
        $this->strStatusFuncionarios = $status;
        $this->strIdentificacion = $identificacion;
        $this->intCargo = $cargo;
        $this->intDependencia = $dependencia;
        $this->intContrato = $contrato;
        $this->strCelular = $celular;
        $this->strDireccion = $direccion;
        $this->strFechaIngreso = $fechaIngreso;
        $this->intHijos = $hijos;
        $this->strNombreHijos = $nombreHijos;
        $this->strSexo = $sexo;
        $this->strLugarResidencia = $lugarResidencia;
        $this->intEdad = $edad;
        $this->strEstadoCivil = $estadoCivil;
        $this->strReligion = $religion;
        $this->strFormacionAcademica = $formacion;
        $this->strNombreFormacion = $nombreformacion;
        // Verificar si ya existe el correo
        $return = 0;
        $sql = "SELECT * FROM tbl_funcionarios WHERE correo_elc = '{$this->strCorreoFuncionarios}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
        $query_insert = "INSERT INTO tbl_funcionarios(
    correo_elc, nombre_completo, imagen, status, nm_identificacion,
    cargo_fk, dependencia_fk, contrato_fk, celular, direccion, fecha_ingreso,
    hijos, nombres_de_hijos, sexo, lugar_de_residencia,
    edad, estado_civil, religion, formacion_academica, nombre_formacion
) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            
        
        $arrData = array(
            $this->strCorreoFuncionarios,
            $this->strNombresFuncionarios,
            $this->strImagen,
            $this->strStatusFuncionarios,
            $this->strIdentificacion,
            $this->intCargo,
            $this->intDependencia,
            $this->intContrato,
            $this->strCelular,
            $this->strDireccion,
            $this->strFechaIngreso,
            $this->intHijos,
            $this->strNombreHijos,
            $this->strSexo,
            $this->strLugarResidencia,
            $this->intEdad,
            $this->strEstadoCivil,
            $this->strReligion,
            $this->strFormacionAcademica,
            $this->strNombreFormacion
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
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
        u.nombre_formacion
    FROM tbl_funcionarios u
    INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
    INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
    INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
    WHERE u.status != 0 
      AND ct.tipo_cont = 'Prestacion de servicios' " . $whereAdmin . "
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
                u.nombre_formacion
            FROM tbl_funcionarios u
            INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
            INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
            WHERE u.idefuncionario = $this->intIdeFuncionarios";

    $request = $this->select($sql);
    return $request;
}


    public function updateFuncionario(
        int $idefuncionarios,
        string $correo,
        string $nombres,
        string $imagen,
        int $status,
        string $identificacion,
        int $cargo,
        int $dependencia,
        int $contrato,
        string $celular,
        string $direccion,
        string $fechaIngreso,
        int $hijos,
        string $nombreHijos,
        string $sexo,
        string $lugarResidencia,
        int $edad,
        string $estadoCivil,
        string $religion,
        string $formacion,
        string $nombreformacion
    ) {
        $this->intIdeFuncionarios = $idefuncionarios;
        $this->strCorreoFuncionarios = $correo;
        $this->strNombresFuncionarios = $nombres;
        $this->strImagen = $imagen;
        $this->strStatusFuncionarios = $status;
        $this->strIdentificacion = $identificacion;
        $this->intCargo = $cargo;
        $this->intDependencia = $dependencia;
        $this->intContrato = $contrato;
        $this->strCelular = $celular;
        $this->strDireccion = $direccion;
        $this->strFechaIngreso = $fechaIngreso;
        $this->intHijos = $hijos;
        $this->strNombreHijos = $nombreHijos;
        $this->strSexo = $sexo;
        $this->strLugarResidencia = $lugarResidencia;
        $this->intEdad = $edad;
        $this->strEstadoCivil = $estadoCivil;
        $this->strReligion = $religion;
        $this->strFormacionAcademica = $formacion;
        $this->strNombreFormacion = $nombreformacion;

        $sql = "UPDATE tbl_funcionarios SET correo_elc=?, nombre_completo=?, imagen=?, status=?, nm_identificacion=?, cargo_fk=?, dependencia_fk=?, contrato_fk=?, celular=?, direccion=?, fecha_ingreso=?, hijos=?, nombres_de_hijos=?, sexo=?, lugar_de_residencia=?, edad=?, estado_civil=?, religion=?, formacion_academica=?, nombre_formacion=? WHERE idefuncionario = $this->intIdeFuncionarios";
        $arrData = array(
            $this->strCorreoFuncionarios,
            $this->strNombresFuncionarios,
            $this->strImagen,
            $this->strStatusFuncionarios,
            $this->strIdentificacion,
            $this->intCargo,
            $this->intDependencia,
            $this->intContrato,
            $this->strCelular,
            $this->strDireccion,
            $this->strFechaIngreso,
            $this->intHijos,
            $this->strNombreHijos,
            $this->strSexo,
            $this->strLugarResidencia,
            $this->intEdad,
            $this->strEstadoCivil,
            $this->strReligion,
            $this->strFormacionAcademica,
            $this->strNombreFormacion
        );
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteFuncionario(int $intIdeFuncionarios)
    {
        $this->intIdeFuncionarios = $intIdeFuncionarios;
        $sql = "UPDATE tbl_funcionarios SET status = ? WHERE idefuncionario = $this->intIdeFuncionarios";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
    public function selectDependencias(){
        $sql = "SELECT dependencia_pk, nombre FROM tbl_dependencia";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCargos() {
    $sql = "SELECT idecargos, nombre, nivel, salario FROM tbl_cargos WHERE estatus = 1";
    $request = $this->select_all($sql);
    return $request;
    }
    public function selectContratoOps() {
    $sql = "SELECT id_contrato, tipo_cont FROM tbl_contrato WHERE tipo_cont = 'Prestacion de servicios'";
    $request = $this->select_all($sql);
    return $request;
}

   

}