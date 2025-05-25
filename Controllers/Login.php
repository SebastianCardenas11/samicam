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
        // Crear directorios si no existen
        $dirBase = "uploads/auditoria";
        if (!is_dir($dirBase)) {
            mkdir($dirBase, 0755, true);
        }
        
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');
        
        $dirAnio = $dirBase . "/" . $anio;
        if (!is_dir($dirAnio)) {
            mkdir($dirAnio, 0755);
        }
        
        $dirMes = $dirAnio . "/" . $mes;
        if (!is_dir($dirMes)) {
            mkdir($dirMes, 0755);
        }
        
        // Preparar datos para el registro
        $fecha = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        
        // Crear contenido del log
        $contenido = "[" . $fecha . "] ";
        $contenido .= "ID: " . $userData['ideusuario'] . " | ";
        $contenido .= "Usuario: " . $userData['nombres'] . " | ";
        $contenido .= "Correo: " . $userData['correo'] . " | ";
        $contenido .= "Rol: " . $userData['nombrerol'] . " | ";
        $contenido .= "IP: " . $ip . " | ";
        $contenido .= "Navegador: " . $userAgent . "\n";
        
        // Escribir en archivo
        $archivo = $dirMes . "/log_" . $dia . ".txt";
        file_put_contents($archivo, $contenido, FILE_APPEND);
    }
}