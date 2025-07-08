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
        getPermisos(MVACACIONES);
    }

    public function Vacaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 6;
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
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u'] && $arrData[$i]['periodos_disponibles'] > 0) {
                    $btnVacaciones = '<button class="btn btn-success" onClick="fntVacacionesInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Registrar Vacaciones"><i class="bi bi-calendar-check"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['r']) {
                    $btnHistorial = '<button class="btn btn-secondary" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
                }
                
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
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaInicio']) || empty($_POST['txtFechaFin']) || empty($_POST['listPeriodo']) || empty($_POST['listTipoVacaciones'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idFuncionario = intval($_POST['idFuncionario']);
                        $fechaInicio = $_POST['txtFechaInicio'];
                        $fechaFin = $_POST['txtFechaFin'];
                        $periodo = intval($_POST['listPeriodo']);
                        $tipoVacaciones = $_POST['listTipoVacaciones'];
                        $valor = isset($_POST['txtValor']) ? floatval($_POST['txtValor']) : 0;
                        // Validar que la fecha de fin sea posterior a la de inicio
                        if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
                            $arrResponse = array("status" => false, "msg" => 'La fecha de fin debe ser posterior a la fecha de inicio.');
                        } else {
                            $request = $this->model->insertVacaciones($idFuncionario, $fechaInicio, $fechaFin, $periodo, $tipoVacaciones, $valor);
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

    public function aprobarVacaciones()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idVacaciones'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idVacaciones = intval($_POST['idVacaciones']);
                        $request = $this->model->aprobarVacaciones($idVacaciones);
                        
                        if ($request['status']) {
                            $arrResponse = array('status' => true, 'msg' => $request['msg']);
                        } else {
                            $arrResponse = array('status' => false, 'msg' => $request['msg']);
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al aprobar las vacaciones. Intente nuevamente.');
                        error_log("Error en aprobarVacaciones: " . $e->getMessage());
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
    
    public function actualizarEstadoVacaciones()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                // Llamar al método del modelo para actualizar el estado de las vacaciones
                $this->model->actualizarEstadoVacaciones();
                $arrResponse = array('status' => true, 'msg' => 'Estado de vacaciones actualizado correctamente');
            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al actualizar el estado de las vacaciones');
                error_log("Error en actualizarEstadoVacaciones: " . $e->getMessage());
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function generarPDF($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            if (isset($params) && is_numeric($params)) {
                $idFuncionario = intval($params);
                
                try {
                    // Actualizar estado de vacaciones antes de generar el PDF
                    $this->model->actualizarEstadoVacaciones();
                    
                    // Obtener datos del funcionario
                    $funcionario = $this->model->selectFuncionario($idFuncionario);
                    if (empty($funcionario)) {
                        throw new Exception("Funcionario no encontrado");
                    }
                    
                    // Obtener historial de vacaciones
                    $historial = $this->model->getHistorialVacaciones($idFuncionario);
                    
                    // Limpiar cualquier salida anterior
                    if (ob_get_length()) ob_clean();
                    
                    // Incluir FPDF primero
                    require_once 'vendor/setasign/fpdf/fpdf.php';
                    
                    // Luego incluir FPDI
                    require_once 'vendor/setasign/fpdi/src/autoload.php';
                    
                    // Crear instancia de FPDI
                    $pdf = new \setasign\Fpdi\Fpdi();
                    
                    // Ruta a la plantilla
                    $templatePath = 'Assets/plantillas/plantilla_historial_permiso.pdf';
                    if (!file_exists($templatePath)) {
                        throw new Exception("No se encontró la plantilla del historial de vacaciones");
                    }
                    
                    // Agregar la página de la plantilla
                    $pdf->setSourceFile($templatePath);
                    $tplIdx = $pdf->importPage(1);
                    
                    // Agregar página
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx);
                    
                    // Configurar fuente
                    $pdf->SetFont('Arial', '', 11);
                    
                    // Tabla de información del funcionario
                    $startY = 55;
                    $pdf->SetXY(20, $startY);
                    
                    // Estilo para encabezados de la tabla
                    $pdf->SetFillColor(230, 230, 230);
                    $pdf->SetFont('Arial', 'B', 10);
                    
                    // Nombre
                    $pdf->Cell(40, 8, mb_convert_encoding('Nombre:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, mb_convert_encoding($funcionario['nombre_completo'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
                    
                    // Identificación
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, mb_convert_encoding('Identificación:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, $funcionario['nm_identificacion'], 1, 1, 'L');
                    
                    // Cargo
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, mb_convert_encoding('Cargo:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, mb_convert_encoding($funcionario['cargo_nombre'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
                    
                    // Dependencia
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, mb_convert_encoding('Dependencia:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, mb_convert_encoding($funcionario['dependencia_nombre'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
                    
                    // Años de servicio y períodos disponibles
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, mb_convert_encoding('Años Servicio:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, $funcionario['anos_servicio'], 1, 1, 'L');
                    
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, mb_convert_encoding('Períodos Disp.:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(130, 8, $funcionario['periodos_disponibles'], 1, 1, 'L');
                    
                    // Espacio entre tablas
                    $pdf->Ln(10);
                    
                    // Título de la sección de historial
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 10, mb_convert_encoding('HISTORIAL DE VACACIONES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
                    $pdf->Ln(5);
                    
                    if (!empty($historial)) {
                        // Encabezados de la tabla de historial
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->SetFillColor(230, 230, 230);
                        $pdf->SetX(20);
                        $pdf->Cell(28, 8, 'Fecha Inicio', 1, 0, 'C', true);
                        $pdf->Cell(28, 8, 'Fecha Fin', 1, 0, 'C', true);
                        $pdf->Cell(18, 8, mb_convert_encoding('Período', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
                        $pdf->Cell(28, 8, 'Tipo', 1, 0, 'C', true);
                        $pdf->Cell(22, 8, 'Valor', 1, 0, 'C', true);
                        $pdf->Cell(28, 8, 'Estado', 1, 0, 'C', true);
                        $pdf->Cell(28, 8, 'F. Registro', 1, 1, 'C', true);
                        
                        // Datos de la tabla
                        $pdf->SetFont('Arial', '', 10);
                        foreach ($historial as $item) {
                            $fechaInicioObj = new DateTime($item['fecha_inicio']);
                            $fechaFinObj = new DateTime($item['fecha_fin']);
                            $fechaRegistroObj = new DateTime($item['fecha_registro']);
                            
                            $fechaInicio = $fechaInicioObj->format('d/m/Y');
                            $fechaFin = $fechaFinObj->format('d/m/Y');
                            $fechaRegistro = $fechaRegistroObj->format('d/m/Y');
                            
                            // Ajustar el texto del estado
                            $estadoTexto = $item['estado'];
                            if ($estadoTexto == 'Cumplidas') {
                                $estadoTexto = 'Cumplida';
                            }
                            
                            $pdf->SetX(20);
                            $pdf->Cell(28, 8, $fechaInicio, 1, 0, 'C');
                            $pdf->Cell(28, 8, $fechaFin, 1, 0, 'C');
                            $pdf->Cell(18, 8, $item['periodo'], 1, 0, 'C');
                            $pdf->Cell(28, 8, mb_convert_encoding($item['tipo_vacaciones'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                            $pdf->Cell(22, 8, number_format($item['valor'], 2, '.', ','), 1, 0, 'C');
                            $pdf->Cell(28, 8, mb_convert_encoding($estadoTexto, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                            $pdf->Cell(28, 8, $fechaRegistro, 1, 1, 'C');
                            
                            // Si la tabla llega al final de la página, agregar una nueva
                            if($pdf->GetY() > 250) {
                                $pdf->AddPage();
                                $pdf->useTemplate($tplIdx);
                                $pdf->SetFont('Arial', 'B', 10);
                                $pdf->SetXY(20, 30);
                                $pdf->SetFillColor(230, 230, 230);
                                $pdf->Cell(28, 8, 'Fecha Inicio', 1, 0, 'C', true);
                                $pdf->Cell(28, 8, 'Fecha Fin', 1, 0, 'C', true);
                                $pdf->Cell(18, 8, mb_convert_encoding('Período', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
                                $pdf->Cell(28, 8, 'Tipo', 1, 0, 'C', true);
                                $pdf->Cell(22, 8, 'Valor', 1, 0, 'C', true);
                                $pdf->Cell(28, 8, 'Estado', 1, 0, 'C', true);
                                $pdf->Cell(28, 8, 'F. Registro', 1, 1, 'C', true);
                                $pdf->SetFont('Arial', '', 10);
                            }
                        }
                    } else {
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(0, 10, 'No hay registros de vacaciones para este funcionario.', 0, 1, 'C');
                    }
                    
                    // Asegurarse de que no haya salida antes del PDF
                    while (ob_get_level()) {
                        ob_end_clean();
                    }
                    
                    // Configurar encabezados para forzar la descarga
                    $nombreFuncionario = $funcionario['nombre_completo'];
                    $caracteres_especiales = array(
                        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
                        'ñ' => 'n', 'Ñ' => 'N', 'ü' => 'u', 'Ü' => 'U'
                    );
                    
                    $nombreFuncionario = str_replace(array_keys($caracteres_especiales), array_values($caracteres_especiales), $nombreFuncionario);
                    $nombreFuncionario = str_replace(' ', '_', $nombreFuncionario);
                    $nombreFuncionario = preg_replace('/[^a-zA-Z0-9_-]/', '', $nombreFuncionario);
                    $nombreArchivo = 'Historial_Vacaciones_' . $nombreFuncionario . '.pdf';
                    
                    try {
                        header('Content-Type: application/pdf');
                        header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
                        header('Pragma: public');
                        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
                        
                        // Generar el PDF
                        $pdf->Output('D', $nombreArchivo);
                        exit();
                    } catch (Exception $e) {
                        error_log("Error al generar el PDF: " . $e->getMessage());
                        throw new Exception("Error al generar el PDF: " . $e->getMessage());
                    }
                    
                } catch (Exception $e) {
                    error_log("Error generando PDF: " . $e->getMessage());
                    echo "Error al generar el PDF: " . $e->getMessage();
                }
            } else {
                echo "Parámetro inválido";
            }
        } else {
            header("Location:".base_url().'/dashboard');
        }
        die();
    }
}