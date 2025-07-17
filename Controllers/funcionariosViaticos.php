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
            $lugar_comision_departamento = strClean($_POST['lugar_comision_departamento_nombre'] ?? $_POST['lugar_comision_departamento'] ?? '');
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
                // Ya no se descuenta manualmente el capital disponible
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
            if (ob_get_level()) {
                ob_end_clean();
            }
            $viatico = $this->model->getViatico($idViatico);
            if (empty($viatico)) {
                throw new Exception('No se encontró el viático especificado.');
            }
            // --- Variables y helpers ---
            $fecha_aprobacion = $viatico['fecha_aprobacion'] ?? '';
            $fecha_salida = $viatico['fecha_salida'] ?? '';
            $fecha_regreso = $viatico['fecha_regreso'] ?? '';
            $fecha = $fecha_aprobacion ? date('d/m/Y', strtotime($fecha_aprobacion)) : '';
            $nombre_empleado = $viatico['nombre_completo'] ?? '';
            $cargo = $viatico['cargo'] ?? '';
            $dependencia = $viatico['dependencia'] ?? '';
            $motivo = $viatico['motivo_gasto'] ?? '';
            $lugar = ($viatico['lugar_comision_departamento'] ?? '') . ' - ' . ($viatico['lugar_comision_ciudad'] ?? '');
            $finalidad = $viatico['finalidad_comision'] ?? '';
            $dias_liquidar = $fecha_salida ? date('d/m/Y', strtotime($fecha_salida)) : '';
            $n_dias = $viatico['n_dias'] ?? '';
            $valor_dia = number_format($viatico['valor_dia'] ?? 0, 0, ',', '.');
            $valor_liquidado = number_format($viatico['valor_viatico'] ?? 0, 0, ',', '.');
            $tipo_transporte = strtolower($viatico['tipo_transporte'] ?? '');
            $valor_transporte = number_format($viatico['valor_transporte'] ?? 0, 0, ',', '.');
            $total_viaticos = number_format($viatico['total_liquidado'] ?? 0, 0, ',', '.');
            $alcalde = 'LEONARDO FABIO HERNÁNDEZ CATAÑO';
            // Helpers
            $toLatin1 = function($text) { return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text); };
            $formatoPesos = function($valor) { return '$ ' . number_format(floatval($valor), 2, ',', '.'); };
            // --- PDF ---
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile(dirname(__DIR__) . '/Assets/plantillas/Plantillapdfalcaldia.pdf');
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 210);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0,0,0);
            // --- INICIO DE LA CUADRÍCULA ---
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetDrawColor(0,0,0);
            $startX = 14; $startY = 50; $h = 6;
            $w1 = 46; $w2 = 35; $w3 = 35; $w4 = 35; $w5 = 35;
            // Encabezado
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(0, 38);
            $pdf->Cell(210, 8, $toLatin1('SOLICITUD DE LIQUIDACION DE VIATICOS'), 0, 1, 'C');
            // Bloque: Informe de la liquidación
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY($startX, $startY);
            $pdf->Cell(186, $h, $toLatin1('Informe de la liquidación'), 1, 1, 'C');
            // Fila 1: Fecha y hora
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetX($startX);
            $pdf->Cell(18, $h, $toLatin1('Fecha'), 1, 0, 'C');
            $pdf->Cell(18, $h, $toLatin1('Día'), 1, 0, 'C');
            $pdf->Cell(18, $h, $toLatin1('Mes'), 1, 0, 'C');
            $pdf->Cell(18, $h, $toLatin1('Año'), 1, 0, 'C');
            $pdf->Cell(18, $h, $toLatin1('Hora'), 1, 0, 'C');
            $pdf->Cell(96, $h, date('h:i a', strtotime($viatico['fecha_creacion'])), 1, 1, 'C');
            $pdf->SetX($startX+18);
            $pdf->Cell(18, $h, date('d', strtotime($viatico['fecha_creacion'])), 1, 0, 'C');
            $pdf->Cell(18, $h, date('m', strtotime($viatico['fecha_creacion'])), 1, 0, 'C');
            $pdf->Cell(18, $h, date('Y', strtotime($viatico['fecha_creacion'])), 1, 1, 'C');
            // Fila 2: Nombre del empleado
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(40, $h, $toLatin1('Nombre del empleado:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(146, $h, $toLatin1($viatico['nombre_completo']), 1, 1, 'L');
            $pdf->SetFont('Arial', '', 9);
            // Fila 3: Cargo y Dependencia
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, $h, $toLatin1('Cargo:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(60, $h, $toLatin1($viatico['cargo']), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(30, $h, $toLatin1('Dependencia:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(76, $h, $toLatin1($viatico['dependencia']), 1, 1, 'L');
            // Fila 4: Motivo, Desde, Hasta
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(30, $h, $toLatin1('Motivo del gasto:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(50, $h, $toLatin1($viatico['motivo_gasto']), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, $h, $toLatin1('Desde:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(30, $h, $toLatin1($viatico['fecha_salida']), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(15, $h, $toLatin1('Hasta:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(41, $h, $toLatin1($viatico['fecha_regreso']), 1, 1, 'L');
            $pdf->SetFont('Arial', '', 9);
            // Fila 5: Lugar a cumplir la comisión
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(50, $h, $toLatin1('Lugar a cumplir la comisión:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(136, $h, $toLatin1($viatico['lugar_comision_departamento'] . ', ' . $viatico['lugar_comision_ciudad']), 1, 1, 'L');
            $pdf->SetFont('Arial', '', 9);
            // Fila 6: Finalidad de la comisión
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(50, $h, $toLatin1('Finalidad de la comisión:'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(136, $h, $toLatin1($viatico['finalidad_comision']), 1, 1, 'L');
            $pdf->SetFont('Arial', '', 9);
            // Bloque: Liquidación de viáticos
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, $h, $toLatin1('Liquidación de viáticos'), 1, 1, 'C');
            // Encabezado viáticos
            $pdf->SetX($startX);
            $pdf->Cell($w1, $h, $toLatin1('Viáticos'), 1, 0, 'C');
            $pdf->Cell($w2, $h, $toLatin1('N° de días'), 1, 0, 'C');
            $pdf->Cell($w3, $h, $toLatin1('Valor del día'), 1, 0, 'C');
            $pdf->Cell($w4, $h, $toLatin1('Valor total liquidado'), 1, 1, 'C');
            // Datos viáticos
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell($w1, $h, '', 1, 0, 'C');
            $pdf->Cell($w2, $h, $toLatin1($viatico['n_dias']), 1, 0, 'C');
            $pdf->Cell($w3, $h, $toLatin1($formatoPesos($viatico['valor_dia'])), 1, 0, 'C');
            $pdf->Cell($w4, $h, $toLatin1($formatoPesos($viatico['valor_viatico'])), 1, 1, 'C');
            // Encabezado transporte
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($w1, $h, $toLatin1('Transporte'), 1, 0, 'C');
            $pdf->Cell($w2, $h, $toLatin1('Interno'), 1, 0, 'C');
            $pdf->Cell($w3, $h, $toLatin1('Desde'), 1, 0, 'C');
            $pdf->Cell($w4, $h, $toLatin1('Hasta'), 1, 0, 'C');
            $pdf->Cell($w5, $h, $toLatin1('Valor'), 1, 1, 'C');
            // Datos transporte interno
            $tipo = strtolower(trim($viatico['tipo_transporte']));
            if ($tipo == 'interno') {
                $pdf->SetX($startX);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell($w1, $h, '', 1, 0, 'C');
                $pdf->Cell($w2, $h, '[X]', 1, 0, 'C');
                $pdf->Cell($w3, $h, $toLatin1($viatico['fecha_salida']), 1, 0, 'C');
                $pdf->Cell($w4, $h, $toLatin1($viatico['fecha_regreso']), 1, 0, 'C');
                $pdf->Cell($w5, $h, $toLatin1($formatoPesos($viatico['valor_transporte'])), 1, 1, 'C');
            } else {
                $pdf->SetX($startX);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell($w1, $h, '', 1, 0, 'C');
                $pdf->Cell($w2, $h, '', 1, 0, 'C');
                $pdf->Cell($w3, $h, '', 1, 0, 'C');
                $pdf->Cell($w4, $h, '', 1, 0, 'C');
                $pdf->Cell($w5, $h, '', 1, 1, 'C');
            }
            // Encabezado transporte aéreo
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($w1, $h, $toLatin1('Transporte'), 1, 0, 'C');
            $pdf->Cell($w2, $h, $toLatin1('Aéreo'), 1, 0, 'C');
            $pdf->Cell($w3, $h, $toLatin1('Desde'), 1, 0, 'C');
            $pdf->Cell($w4, $h, $toLatin1('Hasta'), 1, 0, 'C');
            $pdf->Cell($w5, $h, $toLatin1('Valor'), 1, 1, 'C');
            // Datos transporte aéreo
            if ($tipo == 'aéreo' || $tipo == 'aereo') {
                $pdf->SetX($startX);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell($w1, $h, '', 1, 0, 'C');
                $pdf->Cell($w2, $h, '[X]', 1, 0, 'C');
                $pdf->Cell($w3, $h, $toLatin1($viatico['fecha_salida']), 1, 0, 'C');
                $pdf->Cell($w4, $h, $toLatin1($viatico['fecha_regreso']), 1, 0, 'C');
                $pdf->Cell($w5, $h, $toLatin1($formatoPesos($viatico['valor_transporte'])), 1, 1, 'C');
            } else {
                $pdf->SetX($startX);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell($w1, $h, '', 1, 0, 'C');
                $pdf->Cell($w2, $h, '', 1, 0, 'C');
                $pdf->Cell($w3, $h, '', 1, 0, 'C');
                $pdf->Cell($w4, $h, '', 1, 0, 'C');
                $pdf->Cell($w5, $h, '', 1, 1, 'C');
            }
            // Total valor viáticos
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($w1+$w2+$w3+$w4, $h, $toLatin1('Total, valor viáticos'), 1, 0, 'R');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell($w5, $h, $toLatin1($formatoPesos($viatico['total_liquidado'])), 1, 1, 'C');
            // --- Bajar el bloque de firmas ---
            $pdf->Ln(15);
            // --- Bloque de firmas ---
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(46.5, $h, $toLatin1('Jefe Inmediato'), 1, 0, 'C');
            $pdf->Cell(46.5, $h, $toLatin1('Talento Humano'), 1, 0, 'C');
            $pdf->Cell(46.5, $h, $toLatin1('Fecha Aprobación'), 1, 0, 'C');
            $pdf->Cell(46.5, $h, $toLatin1('Firma del Empleado'), 1, 1, 'C');
            // Fila de espacios para firmas
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(46.5, $h*2.5, '', 1, 0, 'C');
            $pdf->Cell(46.5, $h*2.5, '', 1, 0, 'C');
            $fechaAprobX = $pdf->GetX();
            $fechaAprobY = $pdf->GetY();
            $pdf->Cell(46.5, $h*2.5, '', 1, 0, 'C');
            $pdf->Cell(46.5, $h*2.5, '', 1, 1, 'C');
            // Mini-tabla de Mes y Año dentro de Fecha Aprobación
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY($fechaAprobX, $fechaAprobY);
            $pdf->Cell(23.25, $h, $toLatin1('Mes'), 1, 0, 'C');
            $pdf->Cell(23.25, $h, $toLatin1('Año'), 1, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX($fechaAprobX);
            $pdf->Cell(23.25, $h, date('m', strtotime($viatico['fecha_aprobacion'])), 1, 0, 'C');
            $pdf->Cell(23.25, $h, date('Y', strtotime($viatico['fecha_aprobacion'])), 1, 1, 'C');
            // --- Separar el bloque de Proyecto y Revisión ---
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX($startX);
            $pdf->Cell(25, $h, $toLatin1('Proyecto:'), 1, 0, 'L');
            $pdf->Cell(161, $h, '', 1, 1, 'L');
            $pdf->SetX($startX);
            $pdf->Cell(25, $h, $toLatin1('Revisó:'), 1, 0, 'L');
            $pdf->Cell(161, $h, '', 1, 1, 'L');
            // Leyenda legal
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX($startX);
            $pdf->MultiCell(186, 3.5, $toLatin1('*Los arriba firmantes declaran que han revisado el documento, cuyo contenido se encuentra ajustado a las disposiciones legales vigentes, bajo nuestra responsabilidad lo presentamos para firma.'), 0, 'L');
            // Salida PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Liquidacion_Viatico_' . str_pad($idViatico, 4, '0', STR_PAD_LEFT) . '.pdf"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            $pdf->Output('D', 'Liquidacion_Viatico_' . str_pad($idViatico, 4, '0', STR_PAD_LEFT) . '.pdf');
            exit();
        } catch (Exception $e) {
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
        $viaticos = $this->model->getAllViaticos($year);
        $presupuesto = $this->model->getPresupuestoInfo($year);
        $totalActivos = 0;
        $totalEliminados = 0;
        foreach ($viaticos as $viatico) {
            if ($viatico['estatus'] == 1) {
                $totalActivos += $viatico['total_liquidado'] ?? $viatico['monto'] ?? 0;
            } else {
                $totalEliminados += $viatico['total_liquidado'] ?? $viatico['monto'] ?? 0;
            }
        }
        try {
            ob_clean();
            $toLatin1 = function($text) { return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text); };
            $formatoPesos = function($valor) { return '$ ' . number_format(floatval($valor), 2, ',', '.'); };
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile(dirname(__DIR__) . '/Assets/plantillas/Plantillapdfalcaldia.pdf');
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 210);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetXY(0, 20);
            $pdf->Cell(210, 10, $toLatin1('REPORTE ANUAL DE VIÁTICOS ' . $year), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetXY(0, 30);
            $pdf->Cell(210, 8, $toLatin1('Fecha de generación: ' . date('d/m/Y')), 0, 1, 'C');
            // Resumen de presupuesto
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetXY(14, 45);
            $pdf->Cell(186, 8, $toLatin1('INFORMACIÓN DEL PRESUPUESTO'), 1, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetX(14);
            $pdf->Cell(62, 8, $toLatin1('Capital Total'), 1, 0, 'L');
            $pdf->Cell(62, 8, $toLatin1('Capital Disponible'), 1, 0, 'L');
            $pdf->Cell(62, 8, $toLatin1('Capital Utilizado'), 1, 1, 'L');
            $pdf->SetX(14);
            $pdf->Cell(62, 8, $formatoPesos($presupuesto['capital_total'] ?? 0), 1, 0, 'R');
            $pdf->Cell(62, 8, $formatoPesos($presupuesto['capital_disponible'] ?? 0), 1, 0, 'R');
            $pdf->Cell(62, 8, $formatoPesos(($presupuesto['capital_total'] ?? 0) - ($presupuesto['capital_disponible'] ?? 0)), 1, 1, 'R');
            // Tabla de viáticos
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetX(14);
            $pdf->Cell(186, 8, $toLatin1('LISTADO DE VIÁTICOS'), 1, 1, 'C');
            $pdf->SetFont('Arial', 'B', 8);
            $contador = 1;
            $y = $pdf->GetY();
            // Función mejorada para recortar texto y añadir '...'
            $recortarTexto = function($pdf, $texto, $w) {
                $maxWidth = $w - 1; // Reducimos el margen para aprovechar más espacio
                $texto = trim($texto);
                if ($pdf->GetStringWidth($texto) <= $maxWidth) return $texto;
                
                // Si el texto es muy largo, intentamos abreviarlo primero
                if (strlen($texto) > 30) {
                    // Abreviar palabras comunes
                    $texto = str_replace(
                        ['Departamento', 'Secretaría', 'Municipio', 'Administración', 'Desarrollo', 'Coordinación'],
                        ['Dpto', 'Sec', 'Mpio', 'Admin', 'Des', 'Coord'],
                        $texto
                    );
                }
                
                // Si sigue siendo muy largo, recortamos
                while ($pdf->GetStringWidth($texto . '...') > $maxWidth && strlen($texto) > 0) {
                    $texto = mb_substr($texto, 0, -1, 'UTF-8');
                }
                return $texto . '...';
            };
            // Definición de anchos de columna para la tabla de viáticos (sin dependencia)
            $anchos = [50, 35, 25, 20, 10, 18, 18]; // Suman 176mm aprox
            $hBase = 6; // Altura base para las filas reducida
            // Encabezado de la tabla (sin dependencia y con letra más pequeña)
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetX(14);
            $pdf->Cell($anchos[0], 7, $toLatin1('Funcionario'), 1, 0, 'C');
            $pdf->Cell($anchos[1], 7, $toLatin1('Cargo'), 1, 0, 'C');
            $pdf->Cell($anchos[2], 7, $toLatin1('Motivo'), 1, 0, 'C');
            $pdf->Cell($anchos[3], 7, $toLatin1('Ciudad'), 1, 0, 'C');
            $pdf->Cell($anchos[4], 7, $toLatin1('Días'), 1, 0, 'C');
            $pdf->Cell($anchos[5], 7, $toLatin1('Valor Día'), 1, 0, 'C');
            $pdf->Cell($anchos[8], 7, $toLatin1('Total'), 1, 1, 'C');
            foreach ($viaticos as $viatico) {
                // Si llegamos al final de la página, crear una nueva y repetir encabezados
                if ($pdf->GetY() > 270) {
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx, 0, 0, 210);
                    // Repetir encabezados en la nueva página
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->SetX(14);
                    $pdf->Cell($anchos[0], 7, $toLatin1('Funcionario'), 1, 0, 'C');
                    $pdf->Cell($anchos[1], 7, $toLatin1('Cargo'), 1, 0, 'C');
                    $pdf->Cell($anchos[2], 7, $toLatin1('Motivo'), 1, 0, 'C');
                    $pdf->Cell($anchos[3], 7, $toLatin1('Ciudad'), 1, 0, 'C');
                    $pdf->Cell($anchos[4], 7, $toLatin1('Días'), 1, 0, 'C');
                    $pdf->Cell($anchos[5], 7, $toLatin1('Valor Día'), 1, 0, 'C');
                    $pdf->Cell($anchos[8], 7, $toLatin1('Total'), 1, 1, 'C');
                    $pdf->SetFont('Arial', '', 7);
                }
                $pdf->SetX(14);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell($anchos[0], $hBase, $recortarTexto($pdf, $toLatin1($viatico['nombre_completo'] ?? ''), $anchos[0]), 1, 0, 'L');
                $pdf->Cell($anchos[1], $hBase, $recortarTexto($pdf, $toLatin1($viatico['cargo'] ?? ''), $anchos[1]), 1, 0, 'L');
                $pdf->Cell($anchos[2], $hBase, $recortarTexto($pdf, $toLatin1($viatico['motivo_gasto'] ?? ''), $anchos[2]), 1, 0, 'L');
                $pdf->Cell($anchos[3], $hBase, $recortarTexto($pdf, $toLatin1($viatico['lugar_comision_ciudad'] ?? ''), $anchos[3]), 1, 0, 'L');
                $pdf->Cell($anchos[4], $hBase, $viatico['n_dias'] ?? '', 1, 0, 'C');
                $pdf->Cell($anchos[5], $hBase, $formatoPesos($viatico['valor_dia'] ?? 0), 1, 0, 'R');
                $pdf->Cell($anchos[8], $hBase, $formatoPesos($viatico['total_liquidado'] ?? $viatico['monto'] ?? 0), 1, 1, 'R');
            }
            // Resumen de Viáticos
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetX(14);
            $pdf->Cell(93, 8, $toLatin1('Total Viáticos Activos:'), 1, 0, 'R');
            $pdf->Cell(93, 8, $formatoPesos($totalActivos), 1, 1, 'R');
            $pdf->SetX(14);
            $pdf->Cell(93, 8, $toLatin1('Total Viáticos Eliminados:'), 1, 0, 'R');
            $pdf->Cell(93, 8, $formatoPesos($totalEliminados), 1, 1, 'R');
            // Salida PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Reporte_Viaticos_' . $year . '.pdf"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            $pdf->Output('D', 'Reporte_Viaticos_' . $year . '.pdf');
            exit();
        } catch (Exception $e) {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
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