<?php

require_once 'vendor/setasign/fpdf/fpdf.php';
require_once 'vendor/setasign/fpdi/src/autoload.php';

use setasign\Fpdi\Fpdi;

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
    }

    public function FuncionariosPermisos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 5;
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
                $btnPermisoEspecial = '';

                // Agregar imagen del funcionario
                $urlImagen = media().'/images/funcionarios/'.$arrData[$i]['imagen'];
                // Verificar si existe la imagen
                $rutaImagen = 'Assets/images/funcionarios/'.$arrData[$i]['imagen'];
                if(!file_exists($rutaImagen)){
                    $urlImagen = media().'/images/sin-imagen.png';
                }
                $arrData[$i]['imagen'] = '<img src="'.$urlImagen.'" alt="'.$arrData[$i]['nombre_completo'].'" class="img-thumbnail rounded-circle" style="width:50px; height:50px;">';

                // Formatear el número de permisos como "X/3"
                $arrData[$i]['permisos'] = $arrData[$i]['permisos_mes_actual'] . "/3";

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u'] && $arrData[$i]['permisos_mes_actual'] < 3) {
                    $btnPermit = '<button class="btn btn-success btn-sm" onClick="fntPermitInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Registrar Permiso"><i class="bi bi-door-open"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['r']) {
                    $btnHistorial = '<button class="btn btn-secondary btn-sm" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnPermisoEspecial = '<button class="btn btn-warning btn-sm" onClick="fntPermisoEspecial(' . $arrData[$i]['idefuncionario'] . ')" title="Permiso Especial"><i class="bi bi-exclamation-triangle"></i></button>';
                }
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPermit . ' ' . $btnHistorial . ' ' . $btnPermisoEspecial . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getFuncionariosConPermisos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            $funcionariosConPermisos = [];
            
            foreach ($arrData as $funcionario) {
                $funcionariosConPermisos[] = [
                    'nombre' => $funcionario['nombre_completo'],
                    'permisos_mes_actual' => $funcionario['permisos_mes_actual']
                ];
            }
            
            echo json_encode($funcionariosConPermisos, JSON_UNESCAPED_UNICODE);
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
                        $urlImagen = media().'/images/sin-imagen.png';
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
        if (empty($_SESSION['permisosMod']['u'])) {
            $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        if ($_POST) {
            try {
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaPermiso']) || empty($_POST['listMotivoPermiso'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                $idFuncionario = intval($_POST['idFuncionario']);
                $fechaPermiso = $_POST['txtFechaPermiso'];
                $motivoPermiso = intval($_POST['listMotivoPermiso']);
                $esPermisoEspecial = isset($_POST['es_permiso_especial']) ? 1 : 0;
                $justificacionEspecial = isset($_POST['txtJustificacionEspecial']) ? $_POST['txtJustificacionEspecial'] : '';

                // Validar si es permiso especial
                if ($esPermisoEspecial) {
                    if (empty($justificacionEspecial)) {
                        $arrResponse = array('status' => false, 'msg' => 'La justificación del permiso especial es obligatoria');
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                } else {
                    // Validar número de permisos solo si no es permiso especial
                    $permisosEnMes = $this->model->getPermisosEnMes($idFuncionario);
                    if ($permisosEnMes >= 3) {
                        $arrResponse = array('status' => false, 'msg' => 'El funcionario ya ha utilizado los 3 permisos permitidos para este mes');
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                }

                $request = $this->model->insertPermiso(
                    $idFuncionario, 
                    $fechaPermiso, 
                    $motivoPermiso, 
                    $esPermisoEspecial,
                    $justificacionEspecial
                );

                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Permiso registrado correctamente');
                } elseif ($request == -1) {
                    $arrResponse = array('status' => false, 'msg' => 'Ya existe un permiso registrado para esta fecha');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al registrar el permiso');
                }

            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al procesar la solicitud: ' . $e->getMessage());
            }

            header('Content-Type: application/json');
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
                    // Obtener datos del funcionario
                    $funcionario = $this->model->selectFuncionario($idFuncionario);
                    if (empty($funcionario)) {
                        throw new Exception("Funcionario no encontrado");
                    }
                    
                    // Obtener historial de permisos
                    $historial = $this->model->getHistorialPermisos($idFuncionario);
                    
                    // Limpiar cualquier salida anterior
                    if (ob_get_length()) ob_clean();
                    
                    // Crear nuevo documento PDF
                    $pdf = new FPDF('P', 'mm', 'A4');
                    
                    // Agregar una página
                    $pdf->AddPage();
                    
                    // Configurar fuentes
                    $pdf->SetFont('Arial', 'B', 16);
                    
                    // Título
                    $pdf->Cell(0, 10, utf8_decode('Historial de Permisos'), 0, 1, 'C');
                    $pdf->Ln(5);
                    
                    // Información del funcionario
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 10, utf8_decode('Información del Funcionario'), 0, 1, 'L');
                    
                    // Imagen del funcionario
                    $imagePath = 'Assets/images/funcionarios/'.$funcionario['imagen'];
                    if(file_exists($imagePath)){
                        $pdf->Image($imagePath, 160, 20, 30, 30);
                    } else {
                        // Usar imagen por defecto si no existe
                        $pdf->Image('Assets/images/sin-imagen.png', 160, 20, 30, 30);
                    }
                    
                    $pdf->SetFont('Arial', '', 10);
                    
                    // Datos del funcionario
                    $pdf->Cell(40, 8, 'Nombre:', 1);
                    $pdf->Cell(150, 8, utf8_decode($funcionario['nombre_completo']), 1, 1);
                    
                    $pdf->Cell(40, 8, utf8_decode('Identificación:'), 1);
                    $pdf->Cell(150, 8, $funcionario['nm_identificacion'], 1, 1);
                    
                    $pdf->Cell(40, 8, 'Cargo:', 1);
                    $pdf->Cell(150, 8, utf8_decode($funcionario['cargo_nombre']), 1, 1);
                    
                    $pdf->Cell(40, 8, 'Dependencia:', 1);
                    $pdf->Cell(150, 8, utf8_decode($funcionario['dependencia_nombre']), 1, 1);
                    
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
                            $pdf->Cell(100, 8, utf8_decode($item['motivo']), 1, 0, 'L');
                            $pdf->Cell(50, 8, utf8_decode($item['estado']), 1, 1, 'C');
                        }
                    } else {
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(0, 10, 'No hay registros de permisos para este funcionario.', 0, 1, 'L');
                    }
                    
                    // Asegurarse de que no haya salida antes del PDF
                    while (ob_get_level()) {
                        ob_end_clean();
                    }
                    
                    // Configurar encabezados para forzar la descarga
                    $nombreArchivo = 'Historial_Permisos_'.str_replace(' ', '_', $funcionario['nombre_completo']).'.pdf';
                    header('Content-Type: application/pdf');
                    header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
                    header('Pragma: public');
                    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                    header('Content-Disposition: attachment; filename="'.basename(
                        $nombreArchivo
                    ).'"; filename*=UTF-8\'\''.rawurlencode($nombreArchivo));
                    // Generar el PDF
                    $pdf->Output('D', $nombreArchivo);
                    exit();
                    
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

    public function generarPermisoPDF($idPermiso)
    {
        if ($_SESSION['permisosMod']['r']) {
            if (isset($idPermiso) && is_numeric($idPermiso)) {
                $idPermiso = intval($idPermiso);
                
                try {
                    // Obtener datos del permiso
                    $permiso = $this->model->getPermiso($idPermiso);
                    if (empty($permiso)) {
                        throw new Exception("Permiso no encontrado");
                    }
                    
                    // Obtener datos del funcionario
                    $funcionario = $this->model->selectFuncionario($permiso['id_funcionario']);
                    if (empty($funcionario)) {
                        throw new Exception("Funcionario no encontrado");
                    }
                    
                    // Limpiar cualquier salida anterior
                    if (ob_get_length()) ob_clean();
                    
                    // Incluir FPDI
                    require_once 'vendor/setasign/fpdi/src/autoload.php';
                    
                    // Crear instancia de FPDI
                    $pdf = new \setasign\Fpdi\Fpdi();
                    
                    // Ruta a la nueva plantilla
                    $templatePath = 'Assets/plantillas/plantilla_permiso.pdf';
                    if (!file_exists($templatePath)) {
                        throw new Exception("No se encontró la plantilla del permiso");
                    }
                    
                    try {
                        // Agregar la página de la plantilla
                        $pdf->setSourceFile($templatePath);
                        $tplIdx = $pdf->importPage(1);
                        
                        // Agregar página
                        $pdf->AddPage();
                        $pdf->useTemplate($tplIdx);
                        
                        // Configurar fuente
                        $pdf->SetFont('Arial', '', 11);
                        
                        // Nombre del funcionario
                        $pdf->SetXY(60, 75);
                        $pdf->Cell(140, 8, utf8_decode($funcionario['nombre_completo']), 0, 1);
                        
                        // Identificación
                        $pdf->SetXY(60, 83);
                        $pdf->Cell(140, 8, $funcionario['nm_identificacion'], 0, 1);
                        
                        // Cargo
                        $pdf->SetXY(60, 91);
                        $pdf->Cell(140, 8, utf8_decode($funcionario['cargo_nombre']), 0, 1);
                        
                        // Dependencia
                        $pdf->SetXY(60, 99);
                        $pdf->Cell(140, 8, utf8_decode($funcionario['dependencia_nombre']), 0, 1);
                        
                        // Fecha del permiso
                        $fechaPermiso = date('d/m/Y', strtotime($permiso['fecha_permiso']));
                        $pdf->SetXY(60, 137);
                        $pdf->Cell(140, 8, $fechaPermiso, 0, 1);
                        
                        // Motivo del permiso
                        $pdf->SetXY(60, 146);
                        $pdf->MultiCell(130, 8, utf8_decode($permiso['motivo']), 0, 'L');
                        
                        // Asegurarse de que no haya salida antes del PDF
                        while (ob_get_level()) {
                            ob_end_clean();
                        }
                        
                        // Configurar encabezados para forzar la descarga
                        $nombreArchivoPermiso = 'Permiso_'.str_replace(' ', '_', $funcionario['nombre_completo']).'_'.$fechaPermiso.'.pdf';
                        header('Content-Type: application/pdf');
                        header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
                        header('Pragma: public');
                        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                        header('Content-Disposition: attachment; filename="'.basename(
                            $nombreArchivoPermiso
                        ).'"; filename*=UTF-8\'\''.rawurlencode($nombreArchivoPermiso));
                        // Generar el PDF
                        $pdf->Output('D', $nombreArchivoPermiso);
                        exit();
                        
                    } catch (Exception $e) {
                        error_log("Error al generar el PDF: " . $e->getMessage());
                        throw new Exception("Error al generar el PDF: " . $e->getMessage());
                    }
                    
                } catch (Exception $e) {
                    error_log("Error: " . $e->getMessage());
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Parámetro inválido";
            }
        } else {
            header("Location:".base_url().'/dashboard');
        }
        die();
    }

    public function setPermisoEspecial()
    {
        if (empty($_SESSION['permisosMod']['u'])) {
            $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        if ($_POST) {
            try {
                if (empty($_POST['idFuncionarioEspecial']) || empty($_POST['txtFechaInicioEspecial']) || 
                    empty($_POST['txtFechaFinEspecial']) || empty($_POST['txtJustificacionEspecial'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                $idFuncionario = intval($_POST['idFuncionarioEspecial']);
                $fechaInicio = $_POST['txtFechaInicioEspecial'];
                $fechaFin = $_POST['txtFechaFinEspecial'];
                $justificacion = $_POST['txtJustificacionEspecial'];

                // Validar que la fecha de fin no sea menor que la fecha de inicio
                if (strtotime($fechaFin) < strtotime($fechaInicio)) {
                    $arrResponse = array('status' => false, 'msg' => 'La fecha de fin no puede ser menor que la fecha de inicio');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                // Insertar el permiso especial para cada día en el rango
                $fechaActual = new DateTime($fechaInicio);
                $fechaFinal = new DateTime($fechaFin);
                $exito = true;

                while ($fechaActual <= $fechaFinal) {
                    $request = $this->model->insertPermiso(
                        $idFuncionario,
                        $fechaActual->format('Y-m-d'),
                        1, // ID del motivo (puedes ajustar según tu necesidad)
                        1, // Es permiso especial
                        $justificacion
                    );

                    if ($request <= 0) {
                        $exito = false;
                        break;
                    }

                    $fechaActual->modify('+1 day');
                }

                if ($exito) {
                    $arrResponse = array('status' => true, 'msg' => 'Permiso especial registrado correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al registrar el permiso especial');
                }

            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al procesar la solicitud: ' . $e->getMessage());
            }

            header('Content-Type: application/json');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}