<!-- Modal -->
<div class="modal fade" id="modalFormCargos" tabindex="-1" aria-labelledby="modalFormCargos" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Cargo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="tile-body">
                        <form id="formCargos" name="formCargos" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideCargos" name="ideCargos" value="">
                            <div class="modal-body">
                                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="text-primary">Datos del Cargo</p>
                            </div>
                            <div class="modal-body">
                                <label for="txtNombresCargos">Cargo<span class=" required">*</span></label>
                                <input type="text" class="form-control " id="txtNombresCargos"
                                    name="txtNombresCargos" required="30" >
                            </div>
                            <div class="modal-body">
                                <label for="txtNivel">Nivel<span class=" required">*</span></label>
                                <input type="text" class="form-control " id="txtNivel"
                                    name="txtNivel" required="30" >
                            </div>

                            <div class="modal-body">
                                <label for="txtSalario">Salario</label>
                                <input type="text" class="form-control " id="txtSalario" name="txtSalario" 
                                required="" maxlength="30">
                                
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
<div class="modal fade" id="modalViewCargos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-dark">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Cargo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="tile-body">
          <table class="table table-bordered table-striped align-middle mb-0">
            <tbody>
              <tr>
                <th scope="row" class="text-dark">Cargo:</th>
                <td id="celNombre" class="text-dark"></td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Nivel:</th>
                <td id="celNivel" class="text-dark">0</td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Salario:</th>
                <td id="celSalario" class="text-dark">0</td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Estado:</th>
                <td id="celEstadoCargo" class="text-dark">0</td>
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

