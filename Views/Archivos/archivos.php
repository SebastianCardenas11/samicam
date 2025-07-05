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
                    <a href="<?= base_url(); ?>/categoriasarchivos" class="btn btn-warning ms-2"><i class="bi bi-folder"></i> Gestionar Categorías</a>
                <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house fs-6"></i></li>
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
                                <!-- Botón de debug temporal -->
                                <button class="btn btn-outline-info mb-0 ms-2" type="button" onclick="debugPermisos()">
                                    <i class="bi bi-bug"></i> Debug Permisos
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="listCategoriaFilter">Filtrar por categoría:</label>
                                <select class="form-control" id="listCategoriaFilter" onchange="fntFilterByCategoria()">
                                    <option value="0">Todas las categorías</option>
                                    <!-- Las categorías se cargarán dinámicamente -->
                                </select>
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
                                    <th>Categoría</th>
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
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="todos-tab" data-bs-toggle="tab" href="#todos" role="tab" aria-controls="todos" aria-selected="true">Todos</a>
                        </li>
                        <!-- Las pestañas de categorías se cargarán dinámicamente -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab">
                            <div class="row mt-3" id="fileExplorer">
                                <!-- Los archivos se cargarán dinámicamente aquí -->
                            </div>
                        </div>
                        <!-- El contenido de las pestañas de categorías se cargará dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php footerAdmin($data); ?>