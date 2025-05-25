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
                                <div class="col-md-6">
                                    <div class="">
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
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 id="archivo-titulo" class="text-dark"><i class="fas fa-terminal me-2"></i>Visor de Acciones</h6>
                                                <button id="btn-descargar" class="btn btn-sm btn-outline-primary" style="display: none;">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <pre id="archivo-contenido" class="p-3 bg-white text-dark terminal-style" style="height: 700px; overflow-y: auto; font-family: 'Consolas', monospace; font-size: 0.95rem; line-height: 1.6; margin: 0; border-radius: 0 0 0.5rem 0.5rem; border-top: 1px solid #eee;">$ cat /logs/system
> Seleccione un archivo para ver su contenido...</pre>
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
        font-size: 1.1rem;
    }
    
    .file-tree ul {
        list-style: none;
        padding-left: 25px;
    }
    
    .folder-item, .file-item {
        padding: 8px 0;
    }
    
    .folder-toggle {
        cursor: pointer;
        display: block;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .folder-toggle:hover {
        color: #5e72e4;
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    .file-item {
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .file-item:hover {
        color: #5e72e4;
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    .file-item.active {
        font-weight: bold;
        color: #5e72e4;
        background-color: rgba(94, 114, 228, 0.15);
    }
    
    .folder-toggle-mes {
        cursor: pointer;
        display: block;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .folder-toggle-mes:hover {
        color: #5e72e4;
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    .terminal-style {
        font-family: 'Consolas', 'Courier New', monospace;
        background-color: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .terminal-style .command {
        color: #0066cc;
        font-weight: 500;
    }
    
    .terminal-style .path {
        color: #28a745;
    }
    
    .terminal-style .timestamp {
        color: #6c757d;
        font-size: 0.9em;
    }
    
    .terminal-style .error {
        color: #dc3545;
    }
    
    .terminal-style .warning {
        color: #fd7e14;
    }
    
    .terminal-style .info {
        color: #17a2b8;
    }
    
    .terminal-style .success {
        color: #28a745;
    }
</style>