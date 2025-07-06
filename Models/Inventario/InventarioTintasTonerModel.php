<?php
class TintasTonerModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_tintas_toner WHERE status=1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $sql = "INSERT INTO tbl_tintas_toner (item, disponibles, impresora, modelos_compatibles, fecha_ultima_actualizacion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['item'], $data['disponibles'], $data['impresora'], $data['modelos_compatibles'], $data['fecha_ultima_actualizacion']
        ]);
    }
    public function update($id, $data) {
        $sql = "UPDATE tbl_tintas_toner SET item=?, disponibles=?, impresora=?, modelos_compatibles=?, fecha_ultima_actualizacion=? WHERE id_tinta_toner=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['item'], $data['disponibles'], $data['impresora'], $data['modelos_compatibles'], $data['fecha_ultima_actualizacion'], $id
        ]);
    }
    public function delete($id) {
        $sql = "UPDATE tbl_tintas_toner SET status=0 WHERE id_tinta_toner=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_tintas_toner WHERE id_tinta_toner=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 