<?php

class Dashboard extends Controllers
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

    public function dashboard()
    {
        $data['page_id'] = 2;
        $data['page_tag'] = "Administrador - Sigma";
        $data['page_title'] = " Administrador - Sigma";
        $data['page_name'] = "Administrador";
        $data['page_functions_js'] = "functions_dashboard.js";
        $data['usuarios'] = $this->model->cantUsuarios();
        $data['programas'] = $this->model->cantProgramas();
        $data['fichas'] = $this->model->cantFichas();

        if ($_SESSION['userData']['idrol'] == RCOORDINADOR) {
            $this->views->getView($this, "dashboardCoordinador", $data);
        } else {
            $this->views->getView($this, "dashboard", $data);
        }
    }

    public function getHorasPorMesControlador() {
        $data = $this->model->getHorasPorMesModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getHorasPorInstructor() {
        $data = $this->model->getHorasPorInstructorModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}