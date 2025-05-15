<?php

class Vacaciones extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDASHBOARD);
    }

    public function Vacaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Vacaciones";
        $data['page_title'] = "Vacaciones";
        $data['page_name'] = "Vacaciones";
        $data['page_functions_js'] = "functions_vacaciones.js";
        $this->views->getView($this, "vacaciones", $data);
    }

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnVacaciones = '';
                $btnHistorial = '';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u'] && $arrData[$i]['periodos_disponibles'] > 0) {
                    $btnVacaciones = '<button class="btn btn-success" onClick="fntVacacionesInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Registrar Vacaciones"><i class="bi bi-calendar-check"></i></button>';
                }
                
                $btnHistorial = '<button class="btn btn-secondary" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnVacaciones . ' ' . $btnHistorial . '</div>';
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

    public function getHistorialVacaciones($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                try {
                    $arrData = $this->model->getHistorialVacaciones($idefuncionario);
                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'msg' => 'No hay vacaciones registradas.');
                    } else {
                        $arrResponse = array('status' => true, 'data' => $arrData);
                    }
                } catch (Exception $e) {
                    $arrResponse = array('status' => false, 'msg' => 'Error al obtener el historial de vacaciones.');
                    error_log("Error en getHistorialVacaciones: " . $e->getMessage());
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setVacaciones()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaInicio']) || empty($_POST['txtFechaFin']) || empty($_POST['listPeriodo'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idFuncionario = intval($_POST['idFuncionario']);
                        $fechaInicio = $_POST['txtFechaInicio'];
                        $fechaFin = $_POST['txtFechaFin'];
                        $periodo = intval($_POST['listPeriodo']);
                        
                        // Validar que la fecha de fin sea posterior a la de inicio
                        if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
                            $arrResponse = array("status" => false, "msg" => 'La fecha de fin debe ser posterior a la fecha de inicio.');
                        } else {
                            $request = $this->model->insertVacaciones($idFuncionario, $fechaInicio, $fechaFin, $periodo);
                            
                            if ($request['status']) {
                                $arrResponse = array('status' => true, 'msg' => $request['msg']);
                            } else {
                                $arrResponse = array('status' => false, 'msg' => $request['msg']);
                            }
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al registrar las vacaciones. Intente nuevamente.');
                        error_log("Error en setVacaciones: " . $e->getMessage());
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function cancelarVacaciones()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idVacaciones'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idVacaciones = intval($_POST['idVacaciones']);
                        $request = $this->model->cancelarVacaciones($idVacaciones);
                        
                        if ($request['status']) {
                            $arrResponse = array('status' => true, 'msg' => $request['msg']);
                        } else {
                            $arrResponse = array('status' => false, 'msg' => $request['msg']);
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al cancelar las vacaciones. Intente nuevamente.');
                        error_log("Error en cancelarVacaciones: " . $e->getMessage());
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}