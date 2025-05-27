<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="tile-body">
                        <form id="formUsuario" name="formUsuario" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideUsuario" name="ideUsuario" value="">
                            <div class="modal-body">
                                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="text-primary">Datos del Usuario</p>
                            </div>
                            <div class="modal-body">
                                <label for="txtCorreoUsuario">Correo<span class="required">*</span></label>
                                <input type="email" class="form-control" id="txtCorreoUsuario"
                                    name="txtCorreoUsuario" required="">
                            </div>

                            <div class="modal-body" id="divContrasena">
                                <label for="txtContrasenaUsuario">Contraseña<span class="required">*</span></label>
                                <input type="password" class="form-control" id="txtContrasenaUsuario"
                                    name="txtContrasenaUsuario" required="">
                            </div>

                            <div class="modal-body">
                                <label for="txtNombresUsuario">Nombres<span class="required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtNombresUsuario"
                                    name="txtNombresUsuario" required>
                            </div>

                            <div class="modal-body">
                                <label for="txtRolUsuario">Selecciona el Rol</label>
                                <select class="form-control form-select selectpicker required" id="txtRolUsuario" name="txtRolUsuario">
                                </select>
                            </div>


                            <div class="modal-body form-select-lg mb-3">
                                <label for="listStatus">Estado</label>
                                <select class="form-select" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                                        class="bi bi-floppy"></i>
                                    <span id="btnText">Guardar</span></button>

                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i
                                        class="bi bi-x-lg"></i>Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-dark">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="tile-body">
          <table class="table table-bordered align-middle mb-0">
           <tbody>
              <tr class="bg-light">
                <th scope="row" class="text-dark">ID:</th>
                <td id="celIdeUsuario" class="text-dark">233104</td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Correo:</th>
                <td id="celCorreoUsuario" class="text-dark">233104</td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Nombres:</th>
                <td id="celNombresUsuario" class="text-dark">233104</td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Rol:</th>
                <td id="celRolUsuario" class="text-dark">2875079</td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Estado:</th>
                <td id="celEstadoUsuario" class="text-dark">Programación de Software</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">
            <i class="bi bi-check2"></i> Listo
          </button>
        </div>
      </div>
    </div>
  </div>
</div>