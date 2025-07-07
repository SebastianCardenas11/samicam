<?php
class psi extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MPSI);
    }

    public function psi()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 99;
        $data['page_tag'] = "PSI";
        $data['page_title'] = "Módulo PSI";
        $data['page_name'] = "PSI";
        $data['page_functions_js'] = "functions_psi.js";
        $this->views->getView($this, "psi", $data);
    }

    // ==================== PRÉSTAMOS ====================
    public function getPrestamos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPrestamos();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getPrestamo($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPrestamo($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setPrestamo()
    {
        // Lógica para crear/editar préstamo
    }
    public function delPrestamo()
    {
        // Lógica para eliminar préstamo
    }

    // ==================== SALIDAS ====================
    public function getSalidas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectSalidas();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getSalida($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectSalida($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setSalida()
    {
        // Lógica para crear/editar salida
    }
    public function delSalida()
    {
        // Lógica para eliminar salida
    }

    // ==================== INGRESOS ====================
    public function getIngresos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectIngresos();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getIngreso($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectIngreso($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setIngreso()
    {
        // Lógica para crear/editar ingreso
    }
    public function delIngreso()
    {
        // Lógica para eliminar ingreso
    }
}
