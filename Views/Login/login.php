<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Samicam">
    <link rel="icon" type="image/png" href="<?= media() ?>/images/favicon.png">
    <title><?= $data['page_tag']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="<?= media() ?>/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
<style>
    button {
        &.submit {
            background-color: #004884 !important;
            color: #fff !important;
        }
    }

    .img-fluid {
        margin: 0;
    }

    body {
        overflow: hidden;
    }
</style>
<body>
    <main class="main-content  mt-0">
        <section class="min-vh-100 ">
            <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
                style="background-image: url('<?= media() ?>/images/fondo.jpg');">
                <span class="mask bg-gradient-dark opacity-6"></span>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4 pb-1">
                                <img src="<?= media() ?>/images/samicamIcono.png" class="img-fluid" alt="LOGO SAMICAM">
                            </div>
                            <div class="card-body">
                                <form name="formLogin" id="formLogin" method="POST" action="">
                                    <div class="mb-3">
                                        <input id="txtIdentificacion" name="txtIdentificacion" type="text"
                                            class="form-control" placeholder="Correo" required autocomplete="off"
                                            autofocus />
                                    </div>
                                    <div class="mb-3">
                                        <input id="txtPassword" name="txtPassword" type="password" class="form-control"
                                            placeholder="Contraseña" required autocomplete="off"/>
                                    </div>
                                    <div id="alertLogin" class="text-center mb-3"></div>
                                    <div>
                                        <button type="submit" class="btn submit w-100 ">Iniciar Sesión</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mb-4 mx-auto text-center">

                            <a href="https://www.lajaguadeibirico-cesar.gov.co/politicas/" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                                Políticas
                            </a>
                            <a href="https://www.lajaguadeibirico-cesar.gov.co/transparencia" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                                Transparencia
                            </a>
                            <a href="https://www.lajaguadeibirico-cesar.gov.co/mapa-del-sitio" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                                Mapa del sitio
                            </a>
                            <a href="https://www.lajaguadeibirico-cesar.gov.co/estadisticas/" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                                Estadísticas
                            </a>
                        </div>
                        <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
                            <a href="https://www.facebook.com/NoticiasLaJagua" target="_blank" class="text-secondary me-xl-4 me-4">
                                <span class="text-lg fab fa-facebook"></span>
                            </a>
                            <a href="https://x.com/AlcaldiaLaJagua" target="_blank" class="text-secondary me-xl-4 me-4">
                                <span class="text-lg fab fa-twitter"></span>
                            </a>
                            <a href="https://www.instagram.com/alcaldiadelajaguadeibirico/?hl=es" target="_blank" class="text-secondary me-xl-4 me-4">
                                <span class="text-lg fab fa-instagram"></span>
                            </a>
                            <a href="https://www.youtube.com/@alcaldiadelajaguadeibirico" target="_blank" class="text-secondary me-xl-4 me-4">
                                <span class="text-lg fab fa-youtube"></span>
                            </a>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 mx-auto text-center mt-1">
                            <p class="mb-0 text-secondary">
                                Copyright ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Alcaldia la jagua de ibirico.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </section>
    </main>
    <script> const base_url = "<?=base_url();?>"; </script>
    <script src="<?= media(); ?>/js/jquery-3.7.0.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>
</html>