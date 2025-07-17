<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Función para enviar correo de notificación cuando se asigna una tarea
 * 
 * @param string $emailUsuario Correo electrónico del usuario
 * @param string $nombreUsuario Nombre del usuario
 * @param array $datosTarea Arreglo con los datos de la tarea (título, descripción, fechas, etc)
 * @return bool True si se envió correctamente, False en caso contrario
 */
function enviarCorreoTareaAsignada($emailUsuario, $nombreUsuario, $datosTarea) {
    // Configuración SMTP (Gmail)
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587;
    $smtpUser = 'ssamicamvpn@gmail.com'; // Cambia esto por tu correo de Gmail
    $smtpPass = 'q v b w v l q o r a k h j r x m'; // Cambia esto por tu contraseña o app password

    // Datos del correo
    $para = $emailUsuario;
    $asunto = 'Nueva Tarea Asignada - SAMICAM';
    $mensaje = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación Importante</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #ffffff; /* No se puede cambiar */
            margin: 0;
            padding: 20px;
        }

        .carta-contenedor {
            max-width: 600px;
            margin: 30px auto;
            background-color: #f9f9f9; /* Color sutil para diferenciar del fondo blanco */
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
            box-shadow: 0 0 0 2px #e0e0e0, 0 8px 20px rgba(0, 0, 0, 0.15); /* sombra marcada */
        }

        .cabecera {
            background-color: #004884;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #004884;
        }

        .cabecera h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .contenido {
            padding: 30px;
            text-align: center;
        }

        .contenido img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .saludo {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444;
            text-align: left;
        }

        .mensaje {
            margin-bottom: 25px;
            color: #555;
            text-align: left;
        }

        .mensaje ul {
            padding-left: 20px;
        }

        .destacado {
            background-color: #f8f9fa;
            border-left: 4px solid #004884;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
        }

        .boton {
            display: inline-block;
            background-color: #004884;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .boton:hover {
            background-color: #003766;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            color: #777;
            font-size: 12px;
        }

        .footer a {
            color: #004884;
            text-decoration: none;
            margin: 0 5px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .contenido {
                padding: 20px;
            }

            .cabecera h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="carta-contenedor">
        <div class="cabecera">
            <h1>¡Nueva Tarea Asignada!</h1>
        </div>

        <div class="contenido">
            <img src="https://i.ibb.co/G3nJnfz3/icono.png" alt="Logo Samicam" width="400px">

            <p class="saludo">📢 ¡Hola ' . $nombreUsuario . '!</p>

            <div class="mensaje">
                <p>
                    Te informamos que se ha <strong>asignado una nueva tarea</strong> en tu perfil a partir del <strong>' . $datosTarea['fecha_inicio'] . '</strong>.
                </p>

                <div class="destacado">
                    Revisa los detalles y realiza seguimiento oportunamente.
                </div>

                <p>Detalles importantes:</p>
                <ul>
                    <li><strong>Título:</strong> ' . $datosTarea['titulo'] . '</li>
                    <li><strong>Fecha de inicio:</strong> ' . $datosTarea['fecha_inicio'] . '</li>
                    <li><strong>Fecha de fin:</strong> ' . $datosTarea['fecha_fin'] . '</li>
                    <li><strong>Prioridad:</strong> ' . $datosTarea['prioridad'] . '</li>
                    <li><strong>Descripción:</strong> ' . $datosTarea['descripcion'] . '</li>
                </ul>
            </div>
<a href="' . $datosTarea['url_tarea'] . '" class="boton" style="color: white !important; background-color: #007BFF; padding: 10px; text-decoration: none; border-radius: 5px;">📌 Ver Tarea</a>

        </div>

        <div class="footer">
            <p>© 2025 Samicam - Alcaldía Municipal de La Jagua de Ibirico. Todos los derechos reservados.</p>
            <a href="#">Políticas de Privacidad</a>
            <a href="#">Transparencia</a>
            <a href="#">Cambiar tus preferencias</a>
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