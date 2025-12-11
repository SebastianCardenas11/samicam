<div class="modal fade" id="modalFormSalidas" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModalSalida">Nueva Salida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formSalida" name="formSalida" class="form-horizontal">
          <input type="hidden" id="idSalida" name="idSalida" value="">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="txtFechaSalida" class="form-control-label">Fecha <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="txtFechaSalida" name="txtFechaSalida" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="listTipoEquipoSalida" class="form-control-label">Tipo de Equipo <span class="text-danger">*</span></label>
                <select class="form-control" id="listTipoEquipoSalida" name="listTipoEquipoSalida" required="">
                  <option value="">Seleccione tipo de equipo</option>
                  <option value="pc_torre">PC Torre</option>
                  <option value="todo_en_uno">Todo en Uno</option>
                  <option value="portatil">Portátil</option>
                  <option value="impresora">Impresora</option>
                  <option value="escaner">Escáner</option>
                  <option value="herramienta">Herramienta</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="listDependenciaSalida" class="form-control-label">Dependencia <span class="text-danger">*</span></label>
                <select class="form-control" id="listDependenciaSalida" name="listDependenciaSalida" required="">
                  <option value="">Seleccione dependencia</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtBuscarEquipoSalida" class="form-control-label">Buscar Equipos</label>
                <input type="text" class="form-control" id="txtBuscarEquipoSalida" placeholder="Buscar por número, marca, modelo o serial...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-control-label">Acciones</label><br>
                <button type="button" class="btn btn-sm btn-success" onclick="seleccionarTodosEquipos()">Seleccionar Todos</button>
                <button type="button" class="btn btn-sm btn-warning" onclick="deseleccionarTodosEquipos()">Deseleccionar Todos</button>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label class="form-control-label">Equipos Disponibles <span class="text-danger">*</span></label>
                <div id="equiposListaSalida" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                  <p class="text-muted">Primero seleccione el tipo de equipo</p>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label for="txtObservacionesSalida" class="form-control-label">Observaciones</label>
            <textarea class="form-control" id="txtObservacionesSalida" name="txtObservacionesSalida" rows="3"></textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-danger" id="btnActionFormSalida"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextSalida">Guardar</span></button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>