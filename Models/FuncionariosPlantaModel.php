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
        // Registrar los datos recibidos para depuración
        error_log("Datos recibidos en insertFuncionario:");
        error_log("Correo: $correo");
        error_log("Nombre: $nombres");
        error_log("Cargo: $cargo");
        error_log("Dependencia: $dependencia");
        error_log("Contrato: $contrato");
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
        $sql = "SELECT * FROM tbl_funcionarios_planta WHERE correo_elc = '{$this->strCorreoFuncionarios}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            try {
                // Guardar la consulta en el log para depuración
                error_log("Intentando insertar funcionario planta: " . $this->strNombresFuncionarios);
                
                // Consulta con prepared statements
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
                error_log("Resultado de inserción: " . print_r($request_insert, true));
                $return = $request_insert;
            } catch (Exception $e) {
                error_log("Error en insertFuncionario: " . $e->getMessage());
                $return = 0;
            }
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