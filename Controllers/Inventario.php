<?php
class Inventario extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MINVENTARIO);
    }

    public function Inventario()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
       
        $data['page_tag'] = "Inventario";
        $data['page_title'] = "Inventario";
        $data['page_name'] = "inventario";
        $data['page_functions_js'] = "functions_inventario.js";
        $this->views->getView($this, "index", $data);
    }

}
?>