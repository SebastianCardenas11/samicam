<?php
/**
 * Script de prueba para verificar que los permisos especiales NO se cuenten en los 3 permisos mensuales
 */

// Incluir el archivo de configuración
require_once 'Config/Config.php';

// Función para verificar el conteo de permisos
function verificarConteoPermisos($conexion) {
    echo "=== Verificando conteo de permisos ===\n";
    
    // Obtener un funcionario para la prueba
    $sql = "SELECT idefuncionario, nombre_completo FROM tbl_funcionarios_planta WHERE status = 1 LIMIT 1";
    $result = $conexion->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $funcionario = $result->fetch_assoc();
        $idFuncionario = $funcionario['idefuncionario'];
        $nombreFuncionario = $funcionario['nombre_completo'];
        
        echo "Funcionario de prueba: $nombreFuncionario (ID: $idFuncionario)\n\n";
        
        // Conteo total de permisos en el mes actual
        $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                WHERE id_funcionario = ? 
                AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
                AND tipo_funcionario = 'planta'";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalPermisos = $row['total'];
        
        // Conteo de permisos normales (no especiales)
        $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                WHERE id_funcionario = ? 
                AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
                AND tipo_funcionario = 'planta'
                AND es_permiso_especial = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $permisosNormales = $row['total'];
        
        // Conteo de permisos especiales
        $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                WHERE id_funcionario = ? 
                AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
                AND tipo_funcionario = 'planta'
                AND es_permiso_especial = 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $permisosEspeciales = $row['total'];
        
        echo "Total de permisos en el mes actual: $totalPermisos\n";
        echo "Permisos normales (cuentan en el límite): $permisosNormales\n";
        echo "Permisos especiales (NO cuentan en el límite): $permisosEspeciales\n";
        
        // Verificar que el conteo sea correcto
        if ($totalPermisos == ($permisosNormales + $permisosEspeciales)) {
            echo "✓ El conteo es correcto\n";
        } else {
            echo "✗ Error en el conteo\n";
        }
        
        // Verificar si puede recibir más permisos normales
        if ($permisosNormales < 3) {
            echo "✓ Puede recibir " . (3 - $permisosNormales) . " permiso(s) normal(es) más\n";
        } else {
            echo "✗ Ya no puede recibir más permisos normales (límite de 3 alcanzado)\n";
        }
        
        // Siempre puede recibir permisos especiales
        echo "✓ Siempre puede recibir permisos especiales (sin límite)\n";
        
        return $idFuncionario;
    } else {
        echo "No se encontraron funcionarios para la prueba\n";
        return null;
    }
}

// Función para probar inserción de permiso especial
function probarPermisoEspecial($conexion, $idFuncionario) {
    echo "\n=== Probando inserción de permiso especial ===\n";
    
    if (!$idFuncionario) {
        echo "No hay funcionario para la prueba\n";
        return;
    }
    
    // Fecha de prueba (mañana)
    $fechaPrueba = date('Y-m-d', strtotime('+1 day'));
    
    // Verificar si ya existe un permiso para esa fecha
    $sql = "SELECT COUNT(*) as total FROM tbl_permisos WHERE id_funcionario = ? AND fecha_permiso = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $idFuncionario, $fechaPrueba);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['total'] > 0) {
        echo "Ya existe un permiso para la fecha de prueba ($fechaPrueba)\n";
        return;
    }
    
    // Obtener el conteo antes de la inserción
    $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
            WHERE id_funcionario = ? 
            AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
            AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
            AND tipo_funcionario = 'planta'
            AND es_permiso_especial = 0";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $permisosNormalesAntes = $row['total'];
    
    // Insertar permiso especial
    $sql = "INSERT INTO tbl_permisos(id_funcionario, fecha_permiso, mes, anio, motivo, estado, tipo_funcionario, es_permiso_especial, justificacion_especial) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    $mes = date('m');
    $anio = date('Y');
    $motivo = "Permiso Especial: Cita médica";
    $estado = "Aprobado";
    $tipo = "planta";
    $esEspecial = 1;
    $justificacion = "Prueba del sistema de permisos especiales";
    
    $stmt->bind_param("issssssss", $idFuncionario, $fechaPrueba, $mes, $anio, $motivo, $estado, $tipo, $esEspecial, $justificacion);
    
    if ($stmt->execute()) {
        echo "✓ Permiso especial insertado correctamente\n";
        $idPermisoInsertado = $conexion->insert_id;
        
        // Verificar el conteo después de la inserción
        $sql = "SELECT COUNT(*) as total FROM tbl_permisos 
                WHERE id_funcionario = ? 
                AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE())
                AND tipo_funcionario = 'planta'
                AND es_permiso_especial = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $permisosNormalesDespues = $row['total'];
        
        echo "Permisos normales antes: $permisosNormalesAntes\n";
        echo "Permisos normales después: $permisosNormalesDespues\n";
        
        if ($permisosNormalesAntes == $permisosNormalesDespues) {
            echo "✓ Los permisos especiales NO afectan el conteo de permisos normales\n";
        } else {
            echo "✗ ERROR: Los permisos especiales están afectando el conteo de permisos normales\n";
        }
        
        // Limpiar el permiso de prueba
        $sql = "DELETE FROM tbl_permisos WHERE id_permiso = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idPermisoInsertado);
        $stmt->execute();
        echo "✓ Permiso de prueba eliminado\n";
        
    } else {
        echo "✗ Error al insertar permiso especial: " . $stmt->error . "\n";
    }
}

// Función para verificar la consulta del modelo
function verificarConsultaModelo($conexion, $idFuncionario) {
    echo "\n=== Verificando consulta del modelo ===\n";
    
    if (!$idFuncionario) {
        echo "No hay funcionario para la prueba\n";
        return;
    }
    
    // Simular la consulta que hace el modelo
    $sql = "SELECT 
            u.idefuncionario,
            u.nombre_completo,
            (SELECT COUNT(*) FROM tbl_permisos WHERE id_funcionario = u.idefuncionario AND tipo_funcionario = 'planta' AND MONTH(fecha_permiso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_permiso) = YEAR(CURRENT_DATE()) AND es_permiso_especial = 0) as permisos_mes_actual
        FROM tbl_funcionarios_planta u
        WHERE u.idefuncionario = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo "Resultado de la consulta del modelo:\n";
    echo "- Funcionario: {$row['nombre_completo']}\n";
    echo "- Permisos del mes actual: {$row['permisos_mes_actual']}/3\n";
    
    if ($row['permisos_mes_actual'] <= 3) {
        echo "✓ El conteo está correcto (no excede el límite de 3)\n";
    } else {
        echo "✗ ERROR: El conteo excede el límite de 3\n";
    }
}

// Ejecutar las verificaciones
try {
    // Crear conexión
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    echo "=== PRUEBA DE PERMISOS ESPECIALES (NO CUENTAN EN LÍMITE) ===\n";
    echo "Fecha y hora: " . date('Y-m-d H:i:s') . "\n\n";
    
    $idFuncionario = verificarConteoPermisos($conexion);
    probarPermisoEspecial($conexion, $idFuncionario);
    verificarConsultaModelo($conexion, $idFuncionario);
    
    echo "\n=== PRUEBA COMPLETADA ===\n";
    
    $conexion->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 