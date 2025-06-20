<?php
class PapeleriaModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_papeleria WHERE status=1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $sql = "INSERT INTO tbl_papeleria (item, disponibilidad) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['item'], $data['disponibilidad']
        ]);
    }
    public function update($id, $data) {
        $sql = "UPDATE tbl_papeleria SET item=?, disponibilidad=? WHERE id_papeleria=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['item'], $data['disponibilidad'], $id
        ]);
    }
    public function delete($id) {
        $sql = "UPDATE tbl_papeleria SET status=0 WHERE id_papeleria=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_papeleria WHERE id_papeleria=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 