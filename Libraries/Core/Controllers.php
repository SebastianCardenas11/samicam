<?php

require_once 'Views.php';

class Controllers
{
    public $model;
    protected $view; // Agregamos la propiedad para la vista

    public function __construct()
    {
        $this->loadModel();
        $this->view = new Views(VIEWS); // Instanciamos la clase View
    }

    public function loadModel()
    {
        $modelName = get_class($this) . "Model";
        $modelPath = "Models/" . $modelName . ".php";

        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        }
    }
}
?>

