<?php
require_once "Config/Config.php";

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>Verificando Permisos en Base de Datos</h3>";
    
    // Verificar módulos
    echo "<h4>Módulos en BD:</h4>";
    $sql = "SELECT * FROM tbl_modulo ORDER BY idmodulo";
    $result = $pdo->query($sql);
    while($row = $result->fetch()) {
        echo "ID: " . $row['idmodulo'] . " - " . $row['titulo'] . " (Status: " . $row['status'] . ")<br>";
    }
    
    // Verificar permisos del usuario ID 1 (Superadministrador)
    echo "<br><h4>Permisos del Usuario ID 1:</h4>";
    $sql = "SELECT p.*, m.titulo as modulo_nombre 
            FROM tbl_permisos p 
            LEFT JOIN tbl_modulo m ON p.moduloid = m.idmodulo 
            WHERE p.rolid = 1 
            ORDER BY p.moduloid";
    $result = $pdo->query($sql);
    while($row = $result->fetch()) {
        echo "Módulo " . $row['moduloid'] . " (" . $row['modulo_nombre'] . "): ";
        echo "r=" . $row['r'] . ", w=" . $row['w'] . ", u=" . $row['u'] . ", d=" . $row['d'] . "<br>";
    }
    
    // Verificar constantes específicas
    echo "<br><h4>Verificación de Constantes:</h4>";
    $constantes = [
        'MCARGOS' => MCARGOS,
        'MTAREAS' => MTAREAS, 
        'MPUBLICACIONES' => MPUBLICACIONES,
        'MARCHIVOS' => MARCHIVOS
    ];
    
    foreach($constantes as $nombre => $valor) {
        $sql = "SELECT * FROM tbl_permisos WHERE rolid = 1 AND moduloid = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$valor]);
        $permiso = $stmt->fetch();
        
        echo "$nombre ($valor): ";
        if($permiso) {
            echo "✅ Existe - r=" . $permiso['r'] . ", w=" . $permiso['w'] . ", u=" . $permiso['u'] . ", d=" . $permiso['d'];
        } else {
            echo "❌ No existe en BD";
        }
        echo "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>