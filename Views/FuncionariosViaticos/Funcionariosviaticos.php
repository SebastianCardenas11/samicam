<?php headerAdmin($data); ?>
<?php getModal('modalViaticos', $data); ?>
<?php getModal('modalPresupuestoViaticos', $data); ?>
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
            <section id="viaticos-summary" class="mb-4">
                <h4>Capital Disponible para el Año <span id="anioActual"></span></h4>
                <canvas id="chartCapitalDisponible" height="100"></canvas>
                <p>Total Viáticos Otorgados: <span id="totalViaticos" class="text-success"></span></p>
                <p>Viáticos Descontados: <span id="viaticosDescontados" class="text-danger"></span></p>
            </section>

            <section id="viaticos-historico" class="mb-4">
                <h4>Histórico de Viáticos por Funcionario</h4>
                <table id="tableHistoricoViaticos" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Funcionario</th>
                            <th>Total Viáticos</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>

            <section id="viaticos-detalle" class="mb-4">
                <h4>Detalle de Viáticos Otorgados</h4>
                <table id="tableDetalleViaticos" class="table table-striped table-bordered" style="width:100%">
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
            </section>
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>
