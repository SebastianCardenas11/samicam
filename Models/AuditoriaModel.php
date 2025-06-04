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
     * Registra cualquier acción en el archivo histórico de auditoría
     * @param array $data Datos de la acción a registrar
     * @return bool
     */
    public function registrarAccion($data)
    {
        // Obtener información del cliente
        $fecha = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Preparar contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . ($data['id'] ?? 0) . " | ";
        $contenido .= "Usuario: " . ($data['usuario'] ?? 'Desconocido') . " | ";
        if (isset($data['correo'])) {
            $contenido .= "Correo: " . $data['correo'] . " | ";
        }
        $contenido .= "Rol: " . ($data['rol'] ?? 'Sin rol') . " | ";
        $contenido .= "IP: " . $ip . " | ";
        if (isset($data['navegador'])) {
            $contenido .= "Navegador: " . $data['navegador'] . " | ";
        }
        $contenido .= "Acción: " . ($data['accion'] ?? 'No especificada') . "\n";
        
        // Escribir en el archivo histórico
        return file_put_contents($this->archivoHistorico, $contenido, FILE_APPEND) !== false;
    }

    /**
     * Registra un inicio de sesión en el archivo histórico de auditoría
     */
    public function registrarInicioSesion(int $idUsuario, string $correo, string $nombre, string $rol)
    {
        return $this->registrarAccion([
            'id' => $idUsuario,
            'usuario' => $nombre,
            'correo' => $correo,
            'rol' => $rol,
            'navegador' => $_SERVER['HTTP_USER_AGENT'],
            'accion' => 'Inicio de sesión'
        ]);
    }

    /**
     * Registra el acceso a un módulo en el archivo histórico de auditoría
     */
    public function registrarAccesoModulo($idUsuario, string $nombre, string $rol, string $modulo)
    {
        return $this->registrarAccion([
            'id' => $idUsuario,
            'usuario' => $nombre,
            'rol' => $rol,
            'accion' => 'Acceso al módulo ' . $modulo
        ]);
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
     * @param string $modulo Nombre del módulo
     * @return string Registros de auditoría del módulo
     */
    public function getAuditoriaModulo(string $modulo)
    {
        return $this->buscarEnHistorico('módulo ' . $modulo);
    }
}