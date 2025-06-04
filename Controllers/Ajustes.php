<?php
class Ajustes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
            die();
        }
        $this->model = new AjustesModel();
    }

    public function ajustes()
    {
        $data['page_tag'] = "Ajustes de Perfil";
        $data['page_title'] = "Ajustes de Perfil";
        $data['page_name'] = "ajustes";
        $data['page_functions_js'] = "functions_ajustes.js";
        $data['usuario'] = $_SESSION['userData'];
        $this->views->getView($this,"ajustes",$data);
    }

    public function actualizarPerfil()
    {
        $idUser = $_SESSION['idUser'];
        $nombre = isset($_POST['nombre']) ? strClean($_POST['nombre']) : '';
        $foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
        $arrResponse = array('status' => false, 'msg' => 'Error al actualizar el perfil.');

        if($nombre == ''){
            $arrResponse['msg'] = 'El nombre no puede estar vacío.';
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        // Actualizar nombre
        $request = $this->model->actualizarNombre($idUser, $nombre);
        if($request){
            $_SESSION['userData']['nombres'] = $nombre;
        }

        // Actualizar foto si se subió
        if($foto && $foto['error'] == 0){
            $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
            $nombreArchivo = 'perfil_'.$idUser.'.'.$ext;
            $ruta = 'uploads/perfiles/'.$nombreArchivo;
            if(!is_dir('uploads/perfiles')){
                mkdir('uploads/perfiles', 0755, true);
            }
            if(move_uploaded_file($foto['tmp_name'], $ruta)){
                $this->model->actualizarFoto($idUser, $nombreArchivo);
                $_SESSION['userData']['imgperfil'] = $nombreArchivo;
                $arrResponse['status'] = true;
                $arrResponse['msg'] = 'Perfil actualizado correctamente.';
            }else{
                $arrResponse['msg'] = 'No se pudo guardar la foto.';
            }
        }else if($request){
            $arrResponse['status'] = true;
            $arrResponse['msg'] = 'Perfil actualizado correctamente.';
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
} 