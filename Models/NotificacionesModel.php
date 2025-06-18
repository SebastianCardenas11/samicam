<?php
class NotificacionesModel extends Mysql
{
    private $id_notificacion;
    private $id_funcionario;
    private $tipo;
    private $mensaje;
    private $fecha_creacion;
    private $leido;
    private $tipo_funcionario;

    public function __construct()
    {
        parent::__construct();
    }

    // Insertar una nueva notificación
    public function insertNotificacion(int $id_funcionario, string $tipo, string $mensaje, string $tipo_funcionario = 'planta')
    {
        $this->id_funcionario = $id_funcionario;
        $this->tipo = $tipo;
        $this->mensaje = $mensaje;
        $this->tipo_funcionario = $tipo_funcionario;

        $sql = "INSERT INTO tbl_notificaciones (id_funcionario, tipo, mensaje, tipo_funcionario) 
                VALUES (?, ?, ?, ?)";
        $arrData = array($this->id_funcionario, $this->tipo, $this->mensaje, $this->tipo_funcionario);
        return $this->insert($sql, $arrData);
    }

    // Obtener notificaciones de un funcionario
    public function getNotificacionesFuncionario(int $id_funcionario, string $tipo_funcionario = 'planta')
    {
        $sql = "SELECT * FROM tbl_notificaciones 
                WHERE id_funcionario = ? AND tipo_funcionario = ? 
                ORDER BY fecha_creacion DESC";
        $arrData = array($id_funcionario, $tipo_funcionario);
        return $this->select_all($sql, $arrData);
    }

    // Obtener notificaciones no leídas de un funcionario
    public function getNotificacionesNoLeidas(int $id_funcionario, string $tipo_funcionario = 'planta')
    {
        $sql = "SELECT * FROM tbl_notificaciones 
                WHERE id_funcionario = ? AND tipo_funcionario = ? AND leido = 0 
                ORDER BY fecha_creacion DESC";
        $arrData = array($id_funcionario, $tipo_funcionario);
        return $this->select_all($sql, $arrData);
    }

    // Marcar una notificación como leída
    public function marcarComoLeida(int $id_notificacion)
    {
        $sql = "UPDATE tbl_notificaciones SET leido = 1 WHERE id_notificacion = ?";
        $arrData = array($id_notificacion);
        return $this->update($sql, $arrData);
    }

    // Marcar todas las notificaciones de un funcionario como leídas
    public function marcarTodasComoLeidas(int $id_funcionario, string $tipo_funcionario = 'planta')
    {
        $sql = "UPDATE tbl_notificaciones 
                SET leido = 1 
                WHERE id_funcionario = ? AND tipo_funcionario = ? AND leido = 0";
        $arrData = array($id_funcionario, $tipo_funcionario);
        return $this->update($sql, $arrData);
    }

    // Eliminar una notificación
    public function deleteNotificacion(int $id_notificacion)
    {
        $sql = "DELETE FROM tbl_notificaciones WHERE id_notificacion = ?";
        $arrData = array($id_notificacion);
        return $this->delete($sql, $arrData);
    }

    // Eliminar todas las notificaciones de un funcionario
    public function deleteNotificacionesFuncionario(int $id_funcionario, string $tipo_funcionario = 'planta')
    {
        $sql = "DELETE FROM tbl_notificaciones 
                WHERE id_funcionario = ? AND tipo_funcionario = ?";
        $arrData = array($id_funcionario, $tipo_funcionario);
        return $this->delete($sql, $arrData);
    }
}
?> 