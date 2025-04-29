<?php

class FuncionariosPlanta extends Controllers
{
    // Private $FuncionariosPlanta;

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
        $data['page_tag'] = "Funcionarios Planta";
        $data['page_title'] = "Funcionarios Planta";
        $data['page_name'] = "Funcionarios Planta";
        $data['page_functions_js'] = "functions_funcionarios.js";
        $this->views->getView($this, "funcionariosPlanta", $data);
    }


   public function setFuncionario()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtCorreoUsuario'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intidefuncionario = intval($_POST['idefuncionario']);
                $strIdentificacionUsuario = strClean($_POST['txtCorreoUsuario']);
                $strNombresUsuario = strClean($_POST['txtNombresUsuario']);
                $strpassword = strClean($_POST['txtContrasenaUsuario']);
                $strRolUsuario = intval(strClean($_POST['txtRolUsuario']));
                $intStatus = intval(strClean($_POST['listStatus']));

                // $intTipoId = 5;
                $request_user = "";
                if ($intidefuncionario == 0) {
                    $option = 1;
                    $strPassword =  empty($_POST['txtCorreoUsuario']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtCorreoUsuario']);
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertUsuario(
                            $strIdentificacionUsuario,
                            $strNombresUsuario,
                            $strPassword,
                            $strRolUsuario,
                            $intStatus

                        );
                    }
                } else {
                    $option = 2;
                    $strPassword =  empty($_POST['txtCorreoUsuario']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtCorreoUsuario']);
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateUsuario(
                            $intidefuncionario,
                            $strIdentificacionUsuario,
                            $strNombresUsuario,
                            $strRolUsuario,
                            $intStatus
                        );
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Usuario guardado correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Usuario actualizado correctamente');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! la identificación del Usuario ya existe, ingrese otro');
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
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Usuario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idefuncionario'] . ')" title="Editar Usuario"><i class="bi bi-pencil"></i></button>';
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
                $requestDelete = $this->model->deleteUsuario($intidefuncionario);
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