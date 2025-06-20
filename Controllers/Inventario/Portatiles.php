<?php
require_once 'Models/Inventario/PortatilesModel.php';
class Portatiles {
    private $model;
    public function __construct($db) {
        $this->model = new PortatilesModel($db);
    }
    public function index() {
        $portatiles = $this->model->getAll();
        include 'Views/Inventario/portatiles.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 