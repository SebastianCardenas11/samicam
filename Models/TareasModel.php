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
                    d.nombre as dependencia_nombre
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
                    d.nombre as dependencia_nombre
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
                    d.nombre as dependencia_nombre
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
                    uc.nombres as creador_nombre, 
                    ua.nombres as asignado_nombre,
                    d.nombre as dependencia_nombre
                    FROM tbl_tareas t
                    INNER JOIN tbl_usuarios uc ON t.id_usuario_creador = uc.ideusuario
                    INNER JOIN tbl_usuarios ua ON t.id_usuario_asignado = ua.ideusuario
                    INNER JOIN tbl_dependencia d ON t.dependencia_fk = d.dependencia_pk
                    WHERE t.id_tarea = $id_tarea";
            return $this->select($sql);
        }

        // Obtener usuarios con rol Técnico NTIC o Super Admin
        public function getUsuariosAsignables()
        {
            $sql = "SELECT u.ideusuario, u.nombres 
                    FROM tbl_usuarios u 
                    INNER JOIN rol r ON u.rolid = r.idrol 
                    WHERE r.nombrerol = 'Tecnico Ntic' OR r.nombrerol = 'Superadministrador'
                    AND u.status = 1";
            
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
            $this->observacion = $observacion;
            $sql = "INSERT INTO tbl_tareas (id_usuario_creador, id_usuario_asignado, tipo, descripcion, 
                    dependencia_fk, fecha_inicio, fecha_fin, observacion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $arrData = array($this->id_usuario_creador, $this->id_usuario_asignado, $this->tipo, 
                            $this->descripcion, $this->dependencia_fk, $this->fecha_inicio, 
                            $this->fecha_fin, $this->observacion);
            
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
            $this->observacion = $observacion;
            $sql = "UPDATE tbl_tareas SET id_usuario_asignado = ?, tipo = ?, descripcion = ?, 
                    dependencia_fk = ?, estado = ?, fecha_inicio = ?, fecha_fin = ?, observacion = ? 
                    WHERE id_tarea = ?";
            $arrData = array($this->id_usuario_asignado, $this->tipo, $this->descripcion, 
                            $this->dependencia_fk, $this->estado, $this->fecha_inicio, 
                            $this->fecha_fin, $this->observacion, $this->id_tarea);
            
            return $this->update($sql, $arrData);
        }

        // Actualizar solo el estado de una tarea
        public function updateEstadoTarea(int $id_tarea, string $estado)
        {
            $this->id_tarea = $id_tarea;
            $this->estado = $estado;

            $sql = "UPDATE tbl_tareas SET estado = ? WHERE id_tarea = ?";
            $arrData = array($this->estado, $this->id_tarea);
            
            return $this->update($sql, $arrData);
        }

        // Actualizar solo la observación de una tarea
        public function updateObservacionTarea(int $id_tarea, string $observacion)
        {
            $this->id_tarea = $id_tarea;
            $this->observacion = $observacion;

            $sql = "UPDATE tbl_tareas SET observacion = ? WHERE id_tarea = ?";
            $arrData = array($this->observacion, $this->id_tarea);
            
            return $this->update($sql, $arrData);
        }

        // Eliminar una tarea
        public function deleteTarea(int $id_tarea)
        {
            $this->id_tarea = $id_tarea;
            $sql = "DELETE FROM tbl_tareas WHERE id_tarea = ?";
            $arrData = array($this->id_tarea);
            
            return $this->delete($sql, $arrData);
        }
    }
?>