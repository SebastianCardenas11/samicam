<?php
require_once 'Config/Config.php';
require_once 'Libraries/Core/Conexion.php';

try {
    // Crear conexión directa para pruebas
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexión exitosa a la base de datos<br>";
    
    // Intentar insertar un registro de prueba en tbl_funcionarios_planta
    $stmt = $conn->prepare("INSERT INTO tbl_funcionarios_planta(
        correo_elc, nombre_completo, imagen, status, nm_identificacion,
        cargo_fk, dependencia_fk, contrato_fk, celular, direccion, fecha_ingreso,
        hijos, nombres_de_hijos, sexo, lugar_de_residencia,
        edad, estado_civil, religion, formacion_academica, nombre_formacion,
        periodos_vacaciones)
    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    $datos = array(
        'test@test.com',
        'Usuario Prueba',
        'sinimagen.png',
        1,
        '12345',
        33, // cargo_fk
        1,  // dependencia_fk
        1,  // contrato_fk
        '123456789',
        'Dirección de prueba',
        date('Y-m-d'),
        0,
        '',
        'masculino',
        'Ciudad',
        30,
        'soltero',
        'ninguna',
        'universitario',
        'Ingeniería',
        0  // periodos_vacaciones
    );
    
    $result = $stmt->execute($datos);
    

    
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>