<!-- Modal Selección de Equipo -->
<div class="modal fade" id="modalSeleccionEquipo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title">Seleccionar Equipo para Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Buscar Equipo:</label>
          <input type="text" class="form-control" id="searchEquipo" placeholder="Buscar por tipo, número, marca o modelo...">
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-sm" id="tableSeleccionEquipos">
            <thead>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>