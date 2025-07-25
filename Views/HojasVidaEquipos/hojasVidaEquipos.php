<?php
    headerAdmin($data);
?>
<link rel="stylesheet" href="<?= media() ?>/css/hojas-vida-equipos.css">
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-file-medical"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/hojasVidaEquipos"><?= $data['page_name'] ?></a></li>
        </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="card hoja-vida-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-list"></i> Lista de Equipos</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablaHojasVida" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tipo de Equipo</th>
                                            <th>Número/ID</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Estado</th>
                                            <th>Disponibilidad</th>
                                            <th>Total Movimientos</th>
                                            <th>Último Movimiento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los datos se cargan dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para mostrar hoja de vida -->
<div class="modal fade" id="modalHojaVida" tabindex="-1" aria-labelledby="modalHojaVidaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalHojaVidaLabel">
                    <i class="fas fa-file-medical"></i> Hoja de Vida del Equipo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="contenidoHojaVida">
                    <!-- El contenido se carga dinámicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="generarPDFHojaVida()">
                    <i class="fas fa-file-pdf"></i> Generar PDF
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>