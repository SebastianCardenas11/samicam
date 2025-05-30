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
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    ORDER BY t.fecha_creacion DESC";
            
            return $this->select_all($sql);
        }

        // Obtener tareas por usuario asignado
        public function getTareasByUsuarioAsignado($id_usuario)
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
                    WHERE t.id_usuario_asignado = $id_usuario
                    ORDER BY t.fecha_creacion DESC";
            
            return $this->select_all($sql);
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
            
            return $this->select_all($sql);
        }

        // Obtener una tarea por ID
        public function getTarea($id_tarea)
        {
            $sql = "SELECT t.*, 
                    DATE_FORMAT(t.fecha_inicio, '%d/%m/%Y') as fecha_inicio_format,
                    DATE_FORMAT(t.fecha_fin, '%d/%m/%Y') as fecha_fin_format,
                    DATE_FORMAT(t.fecha_completada, '%d/%m/%Y %H:%i') as fecha_completada,
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre,
                    (SELECT COUNT(*) FROM tbl_observaciones WHERE id_tarea = t.id_tarea) as num_observaciones
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    WHERE t.id_tarea = $id_tarea";
            return $this->select($sql);
        }

        // Obtener observaciones de una tarea
        public function getObservacionesTarea($id_tarea)
        {
            $sql = "SELECT o.*, u.nombres as usuario_nombre, DATE_FORMAT(o.fecha_creacion, '%d/%m/%Y %H:%i') as fecha_format
                    FROM tbl_observaciones o
                    INNER JOIN tbl_usuarios u ON o.id_usuario = u.ideusuario
                    WHERE o.id_tarea = $id_tarea
                    ORDER BY o.fecha_creacion DESC";
            return $this->select_all($sql);
        }

        // Obtener usuarios con rol Técnico NTIC o Super Admin
        public function getUsuariosAsignables()
        {
            $sql = "SELECT u.ideusuario, u.nombres 
                    FROM tbl_usuarios u 
                    INNER JOIN rol r ON u.rolid = r.idrol 
                    WHERE (r.nombrerol LIKE '%Tecnico%' OR r.nombrerol LIKE '%Técnico%' OR r.nombrerol = 'Superadministrador')
                    AND u.status = 1
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
        public function insertTarea(int $id_usuario_creador, int $id_usuario_asignado, string $tipo, 
                                   string $descripcion, int $dependencia_fk, string $fecha_inicio, 
                                   string $fecha_fin, string $observacion = null)
        {
            $this->id_usuario_creador = $id_usuario_creador;
            $this->id_usuario_asignado = $id_usuario_asignado;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->dependencia_fk = $dependencia_fk;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            
            $sql = "INSERT INTO tbl_tareas (id_usuario_creador, id_usuario_asignado, tipo, descripcion, 
                    dependencia_fk, fecha_inicio, fecha_fin) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $arrData = array($this->id_usuario_creador, $this->id_usuario_asignado, $this->tipo, 
                            $this->descripcion, $this->dependencia_fk, $this->fecha_inicio, 
                            $this->fecha_fin);
            
            $id_tarea = $this->insert($sql, $arrData);
            
            // Si hay observación inicial, la guardamos
            if(!empty($observacion)) {
                $this->insertObservacion($id_tarea, $id_usuario_creador, $observacion);
            }
            
            return $id_tarea;
        }

        // Insertar una observación
        public function insertObservacion(int $id_tarea, int $id_usuario, string $observacion)
        {
            $sql = "INSERT INTO tbl_observaciones (id_tarea, id_usuario, observacion) VALUES (?, ?, ?)";
            $arrData = array($id_tarea, $id_usuario, $observacion);
            return $this->insert($sql, $arrData);
        }

        // Actualizar una tarea
        public function updateTarea(int $id_tarea, int $id_usuario_asignado, string $tipo, 
                                   string $descripcion, int $dependencia_fk, string $estado,
                                   string $fecha_inicio, string $fecha_fin, string $observacion = null)
        {
            $this->id_tarea = $id_tarea;
            $this->id_usuario_asignado = $id_usuario_asignado;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->dependencia_fk = $dependencia_fk;
            $this->estado = $estado;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            
            $sql = "UPDATE tbl_tareas SET id_usuario_asignado = ?, tipo = ?, descripcion = ?, 
                    dependencia_fk = ?, estado = ?, fecha_inicio = ?, fecha_fin = ? 
                    WHERE id_tarea = ?";
            $arrData = array($this->id_usuario_asignado, $this->tipo, $this->descripcion, 
                            $this->dependencia_fk, $this->estado, $this->fecha_inicio, 
                            $this->fecha_fin, $this->id_tarea);
            
            $result = $this->update($sql, $arrData);
            
            // Si hay observación nueva, la guardamos
            if(!empty($observacion)) {
                $this->insertObservacion($id_tarea, $_SESSION['idUser'], $observacion);
            }
            
            return $result;
        }

        // Actualizar solo el estado de una tarea
        public function updateEstadoTarea(int $id_tarea, string $estado)
        {
            $this->id_tarea = $id_tarea;
            $this->estado = $estado;
            
            if($estado == 'completada') {
                $sql = "UPDATE tbl_tareas SET estado = ?, fecha_completada = NOW() WHERE id_tarea = ?";
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
            
            // Luego eliminamos la tarea
            $sql = "DELETE FROM tbl_tareas WHERE id_tarea = ?";
            $arrData = array($this->id_tarea);
            
            return $this->delete($sql, $arrData);
        }
    }
?>