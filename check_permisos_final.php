<?php
require_once "Config/Config.php";

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== VERIFICACIÓN DE PERMISOS ===\n\n";
    
    // Verificar módulos
    echo "MÓDULOS EN BD:\n";
    $sql = "SELECT * FROM modulo ORDER BY idmodulo";
    $result = $pdo->query($sql);
    while($row = $result->fetch()) {
        echo "ID: " . $row['idmodulo'] . " - " . $row['titulo'] . " (Status: " . $row['status'] . ")\n";
    }
    
    // Verificar constantes
    echo "\nCONSTANTES:\n";
    echo "MCARGOS = " . MCARGOS . "\n";
    echo "MTAREAS = " . MTAREAS . "\n";
    echo "MPUBLICACIONES = " . MPUBLICACIONES . "\n";
    echo "MARCHIVOS = " . MARCHIVOS . "\n";
    
    // Verificar permisos del rol 1 (Superadministrador)
    echo "\nPERMISOS DEL ROL 1 (Superadministrador):\n";
    $sql = "SELECT p.*, m.titulo as modulo_nombre 
            FROM permisos p 
            LEFT JOIN modulo m ON p.moduloid = m.idmodulo 
            WHERE p.rolid = 1 
            ORDER BY p.moduloid";
    $result = $pdo->query($sql);
    while($row = $result->fetch()) {
        echo "Módulo " . $row['moduloid'] . " (" . $row['modulo_nombre'] . "): ";
        echo "r=" . $row['r'] . ", w=" . $row['w'] . ", u=" . $row['u'] . ", d=" . $row['d'] . ", v=" . ($row['v'] ?? 1) . "\n";
    }
    
    // Verificar módulos específicos
    echo "\nVERIFICACIÓN ESPECÍFICA:\n";
    $modulos = [
        'MCARGOS' => MCARGOS,
        'MTAREAS' => MTAREAS,
        'MPUBLICACIONES' => MPUBLICACIONES,
        'MARCHIVOS' => MARCHIVOS
    ];
    
    foreach($modulos as $nombre => $id) {
        $sql = "SELECT * FROM permisos WHERE rolid = 1 AND moduloid = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $permiso = $stmt->fetch();
        
        echo "$nombre ($id): ";
        if($permiso) {
            echo "✅ EXISTE - r=" . $permiso['r'] . ", v=" . ($permiso['v'] ?? 1);
        } else {
            echo "❌ NO EXISTE";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>