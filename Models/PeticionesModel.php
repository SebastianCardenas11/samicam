<?php 
class PeticionesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las peticiones con información relacionada
    public function getPeticiones()
    {
        $sql = "SELECT p.*, 
                tp.nombre as tipo_peticion_nombre,
                tp.dias_habiles_plazo,
                d.nombre as dependencia_nombre,
                dr.nombre as area_remitida_nombre,
                uc.nombres as usuario_creador_nombre,
                ur.nombres as usuario_responsable_nombre,
                DATE_FORMAT(p.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso_format,
                DATE_FORMAT(p.fecha_vencimiento, '%d/%m/%Y') as fecha_vencimiento_format,
                DATE_FORMAT(p.fecha_respuesta, '%d/%m/%Y') as fecha_respuesta_format,
                CASE 
                    WHEN p.estado_semaforo = 'verde' THEN 'success'
                    WHEN p.estado_semaforo = 'amarillo' THEN 'warning'
                    WHEN p.estado_semaforo = 'rojo' THEN 'danger'
                    ELSE 'secondary'
                END as badge_class
                FROM tbl_peticiones p
                INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                LEFT JOIN tbl_dependencia dr ON p.area_remitida = dr.dependencia_pk
                INNER JOIN tbl_usuarios uc ON p.usuario_creador = uc.ideusuario
                LEFT JOIN tbl_usuarios ur ON p.usuario_responsable = ur.ideusuario
                ORDER BY p.fecha_creacion DESC";
        
        return $this->select_all($sql);
    }

    // Obtener una petición específica
    public function getPeticion($id_peticion)
    {
        $sql = "SELECT p.*, 
                tp.nombre as tipo_peticion_nombre,
                tp.dias_habiles_plazo,
                d.nombre as dependencia_nombre,
                dr.nombre as area_remitida_nombre,
                uc.nombres as usuario_creador_nombre,
                ur.nombres as usuario_responsable_nombre,
                DATE_FORMAT(p.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso_format,
                DATE_FORMAT(p.fecha_vencimiento, '%d/%m/%Y') as fecha_vencimiento_format,
                DATE_FORMAT(p.fecha_respuesta, '%d/%m/%Y') as fecha_respuesta_format
                FROM tbl_peticiones p
                INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                LEFT JOIN tbl_dependencia dr ON p.area_remitida = dr.dependencia_pk
                INNER JOIN tbl_usuarios uc ON p.usuario_creador = uc.ideusuario
                LEFT JOIN tbl_usuarios ur ON p.usuario_responsable = ur.ideusuario
                WHERE p.id_peticion = ?";
        
        return $this->select($sql, [$id_peticion]);
    }

    // Crear nueva petición
    public function insertPeticion($numero_radicado, $fecha_ingreso, $nombre_peticionario, 
                                  $descripcion_solicitud, $id_tipo_peticion, $areas_responsables,
                                  $fecha_remision, $consecutivo, $dias_vencer, $fecha_vencimiento,
                                  $observaciones, $usuario_creador)
    {
        $sql = "INSERT INTO tbl_peticiones (numero_radicado, fecha_ingreso, nombre_peticionario, 
                descripcion_solicitud, id_tipo_peticion, areas_responsables, fecha_remision,
                consecutivo, dias_vencer, fecha_vencimiento, observaciones, usuario_creador) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $arrData = [$numero_radicado, $fecha_ingreso, $nombre_peticionario, $descripcion_solicitud, 
                   $id_tipo_peticion, $areas_responsables, $fecha_remision, $consecutivo, 
                   $dias_vencer, $fecha_vencimiento, $observaciones, $usuario_creador];
        
        return $this->insert($sql, $arrData);
    }

    // Actualizar petición
    public function updatePeticion($id_peticion, $numero_radicado, $fecha_ingreso, $nombre_peticionario, 
                                  $descripcion_solicitud, $id_tipo_peticion, $areas_responsables,
                                  $fecha_remision, $consecutivo, $dias_vencer, $fecha_vencimiento,
                                  $observaciones, $usuario_responsable)
    {
        $sql = "UPDATE tbl_peticiones SET 
                numero_radicado = ?, fecha_ingreso = ?, nombre_peticionario = ?, 
                descripcion_solicitud = ?, id_tipo_peticion = ?, areas_responsables = ?,
                fecha_remision = ?, consecutivo = ?, dias_vencer = ?, fecha_vencimiento = ?,
                observaciones = ?
                WHERE id_peticion = ?";
        
        $arrData = [$numero_radicado, $fecha_ingreso, $nombre_peticionario, $descripcion_solicitud, 
                   $id_tipo_peticion, $areas_responsables, $fecha_remision, $consecutivo,
                   $dias_vencer, $fecha_vencimiento, $observaciones, $id_peticion];
        
        return $this->update($sql, $arrData);
    }

    // Responder petición
    public function responderPeticion($id_peticion, $comentario_respuesta, $usuario_responsable, $archivo_respuesta = null)
    {
        $fecha_respuesta = date('Y-m-d');
        
        // Obtener información de la petición para calcular días hábiles de respuesta
        $peticion = $this->getPeticion($id_peticion);
        $dias_habiles_respuesta = $this->calcularDiasHabiles($peticion['fecha_ingreso'], $fecha_respuesta);
        
        if ($archivo_respuesta) {
            $sql = "UPDATE tbl_peticiones SET 
                    estado = 'respondida', fecha_respuesta = ?, dias_habiles_respuesta = ?, 
                    comentario_respuesta = ?, archivo_respuesta = ?, usuario_responsable = ?
                    WHERE id_peticion = ?";
            $arrData = [$fecha_respuesta, $dias_habiles_respuesta, $comentario_respuesta, 
                       $archivo_respuesta, $usuario_responsable, $id_peticion];
        } else {
            $sql = "UPDATE tbl_peticiones SET 
                    estado = 'respondida', fecha_respuesta = ?, dias_habiles_respuesta = ?, 
                    comentario_respuesta = ?, usuario_responsable = ?
                    WHERE id_peticion = ?";
            $arrData = [$fecha_respuesta, $dias_habiles_respuesta, $comentario_respuesta, 
                       $usuario_responsable, $id_peticion];
        }
        
        return $this->update($sql, $arrData);
    }

    // Remitir petición a otra área
    public function remitirPeticion($id_peticion, $area_remitida, $motivo_remision, $usuario_responsable)
    {
        $sql = "UPDATE tbl_peticiones SET 
                estado = 'remitida', area_remitida = ?, motivo_remision = ?, 
                dependencia_responsable = ?, usuario_responsable = ?
                WHERE id_peticion = ?";
        
        $arrData = [$area_remitida, $motivo_remision, $area_remitida, $usuario_responsable, $id_peticion];
        
        return $this->update($sql, $arrData);
    }

    // Marcar petición como desistida
    public function desistirPeticion($id_peticion, $observaciones, $usuario_responsable)
    {
        $sql = "UPDATE tbl_peticiones SET 
                estado = 'desistida', observaciones = ?, usuario_responsable = ?
                WHERE id_peticion = ?";
        
        $arrData = [$observaciones, $usuario_responsable, $id_peticion];
        
        return $this->update($sql, $arrData);
    }

    // Obtener tipos de petición
    public function getTiposPeticion()
    {
        $sql = "SELECT * FROM tbl_tipos_peticion WHERE status = 1 ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    // Obtener dependencias
    public function getDependencias()
    {
        $sql = "SELECT * FROM tbl_dependencia ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    // Obtener usuarios responsables
    public function getUsuariosResponsables()
    {
        $sql = "SELECT ideusuario, nombres FROM tbl_usuarios WHERE status = 1 ORDER BY nombres ASC";
        return $this->select_all($sql);
    }

    // Obtener estadísticas del dashboard
    public function getEstadisticas()
    {
        $estadisticas = [];
        
        // Total de peticiones
        $sql = "SELECT COUNT(*) as total FROM tbl_peticiones";
        $result = $this->select($sql);
        $estadisticas['total_peticiones'] = $result['total'];
        
        // Peticiones por estado
        $sql = "SELECT estado, COUNT(*) as cantidad FROM tbl_peticiones GROUP BY estado";
        $estados = $this->select_all($sql);
        foreach ($estados as $estado) {
            $estadisticas['por_estado'][$estado['estado']] = $estado['cantidad'];
        }
        
        // Peticiones por semáforo
        $sql = "SELECT estado_semaforo, COUNT(*) as cantidad FROM tbl_peticiones 
                WHERE estado IN ('radicada', 'en_proceso') GROUP BY estado_semaforo";
        $semaforos = $this->select_all($sql);
        foreach ($semaforos as $semaforo) {
            $estadisticas['por_semaforo'][$semaforo['estado_semaforo']] = $semaforo['cantidad'];
        }
        
        // Peticiones próximas a vencer (5 días o menos)
        $sql = "SELECT COUNT(*) as total FROM tbl_peticiones 
                WHERE estado IN ('radicada', 'en_proceso') AND dias_habiles_restantes <= 5";
        $result = $this->select($sql);
        $estadisticas['proximas_vencer'] = $result['total'];
        
        // Peticiones vencidas
        $sql = "SELECT COUNT(*) as total FROM tbl_peticiones WHERE estado = 'vencida'";
        $result = $this->select($sql);
        $estadisticas['vencidas'] = $result['total'];
        
        // Promedio de días de respuesta por dependencia
        $sql = "SELECT d.nombre as dependencia, AVG(p.dias_habiles_respuesta) as promedio_dias
                FROM tbl_peticiones p
                INNER JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                WHERE p.estado = 'respondida' AND p.dias_habiles_respuesta IS NOT NULL
                GROUP BY d.dependencia_pk, d.nombre
                ORDER BY promedio_dias ASC";
        $estadisticas['promedio_por_dependencia'] = $this->select_all($sql);
        
        return $estadisticas;
    }

    // Obtener reportes
    public function getReporte($tipo, $fecha_inicio = null, $fecha_fin = null, $dependencia = null)
    {
        $where_conditions = [];
        $params = [];
        
        if ($fecha_inicio && $fecha_fin) {
            $where_conditions[] = "p.fecha_ingreso BETWEEN ? AND ?";
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        }
        
        if ($dependencia) {
            $where_conditions[] = "p.dependencia_responsable = ?";
            $params[] = $dependencia;
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        
        switch ($tipo) {
            case 'vencidas':
                $sql = "SELECT p.*, tp.nombre as tipo_peticion, d.nombre as dependencia
                        FROM tbl_peticiones p
                        INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                        LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                        WHERE p.estado = 'vencida' " . 
                        ($where_clause ? "AND " . str_replace("WHERE ", "", $where_clause) : "") . "
                        ORDER BY p.fecha_vencimiento ASC";
                break;
                
            case 'proximas_vencer':
                $sql = "SELECT p.*, tp.nombre as tipo_peticion, d.nombre as dependencia
                        FROM tbl_peticiones p
                        INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                        LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                        WHERE p.estado IN ('radicada', 'en_proceso') AND p.dias_habiles_restantes <= 5 " . 
                        ($where_clause ? "AND " . str_replace("WHERE ", "", $where_clause) : "") . "
                        ORDER BY p.dias_habiles_restantes ASC";
                break;
                
            case 'respondidas':
                $sql = "SELECT p.*, tp.nombre as tipo_peticion, d.nombre as dependencia
                        FROM tbl_peticiones p
                        INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                        LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                        WHERE p.estado = 'respondida' " . 
                        ($where_clause ? "AND " . str_replace("WHERE ", "", $where_clause) : "") . "
                        ORDER BY p.fecha_respuesta DESC";
                break;
                
            case 'por_dependencia':
                $sql = "SELECT d.nombre as dependencia, 
                        COUNT(*) as total_peticiones,
                        SUM(CASE WHEN p.estado = 'respondida' THEN 1 ELSE 0 END) as respondidas,
                        SUM(CASE WHEN p.estado = 'vencida' THEN 1 ELSE 0 END) as vencidas,
                        AVG(CASE WHEN p.estado = 'respondida' THEN p.dias_habiles_respuesta END) as promedio_dias
                        FROM tbl_peticiones p
                        INNER JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                        $where_clause
                        GROUP BY d.dependencia_pk, d.nombre
                        ORDER BY total_peticiones DESC";
                break;
                
            default:
                $sql = "SELECT p.*, tp.nombre as tipo_peticion, d.nombre as dependencia
                        FROM tbl_peticiones p
                        INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                        LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                        $where_clause
                        ORDER BY p.fecha_creacion DESC";
        }
        
        return $this->select_all($sql, $params);
    }

    // Calcular días hábiles entre dos fechas (versión simplificada)
    private function calcularDiasHabiles($fecha_inicio, $fecha_fin)
    {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        $dias = 0;
        
        while ($inicio <= $fin) {
            $dia_semana = $inicio->format('N');
            if ($dia_semana >= 1 && $dia_semana <= 5) {
                $dias++;
            }
            $inicio->add(new DateInterval('P1D'));
        }
        
        return $dias;
    }

    // Actualizar estados automáticamente
    public function actualizarEstados()
    {
        // Actualizar peticiones vencidas
        $sql = "UPDATE tbl_peticiones SET estado = 'vencida' 
                WHERE estado IN ('radicada', 'en_proceso') 
                AND fecha_vencimiento < CURDATE()";
        
        $this->update($sql, []);
        
        // Actualizar días hábiles restantes y semáforo para peticiones activas
        $sql = "UPDATE tbl_peticiones p
                INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                SET p.dias_habiles_restantes = calcular_dias_habiles(CURDATE(), p.fecha_vencimiento),
                    p.estado_semaforo = CASE 
                        WHEN calcular_dias_habiles(CURDATE(), p.fecha_vencimiento) <= 0 THEN 'rojo'
                        WHEN calcular_dias_habiles(CURDATE(), p.fecha_vencimiento) <= 5 THEN 'rojo'
                        WHEN calcular_dias_habiles(CURDATE(), p.fecha_vencimiento) <= 10 THEN 'amarillo'
                        ELSE 'verde'
                    END
                WHERE p.estado IN ('radicada', 'en_proceso')";
        
        return $this->update($sql, []);
    }

    // Obtener historial de una petición
    public function getHistorialPeticion($id_peticion)
    {
        $sql = "SELECT h.*, u.nombres as usuario_nombre,
                DATE_FORMAT(h.fecha_cambio, '%d/%m/%Y %H:%i') as fecha_cambio_format
                FROM tbl_peticiones_historial h
                INNER JOIN tbl_usuarios u ON h.usuario = u.ideusuario
                WHERE h.id_peticion = ?
                ORDER BY h.fecha_cambio DESC";
        
        return $this->select_all($sql, [$id_peticion]);
    }

    // Verificar si el número de radicado ya existe
    public function existeRadicado($numero_radicado, $id_peticion = null)
    {
        if ($id_peticion) {
            $sql = "SELECT COUNT(*) as total FROM tbl_peticiones 
                    WHERE numero_radicado = ? AND id_peticion != ?";
            $result = $this->select($sql, [$numero_radicado, $id_peticion]);
        } else {
            $sql = "SELECT COUNT(*) as total FROM tbl_peticiones WHERE numero_radicado = ?";
            $result = $this->select($sql, [$numero_radicado]);
        }
        
        return $result['total'] > 0;
    }

    // Eliminar petición
    public function deletePeticion($id_peticion)
    {
        $sql = "DELETE FROM tbl_peticiones WHERE id_peticion = ?";
        return $this->delete($sql, [$id_peticion]);
    }

    // Obtener notificaciones pendientes
    public function getNotificacionesPendientes()
    {
        // Peticiones próximas a vencer (2 días hábiles o menos)
        $sql = "SELECT p.*, tp.nombre as tipo_peticion, d.nombre as dependencia
                FROM tbl_peticiones p
                INNER JOIN tbl_tipos_peticion tp ON p.id_tipo_peticion = tp.id_tipo
                LEFT JOIN tbl_dependencia d ON p.dependencia_responsable = d.dependencia_pk
                WHERE p.estado IN ('radicada', 'en_proceso') 
                AND p.dias_habiles_restantes <= 2 
                AND p.dias_habiles_restantes > 0
                ORDER BY p.dias_habiles_restantes ASC";
        
        return $this->select_all($sql);
    }
}
?>