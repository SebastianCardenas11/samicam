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
       <?php if (!empty($_SESSION['permisos'][MDASHBOARD]['r']) && (!isset($_SESSION['permisos'][MDASHBOARD]['v']) || $_SESSION['permisos'][MDASHBOARD]['v'] == 1)) { ?>
       <li class="nav-item">
         <a class="nav-link <?= ($data['page_id'] == 1) ? 'active' : ''; ?>" href="<?= base_url(); ?>/dashboard">
           <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
             <i class="bi bi-house-fill text-dark"></i> 
           </div>
           <span class="nav-link-text ms-1">Inicio</span>
         </a>
       </li>
       <?php } ?>

       <?php if (!empty($_SESSION['permisos'][MROLES]['r']) && (!isset($_SESSION['permisos'][MROLES]['v']) || $_SESSION['permisos'][MROLES]['v'] == 1)) { ?>
         <li class="nav-item">
           <a class="nav-link <?= ($data['page_id'] == 3) ? 'active' : ''; ?>" href="<?= base_url(); ?>/roles">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-sliders2-vertical text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Roles</span>
           </a>
         </li>
       <?php } ?>
       
       <?php if (!empty($_SESSION['permisos'][MUSUARIOS]['r']) && (!isset($_SESSION['permisos'][MUSUARIOS]['v']) || $_SESSION['permisos'][MUSUARIOS]['v'] == 1)) { ?>
         <li class="nav-item">
           <a class="nav-link <?= ($data['page_id'] == 2) ? 'active' : ''; ?>" href="<?= base_url(); ?>/usuarios">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-people-fill text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Usuarios</span>
           </a>
         </li>
       <?php } ?>

       <!-- Etiqueta HTML -->
       <li class="nav-item mt-2">
         <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Recursos Humanos</h6>
       </li>

       <?php if (!empty($_SESSION['permisos'][MCARGOS]['r']) && (!isset($_SESSION['permisos'][MCARGOS]['v']) || $_SESSION['permisos'][MCARGOS]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/cargos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/cargos">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-book text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Cargos</span>
           </a>
         </li>
       <?php } ?>
       
       <?php if (!empty($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v']) || $_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v'] == 1)) { ?>
         <li class="nav-item">
           <a class="nav-link <?= ($data['page_id'] == 9) ? 'active' : ''; ?>" href="<?= base_url(); ?>/funcionariosPlanta">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-person-vcard text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Funcionarios Planta</span>
           </a>
         </li>
       <?php } ?>
       
       <?php if (!empty($_SESSION['permisos'][MFUNCIONARIOSOPS]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSOPS]['v']) || $_SESSION['permisos'][MFUNCIONARIOSOPS]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/funcionariosOps')) ? 'active' : '' ?>" href="<?= base_url(); ?>/funcionariosOps">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-person-fill-gear text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Funcionarios OPS</span>
           </a>
         </li>
       <?php } ?>

        <?php if (!empty($_SESSION['permisos'][MVACACIONES]['r']) && (!isset($_SESSION['permisos'][MVACACIONES]['v']) || $_SESSION['permisos'][MVACACIONES]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/vacaciones')) ? 'active' : '' ?>" href="<?= base_url(); ?>/vacaciones">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-calendar-week text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Vacaciones</span>
           </a>
         </li>
       <?php } ?>
       
       <?php if (!empty($_SESSION['permisos'][MVIATICOS]['r']) && (!isset($_SESSION['permisos'][MVIATICOS]['v']) || $_SESSION['permisos'][MVIATICOS]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/funcionariosviaticos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/funcionariosviaticos">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-cash-coin text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Viáticos</span>
           </a>
         </li>
       <?php } ?>

       <?php if (!empty($_SESSION['permisos'][MPERMISOS]['r']) && (!isset($_SESSION['permisos'][MPERMISOS]['v']) || $_SESSION['permisos'][MPERMISOS]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/funcionariospermisos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/funcionariospermisos">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i class="bi bi-door-open text-dark"></i>
             </div>
             <span class="nav-link-text ms-1">Permisos</span>
           </a>
         </li>
       <?php } ?>
    
       <?php if (!empty($_SESSION['permisos'][MARCHIVOS]['r']) && (!isset($_SESSION['permisos'][MARCHIVOS]['v']) || $_SESSION['permisos'][MARCHIVOS]['v'] == 1)) { ?>
         <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], '/archivos')) ? 'active' : '' ?>" href="<?= base_url(); ?>/archivos">
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