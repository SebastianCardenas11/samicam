<?php

/**
 * Helper para enviar notificaciones por email como respaldo
 * cuando WhatsApp no esté disponible
 */

class EmailBackupHelper
{
    private $config;
    
    public function __construct()
    {
        // Cargar configuración
        require_once "Config/WhatsAppConfig.php";
        $this->config = getWhatsAppConfig();
    }
    
    /**
     * Envía notificación de tarea por email
     * @param array $usuarios Array de usuarios asignados
     * @param array $tareaInfo Información de la tarea
     * @return bool True si se envió correctamente
     */
    public function sendTareaNotification($usuarios, $tareaInfo)
    {
        try {
            $to = $this->config['email_backup']['recipient_email'];
            $subject = "🔔 Nueva Tarea Creada en SAMICAM - " . date('d/m/Y H:i:s');
            $message = $this->createEmailMessage($usuarios, $tareaInfo);
            $headers = $this->createEmailHeaders();
            
            $success = mail($to, $subject, $message, $headers);
            
            if ($success) {
                logWhatsAppMessage("Email backup sent successfully to {$to}", "INFO");
            } else {
                logWhatsAppMessage("Failed to send email backup to {$to}", "ERROR");
            }
            
            return $success;
            
        } catch (Exception $e) {
            logWhatsAppMessage("Error sending email backup: " . $e->getMessage(), "ERROR");
            return false;
        }
    }
    
    /**
     * Crea el mensaje de email
     * @param array $usuarios Array de usuarios
     * @param array $tareaInfo Información de la tarea
     * @return string Mensaje formateado
     */
    private function createEmailMessage($usuarios, $tareaInfo)
    {
        $fechaInicio = date('d/m/Y', strtotime($tareaInfo['fecha_inicio']));
        $fechaFin = date('d/m/Y', strtotime($tareaInfo['fecha_fin']));
        
        $message = "🔔 NUEVA TAREA CREADA EN SAMICAM\n\n";
        $message .= "📋 Descripción: {$tareaInfo['descripcion']}\n";
        $message .= "🏷️ Tipo: {$tareaInfo['tipo']}\n";
        $message .= "🏢 Dependencia: {$tareaInfo['dependencia_nombre']}\n";
        $message .= "📅 Fecha de inicio: {$fechaInicio}\n";
        $message .= "📅 Fecha de fin: {$fechaFin}\n";
        
        if (!empty($tareaInfo['observacion'])) {
            $message .= "📝 Observación: {$tareaInfo['observacion']}\n";
        }
        
        $message .= "\n👥 Usuarios Asignados:\n";
        foreach ($usuarios as $usuario) {
            $message .= "   • {$usuario['nombres']}\n";
        }
        
        $message .= "\n📊 Resumen:\n";
        $message .= "   • Total de usuarios: " . count($usuarios) . "\n";
        $message .= "   • Estado: Sin empezar\n";
        $message .= "   • Prioridad: Normal\n";
        
        $message .= "\n💻 Accede al sistema para más detalles.\n";
        $message .= "¡Gracias por tu atención!\n\n";
        $message .= "---\n";
        $message .= "Este mensaje fue enviado como respaldo porque WhatsApp no está disponible.\n";
        $message .= "Fecha: " . date('d/m/Y H:i:s');
        
        return $message;
    }
    
    /**
     * Crea los headers del email
     * @return string Headers del email
     */
    private function createEmailHeaders()
    {
        $headers = "From: SAMICAM <noreply@samicam.com>\r\n";
        $headers .= "Reply-To: noreply@samicam.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        return $headers;
    }
} 