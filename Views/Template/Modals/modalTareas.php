<div class="modal fade" id="modalFormTareas" tabindex="-1" aria-labelledby="modalFormTareas" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title text-black" id="titleModal">Nueva Tarea</h5>
       
      </div>
      <div class="modal-body">
        <form id="formTarea" name="formTarea" class="form-horizontal">
          <input type="hidden" id="idTarea" name="idTarea" value="">
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Usuarios asignados <span class="text-danger">*</span></label>
              <div id="usuariosSeleccionados" class="selected-users mb-2">
                <p class="text-muted">No hay usuarios seleccionados</p>
              </div>
              <input type="hidden" id="usuariosIds" name="usuariosIds" value="">
              <button type="button" class="btn btn-outline-primary btn-sm text-black" onclick="openModalUsuarios()">
                <i class="fas fa-users"></i> Seleccionar usuarios
              </button>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="listTipo" class="form-label">Tipo<span class="text-danger">*</span></label>
              <select class="form-control form-select" id="listTipo" name="listTipo" required>
                <option value="">Seleccione una opcion</option>
                <option value="administrativa">Administrativa</option>
                <option value="técnica">Técnica</option>
                <option value="otra">Otra</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="listDependencia" class="form-label">Dependencia <span class="text-danger">*</span></label>
              <select class="form-control form-select" id="listDependencia" name="listDependencia" required>
                <option >Seleccione una opcion</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="txtDescripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
              <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3" required></textarea>
            </div>
          </div>
          <div class="row mb-3" id="divEstado" style="display: none;">
            <div class="col-md-6">
              <label for="listEstado" class="form-label">Estado <span class="text-danger">*</span></label>
              <select class="form-control form-select" id="listEstado" name="listEstado">
                <option value="sin empezar">Sin empezar</option>
                <option value="en curso">En curso</option>
                <option value="completada">Completada</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="txtFechaInicio" class="form-label">Fecha de inicio <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="txtFechaInicio" name="txtFechaInicio" required>
            </div>
            <div class="col-md-6">
              <label for="txtFechaFin" class="form-label">Fecha de fin <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="txtFechaFin" name="txtFechaFin" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="txtObservacion" class="form-label">Observación inicial (opcional)</label>
              <textarea class="form-control" id="txtObservacion" name="txtObservacion" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnActionForm" class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.selected-users {
  min-height: 40px;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 10px;
}
.user-badge {
  display: inline-block;
  background-color: #e9ecef;
  padding: 5px 10px;
  margin: 2px;
  border-radius: 15px;
  font-size: 0.9em;
}

.form-label {
  font-weight: 500;
}
</style>