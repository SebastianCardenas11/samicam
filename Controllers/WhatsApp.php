<?php

class WhatsApp extends Controllers
{
    private $archivoHistorico = "uploads/whatsapp_log.txt";
    
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MWHATSAPP);
    }

    public function index()
    {
        $this->consola();
    }

    public function consola()
    {
        $data['page_tag'] = "Registro de Mensajes WhatsApp";
        $data['page_title'] = "Registro de Mensajes WhatsApp";
        $data['page_name'] = "whatsapp"; 
        $data['page_functions_js'] = "functions_whatsapp.js";
        $data['page_id'] = 99;
        $this->views->getView($this, "whatsapp", $data);
    }

    public function verHistorico()
    {
        $model = new WhatsAppModel();
        $contenido = $model->getHistoricoCompleto();
        echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscarEnHistorico()
    {
        if ($_POST) {
            $termino = $_POST['termino'];
            $model = new WhatsAppModel();
            $contenido = $model->buscarEnHistorico($termino);
            echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
} 