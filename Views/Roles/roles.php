<?php headerAdmin($data); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Roles</h6>
                </div>
                <!-- Botón Agregar Nuevo Usuario -->
                <div class="button-nuevo">
                    <button data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-info" title="Agregar usuario">
                        <i class="bi bi-plus-lg"></i> Nuevo Usuario
                    </button>
                </div>
                <!-- Botones de Excel y PDF -->
                <div class="button-ex">
                    <button class="btn btn-success" id="exportExcel" title="Exportar a Excel">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                    <button class="btn btn-danger" id="exportPDF" title="Exportar un PDF">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                </div>







                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary-override">CORREO</th>
                                    <th class="text-center text-secondary-override">NOMBRE</th>
                                    <th class="text-center text-secondary-override">ROL</th>
                                    <th class="text-center text-secondary-override">ESTADO</th>
                                    <th class="text-center text-secondary-override">ACCIONES</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
                                <!-- Aquí cargas dinámicamente los funcionarios -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>