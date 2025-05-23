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
        
        echo json_encode([
            [
                'idefuncionario' => 9,
                'nombre_completo' => 'Carlos Lopez',
                'tipo_cont' => 'Libre Nombramiento'
            ]
        ]);
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
            if ($fechaSalida < $fechaActual) {
                echo json_encode(['status' => false, 'msg' => 'La fecha de salida no puede ser anterior a la fecha actual']);
                die();
            }
            
            // Validar que la fecha de regreso sea posterior a la fecha de salida
            if ($fechaRegreso < $fechaSalida) {
                echo json_encode(['status' => false, 'msg' => 'La fecha de regreso debe ser posterior a la fecha de salida']);
                die();
            }

            // Verificar si hay suficiente capital disponible
            $year = date('Y', strtotime($fechaAprobacion));
            $capitalDisponible = $this->model->getCapitalDisponible($year);
            
            if ($monto > $capitalDisponible) {
                echo json_encode(['status' => false, 'msg' => 'El monto excede el capital disponible para viáticos']);
                die();
            }
            
            $request = $this->model->insertViatico($idFuncionario, $descripcion, $monto, $fechaAprobacion, $fechaSalida, $fechaRegreso, $uso);
            
            if ($request > 0) {
                // Actualizar el capital disponible
                $this->actualizarCapitalDisponible($year, $monto);
                echo json_encode(['status' => true, 'msg' => 'Viático asignado correctamente']);
            } else if ($request == "exist") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario ya tiene un viático asignado para esta fecha']);
            } else if ($request == "nofunc") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario seleccionado no existe o no está activo']);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al asignar viático']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        die();
    }

    private function actualizarCapitalDisponible($year, $monto)
    {
        $capitalActual = $this->model->getCapitalDisponible($year);
        $nuevoCapital = $capitalActual - $monto;
        $this->model->actualizarCapitalDisponible($year, $nuevoCapital);
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
        $pdf->SetMargins(15, 15, 15);
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
        
        // Crear PDF
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle('Reporte Anual de Viáticos ' . $year);
        
        // Encabezado
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'REPORTE ANUAL DE VIÁTICOS ' . $year, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generación: ' . date('d/m/Y'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Información del presupuesto
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Información del Presupuesto', 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(60, 8, 'Capital Total:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, '$' . number_format($presupuesto['capital_total'], 2, ',', '.'), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(60, 8, 'Capital Disponible:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, '$' . number_format($presupuesto['capital_disponible'], 2, ',', '.'), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(60, 8, 'Capital Utilizado:', 0, 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, '$' . number_format($presupuesto['capital_total'] - $presupuesto['capital_disponible'], 2, ',', '.'), 0, 1);
        $pdf->Ln(5);
        
        // Tabla de viáticos
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Listado de Viáticos', 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 7, '#', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Funcionario', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Monto', 1, 0, 'C');
        $pdf->Cell(25, 7, 'F. Aprobación', 1, 0, 'C');
        $pdf->Cell(25, 7, 'F. Salida', 1, 0, 'C');
        $pdf->Cell(25, 7, 'F. Regreso', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Estado', 1, 1, 'C');
        
        $pdf->SetFont('Arial', '', 8);
        $contador = 1;
        $totalActivos = 0;
        $totalEliminados = 0;
        
        foreach ($viaticos as $viatico) {
            $pdf->Cell(10, 6, $contador, 1, 0, 'C');
            $pdf->Cell(40, 6, substr($viatico['nombre_completo'], 0, 20), 1, 0, 'L');
            $pdf->Cell(25, 6, '$' . number_format($viatico['monto'], 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($viatico['fecha_salida'])), 1, 0, 'C');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($viatico['fecha_regreso'])), 1, 0, 'C');
            
            if ($viatico['estatus'] == 1) {
                $pdf->Cell(40, 6, 'Activo', 1, 1, 'C');
                $totalActivos += $viatico['monto'];
            } else {
                $pdf->Cell(40, 6, 'Eliminado', 1, 1, 'C');
                $totalEliminados += $viatico['monto'];
            }
            
            $contador++;
        }
        
        // Resumen
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, 'Resumen de Viáticos', 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 7, 'Total Viáticos Activos:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 7, '$' . number_format($totalActivos, 2, ',', '.'), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 7, 'Total Viáticos Eliminados:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 7, '$' . number_format($totalEliminados, 2, ',', '.'), 0, 1);
        
        $pdf->Output('Reporte_Viaticos_' . $year . '.pdf', 'I');
    }
}