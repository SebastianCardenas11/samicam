<?php
    headerAdmin($data);
    getModal('modalInventario', $data);
?>
<style>
/* Estilo personalizado para tabs tipo "borde inferior" y resaltado */
.nav-tabs.custom-tabs {
    border-bottom: 1.5px solid #e0e0e0;
    background: #f7f7f9;
    padding: 0.5rem 1rem 0 1rem;
    border-radius: 8px 8px 0 0;
}
.nav-tabs.custom-tabs .nav-link {
    color: #0d3878;
    font-weight: 500;
    background: none;
    border: none;
    border-radius: 0.5rem 0.5rem 0 0;
    margin-right: 0.5rem;
    padding: 0.6rem 1.2rem 0.6rem 1.1rem;
    display: flex;
    align-items: center;
    transition: background 0.2s, color 0.2s;
}
.nav-tabs.custom-tabs .nav-link i {
    margin-right: 0.5em;
    font-size: 1.1em;
}
.nav-tabs.custom-tabs .nav-link.active {
    background: #fff;
    color: #222;
    border: 1.5px solid #e0e0e0;
    border-bottom: 2.5px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    font-weight: bold;
    z-index: 2;
}
.nav-tabs.custom-tabs .nav-link:not(.active):hover {
    background: #eaf1fb;
    color: #0d3878;
}
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-boxes"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/inventario"><?= $data['page_name'] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs custom-tabs card-header-tabs" id="inventarioTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="impresoras-tab" data-bs-toggle="tab" data-bs-target="#impresoras" type="button" role="tab" aria-controls="impresoras" aria-selected="true">
                                                <i class="fas fa-print"></i> Impresoras
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="escaneres-tab" data-bs-toggle="tab" data-bs-target="#escaneres" type="button" role="tab" aria-controls="escaneres" aria-selected="false">
                                                <i class="fas fa-scanner"></i> Escáneres
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="papeleria-tab" data-bs-toggle="tab" data-bs-target="#papeleria" type="button" role="tab" aria-controls="papeleria" aria-selected="false">
                                                <i class="fas fa-paperclip"></i> Papelería
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tintas-toner-tab" data-bs-toggle="tab" data-bs-target="#tintas-toner" type="button" role="tab" aria-controls="tintas-toner" aria-selected="false">
                                                <i class="fas fa-tint"></i> Tintas y Tóner
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pc-torre-tab" data-bs-toggle="tab" data-bs-target="#pc-torre" type="button" role="tab" aria-controls="pc-torre" aria-selected="false">
                                                <i class="fas fa-desktop"></i> PC Torre
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="todo-en-uno-tab" data-bs-toggle="tab" data-bs-target="#todo-en-uno" type="button" role="tab" aria-controls="todo-en-uno" aria-selected="false">
                                                <i class="fas fa-tv"></i> PC Todo en Uno
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="portatiles-tab" data-bs-toggle="tab" data-bs-target="#portatiles" type="button" role="tab" aria-controls="portatiles" aria-selected="false">
                                                <i class="fas fa-laptop"></i> Portátiles
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="herramientas-tab" data-bs-toggle="tab" data-bs-target="#herramientas" type="button" role="tab" aria-controls="herramientas" aria-selected="false">
                                                <i class="fas fa-tools"></i> Herramientas
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="inventarioTabsContent">
                                        <!-- Pestaña Impresoras -->
                                        <div class="tab-pane fade show active" id="impresoras" role="tabpanel" aria-labelledby="impresoras-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-print"></i> Gestión de Impresoras</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalImpresora()">
                                                                    <i class="fas fa-plus"></i> Nueva Impresora
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaImpresoras')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaImpresoras')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaImpresoras" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Número</th>
                                                                    <th>Marca</th>
                                                                    <th>Modelo</th>
                                                                    <th>Serial</th>
                                                                    <th>Consumible</th>
                                                                    <th>Estado</th>
                                                                    <th>Disponibilidad</th>
                                                                    <th>Dependencia</th>
                                                                    <th>Oficina</th>
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

                                        <!-- Pestaña Escáneres -->
                                        <div class="tab-pane fade" id="escaneres" role="tabpanel" aria-labelledby="escaneres-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-scanner"></i> Gestión de Escáneres</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalEscaner()">
                                                                    <i class="fas fa-plus"></i> Nuevo Escáner
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaEscaneres')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaEscaneres')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaEscaneres"  style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Número</th>
                                                                    <th>Marca</th>
                                                                    <th>Modelo</th>
                                                                    <th>Serial</th>
                                                                    <th>Estado</th>
                                                                    <th>Disponibilidad</th>
                                                                    <th>Dependencia</th>
                                                                    <th>Oficina</th>
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

                                        <!-- Pestaña Papelería -->
                                        <div class="tab-pane fade" id="papeleria" role="tabpanel" aria-labelledby="papeleria-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-paperclip"></i> Gestión de Papelería</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalPapeleria()">
                                                                    <i class="fas fa-plus"></i> Nuevo Artículo
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaPapeleria')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaPapeleria')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaPapeleria" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>Disponibilidad</th>
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

                                        <!-- Pestaña Tintas y Tóner -->
                                        <div class="tab-pane fade" id="tintas-toner" role="tabpanel" aria-labelledby="tintas-toner-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-tint"></i> Gestión de Tintas y Tóner</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalTintaToner()">
                                                                    <i class="fas fa-plus"></i> Nuevo Tinta/Tóner
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaTintasToner')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaTintasToner')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaTintasToner" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>Disponibles</th>
                                                                    <th>Impresora</th>
                                                                    <th>Modelos Compatibles</th>
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

                                        <!-- Pestaña PC Torre -->
                                        <div class="tab-pane fade" id="pc-torre" role="tabpanel" aria-labelledby="pc-torre-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-desktop"></i> Gestión de PC Torre</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalPcTorre()">
                                                                    <i class="fas fa-plus"></i> Nuevo PC Torre
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaPcTorre')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaPcTorre')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaPcTorre" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Número</th>
                                                                    <th>Marca</th>
                                                                    <th>Serial</th>
                                                                    <th>Modelo</th>
                                                                    <th>RAM</th>
                                                                    <th>Velocidad RAM</th>
                                                                    <th>Procesador</th>
                                                                    <th>Velocidad Proc.</th>
                                                                    <th>Disco Duro</th>
                                                                    <th>Capacidad</th>
                                                                    <th>Sistema Operativo</th>
                                                                    <th>N° Activo</th>
                                                                    <th>Monitor</th>
                                                                    <th>N° Activo Monitor</th>
                                                                    <th>Serial Monitor</th>
                                                                    <th>Estado</th>
                                                                    <th>Disponibilidad</th>
                                                                    <th>Dependencia</th>
                                                                    <th>Oficina</th>
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

                                        <!-- Pestaña PC Todo en Uno -->
                                        <div class="tab-pane fade" id="todo-en-uno" role="tabpanel" aria-labelledby="todo-en-uno-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-tv"></i> Gestión de PC Todo en Uno</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalTodoEnUno()">
                                                                    <i class="fas fa-plus"></i> Nuevo PC Todo en Uno
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaTodoEnUno')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaTodoEnUno')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaTodoEnUno" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Número</th>
                                                                    <th>Marca</th>
                                                                    <th>Modelo</th>
                                                                    <th>RAM</th>
                                                                    <th>Velocidad RAM</th>
                                                                    <th>Procesador</th>
                                                                    <th>Velocidad Proc.</th>
                                                                    <th>Disco Duro</th>
                                                                    <th>Capacidad</th>
                                                                    <th>Serial</th>
                                                                    <th>Sistema Operativo</th>
                                                                    <th>N° Activo</th>
                                                                    <th>Estado</th>
                                                                    <th>Disponibilidad</th>
                                                                    <th>Dependencia</th>
                                                                    <th>Oficina</th>
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

                                        <!-- Pestaña Portátiles -->
                                        <div class="tab-pane fade" id="portatiles" role="tabpanel" aria-labelledby="portatiles-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-laptop"></i> Gestión de Portátiles</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalPortatil()">
                                                                    <i class="fas fa-plus"></i> Nuevo Portátil
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaPortatiles')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaPortatiles')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaPortatiles" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Número</th>
                                                                    <th>Marca</th>
                                                                    <th>Modelo</th>
                                                                    <th>RAM</th>
                                                                    <th>Velocidad RAM</th>
                                                                    <th>Procesador</th>
                                                                    <th>Velocidad Proc.</th>
                                                                    <th>Disco Duro</th>
                                                                    <th>Capacidad</th>
                                                                    <th>Serial</th>
                                                                    <th>Sistema Operativo</th>
                                                                    <th>N° Activo</th>
                                                                    <th>Estado</th>
                                                                    <th>Disponibilidad</th>
                                                                    <th>Dependencia</th>
                                                                    <th>Oficina</th>
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

                                        <!-- Pestaña Herramientas -->
                                        <div class="tab-pane fade" id="herramientas" role="tabpanel" aria-labelledby="herramientas-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5><i class="fas fa-tools"></i> Gestión de Herramientas</h5>
                                                        <div class="d-flex gap-2">
                                                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                                                <button class="btn btn-primary" type="button" onclick="openModalHerramienta()">
                                                                    <i class="fas fa-plus"></i> Nueva Herramienta
                                                                </button>
                                                            <?php } ?>
                                                            <button class="btn btn-outline-danger" type="button" onclick="exportarPDF('tablaHerramientas')">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </button>
                                                            <button class="btn btn-outline-success" type="button" onclick="exportarExcel('tablaHerramientas')">
                                                                <i class="fas fa-file-excel"></i> Excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered" id="tablaHerramientas" style="width:100% !important; margin:0 !important;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>Marca</th>
                                                                    <th>Disponibilidad</th>
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
                        </div>
                    </div>
                                </div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>