<?php
class FuncionariosPlantaModel extends Mysql
{
    private $intIdeFuncionario;
    private $strCorreoFuncionario;
    private $strNombresFuncionario;
    private $strStatusFuncionario;
    private $strIdentificacion;
    private $strCargo;
    private $strDependencia;
    private $strCelular;
    private $strDireccion;
    private $strFechaIngreso;
    private $intVacaciones;
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

    // Insertar usuario con los nuevos campos
    public function insertFuncionarios(
        string $correo,
        string $nombres,
        string $status,
        string $identificacion,
        string $cargo,
        string $dependencia,
        string $celular,
        string $direccion,
        string $fechaIngreso,
        int $vacaciones,
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
        $this->intVacaciones = $vacaciones;
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
        $sql = "SELECT * FROM tbl_funcionarios WHERE correo = '{$this->strCorreoFuncionarios}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            // Insertar en la tabla de funcionarios
            $query_insert = "INSERT INTO tbl_funcionarios(correo_elc, nombre_completo, status, nm_identificacion, cargo_fk, dependencia_fk, celular, direccion, fecha_ingreso, vacaciones,fecha_vacaciones, hijos, nombre_de_hijos, sexo, lugar_de_residencia, edad, estado_civil, religion, nivel_escolar, carrera, especialidad, maestria, doctorado)
                            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
                $this->intVacaciones,
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
    $sql = "SELECT u.idefuncionario, u.correo_elc, u.nombre_completo, u.status, u.nm_identificacion, u.cargo_fk, u.dependencia_fk, u.celular, u.direccion, u.fecha_ingreso, u.vacaciones, u.fecha_vacaciones, u.hijos, u.nombres_de_hijos, u.sexo, u.lugar_de_residencia, u.edad, u.estado_civil, u.religion, u.nivel_escolar, u.carrera, u.especialidad, u.maestria, u.doctorado
            FROM tbl_funcionarios u
            WHERE u.status != 0 " . $whereAdmin;
            $request = $this->select_all($sql);
            return $request;
}


    // Seleccionar un usuario específico (con nuevos campos)
    public function selectFuncionario(int $idefuncionario)
    {
        $this->intIdeFuncionario = $idefuncionario;
        $sql = "SELECT u.idefuncionario, u.correo_elc, u.nombre_completo, u.status, u.nm_identificacion, u.cargo_fk, u.dependencia_fk, u.celular, u.direccion, u.fecha_ingreso, u.vacaciones, u.fecha_vacaciones, u.hijos, u.nombres_de_hijos, u.sexo, u.lugar_de_residencia, u.edad, u.estado_civil, u.religion, u.nivel_escolar, u.carrera, u.especialidad, u.maestria, u.doctorado
                FROM tbl_funcionarios u
                WHERE u.idefuncionario = $this->intIdeFuncionario";
        $request = $this->select($sql);
        return $request;
    }

    // Actualizar un usuario (con nuevos campos)
    // public function updateUsuario(
    //     int $ideusuario,
    //     string $correo,
    //     string $nombres,
    //     string $status,
    //     string $identificacion,
    //     string $cargo,
    //     string $dependencia,
    //     string $celular,
    //     string $direccion,
    //     string $fechaIngreso,
    //     int $vacaciones,
    //     int $hijos,
    //     string $nombreHijos,
    //     string $sexo,
    //     string $lugarResidencia,
    //     int $edad,
    //     string $estadoCivil,
    //     string $religion,
    //     string $nivelEscolar,
    //     string $carrera,
    //     string $especialidad,
    //     string $maestria,
    //     string $doctorado
    // ) {
    //     $this->intIdeUsuario = $ideusuario;
    //     $this->strCorreoFuncionarios = $correo;
    //     $this->strNombresFuncionarios = $nombres;
    //     $this->strStatusFuncionarios = $status;
    //     $this->strIdentificacion = $identificacion;
    //     $this->strCargo = $cargo;
    //     $this->strDependencia = $dependencia;
    //     $this->strCelular = $celular;
    //     $this->strDireccion = $direccion;
    //     $this->strFechaIngreso = $fechaIngreso;
    //     $this->intVacaciones = $vacaciones;
    //     $this->intHijos = $hijos;
    //     $this->strNombreHijos = $nombreHijos;
    //     $this->strSexo = $sexo;
    //     $this->strLugarResidencia = $lugarResidencia;
    //     $this->intEdad = $edad;
    //     $this->strEstadoCivil = $estadoCivil;
    //     $this->strReligion = $religion;
    //     $this->strNivelEscolar = $nivelEscolar;
    //     $this->strCarrera = $carrera;
    //     $this->strEspecialidad = $especialidad;
    //     $this->strMaestria = $maestria;
    //     $this->strDoctorado = $doctorado;

    //     $sql = "UPDATE tbl_funcionarios SET correo=?, nombres=?, status=?, identificacion=?, cargo=?, dependencia=?, celular=?, direccion=?, fecha_ingreso=?, vacaciones=?, hijos=?, nombre_hijos=?, sexo=?, lugar_residencia=?, edad=?, estado_civil=?, religion=?, nivel_escolar=?, carrera=?, especialidad=?, maestria=?, doctorado=? WHERE ideusuario = $this->intIdeUsuario";
    //     $arrData = array(
    //         $this->strCorreoFuncionarios,
    //         $this->strNombresFuncionarios,
    //         $this->strStatusFuncionarios,
    //         $this->strIdentificacion,
    //         $this->strCargo,
    //         $this->strDependencia,
    //         $this->strCelular,
    //         $this->strDireccion,
    //         $this->strFechaIngreso,
    //         $this->intVacaciones,
    //         $this->intHijos,
    //         $this->strNombreHijos,
    //         $this->strSexo,
    //         $this->strLugarResidencia,
    //         $this->intEdad,
    //         $this->strEstadoCivil,
    //         $this->strReligion,
    //         $this->strNivelEscolar,
    //         $this->strCarrera,
    //         $this->strEspecialidad,
    //         $this->strMaestria,
    //         $this->strDoctorado
    //     );

    //     $request = $this->update($sql, $arrData);
    //     return $request;
    // }

    // Eliminar usuario (cambiar status)
    // public function deleteUsuario(int $intIdeUsuario)
    // {
    //     $this->intIdeUsuario = $intIdeUsuario;
    //     $sql = "UPDATE tbl_funcionarios SET status = ? WHERE ideusuario = $this->intIdeUsuario ";
    //     $arrData = array(0);
    //     $request = $this->update($sql, $arrData);
    //     return $request;
    // }
}
