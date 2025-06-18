<?php

/**
 * Configuración para notificaciones de WhatsApp
 * 
 * Este archivo contiene la configuración necesaria para enviar
 * notificaciones automáticas de WhatsApp cuando se crean tareas.
 */

// Configuración de WhatsApp
define('WHATSAPP_ENABLED', true); // Habilitar/deshabilitar notificaciones de WhatsApp
define('WHATSAPP_PROVIDER', 'callmebot'); // callmebot, whatsapp_business, wamr

// Configuración para envío a número específico
define('WHATSAPP_SEND_TO_SPECIFIC_NUMBER', true); // Enviar a número específico
define('WHATSAPP_SPECIFIC_NUMBER', '+573018467581'); // Número específico para recibir todas las notificaciones

// Configuración para Callmebot (Gratuito)
define('CALLMEBOT_API_KEY', '2206726'); // Tu API key de Callmebot
define('CALLMEBOT_API_URL', 'https://api.callmebot.com/whatsapp.php');

// Números alternativos de Callmebot si el principal no responde
define('CALLMEBOT_ALTERNATIVE_NUMBERS', [
    '+34 644 51 95 23',  // Número principal
    '+34 644 51 95 24',  // Número alternativo 1
    '+34 644 51 95 25',  // Número alternativo 2
    '+34 644 51 95 26'   // Número alternativo 3
]);

// Configuración para WhatsApp Business API (Gratuito para desarrollo)
define('WHATSAPP_BUSINESS_TOKEN', ''); // Tu token de WhatsApp Business
define('WHATSAPP_PHONE_NUMBER_ID', ''); // Tu Phone Number ID

// Configuración para WAMR (Gratuito con límites)
define('WAMR_API_KEY', ''); // Tu API key de WAMR
define('WAMR_API_URL', 'https://api.wamr.com/v1/message');

// Configuración general
define('WHATSAPP_MESSAGE_TEMPLATE', true); // Usar plantilla de mensaje
define('WHATSAPP_RETRY_ATTEMPTS', 3); // Número de intentos de reenvío
define('WHATSAPP_RETRY_DELAY', 5); // Segundos entre intentos

// Configuración de mensajes
define('WHATSAPP_MESSAGE_PREFIX', '🔔 *SAMICAM - Nueva Tarea*');
define('WHATSAPP_MESSAGE_SUFFIX', '💻 Accede al sistema para más detalles.');

// Configuración de números de teléfono
define('DEFAULT_COUNTRY_CODE', '57'); // Código de país por defecto (Colombia)
define('PHONE_NUMBER_FORMAT', 'international'); // international, national

// Configuración de logs
define('WHATSAPP_LOG_ENABLED', true); // Habilitar logs de WhatsApp
define('WHATSAPP_LOG_FILE', 'uploads/whatsapp_log.txt'); // Archivo de log

// Configuración para respaldo por email
define('WHATSAPP_EMAIL_BACKUP_ENABLED', false); // Deshabilitado temporalmente para evitar warnings de SMTP
define('WHATSAPP_EMAIL_BACKUP_RECIPIENT', 'admin@samicam.com'); // Email para recibir respaldos

/**
 * Obtiene la configuración de WhatsApp
 * @return array Configuración completa
 */
function getWhatsAppConfig()
{
    return [
        'enabled' => WHATSAPP_ENABLED,
        'provider' => WHATSAPP_PROVIDER,
        'send_to_specific_number' => WHATSAPP_SEND_TO_SPECIFIC_NUMBER,
        'specific_number' => WHATSAPP_SPECIFIC_NUMBER,
        'callmebot' => [
            'api_key' => CALLMEBOT_API_KEY,
            'api_url' => CALLMEBOT_API_URL
        ],
        'whatsapp_business' => [
            'token' => WHATSAPP_BUSINESS_TOKEN,
            'phone_number_id' => WHATSAPP_PHONE_NUMBER_ID
        ],
        'wamr' => [
            'api_key' => WAMR_API_KEY,
            'api_url' => WAMR_API_URL
        ],
        'general' => [
            'message_template' => WHATSAPP_MESSAGE_TEMPLATE,
            'retry_attempts' => WHATSAPP_RETRY_ATTEMPTS,
            'retry_delay' => WHATSAPP_RETRY_DELAY
        ],
        'messages' => [
            'prefix' => WHATSAPP_MESSAGE_PREFIX,
            'suffix' => WHATSAPP_MESSAGE_SUFFIX
        ],
        'phone' => [
            'default_country_code' => DEFAULT_COUNTRY_CODE,
            'format' => PHONE_NUMBER_FORMAT
        ],
        'logging' => [
            'enabled' => WHATSAPP_LOG_ENABLED,
            'file' => WHATSAPP_LOG_FILE
        ],
        'email_backup' => [
            'enabled' => WHATSAPP_EMAIL_BACKUP_ENABLED,
            'recipient_email' => WHATSAPP_EMAIL_BACKUP_RECIPIENT
        ]
    ];
}

/**
 * Registra un mensaje en el log de WhatsApp
 * @param string $message Mensaje a registrar
 * @param string $level Nivel del log (INFO, ERROR, WARNING)
 */
function logWhatsAppMessage($message, $level = 'INFO')
{
    if (!WHATSAPP_LOG_ENABLED) {
        return;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    $logFile = WHATSAPP_LOG_FILE;
    $logDir = dirname($logFile);
    
    // Crear directorio si no existe
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    // Escribir en el archivo de log
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

/**
 * Verifica si las notificaciones de WhatsApp están habilitadas
 * @return bool True si están habilitadas
 */
function isWhatsAppEnabled()
{
    return WHATSAPP_ENABLED && !empty(getWhatsAppConfig()['provider']);
}

/**
 * Obtiene la API key del proveedor configurado
 * @return string API key o cadena vacía
 */
function getWhatsAppApiKey()
{
    $config = getWhatsAppConfig();
    $provider = $config['provider'];
    
    switch ($provider) {
        case 'callmebot':
            return $config['callmebot']['api_key'];
        case 'whatsapp_business':
            return $config['whatsapp_business']['token'];
        case 'wamr':
            return $config['wamr']['api_key'];
        default:
            return '';
    }
} 