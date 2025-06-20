<?php
class PcTorreModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM tbl_pc_torre WHERE status=1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $sql = "INSERT INTO tbl_pc_torre (numero_pc, marca, serial, modelo, ram, velocidad_ram, procesador, velocidad_procesador, disco_duro, capacidad, sistema_operativo, numero_activo, monitor, numero_activo_monitor, serial_monitor, estado, disponibilidad, id_dependencia, oficina, id_funcionario, id_cargo, id_contacto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['numero_pc'], $data['marca'], $data['serial'], $data['modelo'], $data['ram'], $data['velocidad_ram'], $data['procesador'], $data['velocidad_procesador'], $data['disco_duro'], $data['capacidad'], $data['sistema_operativo'], $data['numero_activo'], $data['monitor'], $data['numero_activo_monitor'], $data['serial_monitor'], $data['estado'], $data['disponibilidad'], $data['id_dependencia'], $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto']
        ]);
    }
    public function update($id, $data) {
        $sql = "UPDATE tbl_pc_torre SET numero_pc=?, marca=?, serial=?, modelo=?, ram=?, velocidad_ram=?, procesador=?, velocidad_procesador=?, disco_duro=?, capacidad=?, sistema_operativo=?, numero_activo=?, monitor=?, numero_activo_monitor=?, serial_monitor=?, estado=?, disponibilidad=?, id_dependencia=?, oficina=?, id_funcionario=?, id_cargo=?, id_contacto=? WHERE id_pc_torre=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['numero_pc'], $data['marca'], $data['serial'], $data['modelo'], $data['ram'], $data['velocidad_ram'], $data['procesador'], $data['velocidad_procesador'], $data['disco_duro'], $data['capacidad'], $data['sistema_operativo'], $data['numero_activo'], $data['monitor'], $data['numero_activo_monitor'], $data['serial_monitor'], $data['estado'], $data['disponibilidad'], $data['id_dependencia'], $data['oficina'], $data['id_funcionario'], $data['id_cargo'], $data['id_contacto'], $id
        ]);
    }
    public function delete($id) {
        $sql = "UPDATE tbl_pc_torre SET status=0 WHERE id_pc_torre=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM tbl_pc_torre WHERE id_pc_torre=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 