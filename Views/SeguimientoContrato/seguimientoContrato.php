<?php
headerAdmin($data);
getModal('modalSeguimientoContrato', $data);
?>
<link rel="stylesheet" href="<?= media(); ?>/css/seguimiento-graficas.css">
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <h1 class="mb-0 me-4"><i class="fas fa-file-signature"></i> <?= $data['page_title'] ?></h1>
            <button class="btn btn-warning btn-sm mb-0 p-3" type="button" data-bs-toggle="modal" onclick="openModal();">
                <i class="bi bi-plus-lg"></i> Nuevo Contrato
            </button>
        </div>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/seguimientoContrato"><?= $data['page_title'] ?></a></li>
    </ul>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="seguimientoTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-contratos" data-bs-toggle="tab" data-bs-target="#contratos" type="button" role="tab" aria-controls="contratos" aria-selected="true">
            <i class="fas fa-table me-2"></i>Contratos
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-graficos" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab" aria-controls="graficos" aria-selected="false">
            <i class="fas fa-chart-bar me-2"></i>Dashboard
        </button>
      </li>
    </ul>
    
    <div class="tab-content" id="seguimientoTabsContent">
      <!-- Tab Contratos -->
      <div class="tab-pane fade show active" id="contratos" role="tabpanel" aria-labelledby="tab-contratos">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive mt-2">
                            <table class="table table-hover cell-border " id="tableSeguimientoContrato">
                                <thead class="table-success">
                                    <tr>
                                        <th class="text-center">Fecha Aprobación Entidad (Suscripción)</th>
                                        <th class="text-center">Número de Contrato</th>
                                        <th class="text-center">Objeto del Contrato</th>
                                        <th class="text-center">Fecha Inicio</th>
                                        <th class="text-center">Fecha Fin</th>
                                        <th class="text-center">Plazo</th>
                                        <th class="text-center">Valor Total del Contrato</th>
                                        <th class="text-center">Día de Corte Informe de Periodo Mensual</th>
                                        <th class="text-center">Observaciones Ejecución</th>
                                        <th class="text-center">Evidenciado Secop</th>
                                        <th class="text-center">Fecha Verificación</th>
                                        <th class="text-center">Liquidación</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
      <!-- Tab Gráficos -->
      <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="tab-graficos">
        
        <!-- Tarjetas de Métricas -->
        <div class="row mb-4">
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                      Total Contratos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalContratos">0</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      En Progreso</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="enProgreso">0</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      Finalizados</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="finalizados">0</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                      Liquidados</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="liquidados">0</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Botón para exportar todas las gráficas -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card shadow">
              <div class="card-body text-center">
                <button class="btn btn-primary btn-lg" onclick="exportAllCharts()">
                  <i class="fas fa-download me-2"></i>Exportar Todas las Gráficas
                </button>
                <p class="text-muted mt-2 mb-0">
                  <small>Descarga todas las gráficas del dashboard en formato ZIP</small>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Gráficos Principales -->
        <div class="row mb-4">
          <div class="col-lg-8">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-line me-2"></i>Evolución Temporal de Contratos
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.timeScale, 'evolucion-temporal')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.timeScale)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 400px;">
                  <canvas id="chartTimeScale"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-pie me-2"></i>Distribución por Estado
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink2">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.doughnut, 'distribucion-estado')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.doughnut)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                  <canvas id="chartDoughnutValores"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Gráficos Secundarios -->
        <div class="row mb-4">
          <div class="col-lg-6">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-bar me-2"></i>Contratos por Mes - Combo Chart
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink3">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.combo, 'contratos-mes-combo')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.combo)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                  <canvas id="chartComboMes"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-layer-group me-2"></i>Valores por Estado - Stacked Bar
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink4">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.stacked, 'valores-estado-stacked')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.stacked)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                  <canvas id="chartStackedBar"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Gráficos Adicionales -->
        <div class="row mb-4">
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-area me-2"></i>Tendencia Mensual
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink5">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.area, 'tendencia-mensual')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.area)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 250px;">
                  <canvas id="chartAreaTendencia"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-line me-2"></i>Progreso Anual
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink6">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.progress, 'progreso-anual')">
                      <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                    </a>
                    <a class="dropdown-item" href="#" onclick="printChart(charts.progress)">
                      <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative; height: 250px;">
                  <canvas id="chartProgressLine"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-bullseye me-2"></i>Resumen de Valores
                </h6>
              </div>
              <div class="card-body">
                <div class="row text-center">
                  <div class="col-6 mb-3">
                    <div class="border-end">
                      <div class="h4 text-primary" id="valorTotal">$0</div>
                      <small class="text-muted">Valor Total</small>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="h4 text-success" id="valorPromedio">$0</div>
                    <small class="text-muted">Valor Promedio</small>
                  </div>
                  <div class="col-6">
                    <div class="h4 text-warning" id="contratosActivos">0</div>
                    <small class="text-muted">Contratos Activos</small>
                  </div>
                  <div class="col-6">
                    <div class="h4 text-info" id="plazoPromedio">0</div>
                    <small class="text-muted">Plazo Promedio (meses)</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>

<script src="<?= media(); ?>/Js/chart-helpers.js"></script>
<?php footerAdmin($data); ?> 