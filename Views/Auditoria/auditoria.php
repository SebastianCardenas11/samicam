<?php
headerAdmin($data);
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php require_once('Views/Template/nav_admin.php'); ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Explorador de Auditoría de Inicios de Sesión</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Explorador de Archivos</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="file-explorer">
                                                <ul class="file-tree">
                                                    <?php foreach ($data['anios'] as $anio) : ?>
                                                        <li class="folder-item">
                                                            <span class="folder-toggle" data-anio="<?= $anio ?>">
                                                                <i class="fas fa-folder"></i> <?= $anio ?>
                                                            </span>
                                                            <ul class="folder-content meses-container" id="meses-<?= $anio ?>" style="display: none;"></ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 id="archivo-titulo">Contenido del Archivo</h6>
                                                <button id="btn-descargar" class="btn btn-sm btn-primary" style="display: none;">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <pre id="archivo-contenido" class="p-3 bg-light" style="max-height: 500px; overflow-y: auto;">Seleccione un archivo para ver su contenido.</pre>
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
</main>

<?php footerAdmin($data); ?>

<style>
    .file-tree {
        list-style: none;
        padding-left: 0;
    }
    
    .file-tree ul {
        list-style: none;
        padding-left: 20px;
    }
    
    .folder-item, .file-item {
        padding: 5px 0;
    }
    
    .folder-toggle {
        cursor: pointer;
    }
    
    .folder-toggle:hover {
        color: #5e72e4;
    }
    
    .file-item {
        cursor: pointer;
    }
    
    .file-item:hover {
        color: #5e72e4;
    }
    
    .file-item.active {
        font-weight: bold;
        color: #5e72e4;
    }
</style>