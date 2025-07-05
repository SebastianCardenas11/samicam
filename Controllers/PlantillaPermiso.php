<?php
$baseDir = dirname(__DIR__);
require_once $baseDir . '/vendor/setasign/fpdf/fpdf.php';

class PlantillaPermiso extends FPDF
{
    function Header()
    {
        // No header para este formato de carta
    }
    
    function Footer()
    {
        // No footer para este formato de carta
    }
}

// Generar la plantilla
$pdf = new PlantillaPermiso();
$pdf->AddPage();

// Configurar fuente y márgenes
$pdf->SetFont('Arial', '', 12);
$pdf->SetMargins(25, 25, 25);

// Encabezado con fecha y lugar
$pdf->Cell(0, 8, utf8_decode('La Jagua de Ibirico, Cesar 27 de mayo de 2025'), 0, 1, 'L');
$pdf->Ln(10);

// Destinatario
$pdf->Cell(0, 8, utf8_decode('Señor,'), 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode('xxxxxxxxxxxxxxxxxxxxxxxxxxxx'), 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode('Tecnico Operativo'), 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode('Alcaldía Municipal de La Jagua de Ibirico'), 0, 1, 'L');
$pdf->Ln(10);

// Asunto
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, utf8_decode('Asunto: Respuesta a Solicitud'), 0, 1, 'L');
$pdf->Ln(10);

// Saludo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode('Cordial saludo'), 0, 1, 'L');
$pdf->Ln(5);

// Contenido principal
$pdf->MultiCell(0, 8, utf8_decode('De forma respetuosa y con aprecio me dirijo a usted para informarle que su solicitud de permiso para el día 30 de mayo de 2025, por concepto "llevar a hijos menores a cita médica" después de analizado fue aprobado por esta unidad.'), 0, 'J');
$pdf->Ln(15);

// Firmas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, utf8_decode('MOISES XAVIER PATERNINA VASQUEZ'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode('Jefe Oficina Asesora de Talento Humano'), 0, 1, 'C');
$pdf->Ln(10);

// Proyectó y Revisó
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode('Proyectó:	Yuleima Aguilar Lima- Secretaria Ejecutiva'), 0, 1, 'L');
$pdf->Cell(0, 6, utf8_decode('Revisó:	Moisés Paternina Vásquez-jefe Talento Humano'), 0, 1, 'L');
$pdf->Ln(10);

// Texto de responsabilidad (más pequeño)
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 6, utf8_decode('Los arriba firmantes declaramos que hemos revisado el documento, cuyo contenido se encuentra ajustado a las disposiciones legales vigentes, bajo nuestra responsabilidad lo presentamos para firma.'), 0, 'J');

// Guardar la plantilla
$outputPath = $baseDir . '/Assets/plantillas/plantilla_permiso.pdf';
$pdf->Output('F', $outputPath); 