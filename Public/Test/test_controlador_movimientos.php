<?php
// Script que simula exactamente el controlador
session_start();

// Simular permisos de sesión
$_SESSION['permisosMod']['r'] = 1;

// Parámetros de la URL
$idEquipo = 2;
$tipoEquipo = 'impresora';

echo "<h2>🧪 Simulando Controlador getMovimientosEquipo</h2>";
echo "<p><strong>Parámetros:</strong> idEquipo=$idEquipo, tipoEquipo=$tipoEquipo</p>";

try {
    // Validar permisos
    if (!isset($_SESSION['permisosMod']['r'])) {
        echo "<p style='color: red;'>❌ No tiene permisos para esta acción</p>";
        die();
    }
    echo "<p style='color: green;'>✅ Permisos validados</p>";
    
    // Limpiar y validar parámetros
    $idEquipo = intval($idEquipo);
    $tipoEquipo = trim($tipoEquipo);
    
    echo "<p><strong>Parámetros limpios:</strong> idEquipo=$idEquipo, tipoEquipo='$tipoEquipo'</p>";
    
    if ($idEquipo <= 0) {
        echo "<p style='color: red;'>❌ ID de equipo inválido</p>";
        die();
    }
    echo "<p style='color: green;'>✅ ID de equipo válido</p>";
    
    // Validar tipo de equipo
    $tiposValidos = ['impresora', 'escaner', 'pc_torre', 'todo_en_uno', 'portatil', 'herramienta', 'otro'];
    if (!in_array($tipoEquipo, $tiposValidos)) {
        echo "<p style='color: red;'>❌ Tipo de equipo inválido: $tipoEquipo</p>";
        die();
    }
    echo "<p style='color: green;'>✅ Tipo de equipo válido</p>";
    
    // Cargar el modelo
    echo "<p>Cargando modelo...</p>";
    require_once '../../Models/InventarioModel.php';
    $model = new InventarioModel();
    echo "<p style='color: green;'>✅ Modelo cargado</p>";
    
    // Obtener datos
    echo "<p>Llamando al modelo...</p>";
    $arrData = $model->getMovimientosEquipo($idEquipo, $tipoEquipo);
    echo "<p style='color: green;'>✅ Modelo ejecutado</p>";
    
    // Asegurar que sea un array
    if (!is_array($arrData)) {
        echo "<p style='color: orange;'>⚠️ getMovimientosEquipo no devolvió un array, convirtiendo...</p>";
        $arrData = [];
    }
    
    echo "<p><strong>Datos obtenidos:</strong> " . count($arrData) . " registros</p>";
    
    // Simular respuesta JSON
    $response = [
        'status' => true,
        'msg' => '',
        'data' => $arrData
    ];
    
    echo "<h3>📋 Respuesta JSON:</h3>";
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    
    if (count($arrData) > 0) {
        echo "<h3>📊 Datos de movimientos:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Equipo</th><th>Tipo</th><th>Movimiento</th><th>Observación</th><th>Fecha</th><th>Usuario</th></tr>";
        
        foreach ($arrData as $mov) {
            echo "<tr>";
            echo "<td>{$mov['id_movimiento']}</td>";
            echo "<td>{$mov['id_equipo']}</td>";
            echo "<td>{$mov['tipo_equipo']}</td>";
            echo "<td>{$mov['tipo_movimiento']}</td>";
            echo "<td>{$mov['observacion']}</td>";
            echo "<td>{$mov['fecha_hora']}</td>";
            echo "<td>{$mov['usuario']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠️ No hay movimientos para mostrar</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Stack trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><a href='../../Inventario'>← Volver al módulo de Inventario</a></p>";
?> 