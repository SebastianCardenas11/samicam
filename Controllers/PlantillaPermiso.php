<?php
$baseDir = dirname(__DIR__);
require_once $baseDir . '/vendor/setasign/fpdf/fpdf.php';

class PlantillaPermiso extends FPDF
{
    function Header()
    {
        // Logo (ajusta la ruta según tu logo)
        $this->Image($baseDir . '/Assets/images/logo.png', 15, 10, 25);
        
        // Rectángulo decorativo superior
        $this->SetFillColor(0, 82, 156); // Color azul institucional
        $this->Rect(0, 0, 220, 40, 'F');
        
        // Título con color blanco
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 15, '', 0, 1, 'C'); // Espacio para el logo
        $this->Cell(0, 10, utf8_decode('ALCALDÍA MUNICIPAL'), 0, 1, 'C');
        
        // Subtítulo
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('FORMATO DE PERMISO LABORAL'), 0, 1, 'C');
        
        // Restaurar color de texto
        $this->SetTextColor(0, 0, 0);
        
        // Línea decorativa
        $this->SetDrawColor(0, 82, 156); // Color azul para la línea
        $this->SetLineWidth(0.5);
        $this->Line(20, 45, 190, 45);
        $this->Ln(15);
    }
    
    function Footer()
    {
        // Rectángulo decorativo inferior
        $this->SetFillColor(0, 82, 156);
        $this->Rect(0, 250, 220, 47, 'F');
        
        $this->SetY(-40);
        
        // Color blanco para el texto del pie
        $this->SetTextColor(255, 255, 255);
        
        // Líneas para firmas en blanco
        $this->SetDrawColor(255, 255, 255);
        $this->Line(30, 240, 90, 240);
        $this->Line(120, 240, 180, 240);
        
        $this->SetFont('Arial', '', 10);
        $this->SetXY(30, 242);
        $this->Cell(60, 5, 'Firma del Funcionario', 0, 0, 'C');
        $this->SetXY(120, 242);
        $this->Cell(60, 5, 'Firma del Superior', 0, 0, 'C');
        
        // Número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Generar la plantilla
$pdf = new PlantillaPermiso();
$pdf->AliasNbPages();
$pdf->AddPage();

// Contenido base con diseño mejorado
$pdf->SetFillColor(240, 240, 240); // Color gris claro para los encabezados

// Sección de información del funcionario
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 82, 156);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 8, utf8_decode('  INFORMACIÓN DEL FUNCIONARIO'), 1, 1, 'L', true);
$pdf->Ln(5);

// Restaurar color de texto
$pdf->SetTextColor(0, 0, 0);

// Campos para información del funcionario con diseño mejorado
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, '  Nombre:', 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 8, '_________________________________________________', 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, utf8_decode('  Identificación:'), 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 8, '_________________________________________________', 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, '  Cargo:', 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 8, '_________________________________________________', 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, '  Dependencia:', 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 8, '_________________________________________________', 1, 1, 'L');

$pdf->Ln(15);

// Sección de información del permiso
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 82, 156);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 8, utf8_decode('  INFORMACIÓN DEL PERMISO'), 1, 1, 'L', true);
$pdf->Ln(5);

// Restaurar color de texto
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, '  Fecha:', 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 8, '_________________________________________________', 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, '  Motivo:', 1, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 30, '', 1, 1, 'L'); // Área más grande para el motivo

// Guardar la plantilla
$outputPath = $baseDir . '/Assets/plantillas/plantilla_permiso.pdf';
$pdf->Output('F', $outputPath); 