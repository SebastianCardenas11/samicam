<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Escáner</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEscaner">Agregar Escáner</button>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Marca</th><th>Modelo</th><th>Serial</th><th>Estado</th><th>Disponibilidad</th><th>Sectorial</th><th>Oficina</th><th>Asignado</th><th>Cargo</th><th>Contacto</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se mostrarán los registros de escáner -->
      </tbody>
    </table>
  </div>
</div>
<?php if (file_exists('Views/Inventario/modals/modal_escaner.php')) include 'Views/Inventario/modals/modal_escaner.php'; ?> 