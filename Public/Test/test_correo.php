<?php
require_once 'Helpers/enviar_correo.php';

// Datos de prueba
$emailUsuario = 'carloslxpxz@gmail.com'; // Cambia por tu email
$nombreUsuario = 'Usuario de Prueba';
$datosTarea = [
    'titulo' => 'Tarea de prueba',
    'fecha_inicio' => '2025-01-15',
    'fecha_fin' => '2025-01-20',
    'prioridad' => 'Alta'
];

echo "Enviando correo de prueba...\n";

$resultado = enviarCorreoTareaAsignada($emailUsuario, $nombreUsuario, $datosTarea);

if ($resultado) {
    echo "✅ Correo enviado exitosamente\n";
} else {
    echo "❌ Error al enviar correo\n";
}
?>