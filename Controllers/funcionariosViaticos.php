<?php

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
            echo json_encode([]);
            die();
        }
        
        try {
            $funcionarios = $this->model->getFuncionariosValidos();
            echo json_encode($funcionarios, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
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

        // Crear PDF
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetTitle('Reporte de Viático');
        
        // Encabezado
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'REPORTE DE VIÁTICO', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generación: ' . date('d/m/Y'), 0, 1, 'C');
        $pdf->Ln(10);
        
        // Datos del viático
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Funcionario:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, $viatico['nombre_completo'], 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Descripción:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, $viatico['descripcion'], 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Monto:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, '$' . number_format($viatico['monto'], 2, ',', '.'), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Fecha de Aprobación:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, date('d/m/Y', strtotime($viatico['fecha_aprobacion'])), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Fecha de Salida:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, date('d/m/Y', strtotime($viatico['fecha_salida'])), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Fecha de Regreso:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, date('d/m/Y', strtotime($viatico['fecha_regreso'])), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Uso:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(0, 8, $viatico['uso'], 0, 'L');
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(50, 8, 'Estado:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, ($viatico['estatus'] == 1) ? 'Activo' : 'Eliminado', 0, 1);
        
        // Firmas
        $pdf->Ln(20);
        $pdf->Cell(90, 10, '___________________________', 0, 0, 'C');
        $pdf->Cell(90, 10, '___________________________', 0, 1, 'C');
        $pdf->Cell(90, 5, 'Firma del Funcionario', 0, 0, 'C');
        $pdf->Cell(90, 5, 'Firma del Responsable', 0, 1, 'C');
        
        $pdf->Output('Viatico_' . $idViatico . '.pdf', 'I');
    }

    public function generarReporteAnual($year = null)
    {
        // Redireccionar a una página HTML simple con los datos
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
        
        // Generar HTML directamente
        $html = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reporte Anual de Viáticos ' . $year . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1, h2 { color: #333; }
                table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .total { font-weight: bold; }
                @media print {
                    button { display: none; }
                }
            </style>
        </head>
        <body>
            <button onclick="window.print()">Imprimir Reporte</button>
            <button onclick="window.location.href=\'' . base_url() . '/funcionariosViaticos\'">Volver</button>
            
            <h1>Reporte Anual de Viáticos ' . $year . '</h1>
            <p>Fecha de generación: ' . date('d/m/Y') . '</p>
            
            <h2>Información del Presupuesto</h2>
            <table>
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                </tr>
                <tr>
                    <td>Capital Total</td>
                    <td>$' . number_format($presupuesto['capital_total'], 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td>Capital Disponible</td>
                    <td>$' . number_format($presupuesto['capital_disponible'], 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td>Capital Utilizado</td>
                    <td>$' . number_format($presupuesto['capital_total'] - $presupuesto['capital_disponible'], 2, ',', '.') . '</td>
                </tr>
            </table>
            
            <h2>Listado de Viáticos</h2>
            <table>
                <tr>
                    <th>#</th>
                    <th>Funcionario</th>
                    <th>Monto</th>
                    <th>F. Aprobación</th>
                    <th>F. Salida</th>
                    <th>F. Regreso</th>
                    <th>Estado</th>
                </tr>';
        
        $contador = 1;
        foreach ($viaticos as $viatico) {
            $html .= '<tr>
                <td>' . $contador . '</td>
                <td>' . $viatico['nombre_completo'] . '</td>
                <td>$' . number_format($viatico['monto'], 2, ',', '.') . '</td>
                <td>' . date('d/m/Y', strtotime($viatico['fecha_aprobacion'])) . '</td>
                <td>' . date('d/m/Y', strtotime($viatico['fecha_salida'])) . '</td>
                <td>' . date('d/m/Y', strtotime($viatico['fecha_regreso'])) . '</td>
                <td>' . ($viatico['estatus'] == 1 ? 'Activo' : 'Eliminado') . '</td>
            </tr>';
            $contador++;
        }
        
        $html .= '</table>
            
            <h2>Resumen de Viáticos</h2>
            <table>
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                </tr>
                <tr>
                    <td>Total Viáticos Activos</td>
                    <td>$' . number_format($totalActivos, 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td>Total Viáticos Eliminados</td>
                    <td>$' . number_format($totalEliminados, 2, ',', '.') . '</td>
                </tr>
            </table>
        </body>
        </html>';
        
        echo $html;
        exit;
    }
}