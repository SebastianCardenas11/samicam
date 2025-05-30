<?php

class AuditoriaModel extends Mysql
{
    private $archivoHistorico = "uploads/auditoria/historicoAuditoria.txt";
    
    public function __construct()
    {
        parent::__construct();
        
        // Asegurar que el directorio base existe
        $dirBase = "uploads/auditoria";
        if (!file_exists($dirBase)) {
            mkdir($dirBase, 0755, true);
        }
        
        // Crear archivo histórico si no existe
        if (!file_exists($this->archivoHistorico)) {
            file_put_contents($this->archivoHistorico, "");
        }
    }

    /**
     * Registra un inicio de sesión en el archivo histórico de auditoría
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
        
        // Preparar contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . $idUsuario . " | ";
        $contenido .= "Usuario: " . $nombre . " | ";
        $contenido .= "Correo: " . $correo . " | ";
        $contenido .= "Rol: " . $rol . " | ";
        $contenido .= "IP: " . $ip . " | ";
        $contenido .= "Navegador: " . $userAgent . " | ";
        $contenido .= "Acción: Inicio de sesión\n";
        
        // Escribir en el archivo histórico
        file_put_contents($this->archivoHistorico, $contenido, FILE_APPEND);
        
        return true;
    }
    
    /**
     * Registra el acceso a un módulo en el archivo histórico de auditoría
     * @param int $idUsuario ID del usuario
     * @param string $nombre Nombre del usuario
     * @param string $rol Rol del usuario
     * @param string $modulo Nombre del módulo accedido
     * @return bool
     */
    public function registrarAccesoModulo($idUsuario, string $nombre, string $rol, string $modulo)
    {
        // Obtener información del cliente
        $ip = $_SERVER['REMOTE_ADDR'];
        $fecha = date('Y-m-d H:i:s');
        
        // Preparar contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . $idUsuario . " | ";
        $contenido .= "Usuario: " . $nombre . " | ";
        $contenido .= "Rol: " . $rol . " | ";
        $contenido .= "IP: " . $ip . " | ";
        $contenido .= "Acción: Acceso al módulo " . $modulo . "\n";
        
        // Escribir en el archivo histórico
        file_put_contents($this->archivoHistorico, $contenido, FILE_APPEND);
        
        return true;
    }
    
    /**
     * Obtiene el contenido completo del archivo histórico de auditoría
     * @return string
     */
    public function getHistoricoCompleto()
    {
        if (file_exists($this->archivoHistorico)) {
            return file_get_contents($this->archivoHistorico);
        }
        return "";
    }
    
    /**
     * Busca en el archivo histórico según un término de búsqueda
     * @param string $termino Término a buscar
     * @return string Líneas que contienen el término
     */
    public function buscarEnHistorico(string $termino)
    {
        if (!file_exists($this->archivoHistorico) || empty($termino)) {
            return "";
        }
        
        $contenido = file($this->archivoHistorico);
        $resultado = "";
        
        foreach ($contenido as $linea) {
            if (stripos($linea, $termino) !== false) {
                $resultado .= $linea;
            }
        }
        
        return $resultado;
    }
    
    /**
     * Obtiene registros de auditoría específicos para un módulo
     * @param string $modulo Nombre del módulo (cargos, vacaciones, viaticos, archivos)
     * @return string Registros de auditoría del módulo
     */
    public function getAuditoriaModulo(string $modulo)
    {
        // Buscar en el histórico los registros relacionados con el módulo
        $termino = "módulo " . $modulo;
        return $this->buscarEnHistorico($termino);
    }
}