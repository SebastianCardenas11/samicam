<?php
class ProductoModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarProductos($query) {
        $sql = "SELECT nombre FROM productos WHERE nombre LIKE :query LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%".$query."%";
        $stmt->bindParam(':query', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>