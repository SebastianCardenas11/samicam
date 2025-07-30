<!-- Modal Formulario de Mantenimiento -->
<div class="modal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title">Registro de Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
                <input type="text" class="form-control" id="estacionTrabajo" name="estacionTrabajo" placeholder="Ej: Oficina de Sistemas" required>
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
                <input type="text" class="form-control" id="cedulaUsuario" name="cedulaUsuario" placeholder="Número de cédula" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tipo de Dispositivo <span class="text-danger">*</span></label>
                <select class="form-control" id="tipoDispositivo" name="tipoDispositivo" required>
                  <option value="">Seleccionar...</option>
                  <option value="Computador">Computador</option>
                  <option value="Impresora">Impresora</option>
                  <option value="Escáner">Escáner</option>
                  <option value="Monitor">Monitor</option>
                  <option value="Teclado">Teclado</option>
                  <option value="Mouse">Mouse</option>
                  <option value="Otro">Otro</option>
                </select>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Mantenimiento</button>
        </div>
      </form>
    </div>
  </div>
</div>