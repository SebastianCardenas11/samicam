<div class="modal fade" id="modalObservaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="titleModalObs">Observaciones de la Tarea</h5>
      </div>
      <div class="modal-body">
        <!-- Formulario para agregar nueva observación -->
        <form id="formNuevaObservacion" name="formNuevaObservacion" class="form-horizontal mb-4">
          <input type="hidden" id="idTareaObsList" name="idTarea" value="">
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="txtNuevaObservacion" class="form-label fw-bold">Nueva Observación</label>
              <textarea class="form-control" id="txtNuevaObservacion" name="txtObservacion" rows="3" required></textarea>
            </div>
          </div>
          <div class="text-end">
            <button id="btnAgregarObs" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-plus-circle"></i><span>Agregar</span></button>
          </div>
        </form>
        
        <!-- Indicador de carga para observaciones -->
        <div id="loadingIndicatorObs" class="text-center p-2" style="display: none;">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
          <small class="text-muted ms-2">Agregando observación...</small>
        </div>
        
        <hr>
        
        <!-- Lista de observaciones -->
        <h5 class="fw-bold mb-3">Historial de Observaciones</h5>
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
        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
.headerUpdate {
  background-color: #17a2b8;
  color: white;
}
.fw-bold {
  font-weight: 600;
}
.card-header {
  background-color: #f8f9fa;
  font-weight: 500;
}
</style>