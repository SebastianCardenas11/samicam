<?php

class Radicados extends Controllers
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
        getPermisos(21); // ID del módulo de radicados
    }

    public function Radicados()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 21;
        $data['page_tag'] = "Radicados";
        $data['page_title'] = "Radicados";
        $data['page_name'] = "radicados";
        $data['page_functions_js'] = "functions_radicados.js";
        
        // Registrar acceso al módulo
        $this->registrarAccesoModulo("Radicados");
        
        $this->views->getView($this, "radicados", $data);
    }

    public function getRadicados()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->getRadicados();
            
            for ($i = 0; $i < count($arrData); $i++) {
                $arrData[$i]['fecha_envio'] = date('d/m/Y', strtotime($arrData[$i]['fecha_envio']));
                $arrData[$i]['fecha_radicado'] = date('d/m/Y', strtotime($arrData[$i]['fecha_radicado']));
                
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewRadicado(' . $arrData[$i]['id_radicado'] . ')" title="Ver radicado"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditRadicado(' . $arrData[$i]['id_radicado'] . ')" title="Editar radicado"><i class="far fa-edit"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelRadicado(' . $arrData[$i]['id_radicado'] . ')" title="Eliminar radicado"><i class="far fa-trash-alt"></i></button>';
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getRadicado($idRadicado)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdRadicado = intval($idRadicado);
            if ($intIdRadicado > 0) {
                $arrData = $this->model->getRadicado($intIdRadicado);
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

    public function setRadicado()
    {
        if ($_POST) {
            $intIdRadicado = intval($_POST['idRadicado']);
            $strAsunto = strClean($_POST['txtAsunto']);
            $strEntidad = strClean($_POST['txtEntidad']);
            $strMedio = strClean($_POST['listMedio']);
            $strFechaEnvio = strClean($_POST['txtFechaEnvio']);
            $strNumeroRadicado = strClean($_POST['txtNumeroRadicado']);
            $strFechaRadicado = strClean($_POST['txtFechaRadicado']);

            if (empty($strAsunto) || empty($strEntidad) || empty($strMedio) || empty($strFechaEnvio) || empty($strNumeroRadicado) || empty($strFechaRadicado)) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                // Verificar si el número de radicado ya existe
                if ($this->model->existeNumeroRadicado($strNumeroRadicado, $intIdRadicado)) {
                    $arrResponse = array("status" => false, "msg" => 'El número de radicado ya existe.');
                } else {
                    $request_radicado = 0;
                    if ($intIdRadicado == 0) {
                        // Crear
                        if ($_SESSION['permisosMod']['w']) {
                            $request_radicado = $this->model->insertRadicado($strAsunto, $strEntidad, $strMedio, $strFechaEnvio, $strNumeroRadicado, $strFechaRadicado, $_SESSION['userData']['ideusuario']);
                            $option = 1;
                        } else {
                            $arrResponse = array("status" => false, "msg" => 'No tiene permisos para crear.');
                        }
                    } else {
                        // Actualizar
                        if ($_SESSION['permisosMod']['u']) {
                            $request_radicado = $this->model->updateRadicado($intIdRadicado, $strAsunto, $strEntidad, $strMedio, $strFechaEnvio, $strNumeroRadicado, $strFechaRadicado);
                            $option = 2;
                        } else {
                            $arrResponse = array("status" => false, "msg" => 'No tiene permisos para actualizar.');
                        }
                    }

                    if ($request_radicado > 0) {
                        if ($option == 1) {
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        } else {
                            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        }
                    } else if (!isset($arrResponse)) {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delRadicado()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdRadicado = intval($_POST['idRadicado']);
                $requestDelete = $this->model->deleteRadicado($intIdRadicado);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el radicado');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el radicado.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getEstadisticasPorMedio()
    {
        if ($_SESSION['permisosMod']['r']) {
            $anio = intval($_POST['anio']) ?: date('Y');
            $arrData = $this->model->getEstadisticasPorMedio($anio);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getEstadisticasPorMes()
    {
        if ($_SESSION['permisosMod']['r']) {
            $anio = intval($_POST['anio']) ?: date('Y');
            $arrData = $this->model->getEstadisticasPorMes($anio);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getTopEntidades()
    {
        if ($_SESSION['permisosMod']['r']) {
            $anio = intval($_POST['anio']) ?: date('Y');
            $arrData = $this->model->getTopEntidades($anio);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}