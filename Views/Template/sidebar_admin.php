<?php
$rolid = $_SESSION['userData']['idrol'];
?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?= base_url(); ?>/dashboard">
            <img src="<?= media(); ?>/images/logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">SAMICAM</span>
        </a>
    </div>
    
    <?php if ($rolid != 1 && $rolid != 2) { ?>
    <div class="text-center mt-2">
        <div id="colombiaClock" class="p-2 bg-light rounded shadow-sm">
            <i class="bi bi-clock"></i> <span id="clockDisplay"></span>
        </div>
    </div>
    <script>
        function updateClock() {
            const now = new Date();
            const options = { 
                timeZone: 'America/Bogota',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true
            };
            document.getElementById('clockDisplay').textContent = now.toLocaleTimeString('es-CO', options);
            setTimeout(updateClock, 1000);
        }
        updateClock();
    </script>
    <?php } ?>
    
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['permisos'][1]) && $_SESSION['permisos'][1]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 1) ? 'active' : ''; ?>" href="<?= base_url(); ?>/dashboard">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-speedometer2 text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][2]) && $_SESSION['permisos'][2]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 2) ? 'active' : ''; ?>" href="<?= base_url(); ?>/usuarios">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-people text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][3]) && $_SESSION['permisos'][3]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 3) ? 'active' : ''; ?>" href="<?= base_url(); ?>/roles">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Roles</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][4]) && $_SESSION['permisos'][4]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 4) ? 'active' : ''; ?>" href="<?= base_url(); ?>/funcionariosops">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-lines-fill text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Funcionarios</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][5]) && $_SESSION['permisos'][5]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 5) ? 'active' : ''; ?>" href="<?= base_url(); ?>/funcionariospermisos">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-check text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Permisos</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][6]) && $_SESSION['permisos'][6]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 6) ? 'active' : ''; ?>" href="<?= base_url(); ?>/vacaciones">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar2-week text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Vacaciones</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][7]) && $_SESSION['permisos'][7]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 7) ? 'active' : ''; ?>" href="<?= base_url(); ?>/funcionariosviaticos">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash-coin text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Viáticos</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (isset($_SESSION['permisos'][8]) && $_SESSION['permisos'][8]['r'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 8) ? 'active' : ''; ?>" href="<?= base_url(); ?>/archivos">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-text text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Archivos</span>
                    </a>
                </li>
            <?php } ?>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Cuenta</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url(); ?>/logout">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-right text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">Cerrar sesión</span>
                </a>
            </li>
        </ul>
    </div>
</aside>