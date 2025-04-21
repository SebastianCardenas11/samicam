<?php
require_once 'Libraries/Database.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        $this->db = new Database();  // Conectamos con la base de datos
    }

    // Obtener todos los usuarios
    public function getUsuarios() {
        $query = "SELECT * FROM usuarios WHERE status = 1"; // Solo usuarios activos
        $stmt = $this->db->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna los resultados
    }

    // Insertar un nuevo usuario
    public function insertarUsuario($nombre, $correo, $contraseña, $idrol, $status) {
        $query = "INSERT INTO usuarios (nombre, correo, contraseña, idrol, status) 
                  VALUES (:nombre, :correo, :contraseña, :idrol, :status)";
        
        $stmt = $this->db->connect()->prepare($query);
        
        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contraseña', $contraseña_encriptada);
        $stmt->bindParam(':idrol', $idrol);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute(); // Ejecutar la inserción
    }

    // Actualizar un usuario (solo la contraseña y el status)
    public function actualizarUsuario($idusuario, $contraseña, $status) {
        $query = "UPDATE usuarios SET contraseña = :contraseña, status = :status WHERE idusuario = :idusuario";
        $stmt = $this->db->connect()->prepare($query);

        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':contraseña', $contraseña_encriptada);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':idusuario', $idusuario);

        return $stmt->execute(); // Ejecutar la actualización
    }

    // Eliminar un usuario (cambiar status a 0)
    public function eliminarUsuario($idusuario) {
        $query = "UPDATE usuarios SET status = 0 WHERE idusuario = :idusuario"; // No borramos físicamente el usuario, solo lo desactivamos
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':idusuario', $idusuario);
        return $stmt->execute(); // Ejecutar la eliminación
    }
}
?>
