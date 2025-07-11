<?php
class PublicacionesModel extends Mysql
{
    private $intIdPublicacion;
    private $strFechaRecibido;
    private $strCorreoRecibido;
    private $strAsunto;
    private $strFechaPublicacion;
    private $strRespuestaEnvio;
    private $strEnlacePublicacion;
    private $intDependencia;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las publicaciones
    public function selectPublicaciones()
    {
        try {
            $sql = "SELECT p.*, d.nombre as dependencia_nombre 
                    FROM publicaciones p 
                    LEFT JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk 
                    WHERE p.status != 0 
                    ORDER BY p.id_publicacion DESC";
            $request = $this->select_all($sql);
            
            if (!is_array($request)) {
                return array();
            }
            
            return $request;
        } catch (Exception $e) {
            error_log("Error en selectPublicaciones: " . $e->getMessage());
            return array();
        }
    }

    // Obtener una publicación específica
    public function selectPublicacion(int $idpublicacion)
    {
        $this->intIdPublicacion = $idpublicacion;
        $sql = "SELECT p.*, d.nombre as dependencia_nombre 
                FROM publicaciones p 
                LEFT JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk 
                WHERE p.id_publicacion = $this->intIdPublicacion";
        $request = $this->select($sql);
        return $request;
    }

    // Obtener todas las dependencias
    public function getDependencias()
    {
        $sql = "SELECT * FROM tbl_dependencia ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    // Insertar nueva publicación
    public function insertPublicacion(string $fechaRecibido, string $correoRecibido, string $asunto, 
                                    string $fechaPublicacion, string $respuestaEnvio, 
                                    string $enlacePublicacion, int $dependencia, int $status,
                                    string $nombrePublicacion = '')
    {
        $return = 0;
        $this->strFechaRecibido = $fechaRecibido;
        $this->strCorreoRecibido = $correoRecibido;
        $this->strAsunto = $asunto;
        $this->strFechaPublicacion = $fechaPublicacion;
        $this->strRespuestaEnvio = $respuestaEnvio;
        $this->strEnlacePublicacion = $enlacePublicacion;
        $this->intDependencia = $dependencia;
        $this->intStatus = $status;

        $query_insert = "INSERT INTO publicaciones(nombre_publicacion, fecha_recibido, correo_recibido, 
                                                 asunto, fecha_publicacion, respuesta_envio, 
                                                 enlace_publicacion, dependencia_fk, status) 
                        VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData = array(
            $nombrePublicacion ?: $this->strAsunto, // Use provided nombre_publicacion or asunto as fallback
            $this->strFechaRecibido,
            $this->strCorreoRecibido,
            $this->strAsunto,
            $this->strFechaPublicacion,
            $this->strRespuestaEnvio,
            $this->strEnlacePublicacion,
            $this->intDependencia,
            $this->intStatus
        );
        $request_insert = $this->insert($query_insert, $arrData);
        $return = $request_insert;
        
        return $return;
    }

    // Eliminar publicación
    public function deletePublicacion(int $idpublicacion)
    {
        $this->intIdPublicacion = $idpublicacion;
        $sql = "UPDATE publicaciones SET status = ? WHERE id_publicacion = $this->intIdPublicacion";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
    
    // Método para registrar en auditoría
    public function insertAudit($arrData)
    {
        $user_id = $arrData['user_id'];
        $user_name = $arrData['user_name'];
        $user_rol = $arrData['user_rol'];
        $ip = $arrData['ip'];
        $accion = $arrData['accion'];
        
        $query_insert = "INSERT INTO auditoria(user_id, user_name, user_rol, ip, accion) VALUES(?,?,?,?,?)";
        $arrData = array($user_id, $user_name, $user_rol, $ip, $accion);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function getEstadisticas()
    {
        // Publicaciones por mes del año actual
        $sql_por_mes = "SELECT 
            MONTH(fecha_publicacion) as mes,
            COUNT(*) as total
            FROM publicaciones 
            WHERE YEAR(fecha_publicacion) = YEAR(CURRENT_DATE)
            AND status = 1
            GROUP BY MONTH(fecha_publicacion)
            ORDER BY mes";
        $publicaciones_por_mes = $this->select_all($sql_por_mes);

        // Estado de publicaciones
        $sql_estado = "SELECT 
            status,
            COUNT(*) as total
            FROM publicaciones 
            GROUP BY status";
        $estado_publicaciones = $this->select_all($sql_estado);

        // Distribución de respuestas de envío
        $sql_respuestas = "SELECT 
            respuesta_envio,
            COUNT(*) as total
            FROM publicaciones 
            WHERE status = 1
            GROUP BY respuesta_envio";
        $respuestas_envio = $this->select_all($sql_respuestas);

        // Total de publicaciones (solo activas)
        $sql_total = "SELECT COUNT(*) as total FROM publicaciones WHERE status = 1";
        $total_publicaciones = $this->select($sql_total);

        // Publicaciones recientes (últimos 7 días) solo activas
        $sql_recientes = "SELECT COUNT(*) as total FROM publicaciones 
                         WHERE fecha_publicacion >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
                         AND status = 1";
        $publicaciones_recientes = $this->select($sql_recientes);

        // Publicaciones pendientes (sin respuesta de envío) solo activas
        $sql_pendientes = "SELECT COUNT(*) as total FROM publicaciones 
                          WHERE respuesta_envio = 'No'
                          AND status = 1";
        $publicaciones_pendientes = $this->select($sql_pendientes);

        // Publicaciones por dependencia
        $sql_dependencias = "SELECT 
            d.nombre as dependencia,
            COUNT(*) as total
            FROM publicaciones p
            LEFT JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk
            WHERE p.status = 1
            GROUP BY d.dependencia_pk, d.nombre
            ORDER BY total DESC";
        $publicaciones_por_dependencia = $this->select_all($sql_dependencias);

        return array(
            'publicaciones_por_mes' => $publicaciones_por_mes,
            'estado_publicaciones' => $estado_publicaciones,
            'respuestas_envio' => $respuestas_envio,
            'total_publicaciones' => $total_publicaciones['total'],
            'publicaciones_recientes' => $publicaciones_recientes['total'],
            'publicaciones_pendientes' => $publicaciones_pendientes['total'],
            'publicaciones_por_dependencia' => $publicaciones_por_dependencia
        );
    }

    public function updatePublicacion(int $idPublicacion, string $fechaRecibido, string $correoRecibido, 
                                    string $asunto, string $fechaPublicacion, string $respuestaEnvio, 
                                    string $enlacePublicacion, int $dependencia, int $status,
                                    string $nombrePublicacion = '')
    {
        $this->intIdPublicacion = $idPublicacion;
        $this->strFechaRecibido = $fechaRecibido;
        $this->strCorreoRecibido = $correoRecibido;
        $this->strAsunto = $asunto;
        $this->strFechaPublicacion = $fechaPublicacion;
        $this->strRespuestaEnvio = $respuestaEnvio;
        $this->strEnlacePublicacion = $enlacePublicacion;
        $this->intDependencia = $dependencia;
        $this->intStatus = $status;

        // Get current publication data if nombre_publicacion is not provided
        if (empty($nombrePublicacion)) {
            $currentData = $this->selectPublicacion($idPublicacion);
            $nombrePublicacion = $currentData['nombre_publicacion'];
        }

        $sql = "UPDATE publicaciones SET 
                fecha_recibido = ?, 
                correo_recibido = ?, 
                asunto = ?,
                nombre_publicacion = ?, 
                fecha_publicacion = ?, 
                respuesta_envio = ?, 
                enlace_publicacion = ?, 
                dependencia_fk = ?, 
                status = ? 
                WHERE id_publicacion = $this->intIdPublicacion";
        
        $arrData = array(
            $this->strFechaRecibido,
            $this->strCorreoRecibido,
            $this->strAsunto,
            $nombrePublicacion,
            $this->strFechaPublicacion,
            $this->strRespuestaEnvio,
            $this->strEnlacePublicacion,
            $this->intDependencia,
            $this->intStatus
        );

        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function getEstadisticasFiltradas($fechaInicio, $fechaFin)
    {
        // Publicaciones por mes filtradas
        $sql_por_mes = "SELECT 
            MONTH(fecha_publicacion) as mes,
            COUNT(*) as total
            FROM publicaciones 
            WHERE fecha_publicacion BETWEEN ? AND ?
            AND status = 1
            GROUP BY MONTH(fecha_publicacion)
            ORDER BY mes";
        $publicaciones_por_mes = $this->select_all($sql_por_mes, [$fechaInicio, $fechaFin]);

        // Estado de publicaciones filtradas
        $sql_estado = "SELECT 
            status,
            COUNT(*) as total
            FROM publicaciones 
            WHERE fecha_publicacion BETWEEN ? AND ?
            GROUP BY status";
        $estado_publicaciones = $this->select_all($sql_estado, [$fechaInicio, $fechaFin]);

        // Respuestas de envío filtradas
        $sql_respuestas = "SELECT 
            respuesta_envio,
            COUNT(*) as total
            FROM publicaciones 
            WHERE fecha_publicacion BETWEEN ? AND ?
            AND status = 1
            GROUP BY respuesta_envio";
        $respuestas_envio = $this->select_all($sql_respuestas, [$fechaInicio, $fechaFin]);

        // Publicaciones por dependencia filtradas
        $sql_dependencias = "SELECT 
            d.nombre as dependencia,
            COUNT(*) as total
            FROM publicaciones p
            LEFT JOIN tbl_dependencia d ON p.dependencia_fk = d.dependencia_pk
            WHERE p.fecha_publicacion BETWEEN ? AND ?
            AND p.status = 1
            GROUP BY d.dependencia_pk, d.nombre
            ORDER BY total DESC";
        $publicaciones_por_dependencia = $this->select_all($sql_dependencias, [$fechaInicio, $fechaFin]);

        return array(
            'publicaciones_por_mes' => $publicaciones_por_mes ?: [],
            'estado_publicaciones' => $estado_publicaciones ?: [],
            'respuestas_envio' => $respuestas_envio ?: [],
            'publicaciones_por_dependencia' => $publicaciones_por_dependencia ?: []
        );
    }
}
?>