<!-- Modal Selección de Equipo -->
<div class="modal fade" id="modalSeleccionEquipo" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f8f6f0; border-bottom: 1px solid #dee2e6;">
        <h5 class="modal-title text-dark">Seleccionar Equipo para Mantenimiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; color: #000; opacity: 0.5;">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Buscar Equipo:</label>
          <input type="text" class="form-control" id="searchEquipo" placeholder="Buscar por tipo, número, marca o modelo...">
        </div>
        <div class="table-responsive" style="height: 400px; overflow-y: auto;">
          <table class="table table-hover table-sm" id="tableSeleccionEquipos">
            <thead class="sticky-top" style="background-color: white;">
              <tr>
                <th>Tipo</th>
                <th>Número</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Estado</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Funcionalidad del filtro de búsqueda
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchEquipo');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const table = document.getElementById('tableSeleccionEquipos');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length - 1; j++) { // -1 para excluir la columna de acción
                    if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        });
    }
});
</script>