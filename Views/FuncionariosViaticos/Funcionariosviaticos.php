<?php headerAdmin($data); ?>
<?php getModal('modalViaticos', $data); ?>
<?php getModal('modalPresupuestoViaticos', $data); ?>

<!-- Incluir CSS específico para viáticos -->
<link rel="stylesheet" href="<?= media(); ?>/css/viaticos.css">

<!-- Incluir Chart.js para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* Estilos adicionales para quitar efectos hover y animaciones */
.card {
    transition: none !important;
    transform: none !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}
.card:hover {
    transform: none !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

/* Quitar cualquier efecto de zoom en las tablas */
table, tr, td, th {
    transform: none !important;
    transition: none !important;
    transform-origin: center !important;
    perspective: none !important;
}

/* Quitar hover en DataTables */
table.dataTable tbody tr:hover {
    transform: none !important;
    transition: none !important;
    box-shadow: none !important;
    z-index: auto !important;
}

/* Estilos para botones en grupo */
.btn-group .btn {
    margin-right: 2px;
}

/* Asegurar que las tablas sean visibles */
.dataTables_wrapper {
    width: 100%;
    overflow-x: auto;
}

/* Asegurar que los gráficos sean visibles */
canvas {
    display: block !important;
    max-width: 100%;
}
</style>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <h2 class="content-header-title">Módulo de Viáticos</h2>
            </div>
            <div class="content-header-right text-md-end col-md-5 col-12 d-md-block d-none">
                <div class="btn-group" role="group">
                    <button class="btn btn-primary" onclick="openModalViatico();"><i class="bi bi-plus-lg"></i> Agregar Viático</button>
                    <button class="btn btn-secondary" onclick="openModalPresupuesto();"><i class="bi bi-cash-stack"></i> Presupuesto</button>
                    <button id="btnReporteAnual" class="btn btn-info"><i class="bi bi-file-pdf"></i> Reporte Anual</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Capital Disponible <span id="anioActual"></span></h5>
                                <div class="d-flex">
                                    <select id="selectAnio" class="form-select form-select-sm me-1" style="width: auto;">
                                        <?php 
                                        $currentYear = date('Y');
                                        // Solo mostrar año actual y siguiente
                                        for($i = $currentYear; $i <= $currentYear + 1; $i++) {
                                            $selected = ($i == $currentYear) ? 'selected' : '';
                                            echo "<option value=\"$i\" $selected>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <button id="btnFiltrar" class="btn btn-sm btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="chartCapitalDisponible" height="150"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-2">
                                        <p class="mb-1"><strong>Total:</strong> <span id="totalViaticos" class="text-success"></span></p>
                                        <p class="mb-1"><strong>Usado:</strong> <span id="viaticosDescontados" class="text-danger"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header p-2">
                            <h5 class="mb-0">Comparativa Capital Total vs Disponible</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="chartComparativaContainer" style="height: 150px;">
                                        <canvas id="chartComparativa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section id="viaticos-historico" class="mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Histórico de Viáticos por Funcionario</h4>
                    </div>
                    <div class="card-body">
                        <table id="tableHistoricoViaticos" class="table table-bordered no-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Funcionario</th>
                                    <th>Total Viáticos</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="viaticos-detalle" class="mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detalle de Viáticos Otorgados</h4>
                    </div>
                    <div class="card-body">
                        <table id="tableDetalleViaticos" class="table table-bordered no-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Funcionario</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>Fechas (Salida - Regreso)</th>
                                    <th>Uso</th>
                                    <th>Fecha Aprobación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quitar cualquier efecto hover o animación de las cards y tablas
    document.querySelectorAll('.card, table, tr, td, th').forEach(element => {
        element.style.transition = 'none';
        element.style.transform = 'none';
        element.style.boxShadow = element.classList.contains('card') ? '0 1px 3px rgba(0, 0, 0, 0.1)' : 'none';
    });
    
    // Aplicar estilos para quitar hover en tablas
    document.querySelectorAll('.table-bordered tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'transparent';
            this.style.transform = 'none';
        });
    });
});
</script>

<?php footerAdmin($data); ?>