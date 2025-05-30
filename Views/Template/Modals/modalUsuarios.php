<div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuarios" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title text-black">Seleccionar Usuarios</h5>
       
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="form-label fw-bold mb-2">Seleccione los usuarios para asignar la tarea:</label>
            <div id="usuariosCheckboxes" class="checkbox-container">
              <!-- Los checkboxes se cargarán dinámicamente -->
              <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Cargando...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnConfirmarUsuarios" class="btn btn-success" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Confirmar selección</button>
          <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.checkbox-container {
  max-height: 300px;
  overflow-y: auto;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 15px;
  margin-bottom: 15px;
}
.form-check {
  margin-bottom: 8px;
}
.form-check-label {
  margin-left: 5px;
}

.fw-bold {
  font-weight: 600;
}
</style>