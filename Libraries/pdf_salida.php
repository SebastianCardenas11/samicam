<?php
require_once 'vendor/autoload.php';

function generarPDFSalida($salida_data) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator('SAMICAM');
    $pdf->SetAuthor('Sistema PSI');
    $pdf->SetTitle('Documento de Salida de Equipos');
    
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    
    $pdf->AddPage();
    
    $html = '
    <style>
        .header { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table th, .info-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .info-table th { background-color: #f5f5f5; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; }
        .signatures { margin-top: 50px; }
        .signature-box { width: 45%; display: inline-block; text-align: center; margin: 0 2%; }
    </style>
    
    <div class="header">
        DOCUMENTO DE SALIDA DE EQUIPOS<br>
        ALCALDÍA DE LA JAGUA DE IBIRICO
    </div>
    
    <table class="info-table">
        <tr>
            <th>Fecha:</th>
            <td>' . date('d/m/Y', strtotime($salida_data[0]['fecha'])) . '</td>
            <th>Dependencia:</th>
            <td>' . $salida_data[0]['dependencia'] . '</td>
        </tr>
    </table>
    
    <table class="info-table">
        <tr>
            <th>Item</th>
            <th>Descripción</th>
            <th>Marca/Modelo</th>
            <th>N° Activo</th>
            <th>Serial</th>
        </tr>';
    
    foreach($salida_data as $equipo) {
        $html .= '<tr>
            <td>' . $equipo['item'] . '</td>
            <td>' . $equipo['descripcion_dispositivo'] . '</td>
            <td>' . $equipo['marca'] . ' ' . $equipo['modelo'] . '</td>
            <td>' . $equipo['numero_activo'] . '</td>
            <td>' . $equipo['serial'] . '</td>
        </tr>';
    }
    
    $html .= '</table>';
    
    if(!empty($salida_data[0]['observaciones'])) {
        $html .= '<table class="info-table">
            <tr>
                <th>Observaciones:</th>
                <td>' . $salida_data[0]['observaciones'] . '</td>
            </tr>
        </table>';
    }
    
    $html .= '
    <div class="signatures">
        <div class="signature-box">
            <br><br><br>
            _________________________________<br>
            <strong>ENTREGA</strong><br>
            Nombre: ________________________<br>
            Cargo: _________________________<br>
            Fecha: _________________________
        </div>
        <div class="signature-box">
            <br><br><br>
            _________________________________<br>
            <strong>RECIBE</strong><br>
            Nombre: ________________________<br>
            Cargo: _________________________<br>
            Fecha: _________________________
        </div>
    </div>
    
    <div class="footer">
        Documento generado el ' . date('d/m/Y H:i:s') . '<br>
        Sistema SAMICAM - Módulo PSI
    </div>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Salida_Equipos_' . date('Y-m-d') . '.pdf', 'I');
}
?>