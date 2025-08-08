<?php
class psi extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MPSI);
    }

    public function psi()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 99;
        $data['page_tag'] = "PSI";
        $data['page_title'] = "Módulo PSI";
        $data['page_name'] = "PSI";
        $data['page_functions_js'] = "functions_psi.js";
        $this->views->getView($this, "psi", $data);
    }

    // ==================== PRÉSTAMOS ====================
    public function getPrestamos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPrestamos();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getPrestamo($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPrestamo($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setPrestamo()
    {
        if ($_SESSION['permisosMod']['w']) {
            $data = $_POST;
            $id = isset($data['id_prestamos']) ? intval($data['id_prestamos']) : 0;
            
            // Verificar si es un préstamo con múltiples items
            $cantidadItems = isset($data['cantidad_items']) ? intval($data['cantidad_items']) : 1;
            
            if ($id > 0) {
                // Actualización de préstamo existente
                $result = $this->model->updatePrestamo($id, $data);
            } else {
                // Nuevo préstamo
                if ($cantidadItems > 1) {
                    // Procesar múltiples items
                    $result = $this->procesarPrestamoMultiple($data);
                } else {
                    // Préstamo simple
                    $result = $this->model->insertPrestamo($data);
                }
            }
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    // Método para procesar préstamos con múltiples items
    private function procesarPrestamoMultiple($data)
    {
        try {
            $cantidadItems = intval($data['cantidad_items']);
            $prestamosCreados = [];
            
            for ($i = 0; $i < $cantidadItems; $i++) {
                // Crear datos para cada item
                $itemData = [
                    'funcionario_responsable' => $data['funcionario_responsable'],
                    'dependencia' => $data['dependencia'],
                    'cargo_funcionario' => $data['cargo_funcionario'],
                    'fecha_prestamo' => $data['fecha_prestamo'],
                    'fecha_devolucion' => $data['fecha_devolucion'],
                    'observaciones' => $data['observaciones'],
                    'item' => $data["item_$i"] ?? '',
                    'dispositivo' => $data["dispositivo_$i"] ?? '',
                    'marca_modelo' => $data["marca_modelo_$i"] ?? '',
                    'activo' => $data["activo_$i"] ?? '',
                    'serial' => $data["serial_$i"] ?? '',
                    'estado' => $data["estado_$i"] ?? '',
                    'mac' => $data["mac_$i"] ?? '',
                    'equipo_id' => $data["equipo_id_$i"] ?? '',
                    'equipo_tipo' => $data["equipo_tipo_$i"] ?? ''
                ];
                
                // Insertar el préstamo
                $result = $this->model->insertPrestamo($itemData);
                if ($result) {
                    $prestamosCreados[] = $result;
                }
            }
            
            return count($prestamosCreados) === $cantidadItems;
            
        } catch (Exception $e) {
            error_log('Error en procesarPrestamoMultiple: ' . $e->getMessage());
            return false;
        }
    }
    public function delPrestamo()
    {
        if ($_SESSION['permisosMod']['d']) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $result = $this->model->deletePrestamo($id);
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // ==================== SALIDAS ====================
    public function getSalidas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectSalidas();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getSalida($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectSalida($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setSalida()
    {
        if ($_SESSION['permisosMod']['w']) {
            $data = $_POST;
            $id = isset($data['id_salida']) ? intval($data['id_salida']) : 0;
            if ($id > 0) {
                $result = $this->model->updateSalida($id, $data);
            } else {
                $result = $this->model->insertSalida($data);
            }
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function delSalida()
    {
        if ($_SESSION['permisosMod']['d']) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $result = $this->model->deleteSalida($id);
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // ==================== INGRESOS ====================
    public function getIngresos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectIngresos();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getIngreso($id)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectIngreso($id);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setIngreso()
    {
        if ($_SESSION['permisosMod']['w']) {
            $data = $_POST;
            $id = isset($data['id_ingreso']) ? intval($data['id_ingreso']) : 0;
            if ($id > 0) {
                $result = $this->model->updateIngreso($id, $data);
            } else {
                $result = $this->model->insertIngreso($data);
            }
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function delIngreso()
    {
        if ($_SESSION['permisosMod']['d']) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $result = $this->model->deleteIngreso($id);
            echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFuncionariosPlanta()
    {
        $arrData = $this->model->getFuncionariosPlanta();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getFuncionariosOps()
    {
        $arrData = $this->model->getFuncionariosOps();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // ==================== MÉTODOS PARA ACCEDER AL INVENTARIO ====================
    
    public function getPcTorre()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectPcTorre();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPcTorreById($idPcTorre)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdPcTorre = intval(strClean($idPcTorre));
            if ($intIdPcTorre > 0) {
                $arrData = $inventarioModel->selectPcTorreById($intIdPcTorre);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getTodoEnUno()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectTodoEnUno();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getTodoEnUnoById($idTodoEnUno)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdTodoEnUno = intval(strClean($idTodoEnUno));
            if ($intIdTodoEnUno > 0) {
                $arrData = $inventarioModel->selectTodoEnUnoById($intIdTodoEnUno);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getPortatiles()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectPortatiles();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPortatilById($idPortatil)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdPortatil = intval(strClean($idPortatil));
            if ($intIdPortatil > 0) {
                $arrData = $inventarioModel->selectPortatilById($intIdPortatil);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getImpresoras()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectImpresoras();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getImpresoraById($idImpresora)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdImpresora = intval(strClean($idImpresora));
            if ($intIdImpresora > 0) {
                $arrData = $inventarioModel->selectImpresora($intIdImpresora);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getEscaneres()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectEscaneres();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getEscanerById($idEscaner)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdEscaner = intval(strClean($idEscaner));
            if ($intIdEscaner > 0) {
                $arrData = $inventarioModel->selectEscaner($intIdEscaner);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getHerramientas()
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $arrData = $inventarioModel->selectHerramientas();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getHerramientaById($idHerramienta)
    {
        if ($_SESSION['permisosMod']['r']) {
            require_once "Models/InventarioModel.php";
            $inventarioModel = new InventarioModel();
            $intIdHerramienta = intval(strClean($idHerramienta));
            if ($intIdHerramienta > 0) {
                $arrData = $inventarioModel->selectHerramientaById($intIdHerramienta);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
