<?php
class FuncionariosPlantaModel extends Mysql
{
    private $intIdeFuncionarios;
    private $strCorreoFuncionarios;
    private $strNombresFuncionarios;
    private $strStatusFuncionarios;
    private $strIdentificacion;
    private $strCargo;
    private $strDependencia;
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
    private $strNivelEscolar;
    private $strCarrera;
    private $strEspecialidad;
    private $strMaestria;
    private $strDoctorado;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertFuncionario(
        string $correo,
        string $nombres,
        int $status,
        string $identificacion,
        string $cargo,
        string $dependencia,
        string $celular,
        string $direccion,
        string $fechaIngreso,
        // string $fechaVacaciones,
        // string $vacaciones,
        int $hijos,
        string $nombreHijos,
        string $sexo,
        string $lugarResidencia,
        int $edad,
        string $estadoCivil,
        string $religion,
        string $nivelEscolar,
        string $carrera,
        string $especialidad,
        string $maestria,
        string $doctorado
    ) {
        // Asignar los valores de los campos
        $this->strCorreoFuncionarios = $correo;
        $this->strNombresFuncionarios = $nombres;
        $this->strStatusFuncionarios = $status;
        $this->strIdentificacion = $identificacion;
        $this->strCargo = $cargo;
        $this->strDependencia = $dependencia;
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
        $this->strNivelEscolar = $nivelEscolar;
        $this->strCarrera = $carrera;
        $this->strEspecialidad = $especialidad;
        $this->strMaestria = $maestria;
        $this->strDoctorado = $doctorado;

        // Verificar si ya existe el correo
        $return = 0;
        $sql = "SELECT * FROM tbl_funcionarios WHERE correo_elc = '{$this->strCorreoFuncionarios}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_funcionarios(
                correo_elc, nombre_completo, status, nm_identificacion,
                cargo_fk, dependencia_fk, celular, direccion, fecha_ingreso,
                hijos, nombres_de_hijos, sexo, lugar_de_residencia,
                edad, estado_civil, religion, nivel_escolar, carrera, especialidad,
                maestria, doctorado
            ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
        
        
        $arrData = array(
            $this->strCorreoFuncionarios,
            $this->strNombresFuncionarios,
            $this->strStatusFuncionarios,
            $this->strIdentificacion,
            $this->strCargo,
            $this->strDependencia,
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
            $this->strNivelEscolar,
            $this->strCarrera,
            $this->strEspecialidad,
            $this->strMaestria,
            $this->strDoctorado
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
    $sql = "SELECT u.idefuncionario, u.correo_elc, u.nombre_completo, u.status, u.nm_identificacion, u.cargo_fk, u.dependencia_fk, u.celular, u.direccion, u.vacaciones ,u.fecha_ingreso, u.fecha_vacaciones, u.hijos, u.nombres_de_hijos, u.sexo, u.lugar_de_residencia, u.edad, u.estado_civil, u.religion, u.nivel_escolar, u.carrera, u.especialidad, u.maestria, u.doctorado
            FROM tbl_funcionarios u
            WHERE u.status != 0 " . $whereAdmin;
            $request = $this->select_all($sql);
            return $request;
}


    public function selectFuncionario(int $idefuncionarios)
    {
        $this->intIdeFuncionarios = $idefuncionarios;
        $sql = "SELECT u.idefuncionario, u.correo_elc, u.nombre_completo, u.status, u.nm_identificacion, u.cargo_fk, u.dependencia_fk, u.celular, u.direccion, u.fecha_ingreso,u.vacaciones, u.fecha_vacaciones, u.hijos, u.nombres_de_hijos, u.sexo, u.lugar_de_residencia, u.edad, u.estado_civil, u.religion, u.nivel_escolar, u.carrera, u.especialidad, u.maestria, u.doctorado
                FROM tbl_funcionarios u
                WHERE u.idefuncionario = $this->intIdeFuncionarios";
        $request = $this->select($sql);
        return $request;
    }

    public function updateFuncionario(
        int $idefuncionarios,
        string $correo,
        string $nombres,
        int $status,
        string $identificacion,
        string $cargo,
        string $dependencia,
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
        string $nivelEscolar,
        string $carrera,
        string $especialidad,
        string $maestria,
        string $doctorado
    ) {
        $this->intIdeFuncionarios = $idefuncionarios;
        $this->strCorreoFuncionarios = $correo;
        $this->strNombresFuncionarios = $nombres;
        $this->strStatusFuncionarios = $status;
        $this->strIdentificacion = $identificacion;
        $this->strCargo = $cargo;
        $this->strDependencia = $dependencia;
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
        $this->strNivelEscolar = $nivelEscolar;
        $this->strCarrera = $carrera;
        $this->strEspecialidad = $especialidad;
        $this->strMaestria = $maestria;
        $this->strDoctorado = $doctorado;

        $sql = "UPDATE tbl_funcionarios SET correo_elc=?, nombre_completo=?, status=?, nm_identificacion=?, cargo_fk=?, dependencia_fk=?, celular=?, direccion=?, fecha_ingreso=?, hijos=?, nombres_de_hijos=?, sexo=?, lugar_de_residencia=?, edad=?, estado_civil=?, religion=?, nivel_escolar=?, carrera=?, especialidad=?, maestria=?, doctorado=? WHERE idefuncionario = $this->intIdeFuncionarios";
        $arrData = array(
            $this->strCorreoFuncionarios,
            $this->strNombresFuncionarios,
            $this->strStatusFuncionarios,
            $this->strIdentificacion,
            $this->strCargo,
            $this->strDependencia,
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
            $this->strNivelEscolar,
            $this->strCarrera,
            $this->strEspecialidad,
            $this->strMaestria,
            $this->strDoctorado
        );

        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteFuncionario(int $intIdeFuncionarios)
    {
        $this->intIdeFuncionarios = $intIdeFuncionarios;
        $sql = "UPDATE tbl_funcionarios SET status = ? WHERE idefuncionario = $this->intIdeFuncionarios ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}