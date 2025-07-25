<?php

class Cargos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        // session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MCARGOS);
    }

    public function Cargos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Cargos";
        $data['page_title'] = "Cargos";
        $data['page_name'] = "cargos";
        $data['page_id'] = 91;
        $data['page_functions_js'] = "functions_cargos.js";
        $this->views->getView($this, "cargos", $data);
    }

    public function setCargos()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtNombresCargos'])) {
                $arrResponse = array("estatus" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdeCargos = intval($_POST['ideCargos']);
                $strNombresCargos = strClean($_POST['txtNombresCargos']);
                $strNivel = (strClean($_POST['txtNivel']));
                $intSalario = floatval(strClean($_POST['txtSalario']));
                $intEstatus = intval(strClean($_POST['listStatus']));
                // $intTipoId = 5;
                $request_user = "";
                if ($intIdeCargos == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertCargos(
                            $strNombresCargos,
                            $strNivel,
                            $intSalario,
                            $intEstatus

                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateCargos(
                            $intIdeCargos,
                            $strNombresCargos,
                            $strNivel,
                            $intSalario,
                            $intEstatus
                        );
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Cargo guardado correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Cargo actualizado correctamente');
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    } 

    public function getCargos()
    {
        
        
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCargos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                
                // Formatear el salario como peso colombiano
                $arrData[$i]['salario'] = '$ ' . number_format($arrData[$i]['salario'], 2, ',', '.');

                if($arrData[$i]['estatus'] == 1)
                {
                    $arrData[$i]['estatus'] = '<span class="badge text-bg-success">Activo</span>';
                }else{
                    $arrData[$i]['estatus'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idecargos'] . ')" title="Ver Cargo"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idecargos'] . ')" title="Editar Cargo"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idecargos'] . ')" title="Eliminar Cargo"><i class="far fa-trash-alt"></i></button>';
       
                }


                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCargo($idecargos)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idecargos = intval($idecargos);
            if ($idecargos > 0) {
                $arrData = $this->model->selectCargo($idecargos);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    // Formatear el salario como peso colombiano
                    $arrData['salario'] = '$ ' . number_format($arrData['salario'], 2, ',', '.');
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delCargos()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdeCargos = intval($_POST['ideCargos']);
                $requestDelete = $this->model->deleteCargos($intIdeCargos);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Cargo');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Cargo.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

}