<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado' ?></p>
            <p class="app-sidebar__user-designation">Administrador</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item" href="../Dashboard/dashboard.php"><i class="app-menu__icon bi bi-house-door"></i><span class="app-menu__label">Inicio</span></a></li>
        <li><a class="app-menu__item" href="../usuarios/usuarios.php"><i class="app-menu__icon bi bi-person-badge"></i><span class="app-menu__label">Funcionarios</span></a></li>
        <li><a class="app-menu__item" href="../inventario/equipos_pcs.php"><i class="app-menu__icon bi bi-inboxes"></i><span class="app-menu__label">Inventario Equipos</span></a></li>
        <li><a class="app-menu__item" href="../historial_equipos/historial_equipos.php"><i class="app-menu__icon bi bi-clock-history"></i><span class="app-menu__label">Historial Equipos</span></a></li>
    </ul>
</aside>
