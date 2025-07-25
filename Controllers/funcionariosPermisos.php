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

                // Formatear el número de permisos como "X/3" y agregar permisos especiales
                $arrData[$i]['permisos'] = $arrData[$i]['permisos_mes_actual'] . "/3";
                $arrData[$i]['permisos_especiales'] = $arrData[$i]['permisos_especiales_mes'];

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="far fa-eye"></i></button>';
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
    
    public function getPermisosPorFecha($fecha = null)
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                // Si no se proporciona fecha, usar la fecha actual
                if ($fecha === null) {
                    $fecha = date('Y-m-d');
                }
                
                $total = $this->model->getPermisosPorFecha($fecha);
                $arrResponse = array('status' => true, 'total' => $total);
                
            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al obtener los permisos por fecha.');
                error_log("Error en getPermisosPorFecha: " . $e->getMessage());
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
                    
                    // Validar límite de permisos por día específico
                    $permisosPorFecha = $this->model->getPermisosPorFecha($fechaPermiso);
                    $maxPermisosDiarios = defined('MAX_PERMISOS_DIARIOS') ? MAX_PERMISOS_DIARIOS : 5;
                    if ($permisosPorFecha >= $maxPermisosDiarios) {
                        $fechaFormateada = date('d/m/Y', strtotime($fechaPermiso));
                        $arrResponse = array('status' => false, 'msg' => 'Ya se han otorgado los ' . $maxPermisosDiarios . ' permisos máximos permitidos para el día ' . $fechaFormateada);
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
        if (!$_SESSION['permisosMod']['r']) {
            return;
        }
        
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
                
                // Incluir FPDI
                require_once 'vendor/setasign/fpdi/src/autoload.php';
                
                // Crear instancia de FPDI
                $pdf = new \setasign\Fpdi\Fpdi();
                
                // Ruta a la plantilla
                $templatePath = 'Assets/plantillas/plantilla_historial_permiso.pdf';
                if (!file_exists($templatePath)) {
                    throw new Exception("No se encontró la plantilla del historial de permisos");
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
                
                // Permisos del mes
                $pdf->SetX(20);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, mb_convert_encoding('Permisos:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(130, 8, $funcionario['permisos_mes_actual'] . '/3', 1, 1, 'L');
                
                // Espacio entre tablas
                $pdf->Ln(10);
                
                // Posición inicial para la tabla de historial
                $pdf->SetXY(20, $pdf->GetY());
                
                if (!empty($historial)) {
                    // Encabezados de la tabla de historial
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->SetFillColor(230, 230, 230);
                    $pdf->Cell(35, 8, 'Fecha', 1, 0, 'C', true);
                    $pdf->Cell(85, 8, 'Motivo', 1, 0, 'C', true);
                    $pdf->Cell(35, 8, 'Estado', 1, 0, 'C', true);
                    $pdf->Cell(15, 8, 'Tipo', 1, 1, 'C', true);
                    
                    // Datos de la tabla
                    $pdf->SetFont('Arial', '', 9);
                    foreach ($historial as $item) {
                        $fechaPermiso = date('d/m/Y', strtotime($item['fecha_permiso']));
                        $pdf->SetX(20);
                        $pdf->Cell(35, 8, $fechaPermiso, 1, 0, 'C');
                        
                        // Determinar el tipo de permiso
                        $tipoPermiso = ($item['es_permiso_especial'] == 1) ? 'Especial' : 'Normal';
                        $motivo = $item['motivo'];
                        
                        
                        
                        $pdf->Cell(85, 8, mb_convert_encoding($motivo, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
                        $pdf->Cell(35, 8, mb_convert_encoding($item['estado'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                        $pdf->Cell(15, 8, $tipoPermiso, 1, 1, 'C');
                        
                        // Si la tabla llega al final de la página, agregar una nueva y redibujar encabezado
                        if($pdf->GetY() > 250) {
                            $pdf->AddPage();
                            $pdf->useTemplate($tplIdx);
                            $pdf->SetXY(20, 30);
                            $pdf->SetFont('Arial', 'B', 10);
                            $pdf->SetFillColor(230, 230, 230);
                            $pdf->Cell(35, 8, 'Fecha', 1, 0, 'C', true);
                            $pdf->Cell(85, 8, 'Motivo', 1, 0, 'C', true);
                            $pdf->Cell(35, 8, 'Estado', 1, 0, 'C', true);
                            $pdf->Cell(15, 8, 'Tipo', 1, 1, 'C', true);
                            $pdf->SetFont('Arial', '', 9);
                        }
                    }
                } else {
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(0, 10, 'No hay registros de permisos para este funcionario.', 0, 1, 'C');
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
                $nombreArchivo = 'Historial_Permisos_' . $nombreFuncionario . '.pdf';
                
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
                    
                    // Incluir FPDI para usar la plantilla
                    require_once 'vendor/setasign/fpdi/src/autoload.php';
                    
                    // Crear instancia de FPDI
                    $pdf = new \setasign\Fpdi\Fpdi();
                    
                    // Ruta a la plantilla de la alcaldía
                    $templatePath = 'Assets/plantillas/Plantillapdfalcaldia.pdf';
                    if (!file_exists($templatePath)) {
                        throw new Exception("No se encontró la plantilla de la alcaldía");
                    }
                    
                    // Agregar la página de la plantilla
                    $pdf->setSourceFile($templatePath);
                    $tplIdx = $pdf->importPage(1);
                    
                    // Agregar página
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx);
                    
                    // Configurar fuente
                    $pdf->SetFont('Arial', '', 12);
                    
                    // Fecha actual
                    $fechaActual = date('d/m/Y');
                    
                    // Posición para la fecha (ajustar según la plantilla)
                    $pdf->SetXY(25, 30);
                    $pdf->Cell(0, 8, utf8_decode('La Jagua de Ibirico, Cesar ' . $fechaActual), 0, 1, 'L');
                    
                    // Destinatario
                    $pdf->SetXY(25, 50);
                    $pdf->Cell(0, 8, utf8_decode('Señor,'), 0, 1, 'L');
                    $pdf->SetXY(25, 58);
                    $pdf->Cell(0, 8, utf8_decode($funcionario['nombre_completo']), 0, 1, 'L');
                    $pdf->SetXY(25, 66);
                    $pdf->Cell(0, 8, utf8_decode($funcionario['cargo_nombre']), 0, 1, 'L');
                    $pdf->SetXY(25, 74);
                    $pdf->Cell(0, 8, utf8_decode('Alcaldía Municipal de La Jagua de Ibirico'), 0, 1, 'L');
                    
                    // Asunto
                    $pdf->SetXY(25, 90);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 8, utf8_decode('Asunto: Respuesta a Solicitud'), 0, 1, 'L');
                    
                    // Saludo
                    $pdf->SetXY(25, 110);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(0, 8, utf8_decode('Cordial saludo'), 0, 1, 'L');
                    
                    // Fecha del permiso
                    $fechaPermiso = date('d/m/Y', strtotime($permiso['fecha_permiso']));
                    
                    // Contenido principal
                    $pdf->SetXY(25, 130);
                    $contenido = 'De forma respetuosa y con aprecio me dirijo a usted para informarle que su solicitud de permiso para el día ' . $fechaPermiso . ', por concepto "' . $permiso['motivo'] . '" después de analizado fue aprobado por esta unidad.';
                    $pdf->MultiCell(160, 8, utf8_decode($contenido), 0, 'J');
                    
                    // Firmas
                    $pdf->SetXY(25, 170);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 8, utf8_decode('MOISES XAVIER PATERNINA VASQUEZ'), 0, 1, 'C');
                    $pdf->SetXY(25, 180);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(0, 8, utf8_decode('Jefe Oficina Asesora de Talento Humano'), 0, 1, 'C');
                    
                    // Proyectó y Revisó
                    $pdf->SetXY(25, 200);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(0, 6, utf8_decode('Proyectó:	Yuleima Aguilar Lima- Secretaria Ejecutiva'), 0, 1, 'L');
                    $pdf->SetXY(25, 210);
                    $pdf->Cell(0, 6, utf8_decode('Revisó:	Moisés Paternina Vásquez-jefe Talento Humano'), 0, 1, 'L');
                    
                    // Texto de responsabilidad (más pequeño)
                    $pdf->SetXY(25, 230);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(160, 6, utf8_decode('Los arriba firmantes declaramos que hemos revisado el documento, cuyo contenido se encuentra ajustado a las disposiciones legales vigentes, bajo nuestra responsabilidad lo presentamos para firma.'), 0, 'J');
                    
                    // Asegurarse de que no haya salida antes del PDF
                    while (ob_get_level()) {
                        ob_end_clean();
                    }
                    
                    // Configurar encabezados para forzar la descarga
                    $nombreArchivoPermiso = 'Permiso_'.iconv('UTF-8', 'ASCII//TRANSLIT', $funcionario['nombre_completo']).'_'.$fechaPermiso.'.pdf';
                    $nombreArchivoPermiso = str_replace(' ', '_', $nombreArchivoPermiso);
                    $nombreArchivoPermiso = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $nombreArchivoPermiso);
                    
                    header('Content-Type: application/pdf');
                    header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
                    header('Pragma: public');
                    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                    header('Content-Disposition: attachment; filename="'.$nombreArchivoPermiso.'"; filename*=UTF-8\'\''.rawurlencode($nombreArchivoPermiso));
                    
                    // Generar el PDF
                    $pdf->Output('D', $nombreArchivoPermiso);
                    exit();
                    
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
                    empty($_POST['txtFechaFinEspecial']) || empty($_POST['listJustificacionEspecial'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                $idFuncionario = intval($_POST['idFuncionarioEspecial']);
                $fechaInicio = $_POST['txtFechaInicioEspecial'];
                $fechaFin = $_POST['txtFechaFinEspecial'];
                $justificacion = $_POST['listJustificacionEspecial'];
                $otroJustificacion = isset($_POST['txtOtroJustificacion']) ? $_POST['txtOtroJustificacion'] : '';
                
                // Si seleccionó "Otro (especificar)", validar que haya especificado
                if ($justificacion == 'Otro (especificar)' && empty($otroJustificacion)) {
                    $arrResponse = array('status' => false, 'msg' => 'Debe especificar el motivo cuando selecciona "Otro".');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                // Si seleccionó "Otro", usar el texto especificado
                if ($justificacion == 'Otro (especificar)') {
                    $justificacion = $otroJustificacion;
                }

                // Validar que la fecha de fin no sea menor que la fecha de inicio
                if (strtotime($fechaFin) < strtotime($fechaInicio)) {
                    $arrResponse = array('status' => false, 'msg' => 'La fecha de fin no puede ser menor que la fecha de inicio');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                // Validar que el rango de fechas no sea muy extenso (máximo 30 días)
                $fechaInicioObj = new DateTime($fechaInicio);
                $fechaFinObj = new DateTime($fechaFin);
                $diferencia = $fechaInicioObj->diff($fechaFinObj);
                if ($diferencia->days > 30) {
                    $arrResponse = array('status' => false, 'msg' => 'El rango de fechas no puede exceder los 30 días');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                // Insertar el permiso especial para cada día en el rango
                $fechaActual = new DateTime($fechaInicio);
                $fechaFinal = new DateTime($fechaFin);
                $exito = true;
                $permisosInsertados = 0;

                while ($fechaActual <= $fechaFinal) {
                    $fechaFormato = $fechaActual->format('Y-m-d');
                    
                    // Verificar si ya existe un permiso en esa fecha
                    $existePermiso = $this->model->existePermisoEnFecha($idFuncionario, $fechaFormato, true);
                    
                    // Verificar el límite de permisos diarios para esta fecha
                    $permisosPorFecha = $this->model->getPermisosPorFecha($fechaFormato);
                    $maxPermisosDiarios = defined('MAX_PERMISOS_DIARIOS') ? MAX_PERMISOS_DIARIOS : 5;
                    if ($permisosPorFecha >= $maxPermisosDiarios) {
                        $fechaFormateada = $fechaActual->format('d/m/Y');
                        $arrResponse = array('status' => false, 'msg' => 'Ya se han otorgado los ' . $maxPermisosDiarios . ' permisos máximos permitidos para el día ' . $fechaFormateada);
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                    
                    if (!$existePermiso) {
                        $request = $this->model->insertPermiso(
                            $idFuncionario,
                            $fechaActual->format('Y-m-d'),
                            1, // ID del motivo (Cita médica como predeterminado)
                            1, // Es permiso especial
                            $justificacion
                        );

                        if ($request > 0) {
                            $permisosInsertados++;
                        } else {
                            $exito = false;
                            break;
                        }
                    } else {
                        // Si ya existe un permiso especial en esa fecha, continuar con el siguiente día
                        // pero no contar como error
                    }

                    $fechaActual->modify('+1 day');
                }

                if ($exito && $permisosInsertados > 0) {
                    $arrResponse = array('status' => true, 'msg' => "Permiso especial registrado correctamente para $permisosInsertados día(s)");
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al registrar el permiso especial o no se pudieron insertar permisos');
                }

            } catch (Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al procesar la solicitud: ' . $e->getMessage());
            }

            header('Content-Type: application/json');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // API para gráficos de permisos
    public function getFuncionariosMasPermisosPorMes()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $data = $this->model->getFuncionariosMasPermisosPorMes($anio);
            echo json_encode($data);
        }
        die();
    }
    public function getCantidadPermisosPorFuncionario()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $data = $this->model->getCantidadPermisosPorFuncionario($anio);
            echo json_encode($data);
        }
        die();
    }
    public function getDependenciaMasPermisos()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $data = $this->model->getDependenciaMasPermisos($anio);
            echo json_encode($data);
        }
        die();
    }

    public function getAniosConPermisos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $data = $this->model->getAniosConPermisos();
            echo json_encode($data);
        }
        die();
    }

    public function getResumenPermisos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $data = $this->model->getResumenPermisos();
            echo json_encode($data);
        }
        die();
    }
}
