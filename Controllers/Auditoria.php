<?php

class Auditoria extends Controllers
{
    private $archivoHistorico = "uploads/auditoria/historicoAuditoria.txt";
    
    public function __construct()
    {
        parent::__construct();
        session_start();
        // Verificar si el usuario está logueado
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        
        // Verificar si el usuario es superadministrador
        $userData = $_SESSION['userData'];
        if ($userData['nombrerol'] != 'Superadministrador') {
            header('Location: ' . base_url() . '/dashboard');
            die();
        }
        
        // Asignar permisos para el módulo de auditoría
        getPermisos(MAUDITORIA);
    }

    public function index()
    {
        $this->auditoria();
    }

    public function auditoria()
    {
        $data['page_tag'] = "Auditoría - Samicam";
        $data['page_title'] = "AUDITORÍA";
        $data['page_name'] = "auditoria";
        $data['page_functions_js'] = "functions_auditoria.js";
        $data['page_id'] = 10;
        
        // Registrar acceso al módulo solo si no es una recarga de página
        if (!isset($_SESSION['auditoria_accessed']) || $_SESSION['auditoria_accessed'] === false) {
            $this->registrarAccesoModulo("Auditoría");
            $_SESSION['auditoria_accessed'] = true;
        }
        
        $this->views->getView($this, "auditoria", $data);
    }
    
    public function registrarAccesoModulo($modulo)
    {
        $model = new AuditoriaModel();
        $userData = $_SESSION['userData'];
        $idPersona = isset($userData['idpersona']) ? $userData['idpersona'] : 0;
        $model->registrarAccesoModulo($idPersona, $userData['nombres'], $userData['nombrerol'], $modulo);
    }
    
    public function verHistorico()
    {
        $model = new AuditoriaModel();
        $contenido = $model->getHistoricoCompleto();
        
        echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function buscarEnHistorico()
    {
        if ($_POST) {
            $termino = $_POST['termino'];
            $model = new AuditoriaModel();
            $contenido = $model->buscarEnHistorico($termino);
            
            echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function descargarHistorico()
    {
        if (file_exists($this->archivoHistorico)) {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="historicoAuditoria.txt"');
            header('Content-Length: ' . filesize($this->archivoHistorico));
            readfile($this->archivoHistorico);
            exit;
        }
        
        header('Location: ' . base_url() . '/auditoria');
        die();
    }
}