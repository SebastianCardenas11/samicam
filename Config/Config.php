<?php
define('BASE_URL', "http://localhost/SamiCAM");

//Zona horaria
date_default_timezone_set('America/Bogota');

//Datos de conexión a Base de Datos
define('DB_HOST', 'localhost:3306'); // Servidor de la BD
define('DB_USER', 'root'); // Usuario de la BD (cámbialo si es necesario)
define('DB_PASSWORD', ''); // Contraseña de la BD (déjala vacía si no tiene)
define('DB_NAME', 'samicam'); // Nombre de la base de datos
define('DB_CHARSET', 'utf8mb4'); // Codificación de caracteres

// Ruta a la carpeta de vistas
define('VIEWS', 'Views/');
?>
