<?php
// Bot de Telegram básico para Samicam
$token = '7886643614:AAGm5dGL82tZH81WvQPrhdTqMjcBlpy7tEs';
$base_url = "https://api.telegram.org/bot$token/";

// Función para enviar mensajes
function enviarMensaje($chat_id, $mensaje, $base_url) {
    $apiURL = $base_url . "sendMessage";
    $params = [
        'chat_id' => $chat_id,
        'text' => $mensaje
    ];
    file_get_contents($apiURL . '?' . http_build_query($params));
}

// Guardar mensaje en el log
function guardarEnLog($mensaje, $hora, $usuario, $log_file) {
    $log = [];
    if (file_exists($log_file)) {
        $log = json_decode(file_get_contents($log_file), true);
    }
    $log[] = [
        'mensaje' => $mensaje,
        'hora' => $hora,
        'usuario' => $usuario
    ];
    file_put_contents($log_file, json_encode($log));
}

// Procesar formulario
$mensajeEnviado = false;
$chat_id_grupo = '-1002792969248';
$log_file = __DIR__ . '/chat_log.json';

session_start();
if (!isset($_SESSION['chat_historial'])) {
    $_SESSION['chat_historial'] = [];
}

if (isset($_POST['texto']) && !empty($_POST['texto'])) {
    $texto = $_POST['texto'];
    enviarMensaje($chat_id_grupo, $texto, $base_url);
    // Guardar en log como "Tú"
    guardarEnLog($texto, date('H:i'), 'Tú', $log_file);
    // Redirigir para evitar reenvío al recargar
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['borrar_historial'])) {
    file_put_contents($log_file, json_encode([]));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Leer historial del log
$historial = [];
if (file_exists($log_file)) {
    $historial = json_decode(file_get_contents($log_file), true);
}

// --- Webhook para recibir mensajes del grupo ---
$content = file_get_contents("php://input");
$debug_info = "[" . date('Y-m-d H:i:s') . "] ";
$debug_info .= "Contenido recibido: " . var_export($content, true) . "\n";

$update = json_decode($content, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $debug_info .= "Error al decodificar JSON: " . json_last_error_msg() . "\n";
}

if(isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = $update["message"]["text"] ?? '';
    $from = $update["message"]["from"]["first_name"] ?? 'Usuario';
    $hora = date('H:i', $update["message"]["date"]);
    $debug_info .= "Mensaje recibido: chat_id=$chat_id, usuario=$from, texto=$text, hora=$hora\n";
    if ($chat_id == $chat_id_grupo) {
        $log_file = __DIR__ . '/chat_log.json';
        // Refuerzo: leer como array aunque esté vacío o malformado
        $log = [];
        if (file_exists($log_file)) {
            $contenido = file_get_contents($log_file);
            $log = json_decode($contenido, true);
            if (!is_array($log)) {
                $log = [];
            }
        }
        $log[] = [
            'mensaje' => $text,
            'hora' => $hora,
            'usuario' => $from
        ];
        file_put_contents($log_file, json_encode($log));
        $debug_info .= "Mensaje guardado en chat_log.json\n";
    } else {
        $debug_info .= "chat_id recibido ($chat_id) no coincide con el grupo configurado ($chat_id_grupo)\n";
    }
} else {
    $debug_info .= "No se encontró 'message' en el update\n";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chat Telegram Grupo</title>
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .chat-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            width: 400px;
            max-width: 95vw;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-header {
            background: #6c47ff;
            color: #fff;
            padding: 16px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
        }
        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f9f9fb;
        }
        .message {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .message .bubble {
            background: #6c47ff;
            color: #fff;
            padding: 10px 16px;
            border-radius: 16px 16px 4px 16px;
            max-width: 80%;
            font-size: 1em;
            word-break: break-word;
        }
        .message .hora {
            font-size: 0.8em;
            color: #888;
            margin-top: 2px;
        }
        .message .usuario {
            fonwebhook_debugt-size: 0.85em;
            color: #333;
            margin-bottom: 2px;
            align-self: flex-start;
        }
        .chat-form {
            display: flex;
            border-top: 1px solid #eee;
            background: #fafbfc;
            padding: 12px;
        }
        .chat-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            outline: none;
        }
        .chat-form button {
            background: #6c47ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            margin-left: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .chat-form button:hover {
            background: #4b2fcf;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Chat con Grupo Telegram</div>
        <div class="chat-messages" id="chat-messages">
            <?php foreach($historial as $msg): ?>
                <div class="message">
                    <div class="usuario"><?php echo htmlspecialchars($msg['usuario']); ?></div>
                    <div class="bubble"><?php echo htmlspecialchars($msg['mensaje']); ?></div>
                    <div class="hora"><?php echo $msg['hora']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <form class="chat-form" method="post" autocomplete="off">
            <input type="text" id="texto" name="texto" placeholder="Escribe tu mensaje..." required autofocus>
            <button type="submit">Enviar</button>
        </form>
        <form method="post" style="margin:0; padding:0; text-align:center;">
            <button type="submit" name="borrar_historial" style="background:#e74c3c; color:#fff; border:none; border-radius:8px; padding:8px 16px; margin-top:10px; cursor:pointer;">Borrar todo el historial</button>
        </form>
    </div>
    <script>
        // Desplazar el chat hacia abajo automáticamente
        var chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    </script>
</body>
</html>
