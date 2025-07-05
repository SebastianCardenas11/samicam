<?php
class EscanerModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_escaner WHERE status=1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $sql = "INSERT INTO tbl_escaner (marca, modelo, serial, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['marca'], $data['modelo'], $data['serial'],
            $data['estado'], $data['disponibilidad'], $data['id_dependencia'],
            $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto']
        ]);
    }
    public function update($id, $data) {
        $sql = "UPDATE tbl_escaner SET marca=?, modelo=?, serial=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_escaner=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['marca'], $data['modelo'], $data['serial'],
            $data['estado'], $data['disponibilidad'], $data['id_dependencia'],
            $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto'], $id
        ]);
    }
    public function delete($id) {
        $sql = "UPDATE tbl_escaner SET status=0 WHERE id_escaner=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_escaner WHERE id_escaner=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 