<?php if (!isset($salidas) || !is_array($salidas)) $salidas = []; ?>
<div class="card mb-4 shadow-sm border-0">
  <div class="card-header d-flex justify-content-between align-items-center bg-light text-dark">
    <h5 class="mb-0"><i class="bi bi-box-arrow-up"></i> Salidas</h5>
    <div class="d-flex gap-2">
      <button class="btn btn-success btn-sm" onclick="descargarExcelSalidas()">
        <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
      </button>
      <button class="btn btn-danger btn-sm" onclick="descargarPDFSalidas()">
        <i class="bi bi-file-earmark-pdf"></i> Exportar a PDF
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2">
      <div class="mb-2 mb-md-0">
        <label class="me-2">Mostrar</label>
        <select class="form-select d-inline-block w-auto" id="registrosSalidas" onchange="filtrarRegistros('tablaSalidas', this.value)">
          <option value="5">5</option>
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ms-2">registros</span>
      </div>
      <div>
        <input type="text" class="form-control" id="busquedaSalidas" placeholder="Buscar..." onkeyup="buscarEnTabla('tablaSalidas', this.value)">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="tablaSalidas">
        <thead class="table-light">
          <tr>
            <th>Item</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>N° Activo</th>
            <th>Serial</th>
            <th>Dependencia</th>
            <th>Observaciones</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($salidas as $salida): ?>
          <tr>
            <td><?= htmlspecialchars($salida['item']) ?></td>
            <td><?= htmlspecialchars($salida['descripcion_dispositivo']) ?></td>
            <td><?= htmlspecialchars($salida['marca']) ?></td>
            <td><?= htmlspecialchars($salida['modelo']) ?></td>
            <td><?= htmlspecialchars($salida['num_activo']) ?></td>
            <td><?= htmlspecialchars($salida['sn']) ?></td>
            <td><?= htmlspecialchars($salida['dependencia']) ?></td>
            <td><?= htmlspecialchars($salida['observaciones']) ?></td>
            <td class="text-center">
              <!-- Botones de editar/eliminar -->
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
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
  filtrarRegistros('tablaSalidas', document.getElementById('registrosSalidas').value);
});
function descargarExcelSalidas() {
  alert('Funcionalidad de exportar a Excel pendiente de implementar.');
}
function descargarPDFSalidas() {
  alert('Funcionalidad de exportar a PDF pendiente de implementar.');
}
</script> 