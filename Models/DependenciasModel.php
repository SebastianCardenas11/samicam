<?php
class DependenciasModel extends Mysql
{
    private $intIdDependencia;
    private $strNombre;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertDependencia(string $nombre)
    {
        $this->strNombre = $nombre;
        $return = 0;
        $sql = "SELECT * FROM tbl_dependencia WHERE nombre = '{$this->strNombre}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_dependencia(nombre) VALUES(?)";
            $arrData = array($this->strNombre);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectDependencias()
    {
        $sql = "SELECT dependencia_pk, nombre FROM tbl_dependencia ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectDependencia(int $id)
    {
        $this->intIdDependencia = $id;
        $sql = "SELECT dependencia_pk, nombre FROM tbl_dependencia WHERE dependencia_pk = $this->intIdDependencia";
        $request = $this->select($sql);
        return $request;
    }

    public function updateDependencia(int $id, string $nombre)
    {
        $this->intIdDependencia = $id;
        $this->strNombre = $nombre;
        $sql = "SELECT * FROM tbl_dependencia WHERE nombre = '{$this->strNombre}' AND dependencia_pk != $this->intIdDependencia";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE tbl_dependencia SET nombre=? WHERE dependencia_pk = $this->intIdDependencia";
            $arrData = array($this->strNombre);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteDependencia(int $id)
    {
        $this->intIdDependencia = $id;
        $sql = "DELETE FROM tbl_dependencia WHERE dependencia_pk = $this->intIdDependencia";
        $request = $this->delete($sql);
        return $request;
    }
} 