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
        $idequipo = $_GET['id'] ?? 0;
        $tipo = $_GET['tipo'] ?? '';
        
        $arrData = $this->model->selectEquipo($idequipo, $tipo);
        
        require_once 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        
        $html = '<h1>Hoja de Vida - ' . $tipo . '</h1>
        <p>Equipo: ' . $arrData['numero_equipo'] . '</p>
        <p>Marca: ' . $arrData['marca'] . '</p>';
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('hoja_vida.pdf', 'D');
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