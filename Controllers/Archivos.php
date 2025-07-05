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
        getPermisos(MARCHIVOS);
    }

    public function Archivos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 8;
        $data['page_tag'] = "Archivos";
        $data['page_title'] = "Archivos";
        $data['page_name'] = "archivos";
        $data['page_functions_js'] = "functions_archivos.js";
        $this->views->getView($this, "Archivos", $data);
    }

    public function getArchivos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectArchivos();

            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnDownload = '';
                $btnDelete = '';

                // Botón de ver
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewArchivo(' . $arrData[$i]['id'] . ')" title="Ver archivo"><i class="far fa-eye"></i></button>';
                }
                
                // Botón de descargar
                if ($_SESSION['permisosMod']['r']) {
                    $btnDownload = '<a class="btn btn-primary btn-sm" href="' . base_url() . '/uploads/archivos/' . $arrData[$i]['archivo'] . '" download="' . $arrData[$i]['nombre'] . '.' . $arrData[$i]['extension'] . '" title="Descargar"><i class="bi bi-download"></i></a>';
                }
                
                // Botón de eliminar
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelArchivo(' . $arrData[$i]['id'] . ')" title="Eliminar"><i class="bi bi-trash-fill"></i></button>';
                }
                
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnDownload . ' ' . $btnDelete . '</div>';
                
                // Agregar nombre de categoría
                if (!empty($arrData[$i]['id_categoria'])) {
                    $categoria = $this->model->getCategoriaNombre($arrData[$i]['id_categoria']);
                    $arrData[$i]['categoria'] = $categoria['nombre'];
                } else {
                    $arrData[$i]['categoria'] = 'Sin categoría';
                }
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getArchivo($idarchivo)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idarchivo = intval($idarchivo);
            if ($idarchivo > 0) {
                $arrData = $this->model->selectArchivo($idarchivo);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    // Obtener nombre de categoría
                    if (!empty($arrData['id_categoria'])) {
                        $categoria = $this->model->getCategoriaNombre($arrData['id_categoria']);
                        $arrData['categoria'] = $categoria['nombre'];
                    } else {
                        $arrData['categoria'] = 'Sin categoría';
                    }
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setArchivo()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['w']) {
                if (empty($_POST['txtNombre']) || empty($_FILES['fileArchivo'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    $idArchivo = intval($_POST['idArchivo']);
                    $strNombre = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $intCategoria = !empty($_POST['listCategoria']) ? intval($_POST['listCategoria']) : null;
                    
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
                            $request_archivo = $this->model->insertArchivo($strNombre, $strDescripcion, $nombre_archivo_nuevo, $extension, $intCategoria);
                            $option = 1;
                        } else {
                            // Actualizar
                            if ($_SESSION['permisosMod']['u']) {
                                $request_archivo = $this->model->updateArchivo($idArchivo, $strNombre, $strDescripcion, $nombre_archivo_nuevo, $extension, $intCategoria);
                                $option = 2;
                            } else {
                                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para actualizar archivos.');
                                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                                die();
                            }
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
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para crear archivos.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delArchivo()
    {
        // Desactivar la salida del buffer
        ob_clean();
        
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $idarchivo = intval($_POST['idArchivo']);
                try {
                    $requestDelete = $this->model->deleteArchivo($idarchivo);
                    if ($requestDelete) {
                        $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el archivo');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el archivo.');
                    }
                } catch (Exception $e) {
                    $arrResponse = array('status' => false, 'msg' => 'Error: ' . $e->getMessage());
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para eliminar archivos.');
            }
            
            // Asegurar que no haya salida antes del JSON
            if (ob_get_length()) ob_clean();
            
            // Establecer las cabeceras correctas
            header('Content-Type: application/json');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            
            // Enviar la respuesta JSON
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            exit;
        }
        exit;
    }

    public function search()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['r']) {
                $strBusqueda = strClean($_POST['busqueda']);
                $arrData = $this->model->searchArchivos($strBusqueda);
                
                for ($i = 0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnDownload = '';
                    $btnDelete = '';

                    // Botón de ver
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewArchivo(' . $arrData[$i]['id'] . ')" title="Ver archivo"><i class="far fa-eye"></i></button>';
                    
                    // Botón de descargar
                    $btnDownload = '<a class="btn btn-primary btn-sm" href="' . base_url() . '/uploads/archivos/' . $arrData[$i]['archivo'] . '" download="' . $arrData[$i]['nombre'] . '.' . $arrData[$i]['extension'] . '" title="Descargar"><i class="bi bi-download"></i></a>';
                    
                    // Botón de eliminar
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelArchivo(' . $arrData[$i]['id'] . ')" title="Eliminar"><i class="bi bi-trash-fill"></i></button>';
                    }
                    
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnDownload . ' ' . $btnDelete . '</div>';
                    
                    // Agregar nombre de categoría
                    if (!empty($arrData[$i]['id_categoria'])) {
                        $categoria = $this->model->getCategoriaNombre($arrData[$i]['id_categoria']);
                        $arrData[$i]['categoria'] = $categoria['nombre'];
                    } else {
                        $arrData[$i]['categoria'] = 'Sin categoría';
                    }
                }
                
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array(), JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function getSelectCategorias()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectCategorias();
        if (count($arrData) > 0) {
            $htmlOptions .= '<option value="0">Seleccione una categoría</option>';
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_categoria'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
    
    public function getArchivosPorCategoria($idcategoria)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idcategoria = intval($idcategoria);
            $arrData = $this->model->getArchivosPorCategoria($idcategoria);
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnDownload = '';
                $btnDelete = '';

                // Botón de ver
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewArchivo(' . $arrData[$i]['id'] . ')" title="Ver archivo"><i class="far fa-eye"></i></button>';
                }
                
                // Botón de descargar
                if ($_SESSION['permisosMod']['r']) {
                    $btnDownload = '<a class="btn btn-primary btn-sm" href="' . base_url() . '/uploads/archivos/' . $arrData[$i]['archivo'] . '" download="' . $arrData[$i]['nombre'] . '.' . $arrData[$i]['extension'] . '" title="Descargar"><i class="bi bi-download"></i></a>';
                }
                
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

    public function getPermisosUsuario()
    {
        if ($_SESSION['login']) {
            $permisos = array(
                'r' => $_SESSION['permisosMod']['r'] ?? false,
                'w' => $_SESSION['permisosMod']['w'] ?? false,
                'u' => $_SESSION['permisosMod']['u'] ?? false,
                'd' => $_SESSION['permisosMod']['d'] ?? false
            );
            echo json_encode($permisos, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('r' => false, 'w' => false, 'u' => false, 'd' => false), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>