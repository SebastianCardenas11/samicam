<?php
require_once 'Models/Inventario/TintasTonerModel.php';
class TintasToner {
    private $model;
    public function __construct($db) {
        $this->model = new TintasTonerModel($db);
    }
    public function index() {
        $tintas = $this->model->getAll();
        include 'Views/Inventario/tintas_toner.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 