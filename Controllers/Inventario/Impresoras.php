<?php
require_once 'Models/Inventario/ImpresorasModel.php';
class Impresoras {
    private $model;
    public function __construct($db) {
        $this->model = new ImpresorasModel($db);
    }
    public function index() {
        $impresoras = $this->model->getAll();
        include 'Views/Inventario/impresoras.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
    // Métodos para editar, eliminar, etc.
} 