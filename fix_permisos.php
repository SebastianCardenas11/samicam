<?php
require_once "Config/Config.php";

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Listando todas las tablas:\n";
    $result = $pdo->query("SHOW TABLES");
    while($row = $result->fetch()) {
        echo "- " . $row[0] . "\n";
    }
    
    echo "\nBuscando tablas relacionadas con permisos:\n";
    $result = $pdo->query("SHOW TABLES");
    while($row = $result->fetch()) {
        $table = $row[0];
        if(stripos($table, 'rol') !== false || stripos($table, 'modulo') !== false || stripos($table, 'permiso') !== false) {
            echo "✅ Encontrada: $table\n";
            
            // Mostrar estructura
            $desc = $pdo->query("DESCRIBE $table");
            while($col = $desc->fetch()) {
                echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>