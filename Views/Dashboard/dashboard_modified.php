<?php headerAdmin($data); ?>
<style>
    .h{
        height: 100% !important;
    }
    .dashboard-card {
      background: #233554;
      color: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(44,62,80,0.08);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 24px 20px;
      margin-bottom: 0;
      min-height: 120px;
      transition: box-shadow 0.2s;
      text-decoration: none;
    }
    .dashboard-card:hover {
      box-shadow: 0 4px 16px rgba(44,62,80,0.16);
      text-decoration: none;
    }
    .dashboard-card h4 {
      color: #fff;
      font-size: 2.2rem;
      font-weight: bold;
      margin-bottom: 0.2em;
    }
    .dashboard-card p {
      color: #fff;
      font-size: 1.1rem;
      margin-bottom: 0;
    }
    .dashboard-card .icon {
      background: #e5e9f2;
      color: #233554;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-right: 16px;
    }
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Tarjetas a la izquierda -->
    <div class="col-lg-12 d-flex flex-wrap align-content-stretch" style="gap: 20px;">
      <?php if (!empty($_SESSION['permisos'][2]['d'])) { ?>
      <a href="<?=base_url()?>/usuarios" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-users"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= $data['usuarios'] ?? '0' ?></h4>
        </div>
        <p class="mb-0">Usuarios Activos</p>
      </a>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
      <a href="<?=base_url()?>/funcionariosOps" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-user-cog"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= $data['funcionariosops'] ?? '0' ?></h4>
        </div>
        <p class="mb-0">Funcionarios OPS</p>
      </a>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
      <a href="<?=base_url()?>/funcionariosPlanta" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-user-tie"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= $data['funcionariosplanta'] ?? '0' ?></h4>
        </div>
        <p class="mb-0">Funcionarios Planta</p>
      </a>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
      <a href="<?=base_url()?>/vacaciones" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-calendar-week"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= $data['estadisticas']['vacacionesActivas'] ?? '0' ?></h4>
        </div>
        <p class="mb-0">Vacaciones Activas</p>
      </a>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][14]['r'])) { ?>
      <a href="<?=base_url()?>/seguimientoContrato" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-file-contract"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= isset($data['contratos_seguimiento']) ? $data['contratos_seguimiento'] : '--' ?></h4>
        </div>
        <p class="mb-0">Seguimiento de Contrato</p>
      </a>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][10]['r'])) { ?>
      <a href="<?=base_url()?>/practicantes" class="dashboard-card" style="flex: 1 1 30%; min-width: 250px; max-width: 32%;">
        <div class="d-flex align-items-center mb-2">
          <span class="icon"><i class="fa fa-user-graduate"></i></span>
          <h4 class="mb-0" style="color:#fff;"><?= isset($data['practicantes']) ? $data['practicantes'] : '--' ?></h4>
        </div>
        <p class="mb-0">Practicantes</p>
      </a>
      <?php } ?>
    </div>
  </div>
  <!-- Estadísticas de Viáticos debajo de las cards -->
  <?php if (!empty($_SESSION['permisos'][14]['r']) || !empty($_SESSION['permisos'][10]['r'])) { ?>
  <div class="row mt-4">
    <div class="col-12">
      <div class="card h">
        <div class="card-body">
          <h5>Estadísticas de Viáticos</h5>
          <div>
            <p>Total Presupuesto <span class="float-end">$<?= number_format($data['estadisticas_viaticos']['capital_total'] ?? 0, 0, ',', '.') ?></span></p>
            <div class="progress mb-2">
              <div class="progress-bar" style="background:#ff8800; width: 100%"></div>
            </div>
            <p>Gastado <span class="float-end">$<?= number_format($data['estadisticas_viaticos']['capital_gastado'] ?? 0, 0, ',', '.') ?> (<?= $data['estadisticas_viaticos']['porcentaje_gastado'] ?? 0 ?>%)</span></p>
            <div class="progress mb-2">
              <div class="progress-bar" style="background:#ff8800; width: <?= $data['estadisticas_viaticos']['porcentaje_gastado'] ?? 0 ?>%"></div>
            </div>
            <p>Disponible <span class="float-end">$<?= number_format($data['estadisticas_viaticos']['capital_disponible'] ?? 0, 0, ',', '.') ?> (<?= $data['estadisticas_viaticos']['porcentaje_disponible'] ?? 0 ?>%)</span></p>
            <div class="progress mb-2">
              <div class="progress-bar bg-success" style="width: <?= $data['estadisticas_viaticos']['porcentaje_disponible'] ?? 0 ?>%"></div>
            </div>
          </div>
          <p class="mt-3 text-muted" style="font-size: 0.9em;">
            Estadísticas de viáticos del año actual.
          </p>
          <a  class="btn btn-dark" href="<?=base_url();?>/funcionariosviaticos">Ver detalles</a>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<div class="row mt-4">
  <!-- Fila 1: Ingresos y Funcionarios por Cargo -->
  <div class="row mt-4">
    <!-- Gráfico Ingresos de Practicantes y Funcionarios -->
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6>Ingresos de Practicantes y Funcionarios</h6>
          <p class="text-sm">
            <i class="fa fa-arrow-up text-warning"></i>
            <span class="font-weight-bold">Ingresos por mes</span> en el año actual
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart" style="width:100%;">
            <canvas id="chart-ingresos" class="chart-canvas" height="300" style="width:100% !important;"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Gráfico Funcionarios por Cargo (con estilo de card) -->
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6>Funcionarios por Cargo</h6>
          <p class="text-sm">
            <i class="fa fa-users text-primary"></i>
            <span class="font-weight-bold">Distribución de funcionarios</span> según su cargo
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart" style="width:100%; height:300px; position:relative;">
            <canvas id="chart-bars" class="chart-canvas" style="width:100% !important; height:100% !important;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fila 2: Tabla + Bubble Chart (Permisos por Mes) -->
  <div class="row mt-4">
    <!-- Derecha: Tabla y Bubble Chart -->
    <div class="col-lg-6 mb-4 d-flex flex-column justify-content-between">
      <div class="card mb-4 flex-grow-1">
        <div class="card-header pb-0">
          <h6>Últimos 5 Permisos</h6>
        </div>
        <div class="card-body p-3">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Funcionario</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Motivo</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($data['ultimos_permisos']) && count($data['ultimos_permisos']) > 0): ?>
                  <?php foreach($data['ultimos_permisos'] as $permiso): ?>
                    <tr>
                      <td class="text-sm"> <?= htmlspecialchars($permiso['funcionario_cargo'] ?? 'N/A') ?> </td>
                      <td class="text-sm"> <?= htmlspecialchars($permiso['motivo'] ?? 'N/A') ?> </td>
                      <td class="text-sm"> 
                        <?php 
                        $estado = $permiso['estado'] ?? 'Desconocido';
                        $badgeClass = '';
                        switch($estado) {
                            case 'Aprobado':
                                $badgeClass = 'bg-success';
                                break;
                            case 'Pendiente':
                                $badgeClass = 'bg-warning';
                                break;
                            case 'Rechazado':
                                $badgeClass = 'bg-danger';
                                break;
                            default:
                                $badgeClass = 'bg-secondary';
                        }
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center">No hay permisos recientes.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Izquierda: Bubble Chart con información de permisos por mes -->
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6>Permisos por Mes (Bubble Chart)</h6>
          <p class="text-sm">
            <i class="fa fa-chart-bubble text-info"></i>
            <span class="font-weight-bold">Visualización avanzada de permisos</span>
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart" style="width:100%;">
            <canvas id="chart-bubble" class="chart-canvas" height="300" style="width:100% !important;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Agregar el canvas faltante para chart-line -->
<div class="row mt-4" style="display: none;">
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