<div class="modal fade" id="modalFormUsuario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formUsuario" name="formUsuario" class="form-horizontal">
          <input type="hidden" id="ideUsuario" name="ideUsuario" value="">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="txtCorreoUsuario" class="form-label">Correo</label>
                <input type="email" class="form-control" id="txtCorreoUsuario" name="txtCorreoUsuario" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="txtNombresUsuario" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="txtNombresUsuario" name="txtNombresUsuario" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3" id="divContrasena">
                <label for="txtContrasenaUsuario" class="form-label">Contraseña</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="txtContrasenaUsuario" name="txtContrasenaUsuario" required>
                  <button class="btn btn-outline-secondary mb-0" type="button" id="btnTogglePassword">
                    <i class="far fa-eye-slash"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="listStatus" class="form-label">Estado</label>
                <select class="form-select" id="listStatus" name="listStatus" required>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="txtRolUsuario" class="form-label">Rol Principal</label>
                <select class="form-select" id="txtRolUsuario" name="txtRolUsuario" required>
                  <!-- Opciones cargadas dinámicamente -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Roles Adicionales</label>
                <div class="form-control" style="height: auto; min-height: 38px;">
                  <div id="rolesAdicionalesContainer" class="d-flex flex-wrap gap-2">
                    <!-- Los checkboxes se cargarán dinámicamente -->
                    <div class="text-center w-100">
                      <small class="text-muted">Cargando roles...</small>
                    </div>
                  </div>
                </div>
                <small class="form-text text-muted">Selecciona roles adicionales para este usuario</small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnActionForm" class="btn btn-warning" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i>
              <span id="btnText">Guardar</span>
            </button>
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
              <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.form-check {
  margin-bottom: 5px;
}
.form-check-input:checked {
  background-color: #fd7e14;
  border-color: #fd7e14;
}
.form-check-label {
  font-size: 0.875rem;
  cursor: pointer;
}
#rolesAdicionalesContainer {
  max-height: 150px;
  overflow-y: auto;
}
</style>