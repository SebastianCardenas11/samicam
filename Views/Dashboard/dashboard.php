<?php headerAdmin($data);?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1>
                <i class="bi bi-house"></i>
                </i> Inicio
            </h1>
            <p>Sistema de Información para la Gestión de Módulos Académicos - SIGMA</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
    </div>
    <div class="row">

        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-6">
            <a href="<?=base_url()?>/usuarios" class="linkw">
                <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                    <div class="info">
                        <h4>Usuarios</h4>
                        <p><b><?=$data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>


        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-6">
            <a href="<?=base_url()?>/programas" class="link-info">
                <div class="widget-small info coloured-icon">
                    <i class="icon bi bi-list-stars fs-1"></i>
                    <div class="info">
                        <h4>Programas</h4>
                        <p><b><?=$data['programas']?></b></p>
                    </div>
                </div>
        </div>
        </a>
    </div>
    <?php }?>

    <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
    <div class="col-md-6 col-lg-6">
        <a href="<?=base_url()?>/fichas" class="link-info">
            <div class="widget-small warning coloured-icon">
                <i class="icon bi bi-bookmark-star"></i>
                <div class="info">
                    <h4>Fichas</h4>
                    <p><b><?=$data['fichas']?></b></p>
                </div>
            </div>
    </div>
    </a>
    </div>
    <?php }?>


    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Avance de las Fichas</h3>
                <div class="ratio ratio-16x9">
                    <div id="main" style="width: 600px; height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Horas Instructores</h3>
                <div class="ratio ratio-16x9">
                    <div id="mainInstructores" style="width: 600px; height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php footerAdmin($data);?>