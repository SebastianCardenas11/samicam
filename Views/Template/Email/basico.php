<html>
<head>
    <meta charset="UTF-8">
    <title><?= isset($asunto) ? $asunto : 'Correo de Prueba' ?></title>
</head>
<body>
    <h2><?= isset($asunto) ? $asunto : 'Correo de Prueba' ?></h2>
    <p><?= isset($mensaje) ? $mensaje : 'Este es un mensaje de prueba enviado desde SAMICAM.' ?></p>
</body>
</html> 