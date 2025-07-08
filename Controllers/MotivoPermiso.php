<?php

class MotivoPermiso extends Controllers
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

    public function MotivoPermiso()
    {
        $data['page_tag'] = "Gestión de Motivos";
        $data['page_title'] = "Motivos de Permisos";
        $data['page_name'] = "motivos";
        $data['page_functions_js'] = "functions_motivos.js";
        
        $this->views->getView($this, "motivos", $data);
    }

    public function getMotivos()
    {
        require_once 'Models/PermisosModel.php';
        $permisosModel = new PermisosModel();
        $motivos = $permisosModel->getMotivos();
        echo json_encode($motivos);
        die();
    }

    public function setMotivo()
    {
        if ($_POST) {
            $id = !empty($_POST['id_motivo']) ? intval($_POST['id_motivo']) : 0;
            $nombre = strClean($_POST['nombre']);
            $descripcion = strClean($_POST['descripcion']);
            $status = intval($_POST['status']);

            require_once 'Models/PermisosModel.php';
            $permisosModel = new PermisosModel();
            
            if ($id == 0) {
                $resultado = $permisosModel->insertMotivo($nombre, $descripcion, $status);
                $msg = $resultado ? 'Motivo creado correctamente' : 'Error al crear el motivo';
            } else {
                $resultado = $permisosModel->updateMotivo($id, $nombre, $descripcion, $status);
                $msg = $resultado ? 'Motivo actualizado correctamente' : 'Error al actualizar el motivo';
            }
            
            echo json_encode(['status' => $resultado, 'msg' => $msg]);
        }
        die();
    }

    public function getMotivo(int $id)
    {
        if ($id > 0) {
            require_once 'Models/PermisosModel.php';
            $permisosModel = new PermisosModel();
            $motivo = $permisosModel->selectMotivo($id);
            echo json_encode($motivo);
        }
        die();
    }

    public function delMotivo()
    {
        if ($_POST) {
            $id = intval($_POST['id_motivo']);
            require_once 'Models/PermisosModel.php';
            $permisosModel = new PermisosModel();
            $resultado = $permisosModel->deleteMotivo($id);
            $msg = $resultado ? 'Motivo eliminado correctamente' : 'Error al eliminar el motivo';
            echo json_encode(['status' => $resultado, 'msg' => $msg]);
        }
        die();
    }
}