<?php headerAdmin($data);?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1>
                <i class="bi bi-house"></i>
                </i> Inicio
            </h1>
            <p> Sistema Administrativo de Módulos de Información del Centro Administrativo</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
    </div>

    <style>
        h4{
            color: #000 !important;
        }
    </style>
    <!-- Widgets de resumen -->
    <div class="row">
        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
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

        <?php if (!empty($_SESSION['permisos'][4]['r'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/funcionariosOps" class="linkw">
                <div class="widget-small info coloured-icon">
                    <i class="icon bi bi-person-fill-gear fs-1"></i>
                    <div class="info">
                        <h4>Funcionarios OPS</h4>
                        <p><b><?=$data['funcionariosops']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>

        <?php if (!empty($_SESSION['permisos'][5]['r'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/funcionariosPlanta" class="linkw">
                <div class="widget-small warning coloured-icon">
                    <i class="icon bi bi-person-fill fs-1"></i>
                    <div class="info">
                        <h4>Funcionarios Planta</h4>
                        <p><b><?=$data['funcionariosplanta']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>

        <?php if (!empty($_SESSION['permisos'][5]['r'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/vacaciones" class="linkw">
                <div class="widget-small danger coloured-icon">
                    <i class="icon bi bi-calendar-week fs-1"></i>
                    <div class="info">
                        <h4>Vacaciones Activas</h4>
                        <p><b><?=$data['estadisticas']['vacacionesActivas']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>
    </div>

    <!-- Gráficas -->
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title">Funcionarios por Cargo</h3>
                </div>
                <div class="tile-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="graficaFuncionariosPorCargo"></canvas>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title">Funcionarios por Tipo de Contrato</h3>
                </div>
                <div class="tile-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="graficaFuncionariosPorTipoContrato"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

    
</main>

<?php footerAdmin($data);?>