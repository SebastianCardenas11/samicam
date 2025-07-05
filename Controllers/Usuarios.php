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

                // Obtener roles adicionales si existen
                $roles_adicionales = array();
                if (isset($_POST['txtRolesAdicionales']) && is_array($_POST['txtRolesAdicionales'])) {
                    $roles_adicionales = array_map('intval', $_POST['txtRolesAdicionales']);
                }

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
                        
                        // Si se creó el usuario exitosamente, asignar roles adicionales
                        if ($request_user > 0 && !empty($roles_adicionales)) {
                            $this->model->asignarRolesUsuario($request_user, $roles_adicionales);
                        }
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
                            
                            // Actualizar roles adicionales
                            if ($request_user && !empty($roles_adicionales)) {
                                $this->model->updateRolesUsuario($intIdeUsuario, $roles_adicionales);
                            }
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
                            
                            // Actualizar roles adicionales
                            if ($request_user && !empty($roles_adicionales)) {
                                $this->model->updateRolesUsuario($intIdeUsuario, $roles_adicionales);
                            }
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
            // Usar el nuevo método que incluye múltiples roles
            $arrData = $this->model->selectUsuariosConRoles();
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

                // Mostrar roles asignados
                if (!empty($arrData[$i]['roles_asignados'])) {
                    $arrData[$i]['roles_asignados'] = '<span class="badge text-bg-info">' . $arrData[$i]['roles_asignados'] . '</span>';
                } else {
                    $arrData[$i]['roles_asignados'] = '<span class="badge text-bg-secondary">Sin roles adicionales</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['ideusuario'] . ')" title="Ver Usuario"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['ideusuario'] . ')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
                }

                if($_SESSION['permisosMod']['d']){
                    // Permitir eliminar a cualquier usuario con permiso de eliminación
                    // excepto a sí mismo y al superadministrador (idrol = 1)
                    if($arrData[$i]['rol_principal'] == 1 || $_SESSION['userData']['ideusuario'] == $arrData[$i]['ideusuario']){
                        // No mostrar botón para superadmin o para sí mismo
                    } else {
                        $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $arrData[$i]['ideusuario'] . ')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
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
                // Usar el nuevo método que incluye todos los roles
                $arrData = $this->model->selectUsuarioConRoles($ideusuario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    // No enviamos la contraseña al formulario
                    $arrData['password_visible'] = "";
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

    // =====================================================
    // NUEVOS MÉTODOS PARA MANEJAR MÚLTIPLES ROLES
    // =====================================================

    // Obtener roles disponibles para asignar
    public function getRolesDisponibles()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectRoles();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Obtener roles de un usuario específico
    public function getRolesUsuario($ideusuario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $ideusuario = intval($ideusuario);
            if ($ideusuario > 0) {
                $arrData = $this->model->getRolesUsuario($ideusuario);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // Asignar roles a un usuario
    public function asignarRoles()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['u']) {
                $intIdeUsuario = intval($_POST['ideUsuario']);
                $roles = array();
                
                if (isset($_POST['roles']) && is_array($_POST['roles'])) {
                    $roles = array_map('intval', $_POST['roles']);
                }
                
                $request = $this->model->asignarRolesUsuario($intIdeUsuario, $roles);
                
                if ($request) {
                    $arrResponse = array('status' => true, 'msg' => 'Roles asignados correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al asignar roles');
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // Verificar permisos de un usuario (combinando todos sus roles)
    public function getPermisosUsuario($ideusuario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $ideusuario = intval($ideusuario);
            if ($ideusuario > 0) {
                $arrData = $this->model->getPermisosUsuario($ideusuario);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    // MÉTODO DE DEBUG: Verificar permisos del usuario actual
    public function debugPermisosUsuario()
    {
        if (!empty($_SESSION['userData'])) {
            $ideusuario = $_SESSION['userData']['ideusuario'];
            $idrol = $_SESSION['userData']['idrol'];
            
            // Obtener roles del usuario
            $roles = $this->model->getRolesUsuario($ideusuario);
            
            // Obtener permisos combinados
            $permisosCombinados = $this->model->getPermisosUsuario($ideusuario);
            
            // Obtener permisos del rol principal
            require_once("Models/PermisosModel.php");
            $objPermisos = new PermisosModel();
            $permisosRolPrincipal = $objPermisos->permisosModulo($idrol);
            
            $debug = array(
                'usuario_id' => $ideusuario,
                'rol_principal_id' => $idrol,
                'roles_asignados' => $roles,
                'permisos_rol_principal' => $permisosRolPrincipal,
                'permisos_combinados' => $permisosCombinados,
                'permisos_sesion' => $_SESSION['permisos'],
                'permisos_modulo_actual' => $_SESSION['permisosMod']
            );
            
            echo json_encode($debug, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('error' => 'No hay sesión activa'), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}