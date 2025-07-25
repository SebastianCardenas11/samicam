<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
  <div class="sidenav-header text-center">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 d-block">
      <img src="<?= media() ?>/images/samicamIconox.png" class="navbar-brand-img" style="max-height: 100px;"><br>
      <img src="<?= !empty($_SESSION['userData']['imgperfil']) ? base_url().'/Assets/images/uploads/perfiles/'.$_SESSION['userData']['imgperfil'] : media().'/images/sin-imagen.png' ?>" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
      <span class="d-block font-weight-bold mt-2">
        <?= $_SESSION['userData']['nombres']; ?>
      </span>
      <span class="d-block text-muted"><?= $_SESSION['userData']['nombrerol']; ?></span>
    </a>
  </div><br><br><br><br><br><br>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <!-- INICIO -->
      <li class="nav-item">
        <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 1) ? 'active' : ''; ?>" href="<?= base_url(); ?>/dashboard">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-house-fill text-dark"></i>
          </div>
          <span class="nav-link-text ms-1">Inicio</span>
        </a>
      </li>
      <!-- GESTIÓN ADMINISTRATIVA -->
      <?php
      $showAdminSection =
        (!empty($_SESSION['permisos'][MROLES]['r']) && (!isset($_SESSION['permisos'][MROLES]['v']) || $_SESSION['permisos'][MROLES]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MUSUARIOS]['r']) && (!isset($_SESSION['permisos'][MUSUARIOS]['v']) || $_SESSION['permisos'][MUSUARIOS]['v'] == 1));
      if ($showAdminSection) {
      ?>
        <li class="nav-item mt-2">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestion Administrativa</h6>
        </li>
        <?php if (!empty($_SESSION['permisos'][MROLES]['r']) && (!isset($_SESSION['permisos'][MROLES]['v']) || $_SESSION['permisos'][MROLES]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 3) ? 'active' : ''; ?>" href="<?= base_url(); ?>/roles">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-sliders2-vertical text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Roles</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MUSUARIOS]['r']) && (!isset($_SESSION['permisos'][MUSUARIOS]['v']) || $_SESSION['permisos'][MUSUARIOS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 2) ? 'active' : ''; ?>" href="<?= base_url(); ?>/usuarios">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-people-fill text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Usuarios</span>
            </a>
          </li>
        <?php } ?>
      <?php } ?>
      <!-- RECURSOS HUMANOS -->
      <?php
      $showHRSection =
        (!empty($_SESSION['permisos'][MCARGOS]['r']) && (!isset($_SESSION['permisos'][MCARGOS]['v']) || $_SESSION['permisos'][MCARGOS]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MDEPENDENCIAS]['r']) && (!isset($_SESSION['permisos'][MDEPENDENCIAS]['v']) || $_SESSION['permisos'][MDEPENDENCIAS]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v']) || $_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MFUNCIONARIOSOPS]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSOPS]['v']) || $_SESSION['permisos'][MFUNCIONARIOSOPS]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MVACACIONES]['r']) && (!isset($_SESSION['permisos'][MVACACIONES]['v']) || $_SESSION['permisos'][MVACACIONES]['v'] == 1)) ||
        (!empty($_SESSION['permisos'][MVIATICOS]['r']) && (!isset($_SESSION['permisos'][MVIATICOS]['v']) || $_SESSION['permisos'][MVIATICOS]['v'] == 1));
      if ($showHRSection) {
      ?>
        <li class="nav-item mt-2">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Recursos Humanos</h6>
        </li>
        <?php if (!empty($_SESSION['permisos'][MCARGOS]['r']) && (!isset($_SESSION['permisos'][MCARGOS]['v']) || $_SESSION['permisos'][MCARGOS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/cargos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/cargos">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-book text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Cargos</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MDEPENDENCIAS]['r']) && (!isset($_SESSION['permisos'][MDEPENDENCIAS]['v']) || $_SESSION['permisos'][MDEPENDENCIAS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/dependencias')) ? 'active' : '' ?>" href="<?= base_url(); ?>/dependencias">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-diagram-3 text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">S.D.O</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v']) || $_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 9) ? 'active' : ''; ?>" href="<?= base_url(); ?>/funcionariosPlanta">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-person-vcard text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Funcionarios Planta</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MPRACTICANTES]['r']) && (!isset($_SESSION['permisos'][MPRACTICANTES]['v']) || $_SESSION['permisos'][MPRACTICANTES]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($data['page_id']) && $data['page_id'] == 10) ? 'active' : ''; ?>" href="<?= base_url(); ?>/practicantes">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-person-workspace text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Practicantes</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MFUNCIONARIOSOPS]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSOPS]['v']) || $_SESSION['permisos'][MFUNCIONARIOSOPS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/funcionariosOps')) ? 'active' : '' ?>" href="<?= base_url(); ?>/funcionariosOps">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-person-fill-gear text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Funcionarios OPS</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MVACACIONES]['r']) && (!isset($_SESSION['permisos'][MVACACIONES]['v']) || $_SESSION['permisos'][MVACACIONES]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/vacaciones')) ? 'active' : '' ?>" href="<?= base_url(); ?>/vacaciones">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-calendar-week text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Vacaciones</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MVIATICOS]['r']) && (!isset($_SESSION['permisos'][MVIATICOS]['v']) || $_SESSION['permisos'][MVIATICOS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/funcionariosviaticos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/funcionariosviaticos">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-cash-coin text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Viáticos</span>
            </a>
          </li>
        <?php } ?>
      <?php } ?>
      <!-- GESTIÓN OPERATIVA -->
      <?php if (!empty($_SESSION['permisos'][MSEGUIMIENTOCONTRATO]['r']) || !empty($_SESSION['permisos'][MINVENTARIO]['r'])) { ?>
        <li class="nav-item mt-2">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión Operativa</h6>
        </li>
        <?php if (!empty($_SESSION['permisos'][MSEGUIMIENTOCONTRATO]['r'])) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/seguimientoContrato')) ? 'active' : '' ?>" href="<?= base_url(); ?>/seguimientoContrato">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-file-signature text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Seguimiento Contrato</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MINVENTARIO]['r'])) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/Inventario')) ? 'active' : '' ?>" href="<?= base_url(); ?>/Inventario">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-seam text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Inventario</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][MPSI]['r'])) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/Psi')) ? 'active' : '' ?>" href="<?= base_url(); ?>/Psi">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-left-right text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">P.S.I</span>
            </a>
          </li>
        <?php } ?>
      <?php } ?>
      <!-- GESTIÓN DE CONTENIDOS -->
      <?php
      $showContentSection =
        (!empty($_SESSION['permisos'][MARCHIVOS]['r']) && (!isset($_SESSION['permisos'][MARCHIVOS]['v']) || $_SESSION['permisos'][MARCHIVOS]['v'] == 1)) ||
        (isset($_SESSION['permisos'][MPUBLICACIONES]) && !empty($_SESSION['permisos'][MPUBLICACIONES]['r']) && (!isset($_SESSION['permisos'][MPUBLICACIONES]['v']) || $_SESSION['permisos'][MPUBLICACIONES]['v'] == 1)) ||
        (isset($_SESSION['permisos'][MTAREAS]) && !empty($_SESSION['permisos'][MTAREAS]['r']) && (!isset($_SESSION['permisos'][MTAREAS]['v']) || $_SESSION['permisos'][MTAREAS]['v'] == 1));
      if ($showContentSection) {
      ?>
        <li class="nav-item mt-2">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión de Contenidos</h6>
        </li>
        <?php if (!empty($_SESSION['permisos'][MARCHIVOS]['r']) && (!isset($_SESSION['permisos'][MARCHIVOS]['v']) || $_SESSION['permisos'][MARCHIVOS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/archivos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/archivos">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-file-earmark text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Archivos</span>
            </a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION['permisos'][MPUBLICACIONES]) && !empty($_SESSION['permisos'][MPUBLICACIONES]['r']) && (!isset($_SESSION['permisos'][MPUBLICACIONES]['v']) || $_SESSION['permisos'][MPUBLICACIONES]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/publicaciones')) ? 'active' : '' ?>" href="<?= base_url(); ?>/publicaciones">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-newspaper text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Publicaciones</span>
            </a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION['permisos'][MTAREAS]) && !empty($_SESSION['permisos'][MTAREAS]['r']) && (!isset($_SESSION['permisos'][MTAREAS]['v']) || $_SESSION['permisos'][MTAREAS]['v'] == 1)) { ?>
          <li class="nav-item">
            <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/tareas')) ? 'active' : '' ?>" href="<?= base_url(); ?>/tareas">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-card-checklist text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">Tareas</span>
            </a>
          </li>
        <?php } ?>
      <?php } ?>
      <!-- CONTROL Y SEGURIDAD -->
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Control y seguridad</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/notificaciones')) ? 'active' : '' ?>" href="<?= base_url(); ?>/notificaciones">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-bell-fill text-dark"></i>
          </div>
          <span class="nav-link-text ms-1">Notificaciones</span>
        </a>
      </li>
      <?php if (!empty($_SESSION['permisos'][MWHATSAPP]['r'])) { ?>
        <li class="nav-item">
          <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/whatsapp')) ? 'active' : '' ?>" href="<?= base_url(); ?>/whatsapp">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fab fa-whatsapp text-success"></i>
            </div>
            <span class="nav-link-text ms-1">WhatsApp</span>
          </a>
        </li>
      <?php } ?>
      <?php if (isset($_SESSION['userData']['nombrerol']) && $_SESSION['userData']['nombrerol'] == 'Superadministrador') { ?>
        <li class="nav-item">
          <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/auditoria')) ? 'active' : '' ?>" href="<?= base_url(); ?>/auditoria">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-shield-lock text-dark"></i>
            </div>
            <span class="nav-link-text ms-1">Auditoría</span>
          </a>
        </li>
      <?php } ?>
     
      <!-- AJUSTES Y SALIR -->
      <li class="nav-item mt-3">
        <a class="nav-link <?= (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '/ajustes')) ? 'active' : ''; ?>" href="<?= base_url(); ?>/ajustes">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-cog text-dark"></i>
          </div>
          <span class="nav-link-text ms-1">Ajustes</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <a class="nav-link text-danger" href="<?= base_url(); ?>/logout">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-x-circle-fill text-danger"></i>
          </div>
          <span class="nav-link-text ms-1">Salir</span>
        </a>
      </li>
    </ul>
  </div>
</aside>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

