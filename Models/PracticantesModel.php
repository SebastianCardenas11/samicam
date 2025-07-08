<?php
class PracticantesModel extends Mysql
{
    private $intIdePracticante;
    private $strCorreoPracticante;
    private $strNombresPracticante;
    private $strStatusPracticante;
    private $strIdentificacion;
    private $strArl;
    private $strEps;
    private $intEdad;
    private $strSexo;
    private $strTelefono;
    private $strDireccion;
    private $intDependencia;
    private $strCargoHacer;
    private $strFechaIngreso;
    private $strFechaSalida;
    private $intContratoPracticante;
    private $strFormacionAcademica;
    private $strProgramaEstudio;
    private $strInstitucionEducativa;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertPracticante(
        string $correo,
        string $nombres,
        int $status,
        string $identificacion,
        string $arl,
        string $eps,
        int $edad,
        string $sexo,
        string $telefono,
        string $direccion,
        int $dependencia,
        string $cargoHacer,
        string $fechaIngreso,
        string $fechaSalida,
        int $contratoPracticante,
        string $formacionAcademica,
        string $programaEstudio,
        string $institucionEducativa
    ) {
        try {
            // Verificar que las claves foráneas existan
            $sqlDependencia = "SELECT dependencia_pk FROM tbl_dependencia WHERE dependencia_pk = $dependencia";
            $requestDependencia = $this->select($sqlDependencia);
            if(empty($requestDependencia)) {
                return 0;
            }

            $sqlContrato = "SELECT id_contrato_practicante FROM tbl_contratos_practicantes WHERE id_contrato_practicante = $contratoPracticante";
            $requestContrato = $this->select($sqlContrato);
            if(empty($requestContrato)) {
                return 0;
            }

            $sql = "SELECT * FROM tbl_practicantes WHERE correo_electronico = '$correo'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $sql = "SELECT * FROM tbl_practicantes WHERE numero_identificacion = '$identificacion'";
                $request = $this->select_all($sql);

                if (empty($request)) {
                    $query_insert = "INSERT INTO tbl_practicantes(
                        nombre_completo,
                        numero_identificacion,
                        arl,
                        eps,
                        edad,
                        sexo,
                        correo_electronico,
                        telefono,
                        direccion,
                        dependencia_fk,
                        cargo_hacer,
                        fecha_ingreso,
                        fecha_salida,
                        contrato_practicante_fk,
                        formacion_academica,
                        programa_estudio,
                        institucion_educativa,
                        status
                    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

                    $arrData = array(
                        $nombres,
                        $identificacion,
                        $arl,
                        $eps,
                        $edad,
                        $sexo,
                        $correo,
                        $telefono,
                        $direccion,
                        $dependencia,
                        $cargoHacer,
                        $fechaIngreso,
                        $fechaSalida,
                        $contratoPracticante,
                        $formacionAcademica,
                        $programaEstudio,
                        $institucionEducativa,
                        $status
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
            return 0;
        }
    }

    public function selectPracticantes()
    {
        $sql = "SELECT DISTINCT
                p.idepracticante,
                p.nombre_completo,
                p.numero_identificacion,
                p.arl,
                p.eps,
                p.edad,
                p.sexo,
                p.correo_electronico,
                p.telefono,
                p.direccion,
                p.cargo_hacer,
                p.fecha_ingreso,
                p.fecha_salida,
                cp.nombre_contrato as tipo_contrato,
                p.status,
                d.nombre as dependencia,
                p.dependencia_fk,
                p.contrato_practicante_fk,
                p.formacion_academica,
                p.programa_estudio,
                p.institucion_educativa
            FROM tbl_practicantes p
            INNER JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contratos_practicantes cp ON p.contrato_practicante_fk = cp.id_contrato_practicante
            WHERE p.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPracticante(int $idepracticante)
    {
        $this->intIdePracticante = $idepracticante;

        $sql = "SELECT 
                p.idepracticante,
                p.correo_electronico,
                p.nombre_completo,
                p.status,
                p.numero_identificacion,
                p.arl,
                p.eps,
                p.edad,
                p.sexo,
                p.telefono,
                p.direccion,
                p.dependencia_fk,
                d.nombre AS dependencia_nombre,
                p.cargo_hacer,
                p.fecha_ingreso,
                p.fecha_salida,
                cp.nombre_contrato as tipo_contrato,
                p.contrato_practicante_fk,
                p.formacion_academica,
                p.programa_estudio,
                p.institucion_educativa
            FROM tbl_practicantes p
            INNER JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk
            INNER JOIN tbl_contratos_practicantes cp ON p.contrato_practicante_fk = cp.id_contrato_practicante
            WHERE p.idepracticante = $this->intIdePracticante";
        $request = $this->select($sql);
        return $request;
    }

    public function updatePracticante(
        int $idPracticante,
        string $correo,
        string $nombres,
        int $status,
        string $identificacion,
        string $arl,
        string $eps,
        int $edad,
        string $sexo,
        string $telefono,
        string $direccion,
        int $dependencia,
        string $cargoHacer,
        string $fechaIngreso,
        string $fechaSalida,
        int $contratoPracticante,
        string $formacionAcademica,
        string $programaEstudio,
        string $institucionEducativa
    ) {
        try {
            $this->intIdePracticante = $idPracticante;
            $this->strCorreoPracticante = $correo;
            $this->strNombresPracticante = $nombres;
            $this->strStatusPracticante = $status;
            $this->strIdentificacion = $identificacion;
            $this->strArl = $arl;
            $this->strEps = $eps;
            $this->intEdad = $edad;
            $this->strSexo = $sexo;
            $this->strTelefono = $telefono;
            $this->strDireccion = $direccion;
            $this->intDependencia = $dependencia;
            $this->strCargoHacer = $cargoHacer;
            $this->strFechaIngreso = $fechaIngreso;
            $this->strFechaSalida = $fechaSalida;
            $this->intContratoPracticante = $contratoPracticante;
            $this->strFormacionAcademica = $formacionAcademica;
            $this->strProgramaEstudio = $programaEstudio;
            $this->strInstitucionEducativa = $institucionEducativa;

            $sql = "SELECT * FROM tbl_practicantes WHERE correo_electronico = '$this->strCorreoPracticante' AND idepracticante != $this->intIdePracticante";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $sql = "SELECT * FROM tbl_practicantes WHERE numero_identificacion = '$this->strIdentificacion' AND idepracticante != $this->intIdePracticante";
                $request = $this->select_all($sql);

                if (empty($request)) {
                    $sql = "UPDATE tbl_practicantes SET 
                            nombre_completo = ?,
                            numero_identificacion = ?,
                            arl = ?,
                            eps = ?,
                            edad = ?,
                            sexo = ?,
                            correo_electronico = ?,
                            telefono = ?,
                            direccion = ?,
                            dependencia_fk = ?,
                            cargo_hacer = ?,
                            fecha_ingreso = ?,
                            fecha_salida = ?,
                            contrato_practicante_fk = ?,
                            formacion_academica = ?,
                            programa_estudio = ?,
                            institucion_educativa = ?,
                            status = ?
                            WHERE idepracticante = $this->intIdePracticante";

                    $arrData = array(
                        $this->strNombresPracticante,
                        $this->strIdentificacion,
                        $this->strArl,
                        $this->strEps,
                        $this->intEdad,
                        $this->strSexo,
                        $this->strCorreoPracticante,
                        $this->strTelefono,
                        $this->strDireccion,
                        $this->intDependencia,
                        $this->strCargoHacer,
                        $this->strFechaIngreso,
                        $this->strFechaSalida,
                        $this->intContratoPracticante,
                        $this->strFormacionAcademica,
                        $this->strProgramaEstudio,
                        $this->strInstitucionEducativa,
                        $this->strStatusPracticante
                    );

                    $request = $this->update($sql, $arrData);
                } else {
                    $request = "exist_id";
                }
            } else {
                $request = "exist_email";
            }
            return $request;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function deletePracticante(int $intIdePracticante)
    {
        $this->intIdePracticante = $intIdePracticante;
        $sql = "UPDATE tbl_practicantes SET status = ? WHERE idepracticante = $this->intIdePracticante";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }

    public function selectDependencias(){
        $sql = "SELECT dependencia_pk, nombre FROM tbl_dependencia ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectContratosPracticantes() {
        $sql = "SELECT id_contrato_practicante, nombre_contrato FROM tbl_contratos_practicantes WHERE status != 0 ORDER BY nombre_contrato ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function registrarAccesoModulo($idUsuario, $modulo)
    {
        $sql = "INSERT INTO tbl_auditoria (usuario_id, accion, modulo, fecha) VALUES (?, 'Acceso', ?, NOW())";
        $arrData = array($idUsuario, $modulo);
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    public function cantPracticantes() {
        $sql = "SELECT COUNT(*) as total FROM tbl_practicantes WHERE status != 0";
        $request = $this->select($sql);
        return isset($request['total']) ? (int)$request['total'] : 0;
    }
} 