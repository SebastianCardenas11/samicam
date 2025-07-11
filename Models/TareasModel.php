<?php 
    class TareasModel extends Mysql
    {
        private $id_tarea;
        private $id_usuario_creador;
        private $id_usuario_asignado;
        private $tipo;
        private $descripcion;
        private $dependencia_fk;
        private $estado;
        private $observacion;
        private $fecha_inicio;
        private $fecha_fin;

        public function __construct()
        {
            parent::__construct();
        }


        // Obtener todas las tareas
        public function getTareas()
        {
            $sql = "SELECT t.*, 
                    DATE_FORMAT(t.fecha_inicio, '%Y-%m-%d') as fecha_inicio,
                    DATE_FORMAT(t.fecha_fin, '%Y-%m-%d') as fecha_fin,
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    ORDER BY t.fecha_creacion DESC";
            
            $tareas = $this->select_all($sql);
            
            // Calcular tiempo restante para cada tarea
            $fechaActual = new DateTime();
            foreach ($tareas as &$tarea) {
                $fechaFin = new DateTime($tarea['fecha_fin']);
                $intervalo = $fechaActual->diff($fechaFin);
                
                if($fechaFin < $fechaActual) {
                    $tarea['tiempo_restante'] = 'Vencida';
                } else {
                    if($intervalo->days > 0) {
                        $tarea['tiempo_restante'] = $intervalo->days.' días';
                    } else {
                        $tarea['tiempo_restante'] = $intervalo->h.' horas';
                    }
                }
            }
            
            return $tareas;
        }

        // Obtener tareas por usuario asignado
        public function getTareasByUsuarioAsignado($id_usuario)
        {
            $sql = "SELECT DISTINCT t.*, 
                    DATE_FORMAT(t.fecha_inicio, '%Y-%m-%d') as fecha_inicio,
                    DATE_FORMAT(t.fecha_fin, '%Y-%m-%d') as fecha_fin,
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    WHERE (t.id_usuario_asignado = $id_usuario 
                           OR EXISTS (SELECT 1 FROM tbl_tareas_usuarios tu WHERE tu.id_tarea = t.id_tarea AND tu.id_usuario = $id_usuario))
                    ORDER BY t.fecha_creacion DESC";
            
            $tareas = $this->select_all($sql);
            
            // Calcular tiempo restante para cada tarea
            $fechaActual = new DateTime();
            foreach ($tareas as &$tarea) {
                $fechaFin = new DateTime($tarea['fecha_fin']);
                $intervalo = $fechaActual->diff($fechaFin);
                
                if($fechaFin < $fechaActual) {
                    $tarea['tiempo_restante'] = 'Vencida';
                } else {
                    if($intervalo->days > 0) {
                        $tarea['tiempo_restante'] = $intervalo->days.' días';
                    } else {
                        $tarea['tiempo_restante'] = $intervalo->h.' horas';
                    }
                }
            }
            
            return $tareas;
        }

        // Obtener tareas por usuario creador
        public function getTareasByUsuarioCreador($id_usuario)
        {
            $sql = "SELECT t.*, 
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    WHERE t.id_usuario_creador = $id_usuario
                    ORDER BY t.fecha_creacion DESC";
            
            $tareas = $this->select_all($sql);
            
            // Calcular tiempo restante para cada tarea
            $fechaActual = new DateTime();
            foreach ($tareas as &$tarea) {
                $fechaFin = new DateTime($tarea['fecha_fin']);
                $intervalo = $fechaActual->diff($fechaFin);
                
                if($fechaFin < $fechaActual) {
                    $tarea['tiempo_restante'] = 'Vencida';
                } else {
                    if($intervalo->days > 0) {
                        $tarea['tiempo_restante'] = $intervalo->days.' días';
                    } else {
                        $tarea['tiempo_restante'] = $intervalo->h.' horas';
                    }
                }
            }
            
            return $tareas;
        }

        // Obtener una tarea por ID
        public function getTarea($id_tarea)
        {
            $sql = "SELECT t.*, 
                    DATE_FORMAT(t.fecha_inicio, '%Y-%m-%d') as fecha_inicio,
                    DATE_FORMAT(t.fecha_fin, '%Y-%m-%d') as fecha_fin,
                    DATE_FORMAT(t.fecha_inicio, '%d/%m/%Y') as fecha_inicio_format,
                    DATE_FORMAT(t.fecha_fin, '%d/%m/%Y') as fecha_fin_format,
                    DATE_FORMAT(t.fecha_completada, '%d/%m/%Y') as fecha_completada,
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    WHERE t.id_tarea = $id_tarea";
            $tarea = $this->select($sql);
            
            // Obtener todos los usuarios asignados a esta tarea
            if ($tarea) {
                $tarea['usuarios_asignados'] = $this->getUsuariosTarea($id_tarea);
                
                // Calcular tiempo restante
                $fechaFin = new DateTime($tarea['fecha_fin']);
                
                // Si la tarea está completada
                if ($tarea['estado'] == 'Completada' && !empty($tarea['fecha_completada'])) {
                    $fechaCompletada = new DateTime(date('Y-m-d', strtotime(str_replace('/', '-', $tarea['fecha_completada']))));
                    $intervalo = $fechaFin->diff($fechaCompletada);
                    
                    if ($fechaCompletada <= $fechaFin) {
                        $tarea['tiempo_restante'] = '0 días';
                    } else {
                        $tarea['tiempo_restante'] = $intervalo->days.' días de retraso';
                    }
                } else {
                    // Para tareas no completadas
                    $fechaActual = new DateTime();
                    $intervalo = $fechaActual->diff($fechaFin);
                    
                    if ($fechaFin < $fechaActual) {
                        $tarea['tiempo_restante'] = 'Vencida';
                    } else {
                        if ($intervalo->days > 0) {
                            $tarea['tiempo_restante'] = $intervalo->days.' días';
                        } else {
                            $tarea['tiempo_restante'] = $intervalo->h.' horas';
                        }
                    }
                }
            }
            
            return $tarea;
        }

        // Obtener observaciones de una tarea
        public function getObservacionesTarea($id_tarea)
        {
            $sql = "SELECT o.*, u.nombres as usuario_nombre, DATE_FORMAT(o.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_format
                    FROM tbl_observaciones o
                    INNER JOIN tbl_usuarios u ON o.id_usuario = u.ideusuario
                    WHERE o.id_tarea = $id_tarea
                    ORDER BY o.fecha_creacion DESC";
            return $this->select_all($sql);
        }

        // Obtener usuarios con rol Técnico NTIC o Super Admin (incluyendo roles adicionales)
        public function getUsuariosAsignables()
        {
            $sql = "SELECT DISTINCT u.ideusuario, u.nombres 
                    FROM tbl_usuarios u 
                    WHERE u.status = 1
                    AND (
                        -- Usuario con rol principal que califica
                        EXISTS (
                            SELECT 1 FROM rol r 
                            WHERE r.idrol = u.rolid 
                            AND (r.nombrerol LIKE '%Tecnico%' OR r.nombrerol LIKE '%Técnico%' OR r.nombrerol = 'Superadministrador' OR r.nombrerol LIKE '%NTIC%')
                        )
                        OR
                        -- Usuario con roles adicionales que califican
                        EXISTS (
                            SELECT 1 FROM tbl_usuarios_roles ur
                            INNER JOIN rol r ON ur.id_rol = r.idrol
                            WHERE ur.id_usuario = u.ideusuario
                            AND (r.nombrerol LIKE '%Tecnico%' OR r.nombrerol LIKE '%Técnico%' OR r.nombrerol = 'Superadministrador' OR r.nombrerol LIKE '%NTIC%')
                        )
                    )
                    ORDER BY u.nombres ASC";
            
            return $this->select_all($sql);
        }

        // Obtener todas las dependencias
        public function getDependencias()
        {
            $sql = "SELECT * FROM tbl_dependencia";
            return $this->select_all($sql);
        }

        // Crear una nueva tarea
        public function insertTarea(int $id_usuario_creador, array $usuarios_asignados, string $tipo, 
                                   string $descripcion, int $dependencia_fk, string $fecha_inicio, 
                                   string $fecha_fin, string $observacion = null)
        {
            $this->id_usuario_creador = $id_usuario_creador;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->dependencia_fk = $dependencia_fk;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            
            // Asignar el primer usuario como principal para mantener compatibilidad
            $id_usuario_principal = $usuarios_asignados[0];
            
            $sql = "INSERT INTO tbl_tareas (id_usuario_creador, id_usuario_asignado, tipo, descripcion, 
                    dependencia_fk, fecha_inicio, fecha_fin) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            // Formatear las fechas para eliminar la hora
            $this->fecha_inicio = date('Y-m-d', strtotime($this->fecha_inicio));
            $this->fecha_fin = date('Y-m-d', strtotime($this->fecha_fin));
            
            $arrData = array($this->id_usuario_creador, $id_usuario_principal, $this->tipo, 
                            $this->descripcion, $this->dependencia_fk, $this->fecha_inicio, 
                            $this->fecha_fin);
            
            $id_tarea = $this->insert($sql, $arrData);
            
            // Insertar todos los usuarios asignados en la tabla de relación
            foreach ($usuarios_asignados as $id_usuario) {
                $this->insertTareaUsuario($id_tarea, $id_usuario);
            }
            
            // Si hay observación inicial, la guardamos
            if(!empty($observacion)) {
                $this->insertObservacion($id_tarea, $id_usuario_creador, $observacion);
            }
            
            return $id_tarea;
        }
        
        // Insertar relación tarea-usuario
        public function insertTareaUsuario(int $id_tarea, int $id_usuario)
        {
            $sql = "INSERT INTO tbl_tareas_usuarios (id_tarea, id_usuario) VALUES (?, ?)";
            $arrData = array($id_tarea, $id_usuario);
            return $this->insert($sql, $arrData);
        }

        // Insertar una observación
        public function insertObservacion(int $id_tarea, int $id_usuario, string $observacion)
        {
            $sql = "INSERT INTO tbl_observaciones (id_tarea, id_usuario, observacion) VALUES (?, ?, ?)";
            $arrData = array($id_tarea, $id_usuario, $observacion);
            return $this->insert($sql, $arrData);
        }

        // Actualizar una tarea
        public function updateTarea(int $id_tarea, array $usuarios_asignados, string $tipo, 
                                   string $descripcion, int $dependencia_fk, string $estado,
                                   string $fecha_inicio, string $fecha_fin, string $observacion = null)
        {
            $this->id_tarea = $id_tarea;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->dependencia_fk = $dependencia_fk;
            $this->estado = $estado;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            
            // Asignar el primer usuario como principal para mantener compatibilidad
            $id_usuario_principal = $usuarios_asignados[0];
            
            $sql = "UPDATE tbl_tareas SET id_usuario_asignado = ?, tipo = ?, descripcion = ?, 
                    dependencia_fk = ?, estado = ?, fecha_inicio = ?, fecha_fin = ? 
                    WHERE id_tarea = ?";
            
            // Formatear las fechas para eliminar la hora
            $this->fecha_inicio = date('Y-m-d', strtotime($this->fecha_inicio));
            $this->fecha_fin = date('Y-m-d', strtotime($this->fecha_fin));
            $arrData = array($id_usuario_principal, $this->tipo, $this->descripcion, 
                            $this->dependencia_fk, $this->estado, $this->fecha_inicio, 
                            $this->fecha_fin, $this->id_tarea);
            
            $result = $this->update($sql, $arrData);
            
            // Eliminar todas las asignaciones anteriores
            $this->deleteTareaUsuarios($id_tarea);
            
            // Insertar todos los usuarios asignados en la tabla de relación
            foreach ($usuarios_asignados as $id_usuario) {
                $this->insertTareaUsuario($id_tarea, $id_usuario);
            }
            
            // Si hay observación nueva, la guardamos
            if(!empty($observacion)) {
                $this->insertObservacion($id_tarea, $_SESSION['idUser'], $observacion);
            }
            
            return $result;
        }
        
        // Eliminar todas las relaciones tarea-usuario para una tarea
        public function deleteTareaUsuarios(int $id_tarea)
        {
            $sql = "DELETE FROM tbl_tareas_usuarios WHERE id_tarea = ?";
            return $this->delete($sql, array($id_tarea));
        }
        
        // Obtener todos los usuarios asignados a una tarea
        public function getUsuariosTarea(int $id_tarea)
        {
            $sql = "SELECT u.ideusuario, u.nombres 
                    FROM tbl_usuarios u 
                    INNER JOIN tbl_tareas_usuarios tu ON u.ideusuario = tu.id_usuario 
                    WHERE tu.id_tarea = $id_tarea
                    ORDER BY u.nombres ASC";
            return $this->select_all($sql);
        }
        
        // Verificar si un usuario está asignado a una tarea
        public function esUsuarioAsignadoATarea(int $id_tarea, int $id_usuario)
        {
            // Verificar si es el usuario principal
            $sql = "SELECT COUNT(*) as total FROM tbl_tareas 
                    WHERE id_tarea = $id_tarea AND id_usuario_asignado = $id_usuario";
            $result = $this->select($sql);
            
            if ($result['total'] > 0) {
                return true;
            }
            
            // Verificar si está en la tabla de relación
            $sql = "SELECT COUNT(*) as total FROM tbl_tareas_usuarios 
                    WHERE id_tarea = $id_tarea AND id_usuario = $id_usuario";
            $result = $this->select($sql);
            
            return ($result['total'] > 0);
        }

        // Actualizar solo el estado de una tarea
        public function updateEstadoTarea(int $id_tarea, string $estado)
        {
            $this->id_tarea = $id_tarea;
            $this->estado = $estado;
            
            if($estado == 'completada') {
                $sql = "UPDATE tbl_tareas SET estado = ?, fecha_completada = CURDATE() WHERE id_tarea = ?";
            } else {
                $sql = "UPDATE tbl_tareas SET estado = ? WHERE id_tarea = ?";
            }
            
            $arrData = array($this->estado, $this->id_tarea);
            
            return $this->update($sql, $arrData);
        }

        // Eliminar una tarea
        public function deleteTarea(int $id_tarea)
        {
            $this->id_tarea = $id_tarea;
            
            // Primero eliminamos las observaciones asociadas
            $sql = "DELETE FROM tbl_observaciones WHERE id_tarea = ?";
            $this->delete($sql, array($this->id_tarea));
            
            // Eliminamos las relaciones con usuarios
            $this->deleteTareaUsuarios($id_tarea);
            
            // Luego eliminamos la tarea
            $sql = "DELETE FROM tbl_tareas WHERE id_tarea = ?";
            $arrData = array($this->id_tarea);
            
            return $this->delete($sql, $arrData);
        }

        public function countTareasPorEstado(int $estado)
        {
            $estadoTexto = '';
            switch($estado) {
                case 0:
                    $estadoTexto = 'sin empezar';
                    break;
                case 1:
                    $estadoTexto = 'en curso';
                    break;
                case 2:
                    $estadoTexto = 'completada';
                    break;
            }
            
            $sql = "SELECT COUNT(DISTINCT id_tarea) as total FROM tbl_tareas WHERE estado = ?";
            $request = $this->select($sql, [$estadoTexto]);
            return $request['total'];
        }

        public function countTareasVencidas()
        {
            $fecha_actual = date('Y-m-d');
            $sql = "SELECT COUNT(*) as total FROM tbl_tareas 
                    WHERE fecha_fin < '{$fecha_actual}' 
                    AND estado != 'completada'";
            $request = $this->select($sql);
            return $request['total'];
        }

        public function getTareasPorTipo()
        {
            $sql = "SELECT t.tipo as nombre, COUNT(*) as cantidad 
                    FROM tbl_tareas t 
                    GROUP BY t.tipo 
                    ORDER BY cantidad DESC";
            return $this->select_all($sql);
        }

        public function getTareasCompletadasPorMes()
        {
            // Obtener los últimos 12 meses
            $meses = array();
            for ($i = 11; $i >= 0; $i--) {
                $fecha = date('Y-m', strtotime("-$i months"));
                $meses[$fecha] = 0;
            }
            
            $sql = "SELECT DATE_FORMAT(fecha_completada, '%Y-%m') as mes, 
                           COUNT(*) as cantidad
                    FROM tbl_tareas 
                    WHERE estado = 'completada' 
                    AND fecha_completada IS NOT NULL
                    GROUP BY DATE_FORMAT(fecha_completada, '%Y-%m')
                    ORDER BY mes DESC 
                    LIMIT 12";
            $resultados = $this->select_all($sql);
            
            // Llenar los datos en el array de meses
            foreach ($resultados as $resultado) {
                if (isset($meses[$resultado['mes']])) {
                    $meses[$resultado['mes']] = (int)$resultado['cantidad'];
                }
            }
            
            // Convertir a formato de array para el gráfico
            $datos = array();
            foreach ($meses as $mes => $cantidad) {
                $datos[] = array(
                    'mes' => $mes,
                    'cantidad' => $cantidad
                );
            }
            
            return $datos;
        }

        // Obtener todos los usuarios asignados a una tarea con información de contacto
        public function getUsuariosTareaConContacto(int $id_tarea)
        {
            $sql = "SELECT u.ideusuario, u.nombres, u.correo, fp.celular, fp.correo_elc
                    FROM tbl_usuarios u 
                    INNER JOIN tbl_tareas_usuarios tu ON u.ideusuario = tu.id_usuario 
                    LEFT JOIN tbl_funcionarios_planta fp ON u.correo = fp.correo_elc
                    WHERE tu.id_tarea = $id_tarea
                    ORDER BY u.nombres ASC";
            return $this->select_all($sql);
        }

        // Obtener información completa de usuarios por IDs
        public function getUsuariosInfoCompleta(array $usuarios_ids)
        {
            if (empty($usuarios_ids)) {
                return [];
            }
            
            $ids = implode(',', $usuarios_ids);
            $sql = "SELECT u.ideusuario as id, u.nombres, u.correo, fp.celular, fp.correo_elc
                    FROM tbl_usuarios u 
                    LEFT JOIN tbl_funcionarios_planta fp ON u.correo = fp.correo_elc
                    WHERE u.ideusuario IN ($ids)
                    ORDER BY u.nombres ASC";
            return $this->select_all($sql);
        }
    }
?>