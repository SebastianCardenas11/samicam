<?php
class ImportarFuncionariosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function importarFuncionarios($datos)
    {
        try {
            // Iniciar transacción
            if (!$this->beginTransaction()) {
                throw new Exception("No se pudo iniciar la transacción");
            }

            $insertados = 0;
            $errores = [];

            foreach ($datos as $index => $funcionario) {
                // Verificar si el funcionario ya existe
                $sql = "SELECT idefuncionario, correo_elc, nm_identificacion FROM tbl_funcionarios_planta WHERE nm_identificacion = ? OR correo_elc = ?";
                $arrParams = array($funcionario['nm_identificacion'], $funcionario['correo_elc']);
                $request = $this->select($sql, $arrParams);

                if (!empty($request)) {
                    if ($request['nm_identificacion'] == $funcionario['nm_identificacion']) {
                        $errores[] = "Fila " . ($index + 2) . ": Ya existe un funcionario con la identificación " . $funcionario['nm_identificacion'];
                    }
                    if ($request['correo_elc'] == $funcionario['correo_elc']) {
                        $errores[] = "Fila " . ($index + 2) . ": Ya existe un funcionario con el correo " . $funcionario['correo_elc'];
                    }
                    continue;
                }

                // Verificar que existan los IDs de referencia
                $sqlCargo = "SELECT idecargos FROM tbl_cargos WHERE idecargos = ?";
                $sqlDependencia = "SELECT dependencia_pk FROM tbl_dependencia WHERE dependencia_pk = ?";
                $sqlContrato = "SELECT id_contrato FROM tbl_contrato WHERE id_contrato = ?";

                if (!$this->select($sqlCargo, [$funcionario['cargo_fk']])) {
                    $errores[] = "Fila " . ($index + 2) . ": El cargo con ID " . $funcionario['cargo_fk'] . " no existe";
                    continue;
                }

                if (!$this->select($sqlDependencia, [$funcionario['dependencia_fk']])) {
                    $errores[] = "Fila " . ($index + 2) . ": La dependencia con ID " . $funcionario['dependencia_fk'] . " no existe";
                    continue;
                }

                if (!$this->select($sqlContrato, [$funcionario['contrato_fk']])) {
                    $errores[] = "Fila " . ($index + 2) . ": El contrato con ID " . $funcionario['contrato_fk'] . " no existe";
                    continue;
                }

                // Insertar el funcionario
                $sql = "INSERT INTO tbl_funcionarios_planta(
                    correo_elc, 
                    nombre_completo, 
                    nm_identificacion,
                    cargo_fk,
                    dependencia_fk,
                    contrato_fk,
                    celular,
                    direccion,
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
                    periodos_vacaciones,
                    imagen
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'sinimagen.png')";

                $arrData = array(
                    $funcionario['correo_elc'],
                    $funcionario['nombre_completo'],
                    $funcionario['nm_identificacion'],
                    $funcionario['cargo_fk'],
                    $funcionario['dependencia_fk'],
                    $funcionario['contrato_fk'],
                    $funcionario['celular'],
                    $funcionario['direccion'],
                    $funcionario['fecha_ingreso'],
                    $funcionario['hijos'],
                    $funcionario['nombres_de_hijos'],
                    $funcionario['sexo'],
                    $funcionario['lugar_de_residencia'],
                    $funcionario['edad'],
                    $funcionario['estado_civil'],
                    $funcionario['religion'],
                    $funcionario['formacion_academica'],
                    $funcionario['nombre_formacion'],
                    $funcionario['status']
                );

                $result = $this->insert($sql, $arrData);
                if ($result) {
                    $insertados++;
                } else {
                    $errores[] = "Fila " . ($index + 2) . ": Error al insertar el funcionario";
                }
            }

            if (!empty($errores)) {
                $this->rollback();
                throw new Exception(implode("\n", $errores));
            }

            if ($insertados === 0) {
                $this->rollback();
                throw new Exception("No se pudo importar ningún funcionario");
            }

            $this->commit();
            return ["status" => true, "msg" => "Se importaron {$insertados} funcionarios correctamente"];

        } catch (Exception $e) {
            if ($this->conexion && $this->conexion->inTransaction()) {
                $this->rollback();
            }
            error_log("Error en importarFuncionarios: " . $e->getMessage());
            return ["status" => false, "msg" => $e->getMessage()];
        }
    }
} 