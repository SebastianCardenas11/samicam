<?php

class HojaVidaEquipos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(19);
        $this->model = new HojaVidaEquiposModel();
    }

    public function hojaVidaEquipos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Hoja de Vida Equipos";
        $data['page_title'] = "HOJA DE VIDA EQUIPOS";
        $data['page_name'] = "hoja_vida_equipos";
        $data['page_functions_js'] = "functions_hoja_vida_equipos.js";
        $this->views->getView($this, "hoja_vida_equipos", $data);
    }

    public function getEquipos()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectEquipos();
                for ($i = 0; $i < count($arrData); $i++) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewEquipo(' . $arrData[$i]['id'] . ',\'' . $arrData[$i]['tipo'] . '\')" title="Ver equipo"><i class="far fa-eye"></i></button>';
                    $btnPdf = '<button class="btn btn-danger btn-sm" onClick="fntPdfEquipo(' . $arrData[$i]['id'] . ',\'' . $arrData[$i]['tipo'] . '\')" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>';
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPdf . '</div>';
                }
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            echo json_encode([]);
        }
        die();
    }

    public function getEquipo()
    {
        if ($_SESSION['permisosMod']['r']) {
            $idequipo = $_GET['id'] ?? 0;
            $tipo = $_GET['tipo'] ?? '';
            
            $arrData = $this->model->selectEquipo($idequipo, $tipo);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function generarPdf()
    {
        if (!$_SESSION['permisosMod']['r']) {
            header("Location:" . base_url() . '/dashboard');
            exit;
        }
        
        $idequipo = $_GET['id'] ?? 0;
        $tipo = $_GET['tipo'] ?? '';
        
        if (empty($idequipo) || empty($tipo)) {
            echo 'Parámetros inválidos';
            exit;
        }
        
        $arrData = $this->model->selectEquipo($idequipo, $tipo);
        
        if (empty($arrData)) {
            echo 'Equipo no encontrado';
            exit;
        }
        
        $this->generarPdfConPlantilla($arrData, $tipo);
    }
    
    private function generarPdfConPlantilla($data, $tipo)
    {
        try {
            require_once dirname(__DIR__) . '/vendor/autoload.php';
            
            // Verificar si existe la plantilla
            $plantillaPath = dirname(__DIR__) . '/Assets/plantillas/plantilla_viaticos.pdf';
            if (!file_exists($plantillaPath)) {
                // Si no existe la plantilla, usar mPDF normal
                $this->generarPdfSinPlantilla($data, $tipo);
                return;
            }
            
            // Limpiar buffer de salida
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Usar FPDI para trabajar con la plantilla
            $pdf = new \setasign\Fpdi\Fpdi();
            $pdf->setSourceFile($plantillaPath);
            $tplId = $pdf->importPage(1);
            
            $pdf->AddPage();
            $pdf->useTemplate($tplId, 0, 0, 210);
            
            // Configurar fuente y color
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            
            // Función para convertir texto a Latin1
            $toLatin1 = function($text) {
                // Reemplazar caracteres problemáticos manualmente
                $replacements = [
                    'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                    'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
                    'ñ' => 'n', 'Ñ' => 'N', 'ü' => 'u', 'Ü' => 'U'
                ];
                $text = str_replace(array_keys($replacements), array_values($replacements), $text);
                return iconv('UTF-8', 'ISO-8859-1//IGNORE', $text);
            };
            
            // Agregar contenido sobre la plantilla
            $this->agregarContenidoSobrePlantilla($pdf, $data, $tipo, $toLatin1);
            
            $filename = 'Hoja_Vida_' . str_replace([' ', 'á', 'é', 'í', 'ó', 'ú', 'ñ'], ['_', 'a', 'e', 'i', 'o', 'u', 'n'], $tipo) . '_' . $data['numero_equipo'] . '.pdf';
            
            // Headers para forzar descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            $pdf->Output('D', $filename);
            exit;
        } catch (Exception $e) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            exit;
        }
    }
    
    private function generarPdfSinPlantilla($data, $tipo)
    {
        try {
            require_once dirname(__DIR__) . '/vendor/autoload.php';
            
            // Limpiar buffer de salida
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 20,
                'margin_bottom' => 20
            ]);
            
            $html = $this->getHtmlPdf($data, $tipo);
            $mpdf->WriteHTML($html);
            
            $filename = 'Hoja_Vida_' . str_replace([' ', 'á', 'é', 'í', 'ó', 'ú', 'ñ'], ['_', 'a', 'e', 'i', 'o', 'u', 'n'], $tipo) . '_' . $data['numero_equipo'] . '.pdf';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            $mpdf->Output($filename, 'D');
            exit;
        } catch (Exception $e) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            exit;
        }
    }
    
    private function agregarContenidoSobrePlantilla($pdf, $data, $tipo, $toLatin1)
    {
        // Título del documento
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(0, 38);
        $pdf->Cell(210, 8, $toLatin1('HOJA DE VIDA DE EQUIPO - ' . strtoupper($tipo)), 0, 1, 'C');
        
        // Configuración de tabla
        $startX = 14;
        $startY = 50;
        $h = 6;
        
        // Información básica
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY($startX, $startY);
        $pdf->Cell(186, $h, $toLatin1('INFORMACIÓN BÁSICA'), 1, 1, 'C');
        
        $y = $startY + $h;
        $this->crearTablaInformacion($pdf, $data, $tipo, $y, $toLatin1, $startX, $h);
        
        // Especificaciones técnicas (si aplica)
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno', 'Impresora'])) {
            $y += 10;
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY($startX, $y);
            $pdf->Cell(186, $h, $toLatin1('ESPECIFICACIONES TÉCNICAS'), 1, 1, 'C');
            $y += $h;
            $this->crearTablaEspecificaciones($pdf, $data, $tipo, $y, $toLatin1, $startX, $h);
        }
        
        // Mantenimientos del equipo
        $mantenimientos = $this->model->selectMantenimientos($data['id'], $tipo);
        $y += 15;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY($startX, $y);
        $pdf->Cell(186, $h, $toLatin1('HISTORIAL DE MANTENIMIENTOS'), 1, 1, 'C');
        $y += $h;
        $this->crearTablaMantenimientos($pdf, $mantenimientos, $y, $toLatin1, $startX, $h);
        
        // Movimientos del equipo
        $movimientos = $this->model->getMovimientosEquipo($data['id'], $tipo);
        $y += 15;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY($startX, $y);
        $pdf->Cell(186, $h, $toLatin1('MOVIMIENTOS DEL EQUIPO'), 1, 1, 'C');
        $y += $h;
        $this->crearTablaMovimientos($pdf, $movimientos, $y, $toLatin1, $startX, $h);
        
        // Pie de página (ajustar posición según contenido)
        $footerY = max($y + 10, 250);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($startX, $footerY);
        $pdf->Cell(186, 6, $toLatin1('Documento generado el ' . date('d/m/Y H:i:s')), 0, 1, 'C');
    }
    
    private function crearTablaInformacion($pdf, $data, $tipo, &$y, $toLatin1, $startX, $h)
    {
        $pdf->SetFont('Arial', '', 9);
        
        // Datos básicos
        $campos = [
            ['Número de Equipo', $data['numero_equipo'] ?? 'N/A'],
            ['Marca', $data['marca'] ?? 'N/A'],
            ['Modelo', $data['modelo'] ?? 'N/A'],
            ['Serial', $data['serial'] ?? 'N/A'],
            ['Estado', $data['estado'] ?? 'N/A'],
            ['Disponibilidad', $data['disponibilidad'] ?? 'N/A'],
            ['Fecha de Registro', isset($data['fecha_registro']) ? date('d/m/Y', strtotime($data['fecha_registro'])) : 'N/A']
        ];
        
        foreach ($campos as $campo) {
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(60, $h, $toLatin1($campo[0] . ':'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(126, $h, $toLatin1($campo[1]), 1, 1, 'L');
            $y += $h;
        }
    }
    
    private function crearTablaEspecificaciones($pdf, $data, $tipo, &$y, $toLatin1, $startX, $h)
    {
        $pdf->SetFont('Arial', '', 9);
        
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno'])) {
            $campos = [
                ['RAM', ($data['ram'] ?? 'N/A') . (isset($data['velocidad_ram']) && $data['velocidad_ram'] != 'N/A' ? ' - ' . $data['velocidad_ram'] : '')],
                ['Procesador', ($data['procesador'] ?? 'N/A') . (isset($data['velocidad_procesador']) && $data['velocidad_procesador'] != 'N/A' ? ' - ' . $data['velocidad_procesador'] : '')],
                ['Disco Duro', ($data['disco_duro'] ?? 'N/A') . (isset($data['capacidad']) && $data['capacidad'] != 'N/A' ? ' - ' . $data['capacidad'] : '')],
                ['Sistema Operativo', $data['sistema_operativo'] ?? 'N/A']
            ];
        } elseif ($tipo === 'Impresora') {
            $campos = [
                ['Consumible', $data['consumible'] ?? 'N/A']
            ];
        } else {
            $campos = [];
        }
        
        foreach ($campos as $campo) {
            $pdf->SetX($startX);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(60, $h, $toLatin1($campo[0] . ':'), 1, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(126, $h, $toLatin1($campo[1]), 1, 1, 'L');
            $y += $h;
        }
    }
    
    private function crearTablaMovimientos($pdf, $movimientos, &$y, $toLatin1, $startX, $h)
    {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX($startX);
        $pdf->Cell(30, $h, $toLatin1('Fecha'), 1, 0, 'C');
        $pdf->Cell(40, $h, $toLatin1('Tipo'), 1, 0, 'C');
        $pdf->Cell(70, $h, $toLatin1('Descripción'), 1, 0, 'C');
        $pdf->Cell(46, $h, $toLatin1('Usuario'), 1, 1, 'C');
        $y += $h;
        
        $pdf->SetFont('Arial', '', 8);
        if (empty($movimientos)) {
            $pdf->SetX($startX);
            $pdf->Cell(186, $h, $toLatin1('No hay movimientos registrados'), 1, 1, 'C');
            $y += $h;
        } else {
            foreach ($movimientos as $mov) {
                $pdf->SetX($startX);
                $pdf->Cell(30, $h, isset($mov['fecha']) ? date('d/m/Y', strtotime($mov['fecha'])) : 'N/A', 1, 0, 'C');
                $pdf->Cell(40, $h, $toLatin1($mov['tipo'] ?? 'N/A'), 1, 0, 'L');
                $pdf->Cell(70, $h, $toLatin1($mov['descripcion'] ?? 'N/A'), 1, 0, 'L');
                $pdf->Cell(46, $h, $toLatin1($mov['usuario'] ?? 'N/A'), 1, 1, 'L');
                $y += $h;
                
                if ($y > 230) break;
            }
        }
    }

    public function generarPdfTodos()
    {
        if (!$_SESSION['permisosMod']['r']) {
            header("Location:" . base_url() . '/dashboard');
            exit;
        }
        
        $arrData = $this->model->selectEquipos();
        
        if (empty($arrData)) {
            echo 'No hay equipos registrados';
            exit;
        }
        
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        
        $plantillaPath = dirname(__DIR__) . '/Assets/plantillas/plantilla_viaticos.pdf';
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->setSourceFile($plantillaPath);
        $tplId = $pdf->importPage(1);
        
        $pdf->AddPage();
        $pdf->useTemplate($tplId, 0, 0, 210);
        
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(0, 40);
        $pdf->Cell(210, 8, iconv('UTF-8', 'ISO-8859-1', 'INVENTARIO GENERAL DE EQUIPOS'), 0, 1, 'C');
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, 60);
        $pdf->Cell(35, 6, 'Tipo', 1, 0, 'C');
        $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', 'Número'), 1, 0, 'C');
        $pdf->Cell(35, 6, 'Marca', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Modelo', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Estado', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Disponible', 1, 1, 'C');
        
        $pdf->SetFont('Arial', '', 8);
        $y = 66;
        foreach ($arrData as $equipo) {
            if ($y > 250) {
                $pdf->AddPage();
                $pdf->useTemplate($tplId, 0, 0, 210);
                $y = 60;
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetXY(15, $y);
                $pdf->Cell(35, 6, 'Tipo', 1, 0, 'C');
                $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', 'Número'), 1, 0, 'C');
                $pdf->Cell(35, 6, 'Marca', 1, 0, 'C');
                $pdf->Cell(35, 6, 'Modelo', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Estado', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Disponible', 1, 1, 'C');
                $pdf->SetFont('Arial', '', 8);
                $y += 6;
            }
            
            $pdf->SetXY(15, $y);
            $pdf->Cell(35, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['tipo']), 1, 0, 'L');
            $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['numero_equipo']), 1, 0, 'C');
            $pdf->Cell(35, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['marca']), 1, 0, 'L');
            $pdf->Cell(35, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['modelo']), 1, 0, 'L');
            $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['estado']), 1, 0, 'C');
            $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', $equipo['disponibilidad']), 1, 1, 'C');
            $y += 6;
        }
        
        $filename = 'Inventario_Equipos_' . date('Y-m-d') . '.pdf';
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $pdf->Output('D', $filename);
        exit;
    }



    private function getHtmlEquipo($data, $tipo)
    {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
            .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #004884; padding-bottom: 15px; }
            .logo { width: 80px; height: auto; }
            .title { color: #004884; font-size: 16px; font-weight: bold; margin: 10px 0; }
            .subtitle { color: #666; font-size: 12px; }
            .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            .table th { background-color: #004884; color: white; padding: 8px; text-align: left; font-weight: bold; }
            .table td { border: 1px solid #ddd; padding: 8px; }
            .section { margin-bottom: 20px; }
            .section-title { background-color: #f0f0f0; padding: 5px; font-weight: bold; color: #004884; }
        </style>
        <div class="header">
            <h1 class="title">ALCALDÍA DE LA JAGUA DE IBIRICO</h1>
            <p class="subtitle">Sistema Administrativo de Módulos de Información del CAM - SAMICAM</p>
            <h2 style="color: #004884; margin-top: 20px;">HOJA DE VIDA DE EQUIPO - ' . strtoupper($tipo) . '</h2>
        </div>
        
        <div class="section">
            <div class="section-title">INFORMACIÓN BÁSICA</div>
            <table class="table">
                <tr><th style="width: 30%;">Número de Equipo:</th><td>' . $data['numero_equipo'] . '</td></tr>
                <tr><th>Marca:</th><td>' . $data['marca'] . '</td></tr>
                <tr><th>Modelo:</th><td>' . $data['modelo'] . '</td></tr>
                <tr><th>Serial:</th><td>' . $data['serial'] . '</td></tr>
                <tr><th>Estado:</th><td>' . $data['estado'] . '</td></tr>
                <tr><th>Disponibilidad:</th><td>' . $data['disponibilidad'] . '</td></tr>
                <tr><th>Fecha de Registro:</th><td>' . date('d/m/Y', strtotime($data['fecha_registro'])) . '</td></tr>
            </table>
        </div>';
        
        // Agregar campos específicos según el tipo
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno'])) {
            $html .= '<div class="section">
                <div class="section-title">ESPECIFICACIONES TÉCNICAS</div>
                <table class="table">
                    <tr><th style="width: 30%;">RAM:</th><td>' . $data['ram'] . ($data['velocidad_ram'] != 'N/A' ? ' - ' . $data['velocidad_ram'] : '') . '</td></tr>
                    <tr><th>Procesador:</th><td>' . $data['procesador'] . ($data['velocidad_procesador'] != 'N/A' ? ' - ' . $data['velocidad_procesador'] : '') . '</td></tr>
                    <tr><th>Disco Duro:</th><td>' . $data['disco_duro'] . ($data['capacidad'] != 'N/A' ? ' - ' . $data['capacidad'] : '') . '</td></tr>
                    <tr><th>Sistema Operativo:</th><td>' . $data['sistema_operativo'] . '</td></tr>';
            if (isset($data['numero_activo'])) {
                $html .= '<tr><th>Número de Activo:</th><td>' . $data['numero_activo'] . '</td></tr>';
            }
            $html .= '</table></div>';
        } elseif ($tipo === 'Impresora') {
            $html .= '<div class="section">
                <div class="section-title">ESPECIFICACIONES</div>
                <table class="table">
                    <tr><th style="width: 30%;">Consumible:</th><td>' . $data['consumible'] . '</td></tr>
                </table>
            </div>';
        }
        
        // Agregar mantenimientos
        $mantenimientos = $this->model->selectMantenimientos($data['id'], $tipo);
        $html .= '<div class="section">
            <div class="section-title">HISTORIAL DE MANTENIMIENTOS</div>';
        if (empty($mantenimientos)) {
            $html .= '<p>No hay mantenimientos registrados</p>';
        } else {
            $html .= '<table class="table">
                <tr><th>Fecha</th><th>Estación</th><th>Usuario</th><th>Tipo</th><th>Error</th><th>Técnico</th></tr>';
            foreach ($mantenimientos as $mant) {
                $html .= '<tr>
                    <td>' . date('d/m/Y', strtotime($mant['fecha_mantenimiento'])) . '</td>
                    <td>' . $mant['estacion_trabajo'] . '</td>
                    <td>' . $mant['nombre_usuario'] . '</td>
                    <td>' . $mant['tipo_dispositivo'] . '</td>
                    <td>' . substr($mant['error_reportado'], 0, 50) . '...</td>
                    <td>' . $mant['tecnico_servicio'] . '</td>
                </tr>';
            }
            $html .= '</table>';
        }
        $html .= '</div>';
        
        $html .= '<div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
            <p>Documento generado el ' . date('d/m/Y H:i:s') . '</p>
            <p>Alcaldía de La Jagua de Ibirico - Cesar, Colombia</p>
        </div>';
        
        return $html;
    }

    private function getHtmlTodosEquipos($data)
    {
        $totalEquipos = count($data);
        
        $html = '<style>
            body { font-family: Arial, sans-serif; font-size: 10px; margin: 15px; }
            .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #004884; padding-bottom: 15px; }
            .title { color: #004884; font-size: 16px; font-weight: bold; margin: 10px 0; }
            .subtitle { color: #666; font-size: 12px; }
            .stats { background-color: #f8f9fa; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
            .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 9px; }
            .table th { background-color: #004884; color: white; padding: 6px 4px; text-align: center; font-weight: bold; }
            .table td { border: 1px solid #ddd; padding: 4px; text-align: left; }
            .table tr:nth-child(even) { background-color: #f9f9f9; }
            .footer { text-align: center; margin-top: 20px; font-size: 8px; color: #666; }
        </style>
        
        <div class="header">
            <h1 class="title">ALCALDÍA DE LA JAGUA DE IBIRICO</h1>
            <p class="subtitle">Sistema SAMICAM - Inventario General de Equipos</p>
            <p style="color: #004884; font-weight: bold;">Fecha de Generación: ' . date('d/m/Y H:i:s') . '</p>
        </div>
        
        <div class="stats">
            <strong>Total de Equipos Registrados: ' . $totalEquipos . '</strong>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15%;">Tipo</th>
                    <th style="width: 12%;">Número</th>
                    <th style="width: 15%;">Marca</th>
                    <th style="width: 18%;">Modelo</th>
                    <th style="width: 15%;">Serial</th>
                    <th style="width: 12%;">Estado</th>
                    <th style="width: 13%;">Disponibilidad</th>
                </tr>
            </thead>
            <tbody>';
        
        if (empty($data)) {
            $html .= '<tr><td colspan="7" style="text-align: center; padding: 20px;">No hay equipos registrados</td></tr>';
        } else {
            foreach ($data as $equipo) {
                $html .= '<tr>
                    <td>' . htmlspecialchars($equipo['tipo']) . '</td>
                    <td>' . htmlspecialchars($equipo['numero_equipo']) . '</td>
                    <td>' . htmlspecialchars($equipo['marca']) . '</td>
                    <td>' . htmlspecialchars($equipo['modelo']) . '</td>
                    <td>' . htmlspecialchars($equipo['serial']) . '</td>
                    <td>' . htmlspecialchars($equipo['estado']) . '</td>
                    <td>' . htmlspecialchars($equipo['disponibilidad']) . '</td>
                </tr>';
            }
        }
        
        $html .= '</tbody></table>
        
        <div class="footer">
            <p>Documento generado automáticamente por el Sistema SAMICAM</p>
            <p>Alcaldía de La Jagua de Ibirico - Cesar, Colombia</p>
        </div>';
        
        return $html;
    }
    
    private function getHtmlSimple($data, $tipo)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hoja de Vida - ' . $tipo . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #004884; padding-bottom: 15px; }
        .title { color: #004884; font-size: 18px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background-color: #004884; color: white; padding: 8px; }
        td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">ALCALDÍA DE LA JAGUA DE IBIRICO</h1>
        <p>HOJA DE VIDA DE EQUIPO - ' . strtoupper($tipo) . '</p>
    </div>
    
    <table>
        <tr><th>Número de Equipo:</th><td>' . $data['numero_equipo'] . '</td></tr>
        <tr><th>Marca:</th><td>' . $data['marca'] . '</td></tr>
        <tr><th>Modelo:</th><td>' . $data['modelo'] . '</td></tr>
        <tr><th>Serial:</th><td>' . $data['serial'] . '</td></tr>
        <tr><th>Estado:</th><td>' . $data['estado'] . '</td></tr>
        <tr><th>Disponibilidad:</th><td>' . $data['disponibilidad'] . '</td></tr>
        <tr><th>Fecha de Registro:</th><td>' . date('d/m/Y', strtotime($data['fecha_registro'])) . '</td></tr>';
        
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno'])) {
            $html .= '<tr><th>RAM:</th><td>' . $data['ram'] . '</td></tr>
                     <tr><th>Procesador:</th><td>' . $data['procesador'] . '</td></tr>
                     <tr><th>Disco Duro:</th><td>' . $data['disco_duro'] . ' - ' . $data['capacidad'] . '</td></tr>
                     <tr><th>Sistema Operativo:</th><td>' . $data['sistema_operativo'] . '</td></tr>';
        } elseif ($tipo === 'Impresora') {
            $html .= '<tr><th>Consumible:</th><td>' . $data['consumible'] . '</td></tr>';
        }
        
        $html .= '</table>
    <p style="text-align: center; margin-top: 40px; font-size: 12px;">Generado el ' . date('d/m/Y H:i:s') . '</p>
</body>
</html>';
        
        return $html;
    }
    
    private function getHtmlPdf($data, $tipo)
    {
        $html = '<style>
            body { font-family: Arial, sans-serif; font-size: 11px; }
            .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #004884; padding-bottom: 15px; }
            .title { color: #004884; font-size: 16px; font-weight: bold; margin: 10px 0; }
            .subtitle { color: #666; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th { background-color: #004884; color: white; padding: 8px; text-align: left; font-weight: bold; width: 30%; }
            td { border: 1px solid #ddd; padding: 8px; }
            .section-title { background-color: #f0f0f0; padding: 5px; font-weight: bold; color: #004884; margin-top: 20px; }
        </style>
        
        <div class="header">
            <h1 class="title">ALCALDÍA DE LA JAGUA DE IBIRICO</h1>
            <p class="subtitle">Sistema SAMICAM - Hoja de Vida de Equipo</p>
            <h2 style="color: #004884;">EQUIPO: ' . strtoupper($tipo) . '</h2>
        </div>
        
        <div class="section-title">INFORMACIÓN BÁSICA</div>
        <table>
            <tr><th>Número de Equipo:</th><td>' . $data['numero_equipo'] . '</td></tr>
            <tr><th>Marca:</th><td>' . $data['marca'] . '</td></tr>
            <tr><th>Modelo:</th><td>' . $data['modelo'] . '</td></tr>
            <tr><th>Serial:</th><td>' . $data['serial'] . '</td></tr>
            <tr><th>Estado:</th><td>' . $data['estado'] . '</td></tr>
            <tr><th>Disponibilidad:</th><td>' . $data['disponibilidad'] . '</td></tr>
            <tr><th>Fecha de Registro:</th><td>' . date('d/m/Y', strtotime($data['fecha_registro'])) . '</td></tr>
        </table>';
        
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno'])) {
            $html .= '<div class="section-title">ESPECIFICACIONES TÉCNICAS</div>
            <table>
                <tr><th>RAM:</th><td>' . $data['ram'] . ($data['velocidad_ram'] != 'N/A' ? ' - ' . $data['velocidad_ram'] : '') . '</td></tr>
                <tr><th>Procesador:</th><td>' . $data['procesador'] . ($data['velocidad_procesador'] != 'N/A' ? ' - ' . $data['velocidad_procesador'] : '') . '</td></tr>
                <tr><th>Disco Duro:</th><td>' . $data['disco_duro'] . ($data['capacidad'] != 'N/A' ? ' - ' . $data['capacidad'] : '') . '</td></tr>
                <tr><th>Sistema Operativo:</th><td>' . $data['sistema_operativo'] . '</td></tr>';
            if (isset($data['numero_activo']) && $data['numero_activo'] != 'N/A') {
                $html .= '<tr><th>Número de Activo:</th><td>' . $data['numero_activo'] . '</td></tr>';
            }
            $html .= '</table>';
        } elseif ($tipo === 'Impresora') {
            $html .= '<div class="section-title">ESPECIFICACIONES</div>
            <table>
                <tr><th>Consumible:</th><td>' . $data['consumible'] . '</td></tr>
            </table>';
        }
        
        $html .= '<div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
            <p>Documento generado el ' . date('d/m/Y H:i:s') . '</p>
            <p>Alcaldía de La Jagua de Ibirico - Cesar, Colombia</p>
        </div>';
        
        return $html;
    }
    
    public function getMantenimientos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $idequipo = $_GET['id'] ?? 0;
            $tipo = $_GET['tipo'] ?? '';
            
            $arrData = $this->model->selectMantenimientos($idequipo, $tipo);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([]);
        }
        die();
    }
    
    public function setMantenimiento()
    {
        if ($_SESSION['permisosMod']['w']) {
            $idEquipo = intval($_POST['idEquipoMantenimiento']);
            $tipoEquipo = strClean($_POST['tipoEquipoMantenimiento']);
            $fechaMantenimiento = strClean($_POST['fechaMantenimiento']);
            $estacionTrabajo = strClean($_POST['estacionTrabajo']);
            $nombreUsuario = strClean($_POST['nombreUsuario']);
            $cedulaUsuario = strClean($_POST['cedulaUsuario']);
            $tipoDispositivo = strClean($_POST['tipoDispositivo']);
            $errorReportado = strClean($_POST['errorReportado']);
            $accionesRealizadas = strClean($_POST['accionesRealizadas']);
            $tecnicoServicio = strClean($_POST['tecnicoServicio']);
            
            if (empty($idEquipo) || empty($tipoEquipo) || empty($fechaMantenimiento) || 
                empty($estacionTrabajo) || empty($nombreUsuario) || empty($cedulaUsuario) ||
                empty($tipoDispositivo) || empty($errorReportado) || empty($accionesRealizadas)) {
                $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
            } else {
                $request_mantenimiento = $this->model->insertMantenimiento(
                    $idEquipo, $tipoEquipo, $fechaMantenimiento, $estacionTrabajo,
                    $nombreUsuario, $cedulaUsuario, $tipoDispositivo, $errorReportado,
                    $accionesRealizadas, $tecnicoServicio
                );
                
                if ($request_mantenimiento > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Mantenimiento registrado correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible registrar el mantenimiento.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCurrentUser()
    {
        $arrResponse = array(
            'status' => true, 
            'user' => $_SESSION['userData']['nombres'] ?? 'Usuario Actual'
        );
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    private function crearTablaMantenimientos($pdf, $mantenimientos, &$y, $toLatin1, $startX, $h)
    {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX($startX);
        $pdf->Cell(25, $h, $toLatin1('Fecha'), 1, 0, 'C');
        $pdf->Cell(30, $h, $toLatin1('Estación'), 1, 0, 'C');
        $pdf->Cell(35, $h, 'Usuario', 1, 0, 'C');
        $pdf->Cell(25, $h, 'Tipo', 1, 0, 'C');
        $pdf->Cell(35, $h, 'Error', 1, 0, 'C');
        $pdf->Cell(36, $h, $toLatin1('Técnico'), 1, 1, 'C');
        $y += $h;
        
        $pdf->SetFont('Arial', '', 7);
        if (empty($mantenimientos)) {
            $pdf->SetX($startX);
            $pdf->Cell(186, $h, $toLatin1('No hay mantenimientos registrados'), 1, 1, 'C');
            $y += $h;
        } else {
            foreach ($mantenimientos as $mant) {
                $pdf->SetX($startX);
                $pdf->Cell(25, $h, date('d/m/Y', strtotime($mant['fecha_mantenimiento'])), 1, 0, 'C');
                $pdf->Cell(30, $h, $toLatin1(substr($mant['estacion_trabajo'], 0, 15)), 1, 0, 'L');
                $pdf->Cell(35, $h, $toLatin1(substr($mant['nombre_usuario'], 0, 18)), 1, 0, 'L');
                $pdf->Cell(25, $h, $toLatin1(substr($mant['tipo_dispositivo'], 0, 12)), 1, 0, 'L');
                $pdf->Cell(35, $h, $toLatin1(substr($mant['error_reportado'], 0, 20)), 1, 0, 'L');
                $pdf->Cell(36, $h, $toLatin1(substr($mant['tecnico_servicio'], 0, 18)), 1, 1, 'L');
                $y += $h;
                
                if ($y > 230) break;
            }
        }
    }
    
    public function generarPdfMantenimientos()
    {
        if (!$_SESSION['permisosMod']['r']) {
            header("Location:" . base_url() . '/dashboard');
            exit;
        }
        
        $arrData = $this->model->selectTodosMantenimientos();
        
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        
        $plantillaPath = dirname(__DIR__) . '/Assets/plantillas/plantilla_viaticos.pdf';
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->setSourceFile($plantillaPath);
        $tplId = $pdf->importPage(1);
        
        $pdf->AddPage();
        $pdf->useTemplate($tplId, 0, 0, 210);
        
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(0, 40);
        $pdf->Cell(210, 8, iconv('UTF-8', 'ISO-8859-1', 'REPORTE GENERAL DE MANTENIMIENTOS'), 0, 1, 'C');
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 60);
        $pdf->Cell(20, 6, 'Fecha', 1, 0, 'C');
        $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', 'Equipo'), 1, 0, 'C');
        $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', 'Estación'), 1, 0, 'C');
        $pdf->Cell(25, 6, 'Usuario', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Tipo', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Error', 1, 0, 'C');
        $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', 'Técnico'), 1, 1, 'C');
        
        $pdf->SetFont('Arial', '', 7);
        $y = 66;
        foreach ($arrData as $mantenimiento) {
            if ($y > 250) {
                $pdf->AddPage();
                $pdf->useTemplate($tplId, 0, 0, 210);
                $y = 60;
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetXY(10, $y);
                $pdf->Cell(20, 6, 'Fecha', 1, 0, 'C');
                $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', 'Equipo'), 1, 0, 'C');
                $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', 'Estación'), 1, 0, 'C');
                $pdf->Cell(25, 6, 'Usuario', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Tipo', 1, 0, 'C');
                $pdf->Cell(40, 6, 'Error', 1, 0, 'C');
                $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', 'Técnico'), 1, 1, 'C');
                $pdf->SetFont('Arial', '', 7);
                $y += 6;
            }
            
            $pdf->SetXY(10, $y);
            $pdf->Cell(20, 6, date('d/m/Y', strtotime($mantenimiento['fecha_mantenimiento'])), 1, 0, 'C');
            $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', $mantenimiento['numero_equipo']), 1, 0, 'C');
            $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', substr($mantenimiento['estacion_trabajo'], 0, 15)), 1, 0, 'L');
            $pdf->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', substr($mantenimiento['nombre_usuario'], 0, 12)), 1, 0, 'L');
            $pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', substr($mantenimiento['tipo_dispositivo'], 0, 10)), 1, 0, 'L');
            $pdf->Cell(40, 6, iconv('UTF-8', 'ISO-8859-1', substr($mantenimiento['error_reportado'], 0, 25)), 1, 0, 'L');
            $pdf->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', substr($mantenimiento['tecnico_servicio'], 0, 15)), 1, 1, 'L');
            $y += 6;
        }
        
        $filename = 'Mantenimientos_' . date('Y-m-d') . '.pdf';
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $pdf->Output('D', $filename);
        exit;
    }
}