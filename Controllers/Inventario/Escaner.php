<?php
require_once 'Models/Inventario/EscanerModel.php';
class Escaner {
    private $model;
    public function __construct($db) {
        $this->model = new EscanerModel($db);
    }
    public function index() {
        $escaners = $this->model->getAll();
        include 'Views/Inventario/escaner.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 