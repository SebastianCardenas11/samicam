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
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las publicaciones
    public function selectPublicaciones()
    {
        $sql = "SELECT * FROM publicaciones WHERE status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener una publicación específica
    public function selectPublicacion(int $idpublicacion)
    {
        $this->intIdPublicacion = $idpublicacion;
        $sql = "SELECT * FROM publicaciones WHERE id_publicacion = $this->intIdPublicacion";
        $request = $this->select($sql);
        return $request;
    }

    // Insertar nueva publicación
    public function insertPublicacion(string $fechaRecibido, string $correoRecibido, string $asunto, string $fechaPublicacion, string $respuestaEnvio, string $enlacePublicacion, int $status)
    {
        $return = 0;
        $this->strFechaRecibido = $fechaRecibido;
        $this->strCorreoRecibido = $correoRecibido;
        $this->strAsunto = $asunto;
        $this->strFechaPublicacion = $fechaPublicacion;
        $this->strRespuestaEnvio = $respuestaEnvio;
        $this->strEnlacePublicacion = $enlacePublicacion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM publicaciones WHERE asunto = '{$this->strAsunto}' AND correo_recibido = '{$this->strCorreoRecibido}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO publicaciones(nombre_publicacion, fecha_recibido, correo_recibido, asunto, fecha_publicacion, respuesta_envio, enlace_publicacion, status) VALUES(?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->strAsunto, // Usando el asunto como nombre de publicación por defecto
                $this->strFechaRecibido,
                $this->strCorreoRecibido,
                $this->strAsunto,
                $this->strFechaPublicacion,
                $this->strRespuestaEnvio,
                $this->strEnlacePublicacion,
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
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
}
?>