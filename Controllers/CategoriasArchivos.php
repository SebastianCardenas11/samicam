<?php
class CategoriasArchivos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MARCHIVOS);
    }

    public function CategoriasArchivos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 8;
        $data['page_tag'] = "Categorías de Archivos";
        $data['page_title'] = "Categorías de Archivos";
        $data['page_name'] = "categorias_archivos";
        $data['page_functions_js'] = "functions_categorias_archivos.js";
        $this->views->getView($this, "CategoriasArchivos", $data);
    }

    public function getCategorias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCategorias();

            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge text-bg-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewCategoria(' . $arrData[$i]['id_categoria'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning " onClick="fntEditCategoria(' . $arrData[$i]['id_categoria'] . ')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger" onClick="fntDelCategoria(' . $arrData[$i]['id_categoria'] . ')" title="Eliminar categoría"><i class="bi bi-trash-fill"></i></button>';
                }
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCategoria($idcategoria)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idcategoria = intval($idcategoria);
            if ($idcategoria > 0) {
                $arrData = $this->model->selectCategoria($idcategoria);
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

    public function setCategoria()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['w'] || $_SESSION['permisosMod']['u']) {
                if (empty($_POST['txtNombre'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    $idCategoria = intval($_POST['idCategoria']);
                    $strNombre = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $intStatus = intval($_POST['listStatus']);
                    
                    if ($idCategoria == 0) {
                        // Crear
                        if ($_SESSION['permisosMod']['w']) {
                            $request_categoria = $this->model->insertCategoria($strNombre, $strDescripcion, $intStatus);
                            $option = 1;
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para crear categorías.');
                            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                            die();
                        }
                    } else {
                        // Actualizar
                        if ($_SESSION['permisosMod']['u']) {
                            $request_categoria = $this->model->updateCategoria($idCategoria, $strNombre, $strDescripcion, $intStatus);
                            $option = 2;
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para actualizar categorías.');
                            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                            die();
                        }
                    }
                    
                    if ($request_categoria > 0) {
                        if ($option == 1) {
                            $arrResponse = array('status' => true, 'msg' => 'Categoría creada correctamente.');
                        } else {
                            $arrResponse = array('status' => true, 'msg' => 'Categoría actualizada correctamente.');
                        }
                    } else if ($request_categoria == 'exist') {
                        $arrResponse = array('status' => false, 'msg' => 'La categoría ya existe.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo guardar la información.');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delCategoria()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $idcategoria = intval($_POST['idCategoria']);
                $requestDelete = $this->model->deleteCategoria($idcategoria);
                
                if ($requestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoría');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una categoría con archivos asociados.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoría.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para eliminar categorías.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectCategorias()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectCategorias();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_categoria'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
}
?>