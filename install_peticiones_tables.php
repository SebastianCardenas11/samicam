<?php
// Script para crear las tablas necesarias para el módulo de peticiones
require_once "Config/Config.php";

echo "<h2>Instalación de Tablas del Módulo de Peticiones</h2>";

try {
    $connectionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($connectionString, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Conexión exitosa a la base de datos</p>";
    
    // Crear tabla de tipos de petición si no existe
    $sql_tipos = "
    CREATE TABLE IF NOT EXISTS `tbl_tipos_peticion` (
        `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
        `nombre` varchar(100) NOT NULL,
        `descripcion` text DEFAULT NULL,
        `dias_habiles_plazo` int(11) NOT NULL DEFAULT 15,
        `status` tinyint(1) NOT NULL DEFAULT 1,
        `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id_tipo`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    
    $pdo->exec($sql_tipos);
    echo "<p style='color: green;'>✓ Tabla tbl_tipos_peticion creada/verificada</p>";
    
    // Insertar tipos de petición básicos si no existen
    $tipos_basicos = [
        ['Petición', 'Solicitud de información o servicios', 15],
        ['Queja', 'Manifestación de inconformidad', 15],
        ['Reclamo', 'Solicitud de corrección o revisión', 15],
        ['Sugerencia', 'Propuesta de mejora', 30],
        ['Denuncia', 'Reporte de irregularidades', 15]
    ];
    
    foreach ($tipos_basicos as $tipo) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM tbl_tipos_peticion WHERE nombre = ?");
        $check->execute([$tipo[0]]);
        
        if ($check->fetchColumn() == 0) {
            $insert = $pdo->prepare("INSERT INTO tbl_tipos_peticion (nombre, descripcion, dias_habiles_plazo) VALUES (?, ?, ?)");
            $insert->execute($tipo);
            echo "<p style='color: blue;'>+ Tipo de petición '{$tipo[0]}' agregado</p>";
        }
    }
    
    // Verificar si la tabla tbl_peticiones existe
    $check_peticiones = $pdo->query("SHOW TABLES LIKE 'tbl_peticiones'");
    if ($check_peticiones->rowCount() == 0) {
        echo "<p style='color: red;'>✗ La tabla tbl_peticiones no existe. Necesita ejecutar el script SQL completo.</p>";
        echo "<p>Por favor, importe el archivo: <strong>Public/sql/install_peticiones.sql</strong></p>";
    } else {
        echo "<p style='color: green;'>✓ Tabla tbl_peticiones existe</p>";
        
        // Verificar datos
        $count = $pdo->query("SELECT COUNT(*) FROM tbl_peticiones")->fetchColumn();
        echo "<p>Total de peticiones en la base de datos: $count</p>";
    }
    
    echo "<hr>";
    echo "<p style='color: green;'><strong>Instalación completada exitosamente</strong></p>";
    echo "<p><a href='index.php'>Ir al sistema</a> | <a href='index.php?url=peticiones'>Ir a Peticiones</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>