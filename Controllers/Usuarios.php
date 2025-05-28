<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MUSUARIOS);
    }

    public function Usuarios()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 2;
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "Usuarios";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "functions_usuarios.js";
        
        // Registrar acceso al módulo
        $this->registrarAccesoModulo("Usuarios");
        
        $this->views->getView($this, "usuarios", $data);
    }

    public function setUsuario()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtCorreoUsuario'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdeUsuario = intval($_POST['ideUsuario']);
                $strIdentificacionUsuario = strClean($_POST['txtCorreoUsuario']);
                $strNombresUsuario = strClean($_POST['txtNombresUsuario']);
                $strRolUsuario = intval(strClean($_POST['txtRolUsuario']));
                $intStatus = intval(strClean($_POST['listStatus']));

                $request_user = "";
                if ($intIdeUsuario == 0) {
                    $option = 1;
                    // Verificar que se haya proporcionado una contraseña
                    if (empty($_POST['txtContrasenaUsuario'])) {
                        $arrResponse = array("status" => false, "msg" => 'La contraseña es obligatoria.');
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                    
                    // Usar la contraseña proporcionada
                    $strPassword = hash("SHA256", $_POST['txtContrasenaUsuario']);
                    
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertUsuario(
                            $strIdentificacionUsuario,
                            $strNombresUsuario,
                            $strPassword,
                            $strRolUsuario,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    // Verificar si se proporcionó una nueva contraseña para actualizar
                    if (!empty($_POST['txtContrasenaUsuario'])) {
                        // Encriptar la contraseña
                        $strPassword = hash("SHA256", $_POST['txtContrasenaUsuario']);
                        
                        if ($_SESSION['permisosMod']['u']) {
                            $request_user = $this->model->updateUsuarioConPassword(
                                $intIdeUsuario,
                                $strIdentificacionUsuario,
                                $strNombresUsuario,
                                $strPassword,
                                $strRolUsuario,
                                $intStatus
                            );
                        }
                    } else {
                        // No modificar la contraseña al actualizar
                        if ($_SESSION['permisosMod']['u']) {
                            $request_user = $this->model->updateUsuario(
                                $intIdeUsuario,
                                $strIdentificacionUsuario,
                                $strNombresUsuario,
                                $strRolUsuario,
                                $intStatus
                            );
                        }
                    }
                }
                
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Usuario guardado correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Usuario actualizado correctamente');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el correo del Usuario ya existe, ingrese otro');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectUsuarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge text-bg-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['ideusuario'] . ')" title="Ver Usuario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['ideusuario'] . ')" title="Editar Usuario"><i class="bi bi-pencil"></i></button>';
                }

                if($_SESSION['permisosMod']['d']){
                    // Permitir eliminar a cualquier usuario con permiso de eliminación
                    // excepto a sí mismo y al superadministrador (idrol = 1)
                    if($arrData[$i]['idrol'] == 1 || $_SESSION['userData']['ideusuario'] == $arrData[$i]['ideusuario']){
                        // No mostrar botón para superadmin o para sí mismo
                    } else {
                        $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $arrData[$i]['ideusuario'] . ')" title="Eliminar Usuario"><i class="bi bi-trash3"></i></button>';
                    }
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuario($ideusuario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $ideusuario = intval($ideusuario);
            if ($ideusuario > 0) {
                $arrData = $this->model->selectUsuario($ideusuario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    // Añadir una contraseña simple para mostrar en el formulario
                    $arrData['password_visible'] = "123";
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delUsuario()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdeUsuario = intval($_POST['ideUsuario']);
                $requestDelete = $this->model->deleteUsuario($intIdeUsuario);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Usuario');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Usuario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}