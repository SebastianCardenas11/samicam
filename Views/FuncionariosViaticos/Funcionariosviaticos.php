<?php headerAdmin($data); ?>
<?php getModal('modalViaticos', $data); ?>
<?php getModal('modalPresupuestoViaticos', $data); ?>

<!-- Incluir CSS específico para viáticos -->
<link rel="stylesheet" href="<?= media(); ?>/css/viaticos.css">

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
</style>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <h2 class="content-header-title">Módulo de Viáticos</h2>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <button class="btn btn-primary" onclick="openModalViatico();"><i class="bi bi-plus-lg"></i> Agregar Viático</button>
                <button class="btn btn-secondary ms-2" onclick="openModalPresupuesto();"><i class="bi bi-cash-stack"></i> Presupuesto Anual</button>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Capital Disponible para el Año <span id="anioActual"></span></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="chartCapitalDisponible" height="200"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p><strong>Total Presupuesto:</strong> <span id="totalViaticos" class="text-success"></span></p>
                                        <p><strong>Viáticos Usados:</strong> <span id="viaticosDescontados" class="text-danger"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filtrar por Año</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="selectAnio" class="form-select">
                                        <?php 
                                        $currentYear = date('Y');
                                        for($i = $currentYear - 2; $i <= $currentYear + 1; $i++) {
                                            $selected = ($i == $currentYear) ? 'selected' : '';
                                            echo "<option value=\"$i\" $selected>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button id="btnFiltrar" class="btn btn-primary">Filtrar</button>
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
                                    <th>Fecha</th>
                                    <th>Uso</th>
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
    // Quitar cualquier efecto hover o animación de las cards
    document.querySelectorAll('.card').forEach(card => {
        card.style.transition = 'none';
        card.style.transform = 'none';
        card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
    });
    
    // Aplicar estilos para quitar hover en tablas
    document.querySelectorAll('.table-bordered tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'transparent';
        });
    });
    
    document.getElementById('btnFiltrar').addEventListener('click', function() {
        const anioSeleccionado = document.getElementById('selectAnio').value;
        document.getElementById('anioActual').textContent = anioSeleccionado;
        cargarCapitalDisponible(anioSeleccionado);
        cargarHistoricoViaticos(anioSeleccionado);
        cargarDetalleViaticos(anioSeleccionado);
    });
});
</script>

<?php footerAdmin($data); ?>