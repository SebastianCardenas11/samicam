<?php

class ErrorCustom extends Controllers
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
        $this->views->getView($this, "error_custom", $data);
    }

    public function serverError()
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA . " - Error 500";
        $data['page_name'] = "Error 500";
        $data['error_title'] = "Error 500 - Error del servidor";
        $data['error_message'] = "Ha ocurrido un error interno en el servidor. Por favor, inténtelo de nuevo más tarde.";
        $data['error_code'] = "500";
        $this->views->getView($this, "error_custom", $data);
    }

    public function forbidden()
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA . " - Error 403";
        $data['page_name'] = "Error 403";
        $data['error_title'] = "Error 403 - Acceso denegado";
        $data['error_message'] = "No tienes permisos para acceder a esta página.";
        $data['error_code'] = "403";
        $this->views->getView($this, "error_custom", $data);
    }

    public function unauthorized()
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA . " - Error 401";
        $data['page_name'] = "Error 401";
        $data['error_title'] = "Error 401 - No autorizado";
        $data['error_message'] = "Necesitas iniciar sesión para acceder a esta página.";
        $data['error_code'] = "401";
        $this->views->getView($this, "error_custom", $data);
    }

    public function customError($title, $message, $code = "")
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA . " - Error";
        $data['page_name'] = "Error";
        $data['error_title'] = $title;
        $data['error_message'] = $message;
        if(!empty($code)) {
            $data['error_code'] = $code;
        }
        $this->views->getView($this, "error_custom", $data);
    }
}