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
                        <h6>Consola de Mensajes WhatsApp</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-dark"><i class="fas fa-search me-2"></i>Filtrar Mensajes</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                        <input type="text" id="busqueda-termino" class="form-control" placeholder="Buscar por usuario, mensaje, fecha...">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button id="btn-buscar" class="btn btn-primary w-100">
                                                        <i class="fas fa-search me-2"></i>Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 id="archivo-titulo" class="text-dark"><i class="fab fa-whatsapp me-2"></i>Histórico de Mensajes WhatsApp</h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <pre id="archivo-contenido" class="text-success p-3 bg-white text-dark terminal-style" style="height: 700px; overflow-y: auto; font-family: 'Consolas', monospace; font-size: 0.95rem; line-height: 1.6; margin: 0; border-radius: 0 0 0.5rem 0.5rem; border-top: 1px solid #eee;">$ cat /logs/whatsapp_log.txt</pre>
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
    .terminal-style {
        font-family: 'Consolas', 'Courier New', monospace;
        background-color: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .terminal-style .timestamp {
        color: #6c757d;
        font-size: 0.9em;
    }
    .terminal-style .user {
        color: #28a745;
    }
    .terminal-style .message {
        color: #0066cc;
    }
    .terminal-style .highlight {
        background-color: #ffff99;
        color: #000;
        padding: 2px;
        border-radius: 2px;
    }
</style> 