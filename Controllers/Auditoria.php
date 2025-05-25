<?php

class Auditoria extends Controllers
{
    private $logDir = "uploads/auditoria";
    
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
        
        // Obtener estructura de directorios
        $data['anios'] = $this->getAniosDirectorios();
        
        $this->views->getView($this, "auditoria", $data);
    }
    
    private function getAniosDirectorios()
    {
        $anios = [];
        
        if (is_dir($this->logDir)) {
            $dirs = scandir($this->logDir);
            foreach ($dirs as $dir) {
                if ($dir != "." && $dir != ".." && is_dir($this->logDir . "/" . $dir)) {
                    $anios[] = $dir;
                }
            }
        }
        
        return $anios;
    }
    
    public function getMesesDirectorio()
    {
        if ($_POST) {
            $anio = $_POST['anio'];
            $dirAnio = $this->logDir . "/" . $anio;
            $meses = [];
            
            if (is_dir($dirAnio)) {
                $dirs = scandir($dirAnio);
                foreach ($dirs as $dir) {
                    if ($dir != "." && $dir != ".." && is_dir($dirAnio . "/" . $dir)) {
                        $meses[] = $dir;
                    }
                }
            }
            
            echo json_encode($meses, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getArchivosDirectorio()
    {
        if ($_POST) {
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $dirMes = $this->logDir . "/" . $anio . "/" . $mes;
            $archivos = [];
            
            if (is_dir($dirMes)) {
                $files = scandir($dirMes);
                foreach ($files as $file) {
                    if ($file != "." && $file != ".." && is_file($dirMes . "/" . $file)) {
                        $archivos[] = $file;
                    }
                }
            }
            
            echo json_encode($archivos, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function verArchivo()
    {
        if ($_POST) {
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $archivo = $_POST['archivo'];
            $ruta = $this->logDir . "/" . $anio . "/" . $mes . "/" . $archivo;
            
            $contenido = "";
            if (file_exists($ruta)) {
                $contenido = file_get_contents($ruta);
            }
            
            echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function descargarArchivo()
    {
        if ($_GET) {
            $anio = $_GET['anio'];
            $mes = $_GET['mes'];
            $archivo = $_GET['archivo'];
            $ruta = $this->logDir . "/" . $anio . "/" . $mes . "/" . $archivo;
            
            if (file_exists($ruta)) {
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="' . $archivo . '"');
                header('Content-Length: ' . filesize($ruta));
                readfile($ruta);
                exit;
            }
        }
        
        header('Location: ' . base_url() . '/auditoria');
        die();
    }
}