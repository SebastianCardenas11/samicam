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
}