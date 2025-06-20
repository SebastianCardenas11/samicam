<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Tintas y Tóner</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTintaToner">Agregar Tinta/Tóner</button>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Item</th><th>Disponibles</th><th>Impresora</th><th>Modelos Compatibles</th><th>Fecha Última Actualización</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se mostrarán los registros de tintas y tóner -->
      </tbody>
    </table>
  </div>
</div>
<?php if (file_exists('Views/Inventario/modals/modal_tinta_toner.php')) include 'Views/Inventario/modals/modal_tinta_toner.php'; ?> 