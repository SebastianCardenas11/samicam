<div class="card mb-4 shadow-sm border-0">
  <div class="card-header d-flex justify-content-between align-items-center bg-light text-dark">
    <h5 class="mb-0"><i class="bi bi-journal-text"></i> Papelería</h5>
    <div class="d-flex gap-2">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPapeleria">
        <i class="bi bi-plus-circle"></i> Agregar Papelería
      </button>
      <button class="btn btn-success btn-sm" onclick="descargarExcelPapeleria()" title="Descargar Excel"><i class="bi bi-file-earmark-excel"></i></button>
      <button class="btn btn-danger btn-sm" onclick="descargarPDFPapeleria()" title="Descargar PDF"><i class="bi bi-file-earmark-pdf"></i></button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2">
      <div class="mb-2 mb-md-0">
        <label class="me-2">Mostrar</label>
        <select class="form-select d-inline-block w-auto" id="registrosPapeleria" onchange="filtrarRegistros('tablaPapeleria', this.value)">
          <option value="5">5</option>
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ms-2">registros</span>
      </div>
      <div>
        <input type="text" class="form-control" id="busquedaPapeleria" placeholder="Buscar..." onkeyup="buscarEnTabla('tablaPapeleria', this.value)">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="tablaPapeleria">
        <thead class="table-light">
          <tr>
            <th>Item</th>
            <th>Disponibilidad</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se mostrarán los registros de papelería -->
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php if (file_exists('Views/Inventario/modals/modal_papeleria.php')) include 'Views/Inventario/modals/modal_papeleria.php'; ?>
<script>
function buscarEnTabla(idTabla, texto) {
  const tabla = document.getElementById(idTabla);
  const filtro = texto.toLowerCase();
  const filas = tabla.tBodies[0].rows;
  for (let i = 0; i < filas.length; i++) {
    let mostrar = false;
    for (let j = 0; j < filas[i].cells.length; j++) {
      if (filas[i].cells[j].innerText.toLowerCase().indexOf(filtro) > -1) {
        mostrar = true;
        break;
      }
    }
    filas[i].style.display = mostrar ? '' : 'none';
  }
}
function filtrarRegistros(idTabla, cantidad) {
  const tabla = document.getElementById(idTabla);
  const filas = tabla.tBodies[0].rows;
  let visibles = 0;
  for (let i = 0; i < filas.length; i++) {
    if (filas[i].style.display !== 'none') {
      visibles++;
      filas[i].style.display = visibles <= cantidad ? '' : 'none';
    }
  }
}
document.addEventListener('DOMContentLoaded', function() {
  filtrarRegistros('tablaPapeleria', document.getElementById('registrosPapeleria').value);
});
function descargarExcelPapeleria() {
  alert('Funcionalidad de exportar a Excel pendiente de implementar.');
}
function descargarPDFPapeleria() {
  alert('Funcionalidad de exportar a PDF pendiente de implementar.');
}
</script> 