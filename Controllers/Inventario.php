<?php

class Inventario extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MINVENTARIO);
    }

    public function inventario()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 15;
        $data['page_tag'] = "Inventario";
        $data['page_title'] = "Gestión de Inventario";
        $data['page_name'] = "Inventario";
        $data['page_functions_js'] = "functions_inventario.js";
        $this->registrarAccesoModulo("Inventario");
        $this->views->getView($this, "inventario", $data);
    }

    // ==================== IMPRESORAS ====================
    public function getImpresoras()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectImpresoras();
                // Agregar el último movimiento a cada impresora
                foreach ($arrData as &$impresora) {
                    $ultimo = $this->model->getUltimoMovimientoEquipo($impresora['id_impresora'], 'impresora');
                    $impresora['ultimo_movimiento'] = $ultimo ? $ultimo['tipo_movimiento'] : null;
                }
                unset($impresora);
                error_log('Datos obtenidos: ' . print_r($arrData, true));
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                error_log('Error en getImpresoras: ' . $e->getMessage());
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } else {
            error_log('Sin permisos de lectura');
        }
        die();
    }

    public function getImpresora($idImpresora)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdImpresora = intval(strClean($idImpresora));
            if ($intIdImpresora > 0) {
                $arrData = $this->model->selectImpresora($intIdImpresora);
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

    public function setImpresora()
    {
        try {
            error_log('=== INICIO setImpresora ===');
            error_log('POST data: ' . print_r($_POST, true));
            
            if ($_POST) {
                if (
                    empty($_POST['txtNumeroImpresora']) ||
                    empty($_POST['txtMarca']) ||
                    empty($_POST['txtModelo']) ||
                    empty($_POST['txtEstado']) ||
                    empty($_POST['txtDisponibilidad'])
                ) {
                    error_log('Datos obligatorios incompletos');
                    $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
                } else {
                    $intIdImpresora = intval($_POST['idImpresora']);
                    $strNumeroImpresora = strClean($_POST['txtNumeroImpresora']);
                    $strMarca = strClean($_POST['txtMarca']);
                    $strModelo = strClean($_POST['txtModelo']);
                    $strSerial = strClean($_POST['txtSerial']);
                    $strConsumible = strClean($_POST['txtConsumible']);
                    $strEstado = strClean($_POST['txtEstado']);
                    $strDisponibilidad = strClean($_POST['txtDisponibilidad']);

                    error_log('Datos procesados - ID: ' . $intIdImpresora . ', Numero: ' . $strNumeroImpresora);

                    $request = "";
                    if ($intIdImpresora == 0) {
                        if ($_SESSION['permisosMod']['w']) {
                            error_log('Insertando nueva impresora...');
                            $request = $this->model->insertImpresora($strNumeroImpresora, $strMarca, $strModelo, $strSerial, $strConsumible, $strEstado, $strDisponibilidad);
                            $option = 1;
                            error_log('Resultado insert: ' . $request);
                        } else {
                            error_log('Sin permisos de escritura');
                        }
                    } else {
                        if ($_SESSION['permisosMod']['u']) {
                            error_log('Actualizando impresora ID: ' . $intIdImpresora);
                            $request = $this->model->updateImpresora($intIdImpresora, $strNumeroImpresora, $strMarca, $strModelo, $strSerial, $strConsumible, $strEstado, $strDisponibilidad);
                            $option = 2;
                            error_log('Resultado update: ' . $request);
                        } else {
                            error_log('Sin permisos de actualización');
                        }
                    }
                    
                    if ($request > 0) {
                        $msg = $option == 1 ? "Impresora guardada correctamente." : "Impresora actualizada correctamente.";
                        $arrResponse = array("status" => true, "msg" => $msg);
                        error_log('Guardado exitoso: ' . $msg);
                    } else if ($request == 'exist') {
                        $arrResponse = array("status" => false, "msg" => '¡Atención! La impresora ya existe.');
                        error_log('Impresora ya existe');
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        error_log('Error al almacenar - Request result: ' . $request);
                    }
                }
                error_log('Respuesta final: ' . json_encode($arrResponse));
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                error_log('No hay datos POST');
                echo json_encode(array("status" => false, "msg" => 'No se recibieron datos'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log('EXCEPCIÓN en setImpresora: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            echo json_encode(array("status" => false, "msg" => 'Error interno: ' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delImpresora()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdImpresora = intval($_POST['idImpresora']);
                $requestDelete = $this->model->deleteImpresora($intIdImpresora);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la impresora correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== IMPRESORAS ACTIVAS PARA SELECT EN TINTAS Y TONER ====================
    public function getImpresorasActivas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->getImpresorasActivas();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // ==================== ESCÁNERES ====================
    public function getEscaneres()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectEscaneres();
                // Agregar el último movimiento a cada escáner
                foreach ($arrData as &$escaner) {
                    $ultimo = $this->model->getUltimoMovimientoEquipo($escaner['id_escaner'], 'escaner');
                    $escaner['ultimo_movimiento'] = $ultimo ? $ultimo['tipo_movimiento'] : null;
                }
                unset($escaner);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getEscaner($idEscaner)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdEscaner = intval(strClean($idEscaner));
            if ($intIdEscaner > 0) {
                $arrData = $this->model->selectEscaner($intIdEscaner);
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

    public function setEscaner()
    {
        if ($_POST) {
            if (
                empty($_POST['txtNumeroEscaner']) ||
                empty($_POST['txtMarca']) ||
                empty($_POST['txtModelo']) ||
                empty($_POST['txtEstado']) ||
                empty($_POST['txtDisponibilidad'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
            } else {
                $intIdEscaner = intval($_POST['idEscaner']);
                $strNumeroEscaner = strClean($_POST['txtNumeroEscaner']);
                $strMarca = strClean($_POST['txtMarca']);
                $strModelo = strClean($_POST['txtModelo']);
                $strSerial = strClean($_POST['txtSerial']);
                $strEstado = strClean($_POST['txtEstado']);
                $strDisponibilidad = strClean($_POST['txtDisponibilidad']);

                $request = "";
                if ($intIdEscaner == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertEscaner($strNumeroEscaner, $strMarca, $strModelo, $strSerial, $strEstado, $strDisponibilidad);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateEscaner($intIdEscaner, $strNumeroEscaner, $strMarca, $strModelo, $strSerial, $strEstado, $strDisponibilidad);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Escáner guardado correctamente." : "Escáner actualizado correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else if ($request == 'exist') {
                    $arrResponse = array("status" => false, "msg" => '¡Atención! El escáner ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delEscaner()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdEscaner = intval($_POST['idEscaner']);
                $requestDelete = $this->model->deleteEscaner($intIdEscaner);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el escáner correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== PAPELERÍA ====================
    public function getPapeleria()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectPapeleria();
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getArticuloPapeleria($idPapeleria)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdPapeleria = intval(strClean($idPapeleria));
            if ($intIdPapeleria > 0) {
                $arrData = $this->model->selectArticuloPapeleria($intIdPapeleria);
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

    public function setArticuloPapeleria()
    {
        if ($_POST) {
            if (
                empty($_POST['txtItem']) ||
                empty($_POST['txtDisponibilidad'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
            } else {
                $intIdPapeleria = intval($_POST['idPapeleria']);
                $strItem = strClean($_POST['txtItem']);
                $strDisponibilidad = strClean($_POST['txtDisponibilidad']);

                $request = "";
                if ($intIdPapeleria == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertArticuloPapeleria($strItem, $strDisponibilidad);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateArticuloPapeleria($intIdPapeleria, $strItem, $strDisponibilidad);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Artículo guardado correctamente." : "Artículo actualizado correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delArticuloPapeleria()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdPapeleria = intval($_POST['idPapeleria']);
                $requestDelete = $this->model->deleteArticuloPapeleria($intIdPapeleria);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el artículo correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== TINTAS Y TÓNER ====================
    public function getTintasToner()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectTintasToner();
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getTintaToner($idTintaToner)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdTintaToner = intval(strClean($idTintaToner));
            if ($intIdTintaToner > 0) {
                $arrData = $this->model->selectTintaToner($intIdTintaToner);
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

    public function setTintaToner()
    {
        if ($_POST) {
            if (
                empty($_POST['txtItem']) ||
                !isset($_POST['txtDisponibles'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
            } else {
                $intIdTintaToner = intval($_POST['idTintaToner']);
                $strItem = strClean($_POST['txtItem']);
                $intDisponibles = intval($_POST['txtDisponibles']);
                $strImpresora = strClean($_POST['txtImpresora']);
                $strModelosCompatibles = strClean($_POST['txtModelosCompatibles']);

                $request = "";
                if ($intIdTintaToner == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertTintaToner($strItem, $intDisponibles, $strImpresora, $strModelosCompatibles);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateTintaToner($intIdTintaToner, $strItem, $intDisponibles, $strImpresora, $strModelosCompatibles);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Tinta/Tóner guardado correctamente." : "Tinta/Tóner actualizado correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delTintaToner()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdTintaToner = intval($_POST['idTintaToner']);
                $requestDelete = $this->model->deleteTintaToner($intIdTintaToner);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el tinta/tóner correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== DEPENDENCIAS ====================
    public function getDependencias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectDependencias();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // ==================== PC TORRE ====================
    public function getPcTorre()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectPcTorre();
                // Agregar el último movimiento a cada PC Torre
                foreach ($arrData as &$pc) {
                    $ultimo = $this->model->getUltimoMovimientoEquipo($pc['id_pc_torre'], 'pc_torre');
                    $pc['ultimo_movimiento'] = $ultimo ? $ultimo['tipo_movimiento'] : null;
                }
                unset($pc);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getPcTorreById($idPcTorre)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdPcTorre = intval(strClean($idPcTorre));
            if ($intIdPcTorre > 0) {
                $arrData = $this->model->selectPcTorreById($intIdPcTorre);
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

    public function setPcTorre()
    {
        try {
            if ($_POST) {
                error_log('POST PC TORRE: ' . print_r($_POST, true));
                // Validación básica de campos obligatorios
                if (
                    empty($_POST['txtNumeroPcTorre']) ||
                    empty($_POST['txtMarcaPcTorre']) ||
                    empty($_POST['txtModeloPcTorre']) ||
                    empty($_POST['txtEstadoPcTorre']) ||
                    empty($_POST['txtDisponibilidadPcTorre'])
                ) {
                    $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
                } else {
                    $intIdPcTorre = intval($_POST['idPcTorre']);
                    $numero_pc = strClean($_POST['txtNumeroPcTorre']);
                    $marca = strClean($_POST['txtMarcaPcTorre']);
                    $serial = strClean($_POST['txtSerialPcTorre']);
                    $modelo = strClean($_POST['txtModeloPcTorre']);
                    $ram = strClean($_POST['txtRamPcTorre']);
                    $velocidad_ram = strClean($_POST['txtVelocidadRamPcTorre']);
                    $procesador = strClean($_POST['txtProcesadorPcTorre']);
                    $velocidad_procesador = strClean($_POST['txtVelocidadProcesadorPcTorre']);
                    $disco_duro = strClean($_POST['txtDiscoDuroPcTorre']);
                    $capacidad = strClean($_POST['txtCapacidadPcTorre']);
                    $sistema_operativo = strClean($_POST['txtSistemaOperativoPcTorre']);
                    $numero_activo = strClean($_POST['txtNumeroActivoPcTorre']);
                    $monitor = strClean($_POST['txtMonitorPcTorre']);
                    $numero_activo_monitor = strClean($_POST['txtNumeroActivoMonitorPcTorre']);
                    $serial_monitor = strClean($_POST['txtSerialMonitorPcTorre']);
                    $estado = strClean($_POST['txtEstadoPcTorre']);
                    $disponibilidad = strClean($_POST['txtDisponibilidadPcTorre']);

                    $request = "";
                    if ($intIdPcTorre == 0) {
                        if ($_SESSION['permisosMod']['w']) {
                            error_log('Insertando nueva PC Torre...');
                            $request = $this->model->insertPcTorre($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad);
                            $option = 1;
                            error_log('Resultado insert: ' . print_r($request, true));
                        } else {
                            error_log('Sin permisos de escritura');
                        }
                    } else {
                        if ($_SESSION['permisosMod']['u']) {
                            error_log('Actualizando PC Torre ID: ' . $intIdPcTorre);
                            $request = $this->model->updatePcTorre($intIdPcTorre, $numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad);
                            $option = 2;
                            error_log('Resultado update: ' . $request);
                        } else {
                            error_log('Sin permisos de actualización');
                        }
                    }
                    
                    if (is_array($request) && isset($request['error'])) {
                        error_log('Error SQL: ' . $request['error']);
                        $arrResponse = array("status" => false, "msg" => 'Error SQL: ' . $request['error'], "debug" => $request);
                    } else if ($request > 0) {
                        $msg = $option == 1 ? "PC Torre guardada correctamente." : "PC Torre actualizada correctamente.";
                        $arrResponse = array("status" => true, "msg" => $msg);
                        error_log('Guardado exitoso: ' . $msg);
                    } else {
                        error_log('Error al almacenar - Request result: ' . print_r($request, true));
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                error_log('No hay datos POST');
                echo json_encode(array("status" => false, "msg" => 'No se recibieron datos'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log('EXCEPCIÓN en setPcTorre: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            echo json_encode(array("status" => false, "msg" => 'Error interno: ' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPcTorre()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdPcTorre = intval($_POST['idPcTorre']);
                $requestDelete = $this->model->deletePcTorre($intIdPcTorre);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el PC Torre correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== PC TODO EN UNO ====================
    public function getTodoEnUno()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectTodoEnUno();
                // Agregar el último movimiento a cada equipo Todo en Uno
                foreach ($arrData as &$pc) {
                    $ultimo = $this->model->getUltimoMovimientoEquipo($pc['id_todo_en_uno'], 'todo_en_uno');
                    $pc['ultimo_movimiento'] = $ultimo ? $ultimo['tipo_movimiento'] : null;
                }
                unset($pc);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getTodoEnUnoById($idTodoEnUno)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdTodoEnUno = intval(strClean($idTodoEnUno));
            if ($intIdTodoEnUno > 0) {
                $arrData = $this->model->selectTodoEnUnoById($intIdTodoEnUno);
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

    public function setTodoEnUno()
    {
        try {
            if ($_POST) {
                error_log('POST TODO EN UNO: ' . print_r($_POST, true));
                if (
                    empty($_POST['txtNumeroTodoEnUno']) ||
                    empty($_POST['txtMarcaTodoEnUno']) ||
                    empty($_POST['txtModeloTodoEnUno']) ||
                    empty($_POST['txtEstadoTodoEnUno']) ||
                    empty($_POST['txtDisponibilidadTodoEnUno'])
                ) {
                    $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
                } else {
                    $intIdTodoEnUno = intval($_POST['idTodoEnUno']);
                    $numero_pc = strClean($_POST['txtNumeroTodoEnUno']);
                    $marca = strClean($_POST['txtMarcaTodoEnUno']);
                    $modelo = strClean($_POST['txtModeloTodoEnUno']);
                    $ram = strClean($_POST['txtRamTodoEnUno']);
                    $velocidad_ram = strClean($_POST['txtVelocidadRamTodoEnUno']);
                    $procesador = strClean($_POST['txtProcesadorTodoEnUno']);
                    $velocidad_procesador = strClean($_POST['txtVelocidadProcesadorTodoEnUno']);
                    $disco_duro = strClean($_POST['txtDiscoDuroTodoEnUno']);
                    $capacidad = strClean($_POST['txtCapacidadTodoEnUno']);
                    $serial = strClean($_POST['txtSerialTodoEnUno']);
                    $sistema_operativo = strClean($_POST['txtSistemaOperativoTodoEnUno']);
                    $numero_activo = strClean($_POST['txtNumeroActivoTodoEnUno']);
                    $estado = strClean($_POST['txtEstadoTodoEnUno']);
                    $disponibilidad = strClean($_POST['txtDisponibilidadTodoEnUno']);

                    $request = "";
                    if ($intIdTodoEnUno == 0) {
                        if ($_SESSION['permisosMod']['w']) {
                            error_log('Insertando nuevo PC Todo en Uno...');
                            $request = $this->model->insertTodoEnUno($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
                            $option = 1;
                            error_log('Resultado insert: ' . print_r($request, true));
                        } else {
                            error_log('Sin permisos de escritura');
                        }
                    } else {
                        if ($_SESSION['permisosMod']['u']) {
                            error_log('Actualizando PC Todo en Uno ID: ' . $intIdTodoEnUno);
                            $request = $this->model->updateTodoEnUno($intIdTodoEnUno, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
                            $option = 2;
                            error_log('Resultado update: ' . $request);
                        } else {
                            error_log('Sin permisos de actualización');
                        }
                    }
                    
                    if (is_array($request) && isset($request['error'])) {
                        error_log('Error SQL: ' . $request['error']);
                        $arrResponse = array("status" => false, "msg" => 'Error SQL: ' . $request['error'], "debug" => $request);
                    } else if ($request > 0) {
                        $msg = $option == 1 ? "PC Todo en Uno guardado correctamente." : "PC Todo en Uno actualizado correctamente.";
                        $arrResponse = array("status" => true, "msg" => $msg);
                        error_log('Guardado exitoso: ' . $msg);
                    } else {
                        error_log('Error al almacenar - Request result: ' . print_r($request, true));
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                error_log('No hay datos POST');
                echo json_encode(array("status" => false, "msg" => 'No se recibieron datos'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log('EXCEPCIÓN en setTodoEnUno: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            echo json_encode(array("status" => false, "msg" => 'Error interno: ' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delTodoEnUno()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdTodoEnUno = intval($_POST['idTodoEnUno']);
                $requestDelete = $this->model->deleteTodoEnUno($intIdTodoEnUno);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el PC Todo en Uno correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== PORTÁTILES ====================
    public function getPortatiles()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectPortatiles();
                // Agregar el último movimiento a cada portátil
                foreach ($arrData as &$portatil) {
                    $ultimo = $this->model->getUltimoMovimientoEquipo($portatil['id_portatil'], 'portatil');
                    $portatil['ultimo_movimiento'] = $ultimo ? $ultimo['tipo_movimiento'] : null;
                }
                unset($portatil);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getPortatilById($idPortatil)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdPortatil = intval(strClean($idPortatil));
            if ($intIdPortatil > 0) {
                $arrData = $this->model->selectPortatilById($intIdPortatil);
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

    public function setPortatil()
    {
        try {
            if ($_POST) {
                error_log('POST PORTATIL: ' . print_r($_POST, true));
                if (
                    empty($_POST['txtNumeroPortatil']) ||
                    empty($_POST['txtMarcaPortatil']) ||
                    empty($_POST['txtModeloPortatil']) ||
                    empty($_POST['txtEstadoPortatil']) ||
                    empty($_POST['txtDisponibilidadPortatil'])
                ) {
                    $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
                } else {
                    $intIdPortatil = intval($_POST['idPortatil']);
                    $numero_pc = strClean($_POST['txtNumeroPortatil']);
                    $marca = strClean($_POST['txtMarcaPortatil']);
                    $modelo = strClean($_POST['txtModeloPortatil']);
                    $ram = strClean($_POST['txtRamPortatil']);
                    $velocidad_ram = strClean($_POST['txtVelocidadRamPortatil']);
                    $procesador = strClean($_POST['txtProcesadorPortatil']);
                    $velocidad_procesador = strClean($_POST['txtVelocidadProcesadorPortatil']);
                    $disco_duro = strClean($_POST['txtDiscoDuroPortatil']);
                    $capacidad = strClean($_POST['txtCapacidadPortatil']);
                    $serial = strClean($_POST['txtSerialPortatil']);
                    $sistema_operativo = strClean($_POST['txtSistemaOperativoPortatil']);
                    $numero_activo = strClean($_POST['txtNumeroActivoPortatil']);
                    $estado = strClean($_POST['txtEstadoPortatil']);
                    $disponibilidad = strClean($_POST['txtDisponibilidadPortatil']);

                    $request = "";
                    if ($intIdPortatil == 0) {
                        if ($_SESSION['permisosMod']['w']) {
                            error_log('Insertando nuevo Portátil...');
                            $request = $this->model->insertPortatil($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
                            $option = 1;
                            error_log('Resultado insert: ' . print_r($request, true));
                        } else {
                            error_log('Sin permisos de escritura');
                        }
                    } else {
                        if ($_SESSION['permisosMod']['u']) {
                            error_log('Actualizando Portátil ID: ' . $intIdPortatil);
                            $request = $this->model->updatePortatil($intIdPortatil, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad);
                            $option = 2;
                            error_log('Resultado update: ' . $request);
                        } else {
                            error_log('Sin permisos de actualización');
                        }
                    }
                    
                    if (is_array($request) && isset($request['error'])) {
                        error_log('Error SQL: ' . $request['error']);
                        $arrResponse = array("status" => false, "msg" => 'Error SQL: ' . $request['error'], "debug" => $request);
                    } else if ($request > 0) {
                        $msg = $option == 1 ? "Portátil guardado correctamente." : "Portátil actualizado correctamente.";
                        $arrResponse = array("status" => true, "msg" => $msg);
                        error_log('Guardado exitoso: ' . $msg);
                    } else {
                        error_log('Error al almacenar - Request result: ' . print_r($request, true));
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                error_log('No hay datos POST');
                echo json_encode(array("status" => false, "msg" => 'No se recibieron datos'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log('EXCEPCIÓN en setPortatil: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            echo json_encode(array("status" => false, "msg" => 'Error interno: ' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPortatil()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdPortatil = intval($_POST['idPortatil']);
                $requestDelete = $this->model->deletePortatil($intIdPortatil);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el portátil correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== HERRAMIENTAS ====================
    public function getHerramientas()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectHerramientas();
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getHerramientaById($idHerramienta)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdHerramienta = intval(strClean($idHerramienta));
            if ($intIdHerramienta > 0) {
                $arrData = $this->model->selectHerramientaById($intIdHerramienta);
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

    public function setHerramienta()
    {
        if ($_POST) {
            if (
                empty($_POST['txtItemHerramienta']) ||
                empty($_POST['txtMarcaHerramienta']) ||
                empty($_POST['txtDisponibilidadHerramienta'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
            } else {
                $intIdHerramienta = intval($_POST['idHerramienta']);
                $item = strClean($_POST['txtItemHerramienta']);
                $marca = strClean($_POST['txtMarcaHerramienta']);
                $disponibilidad = strClean($_POST['txtDisponibilidadHerramienta']);

                $request = "";
                if ($intIdHerramienta == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertHerramienta($item, $marca, $disponibilidad);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateHerramienta($intIdHerramienta, $item, $marca, $disponibilidad);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Herramienta guardada correctamente." : "Herramienta actualizada correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delHerramienta()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdHerramienta = intval($_POST['idHerramienta']);
                $requestDelete = $this->model->deleteHerramienta($intIdHerramienta);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la herramienta correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // ==================== MOVIMIENTOS DE EQUIPOS ====================
    public function setMovimientoEquipo()
    {
        if ($_POST && $_SESSION['permisosMod']['w']) {
            $idEquipo = intval($_POST['idEquipo']);
            $tipoEquipo = strClean($_POST['tipoEquipo']);
            $tipoMovimiento = strClean($_POST['tipoMovimiento']);
            $observacion = strClean($_POST['observacion']);
            $usuario = isset($_SESSION['userData']['nombres']) ? $_SESSION['userData']['nombres'] : 'sistema';
            
            // Validar que no se pueda dar más de una entrada si ya está en mantenimiento
            if ($tipoMovimiento == 'entrada') {
                $ultimoMovimiento = $this->model->getUltimoMovimientoEquipo($idEquipo, $tipoEquipo);
                if ($ultimoMovimiento && $ultimoMovimiento['tipo_movimiento'] == 'entrada') {
                    $arrResponse = array('status' => false, 'msg' => 'El equipo ya se encuentra en mantenimiento. No se puede registrar otra entrada.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
            }
            
            // Solo cambiar disponibilidad en salidas
            if ($tipoMovimiento == 'salida') {
                $this->model->actualizarDisponibilidadEquipo($idEquipo, $tipoEquipo, 'Disponible');
            }
            // Si es entrada, NO cambiar la disponibilidad
            
            $request = $this->model->insertMovimientoEquipo($idEquipo, $tipoEquipo, $tipoMovimiento, $observacion, $usuario);
            if ($request > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Movimiento registrado correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo registrar el movimiento.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getMovimientosEquipo($idEquipo, $tipoEquipo)
    {
        // Asegurar que se envíe como JSON
        header('Content-Type: application/json');
        
        try {
            // Validar permisos
            if (!isset($_SESSION['permisosMod']['r'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tiene permisos para esta acción',
                    'data' => []
                ]);
                die();
            }
            
            // Limpiar y validar parámetros
            $idEquipo = intval($idEquipo);
            $tipoEquipo = trim($tipoEquipo);
            
            if ($idEquipo <= 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID de equipo inválido',
                    'data' => []
                ]);
                die();
            }
            
            // Validar tipo de equipo
            $tiposValidos = ['impresora', 'escaner', 'pc_torre', 'todo_en_uno', 'portatil', 'herramienta', 'otro'];
            if (!in_array($tipoEquipo, $tiposValidos)) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Tipo de equipo inválido: ' . $tipoEquipo,
                    'data' => []
                ]);
                die();
            }
            
            // Obtener datos
            $arrData = $this->model->getMovimientosEquipo($idEquipo, $tipoEquipo);
            
            // Asegurar que sea un array
            if (!is_array($arrData)) {
                $arrData = [];
            }
            
            echo json_encode([
                'status' => true,
                'msg' => '',
                'data' => $arrData
            ], JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            error_log('Error en getMovimientosEquipo: ' . $e->getMessage());
            echo json_encode([
                'status' => false,
                'msg' => 'Error al obtener los movimientos: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                'data' => []
            ], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getHistoricoGlobal()
    {
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['permisosMod']['r'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tiene permisos para esta acción',
                    'data' => []
                ]);
                die();
            }
            
            $arrData = $this->model->getHistoricoGlobal();
            
            if (!is_array($arrData)) {
                $arrData = [];
            }
            
            echo json_encode([
                'status' => true,
                'msg' => '',
                'data' => $arrData
            ], JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            error_log('Error en getHistoricoGlobal: ' . $e->getMessage());
            echo json_encode([
                'status' => false,
                'msg' => 'Error al obtener el histórico global',
                'error' => $e->getMessage(),
                'data' => []
            ], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getEstadisticasInventario()
    {
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['permisosMod']['r'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tiene permisos para esta acción'
                ]);
                die();
            }
            
            // Obtener datos para los gráficos
            $estadoEquipos = $this->model->getEstadisticasEstadoEquipos();
            $disponibilidadEquipos = $this->model->getEstadisticasDisponibilidadEquipos();
            $movimientosPorMes = $this->model->getEstadisticasMovimientosPorMes();
            $equiposConMasMantenimientos = $this->model->getEquiposConMasMantenimientos();
            
            echo json_encode([
                'status' => true,
                'msg' => '',
                'estadoEquipos' => $estadoEquipos,
                'disponibilidadEquipos' => $disponibilidadEquipos,
                'movimientosPorMes' => $movimientosPorMes,
                'equiposConMasMantenimientos' => $equiposConMasMantenimientos
            ], JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            error_log('Error en getEstadisticasInventario: ' . $e->getMessage());
            echo json_encode([
                'status' => false,
                'msg' => 'Error al obtener las estadísticas',
                'error' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
