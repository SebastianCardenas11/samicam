<?php
class Notificaciones extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
    }

    public function Notificaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 8;
        $data['page_tag'] = "Notificaciones";
        $data['page_title'] = "Notificaciones";
        $data['page_name'] = "notificaciones";
        $data['page_functions_js'] = "functions_notificaciones.js";
        $this->views->getView($this, "Notificaciones", $data);
    }

}
?>