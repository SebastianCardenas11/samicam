<?php

class Errors extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function notFound()
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA . " - Error 404";
        $data['page_name'] = "Error 404";
        $data['error_title'] = "Error 404 - Página no encontrada";
        $data['error_message'] = "La página que estás buscando no existe o ha sido movida.";
        $data['error_code'] = "404";
        $this->views->getView($this, "error", $data);
    }
}

$notFound = new Errors();
$notFound->notFound();