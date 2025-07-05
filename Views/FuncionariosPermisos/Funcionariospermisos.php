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
                                <h4 class="text-primary" id="permisosDisponibles">5</h4>
                                <p class="text-muted">Permisos Disponibles</p>
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
                                <div class="progress-bar bg-success" id="barraProgreso" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="5">
                                    <span id="textoProgreso">0/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="tile-body">
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
            </div>
        </div>
    </div>
</main>

<?php 
getModal('modalFuncionariosPermisos', $data);
footerAdmin($data);
?>