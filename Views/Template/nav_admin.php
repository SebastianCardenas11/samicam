<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/<?= $_SESSION['userData']['imgperfil']; ?>" alt="Imagen de perfil">
        <div>
            <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
            <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
        </div>
    </div>

    <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
                <i class="app-menu__icon bi bi-house-fill"></i>
                <span class="app-menu__label">Inicio</span>
            </a>
        </li>

        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/usuarios">
                    <i class="app-menu__icon bi bi-people-fill"></i>
                    <span class="app-menu__label">Usuarios</span>
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
            <li>
<<<<<<< Updated upstream
                <a class="treeview-item" href="<?= base_url(); ?>/roles">
                    <i class="app-menu__icon bi bi-sliders2-vertical"></i>
                    Roles
=======
                <a class="app-menu__item" href="<?= base_url(); ?>/roles">
                <i class="app-menu__icon bi bi-sliders2-vertical"></i>
                    <span class="app-menu__label">Roles</span>
                </a>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/funcionariosOps">
                <i class="bi bi-person-fill-gear"></i>
                    <span class="app-menu__label">Funcionarios OPS</span>
>>>>>>> Stashed changes
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
    <li class="nav-item">
        <!-- Funcionarios (PRIMER COLAPSE) -->
        <a class="app-menu__item d-flex align-items-center" data-bs-toggle="collapse" href="#collapseFuncionarios" role="button" aria-expanded="false" aria-controls="collapseFuncionarios">
            <i class="app-menu__icon bi bi-person-vcard-fill"></i>
            <span class="app-menu__label flex-grow-1">Funcionarios</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse" id="collapseFuncionarios">
            <ul class="nav flex-column ms-4">
                <!-- OPS -->
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/fichas">
                        <i class="app-menu__icon bi bi-bookmark-star-fill"></i>
                        <span class="app-menu__label">Funcionarios OPS</span>
                    </a>
                </li>

                <!-- Funcionarios Planta (SEGUNDO COLAPSE) -->
                <li>
                    <a class="app-menu__item d-flex align-items-center" data-bs-toggle="collapse" href="#collapsePlanta" role="button" aria-expanded="false" aria-controls="collapsePlanta">
                        <i class="app-menu__icon bi bi-person-fill-gear"></i>
                        <span class="app-menu__label flex-grow-1">Funcionarios Planta</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapsePlanta">
                        <ul class="nav flex-column ms-4">
                            <li>
                                <a class="app-menu__item" href="<?= base_url(); ?>/permisos">
                                    <i class="app-menu__icon bi bi-shield-lock-fill"></i>
                                    <span class="app-menu__label">Permisos</span>
                                </a>
                            </li>
                            <li>
                                <a class="app-menu__item" href="<?= base_url(); ?>/viaticos">
                                    <i class="app-menu__icon bi bi-cash-stack"></i>
                                    <span class="app-menu__label">Viáticos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </li>
<?php } ?>


  

        <a class="bg-danger app-menu__item" href="<?= base_url(); ?>/logout">
            <i class="app-menu__icon bi bi-x-circle-fill"></i>
            <span class="app-menu__label">Salir</span>
        </a>
    </ul>
</aside>
