<?php
require_once 'Models/Inventario/PcTorreModel.php';
class PcTorre {
    private $model;
    public function __construct($db) {
        $this->model = new PcTorreModel($db);
    }
    public function index() {
        $pcs = $this->model->getAll();
        include 'Views/Inventario/pc_torre.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 