<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function enviarCorreoTareaAsignada($emailUsuario, $nombreUsuario, $datosTarea) {
    
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587;
    $smtpUser = 'ssamicamvpn@gmail.com';
    $smtpPass = 'q v b w v l q o r a k h j r x m';

    // Datos del correo
    $para = $emailUsuario;
    $asunto = 'Nueva Tarea Asignada - SAMICAM';
    $mensaje = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación Importante</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; line-height: 1.5; color: #2d3748; background-color: #ffffff; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="width: 100%; max-width: 480px; margin: 0 auto; background-color: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);">
        <div style="background-color: #1a365d; color: white; padding: 12px 24px; display: flex; align-items: center; justify-content: center; gap: 12px;">
           
            <h1 style="margin: 0; font-size: 18px; font-weight: 600; letter-spacing: 0.5px;">Nueva Tarea Asignada</h1>
        </div>

        <div style="padding: 24px;">
            <p style="font-size: 16px; margin-bottom: 16px; color: #2d3748; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 8V12" stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 16H12.01" stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Hola ' . $nombreUsuario . ' !
            </p>

            <div style="margin-bottom: 20px; color: #2d3748; font-size: 14px;">
                <p>Te informamos que se ha <strong>asignado una nueva tarea</strong> en tu perfil a partir del <strong>' . $datosTarea['fecha_inicio'] . '</strong>.</p>
            </div>

            <div style="background-color: #f7fafc; border-left: 3px solid #4299e1; padding: 12px 16px; margin: 16px 0; font-size: 14px; border-radius: 0 4px 4px 0;">
                Revisa los detalles y realiza seguimiento oportunamente.
            </div>

            <div style="margin: 20px 0;">
                <div style="display: flex; margin-bottom: 12px; font-size: 14px;">
                    <span style="font-weight: 600; min-width: 100px; color: #1a365d;">Fecha de inicio:</span>
                    <span style="flex: 1;">' . $datosTarea['fecha_inicio'] . '</span>
                </div>
                <div style="display: flex; margin-bottom: 12px; font-size: 14px;">
                    <span style="font-weight: 600; min-width: 100px; color: #1a365d;">Fecha de fin:</span>
                    <span style="flex: 1;">' . $datosTarea['fecha_fin'] . '</span>
                </div>
                <div style="display: flex; margin-bottom: 12px; font-size: 14px;">
                    <span style="font-weight: 600; min-width: 100px; color: #1a365d;">Prioridad:</span>
                    <span style="flex: 1;">' . $datosTarea['prioridad'] . '</span>
                </div>
                <div style="display: flex; margin-bottom: 12px; font-size: 14px;">
                    <span style="font-weight: 600; min-width: 100px; color: #1a365d;">Descripción:</span>
                    <span style="flex: 1;">' . $datosTarea['titulo'] . '</span>
                </div>
            </div>

            <div style="text-align: center; margin-top: 24px;">
            <a href="" style="text-decoration: none; color: white;">    
            <button style="display: inline-block; background-color: #1a365d; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: 500; font-size: 14px; transition: background-color 0.2s; border: none; cursor: pointer;">
                    
                    Ver Tarea
                </button>
            </a>
            </div>
        </div>

        <div style="text-align: center; padding: 16px; background-color: #f7fafc; color: #718096; font-size: 12px; border-top: 1px solid #e2e8f0;">
         <img src="https://i.ibb.co/G3nJnfz3/icono.png" alt="Logo Samicam" style="height: 32px; width: auto;">
            <p>© 2025 Samicam - Alcaldía Municipal de La Jagua de Ibirico</p>
            <div style="margin-top: 8px;">
                <a href="#" style="color: #4299e1; text-decoration: none; margin: 0 6px; font-size: 11px;">Políticas de Privacidad</a>
                <a href="#" style="color: #4299e1; text-decoration: none; margin: 0 6px; font-size: 11px;">Transparencia</a>
                <a href="#" style="color: #4299e1; text-decoration: none; margin: 0 6px; font-size: 11px;">Preferencias</a>
            </div>
        </div>
    </div>
</body>
</html>


';

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;

        // Remitente y destinatario
        $mail->setFrom($smtpUser, 'SAMICAM');
        $mail->addAddress($para);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        $mail->AltBody = 'Nueva tarea asignada en SAMICAM: ' . $datosTarea['titulo'] . '. Por favor revisa los detalles en tu perfil.';

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Registrar el error en el log del sistema
        error_log('Error al enviar correo a ' . $para . ': ' . $mail->ErrorInfo);
        return false;
    }
}