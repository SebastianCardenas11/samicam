<!-- Modal -->
<div class="modal fade" id="modalFormCategoria" tabindex="-1" aria-labelledby="modalFormCategoria" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <form id="formCategoria" name="formCategoria" method="POST">
                        <input type="hidden" id="idCategoria" name="idCategoria" value="">
                        <div class="modal-body">
                            <p class="text-primary">Los campos con asterisco (<span class="required text-danger">*</span>) son
                                obligatorios.
                            </p>
                            <hr>
                            <p class="text-primary">Datos de la Categoría</p>
                        </div>
                        <div class="modal-body">
                            <label for="txtNombre">Nombre<span class="required text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtNombre"
                                name="txtNombre" required="">
                        </div>

                        <div class="modal-body">
                            <label for="txtDescripcion">Descripción</label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3"></textarea>
                        </div>

                        <div class="modal-body">
                            <label for="listStatus">Estado</label>
                            <select class="form-control" id="listStatus" name="listStatus">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
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

<!-- Modal Ver Categoría -->
<div class="modal fade" id="modalViewCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-dark">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Detalles de la Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="tile-body">
          <table class="table table-bordered align-middle mb-3">
           <tbody>
              <tr class="bg-light">
                <th scope="row" class="text-dark">ID:</th>
                <td id="celId" class="text-dark"></td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Nombre:</th>
                <td id="celNombre" class="text-dark"></td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Descripción:</th>
                <td id="celDescripcion" class="text-dark"></td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Estado:</th>
                <td id="celEstado" class="text-dark"></td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Fecha Creación:</th>
                <td id="celFechaCreacion" class="text-dark"></td>
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