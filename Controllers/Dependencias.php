<?php
class Dependencias extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDEPENDENCIAS);
    }

    public function Dependencias()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Dependencias";
        $data['page_title'] = "Dependencias";
        $data['page_name'] = "dependencias";
        $data['page_functions_js'] = "functions_dependencias.js";
        $this->views->getView($this, "dependencias", $data);
    }

    public function setDependencia()
    {
        if ($_POST) {
            if (empty($_POST['txtNombreDependencia'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdDependencia = intval($_POST['idDependencia']);
                $strNombre = strClean($_POST['txtNombreDependencia']);
                if ($intIdDependencia == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertDependencia($strNombre);
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateDependencia($intIdDependencia, $strNombre);
                    }
                }
                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => $option == 1 ? 'Dependencia guardada correctamente' : 'Dependencia actualizada correctamente');
                } else if ($request == "exist") {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La dependencia ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getDependencias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectDependencias();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['dependencia_pk'] . ')" title="Ver"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['dependencia_pk'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['dependencia_pk'] . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getDependencia($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intId = intval($id);
            if ($intId > 0) {
                $arrData = $this->model->selectDependencia($intId);
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

    public function delDependencia()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intId = intval($_POST['idDependencia']);
                $requestDelete = $this->model->deleteDependencia($intId);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la dependencia');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la dependencia.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
} 