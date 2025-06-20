<?php

class SeguimientoContrato extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MSEGUIMIENTOCONTRATO);
    }

    public function SeguimientoContrato()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Seguimiento de Contratos";
        $data['page_title'] = "Seguimiento de Contratos";
        $data['page_name'] = "seguimiento_contrato";
        $data['page_id'] = 11; // Choose an appropriate ID
        $data['page_functions_js'] = "functions_seguimiento_contrato.js";
        $this->views->getView($this, "seguimientoContrato", $data);
    }

    public function setContrato()
    {
        if ($_POST) {
            $intId = intval($_POST['id']);
            $strObjetoContrato = strClean($_POST['objeto_contrato']);
            $strFechaInicio = strClean($_POST['fecha_inicio']);
            $strFechaTerminacion = strClean($_POST['fecha_terminacion']);
            $intPlazoMeses = intval($_POST['plazo_meses']);
            $decValorTotalContrato = floatval($_POST['valor_total_contrato']);
            $strDiaCorteInforme = strClean($_POST['dia_corte_informe']);
            $strObservacionesEjecucion = strClean($_POST['observaciones_ejecucion']);
            $strEvidenciadoSecop = strClean($_POST['evidenciado_secop']);
            $strFechaVerificacion = strClean($_POST['fecha_verificacion']);
            $decLiquidacion = floatval($_POST['liquidacion']);

            if ($intId == 0) {
                $option = 1;
                if ($_SESSION['permisosMod']['w']) {
                    $request_contrato = $this->model->insertContrato(
                        $strObjetoContrato,
                        $strFechaInicio,
                        $strFechaTerminacion,
                        $intPlazoMeses,
                        $decValorTotalContrato,
                        $strDiaCorteInforme,
                        $strObservacionesEjecucion,
                        $strEvidenciadoSecop,
                        $strFechaVerificacion,
                        $decLiquidacion
                    );
                }
            } else {
                $option = 2;
                if ($_SESSION['permisosMod']['u']) {
                    $request_contrato = $this->model->updateContrato(
                        $intId,
                        $strObjetoContrato,
                        $strFechaInicio,
                        $strFechaTerminacion,
                        $intPlazoMeses,
                        $decValorTotalContrato,
                        $strDiaCorteInforme,
                        $strObservacionesEjecucion,
                        $strEvidenciadoSecop,
                        $strFechaVerificacion,
                        $decLiquidacion
                    );
                }
            }

            if ($request_contrato > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Contrato guardado correctamente');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Contrato actualizado correctamente');
                }
            } else if ($request_contrato == "exist") {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El contrato ya existe.');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContratos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectContratos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                $arrData[$i]['valor_total_contrato'] = '$' . number_format($arrData[$i]['valor_total_contrato'], 2, ',', '.');
                $arrData[$i]['liquidacion'] = '$' . number_format($arrData[$i]['liquidacion'], 2, ',', '.');
                
                if ($arrData[$i]['estado'] == 1) {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-success">Activo</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewContrato(' . $arrData[$i]['id'] . ')" title="Ver Contrato"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditContrato(this,' . $arrData[$i]['id'] . ')" title="Editar Contrato"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelContrato(' . $arrData[$i]['id'] . ')" title="Eliminar Contrato"><i class="far fa-trash-alt"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContrato($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $id = intval($id);
            if ($id > 0) {
                $arrData = $this->model->selectContrato($id);
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

    public function delContrato()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intId = intval($_POST['id']);
                $requestDelete = $this->model->deleteContrato($intId);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Contrato');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Contrato.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
} 