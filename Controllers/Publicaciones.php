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
        getPermisos(8); // Asignar el ID del módulo de publicaciones
    }

    public function Publicaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Publicaciones";
        $data['page_title'] = "PUBLICACIONES <small>SAMICAM</small>";
        $data['page_name'] = "publicaciones";
        $data['page_functions_js'] = "functions_publicaciones.js";
        $this->views->getView($this, "publicaciones", $data);
    }

    public function getPublicaciones()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPublicaciones();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnDelete = '';

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_publicacion'] . ')" title="Ver publicación"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_publicacion'] . ')" title="Eliminar publicación"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnDelete . '</div>';
                
                // Formatear fechas para mejor visualización
                if(!empty($arrData[$i]['fecha_recibido'])) {
                    $arrData[$i]['fecha_recibido'] = date('d/m/Y', strtotime($arrData[$i]['fecha_recibido']));
                }
                if(!empty($arrData[$i]['fecha_publicacion'])) {
                    $arrData[$i]['fecha_publicacion'] = date('d/m/Y', strtotime($arrData[$i]['fecha_publicacion']));
                }
            }
            header('Content-Type: application/json');
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
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
            if (empty($_POST['txtFechaRecibido']) || empty($_POST['txtCorreoRecibido']) || empty($_POST['txtAsunto'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdPublicacion = intval($_POST['idPublicacion']);
                $strFechaRecibido = strClean($_POST['txtFechaRecibido']);
                $strCorreoRecibido = strClean($_POST['txtCorreoRecibido']);
                $strAsunto = strClean($_POST['txtAsunto']);
                $strFechaPublicacion = strClean($_POST['txtFechaPublicacion']);
                $strRespuestaEnvio = strClean($_POST['listRespuestaEnvio']);
                $strEnlacePublicacion = strClean($_POST['txtEnlacePublicacion']);
                $intStatus = intval($_POST['listStatus']);

                $request_publicacion = $this->model->insertPublicacion(
                    $strFechaRecibido,
                    $strCorreoRecibido,
                    $strAsunto,
                    $strFechaPublicacion,
                    $strRespuestaEnvio,
                    $strEnlacePublicacion,
                    $intStatus
                );

                if ($request_publicacion > 0) {
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
                } else if ($request_publicacion == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La publicación ya existe.');
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
}
?>