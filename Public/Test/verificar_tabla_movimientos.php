<?php
// Script para verificar y crear la tabla tbl_equipos_movimientos
require_once '../../Libraries/Core/Conexion.php';

try {
    $conexion = new Conexion();
    $con = $conexion->conectar();
    
    echo "<h2>🔍 Verificando tabla tbl_equipos_movimientos</h2>";
    
    // Verificar si la tabla existe
    $sql_check = "SHOW TABLES LIKE 'tbl_equipos_movimientos'";
    $result = $con->query($sql_check);
    
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✅ La tabla tbl_equipos_movimientos ya existe.</p>";
        
        // Contar registros
        $sql_count = "SELECT COUNT(*) as total FROM tbl_equipos_movimientos";
        $count_result = $con->query($sql_count);
        $count = $count_result->fetch_assoc()['total'];
        echo "<p>📊 Total de registros: $count</p>";
        
        // Mostrar algunos registros de ejemplo
        $sql_sample = "SELECT * FROM tbl_equipos_movimientos ORDER BY fecha_hora DESC LIMIT 5";
        $sample_result = $con->query($sql_sample);
        
        if ($sample_result->num_rows > 0) {
            echo "<h3>📋 Últimos 5 movimientos:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Equipo</th><th>Tipo</th><th>Movimiento</th><th>Observación</th><th>Fecha</th><th>Usuario</th></tr>";
            
            while ($row = $sample_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_movimiento']}</td>";
                echo "<td>{$row['id_equipo']} ({$row['tipo_equipo']})</td>";
                echo "<td>{$row['tipo_equipo']}</td>";
                echo "<td>{$row['tipo_movimiento']}</td>";
                echo "<td>{$row['observacion']}</td>";
                echo "<td>{$row['fecha_hora']}</td>";
                echo "<td>{$row['usuario']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: orange;'>⚠️ La tabla existe pero no tiene registros.</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ La tabla tbl_equipos_movimientos NO existe. Creándola...</p>";
        
        // Crear la tabla
        $sql_create = "
        CREATE TABLE `tbl_equipos_movimientos` (
          `id_movimiento` INT NOT NULL AUTO_INCREMENT,
          `id_equipo` INT NOT NULL,
          `tipo_equipo` ENUM('impresora','pc_torre','todo_en_uno','portatil','escaner','herramienta','otro') NOT NULL,
          `tipo_movimiento` ENUM('entrada','salida') NOT NULL,
          `observacion` TEXT,
          `fecha_hora` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `usuario` VARCHAR(100) NOT NULL,
          PRIMARY KEY (`id_movimiento`),
          KEY `idx_equipo` (`id_equipo`, `tipo_equipo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        
        if ($con->query($sql_create) === TRUE) {
            echo "<p style='color: green;'>✅ Tabla creada exitosamente.</p>";
            
            // Insertar datos de ejemplo
            $sql_insert = "
            INSERT INTO `tbl_equipos_movimientos` (`id_equipo`, `tipo_equipo`, `tipo_movimiento`, `observacion`, `usuario`) VALUES
            (1, 'impresora', 'entrada', 'Mantenimiento preventivo', 'Sistema'),
            (1, 'impresora', 'salida', 'Mantenimiento completado', 'Sistema'),
            (2, 'pc_torre', 'entrada', 'Reparación de disco duro', 'Sistema'),
            (3, 'portatil', 'entrada', 'Cambio de teclado', 'Sistema');
            ";
            
            if ($con->query($sql_insert) === TRUE) {
                echo "<p style='color: green;'>✅ Datos de ejemplo insertados.</p>";
            } else {
                echo "<p style='color: orange;'>⚠️ Error al insertar datos de ejemplo: " . $con->error . "</p>";
            }
            
        } else {
            echo "<p style='color: red;'>❌ Error al crear la tabla: " . $con->error . "</p>";
        }
    }
    
    // Verificar permisos de sesión
    echo "<h3>🔐 Verificando permisos de sesión:</h3>";
    session_start();
    if (isset($_SESSION['permisosMod']['r'])) {
        echo "<p style='color: green;'>✅ Permisos de lectura activos</p>";
    } else {
        echo "<p style='color: red;'>❌ No hay permisos de lectura</p>";
    }
    
    // Probar la consulta del modelo
    echo "<h3>🧪 Probando consulta del modelo:</h3>";
    $sql_test = "SELECT * FROM tbl_equipos_movimientos WHERE id_equipo = 1 AND tipo_equipo = 'impresora' ORDER BY fecha_hora DESC";
    $test_result = $con->query($sql_test);
    
    if ($test_result) {
        echo "<p style='color: green;'>✅ Consulta ejecutada correctamente. Resultados: " . $test_result->num_rows . " registros</p>";
    } else {
        echo "<p style='color: red;'>❌ Error en la consulta: " . $con->error . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='../../Inventario'>← Volver al módulo de Inventario</a></p>";
?> 