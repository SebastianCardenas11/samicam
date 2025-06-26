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
      <!-- <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-resumen" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab" aria-controls="resumen" aria-selected="false">
            <i class="fas fa-info-circle me-2"></i>Resumen
        </button>
      </li> -->
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-graficos" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab" aria-controls="graficos" aria-selected="false">
            <i class="fas fa-chart-bar me-2"></i>Graficos
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-vencimientos" data-bs-toggle="tab" data-bs-target="#vencimientos" type="button" role="tab" aria-controls="vencimientos" aria-selected="false">
            <i class="fas fa-calendar-times me-2"></i>Vencimientos
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-valor" data-bs-toggle="tab" data-bs-target="#valor" type="button" role="tab" aria-controls="valor" aria-selected="false">
            <i class="fas fa-chart-area me-2"></i>Análisis de Valor
        </button>
      </li>
    
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="liquidaciones-tab-btn" data-bs-toggle="tab" data-bs-target="#liquidaciones-tab" type="button" role="tab" aria-controls="liquidaciones-tab" aria-selected="false">
            <i class="fas fa-file-invoice-dollar me-2"></i>Liquidaciones Detalle
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-historial-prorrogas" data-bs-toggle="tab" data-bs-target="#historial-prorrogas" type="button" role="tab" aria-controls="historial-prorrogas" aria-selected="false">
            <i class="fas fa-history me-2"></i>Historial de Prórrogas
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
        <!-- Tarjetas de Métricas (antes estaban en Resumen) -->
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
                      En Ejecucion</div>
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
        <!-- Gráficos Principales -->
        <div class="row mb-4">
          <div class="col-lg-8">
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-line me-2"></i>Evolución Temporal de Contratos
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
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
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-pie me-2"></i>Distribución por Tipo de Plazo
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink2">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.doughnut, 'distribucion-tipo-plazo')">
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
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-bar me-2"></i>Contratos por Mes
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
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
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-layer-group me-2"></i>Valores por Estado 
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
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
          <div class="col-lg-12">
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-area me-2"></i>Tendencia Mensual
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
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
          
          
          
        
          <div class="col-lg-12 mt-4">
            <div class="card shadow mb-4 h-100">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-chart-line me-2"></i>Progreso Anual
                </h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
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
          
           <!-- Botón para exportar todas las gráficas -->
        <div class="row mb-4 mt-4">
          <div class="col-lg-12">
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
        </div>
      </div>

      <!-- Tab Vencimientos -->
      <div class="tab-pane fade" id="vencimientos" role="tabpanel" aria-labelledby="tab-vencimientos">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4>Contratos Próximos a Vencer</h4>
                            <div class="d-flex align-items-center">
                                <label for="selectVencimiento" class="form-label me-2 mb-0">Ver contratos que vencen en:</label>
                                <select class="form-select" id="selectVencimiento" style="width: auto;">
                                    <option value="0" selected>Vencen Hoy</option>
                                    <option value="7">Próximos 7 días</option>
                                    <option value="15">Próximos 15 días</option>
                                    <option value="30" >Próximos 30 días</option>
                                    <option value="60">Próximos 60 días</option>
                                    <option value="90">Próximos 90 días</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tableVencimientos">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Número de Contrato</th>
                                        <th>Objeto del Contrato</th>
                                        <th>Fecha de Terminación</th>
                                        <th>Días Restantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Filas se insertarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
      <!-- Tab Análisis de Valor -->
      <div class="tab-pane fade" id="valor" role="tabpanel" aria-labelledby="tab-valor">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <h4>Análisis de Valor de los Contratos</h4>
                        <div class="row mt-4">
                            <!-- Tarjeta Valor Total -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Valor Total Contratado</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="valorTotalContratado">$ 0.00</div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tarjeta Valor Promedio -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Valor Promedio por Contrato</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="valorPromedioContrato">$ 0.00</div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-balance-scale fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tarjeta Contratos Activos -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Contratos Activos (En Progreso)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="contratosActivos">0</div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-play-circle fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <!-- Tarjeta Plazo Promedio -->
                             <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-secondary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Plazo Promedio (Días)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="plazoPromedio">0</div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-hourglass-half fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-bar me-2"></i>Valor de Contratos por Estado</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-container" style="position: relative; height: 350px;">
                                            <canvas id="chartValorPorEstado"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- Tab Liquidaciones Detalle -->
      <div class="tab-pane fade" id="liquidaciones-tab" role="tabpanel" aria-labelledby="liquidaciones-tab-btn">
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
                <!-- Tarjetas de Métricas -->
                <div class="row mb-4">
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Liquidado</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-liquidado">$0.00</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendiente Liquidación</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="pendiente-liquidacion">$0.00</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Promedio Liquidación</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="promedio-liquidacion">$0.00</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tiempo Promedio</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="tiempo-promedio">0 días</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-stopwatch fa-2x text-gray-300"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Gráficos -->
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card shadow mb-4">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Evolución de Liquidaciones</h6>
                        <div class="dropdown no-arrow">
                          <a class="dropdown-toggle" href="#" role="button" id="dropdownLiquidacionesArea" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownLiquidacionesArea">
                            <div class="dropdown-header">Opciones:</div>
                            <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.liquidacionesArea, 'evolucion-liquidaciones')">
                              <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                            </a>
                            <a class="dropdown-item" href="#" onclick="printChart(charts.liquidacionesArea)">
                              <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart-area">
                          <canvas id="chartLiquidacionesArea"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card shadow mb-4">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Distribución por Mes</h6>
                        <div class="dropdown no-arrow">
                          <a class="dropdown-toggle" href="#" role="button" id="dropdownLiquidacionesBar" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog fa-sm fa-fw text-gray-400"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownLiquidacionesBar">
                            <div class="dropdown-header">Opciones:</div>
                            <a class="dropdown-item" href="#" onclick="exportChartAsImage(charts.liquidacionesBar, 'distribucion-liquidaciones')">
                              <i class="fas fa-download fa-sm fa-fw me-2 text-gray-400"></i>Exportar Imagen
                            </a>
                            <a class="dropdown-item" href="#" onclick="printChart(charts.liquidacionesBar)">
                              <i class="fas fa-print fa-sm fa-fw me-2 text-gray-400"></i>Imprimir
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart-bar">
                          <canvas id="chartLiquidacionesBar"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Tabla de Detalle -->
                <div class="row mb-2">
                  <div class="col-lg-12 d-flex justify-content-end">
                    <a href="<?= base_url(); ?>/SeguimientoContrato/exportarLiquidacionesExcel" class="btn btn-success mb-2" target="_blank">
                      <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card shadow mb-4">
                      <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detalle de Liquidaciones</h6>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="tabla-liquidaciones">
                            <thead>
                              <tr>
                                <th>Contrato</th>
                                <th>Valor</th>
                                <th>Total Liquidado</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Liquidación</th>
                                <th>Días</th>
                                <th>Estado</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab Historial de Prórrogas -->
      <div class="tab-pane fade" id="historial-prorrogas" role="tabpanel" aria-labelledby="tab-historial-prorrogas">
        <div class="tile">
          <div class="tile-body">
            <div class="table-responsive mt-2">
              <table class="table table-hover table-bordered table-sm align-middle" id="tablaHistorialProrrogasGeneral">
                <thead class="table-info text-center">
                  <tr>
                    <th>Número de Contrato</th>
                    <th>Objeto del Contrato</th>
                    <th>Fecha anterior</th>
                    <th>Nueva fecha</th>
                    <th>Días</th>
                    <th>Motivo</th>
                    <th>Registrado</th>
                  </tr>
                </thead>
                <tbody class="text-center align-middle">
                  <!-- Aquí se cargará el historial general por JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
</main>

<script src="<?= media(); ?>/Js/chart-helpers.js"></script>
<?php footerAdmin($data); ?> 