<?php

class FuncionariosViaticos extends Controllers
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
        $this->model = new FuncionariosViaticosModel();
    }

    public function FuncionariosViaticos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['funcionarios_planta'] = $this->model->selectFuncionariosPlanta();
        $data['page_tag'] = "Viaticos";
        $data['page_title'] = "Viaticos";
        $data['page_name'] = "Viaticos";
        $data['page_functions_js'] = "functions_Viaticos.js";
        $this->views->getView($this, "funcionariosviaticos", $data);
    }

    public function getCapitalDisponible($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $presupuesto = $this->model->getPresupuestoInfo($year);
            $capitalTotal = floatval($presupuesto['capital_total']);
            $capitalDisponible = floatval($presupuesto['capital_disponible']);
            
            // Si no hay presupuesto registrado, crear uno por defecto
            if ($capitalTotal <= 0) {
                $capitalTotal = 500000000.00;
                $capitalDisponible = 500000000.00;
                $this->model->setPresupuestoAnual($year, $capitalTotal);
            }
            
            echo json_encode([
                'capitalDisponible' => $capitalDisponible,
                'capitalTotal' => $capitalTotal
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getHistoricoViaticos($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $request = $this->model->getHistoricoViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getDetalleViaticos($year = null)
    {
        header('Content-Type: application/json');
        
        if (empty($_SESSION['permisosMod']['r'])) {
            echo json_encode(['error' => 'No tiene permisos para esta acción']);
            die();
        }
        
        $year = intval($year);
        if ($year <= 0) {
            $year = date('Y');
        }
        
        try {
            $request = $this->model->getDetalleViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        die();
    }

    public function getFuncionariosValidos()
    {
        header('Content-Type: application/json');
        echo json_encode([
            [
                'idefuncionario' => 9,
                'nombre_completo' => 'Carlos Lopez',
                'tipo_cont' => 'Libre Nombramiento'
            ]
        ]);
        die();
    }

    public function deleteViatico()
    {
        header('Content-Type: application/json');
        
        // Temporalmente desactivar la verificación de permisos para pruebas
        /*
        if (empty($_SESSION['permisosMod']['d'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para esta acción']);
            die();
        }
        */
        
        if ($_POST) {
            $idViatico = intval($_POST['idViatico']);
            
            if ($idViatico <= 0) {
                echo json_encode(['status' => false, 'msg' => 'ID de viático no válido']);
                die();
            }
            
            try {
                $result = $this->model->deleteViatico($idViatico);
                
                if ($result) {
                    echo json_encode(['status' => true, 'msg' => 'Viático eliminado correctamente']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'Error al eliminar el viático']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => false, 'msg' => 'Datos no válidos']);
        }
        die();
    }

    public function setViatico()
    {
        header('Content-Type: application/json');
        
        // Temporalmente desactivar la verificación de permisos para pruebas
        /*
        if (!$_POST || empty($_SESSION['permisosMod']['w'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para realizar esta acción']);
            die();
        }
        */
        
        try {
            if (empty($_POST['funci_fk'])) {
                echo json_encode(['status' => false, 'msg' => 'Debe seleccionar un funcionario']);
                die();
            }
            
            $idFuncionario = intval($_POST['funci_fk']);
            $descripcion = strClean($_POST['descripcion']);
            $monto = floatval($_POST['monto']);
            $fecha = strClean($_POST['fecha']);
            $uso = strClean($_POST['uso']);

            if ($idFuncionario <= 0) {
                echo json_encode(['status' => false, 'msg' => 'Funcionario no válido']);
                die();
            }
            
            if ($monto <= 0) {
                echo json_encode(['status' => false, 'msg' => 'El monto debe ser mayor que cero']);
                die();
            }
            
            if (empty($fecha)) {
                echo json_encode(['status' => false, 'msg' => 'Debe seleccionar una fecha']);
                die();
            }

            // Verificar si hay suficiente capital disponible
            $year = date('Y', strtotime($fecha));
            $capitalDisponible = $this->model->getCapitalDisponible($year);
            
            if ($monto > $capitalDisponible) {
                echo json_encode(['status' => false, 'msg' => 'El monto excede el capital disponible para viáticos']);
                die();
            }
            
            $request = $this->model->insertViatico($idFuncionario, $descripcion, $monto, $fecha, $uso);
            
            if ($request > 0) {
                // Actualizar el capital disponible
                $this->actualizarCapitalDisponible($year, $monto);
                echo json_encode(['status' => true, 'msg' => 'Viático asignado correctamente']);
            } else if ($request == "exist") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario ya tiene un viático asignado para esta fecha']);
            } else if ($request == "nofunc") {
                echo json_encode(['status' => false, 'msg' => 'El funcionario seleccionado no existe o no está activo']);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al asignar viático']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        die();
    }

    private function actualizarCapitalDisponible($year, $monto)
    {
        $capitalActual = $this->model->getCapitalDisponible($year);
        $nuevoCapital = $capitalActual - $monto;
        $this->model->actualizarCapitalDisponible($year, $nuevoCapital);
    }

    public function setPresupuestoAnual()
    {
        header('Content-Type: application/json');
        
        if (!$_POST || empty($_SESSION['permisosMod']['w'])) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permisos para realizar esta acción']);
            die();
        }
        
        try {
            $anio = intval($_POST['anio']);
            $capitalTotal = floatval($_POST['capitalTotal']);

            if ($anio <= 0) {
                throw new Exception("Año inválido");
            }
            
            if ($capitalTotal <= 0) {
                throw new Exception("Capital total debe ser mayor que cero");
            }

            $request = $this->model->setPresupuestoAnual($anio, $capitalTotal);
            if ($request > 0) {
                echo json_encode(['status' => true, 'msg' => 'Presupuesto anual guardado correctamente']);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al guardar presupuesto anual']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
        die();
    }
}