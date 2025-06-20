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
        
        // Registrar acceso al módulo cada vez que se accede
        $this->registrarAccesoModulo("Auditoría");
        
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
    
    public function verAuditoriaModulo()
    {
        if ($_POST) {
            $modulo = $_POST['modulo'];
            $model = new AuditoriaModel();
            
            // Registrar el acceso actual al módulo
            if (isset($_SESSION['userData'])) {
                $userData = $_SESSION['userData'];
                $idPersona = isset($userData['idpersona']) ? $userData['idpersona'] : 0;
                $model->registrarAccesoModulo($idPersona, $userData['nombres'], $userData['nombrerol'], $modulo);
            }
            
            $contenido = $model->getAuditoriaModulo($modulo);
            
            echo json_encode(['contenido' => $contenido], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function registrarAccesoJS()
    {
        if ($_POST) {
            $modulo = $_POST['modulo'];
            $model = new AuditoriaModel();
            $userData = $_SESSION['userData'];
            $idPersona = isset($userData['idpersona']) ? $userData['idpersona'] : 0;
            
            // Registrar el acceso al módulo
            $model->registrarAccesoModulo($idPersona, $userData['nombres'], $userData['nombrerol'], $modulo);
            
            echo json_encode(['status' => true], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function descargarHistorico()
    {
        if (file_exists($this->archivoHistorico)) {
            $model = new AuditoriaModel();
            $contenido = $model->getHistoricoCompleto();
            
            // Crear archivo Excel
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="historicoAuditoria.xls"');

            echo "\xEF\xBB\xBF"; // BOM UTF-8 para que Excel muestre bien los acentos

            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Fecha</th>";
            echo "<th>ID</th>";
            echo "<th>Usuario</th>";
            echo "<th>Rol</th>";
            echo "<th>IP</th>";
            echo "<th>Acción</th>";
            echo "</tr>";
            
            $lineas = explode("\n", $contenido);
            foreach ($lineas as $linea) {
                if (empty(trim($linea))) continue;
                
                // Extraer fecha
                preg_match('/\[(.*?)\]/', $linea, $fecha);
                $fecha = isset($fecha[1]) ? $fecha[1] : '';
                
                // Extraer ID
                preg_match('/ID: (.*?) \|/', $linea, $id);
                $id = isset($id[1]) ? $id[1] : '';
                
                // Extraer Usuario
                preg_match('/Usuario: (.*?) \|/', $linea, $usuario);
                $usuario = isset($usuario[1]) ? $usuario[1] : '';
                
                // Extraer Rol
                preg_match('/Rol: (.*?) \|/', $linea, $rol);
                $rol = isset($rol[1]) ? $rol[1] : '';
                
                // Extraer IP
                preg_match('/IP: (.*?) \|/', $linea, $ip);
                $ip = isset($ip[1]) ? $ip[1] : '';
                
                // Extraer Acción
                preg_match('/Acción: (.*)$/', $linea, $accion);
                $accion = isset($accion[1]) ? $accion[1] : '';
                
                echo "<tr>";
                echo "<td>$fecha</td>";
                echo "<td>$id</td>";
                echo "<td>$usuario</td>";
                echo "<td>$rol</td>";
                echo "<td>$ip</td>";
                echo "<td>$accion</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            exit;
        }
        
        header('Location: ' . base_url() . '/auditoria');
        die();
    }
}