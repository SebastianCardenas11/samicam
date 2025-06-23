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

    public function getLiquidaciones()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT 
                        numero_contrato,
                        valor_total_contrato as valor,
                        fecha_inicio as fecha,
                        CASE 
                            WHEN estado = 3 THEN 'Liquidado'
                            WHEN estado = 2 THEN 'Finalizado'
                            ELSE 'En Progreso'
                        END as estado
                    FROM seguimiento_contrato 
                    WHERE estado != 0 
                    ORDER BY fecha_inicio DESC";
            
            $liquidaciones = $this->model->select_all($sql);
            
            // Calcular totales
            $total_liquidado = 0;
            $pendiente_liquidacion = 0;
            
            foreach ($liquidaciones as $liquidacion) {
                if ($liquidacion['estado'] == 'Liquidado') {
                    $total_liquidado += floatval($liquidacion['valor']);
                } else {
                    $pendiente_liquidacion += floatval($liquidacion['valor']);
                }
            }
            
            $arrResponse = [
                'status' => true,
                'liquidaciones' => $liquidaciones,
                'total_liquidado' => $total_liquidado,
                'pendiente_liquidacion' => $pendiente_liquidacion
            ];
            
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getLiquidacionesCompletas()
    {
        if ($_SESSION['permisosMod']['r']) {
            // Obtener datos de liquidaciones con cálculos
            $sql = "SELECT 
                        numero_contrato,
                        valor_total_contrato as valor,
                        fecha_inicio,
                        fecha_terminacion,
                        liquidacion,
                        estado,
                        CASE 
                            WHEN estado = 3 THEN 'Liquidado'
                            WHEN estado = 2 THEN 'Finalizado'
                            ELSE 'En Progreso'
                        END as estado_texto,
                        CASE 
                            WHEN estado = 3 AND liquidacion > 0 THEN DATEDIFF(fecha_terminacion, fecha_inicio)
                            ELSE NULL
                        END as dias
                    FROM seguimiento_contrato 
                    WHERE estado != 0 
                    ORDER BY fecha_inicio DESC";
            
            $liquidaciones = $this->model->select_all($sql);
            
            // Calcular métricas
            $total_liquidado = 0;
            $pendiente_liquidacion = 0;
            $liquidaciones_completadas = 0;
            $dias_totales = 0;
            
            foreach ($liquidaciones as $liquidacion) {
                if ($liquidacion['estado'] == 'Liquidado') {
                    $total_liquidado += floatval($liquidacion['valor']);
                    $liquidaciones_completadas++;
                    if ($liquidacion['dias'] !== null) {
                        $dias_totales += $liquidacion['dias'];
                    }
                } else {
                    $pendiente_liquidacion += floatval($liquidacion['valor']);
                }
            }
            
            $promedio_liquidacion = $liquidaciones_completadas > 0 ? $total_liquidado / $liquidaciones_completadas : 0;
            $tiempo_promedio = $liquidaciones_completadas > 0 ? round($dias_totales / $liquidaciones_completadas) : 0;
            
            // Datos para gráficos
            $sql_evolucion = "SELECT 
                                DATE_FORMAT(fecha_inicio, '%Y-%m') as mes,
                                COUNT(*) as cantidad,
                                SUM(valor_total_contrato) as valor_total
                              FROM seguimiento_contrato 
                              WHERE estado = 3 
                              GROUP BY DATE_FORMAT(fecha_inicio, '%Y-%m')
                              ORDER BY mes DESC 
                              LIMIT 12";
            
            $evolucion = $this->model->select_all($sql_evolucion);
            
            $sql_distribucion = "SELECT 
                                  MONTH(fecha_inicio) as mes,
                                  COUNT(*) as cantidad
                                FROM seguimiento_contrato 
                                WHERE estado = 3 AND YEAR(fecha_inicio) = YEAR(CURDATE())
                                GROUP BY MONTH(fecha_inicio)
                                ORDER BY mes";
            
            $distribucion = $this->model->select_all($sql_distribucion);
            
            // Preparar datos para gráficos
            $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            $cantidades = array_fill(0, 12, 0);
            
            foreach ($distribucion as $item) {
                $cantidades[$item['mes'] - 1] = (int)$item['cantidad'];
            }
            
            $arrResponse = [
                'status' => true,
                'liquidaciones' => $liquidaciones,
                'total_liquidado' => $total_liquidado,
                'pendiente_liquidacion' => $pendiente_liquidacion,
                'promedio_liquidacion' => $promedio_liquidacion,
                'tiempo_promedio' => $tiempo_promedio,
                'grafico_evolucion' => $evolucion,
                'grafico_distribucion' => [
                    'meses' => $meses,
                    'cantidades' => $cantidades
                ]
            ];
            
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContratosPendientesLiquidacion()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT 
                        numero_contrato,
                        objeto_contrato,
                        fecha_terminacion,
                        valor_total_contrato
                    FROM seguimiento_contrato 
                    WHERE estado = 2 
                    ORDER BY fecha_terminacion DESC";
            
            $contratos = $this->model->select_all($sql);
            
            $arrResponse = [
                'status' => true,
                'data' => $contratos
            ];
            
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function exportarLiquidacionesExcel()
    {
        if ($_SESSION['permisosMod']['r']) {
            // Obtener datos de liquidaciones
            $sql = "SELECT 
                        numero_contrato,
                        objeto_contrato,
                        valor_total_contrato as valor,
                        fecha_inicio,
                        fecha_terminacion,
                        liquidacion,
                        estado,
                        CASE 
                            WHEN estado = 3 THEN 'Liquidado'
                            WHEN estado = 2 THEN 'Finalizado'
                            ELSE 'En Progreso'
                        END as estado_texto,
                        CASE 
                            WHEN estado = 3 AND liquidacion > 0 THEN DATEDIFF(fecha_terminacion, fecha_inicio)
                            ELSE NULL
                        END as dias
                    FROM seguimiento_contrato 
                    WHERE estado != 0 
                    ORDER BY fecha_inicio DESC";
            
            $liquidaciones = $this->model->select_all($sql);
            
            // Calcular métricas
            $total_liquidado = 0;
            $pendiente_liquidacion = 0;
            $liquidaciones_completadas = 0;
            $dias_totales = 0;
            
            foreach ($liquidaciones as $liquidacion) {
                if ($liquidacion['estado'] == 'Liquidado') {
                    $total_liquidado += floatval($liquidacion['valor']);
                    $liquidaciones_completadas++;
                    if ($liquidacion['dias'] !== null) {
                        $dias_totales += $liquidacion['dias'];
                    }
                } else {
                    $pendiente_liquidacion += floatval($liquidacion['valor']);
                }
            }
            
            $promedio_liquidacion = $liquidaciones_completadas > 0 ? $total_liquidado / $liquidaciones_completadas : 0;
            $tiempo_promedio = $liquidaciones_completadas > 0 ? round($dias_totales / $liquidaciones_completadas) : 0;
            
            // Configurar headers para descarga de Excel
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Reporte_Liquidaciones_' . date('Y-m-d_H-i-s') . '.xls"');
            header('Cache-Control: max-age=0');
            
            // BOM UTF-8 como PRIMERA salida
            echo "\xEF\xBB\xBF";
            // Meta charset como PRIMERA línea HTML
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
            
            // Crear contenido del Excel
            echo '<table border="1">';
            
            // Título del reporte
            echo '<tr><td colspan="8" style="background-color: #4e73df; color: white; text-align: center; font-weight: bold; font-size: 16px;">REPORTE DE LIQUIDACIONES DE CONTRATOS</td></tr>';
            echo '<tr><td colspan="8" style="text-align: center; font-weight: bold;">Fecha de generación: ' . date('d/m/Y H:i:s') . '</td></tr>';
            echo '<tr><td colspan="8"></td></tr>';
            
            // Métricas resumen
            echo '<tr><td colspan="8" style="background-color: #f8f9fc; font-weight: bold;">RESUMEN DE MÉTRICAS</td></tr>';
            echo '<tr><td colspan="2">Total Liquidado:</td><td colspan="2">$ ' . number_format($total_liquidado, 2, ',', '.') . '</td>';
            echo '<td colspan="2">Pendiente de Liquidación:</td><td colspan="2">$ ' . number_format($pendiente_liquidacion, 2, ',', '.') . '</td></tr>';
            echo '<tr><td colspan="2">Promedio Liquidación:</td><td colspan="2">$ ' . number_format($promedio_liquidacion, 2, ',', '.') . '</td>';
            echo '<td colspan="2">Tiempo Promedio:</td><td colspan="2">' . $tiempo_promedio . ' días</td></tr>';
            echo '<tr><td colspan="8"></td></tr>';
            
            // Encabezados de la tabla
            echo '<tr style="background-color: #4e73df; color: white; font-weight: bold;">';
            echo '<td>Número de Contrato</td>';
            echo '<td>Objeto del Contrato</td>';
            echo '<td>Valor Total</td>';
            echo '<td>Fecha de Inicio</td>';
            echo '<td>Fecha de Terminación</td>';
            echo '<td>Días de Ejecución</td>';
            echo '<td>Estado</td>';
            echo '<td>Liquidación</td>';
            echo '</tr>';
            
            // Datos de liquidaciones
            foreach ($liquidaciones as $liquidacion) {
                echo '<tr>';
                echo '<td>' . $liquidacion['numero_contrato'] . '</td>';
                echo '<td>' . $liquidacion['objeto_contrato'] . '</td>';
                echo '<td>$ ' . number_format($liquidacion['valor'], 2, ',', '.') . '</td>';
                echo '<td>' . $liquidacion['fecha_inicio'] . '</td>';
                echo '<td>' . ($liquidacion['fecha_terminacion'] ?: 'Pendiente') . '</td>';
                echo '<td>' . ($liquidacion['dias'] ?: '-') . '</td>';
                echo '<td>' . $liquidacion['estado_texto'] . '</td>';
                echo '<td>$ ' . number_format($liquidacion['liquidacion'], 2, ',', '.') . '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
        }
        die();
    }
} 