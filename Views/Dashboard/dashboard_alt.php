<?php headerAdmin($data); ?>
<div class="row">
  <div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Bienvenido</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?= $_SESSION['userData']['nombres'] ?>
                                <span class="text-success text-sm font-weight-bolder"><?= $_SESSION['userData']['nombrerol'] ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['usuarios'] ?></h5>
                            <span class="text-white text-sm">Usuarios</span>
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
  <!-- Contenido alternativo: Reloj y Clima -->
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex flex-column h-100">
              <h5 class="font-weight-bolder">Hora Actual</h5>
              <div id="clock" class="display-4 text-center my-4"></div>
              <div id="date" class="h5 text-center mb-4"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex flex-column h-100">
              <h5 class="font-weight-bolder">Clima Local</h5>
              <div id="weather" class="text-center my-4">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Obteniendo información del clima...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php footerAdmin($data); ?>