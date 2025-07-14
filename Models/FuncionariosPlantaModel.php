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
        string $nombreformacion,
        string $lugarExpedicion = '',
        string $libretaMilitar = '',
        string $tipoNombramiento = '',
        string $nivel = '',
        float $salarioBasico = 0,
        string $actoAdministrativo = '',
        string $fechaActoNombramiento = '',
        string $noActaPosesion = '',
        string $fechaActaPosesion = '',
        string $tiempoLaborado = '',
        string $codigo = '',
        string $grado = '',
        string $fechaNacimiento = '',
        string $lugarNacimiento = '',
        string $rh = '',
        string $titulo = '',
        string $tarjetaProfesional = '',
        string $otrosEstudios = '',
        string $cuentaNo = '',
        string $banco = '',
        string $eps = '',
        string $afp = '',
        string $afc = '',
        string $arl = '',
        string $sindicalizado = '',
        string $madreCabezaHogar = '',
        string $prepensionado = ''
    ) {
        try {
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

            $sql = "SELECT * FROM tbl_funcionarios_planta WHERE correo_elc = '$correo'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $sql = "SELECT * FROM tbl_funcionarios_planta WHERE nm_identificacion = '$identificacion'";
                $request = $this->select_all($sql);

                if (empty($request)) {
                    $query_insert = "INSERT INTO tbl_funcionarios_planta(
                        nombre_completo,
                        nm_identificacion,
                        cargo_fk,
                        dependencia_fk,
                        contrato_fk,
                        celular,
                        direccion,
                        correo_elc,
                        fecha_ingreso,
                        hijos,
                        nombres_de_hijos,
                        sexo,
                        lugar_de_residencia,
                        edad,
                        estado_civil,
                        religion,
                        formacion_academica,
                        nombre_formacion,
                        status,
                        lugar_expedicion,
                        libreta_militar,
                        tipo_nombramiento,
                        nivel,
                        salario_basico,
                        acto_administrativo,
                        fecha_acto_nombramiento,
                        no_acta_posesion,
                        fecha_acta_posesion,
                        tiempo_laborado,
                        codigo,
                        grado,
                        fecha_nacimiento,
                        lugar_nacimiento,
                        rh,
                        titulo,
                        tarjeta_profesional,
                        otros_estudios,
                        cuenta_no,
                        banco,
                        eps,
                        afp,
                        afc,
                        arl,
                        sindicalizado,
                        madre_cabeza_hogar,
                        prepensionado,
                        edades_hijos
                    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

                    $arrData = array(
                        $nombres,
                        $identificacion,
                        $cargo,
                        $dependencia,
                        $contrato,
                        $celular,
                        $direccion,
                        $correo,
                        $fechaIngreso,
                        $hijos,
                        $nombreHijos,
                        $sexo,
                        $lugarResidencia,
                        $edad,
                        $estadoCivil,
                        $religion,
                        $formacion,
                        $nombreformacion,
                        $status,
                        $lugarExpedicion,
                        $libretaMilitar,
                        $tipoNombramiento,
                        $nivel,
                        $salarioBasico,
                        $actoAdministrativo,
                        $fechaActoNombramiento,
                        $noActaPosesion,
                        $fechaActaPosesion,
                        $tiempoLaborado,
                        $codigo,
                        $grado,
                        $fechaNacimiento,
                        $lugarNacimiento,
                        $rh,
                        $titulo,
                        $tarjetaProfesional,
                        $otrosEstudios,
                        $cuentaNo,
                        $banco,
                        $eps,
                        $afp,
                        $afc,
                        $arl,
                        $sindicalizado,
                        $madreCabezaHogar,
                        $prepensionado,
                        $edadesHijos
                    );

                    $request_insert = $this->insert($query_insert, $arrData);
                    $return = $request_insert;
                } else {
                    $return = "exist_id";
                }
            } else {
                $return = "exist_email";
            }
            return $return;
        } catch (Exception $e) {
            error_log("Error en insertFuncionario: " . $e->getMessage());
            return 0;
        }
    }

    public function selectFuncionarios()
    {
        $sql = "SELECT DISTINCT
                u.idefuncionario,
                u.nombre_completo,
                u.nm_identificacion,
                u.celular,
                u.direccion,
                u.correo_elc,
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
                u.status,
                u.tiempo_laborado,
                c.nombre as cargo,
                d.nombre as dependencia,
                t.tipo_cont as contrato,
                u.cargo_fk,
                u.dependencia_fk,
                u.contrato_fk
            FROM tbl_funcionarios_planta u
            INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
            INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contrato t ON u.contrato_fk = t.id_contrato
            WHERE u.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFuncionario(int $idefuncionarios)
    {
        $this->intIdeFuncionarios = $idefuncionarios;

        $sql = "SELECT 
                u.*,
                c.nombre AS cargo_nombre,
                d.nombre AS dependencia_nombre,
                ct.tipo_cont AS contrato_nombre
            FROM tbl_funcionarios_planta u
            INNER JOIN tbl_cargos c ON u.cargo_fk = c.idecargos
            INNER JOIN tbl_dependencia d ON u.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contrato ct ON u.contrato_fk = ct.id_contrato
            WHERE u.idefuncionario = $this->intIdeFuncionarios";

        $request = $this->select($sql);
        return $request;
    }

    public function updateFuncionario(
        int $idFuncionario,
        string $correo,
        string $nombres,
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
        string $nombreformacion,
        string $lugarExpedicion = '',
        string $libretaMilitar = '',
        string $tipoNombramiento = '',
        string $nivel = '',
        float $salarioBasico = 0,
        string $actoAdministrativo = '',
        string $fechaActoNombramiento = '',
        string $noActaPosesion = '',
        string $fechaActaPosesion = '',
        string $tiempoLaborado = '',
        string $codigo = '',
        string $grado = '',
        string $fechaNacimiento = '',
        string $lugarNacimiento = '',
        string $rh = '',
        string $titulo = '',
        string $tarjetaProfesional = '',
        string $otrosEstudios = '',
        string $cuentaNo = '',
        string $banco = '',
        string $eps = '',
        string $afp = '',
        string $afc = '',
        string $arl = '',
        string $sindicalizado = '',
        string $madreCabezaHogar = '',
        string $prepensionado = '',
        string $edadesHijos = ''
    ) {
        try {
            $sql = "SELECT * FROM tbl_funcionarios_planta 
                    WHERE (correo_elc = '$correo' AND idefuncionario != $idFuncionario)";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $sql = "SELECT * FROM tbl_funcionarios_planta 
                        WHERE nm_identificacion = '$identificacion' AND idefuncionario != $idFuncionario";
                $request = $this->select_all($sql);

                if (empty($request)) {
                    $sql = "UPDATE tbl_funcionarios_planta 
                            SET nombre_completo = ?,
                                nm_identificacion = ?,
                                cargo_fk = ?,
                                dependencia_fk = ?,
                                contrato_fk = ?,
                                celular = ?,
                                direccion = ?,
                                correo_elc = ?,
                                fecha_ingreso = ?,
                                hijos = ?,
                                nombres_de_hijos = ?,
                                sexo = ?,
                                lugar_de_residencia = ?,
                                edad = ?,
                                estado_civil = ?,
                                religion = ?,
                                formacion_academica = ?,
                                nombre_formacion = ?,
                                status = ?,
                                lugar_expedicion = ?,
                                libreta_militar = ?,
                                tipo_nombramiento = ?,
                                nivel = ?,
                                salario_basico = ?,
                                acto_administrativo = ?,
                                fecha_acto_nombramiento = ?,
                                no_acta_posesion = ?,
                                fecha_acta_posesion = ?,
                                tiempo_laborado = ?,
                                codigo = ?,
                                grado = ?,
                                fecha_nacimiento = ?,
                                lugar_nacimiento = ?,
                                rh = ?,
                                titulo = ?,
                                tarjeta_profesional = ?,
                                otros_estudios = ?,
                                cuenta_no = ?,
                                banco = ?,
                                eps = ?,
                                afp = ?,
                                afc = ?,
                                arl = ?,
                                sindicalizado = ?,
                                madre_cabeza_hogar = ?,
                                prepensionado = ?,
                                edades_hijos = ?
                            WHERE idefuncionario = $idFuncionario";

                    $arrData = array(
                        $nombres,
                        $identificacion,
                        $cargo,
                        $dependencia,
                        $contrato,
                        $celular,
                        $direccion,
                        $correo,
                        $fechaIngreso,
                        $hijos,
                        $nombreHijos,
                        $sexo,
                        $lugarResidencia,
                        $edad,
                        $estadoCivil,
                        $religion,
                        $formacion,
                        $nombreformacion,
                        $status,
                        $lugarExpedicion,
                        $libretaMilitar,
                        $tipoNombramiento,
                        $nivel,
                        $salarioBasico,
                        $actoAdministrativo,
                        $fechaActoNombramiento,
                        $noActaPosesion,
                        $fechaActaPosesion,
                        $tiempoLaborado,
                        $codigo,
                        $grado,
                        $fechaNacimiento,
                        $lugarNacimiento,
                        $rh,
                        $titulo,
                        $tarjetaProfesional,
                        $otrosEstudios,
                        $cuentaNo,
                        $banco,
                        $eps,
                        $afp,
                        $afc,
                        $arl,
                        $sindicalizado,
                        $madreCabezaHogar,
                        $prepensionado,
                        $edadesHijos
                    );

                    $request = $this->update($sql, $arrData);
                    $return = $request;
                } else {
                    $return = "exist_id";
                }
            } else {
                $return = "exist_email";
            }
            return $return;
        } catch (Exception $e) {
            error_log("Error en updateFuncionario: " . $e->getMessage());
            return 0;
        }
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
    $sql = "SELECT id_contrato, tipo_cont FROM tbl_contrato";
    $request = $this->select_all($sql);
    return $request;
}

}