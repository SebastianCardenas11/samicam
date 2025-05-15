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
        $data['page_tag'] = "Viaticos";
        $data['page_title'] = "Viaticos";
        $data['page_name'] = "Viaticos";
        $data['page_functions_js'] = "functions_Viaticos.js";
        $this->views->getView($this, "funcionariosviaticos", $data);
    }

    public function getCapitalDisponible($year)
    {
        if ($_SESSION['permisosMod']['r']) {
            $year = intval($year);
            $request = $this->model->getCapitalDisponible($year);
            echo json_encode(['capitalDisponible' => $request], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getHistoricoViaticos($year)
    {
        if ($_SESSION['permisosMod']['r']) {
            $year = intval($year);
            if ($year <= 0) {
                $year = date('Y');
            }
            $request = $this->model->getHistoricoViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getDetalleViaticos($year)
    {
        if ($_SESSION['permisosMod']['r']) {
            $year = intval($year);
            if ($year <= 0) {
                $year = date('Y');
            }
            $request = $this->model->getDetalleViaticos($year);
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFuncionariosValidos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $request = $this->model->getFuncionariosValidos();
            echo json_encode($request, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setViatico()
    {
        if ($_POST) {
            $idFuncionario = intval($_POST['funci_fk']);
            $descripcion = strClean($_POST['descripcion']);
            $monto = floatval($_POST['monto']);
            $fecha = strClean($_POST['fecha']);
            $uso = strClean($_POST['uso']);

            $request = $this->model->insertViatico($idFuncionario, $descripcion, $monto, $fecha, $uso);
            if ($request > 0) {
                $arrResponse = ['status' => true, 'msg' => 'Viático asignado correctamente'];
            } else {
                $arrResponse = ['status' => false, 'msg' => 'Error al asignar viático'];
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPresupuestoAnual()
    {
        if ($_POST) {
            $anio = intval($_POST['anio']);
            $capitalTotal = floatval($_POST['capitalTotal']);

            $request = $this->model->setPresupuestoAnual($anio, $capitalTotal);
            if ($request > 0) {
                $arrResponse = ['status' => true, 'msg' => 'Presupuesto anual guardado correctamente'];
            } else {
                $arrResponse = ['status' => false, 'msg' => 'Error al guardar presupuesto anual'];
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}