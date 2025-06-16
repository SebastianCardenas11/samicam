<?php headerAdmin($data); ?>
<div class="row">
    <?php if (!empty($_SESSION['permisos'][2]['d'])) { ?>
    <!-- Usuarios -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/usuarios">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-users text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['usuarios']['status'] == 1?></h5>
                            <span class="text-white text-sm">Usuarios</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
    <!-- Funcionarios OPS -->
    <div class="col-lg-3 col-md-6 col-12 mb-3" >
        <a href="<?=base_url()?>/funcionariosOps">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-user-cog text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['funcionariosops']['status'] == 1 ?></h5>
                            <span class="text-white text-sm">Funcionarios OPS</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
    <!-- Funcionarios Planta -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/funcionariosPlanta">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-user-tie text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['funcionariosplanta']['status'] == 1 ?></h5>
                            <span class="text-white text-sm">Funcionarios Planta</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
    <!-- Vacaciones Activas -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/vacaciones">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-calendar-week text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas']['vacacionesActivas'] ?></h5>
                            <span class="text-white text-sm">Vacaciones Activas</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>
</div>

<div class="row mt-4">
  <!-- Gráficas de funcionarios -->
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-body p-3">
        <div class="bg-dark border-radius-md py-3 pe-1 mb-3">
          <div class="chart">
            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
          </div>
        </div>
        <h6 class="ms-2 mt-4 mb-0 text-dark">Funcionarios por Cargo</h6>
        <p class="text-sm ms-2 text-dark">Distribución de funcionarios según su cargo</p>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0">
        <h6 class="text-dark">Permisos por Mes</h6>
        <p class="text-sm text-dark">
          <i class="fa fa-calendar text-success"></i>
          <span class="font-weight-bold">Registro de permisos</span> durante el año
        </p>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<?php footerAdmin($data); ?>