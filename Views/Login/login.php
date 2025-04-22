<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sigma">

    
    <link rel="stylesheet" type="text/css" href="<?=media();?>/css/styles_login.css">
    <!-- ACTUALIZACIÓN ICONOS BOOTSTRAP-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.css" rel="stylesheet">

    <title><?=$data['page_tag'];?></title>
</head>

<body>
    
<div class="container">
    <div class="form-container sign-in-container">
        <form name="formLogin" id="formLogin" method="POST" action="">
            <img src="Assets/images/Escudo_de_La_Jagua_de_Ibirico.svg.png" alt="Logo" class="form-img">
            <h1>Iniciar Sesión</h1>

            <div class="input-group flex-nowrap mb-3">
                <input id="txtIdentificacion" name="txtIdentificacion" type="text" class="form-control"
                    placeholder="Correo" required autocomplete="off" autofocus />
            </div>

            <div class="input-group flex-nowrap mb-3">
                <input id="txtPassword" name="txtPassword" type="password" class="form-control"
                    placeholder="Contraseña" required autocomplete="off" />
            </div>

            <div id="alertLogin" class="text-center mb-3"></div>

           

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-door-open me-2" style="font-size: 1rem; color: white;"></i> Iniciar Sesión
            </button>
        </form>
    </div>

    <!-- Panel de overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <img src="Assets/images/samicam-alcaldia.png" alt="Logo SamiCam" class="logo-samicam">
                <h1 class="hola" id="saludo-hola">Hola !</h1>
                <p class="mensaje-bienvenida">Bienvenido al sistema de gestión SamiCam de la Alcaldía de la Jagua de Ibirico.</p>
            </div>
        </div>
    </div>
</div>


    <!-- ORIGINAL -->
    <script>
    const base_url = "<?=base_url();?>";
    </script>

    <!-- Essential javascripts for application to work-->
    <script src="<?=media();?>/js/jquery-3.7.0.min.js"></script>

    <script src="<?=media();?>/js/popper.min.js"></script>

    <script src="<?=media();?>/js/bootstrap.min.js"></script>

    <script src="<?=media();?>/js/main.js"></script>
    <script src="<?=media();?>/js/hola-login.js"></script>

     <script src="<?=media();?>/js/plugins/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?=media();?>/js/<?=$data['page_functions_js'];?>"></script>

</body>

</html>