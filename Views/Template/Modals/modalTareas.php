<div class="modal fade" id="modalFormTareas" tabindex="-1" aria-labelledby="modalFormTareas" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Tarea</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <form id="formTarea" name="formTarea" class="form-horizontal">
          <input type="hidden" id="idTarea" name="idTarea" value="">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listUsuarioAsignado">Asignar a <span class="required">*</span></label>
              <select class="form-control" id="listUsuarioAsignado" name="listUsuarioAsignado" required>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listTipo">Tipo <span class="required">*</span></label>
              <select class="form-control" id="listTipo" name="listTipo" required>
                <option value="administrativa">Administrativa</option>
                <option value="técnica">Técnica</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="txtDescripcion">Descripción <span class="required">*</span></label>
              <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3" required></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listDependencia">Dependencia <span class="required">*</span></label>
              <select class="form-control" id="listDependencia" name="listDependencia" required>
              </select>
            </div>
            <div class="form-group col-md-6" id="divEstado" style="display: none;">
              <label for="listEstado">Estado <span class="required">*</span></label>
              <select class="form-control" id="listEstado" name="listEstado">
                <option value="sin empezar">Sin empezar</option>
                <option value="en curso">En curso</option>
                <option value="completada">Completada</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtFechaInicio">Fecha de inicio <span class="required">*</span></label>
              <input type="date" class="form-control" id="txtFechaInicio" name="txtFechaInicio" required>
            </div>
            <div class="form-group col-md-6">
              <label for="txtFechaFin">Fecha de fin <span class="required">*</span></label>
              <input type="date" class="form-control" id="txtFechaFin" name="txtFechaFin" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="txtObservacion">Observación inicial (opcional)</label>
              <textarea class="form-control" id="txtObservacion" name="txtObservacion" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>