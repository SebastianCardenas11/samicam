<?php
class ImpresorasModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_impresoras WHERE status=1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $sql = "INSERT INTO tbl_impresoras (marca, modelo, serial, consumible, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['marca'], $data['modelo'], $data['serial'], $data['consumible'],
            $data['estado'], $data['disponibilidad'], $data['id_dependencia'],
            $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto']
        ]);
    }
    public function update($id, $data) {
        $sql = "UPDATE tbl_impresoras SET marca=?, modelo=?, serial=?, consumible=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_impresora=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['marca'], $data['modelo'], $data['serial'], $data['consumible'],
            $data['estado'], $data['disponibilidad'], $data['id_dependencia'],
            $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto'], $id
        ]);
    }
    public function delete($id) {
        $sql = "UPDATE tbl_impresoras SET status=0 WHERE id_impresora=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_impresoras WHERE id_impresora=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 