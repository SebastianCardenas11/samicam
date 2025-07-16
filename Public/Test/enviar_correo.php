<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuración SMTP (Gmail)
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUser = 'ssamicamvpn@gmail.com'; // Cambia esto por tu correo de Gmail
$smtpPass = 'q v b w v l q o r a k h j r x m'; // Cambia esto por tu contraseña o app password

// Datos del correo
$para = 'carloslxpxz@gmail.com'; // Cambia esto por el correo real de destino
$asunto = 'Prueba de envío de correo con PHPMailer desde SAMICAM';
$mensaje = 'Este es un mensaje de prueba enviado usando PHPMailer y SMTP de Gmail.';

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
    $mail->Body    = "<h2>$asunto</h2><p>$mensaje</p>";
    $mail->AltBody = $mensaje;

    $mail->send();
    echo 'Correo enviado correctamente a ' . $para;
} catch (Exception $e) {
    echo 'Error al enviar el correo. Mailer Error: ', $mail->ErrorInfo;
} 