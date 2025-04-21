<?php

spl_autoload_register(function ($class) {
    // Prefijo del namespace base (opcional)
    $base_dir = __DIR__ . '/../';

    // Reemplazar separadores de namespace por separadores de directorio
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    // Si el archivo existe, requerirlo
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Manejo de error mejorado
        error_log("Autoload: No se pudo cargar la clase $class desde $file");
    }
});
?>
