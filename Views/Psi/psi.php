<?php require_once "Views/Template/header_admin.php"; ?>
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h4 class="m-0 font-weight-bold text-primary"><i class="bi bi-arrow-left-right"></i> Módulo PSI (Préstamos, Salidas e Ingresos)</h4>
  </div>
  <div class="card-body">
    <ul class="nav nav-tabs" id="psiTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="prestamos-tab" data-bs-toggle="tab" data-bs-target="#prestamos" type="button" role="tab">Préstamos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="salidas-tab" data-bs-toggle="tab" data-bs-target="#salidas" type="button" role="tab">Salidas</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="ingresos-tab" data-bs-toggle="tab" data-bs-target="#ingresos" type="button" role="tab">Ingresos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab">Gráficos</button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="psiTabsContent">
      <div class="tab-pane fade show active" id="prestamos" role="tabpanel">
        <div class="d-flex justify-content-end mb-2">
          <button class="btn btn-primary" onclick="openModalPsi('prestamo')"><i class="fas fa-plus"></i> Nuevo Préstamo</button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="tablaPrestamos">
            <thead>
              <tr>
                <th>Dependencia</th>
                <th>Funcionario Responsable</th>
                <th>Cargo Funcionario</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Item</th>
                <th>Dispositivo</th>
                <th>Marca/Modelo</th>
                <th>Activo</th>
                <th>Serial</th>
                <th>Estado</th>
                <th>MAC</th>
                <th>Observaciones</th>
                <th>Status</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="salidas" role="tabpanel">
        <div class="d-flex justify-content-end mb-2">
          <button class="btn btn-primary" onclick="openModalPsi('salida')"><i class="fas fa-plus"></i> Nueva Salida</button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="tablaSalidas">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Motivo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="ingresos" role="tabpanel">
        <div class="d-flex justify-content-end mb-2">
          <button class="btn btn-primary" onclick="openModalPsi('ingreso')"><i class="fas fa-plus"></i> Nuevo Ingreso</button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="tablaIngresos">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Origen</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="graficos" role="tabpanel">
        <div class="row">
          <div class="col-md-12">
            <canvas id="psiChart" height="120"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once "Views/Template/Modals/modalPsi.php"; ?>
<?php require_once "Views/Template/footer_admin.php"; ?>
