<div class="modal fade" id="modalObservaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModalObs">Observaciones de la Tarea</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario para agregar nueva observación -->
        <form id="formNuevaObservacion" name="formNuevaObservacion" class="form-horizontal mb-4">
          <input type="hidden" id="idTareaObsList" name="idTarea" value="">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="txtNuevaObservacion">Nueva Observación</label>
              <textarea class="form-control" id="txtNuevaObservacion" name="txtObservacion" rows="3" required></textarea>
            </div>
          </div>
          <div class="text-right">
            <button id="btnAgregarObs" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-plus-circle"></i><span>Agregar</span></button>
          </div>
        </form>
        
        <hr>
        
        <!-- Lista de observaciones -->
        <h5>Historial de Observaciones</h5>
        <div id="listaObservaciones" class="mt-3">
          <!-- Aquí se cargarán las observaciones dinámicamente -->
          <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Cargando...</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
      </div>
    </div>
  </div>
</div>