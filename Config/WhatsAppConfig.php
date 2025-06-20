<?php

define('WHATSAPP_ENABLED', true);
define('WHATSAPP_PROVIDER', 'callmebot');

define('WHATSAPP_SEND_TO_SPECIFIC_NUMBER', true);
define('WHATSAPP_SPECIFIC_NUMBER', '+573163819809');

define('CALLMEBOT_API_KEY', '123456');
define('CALLMEBOT_API_URL', 'https://api.callmebot.com/whatsapp.php');

define('CALLMEBOT_ALTERNATIVE_NUMBERS', [
    '+34 644 51 95 23',
]);

define('WHATSAPP_BUSINESS_TOKEN', '');
define('WHATSAPP_PHONE_NUMBER_ID', '');

define('WAMR_API_KEY', '');
define('WAMR_API_URL', 'https://api.wamr.com/v1/message');

define('WHATSAPP_MESSAGE_TEMPLATE', true);
define('WHATSAPP_RETRY_ATTEMPTS', 3);
define('WHATSAPP_RETRY_DELAY', 5);

define('WHATSAPP_MESSAGE_PREFIX', '🔔 *SAMICAM - Nueva Tarea*');
define('WHATSAPP_MESSAGE_SUFFIX', '💻 Accede al sistema para más detalles.');

define('DEFAULT_COUNTRY_CODE', '57');
define('PHONE_NUMBER_FORMAT', 'international');

define('WHATSAPP_LOG_ENABLED', true);
define('WHATSAPP_LOG_FILE', 'uploads/whatsapp_log.txt');

define('WHATSAPP_EMAIL_BACKUP_ENABLED', false);
define('WHATSAPP_EMAIL_BACKUP_RECIPIENT', 'admin@samicam.com');

define('WHATSAPP_TASK_NUMBER', '573183687660');
define('CALLMEBOT_TASK_API_KEY', '8086746');
define('WHATSAPP_GENERAL_NUMBER', '573163819809');
define('CALLMEBOT_GENERAL_API_KEY', '1234652');

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
        ],
        'task_number' => WHATSAPP_TASK_NUMBER,
        'task_api_key' => CALLMEBOT_TASK_API_KEY,
        'general_number' => WHATSAPP_GENERAL_NUMBER,
        'general_api_key' => CALLMEBOT_GENERAL_API_KEY,
    ];
}

function logWhatsAppMessage($message, $level = 'INFO')
{
    if (!WHATSAPP_LOG_ENABLED) {
        return;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    $logFile = WHATSAPP_LOG_FILE;
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

function isWhatsAppEnabled()
{
    return WHATSAPP_ENABLED && !empty(getWhatsAppConfig()['provider']);
}

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