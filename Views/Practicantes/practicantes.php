<?php
headerAdmin($data);
?>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <h1 class="mb-0 me-4">
                <i class="bi bi-person-workspace"></i> <?= $data['page_title'] ?>
            </h1>
            
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                <button class="btn btn-warning btn-sm px-3 py-2" type="button" onclick="openModal();">
                    <i class="bi bi-plus-lg fs-5 text-black"></i> Nuevo Practicante
                </button>
            <?php } ?>
        </div>
    </div>
    
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/practicantes"><?= $data['page_title'] ?></a></li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePracticantes">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Nombre completo</th>
                                    <th class="text-center">Identificación</th> 
                                    <th class="text-center">ARL</th>
                                    <th class="text-center">EPS</th>
                                    <th class="text-center">Edad</th>
                                    <th class="text-center">Sexo</th>
                                    <th class="text-center">Dependencia</th> 
                                    <th class="text-center">Tipo de Contrato</th> 
                                    <th class="text-center">Formación Académica</th>
                                    <th class="text-center">Programa de Estudio</th>
                                    <th class="text-center">Institución</th>
                                    <th class="text-center">Fecha Ingreso</th>
                                    <th class="text-center">Fecha Salida</th>
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
</main>

<?php getModal('modalPracticantes', $data); ?>

<?php footerAdmin($data); ?> 