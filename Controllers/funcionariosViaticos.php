<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;

class FuncionariosViaticos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MVIATICOS);
        $this->model = new FuncionariosViaticosModel();
    }

    public function FuncionariosViaticos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['funcionarios_planta'] = $this->model->selectFuncionariosPlanta();
        $data['page_id'] = 7;
        $data['page_tag'] = "Viaticos";
        $data['page_title'] = "Viaticos";
        $data['page_name'] = "Viaticos";
        $data['page_functions_js'] = "functions_Viaticos.js";
        $this->views->getView($this, "funcionariosviaticos", $data);
    }

    public function getCapitalDisponible($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $presupuesto = $this->model->getPresupuestoInfo($year);
            $capitalTotal = floatval($presupuesto['capital_total']);
            $capitalDisponible = floatval($presupuesto['capital_disponible']);
            
            // Si no hay presupuesto registrado, crear uno por defecto
            if ($capitalTotal <= 0) {
                $capitalTotal = 500000000.00;
                $capitalDisponible = 500000000.00;
                $this->model->setPresupuestoAnual($year, $capitalTotal);
            }
            
            echo json_encode([
                'capitalDisponible' => $capitalDisponible,
                'capitalTotal' => $capitalTotal
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getHistoricoViaticos($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $request = $this->model->getHistoricoViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getDetalleViaticos($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $request = $this->model->getDetalleViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getFuncionariosValidos()
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $arrData = $this->model->getFuncionariosValidos();
        echo json_encode($arrData);
        die();
    }

    public function deleteViatico()
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['d'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para esta acción']);
            die();
        }
        
        if ($_POST) {
            $idViatico = intval($_POST['idViatico']);
            
            if ($idViatico <= 0) {
                echo json_encode(['status' => false, 'msg' => 'ID de viático no válido']);
                die();
            }
            
            try {
                $result = $this->model->deleteViatico($idViatico);
                
                if ($result) {
                    echo json_encode(['status' => true, 'msg' => 'Viático eliminado correctamente']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'Error al eliminar el viático']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => false, 'msg' => 'Datos no válidos']);
        }
        die();
    }

    public function setViatico()
    {
        header('Content-Type: application/json');
        
        if (!$_POST || empty($_SESSION['permisosMod']['w'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para realizar esta acción']);
            die();
        }
        
        try {
            if (empty($_POST['funci_fk'])) {
                echo json_encode(['status' => false, 'msg' => 'Debe seleccionar un funcionario']);
                die();
            }
            
            $idFuncionario = intval($_POST['funci_fk']);
            $descripcion = strClean($_POST['descripcion']);
            $monto = floatval($_POST['monto']);
            $fechaAprobacion = strClean($_POST['fecha_aprobacion']);
            $fechaSalida = strClean($_POST['fecha_salida']);
            $fechaRegreso = strClean($_POST['fecha_regreso']);
            $uso = strClean($_POST['uso']);

            if ($idFuncionario <= 0) {
                echo json_encode(['status' => false, 'msg' => 'Funcionario no válido']);
                die();
            }
            
            if ($monto <= 0) {
                echo json_encode(['status' => false, 'msg' => 'El monto debe ser mayor que cero']);
                die();
            }
            
            if (empty($fechaAprobacion) || empty($fechaSalida) || empty($fechaRegreso)) {
                echo json_encode(['status' => false, 'msg' => 'Debe completar todas las fechas']);
                die();
            }
            
            // Validar que la fecha de salida no sea anterior a la fecha actual
            $fechaActual = date('Y-m-d');
            if (strtotime($fechaSalida) < strtotime($fechaActual)) {
                echo json_encode(['status' => false, 'msg' => 'La fecha de salida no puede ser anterior a la fecha actual']);
                die();
            }
            
            // Validar que la fecha de regreso sea posterior a la fecha de salida
            if (strtotime($fechaRegreso) < strtotime($fechaSalida)) {
                echo json_encode(['status' => false, 'msg' => 'La fecha de regreso debe ser posterior a la fecha de salida']);
                die();
            }

            $request = $this->model->insertViatico($idFuncionario, $descripcion, $monto, $fechaAprobacion, $fechaSalida, $fechaRegreso, $uso);
            
            if ($request > 0) {
                echo json_encode(['status' => true, 'msg' => 'Viático asignado correctamente']);
            } else if ($request == "exist") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario ya tiene un viático asignado para esta fecha']);
            } else if ($request == "nofunc") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario seleccionado no existe o no está activo']);
            } else if ($request == "nocapital") {
                echo json_encode(['status' => false, 'msg' => 'El monto excede el capital disponible para viáticos']);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al asignar viático']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        die();
    }

    public function setPresupuestoAnual()
    {
        header('Content-Type: application/json');
        
        if (!$_POST || empty($_SESSION['permisosMod']['w'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para realizar esta acción']);
            die();
        }
        
        try {
            $anio = intval($_POST['anio']);
            $capitalTotal = floatval($_POST['capitalTotal']);

            if ($anio <= 0) {
                throw new Exception("Año inválido");
            }
            
            if ($capitalTotal <= 0) {
                throw new Exception("Capital total debe ser mayor que cero");
            }

            $request = $this->model->setPresupuestoAnual($anio, $capitalTotal);
            if ($request > 0) {
                echo json_encode(['status' => true, 'msg' => 'Presupuesto anual guardado correctamente']);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al guardar presupuesto anual']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        die();
    }

    public function generarReporteViatico($idViatico)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }

        $viatico = $this->model->getViatico($idViatico);
        if (empty($viatico)) {
            header("Location:" . base_url() . '/FuncionariosViaticos');
            exit();
        }

        // Generar HTML directamente
        $html = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reporte de Viático</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #333; text-align: center; margin-bottom: 20px; }
                .report-container { max-width: 800px; margin: 0 auto; }
                .report-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                .report-table td { padding: 8px; }
                .label { font-weight: bold; width: 30%; }
                .value { width: 70%; }
                .signatures { margin-top: 50px; width: 100%; }
                .signature { width: 45%; display: inline-block; text-align: center; }
                .signature-line { border-top: 1px solid black; margin-bottom: 5px; width: 80%; display: inline-block; }
                .btn-container { text-align: right; margin: 20px 0; }
                .btn { padding: 8px 15px; margin-left: 10px; cursor: pointer; border: none; border-radius: 4px; color: white; }
                .btn-print { background-color: #4CAF50; }
                .btn-back { background-color: #f44336; }
                @media print {
                    .btn-container { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="report-container">
                <div class="btn-container">
                    <button class="btn btn-print" onclick="window.print()">Imprimir</button>
                    <button class="btn btn-back" onclick="window.history.back()">Volver</button>
                </div>
                
                <h1>REPORTE DE VIÁTICO</h1>
                <p style="text-align: center;">Fecha de generación: ' . date('d/m/Y') . '</p>
                
                <table class="report-table">
                    <tr>
                        <td class="label">Funcionario:</td>
                        <td class="value">' . $viatico['nombre_completo'] . '</td>
                    </tr>
                    <tr>
                        <td class="label">Descripción:</td>
                        <td class="value">' . $viatico['descripcion'] . '</td>
                    </tr>
                    <tr>
                        <td class="label">Monto:</td>
                        <td class="value">$' . number_format($viatico['monto'], 2, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td class="label">Fecha de Aprobación:</td>
                        <td class="value">' . date('d/m/Y', strtotime($viatico['fecha_aprobacion'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Fecha de Salida:</td>
                        <td class="value">' . date('d/m/Y', strtotime($viatico['fecha_salida'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Fecha de Regreso:</td>
                        <td class="value">' . date('d/m/Y', strtotime($viatico['fecha_regreso'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Uso:</td>
                        <td class="value">' . $viatico['uso'] . '</td>
                    </tr>
                    <tr>
                        <td class="label">Estado:</td>
                        <td class="value">' . (($viatico['estatus'] == 1) ? 'Activo' : 'Eliminado') . '</td>
                    </tr>
                </table>
                
                <div class="signatures">
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>Firma del Funcionario</div>
                    </div>
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>Firma del Jefe de Talento Humano</div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        echo $html;
        exit;
    }

    public function generarReporteAnual($year = null)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        // Obtener datos
        $viaticos = $this->model->getAllViaticos($year);
        $presupuesto = $this->model->getPresupuestoInfo($year);
        
        // Calcular totales
        $totalActivos = 0;
        $totalEliminados = 0;
        foreach ($viaticos as $viatico) {
            if ($viatico['estatus'] == 1) {
                $totalActivos += $viatico['monto'];
            } else {
                $totalEliminados += $viatico['monto'];
            }
        }

        try {
            ob_clean(); // Limpiar cualquier salida anterior
            
            // Crear instancia de FPDI
            $pdf = new Fpdi();
            
            // Agregar la plantilla
            $template = dirname(__DIR__) . '/Assets/plantillas/plantilla_historial_permiso.pdf';
            $pageCount = $pdf->setSourceFile($template);
            $tplIdx = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx);

            // Configurar fuente
            $pdf->SetFont('Helvetica', 'B', 12);
            
            // Título del reporte
            $pdf->SetXY(60, 20);
            $pdf->Cell(0, 10, 'REPORTE ANUAL DE VIATICOS ' . $year, 0, 1, 'L');
            
            // Fecha de generación
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(60, 30);
            $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y'), 0, 1, 'L');
            
            // Información del Presupuesto
            $pdf->SetXY(20, 50);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->Cell(0, 10, 'INFORMACION DEL PRESUPUESTO', 0, 1, 'L');
            
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(20, 60);
            $pdf->Cell(80, 8, 'Capital Total:', 1, 0, 'L');
            $pdf->Cell(80, 8, '$' . number_format($presupuesto['capital_total'], 2, ',', '.'), 1, 1, 'R');
            
            $pdf->SetXY(20, 68);
            $pdf->Cell(80, 8, 'Capital Disponible:', 1, 0, 'L');
            $pdf->Cell(80, 8, '$' . number_format($presupuesto['capital_disponible'], 2, ',', '.'), 1, 1, 'R');
            
            $pdf->SetXY(20, 76);
            $pdf->Cell(80, 8, 'Capital Utilizado:', 1, 0, 'L');
            $pdf->Cell(80, 8, '$' . number_format($presupuesto['capital_total'] - $presupuesto['capital_disponible'], 2, ',', '.'), 1, 1, 'R');
            
            // Listado de Viáticos
            $pdf->SetXY(20, 95);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->Cell(0, 10, 'LISTADO DE VIATICOS', 0, 1, 'L');
            
            // Encabezados de la tabla
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetXY(20, 105);
            $pdf->Cell(10, 8, '#', 1, 0, 'C');
            $pdf->Cell(50, 8, 'Funcionario', 1, 0, 'C');
            $pdf->Cell(25, 8, 'Monto', 1, 0, 'C');
            $pdf->Cell(25, 8, 'F. Aprobacion', 1, 0, 'C');
            $pdf->Cell(25, 8, 'F. Salida', 1, 0, 'C');
            $pdf->Cell(25, 8, 'F. Regreso', 1, 0, 'C');
            $pdf->Cell(20, 8, 'Estado', 1, 1, 'C');
            
            // Contenido de la tabla
            $pdf->SetFont('Helvetica', '', 8);
            $y = 113;
            $contador = 1;
            
            foreach ($viaticos as $viatico) {
                // Si queda poco espacio en la página, agregar una nueva
                if ($y > 250) {
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx);
                    $y = 20;
                    
                    // Repetir encabezados de la tabla
                    $pdf->SetFont('Helvetica', 'B', 8);
                    $pdf->SetXY(20, $y);
                    $pdf->Cell(10, 8, '#', 1, 0, 'C');
                    $pdf->Cell(50, 8, 'Funcionario', 1, 0, 'C');
                    $pdf->Cell(25, 8, 'Monto', 1, 0, 'C');
                    $pdf->Cell(25, 8, 'F. Aprobacion', 1, 0, 'C');
                    $pdf->Cell(25, 8, 'F. Salida', 1, 0, 'C');
                    $pdf->Cell(25, 8, 'F. Regreso', 1, 0, 'C');
                    $pdf->Cell(20, 8, 'Estado', 1, 1, 'C');
                    $y += 8;
                }
                
                $pdf->SetXY(20, $y);
                $pdf->Cell(10, 8, $contador, 1, 0, 'C');
                $pdf->Cell(50, 8, $viatico['nombre_completo'], 1, 0, 'L');
                $pdf->Cell(25, 8, '$' . number_format($viatico['monto'], 2, ',', '.'), 1, 0, 'R');
                $pdf->Cell(25, 8, date('d/m/Y', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
                $pdf->Cell(25, 8, date('d/m/Y', strtotime($viatico['fecha_salida'])), 1, 0, 'C');
                $pdf->Cell(25, 8, date('d/m/Y', strtotime($viatico['fecha_regreso'])), 1, 0, 'C');
                $pdf->Cell(20, 8, ($viatico['estatus'] == 1 ? 'Activo' : 'Eliminado'), 1, 1, 'C');
                
                $y += 8;
                $contador++;
            }
            
            // Resumen de Viáticos
            $y += 10;
            $pdf->SetXY(20, $y);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->Cell(0, 10, 'RESUMEN DE VIATICOS', 0, 1, 'L');
            
            $pdf->SetFont('Helvetica', '', 10);
            $y += 10;
            $pdf->SetXY(20, $y);
            $pdf->Cell(80, 8, 'Total Viaticos Activos:', 1, 0, 'L');
            $pdf->Cell(80, 8, '$' . number_format($totalActivos, 2, ',', '.'), 1, 1, 'R');
            
            $pdf->SetXY(20, $y + 8);
            $pdf->Cell(80, 8, 'Total Viaticos Eliminados:', 1, 0, 'L');
            $pdf->Cell(80, 8, '$' . number_format($totalEliminados, 2, ',', '.'), 1, 1, 'R');

            // Generar el PDF
            $pdf->Output('I', 'Reporte_Viaticos_' . $year . '.pdf');
        } catch (Exception $e) {
            ob_clean(); // Limpiar el buffer
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        exit();
    }
}