<div class="modal fade" id="modalFormUsuario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formUsuario" name="formUsuario" class="form-horizontal">
          <input type="hidden" id="ideUsuario" name="ideUsuario" value="">
          <div class="mb-3">
            <label for="txtCorreoUsuario" class="form-label">Correo</label>
            <input type="email" class="form-control" id="txtCorreoUsuario" name="txtCorreoUsuario" required>
          </div>
          <div class="mb-3">
            <label for="txtNombresUsuario" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="txtNombresUsuario" name="txtNombresUsuario" required>
          </div>
          <div class="mb-3" id="divContrasena">
            <label for="txtContrasenaUsuario" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="txtContrasenaUsuario" name="txtContrasenaUsuario" required>
              <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                <i class="bi bi-eye-slash"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="txtRolUsuario" class="form-label">Rol</label>
            <select class="form-select" id="txtRolUsuario" name="txtRolUsuario" required>
              <!-- Opciones cargadas dinámicamente -->
            </select>
          </div>
          <div class="mb-3">
            <label for="listStatus" class="form-label">Estado</label>
            <select class="form-select" id="listStatus" name="listStatus" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
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