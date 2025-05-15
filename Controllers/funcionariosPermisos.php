<?php

class FuncionariosPermisos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDASHBOARD);
    }

    public function FuncionariosPermisos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Permisos";
        $data['page_title'] = "Permisos";
        $data['page_name'] = "Permisos";
        $data['page_functions_js'] = "functions_funcionariosPermisos.js";
        $this->views->getView($this, "funcionariospermisos", $data);
    }
    

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
             
                $btnView = '';
                $btnPermit = '';
                $btnHistorial = '';

                // Mostrar permisos del mes actual
                $permisosUsados = $arrData[$i]['permisos_mes_actual'] ?? 0;
                $arrData[$i]['permisos'] = $permisosUsados . "/3";

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnPermit = '<button class="btn btn-warning" onClick="fntPermitInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Crear Permiso"><i class="bi bi-plus-lg"></i></button>';
                }
                
                $btnHistorial = '<button class="btn btn-secondary" onClick="fntViewHistorial(' . $arrData[$i]['idefuncionario'] . ')" title="Ver Historial"><i class="bi bi-clock-history"></i></button>';
               
            
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPermit . ' ' . $btnHistorial . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
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
                    $arrData = $this->model->getPermisosHistorial($idefuncionario);
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
    
    public function generarPDF($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                // Obtener datos del funcionario
                $funcionario = $this->model->selectFuncionario($idefuncionario);
                if (empty($funcionario)) {
                    echo "Funcionario no encontrado";
                    die();
                }
                
                // Obtener historial de permisos
                $permisos = $this->model->getPermisosHistorial($idefuncionario);
                
                // Cargar la librería TCPDF
                require_once 'Libraries/pdf/tcpdf.php';
                
                // Crear nuevo documento PDF
                $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                
                // Establecer información del documento
                $pdf->SetCreator('SAMICAM');
                $pdf->SetAuthor('Sistema SAMICAM');
                $pdf->SetTitle('Historial de Permisos');
                $pdf->SetSubject('Historial de Permisos del Funcionario');
                
                // Establecer márgenes
                $pdf->SetMargins(15, 15, 15);
                $pdf->SetHeaderMargin(5);
                $pdf->SetFooterMargin(10);
                
                // Eliminar cabecera y pie de página predeterminados
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                
                // Agregar una página
                $pdf->AddPage();
                
                // Establecer fuente
                $pdf->SetFont('helvetica', 'B', 14);
                
                // Título
                $pdf->Cell(0, 10, 'HISTORIAL DE PERMISOS', 0, 1, 'C');
                $pdf->Ln(5);
                
                // Información del funcionario
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 8, 'Datos del Funcionario:', 0, 1);
                $pdf->SetFont('helvetica', '', 11);
                $pdf->Cell(40, 8, 'Nombre:', 0, 0);
                $pdf->Cell(0, 8, $funcionario['nombre_completo'], 0, 1);
                $pdf->Cell(40, 8, 'Identificación:', 0, 0);
                $pdf->Cell(0, 8, $funcionario['nm_identificacion'], 0, 1);
                $pdf->Cell(40, 8, 'Cargo:', 0, 0);
                $pdf->Cell(0, 8, $funcionario['cargo_nombre'], 0, 1);
                $pdf->Cell(40, 8, 'Dependencia:', 0, 0);
                $pdf->Cell(0, 8, $funcionario['dependencia_nombre'], 0, 1);
                $pdf->Ln(5);
                
                // Tabla de permisos
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 8, 'Historial de Permisos:', 0, 1);
                $pdf->Ln(2);
                
                // Cabecera de la tabla
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->SetFillColor(230, 230, 230);
                $pdf->Cell(40, 8, 'Fecha', 1, 0, 'C', true);
                $pdf->Cell(100, 8, 'Motivo', 1, 0, 'C', true);
                $pdf->Cell(40, 8, 'Estado', 1, 1, 'C', true);
                
                // Contenido de la tabla
                $pdf->SetFont('helvetica', '', 10);
                if (!empty($permisos)) {
                    foreach ($permisos as $permiso) {
                        $fecha = date('d/m/Y', strtotime($permiso['fecha_permiso']));
                        $pdf->Cell(40, 8, $fecha, 1, 0, 'C');
                        $pdf->Cell(100, 8, $permiso['motivo'], 1, 0, 'L');
                        $pdf->Cell(40, 8, $permiso['estado'], 1, 1, 'C');
                    }
                } else {
                    $pdf->Cell(180, 8, 'No hay permisos registrados', 1, 1, 'C');
                }
                
                // Fecha de generación
                $pdf->Ln(10);
                $pdf->SetFont('helvetica', 'I', 8);
                $pdf->Cell(0, 5, 'Documento generado el: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
                
                // Generar el PDF
                $pdf->Output('Historial_Permisos_' . $funcionario['nombre_completo'] . '.pdf', 'I');
            } else {
                echo "ID de funcionario inválido";
            }
        } else {
            header("Location:" . base_url() . '/dashboard');
        }
        die();
    }

    public function setPermiso()
    {
        if ($_SESSION['permisosMod']['u']) {
            if ($_POST) {
                if (empty($_POST['idFuncionario']) || empty($_POST['txtFechaPermiso']) || empty($_POST['listMotivoPermiso'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    try {
                        $idFuncionario = intval($_POST['idFuncionario']);
                        $fechaPermiso = $_POST['txtFechaPermiso'];
                        $idMotivoPermiso = intval($_POST['listMotivoPermiso']);
                        
                        $request = $this->model->insertPermiso($idFuncionario, $fechaPermiso, $idMotivoPermiso);
                        
                        if ($request['status']) {
                            $arrResponse = array('status' => true, 'msg' => $request['msg']);
                        } else {
                            $arrResponse = array('status' => false, 'msg' => $request['msg']);
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al registrar el permiso. Intente nuevamente.');
                        error_log("Error en setPermiso: " . $e->getMessage());
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function getMotivosPermisos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectMotivosPermisos();
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'No hay motivos de permisos registrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}