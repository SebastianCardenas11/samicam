<?php
require_once 'Models/Inventario/TodoEnUnoModel.php';
class TodoEnUno {
    private $model;
    public function __construct($db) {
        $this->model = new TodoEnUnoModel($db);
    }
    public function index() {
        $equipos = $this->model->getAll();
        include 'Views/Inventario/todo_en_uno.php';
    }
    public function guardar() {
        $data = $_POST;
        $this->model->insert($data);
        header('Location: /inventario');
    }
} 