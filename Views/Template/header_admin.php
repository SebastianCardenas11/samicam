<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SamiCam</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../../Assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar -->
    <header class="app-header">
        <a class="app-header__logo" href="">logo</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <ul class="app-nav">
            <li class="dropdown">
                <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
                    <i class="bi bi-person fs-4"></i>
                </a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="page-user.html"><i class="bi bi-gear me-2 fs-5"></i> Configuración </a></li>
                    <li><a class="dropdown-item" href="../perfil/perfil.php"><i class="bi bi-person me-2 fs-5"></i> Perfil</a></li>
                    <li><a class="dropdown-item" href="../../logout/logout.php"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </header>
