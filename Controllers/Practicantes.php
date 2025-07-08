<?php

class Practicantes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(MPRACTICANTES);
    }

    public function Practicantes()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['dependencias'] = $this->model->selectDependencias();
        $data['contratos'] = $this->model->selectContratosPracticantes();
        $data['page_tag'] = "Practicantes";
        $data['page_title'] = "Practicantes";
        $data['page_name'] = "Practicantes";
        $data['page_id'] = 10;
        $data['page_functions_js'] = "functions_practicantes.js";
        
        // Registrar acceso al módulo
        $this->registrarAccesoModulo("Practicantes");
        
        $this->views->getView($this, "practicantes", $data);
    }

    public function setPracticante()
    {
        if ($_POST) {
            if (
                empty($_POST['txtCorreoPracticante']) ||
                empty($_POST['txtNombrePracticante']) ||
                empty($_POST['txtIdentificacionPracticante']) ||
                empty($_POST['txtDependenciaPracticante']) ||
                empty($_POST['txtContratoPracticante']) ||
                empty($_POST['txtFechaIngreso']) ||
                empty($_POST['txtFechaSalida']) ||
                empty($_POST['txtFormacionAcademica']) ||
                empty($_POST['txtProgramaEstudio']) ||
                empty($_POST['txtInstitucionEducativa'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos. Por favor, complete todos los campos requeridos.');
            } else {
                $intIdePracticante = intval($_POST['idePracticante']);
                $strCorreo = strClean($_POST['txtCorreoPracticante']);
                $strNombre = strClean($_POST['txtNombrePracticante']);
                $strIdentificacion = strClean($_POST['txtIdentificacionPracticante']);
                $strArl = strClean($_POST['txtArlPracticante']);
                $strEps = strClean($_POST['txtEpsPracticante']);
                $intEdad = intval($_POST['txtEdadPracticante']);
                $strSexo = strClean($_POST['txtSexoPracticante']);
                $strTelefono = strClean($_POST['txtTelefonoPracticante']);
                $strDireccion = strClean($_POST['txtDireccionPracticante']);
                $intDependencia = intval($_POST['txtDependenciaPracticante']);
                $strCargoHacer = strClean($_POST['txtCargoHacerPracticante']);
                $strFechaIngreso = strClean($_POST['txtFechaIngreso']);
                $strFechaSalida = strClean($_POST['txtFechaSalida']);
                $intContratoPracticante = intval($_POST['txtContratoPracticante']);
                $strFormacionAcademica = strClean($_POST['txtFormacionAcademica']);
                $strProgramaEstudio = strClean($_POST['txtProgramaEstudio']);
                $strInstitucionEducativa = strClean($_POST['txtInstitucionEducativa']);
                $intStatus = intval($_POST['listStatus']);

                $request = "";
                if ($intIdePracticante == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        try {
                            $request = $this->model->insertPracticante(
                                $strCorreo,
                                $strNombre,
                                $intStatus,
                                $strIdentificacion,
                                $strArl,
                                $strEps,
                                $intEdad,
                                $strSexo,
                                $strTelefono,
                                $strDireccion,
                                $intDependencia,
                                $strCargoHacer,
                                $strFechaIngreso,
                                $strFechaSalida,
                                $intContratoPracticante,
                                $strFormacionAcademica,
                                $strProgramaEstudio,
                                $strInstitucionEducativa
                            );
                        } catch (Exception $e) {
                            $request = 0;
                        }
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        try {
                            $request = $this->model->updatePracticante(
                                $intIdePracticante,
                                $strCorreo,
                                $strNombre,
                                $intStatus,
                                $strIdentificacion,
                                $strArl,
                                $strEps,
                                $intEdad,
                                $strSexo,
                                $strTelefono,
                                $strDireccion,
                                $intDependencia,
                                $strCargoHacer,
                                $strFechaIngreso,
                                $strFechaSalida,
                                $intContratoPracticante,
                                $strFormacionAcademica,
                                $strProgramaEstudio,
                                $strInstitucionEducativa
                            );
                        } catch (Exception $e) {
                            $request = 0;
                        }
                    }
                }

                if ($request > 0) {
                    $msg = $option == 1 ? "Practicante guardado correctamente" : "Practicante actualizado correctamente";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else if ($request == 'exist_email') {
                    $arrResponse = array("status" => false, "msg" => '¡Atención! El correo electrónico ya está registrado en el sistema.');
                } else if ($request == 'exist_id') {
                    $arrResponse = array("status" => false, "msg" => '¡Atención! El número de identificación ya está registrado en el sistema.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'Practicante ya existe.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPracticantes()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPracticantes();
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
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idepracticante'] . ')" title="Ver Practicante"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idepracticante'] . ')" title="Editar Practicante"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $arrData[$i]['idepracticante'] . ')" title="Eliminar Practicante"><i class="far fa-trash-alt"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPracticante($idepracticante)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idepracticante = intval($idepracticante);
            if ($idepracticante > 0) {
                $arrData = $this->model->selectPracticante($idepracticante);
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

    public function delPracticante()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdePracticante = intval($_POST['idePracticante']);
                $requestDelete = $this->model->deletePracticante($intIdePracticante);
                if ($requestDelete == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el practicante');
                } else if ($requestDelete == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un practicante asociado a un usuario.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el practicante.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function registrarAccesoModulo($modulo)
    {
        if (isset($_SESSION['idUser'])) {
            $this->model->registrarAccesoModulo($_SESSION['idUser'], $modulo);
        }
    }
} 