<?php

class FuncionariosPlanta extends Controllers
{
    // $FuncionariosPlanta;

    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDASHBOARD);
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
        $data['page_functions_js'] = "functions_funcionariosPlanta.js";
        $this->views->getView($this, "funcionariosPlanta", $data);
    }


    public function setFuncionario()
    {
        error_reporting(0);
    
        if ($_POST) {
            if (
                empty($_POST['txtCorreoFuncionario']) ||
                empty($_POST['txtNombreFuncionario']) ||
                empty($_POST['txtIdentificacionFuncionario'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
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
                            $strNombreFormacion,
                        );                        
                    }
                } else {
                    
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
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
                            $strNombreFormacion,
                        );
                    }
                }
    
                if ($request > 0) {
                    $msg = $option == 1 ? "Funcionario guardado correctamente" : "Funcionario actualizado correctamente";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else if ($request == 'exist') {
                    $arrResponse = array("status" => false, "msg" => '¡Atención! El funcionario ya existe.');
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
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idefuncionario'] . ')" title="Editar Funcionario"><i class="bi bi-pencil"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Eliminar Usuario"><i class="bi bi-trash3"></i></button>';
       
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
                $intidefuncionario = intval($_POST['idefuncionario']);
                $requestDelete = $this->model->deleteFuncionario($intidefuncionario);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Usuario');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Usuario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
}