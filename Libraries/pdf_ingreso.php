<?php
require_once 'vendor/autoload.php';

function generarPDFIngreso($ingreso) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator('SAMICAM');
    $pdf->SetAuthor('Sistema PSI');
    $pdf->SetTitle('Documento de Ingreso - ' . $ingreso['item']);
    
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    
    $pdf->AddPage();
    
    $html = '
    <style>
        .header { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .label { font-weight: bold; background-color: #f5f5f5; width: 30%; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; }
    </style>
    
    <div class="header">
        DOCUMENTO DE INGRESO DE EQUIPO<br>
        ALCALDÍA DE LA JAGUA DE IBIRICO
    </div>
    
    <table class="info-table">
        <tr>
            <td class="label">Fecha:</td>
            <td>' . date('d/m/Y', strtotime($ingreso['fecha'])) . '</td>
        </tr>
        <tr>
            <td class="label">Item:</td>
            <td>' . $ingreso['item'] . '</td>
        </tr>
        <tr>
            <td class="label">Descripción:</td>
            <td>' . $ingreso['descripcion_dispositivo'] . '</td>
        </tr>
        <tr>
            <td class="label">Marca:</td>
            <td>' . $ingreso['marca'] . '</td>
        </tr>
        <tr>
            <td class="label">Modelo:</td>
            <td>' . $ingreso['modelo'] . '</td>
        </tr>
        <tr>
            <td class="label">Número de Activo:</td>
            <td>' . $ingreso['numero_activo'] . '</td>
        </tr>
        <tr>
            <td class="label">Serial:</td>
            <td>' . $ingreso['serial'] . '</td>
        </tr>
        <tr>
            <td class="label">Dependencia:</td>
            <td>' . $ingreso['dependencia'] . '</td>
        </tr>
        <tr>
            <td class="label">Observaciones:</td>
            <td>' . $ingreso['observaciones'] . '</td>
        </tr>
    </table>
    
    <div class="footer">
        Documento generado el ' . date('d/m/Y H:i:s') . '<br>
        Sistema SAMICAM - Módulo PSI
    </div>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Ingreso_' . $ingreso['item'] . '_' . date('Y-m-d') . '.pdf', 'I');
}
?>