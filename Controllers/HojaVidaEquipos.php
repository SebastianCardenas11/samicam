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
            require_once 'vendor/autoload.php';
            
            // Verificar si existe la plantilla
            $plantillaPath = 'Assets/plantillas/plantilla_viaticos.pdf';
            if (!file_exists($plantillaPath)) {
                // Si no existe la plantilla, usar mPDF normal
                $this->generarPdfSinPlantilla($data, $tipo);
                return;
            }
            
            // Usar FPDI para trabajar con la plantilla
            $pdf = new \setasign\Fpdi\Fpdi();
            $pdf->setSourceFile($plantillaPath);
            $tplId = $pdf->importPage(1);
            
            $pdf->AddPage();
            $pdf->useTemplate($tplId, 0, 0);
            
            // Configurar fuente
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            
            // Agregar contenido sobre la plantilla
            $this->agregarContenidoSobrePlantilla($pdf, $data, $tipo);
            
            $filename = 'Hoja_Vida_' . str_replace([' ', 'á', 'é', 'í', 'ó', 'ú', 'ñ'], ['_', 'a', 'e', 'i', 'o', 'u', 'n'], $tipo) . '_' . $data['numero_equipo'] . '.pdf';
            
            // Headers para forzar descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            $pdf->Output('D', $filename);
            exit;
        } catch (Exception $e) {
            echo 'Error al generar PDF: ' . $e->getMessage();
            exit;
        }
    }
    
    private function generarPdfSinPlantilla($data, $tipo)
    {
        try {
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
            echo 'Error al generar PDF: ' . $e->getMessage();
            exit;
        }
    }
    
    private function agregarContenidoSobrePlantilla($pdf, $data, $tipo)
    {
        // Título del documento
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(50, 60);
        $pdf->Cell(0, 10, utf8_decode('HOJA DE VIDA DE EQUIPO - ' . strtoupper($tipo)), 0, 1, 'C');
        
        // Tabla de información básica
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(30, 80);
        $pdf->Cell(0, 8, utf8_decode('INFORMACIÓN BÁSICA'), 0, 1, 'L');
        
        $y = 90;
        $this->crearTablaInformacion($pdf, $data, $tipo, $y);
        
        // Obtener movimientos del equipo
        $movimientos = $this->model->getMovimientosEquipo($data['id'], $tipo);
        
        // Tabla de movimientos
        $yMovimientos = $y + 20;
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(30, $yMovimientos);
        $pdf->Cell(0, 8, 'MOVIMIENTOS', 0, 1, 'L');
        
        $this->crearTablaMovimientos($pdf, $movimientos, $yMovimientos + 10);
        
        // Pie de página
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(30, 250);
        $pdf->Cell(0, 6, utf8_decode('Documento generado el ' . date('d/m/Y H:i:s')), 0, 1, 'C');
        $pdf->SetXY(30, 260);
        $pdf->Cell(0, 6, utf8_decode('Alcaldía de La Jagua de Ibirico - Cesar, Colombia'), 0, 1, 'C');
    }
    
    private function crearTablaInformacion($pdf, $data, $tipo, &$y)
    {
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(240, 240, 240);
        
        // Encabezados de tabla
        $pdf->SetXY(30, $y);
        $pdf->Cell(60, 8, utf8_decode('Campo'), 1, 0, 'C', true);
        $pdf->Cell(100, 8, utf8_decode('Información'), 1, 1, 'C', true);
        
        $y += 8;
        $pdf->SetFillColor(255, 255, 255);
        
        // Datos básicos
        $campos = [
            ['Número de Equipo', $data['numero_equipo']],
            ['Marca', $data['marca']],
            ['Modelo', $data['modelo']],
            ['Serial', $data['serial']],
            ['Estado', $data['estado']],
            ['Disponibilidad', $data['disponibilidad']],
            ['Fecha de Registro', date('d/m/Y', strtotime($data['fecha_registro']))]
        ];
        
        // Agregar campos específicos según el tipo
        if (in_array($tipo, ['PC Torre', 'Portátil', 'Todo en Uno'])) {
            $campos[] = ['RAM', $data['ram'] . ($data['velocidad_ram'] != 'N/A' ? ' - ' . $data['velocidad_ram'] : '')];
            $campos[] = ['Procesador', $data['procesador'] . ($data['velocidad_procesador'] != 'N/A' ? ' - ' . $data['velocidad_procesador'] : '')];
            $campos[] = ['Disco Duro', $data['disco_duro'] . ($data['capacidad'] != 'N/A' ? ' - ' . $data['capacidad'] : '')];
            $campos[] = ['Sistema Operativo', $data['sistema_operativo']];
        } elseif ($tipo === 'Impresora') {
            $campos[] = ['Consumible', $data['consumible']];
        }
        
        foreach ($campos as $campo) {
            $pdf->SetXY(30, $y);
            $pdf->Cell(60, 6, utf8_decode($campo[0]), 1, 0, 'L');
            $pdf->Cell(100, 6, utf8_decode($campo[1]), 1, 1, 'L');
            $y += 6;
        }
    }
    
    private function crearTablaMovimientos($pdf, $movimientos, $y)
    {
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(240, 240, 240);
        
        // Encabezados de tabla de movimientos
        $pdf->SetXY(30, $y);
        $pdf->Cell(25, 8, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Tipo', 1, 0, 'C', true);
        $pdf->Cell(50, 8, utf8_decode('Descripción'), 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Usuario', 1, 1, 'C', true);
        
        $y += 8;
        $pdf->SetFillColor(255, 255, 255);
        
        if (empty($movimientos)) {
            $pdf->SetXY(30, $y);
            $pdf->Cell(160, 6, utf8_decode('No hay movimientos registrados'), 1, 1, 'C');
        } else {
            foreach ($movimientos as $mov) {
                $pdf->SetXY(30, $y);
                $pdf->Cell(25, 6, date('d/m/Y', strtotime($mov['fecha'])), 1, 0, 'C');
                $pdf->Cell(40, 6, utf8_decode($mov['tipo']), 1, 0, 'L');
                $pdf->Cell(50, 6, utf8_decode($mov['descripcion']), 1, 0, 'L');
                $pdf->Cell(45, 6, utf8_decode($mov['usuario']), 1, 1, 'L');
                $y += 6;
                
                if ($y > 230) break; // Evitar que se salga de la página
            }
        }
    }

    public function generarPdfTodos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectEquipos();
            $this->generarPdfTodosEquipos($arrData);
        }
        die();
    }

    private function generarPdfEquipo($data, $tipo)
    {
        require_once 'vendor/autoload.php';
        
        try {
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 20,
                'margin_bottom' => 20
            ]);
            
            $html = $this->getHtmlEquipo($data, $tipo);
            $mpdf->WriteHTML($html);
            
            $filename = 'Hoja_Vida_' . str_replace(' ', '_', $tipo) . '_' . $data['numero_equipo'] . '.pdf';
            
            // Forzar descarga directa
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            $mpdf->Output($filename, 'D');
            exit;
        } catch (Exception $e) {
            echo 'Error al generar PDF: ' . $e->getMessage();
            exit;
        }
    }

    private function generarPdfTodosEquipos($data)
    {
        require_once 'vendor/autoload.php';
        
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        
        $html = $this->getHtmlTodosEquipos($data);
        $mpdf->WriteHTML($html);
        
        $filename = 'hoja_vida_todos_equipos.pdf';
        $mpdf->Output($filename, 'D');
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
        
        $html .= '<div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
            <p>Documento generado el ' . date('d/m/Y H:i:s') . '</p>
            <p>Alcaldía de La Jagua de Ibirico - Cesar, Colombia</p>
        </div>';
        
        return $html;
    }

    private function getHtmlTodosEquipos($data)
    {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 10px; }
            .header { text-align: center; margin-bottom: 20px; }
            .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            .table th, .table td { border: 1px solid #ddd; padding: 4px; text-align: left; }
            .table th { background-color: #f2f2f2; }
        </style>
        <div class="header">
            <h2>INVENTARIO GENERAL DE EQUIPOS</h2>
            <p>Sistema SAMICAM - CAM La Jagua de Ibirico</p>
            <p>Fecha: ' . date('d/m/Y') . '</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Número</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Dependencia</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($data as $equipo) {
            $html .= '<tr>
                <td>' . $equipo['tipo'] . '</td>
                <td>' . $equipo['numero_equipo'] . '</td>
                <td>' . $equipo['marca'] . '</td>
                <td>' . $equipo['modelo'] . '</td>
                <td>' . $equipo['estado'] . '</td>
                <td>' . (isset($equipo['dependencia']) ? $equipo['dependencia'] : 'N/A') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
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
}