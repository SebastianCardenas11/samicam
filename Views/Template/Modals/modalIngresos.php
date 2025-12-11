<div class="modal fade" id="modalFormIngresos" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModalIngreso">Nuevo Ingreso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formIngreso" name="formIngreso" class="form-horizontal">
          <input type="hidden" id="idIngreso" name="idIngreso" value="">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="txtFechaIngreso" class="form-control-label">Fecha <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="txtFechaIngreso" name="txtFechaIngreso" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="listTipoEquipoIngreso" class="form-control-label">Tipo de Equipo <span class="text-danger">*</span></label>
                <select class="form-control" id="listTipoEquipoIngreso" name="listTipoEquipoIngreso" required="">
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
                <label for="listDependenciaIngreso" class="form-control-label">Dependencia <span class="text-danger">*</span></label>
                <select class="form-control" id="listDependenciaIngreso" name="listDependenciaIngreso" required="">
                  <option value="">Seleccione dependencia</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtBuscarEquipoIngreso" class="form-control-label">Buscar Equipos</label>
                <input type="text" class="form-control" id="txtBuscarEquipoIngreso" placeholder="Buscar por número, marca, modelo o serial...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-control-label">Acciones</label><br>
                <button type="button" class="btn btn-sm btn-success" onclick="seleccionarTodosEquiposIngreso()">Seleccionar Todos</button>
                <button type="button" class="btn btn-sm btn-warning" onclick="deseleccionarTodosEquiposIngreso()">Deseleccionar Todos</button>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label class="form-control-label">Equipos Disponibles <span class="text-danger">*</span></label>
                <div id="equiposListaIngreso" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                  <p class="text-muted">Primero seleccione el tipo de equipo</p>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label for="txtObservacionesIngreso" class="form-control-label">Observaciones</label>
            <textarea class="form-control" id="txtObservacionesIngreso" name="txtObservacionesIngreso" rows="3"></textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-info" id="btnActionFormIngreso"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextIngreso">Guardar</span></button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>