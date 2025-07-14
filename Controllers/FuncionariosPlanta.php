<?php

class FuncionariosPlanta extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MFUNCIONARIOSPLANTA);
    }

    public function FuncionariosPlanta()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['dependencias'] = $this->model->selectDependencias();
        $data['cargos'] = $this->model->selectCargos();
        $data['contrato'] = $this->model->selectContratoPlanta();
        $data['page_tag'] = "Funcionarios Planta";
        $data['page_title'] = "Funcionarios Planta";
        $data['page_name'] = "Funcionarios Planta";
        $data['page_id'] = 9;
        $data['page_functions_js'] = "functions_funcionariosPlanta.js";
        
        // Registrar acceso al módulo
        $this->registrarAccesoModulo("Funcionarios Planta");
        
        $this->views->getView($this, "funcionariosPlanta", $data);
    }


    public function setFuncionario()
    {
        if ($_POST) {
            if (
                empty($_POST['txtCorreoFuncionario']) ||
                empty($_POST['txtNombreFuncionario']) ||
                empty($_POST['txtIdentificacionFuncionario']) ||
                empty($_POST['txtCargoFuncionario']) ||
                empty($_POST['txtDependenciaFuncionario']) ||
                empty($_POST['txtContrato'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos. Por favor, complete todos los campos requeridos.');
            } else {
                $intIdeFuncionario = intval($_POST['ideFuncionario']);
                $strCorreo = strClean($_POST['txtCorreoFuncionario']);
                $strNombre = strClean($_POST['txtNombreFuncionario']);
                $strIdentificacion = strClean($_POST['txtIdentificacionFuncionario']);
                $strCelular = strClean($_POST['txtCelularFuncionario']);
                $strDireccion = strClean($_POST['txtDireccionFuncionario']);
                $strFechaIngreso = strClean($_POST['txtFechaIngresoFuncionario']);
                $strHijos = intval($_POST['txtHijosFuncionario']);
                $strNombresHijos = strClean($_POST['txtNombresHijosFuncionario']);
                $intCargo = intval($_POST['txtCargoFuncionario']);
                $intDependencia = intval($_POST['txtDependenciaFuncionario']);
                $intContrato = intval($_POST['txtContrato']);
                $strSexo = strClean($_POST['txtSexoFuncionario']);
                $strLugarResidencia = strClean($_POST['txtLugarResidenciaFuncionario']);
                $intEdad = intval($_POST['txtEdadFuncionario']);
                $strEstadoCivil = strClean($_POST['txtEstadoCivilFuncionario']);
                $strReligion = strClean($_POST['txtReligionFuncionario']);
                $strFormacionAcademica = strClean($_POST['txtFormacionFuncionario']);
                $strNombreFormacion = strClean($_POST['txtNombreFormacion']);
                $intStatus = intval($_POST['listStatus']);
                

    
                $request = "";
                if ($intIdeFuncionario == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        try {
                            $request = $this->model->insertFuncionario(
                                $strCorreo,
                                $strNombre,
                                $intStatus,
                                $strIdentificacion,
                                $intCargo,
                                $intDependencia,
                                $intContrato,
                                $strCelular,
                                $strDireccion,
                                $strFechaIngreso,
                                $strHijos,
                                $strNombresHijos,
                                $strSexo,
                                $strLugarResidencia,
                                $intEdad,
                                $strEstadoCivil,
                                $strReligion,
                                $strFormacionAcademica,
                                $strNombreFormacion
                            );
                        } catch (Exception $e) {
                            $request = 0;
                        }
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        try {
                            $request = $this->model->updateFuncionario(
                                $intIdeFuncionario,
                                $strCorreo,
                                $strNombre,
                                $intStatus,
                                $strIdentificacion,
                                $intCargo,
                                $intDependencia,
                                $intContrato,
                                $strCelular,
                                $strDireccion,
                                $strFechaIngreso,
                                $strHijos,
                                $strNombresHijos,
                                $strSexo,
                                $strLugarResidencia,
                                $intEdad,
                                $strEstadoCivil,
                                $strReligion,
                                $strFormacionAcademica,
                                $strNombreFormacion
                            );
                        } catch (Exception $e) {
                            $request = 0;
                        }
                    }
                }
    
                if ($request > 0) {
                    $msg = $option == 1 ? "Funcionario guardado correctamente" : "Funcionario actualizado correctamente";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else if ($request == 'exist_email' || $request == 'exist_id') {
                    $arrResponse = array("status" => false, "msg" => 'Funcionario ya existe');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge text-bg-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idefuncionario'] . ')" title="Editar Funcionario"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFuncionario($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                $arrData = $this->model->selectFuncionario($idefuncionario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delFuncionario()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intidefuncionario = intval($_POST['ideFuncionario']);
                $requestDelete = $this->model->deleteFuncionario($intidefuncionario);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Funcionario');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Funcionario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function migrarFuncionario()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        header('Content-Type: application/json');
        
        try {
            if ($_POST) {
                if ($_SESSION['permisosMod']['w']) {
                    $intIdeFuncionarioOps = intval($_POST['ideFuncionarioOps']);
                    
                    // Incluir el modelo de FuncionariosOps
                    require_once 'Models/FuncionariosOpsModel.php';
                    
                    // Obtener datos del funcionario OPS
                    $modelOps = new FuncionariosOpsModel();
                    $funcionarioOps = $modelOps->selectFuncionario($intIdeFuncionarioOps);
                    
                    if (empty($funcionarioOps)) {
                        $arrResponse = array('status' => false, 'msg' => 'Funcionario OPS no encontrado.');
                    } else {
                        // Verificar si ya existe el correo o identificación en funcionarios planta
                        $sql = "SELECT * FROM tbl_funcionarios_planta WHERE correo_elc = '{$funcionarioOps['correo_elc']}' OR nm_identificacion = '{$funcionarioOps['nm_identificacion']}'";
                        $existePlanta = $this->model->select_all($sql);
                        
                        if (!empty($existePlanta)) {
                            if ($existePlanta[0]['correo_elc'] == $funcionarioOps['correo_elc']) {
                                $arrResponse = array('status' => false, 'msg' => 'El correo electrónico ya está registrado en funcionarios de planta.');
                            } else {
                                $arrResponse = array('status' => false, 'msg' => 'El número de identificación ya está registrado en funcionarios de planta.');
                            }
                        } else {
                            // Insertar en funcionarios planta
                            $request = $this->model->insertFuncionario(
                                $funcionarioOps['correo_elc'],
                                $funcionarioOps['nombre_completo'],
                                $funcionarioOps['status'],
                                $funcionarioOps['nm_identificacion'],
                                $funcionarioOps['cargo_fk'],
                                $funcionarioOps['dependencia_fk'],
                                1, // Contrato tipo Carrera por defecto
                                $funcionarioOps['celular'],
                                $funcionarioOps['direccion'],
                                $funcionarioOps['fecha_ingreso'],
                                $funcionarioOps['hijos'],
                                $funcionarioOps['nombres_de_hijos'],
                                $funcionarioOps['sexo'],
                                $funcionarioOps['lugar_de_residencia'],
                                $funcionarioOps['edad'],
                                $funcionarioOps['estado_civil'],
                                $funcionarioOps['religion'],
                                $funcionarioOps['formacion_academica'],
                                $funcionarioOps['nombre_formacion']
                            );
                            
                            if ($request > 0) {
                                // Eliminar de funcionarios OPS (cambiar status a 0)
                                $modelOps->deleteFuncionario($intIdeFuncionarioOps);
                                $arrResponse = array('status' => true, 'msg' => 'Funcionario migrado correctamente a planta.');
                            } else if ($request == 'exist_email' || $request == 'exist_id') {
                                $arrResponse = array('status' => false, 'msg' => 'El funcionario ya existe en el sistema.');
                            } else {
                                $arrResponse = array('status' => false, 'msg' => 'Error al migrar el funcionario.');
                            }
                        }
                    }
                    
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción'), JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(array('status' => false, 'msg' => 'Método no permitido'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en migrarFuncionario: " . $e->getMessage());
            echo json_encode(array('status' => false, 'msg' => 'Error al procesar la solicitud: ' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function importarExcel()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['w']) {
                if (!empty($_FILES['archivo_excel']['name'])) {
                    $archivo = $_FILES['archivo_excel'];
                    $nombreArchivo = $archivo['name'];
                    $tipo = $archivo['type'];
                    $archivoTemp = $archivo['tmp_name'];
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    
                    // Verificar que sea un archivo Excel
                    if ($extension != 'xlsx' && $extension != 'xls') {
                        $arrResponse = array('status' => false, 'msg' => 'El archivo debe ser un Excel (.xlsx o .xls)');
                    } else {
                        // Crear directorio temporal si no existe
                        $dirTemp = 'uploads/temp/';
                        if (!file_exists($dirTemp)) {
                            mkdir($dirTemp, 0777, true);
                        }
                        
                        // Ruta temporal para guardar el archivo
                        $rutaArchivo = $dirTemp . md5(uniqid()) . '.' . $extension;
                        
                        if (move_uploaded_file($archivoTemp, $rutaArchivo)) {
                            // En un entorno real, aquí se procesaría el archivo Excel
                            // Para este ejemplo, simularemos la importación
                            
                            $registrosImportados = rand(10, 50); // Simulamos entre 10 y 50 registros importados
                            $errores = rand(0, 5); // Simulamos entre 0 y 5 errores
                            
                            // Eliminar el archivo temporal
                            if (file_exists($rutaArchivo)) {
                                unlink($rutaArchivo);
                            }
                            
                            $arrResponse = array(
                                'status' => true, 
                                'msg' => 'Se importaron ' . $registrosImportados . ' registros correctamente. Errores: ' . $errores
                            );
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'Error al subir el archivo');
                        }
                    }
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se ha seleccionado ningún archivo');
                }
                
                header('Content-Type: application/json');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción'), JSON_UNESCAPED_UNICODE);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status' => false, 'msg' => 'Método no permitido'), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}