<?php

class AuditoriaModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Registra un inicio de sesión en el archivo de auditoría
     * @param int $idUsuario ID del usuario que inició sesión
     * @param string $correo Correo del usuario
     * @param string $nombre Nombre del usuario
     * @param string $rol Rol del usuario
     * @return bool
     */
    public function registrarInicioSesion(int $idUsuario, string $correo, string $nombre, string $rol)
    {
        // Obtener información del cliente
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $fecha = date('Y-m-d H:i:s');
        
        // Crear estructura de directorios si no existe
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');
        
        $dirBase = "uploads/auditoria";
        $dirAnio = $dirBase . "/" . $anio;
        $dirMes = $dirAnio . "/" . $mes;
        
        if (!file_exists($dirBase)) {
            mkdir($dirBase, 0755, true);
        }
        
        if (!file_exists($dirAnio)) {
            mkdir($dirAnio, 0755, true);
        }
        
        if (!file_exists($dirMes)) {
            mkdir($dirMes, 0755, true);
        }
        
        // Crear archivo de log
        $archivo = $dirMes . "/log_" . $dia . ".txt";
        
        // Preparar contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . $idUsuario . " | ";
        $contenido .= "Usuario: " . $nombre . " | ";
        $contenido .= "Correo: " . $correo . " | ";
        $contenido .= "Rol: " . $rol . " | ";
        $contenido .= "IP: " . $ip . " | ";
        $contenido .= "Navegador: " . $userAgent . "\n";
        
        // Escribir en el archivo
        file_put_contents($archivo, $contenido, FILE_APPEND);
        
        return true;
    }
    
    /**
     * Obtiene la lista de años disponibles en los registros de auditoría
     * @return array
     */
    public function getAnios()
    {
        $dirBase = "uploads/auditoria";
        $anios = [];
        
        if (file_exists($dirBase) && is_dir($dirBase)) {
            $dirs = scandir($dirBase);
            foreach ($dirs as $dir) {
                if ($dir != "." && $dir != ".." && is_dir($dirBase . "/" . $dir)) {
                    $anios[] = $dir;
                }
            }
        }
        
        return $anios;
    }
    
    /**
     * Obtiene la lista de meses disponibles para un año específico
     * @param string $anio
     * @return array
     */
    public function getMeses(string $anio)
    {
        $dirAnio = "uploads/auditoria/" . $anio;
        $meses = [];
        
        if (file_exists($dirAnio) && is_dir($dirAnio)) {
            $dirs = scandir($dirAnio);
            foreach ($dirs as $dir) {
                if ($dir != "." && $dir != ".." && is_dir($dirAnio . "/" . $dir)) {
                    $meses[] = $dir;
                }
            }
        }
        
        return $meses;
    }
    
    /**
     * Obtiene la lista de días disponibles para un año y mes específicos
     * @param string $anio
     * @param string $mes
     * @return array
     */
    public function getDias(string $anio, string $mes)
    {
        $dirMes = "uploads/auditoria/" . $anio . "/" . $mes;
        $dias = [];
        
        if (file_exists($dirMes) && is_dir($dirMes)) {
            $files = scandir($dirMes);
            foreach ($files as $file) {
                if ($file != "." && $file != ".." && is_file($dirMes . "/" . $file)) {
                    // Extraer el día del nombre del archivo (log_DD.txt)
                    $dia = substr($file, 4, 2);
                    $dias[] = $dia;
                }
            }
        }
        
        return $dias;
    }
    
    /**
     * Obtiene el contenido del archivo de log para un día específico
     * @param string $anio
     * @param string $mes
     * @param string $dia
     * @return string
     */
    public function getLogDia(string $anio, string $mes, string $dia)
    {
        $archivo = "uploads/auditoria/" . $anio . "/" . $mes . "/log_" . $dia . ".txt";
        
        if (file_exists($archivo)) {
            return file_get_contents($archivo);
        }
        
        return "";
    }
}