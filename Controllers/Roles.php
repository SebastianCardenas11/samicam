<?php

class Roles extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        // session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        // getPermisos(MDADMINISTRADOR);
        getPermisos(MUSUARIOS);
    }

    public function Roles()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles";
        $data['page_name'] = "rol_usuario";
        $data['page_title'] = "Roles";
        $data['page_functions_js'] = "functions_roles.js";
        $this->views->getView($this, "roles", $data);
    }

    public function getRoles()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData = $this->model->selectRoles();

            for ($i = 0; $i < count($arrData); $i++) {

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge text-bg-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                // Verificar si es el rol de superadministrador (ID 1)
                if ($arrData[$i]['idrol'] == 1) {
                    // Para el superadministrador, todos los botones deshabilitados
                    $btnView = '<button class="btn btn-secondary" disabled><i class="bi bi-toggles"></i></button>';
                    $btnEdit = '<button class="btn btn-secondary" disabled><i class="bi bi-pencil"></i></button>';
                    $btnDelete = '<button class="btn btn-secondary" disabled><i class="bi bi-trash3"></i></button>';
                } else {
                    // Para otros roles, mostrar botones según permisos
                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info btnPermisosRol" onClick="fntPermisos(' . $arrData[$i]['idrol'] . ')" title="Permisos"><i class="bi bi-toggles"></i></button>';
                    }

                    if ($_SESSION['permisosMod']['u']) {
                        $btnEdit = '<button class="btn btn-warning btnEditRol" onClick="fntEditRol(' . $arrData[$i]['idrol'] . ')" title="Editar"><i class="bi bi-pencil"></i></button>';
                    } else {
                        $btnEdit = '<button class="btn btn-secondary" disabled><i class="bi bi-pencil"></i></button>';
                    }

                    if ($_SESSION['permisosMod']['d']) {
                        // Permitir eliminar roles a cualquier usuario con permiso de eliminación
                        $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelRol(' . $arrData[$i]['idrol'] . ')" title="Eliminar"><i class="bi bi-trash3"></i></button>';
                    } else {
                        $btnDelete = '<button class="btn btn-secondary" disabled><i class="bi bi-trash3"></i></button>';
                    }
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectRoles()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['idrol'] . '">' . $arrData[$i]['nombrerol'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getRol(int $idrol)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdrol = intval(strClean($idrol));
            if ($intIdrol > 0) {
                // No permitir editar el rol de superadministrador (ID 1)
                if ($intIdrol == 1) {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede editar el rol de Superadministrador.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                $arrData = $this->model->selectRol($intIdrol);
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

    public function setRol()
    {
        $intIdrol = intval($_POST['idRol']);
        $strRol = strClean($_POST['txtNombre']);
        $strDescipcion = strClean($_POST['txtDescripcion']);
        $intStatus = intval($_POST['listStatus']);
        
        // No permitir editar el rol de superadministrador (ID 1)
        if ($intIdrol == 1) {
            $arrResponse = array('status' => false, 'msg' => 'No se puede modificar el rol de Superadministrador.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
        
        $request_rol = "";
        if ($intIdrol == 0) {
            //Crear
            if ($_SESSION['permisosMod']['w']) {
                $request_rol = $this->model->insertRol($strRol, $strDescipcion, $intStatus);
                $option = 1;
            }
        } else {
            //Actualizar
            if ($_SESSION['permisosMod']['u']) {
                $request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescipcion, $intStatus);
                $option = 2;
            }
        }

        if ($request_rol > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }
        } else if ($request_rol == 'exist') {
            $arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delRol()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdrol = intval($_POST['idrol']);
                
                // No permitir eliminar el rol de superadministrador (ID 1)
                if ($intIdrol == 1) {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar el rol de Superadministrador.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                $requestDelete = $this->model->deleteRol($intIdrol);
                if ($requestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a usuarios');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el rol');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}