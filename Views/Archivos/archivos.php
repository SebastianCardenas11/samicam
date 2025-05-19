<?php
headerAdmin($data);
getModal('modalArchivos', $data);
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-file-earmark"></i> <?= $data['page_title'] ?>
                <?php if ($_SESSION['permisosMod']['w']) { ?>
                    <button class="btn btn-primary ms-5" type="button" onclick="openModal();"><i class="bi bi-plus-lg"></i> Agregar Archivo</button>
                <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/archivos"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Buscar archivos...">
                                <button class="btn btn-outline-secondary mb-0" type="button" onclick="fntSearchArchivo()">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableArchivos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
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

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <h3 class="mb-4">Explorador de Archivos</h3>
                    <div class="row" id="fileExplorer">
                        <!-- Los archivos se cargarán dinámicamente aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php footerAdmin($data); ?>
