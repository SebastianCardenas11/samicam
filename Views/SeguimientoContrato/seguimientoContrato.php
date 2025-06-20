<?php
headerAdmin($data);
getModal('modalSeguimientoContrato', $data);
?>
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
                                        <th class="text-center">Objeto del Contrato</th>
                                        <th class="text-center">Fecha Inicio</th>
                                        <th class="text-center">Fecha Fin</th>
                                        <th class="text-center">Valor Total</th>
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
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
                <h5 class="mb-3">Gráfico de contratos por mes </h5>
                <canvas id="chartContratosMes" height="100"></canvas>
                <hr>
                <h5 class="mb-3">Contratos activos vs inactivos</h5>
                <div style="max-width:350px;margin:0 auto;">
                  <canvas id="chartContratosActivos" height="60"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>
<?php footerAdmin($data); ?> 