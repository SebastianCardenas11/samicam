<?php
session_start();
require_once "Config/Config.php";

echo "<h3>Verificando Permisos del Usuario</h3>";

if(isset($_SESSION['userData'])) {
    echo "<strong>Usuario:</strong> " . $_SESSION['userData']['nombres'] . "<br>";
    echo "<strong>Rol:</strong> " . $_SESSION['userData']['nombrerol'] . "<br><br>";
    
    echo "<h4>Constantes de Módulos:</h4>";
    echo "MCARGOS = " . MCARGOS . "<br>";
    echo "MTAREAS = " . MTAREAS . "<br>";
    echo "MPUBLICACIONES = " . MPUBLICACIONES . "<br>";
    echo "MARCHIVOS = " . MARCHIVOS . "<br><br>";
    
    echo "<h4>Permisos en Sesión:</h4>";
    if(isset($_SESSION['permisos'])) {
        foreach($_SESSION['permisos'] as $modulo => $permisos) {
            echo "<strong>Módulo $modulo:</strong> ";
            if(is_array($permisos)) {
                echo "r=" . (isset($permisos['r']) ? $permisos['r'] : '0') . ", ";
                echo "w=" . (isset($permisos['w']) ? $permisos['w'] : '0') . ", ";
                echo "u=" . (isset($permisos['u']) ? $permisos['u'] : '0') . ", ";
                echo "d=" . (isset($permisos['d']) ? $permisos['d'] : '0') . ", ";
                echo "v=" . (isset($permisos['v']) ? $permisos['v'] : '1');
            }
            echo "<br>";
        }
    } else {
        echo "No hay permisos en sesión<br>";
    }
    
    echo "<br><h4>Verificación Específica:</h4>";
    $modulos_check = [MCARGOS, MTAREAS, MPUBLICACIONES, MARCHIVOS];
    foreach($modulos_check as $mod) {
        $tiene_permiso = (!empty($_SESSION['permisos'][$mod]['r']) && (!isset($_SESSION['permisos'][$mod]['v']) || $_SESSION['permisos'][$mod]['v'] == 1));
        echo "Módulo $mod: " . ($tiene_permiso ? "✅ SÍ" : "❌ NO") . "<br>";
    }
    
} else {
    echo "No hay sesión activa<br>";
}
?>