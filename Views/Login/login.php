<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="SamiCam">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= media(); ?>/css/styles_login.css" media="all">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>



<body>
    <div class="container">
        <div class="form-container sign-in-container">
            <form name="loginForm" method="POST" action="">
                <img src="Assets/images/Escudo_de_La_Jagua_de_Ibirico.svg.png" alt="Logo" class="form-img">
                <h1>Iniciar Sesión</h1>
                <input id="txtCorreo" name="txtCorreo" type="text" placeholder="Correo" required autocomplete="off" />
                <input id="txtPassword" name="txtPassword" type="password" placeholder="Contraseña" required autocomplete="off" />
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>



        <!-- Panel de overlay -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <img src="Assets/images/samicam-alcaldia.png" alt="Logo SamiCam" class="logo-samicam">
                    <h1 class="hola" id="saludo-hola">Hola !</h1>
                    <p class="mensaje-bienvenida"> Bienvenido al sistema de gestión SamiCam de la Alcaldía de la Jagua de Ibirico.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ANIMACION AL UNDIR HOLA EN EL LOGIN -->
    <script src="Assets/js/hola-login.js"></script>
</body>
</html>