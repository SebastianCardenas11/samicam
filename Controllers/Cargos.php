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
        getPermisos(MDASHBOARD);
    }

    public function Cargos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Cargos";
        $data['page_title'] = "Cargos";
        $data['page_name'] = "cargos";
        $data['page_functions_js'] = "functions_cargos.js";
        $this->views->getView($this, "cargos", $data);
    }

    public function setCargos()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtNombresCargos'])) {
                $arrResponse = array("estatus" => false, "msg" => '``Datos incorrectos.');
            } else {
                $intIdeCargos = intval($_POST['idecargo']);
                $strNombresCargos = strClean($_POST['txtNombresCargos']);
                $strNivel = intval(strClean($_POST['txtNivel']));
                $intSalario = intval(strClean($_POST['txtsalario']));
                $intEstatus = intval(strClean($_POST['txtstatus']));

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
                            $strNombresCargos,
                            $strNivel,
                            $intSalario,
                            $intEstatus
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

    public function getCargos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCargos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if($arrData[$i]['estatus'] == 1)
                {
                    $arrData[$i]['estatus'] = '<span class="badge text-bg-success">Activo</span>';
                }else{
                    $arrData[$i]['estatus'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idecargos'] . ')" title="Ver Usuario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idecargos'] . ')" title="Editar Usuario"><i class="bi bi-pencil"></i></button>';
                }
                // if ($_SESSION['permisosMod']['d']) {
                //     $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['ideusuario'] . ')" title="Eliminar Usuario"><i class="bi bi-trash3"></i></button>';
       
                // }

                // if($_SESSION['permisosMod']['d']){
                //     if(($_SESSION['userData']['idecargos'] != $arrData[$i]['idecargos'] )
                //          ){
                //             $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idecargos'] . ')" title="Eliminar Usuario"><i class="bi bi-trash3"></i></button>';
                //     }else{
                //         $btnDelete = '<button class="btn btn-secondary" disabled ><i class="bi bi-trash3"></i></button>';
                //     }
                // }

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
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // public function delUsuario()
    // {
    //     if ($_POST) {
    //         if ($_SESSION['permisosMod']['d']) {
    //             $intIdeUsuario = intval($_POST['ideUsuario']);
    //             $requestDelete = $this->model->deleteUsuario($intIdeUsuario);
    //             if ($requestDelete) {
    //                 $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Usuario');
    //             } else {
    //                 $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Usuario.');
    //             }
    //             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    //     die();
    // }

}