<!-- Modal -->
<div class="modal fade" id="modalFormSeguimientoContrato" tabindex="-1" aria-labelledby="modalFormSeguimientoContrato" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSeguimientoContrato" name="formSeguimientoContrato" class="form-horizontal">
                    <input type="hidden" id="id" name="id" value="">
                    <p class="text-primary">Todos los campos son obligatorios.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="objeto_contrato">Objeto del Contrato</label>
                            <textarea id="objeto_contrato" class="form-control" name="objeto_contrato" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_terminacion">Fecha de Terminación</label>
                            <input type="date" class="form-control" id="fecha_terminacion" name="fecha_terminacion" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="plazo_meses">Plazo (meses)</label>
                            <input type="number" class="form-control" id="plazo_meses" name="plazo_meses" required>
                        </div>
                        <div class="col-md-6">
                            <label for="valor_total_contrato">Valor Total del Contrato</label>
                            <input type="number" class="form-control" id="valor_total_contrato" name="valor_total_contrato" step="0.01" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="dia_corte_informe">Día de Corte de Informe</label>
                            <input type="date" class="form-control" id="dia_corte_informe" name="dia_corte_informe" required>
                        </div>
                         <div class="col-md-6">
                            <label for="evidenciado_secop">Evidenciado en SECOP 2</label>
                            <input type="text" class="form-control" id="evidenciado_secop" name="evidenciado_secop">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="observaciones_ejecucion">Observaciones de Ejecución</label>
                            <textarea id="observaciones_ejecucion" class="form-control" name="observaciones_ejecucion" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_verificacion">Fecha de Verificación</label>
                            <input type="date" class="form-control" id="fecha_verificacion" name="fecha_verificacion">
                        </div>
                        <div class="col-md-6">
                            <label for="liquidacion">Liquidación</label>
                            <input type="number" class="form-control" id="liquidacion" name="liquidacion" step="0.01" required>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewContrato" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Contrato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Objeto del Contrato:</td>
              <td id="celObjetoContrato"></td>
            </tr>
            <tr>
              <td>Fecha de Inicio:</td>
              <td id="celFechaInicio"></td>
            </tr>
            <tr>
              <td>Fecha de Terminación:</td>
              <td id="celFechaTerminacion"></td>
            </tr>
            <tr>
              <td>Plazo (meses):</td>
              <td id="celPlazoMeses"></td>
            </tr>
            <tr>
              <td>Valor Total del Contrato:</td>
              <td id="celValorTotalContrato"></td>
            </tr>
            <tr>
              <td>Día de Corte de Informe:</td>
              <td id="celDiaCorteInforme"></td>
            </tr>
            <tr>
              <td>Observaciones de Ejecución:</td>
              <td id="celObservacionesEjecucion"></td>
            </tr>
            <tr>
              <td>Evidenciado en SECOP 2:</td>
              <td id="celEvidenciadoSecop"></td>
            </tr>
            <tr>
              <td>Fecha de Verificación:</td>
              <td id="celFechaVerificacion"></td>
            </tr>
            <tr>
              <td>Liquidación:</td>
              <td id="celLiquidacion"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> 