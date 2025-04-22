<?php

class Fichas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MUSUARIOS);
    }



    public function Fichas()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Fichas";
        $data['page_title'] = "Fichas";
        $data['page_name'] = "fichas";
        $data['page_functions_js'] = "functions_fichas.js";
        $this->views->getView($this, "fichas", $data);
    }

    public function setFicha()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtCodigoPrograma'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdeFicha = intval($_POST['ideFicha']);
                $strCodigoPrograma = strClean($_POST['txtCodigoPrograma']);
                $intNumeroFicha = strClean($_POST['txtFichaPrograma']);
                $strIdeInstructor = strClean($_POST['txtIdeInstructor']);
                $intUsuarioIde = strClean($_POST['txtIdeUsuario']);
                $intProgramaIde = strClean($_POST['txtIdPrograma']);

                $intTipoId = 5;
                $request_user = "";
                if ($intIdeFicha == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertFicha(
                            $intNumeroFicha,
                            $intUsuarioIde,
                            $intProgramaIde

                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateFicha(
                            $intIdeFicha,
                            $intNumeroFicha,
                            $intUsuarioIde,
                            $intProgramaIde
                        );
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Guardada correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Actualizada correctamente');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el numero de ficha ya existe');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFichas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFichas();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnAsignar = '';
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

               

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                }



                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['ideficha'] . ')" title="Ver Ficha"><i class="bi bi-eye"></i></button>';
                   
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['ideficha'] . ')" title="Editar Ficha"><i class="bi bi-pencil"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['ideficha'] . ')" title="Eliminar Ficha"><i class="bi bi-trash3"></i></button>';
       
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFicha($ideficha)
    {
        if ($_SESSION['permisosMod']['r']) {
            $ideficha = intval($ideficha);
            $htmlOptions = "";
            if ($ideficha > 0) {
                $arrData = $this->model->selectFicha($ideficha);
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



    public function delFicha()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdeFicha = intval($_POST['ideficha']);
                $requestDelete = $this->model->deleteFicha($intIdeFicha);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Ficha');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Ficha.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getPrograma($codprograma)
    {
        if ($_SESSION['permisosMod']['r']) {
            $codprograma = intval($codprograma);
            $htmlOptions = "";
            if ($codprograma > 0) {
                $arrData = $this->model->selectPrograma($codprograma);
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

    public function getInstructor($identificacion)
    {
        if ($_SESSION['permisosMod']['r']) {
            $identificacion = intval($identificacion);
            $htmlOptions = "";
            if ($identificacion > 0) {
                $arrData = $this->model->selectInstructor($identificacion);
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


    }