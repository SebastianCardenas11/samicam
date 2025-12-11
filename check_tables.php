<?php
require_once "Config/Config.php";

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Verificando tablas de permisos:\n";
    
    $tables = ['tbl_modulo', 'tbl_permisos', 'tbl_rol'];
    foreach($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if($result->rowCount() > 0) {
            echo "✅ $table existe\n";
            
            if($table == 'tbl_modulo') {
                $result = $pdo->query("SELECT * FROM $table ORDER BY idmodulo");
                while($row = $result->fetch()) {
                    echo "  - ID: " . $row['idmodulo'] . " - " . $row['titulo'] . "\n";
                }
            }
        } else {
            echo "❌ $table NO existe\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>