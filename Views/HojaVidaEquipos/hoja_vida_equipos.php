<?php 
headerAdmin($data); 
getModal('modalViewEquipo', $data);
getModal('modalSeleccionEquipo', $data);
getModal('modalMantenimiento', $data);
?>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-desktop"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/hoja_vida_equipos"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4>Inventario de Equipos</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" type="button" onclick="fntNuevoMantenimiento()">
                                <i class="fas fa-tools"></i> Nuevo Mantenimiento
                            </button>
                            <button class="btn btn-warning" type="button" onclick="fntPdfMantenimientos()">
                                <i class="fas fa-wrench"></i> PDF Mantenimientos
                            </button>
                            <button class="btn btn-success" type="button" onclick="fntPdfTodos()">
                                <i class="fas fa-file-pdf"></i> PDF Equipos
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableEquipos">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php footerAdmin($data); ?>