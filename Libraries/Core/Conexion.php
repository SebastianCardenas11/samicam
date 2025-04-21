<?php
require_once "Config/Config.php"; // Importamos la configuración

class Database {
    private $conexion;
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $db = DB_NAME;
    private $charset = DB_CHARSET;

    public function __construct() {
        try {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
            $this->conexion = new PDO($dsn, $this->user, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function connect() {
        return $this->conexion;
    }
}
?>
