<?php
class Logout
{
    public function __construct()
    {
        session_start();
        
        // Registrar cierre de sesión en auditoría si el usuario estaba logueado
        if (isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['userData'])) {
            $this->registrarCierreSesion($_SESSION['userData']);
        }
        
        session_unset();
        session_destroy();
        header('location: ' . base_url() . '/login');
        die();
    }
    
    /**
     * Registra el cierre de sesión en archivos de auditoría
     */
    private function registrarCierreSesion($userData)
    {
        // Crear directorios si no existen
        $dirBase = "uploads/auditoria";
        if (!is_dir($dirBase)) {
            mkdir($dirBase, 0755, true);
        }
        
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');
        
        $dirAnio = $dirBase . "/" . $anio;
        if (!is_dir($dirAnio)) {
            mkdir($dirAnio, 0755);
        }
        
        $dirMes = $dirAnio . "/" . $mes;
        if (!is_dir($dirMes)) {
            mkdir($dirMes, 0755);
        }
        
        // Preparar datos para el registro
        $fecha = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        
        // Crear contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . $userData['ideusuario'] . " | ";
        $contenido .= "Usuario: " . $userData['nombres'] . " | ";
        $contenido .= "Correo: " . $userData['correo'] . " | ";
        $contenido .= "Rol: " . $userData['nombrerol'] . " | ";
        $contenido .= "IP: " . $ip . " | ";
        $contenido .= "Acción: Cierre de sesión\n";
        
        // Escribir en archivo
        $archivo = $dirMes . "/log_" . $dia . ".txt";
        file_put_contents($archivo, $contenido, FILE_APPEND);
    }
}