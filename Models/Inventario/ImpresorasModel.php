<?php
class ImpresorasModel extends Mysql {
    public function __construct() {
        parent::__construct();
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_impresoras WHERE status=1";
        return $this->select_all($sql);
    }
    public function insertImpresora($data) {
        $sql = "INSERT INTO tbl_impresoras (numero_impresora, marca, modelo, serial, consumible, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            $data['numImpresora'], 
            $data['marca'], 
            $data['modelo'], 
            $data['serial'], 
            $data['consumible'],
            $data['estado'], 
            $data['disponibilidad'], 
            $data['id_dependencia'],
            $data['oficina'], 
            $data['id_funcionario'], 
            $data['id_cargo'], 
            $data['id_contacto']
        ];
        
        return $this->insert($sql, $arrData);
    }
    public function updateImpresora($id, $data) {
        $sql = "UPDATE tbl_impresoras SET numero_impresora=?, marca=?, modelo=?, serial=?, consumible=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_impresora=?";
        $arrData = [
            $data['numImpresora'], $data['marca'], $data['modelo'], $data['serial'], $data['consumible'],
            $data['estado'], $data['disponibilidad'], $data['id_dependencia'],
            $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto'], $id
        ];
        return $this->update($sql, $arrData);
    }
    public function deleteImpresora($id) {
        $sql = "UPDATE tbl_impresoras SET status=0 WHERE id_impresora=?";
        $arrData = [$id];
        return $this->update($sql, $arrData);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_impresoras WHERE id_impresora=?";
        $arrData = [$id];
        return $this->select($sql, $arrData);
    }
    public function selectImpresoras() {
        $sql = "SELECT * FROM tbl_impresoras WHERE status=1";
        return $this->select_all($sql);
    }
} 