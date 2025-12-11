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
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_prestamos'] . ')" title="Ver préstamo"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(' . $arrData[$i]['id_prestamos'] . ')" title="Editar préstamo"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_prestamos'] . ')" title="Eliminar préstamo"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                
                // Formatear fechas
                if(!empty($arrData[$i]['fecha_prestamo'])) {
                    $arrData[$i]['fecha_prestamo'] = date('d/m/Y', strtotime($arrData[$i]['fecha_prestamo']));
                }
                if(!empty($arrData[$i]['fecha_devolucion'])) {
                    $arrData[$i]['fecha_devolucion'] = date('d/m/Y', strtotime($arrData[$i]['fecha_devolucion']));
                }
            }
            
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
        if ($_POST) {
            if (empty($_POST['listFuncionario']) || empty($_POST['txtFechaPrestamo']) || 
                empty($_POST['listTipoEquipo']) || empty($_POST['listEquipo'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdPrestamo = intval($_POST['idPrestamo']);
                $intFuncionario = intval($_POST['listFuncionario']);
                $strFechaPrestamo = strClean($_POST['txtFechaPrestamo']);
                $strFechaDevolucion = strClean($_POST['txtFechaDevolucion']);
                $strTipoEquipo = strClean($_POST['listTipoEquipo']);
                $intEquipo = intval($_POST['listEquipo']);
                $strObservaciones = strClean($_POST['txtObservaciones']);

                // Obtener datos del funcionario
                $funcionario_data = $this->model->getFuncionarioById($intFuncionario);

                if(!$funcionario_data) {
                    $arrResponse = array("status" => false, "msg" => 'Funcionario no encontrado.');
                } else {
                    if($intIdPrestamo == 0) {
                        // Crear
                        if($_SESSION['permisosMod']['w']) {
                            $request_prestamo = $this->model->insertPrestamo(
                                $funcionario_data,
                                $strFechaPrestamo,
                                $strFechaDevolucion,
                                $strTipoEquipo,
                                $intEquipo,
                                $strObservaciones
                            );
                            $option = 1;
                        }
                    } else {
                        // Actualizar
                        if($_SESSION['permisosMod']['u']) {
                            $request_prestamo = $this->model->updatePrestamo(
                                $intIdPrestamo,
                                $funcionario_data,
                                $strFechaPrestamo,
                                $strFechaDevolucion,
                                $strTipoEquipo,
                                $intEquipo,
                                $strObservaciones
                            );
                            $option = 2;
                        }
                    }

                    if($request_prestamo > 0) {
                        if($option == 1) {
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        } else {
                            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        }
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdPrestamo = intval($_POST['idPrestamo']);
                $requestDelete = $this->model->deletePrestamo($intIdPrestamo);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el préstamo');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el préstamo.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getFuncionariosPlanta()
    {
        $arrData = $this->model->getFuncionariosPlanta();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getDependencias()
    {
        try {
            $arrData = $this->model->getDependencias();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(array('error' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // ==================== SALIDAS ====================
    public function getSalidas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectSalidas();
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewSalida(' . $arrData[$i]['id_salida'] . ')" title="Ver salida"><i class="far fa-eye"></i></button>';
                    $btnPDF = '<a class="btn btn-success btn-sm" href="' . base_url() . '/psi/generarPDFSalida/' . $arrData[$i]['id_salida'] . '" target="_blank" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditSalida(' . $arrData[$i]['id_salida'] . ')" title="Editar salida"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelSalida(' . $arrData[$i]['id_salida'] . ')" title="Eliminar salida"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPDF . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                
                if(!empty($arrData[$i]['fecha'])) {
                    $arrData[$i]['fecha'] = date('d/m/Y', strtotime($arrData[$i]['fecha']));
                }
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setSalida()
    {
        if ($_POST) {
            if (empty($_POST['txtFechaSalida']) || empty($_POST['listTipoEquipoSalida']) || 
                empty($_POST['equiposSeleccionados']) || empty($_POST['listDependenciaSalida'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strFecha = strClean($_POST['txtFechaSalida']);
                $strTipoEquipo = strClean($_POST['listTipoEquipoSalida']);
                $arrEquipos = json_decode($_POST['equiposSeleccionados'], true);
                $strDependencia = strClean($_POST['listDependenciaSalida']);
                $strObservaciones = strClean($_POST['txtObservacionesSalida']);

                if($_SESSION['permisosMod']['w']) {
                    $request_salida = $this->model->insertSalidaConEquipos(
                        $strFecha, $strDependencia, $strObservaciones, $arrEquipos, $strTipoEquipo
                    );
                    
                    if($request_salida > 0) {
                        $arrResponse = array('status' => true, 'msg' => 'Salida registrada correctamente con ' . count($arrEquipos) . ' equipos.');
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function generarPDFSalida($id_salida)
    {
        if($_SESSION['permisosMod']['r']) {
            $salida = $this->model->selectSalida($id_salida);
            if($salida) {
                require_once 'Libraries/pdf_salida.php';
                generarPDFSalida($salida);
            }
        }
        die();
    }

    // ==================== INGRESOS ====================
    public function getIngresos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectIngresos();
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewIngreso(' . $arrData[$i]['id_ingreso'] . ')" title="Ver ingreso"><i class="far fa-eye"></i></button>';
                    $btnPDF = '<a class="btn btn-success btn-sm" href="' . base_url() . '/psi/generarPDFIngreso/' . $arrData[$i]['id_ingreso'] . '" target="_blank" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditIngreso(' . $arrData[$i]['id_ingreso'] . ')" title="Editar ingreso"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelIngreso(' . $arrData[$i]['id_ingreso'] . ')" title="Eliminar ingreso"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnPDF . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                
                if(!empty($arrData[$i]['fecha'])) {
                    $arrData[$i]['fecha'] = date('d/m/Y', strtotime($arrData[$i]['fecha']));
                }
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setIngreso()
    {
        if ($_POST) {
            if (empty($_POST['txtFechaIngreso']) || empty($_POST['listTipoEquipoIngreso']) || 
                empty($_POST['equiposSeleccionados']) || empty($_POST['listDependenciaIngreso'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strFecha = strClean($_POST['txtFechaIngreso']);
                $strTipoEquipo = strClean($_POST['listTipoEquipoIngreso']);
                $arrEquipos = json_decode($_POST['equiposSeleccionados'], true);
                $strDependencia = strClean($_POST['listDependenciaIngreso']);
                $strObservaciones = strClean($_POST['txtObservacionesIngreso']);

                if($_SESSION['permisosMod']['w']) {
                    $ingresos_creados = [];
                    foreach($arrEquipos as $equipo_id) {
                        $request_ingreso = $this->model->insertIngresoFromInventario(
                            $strFecha, $strTipoEquipo, intval($equipo_id), $strDependencia, $strObservaciones
                        );
                        if($request_ingreso) {
                            $ingresos_creados[] = $request_ingreso;
                        }
                    }
                    
                    if(count($ingresos_creados) > 0) {
                        $arrResponse = array('status' => true, 'msg' => 'Ingresos registrados correctamente.', 'ingresos' => $ingresos_creados);
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function generarPDFIngreso($id_ingreso)
    {
        if($_SESSION['permisosMod']['r']) {
            $ingreso = $this->model->selectIngreso($id_ingreso);
            if($ingreso) {
                require_once 'Libraries/pdf_ingreso.php';
                generarPDFIngreso($ingreso);
            }
        }
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
