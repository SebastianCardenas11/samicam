<?php
class FuncionariosOpsPermisos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MFUNCIONARIOSOPS);
    }

    public function funcionariosOpsPermisos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Funcionarios OPS";
        $data['page_title'] = "FUNCIONARIOS OPS";
        $data['page_name'] = "funcionarios_ops";
        $data['page_functions_js'] = "functions_funcionarios_ops_permisos.js";
        $this->views->getView($this, "funcionariosOpsPermisos", $data);
    }

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idefuncionario'] . ')" title="Ver funcionario"><i class="far fa-eye"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFuncionario($idFuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idFuncionario = intval($idFuncionario);
            if ($idFuncionario > 0) {
                $arrData = $this->model->selectFuncionario($idFuncionario);
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

    public function getMotivosPermisos()
    {
        $arrData = $this->model->getMotivosPermisos();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
}