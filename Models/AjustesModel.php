<?php
class AjustesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actualizarNombre($idUser, $nombre)
    {
        $sql = "UPDATE tbl_usuarios SET nombres = ? WHERE ideusuario = ?";
        $arrData = array($nombre, $idUser);
        return $this->update($sql, $arrData);
    }

    public function actualizarFoto($idUser, $nombreArchivo)
    {
        $sql = "UPDATE tbl_usuarios SET foto = ? WHERE ideusuario = ?";
        $arrData = array($nombreArchivo, $idUser);
        return $this->update($sql, $arrData);
    }
} 