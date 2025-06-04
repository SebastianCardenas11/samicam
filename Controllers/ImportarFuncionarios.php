<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ImportarFuncionarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MFUNCIONARIOSPLANTA);
    }

    public function generarPlantilla()
    {
        if ($_SESSION['permisosMod']['r']) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Estilo para encabezados
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '005298']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ]
            ];

            // Configurar anchos de columna
            $sheet->getColumnDimension('A')->setWidth(30); // Correo
            $sheet->getColumnDimension('B')->setWidth(30); // Nombre completo
            $sheet->getColumnDimension('C')->setWidth(20); // Identificación
            $sheet->getColumnDimension('D')->setWidth(10); // Cargo FK
            $sheet->getColumnDimension('E')->setWidth(10); // Dependencia FK
            $sheet->getColumnDimension('F')->setWidth(10); // Contrato FK
            $sheet->getColumnDimension('G')->setWidth(15); // Celular
            $sheet->getColumnDimension('H')->setWidth(40); // Dirección
            $sheet->getColumnDimension('I')->setWidth(15); // Fecha ingreso
            $sheet->getColumnDimension('J')->setWidth(10); // Hijos
            $sheet->getColumnDimension('K')->setWidth(30); // Nombres hijos
            $sheet->getColumnDimension('L')->setWidth(15); // Sexo
            $sheet->getColumnDimension('M')->setWidth(30); // Lugar residencia
            $sheet->getColumnDimension('N')->setWidth(10); // Edad
            $sheet->getColumnDimension('O')->setWidth(20); // Estado civil
            $sheet->getColumnDimension('P')->setWidth(20); // Religión
            $sheet->getColumnDimension('Q')->setWidth(30); // Formación académica
            $sheet->getColumnDimension('R')->setWidth(30); // Nombre formación

            // Establecer encabezados
            $sheet->setCellValue('A1', 'Correo Electrónico');
            $sheet->setCellValue('B1', 'Nombre Completo');
            $sheet->setCellValue('C1', 'Identificación');
            $sheet->setCellValue('D1', 'ID Cargo');
            $sheet->setCellValue('E1', 'ID Dependencia');
            $sheet->setCellValue('F1', 'ID Contrato');
            $sheet->setCellValue('G1', 'Celular');
            $sheet->setCellValue('H1', 'Dirección');
            $sheet->setCellValue('I1', 'Fecha Ingreso');
            $sheet->setCellValue('J1', 'Número de Hijos');
            $sheet->setCellValue('K1', 'Nombres de Hijos');
            $sheet->setCellValue('L1', 'Sexo');
            $sheet->setCellValue('M1', 'Lugar de Residencia');
            $sheet->setCellValue('N1', 'Edad');
            $sheet->setCellValue('O1', 'Estado Civil');
            $sheet->setCellValue('P1', 'Religión');
            $sheet->setCellValue('Q1', 'Formación Académica');
            $sheet->setCellValue('R1', 'Nombre Formación');

            // Aplicar estilo a encabezados
            $sheet->getStyle('A1:R1')->applyFromArray($headerStyle);
            
            // Agregar una hoja de instrucciones
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $instructionSheet = $spreadsheet->getActiveSheet();
            $instructionSheet->setTitle('Instrucciones');
            
            $instructionSheet->setCellValue('A1', 'INSTRUCCIONES PARA IMPORTAR FUNCIONARIOS');
            $instructionSheet->setCellValue('A3', '1. No modifique los encabezados de las columnas');
            $instructionSheet->setCellValue('A4', '2. La identificación y el correo electrónico deben ser únicos para cada funcionario');
            $instructionSheet->setCellValue('A5', '3. Formato de fecha de ingreso: YYYY-MM-DD (ejemplo: 2024-03-14)');
            $instructionSheet->setCellValue('A6', '4. Los campos ID Cargo, ID Dependencia e ID Contrato deben existir en el sistema');
            $instructionSheet->setCellValue('A7', '5. El campo Sexo debe ser: masculino o femenino');
            $instructionSheet->setCellValue('A8', '6. El campo Número de Hijos debe ser numérico. Si no tiene hijos, coloque 0');
            $instructionSheet->setCellValue('A9', '7. El campo Edad debe ser numérico');
            $instructionSheet->setCellValue('A10', '8. Los campos son obligatorios excepto Nombres de Hijos');
            
            // Dar formato a la hoja de instrucciones
            $instructionSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $instructionSheet->getColumnDimension('A')->setWidth(100);
            
            // Volver a la primera hoja
            $spreadsheet->setActiveSheetIndex(0);

            // Preparar la descarga
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="plantilla_funcionarios_planta.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }
        header("Location:" . base_url() . '/dashboard');
        die();
    }

    public function importarDesdeExcel()
    {
        header('Content-Type: application/json');
        try {
            if (!$_SESSION['permisosMod']['w']) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            if (empty($_FILES['archivo_excel'])) {
                $arrResponse = array('status' => false, 'msg' => 'No se ha seleccionado ningún archivo');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            if ($_FILES['archivo_excel']['error'] !== UPLOAD_ERR_OK) {
                $arrResponse = array('status' => false, 'msg' => 'Error al subir el archivo: ' . $_FILES['archivo_excel']['error']);
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            require_once 'vendor/autoload.php';

            try {
                $archivo = $_FILES['archivo_excel']['tmp_name'];
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo);
                $worksheet = $spreadsheet->getActiveSheet();
                $datos = [];
                $errores = [];
                $fila = 2;

                // Empezar desde la fila 2 (después de los encabezados)
                foreach ($worksheet->getRowIterator(2) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $values = [];
                    foreach ($cellIterator as $cell) {
                        $values[] = trim($cell->getValue());
                    }

                    // Verificar si la fila está vacía
                    if (empty(array_filter($values))) {
                        continue;
                    }

                    // Validaciones básicas
                    if (empty($values[0]) || empty($values[1]) || empty($values[2])) {
                        $errores[] = "Fila {$fila}: El correo, nombre e identificación son obligatorios";
                        continue;
                    }

                    // Validar correo
                    if (!filter_var($values[0], FILTER_VALIDATE_EMAIL)) {
                        $errores[] = "Fila {$fila}: El correo electrónico no es válido";
                        continue;
                    }

                    // Validar IDs numéricos
                    if (!is_numeric($values[3]) || !is_numeric($values[4]) || !is_numeric($values[5])) {
                        $errores[] = "Fila {$fila}: Los IDs de cargo, dependencia y contrato deben ser números";
                        continue;
                    }

                    $funcionario = [
                        'correo_elc' => $values[0],
                        'nombre_completo' => $values[1],
                        'nm_identificacion' => $values[2],
                        'cargo_fk' => intval($values[3]),
                        'dependencia_fk' => intval($values[4]),
                        'contrato_fk' => intval($values[5]),
                        'celular' => $values[6] ?? '',
                        'direccion' => $values[7] ?? '',
                        'fecha_ingreso' => !empty($values[8]) ? $values[8] : date('Y-m-d'),
                        'hijos' => !empty($values[9]) ? intval($values[9]) : 0,
                        'nombres_de_hijos' => $values[10] ?? '',
                        'sexo' => $values[11] ?? '',
                        'lugar_de_residencia' => $values[12] ?? '',
                        'edad' => !empty($values[13]) ? intval($values[13]) : 0,
                        'estado_civil' => $values[14] ?? '',
                        'religion' => $values[15] ?? '',
                        'formacion_academica' => $values[16] ?? '',
                        'nombre_formacion' => $values[17] ?? '',
                        'status' => 1
                    ];

                    $datos[] = $funcionario;
                    $fila++;
                }

                if (!empty($errores)) {
                    $arrResponse = array(
                        'status' => false, 
                        'msg' => 'Se encontraron errores en el archivo:',
                        'errores' => $errores
                    );
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                if (empty($datos)) {
                    $arrResponse = array('status' => false, 'msg' => 'No se encontraron datos válidos para importar');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                $resultado = $this->model->importarFuncionarios($datos);

                if ($resultado) {
                    $arrResponse = array(
                        'status' => true, 
                        'msg' => 'Funcionarios importados correctamente',
                        'total' => count($datos)
                    );
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al importar funcionarios. Verifique que los IDs de cargo, dependencia y contrato existan en el sistema.');
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();

            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $arrResponse = array('status' => false, 'msg' => 'Error al leer el archivo Excel: ' . $e->getMessage());
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }

        } catch (Exception $e) {
            error_log("Error en importarDesdeExcel: " . $e->getMessage());
            $arrResponse = array('status' => false, 'msg' => 'Error al procesar el archivo: ' . $e->getMessage());
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
} 