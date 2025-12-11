<div class="modal fade" id="modalFormPrestamos" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Nuevo Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPrestamo" name="formPrestamo" class="form-horizontal">
          <input type="hidden" id="idPrestamo" name="idPrestamo" value="">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="listFuncionario" class="form-control-label">Funcionario de Planta <span class="text-danger">*</span></label>
                <select class="form-control" id="listFuncionario" name="listFuncionario" required="">
                  <option value="">Seleccione un funcionario</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtDependencia" class="form-control-label">Dependencia</label>
                <input type="text" class="form-control" id="txtDependencia" name="txtDependencia" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtCargo" class="form-control-label">Cargo</label>
                <input type="text" class="form-control" id="txtCargo" name="txtCargo" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtFechaPrestamo" class="form-control-label">Fecha de Préstamo <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="txtFechaPrestamo" name="txtFechaPrestamo" required="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="txtFechaDevolucion" class="form-control-label">Fecha de Devolución</label>
                <input type="date" class="form-control" id="txtFechaDevolucion" name="txtFechaDevolucion">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="listTipoEquipo" class="form-control-label">Tipo de Equipo <span class="text-danger">*</span></label>
                <select class="form-control" id="listTipoEquipo" name="listTipoEquipo" required="">
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
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="listEquipo" class="form-control-label">Equipo <span class="text-danger">*</span></label>
                <select class="form-control" id="listEquipo" name="listEquipo" required="">
                  <option value="">Primero seleccione el tipo de equipo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label for="txtObservaciones" class="form-control-label">Observaciones</label>
            <textarea class="form-control" id="txtObservaciones" name="txtObservaciones" rows="3"></textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btnActionForm"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Ver Préstamo -->
<div class="modal fade" id="modalViewPrestamo" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Datos del Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td><strong>Funcionario:</strong></td>
              <td id="celFuncionario"></td>
            </tr>
            <tr>
              <td><strong>Dependencia:</strong></td>
              <td id="celDependencia"></td>
            </tr>
            <tr>
              <td><strong>Cargo:</strong></td>
              <td id="celCargo"></td>
            </tr>
            <tr>
              <td><strong>Fecha Préstamo:</strong></td>
              <td id="celFechaPrestamo"></td>
            </tr>
            <tr>
              <td><strong>Fecha Devolución:</strong></td>
              <td id="celFechaDevolucion"></td>
            </tr>
            <tr>
              <td><strong>Item:</strong></td>
              <td id="celItem"></td>
            </tr>
            <tr>
              <td><strong>Dispositivo:</strong></td>
              <td id="celDispositivo"></td>
            </tr>
            <tr>
              <td><strong>Estado:</strong></td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td><strong>Observaciones:</strong></td>
              <td id="celObservaciones"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>