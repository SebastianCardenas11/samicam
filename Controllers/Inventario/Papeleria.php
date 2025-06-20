<?php
require_once 'Models/Inventario/PapeleriaModel.php';
class Papeleria {
    private $model;
    public function __construct($db) {
        $this->model = new PapeleriaModel($db);
    }
    public function index() {
        $papeleria = $this->model->getAll();
        include 'Views/Inventario/papeleria.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 