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
            $intPlazo = intval($_POST['plazo']);
            $strTipoPlazo = strClean($_POST['tipo_plazo']);
            $decValorTotalContrato = floatval($_POST['valor_total_contrato']);
            $strDiaCorteInforme = strClean($_POST['dia_corte_informe']);
            $strObservacionesEjecucion = strClean($_POST['observaciones_ejecucion']);
            $strEvidenciadoSecop = strClean($_POST['evidenciado_secop']);
            $strFechaVerificacion = strClean($_POST['fecha_verificacion']);
            $decLiquidacion = floatval($_POST['liquidacion']);
            $intEstado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
            $strNumeroContrato = strClean($_POST['numero_contrato']);
            $strFechaAprobacionEntidad = strClean($_POST['fecha_aprobacion_entidad']);

            if ($intId == 0) {
                $option = 1;
                if ($_SESSION['permisosMod']['w']) {
                    $request_contrato = $this->model->insertContrato(
                        $strObjetoContrato,
                        $strFechaInicio,
                        $strFechaTerminacion,
                        $strFechaAprobacionEntidad,
                        $strNumeroContrato,
                        $intPlazo,
                        $strTipoPlazo,
                        $decValorTotalContrato,
                        $strDiaCorteInforme,
                        $strObservacionesEjecucion,
                        $strEvidenciadoSecop,
                        $strFechaVerificacion,
                        $decLiquidacion,
                        $intEstado
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
                        $strFechaAprobacionEntidad,
                        $strNumeroContrato,
                        $intPlazo,
                        $strTipoPlazo,
                        $decValorTotalContrato,
                        $strDiaCorteInforme,
                        $strObservacionesEjecucion,
                        $strEvidenciadoSecop,
                        $strFechaVerificacion,
                        $decLiquidacion,
                        $intEstado
                    );
                }
            }

            if ($request_contrato > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Contrato guardado correctamente');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Contrato actualizado correctamente');
                }
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
                
                // Formatear el plazo con su tipo
                $tipoPlazo = $arrData[$i]['tipo_plazo'] == 'dias' ? 'días' : 'meses';
                $arrData[$i]['plazo'] = $arrData[$i]['plazo'] . ' ' . $tipoPlazo;
                
                if ($arrData[$i]['estado'] == 1) {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-warning">En progreso</span>';
                } else if ($arrData[$i]['estado'] == 2) {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-danger">Finalizado</span>';
                } else if ($arrData[$i]['estado'] == 3) {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-info">Liquidado</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-secondary">Desconocido</span>';
                }

                // Asegurar que los campos nuevos estén presentes y sin formato
                $arrData[$i]['numero_contrato'] = $arrData[$i]['numero_contrato'];
                $arrData[$i]['fecha_aprobacion_entidad'] = $arrData[$i]['fecha_aprobacion_entidad'];

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

    public function getContratosPorMes()
    {
        if ($_SESSION['permisosMod']['r']) {
            $anio = date('Y');
            $model = $this->model;
            $sql = "SELECT MONTH(fecha_inicio) as mes, COUNT(*) as cantidad FROM seguimiento_contrato WHERE YEAR(fecha_inicio) = $anio GROUP BY mes ORDER BY mes";
            $result = $model->select_all($sql);
            $data = array_fill(1, 12, 0);
            foreach ($result as $row) {
                $data[(int)$row['mes']] = (int)$row['cantidad'];
            }
            echo json_encode(['status'=>true,'data'=>$data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContratosActivosInactivos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT estado, COUNT(*) as cantidad FROM seguimiento_contrato GROUP BY estado";
            $result = $this->model->select_all($sql);
            $data = [
                'activos' => 0,
                'inactivos' => 0,
                'en_progreso' => 0,
                'finalizado' => 0,
                'liquidado' => 0
            ];
            foreach ($result as $row) {
                if ($row['estado'] == 1) {
                    $data['en_progreso'] = (int)$row['cantidad'];
                    $data['activos'] += (int)$row['cantidad'];
                } else if ($row['estado'] == 2) {
                    $data['finalizado'] = (int)$row['cantidad'];
                    $data['inactivos'] += (int)$row['cantidad'];
                } else if ($row['estado'] == 3) {
                    $data['liquidado'] = (int)$row['cantidad'];
                    $data['inactivos'] += (int)$row['cantidad'];
                }
            }
            echo json_encode(['status'=>true,'data'=>$data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getEstadisticasAvanzadas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $anio = date('Y');
            
            // Contratos por mes con valores
            $sqlMes = "SELECT MONTH(fecha_inicio) as mes, COUNT(*) as cantidad, SUM(valor_total_contrato) as valor_total 
                      FROM seguimiento_contrato WHERE YEAR(fecha_inicio) = $anio GROUP BY mes ORDER BY mes";
            $resultMes = $this->model->select_all($sqlMes);
            
            // Valores por estado
            $sqlEstado = "SELECT estado, COUNT(*) as cantidad, SUM(valor_total_contrato) as valor_total, AVG(plazo) as plazo_promedio
                         FROM seguimiento_contrato GROUP BY estado";
            $resultEstado = $this->model->select_all($sqlEstado);
            
            // Métricas generales
            $sqlTotal = "SELECT COUNT(*) as total, SUM(valor_total_contrato) as valor_total, AVG(valor_total_contrato) as promedio, AVG(plazo) as plazo_promedio
                        FROM seguimiento_contrato WHERE estado != 0";
            $resultTotal = $this->model->select_all($sqlTotal);
            
            $arrResponse = [
                'status' => true,
                'mes' => $resultMes,
                'estado' => $resultEstado,
                'total' => $resultTotal
            ];
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContratosPorTipoPlazo()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT tipo_plazo, COUNT(*) as cantidad FROM seguimiento_contrato WHERE estado != 0 GROUP BY tipo_plazo";
            $result = $this->model->select_all($sql);
            
            $data = [
                'dias' => 0,
                'meses' => 0,
            ];

            foreach ($result as $row) {
                if (isset($data[$row['tipo_plazo']])) {
                    $data[$row['tipo_plazo']] = (int)$row['cantidad'];
                }
            }
            
            echo json_encode(['status' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContratosPorVencer()
    {
        if ($_SESSION['permisosMod']['r']) {
            $dias = isset($_GET['dias']) ? intval($_GET['dias']) : 30; // Por defecto, 30 días
            $arrData = $this->model->selectContratosPorVencer($dias);
            
            echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
} 