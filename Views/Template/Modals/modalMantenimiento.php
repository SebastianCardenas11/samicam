<!-- Modal Formulario de Mantenimiento -->
<div class="modal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f8f6f0; border-bottom: 1px solid #dee2e6;">
        <h5 class="modal-title text-dark">Registro de Mantenimiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; color: #000; opacity: 0.5;">&times;</button>
      </div>
      <form id="formMantenimiento" name="formMantenimiento">
        <div class="modal-body">
          <input type="hidden" id="idEquipoMantenimiento" name="idEquipoMantenimiento">
          <input type="hidden" id="tipoEquipoMantenimiento" name="tipoEquipoMantenimiento">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fecha del Mantenimiento <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="fechaMantenimiento" name="fechaMantenimiento" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Estación de Trabajo <span class="text-danger">*</span></label>
                <select class="form-control" id="estacionTrabajo" name="estacionTrabajo" required>
                  <option value="">Seleccionar dependencia...</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nombre del Usuario <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre completo del usuario" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Cédula del Usuario <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="cedulaUsuario" name="cedulaUsuario" placeholder="Número de cédula" required>
              </div>
            </div>
          </div>
          

          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Error Reportado <span class="text-danger">*</span></label>
                <textarea class="form-control" id="errorReportado" name="errorReportado" rows="3" placeholder="Descripción detallada del problema reportado..." required></textarea>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Acciones Realizadas <span class="text-danger">*</span></label>
                <textarea class="form-control" id="accionesRealizadas" name="accionesRealizadas" rows="3" placeholder="Descripción de las acciones realizadas para solucionar el problema..." required></textarea>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Técnico que realizó el servicio</label>
                <input type="text" class="form-control" id="tecnicoServicio" name="tecnicoServicio" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar Mantenimiento
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Cargar dependencias al abrir el modal
document.addEventListener('DOMContentLoaded', function() {
    $('#modalMantenimiento').on('show.bs.modal', function() {
        cargarDependencias();
    });
});

function cargarDependencias() {
    const selectEstacion = document.getElementById('estacionTrabajo');
    
    fetch(base_url + '/inventario/getDependencias')
        .then(response => response.json())
        .then(data => {
            selectEstacion.innerHTML = '<option value="">Seleccionar dependencia...</option>';
            
            if (data && data.length > 0) {
                data.forEach(dependencia => {
                    const option = document.createElement('option');
                    option.value = dependencia.nombre_dependencia;
                    option.textContent = dependencia.nombre_dependencia;
                    selectEstacion.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar dependencias:', error);
        });
}
</script>