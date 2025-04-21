<?php

require_once "Libraries/Core/Controllers.php"; // Asegura que la clase base se carga

class LoginController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // Cargar la vista del formulario de login
        $this->view->display('Login/login');
    }
    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = trim($_POST['txtCorreo']);
            $password = trim($_POST['txtPassword']);

            if (!empty($correo) && !empty($password)) {
                // Verificar si existe el usuario
                $user = $this->model->getUserByEmail($correo);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['idusuario'];
                    $_SESSION['user_role'] = $user['idrol_fk'];
                    echo json_encode(['status' => true, 'msg' => 'Login exitoso']);

                } else {
                    echo json_encode(['status' => false, 'msg' => 'Credenciales incorrectas']);
                }
            } else {
                echo json_encode(['status' => false, 'msg' => 'Todos los campos son obligatorios']);
            }
        }
        die();
    }
}
?>


