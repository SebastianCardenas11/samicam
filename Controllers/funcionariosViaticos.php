<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use setasign\Fpdi\Fpdi;

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
            $idFuncionario = intval($_POST['funci_fk']);
            $cargo = strClean($_POST['cargo']);
            $dependencia = strClean($_POST['dependencia']);
            $motivo_gasto = strClean($_POST['motivo_gasto']);
            $lugar_comision_departamento = strClean($_POST['lugar_comision_departamento']);
            $lugar_comision_ciudad = strClean($_POST['lugar_comision_ciudad']);
            $finalidad_comision = strClean($_POST['finalidad_comision']);
            $descripcion = strClean($_POST['descripcion']);
            $fecha_aprobacion = strClean($_POST['fecha_aprobacion']);
            $fecha_salida = strClean($_POST['fecha_salida']);
            $fecha_regreso = strClean($_POST['fecha_regreso']);
            $n_dias = intval($_POST['n_dias']);
            $valor_dia = floatval($_POST['valor_dia']);
            $valor_viatico = floatval($_POST['valor_viatico']);
            $tipo_transporte = strClean($_POST['tipo_transporte']);
            $valor_transporte = floatval($_POST['valor_transporte']);
            $total_liquidado = floatval($_POST['total_liquidado']);

            // Validaciones básicas (puedes agregar más según reglas de negocio)
            if ($idFuncionario <= 0 || empty($cargo) || empty($dependencia) || empty($motivo_gasto) || empty($lugar_comision_departamento) || empty($lugar_comision_ciudad) || empty($finalidad_comision) || empty($descripcion) || empty($fecha_aprobacion) || empty($fecha_salida) || empty($fecha_regreso) || $n_dias <= 0 || $valor_dia <= 0 || $valor_viatico <= 0 || empty($tipo_transporte) || $valor_transporte < 0 || $total_liquidado < 0) {
                echo json_encode(['status' => false, 'msg' => 'Todos los campos son obligatorios y deben ser válidos.']);
                die();
            }

            $request = $this->model->insertViatico(
                $idFuncionario,
                $cargo,
                $dependencia,
                $motivo_gasto,
                $lugar_comision_departamento,
                $lugar_comision_ciudad,
                $finalidad_comision,
                $descripcion,
                $fecha_aprobacion,
                $fecha_salida,
                $fecha_regreso,
                $n_dias,
                $valor_dia,
                $valor_viatico,
                $tipo_transporte,
                $valor_transporte,
                $total_liquidado
            );
            if ($request > 0) {
                // Descontar el valor del viático del capital disponible
                $anio = intval(date('Y', strtotime($fecha_aprobacion)));
                $capitalDisponibleActual = $this->model->getCapitalDisponible($anio);
                $nuevoCapital = $capitalDisponibleActual - $total_liquidado;
                if ($nuevoCapital < 0) $nuevoCapital = 0;
                $this->model->actualizarCapitalDisponible($anio, $nuevoCapital);
                echo json_encode(['status' => true, 'msg' => 'Viático asignado correctamente']);
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
        try {
            // Limpiar cualquier salida previa
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Obtener datos del viático
            $viatico = $this->model->getViatico($idViatico);
            if (empty($viatico)) {
                throw new Exception('No se encontró el viático especificado.');
            }

            // Verificar que los campos requeridos existan
            $camposRequeridos = ['cargo', 'dependencia', 'nombre_completo', 'fecha_salida', 'fecha_regreso', 'uso', 'descripcion', 'monto'];
            foreach ($camposRequeridos as $campo) {
                if (!isset($viatico[$campo]) || empty($viatico[$campo])) {
                    $viatico[$campo] = 'No especificado';
                }
            }

            // Crear PDF usando FPDI
            $pdf = new Fpdi();
            
            // Agregar la plantilla
            $template = dirname(__DIR__) . '/Assets/plantillas/plantilla_viaticos.pdf';
            $pageCount = $pdf->setSourceFile($template);
            $tplIdx = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx);

            // Configuración inicial
            $pdf->SetMargins(20, 20, 20);
            $pdf->SetFont('Helvetica', 'B', 14);

            // Título
            $pdf->SetXY(20, 20);
            $pdf->Cell(170, 10, mb_convert_encoding('ALCALDÍA DE LA JAGUA DE IBIRICO', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
            $pdf->SetXY(20, 30);
            $pdf->Cell(170, 10, mb_convert_encoding('SOLICITUD DE LIQUIDACIÓN DE VIÁTICOS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

            // Fecha y Hora
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(20, 45);
            $pdf->Cell(30, 6, mb_convert_encoding('Fecha', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(15, 6, date('d', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
            $pdf->Cell(15, 6, date('m', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
            $pdf->Cell(20, 6, date('Y', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
            $pdf->Cell(20, 6, mb_convert_encoding('Hora', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(30, 6, date('H:i'), 1, 1, 'C');

            // Datos del empleado
            $pdf->SetXY(20, 55);
            $pdf->Cell(50, 6, mb_convert_encoding('Nombre del empleado:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(120, 6, mb_convert_encoding($viatico['nombre_completo'], 'ISO-8859-1', 'UTF-8'), 1, 1);

            $pdf->SetXY(20, 61);
            $pdf->Cell(50, 6, mb_convert_encoding('Cargo:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(120, 6, mb_convert_encoding($viatico['cargo'], 'ISO-8859-1', 'UTF-8'), 1, 1);

            $pdf->SetXY(20, 67);
            $pdf->Cell(50, 6, mb_convert_encoding('Dependencia:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(120, 6, mb_convert_encoding($viatico['dependencia'], 'ISO-8859-1', 'UTF-8'), 1, 1);

            // Detalles de la comisión
            $pdf->SetXY(20, 77);
            $pdf->Cell(50, 6, mb_convert_encoding('Motivo del gasto:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(120, 6, mb_convert_encoding('VIÁTICOS', 'ISO-8859-1', 'UTF-8'), 1, 1);

            $pdf->SetXY(20, 83);
            $pdf->Cell(50, 6, mb_convert_encoding('Desde:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(50, 6, date('d/m/Y', strtotime($viatico['fecha_salida'])), 1, 0, 'C');
            $pdf->Cell(20, 6, mb_convert_encoding('Hasta:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(50, 6, date('d/m/Y', strtotime($viatico['fecha_regreso'])), 1, 1, 'C');

            $pdf->SetXY(20, 89);
            $pdf->Cell(50, 6, mb_convert_encoding('Lugar comisión:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(120, 6, mb_convert_encoding($viatico['uso'], 'ISO-8859-1', 'UTF-8'), 1, 1);

            $pdf->SetXY(20, 95);
            $pdf->Cell(50, 6, mb_convert_encoding('Finalidad:', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->MultiCell(120, 6, mb_convert_encoding($viatico['descripcion'], 'ISO-8859-1', 'UTF-8'), 1);

            // Liquidación de viáticos
            $pdf->SetXY(20, 107);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Cell(170, 6, mb_convert_encoding('LIQUIDACIÓN DE VIÁTICOS', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

            // Calcular días
            $fecha1 = new DateTime($viatico['fecha_salida']);
            $fecha2 = new DateTime($viatico['fecha_regreso']);
            $diff = $fecha1->diff($fecha2);
            $dias = $diff->days + 1;
            $valorDia = $viatico['monto'] / $dias;

            // Tabla de liquidación
            $pdf->SetXY(20, 113);
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->Cell(40, 6, mb_convert_encoding('Concepto', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(20, 6, mb_convert_encoding('Días', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(55, 6, mb_convert_encoding('Valor día', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(55, 6, 'Total', 1, 1, 'C');

            $pdf->SetXY(20, 119);
            $pdf->Cell(40, 6, mb_convert_encoding('Viáticos', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(20, 6, $dias, 1, 0, 'C');
            $pdf->Cell(55, 6, '$ ' . number_format($valorDia, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(55, 6, '$ ' . number_format($viatico['monto'], 2, ',', '.'), 1, 1, 'R');

            // Transporte
            $pdf->SetXY(20, 129);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Cell(170, 6, mb_convert_encoding('TRANSPORTE', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(20, 135);
            $pdf->Cell(40, 6, 'Tipo', 1, 0);
            $pdf->Cell(45, 6, mb_convert_encoding('Desde', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(45, 6, mb_convert_encoding('Hasta', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(40, 6, 'Valor', 1, 1);

            $pdf->SetXY(20, 141);
            $pdf->Cell(40, 6, 'Interno', 1, 0);
            $pdf->Cell(45, 6, mb_convert_encoding($viatico['uso'], 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(45, 6, mb_convert_encoding($viatico['uso'], 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(40, 6, '$ 0,00', 1, 1, 'R');

            $pdf->SetXY(20, 147);
            $pdf->Cell(40, 6, mb_convert_encoding('Aéreo', 'ISO-8859-1', 'UTF-8'), 1, 0);
            $pdf->Cell(45, 6, 'N/A', 1, 0);
            $pdf->Cell(45, 6, 'N/A', 1, 0);
            $pdf->Cell(40, 6, '$ 0,00', 1, 1, 'R');

            // Total general
            $pdf->SetXY(20, 157);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Cell(130, 6, mb_convert_encoding('TOTAL VALOR VIÁTICOS', 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
            $pdf->Cell(40, 6, '$ ' . number_format($viatico['monto'], 2, ',', '.'), 1, 1, 'R');

            // Firmas
            $pdf->SetY(180);
            $pdf->Cell(85, 6, mb_convert_encoding('Alcalde Municipal', 'ISO-8859-1', 'UTF-8'), 'T', 0, 'C');
            $pdf->Cell(85, 6, mb_convert_encoding('Firma del Empleado', 'ISO-8859-1', 'UTF-8'), 'T', 1, 'C');

            $pdf->SetY(200);
            $pdf->Cell(56, 6, mb_convert_encoding('Jefe Inmediato', 'ISO-8859-1', 'UTF-8'), 'T', 0, 'C');
            $pdf->Cell(57, 6, mb_convert_encoding('Talento Humano', 'ISO-8859-1', 'UTF-8'), 'T', 0, 'C');
            $pdf->Cell(57, 6, date('d/m/Y', strtotime($viatico['fecha_aprobacion'])), 'T', 1, 'C');

            // Configurar headers para la descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Liquidacion_Viatico_' . str_pad($idViatico, 4, '0', STR_PAD_LEFT) . '.pdf"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Generar y enviar el PDF
            $pdf->Output('D', 'Liquidacion_Viatico_' . str_pad($idViatico, 4, '0', STR_PAD_LEFT) . '.pdf');
            exit();

        } catch (Exception $e) {
            // Asegurarse de que no haya salida previa
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            exit();
        }
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
            $nombreArchivo = 'Reporte_Viaticos_' . $year . '.pdf';
            $pdf->Output('D', $nombreArchivo); // 'D' fuerza la descarga del archivo
        } catch (Exception $e) {
            ob_clean(); // Limpiar el buffer
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        exit();
    }

    // API: Viáticos entregados por mes
    public function getViaticosPorMes($year = null) {
        header('Content-Type: application/json');
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        $year = intval($year);
        if ($year <= 0) $year = date('Y');
        $data = $this->model->getViaticosPorMes($year);
        echo json_encode($data);
        die();
    }

    // API: Capital total y disponible por mes
    public function getCapitalPorMes($year = null) {
        header('Content-Type: application/json');
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        $year = intval($year);
        if ($year <= 0) $year = date('Y');
        $data = $this->model->getCapitalPorMes($year);
        echo json_encode($data);
        die();
    }

    // API: Top ciudades de comisión
    public function getTopCiudadesComision($year = null) {
        header('Content-Type: application/json');
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        $year = intval($year);
        if ($year <= 0) $year = date('Y');
        $data = $this->model->getTopCiudadesComision($year, 10);
        echo json_encode($data);
        die();
    }
}