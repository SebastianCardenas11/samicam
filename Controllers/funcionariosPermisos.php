<?php

class FuncionariosPermisos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDASHBOARD);
    }

    public function FuncionariosPermisos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Permisos";
        $data['page_title'] = "Permisos";
        $data['page_name'] = "Permisos";
        $data['page_functions_js'] = "functions_funcionariosPermisos.js";
        $this->views->getView($this, "funcionariosPermisos", $data);
    }

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnPermit = '';
                $btnHistorial = '';

                // Agregar imagen del funcionario
                $urlImagen = media().'/images/funcionarios/'.$arrData[$i]['imagen'];
                // Verificar si existe la imagen
                $rutaImagen = 'Assets/images/funcionarios/'.$arrData[$i]['imagen'];
                if(!file_exists($rutaImagen)){
                    $urlImagen = media().'/images/sinimagen.png';
                }
                $arrData[$i]['imagen'] = '<img src="'.$urlImagen.'" alt="'.$arrData[$i]['nombre_completo'].'" class="img-thumbnail rounded-circle" style="width:50px; height:50px;">';

                // Formatear el número de permisos como "X/3"
                $arrData[$i]['permisos'] = $arrData[$i]['permisos_mes_actual'] . "/3";

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u'] && $arrData[$i]['permisos_mes_actual'] < 3) {
                    $btnPermit = '<button class="btn btn-success" onClick="fntPermitInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Registrar Permiso"><i class="bi bi-door-open"></i></button>';
                }
                
                $btnHistorial = '<button class="btn btn-secondary" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPermit . ' ' . $btnHistorial . '</div>';
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

    public function getHistorialPermisos($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                try {
                    $arrData = $this->model->getHistorialPermisos($idefuncionario);
                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'msg' => 'No hay permisos registrados.');
                    } else {
                        $arrResponse = array('status' => true, 'data' => $arrData);
                    }
                } catch (Exception $e) {
                    $arrResponse = array('status' => false, 'msg' => 'Error al obtener el historial de permisos.');
                    error_log("Error en getHistorialPermisos: " . $e->getMessage());
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getMotivosPermisos()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->getMotivosPermisos();
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'No hay motivos de permisos registrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al obtener los motivos de permisos.');
                error_log("Error en getMotivosPermisos: " . $e->getMessage());
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPermiso()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaPermiso']) || empty($_POST['listMotivoPermiso'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idFuncionario = intval($_POST['idFuncionario']);
                        $fechaPermiso = $_POST['txtFechaPermiso'];
                        $idMotivo = intval($_POST['listMotivoPermiso']);
                        
                        $request = $this->model->insertPermiso($idFuncionario, $fechaPermiso, $idMotivo);
                        
                        if ($request['status']) {
                            $arrResponse = array('status' => true, 'msg' => $request['msg']);
                        } else {
                            $arrResponse = array('status' => false, 'msg' => $request['msg']);
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al registrar el permiso. Intente nuevamente.');
                        error_log("Error en setPermiso: " . $e->getMessage());
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function generarPDF($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            if (isset($params) && is_numeric($params)) {
                $idFuncionario = intval($params);
                
                // Obtener datos del funcionario
                $funcionario = $this->model->selectFuncionario($idFuncionario);
                if (empty($funcionario)) {
                    echo "Funcionario no encontrado";
                    return;
                }
                
                // Obtener historial de permisos
                $historial = $this->model->getHistorialPermisos($idFuncionario);
                
                // Incluir la librería FPDF
                require_once 'Libraries/pdf/fpdf.php';
                
                // Crear nuevo documento PDF
                $pdf = new FPDF('P', 'mm', 'A4');
                
                // Agregar una página
                $pdf->AddPage();
                
                // Configurar fuentes
                $pdf->SetFont('Arial', 'B', 16);
                
                // Título
                $pdf->Cell(0, 10, 'Historial de Permisos', 0, 1, 'C');
                $pdf->Ln(5);
                
                // Información del funcionario
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Información del Funcionario', 0, 1, 'L');
                
                // Imagen del funcionario
                $imagePath = 'Assets/images/funcionarios/'.$funcionario['imagen'];
                if(file_exists($imagePath)){
                    $pdf->Image($imagePath, 160, 20, 30, 30);
                } else {
                    // Usar imagen por defecto si no existe
                    $pdf->Image('Assets/images/sinimagen.png', 160, 20, 30, 30);
                }
                
                $pdf->SetFont('Arial', '', 10);
                
                // Datos del funcionario
                $pdf->Cell(40, 8, 'Nombre:', 1);
                $pdf->Cell(150, 8, $funcionario['nombre_completo'], 1, 1);
                
                $pdf->Cell(40, 8, 'Identificación:', 1);
                $pdf->Cell(150, 8, $funcionario['nm_identificacion'], 1, 1);
                
                $pdf->Cell(40, 8, 'Cargo:', 1);
                $pdf->Cell(150, 8, $funcionario['cargo_nombre'], 1, 1);
                
                $pdf->Cell(40, 8, 'Dependencia:', 1);
                $pdf->Cell(150, 8, $funcionario['dependencia_nombre'], 1, 1);
                
                $pdf->Cell(40, 8, 'Permisos mes actual:', 1);
                $pdf->Cell(150, 8, $funcionario['permisos_mes_actual'] . '/3', 1, 1);
                
                $pdf->Ln(10);
                
                // Historial de permisos
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Registro de Permisos', 0, 1, 'L');
                
                if (!empty($historial)) {
                    // Encabezados de la tabla
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(40, 8, 'Fecha', 1, 0, 'C');
                    $pdf->Cell(100, 8, 'Motivo', 1, 0, 'C');
                    $pdf->Cell(50, 8, 'Estado', 1, 1, 'C');
                    
                    // Datos de la tabla
                    $pdf->SetFont('Arial', '', 10);
                    foreach ($historial as $item) {
                        $fechaPermiso = date('d/m/Y', strtotime($item['fecha_permiso']));
                        
                        $pdf->Cell(40, 8, $fechaPermiso, 1, 0, 'C');
                        $pdf->Cell(100, 8, $item['motivo'], 1, 0, 'L');
                        $pdf->Cell(50, 8, $item['estado'], 1, 1, 'C');
                    }
                } else {
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(0, 10, 'No hay registros de permisos para este funcionario.', 0, 1, 'L');
                }
                
                // Configurar encabezados para forzar la descarga
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="Historial_Permisos_'.$funcionario['nombre_completo'].'.pdf"');
                header('Cache-Control: max-age=0');
                
                // Generar el PDF
                $pdf->Output('Historial_Permisos_'.$funcionario['nombre_completo'].'.pdf', 'D');
            } else {
                echo "Parámetro inválido";
            }
        } else {
            header("Location:".base_url().'/dashboard');
        }
        die();
    }

    public function generarPermisoPDF($idPermiso)
    {
        if ($_SESSION['permisosMod']['r']) {
            if (isset($idPermiso) && is_numeric($idPermiso)) {
                $idPermiso = intval($idPermiso);
                
                // Obtener datos del permiso
                $permiso = $this->model->getPermiso($idPermiso);
                if (empty($permiso)) {
                    echo "Permiso no encontrado";
                    return;
                }
                
                // Obtener datos del funcionario
                $funcionario = $this->model->selectFuncionario($permiso['id_funcionario']);
                if (empty($funcionario)) {
                    echo "Funcionario no encontrado";
                    return;
                }
                
                // Incluir la librería FPDF
                require_once 'Libraries/pdf/fpdf.php';
                
                // Crear nuevo documento PDF
                $pdf = new FPDF('P', 'mm', 'A4');
                
                // Agregar una página
                $pdf->AddPage();
                
                // Configurar fuentes
                $pdf->SetFont('Arial', 'B', 16);
                
                // Título
                $pdf->Cell(0, 10, 'Comprobante de Permiso', 0, 1, 'C');
                $pdf->Ln(5);
                
                // Información del funcionario
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Información del Funcionario', 0, 1, 'L');
                
                // Imagen del funcionario
                $imagePath = 'Assets/images/funcionarios/'.$funcionario['imagen'];
                if(file_exists($imagePath)){
                    $pdf->Image($imagePath, 160, 20, 30, 30);
                } else {
                    // Usar imagen por defecto si no existe
                    $pdf->Image('Assets/images/sinimagen.png', 160, 20, 30, 30);
                }
                
                $pdf->SetFont('Arial', '', 10);
                
                // Datos del funcionario
                $pdf->Cell(40, 8, 'Nombre:', 1);
                $pdf->Cell(150, 8, $funcionario['nombre_completo'], 1, 1);
                
                $pdf->Cell(40, 8, 'Identificación:', 1);
                $pdf->Cell(150, 8, $funcionario['nm_identificacion'], 1, 1);
                
                $pdf->Cell(40, 8, 'Cargo:', 1);
                $pdf->Cell(150, 8, $funcionario['cargo_nombre'], 1, 1);
                
                $pdf->Cell(40, 8, 'Dependencia:', 1);
                $pdf->Cell(150, 8, $funcionario['dependencia_nombre'], 1, 1);
                
                $pdf->Ln(10);
                
                // Detalles del permiso
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Detalles del Permiso', 0, 1, 'L');
                
                $pdf->SetFont('Arial', '', 10);
                
                // Formatear fecha
                $fechaPermiso = date('d/m/Y', strtotime($permiso['fecha_permiso']));
                
                $pdf->Cell(40, 8, 'Fecha:', 1);
                $pdf->Cell(150, 8, $fechaPermiso, 1, 1);
                
                $pdf->Cell(40, 8, 'Motivo:', 1);
                $pdf->Cell(150, 8, $permiso['motivo'], 1, 1);
                
                $pdf->Cell(40, 8, 'Estado:', 1);
                $pdf->Cell(150, 8, $permiso['estado'], 1, 1);
                
                $pdf->Ln(20);
                
                // Firmas
                $pdf->Cell(95, 8, '___________________________', 0, 0, 'C');
                $pdf->Cell(95, 8, '___________________________', 0, 1, 'C');
                $pdf->Cell(95, 8, 'Firma del Funcionario', 0, 0, 'C');
                $pdf->Cell(95, 8, 'Firma del Jefe Inmediato', 0, 1, 'C');
                
                // Configurar encabezados para forzar la descarga
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="Permiso_'.$funcionario['nombre_completo'].'_'.$fechaPermiso.'.pdf"');
                
                // Generar el PDF
                $pdf->Output('Permiso_'.$funcionario['nombre_completo'].'_'.$fechaPermiso.'.pdf', 'I');
            } else {
                echo "Parámetro inválido";
            }
        } else {
            header("Location:".base_url().'/dashboard');
        }
        die();
    }
}