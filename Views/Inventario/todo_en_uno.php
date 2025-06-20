<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Todo en Uno</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTodoEnUno">Agregar Todo en Uno</button>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>N° PC</th><th>Marca</th><th>Modelo</th><th>RAM</th><th>Procesador</th><th>Disco Duro</th><th>Capacidad</th><th>Serial</th><th>Estado</th><th>Disponibilidad</th><th>Sectorial</th><th>Oficina</th><th>Asignado</th><th>Cargo</th><th>Contacto</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se mostrarán los registros de Todo en uno -->
      </tbody>
    </table>
  </div>
</div>
<?php if (file_exists('Views/Inventario/modals/modal_todo_en_uno.php')) include 'Views/Inventario/modals/modal_todo_en_uno.php'; ?> 