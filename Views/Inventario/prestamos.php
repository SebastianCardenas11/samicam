<?php if (!isset($prestamos) || !is_array($prestamos)) $prestamos = []; ?>
<div class="card mb-4 shadow-sm border-0">
  <div class="card-header d-flex justify-content-between align-items-center bg-light text-dark">
    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Histórico de Préstamos</h5>
    <div class="d-flex gap-2">
      <button class="btn btn-success" onclick="descargarExcelPrestamos()">
        <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
      </button>
      <button class="btn btn-danger" onclick="descargarPDFPrestamos()">
        <i class="bi bi-file-earmark-pdf"></i> Exportar a PDF
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2">
      <div class="mb-2 mb-md-0">
        <label class="me-2">Mostrar</label>
        <select class="form-select d-inline-block w-auto" id="registrosPrestamos" onchange="filtrarRegistros('tablaPrestamos', this.value)">
          <option value="5">5</option>
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ms-2">registros</span>
      </div>
      <div>
        <input type="text" class="form-control" id="busquedaPrestamos" placeholder="Buscar..." onkeyup="buscarEnTabla('tablaPrestamos', this.value)">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="tablaPrestamos">
        <thead class="table-light">
          <tr>
            <th>Dependencia</th>
            <th>Funcionario Responsable</th>
            <th>Cargo</th>
            <th>Fecha Préstamo</th>
            <th>Fecha Devolución</th>
            <th>Item</th>
            <th>Dispositivo</th>
            <th>Modelo</th>
            <th>Activo</th>
            <th>Serial</th>
            <th>Estado</th>
            <th>MAC</th>
            <th>Observaciones</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($prestamos as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['dependencia']) ?></td>
            <td><?= htmlspecialchars($p['funcionario_responsable']) ?></td>
            <td><?= htmlspecialchars($p['cargo']) ?></td>
            <td><?= htmlspecialchars($p['fecha_prestamo']) ?></td>
            <td><?= htmlspecialchars($p['fecha_devolucion']) ?></td>
            <td><?= htmlspecialchars($p['item']) ?></td>
            <td><?= htmlspecialchars($p['dispositivo']) ?></td>
            <td><?= htmlspecialchars($p['modelo']) ?></td>
            <td><?= htmlspecialchars($p['activo']) ?></td>
            <td><?= htmlspecialchars($p['serial']) ?></td>
            <td>
              <?php
                $estado = strtolower($p['estado']);
                if ($estado == 'liquidado') echo '<span class="badge bg-success">LIQUIDADO</span>';
                elseif ($estado == 'finalizado') echo '<span class="badge bg-warning text-dark">FINALIZADO</span>';
                elseif ($estado == 'en ejecucion') echo '<span class="badge bg-info text-white">EN EJECUCION</span>';
                else echo htmlspecialchars($p['estado']);
              ?>
            </td>
            <td><?= htmlspecialchars($p['mac']) ?></td>
            <td><?= htmlspecialchars($p['observaciones']) ?></td>
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
  filtrarRegistros('tablaPrestamos', document.getElementById('registrosPrestamos').value);
});
function descargarExcelPrestamos() {
  alert('Funcionalidad de exportar a Excel pendiente de implementar.');
}
function descargarPDFPrestamos() {
  alert('Funcionalidad de exportar a PDF pendiente de implementar.');
}
</script> 