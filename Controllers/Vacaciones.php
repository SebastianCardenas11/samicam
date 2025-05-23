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

                // Agregar imagen del funcionario
                $urlImagen = media().'/images/funcionarios/'.$arrData[$i]['imagen'];
                // Verificar si existe la imagen
                $rutaImagen = 'Assets/images/funcionarios/'.$arrData[$i]['imagen'];
                if(!file_exists($rutaImagen)){
                    $urlImagen = media().'/images/sinimagen.png';
                }
                $arrData[$i]['imagen'] = '<img src="'.$urlImagen.'" alt="'.$arrData[$i]['nombre_completo'].'" class="img-thumbnail rounded-circle" style="width:50px; height:50px;">';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
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
                    // Agregar URL de la imagen
                    $urlImagen = media().'/images/funcionarios/'.$arrData['imagen'];
                    // Verificar si existe la imagen
                    $rutaImagen = 'Assets/images/funcionarios/'.$arrData['imagen'];
                    if(!file_exists($rutaImagen)){
                        $urlImagen = media().'/images/sinimagen.png';
                    }
                    $arrData['url_imagen'] = $urlImagen;
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
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaInicio']) || empty($_POST['txtFechaFin']) || empty($_POST['listPeriodo'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idFuncionario = intval($_POST['idFuncionario']);
                        $fechaInicio = $_POST['txtFechaInicio'];
                        $fechaFin = $_POST['txtFechaFin'];
                        $periodo = intval($_POST['listPeriodo']);
                        
                        // Validar que la fecha de fin sea posterior a la de inicio
                        if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
                            $arrResponse = array("status" => false, "msg" => 'La fecha de fin debe ser posterior a la fecha de inicio.');
                        } else {
                            $request = $this->model->insertVacaciones($idFuncionario, $fechaInicio, $fechaFin, $periodo);
                            
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
                
                // Actualizar estado de vacaciones antes de generar el PDF
                $this->model->actualizarEstadoVacaciones();
                
                // Obtener datos del funcionario
                $funcionario = $this->model->selectFuncionario($idFuncionario);
                if (empty($funcionario)) {
                    echo "Funcionario no encontrado";
                    return;
                }
                
                // Obtener historial de vacaciones
                $historial = $this->model->getHistorialVacaciones($idFuncionario);
                
                // Incluir la librería FPDF
                require_once 'Libraries/pdf/fpdf.php';
                
                // Crear nuevo documento PDF
                $pdf = new FPDF('P', 'mm', 'A4');
                
                // Agregar una página
                $pdf->AddPage();
                
                // Configurar fuentes
                $pdf->SetFont('Arial', 'B', 16);
                
                // Título
                $pdf->Cell(0, 10, 'Historial de Vacaciones', 0, 1, 'C');
                $pdf->Ln(5);
                
                // Información del funcionario
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Información del Funcionario', 0, 1, 'L');
                
                // Imagen del funcionario
                $imagePath = 'Assets/images/funcionarios/'.$funcionario['imagen'];
                if(file_exists($imagePath)){
                    $pdf->Image($imagePath, 160, 20, 30, 30);
                } else {
                    // Usar imagen predeterminada si no existe
                    $pdf->Image('Assets/images/sinimagen.png', 160, 20, 30, 30);
                }
                
                $pdf->SetFont('Arial', '', 10);
                
                // Datos del funcionario
                $pdf->Cell(40, 8, 'Nombre:', 1);
                $pdf->Cell(150, 8, utf8_decode($funcionario['nombre_completo']), 1, 1);
                
                $pdf->Cell(40, 8, 'Identificación:', 1);
                $pdf->Cell(150, 8, $funcionario['nm_identificacion'], 1, 1);
                
                $pdf->Cell(40, 8, 'Cargo:', 1);
                $pdf->Cell(150, 8, utf8_decode($funcionario['cargo_nombre']), 1, 1);
                
                $pdf->Cell(40, 8, 'Dependencia:', 1);
                $pdf->Cell(150, 8, utf8_decode($funcionario['dependencia_nombre']), 1, 1);
                
                $pdf->Cell(40, 8, 'Fecha de Ingreso:', 1);
                $pdf->Cell(150, 8, $funcionario['fecha_ingreso'], 1, 1);
                
                $pdf->Cell(40, 8, 'Años de Servicio:', 1);
                $pdf->Cell(150, 8, $funcionario['anos_servicio'], 1, 1);
                
                $pdf->Cell(40, 8, 'Períodos Disponibles:', 1);
                $pdf->Cell(150, 8, $funcionario['periodos_disponibles'], 1, 1);
                
                $pdf->Ln(10);
                
                // Historial de vacaciones
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Registro de Vacaciones', 0, 1, 'L');
                
                if (!empty($historial)) {
                    // Encabezados de la tabla
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(35, 8, 'Fecha Inicio', 1, 0, 'C');
                    $pdf->Cell(35, 8, 'Fecha Fin', 1, 0, 'C');
                    $pdf->Cell(30, 8, 'Período', 1, 0, 'C');
                    $pdf->Cell(40, 8, 'Estado', 1, 0, 'C');
                    $pdf->Cell(50, 8, 'Fecha Registro', 1, 1, 'C');
                    
                    // Datos de la tabla
                    $pdf->SetFont('Arial', '', 10);
                    foreach ($historial as $item) {
                        // Ajustar fechas para mostrar correctamente en el PDF
                        $fechaInicioObj = new DateTime($item['fecha_inicio']);
                        $fechaFinObj = new DateTime($item['fecha_fin']);
                        $fechaRegistroObj = new DateTime($item['fecha_registro']);
                        
                        $fechaInicio = $fechaInicioObj->format('d/m/Y');
                        $fechaFin = $fechaFinObj->format('d/m/Y');
                        $fechaRegistro = $fechaRegistroObj->format('d/m/Y');
                        
                        // Ajustar el texto del estado para el PDF
                        $estadoTexto = $item['estado'];
                        if ($estadoTexto == 'Cumplidas') {
                            $estadoTexto = 'Cumplida';
                        }
                        
                        $pdf->Cell(35, 8, $fechaInicio, 1, 0, 'C');
                        $pdf->Cell(35, 8, $fechaFin, 1, 0, 'C');
                        $pdf->Cell(30, 8, $item['periodo'], 1, 0, 'C');
                        $pdf->Cell(40, 8, utf8_decode($estadoTexto), 1, 0, 'C');
                        $pdf->Cell(50, 8, $fechaRegistro, 1, 1, 'C');
                    }
                } else {
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(0, 10, 'No hay registros de vacaciones para este funcionario.', 0, 1, 'L');
                }
                
                // Configurar encabezados para forzar la descarga
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="Historial_Vacaciones_'.$funcionario['nombre_completo'].'.pdf"');
                header('Cache-Control: max-age=0');
                
                // Generar el PDF
                $pdf->Output('Historial_Vacaciones_'.$funcionario['nombre_completo'].'.pdf', 'D');
            } else {
                echo "Parámetro inválido";
            }
        } else {
            header("Location:".base_url().'/dashboard');
        }
        die();
    }
}