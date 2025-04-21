<?php
require_once "Config/Conexion.php"; // Asegura que se carga la conexión antes de usarla

class Mysql extends Conexion
{
    private $conexion;
    private $query;
    private $arrValues;

    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre (Conexion)
        $this->conexion = $this->connect(); // Obtiene la conexión de la clase padre
    }

    // Método para ejecutar consultas SELECT
    public function select(string $query)
    {
        $this->query = $this->conexion->query($query);
        return $this->query->fetch_assoc(); // Devuelve un solo registro
    }

    // Método para ejecutar consultas con múltiples registros
    public function selectAll(string $query)
    {
        $this->query = $this->conexion->query($query);
        $result = array();
        while ($row = $this->query->fetch_assoc()) {
            $result[] = $row;
        }
        return $result; // Devuelve un array con todos los registros
    }

    // Método para ejecutar INSERT, UPDATE, DELETE
    public function query(string $query, array $arrValues)
    {
        $stmt = $this->conexion->prepare($query);
        if ($stmt) {
            $stmt->bind_param(str_repeat("s", count($arrValues)), ...$arrValues);
            $stmt->execute();
            return $stmt->affected_rows; // Devuelve el número de filas afectadas
        }
        return false;
    }
}
?>
