    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
                src="<?= media();?>/images/<?=$_SESSION['userData']['imgperfil'];?>" alt="Imagen de perfil">
            <div>
                <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
                <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
            </div>
        </div>

        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="<?=base_url();?>/dashboard">
                    <i class="app-menu__icon bi bi-house"></i>
                    <span class="app-menu__label">Inicio</span>
                </a>
            </li>

            <?php if (!empty($_SESSION['permisos'][1]['r'])) {?>
            <li>
                <a class="treeview-item" href="<?=base_url();?>/roles">
                    <i class="app-menu__icon bi bi-toggles"></i>
                    Roles
                </a>
            </li>
            <?php }?>

            <?php if (!empty($_SESSION['permisos'][1]['r'])) {?>
            <li><a class="app-menu__item " href="<?=base_url();?>/usuarios">
                    <i class="app-menu__icon bi bi-people"></i>
                    <span class="app-menu__label">Usuarios</span></a></li>
            <?php }?>

            <?php if (!empty($_SESSION['permisos'][2]['r'])) {?>
            <li>
                <a class="treeview-item" href="<?=base_url();?>/programas">
                    <i class="app-menu__icon bi bi-list-stars"></i>
                    Programas</a>
            </li>
            <?php }?>

            <li><a class="app-menu__item " href="<?=base_url();?>/fichas">
                    <i class="app-menu__icon bi bi-bookmark-star"></i>
                    <span class="app-menu__label">Fichas</span></a></li>

            <li><a class="app-menu__item " href="<?=base_url();?>/competencias">
                    <i class="app-menu__icon bi bi-card-checklist"></i>
                    <span class="app-menu__label">Competencias</span></a></li>


            <li><a class="app-menu__item " href="<?=base_url();?>/asignaciones">
                    <i class="app-menu__icon bi bi-check2-circle"></i>
                    <span class="app-menu__label">Asignaciones</span></a></li>
            <li>
                <a class="bg-danger app-menu__item" href="<?=base_url();?>/logout">
                    <i class="app-menu__icon bi bi-x-circle"></i>
                    <span class="app-menu__label">Salir</span>
                </a>
            </li>

        </ul>

    </aside>