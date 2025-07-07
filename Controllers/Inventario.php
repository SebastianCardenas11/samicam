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
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
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
        if ($_POST) {
            if (
                empty($_POST['txtNumeroImpresora']) ||
                empty($_POST['txtMarca']) ||
                empty($_POST['txtModelo']) ||
                empty($_POST['txtEstado']) ||
                empty($_POST['txtDisponibilidad'])
            ) {
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
                $intDependencia = intval($_POST['listDependencia']);
                $strOficina = strClean($_POST['txtOficina']);
                $intFuncionario = intval($_POST['listFuncionario']);
                $intCargo = intval($_POST['listCargo']);
                $intContacto = intval($_POST['listContacto']);

                $request = "";
                if ($intIdImpresora == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertImpresora($strNumeroImpresora, $strMarca, $strModelo, $strSerial, $strConsumible, $strEstado, $strDisponibilidad, $intDependencia, $strOficina, $intFuncionario, $intCargo, $intContacto);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateImpresora($intIdImpresora, $strNumeroImpresora, $strMarca, $strModelo, $strSerial, $strConsumible, $strEstado, $strDisponibilidad, $intDependencia, $strOficina, $intFuncionario, $intCargo, $intContacto);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Impresora guardada correctamente." : "Impresora actualizada correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else if ($request == 'exist') {
                    $arrResponse = array("status" => false, "msg" => '¡Atención! La impresora ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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

    // ==================== ESCÁNERES ====================
    public function getEscaneres()
    {
        if ($_SESSION['permisosMod']['r']) {
            try {
                $arrData = $this->model->selectEscaneres();
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
                $intDependencia = intval($_POST['listDependencia']);
                $strOficina = strClean($_POST['txtOficina']);
                $intFuncionario = intval($_POST['listFuncionario']);
                $intCargo = intval($_POST['listCargo']);
                $intContacto = intval($_POST['listContacto']);

                $request = "";
                if ($intIdEscaner == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertEscaner($strNumeroEscaner, $strMarca, $strModelo, $strSerial, $strEstado, $strDisponibilidad, $intDependencia, $strOficina, $intFuncionario, $intCargo, $intContacto);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateEscaner($intIdEscaner, $strNumeroEscaner, $strMarca, $strModelo, $strSerial, $strEstado, $strDisponibilidad, $intDependencia, $strOficina, $intFuncionario, $intCargo, $intContacto);
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

    // ==================== FUNCIONARIOS, DEPENDENCIAS, CARGOS, CONTACTOS ====================
    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getDependencias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectDependencias();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCargos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCargos();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getContactos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectContactos();
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
        if ($_POST) {
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
                $id_dependencia = intval($_POST['listDependenciaPcTorre']);
                $oficina = strClean($_POST['txtOficinaPcTorre']);
                $id_funcionario = intval($_POST['listFuncionarioPcTorre']);
                $id_cargo = intval($_POST['listCargoPcTorre']);
                $id_contacto = intval($_POST['listContactoPcTorre']);

                $request = "";
                if ($intIdPcTorre == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertPcTorre($numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updatePcTorre($intIdPcTorre, $numero_pc, $marca, $serial, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $sistema_operativo, $numero_activo, $monitor, $numero_activo_monitor, $serial_monitor, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "PC Torre guardada correctamente." : "PC Torre actualizada correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
        if ($_POST) {
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
                $id_dependencia = intval($_POST['listDependenciaTodoEnUno']);
                $oficina = strClean($_POST['txtOficinaTodoEnUno']);
                $id_funcionario = intval($_POST['listFuncionarioTodoEnUno']);
                $id_cargo = intval($_POST['listCargoTodoEnUno']);
                $id_contacto = intval($_POST['listContactoTodoEnUno']);

                $request = "";
                if ($intIdTodoEnUno == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertTodoEnUno($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updateTodoEnUno($intIdTodoEnUno, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "PC Todo en Uno guardado correctamente." : "PC Todo en Uno actualizado correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
        if ($_POST) {
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
                $id_dependencia = intval($_POST['listDependenciaPortatil']);
                $oficina = strClean($_POST['txtOficinaPortatil']);
                $id_funcionario = intval($_POST['listFuncionarioPortatil']);
                $id_cargo = intval($_POST['listCargoPortatil']);
                $id_contacto = intval($_POST['listContactoPortatil']);

                $request = "";
                if ($intIdPortatil == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request = $this->model->insertPortatil($numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request = $this->model->updatePortatil($intIdPortatil, $numero_pc, $marca, $modelo, $ram, $velocidad_ram, $procesador, $velocidad_procesador, $disco_duro, $capacidad, $serial, $sistema_operativo, $numero_activo, $estado, $disponibilidad, $id_dependencia, $oficina, $id_funcionario, $id_cargo, $id_contacto);
                        $option = 2;
                    }
                }
                if ($request > 0) {
                    $msg = $option == 1 ? "Portátil guardado correctamente." : "Portátil actualizado correctamente.";
                    $arrResponse = array("status" => true, "msg" => $msg);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
}
