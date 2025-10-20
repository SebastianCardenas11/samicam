<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('WHATSAPP_ENABLED', false);
define('EMAIL_NOTIFICATIONS_ENABLED', true);
define('EMAIL_RECIPIENT', 'sistema@lajaguadeibirico-cesar.gov.co');

define('WHATSAPP_PHONE_NUMBER', '573163819809');
define('CALLMEBOT_API_KEY', '1234652');
define('CALLMEBOT_API_URL', 'https://api.callmebot.com/whatsapp.php');

define('NOTIFICATION_PREFIX', '🔔 *SAMICAM - Nueva Tarea*');
define('NOTIFICATION_SUFFIX', '💻 Accede al sistema para más detalles.');

define('NOTIFICATION_LOG_ENABLED', true);
define('NOTIFICATION_LOG_FILE', 'uploads/notifications_log.txt');

function getWhatsAppConfig()
{
    return [
        'enabled' => WHATSAPP_ENABLED,
        'provider' => WHATSAPP_PROVIDER,
        'phone_number' => WHATSAPP_PHONE_NUMBER,
        'api_key' => CALLMEBOT_API_KEY,
        'api_url' => CALLMEBOT_API_URL,
        'message_prefix' => WHATSAPP_MESSAGE_PREFIX,
        'message_suffix' => WHATSAPP_MESSAGE_SUFFIX,
        'log_enabled' => WHATSAPP_LOG_ENABLED,
        'log_file' => WHATSAPP_LOG_FILE
    ];
}

function logWhatsAppMessage($message, $level = 'INFO')
{
    if (!NOTIFICATION_LOG_ENABLED) {
        return;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    $logFile = NOTIFICATION_LOG_FILE;
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

function sendNotification($message, $subject = 'Nueva Tarea')
{
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587;
    $smtpUser = 'ssamicamvpn@gmail.com';
    $smtpPass = 'q v b w v l q o r a k h j r x m';
    
    $to = EMAIL_RECIPIENT;
    $fullMessage = NOTIFICATION_PREFIX . "\n\n" . $message . "\n\n" . NOTIFICATION_SUFFIX;
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;
        
        $mail->setFrom($smtpUser, 'SAMICAM');
        $mail->addAddress($to);
        
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $fullMessage;
        
        $mail->send();
        logWhatsAppMessage("Email enviado exitosamente a $to: $subject", 'INFO');
        return true;
    } catch (Exception $e) {
        logWhatsAppMessage("Error al enviar email a $to: " . $mail->ErrorInfo, 'ERROR');
        return false;
    }
}

function sendTaskNotification($taskTitle, $taskDescription, $assignedTo = '')
{
    $message = "Nueva tarea asignada:\n\n";
    $message .= "Título: $taskTitle\n";
    $message .= "Descripción: $taskDescription\n";
    if ($assignedTo) {
        $message .= "Asignado a: $assignedTo\n";
    }
    $message .= "Fecha: " . date('Y-m-d H:i:s');
    
    return sendNotification($message, "SAMICAM - Nueva Tarea: $taskTitle");
}