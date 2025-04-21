<?php
require_once 'Models/UsuarioModel.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel(); // Crear una instancia del modelo
    }

    // Mostrar todos los usuarios
    public function index() {
        $usuarios = $this->usuarioModel->getUsuarios(); // Obtener los usuarios
        require_once 'Views/usuarios/index.php'; // Cargar la vista
    }

    // Crear un nuevo usuario
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];
            $idrol = $_POST['idrol'];
            $status = 1; // Usuario activo

            $this->usuarioModel->insertarUsuario($nombre, $correo, $contraseña, $idrol, $status); // Insertar usuario
            header("Location: index.php?controller=usuario&action=index"); // Redirigir al listado de usuarios
        } else {
            require_once 'Views/usuarios/crear.php'; // Cargar la vista para crear usuario
        }
    }

    // Actualizar un usuario
    public function actualizar($idusuario) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos del formulario
            $contraseña = $_POST['contraseña'];
            $status = $_POST['status'];

            // Encriptar la contraseña solo si se proporciona una nueva
            if (!empty($contraseña)) {
                $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);  // Encriptar con bcrypt
            }

            // Actualizar usuario
            $this->usuarioModel->actualizarUsuario($idusuario, $contraseña, $status);
            header("Location: index.php?controller=usuario&action=index");
        } else {
            // Cargar datos del usuario para mostrar en el formulario
            require_once 'Views/usuarios/editar.php';
        }
    }

    // Eliminar un usuario (cambiar status a 0)
    public function eliminar($idusuario) {
        $this->usuarioModel->eliminarUsuario($idusuario);
        header("Location: index.php?controller=usuario&action=index");
    }
}
?>
