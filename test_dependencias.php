<?php
require_once "Config/Config.php";

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>Testing Dependencias</h3>";
    
    // Check if table exists
    $result = $pdo->query("SHOW TABLES LIKE 'tbl_dependencia'");
    if($result->rowCount() > 0) {
        echo "✅ Table tbl_dependencia exists<br>";
        
        // Check table structure
        $result = $pdo->query("DESCRIBE tbl_dependencia");
        echo "<h4>Table Structure:</h4>";
        while($row = $result->fetch()) {
            echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
        }
        
        // Test query
        $sql = "SELECT dependencia_pk as id, nombre FROM tbl_dependencia ORDER BY nombre";
        $result = $pdo->query($sql);
        echo "<h4>Data:</h4>";
        while($row = $result->fetch()) {
            echo "ID: " . $row['id'] . " - Nombre: " . $row['nombre'] . "<br>";
        }
        
    } else {
        echo "❌ Table tbl_dependencia missing<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>