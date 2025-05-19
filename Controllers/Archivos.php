<?php
class Archivos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
    }

    public function Archivos()
    {
        $data['page_tag'] = "Archivos";
        $data['page_title'] = "MÓDULO DE ARCHIVOS";
        $data['page_name'] = "archivos";
        $data['page_functions_js'] = "functions_archivos.js";
        $this->views->getView($this, "Archivos", $data);
    }

    public function getArchivos()
    {
        $arrData = $this->model->selectArchivos();

        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnDownload = '';
            $btnDelete = '';

            // Botón de ver
            $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewArchivo(' . $arrData[$i]['id'] . ')" title="Ver archivo"><i class="bi bi-eye-fill"></i></button>';
            
            // Botón de descargar
            $btnDownload = '<a class="btn btn-primary btn-sm" href="' . base_url() . '/uploads/archivos/' . $arrData[$i]['archivo'] . '" download title="Descargar"><i class="bi bi-download"></i></a>';
            
            // Botón de eliminar
            if ($_SESSION['permisosMod']['d']) {
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelArchivo(' . $arrData[$i]['id'] . ')" title="Eliminar"><i class="bi bi-trash-fill"></i></button>';
            }
            
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnDownload . ' ' . $btnDelete . '</div>';
        }
        
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getArchivo($idarchivo)
    {
        $idarchivo = intval($idarchivo);
        if ($idarchivo > 0) {
            $arrData = $this->model->selectArchivo($idarchivo);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setArchivo()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_FILES['fileArchivo'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idArchivo = intval($_POST['idArchivo']);
                $strNombre = strClean($_POST['txtNombre']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                
                $archivo = $_FILES['fileArchivo'];
                $nombre_archivo = $archivo['name'];
                $tipo = $archivo['type'];
                $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
                
                // Validar extensiones permitidas
                $extensiones_permitidas = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif');
                $extensiones_prohibidas = array('php', 'exe', 'js', 'html', 'htm');
                
                if (in_array(strtolower($extension), $extensiones_prohibidas)) {
                    $arrResponse = array("status" => false, "msg" => 'Extensión de archivo no permitida.');
                } elseif (!in_array(strtolower($extension), $extensiones_permitidas)) {
                    $arrResponse = array("status" => false, "msg" => 'Solo se permiten archivos: ' . implode(', ', $extensiones_permitidas));
                } else {
                    // Crear directorio si no existe
                    $directorio = 'uploads/archivos/';
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }
                    
                    // Generar nombre único para el archivo
                    $nombre_archivo_nuevo = md5(uniqid(rand(), true)) . '.' . $extension;
                    $ruta_archivo = $directorio . $nombre_archivo_nuevo;
                    
                    if ($idArchivo == 0) {
                        // Crear
                        $request_archivo = $this->model->insertArchivo($strNombre, $strDescripcion, $nombre_archivo_nuevo, $extension);
                        $option = 1;
                    } else {
                        // Actualizar
                        $request_archivo = $this->model->updateArchivo($idArchivo, $strNombre, $strDescripcion, $nombre_archivo_nuevo, $extension);
                        $option = 2;
                    }
                    
                    if ($request_archivo > 0) {
                        if (move_uploaded_file($archivo['tmp_name'], $ruta_archivo)) {
                            if ($option == 1) {
                                $arrResponse = array('status' => true, 'msg' => 'Archivo guardado correctamente.');
                            } else {
                                $arrResponse = array('status' => true, 'msg' => 'Archivo actualizado correctamente.');
                            }
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'Error al guardar el archivo.');
                        }
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo guardar la información.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delArchivo()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $idarchivo = intval($_POST['idArchivo']);
                $requestDelete = $this->model->deleteArchivo($idarchivo);
                
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el archivo');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el archivo.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function search()
    {
        if ($_POST) {
            $strBusqueda = strClean($_POST['busqueda']);
            $arrData = $this->model->searchArchivos($strBusqueda);
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnDownload = '';
                $btnDelete = '';

                // Botón de ver
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewArchivo(' . $arrData[$i]['id'] . ')" title="Ver archivo"><i class="bi bi-eye-fill"></i></button>';
                
                // Botón de descargar
                $btnDownload = '<a class="btn btn-primary btn-sm" href="' . base_url() . '/uploads/archivos/' . $arrData[$i]['archivo'] . '" download title="Descargar"><i class="bi bi-download"></i></a>';
                
                // Botón de eliminar
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelArchivo(' . $arrData[$i]['id'] . ')" title="Eliminar"><i class="bi bi-trash-fill"></i></button>';
                }
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnDownload . ' ' . $btnDelete . '</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>