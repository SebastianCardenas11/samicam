<?php
class Publicaciones extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(MPUBLICACIONES);
    }

    public function Publicaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Publicaciones";
        $data['page_title'] = "Publicaciones";
        $data['page_name'] = "publicaciones";
        $data['page_functions_js'] = "functions_publicaciones.js";
        $data['estadisticas'] = $this->model->getEstadisticas();
        $data['dependencias'] = $this->model->getDependencias();
        $this->views->getView($this, "publicaciones", $data);
    }

    public function getPublicaciones()
    {
        try {
            if ($_SESSION['permisosMod']['r']) {
                $arrData = $this->model->selectPublicaciones();
                
                if (!is_array($arrData)) {
                    throw new Exception("Error al obtener los datos");
                }
                
                for ($i = 0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['id_publicacion'] . ')" title="Ver publicación"><i class="far fa-eye"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['u']) {
                        $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(' . $arrData[$i]['id_publicacion'] . ')" title="Editar publicación"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $arrData[$i]['id_publicacion'] . ')" title="Eliminar publicación"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                    
                    // Formatear fechas para mejor visualización
                    if(!empty($arrData[$i]['fecha_recibido'])) {
                        $arrData[$i]['fecha_recibido'] = date('d/m/Y', strtotime($arrData[$i]['fecha_recibido']));
                    }
                    if(!empty($arrData[$i]['fecha_publicacion'])) {
                        $arrData[$i]['fecha_publicacion'] = date('d/m/Y', strtotime($arrData[$i]['fecha_publicacion']));
                    }

                    // Asegurar que todos los campos existan
                    $required_fields = ['id_publicacion', 'fecha_recibido', 'correo_recibido', 'asunto', 
                                     'dependencia_nombre', 'fecha_publicacion', 'respuesta_envio', 'status'];
                    foreach ($required_fields as $field) {
                        if (!isset($arrData[$i][$field])) {
                            $arrData[$i][$field] = '';
                        }
                    }
                }
                
                header('Content-Type: application/json');
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('error' => 'No tiene permisos para ver publicaciones'), JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPublicacion($idpublicacion)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdPublicacion = intval($idpublicacion);
            if ($intIdPublicacion > 0) {
                $arrData = $this->model->selectPublicacion($intIdPublicacion);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                header('Content-Type: application/json');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setPublicacion()
    {
        if ($_POST) {
            if (empty($_POST['txtFechaRecibido']) || empty($_POST['txtCorreoRecibido']) || 
                empty($_POST['txtAsunto']) || empty($_POST['listDependencia'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdPublicacion = intval($_POST['idPublicacion']);
                $strNombrePublicacion = strClean($_POST['txtNombrePublicacion']);
                $strFechaRecibido = strClean($_POST['txtFechaRecibido']);
                $strCorreoRecibido = strClean($_POST['txtCorreoRecibido']);
                $strAsunto = strClean($_POST['txtAsunto']);
                $strFechaPublicacion = strClean($_POST['txtFechaPublicacion']);
                $strRespuestaEnvio = strClean($_POST['listRespuestaEnvio']);
                $strEnlacePublicacion = strClean($_POST['txtEnlacePublicacion']);
                $intDependencia = intval($_POST['listDependencia']);
                $intStatus = intval($_POST['listStatus']);

                if($intIdPublicacion == 0) {
                    // Crear
                    if($_SESSION['permisosMod']['w']) {
                        $request_publicacion = $this->model->insertPublicacion(
                            $strFechaRecibido,
                            $strCorreoRecibido,
                            $strAsunto,
                            $strFechaPublicacion,
                            $strRespuestaEnvio,
                            $strEnlacePublicacion,
                            $intDependencia,
                            $intStatus,
                            $strNombrePublicacion
                        );
                        $option = 1;
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para crear publicaciones.');
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                } else {
                    // Actualizar
                    if($_SESSION['permisosMod']['u']) {
                        $request_publicacion = $this->model->updatePublicacion(
                            $intIdPublicacion,
                            $strFechaRecibido,
                            $strCorreoRecibido,
                            $strAsunto,
                            $strFechaPublicacion,
                            $strRespuestaEnvio,
                            $strEnlacePublicacion,
                            $intDependencia,
                            $intStatus,
                            $strNombrePublicacion
                        );
                        $option = 2;
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para actualizar publicaciones.');
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                }

                if($request_publicacion > 0) {
                    if($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        // Registrar en auditoría
                        $arrAudit = array(
                            'user_id' => $_SESSION['idUser'],
                            'user_name' => $_SESSION['userData']['nombres'],
                            'user_rol' => $_SESSION['userData']['nombrerol'],
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'accion' => 'Creación de nueva publicación: ' . $strAsunto
                        );
                        $this->model->insertAudit($arrAudit);
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        // Registrar en auditoría
                        $arrAudit = array(
                            'user_id' => $_SESSION['idUser'],
                            'user_name' => $_SESSION['userData']['nombres'],
                            'user_rol' => $_SESSION['userData']['nombrerol'],
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'accion' => 'Actualización de publicación ID: ' . $intIdPublicacion
                        );
                        $this->model->insertAudit($arrAudit);
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            header('Content-Type: application/json');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPublicacion()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdPublicacion = intval($_POST['idPublicacion']);
                $requestDelete = $this->model->deletePublicacion($intIdPublicacion);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la publicación');
                    // Registrar en auditoría
                    $arrAudit = array(
                        'user_id' => $_SESSION['idUser'],
                        'user_name' => $_SESSION['userData']['nombres'],
                        'user_rol' => $_SESSION['userData']['nombrerol'],
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'accion' => 'Eliminación de publicación ID: ' . $intIdPublicacion
                    );
                    $this->model->insertAudit($arrAudit);
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la publicación.');
                }
                header('Content-Type: application/json');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getDependencias()
    {
        if($_SESSION['permisosMod']['r']){
            $arrData = $this->model->getDependencias();
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>