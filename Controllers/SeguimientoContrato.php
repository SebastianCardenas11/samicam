<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $data['page_id'] = 11;
        $data['page_functions_js'] = "functions_seguimiento_contrato.js";
        $this->views->getView($this, "seguimientoContrato", $data);
    }

    public function getDependencias()
    {
        $sql = "SELECT dependencia_pk as id, nombre as dependencia FROM tbl_dependencia ORDER BY nombre ASC";
        $dependencias = $this->model->select_all($sql);
        echo json_encode($dependencias, JSON_UNESCAPED_UNICODE);
        die();
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
            $intDependenciaId = intval($_POST['dependencia_id']);
            $strFechaAprobacionEntidad = strClean($_POST['fecha_aprobacion_entidad']);
            $strTipoInforme = isset($_POST['tipo_informe']) && in_array($_POST['tipo_informe'], ['acta parcial', 'mes vencido']) ? strClean($_POST['tipo_informe']) : 'acta parcial';
            $intCantidadInformes = isset($_POST['cantidad_informes']) ? intval($_POST['cantidad_informes']) : 1;

            if ($intId == 0) {
                $option = 1;
                if ($_SESSION['permisosMod']['w']) {
                    $request_contrato = $this->model->insertContrato(
                        $strObjetoContrato,
                        $strFechaInicio,
                        $strFechaTerminacion,
                        $strFechaAprobacionEntidad,
                        $strNumeroContrato,
                        $intDependenciaId,
                        $intPlazo,
                        $strTipoPlazo,
                        $strTipoInforme,
                        $intCantidadInformes,
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
                        $intDependenciaId,
                        $intPlazo,
                        $strTipoPlazo,
                        $strTipoInforme,
                        $intCantidadInformes,
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
                $btnProrroga = '';
                $btnHistorial = '';
                $btnAdicion = '';
                $btnHistorialAdiciones = '';
                $btnEstado = '';

                // Guardar valor sin formatear para el botón de adición
                $arrData[$i]['valor_total_contrato_raw'] = $arrData[$i]['valor_total_contrato'];
                $arrData[$i]['valor_total_contrato'] = '$' . number_format($arrData[$i]['valor_total_contrato'], 2, ',', '.');
                $arrData[$i]['liquidacion'] = '$' . number_format($arrData[$i]['liquidacion'], 2, ',', '.');
                
                // Formatear el plazo con su tipo
                $tipoPlazo = $arrData[$i]['tipo_plazo'] == 'dias' ? 'días' : 'meses';
                $arrData[$i]['plazo'] = $arrData[$i]['plazo'] . ' ' . $tipoPlazo;
                
                if ($arrData[$i]['estado'] == 1) {
                    $arrData[$i]['estado'] = '<span class="badge text-bg-warning">En ejecucion</span>';
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
                    $btnProrroga = '<button class="btn btn-primary btn-sm" onClick="fntProrrogaContrato(' . $arrData[$i]['id'] . ',\'' . $arrData[$i]['fecha_terminacion'] . '\')" title="Prórroga"><i class="fas fa-clock"></i></button>';
                    $btnHistorial = '<button class="btn btn-info btn-sm" onClick="fntHistorialProrrogas(' . $arrData[$i]['id'] . ')" title="Historial de Prórrogas"><i class="fas fa-history"></i></button>';
                    $valorContrato = $arrData[$i]['valor_total_contrato_raw'];
                    $limiteMaximo = $valorContrato * 0.5;
                    $sqlSumaAdiciones = "SELECT COALESCE(SUM(valor_adicion), 0) as suma FROM adiciones_contrato WHERE id_contrato = ?";
                    $sumaAdiciones = $this->model->select($sqlSumaAdiciones, [$arrData[$i]['id']]);
                    $totalAdiciones = floatval($sumaAdiciones['suma']);
                    if ($totalAdiciones < $limiteMaximo) {
                        $btnAdicion = '<button class="btn btn-success btn-sm" onClick="fntAdicionContrato(' . $arrData[$i]['id'] . ',' . $valorContrato . ')" title="Crear Adición"><i class="fas fa-plus-circle"></i></button>';
                    } else {
                        $btnAdicion = '';
                    }
                    $btnHistorialAdiciones = '<button class="btn btn-warning btn-sm" onClick="fntHistorialAdiciones(' . $arrData[$i]['id'] . ')" title="Historial de Adiciones"><i class="fas fa-history"></i></button>';
                    $btnEstado = '<button class="btn btn-primary btn-sm" onClick="fntCambiarEstadoContrato(' . $arrData[$i]['id'] . ')" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>';
                } else {
                    $btnProrroga = '';
                    $btnHistorial = '';
                    $btnAdicion = '';
                    $btnHistorialAdiciones = '';
                    $btnEstado = '';
                }
                

                // Botón de tres puntos para más opciones
                $btnMore = '<button class="btn btn-secondary btn-sm" onClick="fntShowMoreOptions(' . $arrData[$i]['id'] . ')" title="Más opciones"><i class="fas fa-ellipsis-h"></i></button>';

                // Botones de acción según estado y rol
                if (isset($_SESSION['userData']['idrol']) && $_SESSION['userData']['idrol'] == 1) {
                    // Superadministrador ve todos los botones SIEMPRE
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit .  ' ' . $btnMore . '</div>';
                } else if ($arrData[$i]['estado'] == '<span class="badge text-bg-info">Liquidado</span>') {
                    // Solo botón de ver para los demás
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '</div>';
                } else {
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnMore . '</div>';
                }
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
                            ELSE 'En Ejecucion'
                        END as estado
                    FROM seguimiento_contrato 
                    WHERE estado != 0 
                    ORDER BY fecha_inicio DESC";
            
            $liquidaciones = $this->model->select_all($sql);
            
            // Calcular totales
            $total_liquidado = 0;
            $pendiente_liquidacion = 0;
            
            foreach ($liquidaciones as $liquidacion) {
                if ($liquidacion['estado'] == 3) { // Estado numérico
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
                            ELSE 'En Ejecucion'
                        END as estado_texto,
                        CASE 
                            WHEN estado = 3 AND fecha_terminacion IS NOT NULL AND fecha_inicio IS NOT NULL THEN DATEDIFF(fecha_terminacion, fecha_inicio)
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
                if ($liquidacion['estado'] == 3) { // Estado numérico
                    $total_liquidado += floatval($liquidacion['valor']);
                    $liquidaciones_completadas++;
                    if ($liquidacion['dias'] !== null && $liquidacion['dias'] >= 0) {
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
        if (!isset($_SESSION['permisosMod']['r']) || !$_SESSION['permisosMod']['r']) {
            // No hay permisos, no hacer nada o mostrar error
            return;
        }

        // 1. Obtener los datos de la base de datos
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
                        ELSE 'En Ejecucion'
                    END as estado_texto,
                    CASE 
                        WHEN estado = 3 AND fecha_terminacion IS NOT NULL AND fecha_inicio IS NOT NULL THEN DATEDIFF(fecha_terminacion, fecha_inicio)
                        ELSE NULL
                    END as dias
                FROM seguimiento_contrato 
                WHERE estado != 0 
                ORDER BY fecha_inicio DESC";
        $liquidaciones = $this->model->select_all($sql);

        // 2. Crear una nueva instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Estilos
        $styleTitle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 16],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']]
        ];
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']]
        ];
        $styleMetricHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FC']]
        ];

        // 4. Escribir Título y Fecha
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'REPORTE DE LIQUIDACIONES DE CONTRATOS');
        $sheet->getStyle('A1')->applyFromArray($styleTitle);
        $sheet->getRowDimension('1')->setRowHeight(30);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Fecha de generación: ' . date('d/m/Y H:i:s'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 5. Calcular y escribir métricas
        // ... (cálculo de métricas igual que antes)
        $total_liquidado = 0;
        $pendiente_liquidacion = 0;
        $liquidaciones_completadas = 0;
        $dias_totales = 0;
        foreach ($liquidaciones as $liq) {
            if ($liq['estado'] == 3) { // Liquidado - Estado numérico
                $total_liquidado += floatval($liq['valor']);
                $liquidaciones_completadas++;
                if ($liq['dias'] !== null) $dias_totales += $liq['dias'];
            } else {
                $pendiente_liquidacion += floatval($liq['valor']);
            }
        }
        $promedio_liquidacion = $liquidaciones_completadas > 0 ? $total_liquidado / $liquidaciones_completadas : 0;
        $tiempo_promedio = $liquidaciones_completadas > 0 ? round($dias_totales / $liquidaciones_completadas) : 0;

        $sheet->mergeCells('A4:H4');
        $sheet->setCellValue('A4', 'RESUMEN DE MÉTRICAS');
        $sheet->getStyle('A4')->applyFromArray($styleMetricHeader);

        $sheet->setCellValue('A5', 'Total Liquidado:');
        $sheet->setCellValue('B5', $total_liquidado)->getStyle('B5')->getNumberFormat()->setFormatCode('"$"#,##0.00');
        $sheet->setCellValue('C5', 'Pendiente de Liquidación:');
        $sheet->setCellValue('D5', $pendiente_liquidacion)->getStyle('D5')->getNumberFormat()->setFormatCode('"$"#,##0.00');
        
        $sheet->setCellValue('A6', 'Promedio Liquidación:');
        $sheet->setCellValue('B6', $promedio_liquidacion)->getStyle('B6')->getNumberFormat()->setFormatCode('"$"#,##0.00');
        $sheet->setCellValue('C6', 'Tiempo Promedio:');
        $sheet->setCellValue('D6', $tiempo_promedio . ' días');

        // 6. Escribir encabezados de la tabla
        $headerRow = 8;
        $sheet->setCellValue('A' . $headerRow, 'Número de Contrato');
        $sheet->setCellValue('B' . $headerRow, 'Objeto del Contrato');
        $sheet->setCellValue('C' . $headerRow, 'Valor Total');
        $sheet->setCellValue('D' . $headerRow, 'Fecha de Inicio');
        $sheet->setCellValue('E' . $headerRow, 'Fecha de Terminación');
        $sheet->setCellValue('F' . $headerRow, 'Días de Ejecución');
        $sheet->setCellValue('G' . $headerRow, 'Estado');
        $sheet->setCellValue('H' . $headerRow, 'Liquidación');
        $sheet->getStyle('A' . $headerRow . ':H' . $headerRow)->applyFromArray($styleHeader);

        // 7. Escribir datos
        $row = $headerRow + 1;
        foreach ($liquidaciones as $liquidacion) {
            $sheet->setCellValue('A' . $row, $liquidacion['numero_contrato']);
            $sheet->setCellValue('B' . $row, $liquidacion['objeto_contrato']);
            $sheet->setCellValue('C' . $row, $liquidacion['valor'])->getStyle('C'.$row)->getNumberFormat()->setFormatCode('"$"#,##0.00');
            $sheet->setCellValue('D' . $row, $liquidacion['fecha_inicio']);
            $sheet->setCellValue('E' . $row, $liquidacion['fecha_terminacion'] ?: 'Pendiente');
            $sheet->setCellValue('F' . $row, $liquidacion['dias'] ?: '-');
            $sheet->setCellValue('G' . $row, $liquidacion['estado_texto']);
            $sheet->setCellValue('H' . $row, $liquidacion['liquidacion'])->getStyle('H'.$row)->getNumberFormat()->setFormatCode('"$"#,##0.00');
            $row++;
        }

        // 8. Autoajustar columnas
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 9. Configurar headers y enviar al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Liquidaciones_' . date('Y-m-d_H-i-s') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        die();
    }

    public function setProrrogaContrato()
    {
        if ($_POST) {
            $id_contrato = intval($_POST['id_contrato']);
            $fecha_anterior = strClean($_POST['fecha_anterior']);
            $nueva_fecha = strClean($_POST['nueva_fecha']);
            $dias_prorroga = intval($_POST['dias_prorroga']);
            $motivo = strClean($_POST['motivo']);
            $request = $this->model->saveProrrogaContrato($id_contrato, $fecha_anterior, $nueva_fecha, $dias_prorroga, $motivo);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Prórroga registrada y fecha de terminación actualizada');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo registrar la prórroga');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProrrogasContrato($id_contrato)
    {
        if ($_SESSION['permisosMod']['r']) {
            $id_contrato = intval($id_contrato);
            $data = $this->model->getProrrogasContrato($id_contrato);
            echo json_encode(['status' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getAllProrrogas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT p.*, c.numero_contrato, c.objeto_contrato, d.nombre as dependencia FROM prorrogas_contrato p INNER JOIN seguimiento_contrato c ON p.id_contrato = c.id LEFT JOIN tbl_dependencia d ON c.dependencia_id = d.dependencia_pk ORDER BY p.fecha_registro DESC";
            $data = $this->model->select_all($sql);
            echo json_encode(['status' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Guardar adición
    public function setAdicionContrato()
    {
        if ($_POST) {
            $id_contrato = intval($_POST['id_contrato']);
            $valor_adicion = floatval($_POST['valor_adicion']);
            $motivo = strClean($_POST['motivo']);
            $request = $this->model->saveAdicionContrato($id_contrato, $valor_adicion, $motivo);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Historial de adiciones de un contrato
    public function getAdicionesContrato($id_contrato)
    {
        if ($_SESSION['permisosMod']['r']) {
            $id_contrato = intval($id_contrato);
            $data = $this->model->getAdicionesContrato($id_contrato);
            echo json_encode(['status' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Historial general de adiciones
    public function getAllAdiciones()
    {
        if ($_SESSION['permisosMod']['r']) {
            $sql = "SELECT a.*, c.numero_contrato, c.objeto_contrato, d.nombre as dependencia FROM adiciones_contrato a INNER JOIN seguimiento_contrato c ON a.id_contrato = c.id LEFT JOIN tbl_dependencia d ON c.dependencia_id = d.dependencia_pk ORDER BY a.fecha_adicion DESC";
            $data = $this->model->select_all($sql);
            echo json_encode(['status' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function exportarProrrogasExcel()
    {
        if (!isset($_SESSION['permisosMod']['r']) || !$_SESSION['permisosMod']['r']) {
            return;
        }

        $sql = "SELECT p.*, c.numero_contrato, d.nombre as dependencia, c.objeto_contrato FROM prorrogas_contrato p INNER JOIN seguimiento_contrato c ON p.id_contrato = c.id LEFT JOIN tbl_dependencia d ON c.dependencia_id = d.dependencia_pk ORDER BY p.fecha_registro DESC";
        $data = $this->model->select_all($sql);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REPORTE DE PRÓRROGAS DE CONTRATOS');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Número Contrato');
        $sheet->setCellValue('B3', 'Dependencia');
        $sheet->setCellValue('C3', 'Objeto Contrato');
        $sheet->setCellValue('D3', 'Fecha Anterior');
        $sheet->setCellValue('E3', 'Nueva Fecha');
        $sheet->setCellValue('F3', 'Días Prórroga');
        $sheet->setCellValue('G3', 'Motivo');
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        $row = 4;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['numero_contrato']);
            $sheet->setCellValue('B' . $row, $item['dependencia']);
            $sheet->setCellValue('C' . $row, $item['objeto_contrato']);
            $sheet->setCellValue('D' . $row, $item['fecha_anterior']);
            $sheet->setCellValue('E' . $row, $item['nueva_fecha']);
            $sheet->setCellValue('F' . $row, $item['dias_prorroga']);
            $sheet->setCellValue('G' . $row, $item['motivo']);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Prorrogas_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        die();
    }

    public function exportarAdicionesExcel()
    {
        if (!isset($_SESSION['permisosMod']['r']) || !$_SESSION['permisosMod']['r']) {
            return;
        }

        $data = $this->model->getAllAdiciones();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REPORTE DE ADICIONES DE CONTRATOS');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Número Contrato');
        $sheet->setCellValue('B3', 'Dependencia');
        $sheet->setCellValue('C3', 'Objeto Contrato');
        $sheet->setCellValue('D3', 'Valor Adición');
        $sheet->setCellValue('E3', 'Motivo');
        $sheet->setCellValue('F3', 'Fecha Adición');
        $sheet->getStyle('A3:F3')->getFont()->setBold(true);

        $row = 4;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['numero_contrato']);
            $sheet->setCellValue('B' . $row, $item['dependencia'] ?? 'N/A');
            $sheet->setCellValue('C' . $row, $item['objeto_contrato']);
            $sheet->setCellValue('D' . $row, $item['valor_adicion']);
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('"$"#,##0.00');
            $sheet->setCellValue('E' . $row, $item['motivo']);
            $sheet->setCellValue('F' . $row, $item['fecha_adicion']);
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Adiciones_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        die();
    }

    public function changeEstadoContrato()
    {
        if ($_POST) {
            $id = intval($_POST['id']);
            $estado = intval($_POST['estado']);
            if ($_SESSION['permisosMod']['u']) {
                $request = $this->model->updateEstadoContrato($id, $estado);
                if ($request) {
                    $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el estado');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
} 