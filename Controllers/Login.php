<?php

class Login extends Controllers
{
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . '/dashboard');
            die();
        }
        parent::__construct();
    }

    public function login()
    {
        $data['page_tag'] = "Iniciar Sesión - Samicam";
        $data['page_title'] = "samicam";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login", $data);
    }

    public function loginUser()
    {
        // dep($_POST);
        if ($_POST) {
            if (empty($_POST['txtIdentificacion']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strCorreo = strtolower(strClean($_POST['txtIdentificacion']));
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strCorreo, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'Las credenciales son incorrectas');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['status'] == 1) {
                        $_SESSION['idUser'] = $arrData['ideusuario'];
                        $_SESSION['login'] = true;
                        // Inicializar variables para control de auditoría
                        $_SESSION['auditoria_accessed'] = false;
                        
                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        sessionUser($_SESSION['idUser']);
                        
                        // Registrar inicio de sesión en archivo de auditoría
                        $this->registrarAuditoria($arrData);
                        
                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    /**
     * Registra el inicio de sesión en archivos de auditoría
     */
    private function registrarAuditoria($userData)
    {
        require_once "Models/AuditoriaModel.php";
        $auditoriaModel = new AuditoriaModel();
        
        return $auditoriaModel->registrarInicioSesion(
            $userData['ideusuario'],
            $userData['correo'],
            $userData['nombres'],
            $userData['nombrerol']
        );
    }
}