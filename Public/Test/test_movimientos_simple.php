<?php
// Script simple para probar la consulta de movimientos
require_once '../../Libraries/Core/Conexion.php';

try {
    $conexion = new Conexion();
    $con = $conexion->conectar();
    
    echo "<h2>🧪 Prueba Simple de Movimientos</h2>";
    
    // Parámetros de prueba
    $idEquipo = 2;
    $tipoEquipo = 'impresora';
    
    echo "<p><strong>Parámetros:</strong> idEquipo=$idEquipo, tipoEquipo=$tipoEquipo</p>";
    
    // Verificar si la tabla existe
    $sql_check = "SHOW TABLES LIKE 'tbl_equipos_movimientos'";
    $result_check = $con->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        echo "<p style='color: green;'>✅ Tabla existe</p>";
        
        // Probar la consulta exacta
        $sql = "SELECT * FROM tbl_equipos_movimientos WHERE id_equipo = ? AND tipo_equipo = ? ORDER BY fecha_hora DESC";
        
        $stmt = $con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("is", $idEquipo, $tipoEquipo);
            $stmt->execute();
            $result = $stmt->get_result();
            
            echo "<p style='color: green;'>✅ Consulta ejecutada correctamente</p>";
            echo "<p><strong>Registros encontrados:</strong> " . $result->num_rows . "</p>";
            
            if ($result->num_rows > 0) {
                echo "<h3>📋 Resultados:</h3>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>ID</th><th>Equipo</th><th>Tipo</th><th>Movimiento</th><th>Observación</th><th>Fecha</th><th>Usuario</th></tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id_movimiento']}</td>";
                    echo "<td>{$row['id_equipo']}</td>";
                    echo "<td>{$row['tipo_equipo']}</td>";
                    echo "<td>{$row['tipo_movimiento']}</td>";
                    echo "<td>{$row['observacion']}</td>";
                    echo "<td>{$row['fecha_hora']}</td>";
                    echo "<td>{$row['usuario']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: orange;'>⚠️ No hay movimientos para este equipo</p>";
            }
            
            $stmt->close();
        } else {
            echo "<p style='color: red;'>❌ Error al preparar la consulta: " . $con->error . "</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ La tabla tbl_equipos_movimientos NO existe</p>";
    }
    
    // Probar la clase base
    echo "<h3>🔧 Probando clase base:</h3>";
    try {
        require_once '../../Models/InventarioModel.php';
        $model = new InventarioModel();
        echo "<p style='color: green;'>✅ Clase InventarioModel cargada correctamente</p>";
        
        // Probar método del modelo
        $result = $model->getMovimientosEquipo($idEquipo, $tipoEquipo);
        echo "<p style='color: green;'>✅ Método getMovimientosEquipo ejecutado</p>";
        echo "<p><strong>Resultado del modelo:</strong> " . count($result) . " registros</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error en el modelo: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de conexión: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='../../Inventario'>← Volver al módulo de Inventario</a></p>";
?> 