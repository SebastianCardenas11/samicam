<?php 
    headerAdmin($data); 
    getModal('modalPrestamos', $data);
    getModal('modalSalidas', $data);
    getModal('modalIngresos', $data);
?>
<main class="app-content">
    <div class="app-title">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center">
                <h1 class="me-3"><i class="bi bi-arrow-left-right"></i> <?= $data['page_title'] ?></h1>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                    <button class="btn btn-warning" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nuevo Préstamo</button>
                <?php } ?>
            </div>
        </div>
        <ul class="app-breadcrumb breadcrumb m-0">
            <li class="breadcrumb-item"><i class="bi bi-house fs-6"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/psi"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">
                <div class="tile-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="psiTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="prestamos-tab" data-bs-toggle="tab" data-bs-target="#prestamos" type="button" role="tab">
                                <i class="fas fa-handshake"></i> Préstamos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salidas-tab" data-bs-toggle="tab" data-bs-target="#salidas" type="button" role="tab">
                                <i class="fas fa-arrow-up"></i> Salidas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ingresos-tab" data-bs-toggle="tab" data-bs-target="#ingresos" type="button" role="tab">
                                <i class="fas fa-arrow-down"></i> Ingresos
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="psiTabContent">
                        <!-- PRÉSTAMOS -->
                        <div class="tab-pane fade show active" id="prestamos" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover table-bordered" id="tablePrestamos">
                                    <thead class="table-success">
                                        <tr>
                                            <th class="text-center">Funcionario</th>
                                            <th class="text-center">Dependencia</th>
                                            <th class="text-center">Cargo</th>
                                            <th class="text-center">Fecha Préstamo</th>
                                            <th class="text-center">Fecha Devolución</th>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Dispositivo</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- SALIDAS -->
                        <div class="tab-pane fade" id="salidas" role="tabpanel">
                            <div class="d-flex justify-content-end mt-3 mb-3">
                                <?php if($_SESSION['permisosMod']['w']){ ?>
                                    <button class="btn btn-danger" type="button" onclick="openModalSalida();"><i class="fas fa-plus-circle"></i> Nueva Salida</button>
                                <?php } ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tableSalidas">
                                    <thead class="table-danger">
                                        <tr>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Dependencia</th>
                                            <th class="text-center">Total Equipos</th>
                                            <th class="text-center">Observaciones</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INGRESOS -->
                        <div class="tab-pane fade" id="ingresos" role="tabpanel">
                            <div class="d-flex justify-content-end mt-3 mb-3">
                                <?php if($_SESSION['permisosMod']['w']){ ?>
                                    <button class="btn btn-info" type="button" onclick="openModalIngreso();"><i class="fas fa-plus-circle"></i> Nuevo Ingreso</button>
                                <?php } ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tableIngresos">
                                    <thead class="table-info">
                                        <tr>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Marca</th>
                                            <th class="text-center">Modelo</th>
                                            <th class="text-center">Serial</th>
                                            <th class="text-center">Dependencia</th>
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
        </div>
    </div>
</main>

<?php footerAdmin($data); ?>
