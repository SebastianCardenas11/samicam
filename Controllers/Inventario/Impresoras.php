<?php
require_once 'Models/Inventario/ImpresorasModel.php';

class Impresoras extends Controllers {
    protected $model;
    public function __construct() {
        parent::__construct();
        $this->model = new ImpresorasModel();
    }
    public function index() {
        $impresoras = $this->model->getAll();
        $data['page_tag'] = "Impresoras";
        $data['page_title'] = "Inventario - Impresoras";
        $data['page_name'] = "impresoras";
        $data['impresoras'] = $impresoras;
        $this->views->getView($this, "impresoras", $data);
    }
    
       
    public function setImpresora() {
        // Log para debug
        file_put_contents('debug.log', "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
        file_put_contents('debug.log', "POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar campos obligatorios
            if (empty($_POST['numImpresora']) || empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['serial'])) {
                echo json_encode(['status' => false, 'msg' => 'Campos obligatorios vacíos']);
                exit;
            }
            
            $data = [
                'numImpresora' => $_POST['numImpresora'],
                'marca' => $_POST['marca'],
                'modelo' => $_POST['modelo'],
                'serial' => $_POST['serial'],
                'consumible' => $_POST['consumible'] ?? '',
                'estado' => $_POST['estado'] ?? '',
                'disponibilidad' => $_POST['disponibilidad'] ?? '',
                'id_dependencia' => !empty($_POST['id_dependencia']) ? $_POST['id_dependencia'] : null,
                'oficina' => $_POST['oficina'] ?? '',
                'id_funcionario' => !empty($_POST['id_funcionario']) ? $_POST['id_funcionario'] : null,
                'id_cargo' => $_POST['id_cargo'] ?? '',
                'id_contacto' => $_POST['id_contacto'] ?? ''
            ];
            
            file_put_contents('debug.log', "Data to insert: " . print_r($data, true) . "\n", FILE_APPEND);
            
            try {
                $resultado = $this->model->insertImpresora($data);
                file_put_contents('debug.log', "Insert result: " . $resultado . "\n", FILE_APPEND);
                
                if ($resultado > 0) {
                    echo json_encode(['status' => true, 'msg' => 'Impresora guardada correctamente.']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'No se pudo guardar la impresora.']);
                }
            } catch (Exception $e) {
                file_put_contents('debug.log', "Exception: " . $e->getMessage() . "\n", FILE_APPEND);
                echo json_encode(['status' => false, 'msg' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => false, 'msg' => 'Petición inválida.']);
        }
        exit;
    }

    public function getImpresora() {
        $arrData = $this->model->selectImpresoras();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Métodos para editar, eliminar, etc.
} 