<?php
/**
 * Script de prueba simple para WhatsApp
 * Sin respaldo por email para evitar warnings
 */

// Incluir archivos necesarios
require_once "Config/Config.php";
require_once "Config/WhatsAppConfig.php";
require_once "Helpers/WhatsAppHelper.php";

// Configurar manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== PRUEBA SIMPLE DE WHATSAPP ===\n\n";

try {
    // Verificar configuración
    if (!isWhatsAppEnabled()) {
        echo "❌ Las notificaciones de WhatsApp están deshabilitadas\n";
        exit(1);
    }
    
    echo "✅ Notificaciones de WhatsApp habilitadas\n";
    
    // Obtener configuración
    $config = getWhatsAppConfig();
    echo "📱 Proveedor configurado: " . $config['provider'] . "\n";
    echo "🔑 API Key: " . substr($config['callmebot']['api_key'], 0, 4) . "****\n";
    echo "📞 Número específico: " . $config['specific_number'] . "\n";
    
    // Crear instancia del helper
    $whatsappHelper = new WhatsAppHelper();
    echo "✅ WhatsAppHelper inicializado\n";
    
    // Mensaje de prueba
    $testMessage = "🔔 *PRUEBA SIMPLE SAMICAM*\n\n";
    $testMessage .= "¡Hola! Este es un mensaje de prueba simple.\n\n";
    $testMessage .= "📅 Fecha: " . date('d/m/Y H:i:s') . "\n";
    $testMessage .= "🔧 Sistema: SAMICAM\n\n";
    $testMessage .= "¡Configuración exitosa! 🎉";
    
    echo "\n📱 Enviando mensaje a: " . $config['specific_number'] . "\n";
    echo "💬 Mensaje: {$testMessage}\n\n";
    
    // Enviar mensaje
    $result = $whatsappHelper->sendWhatsAppMessage($config['specific_number'], $testMessage);
    
    if ($result) {
        echo "✅ MENSAJE ENVIADO EXITOSAMENTE\n";
        echo "🎉 ¡WhatsApp está funcionando correctamente!\n";
        echo "\n📋 Próximos pasos:\n";
        echo "   1. Verifica que recibiste el mensaje en tu WhatsApp\n";
        echo "   2. Crea una nueva tarea en SAMICAM\n";
        echo "   3. ¡Disfruta de las notificaciones automáticas!\n";
    } else {
        echo "❌ ERROR AL ENVIAR MENSAJE\n";
        echo "🔧 Revisa los logs en uploads/whatsapp_log.txt\n";
        
        // Mostrar últimas líneas del log
        $logFile = 'uploads/whatsapp_log.txt';
        if (file_exists($logFile)) {
            $logs = file_get_contents($logFile);
            $lines = explode("\n", $logs);
            $lastLines = array_slice($lines, -3);
            echo "\n📝 Últimas líneas del log:\n";
            foreach ($lastLines as $line) {
                if (!empty(trim($line))) {
                    echo "   {$line}\n";
                }
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error durante la prueba: " . $e->getMessage() . "\n";
}

echo "\n=== PRUEBA COMPLETADA ===\n";
?> 