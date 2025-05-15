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

        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/usuarios">
                    <i class="app-menu__icon bi bi-people-fill"></i>
                    <span class="app-menu__label">Usuarios</span>
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/roles">
                    <i class="app-menu__icon bi bi-sliders2-vertical"></i>
                    <span class="app-menu__label">Roles</span>
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/cargos">
                    <i class="app-menu__icon bi bi-book"></i>
                    <span class="app-menu__label">&nbsp;Cargos</span>
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/funcionariosOps">
                    <i class="bi bi-person-fill-gear"></i>
                    <span class="app-menu__label">&nbsp; Funcionarios OPS</span>
                </a>
            </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/funcionariosPlanta">
                    <i class="bi bi-person-fill"></i>
                    <span class="app-menu__label">&nbsp; Funcionarios Planta</span>
                </a>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/vacaciones">
                    <i class="bi bi-calendar-week"></i>
                    <span class="app-menu__label">&nbsp; Vacaciones</span>
                </a>
            </li>
        <?php } ?>

        <a class="bg-danger app-menu__item" href="<?= base_url(); ?>/logout">
            <i class="app-menu__icon bi bi-x-circle-fill"></i>
            <span class="app-menu__label">Salir</span>
        </a>
    </ul>
</aside>