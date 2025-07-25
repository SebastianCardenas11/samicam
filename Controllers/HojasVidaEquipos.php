<?php

class HojasVidaEquipos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function hojasVidaEquipos()
    {
        $data['page_id'] = 18;
        $data['page_tag'] = "Hojas de Vida de Equipos";
        $data['page_title'] = "Hojas de Vida de Equipos";
        $data['page_name'] = "Hojas de Vida";
        $data['page_functions_js'] = "functions_hojas_vida_equipos.js";
        $this->views->getView($this, "hojasVidaEquipos", $data);
    }

    public function getEquiposConMovimientos()
    {
        echo json_encode([
            ['id_equipo' => 1, 'tipo_equipo' => 'impresora', 'numero' => '001', 'marca' => 'HP', 'modelo' => 'LaserJet', 'estado' => 'Bueno', 'disponibilidad' => 'Disponible', 'total_movimientos' => 2, 'ultimo_movimiento' => '2024-01-15 11:30:00'],
            ['id_equipo' => 2, 'tipo_equipo' => 'pc_torre', 'numero' => '002', 'marca' => 'Dell', 'modelo' => 'OptiPlex', 'estado' => 'Bueno', 'disponibilidad' => 'Disponible', 'total_movimientos' => 2, 'ultimo_movimiento' => '2024-01-20 16:45:00']
        ]);
        die();
    }

    public function getHojaVidaEquipo($idEquipo, $tipoEquipo)
    {
        echo json_encode([
            'status' => true,
            'data' => [
                'tipo_equipo' => $tipoEquipo,
                'equipo' => ['numero_pc' => $idEquipo, 'marca' => 'Test', 'modelo' => 'Test', 'estado' => 'Bueno', 'disponibilidad' => 'Disponible'],
                'movimientos' => []
            ]
        ]);
        die();
    }

    public function generarPDFHojaVida()
    {
        if ($_POST && $_SESSION['permisosMod']['r']) {
            $idEquipo = intval($_POST['idEquipo']);
            $tipoEquipo = strClean($_POST['tipoEquipo']);
            
            if ($idEquipo > 0 && !empty($tipoEquipo)) {
                $hojaVida = $this->model->getHojaVidaEquipo($idEquipo, $tipoEquipo);
                
                if (!empty($hojaVida)) {
                    $this->generarPDF($hojaVida);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'No se encontraron datos del equipo']);
                }
            } else {
                echo json_encode(['status' => false, 'msg' => 'Parámetros inválidos']);
            }
        }
        die();
    }

    private function generarPDF($hojaVida)
    {
        require_once 'vendor/autoload.php';
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, 'HOJA DE VIDA DEL EQUIPO', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Información del equipo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'INFORMACION GENERAL', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        
        $equipo = $hojaVida['equipo'];
        $pdf->Cell(50, 6, 'Tipo de Equipo:', 0, 0, 'L');
        $pdf->Cell(0, 6, ucfirst(str_replace('_', ' ', $hojaVida['tipo_equipo'])), 0, 1, 'L');
        
        $pdf->Cell(50, 6, 'Numero/ID:', 0, 0, 'L');
        $numero = isset($equipo['numero_impresora']) ? $equipo['numero_impresora'] : 
                 (isset($equipo['numero_escaner']) ? $equipo['numero_escaner'] : 
                 (isset($equipo['numero_pc']) ? $equipo['numero_pc'] : $equipo['item']));
        $pdf->Cell(0, 6, $numero, 0, 1, 'L');
        
        if (isset($equipo['marca'])) {
            $pdf->Cell(50, 6, 'Marca:', 0, 0, 'L');
            $pdf->Cell(0, 6, $equipo['marca'], 0, 1, 'L');
        }
        
        if (isset($equipo['modelo'])) {
            $pdf->Cell(50, 6, 'Modelo:', 0, 0, 'L');
            $pdf->Cell(0, 6, $equipo['modelo'], 0, 1, 'L');
        }
        
        if (isset($equipo['serial'])) {
            $pdf->Cell(50, 6, 'Serial:', 0, 0, 'L');
            $pdf->Cell(0, 6, $equipo['serial'], 0, 1, 'L');
        }
        
        $pdf->Cell(50, 6, 'Estado:', 0, 0, 'L');
        $pdf->Cell(0, 6, $equipo['estado'], 0, 1, 'L');
        
        $pdf->Cell(50, 6, 'Disponibilidad:', 0, 0, 'L');
        $pdf->Cell(0, 6, $equipo['disponibilidad'], 0, 1, 'L');
        
        $pdf->Ln(5);
        
        // Historial de movimientos
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'HISTORIAL DE MOVIMIENTOS', 0, 1, 'L');
        
        if (!empty($hojaVida['movimientos'])) {
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 6, 'Fecha/Hora', 1, 0, 'C');
            $pdf->Cell(25, 6, 'Tipo', 1, 0, 'C');
            $pdf->Cell(80, 6, 'Observacion', 1, 0, 'C');
            $pdf->Cell(40, 6, 'Usuario', 1, 1, 'C');
            
            $pdf->SetFont('Arial', '', 8);
            foreach ($hojaVida['movimientos'] as $mov) {
                $pdf->Cell(35, 6, date('d/m/Y H:i', strtotime($mov['fecha_hora'])), 1, 0, 'C');
                $pdf->Cell(25, 6, ucfirst($mov['tipo_movimiento']), 1, 0, 'C');
                $pdf->Cell(80, 6, substr($mov['observacion'], 0, 50), 1, 0, 'L');
                $pdf->Cell(40, 6, $mov['usuario'], 1, 1, 'L');
            }
        } else {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 6, 'No hay movimientos registrados para este equipo.', 0, 1, 'L');
        }
        
        $filename = 'hoja_vida_' . $hojaVida['tipo_equipo'] . '_' . $numero . '.pdf';
        $pdf->Output('D', $filename);
    }
}