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
    <ul class="nav nav-tabs mb-3" id="seguimientoTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-contratos" data-bs-toggle="tab" data-bs-target="#contratos" type="button" role="tab" aria-controls="contratos" aria-selected="true">Contratos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-graficos" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab" aria-controls="graficos" aria-selected="false">Gráficos</button>
      </li>
    </ul>
    <div class="tab-content" id="seguimientoTabsContent">
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
      <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="tab-graficos">
      
        
        <!-- Fila 2: Gráficos combinados -->
        <div class="row mb-4">
          <div class="col-lg-6">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3"><i class="fas fa-chart-bar"></i> Contratos por Mes - Combo Chart</h5>
                <canvas id="chartComboMes" height="100"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3"><i class="fas fa-layer-group"></i> Valores por Estado - Stacked Bar</h5>
                <canvas id="chartStackedBar" height="100"></canvas>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Fila 3: Gráficos adicionales -->
        <div class="row mb-4">
          <div class="col-lg-4">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3"><i class="fas fa-chart-area"></i> Tendencia Mensual</h5>
                <canvas id="chartAreaTendencia" height="120"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3"><i class="fas fa-bullseye"></i> Distribución de Valores</h5>
                <canvas id="chartDoughnutValores" height="120"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3"><i class="fas fa-chart-line"></i> Progreso Anual</h5>
                <canvas id="chartProgressLine" height="120"></canvas>
              </div>
            </div>
          </div>
        </div>
    
      </div>
    </div>
</main>
<script src="<?= media(); ?>/Js/chart-helpers.js"></script>
<?php footerAdmin($data); ?> 