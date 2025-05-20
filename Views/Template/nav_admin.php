 <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header text-center">
  <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
  
  <a class="navbar-brand m-0 d-block">
    <!-- Imagen con tamaño normal -->
    <img src="<?= media() ?>/images/samicamIconox.png" class="navbar-brand-img" style="max-height: 100px;"><br>

    <!-- Nombre del usuario -->
    <span class="d-block font-weight-bold mt-2"><?= $_SESSION['userData']['nombres']; ?></span>

    <!-- Rol del usuario -->
    <span class="d-block text-muted"><?= $_SESSION['userData']['nombrerol']; ?></span>
  </a>
</div><br><br><br>

    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
<li class="nav-item">
  <a class="nav-link active" href="<?= base_url(); ?>/dashboard">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="bi bi-house-fill text-white"></i>
    </div>
    <span class="nav-link-text ms-1">Inicio</span>
  </a>
</li>

<?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/usuarios">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-people-fill text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Usuarios</span>
    </a>
  </li>
<?php } ?>

<?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/roles">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-sliders2-vertical text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Roles</span>
    </a>
  </li>
<?php } ?>

<?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/cargos">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-book text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Cargos</span>
    </a>
  </li>
<?php } ?>

<?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/funcionariosOps">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-person-fill-gear text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Funcionarios OPS</span>
    </a>
  </li>
<?php } ?>

<?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/funcionariosPlanta">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-person-fill text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Funcionarios Planta</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/vacaciones">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-calendar-week text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Vacaciones</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url(); ?>/funcionariosviaticos">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-cash-coin text-dark"></i>
      </div>
      <span class="nav-link-text ms-1">Viáticos</span>
    </a>
  </li>
  <?php } ?>
  <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url(); ?>/archivos">
        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i class="bi bi-file-earmark text-dark"></i>
        </div>
        <span class="nav-link-text ms-1">Archivos</span>
      </a>
    </li>
  <?php } ?>
  
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
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="<?= media() ?>/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0 ">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="<?= media() ?>/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0 ">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
               
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>