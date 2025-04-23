<?php

class FuncionariosOps extends Controllers
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

    public function FuncionariosOps()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Funcionarios Ops";
        $data['page_title'] = "Funcionarios Ops";
        $data['page_name'] = "Funcionarios Ops";
        $data['page_functions_js'] = "functions_Funcionariosops.js";
        $this->views->getView($this, "funcionariosops", $data);
    }
}