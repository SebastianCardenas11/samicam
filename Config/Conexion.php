<?php
class Conexion
{
    private $host = "localhost:3306";
    private $user = "root";
    private $password = "";
    private $db_name = "samicam";
    private $connect;

    public function __construct()
    {
        $this->connect = new mysqli($this->host, $this->user, $this->password, $this->db_name);

        if ($this->connect->connect_error) {
            die("Error de conexión: " . $this->connect->connect_error);
        }
    }

    public function connect()
    {
        return $this->connect;
    }
}
?>
