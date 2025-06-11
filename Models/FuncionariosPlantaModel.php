<?php
class FuncionariosPlantaModel extends Mysql
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
    private $intPeriodosVacaciones;

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
        try {
            // Verificar que las claves foráneas existan
            $sqlCargo = "SELECT idecargos FROM tbl_cargos WHERE idecargos = $cargo";
            $requestCargo = $this->select($sqlCargo);
            if(empty($requestCargo)) {
                return 0;
            }

            $sqlDependencia = "SELECT dependencia_pk FROM tbl_dependencia WHERE dependencia_pk = $dependencia";
            $requestDependencia = $this->select($sqlDependencia);
            if(empty($requestDependencia)) {
                return 0;
            }

            $sqlContrato = "SELECT id_contrato FROM tbl_contrato WHERE id_contrato = $contrato";
            $requestContrato = $this->select($sqlContrato);
            if(empty($requestContrato)) {
                return 0;
            }

            // Asignar los valores
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

            // Verificar duplicados
            $sql = "SELECT * FROM tbl_funcionarios_planta WHERE correo_elc = '{$this->strCorreoFuncionarios}' OR nm_identificacion = '{$this->strIdentificacion}'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO tbl_funcionarios_planta(
                    correo_elc, nombre_completo, imagen, nm_identificacion,
                    cargo_fk, dependencia_fk, contrato_fk, celular, direccion, fecha_ingreso,
                    hijos, nombres_de_hijos, sexo, lugar_de_residencia,
                    edad, estado_civil, religion, formacion_academica, nombre_formacion,
                    status, periodos_vacaciones)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0)";

                $arrData = array(
                    $this->strCorreoFuncionarios,
                    $this->strNombresFuncionarios,
                    $this->strImagen,
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
                    $this->strNombreFormacion,
                    $this->strStatusFuncionarios
                );

                $request_insert = $this->insert($query_insert, $arrData);
                return $request_insert;
            } else {
                if (!empty($request[0]['correo_elc']) && $request[0]['correo_elc'] == $this->strCorreoFuncionarios) {
                    return "exist_email";
                } else {
                    return "exist_id";
                }
            }
        } catch (Exception $e) {
            return 0;
        }
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
        u.periodos_vacaciones
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
                u.periodos_vacaciones
            FROM tbl_funcionarios_planta u
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

        $sql = "UPDATE tbl_funcionarios_planta SET correo_elc=?, nombre_completo=?, imagen=?, status=?, nm_identificacion=?, cargo_fk=?, dependencia_fk=?, contrato_fk=?, celular=?, direccion=?, fecha_ingreso=?, hijos=?, nombres_de_hijos=?, sexo=?, lugar_de_residencia=?, edad=?, estado_civil=?, religion=?, formacion_academica=?, nombre_formacion=? WHERE idefuncionario = $this->intIdeFuncionarios";
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
        $sql = "UPDATE tbl_funcionarios_planta SET status = ? WHERE idefuncionario = $this->intIdeFuncionarios";
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
    public function selectContratoPlanta() {
    $sql = "SELECT id_contrato, tipo_cont FROM tbl_contrato WHERE tipo_cont IN ('Carrera', 'Libre Nombramiento')";
    $request = $this->select_all($sql);
    return $request;
}

}