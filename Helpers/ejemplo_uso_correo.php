<?php
/**
 * Ejemplo de uso de la función enviarCorreoTareaAsignada
 */
require_once 'enviar_correo.php';

// Ejemplo de datos de tarea
$datosTarea = [
    'titulo' => 'Revisión de documentación',
    'descripcion' => 'Revisar y actualizar la documentación del módulo de usuarios',
    'fecha_inicio' => '15 de noviembre de 2023',
    'fecha_fin' => '30 de noviembre de 2023',
    'prioridad' => 'Alta',
    'url_tarea' => 'https://localhost/samicam/tareas/ver/123'
];

// Enviar correo
$resultado = enviarCorreoTareaAsignada(
    'correo@ejemplo.com',  // Email del usuario
    'Juan Pérez',          // Nombre del usuario
    $datosTarea            // Datos de la tarea
);

if ($resultado) {
    echo "Correo enviado correctamente";
} else {
    echo "Error al enviar el correo";
}