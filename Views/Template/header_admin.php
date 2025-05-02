<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="samicam">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="SamiCAM">
    <link rel="shortcut icon" href="<?= media(); ?>/images/Escudo_de_La_Jagua_de_Ibirico.svg.png">
    <title><?= $data['page_tag'] ?></title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/selectpicker/picker.css">

    <!-- TODO BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DATA TABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">

    <!-- Font-icon css 2024-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="app sidebar-mini">

    <div id="divLoading">
        <div class="spinner-border visually-hidden" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Navbar-->
    <header class="app-header">
        <a class="app-header__logo" href="<?= base_url(); ?>/dashboard">
            <img src="<?= base_url(); ?>/Assets/images/samicam-dashboard.png" alt="SAMICAM Logo" style=" 
            height: 65px; 
            width: auto; 
            margin-left: -30px;
            margin-top: -16px;">
        </a>


        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Menu-->
        <ul class="app-nav">

            <!-- Menu Uusario -->
            <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="<?= base_url(); ?>/dashboard"><i class="bi bi-gear me-2 fs-5"></i>
                            Configuración</a></li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>/dashboard"><i
                                class="bi bi-person me-2 fs-5"></i> Perfil</a>
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>/logout"><i
                                class="bi bi-box-arrow-right me-2 fs-5"></i>
                            Salir</a></li>
                </ul>
            </li>
        </ul>
    </header>

    <?php require_once "nav_admin.php"; ?>