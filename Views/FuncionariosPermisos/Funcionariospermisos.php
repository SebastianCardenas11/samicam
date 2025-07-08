<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-door-open"></i> <?=$data['page_title']?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/funcionariospermisos"><?=$data['page_title']?></a></li>
        </ul>
    </div>

    <!-- Panel de Control de Permisos Diarios -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card permisos-panel">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white"><i class="bi bi-calendar-check"></i> Control de Permisos Diarios</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center contador-permisos permisos-disponibles">
                                <h4 class="text-primary" id="permisosDisponibles" data-max="<?= MAX_PERMISOS_DIARIOS ?>"><?= MAX_PERMISOS_DIARIOS ?></h4>
                                <p class="text-muted">Permisos Disponibles por Día</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center contador-permisos permisos-usados">
                                <h4 class="text-success" id="permisosUsados">0</h4>
                                <p class="text-muted">Permisos Usados Hoy</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center contador-permisos tiempo-restante">
                                <h4 class="text-info" id="tiempoRestante">--:--:--</h4>
                                <p class="text-muted">Tiempo para Reset</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" id="barraProgreso" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?= MAX_PERMISOS_DIARIOS ?>">
                                    <span id="textoProgreso">0/<?= MAX_PERMISOS_DIARIOS ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p class="mb-0"><i class="bi bi-info-circle"></i> La entidad permite un máximo de <strong><?= MAX_PERMISOS_DIARIOS ?> permisos diarios</strong> por fecha específica. Cada funcionario puede tener hasta <strong>3 permisos por mes</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Gestión de Motivos -->
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <a href="<?= base_url(); ?>/motivopermiso" class="btn btn-warning">
                <i class="fas fa-cogs"></i> Gestión de Motivos
            </a>
        </div>
    </div>

    <!-- Tabs para lista y estadísticas -->
    <ul class="nav nav-tabs mb-3" id="funcionariosPermisosTabs" role="tablist" style="margin-top: 1rem;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-lista-func" data-bs-toggle="tab" data-bs-target="#tabListaFunc" type="button" role="tab" aria-controls="tabListaFunc" aria-selected="true">Lista de Funcionarios</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-estadisticas-func" data-bs-toggle="tab" data-bs-target="#tabEstadisticasFunc" type="button" role="tab" aria-controls="tabEstadisticasFunc" aria-selected="false">Estadísticas</button>
        </li>
    </ul>
    <div class="tab-content" id="funcionariosPermisosTabsContent">
        <div class="tab-pane fade show active" id="tabListaFunc" role="tabpanel" aria-labelledby="tab-lista-func">
            <div class="table-responsive">
                <table class="table table-estilo" id="tableFuncionarios">
                    <thead class="table-success">
                        <tr>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Identificación</th> 
                            <th class="text-center">Cargo</th> 
                            <th class="text-center">Dependencia</th> 
                            <th class="text-center">Permisos</th>
                            <th class="text-center">Acciones</th>
                     </tr>
                    </thead>
                    <tbody class="table-group-divider text-center">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="tabEstadisticasFunc" role="tabpanel" aria-labelledby="tab-estadisticas-func">
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm" style="background:#f8f9fa;">
                        <div class="card-body p-3">
                            <div class="h5 mb-1" id="resumenTotalPermisos">0</div>
                            <div class="text-muted small">Permisos en total</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm" style="background:#f8f9fa;">
                        <div class="card-body p-3">
                            <div class="h5 mb-1" id="resumenPermisosAnio">0</div>
                            <div class="text-muted small">Permisos este año</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm" style="background:#f8f9fa;">
                        <div class="card-body p-3">
                            <div class="h5 mb-1" id="resumenPermisosMes">0</div>
                            <div class="text-muted small">Permisos este mes</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm" style="background:#f8f9fa;">
                        <div class="card-body p-3">
                            <div class="h5 mb-1" id="resumenPermisosHoy">0</div>
                            <div class="text-muted small">Permisos hoy</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filtroAnioEstadisticasFunc">Año</label>
                    <select class="form-control" id="filtroAnioEstadisticasFunc"></select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-2">
                    <div class="card" style="margin-bottom: 0.5rem; width: 100%;">
                        <div class="card-header py-2" style="font-size: 1rem;">Funcionarios con más permisos por mes</div>
                        <div class="card-body p-2" style="padding: 0.5rem;">
                            <canvas id="chartPermisosPorMesFunc" style="height:160px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card" style="margin-bottom: 0.5rem; width: 100%;">
                        <div class="card-header py-2" style="font-size: 1rem;">Cantidad de permisos por funcionario (TOP 5)</div>
                        <div class="card-body p-2" style="padding: 0.5rem;">
                            <canvas id="chartPermisosPorFuncionarioFunc" style="height:160px; max-width: 100%;"></canvas>
                            <div class="mt-2">
                                <table class="table table-sm table-bordered" id="tablaTop5Funcionarios">
                                    <thead>
                                        <tr>
                                            <th>Funcionario</th>
                                            <th>Permisos</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card" style="margin-bottom: 0.5rem; width: 100%;">
                        <div class="card-header py-2" style="font-size: 1rem;">Dependencia con más permisos</div>
                        <div class="card-body p-2" style="padding: 0.5rem;">
                            <canvas id="chartPermisosPorDependenciaFunc" style="height:160px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
getModal('modalFuncionariosPermisos', $data);
footerAdmin($data);
?>