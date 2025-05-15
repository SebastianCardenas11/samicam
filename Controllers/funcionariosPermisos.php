<?php

class FuncionariosPermisos extends Controllers
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
        getPermisos(MDASHBOARD);
    }

    public function FuncionariosPermisos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Permisos";
        $data['page_title'] = "Permisos";
        $data['page_name'] = "Permisos";
        $data['page_functions_js'] = "functions_funcionariosPermisos.js";
        $this->views->getView($this, "funcionariospermisos", $data);
    }
    

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
             
                $btnView = '';
                $btnPermit = '';
                $btnHistorial = '';

                // Mostrar permisos del mes actual
                $permisosUsados = $arrData[$i]['permisos_mes_actual'] ?? 0;
                $arrData[$i]['permisos'] = $permisosUsados . "/3";

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnPermit = '<button class="btn btn-warning" onClick="fntPermitInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Crear Permiso"><i class="bi bi-plus-lg"></i></button>';
                }
                
                $btnHistorial = '<button class="btn btn-secondary" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
               
            
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPermit . ' ' . $btnHistorial . '</div>';
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

    public function getHistorialPermisos($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                $arrData = $this->model->getPermisosHistorial($idefuncionario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'No hay permisos registrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setPermiso()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaPermiso']) || empty($_POST['txtMotivoPermiso'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    $idFuncionario = intval($_POST['idFuncionario']);
                    $fechaPermiso = $_POST['txtFechaPermiso'];
                    $motivoPermiso = $_POST['txtMotivoPermiso'];
                    
                    $request = $this->model->insertPermiso($idFuncionario, $fechaPermiso, $motivoPermiso);
                    
                    if ($request['status']) {
                        $arrResponse = array('status' => true, 'msg' => $request['msg']);
                    } else {
                        $arrResponse = array('status' => false, 'msg' => $request['msg']);
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}